<?php

require '../../config.php';
include '../../src/Cliente.php';
require '../../src/redireciona.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente = new Cliente($mysql);
    $cliente->editar($_POST['id'], $_POST['nome'], $_POST['cpf'], $_POST['endereco']);

    redireciona('/blog/index.php');
}

$cliente = new Cliente($mysql);
$cli = $cliente->encontrarPorId($_GET['id']);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" type="text/css" href="../../style.css">
    <meta charset="UTF-8">
    <title>Editar Artigo</title>
</head>

<body>
    <div id="container">
        <h1>Editar Artigo</h1>
        <form action="editar-cliente.php" method="post">
            <p>
                <label for="nome">Digite o novo nome do cliente</label>
                <input class="campo-form" type="text" name="nome" id="nome" value="<?php echo $cli['nome']; ?>" />
            </p>
            <p>
                <label for="cpf">Digite o novo cpf do cliente</label>
                <input class="campo-form" type="text" name="cpf" id="cpf" value="<?php echo $cli['cpf']; ?>" />
            </p>
            <p>
                <label for="endereco">Digite o novo Endereço do cliente</label>
                <input class="campo-form" type="text" name="endereco" id="endereco" value="<?php echo $cli['endereco']; ?>"/>
            </p>
            <p>
                <input type="hidden" name="id" value="<?php echo $cli['id']; ?>" />
            </p>
            <p>
                <button class="botao">Editar Cliente</button>
            </p>
        </form>
    </div>
</body>

</html>