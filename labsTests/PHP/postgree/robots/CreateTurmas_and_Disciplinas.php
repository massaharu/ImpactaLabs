<?
require_once("../inc/conn.php");
//Limpando bases do iClass

//pg_query(conectaiclass('idigitalclassbkp'),"DELETE FROM tblturma");
//pg_query(conectaiclass('idigitalclassbkp'),"DELETE FROM tbldisciplina");
/////////////////////////////////////////////////////////////////////////////
$sql = "select * from tb_disciplinasSophia";
$stmt = sqlsrv_query(conectaSaturn(), $sql);
while($a1 = sqlsrv_fetch_array($stmt)){
	//Inserindo disciplinas no banco do Iclass
	pg_query($a,"INSERT INTO tbldisciplina(id, nome, descricao, ativo) VALUES('".$a1['idsophia']."','".utf8_encode($a1['desdisciplina'])."','Impacta',true);");
}
/////////////////////////////////////////////////////////////////////////////
$sql = "select * from tb_turmasSophia";
$stmt = sqlsrv_query(conectaSaturn(), $sql);
while($a1 = sqlsrv_fetch_array($stmt)){
	//Inserindo disciplinas no banco do Iclass
	pg_query($a,"INSERT INTO tblturma(id, nome, descricao, ativo) VALUES('".$a1['idturmsophia']."','".utf8_encode($a1['desturma'])."','Impacta',true);");
}
/////////////////////////////////////////////////////////////////////////////

?>