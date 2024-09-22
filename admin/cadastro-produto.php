<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include '/componentes/adm_head.php'; ?>
        <link rel="stylesheet" href="recursos/css/adm_produtos.css" />
        <title>Cadastrar Produtos</title>
    </head>
    <body>
        <?php include '/componentes/adm_header.php'; ?>
        <main class="conteudo-principal">
            <h1 class="titulo">
                Cadastro de Produtos
            </h1>
            <form method="POST" name="form_cad_produtos" class="form-cad-produto">
                <div class="div-campo">
                    <label for="txt_nome">Nome do Produto:</label>
                    <input name="txt_nome" type="text" required>
                </div>
                <div class="div-campo">
                    <label for="txt_descricao">Descrição do produto:</label>
                    <input name="txt_descricao" type="text" required>
                </div>
                <div class="div-campo">
                    <label for="txt_precoAnt">Preço anterior do produto:</label>
                    <input name="txt_precoAnt" type="text" required>
                </div>
                <div class="div-campo">
                    <label for="txt_precoAtual">Preço atual do produto:</label>
                    <input name="txt_precoAtual" type="text" required>
                </div>
                <div class="div-campo">
                    <label for="txt_altura"> Altura do produto(em cm):</label>
                    <input name="txt_altura" type="text" required>
                </div>
                <div class="div-campo">
                    <label for="txt_largura">Largura do produto(em cm):</label>
                    <input name="txt_largura" type="text" required>
                </div>
                <div class="div-campo">
                    <label for="txt_profundidade">Profundidade do produto(em cm):</label>
                    <input name="txt_profundidade" type="text" required>
                </div>
                <div class="div-campo">
                    <label for="txt_peso">Peso do produto(em kg):</label>
                    <input name="txt_peso" type="text" required>
                </div>
                <div class="div-campo">
                    <label for="txt_caminhoIM">Caminho do arquivo de imagem</label>
                    <input name="txt_caminhoIM" type="text" required>
                </div>
                <div class="div-campo">
                    <label for="cbo_categoria">Categoria</label>
                    <select name="cbo_categoria" id="">
                        <option>Categoria do Produto:</option>
                        <option value="1">Escritório.</option>
                        <option value="2">Quarto</option>
                        <option value="3">Cozinha</option>
                        <option value="4">Sala de Jantar</option>
                        <option value="5">Área Externa</option>
                        <option value="6">Sala de Estar</option>
                    </select>
                </div>
                <div class="div-campo">
                    <label for="cbo_destaque">Destaque</label>
                    <select name="cbo_destaque" id="">
                        <option>Colocar produto em destaque na pagina inicial?</option>
                        <option value="1">Sim.</option>
                        <option value="0">Não</option>
                    </select>
                </div>
                </div>
                <div class="div-campo">
                    <label for="cbo_oferta">Ofertas</label>
                    <select name="cbo_oferta" id="">
                        <option>Colocar produto em ofertas relâmpago na pagina inicial?</option>
                        <option value="1">Sim.</option>
                        <option value="0">Não</option>
                    </select>
                </div>
                <div class="div-campo">
                    <label for="cbo_ativo">Ativo</label>
                    <select name="cbo_ativo" id="">
                        <option>Produto Ativo?</option>
                        <option value="1">Sim.</option>
                        <option value="0">Não</option>
                    </select>
                </div>
                <div class="div-botoes">
                    <button type="submit" value="Cadastrar" onclick="document.form_cad_produtos.action='acoes_php/produto/gravar-produto.php'" class="btn-cadastrar">Cadastrar</button>
                    <button onclick="window.location.href='admin-produtos.php'" class="btn-tela-produtos">Ver Produtos</button>
                </div>
            </form>            
        </main>
    </body>
</html>