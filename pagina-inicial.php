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
	
	// Consultas específicas para produtos
	$sql_destaques = mysql_query($select_produtos . " WHERE `destaque` = 1");    
	$sql_ofertas_relampagos = mysql_query($select_produtos . " WHERE `oferta_relampago` = 1");    
	$sql_novidades = mysql_query($select_produtos . " ORDER BY `dt_cadastro` DESC");
?>
<html lang="pt-br">
	<head>
		<?php include 'head.php'; ?>
		<title>Future Mob</title>
	</head>
	<body>
		<?php include 'header.php'; ?>
		<main>
			<div id="carrossel-pagina_inicial" class="carrossel">
				<div class="carrossel-container">
					<?php while($linha = mysql_fetch_assoc($sql_destaques)) { ?>
						<div class="carrossel-item" style="background-image: url('<?php echo $linha['caminho_imagem']; ?>');">
							<div class="carrossel-conteudo">
								<h1><?php echo $linha['nome']; ?></h1>
								<p class="opacity-75"><?php echo $linha['descricao']; ?></p>
								<div>
									<a class="btn btn-lg btn-gradiente" href="detalhes-produto.php?id_produto=<?php echo $linha['id_produto']; ?>">Venha conferir!</a>
								</div>
							</div>
						</div> 			
					<?php } ?>
				</div>
				<button class="carrossel-btn_anterior" onclick="slideAnterior('#carrossel-pagina_inicial');"> ❮ </button>
				<button class="carrossel-btn_proximo" onclick="proximoSlide('#carrossel-pagina_inicial');"> ❯ </button>
			</div>
			<section class="conteudo-pagina_inicial">
				<nav class="menu-categoria">
					<?php while($linha = mysql_fetch_assoc($sql_categorias)) { ?>
						<a class="btn-vertical" href="listagem-geral-produtos.php">
							<img class="img-categoria" src="<?php echo $linha['caminho_icone']; ?>" alt="categoria-sala_estar" />
							<span><?php echo $linha['nome']; ?></span>
						</a>    			
					<?php } ?>
				</nav>
				<div class="ofertas-relampago">
					<h3 class="produtos_titulo"><i class="fa-solid fa-bolt"></i> Ofertas relâmpago!</h3>
					<div class="produtos_cards">
						<?php while($linha = mysql_fetch_assoc($sql_ofertas_relampagos)) { ?>
							<a href="detalhes-produto.php?id_produto=<?php echo $linha['id_produto']; ?>" class="card-produto">

								<img src="<?php echo $linha['caminho_imagem']; ?>" class="card-produto_img" alt="..." />
								<div class="card-produto_conteudo">
									<p class="card-produto_titulo"><?php echo $linha['nome']; ?></p>
									<p>
										<s class="text-muted">De: R$ <?php echo number_format($linha['preco_anterior'], 2, ',', '.'); ?></s><br>
										<b>Por: <span style="font-size: 1.5rem;">R$ <?php echo number_format($linha['preco_atual'], 2, ',', '.'); ?></span></b>
									</p>
									<p class="text-success">
										<b>à vista com pix, ou em 1x no Cartão de Crédito</b>
									</p>
									<p> ou em até 10x de R$ <?php echo number_format($linha['preco_atual'] / 10, 2, ',', '.'); ?> s/ juros </p>
								</div>
							</a>    
						<?php } ?>
					</div>
				</div>
				<div class="novidades">
					<div class="d-flex justify-content-between align-items-center">
						<h3 class="produtos_titulo"><i class="fa-solid fa-face-grin-stars"></i> Novidades!</h3>
						<a href="listagem-geral-produtos.php" class="btn btn-verMaisProdutos">Ver produtos <i class="fa-solid fa-arrow-right" style="margin-left: .25rem;"></i></a>
					</div>
					<div class="produtos_cards">
						<?php while($linha = mysql_fetch_assoc($sql_novidades)) { ?>
							<a href="detalhes-produto.php?id_produto=<?php echo $linha['id_produto']; ?>" class="card-produto">
								<img src="<?php echo $linha['caminho_imagem']; ?>" class="card-produto_img" alt="..." />
								<div class="card-produto_conteudo">
									<p class="card-produto_titulo"><?php echo $linha['nome']; ?></p>
									<p>
										<s class="text-muted">De: R$ <?php echo number_format($linha['preco_anterior'], 2, ',', '.'); ?></s><br>
										<b>Por: <span style="font-size: 1.5rem;">R$ <?php echo number_format($linha['preco_atual'], 2, ',', '.'); ?></span></b>
									</p>
									<p class="text-success">
										<b>à vista com pix, ou em 1x no Cartão de Crédito</b>
									</p>
									<p> ou em até 10x de R$ <?php echo number_format($linha['preco_atual'] / 10, 2, ',', '.'); ?> s/ juros </p>
								</div>                            
							</a>    
						<?php } ?>
					</div>
				</div>
			</section>
		</main>
		<footer id="footer"></footer>
		<script>
			document.addEventListener('DOMContentLoaded', () => {
				mostrarSlide(indice_atual, '#carrossel-pagina_inicial');
				mostrarSlide(indice_atual, '#carrossel-ofertas_relampago');
			});
		</script>
	</body>
</html>