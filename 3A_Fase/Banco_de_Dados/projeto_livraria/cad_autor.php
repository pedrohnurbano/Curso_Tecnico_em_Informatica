<?php
$conectar = mysql_connect('localhost', 'root', '');
$banco = mysql_select_db('livraria');

$pesquisa_autores = array();
$exibir_pesquisa = false;

if (isset($_POST['Gravar'])) {
    $codigo = $_POST['codigo'];
    $nome = $_POST['nome'];
    $pais = $_POST['pais'];

    $sql = "INSERT INTO autor (codigo, nome, pais) VALUES ('$codigo','$nome','$pais')";
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
    $pais = $_POST['pais'];

    $sql = "UPDATE autor SET nome = '$nome', pais = '$pais' WHERE codigo = '$codigo'";
    $resultado = mysql_query($sql);

    if ($resultado == TRUE) {
        echo "<div class='box'>Dados alterados com sucesso!</div>";
    } else {
        echo "<div class='boxerror'>Erro ao alterar os dados.</div>";
    }
}

if (isset($_POST['Excluir'])) {
    $codigo = $_POST['codigo'];

    $sql = "DELETE FROM autor WHERE codigo = '$codigo'";
    $resultado = mysql_query($sql);

    if ($resultado == TRUE) {
        echo "<div class='box'>Dados excluídos com sucesso!</div>";
    } else {
        echo "<div class='boxerror'>Erro ao excluir os dados.</div>";
    }
}

if (isset($_POST['Pesquisar'])) {
    $sql = "SELECT * FROM autor";
    $resultado = mysql_query($sql);

    if (mysql_num_rows($resultado) == 0) {
        echo "<div class='boxerror'>Nenhum autor encontrado.</div>";
    } else {
        while ($dados = mysql_fetch_array($resultado)) {
            $pesquisa_autores[] = $dados;
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
    <title>Cadastro de Autores</title>
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
    <?php if ($exibir_pesquisa && count($pesquisa_autores) > 0): ?>
        <div class="product-list" style="max-width:900px;margin:32px auto 0 auto;">
            <h3 style="margin-bottom:18px;">Autores cadastrados:</h3>
            <div class="product-grid">
                <?php foreach ($pesquisa_autores as $autor): ?>
                    <div class="product-card" style="align-items:flex-start;">
                        <div style="width:100%;">
                            <h4 style="margin-bottom:6px;"><?php echo htmlspecialchars($autor['nome']); ?></h4>
                            <div class="autor" style="color:#888;margin-bottom:4px;">
                                <strong>Código:</strong> <?php echo htmlspecialchars($autor['codigo']); ?>
                            </div>
                            <div class="editora" style="color:#888;">
                                <strong>País:</strong> <?php echo htmlspecialchars($autor['pais']); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    <main class="main-container cadastro-main-center">
        <section class="cadastro-section">
            <div id="titulo">
                <h1>Cadastro de Autor</h1>
            </div>
            <form class="form-admin" name="formulario" method="POST" action="cad_autor.php">
                <fieldset>
                    <legend>Dados do Autor</legend>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="codigo">Código</label>
                            <input type="text" name="codigo" id="codigo" placeholder="Digite o código">
                        </div>
                        <div class="form-col">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome" placeholder="Digite o nome completo">
                        </div>
                        <div class="form-col">
                            <label for="pais">País</label>
                            <input type="text" name="pais" id="pais" placeholder="Digite o país">
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