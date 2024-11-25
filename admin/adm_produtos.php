<?php
    include '../conexao.php';

    $sql_produtos = mysql_query(
        "SELECT 
            `id_produto`,
            `nome`,
            `descricao`,
            `preco_anterior`,
            `preco_atual`,
            `altura`,
            `largura`,
            `profundidade`,
            `peso`,
            `destaque`,
            `oferta_relampago`,
            `id_categoria`,
            `caminho_imagem`,
            `ativo`
        FROM 
            `produtos`;");
?>
<html lang="pt-br">
    <head>
        <?php include '/componentes/adm_head.php'; ?>
        <title>Produtos</title>
    </head>
    <body>
        <?php include '/componentes/adm_header.php'; ?>
        <main class="conteudo-principal">
            <div class="titulo-opcoes">
                <h3 class="titulo">
                    <a href="adm_index.php" class="btn-voltar"><i class="fa-solid fa-arrow-left"></i></a>
                    Produtos
                </h3>
                <button onclick="window.location.href='cadastro-produto.php'" class="botao btn-adicionar">
                    <i class="fa-solid fa-square-plus"></i> Adicionar
                </button>
            </div>
            <div class="table-responsive">
                <table id="tabela-produtos" class="table table-striped">
                    <!-- Cabeçalho da tabela -->
                    <thead>
                        <tr class="tabela-linha">
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Preço anterior</th>
                            <th>Preço atual</th>
                            <th>Destaque?</th>
                            <th>Oferta?</th>
                            <th>Categoria ID</th>
                            <th>Ativo?</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <!-- Corpo da tabela -->
                    <tbody>
                        <?php while ($linha = mysql_fetch_assoc($sql_produtos)) { ?> 
                            <tr class="tabela-linha">
                                <td><?php echo $linha['id_produto']; ?></td>
                                <td>
                                    <?php
                                        // Limita o nome para 30 caracteres e adiciona "..." se for maior.
                                        $nome = $linha['nome'];
                                        echo 
                                            mb_strlen($nome) > 30 ? mb_substr($nome, 0, 30) . "..." : $nome;
                                    ?>
                                </td>
                                <td>R$ <?php echo $linha['preco_anterior']; ?></td>
                                <td>R$ <?php echo $linha['preco_atual']; ?></td>
                                <td><?php echo $linha['destaque'] ? 'Sim' : 'Não'; ?></td>
                                
                                <td><?php echo $linha['oferta_relampago'] ? 'Sim' : 'Não'; ?></td>
                                <td><?php echo $linha['id_categoria']; ?></td>
                                <td><?php echo $linha['ativo'] ? 'Sim' : 'Não'; ?></td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a class="btn-tabela btn-excluir" href="acoes_php/produto/excluir-produto.php?apagar=<?php echo $linha['id_produto']; ?>">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                        <a class="btn-tabela btn-editar" href="edicao-produto.php?id_produto=<?php echo $linha['id_produto']; ?>">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr> 
                        <?php } ?>
                    </tbody>
                </table>               
            </div>
        </main>
    </body>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            transformarTabela('#tabela-produtos');
        });
    </script>
</html>