<?php
$conectar = mysql_connect('localhost', 'root', '');
$banco = mysql_select_db('livraria');

if (isset($_POST['Gravar'])) {
    $codigo = $_POST['codigo'];
    $isbn = $_POST['isbn'];
    $titulo = $_POST['titulo'];
    $numero_paginas = $_POST['numero_paginas'];
    $ano = $_POST['ano'];
    $cod_autor = $_POST['cod_autor'];
    $cod_categoria = $_POST['cod_categoria'];
    $cod_editora = $_POST['cod_editora'];
    $sinopse = $_POST['sinopse'];
    $preco = $_POST['preco'];

    $diretorio = "imagens/";

    $extensao_capa = strtolower(substr($_FILES['foto_capa']['name'], -4));
    $novo_nome_capa = md5(time() . 'capa') . $extensao_capa;
    move_uploaded_file($_FILES['foto_capa']['tmp_name'], $diretorio . $novo_nome_capa);

    $extensao_contracapa = strtolower(substr($_FILES['foto_contracapa']['name'], -4));
    $novo_nome_contracapa = md5(time() . 'contracapa') . $extensao_contracapa;
    move_uploaded_file($_FILES['foto_contracapa']['tmp_name'], $diretorio . $novo_nome_contracapa);

    $sql = "INSERT INTO livro (codigo, isbn, titulo, numero_paginas, ano, cod_autor, cod_categoria, cod_editora, sinopse, preco, foto_capa, foto_contracapa)
            VALUES ('$codigo','$isbn','$titulo','$numero_paginas','$ano','$cod_autor','$cod_categoria','$cod_editora','$sinopse','$preco','$novo_nome_capa','$novo_nome_contracapa')";
    $resultado = mysql_query($sql);

    if ($resultado == TRUE) {
        echo "Dados gravados com sucesso!";
    } else {
        echo "Erro. - Motivo: Falha ao gravar os dados.";
    }
}

if (isset($_POST['Alterar'])) {
    $codigo = $_POST['codigo'];
    $isbn = $_POST['isbn'];
    $titulo = $_POST['titulo'];
    $numero_paginas = $_POST['numero_paginas'];
    $ano = $_POST['ano'];
    $cod_autor = $_POST['cod_autor'];
    $cod_categoria = $_POST['cod_categoria'];
    $cod_editora = $_POST['cod_editora'];
    $sinopse = $_POST['sinopse'];
    $preco = $_POST['preco'];

    $diretorio = "imagens/";
    $set_foto_capa = "";
    $set_foto_contracapa = "";

    if (!empty($_FILES['foto_capa']['name'])) {
        $extensao_capa = strtolower(substr($_FILES['foto_capa']['name'], -4));
        $novo_nome_capa = md5(time() . 'capa') . $extensao_capa;
        move_uploaded_file($_FILES['foto_capa']['tmp_name'], $diretorio . $novo_nome_capa);
        $set_foto_capa = ", foto_capa = '$novo_nome_capa'";
    }

    if (!empty($_FILES['foto_contracapa']['name'])) {
        $extensao_contracapa = strtolower(substr($_FILES['foto_contracapa']['name'], -4));
        $novo_nome_contracapa = md5(time() . 'contracapa') . $extensao_contracapa;
        move_uploaded_file($_FILES['foto_contracapa']['tmp_name'], $diretorio . $novo_nome_contracapa);
        $set_foto_contracapa = ", foto_contracapa = '$novo_nome_contracapa'";
    }

    $sql = "UPDATE livro SET 
            isbn = '$isbn',
            titulo = '$titulo',
            numero_paginas = '$numero_paginas',
            ano = '$ano',
            cod_autor = '$cod_autor',
            cod_categoria = '$cod_categoria',
            cod_editora = '$cod_editora',
            sinopse = '$sinopse',
            preco = '$preco'
            $set_foto_capa
            $set_foto_contracapa
            WHERE codigo = '$codigo'";
    $resultado = mysql_query($sql);

    if ($resultado == TRUE) {
        echo "Dados alterados com sucesso!";
    } else {
        echo "Erro. - Motivo: Falha ao alterar os dados.";
    }
}

if (isset($_POST['Excluir'])) {
    $codigo = $_POST['codigo'];

    $sql = "DELETE FROM livro WHERE codigo = '$codigo'";
    $resultado = mysql_query($sql);

    if ($resultado == TRUE) {
        echo "Dados excluídos com sucesso!";
    } else {
        echo "Erro. - Motivo: Falha ao excluir os dados.";
    }
}

if (isset($_POST['Pesquisar'])) {
    $sql = "SELECT * FROM livro";

    $resultado = mysql_query($sql);

    if (mysql_num_rows($resultado) == 0) {
        echo "Erro. - Motivo: Dados não encontrados.";
    } else {
        echo "<b>Pesquisa de Livros: </b><br>";
        while ($dados = mysql_fetch_array($resultado)) {
            echo "Código: " . $dados['codigo'] . "<br>" .
                "ISBN: " . $dados['isbn'] . "<br>" .
                "Título: " . $dados['titulo'] . "<br>" .
                "Nº Páginas: " . $dados['numero_paginas'] . "<br>" .
                "Ano: " . $dados['ano'] . "<br>" .
                "Autor: " . $dados['cod_autor'] . "<br>" .
                "Categoria: " . $dados['cod_categoria'] . "<br>" .
                "Editora: " . $dados['cod_editora'] . "<br>" .
                "Sinopse: " . $dados['sinopse'] . "<br>" .
                "Preço: " . $dados['preco'] . "<br>";
            echo "Foto Capa: <img src='imagens/" . $dados['foto_capa'] . "' height='100' width='80'><br>";
            echo "Foto Contracapa: <img src='imagens/" . $dados['foto_contracapa'] . "' height='100' width='80'><br><br>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Livros</title>
    <link rel="shortcut icon" href="design_imagens/coffeesbook_icon.png" type="image/png">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header><img src="design_imagens/coffeesbook_logo.png" width="150"></header>

    <main>
        <div id="titulo">
            <h1>Formulário de Cadastro de Livros</h1>
        </div>

        <form class='form' name="formulario" method="POST" action="cad_livro.php" enctype="multipart/form-data">
            <fieldset>
                <legend>Dados do Livro:</legend>
                <label>Código: <input type="text" name="codigo" id="codigo" size="5"></label><br><br>
                <label>ISBN: <input type="text" name="isbn" id="isbn" size="20"></label><br><br>
                <label>Título: <input type="text" name="titulo" id="titulo" size="50"></label><br><br>
                <label>Nº Páginas: <input type="text" name="numero_paginas" id="numero_paginas" size="10"></label><br><br>
                <label>Ano: <input type="text" name="ano" id="ano" size="6"></label><br><br>
                <label>Cód. Autor: <input type="text" name="cod_autor" id="cod_autor" size="5"></label><br><br>
                <label>Cód. Categoria: <input type="text" name="cod_categoria" id="cod_categoria" size="5"></label><br><br>
                <label>Cód. Editora: <input type="text" name="cod_editora" id="cod_editora" size="5"></label><br><br>
                <label>Sinopse:<br>
                    <textarea name="sinopse" id="sinopse" cols="50" rows="4"></textarea>
                </label><br><br>
                <label>Preço: <input type="text" name="preco" id="preco" size="10"></label><br><br>
                <label>Foto Capa: <input type="file" name="foto_capa" id="foto_capa"></label><br><br>
                <label>Foto Contracapa: <input type="file" name="foto_contracapa" id="foto_contracapa"></label><br><br>
            </fieldset>
            <button type="submit" name="Gravar">Gravar</button>
            <button type="submit" name="Alterar">Alterar</button>
            <button type="submit" name="Excluir">Excluir</button>
            <button type="submit" name="Pesquisar">Pesquisar</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2025 Coffee's Book - All rights reserved. </p>
    </footer>
</body>

</html>