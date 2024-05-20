// Carrega o conteúdo da tag <head> quando chamado nas páginas, evitando repetição de código.
function criarElementos(titulo) {
    var head = document.head;
    
    // Abaixo, os elementos que irão compor a tag <head>, serão criados e anexados à tag <head>.
    var title = document.createElement("title");
    title.textContent = titulo;

    var metaCharset = document.createElement("meta");
    metaCharset.setAttribute("charset", "UTF-8");

    var metaViewport = document.createElement("meta");
    metaViewport.setAttribute("name", "viewport");
    metaViewport.setAttribute("content", "width=device-width, initial-scale=1.0");

    head.appendChild(title);
    head.appendChild(metaCharset);
    head.appendChild(metaViewport); 

    /*** Referências JS ***/
    var js_jquery = criarReferenciasJS("https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js");
    var js_bootstrap_5_3_3= criarReferenciasJS("https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js");
    var js_principal = criarReferenciasJS("recursos/javascript/principal.js");

    head.appendChild(js_jquery);
    head.appendChild(js_bootstrap_5_3_3);
    head.appendChild(js_principal); 

    
    /*** Referências CSS ***/
    var css_reset = criarReferenciasCSS("recursos/css/reset.css");
    var css_bootstrap_5_3_3 = criarReferenciasCSS("https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css");
    var css_geral = criarReferenciasCSS("recursos/css/geral.css");

    head.appendChild(css_reset);
    head.appendChild(css_bootstrap_5_3_3);
    head.appendChild(css_geral);
}

function criarReferenciasCSS(href) {
    var referencia_CSS = document.createElement("link");
    referencia_CSS.setAttribute("rel", "stylesheet");
    referencia_CSS.setAttribute("href", href);

    return referencia_CSS;
}

function criarReferenciasJS(src) {
    var referencia_JS = document.createElement("script");
    referencia_JS.setAttribute("src", src);

    return referencia_JS;
}