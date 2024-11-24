<?php
session_start();
require '../config.php';

// Verifica se o administrador está logado
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Verifica se o ID foi enviado
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Atualiza o status do funcionário para 0 (inativo)
    $stmt = $pdo->prepare("UPDATE funcionarios SET status = 0 WHERE id = ?");
    $stmt->execute([$id]);

    // Redireciona para o painel administrativo
    header("Location: painel_admin.php");
    exit;
} else {
    header("Location: painel_admin.php");
    exit;
}
?>
