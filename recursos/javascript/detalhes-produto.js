function adicionarAoCarrinho() {
    notificar(false, 'Produto adicionado!', '', 'success', '');

    var contador;
    var quantidade = parseInt(document.getElementById('qtdProd2').innerHTML);
    if (quantidade > 1) {
        contador = parseInt(document.getElementById('contador-carrinho').innerHTML) + quantidade;
    } else {
        contador = parseInt(document.getElementById('contador-carrinho').innerHTML) + 1;
    }

    document.getElementById('contador-carrinho').innerHTML = contador;
}

function indisponivel() {
    var grupoBotoes = document.getElementById('grpBtnAcoes');
    var btnIndisponivel = document.getElementById('btnAviseMe');
    var quantidade = document.getElementById('div-qtd');

    quantidade.style.display = 'none';
    grupoBotoes.style.display = 'none';
    btnIndisponivel.style.display = 'block';
}

function disponivel() {
    var grupoBotoes = document.getElementById('grpBtnAcoes');
    var btnIndisponivel = document.getElementById('btnAviseMe');
    var quantidade = document.getElementById('div-qtd');

    quantidade.style.display = 'block';
    grupoBotoes.style.display = 'flex';
    btnIndisponivel.style.display = 'none';
}

function avisarQuandoChegar() {
    popupSwal.fire({ 
        title: `Em qual e-mail você deseja ser notificado?`
        , icon: 'question'
        , html: `
        <div class="form-floating">
            <input id="txtEmailAviso" type="email" class="form-control" placeholder="Email" required>
            <label for="txtEmailAviso">Email</label>
        </div>`
        , showCancelButton: true
        , confirmButtonText: "OK"
        , cancelButtonText: "Cancelar"
        , reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            var email = document.getElementById('txtEmailAviso').value;
            if (email) {
                notificar(true, "Obrigado!", "Iremos enviar um e-mail assim que este produto estiver disponível.", "success", '');
            } else {
                popupSwal.fire({ 
                    title: "Por favor, informe um e-mail para ser notificado."
                    , icon: "warning"
                    , confirmButtonText: "OK"
                }).then(() => {
                    avisarQuandoChegar();
                });
            }        
        }
    });
}