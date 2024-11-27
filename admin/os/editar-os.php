<?php

require '../../config.php';
include '../../src/OrdemServico.php';
include '../../src/Produto.php';
require '../../src/redireciona.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ordemServico = new OrdemServico($mysql);
    
    // Atualiza a ordem de serviço
    $ordemServico->editar($_POST['id'], $_POST['numero_ordem'], $_POST['cpf'], $_POST['nome_cliente'], $_POST['produto_id'], $_POST['data_abertura']);

    redireciona('/blog/admin/os/listar-os.php');
}

// Recupera a ordem de serviço a ser editada
$ordemServico = new OrdemServico($mysql);
// var_dump("teste"); exit;

$os = $ordemServico->encontrarPorId($_GET['id']);
$produto = new Produto($mysql);
$produtos = $produto->exibirTodos();

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" type="text/css" href="../../style.css">
    <meta charset="UTF-8">
    <title>Editar Ordem de Serviço</title>
</head>

<body>
    <div id="container">
        <h1>Editar Ordem de Serviço</h1>
        <form action="editar-os.php" method="post" onsubmit="limparCPF(document.getElementById('cpf'))">
            <p>
                <label for="numero_ordem">Número da Ordem</label>
                <input class="campo-form" type="text" name="numero_ordem" id="numero_ordem" value="<?php echo $os['numero_ordem']; ?>" required />
            </p>
            <p>
                <label for="cpf">CPF do Cliente</label>
                <input class="campo-form" type="text" name="cpf" id="cpf" maxlength="14" required value="<?php echo $os['cpf']; ?>"  oninput="formatarCPF(this); buscarCliente()" />
            </p>
            <p>
                <label for="nome_cliente">Nome do Cliente</label>
                <input class="campo-form" type="text" name="nome_cliente" id="nome_cliente" value="<?php echo $os['cliente']; ?>" required readonly/>
            </p>
            <p>
                <label for="produto_id">Produto</label>
                <select name="produto_id" id="produto_id" required>
                    <?php foreach ($produtos as $produto) { ?>
                        <option value="<?php echo $produto['id']; ?>" <?php echo $os['produto_id'] == $produto['id'] ? 'selected' : ''; ?>>
                            <?php echo $produto['descricao']; ?>
                        </option>
                    <?php } ?>
                </select>
            </p>
            <p>
                <label for="data_abertura">Data de Abertura</label>
                <input class="campo-form" type="date" name="data_abertura" id="data_abertura" value="<?php echo $os['data_abertura']; ?>" required />
            </p>
            <p>
                <input type="hidden" name="id" value="<?php echo $os['id']; ?>" />
            </p>
            <p>
                <button class="botao">Editar Ordem de Serviço</button>
            </p>
        </form>
    </div>

   
</body>

</html>
<script>
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

        function buscarCliente(cpf) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "buscar-cliente.php?cpf=" + cpf, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var resposta = JSON.parse(xhr.responseText);
                    console.log(resposta);

                    // Se o cliente for encontrado, preenche o nome automaticamente
                    if (resposta.id) {
                        document.getElementById("nome_cliente").value = resposta.nome;
                        document.getElementById("nome_cliente").readOnly = true;  // Torna o campo nome somente leitura
                    } else {
                        document.getElementById("nome_cliente").value = '';
                        document.getElementById("nome_cliente").readOnly = false;  // Torna o campo nome editável
                    }
                }
            };
            xhr.send();
        }

     

    document.getElementById('cpf').addEventListener('input', function() {
    var cpf = this.value.replace(/\D/g, '');  // Remove todos os caracteres não numéricos
    
    if (cpf.length === 0) {
        // Se o CPF estiver vazio, limpa o campo de nome e permite a edição
        document.getElementById("nome_cliente").value = '';
        document.getElementById("nome_cliente").readOnly = false;
    } else {
        // Caso contrário, faz a busca pelo cliente
        buscarCliente(cpf);

        // Se o CPF tiver menos de 11 caracteres (o usuário apagou algo), limpa o campo de nome
        if (cpf.length < 11) {
            document.getElementById("nome_cliente").value = '';
            document.getElementById("nome_cliente").readOnly = false;
        }
    }
});
window.onload = function() {
        var cpf = document.getElementById('cpf').value.replace(/\D/g, ''); // Pega o valor do campo CPF e remove caracteres não numéricos
        if (cpf.length === 11) {
            // Se o CPF já estiver preenchido, formata o CPF e faz a busca do cliente
            formatarCPF(document.getElementById('cpf'));
            buscarCliente(cpf); // Faz a busca para preencher o nome
        }
    };

    function limparCPF(campo) {
    campo.value = campo.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
}
    </script>