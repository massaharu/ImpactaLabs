<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
//require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/atendimento/cadastros/inc/configuration.php");
/*
$despais = post('despais');
$desabreviacao2 = post('desabreviacao2');
$desabreviacao3 = post('desabreviacao3');

Sql::query('SATURN','VENDAS', "sp_pais_save 0, '$despais', '$desabreviacao2', '$desabreviacao3'");
*/

$novo_pais = new Pais();

foreach($_POST as $key=>$val){
	$novo_pais->{$key} = post($key);
}

$novo_pais->save();

echo success;

/*sp_pais_save – Procedure para salvar e atualizar – Passar como parâmetro idpais, despais, desabreviacao2, desabreviacao3.*/
?>