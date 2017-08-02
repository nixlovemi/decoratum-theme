<?php get_header(); ?>
<div class="purple-arrow">
  &nbsp;
</div>
  
<?php
$arrProdutos = getArrProdutos();
if( count($arrProdutos) == 0 ){
	// faz alguma coisa qdo não tem itens disponíveis
}
else{
	foreach($arrProdutos as $produto){
		$V_ID = $produto["ID"];
		$V_PROD_NAME = $produto["nome"];
		$V_PROD_DESC = $produto["descricao"];
		$V_IMAGE_URL = $produto["thumb_URL"];
		$V_CART_URL = $produto["add_cart_url"];
		$V_PRECO = $produto["preco"]; // nao to fazendo preco promo ainda
		?>
		<div class="chart-cake">
  		<div class="container">
      	<div class="row">
          <div class="col-sm-6">
            <img src="<?php echo $V_IMAGE_URL; ?>" alt="<?php echo $V_PROD_NAME; ?>">
          </div>
          <div class="col-sm-6">
            <div class="tittle-chart-cake">
              <h1 class="pink-color">
                <?php echo $V_PROD_NAME; ?>
              </h1>
            </div>
            <?php
						/*
            <ul class="star">
              <li>
                <div class="icon-star-active">
                  &nbsp;
                </div>
              </li>
              <li>
                <div class="icon-star-active">
                  &nbsp;
                </div>
              </li>
              <li>
                <div class="icon-star-active">
                  &nbsp;
                </div>
              </li>
              <li>
                <div class="icon-star-disable">
                  &nbsp;
                </div>
              </li>
              <li>
                <div class="icon-star-disable">
                  &nbsp;
                </div>
              </li>
              <li>
                <span class="grey-color"><i>Required</i></span>
              </li>
            </ul>
						*/
						?>
            <div class="tittle-chart-cake mar-top-10">
            	<br />
              <h1 class="pink-color">
                R$<?php echo number_format($V_PRECO, 2, ',', '.') ?>
              </h1>
              <br />
            </div>
            <p class="mar-top-10 mar-btm-20">
              <?php echo $V_PROD_DESC; ?>
            </p>
            
            <form method="post" class="btn-inline" action="<?php echo $V_CART_URL; ?>">
              <button class="btn btn-pink-cake mar-right-10">Colocar no Carrinho</button>
            </form>
            
						<?php
						do_action('jigoshop_after_add_to_cart_button');
						
						/*
            <form class="btn-inline" action="product-details-page.html">
              <button class="btn btn-grey-cake">View Details</button>
            </form>
						*/
						?>
          </div>
        </div>
      </div>
    </div>
		<?php
	}
}
?>

<?php
/*
<div class="chart-cake">
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <img src="http://demo.codeopus.net/cakesdream/assets/images/cake-two-buy.png" alt="Cake-two">
      </div>
      <div class="col-sm-6">
        <div class="tittle-chart-cake">
          <h1 class="pink-color">
            Green<span class="grey-color"><i>Cake</i></span>
          </h1>
        </div>
        <ul class="star">
          <li>
            <div class="icon-star-active">
              &nbsp;
            </div>
          </li>
          <li>
            <div class="icon-star-active">
              &nbsp;
            </div>
          </li>
          <li>
            <div class="icon-star-active">
              &nbsp;
            </div>
          </li>
          <li>
            <div class="icon-star-disable">
              &nbsp;
            </div>
          </li>
          <li>
            <div class="icon-star-disable">
              &nbsp;
            </div>
          </li>
          <li>
            <span class="grey-color"><i>Required</i></span>
          </li>
        </ul>
        <div class="tittle-chart-cake mar-top-10">
          <h1 class="pink-color">
            $40
          </h1>
        </div>
        <p class="mar-top-10 mar-btm-20">
          Toffee sugar plum halvah liquorice brownie gummies <br>chocolate bar muffin candy canes. Dessert jelly-o <br>tootsie roll jelly sesame snaps icing.
        </p>
        <form class="btn-inline" action="chart-page.html">
          <button class="btn btn-pink-cake mar-right-10">Add to Chart</button>
        </form>
        <form class="btn-inline" action="product-details-page2.html">
          <button class="btn btn-grey-cake">View Details</button>
        </form>
      </div>
    </div>
  </div>
</div>
*/
?>

<div class="green-arrow">
  &nbsp;
</div>
<section class="more-cake text-center">
  <div class="container">
    <img src="http://crochepassoapasso.com.br/sonhodetrufa/wp-content/themes/sonhodetrufa-v1/images/trufa-white.png" class="mar-top-20" alt="Cake-White">
    <p class="mar-top-20 mar-btm-20">
      You can found&nbsp;<b>See More Product</b>&nbsp;below this.
    </p>
    <div class="row">
      <div class="col-sm-4">
        <div class="more-product">
          <img src="http://demo.codeopus.net/cakesdream/assets/images/shop-cake1.jpg" class="img-100" alt="More-Product">
        </div>
        <div class="detail-product">
          <div class="row">
            <div class="col-sm-6">
              <h1 class="normal-heading green-color">
                $40
              </h1>
            </div>
            <div class="col-sm-6">
              <b>Green </b><i>Cupcake</i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="more-product">
          <img src="http://demo.codeopus.net/cakesdream/assets/images/shop-cake2.jpg" class="img-100" alt="More-Product">
        </div>
        <div class="detail-product">
          <div class="row">
            <div class="col-sm-6">
              <h1 class="normal-heading green-color">
                $40
              </h1>
            </div>
            <div class="col-sm-6">
              <b>Cream </b><i>Cupcake</i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="more-product">
          <img src="http://demo.codeopus.net/cakesdream/assets/images/shop-cake3.jpg" class="img-100" alt="More-Product">
        </div>
        <div class="detail-product">
          <div class="row">
            <div class="col-sm-6">
              <h1 class="normal-heading green-color">
                $40
              </h1>
            </div>
            <div class="col-sm-6">
              <b>Choco </b><i>Cupcake</i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="green-arrow"></div>
<div class="pad-top-150"></div>
<?php get_footer(); ?>