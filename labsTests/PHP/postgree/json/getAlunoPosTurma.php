<?php
# @AUTOR = bbarbosa #
require_once("../inc/conn.php");
$a = pg_query(conectaiclass("idigitalclass_old"),"select a.id, c.nome, a.nome as desnome from tblusuario a inner join tblusuario_x_turma b on a.id = b.fk_usuario inner join tblturma c on b.fk_turma = c.id");
$data = array();
$n = 1;
while($a1 = pg_fetch_array($a)){
	array_push($data,array(
		"n"=>$n,
		"id"=>$a1['id'],
		"descurso"=>$a1['nome'],
		"desnome"=>$a1['desnome']
	));
	$n++;
}
echo json_encode(array("myData"=>$data));
?>