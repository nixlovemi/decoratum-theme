<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
if (@session_id() == "") @session_start();

$arrRet = array();
$arrRet["ok"] = false;
$arrRet["msg"] = "Erro ao finalizar compra! Se o problema persistir, entre em contato conosco!";
$arrSiglas = array("AC", "AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO", "MA", "MT", "MS", "MG", "PA", "PB", "PR", "PE", "PI", "RR", "RO", "RJ", "RN", "RS", "SC", "SP", "SE", "TO");

if( count($_POST) > 0 ){
    $mail      = (isset($_POST["checkout_mail"])) ? trim($_POST["checkout_mail"]) : "";
    $name      = (isset($_POST["checkout_name"])) ? trim($_POST["checkout_name"]) : "";
    $ddd       = (isset($_POST["checkout_ddd"])) ? trim($_POST["checkout_ddd"]) : "";
    $phone     = (isset($_POST["checkout_phone"])) ? trim($_POST["checkout_phone"]) : "";
    $cep       = (isset($_POST["checkout_cep"])) ? trim($_POST["checkout_cep"]) : "";
    $tLogr     = (isset($_POST["checkout_t_logr"])) ? trim($_POST["checkout_t_logr"]) : "";
    $logr      = (isset($_POST["checkout_logr"])) ? trim($_POST["checkout_logr"]) : "";
    $numLogr   = (isset($_POST["checkout_num_logr"])) ? trim($_POST["checkout_num_logr"]) : "";
    $bairrLogr = (isset($_POST["checkout_bairr_logr"])) ? trim($_POST["checkout_bairr_logr"]) : "";
    $cityLogr  = (isset($_POST["checkout_city_logr"])) ? trim($_POST["checkout_city_logr"]) : "";
    $estLogr   = (isset($_POST["checkout_est_logr"])) ? trim($_POST["checkout_est_logr"]) : "";

    $freteVlr  = isset($_SESSION['freteVlr']) ? $_SESSION['freteVlr']: 10;
    $freteName = isset($_SESSION['freteName']) ? $_SESSION['freteName']: "PAC";

    // validacoes ===============
    $strErr = "";
    $arrErr = array();

    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $arrErr[] = "Email";
    }

    if(strlen($name) < 3){
        $arrErr[] = "Nome";
    }
    
    if(!is_numeric($ddd) || strlen($ddd) != 2){
        $arrErr[] = "DDD";
    }
    
    if(strlen($phone) < 8){
        $arrErr[] = "Telefone";
    }
    
    if(strlen($cep) < 8){
        $arrErr[] = "CEP";
    }
    
    if(strlen($tLogr) < 2){
        $arrErr[] = "Tipo Logradouro";
    }
    
    if(strlen($logr) < 2){
        $arrErr[] = "Endereço";
    }
    
    if(strlen($numLogr) < 1){
        $arrErr[] = "Número";
    }
    
    if(strlen($bairrLogr) < 2){
        $arrErr[] = "Bairro";
    }
    
    if(strlen($cityLogr) < 2){
        $arrErr[] = "Cidade";
    }

    if(!in_array(strtoupper($estLogr), $arrSiglas)){
        $arrErr[] = "Estado";
    }

    if(count($arrErr) > 0){
       $strErr = "Antes de finalizar, preencha as seguintes informações: " .implode(", ", $arrErr);

       $arrRet["ok"] = false;
       $arrRet["msg"] = $strErr;

       echo json_encode($arrRet);
       return;
    }
    // ==========================

    // td ok, gera a compra =====
    $address = array(
        'first_name' => ucfirst($name),
        'last_name'  => "",
        'company'    => "",
        'email'      => $mail,
        'phone'      => "($ddd) $phone",
        'address_1'  => "$tLogr. $logr, $numLogr",
        'address_2'  => "Bairro $bairrLogr",
        'city'       => $cityLogr,
        'state'      => strtoupper($estLogr),
        'postcode'   => $cep,
        'country'    => "BR"
    );

    $cartItens = getCartProducts();
    $qtyItens  = count($cartItens);

    if($qtyItens <= 0){
       $arrRet["ok"] = false;
       $arrRet["msg"] = "Ocorreu um erro ao buscar produtos do carrinho. Tente novamente.";

       echo json_encode($arrRet);
       return;
    }

    try {
        $order = wc_create_order();
        $order->set_address( $address, 'billing' );
        $order->set_address( $address, 'shipping' );

        $coupon = getCartCoupon();
        $couponTot = 0;
        if(count($coupon) > 0 && isset($coupon["code"])){
            $code       = $coupon["code"];
            $value      = $coupon["value"];
            $couponTot += $value;

            $order->add_coupon($code, $value, $value);
            //$order->add_fee("Cupom $code", -1*$value, true, ""); ERROR
            //$order->add_discount( sanitize_text_field( $code )); ERROR
        }

        $cartSubTotal = getCartSubtotal();
        $discountAux  = $couponTot; //10.00
        for($i=0; $i<count($cartItens); $i++){
            $item     = $cartItens[$i];
            $lastItem = $i == (count($cartItens) - 1);

            $productId = $item["productID"];
            $qty       = (int) $item["qty"];
            $price     = $item["price"]; //39.90

            if(!$lastItem){
                $percPrice    = $price / $cartSubTotal;
                $descPrice    = number_format($couponTot * $percPrice, 2, ".", "");
                $discountAux -= $descPrice;
            } else {
                $descPrice   = $discountAux;
                $discountAux = 0;
            }

            $arrProInfo = array();
            $arrProInfo["subtotal"] = $price;
            $arrProInfo["total"] = $price - $descPrice;

            $order->add_product( get_product( $productId ), $qty, array("totals" => $arrProInfo) );
        }

        /*$cartSubTotal = getCartSubtotal();
        $discountAux  = $couponTot; //10.00
        foreach ($cartItens as $item) {
            $productId = $item["productID"];
            $qty       = (int) $item["qty"];
            $price     = $item["price"]; //39.90

            $percPrice    = $price / $cartSubTotal;
            $descPrice    = number_format($couponTot * $percPrice, 2, ".", "");
            $discountAux -= $descPrice;

            $arrProInfo = array();
            $arrProInfo["subtotal"] = $price;
            $arrProInfo["total"] = ;

            $order->add_product( get_product( $productId ), $qty );
        }*/

        $shipping_tax = array();
        $shipping_rate = new WC_Shipping_Rate('', $freteName,
                                          $freteVlr, $shipping_tax,
                                          'custom_shipping_method' );
        $order->add_shipping($shipping_rate);

        $order->calculate_shipping();
        $order->calculate_totals();

        $arrRet["ok"] = true;
        $arrRet["msg"] = "Pedido efetuado com sucesso. Você será redirecionado para o PagSeguro para efetuar o pagamento! Por favor não atualize seu navegador durante esse processo!";
    } catch (Exception $e) {
        $order_id = trim(str_replace('#', '', $order->get_order_number()));
        wp_delete_post($order_id,true);
    }
    // ==========================
}

echo json_encode($arrRet);