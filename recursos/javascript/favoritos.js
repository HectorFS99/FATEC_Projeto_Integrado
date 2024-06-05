function visualizarGrid() {
    div_cards = document.getElementById('visualizacaoCards');
    div_cards.style.display = 'flex';

    div_lista = document.getElementById('visualizacaoLista');
    div_lista.style.display = 'none';
}

function visualizarLista() {
    div_cards = document.getElementById('visualizacaoCards');
    div_cards.style.display = 'none';

    div_lista = document.getElementById('visualizacaoLista');
    div_lista.style.display = 'block';
}