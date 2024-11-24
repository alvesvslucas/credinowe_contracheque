<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credinowe</title>
    <link  rel= "ícone-de-toque-da-maçã"  tamanhos= "72x72  " href = "./assets/img/favicon/apple-icon-72x72.png" > 
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <div class="logo"><img src="./assets/img/credinowe.png" alt="Logo Credinowe" class="logo"></div>
        <h1>Bem-vindo ao Portal Contracheque</h1>
    </header>
    <main>
        <div class="card">
            <h2>Escolha uma Opção:</h2>
            <button onclick="window.location.href='pages/admin_login.php'" class="btn">Acesso Administrativo</button>
            <button onclick="window.location.href='pages/login_funcionario.php'" class="btn btn-secondary">Acesso do Funcionário</button>
        </div>
    </main>
    <footer>
        <?php include 'includes/footer.php'; ?>
    </footer>
</body>
</html>
