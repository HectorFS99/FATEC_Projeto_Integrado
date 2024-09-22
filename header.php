<?php
   	header('Content-Type: text/html; charset=utf-8');
    include 'conexao.php';
	$sql_categorias_header = mysql_query("SELECT `id_categoria`, `nome`, `descricao`, `caminho_icone` FROM `categorias`");
?>

<header>
	<nav class="navbar">
		<form class="formulario">
			<div class="input-group">
				<select id="cboCategoria" class="form-select">
					<option selected>Todos</option>
					<?php while ($linha = mysql_fetch_assoc($sql_categorias_header)) { ?>
						<option value="<?php echo $linha['id_categoria']; ?>"><?php echo $linha['nome']; ?></option>
					<?php } ?>
				</select>
				<input id="txtPesquisar" type="text" class="form-control" placeholder="Encontrar sofás, mesas...">
				<button id="btnPesquisar" type="submit" class="btn btn-laranja"><i class="fa-solid fa-magnifying-glass"></i></button>
			</div>
		</form>
		<a href="pagina-inicial.php" style="width: 70px;"><img src="recursos/imagens/logos/logo_futureMob.png" width="70" /></a>
		<div class="botoes_barra_superior">
			<a href="pagina-inicial.php" class="btn-vertical">
				<i class="fa-solid fa-house"></i>
				<span>Início</span>
			</a>
			<a href="listagem-geral-produtos.php" class="btn-vertical">
				<i class="fa-solid fa-cube"></i>
				<span>Produtos</span>
			</a>
			<a href="#" onclick="window.location.href='verifica_login.php'; return false;" class="btn-vertical">
				<i class="fa-solid fa-user"></i>
				<span>Minha Conta</span>
			</a>
			<a href="admin/adm_index.php" class="btn-vertical">
				<i class="fa-solid fa-screwdriver-wrench"></i>
				<span>Admin.</span>
			</a>
			<a href="favoritos.php" class="btn-vertical">
				<i class="fa-solid fa-heart"></i>
				<span>Favoritos</span>
			</a>
			<a id="btnCarrinho" href="carrinho.php" class="btn btn-laranja">
				<i class="fa-solid fa-cart-shopping"></i>
				<span id="contador-carrinho" style="margin-left: 1rem;">0</span>
			</a>
		</div>
	</nav>
</header>