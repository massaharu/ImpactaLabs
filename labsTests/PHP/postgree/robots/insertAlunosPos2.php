<?php
# @AUTOR = bbarbosa #
require_once("../inc/conn.php");
$a = pg_query(conectaiclass("idigitalclass_old"),"select a.id, c.nome from tblusuario a inner join tblusuario_x_disciplina  b on a.id = b.fk_usuario inner join tbldisciplina c on b.fk_disciplina = c.id");
$data = array();
while($a1 = pg_fetch_array($a)){
	array_push($data,array(
		"id"=>$a1['id'],
		"descurso"=>utf8_encode($a1['nome'])
	));
}
echo json_encode(array("myData"=>$data));
?>