<?php
/* Template Name: Retorno Pag - Decoratum */
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
$notificationCode = (isset($_REQUEST["notificationCode"])) ? $_REQUEST["notificationCode"]: "";

if($notificationCode == ""){
    $redirect = esc_url(home_url('/')).'produtos';
    header("location:$redirect");
    return;
}

$arrRet = getStatusPagSeguro("", "", $notificationCode);
$ok     = $arrRet["ok"];

if(!$ok){
    $redirect = esc_url(home_url('/')).'produtos';
    header("location:$redirect");
    return;
}

$orderId       = $arrRet["retPS"]["reference"];
$paymentStatus = $arrRet["statusStr"];
$dtUpdate      = date("d/m/Y H:i:s", strtotime(current_time( "mysql", 0)));

// atualizacao de status ===========================
$orderStatus  = orderGetStatus($orderId);
$pagSegStatus = $arrRet["retPS"]["status"];

switch($pagSegStatus){
    case 1: // Aguardando pagamento
    case 2: // Em análise
    case 3: // Paga
        if($orderStatus != "processing"){
            orderChangeStatus($orderId, "processing");
        }
        break;
}

sendMail("carla@decoratum.com.br,nixlovemi@gmail.com", "Pedido #$orderId", "O pedido número $orderId está com o status $paymentStatus no PagSeguro.");
// =================================================

setPagSeguroTransCode($notificationCode, $orderId);
setPagSeguroPaymentStatus($paymentStatus, $orderId);
setPagSeguroDtUpdate($dtUpdate, $orderId);
return;