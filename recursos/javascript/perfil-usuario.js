function exibirTela(id_tela, id_botao) {
    var listaTelas = document.getElementsByClassName('section-tela');
    var listaBotoes = document.getElementsByClassName('menu-lateral_opcao');

    for (let i = 0; i < listaTelas.length; i++) {
        listaTelas[i].style.display = 'none';
        listaBotoes[i].classList.remove('btn-opcaoMenu_selecionado');
    }

    document.getElementById(id_tela).style.display = 'block';
    document.getElementById(id_botao).classList.add('btn-opcaoMenu_selecionado');
}