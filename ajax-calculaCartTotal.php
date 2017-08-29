<?php
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

if( count($_POST) > 0 ){
    $vExec = (isset($_POST["exec"])) ? trim($_POST["exec"]): "";
    
    if( $vExec == 1 ){
        echo "R$" . number_format(getCartTotal(), 2, ",", ".");
    }
}