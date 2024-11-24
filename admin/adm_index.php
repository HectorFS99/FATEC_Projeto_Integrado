<!DOCTYPE html>
<html lang="pt-br">
    <head>        
        <?php include '/componentes/adm_head.php'; ?>
        <link rel="stylesheet" href="recursos/css/adm_index.css" />
        <title>Painel Administrativo</title>
    </head>
    <body>
	    <?php include '/componentes/adm_header.php'; ?>
        <main class="conteudo-principal">
            <div class="container-opcoes">
                <h3>Gerenciar</h3>
                <div class="opcoes-gerenciamento">
                    <a href="adm_produtos.php" class="opc-geren">
                        <i class="fa-solid fa-cube"></i>
                        <span>Produtos</span>
                    </a>
                    <a href="adm_categorias.php" class="opc-geren">
                        <i class="fa-solid fa-layer-group"></i>
                        <span>Categorias</span>
                    </a>
                    <a href="adm_pedidos.php" class="opc-geren">
                        <i class="fa-solid fa-boxes-stacked"></i>
                        <span>Pedidos</span>
                    </a>
                    <a href="adm_usuarios.php" class="opc-geren">
                        <i class="fa-solid fa-users"></i>
                        <span>Usuarios</span>
                    </a>
                </div>                
            </div>
        </main>
    </body>
</html>