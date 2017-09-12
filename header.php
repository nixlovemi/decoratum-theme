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
$current_post_type = get_post($post)->post_type;
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
        <meta content="Decoratum - Produtos feitos para você" name="description" />
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

        <?php wp_head(); ?>

        <style>
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
                                        <a class="navbar-brand navbar-cake" href="<?php echo esc_url(home_url('/')); ?>">
                                            <img id="logo-decoratum-mobile" alt="Logo Decoratum" src="<?php bloginfo('template_url'); ?>/images/logo-decoratum-188-105.png" />
                                        </a>
                                    </div>
                                    <nav>
                                        <ul class="header-nav hidden-xs">
                                            <li class="pad-top-0i">
                                                <a href="<?php echo esc_url(home_url('/')); ?>"><img alt="Logo Decoratum" src="<?php bloginfo('template_url'); ?>/images/logo-decoratum-188-105.png" /></a>
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
                                                            <a href="<?php echo esc_url(home_url('/')).'carrinho'; ?>">Carrinho</a>
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

                            <?php
                            global $wpdb;
                            $arrSlider = array();

                            $sql = "SELECT post_id, meta_value
                                    FROM wp_postmeta
                                    WHERE meta_key = 'slider_home_url_image'
                                    ORDER BY meta_id";
                            $conn = $wpdb->get_results($sql);
                            foreach($conn as $row){
                                $vPostId = $row->post_id;
                                $vMetaId = $row->meta_value;

                                $productId = $vPostId;
                                $arrProd = getAllProducts("", $productId);
                                if(count($arrProd) > 0){
                                   $Produto = $arrProd[0];
                                   $prodUrl = $Produto->getProductURL();
                                   $htmlImg = wp_get_attachment_image( $vMetaId, 'full' );

                                   if(!array_key_exists($vPostId, $arrSlider)){
                                        $arrSlider[$vPostId] = array();
                                        $arrSlider[$vPostId]["htmlImg"] = $htmlImg;
                                        $arrSlider[$vPostId]["urlLink"] = $prodUrl;
                                    }
                                }
                            }

                            if( count($arrSlider) >= 0 ){
                                ?>

                                <div class="slider-cake2">

                                    <div class="container pad-md-100">
                                        <div class="center2">
                                            <?php
                                            foreach($arrSlider as $slider){
                                                ?>

                                                <div class="img-relative">
                                                    <a href="<?php echo $slider["urlLink"] ?>">
                                                        <?php echo $slider["htmlImg"] ?>
                                                    </a>
                                                </div>

                                                <!--
                                                <div class="img-relative">
                                                    <a href="<?php echo $slider["urlLink"] ?>">
                                                        <?php echo $slider["htmlImg"] ?>
                                                    </a>
                                                </div>

                                                <div class="img-relative">
                                                    <a href="<?php echo $slider["urlLink"] ?>">
                                                        <?php echo $slider["htmlImg"] ?>
                                                    </a>
                                                </div>
                                                -->

                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>

                                </div>

                                <?php
                            }
                            ?>

                            <?php
                            /*
                            <div class="slider-cake2">
                                <div class="container pad-md-100">
                                    <div class="center2">
                                        <div class="img-relative">
                                            <img alt="Trufa Tradicional" src="<?php bloginfo('template_url'); ?>/images/cartonagem-1.png" />

                                              <div class="price-cake hidden-xs">
                                              <p>
                                              R$3,50
                                              </p>
                                              </div>
                                        </div>
                                        <div class="img-relative">
                                            <img alt="Trufa Tradicional - Menta" src="<?php bloginfo('template_url'); ?>/images/cartonagem-2.png" />

                                              <div class="price-cake hidden-xs">
                                              <p>
                                              R$3,50
                                              </p>
                                              </div>
                                        </div>
                                        <div class="img-relative">
                                            <img alt="Trufa Tradicional - Cereja" src="<?php bloginfo('template_url'); ?>/images/cartonagem-3.png" />

                                              <div class="price-cake hidden-xs">
                                              <p>
                                              R$3,50
                                              </p>
                                              </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            */

                            
                            /*
                              <div class="gray-table mar-to-top border-brown">
                              &nbsp;
                              </div>

                              <div class="green-arrow">
                              &nbsp;
                              </div>
                            */
                        } else {
                            $strHeader = ($current_post_type == 'product') ? "Produto": $current_page_slug;
                            ?>
                            <div class="tittle-sub-top pad-top-150">
                                <div class="container">
                                    <a href="<?php echo esc_url(home_url('/')); ?>">Home</a> /
                                    <h1>
                                        <?php echo ucfirst($strHeader); ?>
                                    </h1>
                                </div>
                            </div>
                            <?php
                        } /*else if ($current_page_slug == 'produtos' || $current_page_slug
                            == 'carrinho' || $current_page_slug == 'produto' || $current_post_type == 'product' || $current_page_slug == 'produtos') {

                            $strHeader = ($current_post_type == 'product') ? "Produto": $current_page_slug;
                            ?>
                            <div class="tittle-sub-top pad-top-150">
                                <div class="container">
                                    <a href="<?php echo esc_url(home_url('/')); ?>">Home</a> /
                                    <h1>
                                        <?php echo ucfirst($strHeader); ?>
                                    </h1>
                                </div>
                            </div>
                            <?php
                        }*/
                        ?>
                    </header>
