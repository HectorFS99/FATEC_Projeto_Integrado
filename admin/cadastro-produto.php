<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include '/componentes/adm_head.php'; ?>
        <title>Cadastrar Produtos</title>
    </head>
    <body>
        <?php include '/componentes/adm_header.php'; ?>
        <main class="conteudo-principal">
            <div class="titulo-opcoes">
                <h3 class="titulo">
                    <a href="adm_produtos.php" class="btn-voltar"><i class="fa-solid fa-arrow-left"></i></a>
                    Adicionar Produto
                </h3>
            </div>
            <form method="POST" name="form_cad_produtos" class="formulario w-100">
                <!-- Nome, preço anterior e preço atual -->
                <div class="formulario-grupo">
                    <div class="form-floating">
                        <input name="txt_nome" type="text" required class="form-control" placeholder="Nome completo">
                        <label for="txt_nome">Nome:</label>
                    </div>
                    <div class="form-floating">
                        <input name="txt_precoAnt" type="text" required class="form-control" placeholder="Nome completo">
                        <label for="txt_precoAnt">Preço anterior:</label>
                    </div>
                    <div class="form-floating">
                        <input name="txt_precoAtual" type="text" required class="form-control" placeholder="Nome completo">
                        <label for="txt_precoAtual">Preço atual:</label>
                    </div>
                </div>

                <!-- Altura, largura, profundidade e peso -->
                <div class="formulario-grupo">
                    <div class="form-floating">
                        <input name="txt_altura" type="text" required class="form-control" placeholder="Nome completo">
                        <label for="txt_altura"> Altura (cm):</label>
                    </div>
                    <div class="form-floating">
                        <input name="txt_largura" type="text" required class="form-control" placeholder="Nome completo">
                        <label for="txt_largura">Largura (cm):</label>
                    </div>
                    <div class="form-floating">
                        <input name="txt_profundidade" type="text" required class="form-control" placeholder="Nome completo">
                        <label for="txt_profundidade">Profundidade (cm):</label>
                    </div>
                    <div class="form-floating">
                        <input name="txt_peso" type="text" required class="form-control" placeholder="Nome completo">
                        <label for="txt_peso">Peso (kg):</label>
                    </div>
                </div>

                <!-- Descrição -->
                <div class="form-floating">
                    <textarea name="txt_descricao" required class="form-control" rows="6" placeholder="Nome completo"></textarea>
                    <label for="txt_descricao">Descrição:</label>
                </div>

                <!-- Categoria, destaque, oferta relâmpago e ativo/desativo -->
                <div class="formulario-grupo">
                    <div class="form-floating">
                        <select name="cbo_categoria" id="" class="form-select">
                            <option></option>
                            <option value="1">Escritório</option>
                            <option value="2">Quarto</option>
                            <option value="3">Cozinha</option>
                            <option value="4">Sala de Jantar</option>
                            <option value="5">Área Externa</option>
                            <option value="6">Sala de Estar</option>
                        </select>
                        <label for="cbo_categoria">Selecione a categoria:</label>
                    </div>
                    <div class="form-floating">
                        <select name="cbo_destaque" id="" class="form-select">
                            <option></option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                        <label for="cbo_destaque">Colocar em destaque?</label>
                    </div>
                    <div class="form-floating">
                        <select name="cbo_oferta" id="" class="form-select">
                            <option></option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                        <label for="cbo_oferta">É oferta relâmpago?</label>
                    </div>
                    <div class="form-floating">
                        <select name="cbo_ativo" id="" class="form-select">
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                        <label for="cbo_ativo">O produto estará ativo?</label>
                    </div>
                </div>

                <!-- Caminho da imagem -->
                <div class="form-floating">
                    <input name="txt_caminhoIM" type="text" required class="form-control" placeholder="Nome completo">
                    <label for="txt_caminhoIM">Caminho da imagem:</label>
                </div>

                <div class="form-botoes">
                    <button onclick="window.location.href='adm_produtos.php'" class="botao form-btn btn-cancelar">Cancelar</button>
                    <button onclick="document.form_cad_produtos.action='acoes_php/produto/gravar-produto.php'" type="submit" value="Cadastrar" class="botao form-btn btn-confirmar">Confirmar</button>
                </div>
            </form>
        </main>
    </body>
</html>