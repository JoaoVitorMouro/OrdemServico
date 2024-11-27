<?php

require '../../config.php';
include '../../src/OrdemServico.php';
require '../../src/redireciona.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ordem = new OrdemServico($mysql);
    $ordem->remover($_POST['id']);

    redireciona('/blog/index.php');
}


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" type="text/css" href="../../style.css">
    <meta charset="UTF-8">
    <title>Excluir Ordem de Serviço</title>
</head>

<body>
    <div id="container">
        <h1>Você realmente deseja excluir a Ordem de Serviço?</h1>
        <form method="post" action="excluir-os.php">
            <p>
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                <button class="botao">Excluir</button>
            </p>
        </form>
    </div>
</body>

</html>