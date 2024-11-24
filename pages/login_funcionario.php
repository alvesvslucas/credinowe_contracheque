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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<style>
    body {
  overflow-x: hidden; /* Remove o scroll horizontal */
}
</style>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-sm w-100" style="max-width: 400px;">
            <h2 class="text-center">Login do Funcionário</h2>
            <form method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Digite seu e-mail" required>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" name="senha" id="senha" class="form-control" placeholder="Digite sua senha" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Entrar</button>
                <button type="button" class="btn btn-secondary w-100 mt-3" onclick="window.location.href='../index.php'">Sair</button>
            </form>
            <?php if (isset($erro)) echo "<p class='text-danger mt-3 text-center'>$erro</p>"; ?>
            <!-- Footer -->
            <?php include '../includes/footer.php'; ?>
        </div>
    </div>
</body>
</html>


