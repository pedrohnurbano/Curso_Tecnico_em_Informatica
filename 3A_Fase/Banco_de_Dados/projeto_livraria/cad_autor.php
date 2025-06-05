<?php

$conectar = mysql_connect  ('localhost', 'root', '');
$banco    = mysql_select_db('livraria'                          );

    if (isset($_POST['Gravar'])) {
        $codigo = $_POST['codigo'];
        $nome   = $_POST['nome'  ];
        $pais   = $_POST['pais'  ];

        $sql       = "insert into autor (codigo, nome, pais) values ('$codigo','$nome','$pais')";
        $resultado = mysql_query($sql)                                                   ;

        if ($resultado == TRUE) 
            {echo "Dados gravados com sucesso!              ";}
        else
            {echo "Erro. - Motivo: Falha ao gravar os dados.";}
    }

    if (isset($_POST['Alterar'])) {
        $codigo = $_POST['codigo'];
        $nome   = $_POST['nome'  ];
        $pais   = $_POST['pais'  ];

        $sql       = "update autor set nome = '$nome', pais = '$pais' where codigo = '$codigo'";
        $resultado = mysql_query($sql)                                                  ;

        if ($resultado == TRUE) 
            {echo "Dados alterados com sucesso!              ";} 
        else
            {echo "Erro. - Motivo: Falha ao alterar os dados.";}
    }

    if (isset($_POST['Excluir'])) {
        $codigo = $_POST['codigo'];

        $sql       = "delete from autor where codigo = '$codigo'";
        $resultado = mysql_query($sql)                    ;

        if ($resultado == TRUE)
            {echo "Dados excluídos com sucesso!              ";} 
        else
            {echo "Erro. - Motivo: Falha ao excluir os dados.";}
    }

    if (isset($_POST['Pesquisar'])) {
        $sql       = "select * from autor"   ;
        $resultado = mysql_query($sql);

        if (mysql_num_rows($resultado) == 0) 
            {echo "Erro. - Motivo: Dados não encontrados.";} 
        else 
            {echo "<b>Pesquisa de Autores: </b><br>";
                while ($dados = mysql_fetch_array($resultado))
                    {
                    echo "Código: " . $dados['codigo'] . "<br>"    .
                         "Nome:   " . $dados['nome'  ] . "<br>"    .
                         "País:   " . $dados['pais'  ] . "<br><br>";
                    }
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
        <link rel="stylesheet   " href="styles.css                                          ">
    </head>

    <body>
        <header>
            <img src="design_imagens/coffeesbook_logo.png" width="150">
        </header>

        <main>
            <div id="titulo">
                <h1>Formulário de Cadastro de Autores</h1>
            </div>

            <form class='form' name="formulario" method="POST" action="cad_autor.php">
                <fieldset>
                    <legend>Dados do Autor:</legend>
                    <label >Código: <input type="text" name="codigo" id="codigo" size="5"  placeholder="Digite seu código       "></label><br><br>
                    <label >Nome:   <input type="text" name="nome"   id="nome"   size="50" placeholder="Digite seu nome completo"></label><br><br>
                    <label >País:   <input type="text" name="pais"   id="pais"   size="30" placeholder="Digite seu país         "></label><br><br>
                </fieldset>
                <button type="submit" name="Gravar   ">Gravar   </button>
                <button type="submit" name="Alterar  ">Alterar  </button>
                <button type="submit" name="Excluir  ">Excluir  </button>
                <button type="submit" name="Pesquisar">Pesquisar</button>
            </form>
        </main>

        <footer>
            <p>&copy; 2025 Coffee's Book - All rights reserved. </p>
        </footer>
    </body>
</html>