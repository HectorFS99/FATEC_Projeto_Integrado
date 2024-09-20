<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Painel Administrativo</title>
        
        <!-- ***** ESTILIZAÇÃO ***** -->
        <link rel="stylesheet" href="admin/recursos/css/reset.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" rel="stylesheet" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=SUSE:wght@100..800&display=swap" rel="stylesheet">
        
        <link rel="stylesheet" href="recursos/css/adm_index.css" />
        <!-- ***** ESTILIZAÇÃO ***** -->

        <!-- ***** PROGRAMAÇÃO ***** -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
        <script src="recursos/javascript/adm_principal.js"></script>
        <!-- ***** PROGRAMAÇÃO ***** -->
    </head>
    <body>
        <div>
            <h1>Future Mob - Administrativo</h1>
            <span id="data-atual">18 de setembro de 2024 - 01:08</span>
        </div>
        <main>
            <h3>Gerenciar</h3>
            <div class="opcoes-gerenciamento">
                <a href="#" class="opc-geren">
                    <i class="fa-solid fa-cube"></i>
                    <span>Produtos</span>
                    <button onclick="window.location.href='admin-produtos.php'" class="btn-tela-produtos">Ver Produtos</button>
                </a>
                <a href="#" class="opc-geren">
                    <i class="fa-solid fa-layer-group"></i>
                    <span>Categorias</span>
                </a>
                <a href="#" class="opc-geren">
                    <i class="fa-solid fa-boxes-stacked"></i>
                    <span>Pedidos</span>
                </a>
                <a href="#" class="opc-geren">
                    <i class="fa-solid fa-users"></i>
                    <span>Usuarios</span>
                </a>
            </div>
        </main>
    </body>
</html>