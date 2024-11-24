<?php
session_start();
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file']['tmp_name'];

    if (($handle = fopen($file, 'r')) !== false) {
        // Lê cada linha do arquivo CSV
        while (($data = fgetcsv($ $handle, 1000, ',')) !== false) {
          // $data[0] = Nome, $data[1] = E-mail, $data[2] = Senha, $data[3] = Link do Contracheque
          $nome = trim($data[0]);
          $email = trim($data[1]);
          $senha = password_hash(trim($data[2]), PASSWORD_DEFAULT); // Criptografa a senha
          $link_contracheque = trim($data[3]);

          // Verifica se o e-mail já existe no banco
          $stmt = $pdo->prepare("SELECT * FROM funcionarios WHERE email = ?");
          $stmt->execute([$email]);

          if ($stmt->rowCount() == 0) {
              // Insere o usuário no banco
              $stmt = $pdo->prepare("INSERT INTO funcionarios (nome, email, senha, link_contracheque, status) VALUES (?, ?, ?, ?, 1)");
              $stmt->execute([$nome, $email, $senha, $link_contracheque]);
          }
      }
      fclose($handle);
      $_SESSION['mensagem'] = "Usuários importados com sucesso!";
      header("Location: painel_admin.php");
      exit;
  } else {
      $_SESSION['mensagem'] = "Erro ao abrir o arquivo.";
      header("Location: painel_admin.php");
      exit;
  }
} else {
  $_SESSION['mensagem'] = "Nenhum arquivo enviado.";
  header("Location: painel_admin.php");
  exit;
}
?>

