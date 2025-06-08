<?php
// ===== CONEXÃO COM O BANCO DE DADOS =====
$connect = mysql_connect('localhost', 'root', '');
if (!$connect) {
    die("Erro de conexão: " . mysql_error());
}
$db = mysql_select_db('livraria');
if (!$db) {
    die("Erro ao selecionar o banco de dados: " . mysql_error());
}

// ===== INICIALIZAÇÃO DA SESSÃO =====
session_start();
$status = "";

// ===== ADICIONAR LIVRO AO CARRINHO =====
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
    <!-- Barra superior -->
    <div class="top-bar">
        <div class="top-bar-container">
            <a href="pagina_home.php" class="logo-link">
                <img src="design_imagens/coffeesbook_logo.png" width="180" alt="Logo da Livraria">
            </a>
            <!-- Corrige search-bar para usar GET corretamente -->
            <form class="search-bar" method="get" action="pagina_home.php">
                <input type="text" name="busca" placeholder="O que você procura?" value="<?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?>">
                <button type="submit"><img src="https://cdn-icons-png.flaticon.com/512/622/622669.png" width="20" alt="Buscar"></button>
            </form>
            <div class="header-icons">
                <a href="pagina_login.php" title="Minha Conta">
                    <img src="https://cdn-icons-png.flaticon.com/512/747/747376.png" width="24" height="24"
                        alt="Minha Conta">
                </a>
                <a href="pagina_home.php" title="Favoritos">
                    <img src="https://cdn-icons-png.flaticon.com/512/833/833472.png" width="24" height="24"
                        alt="Favoritos">
                </a>
                <a href="carrinho.php" title="Sacola">
                    <img src="https://cdn-icons-png.flaticon.com/512/263/263142.png" width="24" height="24"
                        alt="Sacola">
                    <?php
                    if (!empty($_SESSION["shopping_cart"])) {
                        $cart_count = count(array_keys($_SESSION["shopping_cart"]));
                        echo "<span>$cart_count</span>";
                    }
                    ?>
                </a>
            </div>
        </div>
    </div>
    <!-- Menu de navegação -->
    <nav class="main-nav">
        <ul>
            <li><a href="#">Autoajuda</a></li>
            <li><a href="#">Biografias</a></li>
            <li><a href="#">HQs</a></li>
            <li><a href="#">Negócios</a></li>
            <li><a href="#">Lançamentos</a></li>
            <li><a href="#">Ofertas</a></li>
            <li><a href="#">Presentes</a></li>
            <li><a href="#">Novidades</a></li>
            <li><a href="#">Mais Vendidos</a></li>
        </ul>
    </nav>
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


    <!-- Barra institucional agora abaixo do banner -->
    <div class="institutional-bar">
        <div class="institutional-container">
            <div class="inst-block">
                <img src="design_imagens/logo_icone.png" width="32" alt="Logo">
                <div>
                    <span class="inst-title">A maior livraria do sul</span>
                    <span class="inst-sub">61 anos de histórias</span>
                </div>
            </div>
            <div class="inst-divider"></div>
            <div class="inst-block">
                <img src="design_imagens/celular_icone.png" width="32" alt="App">
                <div>
                    <span class="inst-title">Baixe nosso APP</span>
                    <span class="inst-sub">Cupom 1º compra</span>
                </div>
            </div>
            <div class="inst-divider"></div>
            <div class="inst-block">
                <img src="design_imagens/local_icone.png" width="32" alt="Loja">
                <div>
                    <span class="inst-title">Retire na loja</span>
                    <span class="inst-sub">Consulte lojas disponíveis</span>
                </div>
            </div>
            <div class="inst-divider"></div>
            <div class="inst-block">
                <img src="design_imagens/presente_icone.png" width="32" alt="Vale Presente">
                <div>
                    <span class="inst-title">Vale presente online</span>
                    <span class="inst-sub">Deixe o dia mais especial</span>
                </div>
            </div>
            <div class="inst-divider"></div>
            <div class="inst-block">
                <img src="design_imagens/cartao_icone.png" width="32" alt="Parcele">
                <div>
                    <span class="inst-title">Parcele suas compras</span>
                    <span class="inst-sub">Em até 10x sem juros</span>
                </div>
            </div>
        </div>
    </div>

    <div style="clear:both;"></div>
    <?php if (!empty($status)) { ?>
        <div class="message_box" style="margin:10px 0px;">
            <?php echo $status; ?>
        </div>
    <?php } ?>
    <main class="main-container">
        <aside class="filter-sidebar">
            <!-- Filtro: apenas um form, sem forms aninhadas -->
            <form name="formulario" method="post" action="pagina_home.php" class="form" id="filtro-form">
                <fieldset>
                    <legend>Livros</legend>
                    <label for="categoria">Categoria:</label>
                    <div id="categorias-lista" class="categorias-scroll">
                        <?php
                        $query = mysql_query("SELECT codigo, nome FROM categoria");
                        while ($cat = mysql_fetch_array($query)) {
                            // Botão de categoria envia o valor para o form principal via JS
                            echo '<button type="button" class="categoria-btn" data-categoria="' . $cat['codigo'] . '" style="width:100%;text-align:left;padding:8px 10px;margin-bottom:4px;border:none;background:#eee;border-radius:5px;cursor:pointer;">' . htmlspecialchars($cat['nome']) . '</button>';
                        }
                        ?>
                    </div>
                    <input type="hidden" name="categoria" id="categoria-hidden" value="<?php echo isset($_POST['categoria']) ? htmlspecialchars($_POST['categoria']) : ''; ?>">
                    <label for="autor">Autor:</label>
                    <select name="autor" id="autor">
                        <option value="" selected>Selecione...</option>
                        <?php
                        $query = mysql_query("SELECT codigo, nome FROM autor");
                        while ($aut = mysql_fetch_array($query)) {
                            $selected = (isset($_POST['autor']) && $_POST['autor'] == $aut['codigo']) ? 'selected' : '';
                            echo '<option value="' . $aut['codigo'] . '" ' . $selected . '>' . $aut['nome'] . '</option>';
                        }
                        ?>
                    </select>
                    <label for="editora">Editora:</label>
                    <select name="editora" id="editora">
                        <option value="" selected>Selecione...</option>
                        <?php
                        $query = mysql_query("SELECT codigo, nome FROM editora");
                        while ($ed = mysql_fetch_array($query)) {
                            $selected = (isset($_POST['editora']) && $_POST['editora'] == $ed['codigo']) ? 'selected' : '';
                            echo '<option value="' . $ed['codigo'] . '" ' . $selected . '>' . $ed['nome'] . '</option>';
                        }
                        ?>
                    </select>
                    <button type="submit" name="pesquisar">Pesquisar</button>
                </fieldset>
            </form>
            <script>
                // Script para enviar categoria ao clicar no botão
                document.querySelectorAll('.categoria-btn').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        document.getElementById('categoria-hidden').value = this.getAttribute('data-categoria');
                        document.getElementById('filtro-form').submit();
                    });
                });
            </script>
        </aside>
        <section class="product-list">
            <?php
            // Consulta padrão para listar todos os livros
            $sql_livros = "SELECT livro.codigo, livro.titulo, livro.preco, livro.capa, categoria.nome AS categoria, autor.nome AS autor, editora.nome AS editora
                           FROM livro
                           INNER JOIN categoria ON livro.cod_categoria = categoria.codigo
                           INNER JOIN autor ON livro.cod_autor = autor.codigo
                           INNER JOIN editora ON livro.cod_editora = editora.codigo";

            // Filtro por busca (GET) ou filtros (POST)
            $conditions = array();
            if (isset($_GET['busca']) && trim($_GET['busca']) != '') {
                $busca = mysql_real_escape_string($_GET['busca']);
                $conditions[] = "(livro.titulo LIKE '%$busca%' OR autor.nome LIKE '%$busca%' OR editora.nome LIKE '%$busca%' OR categoria.nome LIKE '%$busca%')";
            }
            if (isset($_POST['pesquisar'])) {
                if (!empty($_POST['categoria'])) {
                    $categoria = mysql_real_escape_string($_POST['categoria']);
                    $conditions[] = "categoria.codigo = '$categoria'";
                }
                if (!empty($_POST['autor'])) {
                    $autor = mysql_real_escape_string($_POST['autor']);
                    $conditions[] = "autor.codigo = '$autor'";
                }
                if (!empty($_POST['editora'])) {
                    $editora = mysql_real_escape_string($_POST['editora']);
                    $conditions[] = "editora.codigo = '$editora'";
                }
            }
            if (!empty($conditions)) {
                $sql_livros .= " WHERE " . implode(' AND ', $conditions);
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
                    echo "<img src='imagens/{$dados->capa}' alt='Capa do Livro' style='height:220px;object-fit:cover;'>";
                    echo "<h4>{$dados->titulo}</h4>";
                    echo "<p class='autor'>{$dados->autor}</p>";
                    echo "<p class='editora'>{$dados->editora}</p>";
                    echo "<p class='categoria'>{$dados->categoria}</p>";
                    echo "<p class='preco'>R$ <span>" . number_format($dados->preco, 2, ',', '.') . "</span></p>";
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
        <div class="footer-container">
            <div class="footer-info">
                <p><strong>Coffee's Book</strong> - Sua livraria online</p>
                <p>Avenida Jorge Elias De Lucca, n°765, Nossa Senhora da Salete - 88813901, Criciúma - SC</p>
                <p><strong>Atendimento:</strong> contato@coffeesbook.com.br</p>
            </div>
            <div class="footer-social">
                <a href="#"><img src="design_imagens/facebook_icone.png" width="24"
                        alt="Facebook"></a>
                <a href="#"><img src="design_imagens/instagram_icone.png" width="24"
                        alt="Instagram"></a>
                <a href="#"><img src="design_imagens/tiktok_icone.png" width="24"
                        alt="Tiktok"></a>
                <a href="#"><img src="design_imagens/twitter_icone.png" width="24"
                        alt="Twitter"></a>
                <a href="#"><img src="design_imagens/whatsapp_icone.png" width="24"
                        alt="Whatsapp"></a>
                <a href="#"><img src="design_imagens/youtube_icone.png" width="24"
                        alt="Youtube"></a>
            </div>
        </div>
        <p>&copy; 2025 Coffee's Book - All rights reserved. </p>
    </footer>
</body>

</html>