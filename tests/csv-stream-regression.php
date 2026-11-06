<?php
declare(strict_types=1);

// Read source text only: never include the page, configuration or database.
final class RegressionFailure extends RuntimeException {}

function check(bool $condition, string $label): void
{
    if (!$condition) {
        throw new RegressionFailure($label);
    }
}

function auditedCall(string $source): string
{
    $count = preg_match_all('/\bfgetcsv\s*\([^()]*\)/', $source, $matches);
    check($count === 1, 'Expected one real fgetcsv call in the importer.');
    return $matches[0][0];
}

function validateCall(string $call): void
{
    // Permit only the audited PHP builtin call, its actual arguments and $$.
    $allowed = [
        T_STRING => ['fgetcsv'],
        T_VARIABLE => ['$handle'],
        T_LNUMBER => ['1000'],
        T_CONSTANT_ENCAPSED_STRING => ["','"],
    ];
    foreach (token_get_all('<?php ' . $call) as $token) {
        if (is_array($token)) {
            if ($token[0] === T_OPEN_TAG || $token[0] === T_WHITESPACE) {
                continue;
            }
            check(
                isset($allowed[$token[0]]) && in_array($token[1], $allowed[$token[0]], true),
                'The importer call changed beyond the isolated regression scope.'
            );
            continue;
        }
        check(in_array($token, ['(', ')', ',', '$'], true), 'Unexpected call token.');
    }
}

function readUsingActualCall(string $call, $handle): array|false
{
    // The token guard rejects other functions, variables, statements and I/O.
    return eval('return ' . $call . ';');
}

function syntheticStream(array $rows)
{
    $handle = fopen('php://temp', 'w+');
    check(is_resource($handle), 'Could not create the isolated CSV stream.');
    foreach ($rows as $row) {
        check(fputcsv($handle, $row, ',', '"', '\\') !== false, 'Could not create synthetic CSV.');
    }
    check(rewind($handle), 'Could not rewind the isolated stream.');
    return $handle;
}

try {
    check(PHP_MAJOR_VERSION === 8 && PHP_MINOR_VERSION === 2, 'Run this regression with PHP 8.2.');
    $source = file_get_contents(__DIR__ . '/../pages/importar_usuarios.php');
    check(is_string($source), 'Could not read importer source text.');
    $currentCall = auditedCall($source);
    validateCall($currentCall);
    $fixtureText = file_get_contents(__DIR__ . '/fixtures/importar-usuarios-call.before.json');
    check(is_string($fixtureText), 'Could not read the original-call fixture.');
    $fixture = json_decode($fixtureText, true, 512, JSON_THROW_ON_ERROR);
    check(
        $fixture['blob_sha'] === '94669087142b0ba4aebb8190bc14bc099d22c6e8'
        && $fixture['call'] === "fgetcsv(\$ \$handle, 1000, ',')",
        'The negative fixture no longer matches the reviewed original excerpt.'
    );
    $originalCall = $fixture['call'];
    validateCall($originalCall);
    $rows = [
        ['Pessoa ficticia, A', 'csv-a@example.invalid', 'senha-ficticia-a', 'https://example.invalid/a'],
        ['Pessoa "B"', 'csv-b@example.invalid', 'senha-ficticia-b', 'https://example.invalid/b'],
    ];

    $handle = syntheticStream($rows);
    $originalFailed = false;
    $warnings = 0;
    set_error_handler(static function (int $severity) use (&$warnings): bool {
        $warnings++;
        return true; // Do not print diagnostic text or CSV values.
    });
    try {
        readUsingActualCall($originalCall, $handle);
    } catch (TypeError $error) {
        $originalFailed = true;
    } finally {
        restore_error_handler();
        $position = ftell($handle);
        fclose($handle);
    }
    check($originalFailed && $warnings > 0 && $position === 0, 'Original call must fail before reading any CSV row.');
    echo "PASS: reviewed original call fails before reading a CSV row.\n";

    set_error_handler(static function (int $severity): never {
        throw new RegressionFailure('Unexpected PHP diagnostic in the corrected CSV call.');
    });
    $handle = syntheticStream($rows);
    try {
        foreach ($rows as $row) {
            check(readUsingActualCall($currentCall, $handle) === $row, 'Actual importer call did not return all four CSV fields unchanged.');
        }
        check(readUsingActualCall($currentCall, $handle) === false, 'Actual importer call did not stop at EOF.');
    } finally {
        fclose($handle);
        restore_error_handler();
    }
    echo "PASS: actual importer call reads two synthetic four-column CSV rows and EOF.\n";
} catch (Throwable $error) {
    // Only our constant test labels are public; never dump native diagnostics or row data.
    $label = $error instanceof RegressionFailure
        ? $error->getMessage()
        : 'Unexpected ' . get_class($error) . ' in the isolated regression.';
    fwrite(STDERR, "FAIL: " . $label . "\n");
    exit(1);
}
