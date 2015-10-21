<?php 
	# @AUTOR = massaharu #
	$GLOBALS['JSON'] = true;
	require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

	$LandingPage = new LandingPage(post('idlandingpage'));
	
	$LandingPage->instatus = ($LandingPage->instatus)? 0 : 1;
	
	$retorno = $LandingPage->Save(true);
	
	echo json_encode(array(
		'success'=>true,
		'myData'=>new LandingPage($retorno["idlandingpage"])
	));
?>