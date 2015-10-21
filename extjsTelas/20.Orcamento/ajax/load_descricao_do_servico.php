<?php require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); ?>
<?php 
//////////////////////////////////////////////////////////////////////////////////////////////
$idpedido = post('idpedido');
if($idpedido == ''){$idpedido = 0;}
//////////////////////////////////////////////////////////////////////////////////////////////
if(replicacao('FOCUS','Simpac','SPIDER','Simpac','tb_pedidos') == 1)
{
	$a = "'SPIDER','Simpac'";
}
else
{
	$a = "'FOCUS','Simpac'";
}
//////////////////////////////////////////////////////////////////////////////////////////////
$lista = Sql::arrays('SATURN','SIMPAC','sp_OrcamentoDescricaoServico '.($idpedido-15000));
//////////////////////////////////////////////////////////////////////////////////////////////
foreach($lista as $r)
{

	$nro2++;
	
	if($nro2 == 1)
	{
		$my_data .= "['".linkpermissao('modulos/curso/curso_dados.php', 'idcurso='.$r['idcurso'], utf8_decode($r['Curso']), '', '', 'curso.png')."','".$r['Periodo']."','".$r['Desconto']."%','".formatcurrency($r['Unitario'])."','".$r['Qtde']."']";
	}
	else
	{
		$my_data .= ",['".linkpermissao('modulos/curso/curso_dados.php', 'idcurso='.$r['idcurso'], utf8_decode($r['Curso']), '', '', 'curso.png')."','".$r['Periodo']."','".$r['Desconto']."%','".formatcurrency($r['Unitario'])."','".$r['Qtde']."']";
	}
	
}
//////////////////////////////////////////////////////////////////////////////////////////////

?>
<script>
	var myData2 = [
        <?php echo $my_data;?>
    ];

    // create the data store
    var store3 = new Ext.data.SimpleStore({
        fields: [
		   {name: 'a'},
		   {name: 'a1'},
		   {name: 'a2'},
           {name: 'b'},
           {name: 'c'}
        ]
    });
    store3.loadData(myData2);
	
    // create the Grid
    var grid = new Ext.grid.GridPanel({
        store: store3,
        columns: [
			{header: "Treinamento", width: 200, sortable: false, dataIndex: 'a',id:'a'},
			{header: "Per&iacute;odo", 	width: 120, sortable: true, dataIndex: 'a1'},
			{header: "Desc. (%)", 	width: 120, sortable: true, dataIndex: 'a2'},
            {header: "Unit.", 		width: 100, sortable: true, dataIndex: 'b'},
            {header: "Qtd.", 		width: 120, sortable: true, dataIndex: 'c'}
        ],
        stripeRows: true,
        autoExpandColumn: 'a',
        height:screen.height-pscreen(60,'h'),
		style:'margin:-15px 0px 0 0px;',
		border:false,
        width:'auto'
    });
	
	grid.render("aba_descricao_do_servico");
</script>
<div id="aba_descricao_do_servico" style="padding: 15 0 0 0"></div>
<?php unset($lista);?>