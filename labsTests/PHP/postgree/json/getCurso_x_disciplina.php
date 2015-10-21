<?php
//Conectando no banco de dados do IClass
require_once("../inc/conn.php");

$b = pg_query(conectaiclass("idigitalclass"),"select b.id as idcurso, b.nome as nomecurso, c.nome as nomedisciplina, c.id as iddisciplina from tblcurso_x_disciplina a inner join tblcurso b on a.fk_curso = b.id inner join tbldisciplina c on a.fk_disciplina = c.id");
$data = array();
while($a1 = pg_fetch_array($b)){
	array_push($data,array(
		"idcurso"=>$a1['idcurso'],
		"descurso"=>$a1['nomecurso'],
		"desdisciplina"=>$a1['nomedisciplina'],
		"status"=>verifica($a1['idcurso'],$a1['iddisciplina'])
	));
}

function verifica($idcurso,$iddisciplina){
	$query = pg_query(conectaiclass("idigitalclassbkp"),"select * from tblcurso_x_disciplina where fk_curso = ".$idcurso." and fk_disciplina = ".$iddisciplina);	
	if(pg_num_rows($query) == 0){
		return 'nao';
	} else {
		return 'sim';
	}
}

echo json_encode(array("myData"=>$data));
?>