<?php
session_start();
require '../config.php';

// Verifica se o funcionário está logado
if (!isset($_SESSION['funcionario_id'])) {
    header("Location: login_funcionario.php");
    exit;
}

$id = $_SESSION['funcionario_id'];
$stmt = $pdo->prepare("SELECT nome, link_contracheque FROM funcionarios WHERE id = ?");
$stmt->execute([$id]);
$funcionario = $stmt->fetch();

if (!$funcionario) {
    die("Funcionário não encontrado!");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contracheque</title>
</head>
<body>
    <h1>Bem-vindo, <?= htmlspecialchars($funcionario['nome']) ?>!</h1>
    <p>Seu contracheque está disponível no link abaixo:</p>
    <a href="<?= htmlspecialchars($funcionario['link_contracheque']) ?>" target="_blank">Acessar Contracheque</a>
    <br><br>
    <a href="logout_funcionario.php">Sair</a>
</body>
</html>
