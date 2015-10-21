<?php
# @AUTOR = bbarbosa #
require_once("../inc/conn.php");

$a = pg_query(conectaiclass("idigitalclass"),"select * from tblaulaaudio");
while($a1 = pg_fetch_array($a)){
	pg_query(conectaiclass("idigitalclassbkp"),"INSERT INTO tblaulaaudio(id,intensidade,datadecriacao,fk_aula) VALUES(".$a1['id'].",".$a1['intensidade'].",'".$a1['datadecriacao']."',".$a1['fk_aula'].")");
}
?>