<?php

require '../../config.php';
include '../../src/Cliente.php';

$cpf = isset($_GET['cpf']) ? $_GET['cpf'] : '';

// Verifica se o CPF foi enviado
if ($cpf) {
    // var_dump($cpf); exit;
    $cliente = new Cliente($mysql);
    // var_dump("asdaaaa");  exit;
    
    // Consulta se o cliente com esse CPF já existe
    $verificaCliente = $cliente->encontrarPorCPF($cpf);
    if ($verificaCliente) {
        // Se o cliente existir, converte para JSON e retorna
        echo json_encode($verificaCliente);
    } else {
        // Se não encontrar, retorna um array vazio
        echo json_encode([]);
    }
}
