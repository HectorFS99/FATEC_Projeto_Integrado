<?php
    include '/acoes_php/conectar_banco_dados.php';
    
    $ID = 0;

    if (isset($_GET['id_produto'])) {
        $ID = $_GET['id_produto'];
    
    $sql_produtos = mysql_query(
        "SELECT 
            `id_produto`,
            `nome`,
            `descricao`,
            `preco_anterior`,
            `preco_atual`,
            `altura`,
            `largura`,
            `profundidade`,
            `peso`,
            `destaque`,
            `oferta_relampago`,
            `id_categoria`,
            `caminho_imagem`,
            `ativo`
        FROM 
            `produtos`
        WHERE
            `id_produto` = $ID;");

        $produto = mysql_fetch_assoc($sql_produtos);
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include '/componentes/adm_head.php'; ?>
        <link rel="stylesheet" href="/recursos/css/adm_geral.css" />
        <title>Editar Produto</title>
    </head>
    <body>
        <?php include '/componentes/adm_header.php'; ?>
        <hr class="divisor">
        <main class="conteudo-principal">
            <div class="titulo-opcoes">
                <h3 class="titulo">
                    <a href="adm_produtos.php" class="btn-voltar"><i class="fa-solid fa-arrow-left"></i></a>
                    Editar Produto
                </h3>
            </div>
            <form method="POST" name="form_ed_produtos" class="formulario w-100">
                <!-- Nome, preço anterior e preço atual -->
                <div class="formulario-grupo">
                    <div class="form-floating">
                        <input name="txt_nome" type="text" required class="form-control" placeholder="Nome completo" value="<?= $produto['nome'] ?>">
                        <label for="txt_nome">Nome:</label>
                    </div>
                    <div class="form-floating">
                        <input name="txt_precoAnt" type="text" required class="form-control" placeholder="Preço anterior" value="<?= $produto['preco_anterior'] ?>">
                        <label for="txt_precoAnt">Preço anterior:</label>
                    </div>
                    <div class="form-floating">
                        <input name="txt_precoAtual" type="text" required class="form-control" placeholder="Preço atual" value="<?= $produto['preco_atual'] ?>">
                        <label for="txt_precoAtual">Preço atual:</label>
                    </div>
                </div>

                <!-- Altura, largura, profundidade e peso -->
                <div class="formulario-grupo">
                    <div class="form-floating">
                        <input name="txt_altura" type="text" required class="form-control" placeholder="Altura (cm)" value="<?= $produto['altura'] ?>">
                        <label for="txt_altura">Altura (cm):</label>
                    </div>
                    <div class="form-floating">
                        <input name="txt_largura" type="text" required class="form-control" placeholder="Largura (cm)" value="<?= $produto['largura'] ?>">
                        <label for="txt_largura">Largura (cm):</label>
                    </div>
                    <div class="form-floating">
                        <input name="txt_profundidade" type="text" required class="form-control" placeholder="Profundidade (cm)" value="<?= $produto['profundidade'] ?>">
                        <label for="txt_profundidade">Profundidade (cm):</label>
                    </div>
                    <div class="form-floating">
                        <input name="txt_peso" type="text" required class="form-control" placeholder="Peso (kg)" value="<?= $produto['peso'] ?>">
                        <label for="txt_peso">Peso (kg):</label>
                    </div>
                </div>

                <!-- Descrição -->
                <div class="form-floating">
                    <textarea name="txt_descricao" required class="form-control" rows="6" placeholder="Descrição"><?= $produto['descricao'] ?></textarea>
                    <label for="txt_descricao">Descrição:</label>
                </div>

                <!-- Categoria, destaque, oferta relâmpago e ativo/desativo -->
                <div class="formulario-grupo">
                    <div class="form-floating">
                        <select name="cbo_categoria" class="form-select">
                            <option></option>                            
                            <option value="1" <?= $produto['id_categoria'] == 1 ? 'selected' : '' ?>>Escritório</option>
                            <option value="2" <?= $produto['id_categoria'] == 2 ? 'selected' : '' ?>>Quarto</option>
                            <option value="3" <?= $produto['id_categoria'] == 3 ? 'selected' : '' ?>>Cozinha</option>
                            <option value="4" <?= $produto['id_categoria'] == 4 ? 'selected' : '' ?>>Sala de Jantar</option>
                            <option value="5" <?= $produto['id_categoria'] == 5 ? 'selected' : '' ?>>Área Externa</option>
                            <option value="6" <?= $produto['id_categoria'] == 6 ? 'selected' : '' ?>>Sala de Estar</option>
                        </select>
                        <label for="cbo_categoria">Selecione a categoria:</label>
                    </div>
                    <div class="form-floating">
                        <select name="cbo_destaque" class="form-select">
                            <option value="1" <?= $produto['destaque'] ? 'selected' : '' ?>>Sim</option>
                            <option value="0" <?= !$produto['destaque'] ? 'selected' : '' ?>>Não</option>
                        </select>
                        <label for="cbo_destaque">Colocar em destaque?</label>
                    </div>
                    <div class="form-floating">
                        <select name="cbo_oferta" class="form-select">
                            <option value="1" <?= $produto['oferta_relampago'] ? 'selected' : '' ?>>Sim</option>
                            <option value="0" <?= !$produto['oferta_relampago'] ? 'selected' : '' ?>>Não</option>
                        </select>
                        <label for="cbo_oferta">É oferta relâmpago?</label>
                    </div>
                    <div class="form-floating">
                        <select name="cbo_ativo" class="form-select">
                            <option value="1" <?= $produto['ativo'] ? 'selected' : '' ?>>Sim</option>
                            <option value="0" <?= !$produto['ativo'] ? 'selected' : '' ?>>Não</option>
                        </select>
                        <label for="cbo_ativo">O produto estará ativo?</label>
                    </div>
                </div>

                <!-- Caminho da imagem -->
                <div class="form-floating">
                    <input name="txt_caminhoIM" type="text" required class="form-control" placeholder="Caminho da imagem" value="<?= $produto['caminho_imagem'] ?>">
                    <label for="txt_caminhoIM">Caminho da imagem:</label>
                </div>

                <div class="form-botoes">
                    <button type="button" onclick="window.location.href='adm_produtos.php'" class="botao form-btn btn-cancelar">Cancelar</button>
                    <button onclick="document.form_ed_produtos.action='acoes_php/produto/editar-produto.php?id_produto=<?= $ID ?>'" type="submit" value="Confirmar" class="botao form-btn btn-confirmar">Confirmar</button>
                </div>
            </form>
        </main>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                function formatarData(data) {
                    const opcoesData = { day: 'numeric', month: 'long', year: 'numeric' };
                    const dataFormatada = data.toLocaleDateString('pt-BR', opcoesData);
                    
                    const horas = String(data.getHours()).padStart(2, '0');
                    const minutos = String(data.getMinutes()).padStart(2, '0');
                    
                    return `${dataFormatada} - ${horas}:${minutos}`;
                }

                const dataAtual = new Date();
                const elementoData = document.getElementById('data-atual');

                if (elementoData) {
                    elementoData.textContent = formatarData(dataAtual);
                }
            });
        </script>
    </body>
</html>
