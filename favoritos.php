<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Meus Favoritos</title>
        <!-- ***** ESTILIZAÇÃO ***** -->
        <link rel="stylesheet" href="recursos/css/reset.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="recursos/css/geral.css" />
        <link rel="stylesheet" href="recursos/css/header.css" />
        <link rel="stylesheet" href="recursos/css/favoritos.css" />
        <link rel="stylesheet" href="recursos/css/footer.css" />
        <!-- ***** ESTILIZAÇÃO ***** -->
        <!-- ***** PROGRAMAÇÃO ***** -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
        <script src="recursos/javascript/principal.js"></script>
        <script src="recursos/javascript/favoritos.js"></script>
        <!-- ***** PROGRAMAÇÃO ***** -->
    </head>
    <body>
        <?php
            include 'header.php'; 
                
            // Verifique se o usuário está logado
            if (!isset($_SESSION['id_usuario'])) {
                header('Location: login.php');
                exit;
            }
        
            $id_usuario = $_SESSION['id_usuario'];
        
            $result = mysql_query( 
                "SELECT 
                    f.id_produto
                    , p.nome
                    , p.caminho_imagem
                    , p.preco_atual
                    , p.preco_anterior
                    , f.dt_inclusao
                FROM 
                    favoritos AS f
                    INNER JOIN produtos AS p ON f.id_produto = p.id_produto
                WHERE 
                    f.id_usuario = $id_usuario"
            );    
        
            // Array para armazenar os itens favoritos
            $itens_favoritos = [];
            if (mysql_num_rows($result) > 0) {
                while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                    $itens_favoritos[] = $row;
                }
            }
        ?>
        <main style="margin-bottom: 3rem;">
            <?php if (count($itens_favoritos) > 0) { ?>
                <div class="cabecalho-favoritos">
                    <h3><i class="fa-solid fa-heart"></i> Seus Favoritos</h3>
                    <div class="btn-group">
                        <button class="btn btn-light" onclick="visualizarGrid();"><i class="fa-solid fa-grip"></i></button>
                        <button class="btn btn-light" onclick="visualizarLista();"><i class="fa-solid fa-list"></i></button>
                    </div>
                </div>

                <div id="visualizacaoCards" style="display: none;">
                    <?php foreach ($itens_favoritos as $item): ?>
                        <div class="card-favorito">
                            <a class="card-link_detalhes" href="detalhes-produto.php"><img class="img-favorito" src="<?= $item['caminho_imagem']; ?>"></a>
                            <p class="my-1">
                                <s class="text-muted">De: R$ <?= $item['preco_anterior']; ?></s><br>
                                <b>Por: <span style="font-size: 1.5rem;" class="text-success">R$ <?= $item['preco_atual']; ?></span></b>
                            </p>
                            <div class="d-flex gap-2">
                                <a href="./acoes_php/carrinho/adicionar_produto.php?id_produto=<?= $item['id_produto']; ?>&favoritos=true" class="btn btn-laranja w-100">
                                    <i class="fa-solid fa-cart-plus"></i>
                                    <b> Adicionar ao Carrinho</b>
                                </a>
                                <a href="./acoes_php/favorito/desfavoritar.php?id_produto=<?= $item['id_produto']; ?>&id_usuario=<?= $_SESSION['id_usuario']; ?>"
                                    class="btn btn-danger border-0">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div id="visualizacaoLista">
                    <?php foreach ($itens_favoritos as $item): ?>
                        <div class="item-favorito">
                            <div class="item-favorito_conteudo">
                                <a href="detalhes-produto.php"><img class="img-favorito" src="<?= $item['caminho_imagem']; ?>" /></a>
                                <div class="m-3">
                                    <p class="card-produto_titulo"><?= $item['nome']; ?></p>
                                    <div class="avaliacao-estrelas mb-3">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <b>(4.9)</b>
                                    </div>
                                    <p>
                                        <s class="text-muted">De: R$ <?= number_format($item['preco_anterior'], 2, ',', '.'); ?></s><br>
                                        <b>Por: <span style="font-size: 1.5rem;">R$ <?= number_format($item['preco_atual'], 2, ',', '.'); ?></span></b>
                                    </p>
                                    <p class="text-success">
                                        <b>à vista com pix, ou em 1x no Cartão de Crédito</b>
                                    </p>
                                    <p> ou em até 10x de <?= number_format($item['preco_atual'] / 10, 2, ',', '.'); ?> s/ juros </p>
                                </div>
                            </div>
                            <div class="item-favorito_opcoes">
                                <small class="text-center">Produto adicionado em <?= date('d/m/Y', strtotime($item['dt_inclusao'])); ?></small>
                                <div>
                                    <a href="./acoes_php/carrinho/adicionar_produto.php?id_produto=<?= $item['id_produto']; ?>&favoritos=true" class="btn btn-laranja">
                                        <i class="fa-solid fa-cart-plus"></i>
                                        <b> Adicionar ao Carrinho</b>
                                    </a>
                                    <a href="./acoes_php/favorito/desfavoritar.php?id_produto=<?= $item['id_produto']; ?>&id_usuario=<?= $_SESSION['id_usuario']; ?>"
                                        class="btn btn-danger border-0">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php } else { ?>
                <div class="aviso-ausencia-produtos" style="margin-bottom: 6rem;">
                    <i class="fa-solid fa-heart-crack" style="font-size: 4rem;"></i>
                    <h3>Poxa, você ainda não favoritou nada!</h3>
                    <h5>Que tal dar uma olhadinha em alguns de nossos produtos?</h5>
                    <a href="listagem-geral-produtos.php" class="btn btn-gradiente mt-2">Ver produtos</a>
                </div>
            <?php } ?>
        </main>
        <footer id="footer"></footer>
    </body>
</html>