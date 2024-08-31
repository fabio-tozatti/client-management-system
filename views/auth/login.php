<!doctype html>
<html lang="pt-br">

<head>
    <title>Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="/kabum/public/css/style.css">
</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main class="bg-dark min-vh-100 d-flex align-items-center">

        <div class="container">
            <div class="row">
                <div class="offset-lg-4 col-lg-4">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger text-center">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    <div class="card">
                        <div class="card-body p-5">
                            <p class="text-center">Insira seus dados para acessar</p>
                            <hr>
                            <!-- Formulário de login -->
                            <form action="/kabum/authenticate" method="POST">
                                <div class="form-group mb-3 mt-4">
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="form-group mb-3">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Senha"
                                        required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Acessar</button>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>