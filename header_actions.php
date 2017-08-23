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
} else if(isset($_GET["remove_cart"]) && $_GET["remove_cart"] > 0){
    removeCartItem( $_GET["remove_cart"] );
    ?>

    <script>
    document.location.href = '<?php echo getCartURL(); ?>';
    </script>

    <?php
} else if(isset($_GET["change-qty"]) && $_GET["change-qty"] > 0){
    $productId = $_GET["change-qty"];
    $qty       = $_GET["quantity"];

    changeCartItem($productId, $qty);
    ?>

    <script>
    document.location.href = '<?php echo getCartURL(); ?>';
    </script>
    
    <?php
} else if(isset($_GET["add-to-cart"]) && $_GET["add-to-cart"] > 0){
    ?>

    <script>
    document.location.href = '<?php echo getCartURL(); ?>';
    </script>
    
    <?php
}