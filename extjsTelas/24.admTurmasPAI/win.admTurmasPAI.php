<?
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['BOOTSTRAP'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 
?>
<script type="text/javascript">
	Ext.onReady(function(){
		//GLOBALS
		//var PATH = "/simpacweb/modulos/fit/site/admTurmasPAI";
		var PATH = "/simpacweb/labs/Massaharu/extjsTelas/24.admTurmasPAI";
		
		var now = new Date();
		var xt = Ext.getCmp;
		var ms = Ext.MessageBox;

/////////////////////// FUNCTIONS ///////////////////////////////////
		function getPeriodo(month){
			if(month < 6){
				return 1;
			}else if(month >= 6){
				return 2;
			}
		}
		
		function fn_status(v){	
			if(v == true){
				return '<img src="'+PATH+'/res/img/true.png" style="width:16px; height:16px;"/>';
			}else{
				return '<img src="'+PATH+'/res/img/false.png style="width:16px; height:16px;"/>';
			}														  
		}
		
		function loadGridsTurmaPai(obj){
			storelist_turmapai_periodo.reload({
				params:obj
			});
		
			storelist_turmapai.reload({
				params:obj
			});
		}
		
/////////////////////// STORES ///////////////////////////////////////
		var storelist_turmapai = new Ext.data.JsonStore({
			url:PATH+'/json/list_turmapai.php',
			root:'data',
			fields:[
				{name:'idturmapai', type:'int'},
				{name:'id_cod_turma', type:'int'},
				{name:'desnome'},
				{name:'idperiodo', type: 'int'},
				{name:'desperiodo'},
				{name:'descurso_sophia'},
				{name:'nmlogin'},
				{name:'instatus',type:'bit'},
				{name:'dtcadastro',type:'date',dateFormat:'timestamp'}
			]
		});
		
		var storelist_turmas = new Ext.data.JsonStore({
			url:PATH+'/json/list_turmas.php',
			root:'data', 
			fields:[
				{name:'CODIGO', type:'int'},
				{name:'TURMA'},
				{name:'desperiodo'}
			],
		});
		
		var storelist_turmapai_periodo = new Ext.data.JsonStore({
			url:PATH+'/json/list_turmapai_periodo.php',
			root:'data', 
			fields:[
				{name:'CODIGO', type:'int'},
				{name:'TURMA'},
				{name:'desperiodo'}
			],
		});
		
		var storelist_periodos_graduacao = new Ext.data.JsonStore({
			url:PATH+'/json/list_periodos_graduacao.php',
			root:'data', 
			fields:[
				{name:'CODIGO', type:'int'},
				{name:'DESCRICAO'}
			],
			autoLoad:true,
			listeners:{
				load:function($this, rec, opts){
					$.each(rec, function(){
						
						//Carrega a combo de períodos no período vigente a o mesmo carregando a grid 
						if(this.get('DESCRICAO').search(now.getFullYear()) != -1){
							if(this.get('DESCRICAO').search("/"+getPeriodo(now.getMonth())) != -1){
								
								xt('cmbperiodos').setValue(this.get('CODIGO')).setRawValue(this.get('DESCRICAO'));
								xt('cmbperiodosadd').setValue(this.get('CODIGO')).setRawValue(this.get('DESCRICAO'));
								
								loadGridsTurmaPai({
									idperiodo: this.get('CODIGO')
								});
							}
						}
					});
				}
			}
		});
/////////////////////// (ABA) NOTAS ALUNO/TURMA ////////////////////////

/////////////////////// (ABA) DOCUMENTOS SITE(FIT) ////////////////////	

/////////////////////// (ABA) TURMAS PAI //////////////////////////////
	////////////////CENTER
		var turmaspai_center_grid = new Ext.Panel({
			id:'idturmaspai_grid',
			region:'center',
			width:'100%',
			margins:'4 4 4 4',
			layout:'fit',
			tbar:[{
				xtype: 'button',
				text: 'Adicionar',
				icon: PATH+'/res/img/add.png',
				scale: 'medium',
                iconAlign: 'top',
				cls: 'padding: 5px;',
				width: 60,
				handler:function(){
					xt('idturmaspai_add').expand();
				}
			},'-',{
				xtype: 'button',
				text: 'Excluir',
				id:'btnexcluirturmapai',
				icon: PATH+'/res/img/remove.png',
				disabled: true,
				scale: 'medium',
                iconAlign: 'top',
				cls: 'padding: 5px;',
				width: 60,
				handler:function(){
					
					var $selections = Ext.getCmp('gridturmaspai').getSelectionModel().getSelections();
					var $arrObj_selections = [];
					
					ms.show({
						title:'Deseja desvincular estas turmas do PAI?',
						msg:'Obs: Os documentos e qualquer outra coisa relacionado a essas turmas PAI terão suas referências perdidas.',
						buttons: Ext.MessageBox.OKCANCEL,
						icon:Ext.MessageBox.QUESTION,
						fn:function(btn, a, b, c){
							
							if(btn=='ok'){
								Ext.MessageBox.alert('OK');
								
								if($selections.length > 0){
						
									$.each($selections, function(){
										$arrObj_selections.push({
											id_cod_turma:this.get('idturmapai')
										})
									});
									
									Ext.Ajax.request({
										url:PATH+'/ajax/delete_turmapai.php',
										params:{
											turmaspai: JSON.stringify($arrObj_selections)
										},
										success:function(resp){
											$myJson = Ext.util.JSON.decode(resp.responseText);
											
											if($myJson.success){
												ms.info('Aviso', $myJson.msg);
												
												loadGridsTurmaPai({
													idperiodo:xt('cmbperiodos').getValue()
												});
											}else{
												ms.erro('Erro', $myJson.msg);
											}
										}
									});
								}
							}
						}
					})
				}
			},'-','->',{
				xtype: 'buttongroup',
				title:'<b>Período</b>',
              	columns: 1,
            	defaults: {
                	scale: 'small'
            	},
            	items: [{
					xtype: 'combo',
					store: storelist_periodos_graduacao,
					valueField: 'CODIGO',
					displayField: 'DESCRICAO',
					typeAhead: true,
					mode: 'local',
					triggerAction: 'all',
					emptyText: 'Selecione o período.',
					selectOnFocus: true,
					id: 'cmbperiodos',
					width: 150,
					listeners:{
						'select': function(cmb, rec, index){
							
							loadGridsTurmaPai({
								idperiodo: rec.get('CODIGO')
							});
							
							xt('cmbperiodosadd').setValue(
								xt('cmbperiodos').getValue()
							).setRawValue(
								xt('cmbperiodos').getRawValue()
							);
						}
					}
            	}]	
			}],
			items:[{
				xtype:'grid',
				id:'gridturmaspai',
				store:storelist_turmapai,
				loadMask:true,
				stripeRows:true,
				autoScroll:true,
				border:false,
				height:458,
				viewConfig:{
					forceFit:true,
					getRowClass:function(record, rowIndex, rp, ds){
						/*var _class = record.get('instatus');
						if (!_class){
							return 'red';
						}else{
							return 'black';
						}*/
					}
				},
				sm: new Ext.grid.RowSelectionModel({
					singleSelect: false
				}),
				cm:new Ext.grid.ColumnModel({
					defaults: {
						sortable: true, 
						collapsible: true
					},
					columns:[new Ext.grid.RowNumberer({
						width:30,
						header:'nº',
					}),{ 
						header:'Cod. da Turma',
						id:'colvestibular',
						width:45,
						dataIndex:'id_cod_turma'
					},{
						header:'Sigla Turma',
						id:'coldesnome',
						width:40,
						dataIndex:'desnome'
					},{
						header:'Curso',
						id:'coldescurso_sophia',
						dataIndex:'descurso_sophia'
					},{
						header:'Período',
						id:'coldesperiodo',
						width:30,
						dataIndex:'desperiodo'
					},{
						header:'Cadastrado',
						id:'colnmlogin',
						width:35,
						dataIndex:'nmlogin'
					},{
						xtype:'datecolumn',
						header:'Data de Cadastro',
						id:'coldtcadastro',
						width:50,
						dataIndex:'dtcadastro',
						format:'d/m/Y h:i',
					},{
						header:'Status',
						id:'colinstatus',
						width:30,
						dataIndex:'instatus',
						renderer:fn_status
					}],
				}),
				listeners:{
					'rowclick':function(){
						if(xt('gridturmaspai').getSelectionModel().hasSelection()){
							xt('btnexcluirturmapai').enable();
						}else{
							xt('btnexcluirturmapai').disable();
						}
					}
				}
			}],
		});
		
	////////////////////EAST
		var turmaspai_east_add = new Ext.Panel({
			id:'idturmaspai_add', 
			region:'east',
			collapseMode:'mini',
			collapsed:true,
			split:true,
			width:'100%',
			layout:'fit',
			tbar:[{
				xtype: 'button',
				text: 'Voltar',
				id:'btnvoltarturmapai',
				icon: PATH+'/res/img/back.png',
				scale: 'medium',
                iconAlign: 'top',
				cls: 'padding: 5px;',
				width: 60,
				handler:function(){
					xt('idturmaspai_add').collapse();
				}
			}, '-'],
			items: [{
				xtype:'panel',
				layout:'hbox',
				padding: 10,
				items:[{
					xtype:'fieldset',
					title:'Filtrar Turmas PAI',
					flex:1,
					margins:'0 5 0 0',
					items:[{
						xtype: 'form',
						id:'formaddvestibular',
						border: false,
						buttonAlign:'left',
						defaults: {		
							anchor:'100%',		
							allowBlank:false,
							padding: 5
						},
						items: [{
							xtype: 'combo',
							fieldLabel:'Períodos',
							store: storelist_periodos_graduacao,
							valueField: 'CODIGO',
							displayField: 'DESCRICAO',
							typeAhead: true,
							mode: 'local',
							triggerAction: 'all',
							emptyText: 'Selecione o período.',
							selectOnFocus: true,
							id: 'cmbperiodosadd',
							listeners:{
								'select': function(cmb, rec, index){
									
									loadGridsTurmaPai({
										idperiodo: rec.get('CODIGO')
									});
									
									xt('cmbperiodos').setValue(
										xt('cmbperiodosadd').getValue()
									).setRawValue(
										xt('cmbperiodosadd').getRawValue()
									);
								}
							}
						}],
						buttons:[{
							hidden:true
						}]	
					},{ 
						xtype:'grid',
						title:'Turmas',
						id:'gridturmaadd',
						store:storelist_turmapai_periodo,
						loadMask:true,
						stripeRows:true,
						autoScroll:true,
						border:true,
						height:330,
						ddGroup:'turmasGridDDGroup', 
						enableDragDrop:true,
						style:'margin: 10px 0 5px 0',
						viewConfig:{
							forceFit:true
						},
						sm: new Ext.grid.RowSelectionModel({
							singleSelect: false
						}),
						cm:new Ext.grid.ColumnModel({
							defaults: {
								sortable: true, 
								collapsible: true
							},
							columns:[new Ext.grid.RowNumberer({
								width:30,
								header:'nº',
							}),{ 
								header:'Cod. da Turma',
								id:'colvestibularadd',
								width:50,
								dataIndex:'CODIGO'
							},{
								header:'Sigla Turma',
								id:'coldesnomedd',
								dataIndex:'TURMA'
							},{
								header:'Periodo',
								id:'coldesperiodoadd',
								dataIndex:'desperiodo'
							}]
						})
			
					}]
				},{
					xtype:'fieldset',
					title:'Vincular Turmas PAI',
					flex:3,
					items:[{
						xtype:'panel',
						layout:'fit',
						border:false,
						items:[{
							xtype:'grid',
							id:'gridturmaspaiadd',
							ddGroup:'gridlist_turmapaiDDGroup',
							store:storelist_turmapai,
							loadMask:true,
							stripeRows:true,
							autoScroll:true,
							border:false,
							height:380,
							viewConfig:{
								//forceFit:true
							},
							sm: new Ext.grid.RowSelectionModel({
								singleSelect: true
							}),
							cm:new Ext.grid.ColumnModel({
								defaults: {
									sortable: true, 
									collapsible: true
								},
								columns:[new Ext.grid.RowNumberer({
									width:30,
									header:'nº',
								}),{ 
									header:'Cod. da Turma',
									id:'colvestibularaddpai',
									width:90,
									dataIndex:'id_cod_turma'
								},{
									header:'Sigla Turma',
									id:'coldesnomeaddpai',
									width:120,
									dataIndex:'desnome'
								},{
									header:'Curso',
									id:'coldescurso_sophiaaddpai',
									width:350,
									dataIndex:'descurso_sophia'
								},{
									header:'Período',
									id:'coldesperiodoaddpai',
									width:100,
									dataIndex:'desperiodo'
								},{
									header:'Cadastrado',
									id:'colnmloginaddpai',
									width:120,
									dataIndex:'nmlogin'
								}]
							})
						}]
					}]
				}]
			}],
			listeners:{
				'expand':function(){
					//DRAGGABLE
					
					//Define a área para dropar os elementos
					var gridlist_turmapaiDropTargetEl =  xt('gridturmaspaiadd').getView().scroller.dom;
					var gridlist_turmasDropTarget = new Ext.dd.DropTarget(gridlist_turmapaiDropTargetEl, {
						ddGroup    : 'turmasGridDDGroup',
						notifyDrop : function(ddSource, e, data){
							var data = data;
							var records =  ddSource.dragData.selections;
							var arrObj_turmas = [];
							//var sel = Miku.selected('grid_manuais');
							Ext.each(records, ddSource.grid.store.remove, ddSource.grid.store);
							//gridlist_turmas.store.add(records); adiciona os recs à area de drop
							Ext.each(data.selections, function(data, index){
							
								arrObj_turmas.push({
									idperiodo: xt('cmbperiodosadd').getValue(),
									id_cod_turma: data.get('CODIGO')
								});
							});
							
							Ext.Ajax.request({
								url:PATH+"/ajax/save_turmapai.php",
								params:{
									turmaspai: JSON.stringify(arrObj_turmas)
								},
								success: function(response){
									$myJson = Ext.util.JSON.decode(response.responseText);
									
									if($myJson.success){
										ms.info('Vinculado com sucesso!', $myJson.msg);
										
										storelist_turmapai.reload({
											params:{
												idperiodo:xt('cmbperiodosadd').getValue()
											},
										});	
									}else{
										ms.info('Turma(s) não vinculada(s)!', $myJson.msg);
										
										storelist_turmapai_periodo.reload({
											params:{
												idperiodo: xt('cmbperiodosadd').getValue()
											}
										});
									}
								}
							});
							//ordena a tabela a ser dropada
							//gridlist_turmas.store.sort('CODIGO', 'ASC');
							return true;
						}
					});
				}
			}
		});	
/////////////////////// MAIN WINDOW ///////////////////////////////////
		new Ext.Window({
			title:'Administrativo de Turmas PAI (SOPHIA)',
			id:'idwinadmturmaspai',
			iconCls:'ico_file',
			width:Page.width-100,
			height:553,
			layout:'border',
			items:[{
				xtype:'panel',
				region: 'center',
				margins:'2 2 2 2',
				border:false,
				layout:'fit',
				items:[{
					xtype:'tabpanel',
					margins:'2 2 2 2', 
					activeTab: 0,
					tabPosition:'bottom',
					items:[{
						title: 'Turmas PAI',
						layout: 'border',	
						items:[turmaspai_center_grid, turmaspai_east_add],
					},{
						title: 'Documentos Site(FIT)',
						//layout: 'border',	
					//	items:[documentos_center_grid/*,documentos_east_grid*/]
					},{
						title: 'Notas Aluno/Turma',
						//layout: 'border',	
						//items:[alunosaprovados_grid,alunosaprovados_add]
					}]
				}]		
			}],		
		}).show();
	});
</script>