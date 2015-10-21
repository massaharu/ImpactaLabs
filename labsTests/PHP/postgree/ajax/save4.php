<?php
require_once("../inc/conn.php");

# @AUTOR = bbarbosa #
$id = $_POST['id'];
$idturma = $_POST['idturma'];

pg_query(conectaiclass("idigitalclass"),"INSERT INTO tblusuario_x_turma (fk_usuario,fk_turma) VALUES(".$id.",".$idturma.")");

echo '{success:"true"}';

?>