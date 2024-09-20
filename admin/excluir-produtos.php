<?php
    include '../conexao.php';

    if (isset($_GET['apagar'])) {
        $sql = mysql_query("DELETE FROM produtos where id_produto=". $_GET['apagar']);
        
        
        echo 
            "<script>
                alert('Produto excluido com sucesso!');
                window.location.href = 'admin-produtos.php';
            </script>";

        return false;
    }
?>