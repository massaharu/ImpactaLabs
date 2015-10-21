<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 
topopagina('setup_tutorial.png ','ADM. Vestibular Aprovados/Reprovados (FIT) ');
?>
<script type="text/javascript">

	
Ext.onReady(function(){		
	var storevestibularbyinstatus = new Ext.data.JsonStore({
		url:'/simpacweb/modulos/fit/adm_vestibular-resultados/json/vestibularbyinstatus_list.php',
		root:'myData',
		fields:[{name:'desvestibular', type:'string'},
				{name:'idvestibular', type:'int'},
				{name:'instatus',type:'bit'},
				{name:'dtinicio',type:'date',dateFormat:'timestamp'},
				{name:'dttermino',type:'date',dateFormat:'timestamp'},
				{name:'dtcadasdtro',type:'date',dateFormat:'timestamp'},
				{name:'dataformatada',type:'string'}],
		//autoLoad:true
	});
	
	var storevestibular = new Ext.data.JsonStore({
		url:'/simpacweb/modulos/fit/adm_vestibular-resultados/json/vestibular_list.php',
		root:'myData',
		fields:[{name:'desvestibular', type:'string'},
				{name:'idvestibular', type:'int'},
				{name:'instatus',type:'bit'},
				{name:'dtinicio',type:'date',dateFormat:'timestamp'},
				{name:'dttermino',type:'date',dateFormat:'timestamp'},
				{name:'dtsemestre',type:'string'},
				{name:'dtcadasdtro',type:'date',dateFormat:'timestamp'},
				{name:'dataformatada',type:'string'}],
		//autoLoad:true
	});
	
	var groupingStorealunosaprovados = new Ext.data.GroupingStore({
            reader: new Ext.data.JsonReader({
                root: 'myData',
                fields: [{name:'desvestibular', type:'string'},
				{name:'idvestibular', type:'int'},
				{name:'desnome',type:'string'},
				{name:'descurso',type:'string'},
				{name:'desempresa',type:'string'},
				{name:'isprimeirolugar',type:'bit'},
				{name:'instatus',type:'bit'},
				{name:'alunoaprovado_instatus',type:'bit'},
				{name:'dtcadastro',type:'date',dateFormat:'timestamp'},
				{name:'idvestibular_aprovados',type:'int'},
				{name:'desvestibularId',type:'string'}],
            }),
            url: '/simpacweb/modulos/fit/adm_vestibular-resultados/json/alunosaprovados_list.php',
           // autoLoad: true,
            sortInfo: {field: 'isprimeirolugar',direction: "DESC"},			
            groupField: 'desvestibularId',
			
        });
	
	var groupingStorealunosreprovados = new Ext.data.GroupingStore({
            reader: new Ext.data.JsonReader({
                root: 'myData',
                fields: [{name:'desvestibular', type:'string'},
				{name:'idvestibular', type:'int'},
				{name:'desnome',type:'string'},
				{name:'descurso',type:'string'},
				{name:'desempresa',type:'string'},
				{name:'instatus',type:'bit'},
				{name:'alunoreprovado_instatus',type:'bit'},
				{name:'idvestibular_reprovados',type:'int'},
				{name:'dtcadastro',type:'date',dateFormat:'timestamp'},
				{name:'desvestibularId',type:'string'}],
            }),
            url: '/simpacweb/modulos/fit/adm_vestibular-resultados/json/alunosreprovados_list.php',
            //autoLoad: true,
            sortInfo: {field: 'desnome',direction: "DESC"},			
            groupField: 'desvestibularId',			
        });
	
	var arrayStoreSearch = new Ext.data.ArrayStore({
		fields:[{name:'search',type:'string'},
				{name: 'idsearch',type:'int'}],
		data:[['Alunos',1],
			  ['Cargo',2],
			  ['Empresa',3],
			  ['Status',5],
			  ['Vestibular',6]]
	});


	
	function fn_eptValueCursoApr(value, metaData, record){
		if(record.data.descurso == ""){
			value = 'N/A';
		}
		if (record.data.alunoaprovado_instatus != 1) {
			metaData.attr = "style='color:red;'";
		}
		return value;
	}
	function fn_eptValueEmpApr(value, metaData, record){
		if(record.data.desempresa == ""){
			value = 'N/A';
		}
		if (record.data.alunoaprovado_instatus != 1) {
			metaData.attr = "style='color:red;'";
		}
		return value;
	}
	
	function fn_eptValueCursoRep(value, metaData, record){
		if(record.data.descurso == ""){
			value = 'N/A';
		}
		if (record.data.alunoreprovado_instatus != 1) {
			metaData.attr = "style='color:red;'";
		}
		return value;
	}
	function fn_eptValueEmpRep(value, metaData, record){
		if(record.data.desempresa == ""){
			value = 'N/A';
		}
		if (record.data.alunoreprovado_instatus != 1) {
			metaData.attr = "style='color:red;'";
		}
		return value;
	}
	
	function fn_statuscolorApr(value, metaData, record){
		if (record.data.alunoaprovado_instatus != 1) {
			metaData.attr = "style='color:red;'";
		}
		return value;
	}
	
	function fn_statuscolorRep(value, metaData, record){
		if (record.data.alunoreprovado_instatus != 1) {
			metaData.attr = "style='color:red;'";
		}
		return value;
	}
	
	function fn_status(v){	
		if(v == true){
			return '<img src="/simpacweb/images/ico/16/accept.png"/>';
		}else{
			return '<img src="/simpacweb/images/ico/16/remove.png"/>';
		}														  
	}
	
	function fn_isprimeirolugar(value, metaData, record){	
		if(value == true){
			return '<img src="/simpacweb/images/ico/16/star_on.png"/>';
		}else{
			return '<img src="/simpacweb/images/ico/16/star_off.png"/>';
		}														  
	}
	
	function fn_searchrep(comboValue){
		if(comboValue == 6){
			Ext.getCmp('idcomboSearchRep2').show();
			Ext.getCmp('idstat0Rep').hide();
			Ext.getCmp('idstat1Rep').hide();
			Ext.getCmp('filterReprovado').hide();
		}else if(comboValue == 5){
			Ext.getCmp('idstat0Rep').show();
			Ext.getCmp('idstat1Rep').show();
			Ext.getCmp('filterReprovado').hide();
			Ext.getCmp('idcomboSearchRep2').hide();
		}else{
			Ext.getCmp('filterReprovado').show();
			Ext.getCmp('idstat0Rep').hide();
			Ext.getCmp('idstat1Rep').hide();
			Ext.getCmp('idcomboSearchRep2').hide();
		}
	}
	
	function fn_searchapr(comboValue){
		if(comboValue == 6){
			Ext.getCmp('idcombosearchApr2').show();
			Ext.getCmp('idstat0Apr').hide();
			Ext.getCmp('idstat1Apr').hide();
			Ext.getCmp('filterAprovado').hide();
		}else if(comboValue == 5){
			Ext.getCmp('idstat0Apr').show();
			Ext.getCmp('idstat1Apr').show();
			Ext.getCmp('filterAprovado').hide();
			Ext.getCmp('idcombosearchApr2').hide();
		}else{
			Ext.getCmp('filterAprovado').show();
			Ext.getCmp('idstat0Apr').hide();
			Ext.getCmp('idstat1Apr').hide();
			Ext.getCmp('idcombosearchApr2').hide();
		}
	}
	
	var a = false;
	var b = false;
	var c = false;
	
	var data = new Date();
//==============ALUNOS REPROVADOS============================================================================================================================================
	var alunosreprovados_grid = new Ext.Panel({
		id:'idalunosreprovados_grid',
		region:'center',
		margins:'4 4 4 4',
		width:'100%',
		layout:'fit',
		listeners:{
			'activate':function(){
				groupingStorealunosreprovados.load();
			}
		},
		tbar:[{
			text:' Alterar Status',
			id:'btnstatusalunoreprovado',
			iconCls:'ico_arrow_rotate_clockwise',
			disabled:true,
			handler:function(){		
				var rec = Ext.getCmp('gridalunosreprovados').getSelectionModel().getSelected();
				var status = (!rec.get('alunoreprovado_instatus'));
				Ext.Ajax.request({
					url:'/simpacweb/modulos/fit/adm_vestibular-resultados/ajax/alunoreprovado_instatus.php',
					params:{											
						idvestibular_reprovados:Ext.getCmp('gridalunosreprovados').getSelectionModel().getSelected().get('idvestibular_reprovados')
					},
					success:function(){
						rec.set('alunoreprovado_instatus', status);
						rec.commit();
					}
				})
			}
		},'-',{
			text:'Desagrupar',
			id:'btngroupreprovados',
			iconCls: 'ico_arrow_out',
			enableToggle:true,
			toggleHandler: function(button,state){
				if (state == true) {
					groupingStorealunosreprovados.clearGrouping();
					Ext.getCmp('btngroupreprovados').setText('Agrupar');	
					Ext.getCmp('btngroupreprovados').setIconClass('ico_arrow_in');	
				} else {
					groupingStorealunosreprovados.groupBy('desvestibularId');
					Ext.getCmp('btngroupreprovados').setText('Desagrupar');	
					Ext.getCmp('btngroupreprovados').setIconClass('ico_arrow_out');	
				}
			}
		}],
		items:[{
			xtype:'editorgrid',
			id:'gridalunosreprovados',
			store:groupingStorealunosreprovados,
			loadMask:true,
			stripeRows:true,
			autoScroll:true,
			border:false,
			height:458,
			viewConfig:{
				 forceFit:true,
			 },
			sm: new Ext.grid.RowSelectionModel({
			 singleSelect: true,
			}),
			cm:new Ext.grid.ColumnModel({
				columns:[new Ext.grid.RowNumberer({
					width:30,
					header:'nº',
				}),{ 
					header:'',
					id:'hdidvestibularalunosreprovados',
					hidden:true,
					dataIndex:'desvestibularId',
				},{ 
					header:'Alunos Reprovados',
					id:'hdalunosreprovados',
					sortable:true,
					dataIndex:'desnome',
					renderer:fn_statuscolorRep,
					editor: new Ext.form.TextField({
						AllowBlank: false,							  
					})
				},{ 
					header:'Cargo',
					id:'hddescurso',
					sortable:true,
					dataIndex:'descurso',
					renderer:fn_eptValueCursoRep,
					editor: new Ext.form.TextField({
						AllowBlank: false,							  
					})
				},{ 
					header:'Empresa',
					id:'hdempresa',
					sortable:true,
					dataIndex:'desempresa',
					renderer:fn_eptValueEmpRep,
					editor: new Ext.form.TextField({
						AllowBlank: false,							  
					})
				},{
					xtype:'datecolumn',
					header:'Data de Cadastro',
					id:'hddtcadastro',
					width:50,
					sortable:true,
					dataIndex:'dtcadastro',
					format:'d/m/Y h:i',
					editor: new Ext.form.TextField({
						AllowBlank: false,							  
					})
				},{
					header:'Status',
					id:'statuslist',
					width:20,
					sortable:true,
					dataIndex:'alunoreprovado_instatus',
					renderer:fn_status
				}],
			}),
			view: new Ext.grid.GroupingView({
				id:'groupalunosreprovados',
				forceFit:true,
				showGroupName: true,
				enableNoGroups: true,
				enableGroupingMenu: false,
				//hideGroupedColumn: true,
				startCollapsed: true,
				groupTextTpl: '{text}({[values.rs.length]} {[values.rs.length > 1 ? "Alunos" : "Aluno"]})'
				
			}),
			listeners:{
				afteredit: function(e){	
					Ext.Ajax.request({ 
						url:'/simpacweb/modulos/fit/adm_vestibular-resultados/ajax/alunoreprovado_update.php',
							  params:{
								 idvestibular:e.record.get('idvestibular'),
								 idvestibular_reprovados:e.record.get('idvestibular_reprovados'),
								 desnome:e.record.get('desnome'),
								 descurso:e.record.get('descurso'),
								 desempresa:e.record.get('desempresa')
							  },			
							  success:function(){
								 e.record.commit();
							}
						});	
					},
				'click':function(){
					if(Ext.getCmp('gridalunosreprovados').getSelectionModel().getSelected()){
						Ext.getCmp('btnstatusalunoreprovado').enable();
						Ext.getCmp('btnremovereprovados').enable();
					}else{
						Ext.getCmp('btnstatusalunoreprovado').disable();
						Ext.getCmp('btnremovereprovados').disable();
					}
				}
			},
			bbar:[{
				text:'Adicionar',
				iconCls:'ico_add',
				handler:function(){
					setTimeout(
						function(){
							Ext.getCmp('alunosreprovados_add').expand()
						},250
					);
				}
			},'-',{
				text:'Deletar',
				id:'btnremovereprovados',
				iconCls:'ico_delete',
				disabled:true,
				handler:function(){
					if(!Ext.getCmp('gridalunosreprovados').getSelectionModel().getSelected()){
							Ext.MessageBox.erro('Aviso!', 'Por favor, você deve selecionar um aluno para deletar.');
					}else{					
						Ext.MessageBox.confirm('Confirmação', 'Deseja deletar '+Ext.getCmp('gridalunosreprovados').getSelectionModel().getSelected().get('desnome')+' ?',
						function(btn){
							if(btn=='yes'){
								Ext.Ajax.request({
									url: '/simpacweb/modulos/fit/adm_vestibular-resultados/ajax/alunoreprovado_delete.php',
									params:{ 
										idvestibular_reprovados:Ext.getCmp('gridalunosreprovados').getSelectionModel().getSelected().get('idvestibular_reprovados'),
									},
									success:function(){
										Ext.getCmp('gridalunosreprovados').getStore().reload({
											callback:function(){
												Ext.MessageBox.info('','Aluno deletado!');	
											}	
										});
									},
								});
							}
						});									
					}
				}
			},'-',{
				iconCls:'ico_Down',
				tooltip:"Esconder janela",
				handler:function(){
					Ext.getCmp('alunosreprovados_add').collapse();
				}
			},'->',{
				xtype:'label',
				text:'Filtrar por: ',
				style:'margin:0 5px; font-weight: bold;'
			},{
				xtype:'combo',
				id:'idcombosearchRep',
				autoHeight:true,
				typeAhead: true,
				triggerAction: 'all',
				lazyRender:true,
				mode: 'local',
				emptyText:'Pesquisar...',
				store: arrayStoreSearch,
				valueField: 'idsearch',
				displayField: 'search',
				listeners:{
					change:function(){
						comboValue = Ext.getCmp('idcombosearchRep').getValue();
						Ext.getCmp('filterReprovado').reset();
						fn_searchrep(comboValue);
					},
					select:function(){
						comboValue = Ext.getCmp('idcombosearchRep').getValue();
						Ext.getCmp('filterReprovado').reset();
						fn_searchrep(comboValue);
					},
				}
			},{
				xtype:'textfield',
				hidden:true,
				id:'filterReprovado', 
				style:'margin-left:6px;',
				width:((Page.width/5)),
				emptyText:'Texto a ser pesquisado',
				listeners:{
					'valid':function(){
						switch(comboValue){
							case 1:groupingStorealunosreprovados.filter('desnome', this.getValue(), true, false);break;
							case 2:groupingStorealunosreprovados.filter('descurso', this.getValue(), true, false);break;
							case 3:groupingStorealunosreprovados.filter('desempresa', this.getValue(), true, false);
						}
					}
				}
			},{
				xtype:'combo',
				id:'idcomboSearchRep2',
				hidden:true,
				autoHeight:true,
				store:storevestibularbyinstatus,
				displayField:'dataformatada',
				valueField:'idvestibular',
				typeAhead:true,
				triggerAction:'all',
				lazyRender:true,
				allowBlank:false,
				emptyText:'Selecione um vestibular...',
				listeners:{
					'valid':function(){
						groupingStorealunosreprovados.filter('desvestibularId', this.getValue(), true, false);
					}
				}
			},{
				text:'',
				hidden:true,
				id:'idstat0Rep',
				tooltip:'Filtrar pelos Desativados',
				iconCls:'ico_remove',
				listeners:{
					'click':function(){
						groupingStorealunosreprovados.filter('alunoreprovado_instatus', false, true, false);
					}
				}
			},{
				text:'',
				hidden:true,
				id:'idstat1Rep',
				tooltip:'Filtrar pelos Ativados',
				iconCls:'ico_accept',
				listeners:{
					'click':function(){
						groupingStorealunosreprovados.filter('alunoreprovado_instatus', true, true, false);
					}
				}
			}],
		}]
	});	
	
	var alunosreprovados_add = new Ext.Panel({
		id:'alunosreprovados_add', 
		title:'Adicionar alunos reprovados',
		iconCls:'ico_adicionar',
		region:'south',
		margins:'4 4 4 4',
		split:true,
		collapseMode:'mini',
		collapsible: true,
		collapsed:true,
		height:180,
		width:'100%',
		border:true,
		layout:'fit',
		tbar:[{
			xtype:'combo',
			id:'combo_vestibularreprovados',
			width:300,
			autoHeight:true,
			store:storevestibularbyinstatus,
			displayField:'dataformatada',
			valueField:'idvestibular',
			typeAhead:true,
			triggerAction:'all',
			lazyRender:true,
			name:'desdtinicio',
			allowBlank:false,
			emptyText:'Selecione um vestibular...',
		}],
		items: [{
			xtype: 'form',
			id:'formaddalunoreprovado',
			padding: 5,
			border: false,
			buttonAlign:'left',
			defaults: {
				xtype: 'textfield',
				width: 100,
				padding: 5
			},
			items: [{
				fieldLabel: 'Aluno',
				id:'tfalunoreprovado',
				name:'alunoreprovado',
				allowBlank:false,
				anchor:'100%',
			}, {
				fieldLabel: 'Cargo',
				name:'alunoreprovadocargo',
				anchor:'100%',
			}, {
				fieldLabel: 'Empresa',
				name:'alunoreprovadoempresa',
				anchor:'100%',
			}],
			buttons:[{
				text:'Adicionar',
				iconCls:'ico_adicionar',
				handler:function(){
					if(Ext.getCmp('formaddalunoreprovado').getForm().isValid() && Ext.getCmp('combo_vestibularreprovados').isValid()){
						Ext.getCmp('formaddalunoreprovado').getForm().submit({
							url:'/simpacweb/modulos/fit/adm_vestibular-resultados/ajax/alunoreprovado_save.php',
							params:{
								idvestibular:Ext.getCmp('combo_vestibularreprovados').getValue(),
							},
						success:function(){
								Ext.getCmp('gridalunosreprovados').getStore().reload({
									callback:function(){
										Ext.MessageBox.info('',Ext.getCmp('tfalunoreprovado').getValue()+' Adicionado!',function(btnok){
											if(btnok == 'ok'){
												Ext.getCmp('formaddalunoreprovado').getForm().reset();
											}
										});	
									}	
								});
							}
						})
					}else{
						Ext.MessageBox.warning('Aviso!','Preecha o nome do Aluno e escolha um Vestibular.')
					}
				}
			}]			
		}]
	});	
//==============ALUNOS APROVADOS============================================================================================================================================
				 
	var alunosaprovados_grid= new Ext.Panel({
		id:'idalunosaprovados_grid',
		region:'center',
		width:'100%',
		margins:'4 4 4 4',
		layout:'fit',		
		tbar:[{
			text:' Alterar Status',
			id:'btnstatusalunoaprovado',
			iconCls:'ico_arrow_rotate_clockwise',
			disabled:true,
			handler:function(){		
				var rec = Ext.getCmp('gridalunosaprovados').getSelectionModel().getSelected();
				var status = (!rec.get('alunoaprovado_instatus'));
				Ext.Ajax.request({
					url:'/simpacweb/modulos/fit/adm_vestibular-resultados/ajax/alunoaprovado_instatus.php',
					params:{											
						idvestibular_aprovados:Ext.getCmp('gridalunosaprovados').getSelectionModel().getSelected().get('idvestibular_aprovados')
					},
					success:function(){
						rec.set('alunoaprovado_instatus', status);
						rec.commit();
					}
				})
			}
		},'-',{
			text:'Primeiro',
			id:'btnisprimeiro',
			iconCls:'ico_star',
			disabled:true,
			handler:function(){
				var selected = Miku.selected('gridalunosaprovados');
				var arrayList = new Array();
				var flag_found_first = false;
				if(selected){
					Ext.each(groupingStorealunosaprovados.data.items,function(a,b){
						if(selected.data.idvestibular == a.data.idvestibular){													  
							var object = {
								isprimeirolugar: a.data.isprimeirolugar,
								idvestibular: a.data.idvestibular
							}
							arrayList.push(object);
						}
					});					
					for(x in arrayList){
						if(typeof(arrayList[x]) ==  'object'){
							if(arrayList[x].isprimeirolugar == false){
								if(!flag_found_first){
									flag_found_first = false;	
								}
							}else{
								flag_found_first = true;
								break;
							}
						}
					}
					if(!flag_found_first){
						//console.log("Não tem first");
						var rec = Ext.getCmp('gridalunosaprovados').getSelectionModel().getSelected();
						var status = (!rec.get('isprimeirolugar'));
						Ext.Ajax.request({
							url:'/simpacweb/modulos/fit/adm_vestibular-resultados/ajax/alunoaprovado_isprimeirolugar.php',
							params:{											
								idvestibular_aprovados:Ext.getCmp('gridalunosaprovados').getSelectionModel().getSelected().get('idvestibular_aprovados'),
								idvestibular:Ext.getCmp('gridalunosaprovados').getSelectionModel().getSelected().get('idvestibular')
							},
							success:function(){
								rec.set('isprimeirolugar', status);
								rec.commit();
							}
						})
					}else{
						//console.log("Já tem first");
						   if(Ext.getCmp('gridalunosaprovados').getSelectionModel().getSelected().get('isprimeirolugar')==true){
							var rec = Ext.getCmp('gridalunosaprovados').getSelectionModel().getSelected();
							var status = (!rec.get('isprimeirolugar'));
							Ext.Ajax.request({
								url:'/simpacweb/modulos/fit/adm_vestibular-resultados/ajax/alunoaprovado_isprimeirolugar.php',
								params:{											
									idvestibular_aprovados:Ext.getCmp('gridalunosaprovados').getSelectionModel().getSelected().get('idvestibular_aprovados'),
									idvestibular:Ext.getCmp('gridalunosaprovados').getSelectionModel().getSelected().get('idvestibular')
								},
								success:function(){
									rec.set('isprimeirolugar', status);
									rec.commit();
								}
							})
						}else{		
							Ext.MessageBox.info('Aviso','Já existe um primeiro lugar. Deselecione-o para escolher outro.');
						}
					}
				}
			}
		},'-',{			
			text:'Desagrupar',
			id:'btngroupaprovados',
			iconCls: 'ico_arrow_out',
			enableToggle:true,
			toggleHandler: function(button,state){
				if (state == true) {
					groupingStorealunosaprovados.clearGrouping();
					Ext.getCmp('btngroupaprovados').setText('Agrupar');	
					Ext.getCmp('btngroupaprovados').setIconClass('ico_arrow_in');	
				} else {
					groupingStorealunosaprovados.groupBy('desvestibularId');
					Ext.getCmp('btngroupaprovados').setText('Desagrupar');	
					Ext.getCmp('btngroupaprovados').setIconClass('ico_arrow_out');	
				}
			}						
		}],
		items:[{
			xtype:'editorgrid',
			id:'gridalunosaprovados',
			store:groupingStorealunosaprovados,
			loadMask:true,
			stripeRows:true,
			autoScroll:true,
			border:false,
			height:458,
			viewConfig:{
				 forceFit:true,
			 },
			sm: new Ext.grid.RowSelectionModel({
			 singleSelect: true,
			}),
			cm:new Ext.grid.ColumnModel({
				columns:[new Ext.grid.RowNumberer({
					width:30,
					header:'nº',
				}),{
					header:'1º Lugar',
					id:'primeirolugar',
					width:30,
					sortable:true,
					dataIndex:'isprimeirolugar',
					renderer:fn_isprimeirolugar
				},{ 
					header:'',
					id:'hddesvestibularId',
					hidden:true,
					dataIndex:'desvestibularId',
				},{ 
					header:'Alunos Aprovados',
					id:'hdalunosaprovados',
					sortable:true,
					dataIndex:'desnome',
					renderer:fn_statuscolorApr,
					editor: new Ext.form.TextField({
						AllowBlank: false,							  
					})
				},{ 
					header:'Cargo',
					id:'hddescurso',
					sortable:true,
					dataIndex:'descurso',
					renderer:fn_eptValueCursoApr,
					editor: new Ext.form.TextField({
						AllowBlank: false,							  
					})
				},{ 
					header:'Empresa',
					id:'hdempresa',
					sortable:true,
					dataIndex:'desempresa',
					renderer:fn_eptValueEmpApr,
					editor: new Ext.form.TextField({
						AllowBlank: false,							  
					})
				},{
					xtype:'datecolumn',
					header:'Data de Cadastro',
					id:'hddtcadastro',
					width:50,
					sortable:true,
					dataIndex:'dtcadastro',
					format:'d/m/Y h:i',
				},{
					header:'Status',
					id:'statuslist',
					width:20,
					sortable:true,
					dataIndex:'alunoaprovado_instatus',
					renderer:fn_status
				}],
			}),
			view: new Ext.grid.GroupingView({
				id:'groupalunosaprovados',
				forceFit:true,
				showGroupName: true,
				enableNoGroups: true,
				enableGroupingMenu: false,
				//hideGroupedColumn: true,
				startCollapsed: true,
				groupTextTpl: '{text}({[values.rs.length]} {[values.rs.length > 1 ? "Alunos" : "Aluno"]})'
				
			}),
			listeners:{
				afteredit: function(e){	
					Ext.Ajax.request({ 
						url:'/simpacweb/modulos/fit/adm_vestibular-resultados/ajax/alunoaprovado_update.php',
							  params:{
								 idvestibular:e.record.get('idvestibular'),
								 idvestibular_aprovados:e.record.get('idvestibular_aprovados'),
								 desnome:e.record.get('desnome'),
								 descurso:e.record.get('descurso'),
								 desempresa:e.record.get('desempresa')
							  },			
							  success:function(){
								 e.record.commit();
							}
						});	
					},
				'click':function(){
					if(Ext.getCmp('gridalunosaprovados').getSelectionModel().getSelected()){
						Ext.getCmp('btnstatusalunoaprovado').enable();
						Ext.getCmp('btnremoveaprovados').enable();
						Ext.getCmp('btnisprimeiro').enable();
					}else{
						Ext.getCmp('btnstatusalunoaprovado').disable();
						Ext.getCmp('btnremoveaprovados').disable();
						Ext.getCmp('btnisprimeiro').disable();
					}
				}
			},
			bbar:[{
				text:'Adicionar',
				iconCls:'ico_add',
				handler:function(){
					setTimeout(
						function(){
							Ext.getCmp('idalunosaprovados_add').expand()
						},250
					);
				}
			},'-',{
				text:'Deletar',
				id:'btnremoveaprovados',
				iconCls:'ico_delete',
				disabled:true,
				handler:function(){
					if(!Ext.getCmp('gridalunosaprovados').getSelectionModel().getSelected()){
							Ext.MessageBox.erro('Aviso!', 'Por favor, você deve selecionar um aluno para deletar.');
					}else{					
						Ext.MessageBox.confirm('Confirmação', 'Deseja deletar '+Ext.getCmp('gridalunosaprovados').getSelectionModel().getSelected().get('desnome')+' ?',
						function(btn){
							if(btn=='yes'){
								Ext.Ajax.request({
									url: '/simpacweb/modulos/fit/adm_vestibular-resultados/ajax/alunoaprovado_delete.php',
									params:{ 
										idvestibular_aprovados:Ext.getCmp('gridalunosaprovados').getSelectionModel().getSelected().get('idvestibular_aprovados'),
									},
									success:function(){
										Ext.getCmp('gridalunosaprovados').getStore().reload({
											callback:function(){
												Ext.MessageBox.info('','Aluno deletado!');	
											}	
										});
									},
								});
							}
						});									
					}
				}
			},'-',{
				iconCls:'ico_Down',
				tooltip:"Esconder janela",
				handler:function(){
					Ext.getCmp('idalunosaprovados_add').collapse();
				}
			},'->',{
				xtype:'label',
				text:'Filtrar por: ',
				style:'margin:0 5px; font-weight: bold;'
			},{
				xtype:'combo',
				id:'idcombosearchApr',
				autoHeight:true,
				typeAhead: true,
				triggerAction: 'all',
				lazyRender:true,
				mode: 'local',
				emptyText:'Pesquisar...',
				store: arrayStoreSearch,
				valueField: 'idsearch',
				displayField: 'search',
				listeners:{
					change:function(){
						comboValue = Ext.getCmp('idcombosearchApr').getValue();
						Ext.getCmp('filterAprovado').reset();
						fn_searchapr(comboValue);
					},
					select:function(){
						comboValue = Ext.getCmp('idcombosearchApr').getValue();
						Ext.getCmp('filterAprovado').reset();
						fn_searchapr(comboValue);
					},
				}
			},{
				xtype:'textfield',
				hidden:true,
				id:'filterAprovado', 
				style:'margin-left:6px;',
				width:((Page.width/5)),
				emptyText:'Texto a ser pesquisado',
				listeners:{
					'valid':function(){
						switch(comboValue){
							case 1:groupingStorealunosaprovados.filter('desnome', this.getValue(), true, false);break;
							case 2:groupingStorealunosaprovados.filter('descurso', this.getValue(), true, false);break;
							case 3:groupingStorealunosaprovados.filter('desempresa', this.getValue(), true, false);
						}
					}
				}
			},{
				xtype:'combo',
				id:'idcombosearchApr2',
				hidden:true,
				autoHeight:true,
				store:storevestibularbyinstatus,
				displayField:'dataformatada',
				valueField:'idvestibular',
				typeAhead:true,
				triggerAction:'all',
				lazyRender:true,
				allowBlank:false,
				emptyText:'Selecione um vestibular...',
				listeners:{
					'valid':function(){
						groupingStorealunosaprovados.filter('desvestibularId', this.getValue(), true, false);
					}
				}
			},{
				text:'',
				hidden:true,
				id:'idstat0Apr',
				tooltip:'Filtrar pelos Desativados',
				iconCls:'ico_remove',
				listeners:{
					'click':function(){
						groupingStorealunosaprovados.filter('alunoaprovado_instatus', false, true, false);
					}
				}
			},{
				text:'',
				hidden:true,
				id:'idstat1Apr',
				tooltip:'Filtrar pelos Ativados',
				iconCls:'ico_accept',
				listeners:{
					'click':function(){
						groupingStorealunosaprovados.filter('alunoaprovado_instatus', true, true, false);
					}
				}
			}],
		}]
	});
	
	var alunosaprovados_add = new Ext.Panel({
		id:'idalunosaprovados_add', 
		title:'Adicionar alunos aprovados',
		iconCls:'ico_adicionar',
		region:'south',
		margins:'4 4 4 4',
		split:true,
		collapseMode:'mini',
		collapsible: true,
		collapsed:true,
		height:180,
		width:'100%',
		border:true,
		layout:'fit',
		tbar:[{
			xtype:'combo',
			id:'combo_vestibularaprovados',
			width:300,
			autoHeight:true,
			store:storevestibularbyinstatus,
			displayField:'dataformatada',
			valueField:'idvestibular',
			typeAhead:true,
			triggerAction:'all',
			lazyRender:true,
			name:'desdtinicio',
			allowBlank:false,
			emptyText:'Selecione um vestibular...',
		}],
		items: [{
			xtype: 'form',
			id:'formaddalunoaprovado',
			padding: 5,
			border: false,
			buttonAlign:'left',
			defaults: {
				xtype: 'textfield',
				width: 100,
				padding: 5
			},
			items: [{
				fieldLabel: 'Aluno',
				id:'tfalunoaprovado',
				name:'alunoaprovado',
				allowBlank:false,
				anchor:'100%',
			}, {
				fieldLabel: 'Cargo',
				name:'alunoaprovadocargo',
				anchor:'100%',
			}, {
				fieldLabel: 'Empresa',
				name:'alunoaprovadoempresa',
				anchor:'100%',
			}],
			buttons:[{
				text:'Adicionar',
				iconCls:'ico_adicionar',
				handler:function(){
					if(Ext.getCmp('formaddalunoaprovado').getForm().isValid() && Ext.getCmp('combo_vestibularaprovados').isValid()){
						Ext.getCmp('formaddalunoaprovado').getForm().submit({
							url:'/simpacweb/modulos/fit/adm_vestibular-resultados/ajax/alunoaprovado_save.php',
							params:{
								idvestibular:Ext.getCmp('combo_vestibularaprovados').getValue(),
							},
						success:function(){
								Ext.getCmp('gridalunosaprovados').getStore().reload({
									callback:function(){
										Ext.MessageBox.info('',Ext.getCmp('tfalunoaprovado').getValue()+' Adicionado!',function(btnok){
											if(btnok == 'ok'){
												Ext.getCmp('formaddalunoaprovado').getForm().reset();
											}
										});	
									}	
								});
							}
						})
					}else{
						Ext.MessageBox.warning('Aviso!','Preecha o nome do Aluno e escolha um Vestibular.')
					}
				}
			}]			
		}]
	});	
//==============VESTIBULARES=============================================================================================
	var vestibulares_grid = new Ext.Panel({
		id:'idvestibulares_grid',
		region:'center',
		width:'100%',
		margins:'4 4 4 4',
		layout:'fit',
		tbar:[{
			text:'Alterar Status',
			id:'btnstatusvestibular',
			iconCls:'ico_arrow_rotate_clockwise',
			disabled:true,
			handler:function(){		
				var rec = Ext.getCmp('gridvestibulares').getSelectionModel().getSelected();
				var status = (!rec.get('instatus'));
				Ext.Ajax.request({
					url:'/simpacweb/modulos/fit/adm_vestibular-resultados/ajax/vestibular_instatus.php',
					params:{											
						idvestibular:Ext.getCmp('gridvestibulares').getSelectionModel().getSelected().get('idvestibular')
					},
					success:function(){
						//storevestibular.reload();
						rec.set('instatus', status);
						rec.commit();
					}
				})
			}
		}],
		items:[{
			xtype:'editorgrid',
			id:'gridvestibulares',
			store:storevestibular,
			loadMask:true,
			stripeRows:true,
			autoScroll:true,
			border:false,
			height:458,
			viewConfig:{
				 forceFit:true,
				 getRowClass:function(record, rowIndex, rp, ds){
					 var _class = record.get('instatus');
					 if (!_class){
						 return 'red';
					 }else{
						 return 'black';
					 }
				 }
			 },
			sm: new Ext.grid.RowSelectionModel({
			 singleSelect: true,
			}),
			cm:new Ext.grid.ColumnModel({
				columns:[new Ext.grid.RowNumberer({
					width:30,
					header:'nº',
				}),{ 
					header:'Vestibulares',
					id:'hdvestibular',
					width:200,
					sortable:true,
					dataIndex:'desvestibular',
					editor: new Ext.form.TextField({
						AllowBlank: false,							  
					})
				},{
					xtype:'datecolumn',
					header:'Data de Início',
					id:'hddtinicio',
					sortable:true,
					dataIndex:'dtinicio',
					format:'d/m/Y',
				},{
					header:'Semestre',
					id:'hddtsemestre',
					sortable:true,
					dataIndex:'dtsemestre',
				},{
					xtype:'datecolumn',
					header:'Data de Cadastro',
					id:'hddtcadastro',
					sortable:true,
					dataIndex:'dtcadasdtro',
					format:'d/m/Y h:i',
				},{
					header:'Status',
					id:'statuslist',
					width:45,
					sortable:true,
					dataIndex:'instatus',
					renderer:fn_status
				}],
			}),
			listeners:{
				afteredit: function(e){	
					Ext.Ajax.request({ 
						url:'/simpacweb/modulos/fit/adm_vestibular-resultados/ajax/vestibular_update.php',
							  params:{
								 idvestibular:e.record.get('idvestibular'),
								 desvestibular:e.record.get('desvestibular'),
								 dtinicio:e.record.get('dtinicio').format('Y-m-d'),
								 dttermino:e.record.get('dttermino').format('Y-m-d')
							  },			
							  success:function(){
								 e.record.commit();
							}
						});	
					},
				'click':function(){
					if(Ext.getCmp('gridvestibulares').getSelectionModel().getSelected()){
						Ext.getCmp('btnremovervestibular').enable();
						Ext.getCmp('btnstatusvestibular').enable();
					}else{
						Ext.getCmp('btnremovervestibular').disable();
						Ext.getCmp('btnstatusvestibular').disable();
					}
				},
			},
			bbar:[{
				text:'Adicionar',
				iconCls:'ico_add',								
				handler:function(){
					setTimeout(
						function(){
							Ext.getCmp('idvestibulares_add').expand()
						},250
					);
				}
			},'-',{
				text:'Deletar',
				iconCls:'ico_delete',
				id:'btnremovervestibular',
				disabled:true,
				handler:function(){
					if(!Ext.getCmp('gridvestibulares').getSelectionModel().getSelected()){
							Ext.MessageBox.erro('Aviso!', 'Por favor, você deve selecionar um vestibular para deletar.');
					}else{					
						Ext.MessageBox.confirm('Confirmação', 'Deseja deletar '+Ext.getCmp('gridvestibulares').getSelectionModel().getSelected().get('desvestibular')+' ?',
						function(btn){
							if(btn=='yes'){
								Ext.Ajax.request({
									url: '/simpacweb/modulos/fit/adm_vestibular-resultados/ajax/vestibular_delete.php',
									params:{ 
										idvestibular:Ext.getCmp('gridvestibulares').getSelectionModel().getSelected().get('idvestibular'),
									},
									success:function(){
										Ext.getCmp('gridvestibulares').getStore().reload({
											callback:function(){
												Ext.MessageBox.info('',Ext.getCmp('gridvestibulares').getSelectionModel().getSelected().get('desvestibular')+' deletado!');	
											}	
										});
									},
								});
							}
						});									
					}
				}
			},'-',{
				iconCls:'ico_Down',
				tooltip:"Esconder janela",
				handler:function(){
					Ext.getCmp('idvestibulares_add').collapse();
				}
			}],
		}],
	});
	
	var vestibulares_add = new Ext.Panel({
		id:'idvestibulares_add', 
		title:'Adicionar vestibulares novos',
		iconCls:'ico_adicionar',
		region:'south',
		split:true,
		collapseMode:'mini',
		margins:'4 4 4 4',
		collapsible: true,
		collapsed:true,
		height:150,
		width:'100%',
		border:true,
		layout:'fit',
		items: [{
			xtype: 'form',
			id:'formaddvestibular',
			padding: 5,
			border: false,
			buttonAlign:'left',
			defaults: {				
				allowBlank:false,
				padding: 5
			},
			items: [{
				fieldLabel: 'Vestibular',
				id:'iddesvestibular',
				xtype: 'textfield',
				name:'desvestibular',
				anchor:'100%',
			}, {
				xtype: 'datefield',
				fieldLabel: 'Data de Início',
				id:'dtiniciovestibular',		
				width:150
			},{
				xtype: 'combo',
				id:'idcombosemestre',
				width:150,
				fieldLabel:'Semestre',
				autoHeight:true,
				typeAhead: true,
				triggerAction: 'all',
				lazyRender:true,
				mode: 'local',
				allowBlank:false,
				emptyText:'Selecione o semestre...',
				store: new Ext.data.ArrayStore({
					fields:[{name:'semestre',type:'string'},
							{name: 'semestrevalue',type:'string'}],
					data:[['1º Semestre '+data.getFullYear(),data.getFullYear()+'-01-01'],
						  ['2º Semestre '+data.getFullYear(),data.getFullYear()+'-12-12'],
						  ['1º Semestre '+(data.getFullYear()+1),(data.getFullYear()+1)+'-01-01'],
						  ['2º Semestre '+(data.getFullYear()+1),(data.getFullYear()+1)+'-12-12']]
				}),
				valueField: 'semestrevalue',
				displayField: 'semestre',
				listeners:{
					change:function(){
						comboValue = Ext.getCmp('idcombosemestre').getValue();
						//console.log('change '+comboValue);
					},
					select:function(){
						comboValue = Ext.getCmp('idcombosemestre').getValue();	
						//console.log('select '+comboValue);
					},
				}
			}],
			buttons:[{
				text:'Adicionar',
				iconCls:'ico_adicionar',
				handler:function(){
					if(Ext.getCmp('formaddvestibular').getForm().isValid()){
						Ext.getCmp('formaddvestibular').getForm().submit({
							url:'/simpacweb/modulos/fit/adm_vestibular-resultados/ajax/vestibular_save.php',
							params:{
								dt1:Ext.getCmp("dtiniciovestibular").getValue().format('Y-m-d'),
								dt2:Ext.getCmp("idcombosemestre").getValue()
							},
						success:function(){
								Ext.getCmp('gridvestibulares').getStore().reload({
									callback:function(){
										Ext.MessageBox.info('',Ext.getCmp('iddesvestibular').getValue()+'  Adicionado!',function(btnok){
											if(btnok == 'ok'){
												Ext.getCmp('idvestibulares_add').collapse();
												Ext.getCmp('formaddvestibular').getForm().reset();												
											}
										});	
									}	
								});
							}
						})
					}else{
						Ext.MessageBox.warning('Aviso!','Preecha todos os dados.')
					}
				}
			}]			
		}]
	});	
//==============MAIN==============================================================================================================	
	var tabs = new Ext.Panel({
		region: 'center',
		split: true,
		width: 250,
		collapsed:false,
		margins:'2 2 2 2',
		cmargins:'2 2 2 2',
		layout:'fit',
		items:
		new Ext.TabPanel({
			margins:'2 2 2 2', 
			activeTab: 0,
			height:500,
			tabPosition:'bottom',
			autoScroll:false,
			items:[{
				title: 'Vestibulares',
				layout: 'border',		 
				listeners:{
					'activate':function(){
						if(a == false){
							storevestibular.load();
						}
						a = true;
						Ext.getCmp('combo_vestibularreprovados').clearValue();
						Ext.getCmp('combo_vestibularaprovados').clearValue();
					},
					'deactivate':function(){
						Ext.getCmp('btnstatusvestibular').disable();
						Ext.getCmp('btnremovervestibular').disable();
					}
				},
				items:[vestibulares_grid,vestibulares_add],
			},{
				title: 'Alunos Aprovados',
				layout: 'border',	
				listeners:{
					'activate':function(){
						if(b == false){
							groupingStorealunosaprovados.load();
							storevestibularbyinstatus.load();
						}
						b = true;
						//Ext.getCmp('combo_vestibularreprovados').clearValue();
					},
					'deactivate':function(){
						Ext.getCmp('btnstatusalunoaprovado').disable();
						Ext.getCmp('btnisprimeiro').disable();
						Ext.getCmp('btnremoveaprovados').disable();
					}
				},
				items:[alunosaprovados_grid,alunosaprovados_add],
			},{
				title: 'Alunos Reprovados',
				layout: 'border',
				listeners:{
					'activate':function(){
						if(c == false){
							groupingStorealunosreprovados.load();
							storevestibularbyinstatus.load();
						}
						c = true;
						//Ext.getCmp('combo_vestibularaprovados').clearValue();
					},
					'deactivate':function(){
						Ext.getCmp('btnstatusalunoreprovado').disable();
						Ext.getCmp('btnremovereprovados').disable();
					}
				},
				items:[alunosreprovados_grid,alunosreprovados_add],
			}]
		})				
	});	
//====================FULL PANEL=====================================================================================	
	new Ext.FullPanel({
		id:'panel.admvestaprovadosreprovados', //Id da 'Window'
		height:Page.height - 128,
		plain:false,
		modal:true, //Bloquear conteúdo da página enquanto a janela está ativa
		layout:'border',
		items:[tabs],		
	});	
//_____________________Reajusta o tamanho da tela__________________________________________________________________	
	window.onresize = function(){			 
		//Obtem o tamanho no exato momento
		var a = getPageSize();	
		//No componente com determinado 'Id', é setado o novo tamanho (Para reajuste da tela)		 
		Ext.getCmp('panel.admvestaprovadosreprovados').setSize(a.width,a.height - 122);
	};					
});
</script>


