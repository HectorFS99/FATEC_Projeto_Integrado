<?php
    session_start();

   	header('Content-Type: text/html; charset=utf-8');
    include '../../conexao.php';

    $id_usuario = $_SESSION['id_usuario'];
    
    $subtotal = $_POST["txtValorSubTotalPedido"];
    $frete = $_POST["txtValorFrete"];
    $descontos = $_POST["txtValorDesconto"];
    $total = $_POST["txtValorTotalPedido"];

    /* * * * * * OPÇÃO DE ENTREGA (ENTREGA OU RETIRADA NA LOJA). * * * * * */ 
    $id_loja = "null";
    $id_endereco = "null";  

    $opcaoEntrega = $_POST["txtOpcaoEntrega"];
    if (strpos($opcaoEntrega, 'loja') !== false) {
        $id_loja = str_replace("loja_", "", $opcaoEntrega);        
    } else {
        $id_endereco = str_replace("endereco_", "", $opcaoEntrega);
    }

    /* * * * * * INSERE O PEDIDO NA TABELA. * * * * * */  
    $sql = mysql_query(
        "INSERT INTO `pedidos`(
            `subtotal`
            , `frete`
            , `descontos`
            , `total`
            , `id_pagamento`
            , `id_endereco`
            , `id_loja`
            , `id_status`
            , `dt_entrega`
            , `id_usuario`
        ) VALUES (
            $subtotal 
            , $frete
            , $descontos
            , $total
            , null
            , $id_endereco
            , $id_loja
            , 1
            , null
            , $id_usuario
        )"
    );

    /* * * * * * APÓS A INSERÇÃO DO PEDIDO... * * * * * */  
    if ($sql == 1) {
        $sql_id_pedido = mysql_query("SELECT `id_pedido` FROM `pedidos` WHERE `id_usuario` = $id_usuario ORDER BY `id_pedido` DESC LIMIT 1");
        $id_pedido_result = mysql_fetch_assoc($sql_id_pedido);
        $id_pedido = $id_pedido_result['id_pedido'];

        /* * * * * * FORMA DE PAGAMENTO. * * * * * */
        $id_forma_pagamento = "null";
        $id_cartao_pagamento = "null";
        $parcelas = "null";

        $formaPagamento = $_POST["txtCreditoDebito"];
        if ($formaPagamento === 'credito') {
            $id_forma_pagamento = 2;
        } else if ($formaPagamento === 'debito') {
            $id_forma_pagamento = 3;
        } else {
            $formaPagamento = $_POST["txtFormaPagamento"];

            if ($formaPagamento === 'pix') {
                $id_forma_pagamento = 1;
            }
        }        

        /* * * * * * CARTÃO PARA PAGAMENTO E PARCELAS (CASO FORMA DE PAGAMENTO SEJA CRÉDITO OU DÉBITO). * * * * * */  
        if ($id_forma_pagamento === 2 || $id_forma_pagamento === 3) {
            $id_cartao_pagamento = $_POST["txtFormaPagamento"];
            $parcelas =  $_POST["txtParcelas"];        
        }

        /* * * * * * INSERE O PAGAMENTO DO PEDIDO NA TABELA DE PAGAMENTOS. * * * * * */
        $sql_insert_pagamento = mysql_query(
            "INSERT INTO pagamentos (
                `id_forma_pagamento` 
                , `id_cartao_pagamento` 
                , `parcelas`
            ) VALUES (
                $id_forma_pagamento
                , $id_cartao_pagamento
                , $parcelas
            )
        ");
        
        /* * * * * * APÓS A INSERÇÃO DO PAGAMENTO... * * * * * */  
        if ($sql_insert_pagamento == 1) {
            $sql_id_pagamento = mysql_query("SELECT `id_pagamento` FROM `pagamentos` ORDER BY `id_pagamento` DESC LIMIT 1");
            $id_pagamento_result = mysql_fetch_assoc($sql_id_pagamento);
            $id_pagamento = $id_pagamento_result['id_pagamento'];
    
            /* * * * * * ATUALIZA O ID DO PAGAMENTO, NO REGISTRO DO PEDIDO REALIZADO E INSERIDO LÁ EM CIMA. * * * * * */  
            $sql_update_pedido = mysql_query("UPDATE pedidos set id_pagamento = $id_pagamento WHERE id_pedido = $id_pedido");

            include '../carrinho/selecionar_produtos.php';

            /* * * * * * INSERE OS PRODUTOS DO PEDIDO, NA TABELA DE "PEDIDOS_PRODUTOS". * * * * * */
            foreach ($itens_carrinho as $item) {
                $id_produto_pedido = $item['id_produto'];
                $quantidade = $item['total_quantidade'];

                $sql_insert_pedidos_produtos = mysql_query(
                    "INSERT INTO pedidos_produtos (
                        `id_pedido`
                        , `id_produto`
                        , `quantidade`
                    ) VALUES (
                        $id_pedido
                        , $id_produto_pedido
                        , $quantidade
                    )
                ");

                /* * * * * * REMOVE DO CARRINHO OS PRODUTOS QUE FORAM PEDIDOS. * * * * * */  
                if ($sql_insert_pedidos_produtos == 1) {
                    $sql_delete_produto_carrinho = mysql_query("DELETE FROM carrinho WHERE id_produto = $id_produto_pedido AND id_usuario = $id_usuario");
                } else {                    
                    echo "<script>alert('Erro ao registrar os produtos do pedido.');</script>";
                    break;
                }
            }
        } else {
            echo "<script>alert('Erro ao registrar pagamento do pedido.');</script>";                 
            return;
        }

        if ($id_forma_pagamento === 1) {
            echo "<script>window.location.href = '../../pagamento-pix.php';</script>";            
        } else {
            echo "<script>window.location.href = '../../perfil-usuario.php';</script>";  
        }
    } else {
        echo "<script>alert('Erro ao registrar o pedido.');</script>";
    }
?>