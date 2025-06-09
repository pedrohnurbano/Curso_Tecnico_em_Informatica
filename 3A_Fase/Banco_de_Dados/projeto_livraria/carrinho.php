<?php
session_start();

if (isset($_GET['count']) && $_GET['count'] == 1) {
    echo !empty($_SESSION["shopping_cart"]) ? count($_SESSION["shopping_cart"]) : 0;
    exit;
}

if (isset($_POST['action']) && $_POST['action'] === "remove" && isset($_POST["code"])) {
    $code = $_POST["code"];
    if (!empty($_SESSION["shopping_cart"][$code])) {
        unset($_SESSION["shopping_cart"][$code]);
        if (empty($_SESSION["shopping_cart"])) {
            unset($_SESSION["shopping_cart"]);
        }
    }
}

if (isset($_POST['action']) && $_POST['action'] === "change" && isset($_POST["code"], $_POST["quantity"])) {
    $code = $_POST["code"];
    $qty = (int) $_POST["quantity"];
    if (isset($_SESSION["shopping_cart"][$code]) && $qty > 0 && $qty <= 10) {
        $_SESSION["shopping_cart"][$code]["quantity"] = $qty;
    }
}

if (isset($_GET['sidebar']) && $_GET['sidebar'] == 1) {
    if (!empty($_SESSION["shopping_cart"])) {
        $total_price = 0;
        ?>
        <table class="cart-sidebar-table">
            <tbody>
                <?php foreach ($_SESSION["shopping_cart"] as $book_code => $book):
                    $subtotal = $book["preco"] * $book["quantity"];
                    $total_price += $subtotal;
                    ?>
                    <tr>
                        <td style="padding:0 0 0 4px;">
                            <img src="imagens/<?php echo htmlspecialchars($book["capa"]); ?>"
                                alt="<?php echo htmlspecialchars($book["titulo"]); ?>"
                                style="width:38px;height:56px;object-fit:cover;border-radius:4px;">
                        </td>
                        <td style="min-width:90px;">
                            <div style="font-size:0.98em;font-weight:bold;line-height:1.2;">
                                <?php echo htmlspecialchars($book["titulo"]); ?>
                            </div>
                            <div style="font-size:0.93em;color:#888;">R$ <?php echo number_format($book["preco"], 2, ',', '.'); ?>
                            </div>
                        </td>
                        <td>
                            <form method="post" class="cart-sidebar-qty-form" style="margin:0;">
                                <input type="hidden" name="code" value="<?php echo htmlspecialchars($book_code); ?>">
                                <input type="hidden" name="action" value="change">
                                <select name="quantity" class="quantity-selector" style="width:38px;">
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php if ($book["quantity"] == $i)
                                               echo "selected"; ?>>
                                            <?php echo $i; ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </form>
                        </td>
                        <td style="font-size:0.98em;">
                            R$ <?php echo number_format($subtotal, 2, ',', '.'); ?>
                        </td>
                        <td>
                            <form method="post" class="cart-sidebar-remove-form" style="margin:0;">
                                <input type="hidden" name="code" value="<?php echo htmlspecialchars($book_code); ?>">
                                <input type="hidden" name="action" value="remove">
                                <button type="submit" class="remove-btn" title="Remover"
                                    style="padding:4px 10px;font-size:1.1em;">✕</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="cart-sidebar-summary" style="margin-top:10px;">
            Total: R$ <?php echo number_format($total_price, 2, ',', '.'); ?>
        </div>
        <div class="cart-sidebar-actions" style="margin-top:8px;">
            <a href="pagina_home.php" class="continue-shopping">Continuar Comprando</a>
            <button class="checkout-btn" onclick="alert('Funcionalidade de checkout não implementada!')">Finalizar
                Compra</button>
        </div>
        <?php
    } else {
        ?>
        <div class="cart-sidebar-empty">
            <div class="empty-cart-icon">🛒</div>
            <h3>Seu carrinho está vazio</h3>
            <a href="pagina_home.php" class="continue-shopping">Ir às Compras</a>
        </div>
        <?php
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<body class="page-body">
    <div class="cart-sidebar-overlay" id="cartSidebarOverlay"></div>
    <aside class="cart-sidebar" id="cartSidebar">
        <div class="cart-sidebar-header">
            <span class="cart-sidebar-title">Meu Carrinho</span>
            <button class="cart-sidebar-close" id="closeCartSidebar" title="Fechar">&times;</button>
        </div>
        <div class="cart-sidebar-content" id="cartSidebarContent"></div>
    </aside>

    <script>
        function openCartSidebar() {
            document.getElementById('cartSidebarOverlay').classList.add('active');
            document.getElementById('cartSidebar').classList.add('active');
            renderCartSidebar();
        }
        function closeCartSidebar() {
            document.getElementById('cartSidebarOverlay').classList.remove('active');
            document.getElementById('cartSidebar').classList.remove('active');
        }

        document.addEventListener('DOMContentLoaded', function () {
            var openBtn = document.getElementById('open-cart-sidebar');
            if (openBtn) {
                openBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    openCartSidebar();
                });
            }
            var closeBtn = document.getElementById('closeCartSidebar');
            if (closeBtn) closeBtn.addEventListener('click', closeCartSidebar);
            var overlay = document.getElementById('cartSidebarOverlay');
            if (overlay) overlay.addEventListener('click', closeCartSidebar);
        });

        function renderCartSidebar() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'carrinho.php?sidebar=1', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    document.getElementById('cartSidebarContent').innerHTML = xhr.responseText;
                    document.querySelectorAll('.cart-sidebar-remove-form').forEach(function (form) {
                        form.onsubmit = function (ev) {
                            ev.preventDefault();
                            var fd = new FormData(form);
                            fetch('carrinho.php', { method: 'POST', body: fd })
                                .then(() => { renderCartSidebar(); updateCartCount(); });
                        };
                    });
                    document.querySelectorAll('.cart-sidebar-qty-form').forEach(function (form) {
                        form.onchange = function (ev) {
                            var fd = new FormData(form);
                            fetch('carrinho.php', { method: 'POST', body: fd })
                                .then(() => { renderCartSidebar(); updateCartCount(); });
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
                    var el = document.getElementById('cart-count');
                    if (el) {
                        el.textContent = count;
                        el.style.display = count > 0 ? 'inline-block' : 'none';
                    }
                }
            };
            xhr.send();
        }
    </script>
</body>

</html>