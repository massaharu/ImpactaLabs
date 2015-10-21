<?php
require_once("../inc/conn.php");

# @AUTOR = bbarbosa #
$idcurso = $_POST['idcurso'];
$iddisciplina = $_POST['iddisciplina'];

pg_query(conectaiclass("idigitalclassbkp"),"INSERT INTO tblcurso_x_disciplina (fk_curso,fk_disciplina) VALUES(".$idcurso.",".$iddisciplina.")");

echo '{success:"true"}';

?>