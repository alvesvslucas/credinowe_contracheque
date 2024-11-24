<?php
session_start();
require '../config.php'; // Inclui a conexão com o banco

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Busca o funcionário pelo e-mail
    $stmt = $pdo->prepare("SELECT * FROM funcionarios WHERE email = ?");
    $stmt->execute([$email]);
    $funcionario = $stmt->fetch();

    if ($funcionario && password_verify($senha, $funcionario['senha'])) {
        // Login bem-sucedido
        $_SESSION['funcionario_id'] = $funcionario['id'];
        header("Location: contracheque.php");
        exit;
    } else {
        $erro = "E-mail ou senha inválidos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login do Funcionário</title>
</head>
<body>
    <h1>Login do Funcionário</h1>
    <form method="post">
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required>
        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required>
        <button type="submit">Entrar</button>
    </form>
    <?php if (isset($erro)) echo "<p>$erro</p>"; ?>
</body>
</html>
