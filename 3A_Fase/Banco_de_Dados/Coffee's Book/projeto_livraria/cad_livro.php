<?php
$conectar = mysql_connect('localhost', 'root', '');
$banco = mysql_select_db('livraria');

$pesquisa_livros = array();
$exibir_pesquisa = false;

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
        echo "<div class='box'>Dados gravados com sucesso!</div>";
    } else {
        echo "<div class='boxerror'>Erro ao gravar os dados.</div>";
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
        echo "<div class='box'>Dados alterados com sucesso!</div>";
    } else {
        echo "<div class='boxerror'>Erro ao alterar os dados.</div>";
    }
}

if (isset($_POST['Excluir'])) {
    $codigo = $_POST['codigo'];

    $sql = "DELETE FROM livro WHERE codigo = '$codigo'";
    $resultado = mysql_query($sql);

    if ($resultado == TRUE) {
        echo "<div class='box'>Dados excluídos com sucesso!</div>";
    } else {
        echo "<div class='boxerror'>Erro ao excluir os dados.</div>";
    }
}

if (isset($_POST['Pesquisar'])) {
    $sql = "SELECT * FROM livro";
    $resultado = mysql_query($sql);

    if (mysql_num_rows($resultado) == 0) {
        echo "<div class='boxerror'>Nenhum livro encontrado.</div>";
    } else {
        while ($dados = mysql_fetch_array($resultado)) {
            $pesquisa_livros[] = $dados;
        }
        $exibir_pesquisa = true;
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
    <?php if ($exibir_pesquisa && count($pesquisa_livros) > 0): ?>
        <div class="product-list" style="max-width:1100px;margin:32px auto 0 auto;">
            <h3 style="margin-bottom:18px;">Livros cadastrados:</h3>
            <div class="product-grid">
                <?php foreach ($pesquisa_livros as $livro): ?>
                    <div class="product-card" style="align-items:flex-start;">
                        <div class="product-img-container" style="margin-bottom:10px;">
                            <?php if (!empty($livro['foto_capa']) && file_exists('imagens/' . $livro['foto_capa'])): ?>
                                <img src="imagens/<?php echo htmlspecialchars($livro['foto_capa']); ?>" alt="Capa do Livro"
                                    class="product-img-main">
                            <?php else: ?>
                                <div
                                    style="width:150px;height:220px;display:flex;align-items:center;justify-content:center;background:#f7f7f7;border-radius:6px;color:#bbb;font-size:1.2em;">
                                    Sem imagem
                                </div>
                            <?php endif; ?>
                        </div>
                        <h4 style="margin-bottom:6px;"><?php echo htmlspecialchars($livro['titulo']); ?></h4>
                        <div class="autor" style="color:#888;margin-bottom:2px;">
                            <strong>Código:</strong> <?php echo htmlspecialchars($livro['codigo']); ?>
                        </div>
                        <div class="editora" style="color:#888;margin-bottom:2px;">
                            <strong>ISBN:</strong> <?php echo htmlspecialchars($livro['isbn']); ?>
                        </div>
                        <div class="editora" style="color:#888;margin-bottom:2px;">
                            <strong>Nº Páginas:</strong> <?php echo htmlspecialchars($livro['numero_paginas']); ?>
                        </div>
                        <div class="editora" style="color:#888;margin-bottom:2px;">
                            <strong>Ano:</strong> <?php echo htmlspecialchars($livro['ano']); ?>
                        </div>
                        <div class="editora" style="color:#888;margin-bottom:2px;">
                            <strong>Cód. Autor:</strong> <?php echo htmlspecialchars($livro['cod_autor']); ?>
                        </div>
                        <div class="editora" style="color:#888;margin-bottom:2px;">
                            <strong>Cód. Categoria:</strong> <?php echo htmlspecialchars($livro['cod_categoria']); ?>
                        </div>
                        <div class="editora" style="color:#888;margin-bottom:2px;">
                            <strong>Cód. Editora:</strong> <?php echo htmlspecialchars($livro['cod_editora']); ?>
                        </div>
                        <div class="editora" style="color:#888;margin-bottom:2px;">
                            <strong>Preço:</strong> R$ <?php echo number_format($livro['preco'], 2, ',', '.'); ?>
                        </div>
                        <div class="editora" style="color:#888;margin-bottom:2px;">
                            <strong>Sinopse:</strong> <?php echo nl2br(htmlspecialchars($livro['sinopse'])); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    <main class="main-container cadastro-main-center">
        <section class="cadastro-section-livro">
            <div id="titulo">
                <h1>Cadastro de Livro</h1>
            </div>
            <form class="form-admin" name="formulario" method="POST" action="cad_livro.php"
                enctype="multipart/form-data">
                <fieldset>
                    <legend>Dados do Livro</legend>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="titulo">Título</label>
                            <input type="text" name="titulo" id="titulo" placeholder="Digite o título">
                        </div>
                        <div class="form-col">
                            <label for="codigo">Código</label>
                            <input type="text" name="codigo" id="codigo" placeholder="Digite o código">
                        </div>
                        <div class="form-col">
                            <label for="isbn">ISBN</label>
                            <input type="text" name="isbn" id="isbn" placeholder="Digite o ISBN">
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="numero_paginas">Nº Páginas</label>
                            <input type="text" name="numero_paginas" id="numero_paginas"
                                placeholder="Digite o número de páginas">
                        </div>
                        <div class="form-col">
                            <label for="ano">Ano</label>
                            <input type="text" name="ano" id="ano" placeholder="Digite o ano">
                        </div>
                        <div class="form-col">
                            <label for="cod_autor">Cód. Autor</label>
                            <input type="text" name="cod_autor" id="cod_autor" placeholder="Código do autor">
                        </div>
                        <div class="form-col">
                            <label for="cod_categoria">Cód. Categoria</label>
                            <input type="text" name="cod_categoria" id="cod_categoria"
                                placeholder="Código da categoria">
                        </div>
                        <div class="form-col">
                            <label for="cod_editora">Cód. Editora</label>
                            <input type="text" name="cod_editora" id="cod_editora" placeholder="Código da editora">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="preco">Preço</label>
                            <input type="text" name="preco" id="preco" placeholder="Digite o preço">
                        </div>
                        <div class="form-col">
                            <label for="foto_capa">Foto Capa</label>
                            <input type="file" name="foto_capa" id="foto_capa">
                        </div>
                        <div class="form-col">
                            <label for="foto_contracapa">Foto Contracapa</label>
                            <input type="file" name="foto_contracapa" id="foto_contracapa">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-col" style="flex:2;">
                            <label for="sinopse">Sinopse</label>
                            <textarea name="sinopse" id="sinopse" placeholder="Digite a sinopse"></textarea>
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