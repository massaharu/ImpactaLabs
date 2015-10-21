<?php
require_once("../inc/conn.php");

# @AUTOR = bbarbosa #
$id = $_POST['id'];
$iddisciplina = $_POST['iddisciplina'];

pg_query(conectaiclass("idigitalclass"),"INSERT INTO tblusuario_x_disciplina (fk_usuario,fk_disciplina) VALUES(".$id.",".$iddisciplina.")");

echo '{success:"true"}';

?>