document.addEventListener("DOMContentLoaded", function() {
    setTimeout(mudarConteudo, 10000);
});

function mudarConteudo() {
    var icone_carregamento = document.getElementById('icone-carregamento');
    icone_carregamento.style.display = 'none';

    var icone_confirmacao = document.getElementById('icone-confirmacao');
    icone_confirmacao.style.display = 'block';

    var titulo = document.getElementById('titulo');
    titulo.innerHTML = 'Confirmado!'

    var info = document.getElementById('info');
    info.innerHTML = 'Seja bem-vindo(a)! Explore o nosso catálogo e aproveite as nossas ofertas!'

    var btn = document.getElementById('btn');
    btn.innerHTML = 'Continuar'
    btn.setAttribute('href', 'pagina-inicial.html');
}