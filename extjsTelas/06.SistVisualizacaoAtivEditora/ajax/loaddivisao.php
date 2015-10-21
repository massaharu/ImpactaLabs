<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

try{ 
	$data = array();

	$a = Sql::arrays('FOCUS','SIMPAC',"sp_comitenovostreinamentoscarregadivisao_list");
	
	foreach($a as $a1){
		
		array_push($data, 
					array(
						  "iddivisao"=>$a1['id'],
						  "desdivisao"=>trim($a1['desdivisao'])
						  )
				   );
		
	}
	
	echo '{myData:'.json_encode($data).'}';
	
	unset($a);
} catch(Exception $e) {
	echo($e);
}
?>