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

function formatarParaDecimal(valorStr) {
    let valorFormatado = valorStr.replace('.', '').replace(',', '.');
    return parseFloat(valorFormatado);
}

function finalizarPedido(e) {
    e.preventDefault();

    var opcaoEntrega = document.querySelector('input[name="opcao-entrega"]:checked');
    var formaPagamento = document.querySelector('input[name="forma-pagamento"]:checked');

    if (!opcaoEntrega || !formaPagamento) {
        notificar(false, 'Escolha uma opção de entrega e uma forma de pagamento.', '', 'error', '');
        return;
    } else {
        var creditoDebito = document.querySelector('input[name="credito_debito"]:checked');

        if (formaPagamento.value !== 'pix' && !creditoDebito) {
            notificar(false, 'Escolha uma opção de pagamento para o cartão selecionado (crédito ou débito).', '', 'error', '');
            return;           
        } else if (formaPagamento.value !== 'pix') {
            document.getElementById('txtCreditoDebito').value = creditoDebito.value;
            
            var parcelas = document.getElementById('cboParcelas').value;
            document.getElementById('txtParcelas').value = parcelas;
        }
        
        var subTotal = formatarParaDecimal(document.getElementById('lblValorSubTotalPedido').innerText);
        var frete = formatarParaDecimal(document.getElementById('lblValorFrete').innerText);
        var desconto = formatarParaDecimal(document.getElementById('lblValorDesconto').innerText);
        var total = formatarParaDecimal(document.getElementById('lblValorTotalPedido').innerText);
        
        document.getElementById('txtFormaPagamento').value = formaPagamento.value;
        document.getElementById('txtValorSubTotalPedido').value = subTotal;
        document.getElementById('txtValorFrete').value = frete;
        document.getElementById('txtValorDesconto').value = desconto;
        document.getElementById('txtValorTotalPedido').value = total;
        document.getElementById('txtOpcaoEntrega').value = opcaoEntrega.value;

        var formulario = document.getElementById('frmFinalizarPedido');
        formulario.action = 'acoes_php/pedidos/cadastrar_pedido.php';
        formulario.submit();  
    }  
}