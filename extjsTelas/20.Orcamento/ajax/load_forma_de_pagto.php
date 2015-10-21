<?php require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); ?>
<?php 
//////////////////////////////////////////////////////////////////////////////////////////////
$idpedido = post('idpedido');
if($idpedido == ''){$idpedido = 0;}
//////////////////////////////////////////////////////////////////////////////////////////////
$lista2 = Sql::arrays('SATURN', 'Orcamento', 'sp_OrcamentoFormaPagamento '.($idpedido-15000));
//////////////////////////////////////////////////////////////////////////////////////////////
foreach($lista2 as $r2)
{
	$my_data .= "['".$r2['nrparcela']."','".formatcurrency($r2['vlparcela'])."','".date("d/m/Y", $r2['dtvencimento'])."','".$r2['destipoformapagamento']."','".$r2['desObs']."'],";

	
	$valor_total += $r2['vlparcela'];
	
}
//////////////////////////////////////////////////////////////////////////////////////////////
$my_data .= "['<b>Total</b>','".formatcurrency($valor_total)."','','',''],";
//////////////////////////////////////////////////////////////////////////////////////////////
?>
<script>
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
           {name: 'c'}
        ]
    });
    store.loadData(myData);
	
    // create the Grid
    var grid2 = new Ext.grid.GridPanel({
        store: store,
        columns: [
			{header: "Parcela", 		width: 60, sortable: false, dataIndex: 'a'},
			{header: "Valor", 			width: 80, sortable: false, dataIndex: 'a1'},
			{header: "Vencimento", 		width: 120, sortable: false, dataIndex: 'a2'},
            {header: "Forma de Pagto.", width: 150, sortable: false, dataIndex: 'b'},
            {header: "Obs.", 			width: 100, sortable: false, dataIndex: 'c', id:'a'}
        ],
        stripeRows: true,
        autoExpandColumn: 'a',
        //height:screen.height-pscreen(50,'h'),
		autoHeight:true,
		style:'margin:-15px 0px 0 0px;',
		border:false,
        width:'auto'
    });
	
	grid2.render("aba_forma_de_pagto");
</script>
<div id="aba_forma_de_pagto" style="padding: 15 0 0 0"></div>
<?php unset($lista2);?>