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
            var dtNasc = new Date(campo.value)
                , mesNasc = dtNasc.getMonth() + 1 // Dado que os meses aqui são índices, começando por 0, acrescentei +1
                , dtAtual = new Date()
                , mesAtual = dtAtual.getMonth() + 1
                , idade = dtAtual.getFullYear() - dtNasc.getFullYear();
            
            if (mesAtual < mesNasc || (mesAtual === mesNasc && dtAtual.getDate() < dtNasc.getDate())) { 
                idade--; 
            }

            if (idade < 18) {                
                exibirFeedback(campo, div_feedback, 'É necessário ser maior de idade para realizar o cadastro.')
            } else {
                limparFeedback(div_feedback);
            }

            break;
        case 'txtCPF':
            if (!validarCPF(campo.value)) {
                exibirFeedback(campo, div_feedback, 'Informe um CPF válido.')
            } else {
                limparFeedback(div_feedback);
            }
            break;
    }

    return;
}

function exibirFeedback(campo, div_feedback, mensagem) {
    div_feedback.style.display = 'block';
    div_feedback.innerHTML = `<strong>${mensagem}</strong>`;

    //campo.focus();
}

function limparFeedback(div_feedback) {
    div_feedback.innerHTML = '';
    div_feedback.style.display = 'none';
}

/***** Validações gerais *****/
function validarCaracteresEspeciais(texto) {
    return /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/.test(texto);
}

/** CPF **/
function aplicarMascaraCPF(campo) {
    var cpf = campo.value.replace(/[^0-9.-]/g, ''); // Remove letras e mantém apenas números, ponto (.) e hífen (-).
    var cpfFormatado = '';

    campo.value = cpf;

    /* Aplica a máscara conforme o usuário for digitando no campo, acrescentando o ponto (.) e o hífen (-),
       de acordo com a quantidade de caracteres. */
    if (cpf.length >= 3) {
        cpfFormatado += cpf.substring(0, 3) + '.';
    }
    if (cpf.length >= 6) {
        cpfFormatado += cpf.substring(3, 6) + '.';
    }
    if (cpf.length >= 9) {
        cpfFormatado += cpf.substring(6, 9) + '-';
    }
    if (cpf.length >= 11) {
        cpfFormatado += cpf.substring(9, 11);
        campo.value = cpfFormatado;
    }
}

function validarCPF(cpf) {
    cpf = cpf.replace(/[.-]/g, ''); // Remove os pontos (.) e o hífen (-), mantendo apenas números para realizar as operações de validação.

    if (cpf == "00000000000") {
        return false;
    }

    if (cpf.length !== 11 || /^(.)\1+$/.test(cpf)) { // Verifica se o CPF tem 11 dígitos e se não é uma sequência repetida qualquer.
        return false; 
    }
    
    var soma;
    var resto;
    soma = 0;

    for (i = 1; i <= 9; i++) {
        soma = soma + parseInt(cpf.substring(i - 1, i)) * (11 - i); 
    }

    resto = (soma * 10) % 11;
    if ((resto == 10) || (resto == 11)) { 
        resto = 0; 
    }
    if (resto != parseInt(cpf.substring(9, 10))) {
        return false;
    }

    soma = 0;
    for (i = 1; i <= 10; i++) { 
        soma = soma + parseInt(cpf.substring(i - 1, i)) * (12 - i); 
    }

    resto = (soma * 10) % 11;
    if ((resto == 10) || (resto == 11)) {
        resto = 0;        
    }
    if (resto != parseInt(cpf.substring(10, 11) )) {
        return false;
    }

    return true;
}