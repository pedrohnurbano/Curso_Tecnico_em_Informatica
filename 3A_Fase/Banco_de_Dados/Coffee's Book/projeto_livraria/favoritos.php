<?php
session_start();

if (isset($_POST['action']) && $_POST['action'] === "add" && isset($_POST["code"])) {
    $code = $_POST["code"];
    $book = array(
        "titulo" => isset($_POST["titulo"]) ? $_POST["titulo"] : "Livro",
        "capa" => isset($_POST["capa"]) ? $_POST["capa"] : "default.jpg",
        "preco" => isset($_POST["preco"]) ? $_POST["preco"] : 0
    );
    $_SESSION["favoritos"][$code] = $book;
}

if (isset($_POST['action']) && $_POST['action'] === "remove" && isset($_POST["code"])) {
    $code = $_POST["code"];
    if (!empty($_SESSION["favoritos"][$code])) {
        unset($_SESSION["favoritos"][$code]);
        if (empty($_SESSION["favoritos"])) {
            unset($_SESSION["favoritos"]);
        }
    }
}

if (isset($_GET['count']) && $_GET['count'] == 1) {
    echo isset($_SESSION["favoritos"]) ? count($_SESSION["favoritos"]) : 0;
    exit;
}

if (isset($_GET['sidebar']) && $_GET['sidebar'] == 1) {
    if (!empty($_SESSION["favoritos"])) {
        ?>
        <table class="fav-sidebar-table">
            <tbody>
                <?php foreach ($_SESSION["favoritos"] as $book_code => $book): ?>
                    <tr>
                        <td>
                            <img src="imagens/<?php echo htmlspecialchars($book["capa"]); ?>"
                                alt="<?php echo htmlspecialchars($book["titulo"]); ?>"
                                style="width:38px;height:56px;object-fit:cover;border-radius:4px;">
                        </td>
                        <td>
                            <div style="font-size:0.98em;font-weight:bold;">
                                <?php echo htmlspecialchars($book["titulo"]); ?>
                            </div>
                            <div style="font-size:0.93em;color:#888;">
                                R$ <?php echo number_format($book["preco"], 2, ',', '.'); ?>
                            </div>
                        </td>
                        <td>
                            <form method="post" class="fav-sidebar-remove-form" style="margin:0;">
                                <input type="hidden" name="code" value="<?php echo htmlspecialchars($book_code); ?>">
                                <input type="hidden" name="action" value="remove">
                                <button type="submit" title="Remover" style="padding:4px 10px;">✕</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    } else {
        ?>
        <div class="fav-sidebar-empty">
            <div class="empty-fav-icon">⭐</div>
            <h3>Você não tem favoritos</h3>
            <a href="pagina_home.php" class="continue-shopping">Ir às Compras</a>
        </div>
        <?php
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Meus Favoritos</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="fav-sidebar-overlay" id="favSidebarOverlay"></div>
    <aside class="fav-sidebar" id="favSidebar">
        <div class="fav-sidebar-header">
            <span class="fav-sidebar-title">Meus Favoritos</span>
            <button class="fav-sidebar-close" id="closeFavSidebar" title="Fechar">&times;</button>
        </div>
        <div class="fav-sidebar-content" id="favSidebarContent"></div>
    </aside>
    <script>
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
                                .then(() => { renderFavSidebar(); updateFavoritesCounter(); });
                        };
                    });
                }
            };
            xhr.send();
        }
        function openFavSidebar() {
            document.getElementById('favSidebarOverlay').classList.add('active');
            document.getElementById('favSidebar').classList.add('active');
            renderFavSidebar();
        }
        function closeFavSidebar() {
            document.getElementById('favSidebarOverlay').classList.remove('active');
            document.getElementById('favSidebar').classList.remove('active');
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
        document.addEventListener('DOMContentLoaded', function () {
            openFavSidebar();
            document.getElementById('closeFavSidebar').onclick = closeFavSidebar;
            document.getElementById('favSidebarOverlay').onclick = closeFavSidebar;
        });
    </script>
</body>

</html>