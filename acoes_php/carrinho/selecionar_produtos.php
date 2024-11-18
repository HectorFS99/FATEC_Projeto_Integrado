<?php
    $result = mysql_query( 
        "SELECT 
            c.id_produto
            , p.nome
            , p.caminho_imagem
            , p.preco_atual
            , p.preco_anterior
            , SUM(c.quantidade) AS total_quantidade
        FROM 
            carrinho AS c
            INNER JOIN produtos AS p ON c.id_produto = p.id_produto
        WHERE 
            c.id_usuario = $id_usuario
        GROUP BY 
            c.id_produto
            , p.nome
            , p.caminho_imagem
            , p.preco_atual
            , p.preco_anterior"
    );    

    // Array para armazenar os itens do carrinho
    $itens_carrinho = [];
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $itens_carrinho[] = $row;
        }
    }
?>