<?php

require '../../config.php';
require '../../src/Cliente.php';
require '../../src/redireciona.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente = new Cliente($mysql);
    if (!empty($_POST['tipo'])) {
        if($_POST['tipo'] == 'adiciona'){
            $cliente->adicionar($_POST['nome'], $_POST['cpf'], $_POST['endereco']);
            redireciona('/blog/index.php');
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" type="text/css" href="../../style.css">
    <meta charset="UTF-8">
    <title>Adicionar Cliente</title>
</head>

<body>
    <div id="container">
        <h1>Adicionar Cliente</h1>
        <form action="adicionar-cliente.php" method="POST">
            <p>
                <label for="">Digite o nome do cliente</label>
                <input class="campo-form" type="text" name="nome" id="nome" />
                <input type="hidden" name="tipo" id="tipo" value="adiciona">
            </p>
            <p>
                <label for="">Digite o cpf do cliente</label>
                <input class="campo-form" type="text" name="cpf" id="cpf" />
            </p>
            <p>
                <label for="">Digite o endereço do cliente</label>
                <input class="campo-form" type="text" name="endereco" id="endereco" />
            </p>
            
            <p>
                <button class="botao">Criar Cliente</button>
            </p>
        </form>
    </div>
</body>

</html>