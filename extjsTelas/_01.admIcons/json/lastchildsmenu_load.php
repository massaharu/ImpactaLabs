<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$Menu = new Menu();

$arr_lastMenuChilds = Menu::getLastChilds();

$arr_menu = array();

foreach($arr_lastMenuChilds as $menu){
	
	$icon = str_replace("ico_", "", $menu["iconCls"]).".png";
	$desc = (trim($menu["text"]))? trim($menu["text"])." <img src='/simpacweb/images/ico/16/".$icon."'>" : "<img src='/simpacweb/images/ico/16/".$icon."'>"; 
	$dbclick = str_replace("function(){", "", str_replace("}", "", $menu["handler"]));
	$dbclick = str_replace('$.getScript("/simpacweb/modulos/window/', 'openWindowDefault("', $dbclick);
	
	array_push($arr_menu, array(
		"idmenu" => $menu["idmenu"],
		"text" => $menu["text"],
		"parent" => $menu["parent"],
		"handler" => $dbclick,
		"nrordem" => $menu["nrordem"],
		"iconCls" => $menu["iconCls"],
		"desc" => $desc
	));
}


echo json_encode(array(
	"myData"=>$arr_menu,
	"success"=>true
));
?>