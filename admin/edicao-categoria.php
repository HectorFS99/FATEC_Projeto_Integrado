<?php
    header('Content-Type: text/html; charset=utf-8');
    include '../conexao.php'; // Certifique-se de que este caminho está correto

    $id_categoria = 0;

    if (isset($_GET['editar'])) {
        $id_categoria = $_GET['editar'];

        // Consulta SQL para buscar os dados da categoria
        $sql = "SELECT * FROM categorias WHERE id_categoria = $id_categoria";
        $resultado = mysql_query($sql, $conecta_db);

        if (mysql_num_rows($resultado) > 0) {
            // Pega os dados da categoria
            $categoria = mysql_fetch_assoc($resultado);
        } else {
            echo "Categoria não encontrada!";
            exit;
        }
    }

    if (isset($_POST['salvar'])) {
        $id_categoria = $_POST['id_categoria'];
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $caminho_icone = $_POST['caminho_icone'];

        // Atualiza os dados da categoria no banco de dados
        $sql_update = "UPDATE categorias 
                       SET nome = '$nome', descricao = '$descricao', caminho_icone = '$caminho_icone'
                       WHERE id_categoria = $id_categoria";
        
        if (mysql_query($sql_update, $conecta_db)) {
            echo "<script>alert('Categoria atualizada com sucesso!'); window.location.href = 'adm_categorias.php';</script>";
        } else {
            echo "Erro ao atualizar categoria: " . mysql_error();
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include '/componentes/adm_head.php'; ?>
        <link rel="stylesheet" href="/recursos/css/adm_geral.css" />
        <title>Editar Categoria</title>
    </head>
    <body>
        <?php include '/componentes/adm_header.php'; ?>
        <hr class="divisor">
        <main class="conteudo-principal">
            <div class="titulo-opcoes">
                <h3 class="titulo">
                    <a href="adm_produtos.php" class="btn-voltar"><i class="fa-solid fa-arrow-left"></i></a>
                    Editar Categoria
                </h3>
            </div>
            <form action="edicao-categoria.php" method="POST" name="frmCategoria" class="formulario w-100">
                <input type="hidden" name="id_categoria" value="<?php echo $categoria['id_categoria']; ?>">

                <!-- Nome e caminho do ícone -->
                <div class="formulario-grupo">
                    <div class="form-floating">
                        <input name="nome" value="<?php echo $categoria['nome']; ?>" required class="form-control" placeholder="Nome">
                        <label for="nome">Nome:</label>
                    </div>
                    <div class="form-floating">
                        <input name="caminho_icone" value="<?php echo $categoria['caminho_icone']; ?>" type="text" required class="form-control" placeholder="Caminho do Ícone">
                        <label for="caminho_icone">Caminho do Ícone:</label>
                    </div>
                </div>

                <!-- Descrição -->
                <div class="form-floating">
                    <textarea name="descricao" required class="form-control" rows="6" placeholder="Descrição"><?php echo $categoria['descricao']; ?></textarea>
                    <label for="descricao">Descrição:</label>
                </div>
                
                <div class="form-botoes">
                    <button type="button" onclick="window.location.href='adm_categorias.php'" class="botao form-btn btn-cancelar">Cancelar</button>
                    <button type="submit" value="Confirmar" onclick="document.frmCategoria.action='acoes_php/categoria/editar-categoria.php?id_categoria=<?= $id_categoria ?>'" class="botao form-btn btn-confirmar">Confirmar</button>
                </div>
            </form>                    
        </main>
    </body>
</html>
