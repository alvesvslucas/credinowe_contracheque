<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1>Bem-vindo ao Portal Inforttech</h1>
    </header>
    <main>
        <button onclick="window.location.href='pages/admin_login.php'">Acesso Administrativo</button>
        <button onclick="window.location.href='pages/login_funcionario.php'">Acesso do Funcionário</button>
    </main>
    <footer>
        <?php include 'includes/footer.php'; ?>
    </footer>
</body>
</html>
