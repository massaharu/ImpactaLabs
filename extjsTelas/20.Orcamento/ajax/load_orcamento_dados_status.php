<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 

$idpedido = post('idpedido');
?>
<script type="text/javascript">
	
	var store = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/extjsTelas/20.Orcamento/json/orcamento_dados_status.php',
		root: 'myData',
		baseParams:{
			idpedido:<?=$idpedido?>
		},
		fields: [
		   {name: 'idpedido', type:'int'},
		   {name: 'cod_cli',  type:'int'},
		   {name: 'nome_cli'},
		   {name: 'desstatus'},
		   {name: 'dtcadastro',type:'date', dateFormat:'timestamp'},
		   {name: 'idstatus'}
		],
		autoLoad:true
	});
	
	
	var grid = new Ext.grid.GridPanel({
		id:'orcamento_gridstatusatual',
		title:'Status Atual',
        store: store,
		stripeRows: true,
        height:screen.height-pscreen(60,'h'),
		style:'margin:-15px 0px 0 0px;',
		border:false,
        width:'auto',
		viewConfig:{
			 forceFit:true
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: true,
		}),
		columns: [
			{hidden:true, dataIndex:'idpedido'},
			{hidden:true, dataIndex:'cod_cli'},
			new Ext.grid.TemplateColumn({
				header: "Account", 
				sortable: true, 
				dataIndex: 'nome_cli', 
				tpl:LinkPermissao.account,
			}),{
				header: "Status", 	
				sortable: true, 
				dataIndex: 'desstatus',
				renderer:function(v,metaData,a,i){
					var recStatusAtual = Ext.getCmp('orcamento_gridstatusatual').getStore().getAt(i);
					var idstatus = recStatusAtual.get('idstatus');
					
					if(idstatus == 6){
						metaData.attr="style='color:#090; font-weight:bold;'";
					}else if(idstatus == 7){
						metaData.attr="style='color:#C00; font-weight:bold;'";
					}else if(idstatus == 22){
						metaData.attr="style='color:#C00; font-weight:bold;'";
					}else if(idstatus == 23){
						metaData.attr="style='color:#C00; font-weight:bold;'";
					}else if(idstatus == 24){
						metaData.attr="style='color:#C00; font-weight:bold;'";
					}else if(idstatus == 23){
						metaData.attr="style='color:#C00; font-weight:bold;'";
					}
					return v;
				}
			},
			{xtype:'datecolumn', header: "Data do Status", sortable: true, dataIndex: 'dtcadastro'}
		]
       
    });
	
	grid.render("aba_orcamento_dados_status");
</script>
<div id="aba_orcamento_dados_status" style="padding: 15 0 0 0"></div>
