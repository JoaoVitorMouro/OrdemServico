<?php

require '../../config.php';
include '../../src/Produto.php';

$produto = new Produto($mysql);
$produtos = $produto->exibirTodos();

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Página Administrativa - Produtos</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../style.css">
</head>

<body>
    <div id="container">
        <h1>Listagem de Produtos</h1>
        <div>
            <?php foreach ($produtos as $produto) { ?>
            <div id="site-admin">
                <p>
                    <?php echo $produto['codigo'] . " - " . $produto['descricao'] . " (" . $produto['status'] . ")"; ?><br>
                    Garantia: <?php echo $produto['tempo_garantia']; ?> meses
                </p>
                <nav>
                    <a class="botao" href="editar-produto.php?id=<?php echo $produto['id']; ?>">Editar</a>
                    <a class="botao" href="excluir-produto.php?id=<?php echo $produto['id']; ?>">Excluir</a>
                </nav>
            </div>
            <?php } ?>
        </div>
        <a class="botao botao-block" href="adicionar-produto.php">Adicionar Produto</a>
        <a class="botao botao-block" href="../../index.php">Voltar</a>
    </div>
</body>

</html>
