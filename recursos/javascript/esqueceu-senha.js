function enviarCodigoRecuperacao(e) {
    e.preventDefault();

    var txtEmail = document.getElementById('txtEmailLogin').value;

    switch (txtEmail) {
        case 'hector.silva5@fatec.sp.gov.br':
            notificar(true, 'Enviamos o link para o e-mail informado!', 'Ao acessar o link, você será redirecionado para uma página onde poderá redefinir a sua senha.', 'success', 'login.html');
            break;
        case 'diogo.martins5@fatec.sp.gov.br':
            notificar(true, 'Enviamos o link para o e-mail informado!', 'Ao acessar o link, você será redirecionado para uma página onde poderá redefinir a sua senha.', 'success', 'login.html');
            break;
        case 'eduardo.urbano@fatec.sp.gov.br':
            notificar(true, 'Enviamos o link para o e-mail informado!', 'Ao acessar o link, você será redirecionado para uma página onde poderá redefinir a sua senha.', 'success', 'login.html');
            break;
        case 'ellen.oliveira12@fatec.sp.gov.br':
            notificar(true, 'Enviamos o link para o e-mail informado!', 'Ao acessar o link, você será redirecionado para uma página onde poderá redefinir a sua senha.', 'success', 'login.html');
            break;
        case 'enzo.silva9@fatec.sp.gov.br':
            notificar(true, 'Enviamos o link para o e-mail informado!', 'Ao acessar o link, você será redirecionado para uma página onde poderá redefinir a sua senha.', 'success', 'login.html');
            break;
        case 'joao.garcia27@fatec.sp.gov.br':
            notificar(true, 'Enviamos o link para o e-mail informado!', 'Ao acessar o link, você será redirecionado para uma página onde poderá redefinir a sua senha.', 'success', 'login.html');
            break;
        // Professores
        case 'humberto.toledo01@fatec.sp.gov.br':
            notificar(true, 'Enviamos o link para o e-mail informado!', 'Ao acessar o link, você será redirecionado para uma página onde poderá redefinir a sua senha.', 'success', 'login.html');
            break;
        case 'joao.souza73@fatec.sp.gov.br':
            notificar(true, 'Enviamos o link para o e-mail informado!', 'Ao acessar o link, você será redirecionado para uma página onde poderá redefinir a sua senha.', 'success', 'login.html');
            break;
        case 'rennan.araujo01@fatec.sp.gov.br':
            notificar(true, 'Enviamos o link para o e-mail informado!', 'Ao acessar o link, você será redirecionado para uma página onde poderá redefinir a sua senha.', 'success', 'login.html');
            break;
        default:
            notificar(false, 'Usuário não encontrado', '', 'error', '');
    }
}