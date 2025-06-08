<?php
// ===== CONEXÃO COM O BANCO DE DADOS =====
$conectar = mysql_connect('localhost', 'root', '');
$banco = mysql_select_db('livraria');

// ===== PROCESSO DE CADASTRO DE USUÁRIO =====
if (isset($_POST['Cadastrar'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verifica se já existe usuário com o mesmo e-mail
    $verifica = mysql_query("SELECT * FROM usuario WHERE email = '$email'");
    if (mysql_num_rows($verifica) > 0) {
        echo "<div class='boxerror'>E-mail já cadastrado!</div>";
    } else {
        $sql = "INSERT INTO usuario (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
        $resultado = mysql_query($sql);

        if ($resultado == TRUE) {
            echo "<div class='box'>Usuário cadastrado com sucesso!</div>";
        } else {
            echo "<div class='boxerror'>Erro ao cadastrar usuário.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="shortcut icon" href="design_imagens/coffeesbook_icon.png" type="image/png">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="page-body">
    <div class="top-bar">
        <div class="top-bar-container">
            <a href="pagina_home.php" class="logo-link">
                <img src="design_imagens/coffeesbook_logo.png" width="180" alt="Logo da Livraria">
            </a>
            <div class="header-icons">
                <a href="pagina_login.php" title="Minha Conta">
                    <img src="https://cdn-icons-png.flaticon.com/512/747/747376.png" width="24" height="24" alt="Minha Conta">
                </a>
                <a href="pagina_home.php" title="Favoritos">
                    <img src="https://cdn-icons-png.flaticon.com/512/833/833472.png" width="24" height="24" alt="Favoritos">
                </a>
                <a href="carrinho.php" title="Sacola">
                    <img src="https://cdn-icons-png.flaticon.com/512/263/263142.png" width="24" height="24" alt="Sacola">
                </a>
            </div>
        </div>
    </div>
    <main class="main-container" style="display: flex; justify-content: center; align-items: flex-start; min-height: 70vh;">
        <section style="flex: 0 1 400px; width: 100%;">
            <div id="titulo">
                <h1>Cadastro de Usuário</h1>
            </div>
            <form class="form-admin" name="formulario" method="POST" action="cad_usuario.php" autocomplete="off">
                <fieldset>
                    <legend>Preencha seus dados</legend>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome" placeholder="Digite seu nome" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" id="email" placeholder="Digite seu e-mail" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="senha">Senha</label>
                            <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="Cadastrar">Cadastrar</button>
                    </div>
                </fieldset>
            </form>
        </section>
    </main>
    <footer class="page-footer">
        <p>&copy; 2025 Coffee's Book - All rights reserved. </p>
    </footer>
</body>
</html>
