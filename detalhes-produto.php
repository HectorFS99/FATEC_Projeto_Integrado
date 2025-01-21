<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include 'head.php'; ?>
        <link rel="stylesheet" href="recursos/css/detalhes-produto.css" />
        <script src="recursos/javascript/detalhes-produto.js"></script>
		<title>Detalhes</title>
    </head>
    <body>
        <?php include 'header.php'; ?>

        <?php 
            if (isset($_GET['id_produto'])) {
                $id_produto = $_GET['id_produto'];

            $select_produtos = "
                SELECT 
                    `id_produto`,
                    `nome`,
                    `descricao`,
                    `preco_anterior`,
                    `preco_atual`,
                    `altura`,
                    `largura`,
                    `profundidade`,
                    `peso`,
                    `id_categoria`,
                    `caminho_imagem`
                FROM 
                    `produtos`
                WHERE 
                    `id_produto` = '$id_produto'
            ";

            $resultado = mysql_query($select_produtos);
            

            if ($produto = mysql_fetch_assoc($resultado)) {
            } else {
                echo "Produto não encontrado.";
            }
        } else {
            echo "ID do produto não fornecido.";
        }
?>
            <?php 
            if (isset($_GET['id_produto'])) {
                $id_produto = $_GET['id_produto'];

            $select_avaliacoes = "
                SELECT 
                    `id_produto`,
                    `id_usuario`,
                    `avaliacao`,
                    `dt_avaliacao`,
                    `titulo`,
                    `descricao`,
                    `imagem`,
                    `verificado`
                    
                FROM 
                    `avaliacoes`
                WHERE 
                    `id_produto` = '$id_produto'
            ";

            $resultado2 = mysql_query($select_avaliacoes);
            

            if ($avaliacao = mysql_fetch_assoc($resultado2)) {
            } 
            else {
            }
        } else {
            
        }

            
            if (isset($avaliacao['id_usuario'])) {
                $id_usuario = $avaliacao['id_usuario'];

                $select_nome = "
                SELECT 
                    `nome_completo`
                    
                FROM 
                    `usuarios`
                WHERE 
                    `id_usuario` = '$id_usuario'
            ";

            $resultado3 = mysql_query($select_nome);
            

            if ($nome = mysql_fetch_assoc($resultado3)) {
            } else {
                echo "Usuario não encontrado.";
            }
        } else {
            
        }


?>        



        <main class="main-detalhes">
            <div class="detalhes">
                <div class="detalhes-midias">
                    <img src="<?php echo $produto['caminho_imagem']; ?>" class="produto_img" />
                    <div class="detalhes-midias_outras_fotos">
                        <img src="<?php echo $produto['caminho_imagem']; ?>" />
                    </div>
                </div>

                <div class="detalhes-conteudo">
                    <a href="pagina-inicial.php" class="btn btn-sm btn-laranja mb-2"><b><i class="fa-solid fa-arrow-left"></i> Voltar</b></a>
                    <h3><?php echo $produto['nome']; ?></h3>

                        <div class="avaliacao-estrelas">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <b>(4.9)</b>
                        </div>
                        <p>
                            <s class="text-muted">R$<?php echo number_format($produto['preco_anterior'], 2, ',', '.'); ?></s><br>
                            <b>Por: R$ <span style="font-size: 1.5rem;"><?php echo number_format($produto['preco_atual'], 2, ',', '.'); ?></span></b>
                        </p>
                        <p class="text-success">
                            <b>à vista com pix, ou em 1x no Cartão de Crédito</b>
                        </p>
                        <hr />
                        <p> ou em até 10x de R$ <?php echo number_format($produto['preco_atual'] / 10, 2, ',', '.'); ?> s/ juros </p>
                        <div id="div-qtd" class="my-2" style="max-width: 227px;">
                            <div class="input-group input-group-sm" style="background: rgba(128, 128, 128, 0.2); border-radius: 0.25rem;">
                                <span class="input-group-text" id="basic-addon3"><b>Quantidade</b></span>
                                <button onclick="subtrairQtd('qtdProd2', 'lblValorProduto', 'lblQtdProduto', 'lblValorSubTotalPedido');" class="btn btn-dark btn-sm"><i class="fa-solid fa-minus"></i></button>
                                <span id="qtdProd2" name="lblQtdProduto" class="mx-3" style="width: 41px;">1</span>                    
                                <button onclick="adicionarQtd('qtdProd2','lblValorProduto', 'lblQtdProduto', 'lblValorSubTotalPedido');" class="btn btn-dark btn-sm"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="detalhes-conteudo_botoes" id="grpBtnAcoes">
                            <a href="pagamento.php" class="btn btn-lg btn-success"><strong>COMPRAR</strong></a>
                            <a href="./acoes_php/carrinho/adicionar_produto.php?id_produto=<?= $id_produto ?>" class="btn btn-lg btn-laranja"><strong><i class="fa-solid fa-cart-plus"></i> ADICIONAR AO CARRINHO</strong></a>
                        </div>
                        <div id="btnAviseMe" style="display: none;">
                            <button onclick="avisarQuandoChegar();" class="btn btn-lg btn-danger w-100"><strong><i class="fa-solid fa-bell"></i> Avise-me quando chegar</strong></button>
                        </div>
                        <div class="frete">
                            <h6>Calcular frete e prazo</h6>
                            <div class="frete-input">
                                <div class="input-group" style="max-width: 250px;">
                                    <input id="txtCep" type="text" class="form-control" placeholder="Informe o CEP">
                                    <button onclick="pesquisaCep('txtCep');" class="btn btn-laranja"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                                <a href="https://buscacepinter.correios.com.br/app/endereco/index.php" class="link-correios">Não sei o meu CEP</a>
                            </div>
                            <div id="resultado-frete" style="display: none;">  
                                <span id="resultado-cep_logradouro"></span> - <span id="resultado-cep_bairro"></span><br>
                                <small id="resultado-cep_cidade"></small> - <small id="resultado-cep_uf"></small>
                            </div>
                        </div>
                </div>
            </div>
            <div class="detalhes">
                <div class="detalhes-dimensoes">
                    <h3 class="">
                        <i class="bi bi-bounding-box-circles"></i> Dimensões </h3>
                    <div class="detalhes-dimensoes_valores">
                        <div>
                            <i class="fa-solid fa-up-down"></i> Altura: <?php echo $produto['altura']; ?> </div>
                        <div>
                            <i class="bi bi-box-fill"></i> Profundidade: <?php echo $produto['profundidade']; ?> </div>
                        <div>
                            <i class="fa-solid fa-left-right"></i> Largura: <?php echo $produto['largura']; ?> </div>
                        <div>
                            <i class="fa-solid fa-weight-hanging"></i> Peso: <?php echo $produto['peso']; ?> </div>
                    </div>
                </div>
                <div class="detalhes-descricao">
                    <h3>
                        <i class="bi bi-justify-left"></i> Descrição </h3>
                    <p class="detalhes-descricao_texto"> <?php echo $produto['descricao']; ?> </p>
                </div>
            </div>
            <hr class="m-3">
            <div class="detalhes">
                <div class="detalhes-avaliacoes">
                                    <!-- FORMULARIO AVALIAÇÃO -->
                                    <div class="avaliacao-usuario">
                <div class="avaliacao-usuario_cabecalho">
                    <div class="avaliacao-usuario_info">
                        <img src="recursos/imagens/usuarios/user_sample.png">
                        <div>
                            <h6 class="m-0">Você</h6>
                            <b><small class="text-success"><i class="fa-solid fa-circle-check"></i> Avalie este produto.</small></b>
                        </div>
                    </div>
                </div>
                <div class="avaliacao-usuario_corpo">
                    <form action="salvar_avaliacao.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>"> <!-- ID do usuário autenticado -->
                        <input type="hidden" name="id_produto" value="<?php echo $id_produto; ?>"> <!-- Produto sendo avaliado -->

                        <div class="avaliacao-estrelas mb-2">
                                        <label for="avaliacao" class="form-label"><b>Nota:</b></label>
                                        <select name="avaliacao" id="avaliacao" required>
                                            <option value="5">5 estrelas</option>
                                            <option value="4">4 estrelas</option>
                                            <option value="3">3 estrelas</option>
                                            <option value="2">2 estrelas</option>
                                            <option value="1">1 estrela</option>
                                        </select>
                                    </div>

                        <label for="titulo"><b>Título:</b></label>
                        <input type="text" id="titulo" name="titulo" maxlength="50" required class="form-control mb-2"
                            value="<?php echo isset($titulo) ? $titulo : ''; ?>">

                        <label for="descricao"><b>Descrição:</b></label>
                        <textarea id="descricao" name="descricao" maxlength="1000" required class="form-control mb-2"><?php echo isset($descricao) ? $descricao : ''; ?></textarea>

                       

                        <button type="submit" class="btn btn-lg btn-success mt-3">Enviar Avaliação</button>
                    </form>
                </div>
            </div>

                    <div class="detalhes-avaliacoes_titulo">
                        <h3 class="mb-0">Avaliações</h3>
                        <div class="avaliacao-estrelas">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <b>(4.9)</b>
                        </div>
                    </div>
                            <!--  VERIFICA SE HÁ AVALIAÇÕES -->
                    <?php
                    if ($avaliacao == true) {
                    ?> <div class="avaliacao-usuario">
                        <div class="avaliacao-usuario_cabecalho">
                            <div class="avaliacao-usuario_info">
                                <img src="recursos/imagens/usuarios/user_sample.png">
                                <div>
                                    <h6 class="m-0"><?php echo $nome["nome_completo"]; ?></h6>
                                    <?php 
                    
                                        if ($avaliacao["verificado"] == 1) {
                                            echo '<b><small class="text-success"><i class="fa-solid fa-circle-check"></i> Verificado(a)</small></b>';
                                        } else {
                                            echo '<b><small class="text-danger"><i class="fa-solid fa-circle-xmark"></i> Não verificado</small></b>';
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="d-flex flex-column m-4">
                            <div class="avaliacao-estrelas">
                                <?php
                                
                                $nota = (int) $avaliacao["avaliacao"];

                                
                                for ($i = 0; $i < $nota; $i++) {
                                    echo '<i class="fa-solid fa-star"></i>';
                                }

                                for ($i = $nota; $i < 5; $i++) {
                                    echo '<i class="fa-regular fa-star"></i>';
                                }
                                ?>
                            </div>
                                <small class="text-end">
                                
                                </small>

                            </div>
                        </div>
                        <div class="avaliacao-usuario_corpo">
                            <p><b><?php echo $avaliacao["titulo"]; ?></b></p>
                            <p> <?php echo $avaliacao["descricao"]; ?> </p>
                            <img src="<?php echo $produto["caminho_imagem"]; ?>" class="avaliacao-usuario_corpo_imagem" />
                        </div>
                        <div class="avaliacao-usuario_rodape">
                            <small> Essa avaliação foi útil? <i class="fa-regular fa-thumbs-up"></i>68 <i class="fa-regular fa-thumbs-down"></i>12 </small>
                        </div>
                    </div>
                
            <?php
            } else {
                echo "Ainda não há avaliações, seja o primeiro a avaliar!";
            }?>
                    
                    <div class="avaliacao-usuario">
                        <div class="avaliacao-usuario_cabecalho">
                            <div class="avaliacao-usuario_info">
                                <img src="recursos/imagens/usuarios/user_sample.png">
                                <div>
                                    <h6 class="m-0">Catarina M.</h6>
                                    <b><small class="text-success"><i class="fa-solid fa-circle-check"></i> Verificado(a).</small></b>
                                </div>
                            </div>
                            <div class="d-flex flex-column m-4">
                                <div class="avaliacao-estrelas">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <small class="text-end">04/06/2024</small>
                            </div>
                        </div>
                        <div class="avaliacao-usuario_corpo">
                            <p><b>Ótimo produto!</b></p>
                            <p> Material de qualidade e um estilo muito futurista! </p>
                            <img class="avaliacao-usuario_corpo_imagem" src="recursos/imagens/produtos/quarto-cama_couro_veludo.jpg">
                        </div>
                        <div class="avaliacao-usuario_rodape">
                            <small> Essa avaliação foi útil? <i class="fa-regular fa-thumbs-up"></i>68 <i class="fa-regular fa-thumbs-down"></i>12 </small>
                        </div>
                    </div>
                    <div class="avaliacao-usuario">
                        <div class="avaliacao-usuario_cabecalho">
                            <div class="avaliacao-usuario_info">
                                <img src="recursos/imagens/usuarios/user_sample.png">
                                <div>
                                    <h6 class="m-0">Catarina M.</h6>
                                    <b><small class="text-success"><i class="fa-solid fa-circle-check"></i> Verificado(a).</small></b>
                                </div>
                            </div>
                            <div class="d-flex flex-column m-4">
                                <div class="avaliacao-estrelas">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <small class="text-end">04/06/2024</small>
                            </div>
                        </div>
                        <div class="avaliacao-usuario_corpo">
                            <p><b>Ótimo produto!</b></p>
                            <p> Material de qualidade e um estilo muito futurista! </p>
                            <img class="avaliacao-usuario_corpo_imagem" src="recursos/imagens/produtos/quarto-cama_couro_veludo.jpg">
                        </div>
                        <div class="avaliacao-usuario_rodape">
                            <small> Essa avaliação foi útil? <i class="fa-regular fa-thumbs-up"></i>68 <i class="fa-regular fa-thumbs-down"></i>12 </small>
                        </div>
                    </div>
                    <div class="avaliacao-usuario">
                        <div class="avaliacao-usuario_cabecalho">
                            <div class="avaliacao-usuario_info">
                                <img src="recursos/imagens/usuarios/user_sample.png">
                                <div>
                                    <h6 class="m-0">Catarina M.</h6>
                                    <b><small class="text-success"><i class="fa-solid fa-circle-check"></i> Verificado(a).</small></b>
                                </div>
                            </div>
                            <div class="d-flex flex-column m-4">
                                <div class="avaliacao-estrelas">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <small class="text-end">04/06/2024</small>
                            </div>
                        </div>
                        <div class="avaliacao-usuario_corpo">
                            <p><b>Ótimo produto!</b></p>
                            <p> Material de qualidade e um estilo muito futurista! </p>
                            <img class="avaliacao-usuario_corpo_imagem" src="recursos/imagens/produtos/quarto-cama_couro_veludo.jpg">
                        </div>
                        <div class="avaliacao-usuario_rodape">
                            <small> Essa avaliação foi útil? <i class="fa-regular fa-thumbs-up"></i>68 <i class="fa-regular fa-thumbs-down"></i>12 </small>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer id="footer"></footer>
    </body>
</html>



