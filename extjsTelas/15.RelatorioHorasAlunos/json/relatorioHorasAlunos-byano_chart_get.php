<?php
# @AUTOR = Massaharu #
$GLOBALS['JSON'] = TRUE;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$ano = post("ano");

//$ano = 2011;

$data = Sql::arrays("SATURN", "Relatorios", "sp_tempo_alunos_by_ano_list_chart '$ano'");


function fn_castIntToFloat($num){
	return $num/60/60;
}

function fn_dataExtenso($data){
	$mes = substr($data,-2);
	$ano = substr($data,0,4);
	//echo $mes.' '.$data.' ';
	switch($mes){
		case 1: return 'Jan de '.$ano;break;
		case 2: return 'Fev de '.$ano;break;
		case 3: return 'Mar de '.$ano;break;
		case 4: return 'Abr de '.$ano;break;
		case 5: return 'Mai de '.$ano;break;
		case 6: return 'Jun de '.$ano;break;
		case 7: return 'Jul de '.$ano;break;
		case 8: return 'Ago de '.$ano;break;
		case 9: return 'Set de '.$ano;break;
		case 10: return 'Out de '.$ano;break;
		case 11: return 'Nov de '.$ano;break;
		case 12: return 'Dez de '.$ano;
	}
}

foreach($data as &$value ){
	$value['nrtempo'] = fn_castIntToFloat($value['nrtempo']);	
	$value['dtperiodo_data'] = fn_dataExtenso($value['dtperiodo_data']);
}

success(TRUE, array("myData"=>$data));
?>

