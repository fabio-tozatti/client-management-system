<?php

require_once 'core/Database.php';

function loadConfig()
{
    $host = getenv('DB_HOST')     ?: 'localhost';
    $db   = getenv('DB_DATABASE') ?: 'db_clients_management';
    $user = getenv('DB_USERNAME') ?: 'root';
    $pass = getenv('DB_PASSWORD') ?: '';

    $database = new Database($host, $db, $user, $pass);
    $pdo = $database->getConnection();

    // Criar usuário padrão
    ensureDefaultUser($pdo);

    return $pdo;
}

function ensureDefaultUser($pdo)
{
    // Dados do usuário padrão
    $defaultEmail    = 'admin@admin.com';
    $defaultPassword = 'admin123';

    // Verificar se o usuário já existe
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
    $stmt->execute(['email' => $defaultEmail]);
    $userExists = $stmt->fetchColumn();

    if (!$userExists) {
        // Criptografar a senha
        $hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);

        // Inserir o usuário padrão
        $stmt = $pdo->prepare('INSERT INTO users (email, password) VALUES (:email, :password)');
        $stmt->execute([
            'email'    => $defaultEmail,
            'password' => $hashedPassword
        ]);

        // "Usuário padrão criado com sucesso!"
    } 
}
