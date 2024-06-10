function logar(e) {
    e.preventDefault();
    
    var txtEmail = document.getElementById('txtEmailLogin').value;
    var txtSenha = document.getElementById('txtSenhaLogin').value;

    switch (txtEmail) {
        case 'hector.silva5@fatec.sp.gov.br':
            txtSenha === 'hector.silva5' ? window.location.href = 'perfil-usuario.html' : notificar(false, 'E-mail ou senha incorretos.', 'Verifique as suas credenciais e tente novamente.', 'error', '');
            break;
        case 'diogo.martins5@fatec.sp.gov.br':
            txtSenha === 'diogo.martins5' ? window.location.href = 'perfil-usuario.html' : notificar(false, 'E-mail ou senha incorretos.', 'Verifique as suas credenciais e tente novamente.', 'error', '');
            break;
        case 'eduardo.urbano@fatec.sp.gov.br':
            txtSenha === 'eduardo.urbano' ? window.location.href = 'perfil-usuario.html' : notificar(false, 'E-mail ou senha incorretos.', 'Verifique as suas credenciais e tente novamente.', 'error', '');
            break;
        case 'ellen.oliveira12@fatec.sp.gov.br':
            txtSenha === 'ellen.oliveira12' ? window.location.href = 'perfil-usuario.html' : notificar(false, 'E-mail ou senha incorretos.', 'Verifique as suas credenciais e tente novamente.', 'error', '');
            break;
        case 'enzo.silva9@fatec.sp.gov.br':
            txtSenha === 'enzo.silva9' ? window.location.href = 'perfil-usuario.html' : notificar(false, 'E-mail ou senha incorretos.', 'Verifique as suas credenciais e tente novamente.', 'error', '');
            break;
        case 'joao.garcia27@fatec.sp.gov.br':
            txtSenha === 'joao.garcia27' ? window.location.href = 'perfil-usuario.html' : notificar(false, 'E-mail ou senha incorretos.', 'Verifique as suas credenciais e tente novamente.', 'error', '');
            break;
        // Professores
        case 'humberto.toledo01@fatec.sp.gov.br':
            txtSenha === 'humberto.toledo01' ? window.location.href = 'perfil-usuario.html' : notificar(false, 'E-mail ou senha incorretos.', 'Verifique as suas credenciais e tente novamente.', 'error', '');
            break;
        case 'joao.souza73@fatec.sp.gov.br':
            txtSenha === 'joao.souza73' ? window.location.href = 'perfil-usuario.html' : notificar(false, 'E-mail ou senha incorretos.', 'Verifique as suas credenciais e tente novamente.', 'error', '');
            break;
        case 'rennan.araujo01@fatec.sp.gov.br':
            txtSenha === 'rennan.araujo01' ? window.location.href = 'perfil-usuario.html' : notificar(false, 'E-mail ou senha incorretos.', 'Verifique as suas credenciais e tente novamente.', 'error', '');
            break;
        default:
            notificar(false, 'Usuário não cadastrado.', 'Cadastre-se e ganhe desconto de até 30% na primeira compra!', 'error', '');
    }
}