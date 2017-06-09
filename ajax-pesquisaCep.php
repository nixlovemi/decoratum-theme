<?php
function func_cep($cep){

	$cep = str_replace(".", "", $cep);
	$cep = str_replace("-", "", $cep);
	$resultado = @file_get_contents('http://cep.republicavirtual.com.br/web_cep.php?cep=' . urlencode($cep) . '&formato=query_string');
	if (! $resultado) {
		$resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";
	}
	parse_str($resultado, $retorno);
	return $retorno;

}

$ret_cep = func_cep($_POST['cep']);
echo $ret_cep;
?>