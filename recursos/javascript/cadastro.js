/** Validação geral **/
function validarCampo(id_campo, id_feedback) {
    var campo = document.getElementById(id_campo);
    var div_feedback = document.getElementById(id_feedback);

    if (campo.value.length > 0) {
        switch (id_campo) {
            case 'txtNome':
                if (campo.value.length < 2) {
                    exibirFeedback(campo, div_feedback, 'Nome inválido. Informe-o corretamente.')
                } else if (validarCaracteresEspeciais(campo.value)) {
                    exibirFeedback(campo, div_feedback, 'Não são permitidos caracteres especiais. Informe um nome válido.');
                    campo.value = '';
                } else {
                    limparFeedback(div_feedback);
                }

                break;
            case 'dtNasc':
                var dtNasc = new Date(campo.value)
                    , mesNasc = dtNasc.getMonth() + 1 // Dado que os meses aqui são índices, começando por 0, acrescentei +1
                    , dtAtual = new Date()
                    , mesAtual = dtAtual.getMonth() + 1
                    , idade = dtAtual.getFullYear() - dtNasc.getFullYear();
                
                if (mesAtual < mesNasc || (mesAtual === mesNasc && dtAtual.getDate() < dtNasc.getDate())) { idade--; }
                idade < 18 ? exibirFeedback(campo, div_feedback, 'É necessário ser maior de idade para realizar o cadastro.') : limparFeedback(div_feedback);

                break;
            case 'txtCPF':
                !validarCPF(campo.value) ? exibirFeedback(campo, div_feedback, 'Informe um CPF válido.') : limparFeedback(div_feedback);
                break;
            case 'txtRG':
                !validarRG(campo.value) ? exibirFeedback(campo, div_feedback, 'Informe um RG válido.') : limparFeedback(div_feedback);
                break;
            case 'txtEmail':
                !validarEmail(campo.value) ? exibirFeedback(campo, div_feedback, 'Informe um e-mail válido.') : limparFeedback(div_feedback);
                break;
            case 'txtConfirmarEmail':
                document.getElementById(id_campo).value !== document.getElementById('txtEmail').value ? exibirFeedback(campo, div_feedback, 'Este e-mail não coincide com o informado.') : limparFeedback(div_feedback);
                break;
            case 'txtSenha':
                !/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()-_+=])[A-Za-z\d!@#$%^&*()-_+=]{10,}$/.test(campo.value) ? exibirFeedback(campo, div_feedback, 'Esta senha não atende aos critérios de segurança.') : limparFeedback(div_feedback);
                break;
            case 'txtConfirmarSenha':
                document.getElementById(id_campo).value !== document.getElementById('txtSenha').value ? exibirFeedback(campo, div_feedback, 'Esta senha não coincide com a informada.') : limparFeedback(div_feedback);
                break;
        }
    }

    return;
}

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
