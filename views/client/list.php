<?php include __DIR__ . '/../partials/head.php'; ?>

<main class="py-5">
    <div class="container">
        <div class="d-flex justify-content-end">
            <a class="btn btn-sm btn-primary" href="/kabum/clients/create">Novo cliente</a>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <?php if (empty($clients)): ?>
                    <div class="alert alert-info mb-0" role="alert">
                        Nenhum cliente encontrado.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Telefone</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($clients as $client): ?>
                                    <tr id="client-<?php echo $client['id']; ?>">
                                        <td><?php echo $client['id']; ?></td>
                                        <td><?php echo $client['name']; ?></td>
                                        <td><?php echo $client['phone']; ?></td>
                                        <td class="text-end">
                                            <a class="btn btn-sm btn-info" href="/kabum/clients/edit/<?php echo $client['id']; ?>">Editar</a>
                                            <a class="btn btn-sm btn-danger delete-client" data-id="<?php echo $client['id']; ?>" href="#">Deletar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

 <?php include __DIR__ . '/../partials/footer.php'; ?>
