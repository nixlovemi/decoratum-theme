<?php
function objectIntoArray($object){
	return (array) $object;
}

function getThumbByID($thumb_ID, $size="thumbnail"){
	// Accepts any valid image size, or an array of width and height
	// values in pixels (in that order).
	$ret = wp_get_attachment_image_src( $thumb_ID, $size );
	return $ret[0];
}

function getQtItensCarrinho(){
	// return sizeof(jigoshop_cart::$cart_contents);
}

function getIDFromCart($ID_prod){
	/*foreach (jigoshop_cart::$cart_contents as $cart_item_key => $cart_item) {
		$_arr_product = (array) $cart_item["data"];
		if($_arr_product["ID"] == $ID_prod){
			return $cart_item_key;
		}
	}
	
	return false;*/
}

/**
* tipos de frete: 1, 2, 3 e 4 (incrementa R$3,00 a cd tipo)
*/
function getFreteIDProd($tp_frete=1){
	switch($tp_frete){
		case 1:
			return 40;
			break;
		case 2:
			return 44;
			break;
		case 3:
			return 45;
			break;
		case 4:
			return 46;
			break;
		default:
			return ;
			break;
	}
}

function changeQtdItemCart($ID_prod, $qtde=1){
	/*
	$key_cart_prod = getIDFromCart($ID_prod);
	
	if($key_cart_prod != ""){
		jigoshop_cart::set_quantity($key_cart_prod, $qtde);
		return true;
	}
	else{
		return false;
	}
	*/
}

function removeCartItem($ID_prod){
	// changeQtdItemCart($ID_prod, 0);
}

function limparCarrinho(){
	/*jigoshop_cart::empty_cart();
	return true;*/
}

function getArrProdutos($ID = ''){
	/*global $wpdb;
	do_action('jigoshop_before_shop_loop');
	ob_start();*/
	
	/*
	$querystr = "
			SELECT $wpdb->posts.* 
			FROM $wpdb->posts, $wpdb->postmeta
			WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
			--AND $wpdb->postmeta.meta_key = 'visibility' 
			--AND $wpdb->postmeta.meta_value = 'visible' 
			AND $wpdb->posts.post_status = 'publish' 
			AND $wpdb->posts.post_type = 'product'
			--AND $wpdb->posts.post_date < NOW()
			--ORDER BY $wpdb->posts.post_date DESC
	";
	*/
	
	/*
	$and_ID = (is_numeric($ID)) ? " AND $wpdb->posts.ID = $ID ": "";
	
	$querystr = "
			SELECT $wpdb->posts.* 
			FROM $wpdb->posts, $wpdb->postmeta
			WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
			AND $wpdb->postmeta.meta_key = 'visibility' 
			AND $wpdb->postmeta.meta_value = 'visible' 
			AND $wpdb->posts.post_status = 'publish' 
			AND $wpdb->posts.post_type = 'product'
			$and_ID
	";
 	$pageposts = $wpdb->get_results($querystr, OBJECT);
	ob_start();
	$arr_resp_produtos = array();
	
	if($pageposts){
		global $post;
		do_action('jigoshop_before_shop_loop_item');
		
		foreach ($pageposts as $post):
			setup_postdata($post);
			
			$_product = &new jigoshop_product( $post->ID );
			$arr__product = objectIntoArray($_product);
			
			$v_ID = $arr__product["ID"];
			$v_nome = get_the_title();
			$v_descricao = (has_excerpt()) ? get_the_excerpt(): "";
			$v_url = get_the_permalink();
			$v_add_cart_url = $_product->add_to_cart_url();
			$v_existe = $arr__product["exists"];
			$v_sku = $arr__product["sku"];
			$v_thumb_ID = $arr__product["meta"]["_thumbnail_id"][0];
			$v_thumb_url = getThumbByID($v_thumb_ID, array(450, 450));
			$v_preco = $arr__product["meta"]["regular_price"][0];
			$v_preco_promo = $arr__product["meta"]["sale_price"][0];
			$v_visibilidade = $arr__product["meta"]["visibility"][0];
			$v_em_estoque = $arr__product["meta"]["stock_status"][0];
			
			$arr_Produto = array(
				'ID'					=> $v_ID,
				'nome'				=> $v_nome,
				'descricao'		=> $v_descricao,
				'url'					=> $v_url,
				'add_cart_url'=> $v_add_cart_url,
				'existe'			=> $v_existe,
				'sku'					=> $v_sku,
				'thumb_ID'		=> $v_thumb_ID,
				'thumb_URL'		=> $v_thumb_url,
				'preco'				=> (float) $v_preco,
				'preco_promo'	=> (float) $v_preco_promo,
				'visibilidade'=> $v_visibilidade,
				'em_estoque'	=> $v_em_estoque,
			);
			array_push($arr_resp_produtos, $arr_Produto);
		endforeach;
	}
	*/
	
	// if (have_posts()) : while (have_posts()) : the_post();
		/*
		object(jigoshop_product)#3759 (32) {
			["id"]=> int(26)
			["ID"]=> int(26)
			["exists"]=> bool(true)
			["product_type"]=> string(6) "simple"
			["sku"]=> int(26)
			["brand"]=> NULL
			["gtin"]=> NULL
			["mpn"]=> NULL
			["data"]=> NULL
			["post"]=> NULL
			["meta"]=> array(20) {
				["_edit_last"]=> array(1) {
					[0]=> string(1) "1"
				}
				["_edit_lock"]=> array(1) {
					[0]=> string(12) "1454596369:1"
				}
				["_thumbnail_id"]=> array(1) {
					[0]=> string(2) "27"
				}
				["regular_price"]=> array(1) {
					[0]=> string(3) "4.5"
				}
				["sale_price"]=> array(1) {
					[0]=> string(0) ""
				}
				["weight"]=> array(1) {
					[0]=> string(1) "0"
				}
				["length"]=> array(1) {
					[0]=> string(1) "0"
				}
				["width"]=> array(1) {
					[0]=> string(1) "0"
				}
				["height"]=> array(1) {
					[0]=> string(1) "0"
				}
				["tax_status"]=> array(1) {
					[0]=> string(7) "taxable"
				}
				["tax_classes"]=> array(1) {
					[0]=> string(18) "a:1:{i:0;s:1:"*";}"
				}
				["visibility"]=> array(1) {
					[0]=> string(7) "visible"
				}
				["featured"]=> array(1) {
					[0]=> string(0) ""
				}
				["customizable"]=> array(1) {
					[0]=> string(2) "no"
				}
				["customized_length"]=> array(1) {
					[0]=> string(0) ""
				}
				["product_attributes"]=> array(1) {
					[0]=> string(0) ""
				}
				["manage_stock"]=> array(1) {
					[0]=> string(0) ""
				}
				["stock_status"]=> array(1) {
					[0]=> string(7) "instock"
				}
				["sale_price_dates_from"]=> array(1) {
					[0]=> string(0) ""
				}
				["sale_price_dates_to"]=> array(1) {
					[0]=> string(0) ""
				}
			}
			["visibility"]=> string(7) "visible"
			["stock"]=> NULL
			["children"]=> array(0) { }
			["regular_price":protected]=> string(3) "4.5"
			["sale_price":protected]=> string(0) ""
			["sale_price_dates_from":protected]=> string(0) ""
			["sale_price_dates_to":protected]=> string(0) ""
			["stock_sold":protected]=> NULL
			["jigoshop_options":protected]=> NULL
			["weight":"jigoshop_product":private]=> string(1) "0"
			["length":"jigoshop_product":private]=> string(1) "0"
			["width":"jigoshop_product":private]=> string(1) "0"
			["height":"jigoshop_product":private]=> string(1) "0"
			["tax_status":"jigoshop_product":private]=> string(7) "taxable"
			["tax_class":"jigoshop_product":private]=> NULL
			["featured":"jigoshop_product":private]=> string(0) ""
			["manage_stock":"jigoshop_product":private]=> string(0) ""
			["stock_status":"jigoshop_product":private]=> string(7) "instock"
			["backorders":"jigoshop_product":private]=> NULL
			["quantity_sold":"jigoshop_product":private]=> NULL
			["attributes":"jigoshop_product":private]=> array(0) { }
		} 
		*/
	// endwhile; endif;
	return $arr_resp_produtos;
}
// ===============
?>