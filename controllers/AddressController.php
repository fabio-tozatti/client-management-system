<?php

require_once 'models/Address.php';

class AddressController extends BaseController
{
    private $addressModel;

    public function __construct()
    {
       
    }

    // Exibe o formulário para criar um novo endereço
    public function create()
    {
        // Exibir a view do formulário de criação
        $this->view('address/create');
    }

    // Processa a criação de um novo endereço
    public function store()
    {
        $addressModel = new Address();

         // Coleta os dados do formulário
        $data = [
            'client_id'      => $_POST['client_id'],
            'street'         => $_POST['street'],
            'number'         => $_POST['number'],
            'complement'     => $_POST['complement'],
            'neighborhood'   => $_POST['neighborhood'],
            'city'           => $_POST['city'],
            'state'          => $_POST['state'],
            'postal_code'    => $_POST['postal_code']
        ];

        // Cria o novo endereço e obtém o ID
        $addressModel->createAddress($data);

        // Redireciona para a página de edição ou exibe uma mensagem de sucesso
        $_SESSION['success_message'] = 'Endereço salvo com sucesso!';
        $this->redirect('/kabum/clients/edit/' . $data['client_id']);
    }

    // Exibe o formulário para editar um endereço existente
    public function edit($id)
    {
        $address = $this->addressModel->getAddressById($id);

        if (!$address) {
            // Endereço não encontrado, redireciona ou exibe mensagem de erro
            $this->redirect('/kabum/addresses');
        }

        // Exibir a view do formulário de edição com dados do endereço
        $this->view('address/edit', ['address' => $address]);
    }

    // Deleta um endereço
    public function delete($id)
    {
        $addressModel = new Address();
        $addressModel->deleteAddress($id);
        echo json_encode(['success' => true, 'message' => 'Endereço excluído com sucesso.']);
    }
}
