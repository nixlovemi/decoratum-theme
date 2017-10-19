<?php get_header(); ?>

<!-- Start About Cake -->
<section class="about-cake">
    <div class="container">
        <!-- About Content -->
        <h2 class="hide">&nbsp;
        </h2>
        <div class="about-content">
            <img alt="Trufa White" src="<?php bloginfo('template_url'); ?>/images/decoratum-white-v2.png" />
            <p>
                Aqui vai um texto explicando o quão lindos e maravilhosos são os produtos que vendemos!
            </p>
        </div>
    </div>
</section>
<!-- End About Cake -->
<!-- Start Product Cake -->
<section class="product-cake">
    <div class="container">
        <!-- Product Tittle -->
        <div class="product-tittle">
            <img alt="Trufa Purple" src="<?php bloginfo('template_url'); ?>/images/decoratum-pink-v2.png" />
            <h2>
                Produtos
            </h2>
        </div>
        <!-- Product Content -->
        <?php
        echo getHtmlProdDestHome();
        ?>
    </div>
</section>
<!-- End Product Cake -->

<!-- Start Team Cake -->
<section class="abouts-cake">
    <!-- onde ficava OUR TEAM -->
    <!-- xxxxxxxxxxxxxxxxxxxx -->
    <div class="tittle-cake text-center mar-top-20">
        <div class="container">
            <img alt="Trufa Pink" src="<?php bloginfo('template_url'); ?>/images/decoratum-pink-v2.png" />
            <h2 class="pink-color">
                Contato
            </h2>
        </div>
    </div>
    <div class="container mar-top-20" id="home-contato">
        <div class="col-sm-offset-3 col-sm-6">
            <div class="form-group">
                <input id="name-cont-home" class="form-control form-default-cakes" placeholder="Nome Completo" type="text" />
            </div>
            <div class="form-group">
                <input id="mail-cont-home" class="form-control form-default-cakes" placeholder="Email" type="email" />
            </div>
            <div class="form-group">
                <textarea id="msg-cont-home" class="form-control form-default-cakes" placeholder="Sua Mensagem"></textarea>
            </div>
            <div class="form-group">
                <button onclick="sendContact_Home()" class="btn btn-lg btn-pink-cake btn-send mar-top-20">Enviar</button>
            </div>
        </div>
    </div>
</section>
<!-- End Option Cake -->
<?php get_footer(); ?>