<?php

include '../../../conexao.php';

if (isset($_GET['editar'])) {
    $id_usuario = $_GET['editar'];
    $sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
    } else {
        echo "Usuário não encontrado";
    }
    if (isset($_POST['salvar'])) {
        $nome_completo = $_POST['txt_nome'];
        $dt_nascimento = $_POST['date'];
        $cpf = $_POST['txt_cpf'];
        $rg = $_POST['txt_rg'];
        $telefone_celular = $_POST['txt_telefone'];
        $email = $_POST['txt_email'];
        $senha = $_POST['txt_senha'];
        
    
        $sql_update = "UPDATE usuarios SET nome_completo=?, dt_nascimento=?, cpf=?, rg=?, telefone_celular=?, email=?, senha=? WHERE id_usuario=?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sssssssi", $nome, $dt_nascimento, $cpf, $rg, $telefone_celular, $email, $senha $id_usuario);
        if ($stmt_update->execute()) {
            header("Location: ../../adm_usuarios.php?msg=Usuario editado com sucesso");
        } else {
            echo "Erro ao editar usuário: " . $conn->error;
        }
        $stmt_update->close();
    }
    $stmt->close();
    $conn->close();
}
?>
<html>
    <head>
        <title>Editar Usuário</title>
    </head>
    <body>
        <form method="POST">
            <input type="text" name="nome_completo" value="<?php echo $usuario['nome_completo']; ?>" required />
            <input type="text" name="cpf" value="<?php echo $usuario['cpf']; ?>" required />
            <!-- Outros campos de edição -->
            <button type="submit" name="salvar">Salvar</button>
        </form>
    </body>
</html>
 
 