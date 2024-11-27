<?php

require '../../config.php';
include '../../src/Cliente.php';

$cliente = new Cliente($mysql);
$clientes = $cliente->exibirTodos();

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Página administrativa</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../style.css">
</head>

<body>
    <div id="container">
        <h1>Listagem de Clientes</h1>
        <div>
            <?php foreach ($clientes as $cliente) { ?>
            <div id="site-admin">
                <p><?php echo ($cliente['nome']." - ". $cliente['cpf']); ?></p>
                <nav>
                    <a class="botao" href="editar-cliente.php?id=<?php echo $cliente['id']; ?>">Editar</a>
                    <a class="botao" href="excluir-cliente.php?id=<?php echo $cliente['id']; ?>">Excluir</a>
                </nav>
            </div>
            <?php } ?>
        </div>
        <a class="botao botao-block" href="adicionar-cliente.php">Adicionar Cliente</a>
        <a class="botao botao-block" href="../../index.php">Voltar</a>

    </div>
</body>

</html>