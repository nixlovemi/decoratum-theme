<?php
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

if( count($_POST) > 0 ){
    $vProdutoIds    = (isset($_POST["produtoIds"])) ? $_POST["produtoIds"]: "";
    $vQuantidades   = (isset($_POST["quantidades"])) ? $_POST["quantidades"]: "";
    $vCepDestino    = (isset($_POST["cepDestino"])) ? $_POST["cepDestino"]: "";
    $vFreteCarrinho = (isset($_POST["freteCarrinho"])) ? $_POST["freteCarrinho"]: "N";

    $DecoratumShipping = new DecoratumShipping();
    $arrProducts = $DecoratumShipping->generateArrProducts($vProdutoIds, $vQuantidades, $vFreteCarrinho);

    if(count($arrProducts) > 0){
        $arrRet = $DecoratumShipping->execConsultaFrete($arrProducts, $vCepDestino);

        if( count($arrRet) > 0 ){
            echo "<table class='tb-frete' border='0' width='100%'>";
            echo "<tr class='header'>";

            if( $vFreteCarrinho == "S" ){
                echo "<td>&nbsp;</td>";
            }

            echo "  <td>Método</td>";
            echo "  <td>Previsão</td>";
            echo "  <td>Valor</td>";
            echo "</tr>";

            foreach($arrRet as $item){
                $vNome = $item["nome"];
                $vPrazo = $item["prazo"];
                $vValor = $item["valor"];

                $strValor = str_replace(",", ".", $vValor);

                echo "<tr>";

                if( $vFreteCarrinho == "S" ){
                    echo "<td><input class='rad-slc-frete' type='radio' name='rd-slc-frete' id='rd-slc-frete' value='$strValor|$vNome' /></td>";
                }

                echo "  <td>$vNome</td>";
                echo "  <td>$vPrazo dias</td>";
                echo "  <td>R$$vValor</td>";
                echo "</tr>";
            }

            echo '</table>';
        } else {
            echo "Nenhum método de entrega foi encontrado pra sua região. Para maior esclarecimento, entre em contato conosco.";
        }
    }
}