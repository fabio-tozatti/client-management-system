<?php include __DIR__ . '/../partials/head.php'; ?>

<main class="py-5">
    <div class="container">
        <div class="d-flex justify-content-start">
            <a class="btn btn-sm btn-primary" href="/kabum/clients">Voltar</a>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                Cadastro de Cliente
            </div>
            <div class="card-body">

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $_SESSION['success_message']; ?>
                    </div>
                    <?php unset($_SESSION['success_message']); // Limpa a mensagem após exibi-la ?>
                <?php endif; ?>

                <?php $actionUrl = isset($client['id']) ? "/kabum/clients/update/{$client['id']}" : "/kabum/clients/store"; ?>

                <form action="<?php echo $actionUrl ?>" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="<?php echo isset($client['name']) ? htmlspecialchars($client['name']) : ''; ?>"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="dob" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" id="dob" name="dob"
                                value="<?php echo isset($client['dob']) ? htmlspecialchars($client['dob']) : ''; ?>"
                                required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpf" name="cpf"
                                value="<?php echo isset($client['cpf']) ? htmlspecialchars($client['cpf']) : ''; ?>"
                                required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="rg" class="form-label">RG</label>
                            <input type="text" class="form-control" id="rg" name="rg"
                                value="<?php echo isset($client['rg']) ? htmlspecialchars($client['rg']) : ''; ?>"
                                required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="phone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control" id="phone" name="phone"
                                value="<?php echo isset($client['phone']) ? htmlspecialchars($client['phone']) : ''; ?>"
                                required>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-sm btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>

        <?php if (isset($client['id'])): ?>
            <div class="card mt-3">
                <div class="card-header">Endereços</div>
                <div class="card-body">
                    <?php if (!empty($addresses)): ?>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <?php foreach ($addresses as $address): ?>
                                    <tr id="address-<?php echo $address['id']; ?>">
                                        <td><?php echo htmlspecialchars($address['street']); ?></td>
                                        <td><?php echo htmlspecialchars($address['neighborhood']); ?></td>
                                        <td><?php echo htmlspecialchars($address['number']); ?></td>
                                        <td><?php echo htmlspecialchars($address['complement']); ?></td>
                                        <td><?php echo htmlspecialchars($address['city']); ?></td>
                                        <td><?php echo htmlspecialchars($address['state']); ?></td>
                                        <td><?php echo htmlspecialchars($address['postal_code']); ?></td>
                                        <td class="text-end">
                                            <a href="#" class="btn btn-sm btn-danger delete-address" data-id="<?php echo $address['id']; ?>">Remover</a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalId">Adicionar novo endereço</button>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>

    <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Endereço
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/kabum/address/store" method="POST">
                        <input type="hidden" name="client_id" id="client_id" value="<?php echo $client['id']; ?>">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="postal_code" class="form-label">Código Postal</label>
                                <input type="text" class="form-control" id="postal_code" name="postal_code"
                                    required>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label for="street" class="form-label">Rua</label>
                                <input type="text" class="form-control" id="street" name="street" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="number" class="form-label">Número</label>
                                <input type="text" class="form-control" id="number" name="number">
                            </div>
                            <div class="col-md-8 mb-3">
                                <label for="neighborhood" class="form-label">Bairro</label>
                                <input type="text" class="form-control" id="neighborhood" name="neighborhood"
                                    required>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">Cidade</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="state" class="form-label">Estado</label>
                                <input type="text" class="form-control" id="state" name="state" maxlength="2"
                                    required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="complement" class="form-label">Complemento</label>
                                <input type="text" class="form-control" id="complement" name="complement">
                            </div>

                        </div>
                        <div class="modal-footer mt-4 px-0 pb-0">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                                Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>
   
<?php include __DIR__ . '/../partials/footer.php'; ?>
