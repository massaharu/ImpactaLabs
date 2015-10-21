<?php
# @AUTOR = bbarbosa #
$conn = pg_connect("host=172.18.200.210 port=5432 dbname=idigitalclass user=impacta password=impacta");
$a = pg_query($conn,"select a.nome dessala, b.nome desstatus, a.status idstatus from tblsaladeaula a inner join tblsaladeaulastatus b on a.status = b.id order by a.nome");
$data = array();
while($a1 = pg_fetch_array($a)){
	array_push($data,array(
		"dessala"=>$a1['dessala'],
		"desstatus"=>$a1['desstatus'],
		"idstatus"=>$a1['idstatus']
	));
	$n++;
}
echo json_encode(array("myData"=>$data));
?>