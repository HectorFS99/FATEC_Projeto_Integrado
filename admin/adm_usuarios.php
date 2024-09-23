<?php
    include '../conexao.php';

    $sql_usuarios = mysql_query(
        "SELECT 
            `id_usuario`
            , `nome_completo`
            , `cpf`
            , `rg`
            , `dt_nascimento`
            , `sexo`
            , `telefone_celular`
            , `email`
            , `senha`
            , `admin` 
        FROM
            `usuarios`");
?>
<html lang="pt-br">
    <head>
        <?php include '/componentes/adm_head.php'; ?>
        <title>Usuários</title>
    </head>
    <body>
        <?php include '/componentes/adm_header.php'; ?>
        <main class="conteudo-principal">
            <div class="titulo-opcoes">
                <h3 class="titulo">
                    <a href="adm_index.php" class="btn-voltar"><i class="fa-solid fa-arrow-left"></i></a>
                    Usuários
                </h3>
                <button onclick="window.location.href='../cadastro.php'" class="botao btn-adicionar">
                    <i class="fa-solid fa-square-plus"></i> Adicionar
                </button>
            </div>
            <div class="table-responsive">
                <table id="tabela-usuarios" class="table table-striped">
                    <!-- Cabeçalho da tabela -->
                    <thead>
                        <tr class="tabela-linha">
                            <th>ID</th>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>RG</th>
                            <th>Dt. Nasc.</th>
                            <th>Sexo</th>
                            <th>Tel. Celular</th>
                            <th>E-mail</th>
                            <th>É admin.?</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <!-- Corpo da tabela -->
                    <tbody>
                        <?php while ($linha = mysql_fetch_assoc($sql_usuarios)) { ?> 
                            <tr class="tabela-linha">
                                <td><?php echo $linha['id_usuario']; ?></td>
                                <td>
                                    <?php
                                        // Limita o nome para 30 caracteres e adiciona "..." se for maior.
                                        $nome = $linha['nome_completo'];
                                        echo 
                                            mb_strlen($nome) > 30 ? mb_substr($nome, 0, 30) . "..." : $nome;
                                    ?>
                                </td>
                                <td><?php echo $linha['cpf']; ?></td>
                                <td><?php echo $linha['rg']; ?></td>
                                <td><?php echo $linha['dt_nascimento']; ?></td>
                                <td>
                                    <?php
                                        $sexo = $linha['sexo'];                                
                                        if ($sexo == 'M') {
                                            echo 'Masculino';
                                        } else if ($sexo == 'F') {
                                            echo 'Feminino';
                                        } else {
                                            echo 'Não informado';
                                        }
                                    ?>
                                </td>
                                <td><?php echo $linha['telefone_celular']; ?></td>
                                <td><?php echo $linha['email']; ?></td>
                                <td><?php echo $linha['admin'] ? 'Sim' : 'Não'; ?></td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a class="btn-tabela btn-excluir" href="acoes_php/usuario/excluir-usuario.php?apagar=<?php echo $linha['id_usuario']; ?>">
                                            <i class="fa-solid fa-trash-can"></i>
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
            transformarTabela('#tabela-usuarios');
        });
    </script>
</html>