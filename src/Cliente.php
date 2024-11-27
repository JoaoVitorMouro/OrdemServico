<?php

class Cliente
{

    private $mysql;

    public function __construct(mysqli $mysql)
    {
        $this->mysql = $mysql;
    }

    public function adicionar(string $nome, string $cpf, string $endereco): void
    {
        $insereCliente = $this->mysql->prepare('INSERT INTO clientes (nome, cpf, endereco) VALUES(?,?,?);');
        $insereCliente->bind_param('sss', $nome, $cpf, $endereco);
        $insereCliente->execute();
    }

    public function remover(string $id): void
    {
        $removerCliente = $this->mysql->prepare('DELETE FROM clientes WHERE id = ?');
        $removerCliente->bind_param('s', $id);
        $removerCliente->execute();
    }

    public function exibirTodos(): array
    {

        $resultado = $this->mysql->query('SELECT id, nome, cpf, endereco FROM clientes');
        $clientes = $resultado->fetch_all(MYSQLI_ASSOC);

        return $clientes;
    }

    public function encontrarPorId(string $id): array
    {
        $selecionaCliente = $this->mysql->prepare("SELECT id, cpf, endereco, nome FROM clientes WHERE id = ?");
        $selecionaCliente->bind_param('s', $id);
        $selecionaCliente->execute();
        $cliente = $selecionaCliente->get_result()->fetch_assoc();
        return $cliente;
    }
    public function encontrarPorCPF(string $cpf): array
    {
        $selecionaCliente = $this->mysql->prepare("SELECT id, cpf, endereco, nome FROM clientes WHERE cpf = ?");
        $selecionaCliente->bind_param('s', $cpf);
        $selecionaCliente->execute();
        $cliente = $selecionaCliente->get_result()->fetch_assoc();
        return $cliente;
    }

    public function editar(string $id, string $nome, string $endereco, string $cpf): void
    {
        $editaCliente = $this->mysql->prepare('UPDATE clientes SET cpf = ?, nome = ?, endereco = ? WHERE id = ?');
        $editaCliente->bind_param('ssss', $cpf, $nome, $endereco, $id);
        $editaCliente->execute();
    }
}
