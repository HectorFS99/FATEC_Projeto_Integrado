<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de cadastro</title>
    <!-- ***** ESTILIZAÇÃO ***** -->
    <link href="recursos/css/reset.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link href="recursos/css/geral.css" rel="stylesheet">
    <link href="recursos/css/header.css" rel="stylesheet">
    <link href="recursos/css/confirmacao-cadastro.css" rel="stylesheet">
    <!-- ***** ESTILIZAÇÃO ***** -->
    <!-- ***** PROGRAMAÇÃO ***** -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="recursos/javascript/principal.js"></script>
    <!-- ***** PROGRAMAÇÃO ***** -->
</head>

<body>
    <header>
        <nav class="navbar">
            <h2 style="font-family: 'Josefin Sans', sans-serif; color: #ff4400; margin-bottom: 0;">FUTUREMOB</h2>
        </nav>
    </header>
    <main class="container vh-100 mt-0 flex-column">
        <span id="icone-confirmacao" class="fa-regular fa-circle-check" style="display: none;"></span>
        <span id="icone-carregamento" class="loader"></span>
        <h1 id="titulo" class="titulo-confirmacao mt-4">Quase lá!</h1>
        <p id="info" class="info-confirmacao">Enviamos um link de confirmação para o e-mail informado. Por favor, acesse-o para confirmar o seu cadastro.</p>
        <a href="#" id="btn" class="btn btn-lg btn-gradiente">Enviar novamente</a>
    </main>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(mudarConteudo, 10000);
    });

    function mudarConteudo() {
        var icone_carregamento = document.getElementById('icone-carregamento');
        icone_carregamento.style.display = 'none';
        var icone_confirmacao = document.getElementById('icone-confirmacao');
        icone_confirmacao.style.display = 'block';
        var titulo = document.getElementById('titulo');
        titulo.innerHTML = 'Confirmado!'
        var info = document.getElementById('info');
        info.innerHTML = 'Seja bem-vindo(a)! Explore o nosso catálogo e aproveite as nossas ofertas!'
        var btn = document.getElementById('btn');
        btn.innerHTML = 'Continuar'
        btn.setAttribute('href', 'pagina-inicial.php');
    }
</script>

</html>