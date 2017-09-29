<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
if (@session_id() == "") @session_start();

$arrRet = array();
$arrRet["ok"]   = false;
$arrRet["msg"]  = "Erro ao pesquisar pedido! Se o problema persistir, entre em contato conosco!";
$arrRet["html"] = "";

if( count($_POST) > 0 ){
    $exec      = (isset($_POST["exec"])) ? trim($_POST["exec"]) : "";
    $pedido_ID = (isset($_POST["consulta_id_pedido"])) ? trim($_POST["consulta_id_pedido"]) : "";
    $email     = (isset($_POST["consulta_mail"])) ? trim($_POST["consulta_mail"]) : "";
    $cep       = (isset($_POST["consulta_cep"])) ? trim($_POST["consulta_cep"]) : "";

    if($exec == 1){
        $arrOrder = getOrderById($pedido_ID);
        
        if(count($arrOrder) <= 0){
            $arrRet["ok"]   = false;
            $arrRet["msg"]  = "Pedido #$pedido_ID não foi encontrado!";
        } else {
            $isOk = ($arrOrder["cliEmail"] == $email) && ($arrOrder["cliPostcode"] == $cep);
            if(!$isOk){
                $arrRet["ok"]   = false;
                $arrRet["msg"]  = "As informações digitadas do Pedido #$pedido_ID não conferem!";
            } else {
                $arrRet["ok"] = true;
                $html         = "";

                $orderId = $arrOrder["orderID"];
                $orderDt = (isset($arrOrder["date"]) && $arrOrder["date"] != "") ? date("d/m/Y H:i", strtotime($arrOrder["date"])): "";
                $cliName = $arrOrder["cliName"];
                
                switch($arrOrder["status"]){
                   case "pending":
                       $status = "Pagamento pendente";
                       break;
                   case "processing":
                       $status = "Processando";
                       break;
                   case "on-hold":
                       $status = "Em Produção";
                       break;
                   case "completed":
                       $status = "Concluído";
                       break;
                   case "cancelled":
                       $status = "Cancelado";
                       break;
                   case "refunded":
                       $status = "Reembolsado";
                       break;
                   case "failed":
                       $status = "Falhado";
                       break;
                   default:
                       $status = " ** ";
                       break;
                }
                
                $cliMail = $arrOrder["cliEmail"];
                $cliPhon = $arrOrder["cliPhone"];
                
                $html .= "<h4 class='mb-20'>Informações do pedido #$orderId</h4>";
                $html .= "<table width='100%' id='tb-carrinho'>";
                $html .= "  <tr>";
                $html .= "    <td><b>Data do Pedido</b></td>";
                $html .= "    <td>$orderDt</td>";
                $html .= "  </tr>";
                $html .= "  <tr>";
                $html .= "    <td><b>Cliente</b></td>";
                $html .= "    <td>$cliName</td>";
                $html .= "  </tr>";
                $html .= "  <tr>";
                $html .= "    <td><b>Email</b></td>";
                $html .= "    <td>$cliMail</td>";
                $html .= "  </tr>";
                $html .= "  <tr>";
                $html .= "    <td><b>Telefone</b></td>";
                $html .= "    <td>$cliPhon</td>";
                $html .= "  </tr>";
                $html .= "  <tr>";
                $html .= "    <td><b>Status</b></td>";
                $html .= "    <td>$status</td>";
                $html .= "  </tr>";
                $html .= "</table>";
                
                $orderProd = $arrOrder["products"];
                $totItens  = 0;
                if(count($orderProd) > 0){
                    $html .= "<table class='mt-20' width='100%' id='tb-carrinho'>";
                    $html .= "  <thead>";
                    $html .= "    <tr>";
                    $html .= "      <th style='text-align:left;'>Produto</th>";
                    $html .= "      <th style='width:16%; text-align:center;'>Qtde.</th>";
                    $html .= "      <th style='width:16%; text-align:center;'>Preço (R$)</th>";
                    $html .= "    </tr>";
                    $html .= "  </thead>";

                    $html .= "  <tbody>";
                    foreach($orderProd as $product){
                        $totItens += $product["qty"] * $product["subTotal"];

                        $pName = $product["name"];
                        $pQty  = $product["qty"];
                        $pVlue = number_format($product["subTotal"], 2, ",", ".");
                        $pImg  = $product["DecoratumProduct"]->getImageThumbUrl();

                        $html .= "<tr>";
                        $html .= "  <td style='text-align:left;'><img style='margin-right: 5px;' width='32' height='32' src='$pImg' alt='$pName' />$pName</td>";
                        $html .= "  <td style='width:16%; text-align:center;'>$pQty</td>";
                        $html .= "  <td style='width:16%; text-align:center;'>$pVlue</td>";
                        $html .= "</tr>";
                    }
                    $html .= "  </tbody>";
                    
                    $html .= "</table>";
                }
                
                $cliEnde = $arrOrder["cliAddress"];
                $cliBair = $arrOrder["cliDistrict"];
                $cliCity = $arrOrder["cliCity"] . " - " . $arrOrder["cliState"];
                $cliCep  = $arrOrder["cliPostcode"];
                
                $html .= "<table width='100%' id='tb-carrinho' class='mt-20'>";
                $html .= "  <tr>";
                $html .= "    <td><b>Endereço</b></td>";
                $html .= "    <td>$cliEnde</td>";
                $html .= "  </tr>";
                $html .= "  <tr>";
                $html .= "    <td><b>Bairro</b></td>";
                $html .= "    <td>$cliBair</td>";
                $html .= "  </tr>";
                $html .= "  <tr>";
                $html .= "    <td><b>Cidade</b></td>";
                $html .= "    <td>$cliCity</td>";
                $html .= "  </tr>";
                $html .= "  <tr>";
                $html .= "    <td><b>CEP</b></td>";
                $html .= "    <td>$cliCep</td>";
                $html .= "  </tr>";
                $html .= "</table>";

                $strTotItens = number_format($totItens, 2, ",", ".");
                $shipping    = number_format($arrOrder["shippingVal"], 2, ",", ".");
                $discount    = number_format($arrOrder["discountVal"], 2, ",", ".");
                $orderTot    = number_format($arrOrder["total"], 2, ",", ".");

                $html .= "<table width='100%' id='tb-carrinho' class='mt-20'>";
                $html .= "  <tr>";
                $html .= "    <td><b>Total Itens</b></td>";
                $html .= "    <td>+R$ $strTotItens</td>";
                $html .= "  </tr>";
                $html .= "  <tr>";
                $html .= "    <td><b>Frete</b></td>";
                $html .= "    <td>+R$ $shipping</td>";
                $html .= "  </tr>";
                $html .= "  <tr>";
                $html .= "    <td><b>Desconto</b></td>";
                $html .= "    <td>-R$ $discount</td>";
                $html .= "  </tr>";
                $html .= "  <tr>";
                $html .= "    <td><b>Total do Pedido</b></td>";
                $html .= "    <td>=R$ $orderTot</td>";
                $html .= "  </tr>";
                $html .= "</table>";
                
                $strLowStatus = strtolower($status);
                $showPgto = ($strLowStatus == "pagamento pendente" || $strLowStatus == "processando" || $strLowStatus == "falhado");
                if($showPgto){
                    $pagSegKey = $arrOrder["pagseguroKey"];
                    
                    $html .= "<table width='100%' id='tb-carrinho' class='mt-20'>";
                    $html .= "  <tr>";
                    $html .= "    <td align='center'>Se você estiver com problemas no pagamento, entre em contato conosco ou utilize o botão abaixo pra realizar um novo pagamento.</td>";
                    $html .= "  </tr>";
                    $html .= "  <tr>";
                    $html .= "    <td>
                                    <button style='width: 100%; font-size:18px;' type='button' title='Consultar' class='button btn-frete ft-l' id='btn-cons-frete' onclick='execPgtoPagSeguro(\"$pagSegKey\")'>
                                        INICIAR PAGAMENTO
                                    </button>
                                  </td>";
                    $html .= "  </tr>";
                    $html .= "</table>";
                }
                

                $arrRet["html"] = $html;
            }
        }
    }
}

echo json_encode($arrRet);