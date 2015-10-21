<?php
# @AUTOR = Massaharu #
$GLOBALS['JSON'] = TRUE;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idcursoagendado = post('idcursoagendado');

$data = Sql::arrays("SATURN", "Simpac", "sp_cursoagendadovalorespagos_get $idcursoagendado");

foreach($data as &$a){
	switch ($a['idperiodo'])
	{
	case 1:
	  $qdte_horas = 8;
	  $a['qdte_dias'] = $a['QtCargaHoraria']/$qdte_horas;
	  break;
	case 2:
	  $qdte_horas = 4;
	  $a['qdte_dias'] = $a['QtCargaHoraria']/$qdte_horas;
	  break;
	case 3:
	  $qdte_horas = 8;
	 $a['qdte_dias'] = $a['QtCargaHoraria']/$qdte_horas;
	  break;
	case 4:
	  $qdte_horas = 8;
	  $a['qdte_dias'] = $a['QtCargaHoraria']/$qdte_horas;
	  break;
	case 5:
	  $qdte_horas = 8;
	  $a['qdte_dias'] = $a['QtCargaHoraria']/$qdte_horas;
	  break;
	case 6:
	  $qdte_horas = 4;
	  $a['qdte_dias'] = $a['QtCargaHoraria']/$qdte_horas;
	  break;
	case 7:
	  $qdte_horas = 4;
	  $a['qdte_dias'] = $a['QtCargaHoraria']/$qdte_horas;
	  break;
	}
}
	

success(TRUE, array("myData"=>$data));
?>