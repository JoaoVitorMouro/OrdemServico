<?php

require '../../config.php';
include '../../src/OrdemServico.php';
include '../../src/Produto.php';
require '../../src/redireciona.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ordemServico = new OrdemServico($mysql);
    
    // Verifica se todos os campos foram preenchidos
    if (!empty($_POST['numero_ordem']) && !empty($_POST['cpf']) && !empty($_POST['nome_cliente']) && !empty($_POST['produto_id']) && !empty($_POST['data_abertura'])) {
        $ordemServico->adicionar($_POST['numero_ordem'], $_POST['cpf'], $_POST['nome_cliente'], $_POST['produto_id'], $_POST['data_abertura']);
    }

    redireciona('/blog/admin/os/listar-os.php');

}

$produto = new Produto($mysql);
$produtos = $produto->exibirTodos();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Criar Ordem de Serviço</title>
    <link rel="stylesheet" type="text/css" href="../../style.css">
</head>

<body>
    <div id="container">
        <h1>Criar Ordem de Serviço</h1>
        <form action="adicionar-os.php" method="post" onsubmit="limparCPF(document.getElementById('cpf'))">
            <p>
                <label for="numero_ordem">Número da Ordem</label>
                <input class="campo-form" type="text" name="numero_ordem" id="numero_ordem" required />
            </p>
            <p>
                <label for="cpf">CPF do Cliente</label>
                <input class="campo-form" type="text" name="cpf" id="cpf" maxlength="14" required placeholder="123.456.789-01" oninput="formatarCPF(this); buscarCliente()" />
            </p>
            <p>
                <label for="nome_cliente">Nome do Cliente</label>
                <input class="campo-form" type="text" name="nome_cliente" id="nome_cliente" required />
            </p>
            <p>
                <label for="data_abertura">Data de Abertura</label>
                <input class="campo-form" type="date" name="data_abertura" id="data_abertura" value="<?php echo date('Y-m-d'); ?>" required />
            </p>
            <p>
                <label for="produto_id">Produto</label>
                <select name="produto_id" id="produto_id" required>
                    <?php foreach ($produtos as $produto) { ?>
                        <option value="<?php echo $produto['id']; ?>"><?php echo $produto['descricao']; ?></option>
                    <?php } ?>
                </select>
            </p>
            <p>
                <button class="botao">Criar Ordem</button>
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

    // Limpar o CPF antes de enviar
    function limparCPF(campo) {
        campo.value = campo.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
    }

    function buscarCliente() {
    var cpf = document.getElementById("cpf").value.replace(/\D/g, ''); // Remover a máscara do CPF

    // Verificar se o CPF tem 11 dígitos antes de fazer a consulta
    if (cpf.length === 11) { 
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "buscar-cliente.php?cpf=" + cpf, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var resposta = JSON.parse(xhr.responseText);
                // console.log(xhr.responseText)
                // Se o cliente for encontrado, preenche o nome automaticamente
                if (resposta.id) {
                // Preenche o nome do cliente no campo
                document.getElementById("nome_cliente").value = resposta.nome;

                // Torna o campo "nome_cliente" somente leitura
                document.getElementById("nome_cliente").readOnly = true;
            } else {
                // Se não encontrar, limpa o campo nome
                document.getElementById("nome_cliente").value = "";

                // Torna o campo "nome_cliente" editável novamente
                document.getElementById("nome_cliente").readOnly = false;
            }
            }
        };
        xhr.send();
    }
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
</script>