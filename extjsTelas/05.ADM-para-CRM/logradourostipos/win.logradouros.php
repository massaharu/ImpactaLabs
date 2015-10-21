<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript">
	var comboStoreLogradourostipos = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/logradourostipos/get_logradourostipos.php',
		root:'myData',
		fields:[{name:'deslogradourotipo',type:'string'}, 
				{name:'idlogradourotipo',type:'int'}],
      autoLoad:true
   });
	
	var comboStoreLogradouros = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/logradourostipos/get_logradouros.php',
		root:'myData',
		fields:[{name:'deslogradouro',type:'string'}, 
				{name:'idlogradouro',type:'int'}],
      autoLoad:true
   });

  
  if(Ext.getCmp('win.logradouros')){
	  Ext.getCmp('win.logradouros').show()
  }else{
	  var win = new Ext.Window({
		  id:'win.logradouros',
		  height:460,
		  width:370,
		  modal:false,
		  minimizable:true,
		  maximizable:true,
		  iconCls:'ico_flag_green',
		  title:' Logradouros',
		  autoScroll:true,
		  tbar:['Tipos  : ',new Ext.form.ComboBox({
			  id:'logradourosComboListLogradourostipos',
			  store:comboStoreLogradourostipos,
			  width:208,
			  valueField:'idlogradourotipo',
			  displayField:'deslogradourotipo',
			  typeAhead:true,
			  triggerAction:'all',
			  lazyRender:true,
			  name:'idlogradourotipo',
			  mode:'local',
			  emptyText:'Selecione um tipo de logradouro...',
			  listeners:{
				  'select':function(){
					  if(Ext.getCmp('logradourosComboListLogradourostipos').isValid()){
						  comboStoreLogradouros.load({
							  params:{
								  idlogradourotipo:Ext.getCmp('logradourosComboListLogradourostipos').getValue(),
								}
							});
					    }
					}
				}
			}), 
		],
		  bbar:[{
			  xtype:'button',
			  text:'Adicionar Logradouros',
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
						title:'Adicionar um novo Logradouro',
						iconCls:'ico_flag_green',
						items:[{
							xtype:'form',
							id:'formAddLogradouros',
							border:'false',
							padding:5,
							defaults:{anchor:'100%', allowBlank:false},
							items:[{
								xtype:'combo',
								id:'endereco_combo_addendereco',
								store:comboStoreLogradourostipos,
								valueField:'idlogradourotipo',
								displayField:'deslogradourotipo',
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
								fieldLabel:'Logradouro',
								name:'deslogradouro',
								emptyText:'Adicione um logradouros...',
								width:265,
							}],
						}],
						buttons:[{
							text:'Adicionar',
							iconCls:'ico_adicionar',
							handler:function(){
								if(Ext.getCmp('formAddLogradouros').getForm().isValid()){
									Ext.getCmp('formAddLogradouros').getForm().submit({
										url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/logradouros/set_endereco.php',
										params:{											
											idlogradouro:Ext.getCmp('endereco_combo_addcidades').getValue(),
										},
										success:function(){
											Ext.getCmp('gridlogradouro').getStore().reload({
												callback:function(){
													Ext.MessageBox.alert('','Logradouros adicionado com sucesso!');	
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
			 id:'gridlogradouro',
			 sm: new Ext.grid.RowSelectionModel({
			 singleSelect: true,
			}),
			 store:comboStoreLogradouros,
			 loadMask:true,
			 stripeRows:true,
			 autoHeight:true,
			 border:false,
			 anchor:'100%',
			 cm:new Ext.grid.ColumnModel({
				 columns:[{
					 header:'Logradouros',
					 id:'enderecoslist',
					 width:300,
					 sortable:true,
					 dataIndex:'deslogradouro',
					 editor: new Ext.form.TextField({
						AllowBlack: false,							  
					})
				}],
			 }),
			 listeners:{
			 afteredit: function(e){
				  //console.log(e);					
				  Ext.Ajax.request({ 
					  url: '/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/logradourostipos/set_endereco.php',
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
logradouros (Grid - com três colunas)
descidades
desabreviacao2
desabreviacao3*/
</script>


