<?php
session_start();
require '../config.php';

// Verifica se o administrador está logado
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Busca os funcionários cadastrados
$stmt = $pdo->query("SELECT * FROM funcionarios ORDER BY nome");
$funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
</head>
<body>
    <h1>Painel Administrativo</h1>
    <a href="cadastrar_funcionario.php">Cadastrar Novo Funcionário</a>
    <table border="1">
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Link do Contracheque</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($funcionarios as $funcionario): ?>
                <tr>
                    <td><?= htmlspecialchars($funcionario['nome']) ?></td>
                    <td><?= htmlspecialchars($funcionario['email']) ?></td>
                    <td><a href="<?= htmlspecialchars($funcionario['link_contracheque']) ?>" target="_blank">Visualizar</a></td>
                    <td>
                        <a href="editar_funcionario.php?id=<?= $funcionario['id'] ?>">Editar</a>
                        <a href="excluir_funcionario.php?id=<?= $funcionario['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
