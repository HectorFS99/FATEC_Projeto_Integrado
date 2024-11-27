<?php
    session_start();

   	header('Content-Type: text/html; charset=utf-8');
    include '../../conexao.php';
    
    $id_produto = $_GET['id_produto'];
    $id_usuario = $_SESSION['id_usuario'];

	// Verifica se o produto já existe nos favoritos para este usuário.
	$sql_check = mysql_query(
		"SELECT id_produto FROM favoritos WHERE id_produto = $id_produto AND id_usuario = $id_usuario"
	);

	if (mysql_num_rows($sql_check) == 0) {
		// Produto não existe nos favoritos, insere um novo registro.
        $sql = mysql_query(
            "INSERT INTO favoritos(
                id_usuario
                , id_produto
            ) VALUES (
                $id_usuario 
                , $id_produto
            )"
        );
    
        if ($sql == 1) {
            echo
                "<script>
                    window.location.href = '../../favoritos.php';
                </script>";
        } else {
            echo
                "<script>
                    notificar(true, 'Erro ao favoritar item.', '', mysql_error(), '../../listagem-geral-produtos.php')
                    alert(mysql_error());
                </script>";
        }
	} else {
        echo
            "<script>
                window.location.href = '../../favoritos.php';
            </script>";
    }
?>