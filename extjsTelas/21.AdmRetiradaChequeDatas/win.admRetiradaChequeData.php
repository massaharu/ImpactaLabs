<?
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; //$GLOBALS['JSON'] = true; 
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 
?>
<script type="text/javascript">
	Ext.onReady(function(){
		xt = Ext.getCmp;
		ms = Ext.MessageBox;
		
		var mask;
		
		if(xt('winchequearetirardata')){
			xt('winchequearetirardata').show();
		}else{
			var storeRetiradaChequeDiasSemRetirada = new Ext.data.JsonStore({
				url:'/simpacweb/labs/Massaharu/extjsTelas/21.AdmRetiradaChequeDatas/json/retiradacheque_diassemretirada_list.php',
				root:'myData',
				fields:[
					{name:'iddata', type: 'int'},
					{name:'dtdata', type: 'date', dateFormat: 'timestamp'}
				],
				autoLoad:true
			});
			
			var win = new Ext.Window({
				id:'winchequearetirardata',
				title:'Datas que não devem ter Cheques Retirados',
				iconCls:'ico_date',
				height:500,
				width:400,
				border:false,
				layout:'fit',
				bbar:['Data: ',{
					xtype:'datefield',
					id:'dtdatachequeretirado',	
					editable:false,
					emptyText:'Selecione uma data ->',
					height:30,
					width:150
				},'-',{
					text:'Salvar',
					iconCls:'ico_save',
					scale:'medium',
					handler:function(){
						
						var $data = xt('dtdatachequeretirado').getValue();
						
						if($.trim($data) != ""){
						
							Ext.Ajax.request({
								url:'/simpacweb/labs/Massaharu/extjsTelas/21.AdmRetiradaChequeDatas/ajax/retiradacheque_diassemretirada_save.php',
								params:{
									iddata:0,
									dtdata:$data.format('Y-m-d')
								},
								success:function(){
									
									xt('dtdatachequeretirado').setValue("");
									
									mask = new Ext.LoadMask(xt('winchequearetirardata').body,{msg:'Aguarde...'});
									mask.show();
											
									storeRetiradaChequeDiasSemRetirada.reload({
										callback:function(){
											mask.hide();
											
											ms.info('Salvo!', 'Data: '+$data.format('d-m-Y')+' salvo com sucesso.');
										}
									})
								}
							});
						}else{
							ms.erro("Aviso", "Insira uma data válida.");
						}
					}
				},'->','-',{
					text:'Excluir',
					iconCls:'ico_delete',
					scale:'medium',
					handler:function(){
						
						var $gridRow = xt('gridRetiradaChequeDiasSemRetirada').getSelectionModel().getSelected();
						
						if(!$gridRow){
							ms.erro('Aviso!', 'Uma data deve ser selecionada para deletar.');
						}else{
							ms.confirm('Confirmação', 'Deseja realmente deletar a data '+$gridRow.get('dtdata').format('d-m-Y')+' ?',
							function(btn){
								if(btn=='yes'){
									Ext.Ajax.request({
										url:'/simpacweb/labs/Massaharu/extjsTelas/21.AdmRetiradaChequeDatas/ajax/retiradacheque_diassemretirada_delete.php',
										params:{
											iddata:$gridRow.get('iddata')
										},
										success:function(){
											
											mask = new Ext.LoadMask(xt('winchequearetirardata').body,{msg:'Aguarde...'});
											mask.show();
													
											storeRetiradaChequeDiasSemRetirada.reload({
												callback:function(){
													mask.hide();
													
													ms.info('Deletado!', 'Data: '+$gridRow.get('dtdata').format('d-m-Y')+' excluído com sucesso.');
												}
											});
										}
									});
								}
							})
						}
					}
				}],
				items:[{
					xtype:'editorgrid',
					id:'gridRetiradaChequeDiasSemRetirada',
					store:storeRetiradaChequeDiasSemRetirada,
					stripeRows: true,
					border: false,
					height:'auto',
					viewConfig:{
						forceFit:true
					},
					sm: new Ext.grid.RowSelectionModel({
						singleSelect: true,
					}),
					columns:[{
						hidden:true,
						dataIndex:'iddata'
					},{
						header:'Data',
						xtype:'datecolumn',
						dataIndex:'dtdata',
						format:'d/m/Y',
						editor: new Ext.form.DateField({
							allowBlank:false,
							editable:false
						})
					}],
					listeners:{
						afteredit:function(e){
							ms.confirm('Confirmação', 'Deseja realmente alterar a data para '+e.record.get('dtdata').format('Y-m-d')+' ?',
							function(btn){
								if(btn=='yes'){
									Ext.Ajax.request({
										url:'/simpacweb/labs/Massaharu/extjsTelas/21.AdmRetiradaChequeDatas/ajax/retiradacheque_diassemretirada_save.php',
										params:{
											iddata:e.record.get('iddata'),
											dtdata:e.record.get('dtdata').format('Y-m-d')
										},
										success:function(){
											e.record.commit();
										}
									});
								}else{
								
									mask = new Ext.LoadMask(xt('winchequearetirardata').body,{msg:'Aguarde...'});
									mask.show();
											
									storeRetiradaChequeDiasSemRetirada.reload({
										callback:function(){
											mask.hide();
										}
									});
								}
							});
						}
					}
				}]
			}).show();
		}
	})
	
</script>