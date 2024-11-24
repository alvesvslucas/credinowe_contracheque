<?php
session_start();
require '../config.php';

// Verifica se o administrador está logado
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM funcionarios WHERE id = ?");
$stmt->execute([$id]);

header("Location: painel_admin.php");
exit;
?>
