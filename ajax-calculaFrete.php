<?php
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

if( count($_POST) > 0 ){
    $vProdutoIds = (isset($_POST["produtoIds"])) ? $_POST["produtoIds"]: "";
    $vCepDestino = (isset($_POST["cepDestino"])) ? $_POST["cepDestino"]: "";

    if($vProdutoIds != "" && $vCepDestino != ""){
        $DecoratumShipping = new DecoratumShipping();
        $arrRet = $DecoratumShipping->execConsultaFrete(array(), $vCepDestino);

        if( count($arrRet) > 0 ){
            echo "<table class='tb-frete' border='0' width='100%'>";
            echo "<tr class='header'>";
            echo "  <td>Método</td>";
            echo "  <td>Previsão</td>";
            echo "  <td>Valor</td>";
            echo "</tr>";

            foreach($arrRet as $item){
                $vNome = $item["nome"];
                $vPrazo = $item["prazo"];
                $vValor = $item["valor"];

                echo "<tr>";
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