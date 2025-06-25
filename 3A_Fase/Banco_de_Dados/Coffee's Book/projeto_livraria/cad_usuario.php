<?php
$conectar = mysql_connect('localhost', 'root', '');
$banco = mysql_select_db('livraria');

if (isset($_POST['Cadastrar'])) {
    $nome = mysql_real_escape_string($_POST['nome']);
    $email = mysql_real_escape_string($_POST['email']);
    $senha = mysql_real_escape_string($_POST['senha']);

    $verifica = mysql_query("SELECT * FROM usuario WHERE email = '$email'");
    if (mysql_num_rows($verifica) > 0) {
        echo "<div class='boxerror'>E-mail já cadastrado!</div>";
    } else {
        $sql = "INSERT INTO usuario (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
        $resultado = mysql_query($sql);

        if ($resultado == TRUE) {
            header("Location: pagina_login.php");
            exit;
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
                    <img src="https://cdn-icons-png.flaticon.com/512/747/747376.png" width="24" height="24"
                        alt="Minha Conta">
                </a>
            </div>
        </div>
    </div>
    <main class="main-container cadastro-main-center">
        <section class="cadastro-section">
            <div id="titulo">
                <h1>Cadastro de Usuário</h1>
            </div>
            <form class="form-admin" name="formulario" method="POST" action="cad_usuario.php" autocomplete="on">
                <fieldset>
                    <legend>Preencha seus dados</legend>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome" placeholder="Digite seu nome" required
                                autocomplete="name">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" id="email" placeholder="Digite seu e-mail" required
                                autocomplete="email">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="senha">Senha</label>
                            <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required
                                autocomplete="new-password">
                        </div>
                    </div>
                </fieldset>
                <div class="form-actions login-form-actions" style="flex-direction:column;gap:10px;">
                    <button type="submit" name="Cadastrar" style="width:100%;">Cadastrar</button>
                    <div style="width:100%;text-align:center;margin-top:10px;">
                        Já possui uma conta?
                        <a href="pagina_login.php" style="color:#0056b3;text-decoration:underline;">Faça seu login.</a>
                    </div>
                </div>
            </form>
        </section>
    </main>
    <footer class="page-footer">
        <p>&copy; 2025 Coffee's Book - All rights reserved. </p>
    </footer>
</body>

</html>