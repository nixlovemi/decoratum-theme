<?php
/* Template Name: Contato - Decoratum */
get_header();
?>

<section class="product-cake sec-produtos">
    <div class="container">
        <div class="row mt-20 mb-20">
            <div class="col-md-6">
                <div class="tittle-cake text-center mar-top-20">
                    <div class="">
                        <img alt="Trufa Pink" src="<?php bloginfo('template_url'); ?>/images/decoratum-pink-v2.png" />
                        <h2 class="pink-color">
                            Informação
                        </h2>
                    </div>
                </div>
                <div class="mar-top-20" id="home-contato">
                    <p>Obrigado por seu interesse em nossos produtos.</p>
                    <p class="mb-25">Utilize o formulário para entrar em contato conosco.</p>

                    <p>
                        Atendimento:<br />
                        Segunda à sexta das 9:30 hs às 19:00hs<br />
                        Sábados das 10:00hs às 15:00hs.
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="tittle-cake text-center mar-top-20">
                    <div class="">
                        <img alt="Trufa Pink" src="<?php bloginfo('template_url'); ?>/images/decoratum-pink-v2.png" />
                        <h2 class="pink-color">
                            Contato
                        </h2>
                    </div>
                </div>
                <div class="mar-top-20" id="home-contato">
                    <div class="">
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
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
?>