<?php
# @AUTOR = Massaharu #
$GLOBALS['JSON'] = TRUE;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$ano = post("ano");

//$ano = 2012;

$data = Sql::arrays("SATURN", "Relatorios", "sp_tempo_alunos_by_ano_list '$ano'");

function fn_castIntToFloat($num){
	return number_format($num/60/60,2,",","");
}

foreach($data as &$value ){
	if($value['IDENT'] == 'Tempo'){
		$value['IDENT'] = $value['IDENT'].' (Hrs)'; 
		$value['MES1'] = fn_castIntToFloat($value['MES1']);
		$value['MES2'] = fn_castIntToFloat($value['MES2']);
		$value['MES3'] = fn_castIntToFloat($value['MES3']);
		$value['MES4'] = fn_castIntToFloat($value['MES4']);
		$value['MES5'] = fn_castIntToFloat($value['MES5']);
		$value['MES6'] = fn_castIntToFloat($value['MES6']);
		$value['MES7'] = fn_castIntToFloat($value['MES7']);
		$value['MES8'] = fn_castIntToFloat($value['MES8']);
		$value['MES9'] = fn_castIntToFloat($value['MES9']);
		$value['MES10'] = fn_castIntToFloat($value['MES10']);
		$value['MES11'] = fn_castIntToFloat($value['MES11']);
		$value['MES12'] = fn_castIntToFloat($value['MES12']);
	}
}

success(TRUE, array("myData"=>$data));
?>

