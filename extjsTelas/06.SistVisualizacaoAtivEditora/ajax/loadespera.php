<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$category = post('category');
$id = post('id');
$nodes = array();
$sql = new Sql();

switch($category){
	
	case 'novostreinamentos':
		$a = $sql->arrays('FOCUS','SIMPAC',"sp_comitenovostreinamentos_list_espera");
		$nodeCategory = 'novostreinamentos';
		foreach($a as $a1){
			array_push($nodes, array(
				"id"=>$nodeCategory.'-'.$a1['id'],
				"text"=>($a1['inrelatorio'] == 0)?'<span style="color:#999999">'.utf8_encode($a1['nmcurso']).'</span>':utf8_encode($a1['nmcurso']),
				"iconCls"=>($a1['inprioridade'] == 1)?'ico_flag_blue':'ico_flag_red',
				"leaf"=>true,
				"itemId"=>$a1['id'],
				"data"=>array(
					"id"=>$a1['id'],
					"nmcurso"=>$a1['nmcurso'],
					"inprioridade"=>$a1['inprioridade'],
					"indivisao"=>$a1['indivisao'],
					"desdivisao"=>utf8_encode($a1['desdivisao']),
					"dtprevisao"=>$a1['dtprevisao'],
					"dtcadastro"=>$a1['dtcadastro'],
					"nmusuario"=>$a1['nmusuario'],
					"inposicao"=>$a1['inposicao'],
					"instatus"=>$a1['instatus'],
					"desstatus"=>$a1['desstatus'],
					"dtfinalizado"=>$a1['dtfinalizado'],
					"inrelatorio"=>$a1['inrelatorio']
				)
			));
		}
	break;
}


echo json_encode($nodes);
?>