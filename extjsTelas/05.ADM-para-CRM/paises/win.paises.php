<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript">
  var comboStorePaises = new Ext.data.JsonStore({
	  url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/paises/get-paises.php',
	  root:'myData',
	  fields:['idpais','despais','desabreviacao2','desabreviacao3',{name:'instatus',type:'boolean'}],	
	autoLoad:true
  });
/*Ext.onReady(function(){*/
  if(Ext.getCmp('win.paises')){
	  Ext.getCmp('win.paises').show()
  }else{
	  var win = new Ext.Window({
		  id:'win.paises',
		  height:470,
		  width:437,
		  modal:false,
		  minimizable:true,
		  maximizable:true,
		  iconCls:'ico_flag_green',
		  title:' Países',
		  autoScroll:true,
		  tbar:[{
			  xtype:'button',
			  text:'Add País',
			  iconCls:'ico_adicionar',
			  handler:function(){
				  if(Ext.getCmp('win.add_pais')){
					Ext.getCmp('win.add_pais').show();
				  }else{
				  	var win_add = new Ext.Window({
						id:'win.add_pais',
						height:150,
						width:400,
						modal:true,
						title:'Adicionar um país novo',
						iconCls:'ico_flag_green',
						items:[{
							xtype:'form',
							id:'formAddPais',
							border:'false',
							padding:5,
							defaults:{xtype:'textfield', allowBlank:false},
							items:[{
								fieldLabel:'País',
								name:'despais',
								emptyText:'Adicione um país...',
								width:265,
								/*tooltip:{title:'sadsds'},
								listeners:{
									'focus':function(t){
										console.log(t);
										this.getErrors();
									}
								}*/
							},{
								fieldLabel:'Abreviação tipo 2',
								name:'desabreviacao2',
								emptyText:'Adicione uma abreviação de duas letras...',
								maxLength:2,
								width:235
							},{
								fieldLabel:'Abreviação tipo 3',
								name:'desabreviacao3',
								emptyText:'Adicione uma abreviação de três letras...',
								maxLength:3,
								width:235
							},{
								xtype:'hidden',
								name:'instatus',
								value:'1'
							}],
						}],
						buttons:[{
							text:'Adicionar',
							buttonAlign:left,
							iconCls:'ico_adicionar',
							handler:function(){
								if(Ext.getCmp('formAddPais').getForm().isValid()){
									Ext.getCmp('formAddPais').getForm().submit({
										url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/paises/set-paises.php',
/*										params:{											
											despais:Ext.getCmp('addpais').getValue(),
											desabreviacao2:Ext.getCmp('addabrevia2').getValue(),
											desabreviacao3:Ext.getCmp('addabrevia3').getValue()
										},*/
										success:function(){
											Ext.getCmp('gridpaises').getStore().reload({
												callback:function(){
													Ext.MessageBox.alert('','País adicionado com sucesso!');	
													Ext.getCmp('win.add_pais').close();
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
			  xtype:'button',
			  text:'Alterar Status',
			  iconCls:'ico_arrow_rotate_clockwise',
				 handler:function(){
					var rec = Ext.getCmp('gridpaises').getSelectionModel().getSelected();
					if(rec){
						var status = (!rec.get('instatus'));
						Ext.Ajax.request({
							url: '/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/paises/stat-paises.php',
							params: {
								idpais: rec.get('idpais'),
								instatus: status
							},
							success: function () {
								rec.set('instatus', status);
								rec.commit();
							}
						});
					}else{
						Ext.Msg.erro('','Selecione um país!');
					}
				} 
		  }],
		  items:[{
			 xtype:'editorgrid',
			 id:'gridpaises',
			 sm: new Ext.grid.RowSelectionModel({
			 singleSelect: true,
			}),
			 store:comboStorePaises,
			 loadMask:true,
			 stripeRows:true,
			 autoHeight:true,
			 border:false,
			 anchor:'100%',
			 viewConfig:{
				 getRowClass:function(record){
					 var _class = record.get('instatus');
					 if (!_class){
						 return 'red';
					 }/*else{
						 return 'black';
					 }*/
				 }
			 },
			 cm:new Ext.grid.ColumnModel({
				 columns:[{
					 header:'Status',
					 id:'statuslist',
					 width:45,
					 sortable:true,
					 dataIndex:'instatus',
					 renderer:function(v){				
					 if(v == 1){
					 	return '<img src="/simpacweb/images/ico/16/accept.png"/>';
						}
					 else{
					 	return '<img src="/simpacweb/images/ico/16/remove.png"/>';
						}														  
					 }
				},{
					 header:'Países',
					 id:'paiseslist',
					 width:200,
					 sortable:true,
					 dataIndex:'despais',
					 editor: new Ext.form.TextField({
						AllowBlack: false,							  
					})
				},{
					 header:'Abreviação 2',
					 id:'abrevia2',
					 width:79,
					 sortable:true,
					 dataIndex:'desabreviacao2',
					 editor: new Ext.form.TextField({
						AllowBlack: false,							  
					})
				},{
					header:'Abreviação 3',
					id:'abrevia3',
					width:79,
					sortable:true,
					dataIndex:'desabreviacao3',
					tooltip:'sadsds',
					editor: new Ext.form.TextField({
						AllowBlack: false,							  
			    	})
			 	}],
			 }),
			 listeners:{
			 afteredit: function(e){
				  //console.log(e);					
				  Ext.Ajax.request({ 
					  url: '/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/paises/set-paises.php',
						  params:{
							idpais:e.record.get('idpais'),
							despais:e.record.get('despais'),
							desabreviacao2:e.record.get('desabreviacao2'),
							desabreviacao3:e.record.get('desabreviacao3'),
							instatus:e.record.get('instatus')
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
paises (Grid - com três colunas)
despais
desabreviacao2
desabreviacao3*/
</script>


