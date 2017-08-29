<?php
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

if( count($_POST) > 0 ){
    $vCouponCode    = (isset($_POST["couponCode"])) ? trim($_POST["couponCode"]): "";
    if( $vCouponCode != "" ){
        $coupon       = new DecoratumCoupon($vCouponCode);
        $ret          = $coupon->addCouponToCart();
        $cartCoupons  = WC()->cart->get_coupons();
        $couponInCart = WC()->cart->has_discount($vCouponCode);

        if(!$ret && !$couponInCart){
            echo "Cupom n&atilde;o v&aacute;lido.";
        } else {
            // $totDescount = WC()->cart->get_subtotal() - WC()->cart->cart_contents_total();
            // $cartCoupons = WC()->cart->get_coupons();
            // var_dump($cartCoupons);
            // var_dump( WC()->cart->has_discount( $vCouponCode ) );

            $totalCoupon = getTotalCoupon();
            if($totalCoupon > 0){
                echo "Desconto: R$" . number_format($totalCoupon, 2, ",", ".");
            }
        }
    }
}