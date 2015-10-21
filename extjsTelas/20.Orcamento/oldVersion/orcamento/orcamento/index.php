<?php
//////////////////////////////////////////////////////////////////////////////////////////////
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = false; $GLOBALS['ext_theme'] = true; 
//////////////////////////////////////////////////////////////////////////////////////////////
require($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 
//////////////////////////////////////////////////////////////////////////////////////////////
$idcontato = get('idcontato');
//////////////////////////////////////////////////////////////////////////////////////////////
?>
<script>
Ext.onReady(function(){
	
	Ext.QuickTips.init();
	
	<?php 
	if($idcontato == '')
	{
	?>
		var store = new Ext.data.JsonStore({
			url: '/simpacweb/json/store_orcamento_contato.php?code=true',
			root: 'myData',
			fields: [
				{name:'idcontato',type:'int'},
				{name:'descontato'},
				{name:'cdemail'}
			]
		});
		
		store.load();
		
		var grid = new Ext.grid.GridPanel({
			store: store,
			columns: [
				{id:'grid_idcontato', header: "C\u00f3digo", width: 100, sortable: true, dataIndex: 'idcontato'},
				{header: "Nome", width: 100, sortable: true, dataIndex: 'descontato'},
				{header: "E-mail", width: 100, sortable: true, dataIndex: 'cdemail'}
			],
			sm: new Ext.grid.RowSelectionModel({singleSelect:true}),
			width:'auto',
			frame:true,
			autoExpandColumn:'descontato'
		});
		
		var win_contato = new Ext.Window({
			 id: "win_contato", 
			 width: 600, 
			 height: 400, 
			 frame: true, 
			 border: false, 
			 modal: true, 
			 resizable: false, 
			 title: "Buscar Contato", 
			 draggable: true,
			 items:[{
				xtype:'form',
				border:false,
				bodyStyle:'padding:10px;',
				items:[{
						xtype:'numberfield',
						name:'idcontato',
						fieldLabel:'C\u00f3digo',
						allowDecimals:false,
						allowNegative:false,
						width:200
					},{
						xtype:'numberfield',
						name:'nrcpf',
						fieldLabel:'CPF',
						allowDecimals:false,
						allowNegative:false,
						width:200
					},{
						xtype:'textfield',
						name:'descontato',
						fieldLabel:'Nome',
						width:450
					},{
						xtype:'textfield',
						name:'cdemail',
						fieldLabel:'E-mail',
						width:450,
						vtype:'email'
					}],
				buttons:[{
					text:'Pesquisar',
					handler:function(){
							
					}	
			 	}]
				},grid],
				
		});
		
		win_contato.show();
		
	<?php	
	}
	?>
	
	new Ext.Viewport({
    layout: 'border',
    items: [{
		region: 'north',
        height:100,
        border: false,
		style:'padding-top:25px;',
		contentEl:'title_topo'
	},{
        region: 'west',
        title: 'Navigation',
        width: 250,
		style:'padding-bottom:25px;',
        autoScroll: true,
        split: true,
		collapseMode:'mini',
		collapsible: true,
		collapsed:true,
		frame:true,
		border: false
    }, {
        region: 'center',
		border: false,
		style:'padding-bottom:25px;'
    }]
});

});
</script>
<div id="title_topo">
<?php topopagina('orcamento.png','Orçamento');?>
</div>