<?php
    include '../conexao.php';

    $sql_produtos = mysql_query(
        "SELECT 
            `id_pedido`
            , `dt_pedido`
            , `subtotal`
            , `frete`
            , `total`
            , `id_pagamento`
            , `id_endereco`
            , `id_status`
            , `dt_entrega`
            , `id_usuario`
        FROM
            `pedidos`");
?>
<html lang="pt-br">
    <head>
        <?php include '/componentes/adm_head.php'; ?>
        <title>Pedidos</title>
    </head>
    <body>
        <?php include '/componentes/adm_header.php'; ?>
        <main class="conteudo-principal">
            <div class="titulo-opcoes">
                <h3 class="titulo">
                    <a href="adm_index.php" class="btn-voltar"><i class="fa-solid fa-arrow-left"></i></a>
                    Pedidos
                </h3>
            </div>
            <div class="table-responsive">
                <table id="tabela-pedidos" class="table table-striped">
                    <!-- Cabeçalho da tabela -->
                    <thead>
                        <tr class="tabela-linha">
                            <th>ID</th>
                            <th>Dt. Pedido</th>
                            <th>Subtotal</th>
                            <th>Frete</th>
                            <th>Total</th>
                            <th>Pagam. ID</th>
                            <th>Ender. ID</th>
                            <th>Status ID</th>
                            <th>Dt. Entrega</th>
                            <th>Usuário ID</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <!-- Corpo da tabela -->
                    <tbody>
                        <?php while ($linha = mysql_fetch_assoc($sql_produtos)) { ?> 
                            <tr class="tabela-linha">
                                <td><?php echo $linha['id_pedido']; ?></td>
                                <td><?php echo $linha['dt_pedido']; ?></td>
                                <td>R$ <?php echo $linha['subtotal']; ?></td>
                                <td>R$ <?php echo $linha['frete']; ?></td>
                                <td>R$ <?php echo $linha['total']; ?></td>
                                <td><?php echo $linha['id_pagamento']; ?></td>
                                <td><?php echo $linha['id_endereco']; ?></td>
                                <td><?php echo $linha['id_status']; ?></td>
                                <td><?php echo $linha['dt_entrega']; ?></td>
                                <td><?php echo $linha['id_usuario']; ?></td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a class="btn-tabela btn-editar" href="editar-pedido.php?editar=<?php echo $linha['id_pedido']; ?>">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr> 
                        <?php } ?>
                    </tbody>
                </table>               
            </div>
        </main>
    </body>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            transformarTabela('#tabela-pedidos');
        });
    </script>
</html>