<?php
   	header('Content-Type: text/html; charset=utf-8');
    include '../conectar_banco_dados.php';

    if (!function_exists('boolval')) {
        function boolval($val) {
            return (bool) $val;
        }
    }

    $nome = $_POST["txt_nome"];
    $descricao = $_POST["txt_descricao"];
    $caminho_icone = $_POST["txt_caminhoICONE"];

    $sql = mysql_query(
        "INSERT INTO categorias(
            nome
            , descricao
            , caminho_icone
        ) VALUES (
            '$nome' 
            ,'$descricao'
            ,'$caminho_icone'
        )"
    );

    if ($sql == 1) {
        echo
            "<script>
                alert('CATEGORIA ADICIONADA');
                window.location.href = '../../adm_categorias.php';
            </script>";
    } else {
        echo
            "<script>
                alert(mysql_error());
                window.location.href = '../../adm_categorias.php';
            </script>";
    }
?>