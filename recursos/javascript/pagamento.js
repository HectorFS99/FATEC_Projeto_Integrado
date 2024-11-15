document.addEventListener("DOMContentLoaded", function() {
    var valorFreteTexto = document.getElementById('lblValorFrete').innerHTML;
    var valorFrete = parseFloat(valorFreteTexto.replace(/\./g, '').replace(',', '.')); 

    var valorDescontoTexto = document.getElementById('lblValorDesconto').innerHTML;
    var valorDesconto = parseFloat(valorDescontoTexto.replace(/\./g, '').replace(',', '.')); 

    var listaTotaisLbl = document.querySelectorAll('[name="lblValorTotalPedido"]');

    var total = (valorFrete + calcularSubtotal('lblValorProduto', 'lblQtdProduto', 'lblValorSubTotalPedido')) - valorDesconto;
    listaTotaisLbl.forEach(function(elemento) {
        elemento.innerHTML = `${formatarValor(total)}`;
    });
    
    var comboParcelas = document.getElementById('cboParcelas');
    for (let i = 1; i < 11; i++) {
        var htmlOption = `<option value=\"${i}\" ${i == 1 ? 'selected' : ''}>${i}x de R$ ${formatarValor(total/i)}</option>`;
        comboParcelas.innerHTML += htmlOption;
    }
});

function exibirAccordion(id_accordion, id_componente) {
    let componente = document.getElementById(id_componente);
    let listaAccordions = componente.getElementsByClassName('container-accordion');
    
    for (let i = 0; i < listaAccordions.length; i++) {
        listaAccordions[i].style.display = "none";
    }

    accordion = document.getElementById(id_accordion);
    accordion.style.display = "block";

}

/***** Máscaras para formulário de cartão de crédito/débito *****/
function aplicarMascaraNumeroCartao(campo) {
    campo.value = campo.value.replace(/[^0-9 ]/g, ''); // Remove letras e mantém apenas números, ponto (.) e hífen (-).
    $(`#${campo.id}`).mask("0000 0000 0000 0000");
}

function aplicarMascaraValidadeCartao(campo) {
    campo.value = campo.value.replace(/[^0-9/]/g, ''); // Remove letras e mantém apenas números, ponto (.) e hífen (-).
    $(`#${campo.id}`).mask("00/0000");
}

function aplicarMascaraCodigoSeguranca(campo) {
    campo.value = campo.value.replace(/[^0-9/]/g, ''); // Remove letras e mantém apenas números, ponto (.) e hífen (-).
}
/*****/

/***** Validações *****/
function validarDataExpiracao(id_campo, id_feedback) {
    var campo = document.getElementById(id_campo);
    var div_feedback = document.getElementById(id_feedback);

    var posBarra = campo.value.indexOf('/');
    var mes = parseInt(campo.value.substring(0, posBarra));
    var ano = parseInt(campo.value.substring(posBarra + 1));
    
    if (mes > 12 || (ano > 2043 || ano < new Date().getFullYear())) {
        exibirFeedback(campo, div_feedback, 'Data inválida. Informe a validade corretamente.')
    } else {
        limparFeedback(div_feedback);
    }
}
/*****/

function verificaOpcaoEntrega(linkRedirecionamento) {
    const selectedRadio = document.querySelector('input[name="opcao-entrega"]:checked');
    if (selectedRadio) {
        window.location.href = linkRedirecionamento;
    } else {
        notificar(false, 'Escolha uma opção de entrega.', '', 'error', '');
        document.getElementById('txtCep').focus();
    }    
}

function cadastrarEndereco(event) {
    event.preventDefault();
}

function finalizarPedidoPIX() {
    verificaOpcaoEntrega('pagamento-pix.html');
}

function finalizarPedidoCartao(e) {
    e.preventDefault();

    var creditoInfoDiv = document.getElementById('credito_info');
    if (!creditoInfoDiv) {
        console.error('A div com ID "credito-info" não foi encontrada.');
        return;
    }

    var feedbacksInvalidos = creditoInfoDiv.querySelectorAll('.invalid-feedback');
    for (let i = 0; i < feedbacksInvalidos.length; i++) {
        var feedback = feedbacksInvalidos[i].innerHTML.trim();
        if (feedback) {
            notificar(false, 'Os dados informados não são válidos. Por favor, verifique os campos destacados.', '', 'error', '');
            return;
        }
    }

    verificaOpcaoEntrega('perfil-usuario.html');
}