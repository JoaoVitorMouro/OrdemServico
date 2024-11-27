<?php

require '../../config.php';
include '../../src/Produto.php';
require '../../src/redireciona.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto = new Produto($mysql);
    $produto->remover($_POST['id']);

    redireciona('/blog/admin/produto/listar-produtos.php');
}


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <meta charset="UTF-8">
    <title>Excluir Produto</title>
</head>

<body>
    <div id="container">
        <h1>Você realmente deseja excluir o produto?</h1>
        <form method="post" action="excluir-produto.php">
            <p>
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                <button class="botao">Excluir</button>
            </p>
        </form>
    </div>
</body>

</html>