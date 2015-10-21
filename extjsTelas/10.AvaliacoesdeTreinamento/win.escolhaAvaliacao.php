<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript">
var treinamento  = SimpacWeb.vars.rec.get("destreinamento");
var instrutor	 = SimpacWeb.vars.rec.get("desinstrutor");
var idcursoagendado = SimpacWeb.vars.rec.get("idcursoagendado");
var dtinicio 	 = SimpacWeb.vars.rec.get("dtinicio"); 				//Inicio do treinamento
var dttermino 	 = SimpacWeb.vars.rec.get("dttermino");				//Termino do treinamento
var desala 		 = SimpacWeb.vars.rec.get("dessala");				//Sala do treinamento
var nrcapacidade = SimpacWeb.vars.rec.get("nrcapacidade");			//Vagas
var nralunos     = SimpacWeb.vars.rec.get("nralunos");				//Numeros de Alunos
var hinicio		 = SimpacWeb.vars.rec.get("dtinicio");				//Horario Inicio
var htermino	 = SimpacWeb.vars.rec.get("dttermino");				//Horario Termino
var idcurso		 = SimpacWeb.vars.rec.get("idcurso");
var periodo		 = SimpacWeb.vars.rec.get("desperiodo");
var unidade		 = SimpacWeb.vars.rec.get("desunidade");
var URL			 = "/simpacweb/modulos/treinamentos/ajax/";
var xt 			 = Ext.getCmp;


//TM_printAvalSimpac2.php Retorna a data(string) SEM as horas
//TM_printAvalSimpac.php Retorna a data(string) COM horas

var jsonStore = new Ext.data.JsonStore({
		url: URL + "TM_printAvalSimpac2.php",
		root: 'myData',
		fields: [{name: 'aluno',type: 'string'}, 
				 {name: 'nota',type: 'string'}, 
				 {name: 'comentario',type: 'string'},
				 {name: 'cadastrado',type:'string'}],
	});

	var groupingStore = new Ext.data.GroupingStore({
            reader: new Ext.data.JsonReader({
                root: 'myData',
                fields: [{name: 'aluno',type: 'string'}, 
						 {name: 'nota',type: 'string'}, 
						 {name: 'comentario',type: 'string'},
						 {name: 'cadastrado',type:'string'}],
            }),
            url: URL + "TM_printAvalSimpac2.php",
            //autoLoad: false,
            sortInfo: {field: 'cadastrado',direction: "ASC"},
            groupField: 'cadastrado',
        });
	
	var expander = new Ext.ux.grid.RowExpander({
		tpl : new Ext.Template(
			'<b>Comentário:</b></br>{comentario}</br>'
		)
	});
	

	function avalColor(value, metaData, record, rowIndex, colIndex, store){
		if (value=="&#211;timo"){
			return '<img src="/simpacweb/images/ico/16/avaliacao_10.png"/>';			
		}else if(value=="Bom"){
			return '<img src="/simpacweb/images/ico/16/avaliacao_5.png"/>';
		}else if(value=="Ruim"){
			return '<img src="/simpacweb/images/ico/16/avaliacao_0.png"/>';	 
		}else{
			return '<img src="/simpacweb/images/ico/16/avaliacao_10_cinza.png"/>';
		}
	}
	
	function func_comentario(value, metaData, record, rowIndex, colIndex, store){
		if(record.data.comentario!=" s/ comentário"){
			metaData.attr="style='color:blue;'"
		}
		return value;
	}



if(xt("TM_escolha_avaliacao"))
	  xt("TM_escolha_avaliacao").show();	  
else{	
	new Ext.Window({				   
		title:"Avaliação",		
		iconCls:"ico_avaliacao_10",		
		resizable:false,		
		border:false,		
		width: 360,		
		height:385,		
		id:"TM_escolha_avaliacao",		
		items:[{			   
			xtype:"form",				
			border:false,			
			labelWidth:70,			
			padding:10,			
			items:[{				   
				xtype:"fieldset",				
				title:"Cadastro de Avaliação",				
				hideLabel:true,				
				buttons:[{						 
					style:"margin-top:-5; margin-right:20",					
					text:"<b>Diária</b>",					
					scale:"medium",					
					id:"button_diaria",					
					handler:function(){						
						openWindowDefault('win.fichavaliacaodiaria.js');						
						xt("TM_escolha_avaliacao").close();						
					},					
					listeners:{						
						'mouseover':function(){							
							xt("button_final").disable();							
						},						
						'mouseout':function(){							
							xt("button_final").enable();							
						}						
					}					
				},{					
					style:"margin-top:-5; margin-right:40",					
					text:"<b>Final</b>",					
					scale:"medium",					
					id:"button_final",					
					handler:function(){						
						openWindowDefault('win.fichavaliacaofinal.js');						
						xt("TM_escolha_avaliacao").close();						
					},					
					listeners:{						
						'mouseover':function(){							
							xt("button_diaria").disable();							
						},						
						'mouseout':function(){							
							xt("button_diaria").enable();							
						}						
					}					
				}]				
			},{				
				xtype:"fieldset",				
				title:"Impressão de Avaliação Diária",
				buttonAlign:'center',
				items:[{					   
					xtype:"radio",					
					hideLabel:true,					
					boxLabel:"Com todas as datas",					
					id:"avaliacao_diaria_one",					
					name:"avaliacao_diaria"							
				},{					
					xtype:"compositefield",					
					border:false,					
					hideLabel:true,					
					items:[{						   
						xtype:"radio",						
						boxLabel:"Na data: ",						
						checked:true,						
						id:"avaliacao_diaria_two",						
						name:"avaliacao_diaria",						
					},{						
						xtype:"datefield",						
						id:"avaliacao_diaria_data",						
						value:dtinicio,						
						minValue: dtinicio,						
						maxValue: dttermino						
					}]										
				}],				
				buttons:[{						 
					scale:"medium",					
					style:"margin-top:-5;",					
					text:"Consultar",					
					id:"button_diaria_online",
					width:280,
					iconCls:"ico_search",					
					/*listeners:{					
						'mouseover':function(){						
							xt("button_diaria_simpac").disable();						
						},					
						'mouseout':function(){						
							xt("button_diaria_simpac").enable();						
						}					
					},	*/				
					handler:function(){								
						if(xt("avaliacao_diaria_one").checked){		
							/*Ext.Ajax.request({											 
								url: URL + "TM_printAvalSimpac2.php",								
								params:{									
									idcursoagendado: idcursoagendado,									
									todas:1,									
									online:1									
								},								
								success:function(resp){									
									var data = new Object();									
									data = Ext.util.JSON.decode(resp.responseText);									
									if(data.avaliacao != null){*/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////									
								groupingStore.load({
									url: URL + "TM_printAvalSimpac2.php",								
									params:{									
										idcursoagendado: idcursoagendado,	
										todas:1,									
										online:1
									},
								callback:function(data){
									if (data[0]!=null){//Se tiver dados no store
									
										if(Ext.getCmp('winavaliacaoDeTreinamento')){
											Ext.getCmp('winavaliacaoDeTreinamento').show();
										}else{ 
											var win = new Ext.Window({
												id:'winavaliacaoDeTreinamento',
												title:treinamento+'  -  Unidade:  '+unidade+',  Sala:  '+desala+',  Instrutor(a):  '+instrutor+',  Período:  '+periodo,
												iconCls:'ico_avaliacao_10',
												width:500,
												height:600,
												modal:true,
												minimizable:true,
												maximizable:true,
												collapsible:true,
												layout:'fit',
												bbar:[{
													text:'Desagrupar',
													iconCls: 'ico_oneColor_r65_c3_s1',
													handler : function(){
														groupingStore.clearGrouping();
													}		  
												},{
													text:'Imprimir Lista',
													iconCls:'ico_print',
													handler:function(){														
														if(xt("avaliacao_diaria_one").checked){														
															Ext.Ajax.request({																		 
																url: URL + "TM_printAvalSimpac.php",															
																params:{																
																	idcursoagendado: idcursoagendado,																
																	todas:1,																
																	online:1																
																},															
																success:function(resp){																
																	var data = new Object();																
																	data = Ext.util.JSON.decode(resp.responseText);																
																	if(data.avaliacao != null){																	
																		var arrData = new Array();																	
																		for(i = 0 ; i  < data.avaliacao.length ; i++){																		
																			if(arrData.indexOf(data.avaliacao[i].cadastrado) == -1){																			
																				arrData.push(data.avaliacao[i].cadastrado);																			
																			}																		
																		}																	
																		var html = "";																	
																		var count = 0;																	
																		var total = data.avaliacao.length;																	
																		html += '<style type="text/css">'+																	
																				'body{font-family:Arial, Helvetica, sans-serif	; }'+																			
																				'#content { margin:10px !important; }'+																			
																					'img{margin-Left:20px !important;}'+																				
																					'.img{float:left;}'+																				
																					'.p1{margin-top:10px; text-align:center; font-size:25px; font-weight:bold;}'+																				
																					'.p2{margin-top:10px; text-align:center; font-weight:bold;}'+																				
																					'.span1{font-weight:bold ;	font-size:20px; text-align:center;}'+																				
																					'.span2{font-weight:bold;	font-size:14px; text-align:center;}'+																				
																					'.field{margin-left:20; }'+																				
																					'.page{margin-top:10px; page-break-after:avoid;}'+																				
																					'.page2{margin-top:10px; page-break-after:always;}'+																				
																				'</style>'+																			
																				'<br/>';																			
								/*														html +=	'<div class="img">'+
																				'<img src="/simpacweb/images/logonovo.png" />'+
																				'</div>';*/																			
																		html += '<div class="span1">Avaliação Diária - ONLINE</div><br/>';																	
																		html += 'Treinamento: '+treinamento+"<br/>";																	
																		html += 'Unidade: '+unidade+"<br/>";																	
																		html += 'Período: '+periodo+"<br/>";																	
																		html += 'Sala: '+desala+"<br/>";																	
																		html += 'Instrutor: '+instrutor+"<br/><br/><br/>";																	
																		html += '<table width="100%	" cellpadding="0" cellspacing="5">';																	
																		var thead = '<thead><tr>';																	
																		thead += '<td width="40%"><b style="font-size:9px;">Aluno</b></td>';																	
																		thead += '<td width="20%"><b style="font-size:9px;">Cadastrado Em</b></td>';																	
																		thead += '<td width="3%"><b style="font-size:9px;">Nota	</b></td>';																	
																		thead += '<td width="37%"><b style="font-size:9px;">Comentário</b></td>';																	
																		thead += '</thead></tr>';																	
																		html += thead;
																		for(i=0 ; i<arrData.length ; i++){																	
																			var tbody = '<tbody>';																		
								//															tbody += '<tr>'+arrData[i]+'</tr>';																			
																			while(arrData[i] == data.avaliacao[count].cadastrado){																			
																				tbody += '<tr>'+																			
																					 '<td width="40%" style="font-size:10px;">'+data.avaliacao[count].aluno+'</td>'+
																					 '<td width="20%" style="font-size:10px;">'+data.avaliacao[count].cadastrado+'</td>'+
																					 '<td width="3%" style="font-size:10px;">'+data.avaliacao[count].nota+'</td>'+
																					 '<td width="37%" style="font-size:10px;">'+data.avaliacao[count].comentario+'</td></tr>';
																				count++;																			
																				if(count >= total) break;																			
																			}																		
																			tbody += "</tbody>";																		
																			html += tbody;																	
																		}																	
																		html += '</table>';																	
																		var printer = window.open('','Imprimir','width='+screen.width+', height='+screen.height+', top=0, left=0, scrollbars=yes, status=no, toolbar=no, location=no, directories=no, addressbar=no, menubar=no, resizable=yes,maximize=yes');									
																		printer.document.write(html);							
																		printer.print();																	
																	}else{																
																		Ext.Msg.alert("","Esse treinamento não apresenta avaliação(ões) online cadastrada(s)");																
																	}																
																}															
															});		
														}
													}
												}],
												items:[{
													xtype:'grid',
													id:'idgridavaliacaodetreinamento',
													bodyStyle:'overflow-x:hidden',
													store: groupingStore,
													frame:true,
													width: 700,
													height: 450,
													animCollapse: false,
													plugins:expander,
													sm: new Ext.grid.RowSelectionModel({
														singleSelect: true,
													}),
													cm: new Ext.grid.ColumnModel({
														defaults: {
															sortable: true
														},
														columns: [expander,{
															header: "Cadastro", 
															id:'idgridcadastrado',
															width: 20, 
															hidden:true,
															sortable: true, 
															format:'d/m/y H:i',
															dataIndex: 'cadastrado',
															renderer:func_comentario
														},{
															id:'idgridaluno',
															header: "Aluno", 
															width: 30, 
															sortable: true, 
															dataIndex: 'aluno',
															renderer:func_comentario
														},{
															header: "Avaliação", 
															width: 10, 
															sortable: true, 
															dataIndex: 'nota',
															renderer:avalColor,
														}],
													}),
													view: new Ext.grid.GroupingView({
														id:'group',
														forceFit:true,
														showGroupName: true,
														enableNoGroups: true,
														enableGroupingMenu: false,
														//hideGroupedColumn: true,
														//startCollapsed: true,
														groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Items" : "Item"]})'
													}),
												}],
											}).show();	
										}						
								}else{									
									Ext.Msg.alert("","Esse treinamento não apresenta avaliação(ões) online cadastrada(s)");									
									}								
								}								
							});		
						}else{						
							/*Ext.Ajax.request({											 
								url: URL + "TM_printAvalSimpac2.php",								
								params:{									
									idcursoagendado: idcursoagendado,									
									dtinicio: xt("avaliacao_diaria_data").getValue().format("Y-m-d"),									
									todas:0,									
									online:1									
								},*/
								/*var data = new Object();									
									data = Ext.util.JSON.decode(resp.responseText);	
									if(data.avaliacao != null){*/
								jsonStore.load({
									url: URL + "TM_printAvalSimpac2.php",								
									params:{									
										idcursoagendado: idcursoagendado,									
										dtinicio: xt("avaliacao_diaria_data").getValue().format("Y-m-d"),									
										todas:0,									
										online:1
									},
								callback:function(data){
									if (data[0]!=null){//Se tiver dados no store
									
										if(Ext.getCmp('winavaliacaoDeTreinamento2')){
											Ext.getCmp('winavaliacaoDeTreinamento2').show();
										}else{ 
											var win = new Ext.Window({
												id:'winavaliacaoDeTreinamento2',
												title:treinamento+' - Unidade: '+unidade+', Sala: '+desala+', Instrutor(a): '+instrutor+', Período: '+periodo,
												iconCls:'ico_avaliacao_10',
												width:500,
												height:600,

												modal:true,
												minimizable:true,
												maximizable:true,
												collapsible:true,
												layout:'fit',
												bbar:[{
													text:'Imprimir Lista',
													iconCls:'ico_print',
													handler:function(){						
														Ext.Ajax.request({																		 
															url: URL + "TM_printAvalSimpac.php",															
															params:{																
																idcursoagendado: idcursoagendado,																
																dtinicio: xt("avaliacao_diaria_data").getValue().format("Y-m-d"),																
																todas:0,																
																online:1																
															},															
															success:function(resp){																
																var data = new Object();																
																data = Ext.util.JSON.decode(resp.responseText);																
																if(data.avaliacao != null){																	
																	var arrData = new Array();							
																	var html = "";																	
																	var count = 0;																	
																	var total = data.avaliacao.length;																	
																	html += '<style type="text/css">'+		
																			'body{font-family:Arial, Helvetica, sans-serif	; }'+																	
																			'#content { margin:10px !important; }'+																			
																				'img{margin-Left:20px !important;}'+																				
																				'.img{float:left;}'+																				
																				'.p1{margin-top:10px; text-align:center; font-size:25px; font-weight:bold;}'+																				
																				'.p2{margin-top:10px; text-align:center; font-weight:bold;}'+																				
																				'.span1{font-weight:bold ;	font-size:20px; text-align:center;}'+																				
																				'.span2{font-weight:bold;	font-size:14px; text-align:center;}'+																				
																				'.field{margin-left:20; }'+																				
																				'.page{margin-top:10px; page-break-after:avoid;}'+																				
																				'.page2{margin-top:10px; page-break-after:always;}'+																				
																			'</style>'+																			
																			'<br/>';																			
							/*														html +=	'<div class="img">'+
																			'<img src="/simpacweb/images/logonovo.png" />'+
																			'</div>';*/																			
																	html += '<div class="span1">Avaliação Diária - ONLINE</div><br/>';																	
																	html += 'Treinamento: '+treinamento+"<br/>";																	
																	html += 'Unidade: '+unidade+"<br/>";																	
																	html += 'Período: '+periodo+"<br/>";																	
																	html += 'Sala: '+desala+"<br/>";																	
																	html += 'Instrutor: '+instrutor+"<br/><br/><br/>";																	
																	html += '<table width="100%	" cellpadding="0" cellspacing="5">';																		
																	var thead = '<thead><tr>';																	
																	thead += '<td width="40%"><b style="font-size:9px;">Aluno</b></td>';																	
																	thead += '<td width="20%"><b style="font-size:9px;">Cadastrado Em</b></td>';																	
																	thead += '<td width="3%"><b style="font-size:9px;">Nota	</b></td>';																	
																	thead += '<td width="37%"><b style="font-size:9px;">Comentário</b></td>';																											
																	thead += '</thead></tr>';																	
																	html += thead;		
																	for(i=0 ; i<total ; i++){																	
																		var tbody = '<tbody>';																		
							//															tbody += '<tr>'+arrData[i]+'</tr>';																			
																		tbody += '<tr>'+																		
																			 '<td width="40%" style="font-size:10px;">'+data.avaliacao[i].aluno+'</td>'+	
																			 '<td width="20%" style="font-size:10px;">'+data.avaliacao[i].cadastrado+'</td>'+	
																			 '<td width="3%" style="font-size:10px;">'+data.avaliacao[i].nota+'</td>'+
																			 '<td width="37%" style="font-size:10px;">'+data.avaliacao[i].comentario+'</td></tr>';
																		tbody += "</tbody>";																		
																		html += tbody;																	
																	}
																	html += '</table>';																	
																	var printer = window.open('','Imprimir','width='+screen.width+', height='+screen.height+', top=0, left=0, scrollbars=yes, status=no, toolbar=no, location=no, directories=no, addressbar=no, menubar=no, resizable=yes,maximize=yes');								  
																	printer.document.write(html);							
																	printer.print();																	
																}else{																
																	Ext.Msg.alert("","Esse treinamento não apresenta avaliação(ões) online cadastrada(s)");																
																}																
															}															
														});													
													}
												}],
												items:[{
													xtype:'editorgrid',
													id:'idgridavaliacaodetreinamento2',
													store: jsonStore,
													width: 700,
													height: 450,
													animCollapse: false,
													plugins:expander,
													viewConfig:{
														forceFit:true,
														getRowClass:function(record){/*
															console.log(record);
															var s = record.data.get('comentario');
															if (s==" s/ comentário"){
																return 'red';
															}else{
															 return 'black';
															}
														*/}
													},
													sm: new Ext.grid.RowSelectionModel({
														singleSelect: true,
													}),
													cm: new Ext.grid.ColumnModel({
														defaults: {
															sortable: true
														},
															columns: [expander,{
															header: "Cadastro", 
															id:'idgridcadastrado',
															width: 10, 
															sortable: true, 
															hidden:true,
															dataIndex: 'cadastrado',
															renderer:func_comentario
														},{
															id:'idgridaluno',
															header: "Aluno", 
															width: 30, 
															sortable: true, 
															dataIndex: 'aluno',
															renderer:func_comentario
														},{
															header: "Avaliação", 
															width: 10, 
															sortable: true, 
															dataIndex: 'nota',
															renderer:avalColor,															
														}],
													}),
												}],
											}).show();	
										}						
									}else{									
										Ext.Msg.alert("","Esse treinamento não apresenta avaliação(ões) online cadastrada(s)");									
									}									
								}								
						  	});						
						}
					}					
				}]	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////							
			},{				
				xtype:"fieldset",				
				title:"Impressão de Avaliação",				
				buttons:[{						 
					style:"margin-top:-5;",					
					text:"Final Média",					
					scale:"medium",					
					iconCls:"ico_printer",					
					id:"button_final_media",					
					handler:function(){
						
						Ext.Ajax.request({
										 
							url: URL + "TM_printAvalFinall.php",
							
							params:{
								
								idcursoagendado: idcursoagendado,
								
								final: 0,	// "0" => AVALIAÇÃO FINAL MÉDIA
								
							},
							
							success:function(resp){
								
								var data = new Object();
								
								data = Ext.util.JSON.decode(resp.responseText);
								
								if(data.avaliacao != null){
									
									var html = "";
									
									var nota = 0;
									
									html += '<style type="text/css">'+
									
											'body{font-family:Arial, Helvetica, sans-serif	; }'+
											
											'#content { margin:10px !important; }'+
											
												'img{margin-Left:20px !important;}'+
												
												'.img{float:left;}'+
												
												'.p1{margin-top:10px; text-align:center; font-size:25px; font-weight:bold;}'+
												
												'.p2{margin-top:10px; text-align:center; font-weight:bold;}'+
												
												'.span1{font-weight:bold ;	font-size:20px; text-align:center;}'+
												
												'.span2{font-weight:bold;	font-size:14px; text-align:center;}'+
												
												'.field{margin-left:20; }'+
												
												'.tabela{margin-left:250;}'+
												
												'.nota{font-weight:bold; float:right; margin-right:300;}'+
												
											'</style>'+
											
											'<br/>';
											
									html +=	'<div class="img">'+
									
											'<img src="/simpacweb/images/logonovo.png" />'+
											
											'</div>';
											
									html += '<div class="span1">Avaliação Final '+treinamento+'</div><br/>';
									
									html += '<div class="span1">De: '+dtinicio.format("d/m/Y")+' '+data.avaliacao[0].hinicio+' à '+dttermino.format("d/m/Y")+' '+data.avaliacao[0].htermino+'</div><br/><br /.';
									
									html += 'Instrutor: '+instrutor+'<br /><br/ >';
									
									html += '<div class=tabela>';
									
									html += '<table width:80% cellpadding:"0" cellspacing:"5">';
									
									var thead = '<thead><tr>';
									
									thead += '<td width="80%"><b style="font-size:12px;">Categoria</b></td>';
									
									thead += '<td width="20%"><b style="font-size:12px;">Nota</b></td>';
									
									thead += '</thead></tr>';
										
									html += thead;
										
									var tbody = '<tbody>';
											
									for(count = 0 ; count < data.avaliacao.length ; count++){
										
										tbody += '<tr>'+
										
												 '<td width="80%" style="font-size:12px;">'+data.avaliacao[count].topico+'</td>'+																	
												 
												 '<td width="20%" style="font-size:12x;">'+data.avaliacao[count].nota+'</td></tr>';
												 
										nota += parseInt(data.avaliacao[count].nota);
										
									}
									
									tbody += '</tbody>';
									
									html += tbody;
									
									html += '</table><br/>';
									
									html += 'Média: <div class=nota>' +(nota/4);
									
									html += '</div></div>';
									
									var printer = window.open('','Imprimir','width='+screen.width+', height='+screen.height+', top=0, left=0, scrollbars=yes, status=no, toolbar=no, location=no, directories=no, addressbar=no, menubar=no, resizable=yes,maximize=yes');
	  
									printer.document.write(html);

									printer.print();
									
								}else{
									
									Ext.Msg.alert("","Este treinamento não possui uma avaliação média final cadastrada");
								
								}
								
							}
							
						});
						
					},
					
					listeners:{
						
						mouseover:function(){
						
							xt("button_final_online").disable();
						
						},
						
						mouseout:function(){
						
							xt("button_final_online").enable();
						
						}
					
					}
					
				},{
					
					style:"margin-top:-5;",
					
					text:"Final On-line",
					
					scale:"medium",
					
					iconCls:"ico_printer",
					
					id: "button_final_online",
					
					handler:function(){
						
						Ext.Ajax.request({
										 
							url: URL + "TM_printAvalFinall.php",
							
							params:{
								
								idcursoagendado: idcursoagendado,
								
								final: 1,	// "0" => AVALIAÇÃO FINAL ON_LINE
								
							},
							
							success:function(resp){
								
								var space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
								
								var data = new Object();
								
								data = Ext.util.JSON.decode(resp.responseText);
								
								if(data.avaliacao != null){
									
									var arrData = new Array();
									
									var html = "";
									
									var count = 0;
									
									var nota = 0;
									
									for(i = 0 ; i  < data.avaliacao.length ; i++){
										
										if(arrData.indexOf(data.avaliacao[i].aluno) == -1){
											
											arrData.push(data.avaliacao[i].aluno);
											
										}
										
									}
																			
									html += '<style type="text/css">'+
									
											'body{font-family:Arial, Helvetica, sans-serif	; }'+
											
											'#content { margin:10px !important; }'+
											
												'img{margin-Left:20px !important;}'+
												
												'.img{float:left;}'+
												
												'.p1{margin-top:10px; text-align:center; font-size:25px; font-weight:bold;}'+
												
												'.p2{margin-top:10px; text-align:center; font-weight:bold;}'+
												
												'.span1{font-weight:bold ;	font-size:20px; text-align:center;}'+
												
												'.span2{font-weight:bold;	font-size:14px; text-align:center;}'+
												
												'.page1{page-break-after:always}'+
												
												'.page2{page-break-after:avoid}'+
												
												'.linha{border-bottom-style:dotted;  border-bottom-width:2px;}'+
												
												'.field{margin-left:20; }'+
												
												'.tabela{margin-left:250;}'+
												
												'.nota{font-weight:bold; float:right; margin-right:300;}'+
												
											'</style>'+
											
											'<br/>';
																					
									for(p=0 ; p < arrData.length ; p++){

										
										if(p == arrData.length-1){
										
											html += "<div class=page2>";
										
										}else{
											
											html += "<div class=page1>";
										
										}
										
										html +=	'<div class="img">'+
										
												'<img src="/simpacweb/images/logonovo.png" />'+
												
												'</div>';
											
										html += '<div class="span1">Avaliação Final On-line</div><br/>';
									
										html += '<div class="span1">De: '+dtinicio.format("d/m/Y")+' '+data.avaliacao[0].inicio+' à '+dttermino.format("d/m/Y")+' '+data.avaliacao[0].termino+'</div><br/><br /.';
										
										html += 'Treinamento: '+treinamento+' Unidade: '+unidade+' Periodo: '+periodo+' Instrutor: '+instrutor+'<br /><br/ >';
						
										html += '<table width="100%" cellpadding="0" cellspacing="8">';
										
										var tbody = "<tbody>";
										
										tbody += '<spa class=linha>'+arrData[p] + "</span><br />";
										
										nota = 0;
										
										while(arrData[p] == data.avaliacao[count].aluno){
											
											tbody += "<tr><td width='90%' style='font-size:12px' class=linha>"+data.avaliacao[count].pergunta+"</td>"+
											
														 "<td width='10%' style='font-size:12px'>"+data.avaliacao[count].nota+"</td></tr>"+
														 
													 "<tr><td style='font-size:12px'>"+space+" * "+data.avaliacao[count].comente+"</td></tr><tr></tr>";
											
											nota += parseInt(data.avaliacao[count].nota);
											
											count++;
											
											if(count >= data.avaliacao.length) break;
										}
										
										tbody += "</tbody>";
										
										html += tbody;
										
										html += "</table>";
										
										html += "Média: " + (nota/13).toFixed(2);
										
										html += "</div>";
										
									}
									
									var printer = window.open('','Imprimir','width='+screen.width+', height='+screen.height+', top=0, left=0, scrollbars=yes, status=no, toolbar=no, location=no, directories=no, addressbar=no, menubar=no, resizable=yes,maximize=yes');
	  
									printer.document.write(html);

									printer.print();
									
								}else{
								
									Ext.Msg.alert("","Esse treinamento não apresenta nenhuma avaliação cadastrada");
								
								}
								
							}
							
						});
					
					},
					
					listeners:{
						
						mouseover:function(){
						
							xt("button_final_media").disable();
						
						},
						
						mouseout:function(){
						
							xt("button_final_media").enable();
						
						}
					
					}
					
				}/*,{
					style:"margin-top:-5;",
					
					text:"Instrutores",
					
					scale:"medium",
					
					iconCls:"ico_printer",
					
					handler:function(){
						
						Ext.Ajax.request({
						
							url: URL + "printAvalInstAluno.php",
							
							params:{
								
								idcursoagendado: idcursoagendado
								
							},
							
							success:function(resp){
								
								var inicio, termino, total, pages;
								
								inicio = 0;
								
								termino = 18;
								
								var data = new Object();
									
								data = Ext.util.JSON.decode(resp.responseText);
								
								var html = "";
								
								total = data.mydata.length;
								
								pages = (data.mydata.length % 18 == 0) ? data.mydata.length / 18 : Math.floor(data.mydata.length / 18) + 1;
								
								if(data.mydata != null){
								
									html += '<style type="text/css">'+
									
												'body{font-family:Arial, Helvetica, sans-serif; font-size:11}'+
												
												'#content { margin:10px !important; }'+
												
												'img{margin-Left:20px !important;}'+
													
												'.img{float:left;}'+
													
												'.p1{margin-top:10px; text-align:center; font-size:25px; font-weight:bold;}'+
													
												'.p2{margin-top:10px; text-align:center; font-weight:bold;}'+
													
												'.span1{font-weight:bold ;	font-size:20px; text-align:center;}'+
												
												'.span2{font-weight:bold;	font-size:14px; text-align:center;}'+
													
												'.page1{page-break-after:always}'+
													
												'.page2{page-break-after:avoid}'+
													
												'.field{margin-left:20; }'+
										
												'.tabela{margin-left:250;}'+
													
												'.nota{font-weight:bold; float:right; margin-right:300;}'+
													
												'.curso{text-align:center; clear:left; font-size:11}'+
												
												'.tablealuno{border-collapse:collapse;}'+
												
											'</style>';
									
									   ////////////////////////////////////////loop FOR for PAGES	/////////////////////////
									   									   
									   for(pg = 0 ; pg < pages ; pg++){
									   
									   		if(pg == pages-1){
											
												html += "<div class=page2>";
											
											}else{
											
												html += "<div class=page1>";
											
											}
									   
									
											html +=	'<div class="img">'+ 
											
												'<img src="/simpacweb/images/logonovo.png" />'+
													
												'</div>';
	
											html += '<br /><br /><div class="span1">Avaliação Instrutores</div><br/>';
											
											html += '<table width="100%", cellspacing="10" class=curso>';
											
											html += '<tr><td width:"60%" style="size:10">'+treinamento+"</td><td> CH: "+data.mydata[0].ch+"</td></tr>";	
											html += '<tr><td width:"60%" style="size:10">Data: '+dtinicio.format("d/m/Y")+" a "+dttermino.format("d/m/Y")+"</td><td>Período: "+periodo+"</td></tr>";
											
											html += '<tr><td width:"60%" style="size:10">OBS: </td><td>Instrutor: '+instrutor+"</td></tr>";
											
											html += '</table>';
											
											html += "Srs(as) instrutore(as), favor preencher criteriosamente os dados abaixo conforme a legenda<br /><br />";
											
											html += '<table width="100%" celllspacing="10" class=curso">';
											
											html += '<tr style="font-size:11px"><td><b>E</b> = Excelente</td><td><b>B</b> = Bom</td><td><b>R</b> = Regular</td><td><b>P</b> = Péssimo</td></tr>'
											
											html += '</table>';
										
											html += "<br />Agradecemos a sua atenção e dedicação<br /><br /><br/>";
										
											html += '<table width="100%" border=1 class=tablealuno>';
											
											var thead = "<thead>";
												
												thead = "<tr>";
													
													thead += '<td width="50%" style="font-size:11px">Aluno</td>';
													
													thead += '<td width="10%" style="font-size:11px">Participação</td>';
													
													thead += '<td width="10%" style="font-size:11px">Assiduidade</td>';
													
													thead += '<td width="10%" style="font-size:11px">Assimilação</td>';
											
													thead += '<td width="20%" style="font-size:11px">Relacionamento Aula</td>';
												
												thead += "</tr>";
												
											thead += "</thead>";
											
											html += thead;
											
											var tbody = "<tbody>";
											
											for(record = inicio ; record < termino ; record++){
												
												tbody += '<tr><td width="50%" style="font-size:11px">'+data.mydata[record].aluno+'</td>';
												
												tbody += '<td width="10%" style="font-size:11px"></td>';
												
												tbody += '<td width="10%" style="font-size:11px"></td>';
												
												tbody += '<td width="10%" style="font-size:11px"></td>';
												
												tbody += '<td width="20%" style="font-size:11px"></td></tr>';
												
												if(record == total-1) break;
											}
											
											html += tbody;
											
											html += '</table>';
											
											html += "<br /><br /><b>Sugestão e comentários</b><br />";
											
											for(linha = 0 ; linha < 9 ; linha++){
												
												html += '<hr width:"100%"><br/>';
											
											}
											
											inicio += 18;
											
											termino += 18;
										
											html += "</div>";
									    }
									
										var printer = window.open('','Imprimir','width='+screen.width+', height='+screen.height+', top=0, left=0, scrollbars=yes, status=no, toolbar=no, location=no, directories=no, addressbar=no, menubar=no, resizable=yes,maximize=yes');
	  
										printer.document.write(html);

										printer.print();
								}else{

									Ext.Msg.alert("","Sem resultado");

								}
							
							}

						});
						
					}
					
				}*/]
				
			}]
			
		}],
		
		buttons:[{
				 
			text:"Fechar",
			
			handler:function(){
				
				xt("TM_escolha_avaliacao").close();
				
			}
			
		}]
		
	}).show();
	
}
</script>