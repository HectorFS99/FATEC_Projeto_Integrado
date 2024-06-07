function cadastrar(e) {
    e.preventDefault();

    // Aqui, as divs que contêm a classe "invalid-feedback", serão obtidas pra verificar se tem algum conteúdo dentro delas.
    // Se for o caso, o cadastro não será feito e o usuário será notificado.

    var div_feedbacks_invalidos = document.getElementsByClassName('invalid-feedback');

    for (let i = 0; i < div_feedbacks_invalidos.length; i++) {
        var feedback = div_feedbacks_invalidos[i].innerHTML.trim();
        if (feedback) {
            notificar(false, 'Os dados informados não são válidos. Por favor, verifique os campos destacados.', '', 'error', '');
            return;
        }
    }
     
    notificar(true, 'Tudo ok!', 'Eviaremos um link de confirmação para o e-mail informado dentro de alguns instantes.', 'success', 'confirmacao-cadastro.html');
}

function aplicarMascaraRG(campo) {
    campo.value = campo.value.replace(/[^A-Z0-9.-]/g, ''); // Remove caracteres que não são letras maiúsculas nem números.
    $(`#${campo.id}`).mask("00.000.000-0");
}

function validarRG(rg) {
    rg = rg.replace(/[.-]/g, ''); // Remove os pontos (.) e o hífen (-).

    if (rg === "000000000") {
        return false;
    }

    if (rg.length < 8 || /^(.)\1+$/.test(rg)) { // Verifica se o RG tem menos de 8 dígitos (considerando RGs sem DV) e se não é uma sequência repetida qualquer.
        return false; 
    }

    return true;
}