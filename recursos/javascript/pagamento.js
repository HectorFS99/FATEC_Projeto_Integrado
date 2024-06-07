function exibirAccordion(id_accordion) {
    listaAccordions = document.getElementsByClassName('container-accordion');
    for (let i = 0; i < listaAccordions.length; i++) {
        listaAccordions[i].style.display = "none";
    }

    accordion = document.getElementById(id_accordion);
    accordion.style.display = "block";
}