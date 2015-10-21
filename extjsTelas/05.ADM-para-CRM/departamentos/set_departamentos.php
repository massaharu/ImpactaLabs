<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/atendimento/cadastros/inc/configuration.php");

  if(post('iddepartamentopai'))
  {
	  $objDept = new Departamento();
	  foreach($_POST as $key=>$val)
	  
	  {
		  $objDept->{$key} = post($key);
	  }
	  
	  echo json_encode(array('success'=>true,'iddepartamento'=>$objDept->save()));
	  
  }else{
  
	  $objDept = new Departamento(post('iddepartamento'));
	  $objDept->desdepartamento=post('desdepartamento');
	  
	  echo json_encode(array('success'=>true,'iddepartamento'=>$objDept->save()));
  }
?>
