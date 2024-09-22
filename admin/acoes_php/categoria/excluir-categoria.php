<?php
   	header('Content-Type: text/html; charset=utf-8');
    include '../conectar_banco_dados.php';     
    
    if(isset($_GET['APAGAR'])){
        $sql = mysql_query ("DELETE FROM categorias
                             WHERE nome =". $_GET['APAGAR']);
        echo "
            <script>
                Swal.fire({
                    title: 'Categoria Excluída',
                    icon: 'success'
                });
            </script>
        ";
        } else {
        echo "
            <script>
                Swal.fire({
                    title: 'Erro ao excluir categoria',
                    icon: 'error'
                });
            </script>
        ";
    }

?>