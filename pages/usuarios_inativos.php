<?php
session_start();
require '../config.php';

// Verifica se o administrador está logado
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Busca os funcionários inativos
$stmt_inativos = $pdo->query("SELECT * FROM funcionarios WHERE status = 0 ORDER BY nome");
$funcionarios_inativos = $stmt_inativos->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funcionários Inativos</title>
    <link rel="stylesheet" href="../assets/css/inativo.css">
</head>
<body>
    <h1>Funcionários Inativos</h1>

    <!-- Botão para voltar ao painel -->
    <a href="painel_admin.php" class="btn-voltar">Voltar</a>



    <!-- Tabela de funcionários inativos -->
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($funcionarios_inativos as $funcionario): ?>
                <tr>
                    <td><?= htmlspecialchars($funcionario['nome']) ?></td>
                    <td><?= htmlspecialchars($funcionario['email']) ?></td>
                    <td>
                        <a href="restaurar_funcionario.php?id=<?= $funcionario['id'] ?>" onclick="return confirm('Tem certeza que deseja restaurar este funcionário?');">Restaurar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
