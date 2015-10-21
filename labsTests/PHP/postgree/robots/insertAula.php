<?php
# @AUTOR = bbarbosa #
require_once("../inc/conn.php");

$a = pg_query(conectaiclass("idigitalclass"),"select * from tblaula");
while($a1 = pg_fetch_array($a)){
	pg_query(conectaiclass("idigitalclassbkp"),"INSERT INTO tblaula(id,fk_professor,fk_sala,fk_programadeaula,inicio,termino,nomearquivo) VALUES(".$a1['id'].",".$a1['fk_professor'].",".$a1['fk_sala'].",".$a1['fk_programadeaula'].",'".$a1['inicio']."',".((count($a1['termino']) == 0)?"NULL":'\''.$a1['termino'].'\'').",'".$a1['nomearquivo']."')");
	flush();
}
?>