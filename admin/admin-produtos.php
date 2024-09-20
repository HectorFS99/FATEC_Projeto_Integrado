<?php
    include '../conexao.php';
	$sql_categorias = mysql_query("SELECT * FROM `produtos`");
?>

<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Cadastro de produtos</title>

    <link rel="stylesheet" href="css/geral.css">
    
    <link rel="stylesheet" href="css/listagem.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

    <p><h1 class="titulo">Administrador de Produtos.</h1></p>
    <button onclick="window.location.href='cadastrar-produto.php'" class="btn-tela-produtos">Novo Produto</button>
    
    <table class="tabela">
            <tr class="tabela-linha">
                <th colspan="8">Listagem de Produtos</th>
            </tr>
            <tr class="tabela-linha">
                <th>ID</th>
                <th>Nome Produto</th>
                <th>Descrição</th>
                <th>Preço Antigo</th>
                <th>Preço Atual</th>
                <th>Altura</th>
                <th>Largura</th>
                <th>Profundidade</th>
                <th>Peso</th>
                <th>Destaque?</th>
                <th>Oferta?</th>
                <th>ID da Categoria</th>
                <th>Local da Imagem</th>
                <th>Ativo?</th>
                <th>Apagar</th>            
            </tr>
            <?php while($linha = mysql_fetch_assoc($sql_categorias)) { ?>
                <tr class="tabela-linha">
                    <td><?php echo $linha['id_produto']; ?></td>
                    <td><?php echo $linha['nome']; ?></td>
                    <td><?php echo $linha['descricao']; ?></td>
                    <td>R$<?php echo $linha['preco_anterior']; ?></td>
                    <td>R$ <?php echo $linha['preco_atual']; ?></td>
                    <td><?php echo $linha['altura']; ?>cm</td>
                    <td><?php echo $linha['largura']; ?>cm</td>
                    <td><?php echo $linha['profundidade']; ?>cm</td>
                    <td><?php echo $linha['peso']; ?>Kg</td>
                    <td><?php echo $linha['destaque']; ?></td>
                    <td><?php echo $linha['oferta_relampago']; ?></td>
                    <td><?php echo $linha['id_categoria']; ?></td>
                    <td><?php echo $linha['caminho_imagem']; ?></td>
                    <td><?php echo $linha['ativo']; ?></td>

                    <td><a class="btn-excluir" href="excluir-produtos.php?apagar='<?php echo $linha['id_produto']; ?>'"><i class="bi bi-trash3-fill"></i></a></td>
                </tr>     			
            <?php } ?>        
    </table>             
</body>
</html>     