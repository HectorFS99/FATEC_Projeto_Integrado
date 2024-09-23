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

$sql = mysql_query("SELECT * FROM usuarios WHERE email = '$email' OR cpf = '$cpf'");

if (mysqli_num_rows($sql) > 0) {
    echo "<script>alert('Email ou CPF já cadastrados.');</script>";
} else {
    mysql_query("INSERT INTO usuarios (nome_completo, dt_nascimento, cpf, rg, telefone_celular, email, senha) 
                   VALUES ('$nome_completo', '$dt_nascimento', '$cpf', '$rg', '$telefone_celular', '$email', '$senha')");

        echo "<script>window.location.href = 'confirmacao-cadastro.php';</script>";
	}
?>