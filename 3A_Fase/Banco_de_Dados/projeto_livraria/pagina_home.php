<?php
// Conexão com o banco de dados (ajuste conforme necessário)
$connect = mysql_connect('localhost', 'root', '');
if (!$connect) {
    die("Erro de conexão: " . mysql_error());
}
$db = mysql_select_db('livraria');
if (!$db) {
    die("Erro ao selecionar o banco de dados: " . mysql_error());
}

// Inicialização da sessão
session_start();
$status = "";

// Adicionar livro ao carrinho
if (isset($_POST['codigo']) && $_POST['codigo'] != "") {
    $codigo = $_POST['codigo'];
    $resultado = mysql_query("SELECT titulo, preco, capa FROM livro WHERE codigo = '$codigo'");
    if (!$resultado) {
        die("Erro na consulta SQL: " . mysql_error());
    }
    $row = mysql_fetch_assoc($resultado);

    if ($row) {
        $titulo = $row['titulo'];
        $preco = $row['preco'];
        $capa = $row['capa'];

        $cartArray = array(
            $codigo => array(
                'codigo' => $codigo,
                'titulo' => $titulo,
                'preco' => $preco,
                'quantity' => 1,
                'capa' => $capa
            )
        );

        if (empty($_SESSION["shopping_cart"])) {
            $_SESSION["shopping_cart"] = $cartArray;
            $status = "<div class='box'>Livro adicionado ao carrinho!</div>";
        } else {
            $array_keys = array_keys($_SESSION["shopping_cart"]);
            if (in_array($codigo, $array_keys)) {
                $status = "<div class='boxerror'>Livro já está no carrinho!</div>";
            } else {
                $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"], $cartArray);
                $status = "<div class='box'>Livro adicionado ao carrinho!</div>";
            }
        }
    } else {
        $status = "<div class='boxerror'>Livro não encontrado!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Coffee's Book | Brazilian's Bookstore</title>
    <link rel="shortcut icon" href="design_imagens/coffeesbook_icon.png" type="image/png">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="page-body">
    <header class="page-header">
        <a href="pagina_home.php">
            <img src="design_imagens/coffeesbook_logo.png" width="220" alt="Logo da Livraria">
        </a>
        <div class="header-icons">
            <a href="pagina_login.php">
                <img src="design_imagens/user_icon.png" width="24" height="24" alt="Minha Conta">
                <p>Minha conta e <br> <strong>Meus pedidos</strong></p>
            </a>
            <a href="pagina_home.php">
                <img src="design_imagens/favorite_icon.png" width="24" height="24" alt="Favoritos">
            </a>
            <a href="carrinho.php">
                <img src="design_imagens/bag_icon.png" width="24" height="24" alt="Sacola">
                <?php
                if (!empty($_SESSION["shopping_cart"])) {
                    $cart_count = count(array_keys($_SESSION["shopping_cart"]));
                    echo "<span>$cart_count</span>";
                }
                ?>
            </a>
        </div>
    </header>

    <!-- Banner -->
    <div class="banner-slideshow">
        <div class="slides fade">
            <img src="design_imagens/banner_01.png" style="width:100%" height="auto">
        </div>
        <div class="slides fade">
            <img src="design_imagens/banner_02.png" style="width:100%" height="auto">
        </div>
        <div class="slides fade">
            <img src="design_imagens/banner_03.png" style="width:100%" height="auto">
        </div>
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>
    <script>
        let slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("slides");
            if (n > slides.length) { slideIndex = 1 }
            if (n < 1) { slideIndex = slides.length }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slides[slideIndex - 1].style.display = "block";
        }

        setInterval(() => {
            plusSlides(1);
        }, 10000);
    </script>

    <div style="clear:both;"></div>
    <div class="message_box" style="margin:10px 0px;">
        <?php echo $status; ?>
    </div>

    <main class="main-container">
        <aside class="filter-sidebar">
            <form name="formulario" method="post" action="pagina_home.php" class="form">
                <fieldset>
                    <legend>FILTROS</legend>
                    <label for="categoria">Categoria:</label>
                    <select name="categoria" id="categoria">
                        <option value="" selected>Selecione...</option>
                        <?php
                        $query = mysql_query("SELECT codigo, nome FROM categoria");
                        while ($cat = mysql_fetch_array($query)) {
                            echo '<option value="' . $cat['codigo'] . '">' . $cat['nome'] . '</option>';
                        }
                        ?>
                    </select>
                    <label for="autor">Autor:</label>
                    <select name="autor" id="autor">
                        <option value="" selected>Selecione...</option>
                        <?php
                        $query = mysql_query("SELECT codigo, nome FROM autor");
                        while ($aut = mysql_fetch_array($query)) {
                            echo '<option value="' . $aut['codigo'] . '">' . $aut['nome'] . '</option>';
                        }
                        ?>
                    </select>
                    <label for="editora">Editora:</label>
                    <select name="editora" id="editora">
                        <option value="" selected>Selecione...</option>
                        <?php
                        $query = mysql_query("SELECT codigo, nome FROM editora");
                        while ($ed = mysql_fetch_array($query)) {
                            echo '<option value="' . $ed['codigo'] . '">' . $ed['nome'] . '</option>';
                        }
                        ?>
                    </select>
                    <button type="submit" name="pesquisar">Pesquisar</button>
                </fieldset>
            </form>
        </aside>

        <section class="product-list">
            <?php
            // Consulta padrão para listar todos os livros
            $sql_livros = "SELECT livro.codigo, livro.titulo, livro.preco, livro.capa, categoria.nome AS categoria, autor.nome AS autor, editora.nome AS editora
                           FROM livro
                           INNER JOIN categoria ON livro.cod_categoria = categoria.codigo
                           INNER JOIN autor ON livro.cod_autor = autor.codigo
                           INNER JOIN editora ON livro.cod_editora = editora.codigo";

            if (isset($_POST['pesquisar'])) {
                $categoria = (empty($_POST['categoria'])) ? 'null' : mysql_real_escape_string($_POST['categoria']);
                $autor = (empty($_POST['autor'])) ? 'null' : mysql_real_escape_string($_POST['autor']);
                $editora = (empty($_POST['editora'])) ? 'null' : mysql_real_escape_string($_POST['editora']);

                $conditions = array();
                if ($categoria != 'null') {
                    $conditions[] = "categoria.codigo = $categoria";
                }
                if ($autor != 'null') {
                    $conditions[] = "autor.codigo = $autor";
                }
                if ($editora != 'null') {
                    $conditions[] = "editora.codigo = $editora";
                }
                if (!empty($conditions)) {
                    $sql_livros .= " WHERE " . implode(' AND ', $conditions);
                }
            }

            $seleciona_livros = mysql_query($sql_livros);

            if (mysql_num_rows($seleciona_livros) == 0) {
                echo '<h3>Desculpe, mas sua busca não retornou resultados.</h3>';
            } else {
                echo "<h3>Livros encontrados:</h3>";
                echo '<div class="product-grid">';
                while ($dados = mysql_fetch_object($seleciona_livros)) {
                    echo "<div class='product-card'>";
                    echo "<form method='post' action=''>";
                    echo "<img src='imagens/{$dados->capa}' alt='Capa do Livro'>";
                    echo "<h4>{$dados->titulo}</h4>";
                    echo "<p>Autor: {$dados->autor}</p>";
                    echo "<p>Editora: {$dados->editora}</p>";
                    echo "<p>Categoria: {$dados->categoria}</p>";
                    echo "<p>Preço: R$ {$dados->preco}</p>";
                    echo "<input type='hidden' name='codigo' value='{$dados->codigo}'>";
                    echo "<button class='buy-button'>Comprar</button>";
                    echo "</form>";
                    echo "</div>";
                }
                echo '</div>';
            }
            ?>
        </section>
    </main>

    <footer class="page-footer">
        <p>&copy; 2025 Coffee's Book - All rights reserved. </p>
    </footer>
</body>
</html>