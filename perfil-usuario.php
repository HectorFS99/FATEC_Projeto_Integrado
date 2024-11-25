<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Minha Conta</title>
		<!-- ***** ESTILIZAÇÃO ***** -->
		<link rel="stylesheet" href="recursos/css/reset.css" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
		<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="recursos/css/geral.css" />
		<link rel="stylesheet" href="recursos/css/header.css" />
		<link rel="stylesheet" href="recursos/css/perfil-usuario.css" />
		<link rel="stylesheet" href="recursos/css/avaliacao-estrelas.css" />
		<link rel="stylesheet" href="recursos/css/acompanhar-entrega.css" />
		<link rel="stylesheet" href="recursos/css/footer.css" />
		<!-- ***** ESTILIZAÇÃO ***** -->
		<!-- ***** PROGRAMAÇÃO ***** -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
		<script src="recursos/javascript/principal.js"></script>
		<script src="recursos/javascript/pedidos.js"></script>
		<!-- ***** PROGRAMAÇÃO ***** -->
	</head>
	<body>
		<?php 
			date_default_timezone_set('America/Sao_Paulo'); // Define o fuso horário para o Brasil

			include 'header.php';
			
			if (!isset($_SESSION['id_usuario'])) {
				echo 
					"<script>
						alert('Usuário não autenticado. Você será redirecionado para a página inicial.')
						window.location.href = '../pagina-inicial.php';
					</script>";        
			}
		
			$id_usuario = $_SESSION['id_usuario'];

			/* * * * * * * * * * * * * * * * * * * * * * CONSULTA PARA OS PEDIDOS DO USUÁRIO * * * * * * * * * * * * * * * * * * * * * */
			$sql_pedidos = mysql_query(
				"SELECT 
					P.id_pedido
					, P.dt_pedido
					, P.subtotal
					, P.frete
					, P.descontos
					, P.total
					, P.id_status
					, STT.nome AS nome_status
					, END.id_endereco
					, END.nome_endereco
					, END.logradouro
					, END.numero
					, END.complemento
					, END.bairro
					, END.cep
					, END.cidade
					, END.uf
					, L.id_loja
					, L.nome AS nome_loja
					, L.endereco_completo AS endereco_loja
				FROM 
					pedidos AS P
					INNER JOIN status AS STT ON STT.id_status = P.id_status
					LEFT JOIN enderecos AS END ON END.id_endereco = P.id_endereco
					LEFT JOIN lojas AS L ON L.id_loja = P.id_loja
				WHERE
					P.id_usuario = $id_usuario
				ORDER BY
					P.id_pedido DESC"
			);

			$temPedidos = true;
			if (mysql_num_rows($sql_pedidos) == 0) {
				$temPedidos = false;
			}
			
			$sql_usuario = mysql_query(
				"SELECT 
					nome_completo
					, cpf
					, rg
					, dt_nascimento
					, sexo	
					, telefone_celular	
					, email	
					, caminho_img_perfil
					, admin
				FROM
					usuarios
				WHERE 
					id_usuario = $id_usuario");

			$usuario = mysql_fetch_assoc($sql_usuario);
		?>
		<main class="main-usuario">
			<div class="menu-lateral rounded-bottom">
				<button id="btnPedidos" onclick="exibirTela('section-meus-pedidos', this.id);" class="btn menu-lateral_opcao mt-3 btn-opcaoMenu_selecionado">
					<i class="fa-solid fa-boxes-stacked"></i>
					<p>Pedidos</p>
				</button>
				<button id="btnDados" onclick="exibirTela('section-seus-dados', this.id);" class="btn menu-lateral_opcao">
					<i class="fa-solid fa-address-card"></i>
					<p>Dados</p>
				</button>
				<button id="btnEnderecos" onclick="exibirTela('section-enderecos', this.id);" class="btn menu-lateral_opcao">
					<i class="fa-solid fa-map-location-dot"></i>
					<p>Endereços</p>
				</button>
				<a class="btn menu-lateral_opcao rounded-bottom" href="#" onclick="window.location.href='deslogar.php'; return false;">
					<i class="fa-solid fa-person-walking-arrow-loop-left"></i>
					<p>Sair</p>
				</a>
			</div>
			<section class="section-tela" id="section-meus-pedidos">
				<?php if (mysql_num_rows($sql_pedidos) > 0) {
					while($pedido = mysql_fetch_assoc($sql_pedidos)) { ?>
						<div class="container-informacoes">
							<div class="container-informacoes_componentes container-informacoes_cabecalho">
								<!-- Endereço de entrega ou retirada-->
								<div class="container-informacoes_cabecalho-info">
									<?php if ($pedido['id_endereco'] !== null) { ?>
										<strong>Enviar para <?php echo $pedido['nome_endereco']; ?></strong>
										<p><?php echo $pedido['logradouro']; ?>, <?php echo $pedido['numero']; ?> - <?php echo $pedido['complemento']; ?></p> 
										<p><?php echo $pedido['cep']; ?> - <?php echo $pedido['bairro']; ?>, <?php echo $pedido['cidade']; ?> - <?php echo $pedido['uf']; ?></p> 
									<?php } else { ?>									
										<p class="titulo-informacao"></p>
										<strong>Retirar em <?php echo $pedido['nome_loja']; ?></strong>
										<p><?php echo $pedido['endereco_loja']; ?></p> 
									<?php } ?>
								</div>

								<!-- Data do Pedido -->					
								<div class="container-informacoes_cabecalho-info">
									<p class="titulo-informacao">REALIZADO EM</p>
									<p><?php echo date('d/m/Y H:i:s', strtotime($pedido['dt_pedido'])); ?></p>
								</div>
								
								<!-- Total do Pedido-->
								<div class="container-informacoes_cabecalho-info">
									<p class="titulo-informacao">TOTAL</p>
									<p>R$ <?php echo $pedido['total']; ?></p>
								</div>

								<!-- Número do pedido -->
								<div class="container-informacoes_cabecalho-info">
									<p class="titulo-informacao">NÚM. DO PEDIDO</p>
									<?php echo $pedido['id_pedido']; ?>
								</div>									
							</div>
							<div class="container-informacoes_corpo container-pedidos_corpo">
								<?php 
									$select_produtos_pedidos = 
										"SELECT 
											PRD.id_produto
											, PRD.caminho_imagem
											, PRD.nome
											, PRD.preco_atual
											, PRD.preco_anterior
										FROM 
											pedidos_produtos AS PP
											INNER JOIN produtos AS PRD ON PRD.id_produto = PP.id_produto
										WHERE
											PP.id_pedido = "
										;

									$sql_produtos_pedidos = mysql_query($select_produtos_pedidos . $pedido['id_pedido']);

									while ($produto = mysql_fetch_assoc($sql_produtos_pedidos)) { ?>
										<a href="detalhes-produto.php?id_produto=<?php echo $produto['id_produto']; ?>" class="div-produto_info card-container">
											<div class="div-produto_info_img mb-0">
												<img src="<?php echo $produto['caminho_imagem']; ?>" />
											</div>
											<div class="mb-2">
												<h5 class="mb-1"><?php echo $produto['nome']; ?></h5>
												<div class="avaliacao-estrelas mb-2">
													<i class="fa-solid fa-star"></i>
													<i class="fa-solid fa-star"></i>
													<i class="fa-solid fa-star"></i>
													<i class="fa-solid fa-star"></i>
													<i class="fa-solid fa-star"></i>
													<b>(4.9)</b>
												</div>
												<p>
													<s class="titulo-informacao">De: R$ <?php echo number_format($produto['preco_anterior'], 2, ',', '.'); ?></s><br>
													<b>Por: R$ <span name="lblValorProduto"><?php echo number_format($produto['preco_atual'], 2, ',', '.'); ?></span></b>
												</p>
											</div>
										</a>
								<?php } ?>
							</div>
							<div class="container-informacoes_componentes container-informacoes_rodape">
								<!-- Status -->
								<div>
									<p class="titulo-informacao">STATUS</p>
									<p><?php echo $pedido['nome_status']; ?></p>									
								</div>

								<!-- Ações -->
								<div class="container-pedidos-acoes">

									<!-- Em separação ou Enviado -->
									<?php if ($pedido['id_status'] == 4 || $pedido['id_status'] == 5) { ?>
										<button type="button" id="btn" onclick="acompanharEntrega();" class="btn-acao_pedido btn-acompanhar">
											Acompanhar
										</button>									
									<?php } ?>

									<!-- Entregue -->
									<?php if ($pedido['id_status'] == 6) { ?>
										<button type="button" class="btn-acao_pedido btn-devolver">
											Devolver
										</button>
										<button type="button" id="btnAvaliar" onclick="avaliar();" class="btn-acao_pedido btn-avaliar_ped">
											Avaliar
										</button>
									<?php } ?>
									
									<!-- Para poder cancelar, o pedido deve ser diferente de "Entregue" (6), "Cancelado" (7) e "Devolvido" (8) -->
									<?php if ($pedido['id_status'] != 6 && $pedido['id_status'] != 7 && $pedido['id_status'] != 8) { ?>
										<button type="button" class="btn-acao_pedido btn-devolver">
											Cancelar
										</button>								
									<?php } ?>

									<button type="button" class="btn-acao_pedido btn-detalhes_ped">
										Detalhes
									</button>
								</div>							
							</div>
						</div>
				<?php } } else { ?>
					<div class="aviso-ausencia-produtos">
						<i class="fa-solid fa-cart-plus" style="font-size: 4rem;"></i>
						<h3>Poxa, você ainda não tem nenhum pedido!</h3>
						<h5>Que tal dar uma olhadinha em alguns de nossos produtos?</h5>
						<a href="listagem-geral-produtos.php" class="btn btn-gradiente mt-2">Ver produtos</a>
					</div>
				<?php } ?>
			</section>
			<section class="section-tela" id="section-seus-dados" style="display: none;">
				<div class="container-informacoes">
					<h2 class="container-informacoes_cabecalho">
						<img class="img-perfil" src="<?php echo $usuario['caminho_img_perfil']; ?>">
						<?php echo $usuario['nome_completo']; ?>
					</h2>
					<div class="container-informacoes_corpo container-dados_corpo">
						<div class="grupo-info">
							<div>
								<p class="titulo-informacao">CPF</p>
								<p><?php echo $usuario['cpf']; ?></p>
							</div>
							<div>
								<p class="titulo-informacao">RG</p>
								<p><?php echo $usuario['rg']; ?></p>
							</div>
						</div>
						<div class="grupo-info">
							<div>
								<p class="titulo-informacao">Data de Nascimento</p>
								<p><?php echo date('d/m/Y', strtotime($usuario['dt_nascimento'])); ?></p>
							</div>
							<div>
								<p class="titulo-informacao">Sexo</p>
								<p><?php if ($usuario['sexo'] == 'M') { echo 'Masculino'; } else { echo 'Feminino'; } ?></p>
							</div>
						</div>										
						<div class="grupo-info">
							<div>
								<p class="titulo-informacao">Telefone Celular</p>
								<p><?php echo $usuario['telefone_celular']; ?></p>
							</div>
							<div>
								<p class="titulo-informacao">E-mail</p>
								<p><?php echo $usuario['email']; ?></p>
							</div>
						</div>						
					</div>
					<div class="container-informacoes_componentes container-informacoes_rodape">
						<!-- Perfil -->
						<div>
							<p class="titulo-informacao">PERFIL</p>
							<p><?php if ($usuario['admin'] == 1) { echo 'Administrador'; } else { echo 'Cliente'; } ?></p>
							</div>

						<!-- Ações -->
						<div class="container-pedidos-acoes">
							<button type="button" class="btn-acao_pedido btn-detalhes_ped my-1">
								<i class="fa-solid fa-pen-to-square"></i> Alterar dados
							</button>
						</div>	
					</div>
				</div>
			</section>
			<section class="section-tela" id="section-enderecos" style="display: none;">
				<h4 class="mt-3"><i class="fa-solid fa-code mx-3"></i> Desculpe, essa tela está em fase de desenvolvimento.</h4>
				<p class="mx-3 mt-3">A FutureMob agradece a compreensão.</p>
			</section>
		</main>
		<footer id="footer"></footer>
		<script>
			function exibirTela(id_tela, id_botao) {
				var listaTelas = document.getElementsByClassName('section-tela');
				var listaBotoes = document.getElementsByClassName('menu-lateral_opcao');

				for (let i = 0; i < listaTelas.length; i++) {
					listaTelas[i].style.display = 'none';
					listaBotoes[i].classList.remove('btn-opcaoMenu_selecionado');
				}

				document.getElementById(id_tela).style.display = 'block';
				document.getElementById(id_botao).classList.add('btn-opcaoMenu_selecionado');
			}
		</script>
	</body>
</html>