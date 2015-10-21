<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$id = post('iddepartamentopai');

function getArrayDeptos($id){
	return Sql::arrays('SATURN','Vendas',"sp_departamentobyiddepartamentopai_get $id");
}

function getChilds($parent){
	
	$childrens = array();
	
	foreach(getArrayDeptos($parent) as $r){
		
		$node = array(
			"text"=>$r['desdepartamento'],
			"iddepartamentopai"=>$r['iddepartamento']
		);
		
		if(count(getArrayDeptos($r['iddepartamento']))){
			$node['children'] = getChilds($r['iddepartamento']);
		}else{
			$node['leaf'] = true;
		}
		
		array_push($childrens, $node);
		
	}
	
	return $childrens;
	
}

echo json_encode(getChilds($id));

?>