<?php
    session_start();

   	header('Content-Type: text/html; charset=utf-8');
    include '../../conexao.php';

    $id_usuario = $_SESSION['id_usuario'];
    
    $subtotal = $_POST["txtValorSubTotalPedido"];
    $frete = $_POST["txtValorFrete"];
    $descontos = $_POST["txtValorDesconto"];
    $total = $_POST["txtValorTotalPedido"];
    $id_forma_pagamento = null;
    $id_cartao_pagamento = null;
    $parcelas = null;
    $id_loja = null;
    $id_endereco = null;  

    /* * * * * * FORMA DE PAGAMENTO * * * * * */
    if ($_POST["txtCreditoDebito"] === 'credito') {
        $id_forma_pagamento = 2;
    } else if ($_POST["txtCreditoDebito"] === 'debito') {
        $id_forma_pagamento = 3;
    } else if ($_POST["txtFormaPagamento"] === 'pix') {
        $id_forma_pagamento = 1;
    }

    /* * * * * * FORMA DE PAGAMENTO (CASO SEJA CRÉDITO OU DÉBITO) * * * * * */  
    if ($id_forma_pagamento === 2 || $id_forma_pagamento === 3) {
        $id_cartao_pagamento = $_POST["txtFormaPagamento"];
        $parcelas =  $_POST["txtParcelas"];        
    }

    /* * * * * * OPÇÃO DE ENTREGA (ENTREGA OU RETIRADA NA LOJA) * * * * * */  
    if (strpos($_POST["txtOpcaoEntrega"], 'loja')) {
        $id_loja = str_replace("loja_", "", $_POST["txtOpcaoEntrega"]);
    } else if (strpos($_POST["txtOpcaoEntrega"], 'endereco')) {
        $id_endereco = str_replace("endereco_", "", $_POST["txtOpcaoEntrega"]);
    }

    echo "<script>alert('subtotal: $subtotal');</script>";
    echo "<script>alert('frete: $frete');</script>";
    echo "<script>alert('descontos: $descontos');</script>";
    echo "<script>alert('total: $total');</script>";
    echo "<script>alert('id_forma_pagamento: $id_forma_pagamento');</script>";
    echo "<script>alert('id_cartao_pagamento: $id_cartao_pagamento');</script>";
    echo "<script>alert('parcelas: $parcelas');</script>";
    echo "<script>alert('id_loja: $id_loja');</script>";
    echo "<script>alert('id_endereco: $id_endereco');</script>";
    echo "<script>alert('id_usuario: $id_usuario');</script>";

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

    if ($sql == 1) {
        $sql_id_pedido = mysql_query("SELECT `id_pedido` FROM `pedidos` WHERE `id_usuario` = $id_usuario ORDER BY `id_pedido` DESC LIMIT 1");
        $id_pedido_result = mysql_fetch_assoc($sql_id_pedido);
        $id_pedido = $id_pedido_result['id_pedido'];

        $sql_insert_pagamento = mysql_query(
            "INSERT INTO pagamentos (
                `id_pedido`, 
                `id_forma_pagamento`, 
                `id_cartao_pagamento`, 
                `parcelas`
            ) VALUES (
                $id_pedido,
                $id_forma_pagamento,
                $id_cartao_pagamento,
                $parcelas
            )
        ");

        if ($sql_insert_pagamento == 1) {
            $sql_id_pagamento = mysql_query("SELECT `id_pagamento` FROM `pagamentos` WHERE `id_pedido` = $id_pedido ORDER BY `id_pagamento` DESC LIMIT 1");
            $id_pagamento_result = mysql_fetch_assoc($sql_id_pagamento);
            $id_pagamento = $id_pagamento_result['id_pagamento'];
    
            $sql_update_pedido = "UPDATE pedidos set id_pagamento = $id_pagamento WHERE id_pedido = $id_pedido";

            include '../carrinho/selecionar_produtos.php';
            
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

                if (!$sql_insert_pedidos_produtos) {
                    echo "<script>alert('Erro ao registrar os produtos do pedido.');</script>";
                    break;
                } else {
                    $sql_delete_produto_carrinho = mysql_query("DELETE FROM carrinho WHERE id_produto = $id_produto AND id_usuario = $id_usuario");
                }
            }            
        } else {
            echo 
                "<script>alert('Erro ao registrar pagamento do pedido.');</script>"; 
                
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