<?php

require '../../config.php';
include '../../src/Produto.php';
require '../../src/redireciona.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto = new Produto($mysql);
    $produto->editar($_POST['id'], $_POST['codigo'], $_POST['descricao'], $_POST['status'], $_POST['tempo_garantia']);

    redireciona('/blog/admin/produto/listar-produtos.php');

}

$produto = new Produto($mysql);
$prod = $produto->encontrarPorId($_GET['id']);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" type="text/css" href="../../style.css">
    <meta charset="UTF-8">
    <title>Editar Produto</title>
</head>

<body>
    <div id="container">
        <h1>Editar Produto</h1>
        <form action="editar-produto.php" method="post">
            <p>
                <label for="codigo">Digite o novo código do produto</label>
                <input class="campo-form" type="text" name="codigo" id="codigo" value="<?php echo $prod['codigo']; ?>" />
            </p>
            <p>
                <label for="descricao">Digite a nova descrição do produto</label>
                <input class="campo-form" type="text" name="descricao" id="descricao" value="<?php echo $prod['descricao']; ?>" />
            </p>
            <p>
                <label for="status">Selecione o novo status do produto</label>
                <select class="campo-form" name="status" id="status">
                    <option value="ativo" <?php echo $prod['status'] === 'ativo' ? 'selected' : ''; ?>>Ativo</option>
                    <option value="inativo" <?php echo $prod['status'] === 'inativo' ? 'selected' : ''; ?>>Inativo</option>
                </select>
            </p>
            <p>
                <label for="tempo_garantia">Digite o novo tempo de garantia (em meses)</label>
                <input class="campo-form" type="number" name="tempo_garantia" id="tempo_garantia" value="<?php echo $prod['tempo_garantia']; ?>" />
            </p>
            <p>
                <input type="hidden" name="id" value="<?php echo $prod['id']; ?>" />
            </p>
            <p>
                <button class="botao">Editar Produto</button>
            </p>
        </form>
    </div>
</body>

</html>
