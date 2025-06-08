<?php
// ===== CONEXÃO COM O BANCO DE DADOS =====
$conectar = mysql_connect('localhost', 'root', '');
$banco = mysql_select_db('livraria');

// ===== PROCESSO DE LOGIN =====
if (isset($_POST['Entrar'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT email, senha FROM usuario WHERE email = '$email' and senha = '$senha'";
    $resultado = mysql_query($sql);

    if (mysql_num_rows($resultado) <= 0) {
        // Login inválido
        echo "<script language='javascript' type='text/javascript'>
            alert('E-mail e/ou senha incorreto(s)!');
            window.location.href='pagina_login.php';
            </script>";
    } else {
        // Login válido, cria cookie e redireciona
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
                <h1>Login do Usuário</h1>
            </div>
            <form class="form" name="formulario" method="POST" action="pagina_login.php" style="max-width:400px;">
                <fieldset>
                    <legend>Dados de Acesso:</legend>
                    <label>E-mail: <input type="text" name="email" id="email" required></label>
                    <label>Senha: <input type="password" name="senha" id="senha" required></label>
                </fieldset>
                <div class="form-actions" style="justify-content: center;">
                    <a href="cad_usuario.php" class="form-admin-btn" style="text-decoration:none;">
                        <button type="button" style="margin-right:12px;">Cadastrar-se</button>
                    </a>
                    <button type="submit" name="Entrar">Entrar</button>
                </div>
            </form>
        </section>
    </main>
    <footer class="page-footer">
        <p>&copy; 2025 Coffee's Book - All rights reserved. </p>
    </footer>
</body>
</html>