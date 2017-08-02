<?php get_header(); ?>
<div class="purple-arrow">
  &nbsp;
</div>
<?php
// echo jigoshop_cart::get_cart_total();
?>
<div class="chart-cake">
	<div class="container">
  
  	<?php
		$jigoshop_options = Jigoshop_Base::get_options();
		$cart_contents = jigoshop_cart::$cart_contents;
		
		if ( ! empty( $cart_contents ) ) {
			?>
      <button style="margin-bottom:10px;" class="btn btn-pink-cake" onclick="continueShop();">< Continuar Comprando</button>
      <table class="table table-bordered table-hover hidden-xs">
        <thead>
          <tr>
            <th>
              Nº
            </th>
            <th>
              Produto
            </th>
            <th>
              Descri&ccedil;&atilde;o
            </th>
            <th>
              Quantidade
            </th>
            <th>
              Pre&ccedil;o
            </th>
            <th>
              &nbsp;
            </th>
          </tr>
        </thead>
        <tbody>
      <?php
			$i = 1;
			$divHiddenHTML = '<div class="visible-xs">';
			
			foreach ( $cart_contents as $key => $value ) {
				$_product = $value['data'];
				$_product_arr = (array) $_product;
				$_product_arr = getArrProdutos($_product_arr["ID"]);
				$_product_arr = $_product_arr[0];
				
				$thumb_ID = $_product_arr['thumb_ID'];
				$thumb_URL = (is_numeric($thumb_ID)) ? getThumbByID($thumb_ID, array(100,100)) : 'http://crochepassoapasso.com.br/sonhodetrufa/wp-content/plugins/jigoshop/assets/images/placeholder.png';
				// esc_url( jigoshop_cart::get_remove_url($key))
				
				if ( $_product->exists() && $value['quantity'] > 0 ) {
					?>
          <tr>
          	<td>
              <?php echo $i; ?>
            </td>
            <td>
              <img alt="<?php echo esc_attr( $_product->get_title() ); ?>" class="img-100px" src="<?php echo $thumb_URL; ?>" />
            </td>
            <td class="chart-description">
              <h4 class="mar-btm-0 prod-title-cart">
                <?php echo $_product->get_title(); ?>
              </h4>
              <p class="mar-top-10 pad-top-10 top-dashed">
                <?php echo strip_tags($_product_arr['descricao']); ?>
              </p>
            </td>
            <td>
            	<select class="qtd-item-carrinho" data-id-prod="<?php echo $_product_arr["ID"]; ?>">
              	<?php
								for($ii=1; $ii<=15; $ii++){
									$selected = ($ii == $value['quantity']) ? ' selected ': '';
									?>
                  <option <?php echo $selected; ?> value="<?php echo $ii; ?>"><?php echo $ii; ?></option>
                  <?php
								}
								?>
              </select>
            </td>
            <td>
              <span class="preco-item-carrinho"><?php echo $_product->get_price_html(); ?></span>
            </td>
            <td class="chart-center">
              <button class="btn btn-pink-cake mar-right-10" onclick="removeCartItem(<?php echo $_product_arr["ID"]; ?>)">Excluir</button>
            </td>
          </tr> 
          <?php
					
					$divHiddenHTML .= '
					  <div class="top-cake-table">
							<div class="top-cake-no">
								Nº : '.$i.'
							</div>
							<div class="top-cake-product">
								Produto : '.$_product->get_title().'
							</div>
							<div class="top-cake-desription">
								Descri&ccedil;&atilde;o : 
								<p>
									'.strip_tags($_product_arr['descricao']).'
								</p>
								<p>
								  <strong>'.$_product->get_price_html().'</strong>
								</p>
							</div>
							<div class="top-cake-img">
								<img alt="'.esc_attr( $_product->get_title() ).'" class="img-150px" src="'.$thumb_URL.'" />
							</div>
							<div class="top-cake-button text-center">
								<button class="btn btn-pink-cake mar-right-10">Checkout</button>
							</div>
						</div>
					';
					
					$i++;
				}
			}
			?>
        </tbody>
      </table>
      
      <?php
			$divHiddenHTML .= '</div>';
			echo $divHiddenHTML;
			
			echo '<p class="total"><strong>';
			echo __( ( ( $jigoshop_options->get_option( 'jigoshop_prices_include_tax') == 'yes' ) ? 'Total' : 'Subtotal' ), 'jigoshop' );
			echo ':</strong> ' . jigoshop_cart::get_cart_total();
			echo '</p>';
			
			echo '<p align="right">';
			echo '  <button class="btn btn-grey-cake mar-right-10 botao-limpar-carr" onclick="clearCart();">Limpar Carrinho</button>';
			echo '  <button class="btn btn-blue-cake mar-right-10 botao-atualizar-carr" onclick="updateCart();">Atualiza Carrinho</button>';
			echo '  <button class="btn btn-pink-cake botao-finalizar-carr" onclick="finishShop();">Finalizar Compra</button>';
			echo '</p>';
		}
		else{
			?>
      <p>Nenhum item no carrinho :(</p>
      <?php
		}
		?>
  </div>
</div>
<div class="pad-top-150"></div>
<?php get_footer(); ?>