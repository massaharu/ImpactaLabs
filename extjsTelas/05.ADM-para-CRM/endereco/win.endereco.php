<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript">
	var comboStoreEndereco = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/endereco/get_endereco.php',
		root:'myData',
		fields:[{name:'despais',type:'string'}, 
				{name:'idpais',type:'int'},
				{name:'instatus',type:'boolean'}],
      autoLoad:true
   });
		
	var comboStoreEstados = new Ext.data.JsonStore({
	  url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/estados/get_estadosbypais.php',
	  root:'myData',
	  fields:['idestado','desestado','desestadosigla',{name:'instatus',type:'boolean'}],	
   });
  
	var comboStoreCidades = new Ext.data.JsonStore({
	  url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/cidades/get_cidadesbyestado.php',
	  root:'myData',
	  fields:[{name:'idcidade',type:'int'},
			  {name:'descidade',type:'string'},
			  {name:'idestado',type:'int'}],
	}); 
	  
  	var comboStoreBairros = new Ext.data.JsonStore({
	  url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/bairros/get_bairrosbycidades.php',
	  root:'myData',
	  fields:[{name:'idbairro',type:'int'},
			  {name:'desbairro',type:'string'},
			  {name:'idcidade',type:'int'}],
	});
	
	var comboStoreEndereco = new Ext.data.JsonStore({
	  url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/endereco/get_enderecobybairros.php',
	  root:'myData',
	  fields:[{name:'idenderecotipo',type:'int'},
			  {name:'desendereco',type:'string'},
			  {name:'idbairro',type:'int'}],
	});
  
  if(Ext.getCmp('win.endereco')){
	  Ext.getCmp('win.endereco').show()
  }else{
	  var win = new Ext.Window({
		  id:'win.endereco',
		  height:460,
		  width:370,
		  modal:false,
		  minimizable:true,
		  maximizable:true,
		  iconCls:'ico_flag_green',
		  title:' Endereco',
		  autoScroll:true,
		  tbar:['Tipos de Logradouros:',new Ext.form.ComboBox({
			  id:'enderecoComboListEndereco',
			  store:comboStoreEndereco,
			  width:208,
			  valueField:'idpais',
			  displayField:'despais',
			  typeAhead:true,
			  triggerAction:'all',
			  lazyRender:true,
			  name:'idpais',
			  mode:'local',
			  emptyText:'Selecione um tipo de logradouro...',
			  listeners:{
				  'select':function(){
					  if(Ext.getCmp('enderecoComboListEndereco').isValid()){
						  comboStoreEstados.load({
							  params:{
								  idpais:Ext.getCmp('enderecoComboListEndereco').getValue(),
								}
							});
					    }
					}
				}
			}), 
		],
		  bbar:[{
			  xtype:'button',
			  text:'Adicionar Endereco',
			  iconCls:'ico_adicionar',
			  handler:function(){
				  if(Ext.getCmp('win.add_endereco')){
					Ext.getCmp('win.add_endereco').show();
				  }else{
				  	var win_add = new Ext.Window({
						id:'win.add_endereco',
						height:138,
						width:400,
						modal:true,
						title:'Adicionar um novo Endereco',
						iconCls:'ico_flag_green',
						items:[{
							xtype:'form',
							id:'formAddEndereco',
							border:'false',
							padding:5,
							defaults:{anchor:'100%', allowBlank:false},
							items:[{
								xtype:'combo',
								id:'endereco_combo_addendereco',
								store:comboStoreBairros,
								valueField:'idbairro',
								displayField:'desbairro',
								fieldLabel:'Tipos de Logradouros',
								typeAhead:true,
								triggerAction:'all',
								lazyRender:true,
								mode:'local',
								/*name:'value',*/
								width:270,
								emptyText:'Selecione um tipo de logradouro...'
							 },{
								xtype:'textfield',
								id:'addendereco',
								fieldLabel:'Endereco',
								name:'desbairro',
								emptyText:'Adicione um endereco...',
								width:265,
							}],
						}],
						buttons:[{
							text:'Adicionar',
							iconCls:'ico_adicionar',
							handler:function(){
								if(Ext.getCmp('formAddEndereco').getForm().isValid()){
									Ext.getCmp('formAddEndereco').getForm().submit({
										url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/endereco/set_endereco.php',
										params:{											
											idbairro:Ext.getCmp('endereco_combo_addcidades').getValue(),
										},
										success:function(){
											Ext.getCmp('gridendereco').getStore().reload({
												callback:function(){
													Ext.MessageBox.alert('','Endereco adicionado com sucesso!');	
													Ext.getCmp('win.add_endereco').close();
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
		  }],
		  items:[{
			 xtype:'editorgrid',
			 id:'gridendereco',
			 sm: new Ext.grid.RowSelectionModel({
			 singleSelect: true,
			}),
			 store:comboStoreEndereco,
			 loadMask:true,
			 stripeRows:true,
			 autoHeight:true,
			 border:false,
			 anchor:'100%',
			 cm:new Ext.grid.ColumnModel({
				 columns:[{
					 header:'Endereco',
					 id:'enderecoslist',
					 width:300,
					 sortable:true,
					 dataIndex:'desendereco',
					 editor: new Ext.form.TextField({
						AllowBlack: false,							  
					})
				}],
			 }),
			 listeners:{
			 afteredit: function(e){
				  //console.log(e);					
				  Ext.Ajax.request({ 
					  url: '/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/endereco/set_endereco.php',
						  params:{
							idendereco:e.record.get('idendereco'),
							desendereco:e.record.get('desendereco'),
							idbairro:Ext.getCmp('enderecoComboListBairros').getValue()
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
endereco (Grid - com três colunas)
descidades
desabreviacao2
desabreviacao3*/
</script>


