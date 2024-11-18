<?php
	include '../../admin/acoes_php/conectar_banco_dados.php';

	session_start();

	if (!isset($_SESSION['id_usuario'])) {
		echo 
			"<script>
				alert('Você precisa estar logado para adicionar ao carrinho.');
				window.location.href = '../../login.php';
			</script>";

		exit();
	}

	$id_produto = isset($_GET['id_produto']) ? intval($_GET['id_produto']) : 0;
	$id_usuario = $_SESSION['id_usuario'];  // ID do usuário da sessão
	$quantidade = isset($_GET['quantidade']) ? intval($_GET['quantidade']) : 1;

	// Modos de visualização e retorno.
	$comprarAgora = isset($_GET['comprarAgora']) ? $_GET['comprarAgora'] : false;
	$listagem = isset($_GET['listagem']) ? $_GET['listagem'] : false;

	if ($id_produto <= 0 || $quantidade <= 0) {
		echo 
			"<script>
				alert('Dados inválidos!');
				window.location.href = '../../produtos.php';
			</script>";

		exit();
	}

	$sql = mysql_query(
		"INSERT INTO carrinho (
			id_produto
			, id_usuario
			, quantidade) 
		VALUES (
			$id_produto
			, $id_usuario
			, $quantidade)
		");

	if ($comprarAgora) {
		header("Location: ../../pagamento.php");
	} else if ($listagem) {
		header("Location: ../../listagem-geral-produtos.php");
	} else {
		header("Location: ../../detalhes-produto.php?id_produto=$id_produto");
	}
?>