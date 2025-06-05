<!-- Código PHP: -->
<?php
$conectar = mysql_connect('localhost', 'root', '');
$banco = mysql_select_db('livraria');

// Gravação de dados:
if (isset($_POST['Gravar'])) {
    $codigo = $_POST['codigo'];
    $nome = $_POST['nome'];

    $sql = "insert into editora (codigo, nome)
            values ('$codigo','$nome')";
    $resultado = mysql_query($sql);

    if ($resultado == TRUE) {
        echo "Dados gravados com sucesso!";
    } else {
        echo "Erro. - Motivo: Falha ao gravar os dados.";
    }
}

// Alteração de dados:
if (isset($_POST['Alterar'])) {
    $codigo = $_POST['codigo'];
    $nome = $_POST['nome'];

    $sql = "update editora set nome = '$nome',
            where codigo = '$codigo'";
    $resultado = mysql_query($sql);

    if ($resultado == TRUE) {
        echo "Dados alterados com sucesso!";
    } else {
        echo "Erro. - Motivo: Falha ao alterar os dados.";
    }
}

// Exclusão de dados:
if (isset($_POST['Excluir'])) {
    $codigo = $_POST['codigo'];
    $nome = $_POST['nome'];

    $sql = "delete from editora where codigo = '$codigo'";
    $resultado = mysql_query($sql);

    if ($resultado == TRUE) {
        echo "Dados excluídos com sucesso!";
    } else {
        echo "Erro. - Motivo: Falha ao excluir os dados.";
    }
}

// Pesquisa de dados:
if (isset($_POST['Pesquisar'])) {
    $sql = "select * from editora";

    $resultado = mysql_query($sql);

    if (mysql_num_rows($resultado) == 0) {
        echo "Erro. - Motivo: Dados não encontrados.";
    } else {
        echo "<b>" . "Pesquisa de Editoras: " . "</b><br>";
        while ($dados = mysql_fetch_array($resultado)) {
            echo "Código: " . $dados['codigo'] . "<br>" .
                "Nome: " . $dados['nome'] . "<br>";
        }
    }
}
?>

<!-- Código HTML: -->
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Cadastro de Editoras </title>
    <link rel="shortcut icon" href="design_imagens/coffeesbook_icon.png" type="image/png">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header><img src="design_imagens/coffeesbook_logo.png" width="150"></header>

    <main>
        <div id="titulo">
            <h1> Formulário de Cadastro de Editoras </h1>
        </div>

        <form class='form' name="formulario" method="POST" action="cad_editora.php">
            <fieldset>
                <legend> Dados da Editora: </legend>
                <label> Código: <input type="text" name="codigo" id="codigo" size="5"></label><br><br>
                <label> Nome: <input type="text" name="nome" id="nome" size="50"></label><br><br>
            </fieldset>
            <button type="submit" name="Gravar"> Gravar </button>
            <button type="submit" name="Alterar"> Alterar </button>
            <button type="submit" name="Excluir"> Excluir </button>
            <button type="submit" name="Pesquisar"> Pesquisar </button>
        </form>
    </main>

    <footer>
        <p>&copy; 2025 Coffee's Book - All rights reserved. </p>
    </footer>
</body>

</html>