<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 1000);
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$excel = new SimpleXLSX('2014-2_PAI2/nota-pai1.xlsx');

?>
<table>
	<tbody>
<?
foreach($excel->rows() as $key=>$val){
	if(trim($val[0]) != "" && trim($val[1]) != "" && trim($val[2]) != ""){
		
		echo "<tr><td>INSERT INTO tb_notaspai_teste VALUES('".trim($val[0])."', '".utf8_decode(trim($val[1]))."', '".number_format(((is_numeric($val[2]))? $val[2] : '0.00'), 2)."')</td></tr>";
		
		Sql::arrays("SQL_TESTE", "DEV_TESTE", "INSERT INTO tb_notaspai_teste VALUES('".trim($val[0])."', '".utf8_decode(trim($val[1]))."', '".number_format(((is_numeric($val[2]))? $val[2] : '0.00'), 2)."')");
	}
}
?>
	</tbody>
</table>
<?
echo "SUCCESS";
?>