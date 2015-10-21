<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript">
/*	if(Ext.getCmp('winvalorespagos')){
		(Ext.getCmp('winvalorespagos').show)
	}else{*/
		
Ext.onReady(function(){
		var myMask = new Ext.LoadMask(Ext.getBody(), {msg:"Aguarde......"});
		
		var store_valorespagos = new Ext.data.JsonStore({
			url: "/simpacweb/json/store_valorespagos.php?code=true",
			root: "myData",
			fields: [
				{name:"idcursoagendado", type:"int"},
				{name:"descurso"}, 
				{name:"dtinicio", type:"date", dateFormat:"timestamp"},
				{name:"dttermino", type:"date", dateFormat:"timestamp"},
				{name:"desperiodo"},
				{name:"vlinstrutor"},
				{name:"nminstrutor"},
				{name:"vltotalpago"}
			]
		});
		
		var storetreinamento = new Ext.data.JsonStore({
			url:'/simpacweb/modulos/secretaria/ajax/getTreinamentosValoresPagos.php',
			root:'myData',
			fields:[{name:'idcurso', type:'int'},{name:'descurso', type:'string'}],
			autoLoad:true
		});
		
		
		var tempgrid = new Ext.grid.GridPanel({
		store:store_valorespagos,
		columns: [
			new Ext.grid.TemplateColumn({id: 'descurso', header: 'Treinamento', width: 300, sortable: false, dataIndex: 'descurso', tpl:LinkPermissao.cursoagendado}),
			{header: 'Inicio', width: 100, sortable: true, xtype: 'datecolumn', format: 'd/m/Y', dataIndex: 'dtinicio'},
			{header: 'T\u00e9rmino', width: 100, sortable: true, xtype: 'datecolumn', format: 'd/m/Y', dataIndex: 'dttermino'},
			{header: 'Per\u00edodo', width: 100, sortable: true, dataIndex: 'desperiodo', hidden:true},
			{header: 'Instrutor', width: 200, sortable: true, dataIndex: 'nminstrutor', hidden:true},	
			{header: 'Valor Instrutor', width: 100, sortable: true, dataIndex: 'vlinstrutor', renderer: formatcurrency},
			{header: 'Valor Pago', width: 100, sortable: true, dataIndex: 'vltotalpago', renderer: formatcurrency}
		],
		border:false,
		//autoHeight:true
		height:Page.height-260
	});
		
////////////////////////////////////////MENU SEARCH(WEST)///////////////////////////////////////////////////////////////////////////////////////////////////////////		
			
	var menuSearch = new Ext.Panel({
		id:'idpanelmenusearch',
		region: 'west',
		//collapsible: true,
		split:true,
		collapseMode:'mini',
		margins:'2 2 2 2',
		width:'99%',
		layout:'fit',
		items:[{
			xtype:'form',
			border:false,
			width:'100%',
			bodyStyle:'margin:10px;',
			items:[{
				xtype:'fieldset',
				title:'Filtro de Pesquisa',
				autoHeight:true,
				collapsed:false,
				width:462,
				height:'100%',
				buttonAlign:'center',
				labelWidth:100,					
				items:[{
					xtype: 'compositefield',
					labelWidth: 120,
					hideLabel:true,
					items: [{
						xtype:'label',
						text:'De: ',
						width:100
					},{
						xtype:'datefield', 
						format:'d/m/Y',
						id:'filtr_data1',
						value:getdate()							
					},{
						xtype:'label',
						text:'Até: ',
						width:30
					},{
						xtype:'datefield', 
						format:'d/m/Y',
						id:'filtr_data2',
						value:getdate()
					}]
				},{
					fieldLabel:'Treinamento',
					width:200,
					typeAhead: true,
					triggerAction: 'all',
					lazyRender:true,
					mode: 'local',
					id:'nmcurso',
					store: storetreinamento,
					valueField: 'idcurso',
					displayField: 'descurso',
					xtype:'combo',
					emptyText:'Selecione um treinamento...',
					anchor:'100%'
				}],
				buttons:[{
					text:'Pesquisar',
					scale:'large',
					iconCls:'ico_search',
					handler:function(){
						mainWinPos = Ext.getCmp('winvalorespagos').getPosition();
						myMask.show();
						store_valorespagos.reload({							
							params:{
								data1:Ext.getCmp('filtr_data1').getValue().format('Y-m-d'),
								data2:Ext.getCmp('filtr_data2').getValue().format('Y-m-d'),
								idcurso:Ext.getCmp('nmcurso').getValue()
							},
							callback:function(grid){
								myMask.hide();
								if(grid != ''){
									Ext.getCmp('winvalorespagos').setSize(800,400),
									Ext.getCmp('winvalorespagos').setPosition(mainWinPos[0]-150,mainWinPos[1]-80),
									Ext.getCmp('idpanelmenusearch').collapse(),
									Ext.getCmp('winvalorespagos').setTitle('Treinamentos - Valores Pagos - De: '+Ext.getCmp('filtr_data1').getValue().format('d-m-Y')+', Até: '+Ext.getCmp('filtr_data1').getValue().format('d-m-Y')+', Curso: '+Ext.getCmp('nmcurso').getRawValue())
								}else{
									Ext.MessageBox.info('Aviso!','Não há nenhum registro para o curso '+Ext.getCmp('nmcurso').getRawValue()+' na data de: '+Ext.getCmp('filtr_data1').getValue().format('d-m-Y')+' até: '+Ext.getCmp('filtr_data1').getValue().format('d-m-Y'))
								}
							}
						})
					}
				}],
			}]
		}],
		listeners:{
			'expand':function(){
				Ext.getCmp('winvalorespagos').setPosition(mainWinPos[0],mainWinPos[1]),
				Ext.getCmp('winvalorespagos').setSize(500,200),
				Ext.getCmp('winvalorespagos').setTitle('Treinamentos - Valores Pagos')
			},
			'collapse':function(){
				Ext.getCmp('winvalorespagos').setSize(800,400),
				Ext.getCmp('winvalorespagos').setPosition(mainWinPos[0]-150,mainWinPos[1]-80),
				Ext.getCmp('idpanelmenusearch').collapse()
			}
		}
	})
/////////////////////////////////////GRID VALORES PAGOS(CENTER)//////////////////////////////////////////////////////////////////////////////////////////////////////////////		
	var gridValoresPagos = new Ext.Panel({
		id:'idpanelgridvalorespagos',
		region: 'center',
		margins:'2 2 2 0',
		layout:'fit',
		bbar:[{
			iconCls:'ico_Forward',
			tooltip:"Voltar para menu de pesquisa",
			handler:function(){
				Ext.getCmp('idpanelmenusearch').expand(),
				Ext.getCmp('winvalorespagos').setTitle('Treinamentos - Valores Pagos')
			}
		},'-',{
			xtype: "export",
			target: 'idgridvalorespagos',
		}],
		items:[tempgrid]
	});
/////////////////////////////////////MAIN WINDOW//////////////////////////////////////////////////////////////////		
	var winMain = new Ext.Window({
		title:'Treinamentos - Valores Pagos',
		id:'winvalorespagos',
		height:200,
		width:500,
		resizable:false,
		minimizable:true,	
		minWidth:200,
		minHeight:100,
		modal:true,
		collapsible:true,
		layout:'border',
		iconCls:'ico_money',
		items:[menuSearch, gridValoresPagos]
	}).show();	
});

	
	
</script>