<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript">
	var comboStoreContatoscategorias = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/contatoscategorias/get_contatoscategorias.php',
		root:'myData',
		fields:[{name:'descontatotipocategoria',type:'string'}, 
				{name:'idcontatotipocategoria',type:'int'}],
      autoLoad:true
   });
  
  if(Ext.getCmp('win.contatoscategorias')){
	  Ext.getCmp('win.contatoscategorias').show()
  }else{
	  var win = new Ext.Window({
		  id:'win.contatoscategorias',
		  height:460,
		  width:320,
		  modal:false,
		  minimizable:true,
		  maximizable:true,
		  iconCls:'ico_contact_phone',
		  title:' Categoria de Contatos',
		  autoScroll:true,
		  bbar:[{
			  xtype:'button',
			  text:'Adicionar',
			  iconCls:'ico_adicionar',
			  handler:function(){
				  if(Ext.getCmp('win.add_contatotipocategoria')){
					Ext.getCmp('win.add_contatotipocategoria').show();
				  }else{
				  	var win_add = new Ext.Window({
						id:'win.add_contatotipocategoria',
						height:116,
						width:450,
						modal:true,
						title:'Adicionar uma nova Categoria de Contato',
						iconCls:'ico_contact_phone',
						items:[{
							xtype:'form',
							id:'formAddContatoscategorias',
							border:'false',
							padding:5,
							defaults:{anchor:'100%', allowBlank:false},
							items:[{
								xtype:'textfield',
								id:'addcontatostiposcategorias',
								fieldLabel:'Categoria de Contato',
								name:'descontatotipocategoria',
								emptyText:'Adicione uma categoria de contato...',
								width:265,
							}],
						}],
						buttons:[{
							text:'Adicionar',
							iconCls:'ico_adicionar',
							handler:function(btn){
								loadInBtn(btn);
								if(Ext.getCmp('formAddContatoscategorias').getForm().isValid()){
									Ext.getCmp('formAddContatoscategorias').getForm().submit({
										url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/contatoscategorias/set_contatoscategorias.php',
										params:{											
											
										},
										success:function(){
											Ext.getCmp('gridcontatostiposcategorias').getStore().reload({
												callback:function(){
													Ext.MessageBox.alert('','Categoria de Contato adicionado com sucesso!');	
													Ext.getCmp('win.add_contatotipocategoria').close();
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
		  },'-',{
			  text:'Desativar',
			  iconCls:'ico_delete',
			  handler:function(){
				  if(!Ext.getCmp('gridcontatostiposcategorias').getSelectionModel().getSelected()){
					  Ext.MessageBox.alert('Aviso!', 'Por favor, Selecione uma categoria.');
				  }else{
					  Ext.MessageBox.confirm('Confirmacao', 'Deletar o registro selecionado?',function(btn){
						  if(btn=='yes'){
							  Ext.Ajax.request({
								  url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/contatoscategorias/del_contatoscategorias.php',
								  params:{											
									  idcontatotipocategoria:Ext.getCmp('gridcontatostiposcategorias').getSelectionModel().getSelected().get('idcontatotipocategoria')
								  },
								  success:function(){
									  Ext.getCmp('gridcontatostiposcategorias').getStore().reload({
										  callback:function(){
											  Ext.MessageBox.alert('','Categoria deletado!');	
										  }	
									  });
								  }
							  })
						  }
					  });
				  }
			  }
		}],
		  items:[{
			 xtype:'editorgrid',
			 id:'gridcontatostiposcategorias',
			 sm: new Ext.grid.RowSelectionModel({
			 singleSelect: true,
			}),
			 store:comboStoreContatoscategorias,
			 loadMask:true,
			 stripeRows:true,
			 autoHeight:true,
			 border:false,
			 anchor:'100%',
			 cm:new Ext.grid.ColumnModel({
				 columns:[{
					 header:'Categoria de Contatos',
					 id:'categoriadecontatoslist',
					 width:300,
					 sortable:true,
					 dataIndex:'descontatotipocategoria',
					 editor: new Ext.form.TextField({
						AllowBlack: false,							  
					})
				}],
			 }),
			 listeners:{
			 afteredit: function(e){
				  //console.log(e);	
				  Ext.Ajax.request({ 
					  url: '/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/contatoscategorias/up_contatoscategorias.php',
						  params:{
							idcontatotipocategoria:e.record.get('idcontatotipocategoria'),
							descontatotipocategoria:e.record.get('descontatotipocategoria'),
							//idbairro:Ext.getCmp('logradourosComboListBairros').getValue()
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
</script>


