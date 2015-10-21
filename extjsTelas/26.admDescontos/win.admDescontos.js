// @AUTHOR = Massaharu
//GLOBALS
ARR_OBJCURSOS = [];
ARR_DESCONTOITENS = [];
MATRICULA = 1;
MENSALIDADE = 2;

//CONSTANTES
PATH = "/simpacweb/modulos/fit/financeiro/admDescontos";
var ms = Ext.MessageBox;

/////////////////// OBJETO /////////////////// 
var Class_Desconto = function(args){
	//tb_desconto
	var iddesconto;
	var iddescontotipo;
	var desdesconto;
	
	var DescontoCampanhaFit = {};
	var DescontoBolsaFit = {};
	
	var Cursos = [];
	var Itens = [];
	
	var construct = function(){
		iddesconto			= (typeof(args.iddesconto) != "undefined")? args.iddesconto : null;
		iddescontotipo		= (typeof(args.iddescontotipo) != "undefined")? args.iddescontotipo : null;
		desdesconto 		= (typeof(args.desdesconto) != "undefined")? args.desdesconto : null;
		DescontoCampanhaFit = (typeof(args.DescontoCampanhaFit) != "undefined")? args.DescontoCampanhaFit : null;
		DescontoBolsaFit 	= (typeof(args.DescontoBolsaFit) != "undefined")? args.DescontoBolsaFit : null;
		Cursos 				= (typeof(args.Cursos) != "undefined")? args.Cursos : null;
		Cursos 				= (typeof(args.Cursos) != "undefined")? args.Cursos : null;
		Itens 				= (typeof(args.Itens) != "undefined")? args.Itens : null;
	}
	
	this.get = function(){
		return {
			iddesconto			: iddesconto,
			iddescontotipo		: iddescontotipo,
			desdesconto 		: desdesconto,
			DescontoCampanhaFit : DescontoCampanhaFit,
			DescontoBolsaFit 	: DescontoBolsaFit,
			Cursos 				: Cursos,
			Itens 				: Itens
		}
	}
	
	this.destruct = function(){
		iddesconto			= null,
		iddescontotipo		= null,
		desdesconto 		= null,
		DescontoCampanhaFit	= null,
		DescontoBolsaFit	= null,
		Cursos 				= null,
		Itens 				= null
	}
	 
	if(typeof(args) != "undefined") construct();
}

/////////////////// STORES /////////////////// 
var storelist_produtos_sophiacursos = new Ext.data.JsonStore({
	url: PATH+'/actions/json/produtos_sophiacursos_list.php',
	root:'data', 
	fields:[
		{name:'idproduto', type:'int'},
		{name:'idprodutotipo', type:'int'},
		{name:'desproduto'},
		{name:'instatus', type:'bit'},
		{name:'dtcadastro',type:'date',dateFormat:'timestamp'},
		{name:'idimagem', type:'int'},
		{name:'nrestoque', type:'int'},
		{name:'dtvalidade',type:'date',dateFormat:'timestamp'},
		{name:'nrparcelas', type:'int'},
		{name:'desprodutotipo'}
	],
	autoLoad:true
});

var storelist_descontotipoacademico = new Ext.data.JsonStore({
	url: PATH+'/actions/json/descontotipoacademico_list.php',
	root:'data', 
	fields:[
		{name:'idprodutotipo', type:'int'},
		{name:'desprodutotipo'},
		{name:'dtcadastro',type:'date',dateFormat:'timestamp'}
	],
	autoLoad:true
});

var storelist_descontoItemTipoList = new Ext.data.JsonStore({
	url: PATH+'/actions/json/descontoItemTipoList.php',
	root:'data', 
	fields:[
		{name:'iddescontoitemtipo', type:'int'},
		{name:'destipoitem'},
		{name:'instatus', type:'bit'},
		{name:'dtcadastro',type:'date',dateFormat:'timestamp'}
	],
	autoLoad:true
});

var storelist_descontoTipoList = new Ext.data.JsonStore({
	url: PATH+'/actions/json/descontoTipoList.php',
	root:'data', 
	fields:[
		{name:'iddescontotipo', type:'int'},
		{name:'desdescontotipo'},
		{name:'instatus', type:'bit'},
		{name:'dtcadastro',type:'date',dateFormat:'timestamp'}
	],
	autoLoad:true
});

var storelist_pjList = new Ext.data.JsonStore({
	url: PATH+'/actions/json/pjList.php',
	root:'data', 
	fields:[
		{name:'idpessoa', type:'int'},
		{name:'idpessoatipo', type:'int'},
		{name:'despessoa'},
		{name:'idproprietario', type:'int'},
		{name:'idpessoaimportancia', type:'int'},
		{name:'indeletado', type:'bit'},
		{name:'dtcadastro',type:'date',dateFormat:'timestamp'}
	],
	autoLoad:true
});

var storelist_naturezasList = new Ext.data.JsonStore({
	url: PATH+'/actions/json/naturezasList.php',
	root:'data', 
	fields:[
		{name:'idnaturezadesconto', type:'int'},
		{name:'desnaturezadesconto'},
		{name:'nrordem', type:'int'},
		{name:'nrvalidadetipo', type:'int'},
		{name:'invisivel', type:'bit'},
		{name:'dtcadastro',type:'date',dateFormat:'timestamp'}
	],
	autoLoad:true
});

var arraystore_produtos_sophiacursos = new Ext.data.ArrayStore({
	fields: [
	   {name: 'idproduto', type: 'int'},
	   {name: 'idprodutotipo', type: 'int'},
	   {name: 'desprodutotipo'},
	   {name: 'desproduto'}
	]
});

///////////////////// FUNCTIONS ///////////////////// 
function fn_enableDia(obj){
	if(!obj.nmfield.isValid()) return false;
		
	if($.trim(obj.nmfield.getValue()) == ""){ 
		
		xt('cpadmdesconto'+obj.descontoitemtipo+'dia1').disable();
		xt('cpadmdesconto'+obj.descontoitemtipo+'dia2').hide();
		xt('cpadmdesconto'+obj.descontoitemtipo+'dia3').hide();
		xt('nbadmdesconto'+obj.descontoitemtipo+'dia1perc').setValue("");	
		xt('nbadmdesconto'+obj.descontoitemtipo+'dia2perc').setValue("");	
		xt('nbadmdesconto'+obj.descontoitemtipo+'dia3perc').setValue("");	
		xt('nbadmdesconto'+obj.descontoitemtipo+'dia1').setValue("");
		xt('nbadmdesconto'+obj.descontoitemtipo+'dia2').setValue("");
		xt('nbadmdesconto'+obj.descontoitemtipo+'dia3').setValue("");
		
		return false;
	}
	
	if(obj.nmfield.getValue() >= 40){
		
		xt('cpadmdesconto'+obj.descontoitemtipo+'dia1').enable();
		xt('cpadmdesconto'+obj.descontoitemtipo+'dia2').show();
		xt('cpadmdesconto'+obj.descontoitemtipo+'dia3').show();
		xt('nbadmdesconto'+obj.descontoitemtipo+'dia1perc').setValue(obj.nmfield.getValue());	
		xt('nbadmdesconto'+obj.descontoitemtipo+'dia2perc').setValue(obj.nmfield.getValue() - 10);	
		xt('nbadmdesconto'+obj.descontoitemtipo+'dia3perc').setValue(obj.nmfield.getValue() / 2);	
		xt('nbadmdesconto'+obj.descontoitemtipo+'dia1').setValue(1);
		xt('nbadmdesconto'+obj.descontoitemtipo+'dia2').setValue(5);
		xt('nbadmdesconto'+obj.descontoitemtipo+'dia3').setValue(10);
		
	}else if(obj.nmfield.getValue() >= 20){
		
		xt('cpadmdesconto'+obj.descontoitemtipo+'dia1').enable();
		xt('cpadmdesconto'+obj.descontoitemtipo+'dia2').show();
		xt('cpadmdesconto'+obj.descontoitemtipo+'dia3').hide();
		xt('nbadmdesconto'+obj.descontoitemtipo+'dia1perc').setValue(obj.nmfield.getValue());	
		xt('nbadmdesconto'+obj.descontoitemtipo+'dia2perc').setValue(obj.nmfield.getValue() - 10);	
		xt('nbadmdesconto'+obj.descontoitemtipo+'dia3perc').setValue("");	
		xt('nbadmdesconto'+obj.descontoitemtipo+'dia1').setValue(1);
		xt('nbadmdesconto'+obj.descontoitemtipo+'dia2').setValue(10);
		xt('nbadmdesconto'+obj.descontoitemtipo+'dia3').setValue("");
		
	}else{
		
		xt('cpadmdesconto'+obj.descontoitemtipo+'dia1').enable();
		xt('cpadmdesconto'+obj.descontoitemtipo+'dia2').hide();
		xt('cpadmdesconto'+obj.descontoitemtipo+'dia3').hide();
		xt('nbadmdesconto'+obj.descontoitemtipo+'dia1perc').setValue(obj.nmfield.getValue());	
		xt('nbadmdesconto'+obj.descontoitemtipo+'dia2perc').setValue("");	
		xt('nbadmdesconto'+obj.descontoitemtipo+'dia3perc').setValue("");	
		xt('nbadmdesconto'+obj.descontoitemtipo+'dia1').setValue(1);
		xt('nbadmdesconto'+obj.descontoitemtipo+'dia2').setValue("");
		xt('nbadmdesconto'+obj.descontoitemtipo+'dia3').setValue("");
	}
}

function fn_campanhaInternaFields(obj){
	if(obj.record.get('iddescontotipo') == obj.iddescontotipo){
		$.each(obj.fields, function(i, v){
			xt(v.field).show(); 
		});
	}else{
		$.each(obj.fields, function(i, v){
			xt(v.field).hide().setValue(''); 
		});
	}
}

function fn_bolsaFields(obj){
	if(obj.record.get('iddescontotipo') == obj.iddescontotipo){
		$.each(obj.fields, function(i, v){
			if(v.hidden == true){
				xt(v.field).hide();
			}else{
				xt(v.field).show(); 
			}
		});
	}else{
		$.each(obj.fields, function(i, v){
			if(v.hidden){
				xt(v.field).show(); 
			}else{
				xt(v.field).hide();
			}
		});
	}
}

function getDias(obj){

	var $arrObj_dias = [];
	var $checked = false;
	var $disabled = false;
	var $hidden = false;
	
	for(var i = 1; i <= obj.qtd_dias; i++){
		
		if(i == 1){
			$checked = true;
			$disabled = true;
			$hidden = false;
		}else{
			$checked = false;
			$disabled = false;
			$hidden = true;
		}
		
		$arrObj_dias.push({
			xtype:'compositefield',
			id:'cpadmdesconto'+obj.itemtipos+'dia'+i,
			disabled: $disabled,
			hidden: $hidden,
			items:[{
				xtype:'numberfield',
				id:'nbadmdesconto'+obj.itemtipos+'dia'+i,
				fieldLabel:'Dia', 
				width:40,
				value: 1
			},{
				xtype:"displayfield",
				value:'Util:'
			},{
				xtype:"checkbox",
				id:'ckadmdesconto'+obj.itemtipos+'dia'+i,
				name:'ckbadmdesconto'+obj.itemtipos+'util',
				checked: $checked
			},{
				xtype:'numberfield',
				id:'nbadmdesconto'+obj.itemtipos+'dia'+i+'perc',
				maxValue: 100
			},{
				xtype:"displayfield",
				value:'%'
			}]
		})
	}
	
	return $arrObj_dias;
}

//Valida os campos dos Dias do formulário
function validDescontoDia(obj){
	for(var i = 1; i <= obj.qtd_dias; i++){
		
		var $cpfield = xt('cpadmdesconto'+obj.itemtipos+'dia'+i);
		var $nbfieldDia = xt('nbadmdesconto'+obj.itemtipos+'dia'+i);
		var $ckfieldUtil = xt('ckadmdesconto'+obj.itemtipos+'dia'+i);
		var $nbfieldPerc = xt('nbadmdesconto'+obj.itemtipos+'dia'+i+'perc');
		
		if($cpfield.isVisible() && !$nbfieldDia.disabled && !$ckfieldUtil.disabled && !$nbfieldPerc.disabled){
		
			ARR_DESCONTOITENS.push({
				iditemtipo 	: obj.iditemtipo,
				nrdia		: $nbfieldDia.getValue(),
				nrporc 		: $nbfieldPerc.getValue(),
				inutil		: ($ckfieldUtil.getValue())? 1 : 0
			});
		}
	}
}

function fn_resetOnSave(){
	
	ARR_OBJCURSOS = [];
	ARR_DESCONTOITENS = [];
	storelist_produtos_sophiacursos.reload();
	arraystore_produtos_sophiacursos.removeAll();
	xt('idformadmdescontocad').getForm().reset();
	
	fn_enableDia({
		nmfield: xt('idnbadmdescontomaior'),
		descontoitemtipo: 'mensalidade'
	});
	fn_enableDia({
		nmfield: xt('idnbadmdescontomatricula'),
		descontoitemtipo: 'matricula'
	});	
}

////
var checkCursoDesconto = new Ext.grid.CheckboxSelectionModel({
	singleSelect: false
});

if(xt('idwinadmdesconto')){
	xt('idwinadmdesconto').show();
}else{
	new Ext.Window({
		title:'Administrativo de Descontos FIT',
		id:'idwinadmdesconto',
		iconCls:'ico_file',
		width:500,
		height:450,
		layout:'fit',
		items:[{
			xtype:'panel',
			id:'idpaneladmdescontocad',
			height:390,
			autoScroll:true,
			border:false,
			items:[{
				xtype:'form',
				id:'idformadmdescontocad',
				padding:10,
				border:false,
				defaults:{
					anchor:'97%'
				},
				items:[{
					xtype:'textfield',
					id:'idtxtadmdescontodescricao',
					fieldLabel:'Descrição',
					allowBlank: false 
				},{
					xtype: 'compositefield',
					items:[{
						xtype: 'combo',
						fieldLabel:'Tipo de Desconto',
						width:200,
						valueField: 'iddescontotipo',
						displayField: 'desdescontotipo',
						typeAhead: true,
						mode: 'local',
						triggerAction: 'all',
						emptyText: 'Selecione o tipo de desconto.',
						selectOnFocus: true,
						id: 'cmbadmdescontotipodesc',
						allowBlank: false,
						store:storelist_descontoTipoList,
						listeners:{
							'select':function(combo, record, index){
															
								fn_campanhaInternaFields({
									record: record,
									iddescontotipo: 2, //Campanha Interna
									fields: [{
										field: 'dfadmdescontode',
										hidden: false
									},{
										field: 'dfadmdescontoate',
										hidden: false
									},{
										field: 'txtadmdescontoobs',
										hidden: false
									},{
										field: 'idnbadmdescontoqtdparcelas',
										hidden: false
									}]
								});
								
								fn_bolsaFields({
									record: record,
									iddescontotipo: 1, //BOLSA
									fields: [{
										field: 'idfsadmdescontomensalidade',
										hidden: true
									},{
										field: 'idfsadmdescontomatricula', 
										hidden: true
									},{
										field: 'idnbadmdescontobolsaperc',
										hidden: false
									},{
										field: 'cmbadmdescontonatureza',
										hidden: false
									},{
										field: 'cpfielddmdescontofinanciadora',
										hidden: false
									},{
										field:'cpfieldtipobolsa',
										hidden: false
									}]
								});
							}
						}
					},{
						xtype:'button',
						iconCls:'ico_add',
						text:'Add Curso ao desconto',
						handler: function(){
							if(xt('winaddcursodesconto')){
								xt('winaddcursodesconto').show();
							}else{
								new Ext.Window({
									id:'idwinaddcursodesconto',
									title:'Adicionar curso ao desconto',
									width:800,
									height:400,
									modal: true,
									layout:'hbox',
									bbar:[{
										xtype: 'combo',
										fieldLabel:'Tipo Acadêmico',
										id: 'cmbadmdescontotipoacademico',
										width:200,
										store: storelist_descontotipoacademico,
										valueField: 'idprodutotipo',
										displayField: 'desprodutotipo',
										typeAhead: true,
										mode: 'local',
										triggerAction: 'all',
										emptyText: 'Selecione o tipo academico.',
										selectOnFocus: true,
										listeners:{
											'select': function(cmb, rec, i){
												
												storelist_produtos_sophiacursos.reload({
													params:{
														idprodutotipo: rec.get('idprodutotipo')
													}
												});	
											}
										}
									},'->','-',{
										text:'Adicionar',
										iconCls:'ico_add',
										handler: function(){
											
											var count = arraystore_produtos_sophiacursos.getCount();
											
											if(count < 1){
												ms.erro(
													'Nenhum curso foi Vinculado ao desconto!',
													'Selecione os cursos da tabela à esquerda e arraste para a outra tabela.'
												);
												return false;
											}
											
											ARR_OBJCURSOS = [];
											
											for(i = (count-1); i >= 0; i--){
												
												ARR_OBJCURSOS.push({
													idproduto : arraystore_produtos_sophiacursos.getAt(i).get('idproduto'),
													idprodutotipo: arraystore_produtos_sophiacursos.getAt(i).get('idprodutotipo'),
													desproduto: arraystore_produtos_sophiacursos.getAt(i).get('desproduto'),
													desprodutotipo: arraystore_produtos_sophiacursos.getAt(i).get('desprodutotipo')
												});
											}
											
											ms.info('Vinculado(s)', 'Cursos vinculados ao desconto');
											
											xt('idwinaddcursodesconto').close();
										}
									}],
									items:[{
										xtype:'panel',
										layout: 'fit',
										height:340,
										flex: 1,
										items:[{
											xtype:'grid',
											id:'idgridaddcursodesconto',
											store: storelist_produtos_sophiacursos,
											enableDragDrop:true,
											ddGroup:'ddgroupaddcursodesconto',
											loadMask:true,
											stripeRows:true,
											autoScroll:true,
											border:false,
											viewConfig:{
												forceFit:true
											},
											sm: checkCursoDesconto,
											cm: new Ext.grid.ColumnModel({
												defaults: {
													sortable: true, 
													collapsible: true
												},
												columns:[checkCursoDesconto,{ 
													id:'colidproduto',
													hidden: true,
													dataIndex:'idproduto'
												},{ 
													id:'colidprodutotipo',
													hidden: true,
													dataIndex:'idprodutotipo'
												},{
													header:'Tipo',
													width:40,
													dataIndex:'desprodutotipo'
												},{ 
													header:'Curso',
													id:'coldesproduto',
													dataIndex:'desproduto'
												}]
											})
										}]
									},{
										xtype:'panel',
										layout: 'fit',
										height:340,
										flex: 1,
										items:[{
											xtype:'grid',
											id:'idgridaddcursodescontosave',
											enableDragDrop:true,
											ddGroup:'ddgroupaddcursodescontosave',
											store: arraystore_produtos_sophiacursos,
											loadMask:true,
											stripeRows:true,
											autoScroll:true,
											border:false,
											viewConfig:{
												forceFit:true
											},
											cm: new Ext.grid.ColumnModel({
												defaults: {
													sortable: true, 
													collapsible: true
												},
												columns:[{ 
													id:'colidprodutosave',
													hidden: true,
												},{ 
													id:'colidprodutotiposave',
													hidden: true,
												},{
													header:'Tipo',
													id:'coldesprodutotiposave',
													width:40,
												},{ 
													header:'Curso',
													id:'coldesprodutosave',
												}]
											})
										}]
									}],
									listeners:{
										'afterrender': function(){
											
											var Produtos = Ext.data.Record.create([
												{name: 'idproduto', type: 'int'},
												{name: 'idprodutotipo', type: 'int'},
												{name: 'desprodutotipo'},
												{name: 'desproduto'}
											]);
											
											////////////////// Adicionar Curso //////////////
											//DRAGGABLE
											//Define a área para dropar os elementos
											var gridlist_addcursodescontosaveTargetEl =  xt('idgridaddcursodescontosave').getView().scroller.dom; //
											var gridlist_addcursodescontosaveDropTarget = new Ext.dd.DropTarget(gridlist_addcursodescontosaveTargetEl, {
												ddGroup    : 'ddgroupaddcursodesconto', //de onde vem
												notifyDrop : function(ddSource, e, data){
													var data = data;
													var records =  ddSource.dragData.selections;
													//var sel = Miku.selected('grid_manuais');
													Ext.each(records, ddSource.grid.store.remove, ddSource.grid.store);
													//gridlist_turmas.store.add(records); adiciona os recs à area de drop
													Ext.each(data.selections, function(data, index){
														
														var myRec = new Produtos({
															idproduto: data.get('idproduto'),
															idprodutotipo: data.get('idprodutotipo'),
															desprodutotipo: data.get('desprodutotipo'),
															desproduto: data.get('desproduto')
														});
														
														arraystore_produtos_sophiacursos.add(myRec);
													});
													
													arraystore_produtos_sophiacursos.commitChanges();																
													//ordena a tabela a ser dropada
													//gridlist_turmas.store.sort('CODIGO', 'ASC');
												}
											});
											
											////////////////// Adicionar Curso //////////////
											//Define a área para dropar os elementos
											var gridlist_addcursodescontoTargetEl =  xt('idgridaddcursodesconto').getView().scroller.dom; //
											var gridlist_addcursodescontoDropTarget = new Ext.dd.DropTarget(gridlist_addcursodescontoTargetEl, {
												ddGroup    : 'ddgroupaddcursodescontosave', //de onde vem
												notifyDrop : function(ddSource, e, data){
													var data = data;
													var records =  ddSource.dragData.selections;
													//var sel = Miku.selected('grid_manuais');
													Ext.each(records, ddSource.grid.store.remove, ddSource.grid.store);
												}
											});
										}
									}
								}).show();
							}
						}
					}],					
				},{
					xtype:'datefield',
					fieldLabel:'De',
					id:'dfadmdescontode',
					hidden: true,
					width:150,
					listeners:{
						'select': function(){
							var $dateDe = xt('idsolicitacaosecretariadata_inicio').getValue();
							var $dateAte = xt('idsolicitacaosecretariadata_final').getValue();
							
							if(fn_getDateInt($dateDe) > fn_getDateInt($dateAte)){
								xt('idsolicitacaosecretariadata_final').setValue($dateDe);
							}
						}
					}
				},{
					xtype:'datefield',
					fieldLabel:'Até',
					width:150,
					id:'dfadmdescontoate',
					hidden: true
				},{
					xtype:'textarea',
					fieldLabel:'Observação',
					id:'txtadmdescontoobs',
					hidden: true,
					width:150
				},{
					xtype:'numberfield',
					id:'idnbadmdescontoqtdparcelas',
					fieldLabel:'Qtde. Parcelas',
					hidden:true
				},{
					xtype:'numberfield',
					id:'idnbadmdescontobolsaperc',
					hidden:true,
					value:100,
					disabled:true,
					fieldLabel:'Bolsa %'
				},{					
					xtype: 'combo',
					fieldLabel:'Natureza',
					width:200,
					valueField: 'idnaturezadesconto',
					displayField: 'desnaturezadesconto',
					hidden: true,
					typeAhead: true,
					mode: 'local',
					triggerAction: 'all',
					emptyText: 'Selecione uma natureza...',
					selectOnFocus: true,
					id: 'cmbadmdescontonatureza',
					store:storelist_naturezasList,
					listeners:{
						'select': function(combo, record, index){
							if(record.get('idnaturezadesconto') == 5){ //Financiamento
								xt('cpfielddmdescontofinanciadora').enable();
							}else{
								xt('cpfielddmdescontofinanciadora').disable();
							}
						}
					}
				},{
					xtype:'compositefield',
					id: 'cpfieldtipobolsa',
					hidden:true,
					items:[{
						xtype:'displayfield',
						value:'Matricula: '
					},{
						xtype:'checkbox',
						id:'ckadmdescontoinmatricula',
						checked:true
					},{
						xtype:'displayfield',
						value:'Mensalidade: '
					},{
						xtype:'checkbox',
						id:'ckadmdescontoinmensalidade',
						checked:true
					}]
				},{	
					xtype:'compositefield',
					id:'cpfielddmdescontofinanciadora',
					hidden:true,
					items:[{
						xtype: 'combo',
						fieldLabel:'Empresa Financiadora',
						disabled:true,
						width:250,
						valueField: 'idpessoa',
						displayField: 'despessoa',
						typeAhead: true,
						mode: 'local',
						triggerAction: 'all',
						emptyText: 'Selecione uma empresa...',
						selectOnFocus: true,
						id: 'cmbadmdescontoempresafinanciadora',
						store:storelist_pjList
					},{
						xtype:'displayfield',
						value:'Gerar Débito: '
					},{
						xtype:'checkbox',
						id:'ckadmdescontogerardebito',
						disabled:true,
						checked:true
					}]
				},{
					///////////////////////////// MENSALIDADE //////////////////////////////////////
					xtype:'fieldset',
					id:'idfsadmdescontomensalidade',
					collapsible:true,
					width:'80%',
					title:'Mensalidade',
					items:[{
						xtype:'numberfield',
						id:'idnbadmdescontomaior',
						fieldLabel:'% Maior',
						enableKeyEvents: true,
						maxValue: 100,
						listeners:{
							'blur': function($this){
								fn_enableDia({
									nmfield: $this,
									descontoitemtipo: 'mensalidade'
								});
							},
							'keydown': function($this, e){
								
								if(e.getKey() == e.ENTER){
									
									fn_enableDia({
										nmfield: $this,
										descontoitemtipo: 'mensalidade'
									});
								}
							}
						}
					},
					getDias({
						itemtipos: 'mensalidade',
						qtd_dias: 5
					})]
				},{		
					///////////////////////////// MATRICULA //////////////////////////////////////			
					xtype:'fieldset',
					id:'idfsadmdescontomatricula',
					collapsible:true,
					title:'Matrícula',
					items:[{
						xtype:'numberfield',
						id: 'idnbadmdescontomatricula',
						fieldLabel:'% Matrícula',
						enableKeyEvents: true,
						maxValue: 100, 
						listeners:{
							'blur': function($this){
								fn_enableDia({
									nmfield: $this,
									descontoitemtipo: 'matricula'
								});
							},
							'keydown': function($this, e){
								
								if(e.getKey() == e.ENTER){
									
									fn_enableDia({
										nmfield: $this,
										descontoitemtipo: 'matricula'
									});
								}
							}
						}
					},
					getDias({
						itemtipos: 'matricula',
						qtd_dias: 5
					})]
				}]
			}]
		}],	
		buttons:[{
			text:'<b>Cadastrar</b>',
			iconCls:'ico_save',
			scale:'large',
			handler: function(){
				
				var mask = new Ext.LoadMask(xt('idwinadmdesconto').body,{msg:'Aguarde...'});
				
				var percMaior = $.trim(xt('idnbadmdescontomaior').getValue());
				var percMatricula = $.trim(xt('idnbadmdescontomatricula').getValue());
				var percBolsa = $.trim(xt('idnbadmdescontobolsaperc').getValue());
				var dtDe = ($.trim(xt('dfadmdescontode').getValue()))? $.trim(xt('dfadmdescontode').getValue().format('Y-m-d')) : "";
				var dtAte = ($.trim(xt('dfadmdescontoate').getValue()))? $.trim(xt('dfadmdescontoate').getValue().format('Y-m-d')) : "";
				var idnatureza = xt('cmbadmdescontonatureza').getValue();
				var inmensalidade = xt('ckadmdescontoinmensalidade').getValue();
				var inmatricula = xt('ckadmdescontoinmatricula').getValue(); 
				var idpessoajuridica = xt('cmbadmdescontoempresafinanciadora').getValue();
				
				/******************* VALIDAÇÃO **************/
				if(ARR_OBJCURSOS.length < 1){
					ms.erro('Não cadastrado', "Vincule os cursos ao desconto pelo botão \"Add Curso ao desconto\"");
					return false;
				}
				
				if(!xt('idformadmdescontocad').getForm().isValid()){
					ms.erro('Não cadastrado', "Insira todas as informações corretamente");
					return false;
				}
				
				switch(parseInt(xt('cmbadmdescontotipodesc').getValue())){
					case 1 : //BOLSA
						if(percBolsa == ""){
							ms.erro('Não cadastrado', "Um desconto deve ser inserido");
							return false;
						}						
						if(idnatureza == ""){
							ms.erro('Não cadastrado', "Selecione uma NATUREZA para o desconto");
							return false;
						}
						if(!inmensalidade && !inmatricula){
							ms.erro('Não cadastrado', "Selecione se o desconto é para uma MATRÍCULA e ou MENSALIDADE  para o desconto");
							return false;
						}						
						if(idnatureza == 5 && idpessoajuridica == ""){
							ms.erro('Não cadastrado', "Selecione uma EMPRESA para o desconto de FINANCIAMENTO.");
							return false;
						}
						break;
					case 2 : //Campanha Interna
						if(dtDe == "" || dtAte == ""){
							ms.erro('Não cadastrado', "Insira uma data de início e término para a campanha");
							return false;
						}
						if(percMaior == "" && percMatricula == ""){
							ms.erro('Não cadastrado', "Um desconto deve ser inserido");
							return false;
						}
						
						validDescontoDia({
							qtd_dias: 5,
							itemtipos:'matricula',
							iditemtipo: MATRICULA
						});	
						
						validDescontoDia({
							qtd_dias: 5,
							itemtipos:'mensalidade',
							iditemtipo: MENSALIDADE
						});		
						
						if(ARR_DESCONTOITENS.length < 1){
							ms.erro('Não cadastrado', "Insira corretamente o valor do Dia e seu percentual de desconto");
							return false;
						}			
						break;
					case 3 :  //Desconto
						if(percMaior == "" && percMatricula == ""){
							ms.erro('Não cadastrado', "Um desconto deve ser inserido");
							return false;
						}
						validDescontoDia({
							qtd_dias: 5,
							itemtipos:'matricula',
							iditemtipo: MATRICULA
						});	
						
						validDescontoDia({
							qtd_dias: 5,
							itemtipos:'mensalidade',
							iditemtipo: MENSALIDADE
						});
						
						if(ARR_DESCONTOITENS.length < 1){
							ms.erro('Não cadastrado', "Insira corretamente o valor do Dia e seu percentual de desconto");
							return false;
						}			
						break;
					case 4 : //Empresa Conveniada
						if(percMaior == "" && percMatricula == ""){
							ms.erro('Não cadastrado', "Um desconto deve ser inserido");
							return false;
						}
						
						validDescontoDia({
							qtd_dias: 5,
							itemtipos:'matricula',
							iditemtipo: MATRICULA
						});	
						
						validDescontoDia({
							qtd_dias: 5,
							itemtipos:'mensalidade',
							iditemtipo: MENSALIDADE
						});		
						
						
						if(ARR_DESCONTOITENS.length < 1){
							ms.erro('Não cadastrado', "Insira corretamente o valor do Dia e seu percentual de desconto");
							return false;
						}	
						break; 
				}
				
				/*********************************************************/
				
				var Descontos = new Class_Desconto({
					iddescontotipo		: xt('cmbadmdescontotipodesc').getValue(),
					desdesconto 		: xt('idtxtadmdescontodescricao').getValue(),
					DescontoCampanhaFit : {
						dtinicio 		: dtDe,
						dttermino 		: dtAte,
						desobservacao 	: xt('txtadmdescontoobs').getValue(),
						nrparcelas 		: xt('idnbadmdescontoqtdparcelas').getValue(),
					},
					DescontoBolsaFit	: {
						idpessoajuridica	: idpessoajuridica,
						idnaturezadesconto 	: idnatureza,
						nrporc 				: percBolsa,
						inmensalidade 		: (inmensalidade)? 1 : 0,
						inmatricula 		: (inmatricula)? 1 : 0,
						ingerardebito 		: (xt('ckadmdescontogerardebito').getValue())? 1 : 0
					},
					Cursos 				: ARR_OBJCURSOS,
					Itens 				: ARR_DESCONTOITENS
				});
				
				mask.show();
				
				$.ajax({
					url: PATH+'/actions/ajax/descontos_save.php',
					type:'POST',
					dataType:'JSON',
					data:{
						Descontos: JSON.stringify(Descontos.get())
					},
					success:function(resp){
						
						if(resp.success){
							ms.info('Cadastrado!', resp.msg);
							
							fn_resetOnSave();
						}else{
							ms.erro('Não cadastrado!', resp.msg);
						}
						
						mask.hide();
					},
					error:function(){
						
						ms.erro('Não cadastrado!', resp.msg);
						
						mask.hide();
					}
				});
			}
		}]
	}).show();
}