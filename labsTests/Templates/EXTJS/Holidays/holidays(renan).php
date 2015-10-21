<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript">
var id = 0;
if(Ext.getCmp('janelaferiadosv1.0')){
	Ext.getCmp('janelaferiadosv1.0').show();
}else{
	var storage = new Ext.data.JsonStore({
	  url: '/simpacweb/modulos/treinamentos/feriados/ajax/SelectFeriado.php',
	  root: 'mydata',
	  fields: [{name: 'idferiado',	type: 'int'}
			  ,{name: 'desferiado',	type: 'string'}
			  ,{name: 'dtinicio',	type: 'date',	dateFormat: 'timestamp'}
			  ,{name: 'dttermino',	type: 'date',	dateFormat: 'timestamp'}],
	  autoLoad:true
	});
	
	new Ext.Window({
		id: 'janelaferiadosv1.0',
		width: 510,
		height: 370,
		border: false,
		title: 'Feriados',
		minimizable: true,
		resizable: false,
		autoScroll:true,
		iconCls: 'ico_book_open', //inserir icone na aba da janela
		items:[{
			xtype: 'editorgrid',
			id: 'egrid',
			height: 335,
			sm: new Ext.grid.RowSelectionModel({
				singleSelect: true,
			}),
			store: storage,
			border: false,
			tbar:[{
				text:'Adicionar',
				iconCls:'ico_add',
				handler:function(){
					if(Ext.getCmp('adicionarferiado')){
			 			Ext.getCmp('adicionarferiado').show();
					}
					else {
						var feriado = new Ext.Window({
							id: 'adicionarferiado',
							width: 350,
							autoHeight: true,
							title: 'Adicionar',
							items:[{
								xtype: 'form',
								border: false,
								padding: 10,
								defaults: {allowBlank: false, anchor: '100%'},
								items:[{
									xtype: 'textfield',
									fieldLabel: 'Feriado',
									name: 'addferiado',
									id: 'addferiado'
								},{
									xtype: 'compositefield',
									defaults: {flex: 1},
									items:[{
										xtype: 'datefield',
										fieldLabel: 'De',
										name: 'adddata',
										id: 'adddata',
										listeners: {
											select: function(adddata){
												 Ext.getCmp('adddata1').setMinValue(adddata.getValue());
											}
										}
							 	},{
									xtype: 'timefield',
									name: 'addhora',
									format: 'H:i',
									id: 'addhora'
								}]
							},{
								xtype: 'compositefield',
								defaults: {flex: 1},
								items:[{
									xtype: 'datefield',
									fieldLabel: 'Ate',
									name: 'adddata1',
									id: 'adddata1',
									listeners: {
										select: function(adddata1){
											Ext.getCmp('adddata').setMaxValue(adddata1.getValue());
										}
									}
								},{
									xtype: 'timefield',
									name: 'addhora1',
									format: 'H:i',
									id: 'addhora1'
								}]
							}]
						}],		
						buttons:[{
							text: 'Confirmar',
							iconCls: 'ico_action_check',
							iconAlign: 'right',
							handler: function(a){
								Ext.Ajax.request({
									url: '/simpacweb/modulos/treinamentos/feriados/ajax/InsertFeriado.php',
									params: {
									   desferiado: Ext.getCmp('addferiado').getValue(), 
									   dtinicio:   Ext.getCmp('adddata').getValue().format('Y-m-d') +" "+ Ext.getCmp('addhora').getValue(),
									   dttermino:  Ext.getCmp('adddata1').getValue().format('Y-m-d')+" "+ Ext.getCmp('addhora1').getValue()
									},
									success: function(i){
										eval('var data = '+i.responseText+';');
										var registro = {	
											desferiado: Ext.getCmp('addferiado').getValue(), 
											dtinicio:Ext.getCmp('adddata').getValue().format('Y-m-d'	) +" "+ Ext.getCmp('addhora').getValue(),
											dttermino: Ext.getCmp('adddata1').getValue().format('Y-m-d')+" "+ Ext.getCmp('addhora1').getValue(),
											idferiado: data.id
									    }
										var record = new storage.recordType(registro, ++id);
										storage.insert(0,record);
										feriado.close();
									}				 
								})
							}
						},{
						  text: 'Cancelar',
						  iconCls: 'ico_cancelar',
						  iconAlign: 'right',
						  handler: function(){
							  feriado.close();
							  }
						}]
					}).show();
				}
			}
		},{
			text: 'Deletar',
			iconCls: 'ico_delete',
			handler: function(a){
				Ext.Msg.confirm('Confirma&#231;&#227;o','Tem certeza disso?',function(btn){	
					if(btn == 'yes'){
						var del = Ext.getCmp('egrid').getSelectionModel().getSelected();
								
						Ext.Ajax.request({
							url: '/simpacweb/modulos/treinamentos/feriados/ajax/DeleteFeriado.php',
							params: {
								id: del.get('idferiado'),
								},			
							success: function(){ //deletar dados
								Ext.getCmp('egrid').getStore().remove(del);
								Ext.Msg.alert('Mensagem','Deletado');
							 }
						});
					}
				});
			}
		},'->',{
			iconCls:'ico_print',
			handler:function(){
				printer(Ext.getCmp('egrid'));
			}
		},'-',{
			iconCls:'ico_excel',
			handler:function(){
				exporter(Ext.getCmp('egrid'));
			}
		}],
		cm:new Ext.grid.ColumnModel({
			columns:[{
				header: 'Feriado',
				dataIndex: 'desferiado',
				width: 183,
				sortable: true,
				editor: new Ext.form.TextField({
					AllowBlack: false,							  
				})
			},{
				header: 'Data Inicio',
				dataIndex: 'dtinicio',
				xtype:'datecolumn',
				format: 'd/m/Y H:i:s',
				width: 138,
				sortable: true,
				editor: new Ext.form.TextField({
					AllowBlack: false,							  
				})
			},{
				header: 'Data Termino',
				dataIndex: 'dttermino',
				xtype:'datecolumn',
				format: 'd/m/Y H:i:s',
				width: 138,
				sortable: true,
				editor: new Ext.form.TextField({
					AllowBlack: false,							  
				})
			}],
		}),
	   	listeners:{
			afteredit: function(e){
				//console.log(e);					
				Ext.Ajax.request({ //Alterar dados
			 		url: '/simpacweb/modulos/treinamentos/feriados/ajax/UpdateFeriado.php',
						params:{
							field: e.field,
							value: e.value,
							id: e.record.get('idferiado')
						},			
						success: function(){
							e.record.commit();	
						}
					});	
				}
			}
		}]
	}).show();
}
</script>