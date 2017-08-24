<?php
/* Template Name: Carrinho - Decoratum */
/* https://getbootstrap.com/examples/grid/ */
get_header();
?>

<section class="product-cake sec-carrinho">
    <div class="container">
        <div style="width:100%; height: 170px; background-color:#abc2e8; color: #000; margin-bottom:30px;">
            TALVEZ COLOCAR UM BANNER AQUI
        </div>

        <?php
        $cartItens = getCartProducts();
        $qtyItens  = count($cartItens);
        $cartTotal = 0;

        if($qtyItens <= 0){
            ?>
            
            <h3>Carrinho vazio</h3>
            <p>Você ainda não escolheu nenhum produto.</p>

            <div style="width: 100%;" class="ft-l">
                <button style="width: 50%; font-size:18px;" type="button" title="Consultar" class="button btn-frete mt-10 mb-20 ft-l" id="btn-cons-frete" onclick="document.location.href = 'http://decoratum.com.br'">
                    Voltar ao site
                </button>
            </div>

            <?php
        } else {
            ?>

            <small class="mb-5" id="label-deslize">Deslize para ver a tabela</small>
                <div id="holder-tb-carrinho">
                    <table id="tb-carrinho" class="mb-25">
                        <thead>
                            <tr>
                                <th style="text-align:center;">Produto</th>
                                <th style="width:16%; text-align:center;">Preço</th>
                                <th style="width:16%; text-align:center;">Quantidade</th>
                                <th style="width:16%; text-align:center;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($cartItens as $item){
                                $Produto = $item["product"];
                                $qty     = (int) $item["qty"];
                                $price   = $item["price"];
                                $total   = $price * $qty;

                                $strQty     = ($qty < 9) ? '0'.$qty : $qty;
                                $cartTotal += $total;
                                ?>

                                <tr>
                                    <td>
                                        <a href="<?php echo $Produto->getProductURL(); ?>">
                                            <img style="float: left; margin-right: 15px; width: 78px; height: 62px;" alt="Decoratum - <?php echo $Produto->getTitle(); ?>" src="<?php echo $Produto->getImageThumbUrl() ?>">
                                        </a>
                                        <a class="prod-title-cart" href="<?php echo $Produto->getProductURL(); ?>">
                                            <?php echo $Produto->getTitle(); ?>
                                        </a>
                                        <br />
                                        Entrega em até 7 dias úteis para São Paulo.
                                    </td>
                                    <td class="product-price">
                                        R$<?php echo number_format($price, 2, ",", "."); ?>
                                    </td>
                                    <td class="product-price">
                                        <input id="qty_<?php echo $Produto->getId(); ?>" name="qty" class="qntdd_prod qtde_carrinho mask-qty-prod" value="<?php echo $strQty; ?>" maxlength="2" title="O campo de quantidade aceita apenas números, de 1 até 99." type="text" />
                                        <center class="mt-5">
                                            <a title="Remover do Carrinho" href="javascript:;" onClick="changeCartItem(<?php echo $Produto->getId(); ?>)">
                                                <img alt="Alterar Quantidade" width="13" height="18" src="<?php bloginfo('template_url'); ?>/images/icon-loop.png" />
                                            </a>
                                            &nbsp;
                                            <a title="Remover do Carrinho" href="<?php echo esc_url(home_url('/')).'?remove_cart=' . $Produto->getId(); ?>">
                                                <img alt="Remover do Carrinho" width="18" height="18" src="<?php bloginfo('template_url'); ?>/images/icon-trash.png" />
                                            </a>
                                        </center>
                                    </td>
                                    <td class="product-price">
                                        R$<?php echo number_format($total, 2, ",", "."); ?>
                                    </td>
                                </tr>

                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <ul class="ul-subtotal-list">
                    <li>
                        <div class="subtotal">
                            <table class="tb-subtotal">
                                <tbody>
                                    <tr>
                                        <td class="texto">Subtotal</td>
                                        <td class="valor">R$<?php echo number_format($cartTotal, 2, ",", "."); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </li>

                    <li>
                        <div class="subtotal">
                            <table class="tb-subtotal">
                                <tbody>
                                    <tr>
                                        <td class="texto">Frete</td>
                                        <td class="">
                                            <div style="float: right;">
                                                <input style="width: 100%" id="frete_carrinho" name="frete_carrinho" class="inpt-frete mask-cep" value="" maxlength="8" title="" type="text">
                                                <br />
                                                <button style="width: 100%;" type="button" title="Consultar" class="button btn-frete mt-10 mb-20" id="btn-cons-frete" onclick="calculaFrete('', '', $('#frete_carrinho').val(), 'ret-frete-cart', 'S')">
                                                    &nbsp;
                                                    Consultar
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <small id="ret-frete-cart" style="width:100%; text-align:center; display:block;"></small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </li>

                    <li>
                        <div class="subtotal">
                            <table class="tb-subtotal">
                                <tbody>
                                    <tr>
                                        <td class="texto">Cupom</td>
                                        <td class="">
                                            <div style="float: right;">
                                                <input style="width: 100%" id="cupom_carrinho" name="cupom_carrinho" class="inpt-frete" value="" maxlength="14" title="" type="text">
                                                <br />
                                                <button style="width: 100%;" type="button" title="Consultar" class="button btn-frete mt-10 mb-20" id="btn-cons-frete" onclick="alert(2)">
                                                    &nbsp;
                                                    Adicionar
                                                </button>
                                                <br />
                                                <small style="width:100%; text-align:center; display:block;">Desconto -R$5,00</small>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </li>

                    <li>
                        <div class="subtotal">
                            <table class="tb-subtotal">
                                <tbody>
                                    <tr>
                                        <td class="texto">TOTAL</td>
                                        <td class="valor" style="font-weight:bold;"><span id="spn-cart-total">R$<?php echo number_format($cartTotal, 2, ",", "."); ?></span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="texto">
                                            <button style="width: 60%; float:right; font-size:18px;" type="button" title="Consultar" class="button btn-frete mt-10 mb-20" id="btn-cons-frete" onclick="alert(2)">
                                                &nbsp;
                                                Finalizar Compra
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </li>
                </ul>

            <?php
        }
        ?>
    </div>
</section>

<?php
get_footer();
?>
