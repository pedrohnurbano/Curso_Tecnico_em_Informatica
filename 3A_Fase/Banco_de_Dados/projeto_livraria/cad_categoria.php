<?php
$conectar = mysql_connect('localhost', 'root', '');
$banco = mysql_select_db('livraria');

if (isset($_POST['Gravar'])) {
    $codigo = $_POST['codigo'];
    $nome = $_POST['nome'];

    $sql = "INSERT INTO categoria (codigo, nome) VALUES ('$codigo','$nome')";
    $resultado = mysql_query($sql);

    if ($resultado == TRUE) {
        echo "<div class='box'>Dados gravados com sucesso!</div>";
    } else {
        echo "<div class='boxerror'>Erro ao gravar os dados.</div>";
    }
}

if (isset($_POST['Alterar'])) {
    $codigo = $_POST['codigo'];
    $nome = $_POST['nome'];

    $sql = "UPDATE categoria SET nome = '$nome' WHERE codigo = '$codigo'";
    $resultado = mysql_query($sql);

    if ($resultado == TRUE) {
        echo "<div class='box'>Dados alterados com sucesso!</div>";
    } else {
        echo "<div class='boxerror'>Erro ao alterar os dados.</div>";
    }
}

if (isset($_POST['Excluir'])) {
    $codigo = $_POST['codigo'];

    $sql = "DELETE FROM categoria WHERE codigo = '$codigo'";
    $resultado = mysql_query($sql);

    if ($resultado == TRUE) {
        echo "<div class='box'>Dados excluídos com sucesso!</div>";
    } else {
        echo "<div class='boxerror'>Erro ao excluir os dados.</div>";
    }
}

if (isset($_POST['Pesquisar'])) {
    $sql = "SELECT * FROM categoria";
    $resultado = mysql_query($sql);

    if (mysql_num_rows($resultado) == 0) {
        echo "<div class='boxerror'>Nenhuma categoria encontrada.</div>";
    } else {
        echo "<b>Pesquisa de Categorias: </b><br>";
        while ($dados = mysql_fetch_array($resultado)) {
            echo "Código: " . $dados['codigo'] . "<br>" .
                "Nome: " . $dados['nome'] . "<br>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Categorias</title>
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
            </div>
        </div>
    </div>
    <main class="main-container cadastro-main-center">
        <section class="cadastro-section">
            <div id="titulo">
                <h1>Cadastro de Categoria</h1>
            </div>
            <form class="form-admin" name="formulario" method="POST" action="cad_categoria.php">
                <fieldset>
                    <legend>Dados da Categoria</legend>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="codigo">Código</label>
                            <input type="text" name="codigo" id="codigo" placeholder="Digite o código">
                        </div>
                        <div class="form-col">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome" placeholder="Digite o nome da categoria">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="Gravar">Gravar</button>
                        <button type="submit" name="Alterar">Alterar</button>
                        <button type="submit" name="Excluir">Excluir</button>
                        <button type="submit" name="Pesquisar">Pesquisar</button>
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