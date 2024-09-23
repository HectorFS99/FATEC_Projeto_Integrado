<header class="cabecalho">
    <div>
        <h1>Painel Administrativo</h1>
        <span id="data-atual"></span>
    </div>
    <div class="dropdown">
        <button class="botao btn-usuario" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="mx-2">Usuário Admin.</span>
            <img src="recursos/imagens/usuarios/admin.png">
        </button>
        <ul class="dropdown-menu">
            <li>
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