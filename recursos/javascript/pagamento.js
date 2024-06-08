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