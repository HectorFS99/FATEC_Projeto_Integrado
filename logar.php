<?php

include 'conexao.php';

$email = $_POST['txt_email'];
$senha = $_POST['txt_senha'];

$sql = mysql_query("SELECT email, senha FROM usuarios
                    WHERE email = '$email' AND senha = '$senha'");



if (mysql_num_rows($sql) == 0) {
    echo "
	<script>
	alert('oi'); 
	 </script>";
	
} else {
	echo "
	<h1>$email</h1>
	<h1>$senha</h1>";
}
