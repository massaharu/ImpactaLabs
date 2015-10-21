<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript">
  var comboStorePaises = new Ext.data.JsonStore({
	  url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/paises/get-paises.php',
	  root:'myData',
	  fields:[{name:'despais',type:'string'}, 
			  {name:'idpais',type:'int'},
			  {name:'instatus',type:'boolean'}],
});
	  
	  
  var comboStoreEstados = new Ext.data.JsonStore({
	  url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/estados/get_estadosbypais.php',
	  root:'myData',
	  fields:['idestado','desestado','desestadosigla',{name:'instatus',type:'boolean'}],	
	//autoLoad:true
  });
/*Ext.onReady(function(){*/
  if(Ext.getCmp('win.estados')){
	  Ext.getCmp('win.estados').show()
  }else{
	  var win = new Ext.Window({
		  id:'win.estados',
		  height:470,
		  width:367,
		  modal:false,
		  minimizable:true,
		  maximizable:true,
		  iconCls:'ico_flag_green',
		  title:' Estados',
		  autoScroll:true,
		  tbar:[{
			  xtype:'button',
			  text:'Add Estado',
			  iconCls:'ico_adicionar',
			  handler:function(){
				  if(Ext.getCmp('win.add_estado')){
					Ext.getCmp('win.add_estado').show();
				  }else{
				  	var win_add = new Ext.Window({
						id:'win.add_estado',
						height:155,
						width:400,
						modal:true,
						title:'Adicionar um estado novo',
						iconCls:'ico_flag_green',
						items:[{
							xtype:'form',
							id:'estado_formAddestado',
							border:'false',
							padding:5,
							defaults:{anchor:'100%', allowBlank:false},
							items:[{
								xtype:'combo',
								id:'estado_combo_addestado',
								store:comboStorePaises,
								valueField:'idpais',
								displayField:'despais',
								fieldLabel:'País',
								typeAhead:true,
								triggerAction:'all',
								lazyRender:true,
								/*name:'value',*/
								width:270,
								emptyText:'Selecione um país...'
							 },{
								 xtype:'textfield',
								fieldLabel:'Estado',
								name:'desestado',
								emptyText:'Adicione um estado...',
								width:265,
								/*tooltip:{title:'sadsds'},
								listeners:{
									'focus':function(t){
										console.log(t);
										this.getErrors();
									}
								}*/
							},{
								xtype:'textfield',
								fieldLabel:'Sigla',
								name:'desestadosigla',
								emptyText:'Adicione uma abreviação...',
								maxLength:2,
								width:235
							}/*,{
								xtype:'hidden',
								name:'instatus',
								value:'1'
							}*/],
						}],
						buttons:[{
							text:'Adicionar',
							iconCls:'ico_adicionar',
							handler:function(){
								if(Ext.getCmp('estado_formAddestado').getForm().isValid()){
									Ext.getCmp('estado_formAddestado').getForm().submit({
										url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/estados/set_estados.php',
										params:{											
											idpais:Ext.getCmp('estado_combo_addestado').getValue(),
											/*desabreviacao2:Ext.getCmp('addabrevia2').getValue(),
											desabreviacao3:Ext.getCmp('addabrevia3').getValue()*/
										},
										success:function(){
											Ext.getCmp('gridestados').getStore().reload({
												callback:function(){
													Ext.MessageBox.alert('','Estado adicionado com sucesso!');	
													Ext.getCmp('win.add_estado').close();
												}	
											});
										}
									})
								}
							}
						}]
					}).show();
				 }
			  }
		  },'-',new Ext.form.ComboBox({
			  id:'estado_comboListEstado',
			  store:comboStorePaises,
			  valueField:'idpais',
			  displayField:'despais',
			  typeAhead:true,
			  triggerAction:'all',
			  lazyRender:true,
			  name:'despais',
			  emptyText:'Selecione um país...'
			  }),'-',{
			  xtype:'button',
			  text:'Pesquisar',
			  iconCls:'ico_search', 
			  handler:function(){
				  if(Ext.getCmp('estado_comboListEstado').isValid()){
					  comboStoreEstados.reload({
						  params:{
							  idpais:Ext.getCmp('estado_comboListEstado').getValue(),
							}
						});
					}
				}
			}],
		  items:[{
			 xtype:'editorgrid',
			 id:'gridestados',
			 sm: new Ext.grid.RowSelectionModel({
			 singleSelect: true,
			}),
			 store:comboStoreEstados,
			 loadMask:true,
			 stripeRows:true,
			 autoHeight:true,
			 border:false,
			 anchor:'100%',
			 cm:new Ext.grid.ColumnModel({
				 columns:[{
					 header:'Estados',
					 id:'estadoslist',
					 width:260,
					 sortable:true,
					 dataIndex:'desestado',
					 editor: new Ext.form.TextField({
						AllowBlack: false,							  
					})
				},{
					 header:'Sigla',
					 id:'abrevia2',
					 width:79,
					 sortable:true,
					 dataIndex:'desestadosigla',
					 editor: new Ext.form.TextField({
						AllowBlack: false,							  
					})
				}],
			 }),
			 listeners:{
			 afteredit: function(e){
				  //console.log(e);					
				  Ext.Ajax.request({ 
					  url: '/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/estados/set_estados.php',
						  params:{
							idestado:e.record.get('idestado'),
							desestado:e.record.get('desestado'),
							desestadosigla:e.record.get('desestadosigla'),
							idpais:Ext.getCmp('estado_comboListEstado').getValue()
						  },			
						  success:function(){
							 e.record.commit();
						}
					});	
			  	}
			},
			 height:610,
			 border:true,
			 defaults:{anchor:'100%'},
		  }],
	}).show();
}
/*Todos vão ter delete, update e insert.
estados (Grid - com três colunas)
desestado
desabreviacao2
desabreviacao3*/
</script>


