<?php

class OrdemServico
{
    private $mysql;

    public function __construct(mysqli $mysql)
    {
        $this->mysql = $mysql;
    }

    // Adiciona uma nova ordem de serviço
    public function adicionar(string $numero_ordem, string $cpf, string $nome_cliente, int $produto_id, $data_abertura): void
    {
        $clienteId = $this->verificarCliente($cpf, $nome_cliente);
      
        $insereOrdemServico = $this->mysql->prepare(
            'INSERT INTO ordens_servico (numero_ordem, data_abertura, nome_consumidor, cpf_consumidor, id_produto) VALUES (?, ?, ?, ?, ?);'
        );
      
        $insereOrdemServico->bind_param('sssis', $numero_ordem, $data_abertura, $nome_cliente, $cpf, $produto_id);
        $insereOrdemServico->execute();
    }

    // Verifica se o cliente existe e, se não, cria um novo
    private function verificarCliente(string $cpf, string $nome_cliente)
    {
        $verificaCliente = $this->mysql->prepare(
            'SELECT id FROM clientes WHERE cpf = ?'
        );
        $verificaCliente->bind_param('s', $cpf);
        $verificaCliente->execute();
        $result = $verificaCliente->get_result();

        if ($result->num_rows > 0) {

            // Cliente já existe, retorna o ID
            return $result->fetch_assoc()['id'];
        } else {

            // Cria o cliente automaticamente
            $insereCliente = $this->mysql->prepare(
                'INSERT INTO clientes (nome, cpf) VALUES (?, ?);'
            );

            $insereCliente->bind_param('ss', $nome_cliente, $cpf);

            $insereCliente->execute();

            return $this->mysql->insert_id; // Retorna o ID do cliente criado
        }
    }

    // Exibe todas as ordens de serviço
    public function exibirTodos()
    {
        $resultado = $this->mysql->query(
            'SELECT os.id, os.numero_ordem, os.data_abertura, os.nome_consumidor AS cliente, p.descricao AS produto
             FROM ordens_servico os
             INNER JOIN produtos p ON os.id_produto = p.id'
        );

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    // Encontra a ordem de serviço por ID
    public function encontrarPorId(string $id): array
    {
        $selecionaOrdemServico = $this->mysql->prepare(
            'SELECT os.id, os.numero_ordem, os.data_abertura, os.nome_consumidor AS cliente, os.cpf_consumidor as cpf, p.descricao AS produto
             FROM ordens_servico os
             INNER JOIN produtos p ON os.id_produto = p.id
             WHERE os.id = ?'
        );
        $selecionaOrdemServico->bind_param('s', $id);
        $selecionaOrdemServico->execute();

        return $selecionaOrdemServico->get_result()->fetch_assoc();
    }

    public function editar($id, $numero_ordem, $cpf, $nome_cliente, $produto_id, $data_abertura)
    {
        // Prepara a query SQL para atualizar a ordem de serviço
        $sql = "UPDATE ordens_servico 
                SET numero_ordem = ?, cpf_consumidor = ?, nome_consumidor = ?, id_produto = ?, data_abertura = ? 
                WHERE id = ?";

        // Prepara a declaração SQL
        $stmt = $this->mysql->prepare($sql);

        if ($stmt === false) {
            die("Erro ao preparar a query: " . $this->mysql->error);
        }

        // Liga os parâmetros à query
        $stmt->bind_param("sssssi", $numero_ordem, $cpf, $nome_cliente, $produto_id, $data_abertura, $id);

        // Executa a query
        $stmt->execute();
         
    }
    public function remover(string $id): void
    {
        $removerOs = $this->mysql->prepare('DELETE FROM ordens_servico WHERE id = ?');
        $removerOs->bind_param('s', $id);
        $removerOs->execute();
    }

}

