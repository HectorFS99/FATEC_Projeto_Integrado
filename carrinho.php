<?php
    include 'conexao.php';
    session_start();

    // Verifique se o usuário está logado
    if (!isset($_SESSION['id_usuario'])) {
        header('Location: login.php');
        exit;
    }

    $id_usuario = $_SESSION['id_usuario'];

    include 'acoes_php/carrinho/selecionar_produtos.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Carrinho</title>
        <!-- ***** ESTILIZAÇÃO ***** -->
        <link rel="stylesheet" href="recursos/css/reset.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
            rel="stylesheet">
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
                    <?php foreach ($itens_carrinho as $item): ?>
                        <div class="info-container produto_container">
                            <div class="div-produto_info">
                                <a href="detalhes-produto.php?id_produto=<?= $item['id_produto']; ?>" class="div-produto_info_img">
                                    <img src="<?= $item['caminho_imagem']; ?>" alt="<?= $item['nome']; ?>" />
                                </a>
                                <div class="mb-2">
                                    <h5 class="mb-1"><?= htmlspecialchars($item['nome']); ?></h5>
                                    <div class="avaliacao-estrelas mb-2">
                                        <!-- Exemplo de avaliação fixa (pode ajustar para ser dinâmica) -->
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <b>(4.9)</b>
                                    </div>
                                    <p>
                                        <s class="text-muted">De: R$
                                            <?= number_format($item['preco_anterior'], 2, ',', '.'); ?></s><br>
                                        <b>Por: R$ <span
                                                name="lblValorProduto"><?= number_format($item['preco_atual'], 2, ',', '.'); ?></span></b>
                                    </p>
                                    <p><b>à vista com pix, ou em 1x no Cartão de Crédito</b></p>
                                    <p>ou em até 10x de <?= number_format($item['preco_atual'] / 10, 2, ',', '.'); ?> s/ juros</p>
                                </div>
                            </div>
                            <div class="div-produto_opcoes">
                                <div class="mt-3" style="max-width: 225px;">
                                    <div class="input-group input-group-sm" style="background: rgba(128, 128, 128, 0.231); border-radius: 0.5rem;">
                                        <span class="input-group-text" id="basic-addon3"><b>Quantidade</b></span>
                                        <button
                                            onclick="subtrairQtd('qtdProd<?= $item['id_produto']; ?>', 'lblValorProduto', 'lblQtdProduto', 'lblValorSubTotalPedido');"
                                            class="btn btn-dark btn-sm">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                        <span id="qtdProd<?= $item['id_produto']; ?>" name="lblQtdProduto"
                                            class="mx-3"><?= $item['total_quantidade']; ?></span>
                                        <button
                                            onclick="adicionarQtd('qtdProd<?= $item['id_produto']; ?>', 'lblValorProduto', 'lblQtdProduto', 'lblValorSubTotalPedido');"
                                            class="btn btn-dark btn-sm">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <button class="btn btn-sm btn-favorito"><i class="fa-solid fa-heart"></i> Favoritar</button>
                                    <button class="btn btn-sm btn-compartilhar"><i class="fa-solid fa-share-from-square"></i>Compartilhar</button>
                                    <a href="./acoes_php/carrinho/remover_produto.php?id=<?= $item['id_produto']; ?>&usuario=<?= $_SESSION['id_usuario']; ?>"
                                        class="btn btn-sm btn-danger border-0">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="coluna-2">
                    <div class="info-container">
                        <div class="div-valor_info px-3 pt-3">
                            <?php
                                $total_itens = 0;
                                foreach ($itens_carrinho as $item) {
                                    $total_itens += $item['total_quantidade'];
                                }
                            ?>
                            <h5>Subtotal (<?= $total_itens; ?> itens):</h5>
                            <h4 class="text-success"><b>R$ <span id="lblValorSubTotalPedido"></span></b></h4>
                        </div>
                        <div class="p-3">
                            <a href="pagamento.php" class="btn btn-success w-100"><b>Comprar</b></a>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="aviso-ausencia-produtos">
                    <i class="fa-solid fa-cart-plus" style="font-size: 4rem;"></i>
                    <h3>Poxa, não tem nada no seu carrinho!</h3>
                    <h5>Que tal dar uma olhadinha em alguns de nossos produtos?</h5>
                    <a href="listagem-geral-produtos.php" class="btn btn-gradiente mt-2">Ver produtos</a>
                </div>
            <?php } ?>   
        </main>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var subtotal = calcularSubtotal('lblValorProduto', 'lblQtdProduto', 'lblValorSubTotalPedido');
                console.log(subtotal);
            });
        </script>        
    </body>
</html>