<?php
$conectar = mysql_connect('localhost', 'root', '');
$banco = mysql_select_db('livraria');

if (isset($_POST['Entrar'])) {
    $email = mysql_real_escape_string($_POST['email']);
    $senha = mysql_real_escape_string($_POST['senha']);

    $sql = "SELECT email, senha FROM usuario WHERE email = '$email' and senha = '$senha'";
    $resultado = mysql_query($sql);

    if (mysql_num_rows($resultado) <= 0) {
        echo "<script language='javascript' type='text/javascript'>
            alert('E-mail e/ou senha incorreto(s)!');
            window.location.href='pagina_login.php';
            </script>";
    } else {
        setcookie('login', $email);
        header('Location:pagina_menu.html');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Login</title>
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
    <main class="main-container login-main-center">
        <section class="login-section">
            <div id="titulo">
                <h1>Login do Usuário</h1>
            </div>
            <form class="form" name="formulario" method="POST" action="pagina_login.php" autocomplete="on">
                <fieldset>
                    <legend>Dados de Acesso:</legend>
                    <label for="email">E-mail: <input type="email" name="email" id="email" required
                            autocomplete="email"></label>
                    <label for="senha">Senha: <input type="password" name="senha" id="senha" required
                            autocomplete="current-password"></label>
                </fieldset>
                <div class="form-actions login-form-actions" style="flex-direction:column;gap:10px;">
                    <button type="submit" name="Entrar" style="width:100%;">Entrar</button>
                    <div style="width:100%;text-align:center;margin-top:10px;">
                        Não possui uma conta?
                        <a href="cad_usuario.php" style="color:#0056b3;text-decoration:underline;">Cadastre-se aqui.</a>
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