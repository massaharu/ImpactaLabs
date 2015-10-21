<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$datainicio = post('datainicio');
$datafim = post('datafim');

try{ 
	$data = array();

	$a = Sql::arrays('FOCUS','SIMPAC',"sp_andamento_list");
	
	foreach($a as $a1){
		
		array_push($data, 
					array(
						  "id"=>$a1['id'],
						  "nmcurso"=>trim($a1['nmcurso']),
						  "inprioridade"=>$a1['inprioridade'],
						  "indivisao"=>$a1['indivisao'],
						  "desdivisao"=>trim($a1['desdivisao']),
						  "dtprevisao"=>($a1['dtprevisao']) ? date("d/m/Y", $a1['dtprevisao']) : '',
						  "dtcadastro"=>($a1['dtcadastro']) ? date("d/m/Y", $a1['dtcadastro']) : '',
						  "nmusuario"=>$a1['nmusuario'],
						  "inposicao"=>$a1['inposicao'],
						  "instatus"=>$a1['instatus'],
						  "desstatus"=>$a1['desstatus'],
						  "dtfinalizado"=>($a1['dtfinalizado']) ? date("d/m/Y", $a1['dtfinalizado']) : '',
						  "inrelatorio"=>$a1['inrelatorio'],
						  "desdescricao"=>trim($a1['desdescricao'])
						  )
				   );
		
	}
	
	echo '{myData:'.json_encode($data).'}';
	
	unset($a);
} catch(Exception $e) {
	echo($e);
}
?>