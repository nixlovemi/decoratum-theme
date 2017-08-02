<?php
// header("Expires: ".gmdate('D, d M Y H:i:s', strtotime('+5 minutes')));
// header("Cache-Control: max-age=".strtotime('+365 days'));
// https://www.iconfinder.com/icons/343415/facebook_icon#size=128
// http://www.oppa.com.br/almofada-ourico-40x40

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("header_actions.php");

// get current page slug
global $post;
$current_page_slug = get_post($post)->post_name;
$class_wrap_header = "";

/* switch ($current_page_slug) {
  case 'produtos':
  $class_wrap_header = "purple-top-dot";
  break;
  default:
  $class_wrap_header = "";
  break;
  } */
// =====================
?>

<!DOCTYPE html>
<html class="no-js" lang="pt-br">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="Decoratum - Trufas Tradicionais" name="description" />
        <link href="<?php bloginfo('template_url'); ?>/images/favicon-32x32.png" rel="shortcut icon" />

        <title><?php bloginfo('blogname'); ?><?php wp_title(' | '); ?></title>

        <?php if (is_singular()): ?>
            <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <?php endif; ?>

        <link href="<?php bloginfo('template_url'); ?>/fonts/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" />
        <link href="<?php bloginfo('template_url'); ?>/css/bootstrap.css" rel="stylesheet" />
        <link href="<?php bloginfo('template_url'); ?>/css/font-family.css" rel="stylesheet" />
        <link href="<?php bloginfo('template_url'); ?>/css/slick.css" rel="stylesheet" />
        <link href="<?php bloginfo('template_url'); ?>/css/slick-theme.css" rel="stylesheet" />
        <link href="<?php bloginfo('template_url'); ?>/css/global.css" rel="stylesheet" />
        <link href="<?php bloginfo('template_url'); ?>/style.css" rel="stylesheet" />
        <link href="<?php bloginfo('template_url'); ?>/css/animate.css" rel="stylesheet" />
        <link href="<?php bloginfo('template_url'); ?>/css/jquery.fancybox.css" rel="stylesheet" type="text/css" />
        <link href="<?php bloginfo('template_url'); ?>/css/effect2.css" rel="stylesheet" type="text/css" />
        <link href="<?php bloginfo('template_url'); ?>/js/PgwModal/pgwmodal.min.css" rel="stylesheet" type="text/css" />
        <!--<script src="<?php bloginfo('template_url'); ?>/js/modernizr.custom.js"></script>-->

        <?php wp_head(); ?>

        <style>
            .mais-info .conteudo ul.comentarios li{
                border-top: solid 1px #CCC;
                padding: 15px 0 15px 0;
            }
            .mais-info .conteudo ul.comentarios li:last-child{
                border-bottom: solid 1px #CCC;
            }
            .mais-info .conteudo ul.comentarios li .title{
                font-weight: bold;
            }
            .mais-info .conteudo ul.comentarios li .autor{
                margin-bottom: 0;
            }
            .sec-carrinho{
                margin: 32px 0 25px 0;
            }
            .sec-carrinho #tb-carrinho{
                width: 100%;
                border-collapse: collapse;
                table-layout: auto;
                color: #550503;
                font-family: "Helvetica Neue",Helvetica,sans-serif;
                font-weight: 300;
                background-color: #FFF;
            }
            .sec-carrinho #tb-carrinho, .sec-carrinho #tb-carrinho th, .sec-carrinho #tb-carrinho td{
                border: 1px solid #DDD;
                padding: 0.5rem 0.625rem 0.625rem;
            }
            .sec-carrinho #tb-carrinho th, .sec-carrinho #tb-carrinho td{
                padding: 12px 5px;
            }
            .sec-carrinho #tb-carrinho .product-price{
                text-align: center;
                padding: 0 10px;
                white-space: nowrap;
                min-width: 100px;
            }
            .sec-carrinho #tb-carrinho .qtde_carrinho{
                font-size: 18px;
                padding: 10px 4px;
                text-align: center;
                height: 38px;
            }
            .sec-carrinho .ul-subtotal-list{
                float:right;
                width:40%;
            }
            .sec-carrinho .ul-subtotal-list li{
                display: block;
                overflow: hidden;
            }
            .sec-carrinho .subtotal .tb-subtotal{
                width:100%;
                border-bottom:solid 1px #DDD;
                padding-bottom:10px;
                margin-bottom:10px;
                font-size: 18px;
            }
            .sec-carrinho .subtotal .tb-subtotal th, .sec-carrinho .subtotal .tb-subtotal td{
                padding: 12px 5px;
            }
            .sec-carrinho .subtotal .tb-subtotal .texto{
                text-align:left;
                font-weight:bold;
            }
            .sec-carrinho .subtotal .tb-subtotal .valor{
                text-align:center;
                width: 40%;
            }
            .sec-prod-single .sec-frete .inpt-frete, .sec-carrinho .inpt-frete{
                width: 110px;
                height: 35px;
                line-height: 30px\9;
                float: left;
                text-align: center;
                font-size: 16px;
                padding: 0;
            }
            .sec-produtos .dv-titulo-coluna{
                padding-bottom: 10px;
                border-bottom: solid 1px #DDD;
                font-size: 18px;
            }
            .sec-produtos #categoria-produtos li{
                margin-bottom: 10px;
            }
            .sec-produtos #categoria-produtos li ul{
                margin-top: 10px;
                margin-left: 10px;
            }
            .sec-produtos #filtros-produtos{
                float: right;
            }
            .sec-produtos #filtros-produtos li{
                display: inline-table;
                margin-right: 50px;
            }
            .sec-produtos #filtros-produtos li:last-child{
                margin-right: 0;
            }
            .sec-produtos #ordenar-por{
                width: 108px !important;
                -webkit-appearance: none !important;
                -moz-appearance: none !important;
                appearance: none !important;
                padding: 2px 2px 2px 2px !important;
                /*background: url("http://cdn1.iconfinder.com/data/icons/cc_mono_icon_set/blacks/16x16/br_down.png") no-repeat scroll 94px center / 7px 7px #fff !important;*/
                height: auto;
                font-size: .775rem;
                background-color: #fff;

                -webkit-border-radius: 0px;
                background-color: #fafafa;
                background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgeD0iMTJweCIgeT0iMHB4IiB3aWR0aD0iMjRweCIgaGVpZ2h0PSIzcHgiIHZpZXdCb3g9IjAgMCA2IDMiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDYgMyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+PHBvbHlnb24gcG9pbnRzPSI1Ljk5MiwwIDIuOTkyLDMgLTAuMDA4LDAgIi8+PC9zdmc+);
                background-position: 100% center;
                background-repeat: no-repeat;
                border: 1px solid #ccc;
                padding: 0.5rem;
                font-size: 1.1rem;
                line-height: normal;
                border-radius: 0;
                height: 2.3125rem;
            }
            .sec-produtos #lista-produtos .item-produto img{
                width: 100%;
                height: auto;
                display: block;
                border: solid 5px #FFF;
            }
            #lista-produtos .item-produto .info-produto{
                width: 100%;
                display: inline-block;
                overflow: hidden;
            }
            #lista-produtos .item-produto .info-produto .nome{
                float: left;
                width: 70%;
                font-size: 12px;
            }
            #lista-produtos .item-produto .info-produto .preco{
                float: left;
                width: 30%;
                text-align: right;
                font-size: 12.5px;
            }
            #lista-produtos .item-produto .info-produto .preco .preco-de{
                text-decoration: line-through;
                font-size: 12px;
            }
            #lista-produtos .item-produto .info-produto .preco .preco-por{
                color: red;
                font-size: 13px;
            }
        </style>
    </head>
    <body class="demo-1">
        <div class="ip-container" id="ip-container">
            <!--initial header-->
            <?php
            /*
              <header class="ip-header">
              <div class="ip-loader">
              <svg class="ip-inner" height="60px" viewbox="0 0 80 80" width="60px">
              <path class="ip-loader-circlebg" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z"></path>
              <path class="ip-loader-circle" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z" id="ip-loader-circle"></path>
              </svg>
              </div>
              </header>
             */
            ?>
            <!--main content-->
            <div class="ip-main">
                <div class="top-highlight hide">
                    &nbsp;
                </div>
                <!-- Start Header Cake -->
                <section class="header-wrapper">
                    <header class="wrap-header <?php echo $class_wrap_header; ?>">
                        <div class="top-absolute">
                            <div class="top-header">
                                <div class="container">
                                    <div class="navbar-header visible-xs">
                                        <button class="navbar-toggle toggle-cake show-menu">
                                            <span class="sr-only">Toggle Navigation</span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                        <a class="navbar-brand navbar-cake" href="#">
                                            <img alt="Logo Decoratum" src="<?php bloginfo('template_url'); ?>/images/logo-100.png" />
                                        </a>
                                    </div>
                                    <nav>
                                        <ul class="header-nav hidden-xs">
                                            <li class="pad-top-0i">
                                                <img alt="Logo Decoratum" src="<?php bloginfo('template_url'); ?>/images/logo-decoratum-188-105.png" />
                                            </li>

                                            <li>
                                                <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                                            </li>

                                            <li>
                                                <a href="<?php echo esc_url(home_url('/')).'produtos'; ?>">Produtos</a>
                                            </li>

                                            <li>
                                                <?php
                                                // $qtItensCarrinho = getQtItensCarrinho();
                                                // $strCarrinho     = ($qtItensCarrinho == 0) ? "vazio" : "$qtItensCarrinho item(ns)";
                                                ?>
                                                <a href="<?php echo esc_url(home_url('/')).'carrinho'; ?>">Carrinho</a>
                                            </li>
                                            <li>
                                                <a href="blog-center.html">Contato</a>
                                            </li>
                                        </ul>

                                        <!--
                                        <ul class="header-nav hidden-xs">
                                            <li>
                                                <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo esc_url(home_url('/')).'produtos'; ?>">Produtos</a>
                                            </li>
                                            <li class="pad-top-0i">
                                                <img alt="Logo Decoratum" src="<?php bloginfo('template_url'); ?>/images/logo-150.png" />
                                            </li>
                                            <li>
                                        <?php
                                        // $qtItensCarrinho = getQtItensCarrinho();
                                        // $strCarrinho     = ($qtItensCarrinho == 0) ? "vazio" : "$qtItensCarrinho item(ns)";
                                        ?>
                                                <a href="<?php echo esc_url(home_url('/')).'carrinho'; ?>">Carrinho<br /><small>[<?php echo $strCarrinho; ?>]</small></a>
                                            </li>
                                            <li>
                                                <a href="blog-center.html">Contato</a>
                                            </li>
                                        </ul>
                                        -->
                                    </nav>
                                    <!-- Start Mega Menu Cake -->
                                    <div class="mega-menu hide">
                                        <div class="tittle-mega">
                                            <h4>
                                                - Menu -
                                            </h4>
                                        </div>
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <ul class="list-mega">
                                                        <li>
                                                            <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo esc_url(home_url('/')).'produtos'; ?>">Produtos</a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo esc_url(home_url('/')).'carrinho'; ?>">Carrinho <small>[<?php echo $strCarrinho; ?>]</small></a>
                                                        </li>
                                                        <li>
                                                            <a href="blog-center.html">Contato</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <?php
                                                /*
                                                  <div class="col-sm-4">
                                                  <ul class="list-mega">
                                                  <li class="bottom-red-border">
                                                  Blog
                                                  </li>
                                                  <li>
                                                  <a href="blog.html">Blog Left Content</a>
                                                  </li>
                                                  <li>
                                                  <a href="blog-right-content.html">Blog Right Content</a>
                                                  </li>
                                                  <li>
                                                  <a href="blog-center.html">Blog Center</a>
                                                  </li>
                                                  </ul>
                                                  </div>
                                                  <div class="col-sm-4">
                                                  <ul class="list-mega">
                                                  <li class="bottom-red-border">
                                                  Gallery
                                                  </li>
                                                  <li>
                                                  <a href="gallery.html">Gallery 3 Column</a>
                                                  </li>
                                                  <li>
                                                  <a href="gallery-4-column.html">Gallery 4 Column</a>
                                                  </li>
                                                  <li>
                                                  <a href="gallery-dot.html">Gallery With Text</a>
                                                  </li>
                                                  </ul>
                                                  </div>
                                                  <div class="col-sm-4">
                                                  <ul class="list-mega">
                                                  <li class="bottom-red-border">
                                                  OTHER PAGEs
                                                  </li>
                                                  <li>
                                                  <a href="chart-page.html">Chart Page</a>
                                                  </li>
                                                  <li>
                                                  <a href="product-details-page.html">Product Details</a>
                                                  </li>
                                                  <li>
                                                  <a href="privacy-policy.html">Privacy Policy</a>
                                                  </li>
                                                  <li>
                                                  <a href="terms-of-use.html">Terms Of Use</a>
                                                  </li>
                                                  <li>
                                                  <a href="404.html">404</a>
                                                  </li>
                                                  </ul>
                                                  </div>
                                                 */
                                                ?>
                                            </div>
                                            <div class="div text-center">
                                                <button class="btn btn-pink-cake mar-top-20 close-menu">Fechar Menu</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Mega Menu Cake -->
                                </div>
                            </div>
                            <div class="triangle-no-animate">
                                &nbsp;
                            </div>
                        </div>
                        <?php
                        if (is_home()) {
                            ?>
                            <div class="tittle-cake text-center pad-top-150">
                                <div class="container">
                                    <?php
                                    /*
                                      <h1>
                                      Produtos feitos PRA VOCÊ
                                      </h1>
                                     */
                                    ?>

                                    <?php
                                    /*
                                      <h2>
                                      Produtos feitos
                                      </h2>
                                      <h1>
                                      PRA VOCÊ
                                      </h1>
                                     */
                                    ?>
                                </div>
                            </div>
                            <div class="slider-cake2">
                                <div class="container pad-md-100">
                                    <div class="center2">
                                        <div class="img-relative">
                                            <img alt="Trufa Tradicional" src="<?php bloginfo('template_url'); ?>/images/cartonagem-1.png" />
                                            <?php
                                            /*
                                              <div class="price-cake hidden-xs">
                                              <p>
                                              R$3,50
                                              </p>
                                              </div>
                                             */
                                            ?>
                                        </div>
                                        <div class="img-relative">
                                            <img alt="Trufa Tradicional - Menta" src="<?php bloginfo('template_url'); ?>/images/cartonagem-2.png" />
                                            <?php
                                            /*
                                              <div class="price-cake hidden-xs">
                                              <p>
                                              R$3,50
                                              </p>
                                              </div>
                                             */
                                            ?>
                                        </div>
                                        <div class="img-relative">
                                            <img alt="Trufa Tradicional - Cereja" src="<?php bloginfo('template_url'); ?>/images/cartonagem-3.png" />
                                            <?php
                                            /*
                                              <div class="price-cake hidden-xs">
                                              <p>
                                              R$3,50
                                              </p>
                                              </div>
                                             */
                                            ?>
                                        </div>
                                        <?php
                                        /*
                                          <div class="img-relative">
                                          <img alt="Trufa Tradicional - Côco" src="<?php bloginfo('template_url'); ?>/images/cartonagem-1.png" />

                                          <div class="price-cake hidden-xs">
                                          <p>
                                          R$3,50
                                          </p>
                                          </div>
                                          </div>

                                          <div>
                                          <img alt="Cake-Two" src="images/cake-two.png" />
                                          </div>
                                          <div>
                                          <img alt="Cake-Three" src="images/cake-three.png" />
                                          </div>
                                          <div>
                                          <img alt="Cake-Four" src="images/cake-four.png" />
                                          </div>

                                          <div>
                                          <img alt="Cake-Five" src="images/cake-five.png" />
                                          </div>
                                         */
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                            /*
                              <div class="gray-table mar-to-top border-brown">
                              &nbsp;
                              </div>

                              <div class="green-arrow">
                              &nbsp;
                              </div>
                             */
                        } else if ($current_page_slug == 'produtos' || $current_page_slug
                            == 'carrinho' || $current_page_slug == 'produto') {
                            ?>
                            <div class="tittle-sub-top pad-top-150">
                                <div class="container">
                                    <a href="<?php echo esc_url(home_url('/')); ?>">Home</a> /
                                    <h1>
                                        <?php echo ucfirst($current_page_slug); ?>
                                    </h1>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </header>
