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
    <style>/* Reset básico */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  background: #f9f9f9; /* Fundo branco suave */
  color: #333333;
  padding: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
}

/* Título */
h1 {
  color: #333333;
  margin-bottom: 20px;
  font-size: 2rem;
  text-align: center;
}

/* Formulário */
form {
  background: #ffffff; /* Fundo branco para destaque */
  border-radius: 12px;
  padding: 20px;
  width: 100%;
  max-width: 400px;
  box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  gap: 15px;
}

/* Labels */
form label {
  font-size: 1rem;
  color: #555555;
  margin-bottom: 5px;
}

/* Inputs */
form input {
  padding: 10px;
  border: 1px solid #cccccc;
  border-radius: 8px;
  font-size: 1rem;
  width: 100%;
  transition: border-color 0.3s ease-in-out;
}

form input:focus {
  border-color: #2575fc;
  outline: none;
}

/* Botão */
form button {
  padding: 10px 15px;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  background: #2575fc;
  color: white;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.3s ease-in-out;
}

form button:hover {
  background: #1E5DBE;
}

/* Responsividade */
@media (max-width: 768px) {
  h1 {
    font-size: 1.5rem;
  }

  form {
    padding: 15px;
  }

  form label {
    font-size: 0.9rem;
  }

  form input {
    font-size: 0.9rem;
  }

  form button {
    font-size: 0.9rem;
  }
}
</style>
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
        <button type="button" onclick="window.location.href='./painel_admin.php'">Voltar</button>

    </form>
</body>
</html>
