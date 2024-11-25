<?php
    include '../conexao.php';

    $sql_pedidos = mysql_query(
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
                        <?php while ($linha = mysql_fetch_assoc($sql_pedidos)) { ?> 
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
                                        <button class="btn-tabela btn-informacoes" 
                                            onclick="exibirInformacoesPedido('detalhesPedido_<?php echo $linha['id_pedido']; ?>', 'Detalhes do pedido <?php echo $linha['id_pedido']; ?>', '800px')">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </button>
                                        
                                        <button class="btn-tabela btn-produtos" 
                                            onclick="exibirInformacoesPedido('produtosPedido_<?php echo $linha['id_pedido']; ?>', 'Produtos do pedido <?php echo $linha['id_pedido']; ?>', '1300px')">
                                            <i class="fa-solid fa-cubes"></i>
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
                                        
                                        <!-- Produtos do pedido -->
                                        <div id="produtosPedido_<?php echo $linha['id_pedido']; ?>" style="display: none;">
                                            <table id="tabela-produtos_<?php echo $linha['id_pedido']; ?>" class="table table-striped text-center align-middle ">
                                                <!-- Cabeçalho da tabela -->
                                                <thead>
                                                    <tr class="tabela-linha">
                                                        <th width="5%">ID</th>
                                                        <th width="10%">Imagem</th>
                                                        <th>Nome</th>
                                                        <th>Pre. anterior</th>
                                                        <th>Preço atual</th>
                                                        <th>Destaque?</th>
                                                        <th width="10%">Oferta?</th>
                                                        <th>Categoria</th>
                                                        <th width="10%">Ações</th>
                                                    </tr>
                                                </thead>
                                                <!-- Corpo da tabela -->
                                                <tbody>
                                                    <?php 
                                                        $select_produtos_pedidos = 
                                                            "SELECT 
                                                                PRD.id_produto
                                                                , PRD.caminho_imagem
                                                                , PRD.nome
                                                                , PRD.preco_atual
                                                                , PRD.preco_anterior
                                                                , PRD.destaque
                                                                , PRD.oferta_relampago
                                                                , CAT.nome AS categoria
                                                            FROM 
                                                                pedidos_produtos AS PP
                                                                INNER JOIN produtos AS PRD ON PRD.id_produto = PP.id_produto
                                                                INNER JOIN categorias AS CAT ON CAT.id_categoria = PRD.id_categoria
                                                            WHERE
                                                                PP.id_pedido = "
                                                            ;

                                                        $sql_produtos_pedidos = mysql_query($select_produtos_pedidos . $linha['id_pedido']);

                                                        while ($produto = mysql_fetch_assoc($sql_produtos_pedidos)) { ?>     
                                                            <tr class="tabela-linha">
                                                                <td><?php echo $produto['id_produto']; ?></td>
                                                                <td>
                                                                    <img width="100px" src="../<?php echo $produto['caminho_imagem']; ?>" />
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                        // Limita o nome para 30 caracteres e adiciona "..." se for maior.
                                                                        $nome = $produto['nome'];
                                                                        echo 
                                                                            mb_strlen($nome) > 30 ? mb_substr($nome, 0, 30) . "..." : $nome;
                                                                    ?>
                                                                </td>
                                                                <td>R$ <?php echo $produto['preco_anterior']; ?></td>
                                                                <td>R$ <?php echo $produto['preco_atual']; ?></td>
                                                                <td><?php echo $produto['destaque'] ? 'Sim' : 'Não'; ?></td>                                                            
                                                                <td><?php echo $produto['oferta_relampago'] ? 'Sim' : 'Não'; ?></td>
                                                                <td><?php echo $produto['categoria']; ?></td>
                                                                <td>
                                                                    <div class="d-flex align-items-center justify-content-center">
                                                                        <a class="btn-tabela btn-editar" href="../detalhes-produto.php?id_produto=<?php echo $produto['id_produto']; ?>">
                                                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr> 
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <script>
                                                transformarTabela('#tabela-produtos_<?php echo $linha['id_pedido']; ?>');
                                            </script>
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
        function exibirInformacoesPedido(idConteudo, titulo, larguraModal) {
            var htmlConteudo = document.getElementById(idConteudo);

            popupSwal.fire({ 
                title: `<span style="text-shadow: none !important;">${titulo}<span>`
                , html: htmlConteudo.innerHTML
                , showConfirmButton: false
                , showCancelButton: true
                , cancelButtonText: "Fechar"
                , width: larguraModal
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            transformarTabela('#tabela-pedidos');
        });
    </script>
</html>