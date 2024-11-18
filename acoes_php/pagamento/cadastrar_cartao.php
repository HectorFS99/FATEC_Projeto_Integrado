<?php
    session_start();

   	header('Content-Type: text/html; charset=utf-8');
    include '../../conexao.php';

    $id_usuario = $_SESSION['id_usuario'];

    $apelido = $_POST["txtApelidoCartao"];
    $numero_cartao = str_replace(' ', '', $_POST["txtNumeroCartao"]);
    $nome_impresso = $_POST["txtNomeImpressoCartao"];
    $dt_expiracao = $_POST["txtExpiracaoCartao"];
    $codigo_seguranca = $_POST["txtCodigoSegurancaCartao"];
    $credito = $_POST["rdbCreditoDebito"] === "credito" ? 1 : 0;
    $debito = $_POST["rdbCreditoDebito"] === "debito" ? 1 : 0;
    $principal = isset($_POST["chkCartaoPagamentoPrincipal"]) ? 1 : 0;

    // Consulta para verificar se já existem cartões cadastrados para o usuário em questão.
    // Caso não, o cartão será definido como principal automaticamente.
	$select_pagamentos = 
        "SELECT 
            `id_cartao_pagamento`
            , `id_usuario`
            , `numero_cartao`
            , `nome_impresso`
            , `dt_expiracao`
            , `codigo_seguranca`
            , `bandeira`
            , `apelido`
            , `credito`
            , `debito`
            , `dt_cadastro`
            , `principal` 
        FROM 
            `cartoes_pagamento`
        WHERE
            `id_usuario` = $id_usuario";

    $sql_pagamentos = mysql_query($select_pagamentos);

    if (mysql_num_rows($sql_pagamentos) == 0) {
        $principal = 1;
    } else {
        $sql_pagamentoPrincipal = mysql_query($select_pagamentos . " AND `principal` = 1");
        $pagamentoPrincipal = mysql_fetch_assoc($sql_pagamentoPrincipal);
        $idPagamentoPrincipal = $pagamentoPrincipal['id_cartao_pagamento'];

        if ($principal == 1) {
            $update = mysql_query("UPDATE cartoes_pagamento set `principal` = 0 WHERE `id_cartao_pagamento` = $idPagamentoPrincipal");
        }
    }

    $sql = mysql_query(
        "INSERT INTO cartoes_pagamento(
            id_usuario
            , numero_cartao
            , nome_impresso
            , dt_expiracao
            , codigo_seguranca
            , bandeira
            , apelido
            , credito
            , debito
            , principal
        ) VALUES (
            $id_usuario
            , '$numero_cartao'
            , '$nome_impresso'
            , '$dt_expiracao'
            , $codigo_seguranca
            , 'MasterCard'
            , '$apelido'                                           
            , $credito
            , $debito
            , $principal
        )"
    );

    if ($sql == 1) {
        echo
            "<script>
                window.location.href = '../../pagamento.php';
            </script>";
    } else {
        echo
            "<script>
                alert('Não foi possível cadastrar o cartão de pagamento.');
                console.log('$apelido');
                console.log('$numero_cartao');
            </script>";
    }
?>