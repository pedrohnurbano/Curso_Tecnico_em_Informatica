<?php
$connect = mysql_connect('localhost', 'root', '');
if (!$connect) {
    die("Erro de conexão: " . mysql_error());
}
$db = mysql_select_db('livraria');
if (!$db) {
    die("Erro ao selecionar o banco de dados: " . mysql_error());
}

session_start();
$status = "";

if (isset($_POST['codigo']) && $_POST['codigo'] != "") {
    $codigo = $_POST['codigo'];
    $resultado = mysql_query("SELECT titulo, preco, foto_capa FROM livro WHERE codigo = '$codigo'");
    if (!$resultado) {
        die("Erro na consulta SQL: " . mysql_error());
    }
    $row = mysql_fetch_assoc($resultado);

    if ($row) {
        $titulo = $row['titulo'];
        $preco = $row['preco'];
        $capa = $row['foto_capa'];

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
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            var msg = document.querySelector('.message_box');
            if (msg) {
                setTimeout(function () {
                    msg.style.display = 'none';
                }, 3000);
            }

            function updateFavoritesCounter() {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'favoritos.php?count=1', true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var count = parseInt(xhr.responseText, 10);
                        var counter = document.getElementById('favorites-counter');
                        if (counter) {
                            counter.textContent = count;
                            counter.style.display = count > 0 ? 'inline-block' : 'none';
                        }
                    }
                };
                xhr.send();
            }

            function addToFavorites(btn) {
                var card = btn.closest('.product-card');
                var codigo = btn.getAttribute('data-codigo');
                var titulo = card.querySelector('h4').textContent;
                var capa = card.querySelector('.product-img-main').getAttribute('src').replace('imagens/', '');
                var preco = card.querySelector('.preco').textContent.replace(/[^\d,]/g, '').replace(',', '.');
                var data = new FormData();
                data.append('action', 'add');
                data.append('code', codigo);
                data.append('titulo', titulo);
                data.append('capa', capa);
                data.append('preco', preco);

                fetch('favoritos.php', { method: 'POST', body: data })
                    .then(() => updateFavoritesCounter());
            }

            document.querySelectorAll('.favorite-heart').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    btn.classList.toggle('favorited');
                    if (btn.classList.contains('favorited')) {
                        addToFavorites(btn);
                    } else {
                        var codigo = btn.getAttribute('data-codigo');
                        var data = new FormData();
                        data.append('action', 'remove');
                        data.append('code', codigo);
                        fetch('favoritos.php', { method: 'POST', body: data })
                            .then(() => updateFavoritesCounter());
                    }
                });
            });

            updateFavoritesCounter();

            var favLink = document.getElementById('favoritos-header-link');
            if (favLink) {
                favLink.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (!document.getElementById('favSidebarOverlay')) {
                        var overlay = document.createElement('div');
                        overlay.className = 'fav-sidebar-overlay active';
                        overlay.id = 'favSidebarOverlay';
                        document.body.appendChild(overlay);

                        var aside = document.createElement('aside');
                        aside.className = 'fav-sidebar active';
                        aside.id = 'favSidebar';
                        aside.innerHTML = `
                            <div class="fav-sidebar-header">
                                <span class="fav-sidebar-title">Meus Favoritos</span>
                                <button class="fav-sidebar-close" id="closeFavSidebar" title="Fechar">&times;</button>
                            </div>
                            <div class="fav-sidebar-content" id="favSidebarContent"></div>
                        `;
                        document.body.appendChild(aside);

                        document.getElementById('closeFavSidebar').onclick = closeFavSidebar;
                        overlay.onclick = closeFavSidebar;
                    } else {
                        document.getElementById('favSidebarOverlay').classList.add('active');
                        document.getElementById('favSidebar').classList.add('active');
                    }
                    renderFavSidebar();
                });
            }

            function closeFavSidebar() {
                var overlay = document.getElementById('favSidebarOverlay');
                var aside = document.getElementById('favSidebar');
                if (overlay) overlay.classList.remove('active');
                if (aside) aside.classList.remove('active');
            }

            function renderFavSidebar() {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'favoritos.php?sidebar=1', true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        document.getElementById('favSidebarContent').innerHTML = xhr.responseText;
                        document.querySelectorAll('.fav-sidebar-remove-form').forEach(function (form) {
                            form.onsubmit = function (ev) {
                                ev.preventDefault();
                                var fd = new FormData(form);
                                fetch('favoritos.php', { method: 'POST', body: fd })
                                    .then(() => {
                                        renderFavSidebar();
                                        updateFavoritesCounter();
                                        var code = form.querySelector('input[name="code"]').value;
                                        document.querySelectorAll('.favorite-heart[data-codigo="' + code + '"]').forEach(function (btn) {
                                            btn.classList.remove('favorited');
                                        });
                                    });
                            };
                        });
                    }
                };
                xhr.send();
            }

            function updateCartCount() {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'carrinho.php?count=1', true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var count = parseInt(xhr.responseText, 10);
                        var cartIcon = document.getElementById('open-cart-sidebar');
                        if (cartIcon) {
                            var span = cartIcon.querySelector('span');
                            if (!span) {
                                span = document.createElement('span');
                                cartIcon.appendChild(span);
                            }
                            span.textContent = count;
                            span.style.display = count > 0 ? 'inline-block' : 'none';
                        }
                    }
                };
                xhr.send();
            }
            updateCartCount();

            document.getElementById('open-cart-sidebar').onclick = function (e) {
                e.preventDefault();
                document.getElementById('cart-sidebar-overlay').classList.add('active');
                document.getElementById('cart-sidebar').classList.add('active');
                loadCartSidebar();
            };
            document.getElementById('close-cart-sidebar').onclick = function () {
                document.getElementById('cart-sidebar-overlay').classList.remove('active');
                document.getElementById('cart-sidebar').classList.remove('active');
                updateCartCount();
            };
            document.getElementById('cart-sidebar-overlay').onclick = function () {
                document.getElementById('cart-sidebar-overlay').classList.remove('active');
                document.getElementById('cart-sidebar').classList.remove('active');
                updateCartCount();
            };

            function attachSidebarForms() {
                document.querySelectorAll('.cart-sidebar-remove-form').forEach(function (form) {
                    form.onsubmit = function (e) {
                        e.preventDefault();
                        var data = new FormData(form);
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', 'carrinho.php', true);
                        xhr.onload = function () {
                            if (xhr.status === 200) {
                                loadCartSidebar();
                                updateCartCount();
                            }
                        };
                        xhr.send(data);
                    };
                });
                document.querySelectorAll('.cart-sidebar-qty-form .quantity-selector').forEach(function (select) {
                    select.onchange = function () {
                        var form = select.closest('form');
                        var data = new FormData(form);
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', 'carrinho.php', true);
                        xhr.onload = function () {
                            if (xhr.status === 200) {
                                loadCartSidebar();
                                updateCartCount();
                            }
                        };
                        xhr.send(data);
                    };
                });
            }
        });
    </script>
</head>

<body class="page-body">
    <div class="top-bar">
        <div class="top-bar-container">
            <a href="pagina_home.php" class="logo-link">
                <img src="design_imagens/coffeesbook_logo.png" width="180" alt="Logo da Livraria">
            </a>
            <form class="search-bar" method="get" action="pagina_home.php">
                <input type="text" name="busca" placeholder="O que você procura?"
                    value="<?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?>">
                <button type="submit"><img src="https://cdn-icons-png.flaticon.com/512/622/622669.png" width="20"
                        alt="Buscar"></button>
            </form>
            <div class="header-icons">
                <a href="pagina_login.php" title="Minha Conta">
                    <img src="https://cdn-icons-png.flaticon.com/512/747/747376.png" width="24" height="24"
                        alt="Minha Conta">
                </a>
                <a href="favoritos.php" title="Favoritos" id="favoritos-header-link" style="position:relative;">
                    <img src="https://cdn-icons-png.flaticon.com/512/833/833472.png" width="24" height="24"
                        alt="Favoritos">
                    <span class="favorites-counter" id="favorites-counter" style="display:none;">0</span>
                </a>
                <a href="carrinho.php" title="Sacola" id="open-cart-sidebar">
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
    <nav class="main-nav">
        <ul>
            <li class="main-nav-hamburger" style="position:relative;">
                <a href="#" id="main-menu-toggle">
                    <span class="main-menu-icon">
                        <span class="main-menu-bar"></span>
                        <span class="main-menu-bar"></span>
                        <span class="main-menu-bar"></span>
                    </span>
                </a>
                <span class="comprar-categoria-label" id="comprar-categoria-label">
                    Compre por categoria <span class="comprar-categoria-arrow">&#9660;</span>
                </span>
                <div class="categorias-dropdown" id="categorias-dropdown">
                    <ul>
                        <?php
                        $query = mysql_query("SELECT codigo, nome FROM categoria");
                        while ($cat = mysql_fetch_array($query)) {
                            echo '<li><a href="pagina_home.php?categoria=' . urlencode($cat['codigo']) . '">' . htmlspecialchars($cat['nome']) . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </li>
            <li><a href="#">Autoajuda</a></li>
            <li><a href="#">Biografias</a></li>
            <li><a href="#">Negócios</a></li>
            <li><a href="#">Lançamentos</a></li>
            <li><a href="#">Ofertas</a></li>
            <li><a href="#">Presentes</a></li>
            <li><a href="#">Mais Vendidos</a></li>
        </ul>
    </nav>
    <script>
        const catLabel = document.getElementById('comprar-categoria-label');
        const catDropdown = document.getElementById('categorias-dropdown');
        const hamburgerLi = catLabel.closest('li');

        function showDropdown() {
            catDropdown.style.display = 'block';
        }
        function hideDropdown() {
            catDropdown.style.display = 'none';
        }
        hamburgerLi.addEventListener('mouseenter', showDropdown);
        hamburgerLi.addEventListener('mouseleave', hideDropdown);
    </script>
    <div class="banner-slideshow">
        <div class="slides fade">
            <img src="design_imagens/banner_01.png" class="banner-img">
        </div>
        <div class="slides fade">
            <img src="design_imagens/banner_02.png" class="banner-img">
        </div>
        <div class="slides fade">
            <img src="design_imagens/banner_03.png" class="banner-img">
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
            <form name="formulario" method="post" action="pagina_home.php" class="form" id="filtro-form">
                <fieldset>
                    <legend>Livros</legend>
                    <label for="categoria">Categoria:</label>
                    <select name="categoria" id="categoria">
                        <option value="" selected>Selecione...</option>
                        <?php
                        $query = mysql_query("SELECT codigo, nome FROM categoria");
                        while ($cat = mysql_fetch_array($query)) {
                            $selected = (isset($_POST['categoria']) && $_POST['categoria'] == $cat['codigo']) ? 'selected' : '';
                            echo '<option value="' . $cat['codigo'] . '" ' . $selected . '>' . htmlspecialchars($cat['nome']) . '</option>';
                        }
                        ?>
                    </select>
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
        </aside>
        <section class="product-list">
            <?php
            $sql_livros = "SELECT livro.codigo, livro.titulo, livro.preco, livro.foto_capa, livro.foto_contracapa, categoria.nome AS categoria, autor.nome AS autor, editora.nome AS editora
                           FROM livro
                           INNER JOIN categoria ON livro.cod_categoria = categoria.codigo
                           INNER JOIN autor ON livro.cod_autor = autor.codigo
                           INNER JOIN editora ON livro.cod_editora = editora.codigo";

            $conditions = array();
            if (isset($_GET['busca']) && trim($_GET['busca']) != '') {
                $busca = mysql_real_escape_string($_GET['busca']);
                $conditions[] = "(livro.titulo LIKE '%$busca%' OR autor.nome LIKE '%$busca%' OR editora.nome LIKE '%$busca%' OR categoria.nome LIKE '%$busca%')";
            }
            if (isset($_POST['pesquisar'])) {
                if (!empty($_POST['categoria'])) {
                    $categoria = mysql_real_escape_string($_POST['categoria']);
                    $conditions[] = "livro.cod_categoria = '$categoria'";
                }
                if (!empty($_POST['autor'])) {
                    $autor = mysql_real_escape_string($_POST['autor']);
                    $conditions[] = "livro.cod_autor = '$autor'";
                }
                if (!empty($_POST['editora'])) {
                    $editora = mysql_real_escape_string($_POST['editora']);
                    $conditions[] = "livro.cod_editora = '$editora'";
                }
            }
            if (isset($_GET['categoria']) && trim($_GET['categoria']) != '') {
                $categoria_get = mysql_real_escape_string($_GET['categoria']);
                $conditions[] = "livro.cod_categoria = '$categoria_get'";
            }
            if (!empty($conditions)) {
                $sql_livros .= " WHERE " . implode(' AND ', $conditions);
            }

            $seleciona_livros = mysql_query($sql_livros);
            if (!$seleciona_livros) {
                echo "Erro na consulta: " . mysql_error();
            } else {
                if (mysql_num_rows($seleciona_livros) == 0) {
                    echo '<h3>Desculpe, mas sua busca não retornou resultados.</h3>';
                } else {
                    echo "<h3>Livros encontrados:</h3>";
                    echo '<div class="product-grid">';
                    while ($dados = mysql_fetch_object($seleciona_livros)) {
                        $preco_antigo = $dados->preco * 1.3;
                        $parcela = $dados->preco / 2;
                        echo "<div class='product-card' data-codigo='{$dados->codigo}'>";
                        echo "<form method='post' action=''>";
                        echo "<div class='product-img-container' style='position:relative;'>";
                        echo "<button type='button' class='favorite-heart' data-codigo='{$dados->codigo}' title='Favoritar' aria-label='Favoritar'>&#10084;</button>";
                        echo "<img src='imagens/{$dados->foto_capa}' alt='Capa do Livro' class='product-img-main'>";
                        echo "<img src='imagens/{$dados->foto_contracapa}' alt='Contracapa do Livro' class='product-img-back'>";
                        echo "</div>";
                        echo "<h4>{$dados->titulo}</h4>";
                        echo "<div class='star-rating'>";
                        echo str_repeat('&#9733;', 5);
                        echo "<span class='star-count'>(1)</span>";
                        echo "</div>";
                        echo "<div class='preco-antigo'>De: R$ " . number_format($preco_antigo, 2, ',', '.') . "<br>Por:" . "</div>";
                        echo "<div class='preco'>R$ " . number_format($dados->preco, 2, ',', '.') . "</div>";
                        echo "<div class='parcelamento'>ou 2x de R$ " . number_format($parcela, 2, ',', '.') . " sem juros</div>";
                        echo "<input type='hidden' name='codigo' value='{$dados->codigo}'>";
                        echo "<div class='buy-button-container'>";
                        echo "<button class='buy-button'>Comprar</button>";
                        echo "</div>";
                        echo "</form>";
                        echo "</div>";
                    }
                    echo '</div>';
                }
            }
            ?>
        </section>
    </main>
    <section id="explore-cultura" class="explore-cultura">
        <h2 class="explore-cultura-title">Explore na Coffee's Book</h2>
        <div id="autores-carousel" class="autores-carousel">
            <button id="autores-prev" class="autores-carousel-btn">&#10094;</button>
            <div id="autores-lista" class="autores-lista">
                <?php
                $autores = array(
                    array(
                        'nome' => 'Machado de Assis',
                        'foto_url' => 'https://upload.wikimedia.org/wikipedia/commons/4/40/Machado_de_Assis_aos_57_anos.jpg'
                    ),
                    array(
                        'nome' => 'Clarice Lispector',
                        'foto_url' => 'https://s2.static.brasilescola.uol.com.br/be/2022/09/clarice-lispector.jpg'
                    ),
                    array(
                        'nome' => 'Paulo Coelho',
                        'foto_url' => 'https://wp-content.amenteemaravilhosa.com.br/2015/08/8-PO-15-frases-c%C3%A9lebres-de-Paulo-Coelho.jpg'
                    ),
                    array(
                        'nome' => 'Cecília Meireles',
                        'foto_url' => 'https://multi.rio/images/img_2015_06/cecilia_home.jpg'
                    ),
                    array(
                        'nome' => 'Monteiro Lobato',
                        'foto_url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQO2wgdpw1ZcXUQevhhbUO_KPduWVVyKT7qkuGFyGHd7k3RPOH4mptZm5wSbsUI0c0JVt4&usqp=CAU'
                    ),
                    array(
                        'nome' => 'Lygia Fagundes Telles',
                        'foto_url' => 'https://s1.static.brasilescola.uol.com.br/be/2020/09/lygia-fagundes-telles.jpg'
                    ),
                    array(
                        'nome' => 'Rubem Fonseca',
                        'foto_url' => 'https://rascunho.com.br/wp-content/uploads/2024/09/rubem-fonsceca1.jpg'
                    ),
                    array(
                        'nome' => 'Rachel de Queiroz',
                        'foto_url' => 'https://static.todamateria.com.br/upload/ra/ch/racheldequeiroz2.jpg'
                    ),
                );
                foreach ($autores as $idx => $autor) {
                    echo '<div class="autor-card" data-autor-idx="' . $idx . '" style="display:none">';
                    echo '<div class="autor-card-img">';
                    echo '<img src="' . htmlspecialchars($autor['foto_url']) . '" alt="' . htmlspecialchars($autor['nome']) . '">';
                    echo '</div>';
                    echo '<div class="autor-card-nome">' . htmlspecialchars($autor['nome']) . '</div>';
                    echo '</div>';
                }
                ?>
            </div>
            <button id="autores-next" class="autores-carousel-btn">&#10095;</button>
        </div>
        <script>
            (function () {
                const cards = Array.from(document.querySelectorAll('#autores-lista .autor-card'));
                let start = 0;
                const visible = 3;
                function updateCarousel() {
                    cards.forEach((card, idx) => {
                        card.style.display = (idx >= start && idx < start + visible) ? 'flex' : 'none';
                    });
                }
                updateCarousel();
                document.getElementById('autores-prev').onclick = function () {
                    if (start > 0) {
                        start--;
                        updateCarousel();
                    }
                };
                document.getElementById('autores-next').onclick = function () {
                    if (start + visible < cards.length) {
                        start++;
                        updateCarousel();
                    }
                };

                setInterval(function () {
                    if (start + visible < cards.length) {
                        start++;
                    } else {
                        start = 0;
                    }
                    updateCarousel();
                }, 5000);
            })();
        </script>
    </section>
    <div class="social-bar">
        <div class="social-bar-container">
            <span class="social-title">REDES SOCIAIS</span>
            <a href="#" class="social-icon" title="Facebook">
                <img src="design_imagens/facebook_icone.png" alt="Facebook">
            </a>
            <a href="#" class="social-icon" title="Instagram">
                <img src="design_imagens/instagram_icone.png" alt="Instagram">
            </a>
            <a href="#" class="social-icon" title="YouTube">
                <img src="design_imagens/youtube_icone.png" alt="YouTube">
            </a>
            <a href="#" class="social-icon" title="TikTok">
                <img src="design_imagens/tiktok_icone.png" alt="TikTok">
            </a>
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-container"
            style="display: flex; align-items: flex-start; justify-content: center; gap: 32px; flex-wrap: wrap;">
            <div class="footer-info">
                <p><strong>Coffee's Book</strong> - Sua livraria online</p>
                <p>Avenida Jorge Elias De Lucca, n°765, Nossa Senhora da Salete - 88813901, Criciúma - SC</p>
                <p><strong>Atendimento:</strong> contato@coffeesbook.com.br</p>
            </div>
        </div>
        <p>&copy; 2025 Coffee's Book - All rights reserved. </p>
    </footer>

    <div class="cart-sidebar-overlay" id="cart-sidebar-overlay"></div>
    <aside class="cart-sidebar" id="cart-sidebar">
        <div class="cart-sidebar-header">
            <span class="cart-sidebar-title">Sacola</span>
            <button class="cart-sidebar-close" id="close-cart-sidebar" title="Fechar">&times;</button>
        </div>
        <div class="cart-sidebar-content" id="cart-sidebar-content">
        </div>
    </aside>

    <script>
        function loadCartSidebar() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'carrinho.php?sidebar=1', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    document.getElementById('cart-sidebar-content').innerHTML = xhr.responseText;
                    attachSidebarForms();
                }
            };
            xhr.send();
        }

        function attachSidebarForms() {
            document.querySelectorAll('.cart-sidebar-remove-form').forEach(function (form) {
                form.onsubmit = function (e) {
                    e.preventDefault();
                    var data = new FormData(form);
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'carrinho.php', true);
                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            loadCartSidebar();
                            updateCartCount();
                        }
                    };
                    xhr.send(data);
                };
            });
            document.querySelectorAll('.cart-sidebar-qty-form .quantity-selector').forEach(function (select) {
                select.onchange = function () {
                    var form = select.closest('form');
                    var data = new FormData(form);
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'carrinho.php', true);
                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            loadCartSidebar();
                            updateCartCount();
                        }
                    };
                    xhr.send(data);
                };
            });
        }

        document.getElementById('open-cart-sidebar').onclick = function (e) {
            e.preventDefault();
            document.getElementById('cart-sidebar-overlay').classList.add('active');
            document.getElementById('cart-sidebar').classList.add('active');
            loadCartSidebar();
        };
        document.getElementById('close-cart-sidebar').onclick = function () {
            document.getElementById('cart-sidebar-overlay').classList.remove('active');
            document.getElementById('cart-sidebar').classList.remove('active');
            updateCartCount();
        };
        document.getElementById('cart-sidebar-overlay').onclick = function () {
            document.getElementById('cart-sidebar-overlay').classList.remove('active');
            document.getElementById('cart-sidebar').classList.remove('active');
            updateCartCount();
        };
    </script>
</body>

</html>