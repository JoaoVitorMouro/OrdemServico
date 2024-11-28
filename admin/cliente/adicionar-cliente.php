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
        <form action="adicionar-cliente.php" method="POST" onsubmit="limparCPF(document.getElementById('cpf'))">
            <p>
                <label for="nome">Digite o nome do cliente</label>
                <input class="campo-form" type="text" name="nome" id="nome" required />
                <input type="hidden" name="tipo" id="tipo" value="adiciona">
            </p>
            <p>
                <label for="cpf">Digite o CPF do cliente</label>
                <input class="campo-form" type="text" name="cpf" id="cpf" maxlength="14" required />
            </p>
            <p>
                <label for="endereco">Digite o endereço do cliente</label>
                <input class="campo-form" type="text" name="endereco" id="endereco" required />
            </p>
            
            <p>
                <button class="botao">Criar Cliente</button>
            </p>
        </form>
    </div>
</body>

<script>
    // Função para formatar o CPF durante a digitação
    function formatarCPF(campo) {
        let valor = campo.value.replace(/\D/g, ''); // Remove tudo que não é número

        if (valor.length <= 3) {
            campo.value = valor;
        } else if (valor.length <= 6) {
            campo.value = valor.replace(/(\d{3})(\d{1,})/, '$1.$2');
        } else if (valor.length <= 9) {
            campo.value = valor.replace(/(\d{3})(\d{3})(\d{1,})/, '$1.$2.$3');
        } else {
            campo.value = valor.replace(/(\d{3})(\d{3})(\d{3})(\d{1,})/, '$1.$2.$3-$4');
        }
    }

    // Função para limpar a formatação do CPF antes de enviar o formulário
    function limparCPF(campo) {
        campo.value = campo.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
    }

    // Adiciona o evento de input para aplicar a máscara de CPF
    document.getElementById('cpf').addEventListener('input', function () {
        formatarCPF(this);
    });
</script>

</html>