<?php
    session_start();
    include 'conexao.php';
    
    $id_usuario = $_SESSION['id_usuario'];

    /* * * * * * * * * * * * * * * * * * * * * * CONSULTA PARA ITENS DO CARRINHO * * * * * * * * * * * * * * * * * * * * * */
    include 'acoes_php/carrinho/selecionar_produtos.php';

    /* * * * * * * * * * * * * * * * * * * * * * CONSULTA PARA LOJAS FUTUREMOB * * * * * * * * * * * * * * * * * * * * * */
	$sql_lojas = mysql_query(
        "SELECT 
            `id_loja`
            , `nome`
            , `endereco_completo` 
        FROM 
            `lojas`"
    );	

    /* * * * * * * * * * * * * * * * * * * * * * CONSULTA PARA ENDEREÇOS DO USUÁRIO * * * * * * * * * * * * * * * * * * * * * */
	$select_enderecos = 
        "SELECT 
            `id_endereco`
            , `id_usuario`
            , `nome_endereco`
            , `cep`
            , `logradouro`
            , `numero`
            , `complemento`
            , `bairro`
            , `cidade`
            , `uf`
            , `dt_cadastro`
            , `principal` 
        FROM 
            `enderecos`
        WHERE
            `id_usuario` = $id_usuario"
    ;	    

	$sql_enderecos = mysql_query($select_enderecos . " AND `principal` = 0");
    $sql_enderecoPrincipal = mysql_query($select_enderecos . " AND `principal` = 1"); 

    $temEnderecosCadastrados = true;

    if (mysql_num_rows($sql_enderecos) == 0 && mysql_num_rows($sql_enderecoPrincipal) == 0) {
        $temEnderecosCadastrados = false;
    }

    /* * * * * * * * * * * * * * * * * * * * * * CONSULTA PARA CARTÕES DE PAGAMENTO (CRÉDITO/DÉBITO) DO USUÁRIO * * * * * * * * * * * * * * * * * * * * * */
    $select_cartoes_pagamento = 
        "SELECT 
            `id_cartao_pagamento`
            , `id_usuario`
            , `numero_cartao`
            , `nome_impresso`
            , `dt_expiracao`
            , `codigo_seguranca`
            , `bandeira`
            , `dt_cadastro`
            , `apelido`
            , `credito`
            , `debito`
            , `principal`
        FROM 
            `cartoes_pagamento`
        WHERE
            `id_usuario` = $id_usuario"
    ;

    $sql_cartoes_pagamento = mysql_query($select_cartoes_pagamento . " AND `principal` = 0");
    $sql_cartoes_pagamento_principal = mysql_query($select_cartoes_pagamento . " AND `principal` = 1"); 

    $temCartoesPagamentoCadastrados = true;

    if (mysql_num_rows($sql_cartoes_pagamento) == 0 && mysql_num_rows($sql_cartoes_pagamento_principal) == 0) {
        $temCartoesPagamentoCadastrados = false;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pagamento</title>
        <!-- ***** ESTILIZAÇÃO ***** -->
        <link rel="stylesheet" href="recursos/css/reset.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="recursos/css/geral.css" />
        <link rel="stylesheet" href="recursos/css/header.css" />
        <link rel="stylesheet" href="recursos/css/carrinho_pagamento.css" />
        <link rel="stylesheet" href="recursos/css/footer.css" />
        <!-- ***** ESTILIZAÇÃO ***** -->
        <!-- ***** PROGRAMAÇÃO ***** -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
        <script src="recursos/javascript/principal.js"></script>
        <script src="recursos/javascript/pagamento.js"></script>
        <!-- ***** PROGRAMAÇÃO ***** -->
    </head>
    <body>
        <header>
            <nav class="custom-navbar">
                <a href="pagina-inicial.php"><i class="fa-solid fa-arrow-left"></i></a>
                <span>FUTUREMOB</span>
            </nav>
        </header>
        <main class="custom-main mb-4">
            <?php if (count($itens_carrinho) > 0) { ?>
                <div class="coluna-1">
                    <!-- Endereços -->
                    <div class="info-container">
                        <div class="div-endereco_titulo">
                            <h5><i class="fa-solid fa-truck-ramp-box"></i> Endereço de Entrega</h5>
                        </div>
                        <div class="div-endereco_cep">                        
                            <div class="componente-accordion acc-entrega" id="secao-opcoes_entrega">
                                <!-- Entrega Normal -->
                                <section class="border-bottom w-100">
                                    <div onclick="document.getElementById('opcao-entrega_normal').click();" class="btn-accordion">
                                        <div>
                                            <input onclick="exibirAccordion('entrega_normal', 'secao-opcoes_entrega');" id="opcao-entrega_normal" type="radio" name="acc_opcoes-entrega"/>
                                            <i class="fa-solid fa-truck"></i>Entrega Normal 
                                        </div>
                                    </div>
                                    <div id="entrega_normal" class="container-accordion" style="display: none;">
                                        <div class="conteudo-accordion">
                                            <!-- Endereço principal -->
                                            <?php if ($temEnderecosCadastrados) {
                                                while($linha = mysql_fetch_assoc($sql_enderecoPrincipal)) { ?>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="opcao-entrega" id="rdbEndereco_principal" value="endereco_<?php echo $linha['id_endereco']; ?>">
                                                        <label class="form-check-label" for="rdbEndereco_principal">
                                                            <strong>
                                                                Endereço Principal - <?php echo $linha['nome_endereco']; ?>
                                                            </strong>
                                                            <p>
                                                                <?php echo $linha['logradouro']; ?>, <?php echo $linha['numero']; ?> - <?php echo $linha['complemento']; ?>
                                                            </p> 
                                                            <p>
                                                                <?php echo $linha['cep']; ?> - <?php echo $linha['bairro']; ?>, <?php echo $linha['cidade']; ?> - <?php echo $linha['uf']; ?>
                                                            </p> 
                                                        </label>
                                                    </div>
                                                <?php }?>                                   
                                            <?php } else { ?>
                                                <h4 class="mb-2">Você não possui endereços cadastrados.</h4>
                                                <p class="mb-3">
                                                    Cadastre um abaixo para prosseguir (por ser o seu primeiro endereço cadastrado, 
                                                    o mesmo será definido como "Endereço Principal" automaticamente. 
                                                    Você pode mudar isso nas suas configurações de perfil ou cadastrando outro endereço, marcando-o como principal).
                                                </p>
                                            <?php }?>

                                            <!-- Outras opções de endereços -->
                                            <div class="accordion" id="accordionEnderecosOpcoes">
                                                <!-- Endereços cadastrados do usuário -->
                                                <?php if ($temEnderecosCadastrados) { ?>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header">
                                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOutrosEnderecos">
                                                                <strong>Escolher outro endereço</strong>
                                                            </button>
                                                        </h2>
                                                        <?php if (mysql_num_rows($sql_enderecos) > 0) { ?>
                                                            <div id="collapseOutrosEnderecos" class="accordion-collapse collapse m-3" data-bs-parent="#accordionEnderecosOpcoes">
                                                                <?php while($linha = mysql_fetch_assoc($sql_enderecos)) { ?>
                                                                    <div class="form-check mb-3">
                                                                        <input class="form-check-input" type="radio" name="opcao-entrega" id="rdbEndereco_<?php echo $linha["id_endereco"]; ?>" value="endereco_<?php echo $linha['id_endereco']; ?>">
                                                                        <label class="form-check-label" for="rdbEndereco_<?php echo $linha["id_endereco"]; ?>">
                                                                            <strong>
                                                                                <?php echo $linha['nome_endereco']; ?>
                                                                            </strong>
                                                                            <p>
                                                                                <?php echo $linha['logradouro']; ?>, <?php echo $linha['numero']; ?> - <?php echo $linha['complemento']; ?>
                                                                            </p> 
                                                                            <p>
                                                                                <?php echo $linha['cep']; ?> - <?php echo $linha['bairro']; ?>, <?php echo $linha['cidade']; ?> - <?php echo $linha['uf']; ?>
                                                                            </p> 
                                                                        </label>
                                                                    </div>                                            
                                                                <?php }?> 
                                                            </div>
                                                        <?php } else { ?>
                                                            <div id="collapseOutrosEnderecos" class="accordion-collapse collapse m-3" data-bs-parent="#accordionEnderecosOpcoes">
                                                                <h5 class="mb-2">Você não possui outros endereços cadastrados.</h5>
                                                                <p class="mb-3">                                                            
                                                                    Cadastre um logo abaixo.
                                                                </p>                                                            
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>

                                                <!-- Cadastro de endereços -->
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCadastrarEndereco" aria-expanded="false" aria-controls="collapseTwo">
                                                            <strong>Cadastrar Endereço</strong>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseCadastrarEndereco" class="accordion-collapse collapse" data-bs-parent="#accordionEnderecosOpcoes">
                                                        <!-- Formulário -->
                                                        <form id="frmCadastrarEndereco" method="post" name="frmCadastrarEndereco" class="formulario m-3"  onsubmit="confirmarFormulario(event, 'frmCadastrarEndereco', 'acoes_php/endereco/cadastrar_endereco.php');">
                                                            <!-- Nome do Endereço -->                                   
                                                            <div class="form-floating">
                                                                <input id="txtNomeEndereco" name="txtNomeEndereco" type="text" class="form-control" placeholder="Nome do Endereço (Exemplos: Casa, Trabalho)" 
                                                                    onfocusout="validarNome('txtNomeEndereco', 'txtNomeEnderecoErro');"
                                                                    maxlength="30" required>

                                                                <label for="txtNomeEndereco">Nome do Endereço (Exemplos: Casa, Trabalho)</label>
                                                                <div id="txtNomeEnderecoErro" class="invalid-feedback">
                                                                </div>
                                                            </div>

                                                            <!-- CEP -->
                                                            <div class="form-floating mt-0">
                                                                <input id="txtCep" name="txtCep" type="text" class="form-control" placeholder="Informe o CEP"
                                                                    onfocusout="pesquisaCep('txtCep');"
                                                                    maxlength="8" required>

                                                                <label for="txtCep">CEP</label>
                                                                <a href="https://buscacepinter.correios.com.br/app/endereco/index.php" class="link-correios m-0">Não sei o meu CEP</a>
                                                                <div id="txtCepErro" class="invalid-feedback">
                                                                </div>
                                                            </div>
                                                        
                                                            <!-- Logradouro -->                                   
                                                            <div class="form-floating">
                                                                <input id="resultado-cep_logradouro" name="resultado-cep_logradouro" type="text" class="form-control" placeholder="Logradouro" 
                                                                    maxlength="50" required>

                                                                <label for="resultado-cep_logradouro">Logradouro</label>                                                         
                                                            </div>
                                                        
                                                            <!-- Número -->                                   
                                                            <div class="form-floating">
                                                                <input name="txtNumeroEndereco" type="text" class="form-control" placeholder="Número" 
                                                                    maxlength="7" required>

                                                                <label for="resultado-cep_logradouro">Número</label>
                                                                <div id="txtCepErro" class="invalid-feedback">
                                                                </div>
                                                            </div>
                                                        
                                                            <!-- Complemento -->                                   
                                                            <div class="form-floating">
                                                                <input name="txtComplemento" type="text" class="form-control" placeholder="Complemento" 
                                                                    maxlength="30" required>

                                                                <label for="txtComplemento">Complemento</label>
                                                            </div>
                                                            
                                                            <!-- Bairro -->                                   
                                                            <div class="form-floating">
                                                                <input id="resultado-cep_bairro" name="resultado-cep_bairro" type="text" class="form-control" placeholder="Bairro" 
                                                                    maxlength="30" required>

                                                                <label for="resultado-cep_bairro">Bairro</label>
                                                            </div>
                                                            
                                                            <!-- Cidade -->                                   
                                                            <div class="form-floating">
                                                                <input id="resultado-cep_cidade" name="resultado-cep_cidade" type="text" class="form-control" placeholder="Localidade" 
                                                                    maxlength="60" required>

                                                                <label for="resultado-cep_cidade">Cidade</label>
                                                            </div>
                                                            
                                                            <!-- UF -->                                   
                                                            <div class="form-floating mb-0">
                                                                <input id="resultado-cep_uf" name="resultado-cep_uf" type="text" class="form-control" placeholder="UF" 
                                                                    maxlength="2" required>

                                                                <label for="resultado-cep_uf">UF</label>
                                                            </div>

                                                            <!-- Endereço principal e botão de confirmação --> 
                                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                                <div class="form-check">
                                                                    <input name="chkEnderecoPrincipal" class="form-check-input" type="checkbox">
                                                                    <label class="form-check-label" for="chkEnderecoPrincipal">Marcar como Endereço Principal</label>
                                                                </div>
                                                                <button type="submit" class="btn btn-laranja">
                                                                    <strong>Confirmar</strong>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                    
                                </section>

                                <!-- Retirar na Loja -->
                                <section class="w-100">
                                    <div onclick="document.getElementById('opcao-entrega_retirar').click();" class="btn-accordion">
                                        <div>
                                            <input onclick="exibirAccordion('entrega_retirar', 'secao-opcoes_entrega');" id="opcao-entrega_retirar" type="radio" name="acc_opcoes-entrega"/>
                                            <i class="fa-solid fa-shop"></i>Retirar na Loja
                                        </div>
                                    </div>
                                    <div id="entrega_retirar" class="container-accordion" style="display: none;">
                                        <div class="conteudo-accordion">
                                            <?php while($linha = mysql_fetch_assoc($sql_lojas)) { ?>
                                                <div class="form-check mb-3">
                                                    <input id="rdbLoja_<?php echo $linha['id_loja']; ?>" class="form-check-input" type="radio" name="opcao-entrega" value="loja_<?php echo $linha['id_loja']; ?>">
                                                    <label class="form-check-label" for="rdbLoja_<?php echo $linha['id_loja']; ?>">
                                                        <strong>
                                                            <?php echo $linha['nome']; ?>
                                                        </strong>
                                                        <p>
                                                            <?php echo $linha['endereco_completo']; ?>
                                                        </p>
                                                    </label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>                    
                                </section>
                            </div>
                        </div>
                    </div>

                    <!-- Pagamentos -->
                    <div class="componente-accordion acc-pagamento" id="secao-formas_pagamento">
                        <!-- Pix -->
                        <section class="border-bottom w-100">
                            <div onclick="document.getElementById('forma-pagamento_pix').click();" class="btn-accordion">
                                <div>
                                    <input onclick="exibirAccordion('pix_info', 'secao-formas_pagamento');" id="forma-pagamento_pix" type="radio" name="forma-pagamento" value="pix"/>
                                    <i class="fa-brands fa-pix"></i>Pix 
                                </div>
                                <small>aprovação imediata!</small>
                            </div>
                            <div id="pix_info" class="container-accordion" style="display: none;">
                                <div class="conteudo-accordion">
                                    <div class="total-pagar_pix">
                                        <h5 class="mb-2">Total a Pagar:</h5>
                                        <h5 class="text-success"><b>R$ <span name="lblValorTotalPedido"></span></b></h5>
                                    </div>
                                    <div class="pix-instrucoes">
                                        <h5 class="mb-3">Veja como é fácil pagar com <strong style="color: #32BCAD;">pix</strong>!</h5>
                                        <ul>
                                            <li class="pix-passo">
                                                <i class="bi bi-1-circle"></i>
                                                <p>Para realizar o pagamento com Pix, clique em <strong style="color: #32BCAD;">"Finalizar pedido com Pix"</strong>.</p>
                                            </li>
                                            <li class="pix-passo_pontos"></li>
                                            <li class="pix-passo"><i class="bi bi-2-circle"></i><p>Você será redirecionado para uma nova tela com as informações de pagamento.</p></li>
                                            <li class="pix-passo_pontos"></li>
                                            <li class="pix-passo"><i class="bi bi-3-circle"></i><p>Escaneie o QR code ou copie o código para efetuar o pagamento.</p></li>
                                        </ul>
                                        <h5 class="mt-3">Pronto! Viu só como é <strong style="color: #32BCAD;">fácil</strong>?</h5>
                                    </div>
                                </div>
                            </div>                    
                        </section>

                        <!-- Cartão de Crédito/Débito -->
                        <section class="w-100">
                            <div onclick="document.getElementById('forma-pagamento_credito').click();" class="btn-accordion">
                                <div onclick="exibirAccordion('credito_info', 'secao-formas_pagamento');" id="forma-pagamento_credito">
                                    <i class="fa-solid fa-credit-card mx-0"></i>
                                    <span class="mx-1">Cartão de Crédito/Débito</span>                                                            
                                </div>
                            </div>
                            <div id="credito_info" class="container-accordion" style="display: none;">
                                <div class="conteudo-accordion">
                                    <!-- Pagamento principal -->
                                    <?php if ($temCartoesPagamentoCadastrados) {
                                        while($linha = mysql_fetch_assoc($sql_cartoes_pagamento_principal)) { ?>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio" name="forma-pagamento" id="chkPagamento_principal" value="<?php echo $linha['id_cartao_pagamento']; ?>">
                                                <label class="form-check-label" for="chkPagamento_principal">
                                                    <strong>
                                                        Cartão Principal - <?php echo $linha['apelido']; ?>
                                                    </strong>
                                                    <p>
                                                        <?php echo $linha['nome_impresso']; ?>, terminado em <?php echo $linha['numero_cartao']; ?> - <?php echo $linha['bandeira']; ?>
                                                    </p> 
                                                    <p>
                                                        Vencimento: <?php echo $linha['dt_expiracao']; ?>
                                                    </p> 
                                                </label>
                                            </div>
                                        <?php }?>
                                    <?php } else { ?>
                                        <h4 class="mb-2">Nenhum cartão foi cadastrado para pagamento.</h4>
                                        <p class="mb-3">
                                            Você pode cadastrar um cartão de crédito ou débito logo abaixo.
                                            (por ser o seu primeiro cartão cadastrado, o mesmo será definido como "Cartão Principal" automaticamente. 
                                            Você pode mudar isso nas suas configurações de perfil ou cadastrando outro cartão, marcando-o como principal).
                                        </p>
                                    <?php }?>

                                    <!-- Outras opções de Cartões para Pagamento -->
                                    <div class="accordion" id="accordionCartoesPagamentoOpcoes">
                                        <!-- Cartões cadastrados do usuário -->
                                        <?php if ($temCartoesPagamentoCadastrados) { ?>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOutrosPagamentos">
                                                        <strong>Escolher outro cartão</strong>
                                                    </button>
                                                </h2>
                                                <?php if (mysql_num_rows($sql_cartoes_pagamento) > 0) { ?>
                                                    <div id="collapseOutrosPagamentos" class="accordion-collapse collapse m-3" data-bs-parent="#accordionCartoesPagamentoOpcoes">
                                                        <?php while($linha = mysql_fetch_assoc($sql_cartoes_pagamento)) { ?>
                                                            <div class="form-check mb-3">
                                                                <input class="form-check-input" type="radio" name="forma-pagamento" id="chkPagamento_<?php echo $linha["id_cartao_pagamento"]; ?>" value="<?php echo $linha['id_cartao_pagamento']; ?>">
                                                                <label class="form-check-label" for="chkPagamento_<?php echo $linha["id_cartao_pagamento"]; ?>">
                                                                    <strong>
                                                                        <?php echo $linha['apelido']; ?>
                                                                    </strong>
                                                                    <p>
                                                                        <?php echo $linha['nome_impresso']; ?>, terminado em <?php echo $linha['numero_cartao']; ?> - <?php echo $linha['bandeira']; ?>
                                                                    </p> 
                                                                    <p>
                                                                        Vencimento: <?php echo $linha['dt_expiracao']; ?>
                                                                    </p> 
                                                                </label>
                                                            </div>                                            
                                                        <?php }?> 
                                                    </div>
                                                <?php } else { ?>
                                                    <div id="collapseOutrosPagamentos" class="accordion-collapse collapse m-3" data-bs-parent="#accordionCartoesPagamentoOpcoes">
                                                        <h5 class="mb-2">Você não possui outros cartões cadastrados.</h5>
                                                        <p class="mb-3">                                                            
                                                            Cadastre um logo abaixo.
                                                        </p>                                                            
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>

                                        <!-- Cadastro de Cartão para Pagamento -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCadastrarCartaoPagamento">
                                                    <strong>Cadastrar Cartão de Crédito/Débito</strong>
                                                </button>
                                            </h2>
                                            <div id="collapseCadastrarCartaoPagamento" class="accordion-collapse collapse" data-bs-parent="#accordionCartoesPagamentoOpcoes">
                                                <!-- Formulário -->
                                                <form id="frmCadastrarCartaoPagamento" name="frmCadastrarCartaoPagamento" class="formulario m-3" method="post" onsubmit="confirmarFormulario(event, 'frmCadastrarCartaoPagamento', 'acoes_php/pagamento/cadastrar_cartao.php');">
                                                    <!-- Apelido -->
                                                    <div class="form-floating">
                                                        <input id="txtApelidoCartao" name="txtApelidoCartao" type="text" class="form-control" 
                                                            onfocusout="validarNome('txtApelidoCartao', 'txtApelidoCartaoErro');"
                                                            placeholder="Apelido (exemplo: Cartão Pessoal, Cartão Corporativo)" 
                                                            maxlength="30" required>

                                                        <label for="txtApelidoCartao">Apelido (exemplo: Cartão Pessoal, Cartão Corporativo)</label>
                                                        <div id="txtApelidoCartaoErro" class="invalid-feedback">
                                                        </div>
                                                    </div>                                                    

                                                    <!-- Número do Cartão -->
                                                    <div class="form-floating mt-0">
                                                        <input id="txtNumeroCartao" name="txtNumeroCartao" 
                                                            oninput="aplicarMascaraNumeroCartao(this);"  type="text" maxlength="19" class="form-control" placeholder="Número do Cartão" required>

                                                        <label for="txtNumeroCartao">Número do Cartão <small style="color: rgb(184, 184, 184);">(0000 0000 0000 0000)</small></label>
                                                        <div id="txtNumeroCartaoErro" class="invalid-feedback">
                                                        </div>
                                                    </div>

                                                    <!-- Nome Impresso no Cartão -->
                                                    <div class="form-floating">
                                                        <input id="txtNomeImpressoCartao" name="txtNomeImpressoCartao" 
                                                            onfocusout="validarNome('txtNomeImpressoCartao', 'txtNomeImpressoCartaoErro');"
                                                            oninput="this.value = this.value.toUpperCase();"
                                                            type="text" class="form-control" placeholder="Nome Impresso no Cartão" 
                                                            maxlength="20" required>

                                                        <label for="txtNomeImpressoCartao">Nome Impresso no Cartão</label>
                                                        <div id="txtNomeImpressoCartaoErro" class="invalid-feedback">
                                                        </div>
                                                    </div>

                                                    <!-- Data de Expiração -->                                                
                                                    <div class="form-floating">
                                                        <input id="txtExpiracaoCartao" name="txtExpiracaoCartao"
                                                            onfocusout="validarDataExpiracao('txtExpiracaoCartao', 'txtExpiracaoCartaoErro');" 
                                                            oninput="aplicarMascaraValidadeCartao(this);"type="text" maxlength="7" class="form-control" placeholder="Validade (MM/AAAA)" required>

                                                        <label for="txtExpiracaoCartao">Data de Expiração<small style="color: rgb(184, 184, 184);">(MM/AAAA)</small></label>
                                                        <div id="txtExpiracaoCartaoErro" class="invalid-feedback">
                                                        </div>
                                                    </div>

                                                    <!-- Código de Segurança -->                                                
                                                    <div class="form-floating">
                                                        <input id="txtCodigoSegurancaCartao" name="txtCodigoSegurancaCartao" 
                                                            oninput="aplicarMascaraCodigoSeguranca(this);" type="text" maxlength="3" class="form-control" placeholder="Código de Segurança" autocomplete="off" required>

                                                        <label for="txtCodigoSegurancaCartao">Código de Segurança</label>
                                                    </div>

                                                    <!-- Crédito ou Débito, Cartão Principal -->
                                                    <div class="d-flex align-items-start justify-content-between m-0">
                                                        <!-- Crédito ou Débito -->
                                                        <div>
                                                            <div class="form-check d-flex align-items-center">
                                                                <input id="rdbCredito" class="form-check-input" type="radio" value="credito" name="rdbCreditoDebito">
                                                                <label class="form-check-label mx-2" for="rdbCredito">Crédito</label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center">
                                                                <input id="rdbDebito" class="form-check-input" type="radio" value="debito" name="rdbCreditoDebito" checked>
                                                                <label class="form-check-label mx-2" for="rdbDebito">Débito</label>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Cartão Principal --> 
                                                        <div class="form-check">
                                                            <input name="chkCartaoPagamentoPrincipal" class="form-check-input" type="checkbox">
                                                            <label class="form-check-label" for="chkCartaoPagamentoPrincipal">Marcar como Cartão Principal</label>
                                                        </div>
                                                    </div>       

                                                    <div class="div-finalizar">
                                                        <div class="bandeiras_pagamento">
                                                            <img src="recursos/imagens/logos/bandeiras_pagamento/visa.svg" alt="visa" />
                                                            <img src="recursos/imagens/logos/bandeiras_pagamento/mastercard.svg" alt="mastercard" />
                                                            <img src="recursos/imagens/logos/bandeiras_pagamento/american-express.svg" alt="american-express" />
                                                            <img src="recursos/imagens/logos/bandeiras_pagamento/hipercard.svg" alt="hipercard" />
                                                        </div>
                                                        <button type="submit" class="btn btn-cartao">
                                                            <strong>Confirmar</strong>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if ($temCartoesPagamentoCadastrados) { ?>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <div class="d-flex justify-content-between align-items-center"> 
                                                <!-- Quantidade de parcelas -->
                                                <div class="form-floating">
                                                    <select id="cboParcelas" name="cboParcelas" class="form-select">
                                                    </select>
                                                    <label for="cboParcelas">Quantidade de parcelas</label>
                                                </div>

                                                <!-- Crédito ou Débito -->
                                                <div class="mx-3">
                                                    <div class="form-check d-flex align-items-center">
                                                        <input id="rdbCredito" class="form-check-input" type="radio" name="credito_debito" value="credito">
                                                        <label class="form-check-label mx-2" for="rdbCredito">Crédito</label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center">
                                                        <input id="rdbDebito" class="form-check-input" type="radio" name="credito_debito" value="debito">
                                                        <label class="form-check-label mx-2" for="rdbDebito">Débito</label>
                                                    </div>
                                                </div>                                           
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>    
                        </section>
                    </div>
                </div>

                <!-- Resumo e finalização do pedido -->
                <div class="coluna-2">
                    <form name="frmFinalizarPedido" id="frmFinalizarPedido" method="post" onsubmit="finalizarPedido(event);" class="info-container">      
                        <input type="hidden" id="txtValorSubTotalPedido" name="txtValorSubTotalPedido" value="">
                        <input type="hidden" id="txtValorFrete" name="txtValorFrete" value="">
                        <input type="hidden" id="txtValorDesconto" name="txtValorDesconto" value="">
                        <input type="hidden" id="txtValorTotalPedido" name="txtValorTotalPedido" value="">
                        <input type="hidden" id="txtCreditoDebito" name="txtCreditoDebito" value="">
                        <input type="hidden" id="txtFormaPagamento" name="txtFormaPagamento" value="">
                        <input type="hidden" id="txtParcelas" name="txtParcelas" value="">
                        <input type="hidden" id="txtOpcaoEntrega" name="txtOpcaoEntrega" value="">

                        <h5 class="div-valor_titulo"><i class="fa-solid fa-bag-shopping"></i> Resumo do Pedido</h5>
                        <div class="div-valor_info resumo-pedido">
                            <p>Subtotal:</p>
                            <p>R$ <span id="lblValorSubTotalPedido"></span></p>
                        </div>
                        <div class="div-valor_info resumo-pedido">
                            <p>Total de frete:</p>
                            <p>R$ <span id="lblValorFrete">9,99</span></p>
                        </div>
                        <div class="div-valor_info resumo-pedido">
                            <p class="text-success"><b>Total de descontos:</b></p>
                            <p class="text-success"><b>R$ <span id="lblValorDesconto">0,00</span></b></p>
                        </div>
                        <div class="div-valor_info resumo-pedido">
                            <h4>Total a pagar:</h4>
                            <h4 class="text-success">R$ <span id="lblValorTotalPedido" name="lblValorTotalPedido"></span></h4>
                        </div>
                        <div class="d-flex"> 
                            <a href="listagem-geral-produtos.php" class="btn btn-resumoPedido btn-escolherMaisProdutos">Escolher mais produtos</a>                         
                            <button type="submit" class="btn btn-resumoPedido btn-finalizar">Finalizar Pedido</button> 
                        </div>
                    </form>
                    <?php foreach ($itens_carrinho as $item): ?>
                        <div class="info-container p-3">
                            <div class="div-produto_info">
                                <a href="detalhes-produto.php?id_produto=<?php echo $item['id_produto']; ?>" class="div-produto_info_img"><img src="<?php echo $item['caminho_imagem']; ?>" /></a>
                                <div class="mb-2">
                                    <h5 class="mb-1"><?php echo $item['nome']; ?></h5>
                                    <!-- <div class="avaliacao-estrelas mb-2">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <b>(4.9)</b>
                                    </div> -->
                                    <p>
                                        <s class="text-muted">De: R$ <?php echo number_format($item['preco_anterior'], 2, ',', '.'); ?></s><br>
                                        <b>Por: R$ <span name="lblValorProduto"><?php echo number_format($item['preco_atual'], 2, ',', '.'); ?></span></b>
                                    </p>
                                    <p><b>à vista com pix, ou em 1x no Cartão de Crédito</b></p>
                                    <p>ou em até 10x de <?php echo number_format($item['preco_atual'] / 10, 2, ',', '.'); ?> s/ juros</p>
                                </div>
                            </div>
                            <div class="div-produto_opcoes">
                                <span class="text-muted mt-2"><span name="lblQtdProduto">1</span> item(ns)</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php } else { ?>
                <div class="aviso-ausencia-produtos">
                    <i class="fa-solid fa-cart-shopping" style="font-size: 4rem;"></i>
                    <h3>Poxa, não tem nada aqui para realizar um pedido.</h3>
                    <h5>Que tal escolher alguns de nossos produtos?</h5>
                    <a href="listagem-geral-produtos.php" class="btn btn-gradiente mt-2">Ver produtos</a>
                </div>
            <?php } ?>
        </main>
    </body>
</html>