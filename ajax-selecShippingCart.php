<?php
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

if( count($_POST) > 0 ){
    $vValueRd = (isset($_POST["valueRd"])) ? $_POST["valueRd"]: "";

    if($vValueRd != ""){
        $arrValueRd = explode("|", $vValueRd);
        $valor      = isset($arrValueRd[0]) ? $arrValueRd[0]: 0;
        $name       = $arrValueRd[1];

        $subtotal = getCartSubtotal();
        $totalCart = $subtotal + $valor;

        echo "R$" . number_format($totalCart, 2, ",", ".");
    }
}