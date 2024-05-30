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

/***** SweetAlert2. *****/
// Popups
const popupSwal = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-lg btn-light custom-button-popup',
        cancelButton: 'btn btn-lg btn-danger custom-button-popup',
        popup: 'custom-popup'
    },
    buttonsStyling: false
});
 
// Toasts
const toastSwal = Swal.mixin({
    toast: true,
    position: 'top-end',
    iconColor: 'white',
    customClass: {
        popup: 'colored-toast',
    },
    showConfirmButton: false,
    timer: 7000,
    timerProgressBar: true,
});
 
// Caso 'popup' seja passado como 'true', será exibido um POPUP. Caso 'false', será exibido um TOAST.
function notificar(popup, titulo, mensagem, icone, caminho) {
    if (popup) {
        popupSwal.fire({ 
            title: `${titulo}`
            , text: `${mensagem}`
            , icon: `${icone}` 
        }).then(() => { 
            if (caminho) { window.location.href = `${caminho}`; }            
        }) 
    } else {
        toastSwal.fire({
            title: `${titulo}`
            , text: `${mensagem}`
            , icon: `${icone}` 
        });
    }
}
/*****/

/** Máscaras para campos **/
function aplicarMascaraCPF(campo) {
    campo.value = campo.value.replace(/[^0-9.-]/g, ''); // Remove letras e mantém apenas números, ponto (.) e hífen (-).
    $(`#${campo.id}`).mask("000.000.000-00");
}

function aplicarMascaraRG(campo) {
    campo.value = campo.value.replace(/[^A-Z0-9.-]/g, ''); // Remove caracteres que não são letras maiúsculas nem números.
    $(`#${campo.id}`).mask("00.000.000-0");
}

function aplicarMascaraTelefone(campo) {
    $(`#${campo.id}`).mask("(00) 00000-0000");
}

/** Validação geral **/
function validarCampo(id_campo, id_feedback) {
    var campo = document.getElementById(id_campo);
    var div_feedback = document.getElementById(id_feedback);

    if (campo.value.length > 0) {
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
                
                if (mesAtual < mesNasc || (mesAtual === mesNasc && dtAtual.getDate() < dtNasc.getDate())) { idade--; }
                idade < 18 ? exibirFeedback(campo, div_feedback, 'É necessário ser maior de idade para realizar o cadastro.') : limparFeedback(div_feedback);

                break;
            case 'txtCPF':
                !validarCPF(campo.value) ? exibirFeedback(campo, div_feedback, 'Informe um CPF válido.') : limparFeedback(div_feedback);
                break;
            case 'txtRG':
                !validarRG(campo.value) ? exibirFeedback(campo, div_feedback, 'Informe um RG válido.') : limparFeedback(div_feedback);
                break;
            case 'txtEmail':
                !validarEmail(campo.value) ? exibirFeedback(campo, div_feedback, 'Informe um e-mail válido.') : limparFeedback(div_feedback);
                break;
            case 'txtConfirmarEmail':
                document.getElementById(id_campo).value !== document.getElementById('txtEmail').value ? exibirFeedback(campo, div_feedback, 'Este e-mail não coincide com o informado.') : limparFeedback(div_feedback);
                break;
            case 'txtSenha':
                !/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()-_+=])[A-Za-z\d!@#$%^&*()-_+=]{10,}$/.test(campo.value) ? exibirFeedback(campo, div_feedback, 'Esta senha não atende aos critérios de segurança.') : limparFeedback(div_feedback);
                break;
            case 'txtConfirmarSenha':
                document.getElementById(id_campo).value !== document.getElementById('txtSenha').value ? exibirFeedback(campo, div_feedback, 'Esta senha não coincide com a informada.') : limparFeedback(div_feedback);
                break;
        }
    }

    return;
}

/** Validações específicas **/
function validarCaracteresEspeciais(texto) {
    return /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/.test(texto);
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

function validarRG(rg) {
    rg = rg.replace(/[.-]/g, ''); // Remove os pontos (.) e o hífen (-).

    if (rg === "000000000") {
        return false;
    }

    if (rg.length < 8 || /^(.)\1+$/.test(rg)) { // Verifica se o RG tem menos de 8 dígitos (considerando RGs sem DV) e se não é uma sequência repetida qualquer.
        return false; 
    }

    return true;
}

function validarEmail(email) {
    return /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}(?:\.[a-zA-Z]{2,})?$/.test(email);
}

/** Feedback **/
function exibirFeedback(campo, div_feedback, mensagem) {
    div_feedback.style.display = 'block';
    div_feedback.innerHTML = `<strong>${mensagem}</strong>`;

    //campo.focus();
}

function limparFeedback(div_feedback) {
    div_feedback.innerHTML = '';
    div_feedback.style.display = 'none';
}

function visualizarSenha(id_campo) {
    var campo_senha = document.getElementById(id_campo);
    var botao_visualizar = document.querySelector('.olho-senha');

    if (campo_senha.type === 'password') {
        campo_senha.type = 'text';
        botao_visualizar.classList.replace('fa-eye-slash', 'fa-eye');
    } else {
        campo_senha.type = 'password';
        botao_visualizar.classList.replace('fa-eye', 'fa-eye-slash');
    }    
}

function impedirColagem(e) { // Impede que o usuário cole conteúdos em um determinado campo. EXEMPLO: Campo de confirmação de e-mail e senha.
    e.preventDefault();
    var clipboardData = e.clipboardData || window.clipboardData;
    clipboardData.setData('text', '');
}

function cadastrar(e) {
    e.preventDefault();

    // Aqui, as divs que contêm a classe "invalid-feedback", serão obtidas pra verificar se tem algum conteúdo dentro delas.
    // Se for o caso, o cadastro não será feito e o usuário será notificado.

    var div_feedbacks_invalidos = document.getElementsByClassName('invalid-feedback');

    for (let i = 0; i < div_feedbacks_invalidos.length; i++) {
        var feedback = div_feedbacks_invalidos[i].innerHTML.trim();
        if (feedback) {
            notificar(false, 'Os dados informados não são válidos. Por favor, verifique os campos destacados.', '', 'error', '');
            return;
        }
    }
     
    notificar(true, 'Tudo ok!', 'Eviaremos um link de confirmação para o e-mail informado dentro de alguns instantes.', 'success', 'confirmacao-cadastro.html');
}