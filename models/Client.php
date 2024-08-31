<?php

require_once 'core/Database.php';

class Client
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = loadConfig(); 
    }

    // retorna todos os clientes
    public function getAllClients()
    {
        $stmt = $this->pdo->query('SELECT * FROM clients');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // retorna o cliente pelo id
    public function getClientById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM clients WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // cria um novo cliente
    public function createClient($data)
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO clients (name, dob, cpf, rg, phone)
            VALUES (:name, :dob, :cpf, :rg, :phone)
        ');
        $stmt->execute($data);

        // Retorna o ID do cliente criado
        return $this->pdo->lastInsertId();
    }

    // atualiza o cliente
    public function updateClient($id, $data)
    {
        $data['id'] = $id;
        $stmt = $this->pdo->prepare('
            UPDATE clients
            SET name = :name, dob = :dob, cpf = :cpf, rg = :rg, phone = :phone
            WHERE id = :id
        ');
        $stmt->execute($data);
    }

    // remove o cliente
    public function deleteClient($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM clients WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    // verifica se já existe o cpf cadastrado
    public function cpfExists($cpf, $excludeId = null)
    {
        $sql = 'SELECT COUNT(*) FROM clients WHERE cpf = :cpf';
        $params = [':cpf' => $cpf];

        if ($excludeId !== null) {
            $sql .= " AND id != :id";
            $params[':id'] = $excludeId;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
}
