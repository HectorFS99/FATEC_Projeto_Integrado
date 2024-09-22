<?php
    $servidor = "localhost";
    $usuario = "root";
    $senha = "usbw";
    $banco = "future_mob";

    $conecta_db = mysql_connect($servidor, $usuario, $senha) or die (mysql_error());
    mysql_select_db($banco) or die ("Erro ao conectar ao banco de dados.");
?>