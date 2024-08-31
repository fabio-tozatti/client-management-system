<?php

require_once 'models/Client.php';
require_once 'models/Address.php';

class ClientController extends BaseController
{
    public function __construct()
    {
        $this->checkAuthentication();
    }

    protected function checkAuthentication()
    {
        if (!isset($_SESSION['user_id'])) {
            // Redireciona para a página de login se não estiver logado
            header('Location: /kabum/login');
            exit;
        }
    }

    public function list()
    {
        $clients = $this->getClients();
        $this->view('client/list', ['clients' => $clients]);
    }

    // retorna formulário para preenchimento
    public function create()
    {
        $this->view('client/create');
    }

    // função para salvar dados do formulário
    public function store()
    {
        $data = $this->getClientDataFromRequest();

        $clientModel = new Client();

        // Verificando se o CPF já existe para novos registros
        if ($this->checkCpfExists($data['cpf'])) {
            $this->view('client/create', ['error' => 'CPF já cadastrado.']);
            return;
        }

        $this->saveClient($clientModel, $data);
        $this->redirect('/kabum/clients');
    }

    // retorna dados para o formulário para edição
    public function edit($id)
    {
        $client = $this->getClientById($id);

        // busca endereços relacionados ao cliente
        $addressModel = new Address();
        $addresses = $addressModel->getAddressesByClientId($id);

        $this->view('client/create', [
            'client'    => $client,
            'addresses' => $addresses
        ]);
    }

    // prepara a atualização dos dados do usuário
    public function update($id)
    {
        $data = $this->getClientDataFromRequest();

        $clientModel = new Client();

         // Verificando se o CPF já existe para novos registros
         if ($this->checkCpfExists($data['cpf'], $id)) {
            $this->view(
                'client/edit', [
                    'error'  => 'CPF já cadastrado.', 
                    'client' => $data
                ]
            );
            return;
        }

        $this->saveClient($clientModel, $data, $id);
        $this->redirect('/kabum/clients');
    }

    //verifica se existe o cpf já cadastrado
    private function checkCpfExists($cpf, $excludeId = null)
    {
        $clientModel = new Client();

        // Se $excludeId for fornecido, a verificação deve ignorar esse ID
        if ($clientModel->cpfExists($cpf, $excludeId)) {
            return true;
        }

        return false;
    }

    // captura dados enviados pelo form
    private function getClientDataFromRequest()
    {
        return [
            'name'  => $_POST['name']  ?? '',
            'dob'   => $_POST['dob']   ?? '',
            'cpf'   => $_POST['cpf']   ?? '',
            'rg'    => $_POST['rg']    ?? '',
            'phone' => $_POST['phone'] ?? ''
        ];
    }

    // salva os dados
    private function saveClient($clientModel, $data, $id = null)
    {
        if ($id) {
            // Atualiza o cliente existente
            $clientModel->updateClient($id, $data);
            $_SESSION['success_message'] = 'Cliente atualizado com sucesso!';
        } else {
            // Cria um novo cliente
            $id = $clientModel->createClient($data);
            $_SESSION['success_message'] = 'Cliente criado com sucesso!';
        }
        $this->redirect('/kabum/clients/edit/'.$id);
    }

    // remove cliente
    public function delete($id)
    {
        $id = intval($id);
        $clientModel = new Client();
        $clientModel->deleteClient($id);
        echo json_encode(['success' => true, 'message' => 'Cliente excluído com sucesso.']);
    }

    // lista todos clientes
    private function getClients()
    {
        $clientModel = new Client();
        return $clientModel->getAllClients();
    }

    // retorna cliente por id
    private function getClientById($id)
    {
        $clientModel = new Client();
        return $clientModel->getClientById($id);
    }
}
