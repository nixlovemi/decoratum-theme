<?php
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

if( count($_POST) > 0 ){
    $vExec     = (isset($_POST["exec"])) ? trim($_POST["exec"]): "";
    $vVlrFrete = (isset($_POST["vlrFrete"])) ? $_POST["vlrFrete"]: 0;
    
    if( $vExec == 1 ){
        echo "R$" . number_format(getCartTotal() + $vVlrFrete, 2, ",", ".");
    }
}