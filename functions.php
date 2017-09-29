<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

    private function getTotalFromArrProd($arrProdutos)
    {
        $totM3 = 0;
        $totKG = 0;

        foreach ($arrProdutos as $item) {
            $Product = $item["Product"];
            $qty     = $item["qty"];

            $vA  = $Product->getHeight() / 100;
            $vL  = $Product->getWidth() / 100;
            $vC  = $Product->getLength() / 100;
            $vM3 = $vA * $vL * $vC;

            $totM3 += $vM3 * $qty;
            $totKG += $Product->getWeight() * $qty;
        }

        $arrTot          = array();
        $arrTot["totM3"] = $totM3;
        $arrTot["totKG"] = $totKG;

        return $arrTot;
    }

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
        // se quiser blocar cep q nao existe, eh aqui que valida
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

    public function generateArrProducts($productIds, $qtys, $fromCart = "N")
    {
        $arrProducts = array();

        if ($fromCart == "S") {
            $cartProd = getCartProducts();
            foreach ($cartProd as $item) {
                $arrItem            = array();
                $arrItem["Product"] = $item["product"];
                $arrItem["qty"]     = (int) $item["qty"];

                $arrProducts[] = $arrItem;
            }
        } else {
            $arrProdIds = explode(",", $productIds);
            $arrQtys    = explode(",", $qtys);

            for ($i = 0; $i < count($arrProdIds); $i++) {
                $ret     = getAllProducts("", $arrProdIds[$i]);
                $Product = $ret[0];

                $arrItem            = array();
                $arrItem["Product"] = $Product;
                $arrItem["qty"]     = (int) $arrQtys[$i];

                $arrProducts[] = $arrItem;
            }
        }

        return $arrProducts;
    }

    public function execConsultaFrete($arrProdutos, $cep)
    {
        // https://www.correios.com.br/para-voce/correios-de-a-a-z/pdf/calculador-remoto-de-precos-e-prazos/manual-de-implementacao-do-calculo-remoto-de-precos-e-prazos
        // 1 forma: calcular a soma dos m3 dos itens do carrinho; tirar a raiz cubica e enviar como AxLxC;
        // 2 forma: passar sempre as medidas minimas e somar o peso dos itens;

        $arrTotProducts = $this->getTotalFromArrProd($arrProdutos);
        $vTotKG         = (isset($arrTotProducts["totKG"])) ? $arrTotProducts["totKG"]
                : 1;
        //$vTotM3       = $arrTotProducts["totM3"];

        $data['nCdEmpresa']          = ''; // Código da sua empresa, se você tiver contrato com os correios saberá qual é esse código. (opcional)
        $data['sDsSenha']            = ''; // Senha de acesso ao serviço. (opcional)
        $data['sCepOrigem']          = $this->_cepOrigem;
        $data['sCepDestino']         = str_replace(array(".", "-"), "", $cep);
        $data['nVlPeso']             = $vTotKG; // O peso do produto deverá ser enviado em quilogramas
        $data['nCdFormato']          = '2'; // Formato da encomenda, nesse caso tem apenas duas opções: 1 para caixa / pacote e 2 para rolo/prisma.
        $data['nVlComprimento']      = '18'; // informado em centímetros e somente números (valor minimo 16)
        $data['nVlAltura']           = '0'; // informado em centímetros e somente números (valor minimo 2)
        $data['nVlLargura']          = '0'; // informado em centímetros e somente números (valor minimo 11)
        $data['nVlDiametro']         = '5'; // informado em centímetros e somente números
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
// classe de Cupom
class DecoratumCoupon
{
    private $_wc_coupon;
    private $_coupon_code;

    public function __construct($vCouponCode)
    {
        $this->_coupon_code = $vCouponCode;
        $this->_wc_coupon   = new WC_Coupon($vCouponCode);
    }

    private function getCouponData()
    {
        $coupon = $this->_wc_coupon;

        /*
          array(43) {

          string(13) "discount_type"
          [23]=>
          string(13) "coupon_amount"
          [24]=>
          string(11) "expiry_date"
          [25]=>
          string(12) "date_expires"
          [26]=>
          string(11) "usage_count"
          [27]=>
          string(14) "individual_use"
          [28]=>
          string(11) "product_ids"
          [29]=>
          string(19) "exclude_product_ids"
          [30]=>
          string(11) "usage_limit"
          [31]=>
          string(20) "usage_limit_per_user"
          [32]=>
          string(22) "limit_usage_to_x_items"
          [33]=>
          string(13) "free_shipping"
          [34]=>
          string(18) "product_categories"
          [35]=>
          string(26) "exclude_product_categories"
          [36]=>
          string(18) "exclude_sale_items"
          [37]=>
          string(14) "minimum_amount"
          [38]=>
          string(14) "maximum_amount"
          [39]=>
          string(14) "customer_email"
          [40]=>
          string(8) "_used_by"
          [41]=>
          string(10) "_edit_lock"
          [42]=>
          string(10) "_edit_last"
          }
         */

        $coupon_post = get_post($coupon->id);
        $coupon_data = array(
            'id' => $coupon->id,
            'code' => $coupon->code,
            'type' => $coupon->type,
            'created_at' => (isset($coupon_post)) ? $coupon_post->post_date_gmt : null,
            'updated_at' => (isset($coupon_post)) ? $coupon_post->post_modified_gmt
                : null,
            'amount' => wc_format_decimal($coupon->coupon_amount, 2),
            'individual_use' => ( 'yes' === $coupon->individual_use ),
            'product_ids' => array_map('absint', (array) $coupon->product_ids),
            'exclude_product_ids' => array_map('absint',
                (array) $coupon->exclude_product_ids),
            'usage_limit' => (!empty($coupon->usage_limit) ) ? $coupon->usage_limit
                : null,
            'usage_limit_user' => (!empty($coupon->usage_limit_per_user) ) ? $coupon->usage_limit_per_user
                : null,
            'usage_count' => (int) $coupon->usage_count,
            'expiry_date' => (!empty($coupon->expiry_date) ) ? date('Y-m-d',
                strtotime($coupon->expiry_date)) : null,
            'enable_free_shipping' => $coupon->enable_free_shipping(),
            'product_category_ids' => array_map('absint',
                (array) $coupon->product_categories),
            'exclude_product_category_ids' => array_map('absint',
                (array) $coupon->exclude_product_categories),
            'exclude_sale_items' => $coupon->exclude_sale_items(),
            'minimum_amount' => wc_format_decimal($coupon->minimum_amount, 2),
            'maximum_amount' => wc_format_decimal($coupon->maximum_amount, 2),
            'customer_emails' => $coupon->customer_email,
            'description' => (isset($coupon_post)) ? $coupon_post->post_excerpt : null,
        );

        return $coupon_data;
    }

    public function isValid()
    {
        $coupon = $this->_wc_coupon;
        return $coupon->is_valid();
    }

    public function addCouponToCart()
    {
        if ($this->isValid()) {
            $coupon_code = $this->_coupon_code;
            $ret         = WC()->cart->add_discount($coupon_code);

            return $ret;
        } else {
            return false;
        }
    }
}

function getProductCategories($args)
{
    $args['taxonomy'] = 'product_cat';

    $all_categories = get_categories($args);
    return $all_categories;
}

function catIdToName($strCategoriesIds)
{
    $arrCat      = explode(",", $strCategoriesIds);
    $arrCatNames = array();

    foreach ($arrCat as $catId) {
        $catName       = get_cat_name($catId);
        $arrCatNames[] = $catName;
    }

    return implode(",", $arrCatNames);
}

function getAllProducts($category = "", $productId = "", $tag = "",
                        $orderBy = "title")
{
    //orderBy: title|price|priceDesc
    $arrProducts = array();

    $args                   = array();
    $args["post_type"]      = "product";
    $args["posts_per_page"] = -1;
    if ($category != "") {
        $strCatNames         = catIdToName($category);
        $args["product_cat"] = $strCatNames;
    }
    if ($tag != "") {
        $args["product_tag"] = $tag;
    }
    if (is_numeric($productId) && $productId > 0) {
        $args["ID"] = $productId;
    }

    if ($orderBy == "price") {
        $args["orderby"]  = "meta_value_num";
        $args["meta_key"] = "_$orderBy";
    } else if ($orderBy == "priceDesc") {
        $args["orderby"]  = "meta_value_num";
        $args["meta_key"] = "_price";
        $args["order"]    = "desc";
    } else {
        $args["orderby"] = $orderBy;
    }

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

function getOrderById($orderId)
{
    /*
     *
    object(WC_Order)#9767 (14) {
        ["status_transition":protected]=>
        bool(false)
        ["data":protected]=>
        array(28) {
          ["parent_id"]=>
          int(0)
          ["status"]=>
          string(10) "processing"
          ["currency"]=>
          string(3) "BRL"
          ["version"]=>
          string(5) "3.1.2"
          ["prices_include_tax"]=>
          bool(false)
          ["date_created"]=>
          object(WC_DateTime)#9774 (4) {
            ["utc_offset":protected]=>
            int(-10800)
            ["date"]=>
            string(26) "2017-09-12 12:50:54.000000"
            ["timezone_type"]=>
            int(1)
            ["timezone"]=>
            string(6) "+00:00"
          }
          ["date_modified"]=>
          object(WC_DateTime)#9775 (4) {
            ["utc_offset":protected]=>
            int(-10800)
            ["date"]=>
            string(26) "2017-09-12 12:51:39.000000"
            ["timezone_type"]=>
            int(1)
            ["timezone"]=>
            string(6) "+00:00"
          }
          ["discount_total"]=>
          string(4) "39.5"
          ["discount_tax"]=>
          string(1) "0"
          ["shipping_total"]=>
          string(4) "16.1"
          ["shipping_tax"]=>
          string(1) "0"
          ["cart_tax"]=>
          string(1) "0"
          ["total"]=>
          string(5) "16.50"
          ["total_tax"]=>
          string(1) "0"
          ["customer_id"]=>
          int(0)
          ["order_key"]=>
          string(22) "wc_order_59b7d82eef740"
          ["billing"]=>
          array(11) {
            ["first_name"]=>
            string(13) "Leandro Parra"
            ["last_name"]=>
            string(0) ""
            ["company"]=>
            string(0) ""
            ["address_1"]=>
            string(25) "Av. Carlos Rosenfeld, 185"
            ["address_2"]=>
            string(16) "Bairro Cachoeira"
            ["city"]=>
            string(11) "Nova Odessa"
            ["state"]=>
            string(2) "SP"
            ["postcode"]=>
            string(9) "01254-200"
            ["country"]=>
            string(2) "BR"
            ["email"]=>
            string(19) "nixlovemi@gmail.com"
            ["phone"]=>
            string(14) "(19) 981324148"
          }
          ["shipping"]=>
          array(9) {
            ["first_name"]=>
            string(13) "Leandro Parra"
            ["last_name"]=>
            string(0) ""
            ["company"]=>
            string(0) ""
            ["address_1"]=>
            string(25) "Av. Carlos Rosenfeld, 185"
            ["address_2"]=>
            string(16) "Bairro Cachoeira"
            ["city"]=>
            string(11) "Nova Odessa"
            ["state"]=>
            string(2) "SP"
            ["postcode"]=>
            string(9) "01254-200"
            ["country"]=>
            string(2) "BR"
          }
          ["payment_method"]=>
          string(0) ""
          ["payment_method_title"]=>
          string(0) ""
          ["transaction_id"]=>
          string(0) ""
          ["customer_ip_address"]=>
          string(12) "192.168.0.79"
          ["customer_user_agent"]=>
          string(82) "mozilla/5.0 (macintosh; intel mac os x 10.12; rv:55.0) gecko/20100101 firefox/55.0"
          ["created_via"]=>
          string(0) ""
          ["customer_note"]=>
          string(0) ""
          ["date_completed"]=>
          NULL
          ["date_paid"]=>
          object(WC_DateTime)#9828 (4) {
            ["utc_offset":protected]=>
            int(-10800)
            ["date"]=>
            string(26) "2017-09-12 09:51:39.000000"
            ["timezone_type"]=>
            int(1)
            ["timezone"]=>
            string(6) "+00:00"
          }
          ["cart_hash"]=>
          string(0) ""
        }
        ["items":protected]=>
        array(0) {
        }
        ["items_to_delete":protected]=>
        array(0) {
        }
        ["cache_group":protected]=>
        string(6) "orders"
        ["data_store_name":protected]=>
        string(5) "order"
        ["object_type":protected]=>
        string(5) "order"
        ["id":protected]=>
        int(200)
        ["changes":protected]=>
        array(0) {
        }
        ["object_read":protected]=>
        bool(true)
        ["extra_data":protected]=>
        array(0) {
        }
        ["default_data":protected]=>
        array(28) {
          ["parent_id"]=>
          int(0)
          ["status"]=>
          string(0) ""
          ["currency"]=>
          string(0) ""
          ["version"]=>
          string(0) ""
          ["prices_include_tax"]=>
          bool(false)
          ["date_created"]=>
          NULL
          ["date_modified"]=>
          NULL
          ["discount_total"]=>
          int(0)
          ["discount_tax"]=>
          int(0)
          ["shipping_total"]=>
          int(0)
          ["shipping_tax"]=>
          int(0)
          ["cart_tax"]=>
          int(0)
          ["total"]=>
          int(0)
          ["total_tax"]=>
          int(0)
          ["customer_id"]=>
          int(0)
          ["order_key"]=>
          string(0) ""
          ["billing"]=>
          array(11) {
            ["first_name"]=>
            string(0) ""
            ["last_name"]=>
            string(0) ""
            ["company"]=>
            string(0) ""
            ["address_1"]=>
            string(0) ""
            ["address_2"]=>
            string(0) ""
            ["city"]=>
            string(0) ""
            ["state"]=>
            string(0) ""
            ["postcode"]=>
            string(0) ""
            ["country"]=>
            string(0) ""
            ["email"]=>
            string(0) ""
            ["phone"]=>
            string(0) ""
          }
          ["shipping"]=>
          array(9) {
            ["first_name"]=>
            string(0) ""
            ["last_name"]=>
            string(0) ""
            ["company"]=>
            string(0) ""
            ["address_1"]=>
            string(0) ""
            ["address_2"]=>
            string(0) ""
            ["city"]=>
            string(0) ""
            ["state"]=>
            string(0) ""
            ["postcode"]=>
            string(0) ""
            ["country"]=>
            string(0) ""
          }
          ["payment_method"]=>
          string(0) ""
          ["payment_method_title"]=>
          string(0) ""
          ["transaction_id"]=>
          string(0) ""
          ["customer_ip_address"]=>
          string(0) ""
          ["customer_user_agent"]=>
          string(0) ""
          ["created_via"]=>
          string(0) ""
          ["customer_note"]=>
          string(0) ""
          ["date_completed"]=>
          NULL
          ["date_paid"]=>
          NULL
          ["cart_hash"]=>
          string(0) ""
        }
        ["data_store":protected]=>
        object(WC_Data_Store)#9768 (4) {
          ["instance":"WC_Data_Store":private]=>
          object(WC_Order_Data_Store_CPT)#9769 (3) {
            ["internal_meta_keys":protected]=>
            array(77) {
              [0]=>
              string(10) "_parent_id"
              [1]=>
              string(7) "_status"
              [2]=>
              string(9) "_currency"
              [3]=>
              string(8) "_version"
              [4]=>
              string(19) "_prices_include_tax"
              [5]=>
              string(13) "_date_created"
              [6]=>
              string(14) "_date_modified"
              [7]=>
              string(15) "_discount_total"
              [8]=>
              string(13) "_discount_tax"
              [9]=>
              string(15) "_shipping_total"
              [10]=>
              string(13) "_shipping_tax"
              [11]=>
              string(9) "_cart_tax"
              [12]=>
              string(6) "_total"
              [13]=>
              string(10) "_total_tax"
              [14]=>
              string(12) "_customer_id"
              [15]=>
              string(10) "_order_key"
              [16]=>
              string(8) "_billing"
              [17]=>
              string(9) "_shipping"
              [18]=>
              string(15) "_payment_method"
              [19]=>
              string(21) "_payment_method_title"
              [20]=>
              string(15) "_transaction_id"
              [21]=>
              string(20) "_customer_ip_address"
              [22]=>
              string(20) "_customer_user_agent"
              [23]=>
              string(12) "_created_via"
              [24]=>
              string(14) "_customer_note"
              [25]=>
              string(15) "_date_completed"
              [26]=>
              string(10) "_date_paid"
              [27]=>
              string(10) "_cart_hash"
              [28]=>
              string(14) "_customer_user"
              [29]=>
              string(10) "_order_key"
              [30]=>
              string(15) "_order_currency"
              [31]=>
              string(19) "_billing_first_name"
              [32]=>
              string(18) "_billing_last_name"
              [33]=>
              string(16) "_billing_company"
              [34]=>
              string(18) "_billing_address_1"
              [35]=>
              string(18) "_billing_address_2"
              [36]=>
              string(13) "_billing_city"
              [37]=>
              string(14) "_billing_state"
              [38]=>
              string(17) "_billing_postcode"
              [39]=>
              string(16) "_billing_country"
              [40]=>
              string(14) "_billing_email"
              [41]=>
              string(14) "_billing_phone"
              [42]=>
              string(20) "_shipping_first_name"
              [43]=>
              string(19) "_shipping_last_name"
              [44]=>
              string(17) "_shipping_company"
              [45]=>
              string(19) "_shipping_address_1"
              [46]=>
              string(19) "_shipping_address_2"
              [47]=>
              string(14) "_shipping_city"
              [48]=>
              string(15) "_shipping_state"
              [49]=>
              string(18) "_shipping_postcode"
              [50]=>
              string(17) "_shipping_country"
              [51]=>
              string(15) "_completed_date"
              [52]=>
              string(10) "_paid_date"
              [53]=>
              string(10) "_edit_lock"
              [54]=>
              string(10) "_edit_last"
              [55]=>
              string(14) "_cart_discount"
              [56]=>
              string(18) "_cart_discount_tax"
              [57]=>
              string(15) "_order_shipping"
              [58]=>
              string(19) "_order_shipping_tax"
              [59]=>
              string(10) "_order_tax"
              [60]=>
              string(12) "_order_total"
              [61]=>
              string(15) "_payment_method"
              [62]=>
              string(21) "_payment_method_title"
              [63]=>
              string(15) "_transaction_id"
              [64]=>
              string(20) "_customer_ip_address"
              [65]=>
              string(20) "_customer_user_agent"
              [66]=>
              string(12) "_created_via"
              [67]=>
              string(14) "_order_version"
              [68]=>
              string(19) "_prices_include_tax"
              [69]=>
              string(15) "_date_completed"
              [70]=>
              string(10) "_date_paid"
              [71]=>
              string(15) "_payment_tokens"
              [72]=>
              string(22) "_billing_address_index"
              [73]=>
              string(23) "_shipping_address_index"
              [74]=>
              string(15) "_recorded_sales"
              [75]=>
              string(29) "_recorded_coupon_usage_counts"
              [76]=>
              string(16) "_shipping_method"
            }
            ["meta_type":protected]=>
            string(4) "post"
            ["object_id_field_for_meta":protected]=>
            string(0) ""
          }
          ["stores":"WC_Data_Store":private]=>
          array(18) {
            ["coupon"]=>
            string(24) "WC_Coupon_Data_Store_CPT"
            ["customer"]=>
            string(22) "WC_Customer_Data_Store"
            ["customer-download"]=>
            string(31) "WC_Customer_Download_Data_Store"
            ["customer-session"]=>
            string(30) "WC_Customer_Data_Store_Session"
            ["order"]=>
            string(23) "WC_Order_Data_Store_CPT"
            ["order-refund"]=>
            string(30) "WC_Order_Refund_Data_Store_CPT"
            ["order-item"]=>
            string(24) "WC_Order_Item_Data_Store"
            ["order-item-coupon"]=>
            string(31) "WC_Order_Item_Coupon_Data_Store"
            ["order-item-fee"]=>
            string(28) "WC_Order_Item_Fee_Data_Store"
            ["order-item-product"]=>
            string(32) "WC_Order_Item_Product_Data_Store"
            ["order-item-shipping"]=>
            string(33) "WC_Order_Item_Shipping_Data_Store"
            ["order-item-tax"]=>
            string(28) "WC_Order_Item_Tax_Data_Store"
            ["payment-token"]=>
            string(27) "WC_Payment_Token_Data_Store"
            ["product"]=>
            string(25) "WC_Product_Data_Store_CPT"
            ["product-grouped"]=>
            string(33) "WC_Product_Grouped_Data_Store_CPT"
            ["product-variable"]=>
            string(34) "WC_Product_Variable_Data_Store_CPT"
            ["product-variation"]=>
            string(35) "WC_Product_Variation_Data_Store_CPT"
            ["shipping-zone"]=>
            string(27) "WC_Shipping_Zone_Data_Store"
          }
          ["current_class_name":"WC_Data_Store":private]=>
          string(23) "WC_Order_Data_Store_CPT"
          ["object_type":"WC_Data_Store":private]=>
          string(5) "order"
        }
        ["meta_data":protected]=>
        array(7) {
          [0]=>
          object(stdClass)#9830 (3) {
            ["id"]=>
            int(2986)
            ["key"]=>
            string(15) "_shipping_email"
            ["value"]=>
            string(19) "nixlovemi@gmail.com"
          }
          [1]=>
          object(stdClass)#9829 (3) {
            ["id"]=>
            int(2987)
            ["key"]=>
            string(15) "_shipping_phone"
            ["value"]=>
            string(14) "(19) 981324148"
          }
          [2]=>
          object(stdClass)#9831 (3) {
            ["id"]=>
            int(2988)
            ["key"]=>
            string(13) "pagseguro_key"
            ["value"]=>
            string(32) "7CD1900BEDED449664D80FB335A4E57C"
          }
          [3]=>
          object(stdClass)#9832 (3) {
            ["id"]=>
            int(2990)
            ["key"]=>
            string(29) "_download_permissions_granted"
            ["value"]=>
            string(3) "yes"
          }
          [4]=>
          object(stdClass)#9833 (3) {
            ["id"]=>
            int(2994)
            ["key"]=>
            string(23) "pagseguro_paymentStatus"
            ["value"]=>
            string(9) "Cancelada"
          }
          [5]=>
          object(stdClass)#9834 (3) {
            ["id"]=>
            int(2995)
            ["key"]=>
            string(18) "pagseguro_dtUpdate"
            ["value"]=>
            string(19) "25/09/2017 07:30:46"
          }
          [6]=>
          object(stdClass)#9835 (3) {
            ["id"]=>
            int(3019)
            ["key"]=>
            string(25) "pagseguro_transactionCode"
            ["value"]=>
            string(39) "C3BF69-CC92649264B6-26649BCFBD4D-694A9C"
          }
        }
      }
    */

    $arrOrder = array();

    $order   = new WC_Order( $orderId );
    $version = trim($order->version);
    
    if($version != ""){
        $orderItens = $order->get_items();
        $order      = $order->data;

        $arrOrder["orderID"]     = $orderId;
        $arrOrder["status"]      = $order["status"];
        $arrOrder["date"]        = date("Y-m-d H:i:s", $order["date_created"]->getOffsetTimestamp());
        $arrOrder["discountVal"] = $order["discount_total"];
        $arrOrder["shippingVal"] = $order["shipping_total"];
        $arrOrder["total"]       = $order["total"];
        
        $arrOrder["cliName"]     = $order["billing"]["first_name"];
        $arrOrder["cliAddress"]  = $order["billing"]["address_1"];
        $arrOrder["cliDistrict"] = $order["billing"]["address_2"];
        $arrOrder["cliCity"]     = $order["billing"]["city"];
        $arrOrder["cliState"]    = $order["billing"]["state"];
        $arrOrder["cliPostcode"] = $order["billing"]["postcode"];
        $arrOrder["cliEmail"]    = $order["billing"]["email"];
        $arrOrder["cliPhone"]    = $order["billing"]["phone"];

        foreach($order["meta_data"] as $metaItem){
            $key   = $metaItem->key;
            $value = $metaItem->value;

            switch($key){
                case "pagseguro_key":
                    $arrOrder["pagseguroKey"] = $value;
                    break;
                case "pagseguro_paymentStatus":
                    $arrOrder["pagseguroPaymentStatus"] = $value;
                    break;
                case "pagseguro_dtUpdate":
                    $arrOrder["pagseguroDtUpdate"] = $value;
                    break;
                case "pagseguro_transactionCode":
                    $arrOrder["pagseguroTransCode"] = $value;
                    break;
            }
        }

        $arrOrder["products"] = array();
        foreach($orderItens as $orderItem => $arrOrderItem){
            $arrItem = array();
            $arrItem["name"]   = $arrOrderItem["name"];
            $arrItem["prodId"] = $arrOrderItem["product_id"];

            $arrRet = getAllProducts("", $arrItem["prodId"]);
            $arrItem["DecoratumProduct"] = null;
            if( count($arrRet) > 0 ){
                $arrItem["DecoratumProduct"] = $arrRet[0];
            }

            $arrItem["qty"]      = $arrOrderItem["quantity"];
            $arrItem["subTotal"] = $arrOrderItem["subtotal"];
            $arrItem["total"]    = $arrOrderItem["total"];
            
            $arrOrder["products"][] = $arrItem;
        }
    }

    return $arrOrder;
}

function moneyToFloat($str)
{
    $str = trim($str);

    if (strlen($str) <= 0) {
        return null;
    }

    $str = str_replace(".", "", $str);
    $str = str_replace(",", ".", $str);
    $str = str_replace("R$", "", $str);
    $str = str_replace("US$", "", $str);
    $str = str_replace("U$", "", $str);
    $str = str_replace("$", "", $str);
    $str = str_replace(" ", "", $str);
    return (float) $str;
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

function getCartSubtotal()
{
    /* global $woocommerce;

      $items    = $woocommerce->cart->get_cart();
      $subtotal = 0;

      foreach ($items as $values) {
      $productId = $values['data']->get_id();
      $ret       = getAllProducts("", $productId);
      $Product   = $ret[0];

      $subtotal += $Product->getPrice() * $values['quantity'];
      } */

    $subtotal = number_format((float) WC()->cart->subtotal, 2, ".", "");
    return $subtotal;
}

function getCartTotal()
{
    /* global $woocommerce;

      $items    = $woocommerce->cart->get_cart();
      $subtotal = 0;

      foreach ($items as $values) {
      $productId = $values['data']->get_id();
      $ret       = getAllProducts("", $productId);
      $Product   = $ret[0];

      $subtotal += $Product->getPrice() * $values['quantity'];
      } */

    //$total = strip_tags(WC()->cart->get_cart_total());
    // echo "<pre>";
    // var_dump($total);
    // echo "</pre>";

    global $woocommerce;

    $total  = $woocommerce->cart->cart_contents_total + $woocommerce->cart->tax_total;
    $total2 = number_format((float) $total, 2, ".", "");
    return $total2;
}

function getCartCoupon()
{
    $arrCartCoupon = array();
    $cartCoupons   = WC()->cart->get_coupons();

    if (count($cartCoupons) > 0) {
        foreach ($cartCoupons as $code => $coupon) {
            $arrCartCoupon["code"]      = strtoupper($code);
            $arrCartCoupon["WC_coupon"] = $coupon;
        }

        $vCouponValue           = getTotalCoupon();
        $arrCartCoupon["value"] = $vCouponValue;
    }

    return $arrCartCoupon;
}

function getTotalCoupon()
{
    return number_format((float) getCartSubtotal() - getCartTotal(), 2, ".", "");
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

        $arrItem              = array();
        $arrItem["productID"] = $productId;
        $arrItem["product"]   = $Product;
        $arrItem["qty"]       = $values['quantity'];
        $arrItem["price"]     = $Product->getPrice();

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
        /* if ($cart_item['variation_id'] == $productId) { */
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

function findCep($cep)
{
    $arrRet = array();
    $vCep   = str_replace(array(".", "-"), "", $cep);

    $data['cep']     = $vCep;
    $data['formato'] = "query_string";
    $data            = http_build_query($data);

    $url  = 'http://cep.republicavirtual.com.br/web_cep.php';
    $curl = curl_init($url.'?'.$data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $resultado = curl_exec($curl);
    if (!$resultado) {
        $resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";
    }

    parse_str($resultado, $arrRet);
    $arrRet = array_map('trim', $arrRet);
    $arrRet = array_map('utf8_encode', $arrRet);

    $arrRetorno                  = array();
    $arrRetorno["ok"]            = $arrRet["resultado"] != 0;
    $arrRetorno["msg"]           = $arrRet["resultado_txt"];
    $arrRetorno["completo"]      = $arrRet["resultado_txt"] == "sucesso - cep completo";
    $arrRetorno["uf"]            = $arrRet["uf"];
    $arrRetorno["cidade"]        = $arrRet["cidade"];
    $arrRetorno["bairro"]        = $arrRet["bairro"];
    $arrRetorno["tp_logradouro"] = $arrRet["tipo_logradouro"];
    $arrRetorno["logradouro"]    = $arrRet["logradouro"];
    $arrRetorno["endereco"]      = $arrRet["tipo_logradouro"]." ".$arrRet["logradouro"];

    return $arrRetorno;
}

function getHtmlTbCart($cartItens, $isCheckout=false)
{
    $cartTotal = 0;
    ?>

    <small class="mb-5" id="label-deslize">Deslize para ver a tabela</small>
    <div id="holder-tb-carrinho">
        <table id="tb-carrinho" class="mb-25">
            <thead>
                <tr>
                    <th style="text-align:center;">Produto</th>
                    <th style="width:16%; text-align:center;">Preço</th>
                    <th style="width:16%; text-align:center;">Quantidade</th>
                    <th style="width:16%; text-align:center;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($cartItens as $item) {
                    $Produto = $item["product"];
                    $qty     = (int) $item["qty"];
                    $price   = $item["price"];
                    $total   = $price * $qty;

                    $strQty    = ($qty < 9) ? '0'.$qty : $qty;
                    $cartTotal += $total;
                    ?>

                    <tr>
                        <td>
                            <a href="<?php echo $Produto->getProductURL(); ?>">
                                <img style="float: left; margin-right: 15px; width: 78px; height: 62px;" alt="Decoratum - <?php echo $Produto->getTitle(); ?>" src="<?php echo $Produto->getImageThumbUrl() ?>">
                            </a>
                            <a class="prod-title-cart" href="<?php echo $Produto->getProductURL(); ?>">
                                <?php echo $Produto->getTitle(); ?>
                            </a>
                            <br />
                            Entrega em até 7 dias úteis para São Paulo.
                        </td>
                        <td class="product-price">
                            R$<?php echo number_format($price, 2, ",", "."); ?>
                        </td>
                        <td class="product-price">
                            <?php
                            if($isCheckout){
                                echo $strQty;
                            } else {
                                ?>
                                <input id="qty_<?php echo $Produto->getId(); ?>" name="qty" class="qntdd_prod qtde_carrinho mask-qty-prod" value="<?php echo $strQty; ?>" maxlength="2" title="O campo de quantidade aceita apenas números, de 1 até 99." type="text" />
                                <center class="mt-5">
                                    <a title="Remover do Carrinho" href="javascript:;" onClick="changeCartItem(<?php echo $Produto->getId(); ?>)">
                                        <img alt="Alterar Quantidade" width="13" height="18" src="<?php bloginfo('template_url'); ?>/images/icon-loop.png" />
                                    </a>
                                    &nbsp;
                                    <a title="Remover do Carrinho" href="<?php echo esc_url(home_url('/')).'?remove_cart='.$Produto->getId(); ?>">
                                        <img alt="Remover do Carrinho" width="18" height="18" src="<?php bloginfo('template_url'); ?>/images/icon-trash.png" />
                                    </a>
                                </center>
                                <?php
                            }
                            ?>
                        </td>
                        <td class="product-price">
                            R$<?php echo number_format($total, 2, ",", "."); ?>
                        </td>
                    </tr>

                <?php
            }
            ?>
            </tbody>
        </table>
    </div>

    <ul class="ul-subtotal-list">
        <li>
            <div class="subtotal">
                <table class="tb-subtotal">
                    <tbody>
                        <?php
                        if(!$isCheckout){
                            ?>
                            <tr>
                                <td width="50%" align="right">
                                    <button style="width: 80%;" type="button" title="Consultar" class="button btn-frete mt-10 mb-20" id="btn-cons-frete" onclick="goToShopping()">
                                        Continuar Compra
                                    </button>
                                </td>
                                <td width="50%" align="right">
                                    <button style="width: 80%;" type="button" title="Consultar" class="button btn-frete mt-10 mb-20" id="btn-cons-frete" onclick="clearCart()">
                                        Limpar Carrinho
                                    </button>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td class="texto">Subtotal</td>
                            <td class="valor">R$<?php echo number_format($cartTotal, 2, ",", "."); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </li>

        <li>
            <div class="subtotal">
                <table class="tb-subtotal">
                    <tbody>
                        <tr>
                            <td class="texto">Frete</td>
                            <td class="">
                                <div style="float: right; text-align: right; font-size: 15px;">
                                    <?php
                                    if($isCheckout){
                                        $vCepValue = (isset($_SESSION["cepValue"])) ? $_SESSION["cepValue"]: "";
                                        $vFreteStr = (isset($_SESSION["freteStr"])) ? $_SESSION["freteStr"]: "";

                                        echo "CEP: $vCepValue";
                                        echo "<br />";
                                        echo $vFreteStr;
                                    } else {
                                        ?>
                                        <input style="width: 100%" id="frete_carrinho" name="frete_carrinho" class="inpt-frete mask-cep" value="" maxlength="8" title="" type="text">
                                        <br />
                                        <button style="width: 100%;" type="button" title="Consultar" class="button btn-frete mt-10 mb-20" id="btn-cons-frete" onclick="calculaFrete('', '', $('#frete_carrinho').val(), 'ret-frete-cart', 'S')">
                                            &nbsp;
                                            Consultar
                                        </button>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <?php
                        if(!$isCheckout){
                            ?>
                            <tr>
                                <td colspan="2">
                                    <small id="ret-frete-cart" style="width:100%; text-align:center; display:block;"></small>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </li>

        <li>
            <div class="subtotal">
                <table class="tb-subtotal">
                    <tbody>
                        <tr>
                            <td class="texto">Cupom</td>
                            <td class="">
                                <div style="float: right; text-align: right; font-size: 15px;">
                                    <?php
                                    $arrCoupons = getCartCoupon();
                                    $vCode      = "";
                                    $vTotal     = "";

                                    if($isCheckout){
                                        if (count($arrCoupons) > 0) {
                                            $vCode  = $arrCoupons["code"];
                                            $vTotal = "Desconto: R$".number_format($arrCoupons["value"], 2, ",", ".");

                                            echo "Cupom: $vCode";
                                            echo "<br />";
                                            echo $vTotal;
                                        } else {
                                            echo "Nenhum cupom vinculado";
                                        }
                                    } else {
                                        if (count($arrCoupons) > 0) {
                                            $vCode  = $arrCoupons["code"];
                                            $vTotal = "Desconto: R$".number_format($arrCoupons["value"], 2, ",", ".");
                                        }
                                        ?>
                                    
                                        <input style="width: 100%" id="cupom_carrinho" name="cupom_carrinho" class="inpt-frete" value="<?php echo $vCode; ?>" maxlength="14" title="" type="text" />
                                        <br />
                                        <button style="width: 100%;" type="button" title="Consultar" class="button btn-frete mt-10 mb-20" id="btn-cons-frete" onclick="addCoupon_Cart();" />
                                        &nbsp;
                                        Adicionar
                                        </button>
                                        <br />
                                        <small id="ret-ajax-coupon" style="width:100%; text-align:center; display:block;"><?php echo $vTotal; ?></small>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </li>

        <li>
            <div class="subtotal">
                <table class="tb-subtotal">
                    <tbody>
                        <tr>
                            <td class="texto">TOTAL</td>
                            <td class="valor" style="font-weight:bold;">
                                <?php
                                $vFreteVlr = (isset($_SESSION["freteVlr"])) ? $_SESSION["freteVlr"]: 0;
                                $vTotal = ($isCheckout) ? getCartTotal() + $vFreteVlr: getCartTotal();
                                ?>
                                <span id="spn-cart-total">R$<?php echo number_format($vTotal, 2, ",", "."); ?></span>
                            </td>
                        </tr>
                        <?php
                        if(!$isCheckout){
                            ?>
                            <tr>
                                <td colspan="2" class="texto">
                                    <button style="width: 60%; float:right; font-size:18px;" type="button" title="Consultar" class="button btn-frete mt-10 mb-20" id="btn-cons-frete" onclick="goToCheckout()">
                                        &nbsp;
                                        Finalizar Compra
                                    </button>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </li>
    </ul>

    <?php
}

function setPagSeguroKey($keyValue, $postID)
{
    $ret = add_post_meta( $postID, 'pagseguro_key', $keyValue, true );

    if ( !$ret ) {
        $ret = update_post_meta( $postID, 'pagseguro_key', $keyValue );
    }
    
    return $ret;
}

function setPagSeguroTransCode($transCode, $postID)
{
    $ret = add_post_meta( $postID, 'pagseguro_transactionCode', $transCode, true );

    if ( !$ret ) {
        $ret = update_post_meta( $postID, 'pagseguro_transactionCode', $transCode );
    }

    return $ret;
}

function setPagSeguroPaymentUrl($paymentUrl, $postID)
{
    $ret = add_post_meta( $postID, 'pagseguro_paymentLink', $paymentUrl, true );

    if ( !$ret ) {
        $ret = update_post_meta( $postID, 'pagseguro_paymentLink', $paymentUrl );
    }

    return $ret;
}

function setPagSeguroPaymentStatus($paymentStatus, $postID)
{
    $ret = add_post_meta( $postID, 'pagseguro_paymentStatus', $paymentStatus, true );

    if ( !$ret ) {
        $ret = update_post_meta( $postID, 'pagseguro_paymentStatus', $paymentStatus );
    }

    return $ret;
}

function setPagSeguroDtUpdate($dtUpdate, $postID)
{
    $ret = add_post_meta( $postID, 'pagseguro_dtUpdate', $dtUpdate, true );

    if ( !$ret ) {
        $ret = update_post_meta( $postID, 'pagseguro_dtUpdate', $dtUpdate );
    }

    return $ret;
}

function getPagSeguroInfo()
{
    $arrInfo = array();
    $arrInfo["mail"]   = "carla@decoratum.com.br";
    $arrInfo["secret"] = "2B205FD423A14C7EB1E499C4247FE3D7";

    return $arrInfo;
}

function getStatusPagSeguro($transactionCode="", $referenceCode="", $notificationCode="")
{
    /*
    Array
    (
        [date] => 2017-09-11T10:43:44.000-03:00
        [code] => F262D215-F1CE-4F40-A394-85B16FB64873
        [reference] => 196
        [type] => 1
        [status] => 1
        [lastEventDate] => 2017-09-11T10:47:27.000-03:00
        [paymentMethod] => Array
            (
                [type] => 2
                [code] => 202
            )

        [paymentLink] => https://pagseguro.uol.com.br/checkout/payment/booklet/print.jhtml?c=18a5435a0e410a8e00e3be18ab9c327eb7dc295751697585a79bc063a3d0f7c0c7ea92eddcc85add
        [grossAmount] => 46.00
        [discountAmount] => 0.00
        [creditorFees] => Array
            (
                [intermediationRateAmount] => 0.40
                [intermediationFeeAmount] => 1.84
            )

        [netAmount] => 43.76
        [extraAmount] => -10.00
        [installmentCount] => 1
        [itemCount] => 1
        [items] => Array
            (
                [item] => Array
                    (
                        [id] => 123
                        [description] => Capa Caderneta de Vacinação
                        [quantity] => 1
                        [amount] => 39.90
                    )

            )

        [sender] => Array
            (
                [name] => Leandro Parra
                [email] => nixlovemi@gmail.com
                [phone] => Array
                    (
                        [areaCode] => 19
                        [number] => 34683244
                    )

            )

        [shipping] => Array
            (
                [address] => Array
                    (
                        [street] => Av. Carlos Rosenfeld
                        [number] => 185
                        [complement] => Array
                            (
                            )

                        [district] => Cachoeira
                        [city] => Nova Odessa
                        [state] => SP
                        [country] => BRA
                        [postalCode] => 13477780
                    )

                [type] => 3
                [cost] => 16.10
            )

        [primaryReceiver] => Array
            (
                [publicKey] => PUB3587E34560E6409E93B2E6666A422325
            )

    )
    */

    $infoPS   = getPagSeguroInfo();
    $mailPS   = $infoPS["mail"];
    $secretPS = $infoPS["secret"];
    
    if($transactionCode != ""){
       $url = "https://ws.pagseguro.uol.com.br/v3/transactions/$transactionCode/?email=$mailPS&token=$secretPS";
    } elseif($referenceCode != ""){
       $url = "https://ws.pagseguro.uol.com.br/v2/transactions/?email=$mailPS&token=$secretPS&reference=$referenceCode";
    } elseif($notificationCode != ""){
        $url = "https://ws.pagseguro.uol.com.br/v3/transactions/notifications/$notificationCode/?email=$mailPS&token=$secretPS";
    } else {
        return false;
    }

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $xml = curl_exec($curl);
    curl_close($curl);

    $arrRet["ok"]             = false;
    $arrRet["retPS"]          = array();
    $arrRet["typeStr"]        = "";
    $arrRet["statusStr"]      = "";
    $arrRet["paymentTypeStr"] = "";
    $arrRet["paymentCodeStr"] = "";

    if($xml == 'Unauthorized'){
        $arrRet["ok"] = false;
    } else {
        $arrRet["ok"] = true;

        $xml   = simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);
        $json  = json_encode($xml);
        $array = json_decode($json,TRUE);
        $arrRet["retPS"] = $array;

        switch($array["type"]){
            case 1:
                $arrRet["typeStr"] = "Pagamento";
                break;
            default:
                $arrRet["typeStr"] = "**";
                break;
        }

        switch($array["status"]){
            case 1:
                $arrRet["statusStr"] = "Aguardando pagamento";
                break;
            case 2:
                $arrRet["statusStr"] = "Em análise";
                break;
            case 3:
                $arrRet["statusStr"] = "Paga";
                break;
            case 4:
                $arrRet["statusStr"] = "Disponível";
                break;
            case 5:
                $arrRet["statusStr"] = "Em disputa";
                break;
            case 6:
                $arrRet["statusStr"] = "Devolvida";
                break;
            case 7:
                $arrRet["statusStr"] = "Cancelada";
                break;
            default:
                $arrRet["statusStr"] = "**";
                break;
        }

        switch($array["paymentMethod"]["type"]){
            case 1:
                $arrRet["paymentTypeStr"] = "Cartão de crédito";
                break;
            case 2:
                $arrRet["paymentTypeStr"] = "Boleto";
                break;
            case 3:
                $arrRet["paymentTypeStr"] = "Débito online (TEF)";
                break;
            case 4:
                $arrRet["paymentTypeStr"] = "Saldo PagSeguro";
                break;
            case 5:
                $arrRet["paymentTypeStr"] = "Oi Paggo";
                break;
            case 7:
                $arrRet["paymentTypeStr"] = "Depósito em conta";
                break;
            default:
                $arrRet["paymentTypeStr"] = "**";
                break;
        }

        switch($array["paymentMethod"]["code"]){
            case 101:
                $arrRet["paymentCodeStr"] = "Cartão de crédito Visa";
                break;
            case 102:
                $arrRet["paymentCodeStr"] = "Cartão de crédito MasterCard";
                break;
            case 103:
                $arrRet["paymentCodeStr"] = "Cartão de crédito American Express";
                break;
            case 104:
                $arrRet["paymentCodeStr"] = "Cartão de crédito Diners";
                break;
            case 105:
                $arrRet["paymentCodeStr"] = "Cartão de crédito Hipercard.";
                break;
            case 106:
                $arrRet["paymentCodeStr"] = "Cartão de crédito Aura";
                break;
            case 107:
                $arrRet["paymentCodeStr"] = "Cartão de crédito Elo";
                break;
            case 108:
                $arrRet["paymentCodeStr"] = "Cartão de crédito PLENOCard";
                break;
            case 109:
                $arrRet["paymentCodeStr"] = "Cartão de crédito PersonalCard";
                break;
            case 110:
                $arrRet["paymentCodeStr"] = "Cartão de crédito JCB";
                break;
            case 111:
                $arrRet["paymentCodeStr"] = "Cartão de crédito Discover";
                break;
            case 112:
                $arrRet["paymentCodeStr"] = "Cartão de crédito BrasilCard";
                break;
            case 113:
                $arrRet["paymentCodeStr"] = "Cartão de crédito FORTBRASIL";
                break;
            case 114:
                $arrRet["paymentCodeStr"] = "Cartão de crédito CARDBAN";
                break;
            case 115:
                $arrRet["paymentCodeStr"] = "Cartão de crédito VALECARD";
                break;
            case 116:
                $arrRet["paymentCodeStr"] = "Cartão de crédito Cabal";
                break;
            case 117:
                $arrRet["paymentCodeStr"] = "Cartão de crédito Mais!";
                break;
            case 118:
                $arrRet["paymentCodeStr"] = "Cartão de crédito Avista";
                break;
            case 119:
                $arrRet["paymentCodeStr"] = "Cartão de crédito GRANDCARD";
                break;
            case 120:
                $arrRet["paymentCodeStr"] = "Cartão de crédito Sorocred";
                break;
            case 201:
                $arrRet["paymentCodeStr"] = "Boleto Bradesco";
                break;
            case 202:
                $arrRet["paymentCodeStr"] = "Boleto Santander";
                break;
            case 301:
                $arrRet["paymentCodeStr"] = "Débito online Bradesco";
                break;
            case 302:
                $arrRet["paymentCodeStr"] = "Débito online Itaú";
                break;
            case 303:
                $arrRet["paymentCodeStr"] = "Débito online Unibanco";
                break;
            case 304:
                $arrRet["paymentCodeStr"] = "Débito online Banco do Brasil";
                break;
            case 305:
                $arrRet["paymentCodeStr"] = "Débito online Banco Real";
                break;
            case 306:
                $arrRet["paymentCodeStr"] = "Débito online Banrisul";
                break;
            case 307:
                $arrRet["paymentCodeStr"] = "Débito online HSBC";
                break;
            case 401:
                $arrRet["paymentCodeStr"] = "Saldo PagSeguro";
                break;
            case 501:
                $arrRet["paymentCodeStr"] = "Oi Paggo";
                break;
            case 701:
                $arrRet["paymentCodeStr"] = "Depósito em conta - Banco do Brasil";
                break;
            case 702:
                $arrRet["paymentCodeStr"] = "Depósito em conta - HSBC";
                break;
            default:
                $arrRet["paymentCodeStr"] = "**";
                break;
        }
    }

    return $arrRet;
}

function orderGetStatus($orderId)
{
    global $woocommerce;

    try {
       $order = new WC_Order( $orderId );
       return $order->status;
    } catch (Exception $e) {
        return false;
    }
}

function orderChangeStatus($orderId, $newStatus, $obs="")
{
    /*
    1) pending: Pagamento pendente
    2) processing: Processando
    3) on-hold: Aguardando
    4) completed: Concluído
    5) cancelled: Cancelado
    6) refunded: Reembolsado
    7) failed: Falhado
    */
    
    global $woocommerce;

    try {
       $order = new WC_Order( $orderId );
       $order->update_status( $newStatus, $obs);
       //$order->update_status( string $new_status, string $note = '' )

       return true;
    } catch (Exception $e) {
        return false;
    }
}

function sendMail($to, $subject, $body)
{
    $headers = array("Content-Type: text/html; charset=UTF-8", "From: Decoratum <contato@decoratum.com.br>");
    return wp_mail( $to, $subject, $body, $headers );
}