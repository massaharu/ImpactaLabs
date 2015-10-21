<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

//$dataCargo = Cargo::createStore();



if($dataCargo){
	echo success;
}

$dataUsuario = Usuario::createStore();
pre($dataUsuario);
if($dataUsuario){
	echo success;
}
?>