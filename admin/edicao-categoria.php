<?php
    header('Content-Type: text/html; charset=utf-8');
    include '../conexao.php'; // Certifique-se de que este caminho está correto

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
    <meta charset="UTF-8">
    <title>Editar Categoria</title>
</head>
<body>
    <h2>Editar Categoria</h2>
    <form action="edicao-categoria.php" method="POST">
        <input type="hidden" name="id_categoria" value="<?php echo $categoria['id_categoria']; ?>">

        <label for="nome">Nome:</label>
        <input type="text" name="nome" value="<?php echo $categoria['nome']; ?>" required><br><br>

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" required><?php echo $categoria['descricao']; ?></textarea><br><br>

        <label for="caminho_icone">Caminho do Ícone:</label>
        <input type="text" name="caminho_icone" value="<?php echo $categoria['caminho_icone']; ?>"><br><br>

        <button type="submit" name="salvar">Salvar Alterações</button>
    </form>
</body>
</html>
