<?php
session_start();

if (isset($_SESSION['id_usuario']) && !empty($_SESSION['id_usuario'])) {
    header("Location: perfil-usuario.php");
} else {
    header("Location: login.php");
}

exit();

?>