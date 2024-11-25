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

    if (isset($_GET['id_produto'])) { 
        $sql = mysql_query(
            "UPDATE produtos
                SET nome = '$nome'
                , descricao = '$descricao'
                , preco_anterior = '$preco_anterior'
                , preco_atual = '$preco_atual'
                , altura = '$altura'
                , largura = '$largura' 
                , profundidade = '$profundidade'
                , peso = '$peso'
                , destaque = '$destaque'
                , oferta_relampago = '$oferta_relampago'
                , id_categoria = '$id_categoria'
                , caminho_imagem = '$caminho_imagem'
                , ativo = '$ativo'
            where id_produto=" . $_GET['id_produto']
        );
    }
    
    if ($sql == 1) {
        echo
            "<script>
                alert('Edição realizada com sucesso!');
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
