<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript">
	var comboStoreContatostipos = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/contatostipos/get_contatostipos.php',
		root:'myData',
		fields:[{name:'descontatotipo',type:'string'}, 
				{name:'idcontatotipo',type:'int'}],
      autoLoad:true
   });
  
  if(Ext.getCmp('win.contatostipos')){
	  Ext.getCmp('win.contatostipos').show()
  }else{
	  var win = new Ext.Window({
		  id:'win.contatostipos',
		  height:460,
		  width:320,
		  modal:false,
		  minimizable:true,
		  maximizable:true,
		  iconCls:'ico_contact_phone',
		  title:' Tipos de Contatos',
		  autoScroll:true,
		  bbar:[{
			  xtype:'button',
			  text:'Adicionar Tipo de Contato',
			  iconCls:'ico_adicionar',
			  handler:function(){
				  if(Ext.getCmp('win.add_contatotipo')){
					Ext.getCmp('win.add_contatotipo').show();
				  }else{
				  	var win_add = new Ext.Window({
						id:'win.add_contatotipo',
						height:98,
						width:450,
						modal:true,
						title:'Adicionar um novo Tipo de Contato',
						iconCls:'ico_contact_phone',
						items:[{
							xtype:'form',
							id:'formAddContatostipos',
							border:'false',
							padding:5,
							defaults:{anchor:'100%', allowBlank:false},
							items:[{
								xtype:'textfield',
								id:'addcontatostipos',
								fieldLabel:'Tipo de Contato',
								name:'descontatotipo',
								emptyText:'Adicione um tipo de contato...',
								width:265,
							}],
						}],
						buttons:[{
							text:'Adicionar',
							iconCls:'ico_adicionar',
							handler:function(){
								if(Ext.getCmp('formAddContatostipos').getForm().isValid()){
									Ext.getCmp('formAddContatostipos').getForm().submit({
										url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/contatostipos/set_contatostipos.php',
										params:{											
											
										},
										success:function(){
											Ext.getCmp('gridcontatostipos').getStore().reload({
												callback:function(){
													Ext.MessageBox.alert('','Tipo de Contato adicionado com sucesso!');	
													Ext.getCmp('win.add_contatotipo').close();
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
			 id:'gridcontatostipos',
			 sm: new Ext.grid.RowSelectionModel({
			 singleSelect: true,
			}),
			 store:comboStoreContatostipos,
			 loadMask:true,
			 stripeRows:true,
			 autoHeight:true,
			 border:false,
			 anchor:'100%',
			 cm:new Ext.grid.ColumnModel({
				 columns:[{
					 header:'Contatos Tipos',
					 id:'contatostiposlist',
					 width:300,
					 sortable:true,
					 dataIndex:'descontatotipo',
					 editor: new Ext.form.TextField({
						AllowBlack: false,							  
					})
				}],
			 }),
			 listeners:{
			 afteredit: function(e){
				  //console.log(e);					
				  Ext.Ajax.request({ 
					  url: '/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/contatostipos/set_contatostipos.php',
						  params:{
							idcontatotipo:e.record.get('idcontatotipo'),
							descontatotipo:e.record.get('descontatotipo'),
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


