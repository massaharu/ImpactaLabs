<?php
# @AUTOR = bbarbosa #
require_once("../inc/conn.php");
$a = pg_query(conectaiclass("idigitalclass"),"select * from tblusuario where perfil = 'Administrador'");
while($a1 = pg_fetch_array($a)){
	pg_query(conectaiclass("idigitalclassbkp"),"INSERT INTO tblusuario(id, nome, login, password, email, ativo, perfil) VALUES(".$a1['id'].",'".$a1['nome']."','".$a1['login']."','".$a1['password']."','".$a1['email']."',true,'".$a1['perfil']."')");
	flush();
}
?>