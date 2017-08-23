<?php
/* https://getbootstrap.com/examples/grid/ */
/* ?add-to-cart=[PRODUCT-ID]&variation_id=[VARIATION-ID]&attribute_[ATTRIBUTE-NAME]=[ATTRIBUTE-SLUG]&attribute_[ATTRIBUTE-NAME]=[ATTRIBUTE-SLUG]&quantity=[VALUE] */
get_header();

global $post;
$productId  = $post->ID;
$product = new WC_Product($productId);

$permalink  = get_permalink($productId);
$retProduct = getAllProducts("", $productId);
$vProduct   = $retProduct[0];
?>

<section class="product-cake sec-prod-single">
    <div class="container">
        <?php
        // echo do_shortcode("[product_page id='$productId']");
        ?>

        <div id="hold-nome-produto">
            <h1><?php echo $vProduct->getTitle(); ?></h1>
        </div>
        <div class="row">
            <div class="col-md-7">
                <div class="slider-prod-single">
                    <?php
                    $arrGalleryUrl = $vProduct->getGallerySingleUrl();
                    $count = 1;
                    foreach($arrGalleryUrl as $imageUrl){
                        ?>

                        <div class="img-relative">
                            <img alt="<?php echo $vProduct->getTitle(); ?> - Imagem <?php echo $count; ?>" src="<?php echo $imageUrl; ?>" />
                        </div>

                        <?php
                        $count++;
                    }
                    ?>
                </div>
            </div>

            <div id="col-dir-info-prod" class="col-md-5">
                <div class="pt-15 pb-2">
                    <section class="sec-preco">
                        <h4 class="mt-0">Preço:</h4>

                        <?php
                        $precoDe  = ($vProduct->getSalePrice() > 0) ? $vProduct->getRegularPrice(): "";
                        $precoPor = $vProduct->getPrice();

                        if($precoDe > 0){
                            echo "<p class='preco-de'>de R$$precoDe</p>";
                        }
                        ?>

                        <p class="preco">por <span>R$<?php echo $precoPor; ?></span> à vista</p>

                        <input type="hidden" id="hddnSpProId" value="<?php echo $productId; ?>" />
                        <input id="qtdeItem" name="qty" class="qntdd_prod mask-qty-prod" value="01" maxlength="2" title="O campo de quantidade aceita apenas números, de 1 até 99." type="text" />
                        <button type="button" title="Adicionar ao carrinho" class="button btn-cart" id="btn-add-cart" onclick=" addToCart_SP(); " />
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            &nbsp;
                            Adicionar ao Carrinho <span class="ajax-loader">
                        </button>
                    </section>

                    <section class="sec-frete">
                        <h4 class="mt-0">Frete:</h4>

                        <input id="inptFrete" name="frete" class="inpt-frete mask-cep" value="" type="text">
                        <button type="button" title="Consultar" class="button btn-frete" id="btn-cons-frete" onclick=" calculaFrete('<?php echo $productId; ?>', $('#inptFrete').val(), 'retConsFrete'); ">
                            &nbsp;
                            Consultar Frete
                        </button>

                        <div class="mt-15" id="retConsFrete"></div>
                    </section>

                    <section class="">
                        <!-- nao sei como fazer ainda -->
                        <h4 class="mt-0">Cores disponíveis:</h4>
                        <p>As cores do produto são apenas uma sugestão de composé. Após a compra do item  entraremos em contato para conversarmos sobre as estampas =)</p>

                        <!--
                        <ul id="lista-variacoes">
                            <li> <a style="cursor: auto;"> <img data-id="7109" src="<?php bloginfo('template_url'); ?>/images/almofada_ourico_40x40_1.jpg" alt="Almofada Ouriço - 40x40"> </a> </li>
                            <li> <a style="cursor: auto;"> <img data-id="7109" src="<?php bloginfo('template_url'); ?>/images/almofada_ourico_40x40_2.jpg" alt="Almofada Ouriço - 40x40"> </a> </li>
                        </ul>
                        -->
                    </section>

                    <!--
                    <section class="sec-qdd-qtde" style="display: flex;">
                    </section>
                    -->

                    <section class="sec-frete">
                        Compartilhe:
                        &nbsp;
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($permalink); ?>" target="_blank"><img alt="Compartilhe <?php echo $vProduct->getTitle(); ?>" src="<?php bloginfo('template_url'); ?>/images/compartilhar-fcbk.png"></a>
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
                    echo nl2br($vProduct->getDescription());
                    ?>
                </div>
            </div>
        </div>

        <div class="row mais-info">
            <div class="conteudo">

                <?php
                $args = array (
                    'post_type' => 'product',
                    'post_ID' =>$product->id,  // Product Id
                    'status' => array("approve", "hold"), // Status you can also use 'hold', 'spam', 'trash',
                    //'number' => 1  // Number of comment you want to fetch I want latest approved post soi have use 1
                    );
                $comments = get_comments($args);
                $temComments = count($comments) > 0;
                ?>

                <!-- nao sei como fazer ainda -->
                <h3 class="mt-0 mb-15">Avaliações</h3>

                <?php
                if( $vProduct->getReviewCount() > 0 ){
                    ?>
                    <p style="font-size: 12px;" class="mb-15">
                        Quantidade: <?php echo $vProduct->getReviewCount(); ?>
                        <br />
                        Média: <?php echo $vProduct->getReviewAvg(); ?>
                    </p>
                    <?php
                }
                ?>

                <?php
                if($temComments){
                    ?>

                    <ul class="comentarios">
                        <?php
                        foreach($comments as $comment) :
                            $rating = get_comment_meta( $comment->comment_ID, "rating", true );
                            ?>

                            <li>
                                <p class="title">Avaliação: <?php echo ratingToString($rating); ?></p>
                                <p><?php echo $comment->comment_content; ?></p>
                                <p class="autor"><?php echo $comment->comment_author; ?></p>
                            </li>

                            <?php
                        endforeach;
                        ?>
                    </ul>

                    <?php
                }
                ?>

                <div class="mt-30">
                    <?php
                    if (get_option('woocommerce_review_rating_verification_required')
                        === 'no' || wc_customer_bought_product('',
                            get_current_user_id(), $product->get_id())) :

                        $commenter = wp_get_current_commenter();

                        $comment_form = array(
                            'title_reply' => $temComments ? __('Avalie o produto ' . $vProduct->getTitle(),
                                'woocommerce') : __('Seja o primeiro a avaliar o produto ',
                                'woocommerce').' &ldquo;'.get_the_title().'&rdquo;',
                            'title_reply_to' => __('Deixe um comentário: %s',
                                'woocommerce'),
                            'comment_notes_before' => '',
                            'comment_notes_after' => '',
                            'fields' => array(
                                'author' => '<p class="comment-form-author">'.'<label for="author">'.__('Nome',
                                    'woocommerce').' <span class="required">*</span></label> '.
                                '<input id="author" name="author" type="text" value="'.esc_attr($commenter['comment_author']).'" size="30" aria-required="true" /></p>',
                                'email' => '<p class="comment-form-email"><label for="email">'.__('Email',
                                    'woocommerce').' <span class="required">*</span></label> '.
                                '<input id="email" name="email" type="text" value="'.esc_attr($commenter['comment_author_email']).'" size="30" aria-required="true" /></p>',
                            ),
                            'label_submit' => __('Submit', 'woocommerce'),
                            'logged_in_as' => '',
                            'comment_field' => ''
                        );

                        if (get_option('woocommerce_enable_review_rating') === 'yes') {
                            $comment_form['comment_field'] = '
                                <p class="comment-form-rating"><label for="rating">'.__('Nota do Produto',
                                    'woocommerce').'</label>
                                    <select name="rating" id="">
                                        <option value="">'.__('Rate&hellip;',
                                    'woocommerce').'</option>
                                        <option value="5">'.__('Perfeito',
                                    'woocommerce').'</option>
                                        <option value="4">'.__('Bom',
                                    'woocommerce').'</option>
                                        <option value="3">'.__('Razoável',
                                    'woocommerce').'</option>
                                        <option value="2">'.__('Ruim',
                                    'woocommerce').'</option>
                                        <option value="1">'.__('Péssimo',
                                    'woocommerce').'</option>
                                    </select>
                                </p>';
                        }

                        $comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">'.__('Sua opinião',
                                'woocommerce').'</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';

                        comment_form(apply_filters('woocommerce_product_review_comment_form_args',
                                $comment_form));

                    else :
                        ?>

                        <p class="woocommerce-verification-required"><?php _e('Only logged in customers who have purchased this product may leave a review.',
                        'woocommerce');
                        ?></p>

                    <?php endif; ?>
                </div>
                
                <!--
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
                -->
            </div>
        </div>

<?php
get_footer();
?>
