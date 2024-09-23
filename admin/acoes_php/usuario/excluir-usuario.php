<?php
include '../../../conexao.php';

if (isset($_GET['apagar']) && is_numeric($_GET['apagar'])) {
    $id_usuario = intval($_GET['apagar']);

    mysql_query("DELETE FROM usuarios WHERE id_usuario = '$id_usuario'");
    echo "
        <script>
        alert('Usuario deletado'); 
        window.location.href = '/admin/adm_usuarios.php'
        </script>
        ";
} else {
    echo "ID de usuário inválido.";
}

?>
