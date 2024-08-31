<?php

class User
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = loadConfig(); 
    }

    // valida o login
    public function authenticate($email, $password)
    {
        $stmt = $this->pdo->prepare('
            SELECT id, email, password
            FROM users
            WHERE email = :email
        ');

        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    public function getUserByEmail($email)
    {
        $stmt = $this->pdo->prepare('SELECT id, email, password FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
