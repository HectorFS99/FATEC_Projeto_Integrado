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