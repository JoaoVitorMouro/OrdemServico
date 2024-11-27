<?php

require '../../config.php';
require '../../src/Produto.php';
require '../../src/redireciona.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto = new Produto($mysql);
    if (!empty($_POST['tipo'])) {
        if ($_POST['tipo'] === 'adiciona') {
            $produto->adicionar($_POST['codigo'], $_POST['descricao'], $_POST['status'], $_POST['tempo_garantia']);
            redireciona('/blog/admin/produto/listar-produtos.php');
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" type="text/css" href="../../style.css">
    <meta charset="UTF-8">
    <title>Adicionar Produto</title>
</head>

<body>
    <div id="container">
        <h1>Adicionar Produto</h1>
        <form action="adicionar-produto.php" method="POST">
            <p>
                <label for="codigo">Digite o código do produto</label>
                <input class="campo-form" type="text" name="codigo" id="codigo" required />
                <input type="hidden" name="tipo" id="tipo" value="adiciona">
            </p>
            <p>
                <label for="descricao">Digite a descrição do produto</label>
                <textarea class="campo-form" name="descricao" id="descricao" rows="4" required></textarea>
            </p>
            <p>
                <label for="status">Selecione o status do produto</label>
                <select class="campo-form" name="status" id="status" required>
                    <option value="ativo">Ativo</option>
                    <option value="inativo">Inativo</option>
                </select>
            </p>
            <p>
                <label for="tempo_garantia">Digite o tempo de garantia (em meses)</label>
                <input class="campo-form" type="number" name="tempo_garantia" id="tempo_garantia" min="0" required />
            </p>
            <p>
                <button class="botao">Criar Produto</button>
            </p>
        </form>
    </div>
</body>

</html>
