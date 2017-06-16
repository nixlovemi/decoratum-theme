<?php
if (isset($_GET["a"]) && $_GET["a"] != "") {
    if ($_GET["a"] == "clearCart") {
        limparCarrinho();

        $redirect = esc_url(home_url('/')).'produtos';
        header("location:$redirect");
    }
} else if (isset($_POST["stringfyJSON"]) && $_POST["stringfyJSON"] != "") {
    $stringJSON = urldecode($_POST["stringfyJSON"]);
    $arrayJSON  = json_decode($stringJSON, 1);

    foreach ($arrayJSON["produtos"] as $produto) {
        $ID_prod = $produto["id_prod"];
        $qtde    = $produto["qtde"];

        changeQtdItemCart($ID_prod, $qtde);
    }

    $redirect = esc_url(home_url('/')).'carrinho';
    header("location:$redirect");
} else if (isset($_POST["ID_PROD_DEL"]) && $_POST["ID_PROD_DEL"] != "") {
    $ID_prod = $_POST["ID_PROD_DEL"];
    changeQtdItemCart($ID_prod, 0);

    $redirect = esc_url(home_url('/')).'carrinho';
    header("location:$redirect");
}