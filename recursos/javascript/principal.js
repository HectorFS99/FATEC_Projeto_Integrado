document.addEventListener("DOMContentLoaded", function() {

    // Monta a tag <header> em todas as páginas, a fim de evitar repetição de código em cada uma delas.
    // *** Todas as páginas terão a mesma barra de navegação superior.
    
    document.body.insertAdjacentHTML('afterbegin', 
        `<nav class="navbar fixed-top">
            <img src="recursos/imagens/logo_fatec_cor.png" width="125">
        </nav>`
    );
});