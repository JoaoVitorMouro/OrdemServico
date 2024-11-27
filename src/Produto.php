<?php

class Produto
{
    private $mysql;

    public function __construct(mysqli $mysql)
    {
        $this->mysql = $mysql;
    }

    public function adicionar(string $codigo, string $descricao, string $status, int $tempo_garantia): void
    {
        $insereProduto = $this->mysql->prepare('INSERT INTO produtos (codigo, descricao, status, tempo_garantia) VALUES (?, ?, ?, ?);');
        $insereProduto->bind_param('sssi', $codigo, $descricao, $status, $tempo_garantia);
        $insereProduto->execute();
    }

    public function remover(string $id): void
    {
        $removerProduto = $this->mysql->prepare('DELETE FROM produtos WHERE id = ?');
        $removerProduto->bind_param('s', $id);
        $removerProduto->execute();
    }

    public function exibirTodos(): array
    {
        $resultado = $this->mysql->query('SELECT id, codigo, descricao, status, tempo_garantia FROM produtos');
        $produtos = $resultado->fetch_all(MYSQLI_ASSOC);

        return $produtos;
    }

    public function encontrarPorId(string $id): array
    {
        $selecionaProduto = $this->mysql->prepare('SELECT id, codigo, descricao, status, tempo_garantia FROM produtos WHERE id = ?');
        $selecionaProduto->bind_param('s', $id);
        $selecionaProduto->execute();
        $produto = $selecionaProduto->get_result()->fetch_assoc();

        return $produto;
    }

    public function editar(string $id, string $codigo, string $descricao, string $status, int $tempo_garantia): void
    {
        $editaProduto = $this->mysql->prepare('UPDATE produtos SET codigo = ?, descricao = ?, status = ?, tempo_garantia = ? WHERE id = ?');
        $editaProduto->bind_param('sssis', $codigo, $descricao, $status, $tempo_garantia, $id);
        $editaProduto->execute();
    }
}
