<?php
    include '../conectar_banco_dados.php';

    if (!function_exists('boolval')) {
        function boolval($val) {
            return (bool) $val;
        }
    }

    $nome = $_POST["txt_nome"];
    $descricao = $_POST["txt_descricao"];
    $preco_anterior = floatval($_POST["txt_precoAnt"]);
    $preco_atual = floatval($_POST["txt_precoAtual"]);
    $altura = floatval($_POST["txt_altura"]);
    $largura = floatval($_POST["txt_largura"]);
    $profundidade = floatval($_POST["txt_profundidade"]);
    $peso = floatval($_POST["txt_peso"]);
    $id_categoria = intval($_POST["cbo_categoria"]);
    $caminho_imagem = $_POST["txt_caminhoIM"];
    $destaque = boolval(isset($_POST["cbo_destaque"]) ? $_POST["cbo_destaque"] : 0);
    $oferta_relampago = boolval(isset($_POST["cbo_oferta"]) ? $_POST["cbo_oferta"] : 0);
    $ativo = boolval(isset($_POST["cbo_ativo"]) ? $_POST["cbo_ativo"] : 0);

    $sql = mysql_query(
        "INSERT INTO produtos(
            nome
            , descricao
            , preco_anterior
            , preco_atual
            , altura
            , largura
            , profundidade
            , peso
            , destaque
            , oferta_relampago
            , id_categoria
            , caminho_imagem
            , ativo
        ) VALUES (
            '$nome' 
            ,'$descricao'
            ,'$preco_anterior' 
            ,'$preco_atual'
            ,'$altura'
            ,'$largura' 
            ,'$profundidade'
            ,'$peso'
            ,'$destaque'
            ,'$oferta_relampago'
            ,'$id_categoria'
            ,'$caminho_imagem'
            ,'$ativo'
        )"
    );

    if ($sql == 1) {
        echo
            "<script>
                alert('Cadastro realizado com sucesso!');
                window.location.href = '../../adm_produtos.php';
            </script>";
    } else {
        echo
            "<script>
                alert(mysql_error());
                window.location.href = '../../adm_produtos.php';
            </script>";
    }
?>