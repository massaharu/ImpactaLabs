<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
//Aqui é feita a conexão com o banco.
//Nome do seu computador
$servidor_conexao = 'SQL_TESTE';

//Nome do seu banco
$banco_conexao = 'DEV_TESTE';

//Usuário do banco
$usuario_conexao = 'user_cheque' ;

//Senha do banco
$senha_conexao = 'cheque123';

//conecta-se ao servidor
$msg="<p>Não foi possível conectar ao <b>servidor de banco de dados</b>. Verifique o erro acima e contacte o suporte</p>";

$GLOBALS['conexao'] = mssql_pconnect($servidor_conexao,$usuario_conexao,$senha_conexao) or die($msg);

//seleciona o banco
mssql_select_db($banco_conexao,$GLOBALS['conexao']) or die($msg);





//inicio o critério e recebo qualquer cadeia que se deseje procurar
$criterio = "";

if ($_GET["criterio"]!=""){

	$txt_criterio = $_GET["criterio"];
	
	$criterio = " where destitulo like '%" . $txt_criterio . "%'";

}


//Número máximo de links a serem exibidos
$numero_links = "5";

//Número de registros por página
$total_reg = "5";

$pagina = $_GET["pagina"];

if(!$pagina) {

	$pc = "1";

} else {

	$pc = $pagina;

}

echo '$pc'.$pc;


// intevalo revebe o valor da variavel numero_links
$intervalo = $numero_links;

// inicio recebe pc - 1 para montamos o sql

//$inicio = $pc-1;
$inicio = $pc*$total_reg;


//Aqui eu mostro o total de registros encontrados
$sql = mssql_query("SELECT * FROM tb_videos ".$criterio);

$tr = mssql_num_rows($sql);
//Aqui vai o código que substitui o famoso LIMIT do MySql. Adaptado para SQL Server.

$sql2=mssql_query("

select * from (

	select top $total_reg * from (
	
	select top $inicio * from tb_videos ".$criterio."
	
	order by dtcadastro asc
	
	) as newtbl order by dtcadastro desc

) as newtbl2 order by dtcadastro asc");



// recebemos o valor do total de paginas
$tp = ceil($tr/$total_reg);


// listamos os dados de acordo com os parametros da sql2

echo "<font size='1' face='Verdana'>";

echo "Página $pc de $tp<br> Total de registros encontrados: $tr<br>";

if($txt_criterio) {

	echo "Buscando por: <b>$txt_criterio</b><br>";

}

echo "</font>";

echo "<hr>";

while($dados=mssql_fetch_array($sql2)) {

	$id = $dados["idvideo"];
	
	$nome = $dados["destitulo"];
	
	echo "<span class='texto'>$id - $nome</span><br>";

}

echo "<hr>";

// A variavel aux recebe o valor do total de paginas/intervalo

$aux = $tp/$intervalo;

$aux1 = $pc/$intervalo;

$pi = $aux1 * $intervalo;

if ($pi == "0") {

	$pi = "1";

}

$pf = $pi + $intervalo -1;

$anterior = $pi-$intervalo;

if($pc<=$intervalo) {

	$anterior = 1;

}

$aux2 = $pi + 1;

if($pi>1) {

	$aux = $pi - 1;
	
	$aux2 = $pi + 1;
	
	// Começa a listar a paginação
	
	echo "<a href='paginacao-teste.php?pagina=$aux&criterio=$txt_criterio'><<<b> Anterior </b></a>&nbsp;";

}else{

	echo "<font size='1' face='Verdana'>";
	
	echo "<< Anterior &nbsp;&nbsp;&nbsp;";
	
	echo "</font>";

}

// Monta os links da parte central da paginação

for ($pi;$pi<$pf;$pi++){

	if($pi<=$tp) {
	
		if($pc==$pi) {
			
			echo "<strong><font size='1' face='Verdana'>";
			
			echo "<b>[" . $pi . "]</b>&nbsp;";
			
			echo "</font></strong>";
	
		} else {
		
			echo "<a href='paginacao-teste.php?pagina=" . $pi . "&criterio=" . $txt_criterio . "'>" . $pi . "</a>&nbsp;";
		
		}
	
	}

}

// faz verificação pra incluir ou não link na palavra próximo

if($pc != $tp){

	echo "<strong><font size='1' face='Verdana'>";
	
	echo "<a href='paginacao-teste.php?pagina=$aux2&criterio=$txt_criterio'><b>&nbsp;&nbsp;&nbsp; Próximo</b> >></a>";
	
	echo "</font></strong>";

}else{

	echo "<font size='1' face='Verdana'>";
	
	echo "&nbsp;&nbsp;&nbsp; Próximo >>";
	
	echo "</font>";

}

?>


<html>

<head>