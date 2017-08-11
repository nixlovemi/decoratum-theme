<?php
/* https://getbootstrap.com/examples/grid/ */
get_header();

global $post;
$productId  = $post->ID;
$permalink  = get_permalink($productId);
$retProduct = getAllProducts("", $productId);
$Product    = $retProduct[0];
?>

<section class="product-cake sec-prod-single">
    <div class="container">
        <div id="hold-nome-produto">
            <h1><?php echo $Product->getTitle(); ?></h1>
        </div>
        <div class="row">
            <div class="col-md-7">
                <div class="slider-prod-single">
                    <?php
                    $arrGalleryUrl = $Product->getGallerySingleUrl();
                    $count = 1;
                    foreach($arrGalleryUrl as $imageUrl){
                        ?>

                        <div class="img-relative">
                            <img alt="<?php echo $Product->getTitle(); ?> - Imagem <?php echo $count; ?>" src="<?php echo $imageUrl; ?>" />
                        </div>

                        <?php
                        $count++;
                    }
                    ?>
                </div>
            </div>

            <div id="col-dir-info-prod" class="col-md-5">
                <div class="pt-15 pb-2">
                    <section class="">
                        <!-- nao sei como fazer ainda -->
                        <h4 class="mt-0">Cores disponíveis:</h4>

                        <ul id="lista-variacoes">
                            <li> <a style="cursor: auto;"> <img data-id="7109" src="<?php bloginfo('template_url'); ?>/images/almofada_ourico_40x40_1.jpg" alt="Almofada Ouriço - 40x40"> </a> </li>
                            <li> <a style="cursor: auto;"> <img data-id="7109" src="<?php bloginfo('template_url'); ?>/images/almofada_ourico_40x40_2.jpg" alt="Almofada Ouriço - 40x40"> </a> </li>
                        </ul>
                    </section>

                    <section class="sec-preco">
                        <h4 class="mt-0">Preço:</h4>

                        <?php
                        $precoDe  = ($Product->getSalePrice() > 0) ? $Product->getRegularPrice(): "";
                        $precoPor = $Product->getPrice();

                        if($precoDe > 0){
                            echo "<p class='preco-de'>de R$$precoDe</p>";
                        }
                        ?>
                        
                        <p class="preco">por <span>R$<?php echo $precoPor; ?></span> à vista</p>

                        <input id="qty" name="qty" class="qntdd_prod" value="1" maxlength="2" title="O campo de quantidade aceita apenas números, de 1 até 99." type="text">
                        <button type="button" title="Adicionar ao carrinho" class="button btn-cart" id="btn-add-cart" onclick="alert(1)">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            &nbsp;
                            Adicionar ao Carrinho <span class="ajax-loader">
                        </button>
                    </section>

                    <!--
                    <section class="sec-qdd-qtde" style="display: flex;">
                    </section>
                    -->

                    <section class="sec-frete">
                        <h4 class="mt-0">Frete:</h4>

                        <input id="frete" name="frete" class="inpt-frete" value="" maxlength="8" title="" type="text">
                        <button type="button" title="Consultar" class="button btn-frete" id="btn-cons-frete" onclick="alert(2)">
                            &nbsp;
                            Consultar Frete
                        </button>
                    </section>

                    <section class="sec-frete">
                        Compartilhe:
                        &nbsp;
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($permalink); ?>" target="_blank"><img alt="Compartilhe <?php echo $Product->getTitle(); ?>" src="<?php bloginfo('template_url'); ?>/images/compartilhar-fcbk.png"></a>
                        <?php
                        #https://www.iconfinder.com/icons/343415/facebook_icon#size=128
                        ?>
                    </section>
                </div>
            </div>
        </div>

        <div class="row mais-info mb-15">
            <div class="conteudo pb-0">
                <h3>Descrição</h3>

                <div class="mb-15">
                    <?php
                    echo nl2br($Product->getDescription());

                    // echo wp_kses_post( $package_name );
                    // $Shipping = new WC_Shipping();
                    // $teste = $Shipping->get_shipping_methods();

                    // var_dump( $teste );
                    ?>
                </div>
            </div>
        </div>

        <div class="row mais-info">
            <div class="conteudo">
                <!-- nao sei como fazer ainda -->
                <h3 class="mt-0 mb-20">Comentários</h3>
                <ul class="comentarios">
                    <li>
                        <p class="title">Ótimo produto</p>
                        <p>O notebook é muito bom mesmo, acabamento muito bonito. Rápido e com acesso fácil para quem quiser colocar ainda mais memória (não acho necessário) ou até mesmo um SSD M.2, esse sim vale a pena investir. Aproveita que são poucos os que tem placa de vídeo dedicada e 2TB de HD por um preço tão bom.</p>
                        <p class="autor">Leandro</p>
                    </li>

                    <li>
                        <p class="title">Excelente aparelho</p>
                        <p>BOM HARDWARE i5, 8gb ram, 2TB HD, 940mx etc...., porém o que decepciona é a carcaça muito simples (como todos da serie F5-573) e a aparente fragilidade da tela, (parece que vai quebrar a qualquer momento - muito fina). Outro ponto é a necessidade de configurar para que a placa de vídeo funcione ( caso contrario o note sempre usa a placa onboard) . O teclado é razoável. Tem que acostumar com a posição das teclas - como tudo no brasil, não existe um padrão .</p>
                        <p class="autor">João</p>
                    </li>

                    <li>
                        <p class="title">Lindo, rápido e atualizado</p>
                        <p>O notebook é lindo, não se preocupem com o teclado, não é padrão americano como nas imagens, possui "ç", a iniciação demora em média 4 segundos, a placa creio ser a melhor (mais atualizada) dentre notebooks CONVENCIONAIS, não é um notebook gamer, mas garanto que também não decepciona nessa área. No geral me serviu com nota 10.</p>
                        <p class="autor">Claudia</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
?>
