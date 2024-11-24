<?php
session_start();
require '../config.php';

// Verifica se o administrador está logado
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $link_contracheque = $_POST['link_contracheque'];

    $stmt = $pdo->prepare("INSERT INTO funcionarios (nome, email, senha, link_contracheque) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $email, $senha, $link_contracheque]);

    header("Location: painel_admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Funcionário</title>
</head>
<body>
    <h1>Cadastrar Funcionário</h1>
    <form method="post">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required>
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required>
        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required>
        <label for="link_contracheque">Link do Contracheque:</label>
        <input type="url" name="link_contracheque" id="link_contracheque" required>
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
