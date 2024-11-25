<?php
    session_start();
    date_default_timezone_set('America/Sao_Paulo'); // Define o fuso horário para o Brasil

	include '../admin/acoes_php/conectar_banco_dados.php';

    if (!isset($_SESSION['id_usuario'])) {
        echo 
            "<script>
                alert('Usuário não autenticado. Você será redirecionado para a página inicial.')
                window.location.href = '../pagina-inicial.php';
            </script>";        
    }

    $id_usuario = $_SESSION['id_usuario'];

    $sql_usuario = mysql_query(
        "SELECT 
            nome_completo
            , telefone_celular
            , email
            , caminho_img_perfil
        FROM
            usuarios
        WHERE 
            id_usuario = $id_usuario"
    ) or die("Erro ao obter dados do usuário: " . mysql_error());

    $usuario = mysql_fetch_assoc($sql_usuario);
    if (!$usuario) {
        die("Usuário não encontrado.");
    }
?>

<header class="cabecalho">
    <div>
        <h1>Painel Administrativo</h1>
        <span id="data-atual"></span>
    </div>
    <div class="dropdown">
        <button class="botao btn-usuario" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="mx-2"><?php echo $usuario['nome_completo']; ?></span>
            <img src="<?php echo $usuario['caminho_img_perfil']; ?>">
        </button>
        <ul class="dropdown-menu">
            <li>
                <div class="info-usuario">
                    <span><?php echo $usuario['email']; ?></span>
                    <span><?php echo $usuario['telefone_celular']; ?></span>
                </div>
                <a class="dropdown-item" href="../pagina-inicial.php">
                    <i class="fa-solid fa-person-walking-arrow-right"></i>Sair
                </a>
            </li>
        </ul>
    </div>
</header>
<hr class="divisor">
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function formatarData(data) {
            const opcoesData = { day: 'numeric', month: 'long', year: 'numeric' };
            const dataFormatada = data.toLocaleDateString('pt-BR', opcoesData);
            
            const horas = String(data.getHours()).padStart(2, '0');
            const minutos = String(data.getMinutes()).padStart(2, '0');
            
            return `${dataFormatada} - ${horas}:${minutos}`;
        }

        const dataAtual = new Date();
        const elementoData = document.getElementById('data-atual');

        if (elementoData) {
            elementoData.textContent = formatarData(dataAtual);
        }
    });
</script>