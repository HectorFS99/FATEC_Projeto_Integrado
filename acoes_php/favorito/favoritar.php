<?php
    session_start();

   	header('Content-Type: text/html; charset=utf-8');
    include '../../conexao.php';
    
    $id_produto = $_GET['id_produto'];
    $id_usuario = $_SESSION['id_usuario'];

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
                notificar(true, 'Erro ao cadastrar endereço', '', mysql_error(), '../../listagem-geral-produtos.php')
                alert(mysql_error());
            </script>";
    }

    $result = mysql_query( 
        "SELECT 
            f.id_produto
            , p.nome
            , p.caminho_imagem
            , p.preco_atual
            , p.preco_anterior
        FROM 
            favoritos AS f
            INNER JOIN produtos AS p ON f.id_produto = p.id_produto
        WHERE 
            f.id_usuario = $id_usuario"
    );    

    // Array para armazenar os itens favoritos
    $itens_favoritos = [];
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $itens_favoritos[] = $row;
        }
    }

?>