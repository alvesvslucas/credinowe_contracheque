<?php
session_start();
require '../config.php';

// Verifica se o administrador está logado
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Busca os funcionários ativos
$stmt = $pdo->query("SELECT * FROM funcionarios WHERE status = 1 ORDER BY nome");
$funcionarios_ativos = $stmt->fetchAll(PDO::FETCH_ASSOC); // Definindo a variável corretamente
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="../assets/css/painel.css">
     
</head>
<body>
    <h1>Painel Administrativo</h1>
    
    <!-- Botões de ações principais -->
    <nav>
    <a class="cadastro" href="cadastrar_funcionario.php">Cadastrar Novo Funcionário</a>
    <a class="inativo" href="usuarios_inativos.php">Ver Inativos</a>
    <button class="btn-importar" id="btnImportar">Importar</button>
    <a class="inativo" href="../index.php">Sair</a>
    
</nav>

<section class="importar-usuarios" id="importarSection" style="display: none;">
    <h2>Importar Usuários</h2>
    <form action="importar_usuarios.php" method="post" enctype="multipart/form-data">
        <label for="file">Selecione um arquivo CSV:</label>
        <input type="file" name="file" id="file" accept=".csv" required>
        <button type="submit">Importar</button>
    </form>
</section>

<style>
    /* Estilização do menu */
    nav button:hover {
        background-color: #fff;
        border-radius: 5px;
    }

    .btn-importar {
        background-color: #D16301;
        font-weight: 700;
        font-size: 16px;
        color: #ffffff;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .btn-importar:hover {
        background-color: #fff;
        color:#d16301;
    }

    /* Estilo da seção de importação */
    .importar-usuarios {
        margin-top: 20px;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease; /* Suaviza a transição ao mostrar/ocultar */
    }

    .importar-usuarios h2 {
        margin-bottom: 15px;
        color: #024c8d;
    }

    .importar-usuarios form {
        display: flex;
        flex-direction: column;
    }

    .importar-usuarios label {
        margin-bottom: 10px;
    }

    .importar-usuarios input[type="file"] {
        margin-bottom: 15px;
    }

    .importar-usuarios button {
        background-color: #d16301;
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        border-radius: 5px;
        transition: background 0.3s ease;
    }

    .importar-usuarios button:hover {
        background-color: #024c8d;
    }
</style>

    <!-- Tabela de funcionários ativos -->
    <h2>Funcionários Ativos</h2>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Link do Contracheque</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($funcionarios_ativos as $funcionario): ?>
                <tr>
                    <td><?= htmlspecialchars($funcionario['nome']) ?></td>
                    <td><?= htmlspecialchars($funcionario['email']) ?></td>
                    <td><a href="<?= htmlspecialchars($funcionario['link_contracheque']) ?>" target="_blank">Visualizar</a></td>
                    <td>
                        <a href="editar_funcionario.php?id=<?= $funcionario['id'] ?>">Editar</a>
                        <a href="ocultar_funcionario.php?id=<?= $funcionario['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este funcionário?');">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <footer>
    <p>&copy; <?php echo date('Y'); ?> Credinowe. Todos os direitos reservados.</p>
</footer>
<script>
    // Seleciona o botão "Importar" e a seção
    const btnImportar = document.getElementById('btnImportar');
    const importarSection = document.getElementById('importarSection');

    // Adiciona um evento de clique ao botão
    btnImportar.addEventListener('click', () => {
        // Alterna a exibição da seção com transições suaves
        if (importarSection.style.display === 'none' || importarSection.style.display === '') {
            importarSection.style.display = 'block'; // Mostra a seção
        } else {
            importarSection.style.display = 'none'; // Esconde a seção
        }
    });
</script>


</body>
</html>
