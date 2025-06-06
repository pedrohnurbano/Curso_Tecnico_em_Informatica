<?php
session_start();
$status = "";

if (isset($_POST['action']) && $_POST['action'] == "remove") {
    if (!empty($_SESSION["shopping_cart"])) {
        foreach ($_SESSION["shopping_cart"] as $key => $value) {
            if (isset($_POST["code"]) && $_POST["code"] == $key) {
                unset($_SESSION["shopping_cart"][$key]);
                $status = "<div class='box error'>Livro removido do carrinho!</div>";
            }
            if (empty($_SESSION["shopping_cart"])) {
                unset($_SESSION["shopping_cart"]);
            }
        }
    }
}

if (isset($_POST['action']) && $_POST['action'] == "change") {
    if (isset($_POST["code"]) && isset($_SESSION["shopping_cart"][$_POST["code"]])) {
        $_SESSION["shopping_cart"][$_POST["code"]]["quantity"] = $_POST["quantity"];
        $status = "<div class='box'>Quantidade atualizada!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Carrinho de Compras | LIVRARIA</title>
    <link rel="shortcut icon" href="design_imagens/coffeesbook_icon.png" type="image/png">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="page-header">
        <a href="pagina_home.php">
            <img src="design_imagens/coffeesbook_logo.png" width="220" alt="Logo da Livraria">
        </a>
        <div class="header-icons">
            <a href="pagina_login.php">
                <img src="design_images/user_icon.png" width="24" height="24" alt="Minha Conta">
                <p>Minha conta e <br> <strong>Meus pedidos</strong></p>
            </a>
            <a href="pagina_home.php">
                <img src="design_images/favorite_icon.png" width="24" height="24" alt="Favoritos">
            </a>
            <a href="carrinho.php">
                <img src="design_images/bag_icon.png" width="24" height="24" alt="Sacola">
                <?php
                if (!empty($_SESSION["shopping_cart"])) {
                    $cart_count = count(array_keys($_SESSION["shopping_cart"]));
                    echo "<span>$cart_count</span>";
                }
                ?>
            </a>
        </div>
    </header>

    <div class="message_box">
        <?php echo $status; ?>
    </div>

    <div class="cart-container">
        <h2 class="cart-title">Meu Carrinho de Compras</h2>

        <?php
        if (isset($_SESSION["shopping_cart"]) && !empty($_SESSION["shopping_cart"])) {
            $total_price = 0;
        ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Livro</th>
                        <th>Quantidade</th>
                        <th>Preço Unitário</th>
                        <th>Subtotal</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($_SESSION["shopping_cart"] as $book_code => $book) {
                        $subtotal = $book["preco"] * $book["quantity"];
                        $total_price += $subtotal;
                    ?>
                        <tr>
                            <td>
                                <div class="product-info">
                                    <img src="imagens/<?php echo $book["capa"]; ?>" alt="<?php echo $book["titulo"]; ?>">
                                    <div>
                                        <div class="product-name"><?php echo $book["titulo"]; ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <form method="post" action="">
                                    <input type="hidden" name="code" value="<?php echo $book_code; ?>">
                                    <input type="hidden" name="action" value="change">
                                    <select name="quantity" class="quantity-selector" onchange="this.form.submit()">
                                        <?php for ($i = 1; $i <= 10; $i++) : ?>
                                            <option value="<?php echo $i; ?>" <?php if ($book["quantity"] == $i) echo "selected"; ?>>
                                                <?php echo $i; ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </form>
                            </td>
                            <td>R$ <?php echo number_format($book["preco"], 2, ',', '.'); ?></td>
                            <td>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
                            <td>
                                <form method="post" action="">
                                    <input type="hidden" name="code" value="<?php echo $book_code; ?>">
                                    <input type="hidden" name="action" value="remove">
                                    <button type="submit" class="remove-btn">Remover</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <div class="cart-summary">
                <div class="total-price">Total: R$ <?php echo number_format($total_price, 2, ',', '.'); ?></div>
            </div>

            <div class="cart-actions">
                <a href="pagina_home.php" class="continue-shopping">Continuar Comprando</a>
                <button class="checkout-btn">Finalizar Compra</button>
            </div>
        <?php
        } else {
        ?>
            <div class="empty-cart">
                <div class="empty-cart-icon">🛒</div>
                <h3>Seu carrinho está vazio</h3>
                <p>Explore nossa livraria e descubra livros incríveis!</p>
                <a href="pagina_home.php" class="continue-shopping">Ir às Compras</a>
            </div>
        <?php
        }
        ?>
    </div>

    <footer class="page-footer">
        <p>&copy; 2025 Coffee's Book - All rights reserved. </p>
    </footer>
</body>
</html>