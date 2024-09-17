<?php

include 'conexao.php';

$nome_completo = $_POST['txt_nome'];
$dt_nascimento = $_POST['date'];
$cpf = $_POST['txt_cpf'];
$rg = $_POST['txt_rg'];
$telefone_celular = $_POST['txt_telefone'];
$email = $_POST['txt_email'];
$confirma_email = $_POST['txt_confirmar_email'];
$senha = $_POST['txt_senha'];
$confirma_senha = $_POST['txt_confirmar_senha'];

$sql = mysql_query("SELECT * FROM usuarios
                    WHERE email = '$email' 
                    OR cpf = '$cpf'");



if (mysql_num_rows($sql) > 0) {
    echo "<center><h1> O usuario ja existe </h1></center>";
} else {
    mysql_query("INSERT INTO usuarios (nome_completo, dt_nascimento, cpf, rg, telefone_celular, email, senha) VALUES ('$nome_completo', '$dt_nascimento', '$cpf', '$rg', '$telefone_celular', '$email', '$senha' )");
    echo "<center><h1> O usuario foi cadastrado </h1></center>";
}
