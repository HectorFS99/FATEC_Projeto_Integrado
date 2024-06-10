// Monta o header e o footer em todas as páginas que contêm a tag header e footer.
document.addEventListener("DOMContentLoaded", function() {
    header = document.getElementById('header');
    if (header) {
        header.innerHTML = `        
        <nav class="navbar">
            <form class="formulario">
                <div class="input-group">
                    <select id="cboCategoria" class="form-select">
                        <option selected>Todos</option>
                        <option value="1">Sala de Estar</option>
                        <option value="2">Escritório</option>
                        <option value="3">Quarto</option>
                        <option value="3">Cozinha</option>
                        <option value="3">Sala de Jantar</option>
                        <option value="3">Área Externa</option>
                    </select>
                    <input id="txtPesquisar" type="text" class="form-control" placeholder="Encontrar sofás, mesas...">
                    <button id="btnPesquisar" type="submit" class="btn btn-laranja"><i class="fa-solid fa-magnifying-glass"></i></button>					
                </div>
            </form>
            <a href="pagina-inicial.html" style="width: 70px;"><img src="recursos/imagens/logos/logo_futureMob.png" width="70"/></a>
            <div class="botoes_barra_superior">        
                <a href="pagina-inicial.html" class="btn-vertical">
                    <i class="fa-solid fa-house"></i>
                    <span>Início</span>
                </a>
                <a href="listagem-geral-produtos.html" class="btn-vertical">
                    <i class="fa-solid fa-cube"></i>
                    <span>Produtos</span>
                </a>
                <a href="login.html" class="btn-vertical">
                    <i class="fa-solid fa-user"></i>
                    <span>Minha Conta</span>
                </a>
                <a href="favoritos.html" class="btn-vertical">
                    <i class="fa-solid fa-heart"></i>
                    <span>Favoritos</span>
                </a>
                <a id="btnCarrinho" href="carrinho.html" class="btn btn-laranja">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span id="contador-carrinho" style="margin-left: 1rem;">0</span>
                </a>
            </div>
        </nav>`;
    }
    
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
                <a class="btn btn-sobre" href="sobre.html">Clique e conheça!</a>
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

/* Validação geral */
function validarCampo(id_campo, id_feedback) {
    var campo = document.getElementById(id_campo);
    var div_feedback = document.getElementById(id_feedback);

    if (campo.value.length > 0) {
        switch (id_campo) {
            case 'txtNome':
            case 'txtNomeTitularCartao':
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
            case 'txtValidadeCartao':
                var posBarra = campo.value.indexOf('/');
                var mes = parseInt(campo.value.substring(0, posBarra));
                var ano = parseInt(campo.value.substring(posBarra + 1));
                
                if (mes > 12 || (ano > 2043 || ano < new Date().getFullYear())) {
                    exibirFeedback(campo, div_feedback, 'Data inválida. Informe a validade corretamente.')
                } else {
                    limparFeedback(div_feedback);
                }

                break;
            // ToDo: Acrescentar validação para cartão de crédito/débito...
        }
    }

    return;
}

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

function validarEmail(email) {
    return /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}(?:\.[a-zA-Z]{2,})?$/.test(email);
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
        document.getElementById('resultado-cep_logradouro').innerHTML = conteudo.logradouro;
        document.getElementById('resultado-cep_bairro').innerHTML = conteudo.bairro;
        document.getElementById('resultado-cep_localidade').innerHTML = conteudo.localidade;
        document.getElementById('resultado-cep_uf').innerHTML = conteudo.uf;  

        document.getElementById('resultado-frete').style.display = 'block';
    } else {
        componente_cep.value = '';
        notificar(false, 'CEP não encontrado', '', 'error', '');
    }
}