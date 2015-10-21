<?php
//Conectando no banco de dados do IClass
require_once("../inc/conn.php");

$b = pg_query(conectaiclass("idigitalclass"),"select a.id, a.fk_curso as idcurso, fk_periodo as idperiodo, b.nome as nomedisciplina, c.nome as nometurma, a.fk_professor as idprofessor from tblprogramadeaula a inner join tbldisciplina b on a.fk_disciplina = b.id inner join tblturma c on a.fk_turma = c.id");
$data = array();
while($a1 = pg_fetch_array($b)){
	array_push($data,array(
		"id"=>$a1['id'],
		"idcurso"=>$a1['idcurso'],
		"idperiodo"=>$a1['idperiodo'],
		"desdisplina"=>$a1['nomedisciplina'],
		"desturma"=>$a1['nometurma'],
		"idprofessor"=>$a1['idprofessor'],
		"status"=>verifica($a1['id'])
	));
}

function verifica($id){
	$query = pg_query(conectaiclass("idigitalclassbkp"),"select * from tblprogramadeaula where id = ".$id);
	if(pg_num_rows($query) == 0){
		return 'nao';
	} else {
		return 'sim';
	}
}

echo json_encode(array("myData"=>$data));
?>