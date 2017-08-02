<?php
	/* Template Name: Carrinho - Decoratum */
	/* https://getbootstrap.com/examples/grid/ */
	get_header();
?>

<section class="product-cake sec-carrinho">
	<div class="container">
		<div style="width:100%; height: 170px; background-color:#abc2e8; color: #000; margin-bottom:30px;">
			TALVEZ COLOCAR UM BANNER AQUI
		</div>

		<table id="tb-carrinho" class="mb-25">
			<thead>
				<tr>
					<th style="text-align:center;">Produto</th>
					<th style="width:16%; text-align:center;">Preço</th>
					<th style="width:16%; text-align:center;">Quantidade</th>
					<th style="width:16%; text-align:center;">Subtotal</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<img style="float: left; margin-right: 15px;" alt="Almofada Ouriço - 40x40" src="<?php bloginfo('template_url'); ?>/images/almofada_ourico_40x40_1.jpg">
						Almofada Ouriço - 40x40
						<br />
						Tamanho: 40 x 40 x 0,16 cm
						<br />
						Entrega em até 7 dias úteis para São Paulo.
					</td>
					<td class="product-price">
						R$49,99
					</td>
					<td class="product-price">
						<input name="qty" class="qntdd_prod qtde_carrinho" value="1" maxlength="2" title="O campo de quantidade aceita apenas números, de 1 até 99." type="text">
					</td>
					<td class="product-price">
						R$49,99
					</td>
				</tr>

				<tr>
					<td>
						<img style="float: left; margin-right: 15px;" alt="Almofada Ouriço - 40x40" src="<?php bloginfo('template_url'); ?>/images/almofada_ourico_40x40_2.jpg">
						Almofada Ouriço - 50x50
						<br />
						Tamanho: 41 x 41 x 0,17 cm
						<br />
						Entrega em até 6 dias úteis para São Paulo.
					</td>
					<td class="product-price">
						R$50,00
					</td>
					<td class="product-price">
						<input name="qty" class="qntdd_prod qtde_carrinho" value="2" maxlength="2" title="O campo de quantidade aceita apenas números, de 1 até 99." type="text">
					</td>
					<td class="product-price">
						R$100,00
					</td>
				</tr>
			</tbody>
		</table>

		<ul class="ul-subtotal-list">
			<li>
				<div class="subtotal">
					<table class="tb-subtotal">
						<tbody>
							<tr>
								<td class="texto">Subtotal</td>
								<td class="valor">R$199,98</td>
							</tr>
						</tbody>
					</table>
				</div>
			</li>

			<li>
				<div class="subtotal">
					<table class="tb-subtotal">
						<tbody>
							<tr>
								<td class="texto">Frete</td>
								<td class="">
									<div style="float: right;">
										<input style="width: 100%" id="frete_carrinho" name="frete_carrinho" class="inpt-frete" value="" maxlength="8" title="" type="text">
										<br />
										<button style="width: 100%;" type="button" title="Consultar" class="button btn-frete mt-10 mb-20" id="btn-cons-frete" onclick="alert(2)">
					 						&nbsp;
											Consultar
										</button>
										<br />
										<small style="width:100%; text-align:center; display:block;">Frete R$10,00
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</li>

			<li>
				<div class="subtotal">
					<table class="tb-subtotal">
						<tbody>
							<tr>
								<td class="texto">Cupom</td>
								<td class="">
									<div style="float: right;">
										<input style="width: 100%" id="cupom_carrinho" name="cupom_carrinho" class="inpt-frete" value="" maxlength="14" title="" type="text">
										<br />
										<button style="width: 100%;" type="button" title="Consultar" class="button btn-frete mt-10 mb-20" id="btn-cons-frete" onclick="alert(2)">
					 						&nbsp;
											Adicionar
										</button>
										<br />
										<small style="width:100%; text-align:center; display:block;">Desconto -R$5,00
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</li>

			<li>
				<div class="subtotal">
					<table class="tb-subtotal">
						<tbody>
							<tr>
								<td class="texto">TOTAL</td>
								<td class="valor" style="font-weight:bold;">R$204,98</td>
							</tr>
							<tr>
								<td colspan="2" class="texto">
									<button style="width: 60%; float:right; font-size:18px;" type="button" title="Consultar" class="button btn-frete mt-10 mb-20" id="btn-cons-frete" onclick="alert(2)">
										&nbsp;
										Finalizar Compra
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</li>
		</ul>
  </div>
</section>

<?php
	get_footer();
?>
