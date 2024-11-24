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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-sm w-100" style="max-width: 400px;">
            <h1 class="text-center fs-4 mb-3">Bem-vindo, <?= htmlspecialchars($funcionario['nome']) ?>!</h1>
            <p class="text-center">Seu contracheque está disponível no link abaixo:</p>
            <div class="d-flex justify-content-center mb-3">
                <a href="<?= htmlspecialchars($funcionario['link_contracheque']) ?>" target="_blank" class="btn btn-primary">Acessar Contracheque</a>
            </div>
            <div class="d-flex justify-content-center">
                <a href="logout_funcionario.php" class="btn btn-secondary">Sair</a>
                
            </div>
            <!-- Footer -->
            <?php include '../includes/footer.php'; ?>
        </div>
    </div>
    
    
</body>
</html>
