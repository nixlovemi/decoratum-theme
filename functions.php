<?php
// setup basico pra temas woo commerce
add_action('after_setup_theme', 'woocommerce_support');

function woocommerce_support()
{
    add_theme_support('woocommerce');
}

// ===================================

function get_custom_post_type_template($single_template) {
 global $post;

 if ($post->post_type == 'product') {
      $single_template = dirname( __FILE__ ) . '/template-single-prod.php';
 }
 return $single_template;
}
add_filter( 'single_template', 'get_custom_post_type_template' );

// classe de Produto =================
class DecoratumProduct{
    private $_id;
    private $_title;
    private $_description;
    private $_shortDescription;
    private $_price;
    private $_regularPrice;
    private $_imageId;
    private $_galleryIds;
    private $_wcProduct;

    private function getImageUrl($imageId, $size="shop_single"){
        // shop_single | shop_catalog | shop_thumbnail
        $arrRet = wp_get_attachment_image_src( $imageId, $size );
        return $arrRet[0];
    }
    private function getGalleryUrl($galleryIds, $size="shop_single"){
        $retArray = array();
        foreach($galleryIds as $imageId){
            $retArray[] = $this->getImageUrl($imageId, $size);
        }

        return $retArray;
    }

    public function getId(){
        return $this->_id;
    }
    public function getTitle(){
        return $this->_title;
    }
    public function getDescription(){
        return $this->_description;
    }
    public function getShortDescription(){
        return $this->_shortDescription;
    }
    public function getPrice(){
        return $this->_price;
    }
    public function getRegularPrice(){
        return $this->_regularPrice;
    }
    public function getImageId(){
        return $this->_imageId;
    }
    public function getImageThumbUrl(){
        return $this->getImageUrl( $this->_imageId, "shop_thumbnail" );
    }
    public function getImageCatalogUrl(){
        return $this->getImageUrl( $this->_imageId, "shop_catalog" );
    }
    public function getImageSingleUrl(){
        return $this->getImageUrl( $this->_imageId, "shop_single" );
    }
    public function getGalleryIds(){
        return $this->_galleryIds;
    }
    public function getGallerySingleUrl(){
        return $this->getGalleryUrl($this->_galleryIds, "shop_single");
    }
    public function getWcProduct(){
        return $this->_wcProduct;
    }
    public function getWcProductArray(){
        return (array) $this->_wcProduct;
    }
    
    public function setId($value){
        $this->_id = $value;
        return $this;
    }
    public function setTitle($value){
        $this->_title = $value;
        return $this;
    }
    public function setDescription($value){
        $this->_description = $value;
        return $this;
    }
    public function setShortDescription($value){
        $this->_shortDescription = $value;
        return $this;
    }
    public function setPrice($value){
        $this->_price = $value;
        return $this;
    }
    public function setRegularPrice($value){
        $this->_regularPrice = $value;
        return $this;
    }
    public function setImageId($value){
        $this->_imageId = $value;
        return $this;
    }
    public function setGalleryIds($value){
        $this->_galleryIds = $value;
        return $this;
    }
    public function setWcProduct($value){
        $this->_wcProduct = $value;
        return $this;
    }
}
// ===================================

function getAllProducts($category = "", $productId = "")
{
    $arrProducts = array();
    
    $args = array();
    $args["post_type"] = "product";
    $args["posts_per_page"] = -1;
    if($category != ""){
        $args["product_cat"] = $category;
    }
    if(is_numeric($productId) && $productId > 0){
        $args["ID"] = $productId;
    }
    $args["orderby"] = "title";

    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post(); global $product;

        $DecoratumProduct = new DecoratumProduct();
        $DecoratumProduct->setId( $product->get_id() );
        $DecoratumProduct->setTitle( $product->get_name() );
        $DecoratumProduct->setDescription( $product->get_description() );
        $DecoratumProduct->setShortDescription( $product->get_short_description() );
        $DecoratumProduct->setPrice( $product->get_price() );
        $DecoratumProduct->setRegularPrice( $product->get_regular_price() );
        $DecoratumProduct->setImageId( $product->get_image_id() );
        $DecoratumProduct->setGalleryIds( $product->get_gallery_image_ids() );
        $DecoratumProduct->setWcProduct($product);

        $arrProducts[] = $DecoratumProduct;

    endwhile;
    wp_reset_query();

    return $arrProducts;
}
