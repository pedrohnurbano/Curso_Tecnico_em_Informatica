<?php
$conectar = mysql_connect('localhost', 'root', '');
$banco = mysql_select_db('livraria');

$pesquisa_editoras = array();
$exibir_pesquisa = false;

if (isset($_POST['Gravar'])) {
    $codigo = $_POST['codigo'];
    $nome = $_POST['nome'];

    $sql = "INSERT INTO editora (codigo, nome) VALUES ('$codigo','$nome')";
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

    $sql = "UPDATE editora SET nome = '$nome' WHERE codigo = '$codigo'";
    $resultado = mysql_query($sql);

    if ($resultado == TRUE) {
        echo "<div class='box'>Dados alterados com sucesso!</div>";
    } else {
        echo "<div class='boxerror'>Erro ao alterar os dados.</div>";
    }
}

if (isset($_POST['Excluir'])) {
    $codigo = $_POST['codigo'];

    $sql = "DELETE FROM editora WHERE codigo = '$codigo'";
    $resultado = mysql_query($sql);

    if ($resultado == TRUE) {
        echo "<div class='box'>Dados excluídos com sucesso!</div>";
    } else {
        echo "<div class='boxerror'>Erro ao excluir os dados.</div>";
    }
}

if (isset($_POST['Pesquisar'])) {
    $sql = "SELECT * FROM editora";
    $resultado = mysql_query($sql);

    if (mysql_num_rows($resultado) == 0) {
        echo "<div class='boxerror'>Nenhuma editora encontrada.</div>";
    } else {
        while ($dados = mysql_fetch_array($resultado)) {
            $pesquisa_editoras[] = $dados;
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
    <title>Cadastro de Editoras</title>
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
    <?php if ($exibir_pesquisa && count($pesquisa_editoras) > 0): ?>
        <div class="product-list" style="max-width:900px;margin:32px auto 0 auto;">
            <h3 style="margin-bottom:18px;">Editoras cadastradas:</h3>
            <div class="product-grid">
                <?php foreach ($pesquisa_editoras as $editora): ?>
                    <div class="product-card" style="align-items:flex-start;">
                        <div style="width:100%;">
                            <h4 style="margin-bottom:6px;"><?php echo htmlspecialchars($editora['nome']); ?></h4>
                            <div class="editora" style="color:#888;">
                                <strong>Código:</strong> <?php echo htmlspecialchars($editora['codigo']); ?>
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
                <h1>Cadastro de Editora</h1>
            </div>
            <form class="form-admin" name="formulario" method="POST" action="cad_editora.php">
                <fieldset>
                    <legend>Dados da Editora</legend>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="codigo">Código</label>
                            <input type="text" name="codigo" id="codigo" placeholder="Digite o código">
                        </div>
                        <div class="form-col">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome" placeholder="Digite o nome da editora">
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