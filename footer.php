				</section>
        <!-- Start Footer Cake -->
        <footer>
          <div class="triangle-no-animate">
            &nbsp;
          </div>
          <div class="container">
            <?php
            /*
            <div class="abs-logo-footer">
              <img alt="Logo Sonho de Trufa" src="<?php bloginfo('template_url'); ?>/images/logo.png" />
            </div>
             */
            ?>
            <div class="top-footer">
              <div class="row">
                <div class="col-sm-6">
                  <img alt="Logo White" class="img-cake-center-res" src="<?php bloginfo('template_url'); ?>/images/logo-decoratum-white-v2.png?random=123" />
                </div>
                <div class="col-sm-6 text-right">
                  <ul class="sosmed-cake">
                    <li>
                      <div class="center-sosmed">
                        <p class="icon icon-facebook">&nbsp;
                        </p>
                      </div>
                    </li>
                    <li>
                      <div class="center-sosmed">
                        <p class="icon icon-twitter">&nbsp;
                        </p>
                      </div>
                    </li>
                    <!--<li>
                      <div class="center-sosmed">
                        <p class="icon icon-behance">&nbsp;
                        </p>
                      </div>
                    </li>
                    <li>
                      <div class="center-sosmed">
                        <p class="icon icon-dribbble">&nbsp;
                        </p>
                      </div>
                    </li>-->
                    <li>
                      <div class="center-sosmed">
                        <p class="icon icon-pinterest">&nbsp;
                        </p>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="line-top-white mar-btm-20 mar-top-20">
              &nbsp;
            </div>
            <div class="content-about-footer">
              <!-- Column -->
              <div class="col-sm-4">
                <?php
								/*
                <h4>
                  Decoratum
                </h4>
								*/
								?>
                
                <br />
                <p class="mar-btm-20">
                  Produtos incríveis feito com amor para você.
                </p>
                <p class="mar-btm-20">
                  contato@decoratum.com.br
                </p>
                <p class="mar-btm-20">
                  Tel: <strong>019 2222-3333</strong>
                </p>
              </div>
              <!-- Column -->
              <div class="col-sm-4 hidden-xs">
                <?php
                $arrProducts = getAllProducts("", "", "produto_footer");
                if(count($arrProducts) > 0){
                    ?>
                    <ul class="list-picture-footer">
                        <?php
                        foreach($arrProducts as $Product){
                            ?>
                            <li>
                                <a class="" href="<?php echo $Product->getProductURL(); ?>">
                                    <img alt="Img-sm-picture" class="img-100" src="<?php echo $Product->getImageThumbUrl(); ?>" />
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                    <?php
                }
                ?>

                <?php
                /*
                <ul class="list-picture-footer">
                  <li>
                    <a class="fancybox" data-fancybox-group="contentgallery" href="<?php bloginfo('template_url'); ?>/images/cartonagem-1-footer.png"><img alt="Img-sm-picture" class="img-100" src="<?php bloginfo('template_url'); ?>/images/cartonagem-1-footer.png" /></a>
                  </li>
                  <li>
                    <a class="fancybox" data-fancybox-group="contentgallery" href="<?php bloginfo('template_url'); ?>/images/cartonagem-2-footer.png"><img alt="Img-sm-picture" class="img-100" src="<?php bloginfo('template_url'); ?>/images/cartonagem-2-footer.png" /></a>
                  </li>
                  <li>
                    <a class="fancybox" data-fancybox-group="contentgallery" href="<?php bloginfo('template_url'); ?>/images/cartonagem-3-footer.png"><img alt="Img-sm-picture" class="img-100" src="<?php bloginfo('template_url'); ?>/images/cartonagem-3-footer.png" /></a>
                  </li>
                  <li>
                    <a class="fancybox" data-fancybox-group="contentgallery" href="<?php bloginfo('template_url'); ?>/images/cartonagem-1-footer.png"><img alt="Img-sm-picture" class="img-100" src="<?php bloginfo('template_url'); ?>/images/cartonagem-1-footer.png" /></a>
                  </li>
                  <li>
                    <a class="fancybox" data-fancybox-group="contentgallery" href="<?php bloginfo('template_url'); ?>/images/cartonagem-2-footer.png"><img alt="Img-sm-picture" class="img-100" src="<?php bloginfo('template_url'); ?>/images/cartonagem-2-footer.png" /></a>
                  </li>
                  <li>
                    <a class="fancybox" data-fancybox-group="contentgallery" href="<?php bloginfo('template_url'); ?>/images/cartonagem-3-footer.png"><img alt="Img-sm-picture" class="img-100" src="<?php bloginfo('template_url'); ?>/images/cartonagem-3-footer.png" /></a>
                  </li>
                  <li>
                    <a class="fancybox" data-fancybox-group="contentgallery" href="<?php bloginfo('template_url'); ?>/images/cartonagem-1-footer.png"><img alt="Img-sm-picture" class="img-100" src="<?php bloginfo('template_url'); ?>/images/cartonagem-1-footer.png" /></a>
                  </li>
                  <li>
                    <a class="fancybox" data-fancybox-group="contentgallery" href="<?php bloginfo('template_url'); ?>/images/cartonagem-2-footer.png"><img alt="Img-sm-picture" class="img-100" src="<?php bloginfo('template_url'); ?>/images/cartonagem-2-footer.png" /></a>
                  </li>
                </ul>
                
                <div class="clear"></div>
                <p style="text-align:center;">
                  Veja também
                </p>
                */
                ?>
              </div>
              <!-- Column -->
              <div class="col-sm-4">
                <ul class="list-link-home">
                  <li>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
                  </li>
                  <li>
                    <a href="<?php echo esc_url(home_url( '/' )) . 'produtos'; ?>">Produtos</a>
                  </li>
                  <li>
                    <a href="<?php echo esc_url(home_url( '/' )) . 'carrinho'; ?>">Carrinho</a>
                  </li>
                  <li>
                    <a href="<?php echo esc_url(home_url( '/' )) . 'meus-pedidos'; ?>">Meus Pedidos</a>
                  </li>
                  <li>
                    <a href="<?php echo esc_url(home_url( '/' )) . 'politica-de-privacidade'; ?>">Política de privacidade</a>
                  </li>
                  <li>
                    <a href="<?php echo esc_url(home_url( '/' )) . 'trocas-e-devolucoes'; ?>">Trocas e Devoluções</a>
                  </li>
                  <!--
                  <li>
                    <a href="javascript:;">Prazo de Entrega</a>
                  </li>
                  
                  <li>
                    <a href="blog-center.html">Blog</a>
                  </li>
                  -->
                </ul>
              </div>
            </div>
            <!--
            <div class="logo-dn">
              <img alt="Delip Nugraha" src="images/dn.png" />
            </div>
            -->
          </div>
        </footer>
        <!-- End Option Cake -->
      </div>
    </div>

    <script src="<?php bloginfo('template_url'); ?>/js/jquery.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/jquery.fancybox.pack.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/modernizr.custom.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/slick.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/wow.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/custom.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/bootstrap.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/classie.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/PgwModal/pgwmodal.min.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/jquery.maskedinput/dist/jquery.maskedinput.min.js"></script>

    <!--<script src="<?php bloginfo('template_url'); ?>/js/pathLoader.js"></script>-->
    <!--<script src="<?php bloginfo('template_url'); ?>/js/galleria/galleria-1.5.7.min.js"></script>-->
    
    <!--<script src="<?php bloginfo('template_url'); ?>/js/main.js"></script>-->
    <script src="<?php bloginfo('template_url'); ?>/master.js"></script>
    <script type="text/javascript">
      new WOW().init();
    </script>
    
    <?php wp_footer(); ?>
  </body>
</html>