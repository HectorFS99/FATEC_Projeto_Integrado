<?php 
header('Content-Type: text/html; charset=utf-8');

// Inclui a conexão ao banco de dados
include '../conexao.php';

if (isset($_GET['editar'])) {
    $id_categoria = $_GET['editar'];

    if (!$conecta_db) {
        die("Falha na conexão: " . mysqli_connect_error());
    }

    // Executa a consulta no banco de dados
    $sql = "SELECT * FROM categorias WHERE id_categoria = $id_categoria";


    //if (mysqli_num_rows($resultado) > 0) {
    //    $categoria = mysqli_fetch_assoc($resultado);
    //} else {
    //    echo "Categoria não encontrada!";
    //    exit;
    //}
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
    <form action="edicao_categoria.php" method="POST">
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
