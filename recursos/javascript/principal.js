document.addEventListener("DOMContentLoaded", function() {

    // Monta a tag <header> em todas as páginas, a fim de evitar repetição de código em cada uma delas.
    // *** Todas as páginas terão a mesma barra de navegação superior.
    
    document.body.insertAdjacentHTML('afterbegin', 
        `<header class="fixed-top">
            <nav class="navbar">
                <img src="recursos/imagens/logo_fatec_cor.png" width="125">
            </nav>
        </header>`
    );
});

function validarCampo(id_campo, id_feedback) {
    var campo = document.getElementById(id_campo);
    var div_feedback = document.getElementById(id_feedback);

    switch (id_campo) {
        case 'txtNome':
            if (campo.value.length < 2) {
                exibirFeedback(campo, div_feedback, 'Nome inválido. Informe-o corretamente.')
            } else if (validarCaracteresEspeciais(campo.value)) {
                exibirFeedback(campo, div_feedback, 'Não são permitidos caracteres especiais. Informe um nome válido.');
                campo.value = '';
            } else {
                limparFeedback(div_feedback);
            }

            break;
        case 'dtNasc':

            break;
    }

    return;
}

function validarCaracteresEspeciais(texto) {
    return /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/.test(texto);
}

function exibirFeedback(campo, div_feedback, mensagem) {
    div_feedback.style.display = 'block';
    div_feedback.innerHTML = `<strong>${mensagem}</strong>`;

    campo.focus();
}

function limparFeedback(div_feedback) {
    div_feedback.innerHTML = '';
    div_feedback.style.display = 'none';
}