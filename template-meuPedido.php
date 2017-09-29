<?php
/* Template Name: Meu Pedido - Decoratum */
/* https://getbootstrap.com/examples/grid/ */
get_header();
?>

<section class="product-cake sec-carrinho">
    <div class="container">
        <div style="width:100%; height: 170px; background-color:#abc2e8; color: #000; margin-bottom:30px;">
            TALVEZ COLOCAR UM BANNER AQUI
        </div>

        <h3 class="mb-25">Digite as informações abaixo para consultar os detalhes do seu pedido.</h3>
        <div class="row">
            <div class="col-sm-6">
                <form name="frm-consulta-pedido" id="frm-consulta-pedido">
                    <table width="100%">
                        <tr>
                            <td>Número do Pedido #</td>
                        </tr>
                        <tr>
                            <td><input style="width: 100%; text-align: left; padding-left: 3px;" name="consulta_id_pedido" class="inpt-frete" value="" maxlength="10" title="" type="text" /></td>
                        </tr>

                        <tr>
                            <td>Email:</td>
                        </tr>
                        <tr>
                            <td><input style="width: 100%; text-align: left; padding-left: 3px;" name="consulta_mail" class="inpt-frete" value="" maxlength="70" title="" type="text" /></td>
                        </tr>

                        <tr>
                            <td>CEP Entrega:</td>
                        </tr>
                        <tr>
                            <td><input style="width: 100%; text-align: left; padding-left: 3px;" name="consulta_cep" class="inpt-frete mask-cep" value="" maxlength="10" title="" type="text" /></td>
                        </tr>

                        <tr>
                            <td>
                                <br /><br />
                                <button style="width: 100%; font-size:18px;" type="button" title="Consultar" class="button btn-frete mt-10 mb-20 ft-l" id="btn-cons-frete" onclick="execConsultaPedido()">
                                    PESQUISAR PEDIDO
                                </button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="col-sm-6" id="dv-ret-pesquisa-pedido">
                <center>Nenhum pedido pesquisado!</center>
                <br />
                <center>
                    <img class="img-responsive" src="<?php bloginfo('template_url'); ?>/images/clock-waiting.png" alt="Aguardando - Decoratum" />
                </center>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
?>
