<?php require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
//////////////////////////////////////////////////////////////////////////////////////////////
$idpedido = post('idpedido');
if($idpedido == ''){$idpedido = 0;}
//////////////////////////////////////////////////////////////////////////////////////////////
$lista = Sql::arrays('FOCUS','Simpac','sp_OrcamentoDataTreins '.($idpedido-15000));

//////////////////////////////////////////////////////////////////////////////////////////////
foreach($lista as $r){
/*while($r = ors($lista))
{*/

	$nro2++;
	
	if($nro2 == 1)
	{
		$my_data .= "[".$nro2.",'".linkpermissao('modulos/cursosagendados/treinamento_dados.php', 'idcursoagendado='.$r['IdCursoAgendado'], utf8_decode($r['descurso']), '', '', 'turma.png')."','".($r['Dtinicio'] == "Em Aberto" ? $r['Dtinicio'] : date("d/m/Y H:i:s", timestamp($r['Dtinicio'])))."','".($r['DtTermino'] == "Em Aberto" ? $r['DtTermino'] : date("d/m/Y H:i:s", timestamp($r['DtTermino'])))."','".$r['DesPeriodo']."']";
	}
	else
	{
		$my_data .= ",[".$nro2.",'".linkpermissao('modulos/cursosagendados/treinamento_dados.php', 'idcursoagendado='.$r['IdCursoAgendado'], utf8_decode($r['descurso']), '', '', 'turma.png')."','".($r['Dtinicio'] == "Em Aberto" ? $r['Dtinicio'] : date("d/m/Y H:i:s", timestamp($r['Dtinicio'])))."','".($r['DtTermino'] == "Em Aberto" ? $r['DtTermino'] : date("d/m/Y H:i:s", timestamp($r['DtTermino'])))."','".$r['DesPeriodo']."']";
	}
	
}
//////////////////////////////////////////////////////////////////////////////////////////////
?>
<script>
//////////////////////////////////////////////////////////////////////////////////////////////
var myData = [
	<?php echo $my_data;?>
];

// create the data store
var store = new Ext.data.SimpleStore({
	fields: [
	   {name: 'a'},
	   {name: 'a1'},
	   {name: 'a2'},
	   {name: 'b'},
	   {name: 'c'},
	   {name: 'd'}
	]
});
store.loadData(myData);

// create the Grid
var grid = new Ext.grid.GridPanel({
	store: store,
	title:'Op&ccedil;&otilde;es de Data',
	columns: [
		{header: "", 				width: 20, sortable: false, dataIndex: 'a'},
		{header: "Treinamento", 	width: 200, sortable: false, dataIndex: 'a1',id:'a'},
		{header: "Inicio", 			width: 140, sortable: false, dataIndex: 'a2'},
		{header: "T&eacute;rmino", 	width: 140, sortable: false, dataIndex: 'b'},
		{header: "Per&iacute;odo", 	width: 120, sortable: false, dataIndex: 'c'}
	],
	stripeRows: true,
	autoExpandColumn: 'a',
	height:pscreen(30,'h'),
	style:'margin:-15px 0 0 0;',
	border:false,
	width:'auto'
});
//////////////////////////////////////////////////////////////////////////////////////////////
</script>
<?php 
//////////////////////////////////////////////////////////////////////////////////////////////
unset($lista); 
//////////////////////////////////////////////////////////////////////////////////////////////
$lista2 = Sql::arrays('CALIBRA','Orcamento','sp_OrcamentoOpcaoDataEscolhida '.$idpedido);
//////////////////////////////////////////////////////////////////////////////////////////////
foreach($lista2 as $r2){
/*while($r2 = ors($lista2))
{*/

	$nro3++;
	
	if($nro3 == 1)
	{
		$my_data2 .= "[".$nro3.",'".linkpermissao('modulos/cursosagendados/treinamento_dados.php', 'idcursoagendado='.$r2['IdCursoAgendado'],  utf8_decode($r2['descurso']), '', '', 'turma.png')."','".($r2['Dtinicio'] == "" ? 'Em Aberto' : date("d/m/Y H:i:s", timestamp($r2['Dtinicio'])))."','".($r2['DtTermino'] == "" ? 'Em Aberto' : date("d/m/Y H:i:s", timestamp($r2['DtTermino'])))."','".$r2['DesPeriodo']."']";
	}
	else
	{
		$my_data2 .= ",[".$nro3.",'".linkpermissao('modulos/cursosagendados/treinamento_dados.php', 'idcursoagendado='.$r2['IdCursoAgendado'],  utf8_decode($r2['descurso']), '', '', 'turma.png')."','".($r2['Dtinicio'] == "" ? 'Em Aberto' : date("d/m/Y H:i:s", timestamp($r2['Dtinicio'])))."','".($r2['DtTermino'] == "" ? 'Em Aberto' : date("d/m/Y H:i:s", timestamp($r2['DtTermino'])))."','".$r2['DesPeriodo']."']";
	}
	
}
//////////////////////////////////////////////////////////////////////////////////////////////
?>
<script>
//////////////////////////////////////////////////////////////////////////////////////////////
var myData2 = [
	<?php echo $my_data2;?>
];

// create the data store
var store2 = new Ext.data.SimpleStore({
	fields: [
	   {name: '2a'},
	   {name: '2a1'},
	   {name: '2a2'},
	   {name: '2b'},
	   {name: '2c'},
	   {name: '2d'}
	]
});
store2.loadData(myData2);

// create the Grid
var grid2 = new Ext.grid.GridPanel({
	store: store2,
	title:'Datas Escolhidas',
	columns: [
		{header: "", 				width: 20, sortable: false, dataIndex: '2a'},
		{header: "Treinamento", 	width: 200, sortable: false, dataIndex: '2a1',id:'2a'},
		{header: "Inicio", 			width: 140, sortable: false, dataIndex: '2a2'},
		{header: "T&eacute;rmino", 	width: 140, sortable: false, dataIndex: '2b'},
		{header: "Per&iacute;odo", 	width: 120, sortable: false, dataIndex: '2c'}
	],
	stripeRows: true,
	autoExpandColumn: '2a',
	height:pscreen(20,'h'),
	border:false,
	width:'auto'
});
//////////////////////////////////////////////////////////////////////////////////////////////
grid.render('aba_opcoes_de_data');
grid2.render('aba_opcoes_de_data2');
//////////////////////////////////////////////////////////////////////////////////////////////
</script>
<div id="aba_opcoes_de_data" style="padding: 15 0 0 0"></div>
<div id="aba_opcoes_de_data2" style="padding: 15 0 0 0"></div>