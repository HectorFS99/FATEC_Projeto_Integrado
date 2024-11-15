// Monta o header e o footer em todas as páginas que contêm a tag header e footer.
document.addEventListener("DOMContentLoaded", function() {
    var footer = document.getElementById('footer');
    if (footer) {
        footer.innerHTML = `
        <hr />
        <div class="d-flex justify-content-around flex-wrap">
            <div class="formas_pagamento">
                <h4>Formas de Pagamento</h4>
                <div class="logos_footer bandeiras_pagamento">
                    <img src="recursos/imagens/logos/bandeiras_pagamento/visa.svg" alt="visa" />
                    <img src="recursos/imagens/logos/bandeiras_pagamento/mastercard.svg" alt="mastercard" />
                    <img src="recursos/imagens/logos/bandeiras_pagamento/american-express.svg" alt="american-express" />
                    <img src="recursos/imagens/logos/bandeiras_pagamento/hipercard.svg" alt="hipercard" />
                    <img src="recursos/imagens/logos/bandeiras_pagamento/pix.svg" alt="pix" />
                </div>
            </div>
            <div class="app_futuremob">
                <h4>Baixe o nosso aplicativo!</h4>
                <div class="logos-footer disponivel_app">
                    <img src="recursos/imagens/icones/disponivel-google-play.svg" alt="disponivel-google-play">
                    <img src="recursos/imagens/icones/disponivel-app-store.svg" alt="disponivel-na-app-store">
                </div>
            </div>
            <div class="div-sobre">
                <span>FUTUREMOB</span>
                <a class="btn btn-sobre" href="sobre.php">Clique e conheça!</a>
            </div>
        </div>`;
    }    
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

/***** Máscaras para campos (pode ser usada em outras telas) *****/
function aplicarMascaraCPF(campo) {
    campo.value = campo.value.replace(/[^0-9.-]/g, ''); // Remove letras e mantém apenas números, ponto (.) e hífen (-).
    $(`#${campo.id}`).mask("000.000.000-00");
}

function aplicarMascaraTelefone(campo) {
    $(`#${campo.id}`).mask("(00) 00000-0000");
}
/*****/

/***** Validações *****/
function validarCaracteresEspeciais(texto) {
    return /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/.test(texto);
}

function validarComparacaoCampos(id_campo, id_campo_confirmacao, id_feedback, mensagem) {
    var campo = document.getElementById(id_campo);
    var campo_confirmacao = document.getElementById(id_campo_confirmacao);

    var div_feedback = document.getElementById(id_feedback);

    campo.value !== campo_confirmacao.value ? exibirFeedback(campo, div_feedback, mensagem) : limparFeedback(div_feedback);
}

function validarCriteriosSenha(id_campo, id_feedback) {
    var campo = document.getElementById(id_campo);
    var div_feedback = document.getElementById(id_feedback);

    !/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()-_+=])[A-Za-z\d!@#$%^&*()-_+=]{10,}$/.test(campo.value) ? exibirFeedback(campo, div_feedback, 'Esta senha não atende aos critérios de segurança.') : limparFeedback(div_feedback);
}

function validarNome(id_campo, id_feedback) {
    var campo = document.getElementById(id_campo);
    var div_feedback = document.getElementById(id_feedback);

    if (campo.value.length < 2) {
        exibirFeedback(campo, div_feedback, 'Nome inválido. Informe-o corretamente.')
    } else if (validarCaracteresEspeciais(campo.value)) {
        exibirFeedback(campo, div_feedback, 'Não são permitidos caracteres especiais. Informe um nome válido.');
        campo.value = '';
    } else {
        limparFeedback(div_feedback);
    }    
}

function validarDataNascimento(id_campo, id_feedback) {
    var campo = document.getElementById(id_campo);
    var div_feedback = document.getElementById(id_feedback);

    var dtNasc = new Date(campo.value)
        , mesNasc = dtNasc.getMonth() + 1 // Dado que os meses aqui são índices, começando por 0, acrescentei +1
        , dtAtual = new Date()
        , mesAtual = dtAtual.getMonth() + 1
        , idade = dtAtual.getFullYear() - dtNasc.getFullYear();
    
    if (mesAtual < mesNasc || (mesAtual === mesNasc && dtAtual.getDate() < dtNasc.getDate())) { idade--; }

    idade < 18 ? exibirFeedback(campo, div_feedback, 'É necessário ser maior de idade para realizar o cadastro.') : limparFeedback(div_feedback);    
}

function validarCPF(id_campo, id_feedback) {
    var campo = document.getElementById(id_campo);
    var div_feedback = document.getElementById(id_feedback);

    var cpf = campo.value.replace(/[.-]/g, ''); // Remove os pontos (.) e o hífen (-), mantendo apenas números para realizar as operações de validação.

    if (cpf == "00000000000") {
        exibirFeedback(campo, div_feedback, 'Informe um CPF válido.');
        return;
    }

    if (cpf.length !== 11 || /^(.)\1+$/.test(cpf)) { // Verifica se o CPF tem 11 dígitos e se não é uma sequência repetida qualquer.
        exibirFeedback(campo, div_feedback, 'Informe um CPF válido.');
        return; 
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
        exibirFeedback(campo, div_feedback, 'Informe um CPF válido.');
        return;
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
        exibirFeedback(campo, div_feedback, 'Informe um CPF válido.');
        return;
    }

    limparFeedback(div_feedback);
}

function validarEmail(id_campo, id_feedback) {
    var campo = document.getElementById(id_campo);
    var div_feedback = document.getElementById(id_feedback);

    !/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}(?:\.[a-zA-Z]{2,})?$/.test(campo.value) ? exibirFeedback(campo, div_feedback, 'Informe um e-mail válido.') : limparFeedback(div_feedback);
}
/*****/

/***** Feedback *****/
function exibirFeedback(campo, div_feedback, mensagem) {
    div_feedback.style.display = 'block';
    div_feedback.innerHTML = `<strong>${mensagem}</strong>`;

    //campo.focus();
}

function limparFeedback(div_feedback) {
    div_feedback.innerHTML = '';
    div_feedback.style.display = 'none';
}

function verificarFeedbackInvalido(id_form) {
    var formulario = document.getElementById(id_form);
    var feedbacks = formulario.querySelectorAll(".invalid-feedback");
    
    for (let i = 0; i < feedbacks.length; i++) {
        if (feedbacks[i].textContent.trim() !== "") {
            return true;
        }
    }
    
    return false;
}

function confirmarFormulario(event, id_form, caminho_action) {
    event.preventDefault();

    if (verificarFeedbackInvalido(id_form)) {
        notificar(false, "Verifique as suas informações", "Um ou mais dados informados não são válidos.", "error", "");
        return;
    } else {
        var formulario = document.getElementById(id_form);
        formulario.action = caminho_action;
        formulario.submit();    
    }
}
/*****/

/***** Carrossel *****/
let indice_atual = 0;

function mostrarSlide(indice, id_componente) {
    const slides = document.querySelectorAll(`${id_componente} .carrossel-item`);
    const totalSlides = slides.length;

    if (indice >= totalSlides) {
        indice_atual = 0;
    } else if (indice < 0) {
        indice_atual = totalSlides - 1;
    } else {
        indice_atual = indice;
    }

    const container = document.querySelector(`${id_componente} .carrossel-container`);
    container.style.transform = `translateX(-${indice_atual * 100}%)`;
}

function slideAnterior(id_componente) {
    mostrarSlide(indice_atual - 1, id_componente);
}

function proximoSlide(id_componente) {
    mostrarSlide(indice_atual + 1, id_componente);
}
/*****/

/***** Valores *****/
function calcularSubtotal(name_lbl_valor, name_lbl_qtd, id_lbl_subTotal) {
    var listaProdutosPreco = document.querySelectorAll(`[name="${name_lbl_valor}"]`);
    var listaProdutosQtd = document.querySelectorAll(`[name="${name_lbl_qtd}"]`);

    var subTotal = 0;
    for (let i = 0; i < listaProdutosPreco.length; i++) {
        var subTotalTexto = listaProdutosPreco[i].textContent.trim();        
        var qtd = parseInt(listaProdutosQtd[i].textContent.trim());

        subTotal += parseFloat((subTotalTexto.replace(/\./g, '').replace(',', '.')) * qtd);
    }

    document.getElementById(id_lbl_subTotal).innerHTML = `${formatarValor(subTotal)}`;

    return subTotal;
}

function formatarValor(valor) {
    return new Intl.NumberFormat('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(valor);
}

function adicionarQtd(id_componente_qtd, name_lbl_valor, name_lbl_qtd, id_lbl_subTotal) {
    var qtd = parseInt(document.getElementById(id_componente_qtd).innerHTML) + 1;
    document.getElementById(id_componente_qtd).innerHTML = qtd;

    calcularSubtotal(name_lbl_valor, name_lbl_qtd, id_lbl_subTotal);
}

function subtrairQtd(id_componente_qtd, name_lbl_valor, name_lbl_qtd, id_lbl_subTotal) {
    var componente = document.getElementById(id_componente_qtd);
    var qtd = parseInt(componente.innerHTML);

    qtd > 1 ? componente.innerHTML = qtd - 1 : componente.innerHTML = componente.innerHTML;

    calcularSubtotal(name_lbl_valor, name_lbl_qtd, id_lbl_subTotal);
}

/***** BUSCA POR CEP *****/
function pesquisaCep(id_componente_cep) {
    var componente_cep = document.getElementById(id_componente_cep);
    var cep = componente_cep.value.replace(/\D/g, '');

    if (cep) {
        var validacep = /^[0-9]{8}$/;      
        if(validacep.test(cep)) {
            var script = document.createElement('script');
            script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=dados_cep';

            document.body.appendChild(script);
        } else {
            componente_cep.value = '';
            notificar(false, 'CEP inválido', 'Informe um CEP válido para consulta.', 'error', '');
        }
    } else { componente_cep.value = ''; }    
}

function dados_cep(conteudo) {
    if (!("erro" in conteudo)) {
        var container = document.getElementById('resultado-frete');

        var logradouro = document.getElementById('resultado-cep_logradouro'); // Endereço
        var bairro = document.getElementById('resultado-cep_bairro');
        var localidade = document.getElementById('resultado-cep_cidade'); // Cidade
        var uf = document.getElementById('resultado-cep_uf');

        logradouro.innerHTML = logradouro.value = conteudo.logradouro;
        bairro.innerHTML = bairro.value = conteudo.bairro;
        localidade.innerHTML = localidade.value = conteudo.localidade;
        uf.innerHTML = uf.value = conteudo.uf;  

        if (container) { container.style.display = 'block'; }
    } else {
        componente_cep.value = '';
        notificar(false, 'CEP não encontrado', '', 'error', '');
    }
}