<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript">
	var comboStorePessoajuridicatipos = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/pessoajuridicatipos/get_pessoajuridicatipos.php',
		root:'myData',
		fields:[{name:'despessoajuridicatipo',type:'string'}, 
				{name:'idpessoajuridicatipo',type:'int'}],
      autoLoad:true
   });
  
  if(Ext.getCmp('win.pessoajuridicatipos')){
	  Ext.getCmp('win.pessoajuridicatipos').show()
  }else{
	  var win = new Ext.Window({
		  id:'win.pessoajuridicatipos',
		  height:460,
		  width:320,
		  modal:false,
		  minimizable:true,
		  maximizable:true,
		  iconCls:'ico_People',
		  title:' Pessoa Juridica Tipos',
		  autoScroll:true,
		  bbar:[{
			  xtype:'button',
			  text:'Adicionar Pessoa Juridica Tipo',
			  iconCls:'ico_adicionar',
			  handler:function(){
				  if(Ext.getCmp('win.add_pessoajuridicatipo')){
					Ext.getCmp('win.add_pessoajuridicatipo').show();
				  }else{
				  	var win_add = new Ext.Window({
						id:'win.add_pessoajuridicatipo',
						height:116,
						width:450,
						modal:true,
						title:'Adicionar uma nova Pessoa Juridica Tipo',
						iconCls:'ico_People',
						items:[{
							xtype:'form',
							id:'formAddPessoajuridicatipo',
							border:'false',
							padding:5,
							defaults:{anchor:'100%', allowBlank:false},
							items:[{
								xtype:'textfield',
								id:'addpessoajuridicatipos',
								fieldLabel:'Pessoa Juridica Tipo',
								name:'despessoajuridicatipos',
								emptyText:'Adicione um tipo de Pessoa...',
								width:265,
							}],
						}],
						buttons:[{
							text:'Adicionar',
							iconCls:'ico_adicionar',
							handler:function(){
								if(Ext.getCmp('formAddPessoajuridicatipo').getForm().isValid()){
									Ext.getCmp('formAddPessoajuridicatipo').getForm().submit({
										url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/pessoajuridicatipos/set_pessoajuridicatipos.php',
										params:{											
											
										},
										success:function(){
											Ext.getCmp('gridpessoajuridicatipos').getStore().reload({
												callback:function(){
													Ext.MessageBox.alert('','Pessoa Juridica Tipo adicionado com sucesso!');	
													Ext.getCmp('win.add_pessoajuridicatipo').close();
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
			 id:'gridpessoajuridicatipos',
			 sm: new Ext.grid.RowSelectionModel({
			 singleSelect: true,
			}),
			 store:comboStorePessoajuridicatipos,
			 loadMask:true,
			 stripeRows:true,
			 autoHeight:true,
			 border:false,
			 anchor:'100%',
			 cm:new Ext.grid.ColumnModel({
				 columns:[{
					 header:'Pessoa Juridica Tipos',
					 id:'pessoajuridicatiposlist',
					 width:300,
					 sortable:true,
					 dataIndex:'despessoajuridicatipo',
					 editor: new Ext.form.TextField({
						AllowBlack: false,							  
					})
				}],
			 }),
			 listeners:{
			 afteredit: function(e){
				  //console.log(e);					
				  Ext.Ajax.request({ 
					  url: '/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/pessoajuridicatipos/set_pessoajuridicatipos.php',
						  params:{
							idpessoajuridicatipo:e.record.get('idpessoajuridicatipo'),
							despessoajuridicatipos:e.record.get('despessoajuridicatipos'),
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


