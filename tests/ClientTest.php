<?php

use PHPUnit\Framework\TestCase;

require_once 'models/Client.php';
require_once 'config/config.php';

class ClientTest extends TestCase
{
    private $pdo;
    private $client;

    protected function setUp(): void
    {
        // Crie uma conexão em memória para testes (usando SQLite)
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Crie a tabela de clientes no banco em memória
        $this->pdo->exec('
            CREATE TABLE clients (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT,
                dob TEXT,
                cpf TEXT,
                rg TEXT,
                phone TEXT
            )
        ');

        // Instancie a classe Client com a conexão PDO
        $this->client = new Client($this->pdo);
    }

    public function testCreateClient()
    {
        // Dados para inserir um cliente
        $data = [
            'name'  => 'John Doe',
            'dob'   => '1985-10-15',
            'cpf'   => '123.456.789-00',
            'rg'    => '12.345.678-9',
            'phone' => '(12) 34567-8900'
        ];

        // Crie o cliente
        $id = $this->client->createClient($data);

        // Verifique se o cliente foi criado com sucesso
        $this->assertIsInt((int)$id);
        $this->assertGreaterThan(0, (int)$id);

        // Verifique se o cliente pode ser recuperado pelo ID
        $client = $this->client->getClientById($id);
        $this->assertNotNull($client); // Certifique-se de que o cliente foi recuperado
        $this->assertEquals('John Doe', $client['name']);
        $this->assertEquals('123.456.789-00', $client['cpf']);
    }

    protected function tearDown(): void
    {
        // Feche a conexão PDO
        $this->pdo = null;
    }
}
