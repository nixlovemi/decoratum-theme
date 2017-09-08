<?php
/* Template Name: Checkout - Decoratum */
/* https://getbootstrap.com/examples/grid/ */
if (@session_id() == "") @session_start();

$temPost     = count($_POST) > 0;
$vCepValue   = isset($_POST["cepValue"]) ? $_POST["cepValue"] : "";
$vFreteValue = isset($_POST["freteValue"]) ? $_POST["freteValue"] : "";
$vFreteName  = isset($_POST["freteName"]) ? $_POST["freteName"] : "";

if (!$temPost || $vCepValue == "" || $vFreteValue == "" || $vFreteName == "") {
    $redirect = esc_url(home_url('/')).'produtos';
    header("location:$redirect");
}

get_header();
?>

<section class="product-cake sec-carrinho">
    <div class="container mb-40">
        <h3>Por favor, revise seu pedido antes de realizar o pagamento!</h3>

        <?php
        $cartItens = getCartProducts();
        $qtyItens  = count($cartItens);

        if($qtyItens <= 0){
            $redirect = esc_url(home_url('/')).'produtos';
            header("location:$redirect");
        }

        $_SESSION["cepValue"]  = $vCepValue;
        $_SESSION["freteVlr"]  = $vFreteValue;
        $_SESSION["freteName"] = $vFreteName;
        $_SESSION["freteStr"]  = "Selecionado: $vFreteName -> R$ " . number_format($vFreteValue, 2, ",", ".");

        $_SESSION['freteVlr'] = $vFreteValue;
        $_SESSION['freteName'] = $vFreteName;

        getHtmlTbCart($cartItens, true);
        ?>
    </div>
    <div class="container">
        <h3>Complete as informações e prossiga para o PagSeguro</h3>
        <form id="frm-checkout">
            <div class="row">
                <div class="col-sm-4">
                    <h4>Suas Informações:</h4>
                    <table width="100%">
                        <tr>
                            <td>Email:</td>
                        </tr>
                        <tr>
                            <td><input style="width: 100%; text-align: left; padding-left: 3px;" name="checkout_mail" class="inpt-frete" value="" maxlength="100" title="" type="text" /></td>
                        </tr>

                        <tr>
                            <td>Nome Completo:</td>
                        </tr>
                        <tr>
                            <td><input style="width: 100%; text-align: left; padding-left: 3px;" name="checkout_name" class="inpt-frete" value="" maxlength="70" title="" type="text" /></td>
                        </tr>

                        <tr>
                            <td>DDD:</td>
                        </tr>
                        <tr>
                            <td><input style="width: 100%; text-align: left; padding-left: 3px;" name="checkout_ddd" class="inpt-frete" value="" maxlength="2" title="" type="text" /></td>
                        </tr>

                        <tr>
                            <td>Telefone:</td>
                        </tr>
                        <tr>
                            <td><input style="width: 100%; text-align: left; padding-left: 3px;" name="checkout_phone" class="inpt-frete" value="" maxlength="10" title="" type="text" /></td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-4">
                    <?php
                    $infoCep    = findCep($vCepValue);
                    $isCompleto = $infoCep["completo"];
                    $tpLogr     = (isset($infoCep["tp_logradouro"])) ? $infoCep["tp_logradouro"]: "";
                    $Ende       = (isset($infoCep["logradouro"])) ? $infoCep["logradouro"]: "";
                    $Bairr      = (isset($infoCep["bairro"])) ? $infoCep["bairro"]: "";
                    $City       = (isset($infoCep["cidade"])) ? $infoCep["cidade"]: "";
                    $Est        = (isset($infoCep["uf"])) ? $infoCep["uf"]: "";

                    $vReadOnly  = ($isCompleto) ? " readonly='' ": "";
                    ?>

                    <h4>Entrega:</h4>
                    <table width="100%">
                        <tr>
                            <td>CEP:</td>
                        </tr>
                        <tr>
                            <td><input style="width: 100%; text-align: left; padding-left: 3px;" name="checkout_cep" class="inpt-frete" value="<?php echo $vCepValue; ?>" readonly="" maxlength="10" title="" type="text" /></td>
                        </tr>

                        <tr>
                            <td>Tipo Logradouro:</td>
                        </tr>
                        <tr>
                            <td><input <?php echo $vReadOnly; ?> style="width: 100%; text-align: left; padding-left: 3px;" name="checkout_t_logr" class="inpt-frete" value="<?php echo $tpLogr; ?>" maxlength="10" title="" type="text" /></td>
                        </tr>

                        <tr>
                            <td>Endereço:</td>
                        </tr>
                        <tr>
                            <td><input <?php echo $vReadOnly; ?> style="width: 100%; text-align: left; padding-left: 3px;" name="checkout_logr" class="inpt-frete" value="<?php echo $Ende; ?>" maxlength="70" title="" type="text" /></td>
                        </tr>

                        <tr>
                            <td>Número:</td>
                        </tr>
                        <tr>
                            <td><input style="width: 100%; text-align: left; padding-left: 3px;" name="checkout_num_logr" class="inpt-frete" value="" maxlength="15" title="" type="text" /></td>
                        </tr>

                        <tr>
                            <td>Bairro:</td>
                        </tr>
                        <tr>
                            <td><input <?php echo $vReadOnly; ?> style="width: 100%; text-align: left; padding-left: 3px;" name="checkout_bairr_logr" class="inpt-frete" value="<?php echo $Bairr; ?>" maxlength="40" title="" type="text" /></td>
                        </tr>

                        <tr>
                            <td>Cidade:</td>
                        </tr>
                        <tr>
                            <td><input <?php echo $vReadOnly; ?> style="width: 100%; text-align: left; padding-left: 3px;" name="checkout_city_logr" class="inpt-frete" value="<?php echo $City; ?>" maxlength="70" title="" type="text" /></td>
                        </tr>

                        <tr>
                            <td>Estado:</td>
                        </tr>
                        <tr>
                            <td><input <?php echo $vReadOnly; ?> style="width: 100%; text-align: left; padding-left: 3px;" name="checkout_est_logr" class="inpt-frete" value="<?php echo $Est; ?>" maxlength="2" title="" type="text" /></td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-4">
                    <h4>Pagamento:</h4>
                    <p>O pagamento é feito via PagSeguro, onde seu pagamento é processado com segurança e você ainda pode escolher a forma de pagamento e a quantidade de parcelas.</p>
                    <p>Para conhecer melhor como funciona o PagSeguro, clique na imagem.</p>
                    <p align="center">
                        <a href="https://pagseguro.uol.com.br/para_voce/passo_a_passo.jhtml#rmcl" target="_blank">
                            <img class="img-responsive" alt="Saiba Mais - PagSeguro" src="<?php bloginfo('template_url'); ?>/images/pagseguro-footer.png" />
                        </a>
                    </p>

                    <!-- execCheckout() -->
                    <button style="width: 100%; font-size:18px;" type="button" title="Consultar" class="button btn-frete mt-10 mb-20 ft-l" id="btn-cons-frete" onclick="execCheckout()">
                        FINALIZAR E INICIAR PAGAMENTO
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

<?php
get_footer();
?>
