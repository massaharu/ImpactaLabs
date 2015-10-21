<?php
# @AUTOR = Massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idinstrutor = post('idinstrutor');
$dt1 = post('dt1');
$dt2 = post('dt2');

/*while($a1 = mssql_fetch_array("sp_liberaavaliacaofinal")){
	array_push($data,array(
		"a"=>1,
		"b"=>2
	));
}*/

//SQ::arrays
//primeiro servidor
// banco de dados

echo json_encode(array("myData"=>Sql::arrays('SATURN','INSTRUTORES',"sp_liberaavaliacaofinal $idinstrutor,'$dt1','$dt2'")));

?>