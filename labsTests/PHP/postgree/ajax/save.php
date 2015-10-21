<?php
# @AUTOR = bbarbosa #
require_once("../inc/conn.php");

$id = $_POST['id'];
$idcurso = $_POST['idcurso'];
$idperiodo = $_POST['idperiodo'];
$idprofessor = $_POST['idprofessor'];
$iddisciplina = $_POST['iddisciplina'];
$idturma = $_POST['idturma'];

pg_query(conectaiclass("idigitalclassbkp"),"INSERT INTO tblprogramadeaula(id,fk_curso,fk_periodo,fk_disciplina,fk_turma,fk_professor,ativo) VALUES($id,$idcurso,$idperiodo,$iddisciplina,$idturma,$idprofessor,true);");

echo '{success:"true"}';

?>