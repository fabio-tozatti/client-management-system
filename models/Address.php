<?php

require_once 'core/Database.php';

class Address
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = loadConfig(); 
    }

    // Cria um novo endereço
    public function createAddress($data)
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO addresses (client_id, street, number, complement, neighborhood, city, state, postal_code)
            VALUES (:client_id, :street, :number, :complement, :neighborhood, :city, :state, :postal_code)
        ');
        $stmt->execute($data);
    }

    // Atualiza um endereço existente
    public function updateAddress($id, $data)
    {
        $stmt = $this->pdo->prepare('
            UPDATE addresses
            SET client_id = :client_id,
                street = :street,
                number = :number,
                complement = :complement,
                neighborhood = :neighborhood,
                city = :city,
                state = :state,
                postal_code = :postal_code,
                country = :country
            WHERE id = :id
        ');
        $data['id'] = $id;
        $stmt->execute($data);
    }

    // Obtém todos os endereços de um cliente
    public function getAddressesByClientId($clientId)
    {
        $stmt = $this->pdo->prepare('
            SELECT * FROM addresses WHERE client_id = :client_id
        ');
        $stmt->execute(['client_id' => $clientId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Deleta um endereço pelo ID
    public function deleteAddress($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM addresses WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
