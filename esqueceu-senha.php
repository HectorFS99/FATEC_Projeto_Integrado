<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesse a sua conta</title>
    <!-- ***** ESTILIZAÇÃO ***** -->
    <link href="recursos/css/reset.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link href="recursos/css/geral.css" rel="stylesheet">
    <link href="recursos/css/header.css" rel="stylesheet">
    <link href="recursos/css/esqueceu-senha.css" rel="stylesheet">
    <!-- ***** ESTILIZAÇÃO ***** -->
    <!-- ***** PROGRAMAÇÃO ***** -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script src="recursos/javascript/principal.js"></script>
    <script src="recursos/javascript/esqueceu-senha.js"></script>
    <!-- ***** PROGRAMAÇÃO ***** -->
</head>

<body>
    <header>
        <nav class="custom-navbar">
            <a href="pagina-inicial.php"><i class="fa-solid fa-arrow-left"></i></a>
            <span style="font-weight: 400;">FUTUREMOB</span>
        </nav>
    </header>
    <main class="container">
        <form class="formulario" onsubmit="enviarCodigoRecuperacao(event);">
            <h4 class="mb-4">Iremos te enviar um link de segurança no e-mail informado.</h4>
            <div class="form-floating">
                <input id="txtEmailLogin" type="email" class="form-control" placeholder="Email" required>
                <label for="txtEmailLogin">Email</label>
            </div>
            <div class="btn-group-vertical w-100 mt-2">
                <button class="btn btn-lg btn-laranja" type="submit">Confirmar</button>
            </div>
        </form>
    </main>
</body>

</html>