<?php

require '../../config.php';
include '../../src/OrdemServico.php';

$ordemservico = new OrdemServico($mysql);
$ordens = $ordemservico->exibirTodos();

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Página Administrativa - Ordens de Serviço</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../style.css">
</head>

<body>
    <div id="container">
        <h1>Listagem de Ordens de Serviço</h1>
        <div>
            <?php foreach ($ordens as $ordem) { ?>
            <div id="site-admin">
                <p><strong>Número da Ordem:</strong> <?php echo $ordem['numero_ordem']; ?></p>
                <p><strong>Cliente:</strong> <?php echo $ordem['cliente']; ?></p>
                <p><strong>Produto:</strong> <?php echo $ordem['produto']; ?></p>
                <p><strong>Data de Abertura:</strong> <?php echo date('d/m/Y', strtotime($ordem['data_abertura'])); ?></p>
                <nav>
                    <a class="botao" href="editar-os.php?id=<?php echo $ordem['id']; ?>">Editar</a>
                    <a class="botao" href="excluir-os.php?id=<?php echo $ordem['id']; ?>">Excluir</a>
                </nav>
            </div>
            <?php } ?>
        </div>
        <a class="botao botao-block" href="adicionar-os.php">Adicionar Ordem de Serviço</a>
        <a class="botao botao-block" href="../../index.php">Voltar</a>
    </div>
</body>

</html>
