<?php
# @AUTOR = bbarbosa #
require_once("../inc/conn.php");
$a = pg_query(conectaiclass("idigitalclass"),"select * from tbldisciplina order by id");
while($a1 = pg_fetch_array($a)){
	echo $a1['nome'].'<br>';
}
?>