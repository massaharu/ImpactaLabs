<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = false; $GLOBALS['ext_theme'] = true;
require($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 
topopagina('chat_time.png','Atendimentos por hora');
?>
<script type="text/javascript">
Ext.onReady(function() { 
					 
	var store_departamentos = new Ext.data.JsonStore({
	  url:'../../../../modulos/atendimento/chat-relatorios/ajax/departamento_list.php',
	  root:'myData',
	  fields:[{name:'desdepartamento', type:'string'},
			  {name:'iddepartamento', type:'int'}]
  	});
	
	var data = new Date();
	
//____________________________________________PANEL ATENDIMENTOS HORA (EAST)________________________________________________		
		var panelAtendimentos = new Ext.Panel({
			title:'Atendimentos Hora',
			id:'idpanelatendimentos',
			region:'east',
			iconCls:'ico_clock',
			/*split:false,*/
			width:'60%',
			margins:'4 4 4 0',
			collapsible: true,
			collapsed:true,
			height:500,
			border:true,
			split:true,
			layout:'fit',
			bbar:[{
				iconCls: 'ico_excel',
				tooltip: 'Exportar para Excel',
				handler: function(){
					exporter(Ext.getCmp("gridFila"));	
				}
			},'-',{
				iconCls: 'ico_printer',
				tooltip: 'Imprimir',
				handler: function(){
					printer(Ext.getCmp("gridFila"));	
				}
			}],
			items:[{
				xtype:'grid',
				border:false,
				id: 'gridFila',	
				autoScroll:true,
				height: Page.height-210,
				viewConfig:{
					forceFit:true
				},
				store: new Ext.data.JsonStore({
					autoLoad: false,
					url: '../../../../modulos/atendimento/chat-relatorios/ajax/json.atendimentoHora.php',
					root: 'myData',
					fields: [{name:'atendimentos', type: 'int'},
							 {name:'hora', type: 'int'}]
				}),
				colModel: new Ext.grid.ColumnModel({
					defaults: {
						width: 200,
						sortable: true
					},
					columns: [{
						header: 'Hora de Atendimento', 
						dataIndex: 'hora'
					},{
						header: 'Quantidade de Atendimentos', 
						dataIndex: 'atendimentos'
					}],
				}),
				sm: new Ext.grid.RowSelectionModel({
					singleSelect:true
				}),
				loadMask:true	
			}]
		});
//______________________________________PANEL FILTRO (CENTER)_________________________________________________		
	var panelFiltro = new Ext.Panel({
			title:'Filtro',
			iconCls:'ico_search',
			//baseCls:'x-plain',
			id: 'AgendaPanel',
			region:'center',
			width:'40%',
			margins:'4 0 4 4',
			padding:15,
			collapsible: true,
			split:true,
			border:true,
			autoScroll:true,
			bbar:[{}],
			items:[{
				xtype:'form',
				border:false,
				id: 'frmFiltro',
				height:400,
				//defaults:{padding:15,margins:'15'},
				//labelWidth: 50,
				items:[{								
					xtype:'fieldset',
					title:'',
					autoHeight:true,
					collapsed:false,
					padding:22,
					buttonAlign:'center',
					items:[{
						xtype: 'datefield',
						id: 'dataInicio',
						fieldLabel:'Início',
						width:180,
						//maxValue: DateAdd("d",-1,data),
						allowBlank:false,
						listeners: {
							select: function(dataInicio){
								 Ext.getCmp('dataTermino').setMinValue(dataInicio.getValue());
							}
						}
					},{
						xtype: 'datefield',
						id: 'dataTermino',
						fieldLabel:'Término',
						width:180,
						//maxValue: DateAdd("d",-1,data),
						allowBlank:false,
						listeners: {
							select: function(dataTermino){
								 Ext.getCmp('dataInicio').setMaxValue(dataTermino.getValue());
							}
						}
					},{
						xtype:'combo',
						id:'cmbdept',
						store:store_departamentos,
						width:180,
						typeAhead:true,
						triggerAction: 'all',
						lazyRender: true,
						//mode: 'local',
						fieldLabel: 'Departamentos',
						valueField: 'iddepartamento',
						displayField: 'desdepartamento',
						emptyText:'Departamentos...',
						name:'iddepartamento',	
						allowBlank:false
					}],		
					buttons: [{
						text: 'Filtrar',
						iconCls:'ico_search',
						width:200,
						height:35,
						handler: function(){
							if(Ext.getCmp("dataInicio").getValue() != 0 && Ext.getCmp("dataTermino").getValue() != 0 && Ext.getCmp('cmbdept').getValue() == 0){
								Ext.MessageBox.show({
									msg:'Por Favor, Selecione um Departamento',
									buttons: Ext.MessageBox.alert,
									icon:Ext.MessageBox.ERROR,
								});
							}
							if(Ext.getCmp("frmFiltro").getForm().isValid()){
								Ext.getCmp('idpanelatendimentos').expand();
								Ext.getCmp("gridFila").getStore().reload({
									params:{
										data1: Ext.getCmp("dataInicio").getValue(), 
										data2: Ext.getCmp("dataTermino").getValue(),
										iddepartamento:Ext.getCmp('cmbdept').getValue()
									}
								});
							}
						}
					}],
				}],
			}],
		});
//___________________________________MAIN PANEL_______________________________________________________________________________		
		new Ext.FullPanel({
			id:'AtendimentosHora', //Id da 'Window'
			height:Page.height - 128,
			plain:false,
			modal:true, //Bloquear conteúdo da página enquanto a janela está ativa
			layout:'border',
			items:[
				   panelFiltro,
				   panelAtendimentos
			],		
		});	
//___________________________Reajusta o tamanho da tela____________________________________________________________________________________	
	window.onresize = function(){			 
		//Obtem o tamanho no exato momento
		var a = getPageSize();	
		//No componente com determinado 'Id', é setado o novo tamanho (Para reajuste da tela)		 
		Ext.getCmp('AtendimentosHora').setSize(a.width,a.height - 122);
	};
});
</script>

