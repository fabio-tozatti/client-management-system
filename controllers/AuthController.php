<?php

require_once 'BaseController.php';
require_once 'models/User.php';

class AuthController extends BaseController
{
    public function login()
    {
        $this->view('auth/login');
    }

    public function authenticate()
    {
        // Verifica se o método de requisição é POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Coleta os dados do formulário
            $email    = trim($_POST['email']);
            $password = trim($_POST['password']);

            // Cria uma instância do modelo User
            $userModel = new User();

            // Verifica se o email e a senha estão corretos
            $user = $userModel->getUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                // Autenticação bem-sucedida
                // Inicia a sessão e armazena informações do usuário
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                
                // Redireciona para o dashboard ou página inicial
                $this->redirect('/kabum/clients');
            } else {
                // Credenciais inválidas
                $this->view('auth/login', ['error' => 'Email ou senha incorretos.']);
            }
        } else {
            // Se não for POST, redireciona para a página de login
            $this->redirect('/login');
        }
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('/kabum/login');
    }
}