<?php
    include '../../admin/acoes_php/conectar_banco_dados.php';
    session_start();

    if (isset($_GET['id']) && isset($_GET['usuario'])) {
        $id_produto = $_GET['id'];
        $id_usuario = $_GET['usuario'];

        echo "ID do Produto: " . $id_produto . "<br>";
        echo "ID do Usuário: " . $id_usuario . "<br>";

        $sql = mysql_query("DELETE FROM carrinho WHERE id_produto = $id_produto AND id_usuario = $id_usuario");
            header('Location: ../../carrinho.php');
            exit();
    } else {
        echo "ID do produto ou ID do usuário não encontrados.";
        exit();
    }
?>
