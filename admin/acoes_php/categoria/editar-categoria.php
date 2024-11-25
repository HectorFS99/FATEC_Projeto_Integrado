<?php
    include '../conectar_banco_dados.php';

    if (isset($_POST['salvar'])) {
        // Pega os valores do formulário
        $id_categoria = $_POST['id_categoria'];
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $caminho_icone = $_POST['caminho_icone'];

        $sql = "UPDATE categorias 
                SET nome = '$nome', descricao = '$descricao', caminho_icone = '$caminho_icone'
                WHERE id_categoria = $id_categoria";

        if (mysqli_query($conexao, $sql)) {
            echo "<script>
                    alert('Categoria atualizada com sucesso!');
                    window.location.href = 'adm_categorias.php';
                  </script>";
        } else {
            echo "Erro ao atualizar categoria: " . mysqli_error($conexao);
        }
    }
?>