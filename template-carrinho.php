<?php
/* Template Name: Carrinho - Decoratum */
/* https://getbootstrap.com/examples/grid/ */
get_header();
?>

<section class="product-cake sec-carrinho">
    <div class="container">
        <!--
        <div style="width:100%; height: 170px; background-color:#abc2e8; color: #000; margin-bottom:30px;">
            TALVEZ COLOCAR UM BANNER AQUI
        </div>
        -->

        <?php
        $cartItens = getCartProducts();
        $qtyItens  = count($cartItens);

        if ($qtyItens <= 0) {
        ?>
            <h3>Carrinho vazio</h3>
            <p>Você ainda não escolheu nenhum produto.</p>

            <div style="width: 100%;" class="ft-l">
                <button style="width: 50%; font-size:18px;" type="button" title="Consultar" class="button btn-frete mt-10 mb-20 ft-l" id="btn-cons-frete" onclick="document.location.href = 'http://decoratum.com.br'">
                    Voltar ao site
                </button>
            </div>

            <h3 class="mt-40 mb-40">Aproveite e veja nossas ofertas!</h3>
            <?php
            echo getHtmlProdDestHome(6);
        } else {
            getHtmlTbCart($cartItens);
        }
        ?>
    </div>
</section>

<?php
get_footer();
?>
