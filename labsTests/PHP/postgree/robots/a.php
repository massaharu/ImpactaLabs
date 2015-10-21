<?php
# @AUTOR = bbarbosa #
require_once("../inc/conn.php");
$ra = $_GET['ra'];
$id = $_GET['id'];
///////////////////////////////////////////////////////////////////////////////////
try {
	$sql = "select codigo_alu,senha_alu,nome_alu,curso_alu,turma_alu,semestre,periodo_alu,situac_alu,email_alu,idturmsophia,desturma from cadalu a inner join tb_turmassophia b on a.turma_alu = b.desturma where curso_alu not in('Mecatrônica','Telecomunicações') and codigo_alu = ".$ra; 
	$conn = sqlsrv_connect("SPIDER", array("Database"=>"FIT", "UID"=>"user_cheque", "PWD"=>"cheque123"));
	$stmt = sqlsrv_query($conn, $sql); 
	while($a1 = sqlsrv_fetch_array($stmt)){
		/*pg_query(conectaiclass("idigitalclass"),"INSERT INTO tblusuario(id,nome,login,password,email,ativo,perfil) VALUES(".$id.",'".str_replace("'"," ",utf8_encode($a1['nome_alu']))."','".$a1['codigo_alu']."','".$a1['senha_alu']."','".$a1['email_alu']."',true,'Aluno')");
	pg_query(conectaiclass("idigitalclass"),"INSERT INTO tblusuario_x_turma(fk_usuario,fk_turma) VALUES(".$id.",".$a1['idturmsophia'].")");
	cadastradisciplina($a1['codigo_alu'],$id);*/
	}
	echo '{"success":"true"}';
} catch (Exception $e) {
	echo "Exceção pega: ",  $e->getMessage(), "\n";
}

function cadastradisciplina($ra,$id){
	$s0 = "select idsophia from tb_iclass a inner join tb_disciplinassophia b on a.desdisciplina = b.desdisciplina collate SQL_Latin1_General_CP1_CI_AS where nrRA = ".$ra." group by idsophia";
	$conn2 = sqlsrv_connect("SPIDER", array("Database"=>"FIT", "UID"=>"user_cheque", "PWD"=>"cheque123"));
 	$s1 = sqlsrv_query($conn2, $s0);
	while($s2 = sqlsrv_fetch_array($s1)){
		pg_query(conectaiclass("idigitalclass"),"INSERT INTO tblusuario_x_disciplina(fk_usuario,fk_disciplina) values(".$id.",".$s2['idsophia'].")");
	}
	unset($s0,$conn2,$s1,$s2);
}

?>