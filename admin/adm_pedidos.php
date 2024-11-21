<?php
    include '../conexao.php';

    $sql_produtos = mysql_query(
        "SELECT 
            ped.`id_pedido`
            , ped.`dt_pedido`
            , ped.`subtotal`
            , ped.`frete`
            , ped.`total`
            , fpag.`nome` AS forma_pagamento
            , cpag.`numero_cartao`
            , pag.`parcelas`
            , CONCAT(end.`logradouro`, ', ', end.`numero`, ' - ', end.`complemento`, ', ', end.`bairro`, ' - ', end.`cidade`, ', ', end.`uf`) AS endereco
            , loj.`endereco_completo` AS endereco_loja
            , stt.`nome` AS status_pedido
            , ped.`dt_entrega`
            , usr.`nome_completo`
            , usr.`email`
            , usr.`telefone_celular`
        FROM
            `pedidos` AS ped
            INNER JOIN `pagamentos` AS pag ON pag.`id_pagamento` = ped.`id_pagamento`
            INNER JOIN `formas_pagamento` AS fpag ON fpag.`id_forma_pagamento` = pag.`id_forma_pagamento`
            LEFT JOIN `cartoes_pagamento` AS cpag ON cpag.`id_cartao_pagamento` = pag.`id_cartao_pagamento`
            LEFT JOIN `enderecos` AS end ON end.`id_endereco` = ped.`id_endereco`
            LEFT JOIN `lojas` AS loj ON loj.`id_loja` = ped.`id_loja`
            INNER JOIN `status` AS stt ON stt.`id_status` = ped.`id_status`
            INNER JOIN `usuarios` AS usr ON usr.`id_usuario` = ped.`id_usuario`
        ORDER BY 
            ped.`id_pedido` DESC;
    ");
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
                            <th>Status</th>
                            <th>Dt. Entrega</th>
                            <th>Cliente</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <!-- Corpo da tabela -->
                    <tbody>
                        <?php while ($linha = mysql_fetch_assoc($sql_produtos)) { ?> 
                            <tr class="tabela-linha">
                                <td><?php echo $linha['id_pedido']; ?></td>
                                <td><?php echo date('d/m/Y H:i:s', strtotime($linha['dt_pedido'])); ?></td>
                                <td>R$ <?php echo $linha['subtotal']; ?></td>
                                <td>R$ <?php echo $linha['frete']; ?></td>
                                <td>R$ <?php echo $linha['total']; ?></td>
                                <td><?php echo $linha['status_pedido']; ?></td>
                                <td><?php echo $linha['dt_entrega'] !== null ? date('d/m/Y H:i:s', strtotime($linha['dt_entrega'])) : "Não definida."; ?></td>
                                <td><?php echo $linha['nome_completo']; ?></td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-around">
                                        <a class="btn-tabela btn-editar" href="editar-pedido.php?editar=<?php echo $linha['id_pedido']; ?>">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <button class="btn-tabela btn-informacoes" 
                                            onclick="exibirDetalhesPedido('detalhesPedido_<?php echo $linha['id_pedido']; ?>', <?php echo $linha['id_pedido']; ?>)">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </button>
                                        
                                        <!-- Conteúdo que será renderizado na modal de detalhes do pedido -->
                                        <div id="detalhesPedido_<?php echo $linha['id_pedido']; ?>" style="display: none;">
                                            <div class="container-detalhes_ped">
                                                <div class="detalhes_ped-coluna">
                                                    <!-- Enviar para/Retirar em -->
                                                    <?php if ($linha['endereco'] != null) { ?>
                                                        <div class="mb-4">
                                                            <h4 class="detalhes_ped-titulo_info">
                                                                <i class="fa-solid fa-truck-fast"></i> Enviar para
                                                            </h4>
                                                            <p><?php echo $linha['endereco']; ?></p>            
                                                        </div> 
                                                    <?php } else { ?>
                                                        <div class="mb-4">
                                                            <h4 class="detalhes_ped-titulo_info">
                                                                <i class="fa-solid fa-box"></i> Retirar em 
                                                            </h4>
                                                            <p><?php echo $linha['endereco_loja']; ?></p>            
                                                        </div>
                                                    <?php } ?>

                                                    <!-- E-mail -->
                                                    <div class="mb-4">
                                                        <h4 class="detalhes_ped-titulo_info">
                                                            <i class="fa-solid fa-at"></i> E-mail do Cliente
                                                        </h4>
                                                        <a href="mailto:<?php echo $linha['email']; ?>"><?php echo $linha['email']; ?></a>            
                                                    </div>
                                                    
                                                    <!-- Telefone -->                                                    
                                                    <div class="mb-4">
                                                        <h4 class="detalhes_ped-titulo_info">
                                                            <i class="fa-solid fa-phone"></i> Telefone para Contato
                                                        </h4>
                                                        <p><?php echo $linha['telefone_celular']; ?></p>            
                                                    </div>
                                                </div>

                                                <div class="detalhes_ped-coluna">
                                                    <!-- Forma de Pagamento -->
                                                    <div class="mb-4">
                                                        <h4 class="detalhes_ped-titulo_info">
                                                            <i class="fa-solid fa-file-invoice-dollar"></i> Forma de Pagamento
                                                        </h4>
                                                        <p><?php echo $linha['forma_pagamento']; ?></p>            
                                                    </div>

                                                    <!-- Cartão de Crédito/Débito -->
                                                    <?php if ($linha['numero_cartao'] != null) { ?>
                                                        <div class="mb-4">
                                                            <h4 class="detalhes_ped-titulo_info">
                                                                <i class="fa-solid fa-credit-card"></i> Número do Cartão
                                                            </h4>
                                                            <p>Terminado em <?php echo $linha['numero_cartao']; ?></p>
                                                        </div>

                                                        <div class="mb-4">
                                                            <h4 class="detalhes_ped-titulo_info">
                                                                <i class="fa-solid fa-layer-group"></i> Parcelado em
                                                            </h4>
                                                            <p><?php echo $linha['parcelas']; ?>x</p>
                                                        </div>  
                                                    <?php } ?>                                                           
                                                </div>                                               
                                            </div>
                                        </div>

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
        function exibirDetalhesPedido(idConteudo, numero_ped) {
            var htmlConteudo = document.getElementById(idConteudo);

            popupSwal.fire({ 
                title: `<span style="text-shadow: none !important;">Detalhes do Pedido ${numero_ped}<span>`
                , html: htmlConteudo.innerHTML
                , showConfirmButton: false
                , showCancelButton: true
                , cancelButtonText: "Fechar"
                , width: '800px'
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            transformarTabela('#tabela-pedidos');
        });
    </script>
</html>