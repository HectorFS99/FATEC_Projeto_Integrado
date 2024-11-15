<?php
    session_start();

   	header('Content-Type: text/html; charset=utf-8');
    include '../../conexao.php';

    $id_usuario = $_SESSION['id_usuario'];
    
    $nome_endereco = $_POST["txtNomeEndereco"];
    $cep = $_POST["txtCep"];
    $logradouro = $_POST["resultado-cep_logradouro"];
    $numero = $_POST["txtNumeroEndereco"];
    $complemento = $_POST["txtComplemento"];
    $bairro = $_POST["resultado-cep_bairro"];
    $cidade = $_POST["resultado-cep_cidade"];
    $uf = $_POST["resultado-cep_uf"];
    $principal = isset($_POST["chkEnderecoPrincipal"]) ? 1 : 0;

    // Consulta para verificar se já existem endereços cadastrados para o usuário em questão.
    // Caso não, o endereço será definido como principal automaticamente.
	$select_enderecos = 
        "SELECT 
            `id_endereco`
            , `id_usuario`
            , `nome_endereco`
            , `cep`
            , `logradouro`
            , `numero`
            , `complemento`
            , `bairro`
            , `cidade`
            , `uf`
            , `dt_cadastro`
            , `principal` 
        FROM 
            `enderecos`
        WHERE
            `id_usuario` = $id_usuario";

    $sql_enderecos = mysql_query($select_enderecos);

    if (mysql_num_rows($sql_enderecos) == 0) {
        $principal = 1;
    } else {
        $sql_enderecoPrincipal = mysql_query($select_enderecos . " AND `principal` = 1");
        $enderecoPrincipal = mysql_fetch_assoc($sql_enderecoPrincipal);
        $idEnderecoPrincipal = $enderecoPrincipal['id_endereco'];

        if ($principal == 1) {
            $update = mysql_query("UPDATE enderecos set `principal` = 0 WHERE `id_endereco` = $idEnderecoPrincipal");
        }
    }

    $sql = mysql_query(
        "INSERT INTO enderecos(
            id_usuario
            , nome_endereco
            , cep
            , logradouro
            , numero
            , complemento
            , bairro
            , cidade
            , uf
            , principal
        ) VALUES (
            $id_usuario 
            , '$nome_endereco'
            , '$cep'
            , '$logradouro'
            , '$numero'
            , '$complemento'
            , '$bairro'
            , '$cidade'
            , '$uf'
            , $principal
        )"
    );

    if ($sql == 1) {
        echo
            "<script>
                window.location.href = '../../pagamento.php';
            </script>";
    } else {
        echo
            "<script>
                notificar(true, 'Erro ao cadastrar endereço', '', mysql_error(), '../../pagamento.php')
                alert(mysql_error());
            </script>";
    }
?>