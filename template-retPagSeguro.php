<?php
/* Template Name: Retorno Pag - Decoratum */
get_header();

// $transactionId = (isset($_REQUEST["transaction_id"])) ? $_REQUEST["transaction_id"]: "F262D215-F1CE-4F40-A394-85B16FB64873";
$transactionId    = (isset($_REQUEST["transaction_id"])) ? $_REQUEST["transaction_id"]: "";
$notificationCode = (isset($_REQUEST["notificationCode"])) ? $_REQUEST["notificationCode"]: "";

if($transactionId == "" && $notificationCode){
    $redirect = esc_url(home_url('/')).'produtos';
    header("location:$redirect");
    return;
}

$isNotification = false;
if($transactionId != ""){
   $arrRet = getStatusPagSeguro($transactionId);
   $ok     = $arrRet["ok"];
} else if($notificationCode != ""){
   $arrRet = getStatusPagSeguro("", "", $notificationCode);
   $ok     = $arrRet["ok"];

   $isNotification = true;
} else {
    $ok    = false;
}

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
    case 7:
        orderChangeStatus($orderId, "pending");
        break;
}

sendMail("carla@decoratum.com.br,nixlovemi@gmail.com", "Pedido #$orderId", "O pedido número $orderId está com o status $paymentStatus no PagSeguro.");
// =================================================

// quando vier de notificacao, so executa esse bloco
if($isNotification){
    setPagSeguroPaymentStatus($paymentStatus, $orderId);
    setPagSeguroDtUpdate($dtUpdate, $orderId);
    return;
}
// =================================================

$dtOrder    = date("d/m/Y H:i", strtotime($arrRet["retPS"]["date"]));
$transCode  = $arrRet["retPS"]["code"];
$orderTot   = $arrRet["retPS"]["grossAmount"];
$mailCli    = $arrRet["retPS"]["sender"]["email"];
$nomeCli    = $arrRet["retPS"]["sender"]["name"];
$ordemItens = $arrRet["retPS"]["items"];

$cepCli    = $arrRet["retPS"]["shipping"]["address"]["postalCode"];
$cepCli    = substr($cepCli, 0, 5) . "-" . substr($cepCli, 5, 3);

$endeCli   = $arrRet["retPS"]["shipping"]["address"]["street"];
$numCli    = $arrRet["retPS"]["shipping"]["address"]["number"];
$bairrCli  = $arrRet["retPS"]["shipping"]["address"]["district"];
$cidCli    = $arrRet["retPS"]["shipping"]["address"]["city"] . " / " . $arrRet["retPS"]["shipping"]["address"]["state"];

$paymentStr    = $arrRet["paymentTypeStr"] . " // " . $arrRet["paymentCodeStr"];
$paymentLink   = $arrRet["retPS"]["paymentLink"];

// atualiza custom fields
setPagSeguroTransCode($transCode, $orderId);
setPagSeguroPaymentUrl($paymentLink, $orderId);
setPagSeguroPaymentStatus($paymentStatus, $orderId);
setPagSeguroDtUpdate($dtUpdate, $orderId);
?>

<section class="product-cake sec-carrinho">
    <div class="container mb-40">
        <h1>Compra realizada!</h1>
        <p>Muito obrigado por comprar conosco. Os detalhes da compra estão a seguir:</p>

        <h3>Detalhes:</h3>
        <div id="holder-tb-carrinho">
            <table id="tb-carrinho" class="mb-25">
                <tr>
                    <td width="20%"><strong>Código do Pedido:</strong></td>
                    <td><?php echo $orderId; ?></td>
                </tr>

                <tr>
                    <td width="20%"><strong>Data do Pedido:</strong></td>
                    <td><?php echo $dtOrder; ?></td>
                </tr>

                <tr>
                    <td width="20%"><strong>Total do Pedido:</strong></td>
                    <td>R$ <?php echo number_format($orderTot, 2, ",", "."); ?></td>
                </tr>

                <tr>
                    <td width="20%"><strong>Email:</strong></td>
                    <td><?php echo $mailCli; ?></td>
                </tr>

                <tr>
                    <td width="20%"><strong>Nome:</strong></td>
                    <td><?php echo $nomeCli; ?></td>
                </tr>
            </table>
        </div>

        <h3>Itens:</h3>
        <div id="holder-tb-carrinho">
            <table id="tb-carrinho" class="mb-25">
                <tr>
                    <td><strong>Descrição</strong></td>
                    <td width="20%"><strong>Quantidade</strong></td>
                </tr>

                <?php
                foreach($ordemItens as $item){
                    $id   = $item["id"];
                    $name = $item["description"];
                    $qty  = $item["quantity"];

                    $arrPro = getAllProducts("", $id);
                    ?>

                    <tr>
                        <td>
                            <?php
                            if( count($arrPro) > 0 ){
                                $Produto = $arrPro[0];
                                ?>
                                <a href="<?php echo $Produto->getProductURL(); ?>">
                                    <img style="float: left; margin-right: 15px; width: 78px; height: 62px;" alt="Decoratum - <?php echo $Produto->getTitle(); ?>" src="<?php echo $Produto->getImageThumbUrl() ?>">
                                </a>
                                <a class="prod-title-cart" href="<?php echo $Produto->getProductURL(); ?>">
                                    <?php echo $Produto->getTitle(); ?>
                                </a>
                                <?php
                            } else {
                                echo $name;
                            }
                            ?>
                        </td>
                        <td width="20%"><?php echo $qty; ?></td>
                    </tr>

                    <?php
                }
                ?>
            </table>
        </div>

        <h3>Entrega:</h3>
        <div id="holder-tb-carrinho">
            <table id="tb-carrinho" class="mb-25">
                <tr>
                    <td width="20%"><strong>CEP:</strong></td>
                    <td><?php echo $cepCli; ?></td>
                </tr>

                <tr>
                    <td width="20%"><strong>Endereço:</strong></td>
                    <td><?php echo $endeCli; ?></td>
                </tr>

                <tr>
                    <td width="20%"><strong>Número:</strong></td>
                    <td><?php echo $numCli; ?></td>
                </tr>

                <tr>
                    <td width="20%"><strong>Bairro:</strong></td>
                    <td><?php echo $bairrCli; ?></td>
                </tr>

                <tr>
                    <td width="20%"><strong>Cidade:</strong></td>
                    <td><?php echo $cidCli; ?></td>
                </tr>
            </table>
        </div>

        <h3>Pagamento:</h3>
        <div id="holder-tb-carrinho">
            <table id="tb-carrinho" class="mb-25">
                <tr>
                    <td width="20%"><strong>Tipo:</strong></td>
                    <td><?php echo $paymentStr; ?></td>
                </tr>
                <tr>
                    <td width="20%"><strong>Status:</strong></td>
                    <td><?php echo $paymentStatus; ?></td>
                </tr>
                <tr>
                    <td width="20%"><strong>Link:</strong></td>
                    <td>Caso tenha havido algum problema com o pagamento, você poderá refazê-lo clicando <a target="_blank" href="<?php echo $paymentLink; ?>">nesse link</a>.</td>
                </tr>
            </table>
        </div>
    </div>

    <?php
    /*
    <div class="container mb-40">
        <?php
        echo "<pre>";
        print_r($arrRet);
        echo "</pre>";
        ?>
    </div>
    */
    ?>
</section>

<?php
get_footer();
?>