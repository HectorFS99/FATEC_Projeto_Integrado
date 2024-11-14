<?php
    session_start();

   	header('Content-Type: text/html; charset=utf-8');
    include '../../conexao.php';
    
    $id_produto = $_GET['id_produto'];
    $id_usuario = $_SESSION['id_usuario'];

    $sql = mysql_query(
        "INSERT INTO favoritos(
            id_usuario
            , id_produto
        ) VALUES (
            $id_usuario 
            , $id_produto
        )"
    );

    if ($sql == 1) {
        echo
            "<script>
                window.location.href = '../../favoritos.php';
            </script>";
    } else {
        echo
            "<script>
                notificar(true, 'Erro ao cadastrar endereço', '', mysql_error(), '../../listagem-geral-produtos.php')
                alert(mysql_error());
            </script>";
    }
?>