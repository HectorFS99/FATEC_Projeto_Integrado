<?php
    include '../../admin/acoes_php/conectar_banco_dados.php';
    session_start();

    if (isset($_GET['id_produto']) && isset($_GET['id_usuario'])) {
        $id_produto = $_GET['id_produto'];
        $id_usuario = $_GET['id_usuario'];

        $sql = mysql_query("DELETE FROM favoritos WHERE id_produto = $id_produto AND id_usuario = $id_usuario");
            header('Location: ../../favoritos.php');
            exit();
    } else {
        echo "ID do produto ou ID do usuário não encontrados.";
        exit();
    }
?>