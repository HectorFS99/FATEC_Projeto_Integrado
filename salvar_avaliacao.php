<?php
    session_start();

    header('Content-Type: text/html; charset=utf-8');
    include 'conexao.php';

    $id_usuario = $_SESSION['id_usuario'];

    
    $id_produto = $_POST["id_produto"]; 
    $avaliacao = $_POST["avaliacao"]; 
    $titulo = $_POST["titulo"]; 
    $descricao = $_POST["descricao"]; 
    $dt_avaliacao = date("Y-m-d"); 

    
    $imagem = "null";
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $nome_arquivo = $_FILES['imagem']['name'];
        $caminho_temporario = $_FILES['imagem']['tmp_name'];
        $diretorio_destino = '../../uploads/avaliacoes/';

       
        if (!is_dir($diretorio_destino)) {
            mkdir($diretorio_destino, 0777, true);
        }

        $caminho_completo = $diretorio_destino . $nome_arquivo;
        if (move_uploaded_file($caminho_temporario, $caminho_completo)) {
            $imagem = $nome_arquivo; 
        }
    }


    $sql = mysql_query(
        "INSERT INTO avaliacoes (
            `id_produto`,
            `id_usuario`,
            `avaliacao`,
            `dt_avaliacao`,
            `titulo`,
            `descricao`,
            `imagem`,
            `verificado`
        ) VALUES (
            $id_produto,
            $id_usuario,
            $avaliacao,
            '$dt_avaliacao',
            '$titulo',
            '$descricao',
            '$imagem',
            0
        )"
    );


    if ($sql == 1) {
        echo "<script>alert('Avaliação registrada com sucesso!');</script>";
        echo "<script>window.location.href = 'detalhes-produto.php?id_produto=$id_produto';</script>";
    } else {
        
    }
?>

