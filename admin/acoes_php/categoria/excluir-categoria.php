<?php
   	header('Content-Type: text/html; charset=utf-8');  
    include '../conectar_banco_dados.php';     
    if(isset($_GET['apagar'])){
        $sql = mysql_query ("DELETE FROM categorias
                             WHERE id_categoria =". $_GET['apagar']);
        echo "
            <script>
                Swal.fire({
                title: "CATEGORIA EXCLUÍDA",
                icon: "success"
                });
            </script>
        ";
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