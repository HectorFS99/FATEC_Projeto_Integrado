<?php
   	header('Content-Type: text/html; charset=utf-8');
    include '../conexao.php';

    $sql_categoria = mysql_query(
        "SELECT 
            `id_categoria`,
            `nome`,
            `descricao`,
            `caminho_icone`
        FROM 
            `categorias`;");
?>
<html lang="pt-br">
    <head>
        <?php include '/componentes/adm_head.php'; ?>
        <title>Categorias</title>
    </head>
    <body>
        <?php include '/componentes/adm_header.php'; ?>
        <main class="conteudo-principal">
            <div class="titulo-opcoes">
                <h3 class="titulo">
                    <a href="adm_index.php" class="btn-voltar"><i class="fa-solid fa-arrow-left"></i></a>
                    Categorias
                </h3>
                <button onclick="window.location.href= 'cadastro-categoria.php'" class="botao btn-adicionar">
                    <i class="fa-solid fa-square-plus"></i> Adicionar
                </button>
            </div>
            <div class="table-responsive">
                <table id="tabela-categoria" class="table table-striped">
                    <!-- Cabeçalho da tabela -->
                    <thead>
                        <tr class="tabela-linha">
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Ícone</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <!-- Corpo da tabela -->
                    <tbody>
                        <?php while ($linha = mysql_fetch_assoc($sql_categoria)) { ?> 
                            <tr class="tabela-linha">
                                <td><?php echo $linha['id_categoria']; ?></td>
                                <td>
                                    <?php
                                        // Limita o nome para 30 caracteres e adiciona "..." se for maior.
                                        $nome = $linha['nome'];
                                        echo 
                                            mb_strlen($nome) > 30 ? mb_substr($nome, 0, 30) . "..." : $nome;
                                    ?>
                                </td>
                                <td><?php echo $linha['descricao']; ?></td>
                                <td> <?php echo $linha['caminho_icone']; ?></td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a class="btn-tabela btn-excluir" href="acoes_php/categoria/excluir-categoria.php?apagar=<?php echo $linha['id_categoria']; ?>">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                        <a class="btn-tabela btn-editar" href="edicao-categoria.php?editar=<?php echo $linha['id_categoria']; ?>">
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
            transformarTabela('#tabela-categoria');
        });
    </script>
</html>