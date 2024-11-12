<?php
session_start();

include 'conexao.php';

$email = $_POST['txt_email'];
$senha = $_POST['txt_senha'];

$sql = mysql_query("SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'");

if (mysql_num_rows($sql) == 0) {
    $_SESSION['autenticado'] = false;
    
	echo "
    <script>
        alert('Email ou senha incorretos'); 
        window.location.href = 'login.php';
    </script>";
} else {
	$usuario = mysql_fetch_assoc($sql);

	$_SESSION['email'] = $usuario['email'];
	$_SESSION['id_usuario'] = $usuario['id_usuario'];
	$_SESSION['admin'] = $usuario['admin'];
	$id_usuario = $usuario['id_usuario'];

	$sql_carrinho = mysql_query("SELECT * FROM carrinho WHERE id_usuario = '$id_usuario'");
    $_SESSION['carrinho'] = [];
    while ($item_carrinho = mysql_fetch_assoc($sql_carrinho)) {
        $_SESSION['carrinho'][] = $item_carrinho; 
    }

    $sql_pedidos = mysql_query("SELECT * FROM pedidos_produtos WHERE id_usuario = '$id_usuario'");
    $_SESSION['pedidos'] = [];
    while ($pedido = mysql_fetch_assoc($sql_pedidos)) {
        $_SESSION['pedidos'][] = $pedido;  
    }

    $sql_favoritos = mysql_query("SELECT * FROM favoritos WHERE id_usuario = '$id_usuario'");
    $_SESSION['favoritos'] = [];
    while ($favorito = mysql_fetch_assoc($sql_favoritos)) {
        $_SESSION['favoritos'][] = $favorito;  
    }

	$_SESSION['autenticado'] = true;

	header("Location: pagina-inicial.php");

	exit();
}