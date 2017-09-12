<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

<section class="product-cake sec-carrinho">
    <div class="container">
        <center>
            <img class="img-responsive" alt="Página não encontrada | Decoratum" src="<?php bloginfo('template_url'); ?>/images/unicorn-404.png" />
        </center>

        <p align="center" class="mt-25" style="font-size: 20px;">A página ou conteúdo solicitado parece não existir.</p>
        <p align="center" class="mt-25" style="font-size: 20px;">Utilize os menus para voltar a navegar no nosso site =)</p>
    </div>
</section>

<?php get_footer(); ?>