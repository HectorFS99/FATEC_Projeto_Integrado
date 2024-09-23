<?php
    include '../conectar_banco_dados.php';

    if (isset($_GET['apagar'])) {
        $sql = mysql_query("DELETE FROM produtos where id_produto=" . $_GET['apagar']);
        
        echo
            "<script>
                alert('Produto excluido com sucesso!');
                window.location.href = '../../adm_produtos.php';
            </script>";

        return false;
    } else {
        echo "
            <script>
                alert('Ocorreu um erro, tente novamente');
                window.location.href = '../../adm_categorias.php';
            </script>
        ";
        }
?>