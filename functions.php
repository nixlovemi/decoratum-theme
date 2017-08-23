<?php
// setup basico pra temas woo commerce
add_action('after_setup_theme', 'woocommerce_support');

function woocommerce_support()
{
    add_theme_support('woocommerce');
}

// ===================================
// classe da Entrega =================
class DecoratumShipping
{
    // private $_correiosCodSedex10 = '40215';
    private $_correiosCodSedex = '40010';
    private $_correiosCodPac   = '41106';
    private $_cepOrigem        = '13477708';

    private function getCodigosTxt()
    {
        $arrCodigos   = array();
        $arrCodigos[] = $this->_correiosCodPac;
        $arrCodigos[] = $this->_correiosCodSedex;
        // $arrCodigos[] = $this->_correiosCodSedex10;

        return implode(",", $arrCodigos);
    }

    public function getNomeFromCodigoCorreios($correioCod)
    {
        $strNome = "";

        switch ($correioCod) {
            case $this->_correiosCodSedex:
                $strNome = "Sedex";
                break;
            case $this->_correiosCodPac:
                $strNome = "PAC";
                break;
        }

        return $strNome;
    }

    private function processArrRet($returnCurl)
    {
        $arrRet = array();

        foreach ($returnCurl->cServico as $row) {
            $vRow = (array) $row;

            if ($vRow["Erro"] == 0) {
                $arrItem           = array();
                $arrItem["codigo"] = $vRow["Codigo"];
                $arrItem["nome"]   = $this->getNomeFromCodigoCorreios($vRow["Codigo"]);
                $arrItem["prazo"]  = $vRow["PrazoEntrega"];
                $arrItem["valor"]  = $vRow["Valor"];

                $arrRet[] = $arrItem;
            }
        }

        return $arrRet;
    }

    public function execConsultaFrete($arrProdutos, $cep)
    {
        // https://www.correios.com.br/para-voce/correios-de-a-a-z/pdf/calculador-remoto-de-precos-e-prazos/manual-de-implementacao-do-calculo-remoto-de-precos-e-prazos

        $data['nCdEmpresa']          = ''; // Código da sua empresa, se você tiver contrato com os correios saberá qual é esse código. (opcional)
        $data['sDsSenha']            = ''; // Senha de acesso ao serviço. (opcional)
        $data['sCepOrigem']          = $this->_cepOrigem;
        $data['sCepDestino']         = str_replace(array(".", "-"), "", $cep);
        $data['nVlPeso']             = '1'; // O peso do produto deverá ser enviado em quilogramas
        $data['nCdFormato']          = '1'; // Formato da encomenda, nesse caso tem apenas duas opções: 1 para caixa / pacote e 2 para rolo/prisma.
        $data['nVlComprimento']      = '16'; // informado em centímetros e somente números
        $data['nVlAltura']           = '5'; // informado em centímetros e somente números
        $data['nVlLargura']          = '15'; // informado em centímetros e somente números
        $data['nVlDiametro']         = '0'; // informado em centímetros e somente números
        $data['sCdMaoPropria']       = 'n'; // Mão própria, nesse parâmetro você informa se quer a encomenda deverá ser entregue somente para uma determinada pessoa após confirmação por RG
        $data['nVlValorDeclarado']   = '0'; // O valor declarado serve para o caso de sua encomenda extraviar, então você poderá recuperar o valor dela. Vale lembrar que o valor da encomenda interfere no valor do frete. Se não quiser declarar pode passar 0
        $data['sCdAvisoRecebimento'] = 'n'; // No parâmetro aviso de recebimento, você informa se quer ser avisado sobre a entrega da encomenda. Para não avisar use “n”, para avisar use “s”.
        $data['nIndicaCalculo']      = '3'; // Tipo de informação que será retornada. Valores possíveis: 1, 2 ou 3 // 1 - Só preço // 2 - Só prazo // 3 - Preço e Prazo
        $data['StrRetorno']          = 'xml';
        //$data['nCdServico'] = '40010';
        $data['nCdServico']          = $this->getCodigosTxt(); // '00000,11111,22222'
        $data                        = http_build_query($data);

        $url  = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx';
        $curl = curl_init($url.'?'.$data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result    = curl_exec($curl);
        $resultXML = simplexml_load_string($result);

        $arrResult = $this->processArrRet($resultXML);
        return $arrResult;
    }
}

// ===================================
// classe de Produto =================
class DecoratumProduct
{
    private $_id;
    private $_title;
    private $_description;
    private $_shortDescription;
    private $_price;
    private $_regularPrice;
    private $_salePrice;
    private $_weight; // peso KG
    private $_length; // comprimento cm
    private $_width; // largura cm
    private $_height; // altura cm
    private $_imageId;
    private $_galleryIds;
    private $_reviewCount;
    private $_reviewAvg;
    private $_slug;
    private $_wcProduct;

    private function getImageUrl($imageId, $size = "shop_single")
    {
        // shop_single | shop_catalog | shop_thumbnail
        $arrRet = wp_get_attachment_image_src($imageId, $size);
        return $arrRet[0];
    }

    private function getGalleryUrl($galleryIds, $size = "shop_single")
    {
        $retArray = array();
        foreach ($galleryIds as $imageId) {
            $retArray[] = $this->getImageUrl($imageId, $size);
        }

        return $retArray;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function getShortDescription()
    {
        return $this->_shortDescription;
    }

    public function getPrice()
    {
        return $this->_price;
    }

    public function getRegularPrice()
    {
        return $this->_regularPrice;
    }

    public function getSalePrice()
    {
        return $this->_salePrice;
    }

    public function getWeight()
    {
        return $this->_weight;
    }

    public function getLength()
    {
        return $this->_length;
    }

    public function getWidth()
    {
        return $this->_width;
    }

    public function getHeight()
    {
        return $this->_height;
    }

    public function getImageId()
    {
        return $this->_imageId;
    }

    public function getImageThumbUrl()
    {
        return $this->getImageUrl($this->_imageId, "shop_thumbnail");
    }

    public function getImageCatalogUrl()
    {
        return $this->getImageUrl($this->_imageId, "shop_catalog");
    }

    public function getImageSingleUrl()
    {
        return $this->getImageUrl($this->_imageId, "shop_single");
    }

    public function getGalleryIds()
    {
        return $this->_galleryIds;
    }

    public function getGallerySingleUrl()
    {
        return $this->getGalleryUrl($this->_galleryIds, "shop_single");
    }

    public function getWcProduct()
    {
        return $this->_wcProduct;
    }

    public function getWcProductArray()
    {
        return (array) $this->_wcProduct;
    }

    public function getReviewCount()
    {
        return $this->_reviewCount;
    }

    public function getReviewAvg()
    {
        return $this->_reviewAvg;
    }

    public function getSlug()
    {
        return $this->_slug;
    }

    public function getProductURL()
    {
        return "http://decoratum.com.br/produto/".$this->_slug;
    }

    public function setId($value)
    {
        $this->_id = $value;
        return $this;
    }

    public function setTitle($value)
    {
        $this->_title = $value;
        return $this;
    }

    public function setDescription($value)
    {
        $this->_description = $value;
        return $this;
    }

    public function setShortDescription($value)
    {
        $this->_shortDescription = $value;
        return $this;
    }

    public function setPrice($value)
    {
        $this->_price = $value;
        return $this;
    }

    public function setRegularPrice($value)
    {
        $this->_regularPrice = $value;
        return $this;
    }

    public function setSalePrice($value)
    {
        $this->_salePrice = $value;
        return $this;
    }

    public function setWeight($value)
    {
        $this->_weight = $value;
        return $this;
    }

    public function setLength($value)
    {
        $this->_length = $value;
        return $this;
    }

    public function setWidth($value)
    {
        $this->_width = $value;
        return $this;
    }

    public function setHeight($value)
    {
        $this->_height = $value;
        return $this;
    }

    public function setImageId($value)
    {
        $this->_imageId = $value;
        return $this;
    }

    public function setGalleryIds($value)
    {
        $this->_galleryIds = $value;
        return $this;
    }

    public function setWcProduct($value)
    {
        $this->_wcProduct = $value;
        return $this;
    }

    public function setReviewCount($value)
    {
        $this->_reviewCount = $value;
        return $this;
    }

    public function setReviewAvg($value)
    {
        $this->_reviewAvg = $value;
        return $this;
    }

    public function setSlug($value)
    {
        $this->_slug = $value;
        return $this;
    }
}
// ===================================

function getAllProducts($category = "", $productId = "")
{
    $arrProducts = array();

    $args                   = array();
    $args["post_type"]      = "product";
    $args["posts_per_page"] = -1;
    if ($category != "") {
        $args["product_cat"] = $category;
    }
    if (is_numeric($productId) && $productId > 0) {
        $args["ID"] = $productId;
    }
    $args["orderby"] = "title";

    $loop = new WP_Query($args);
    while ($loop->have_posts()) : $loop->the_post();
        global $product;

        $DecoratumProduct = new DecoratumProduct();
        $DecoratumProduct->setId($product->get_id());
        $DecoratumProduct->setTitle($product->get_name());
        $DecoratumProduct->setDescription($product->get_description());
        $DecoratumProduct->setShortDescription($product->get_short_description());
        $DecoratumProduct->setPrice($product->get_price());
        $DecoratumProduct->setRegularPrice($product->get_regular_price());
        $DecoratumProduct->setSalePrice($product->get_sale_price());
        $DecoratumProduct->setWeight($product->get_weight());
        $DecoratumProduct->setLength($product->get_length());
        $DecoratumProduct->setWidth($product->get_width());
        $DecoratumProduct->setHeight($product->get_height());
        $DecoratumProduct->setImageId($product->get_image_id());
        $DecoratumProduct->setGalleryIds($product->get_gallery_image_ids());
        $DecoratumProduct->setWcProduct($product);
        $DecoratumProduct->setReviewCount(count($product->get_rating_counts()));
        $DecoratumProduct->setReviewAvg($product->get_average_rating());
        $DecoratumProduct->setSlug($product->get_slug());

        // echo "<pre>";
        // print_r($DecoratumProduct);
        // echo "</pre>";

        $arrProducts[] = $DecoratumProduct;

    endwhile;
    wp_reset_query();

    return $arrProducts;
}

function ratingToString($rating)
{
    $strRating = "*";

    switch ($rating) {
        case "5":
            $strRating = "Perfeito";
            break;
        case "4":
            $strRating = "Bom";
            break;
        case "3":
            $strRating = "Razoável";
            break;
        case "2":
            $strRating = "Ruim";
            break;
        case "1":
            $strRating = "Péssimo";
            break;
    }

    return $strRating;
}

function getCartProducts()
{
    global $woocommerce;

    $items   = $woocommerce->cart->get_cart();
    $arrCart = array();

    foreach ($items as $values) {
        // $_product =  wc_get_product( $values['data']->get_id());
        $productId = $values['data']->get_id();
        $ret       = getAllProducts("", $productId);
        $Product   = $ret[0];

        $arrItem            = array();
        $arrItem["product"] = $Product;
        $arrItem["qty"]     = $values['quantity'];
        $arrItem["price"]   = $Product->getPrice();

        $arrCart[] = $arrItem;
    }

    return $arrCart;
}

function getCartURL()
{
    return "http://decoratum.com.br/carrinho";
}

function clearCart()
{
    global $woocommerce;
    $woocommerce->cart->empty_cart();
}

function removeCartItem($productId)
{
    global $woocommerce;

    foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item) {
        /*if ($cart_item['variation_id'] == $productId) {*/
        if ($cart_item['product_id'] == $productId) {
            //remove single product
            $woocommerce->cart->remove_cart_item($cart_item_key);
        }
    }
}

function changeCartItem($productId, $qty)
{
    global $woocommerce;

    foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item) {
        if ($cart_item['product_id'] == $productId) {
            $woocommerce->cart->set_quantity($cart_item_key, $qty);
        }
    }
}