<?php
	header('Content-Type: text/html; charset=utf-8');
	include 'conexao.php';



    
	// Consulta para categorias
	$sql_categorias = mysql_query(
		"SELECT
			`id_categoria`,
			`nome`,
			`descricao`,
			`caminho_icone`
		FROM
			`categorias`"
	);

    $ordenacao = isset($_GET['filtrar']) ? $_GET['filtrar'] : '';

    $filtro_categoria = isset($_GET['filtrar_categoria']) ? $_GET['filtrar_categoria'] : '';
    $preco_minimo = isset($_GET['preco_minimo']) ? floatval($_GET['preco_minimo']) : null;
    $preco_maximo = isset($_GET['preco_maximo']) ? floatval($_GET['preco_maximo']) : null;

    // Consulta base para produtos
    $select_produtos = 
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
            `produtos`";

    $condicoes = [];
    $filtro_aplicado = false;

    // Verifica categoria
    if ($filtro_categoria) {
        $condicoes[] = "id_categoria = " . intval($filtro_categoria);        
    }

    // Verifica preços
    if ($preco_minimo !== null) {
        $condicoes[] = "preco_atual >= " . $preco_minimo;
    }
    if ($preco_maximo !== null) {
        $condicoes[] = "preco_atual <= " . $preco_maximo;
    }

    // Adiciona condições à consulta
    if (count($condicoes) > 0) {
        $select_produtos .= " WHERE " . implode(" AND ", $condicoes);
        $filtro_aplicado = true;
    }

    // Modifica a consulta com base no filtro selecionado
    switch ($ordenacao) {
        case 'lancamento':
            $select_produtos .= " ORDER BY `dt_cadastro` DESC";
            $filtro_selecionado = " - Ordenado por lançamento";
            break;
        case 'menor_preco':
            $select_produtos .= " ORDER BY `preco_atual` ASC";
            $filtro_selecionado = " - Ordenado pelo menor preço";
            break;
        case 'maior_preco':
            $select_produtos .= " ORDER BY `preco_atual` DESC";
            $filtro_selecionado = " - Ordenado pelo maior preço";
            break;
        default:
            $select_produtos .= "";
            $filtro_selecionado = "";
            break;
    }

    $sql_produtos = mysql_query($select_produtos);
?>
<html lang="pt-br">
    <head>
        <?php include 'head.php'; ?>
        <link rel="stylesheet" href="recursos/css/listagem-geral-produtos.css" />
        <title>Future Mob</title>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <main class="main-listagem">
            <!-- Menu de Filtros -->
            <div class="menu-filtros">
                <div class="titulo mx-0">
                    <h4>Filtros</h4>
                    <?php if ($filtro_aplicado) { ?>
                        <form method="GET" action="listagem-geral-produtos.php">
                            <button class="btn btn-light border" type="submit" name="filtrar_categoria" value="">
                                <i class="fa-solid fa-filter-circle-xmark"></i> Limpar
                            </button>
                        </form>		
					<?php } ?>                 
                </div>

                <!-- Categorias -->
                <button onclick="exibirFiltroAcc('acc-categorias');" class="btn btn-filtros_accordion">Categorias</button>
                <section id="acc-categorias" class="acc">
                    <form method="GET" action="listagem-geral-produtos.php">
                        <ul class="filtro-lista_categorias">
                            <li><button type="submit" name="filtrar_categoria" value="" class="btn btn-categoria_filtro">Todos</button></li>
                            <?php while ($linha = mysql_fetch_assoc($sql_categorias)) { ?>
                                <li>
                                    <button type="submit" name="filtrar_categoria" value="<?php echo $linha['id_categoria']; ?>" class="btn btn-categoria_filtro">
                                        <?php echo $linha['nome']; ?>
                                    </button>
                                </li>
                            <?php } ?>
                        </ul>
                    </form>
                </section>

                <!-- Preço -->
                <button onclick="exibirFiltroAcc('acc-preco');" class="btn btn-filtros_accordion">Preço</button>
                <section id="acc-preco" class="acc">
                    <form method="GET" action="listagem-geral-produtos.php">
                        <div>
                            <label>Mínimo:</label>
                            <input type="number" name="preco_minimo" class="form-control" min="100" value="100" required>
                        </div>
                        <div class="my-2">
                            <label>Máximo:</label>
                            <input type="number" name="preco_maximo" class="form-control" min="100" max="20000" required>
                        </div>
                        <button type="submit" class="btn btn-laranja w-100">Aplicar</button>
                    </form>
                </section>
                
                <!-- Avaliações -->
                <button onclick="exibirFiltroAcc('acc-avaliacao');" class="btn btn-filtros_accordion border-0">Avaliação</button>
                <section id="acc-avaliacao" class="acc border-0 border-top">
                    <div class="text-muted mb-2">
                        <small>Desculpe, estamos desenvolvendo este filtro.</small>
                    </div>
                    <?php for($i = 1; $i <= 5; $i++) { ?>
                        <div class="form-check">
                            <input disabled class="form-check-input" type="checkbox" id="filtro-<?php echo $i; ?>estrelas">
                            <label class="form-check-label" for="filtro-<?php echo $i; ?>estrelas"><?php echo $i; ?> estrelas</label>
                        </div>
                    <?php } ?>
                </section>
            </div>

            <!-- Listagem de Produtos -->
            <div class="d-flex flex-column justify-content-center w-100">
                <div class="titulo">
                    <h4>Produtos<?php echo $filtro_selecionado; ?></h4>
                    <div class="d-flex justify-content-between">
                        <!-- <div class="btn-group border mx-1">
                            <button class="btn btn-light" onclick="visualizarGrid();"><i class="fa-solid fa-grip"></i></button>
                            <button class="btn btn-light" onclick="visualizarLista();"><i class="fa-solid fa-list"></i></button>
                        </div> -->
                        <form method="GET" action="listagem-geral-produtos.php">
                            <select name="filtrar" class="form-select" onchange="this.form.submit()">
                                <option selected>Ordenar por</option>
                                <option value="lancamento">Lançamento</option>
                                <option value="menor_preco">Menor preço</option>
                                <option value="maior_preco">Maior preço</option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="grid-produtos">
                    <?php while($linha = mysql_fetch_assoc($sql_produtos)) { ?>
                        <div href="detalhes-produto.php?id_produto=<?php echo $linha['id_produto']; ?>" class="card-produto_listagem">
                            <a href="detalhes-produto.php?id_produto=<?php echo $linha['id_produto']; ?>"><img class="card-produto_listagem_img" src="<?php echo $linha['caminho_imagem']; ?>"></a>
                            <h6 class="mb-1"><?php echo $linha['nome']; ?></h6>
                            <!-- <div class="avaliacao-estrelas mb-2">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <small><b>EM DESENVOLVIMENTO </></b></small>
                            </div> -->
                            <small><s>De: R$ <?php echo number_format($linha['preco_anterior'], 2, ',', '.'); ?></s></small>
                            <p>Por: R$ <?php echo number_format($linha['preco_atual'], 2, ',', '.'); ?></p>
                            <small>ou em até 10x de R$ <?php echo number_format($linha['preco_atual'] / 10, 2, ',', '.'); ?> s/ juros</small>
                            
                            <?php if (isset($_SESSION['autenticado']) && $_SESSION['id_usuario'] > 0) { ?>
                                <div class="d-flex">
                                    <a href="./acoes_php/carrinho/adicionar_produto.php?id_produto=<?php echo $linha['id_produto']; ?>&comprarAgora=true" class="btn btn-laranja mt-2 w-100">
                                        <strong>Comprar</strong>
                                    </a>
                                    <a href="acoes_php/favorito/favoritar.php?id_produto=<?php echo $linha['id_produto']; ?>" class="btn btn-danger mt-2 d-flex align-items-center" style="margin-left: 10px">
                                        <i class="fa-regular fa-heart"></i>
                                    </a>                                    
                                </div>                                
                                <a href="./acoes_php/carrinho/adicionar_produto.php?id_produto=<?php echo $linha['id_produto']; ?>&listagem=true" class="btn btn-light mt-2 w-100">
                                    <strong>Adicionar ao Carrinho</strong>
                                </a>                                
                            <?php } else { ?>
                                <a href="login.php" class="btn btn-laranja mt-2">Comprar</a>                                
                            <?php } ?>
                        </div>
					<?php } ?>
                </div>            
            </div>
        </main>
        <footer id="footer"></footer>
        <script>
            function exibirFiltroAcc(id_componente) {
                var accordion = document.getElementById(id_componente);
                accordion.style.display === "block" ? accordion.style.display = "none" : accordion.style.display = "block";
                accordion.classList.toggle("acc-aberto");
            }
        </script>
    </body>
</html>