/*
	# @AUTOR = renan #
	# @AUTOR = massaharu #
	# @AUTOR = ricardo #
	# @AUTOR = bcunha #
	
	versão antiga da janela: win.escolhaAvaliacao.js
*/
	/*
	 * VARIAVEIS
	 */
	
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
	var idperiodo    = SimpacWeb.vars.rec.json.idperiodo;

	//Arrays responsáveis por alimentar o grafico
	var dates = new Array(), ruins = new Array(), bons = new Array(), otimos = new Array();
	
	/*
	 * FUNÇÕES INTERNAS
	 */
	 	//Compara duas datas
	function dateComparsion(date1, comparison, date2) {
		//Ricardo [25/06/2012]
		if (comparison == null) { comparison = "<"; }
		date1 = new Date(date1);
		date2 = new Date(date2);
		switch (comparison) {
			case "<":
				if (date1.getFullYear() < date2.getFullYear()) {
					return true;
				}
				
				else if (date1.getFullYear() == date2.getFullYear()) {
					if (date1.getMonth() < date2.getMonth()) {
						return true;
					}
					
					else if (date1.getMonth() == date2.getMonth()) {
						if (date1.getDate() < date2.getDate()) {
							return true;
						}
						
						else {
							return false;
						}
					}
					
					else {
						return false;
					}
				}
				
				else {
					return false;
				}
				break;
			case ">":
				return dateComparsion(date2, "<", date1);
				break;
				
			case "<=":
				if (date2 == date1 && dateComparsion(date1, ">", date2)) {
					return true;
				} else {
					return false;
				}
				break;
			case ">=":
				if (date1 == date2 && dateComparsion(date1, "<", date2)) {
					return true;
				} else {
					return false;
				}
				break;
			case "==":
				if (date1 == date2) { return true; }
				else { return false; }
				break;
			case "!=":
				if (date1 != date2) { return true; }
				else { return false; }
				break;
		}
	}
	 
	function avalColor(value, metaData, record, rowIndex, colIndex, store){
		if (value == "&#211;timo" || value == 10) {
			return '<img src="/simpacweb/images/ico/16/avaliacao_10.png"/>';			
		} else if (value == "Bom" || value == 5) {
			return '<img src="/simpacweb/images/ico/16/avaliacao_5.png"/>';
		} else if (value == "Ruim" || value == 0) {
			return '<img src="/simpacweb/images/ico/16/avaliacao_0.png"/>';	 
		} else {
			return '<img src="/simpacweb/images/ico/16/avaliacao_10_cinza.png"/>';
		}
	}
	
	function func_comentario(value, metaData, record, rowIndex, colIndex, store){
		if (record.data.comentario != "s/ comentário" && record.data.comentario != " s/ comentário") {
			metaData.attr = "style='color:blue;'";
		}
		return value;
	}
	
	function func_comentario_instrutor(value, metaData, record, rowIndex, colIndex, store){
		if (record.data.descomentario != "s/ comentário" && record.data.descomentario != " s/ comentário"  && record.data.descomentario != ""  && record.data.descomentario != null) {
			metaData.attr = "style='color:blue;'";
		}
		return value;
	}
	
	function func_comentario_final(value, metaData, record, rowIndex, colIndex, store){
		if (record.data.descomentario != "") {
			metaData.attr="style='color:blue;'";
		}
		return value;
	}
	
	function convertDate(myDate) {
		myDate = myDate.split("-");
		return myDate[0]+"/"+myDate[1];
	}

	function convertToHighcharts(obj) {
		var date = "";
		var dates = new Array(); 
		var otimos = new Array(); 
		var bons = new Array();
		var ruins = new Array();
		
		var retorno = new Array();
		
		for (i = 0; i < obj.myData.length; i++) {
			if (date != obj.myData[i].cadastrado) {
				dates[dates.length] = convertDate(obj.myData[i].cadastrado);
				otimos[otimos.length] = 0;
				bons[bons.length] = 0;
				ruins[ruins.length] = 0;
			}
			
			if (obj.myData[i].nota == "&#211;timo") {
				otimos[otimos.length - 1] += 1;
			}
			
			else if (obj.myData[i].nota == "Bom") {
				bons[bons.length - 1] += 1;
			}
			
			else if (obj.myData[i].nota == "Ruim") {
				ruins[ruins.length - 1] += 1;
			}
			
			date = obj.myData[i].cadastrado;
		}
		
		for (i = 0; i < dates.length; i++) {
			if (otimos[i] == null) { otimos[i] = 0; }
			if (bons[i] == null) { bons[i] = 0; }
			if (ruins[i] == null) { ruins[i] = 0; }
		}
		
		retorno[retorno.length] = dates;
		retorno[retorno.length] = otimos;
		retorno[retorno.length] = bons;
		retorno[retorno.length] = ruins;
		return retorno;
	}
	
	function getOtimos(obj) {
		var otimos = 0;
		if (obj != null) {
			for (i = 0; i < obj.myData.length; i++) {
				if (obj.myData[i].nota == "&#211;timo") {
					otimos += 1;
				}
			}
		}
		return otimos;
	}
	
	function getBons(obj) {
		var bons = 0;
		if (obj != null) {
			for (i = 0; i < obj.myData.length; i++) {
				if (obj.myData[i].nota == "Bom") {
					bons += 1;
				}
			}
		}
		return bons;
	}
	
	function getRuins(obj) {
		var ruins = 0;
		if (obj != null) {
			for (i = 0; i < obj.myData.length; i++) {
				if (obj.myData[i].nota == "Ruim") {
					ruins += 1;
				}
			}
		}
		
		return ruins;
	}
	
	function getOtimos_final(obj) {
		var otimos = 0;
		for (i = 0; i < obj.data.items.length; i++) {
			if (obj.data.items[i].json.nrnota == 10) {
				otimos += 1;
			}
		}
		
		return otimos;
	}
	
	function getBons_final(obj) {
		var bons = 0;
		for (i = 0; i < obj.data.items.length; i++) {
			if (obj.data.items[i].json.nrnota == 5) {
				bons += 1;
			}
		}
		
		return bons;
	}
	
	function getRuins_final(obj) {
		var ruins = 0;
		for (i = 0; i < obj.data.items.length; i++) {
			if (obj.data.items[i].json.nrnota == 0 && obj.data.items[i].json.nrnota != null) {
				ruins += 1;
			}
		}
		
		return ruins;
	}
	
	function getYear(obj) {
		var myyear = obj.myData[0].cadastrado;
		myyear = myyear.split("-");
		return myyear[2];
	}
	
	function getDateFromStr(strng) {
		//retorna um array avisando quais posições do texto são data
		var createnew = true;
		var filters = new Array();
		var identifica = new Array();
		
		if (strng != null) {
			strng = strng.split(" ");
			for (i = 0; i < strng.length; i++) {
				if (strng[i].match("^([1-9]|0[1-9]|[1,2][0-9]|3[0,1])($|(/|\-)($|([0-1]|(0[1-9]|1[0,1,2]))($|(/|\-)($|[0-9]($|[0-9]($|[0-9]($|[0-9])))$))))") != null) {
					filters[filters.length] = strng[i];
					identifica[identifica.length] = "date";
					createnew = true;
				} else {
					if (createnew == true) {
						filters[filters.length] = "";
						identifica[identifica.length] = "name";
					}
					filters[filters.length - 1] += " " + strng[i];
					filters[filters.length - 1] = trim(filters[filters.length - 1]);
					createnew = false;
				}
			}
		}
		
		var matriz = new Array(2);
		matriz[0] = filters;
		matriz[1] = identifica;
		return matriz;
	}
	
	//---------------------------------------------------Bruno Lopes---------------------------------------------
	//-----------------------------------------------------------------------------------------------------------
	var storeAvalInstrutor = new Ext.data.JsonStore({
		url:'/simpacweb/labs/BCunha/Servicos/AvalDiariaInstrutor/json/avalDiariaInstrutor_list.php',
		root:'myData',
		baseParams:{
			cursoagendado:idcursoagendado,	
		},
		autoLoad:true,
		fields:[{
			name:'idcursoagendado'
		},
		{
			name:'inicioaula',
			type:'date',
			dateFormat:'timestamp'
		},
		{
			name:'dtcadastramento',
			type:'date',
			dateFormat:'timestamp'
		},
		{
			name:'terminoaula',
			type:'date',
			dateFormat:'timestamp'
		},
		{
			name:'idcurso'
		},
		{
			name:'descurso'
		},
		{
			name:'idinstrutor'	
		},
		{
			name:'nmusual'	
		},
		{
			name:'iniciocurso',
			type:'date',
			dateFormat:'timestamp'
		},
		{
			name:'terminocurso',
			type:'date',
			dateFormat:'timestamp'
		},
		{
			name:'descomentario'	
		}],
	});
	
	var dataHoje = new Date();
		
	//-----------------------------------------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------------------------------
	
	/*
	 * jQUERY
	 */
$(function(){
	jQuery.getScript("/simpacweb/modulos/treinamentos/highcharts/highcharts.js");
	jQuery.getScript("/simpacweb/modulos/treinamentos/highcharts/modules/exporting.js");
	
	if(Ext.getCmp("TM_escolha_avaliacao_v2")) {
		Ext.getCmp("TM_escolha_avaliacao_v2").show();	  
	} else {
	
		$.ajax({
			type: "POST",
			url: "/simpacweb/modulos/treinamentos/ajax/TM_printAvalSimpac2.php",
			dataType: 'json',
			data: $.param({
				idcursoagendado: idcursoagendado,
				todas: 1,
				online: 1
			}),
			success: function(retorno) {
		
		/*
		 * PLUGINS
		 */
		var expander = new Ext.ux.grid.RowExpander({
			tpl: new Ext.Template (
				'<b>Comentário:</b><br />{comentario}<br />'
			)
		});
		
		var expander_final = new Ext.ux.grid.RowExpander({
			tpl: new Ext.Template (
				'<b>Comentário:</b><br />{descomentario}<br />'
			)
		});
		
		var expanderAvalInstrutor = new Ext.ux.grid.RowExpander({
			tpl: new Ext.Template (
				'<b>Comentário:</b><br />{descomentario}<br />'
			)
		});
		
		/*
		 * STORES
		 */
		var groupingStore = new Ext.data.GroupingStore({
			reader: new Ext.data.JsonReader({
				root: 'myData',
				fields: [{
					name: 'aluno',
					type: 'string'
				}, {
					name: 'nota',
					type: 'string'
				}, {
					name: 'comentario',
					type: 'string'
				}, {
					name: 'cadastrado',
					type:'string'
				}],
			}),
			baseParams: {
				idcursoagendado: idcursoagendado,	
				todas:1,
				online:1
			},
			url: "/simpacweb/modulos/treinamentos/ajax/TM_printAvalSimpac2.php",
			sortInfo: {
				field: 'cadastrado',
				direction: "ASC"
			},
			groupField: 'cadastrado',
			autoLoad: true
		});
		
		var diaadia = new Ext.data.JsonStore({//store do piechart
			fields: [{
				name: 'nota',
				type: 'string'
			}, {
				name: 'quantidade',
				type: 'int'
			}],
			data: [
				{ nota: 'Ruim', quantidade: getRuins(retorno) },
				{ nota: 'Bom', quantidade: getBons(retorno) },
				{ nota: 'Ótimo', quantidade: getOtimos(retorno) }
			]
		});
		
		var nullcontent = new Ext.data.JsonStore({//store do piechart
			fields: [{
				name: 'nota',
				type: 'string'
			}, {
				name: 'quantidade',
				type: 'int'
			}],
			data: [
				{ nota: 'Vazio', quantidade: 1 }
			]
		});
		
		//OS GRAFICOS SÃO CRIADOS DENTRO DO EVENTO LOAD DESSE STORE, POR CAUSA DE PROBLEMAS COM O TEMPO DE EXECUÇÃO
		var groupingStore_avaliacaoFinal = new Ext.data.GroupingStore({
			reader: new Ext.data.JsonReader({
				root: 'myData',
				fields: [{
					name: 'desquestao',
					type: 'string'
				}, {
					name: 'nmaluno',
					type: 'string'
				}, {
					name: 'nrnota',
					type: 'string'
				}, {
					name: 'descomentario',
					type: 'string'
				}],
			}),
			baseParams: {
				idcursoagendado: idcursoagendado
			},
			url: "/simpacweb/modulos/treinamentos/ajax/avaliacaofinal_cursoagendado_get.php",
			sortInfo: {
				field: 'desquestao',
				direction: "ASC"
			},
			groupField: 'desquestao',
			autoLoad: true,
			listeners: {
				load: function() {
				
					//PROBLEMAS COM O TEMPO DE EXECUÇÃO ME LEVARAM A COLOCAR  A JANELA DENTRO DO JSON
					if (dateComparsion(dttermino, "<", new Date())) {
						var otms = getOtimos_final(groupingStore_avaliacaoFinal);
						var bons = getBons_final(groupingStore_avaliacaoFinal);
						var ruins = getRuins_final(groupingStore_avaliacaoFinal);
					
						var avaliacaofinal = new Ext.data.JsonStore({//store do piechart
							fields: [{
								name: 'nota',
								type: 'string'
							}, {
								name: 'quantidade',
								type: 'int'
							}],
							data: [
								{ nota: 'Ruim', quantidade: ruins },
								{ nota: 'Bom', quantidade: bons },
								{ nota: 'Ótimo', quantidade: otms }
							]
						});
					}
				
				/*
				 * SENCHA
				 */
					new Ext.Window({
						title: "Relatório de perguntas do treinamento "+treinamento,
						id: "TM_escolha_avaliacao_v2",
						height: 610,
						width: 700,
						resizable: false,
						draggable: true,						
						items: [{
							xtype: "tabpanel",
							id: "tabs_relatorios",
							activeTab: 0,
							items: [{
								//GRAFICOS
								title: 'Gráficos',
								items: [{
									xtype: 'panel',
									id: "container_do_grafico",
									style: 'height: 310px'
								}, {
									xtype: 'panel',
									border: false,
									id: "tab_relatorios_em_graficos",
									layout: 'table',
									layoutConfig: { columns: 2 },
									items: [{
										xtype: 'label',
										text: 'Avaliação diária',
										style: 'padding: 0px 100px; font-weight: bold; font-size: 16px',
										height: 5
									},  {
										xtype: 'label',
										text: 'Avaliação final',
										style: 'padding: 0px 100px; font-weight: bold; font-size: 16px',
										height: 5
									}, {
										xtype: "piechart",
										url: '/simpacweb/extjs/ext-3.3.1/resources/charts.swf',
										width: 230,
										height: 165,
										style: "margin: 15px 50px",
										dataField: 'quantidade',
										categoryField: 'nota',
										store: diaadia,
										series: [{
											style: {
												colors:[0xDF0F1E, 0xE2B411, 0x0FAD0F]
											}
										}]
									}],
									listeners: {
										afterrender: function() {
											var piechart;
											if (dateComparsion(dttermino, "<", new Date())) {
												piechart = new Ext.chart.PieChart({
													xtype: "piechart",
													url: '/simpacweb/extjs/ext-3.3.1/resources/charts.swf',
													width: 230,
													height: 165,
													style: "margin: 15px 50px",
													dataField: 'quantidade',
													categoryField: 'nota',
													store: avaliacaofinal,
													series: [{
														style: {
															colors:[0xDF0F1E, 0xE2B411, 0x0FAD0F]
														}
													}]
												});
											} else {
												piechart = new Ext.chart.PieChart({
													xtype: "piechart",
													url: '/simpacweb/extjs/ext-3.3.1/resources/charts.swf',
													width: 230,
													height: 165,
													style: "margin: 15px 50px",
													dataField: 'quantidade',
													categoryField: 'nota',
													store: nullcontent,
													series: [{
														style: {
															colors:[0x999999]
														}
													}]
												});
											}
											Ext.getCmp("tab_relatorios_em_graficos").add(piechart);
										}
									}
								}]
							}, {
								//TABELA DE AVALIAÇÕES DIARIAS
								title: 'Tabela das avaliações diárias (Aluno)',
								items: [{
									xtype:'grid',
									id: "grid_tabela_avaliacao_diaria",
									bodyStyle:'overflow-x:hidden',
									store: groupingStore,
									width: 685,
									height: 524,
									border: false,
									plugins: expander,
									sm: new Ext.grid.RowSelectionModel({
										singleSelect: true,
									}),
									cm: new Ext.grid.ColumnModel({
										columns: [expander, {
											header: "Cadastro", 
											hidden: true,
											format: 'd/m/y H:i',
											dataIndex: 'cadastrado',
											renderer: func_comentario
										}, {
											header: "Aluno", 
											width: 575,
											dataIndex: 'aluno',
											renderer: func_comentario
										}, {
											header: "Avaliação", 
											width: 75, 
											dataIndex: 'nota',
											renderer: avalColor,
										}],
									}),
									view: new Ext.grid.GroupingView({
										forceFit:true,
										showGroupName: true,
										enableNoGroups: true,
										enableGroupingMenu: false,
										groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Items" : "Item"]})'
									}),
									tbar: [{
										xtype: 'spacer',
										width: 10
									}, {
										xtype: "label",
										text: "Filtro de pesquisa"
									}, {
										xtype: 'spacer',
										width: 15
									}, {
										xtype: "textfield",
										id: "filtro_groupingStore",
										enableKeyEvents: true,
										listeners: {
											keyup: function() {
												var retornatudo = false;
												var txtArray = Ext.getCmp("filtro_groupingStore").getValue();
												txtArray = txtArray.toLowerCase();
												if (txtArray == "") {//se a pessoa não digitar nada, todas as coisas são retornadas
													retornatudo = true;
												}
												
												txtArray = getDateFromStr(txtArray);
												groupingStore.filterBy(function(rec, id) {
													if (retornatudo == true) {
														return rec;
													}
													
													for (i = 0; i < txtArray[0].length; i++) {
														if (txtArray[1][i] == "name") {//se não for uma data, ele verifica se o nome é igual
															var nome_procura = txtArray[0][i];
															var nome_encontra = rec.json.aluno;
															nome_encontra = nome_encontra.toLowerCase();
															var igual = true;
															
															//Verificando se o começo da digitação é igual, como se a pesquisa fosse "Ricardo Azzi" e o nome "Ricardo Azzi Silva"
															for (j = 0; j < nome_procura.length; j++) {
																if (nome_procura[j] != nome_encontra[j]) {
																	igual = false;
																}
															}
															
															if (igual == true) {
																return rec;
															}
														} else if (txtArray[1][i] == "date") {//Se ele for uma data, ele compara com as datas
															var date_procura = txtArray[0][i];
															date_procura = date_procura.replace("/", "-");
															var date_encontra = rec.json.cadastrado;
															date_encontra = date_encontra.replace("/", "-");
															
															var encontrou = true;
															for (j = 0; j < date_procura.length; j++) {
																if (date_procura[j] != date_encontra[j]) {
																	encontrou = false;
																}
															}
															
															if (encontrou == true) {
																return rec;
															}
														}
													}
												});
											}
										}
									}],
									bbar: [{
										text:'Desagrupar',
										id:'btngroup',
										iconCls: 'ico_arrow_out',
										enableToggle:true,
										toggleHandler: function(a,b){
											if (b == true) {
												groupingStore.clearGrouping();
												Ext.getCmp('btngroup').setText('Agrupar');	
												Ext.getCmp('btngroup').setIconClass('ico_arrow_in');	
											} else {
												groupingStore.groupBy('cadastrado');
												Ext.getCmp('btngroup').setText('Desagrupar');	
												Ext.getCmp('btngroup').setIconClass('ico_arrow_out');	
											}
										}		  
									},'-', {
										text: 'Imprimir avaliação diária',
										iconCls: 'ico_printer',
										handler: function(){
										
											Ext.Ajax.request({									 
												url: "/simpacweb/modulos/treinamentos/ajax/TM_printAvalSimpac.php",															
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
													} else {																
														Ext.Msg.alert("","Esse treinamento não apresenta avaliação(ões) online cadastrada(s)");																
													}																
												}															
											});		
											
										}
									}, "-"
									//-------------------------------Bruno Lopes ------------------------------------//
									//-------------------------------------------------------------------------------//
										/*{
											xtype: 'button',
											text: 'E-mail ao Aluno',
											id: 'emailParaALuno',
											iconCls: 'ico_aluno_edit',
											handler: function(){														
												//Verifica se alguma linha foi selecionada
												if(Ext.getCmp('grid_tabela_avaliacao_diaria').getSelectionModel().hasSelection()){
													//Atribuição de variável
													var recAvaliacaoFinal;
													var emailAluno;
													
													//Atribui à variável o valor da 'record' selecionada
													recAvaliacaoFinal = Ext.getCmp('grid_tabela_avaliacao_diaria').getSelectionModel().getSelected();
													
													//Atribui o e-mail do aluno à variável
													emailAluno = recAvaliacaoFinal.data.email;
													
													console.log(emailAluno);
												}
												else{
													Ext.Msg.alert('Aviso','Por favor, selecione uma avaliação.');	
												}
											}
										}*/
									//---------------------------------------------------------------------------//
									//---------------------------------------------------------------------------//
									]
								}]
							},
							//-------------------------------Bruno Lopes ------------------------------------//
							//-------------------------------------------------------------------------------//
							{
								title:'Tabela das avaliações diárias (Instrutor)',
								id:'panavalDiariaInstrutor'/*'winavalDiariaInstrutor'*/,
								items:[{
									//--------
									xtype:'grid',
									id:'idgridavaliacaoinstrutor',
									bodyStyle:'overflow-x:hidden',
									store: storeAvalInstrutor,
									//width:600,
									height:523,
									loadMask:true,
									//stripeRows:true,
									plugins:expanderAvalInstrutor,
									border:false,
									//animCollapse:false,
									sm: new Ext.grid.RowSelectionModel({
										singleSelect:true	
									}),									
									cm: new Ext.grid.ColumnModel({
										/*defaults:{
											sortable:true	
										},*/
										columns: [expanderAvalInstrutor, 
										{
											header:'Data',
											xtype:'datecolumn',
											format:'d/m/Y',
											width: 145,
											dataIndex:'inicioaula'
										},
										{
											header:'Instrutor',
											width: 380,
											dataIndex: "nmusual",
											renderer: func_comentario_instrutor
										}]
									}),	
									//--------
									tbar:[{
										xtype:'spacer',
										width:10	
									},
									'Filtro da Pesquisa ',
									{
										xtype:'spacer',
										width:20	
									},
									{
										xtype:'textfield',
										id:'filtroAvaliacoesDiariasInstrutor',
										width:200,
										emptyText:'Pesquise pela Data',
										enableKeyEvents:true,
										listeners: {
											keyup: function(rec) {
												storeAvalInstrutor.filterBy(function(rec){
													if (Ext.getCmp("filtroAvaliacoesDiariasInstrutor").getValue() != "") {
														var filtro = Ext.getCmp("filtroAvaliacoesDiariasInstrutor").getValue();
														filtro = filtro.split(" ");
														var content = rec.json.descomentario+" "+rec.json.descurso+" "+rec.json.nmusual;
														var dia = new Date(rec.json.inicioaula*1000).format("d/m/Y");
														content += " "+dia;
														
														var isValid = true;
														for (i = 0; i < filtro.length; i++) {
															if (content.indexOf(filtro[i]) == -1) {
																isValid = false;
															}
														}
														
														if (isValid == true) {
															return rec;
														}
													} else {
														return rec;
													}
												});
											}
										}
									}]					
								}]
							}
							//---------------------------------------------------------------------------//
							//---------------------------------------------------------------------------//
							]
						}],
						//Botões da tela antiga, referentes a inclusão de aliações diárias e finais
						bbar: [{
							xtype: "button",				
							text:"<b>Cadastrar Avaliação Diária</b>",
							id:"button_diaria",					
							handler:function(){						
								openWindowDefault('win.fichavaliacaodiaria.js');						
								//Ext.getCmp("TM_escolha_avaliacao_v2").close();						
							}				
						},"-",{					
							xtype: "button",				
							text:"<b>Cadastrar Avaliação Final</b>",					
							id: "button_final",					
							handler:function(){						
								openWindowDefault('win.fichavaliacaofinal.js');						
								//Ext.getCmp("TM_escolha_avaliacao_v2").close();						
							}				
						}],
						
						
							listeners: {
								afterrender: function() {
									if (dateComparsion(dttermino, "<", new Date())) {
											var tab = new Ext.Panel({
												//TABELA DA AVALIAÇÃO FINAL
												title: "Tabela da avaliação final (Aluno)",
												items: [{
													xtype:'grid',
													id: "grid_tabela_avaliacao_final",
													bodyStyle:'overflow-x:hidden',
													store: groupingStore_avaliacaoFinal,
													width: 685,
													height: 524,
													border: false,
													plugins: expander_final,
													sm: new Ext.grid.RowSelectionModel({
														singleSelect: true,
													}),
													cm: new Ext.grid.ColumnModel({
														columns: [expander_final, {
															header: "Questão", 
															hidden: true,
															dataIndex: 'desquestao',
															renderer: func_comentario_final
														}, {
															header: "Aluno", 
															width: 575,
															dataIndex: 'nmaluno',
															renderer: func_comentario_final
														}, {
															header: "Avaliação", 
															width: 75, 
															dataIndex: 'nrnota',
															renderer: avalColor
														}],
													}),
													view: new Ext.grid.GroupingView ({
														forceFit: true,
														showGroupName: true,
														enableNoGroups: true,
														enableGroupingMenu: false,
														groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Items" : "Item"]})'
													}),
													bbar: [{
														text:'Desagrupar',
														id: 'btngroup2',
														iconCls: 'ico_arrow_out',
														enableToggle:true,
														toggleHandler: function(a,b){
															if (b == true) {
																groupingStore_avaliacaoFinal.clearGrouping();
																Ext.getCmp('btngroup2').setText('Agrupar');	
																Ext.getCmp('btngroup2').setIconClass('ico_arrow_in');	
															} else {
																groupingStore_avaliacaoFinal.groupBy('desquestao');
																Ext.getCmp('btngroup2').setText('Desagrupar');	
																Ext.getCmp('btngroup2').setIconClass('ico_arrow_out');	
															}
														}		  
													},'-', {
														xtype: "button",
														text: "Imprimir avaliação final",
														iconCls: "ico_printer",
														id: "button_final_online",
														handler:function(){
															Ext.Ajax.request({
																url: "/simpacweb/modulos/treinamentos/ajax/TM_printAvalFinall.php",
																params: {
																	idcursoagendado: idcursoagendado,
																	final: 1
																},
																success:function(resp) {
																	var space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
																	var data = new Object();
																	data = Ext.util.JSON.decode(resp.responseText);
																	if (data.avaliacao != null) {
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
																				'<br />';
																				
																		for(p=0; p < arrData.length; p++){
																			if (p == arrData.length - 1){
																				html += "<div class=page2>";
																			} else {
																				html += "<div class=page1>";
																			}
																			
																			html +=	'<div class="img">'+
																					'<img src="/simpacweb/images/logonovo.png" />'+
																					'</div>';
																			html += '<div class="span1" style="font-size:14px">Avaliação Final On-line</div><br/>';
																			html += '<div class="span1" style="font-size:15px">'+treinamento+'</div><br/>';
																			html += '<div class="span1" style="font-size:14px">De: '+dtinicio.format("d/m/Y")+' '+data.avaliacao[0].inicio+' à '+dttermino.format("d/m/Y")+' '+data.avaliacao[0].termino+'</div><br/><br /.';
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
																		
																	} else {
																		Ext.Msg.alert("","Esse treinamento não apresenta nenhuma avaliação cadastrada");
																	}
																}
															});
														}
														
													}]
												}]
											});//final da adição do item
											Ext.getCmp("tabs_relatorios").add(tab);
									}//fim do IF que verifica se a Tab de avaliação final deve aparecer
								},
								'render':function(){
									console.log('<?=$_SESSION["id"]?>');
								}
							}
						
						
					}).show();
					
					
					/*
					 * HIGHCHARTS
					 */
					//O grafico será renderizado na window
						var obj = retorno;
						obj = convertToHighcharts(obj); //essa variavel cria as informações para o Highchart
						dates = obj[0];
						otimos = obj[1];
						bons = obj[2];
						ruins = obj[3];
						
						var chart = new Highcharts.Chart({//começo do highchart
							chart: {
								renderTo: 'container_do_grafico',
								type: 'line',
								marginRight: 130,
								marginBottom: 20,
								height: 285,
								animation: false
							},
							title: {
								text: 'Avaliação dos alunos do treinamento ' + treinamento,
								x: -20 //center
							},
							subtitle: {
								text: getYear(retorno),
								x: -20
							},
							xAxis: {
								categories: dates
							},
							yAxis: {
								title: {
									text: 'Notas'
								},
								min: 0,
								allowDecimals: false,
								plotLines: [{
									value: 0,
									width: 1,
									color: '#808080'
								}]
							},
							tooltip: {
								formatter: function() {
									return '<b>Quantidade de</b><br />' +
									'<b>'+this.series.name + ':</b> ' + this.y;
								}
							},
							legend: {
								layout: 'vertical',
								align: 'right',
								verticalAlign: 'top',
								x: -10,
								y: 100,
								borderWidth: 0
							},
							series: [{
								name: 'Ruim',
								data: ruins,
								color: "#D3000F"
							}, {
								name: 'Bom',
								data: bons,
								color: "#CEA513"
							}, {
								name: 'Ótimo',
								data: otimos,
								color: "#008B00"
							}]
						}); //fim do highchart
				}
			}
		});//fim do store que chama o sencha
		

			}//fim do success
		});//fim do ajax
	}//fim do else que verifica se a janela está ou não aberta
}); //fim do jquery