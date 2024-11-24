<?php
session_start();
require '../config.php';

// Verifica se o administrador está logado
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM funcionarios WHERE id = ?");
$stmt->execute([$id]);
$funcionario = $stmt->fetch();

if (!$funcionario) {
    die("Funcionário não encontrado!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $link_contracheque = $_POST['link_contracheque'];

    $stmt = $pdo->prepare("UPDATE funcionarios SET nome = ?, email = ?, link_contracheque = ? WHERE id = ?");
    $stmt->execute([$nome, $email, $link_contracheque, $id]);

    header("Location: painel_admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Funcionário</title>
    <link rel="stylesheet" href="../assets/css/editFunc.css">

</head>
<body>
    <h1>Editar Funcionário</h1>
    <form method="post">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($funcionario['nome']) ?>" required>
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($funcionario['email']) ?>" required>
        <label for="link_contracheque">Link do Contracheque:</label>
        <input type="url" name="link_contracheque" id="link_contracheque" value="<?= htmlspecialchars($funcionario['link_contracheque']) ?>" required>
        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>
