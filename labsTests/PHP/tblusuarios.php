<?php
# @AUTOR = massaharu #
$GLOBALS['BOOTSTRAP'] = true; 
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/postgree/inc/conn.php");
?>
<style>
	th{
		padding: 2px 5px;
	}
</style>
<script type="text/javascript" src="../Plugins & API's/javascript/mousetrap/mousetrap.js"></script>
<script>
	$(function(){
		Mousetrap.bind('ctrl+shift+up', function(e, combo) {
			console.log(combo); // logs 'ctrl+shift+up'
			var linha = parseInt(prompt("Vá para a linha"));
			
			if(linha){
				$('html,body').animate({ scrollTop: parseInt($('#index-'+linha).offset().top)}, 0);
			}
		});
	})
</script>
<?
//$a = pg_query(conectaiclass("idigitalclass"),"SELECT * FROM tblusuario WHERE nome LIKE '%Dente%' LIMIT 10");
//pg_query(conectaiclass("idigitalclass"),"UPDATE tblusuario SET login = '1201550' WHERE id = 3278");
/*$string = "host=172.18.200.210 port=5432 dbname=idigitalclass user=impacta password=impacta";
$conn = pg_connect($string);*/

//$a = pg_query(conectaiclass("idigitalclass"),"SELECT * FROM tblusuario WHERE id = 3278");
$a = pg_query(conectaiclass("idigitalclass"),"SELECT * FROM tblusuario order by nome"); 

$data = array();
$index = 1;

//pre(pg_fetch_array($a));//Ver nomes da colunas da tabela

$table_usuario = 
'<table class="table table-bordered">
	<thead>
		<tr>
			<th>Nº</th>
			<th>Id</th>
			<th>Nome</th>
			<th>Login</th>
			<th>Password</th>
			<th>Email</th>
			<th>Ativo</th>
			<th>Perfil</th>
			<th>Coordenador</th>
			<th>fk_coordenador</th>
		</tr>
	</thead>
	<tbody>';
		

while($a1 = pg_fetch_array($a)){
	
	$table_usuario .= 
	'<tr>
		<td id="index-'.$index.'">'.$index.'</td>
		<td>'.$a1["id"].'</td>
		<td>'.$a1["nome"].'</td>
		<td>'.$a1["login"].'</td>
		<td>'.$a1["password"].'</td>
		<td>'.$a1["email"].'</td>
		<td>'.$a1["ativo"].'</td>
		<td>'.$a1["perfil"].'</td>
		<td>'.$a1["coordenador"].'</td>
		<td>'.$a1["fk_coordenador"].'</td>
	</tr>';
	$index++;
}

$table_usuario .=
	'</tbody>
</table>';

echo $table_usuario;

?>