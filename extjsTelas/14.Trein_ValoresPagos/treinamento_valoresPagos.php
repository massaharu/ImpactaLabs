<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

//$idcursoagendado = get('idcursoagendado');
?>

<script type="text/javascript">
	//Pega o id do cursoagendado via javascript	 
	var idcursoagendado = document.location.href.split("?");
	idcursoagendado = idcursoagendado[1];
	idcursoagendado = idcursoagendado.split("=");
	idcursoagendado = idcursoagendado[1];
	
	
	//printa DIV - recebe o id da div como parâmetro
	function printDivData(crtlid1){
		var ctrlcontent1 = document.getElementById(crtlid1);
		var printscreen = window.open('','','left=50,top=50,width=1000,height=700,toolbar=0,scrollbars=0,status=0');
		printscreen.document.write(ctrlcontent1.innerHTML);
		printscreen.document.close();
		printscreen.focus();
		printscreen.print();
		printscreen.close();
	}
	function func_comentario(value, metaData, record, rowIndex, colIndex, store){
		if(record.data.comentario!=" s/ comentário"){
			metaData.attr="style='color:blue;'"
		}
		return value;
	}
	
	Ext.onReady(function(){
						 
		lucro_total = 0;	
						 
		var storeInstrutorcursosministrados = new Ext.data.JsonStore({
			url: '/simpacweb/modulos/cursosagendados/json/getValoresPagosInstrutorcursosministrados.php',
			root: 'myData',
			fields:[{name: 'idinstrutor', type: 'int'},
					{name: 'idcurso', type: 'int'},
					{name: 'dtcadastramento' , type: 'date', dateFormat:'timestamp'},
					{name: 'valor', type: 'float'}],
			listeners:{
				load:function(){
					storeApostilaslivrosvalores.reload({
						url: '/simpacweb/modulos/cursosagendados/json/getValoresPagosApostilaslivrosvalores.php',					
						params:{
							IdCurso:recTreinamento.get('IdCurso')
						}
					});	
					
					recInstrutorcursosministrados = storeInstrutorcursosministrados.getAt(0),
					
					//Ext.getCmp('dfinstrvalorhora').setValue(formatcurrency(recInstrutorcursosministrados.get('valor'))+'  -------  '+formatcurrency(recInstrutorcursosministrados.get('valor')*recTreinamento.get('QtCargaHoraria')))					
					$('#tdinst_valorhora').html(formatcurrency(recInstrutorcursosministrados.get('valor')));
					$('#tdinst_valorhoraXqtdcargahoraria').html(formatcurrency(recInstrutorcursosministrados.get('valor')*recTreinamento.get('QtCargaHoraria')));
					
					lucro_total += recInstrutorcursosministrados.get('valor')*recTreinamento.get('QtCargaHoraria');			
					
					//console.log('storeInstrutorcursosministrados',lucro_total);
				}
			}
		});
		
		var storeApostilaslivrosvalores = new Ext.data.JsonStore({
			url: '/simpacweb/modulos/cursosagendados/json/getValoresPagosApostilaslivrosvalores.php',
			root: 'myData',
			fields:[{name: 'idcurso', type: 'int'},
					{name: 'vltotal', type: 'float'},
					{name: 'inlivro', type: 'bit'}],
			listeners:{
				load:function(){
					recApostilaslivrosvalores = storeApostilaslivrosvalores.getAt(0);
					if(storeApostilaslivrosvalores.getTotalCount() > 0){
						
						//Ext.getCmp('dfapostilas').setValue(formatcurrency(recApostilaslivrosvalores.get('vltotal'))+' ------- '+formatcurrency(recApostilaslivrosvalores.get('vltotal')*storeAlunos.getTotalCount()));
						$('#tdapostilas').html(formatcurrency(recApostilaslivrosvalores.get('vltotal')));
						$('#tdapostilasXqtdalunos').html(formatcurrency(recApostilaslivrosvalores.get('vltotal')*storeAlunos.getTotalCount()));
						lucro_total += recApostilaslivrosvalores.get('vltotal')*storeAlunos.getTotalCount(),
						
						//Ext.getCmp('lbdepesasalunos').setText('Despesas com '+qtde_alunos+' alunos: ------------------- '+formatcurrency(lucro_total)),
						$('#tddespesas').html("Despesas com "+qtde_alunos+" alunos:");
						$('#tddespesasalunos').html(formatcurrency(lucro_total));
												
						lucro_totalfinal = valor_unitario_total - lucro_total,	
						//Ext.getCmp('dftotallucro').setValue(' -------------------- '+formatcurrency(lucro_totalfinal));
						$('#tdtotallucro').html(formatcurrency(lucro_totalfinal));
						$(function(){
							if(lucro_totalfinal <= 0){
								$('#trtotallucro td').css({
									"color":"red",
									"background-color":"#F0D1D1",
									"font-weight":"bold"
								});
							}else{
								$('#trtotallucro td').css({
									"color":"green",
									"background-color":"#C8ECB9",
									"font-weight":"bold"
								});
							}
						});
					}else{
						storeApostilaslivrosvalores2.reload({
							url: '/simpacweb/modulos/cursosagendados/json/getValoresPagosApostilaslivrosvalores-relacao.php',
							params:{
								IdCurso:recTreinamento.get('IdCurso')
							}
						});						
						
						
						//Ext.getCmp('lbdepesasalunos').setText('Despesas com '+qtde_alunos+' alunos: ------------------- '+formatcurrency(lucro_total)),
						$('#tddespesas').html("Despesas com "+qtde_alunos+" alunos:");
						$('#tddespesasalunos').html(formatcurrency(lucro_total));
												
						lucro_totalfinal = valor_unitario_total - lucro_total,	
						//Ext.getCmp('dftotallucro').setValue(' -------------------- '+formatcurrency(lucro_totalfinal));
						$('#tdtotallucro').html(formatcurrency(lucro_totalfinal));
						$(function(){
							if(lucro_totalfinal <= 0){
								$('#trtotallucro td').css({
									"color":"red",
									"background-color":"#F0D1D1",
									"font-weight":"bold"
								});
							}else{
								$('#trtotallucro td').css({
									"color":"green",
									"background-color":"#C8ECB9",
									"font-weight":"bold"
								});
							}
						});
						
					}
					//console.log('storeApostilaslivrosvalores',lucro_total)
				}
			}
		});
		
		var storeApostilaslivrosvalores2 = new Ext.data.JsonStore({
			url: '/simpacweb/modulos/cursosagendados/json/getValoresPagosApostilaslivrosvalores-relacao.php',
			root: 'myData',
			fields:[{name: 'vltotal', type: 'float'}],
			listeners:{
				load:function(){
					recApostilaslivrosvalores2 = storeApostilaslivrosvalores2.getAt(0);
					
					if(storeApostilaslivrosvalores2.getTotalCount() > 0){
						
						//Ext.getCmp('dfapostilas').setValue(formatcurrencyl(recApostilaslivrosvalores2.get('vltotal'))+' - '+formatcurrency(recApostilaslivrosvalores2.get('vltotal')*storeAlunos.getTotalCount()));
						$('#tdapostilas').html(formatcurrencyl(recApostilaslivrosvalores2.get('vltotal')));
						$('#tdapostilasXqtdalunos').html(formatcurrency(recApostilaslivrosvalores2.get('vltotal')*storeAlunos.getTotalCount()));
					}else{
						$('#tdapostilas').html('N/A');
						$('#tdapostilasXqtdalunos').html('N/A');
					}
					//console.log('storeApostilaslivrosvalores2');
				}
			}
		});
		
		var storeTreinamento = new Ext.data.JsonStore({
			url: '/simpacweb/modulos/cursosagendados/json/getValoresPagosTreinamento.php',
			root: 'myData',
			baseParams:{
				idcursoagendado:idcursoagendado
			},
			fields: [{name: 'DesCurso',type: 'string'},
					 {name: 'DesEndereco',type: 'string'},
					 {name: 'DesPeriodo',type: 'string'},
					 {name: 'DesSala',type: 'string'},
					 {name: 'DesUnidade',type: 'string'},
					 {name: 'DtTermino',type: 'date',dateFormat:'timestamp'},
					 {name: 'Dtinicio',type: 'date', dateFormat:'timestamp'},
					 {name: 'IdCurso',type: 'int'},
					 {name: 'IdInstrutor',type: 'int'},
					 {name: 'IdSala',type: 'int'},
					 {name: 'NmInstrutor',type: 'string'},
					 {name: 'QtCargaHoraria',type: 'string'},
					 {name: 'VlTotal',type: 'float'},
					 {name: 'idcursoagendado',type: 'int'},
					 {name: 'qdte_dias', type: 'int'},
					 {name: 'idperiodo',type: 'int'}],
			autoLoad:true,	
			listeners:{
				load:function(){
					
					recTreinamento = storeTreinamento.getAt(0);
					
					Ext.getCmp('displayfielddescurso').setValue(recTreinamento.get('DesCurso')+' - '+recTreinamento.get('Dtinicio').format('d/m/Y H:i')+' à '+recTreinamento.get('DtTermino').format('d/m/Y H:i'));
					
					Ext.getCmp('displayfiedvltotal').setValue(formatcurrency(recTreinamento.get('VlTotal')));
					
					$('#mainwin #ext-gen130').html('Valores Pagos: '+recTreinamento.get('DesCurso')+' - '+recTreinamento.get('Dtinicio').format('d/m/Y H:i')+' à '+recTreinamento.get('DtTermino').format('d/m/Y H:i')+' | Valor: '+formatcurrency(recTreinamento.get('VlTotal')));
					
					storeInstrutorcursosministrados.reload({
						url: '/simpacweb/modulos/cursosagendados/json/getValoresPagosInstrutorcursosministrados.php',
						params:{
							IdInstrutor:recTreinamento.get('IdInstrutor'),
							IdCurso:recTreinamento.get('IdCurso')
						}
					})
					//console.log('storetreinamentos');
				}
			}
		});
		
		var storeAlunos = new Ext.data.JsonStore({
			url: '/simpacweb/modulos/cursosagendados/json/getValoresPagosAlunos.php',
			root: 'myData',
			baseParams:{
				idcursoagendado:idcursoagendado
			},
			fields: [{name: 'NrCPF',type: 'string'},
					 {name: 'idpedido',type: 'int'},
					 {name: 'idcurso1',type: 'int'},
					 {name: 'idcurso2',type: 'int'},
					 {name: 'matricula',type: 'string'},
					 {name: 'InTipo', type: 'string'},
					 {name: 'Aluno',type: 'string'},
					 {name: 'Dtinicio',type: 'date', dateFormat:'timestamp'},
					 {name: 'DtTermino',type: 'date', dateFormat:'timestamp'},
					 {name: 'DesOBS',type: 'string'},
					 {name: 'obsstatus', type:'string'},
					 {name: 'DesSala',type: 'string'},
					 {name: 'QtCargaHoraria',type: 'string'},
					 {name: 'DesPeriodo',type: 'string'},
					 {name: 'NmUsual',type: 'string'},
					 {name: 'DesUnidade',type: 'string'},
					 {name: 'Unitario',type: 'float'},
					 {name: 'Valor_Total',type: 'float'},
					 {name: 'idaluno',type: 'int'},
					 {name: 'LojaVirtual', type: 'int'},
					 {name: 'valor_total_1', type: 'float'},
					 {name: 'valor_total_2', type: 'float'}],
			autoLoad:true,
			listeners:{
				load:function(){					
					qtde_alunos = storeAlunos.getTotalCount();
					
					if(qtde_alunos == 0)
						Ext.MessageBox.warning('Aviso!','Não tem nenhum aluno inserido.');
					
					valor_unitario_total = storeAlunos.getAt(qtde_alunos-1).get('valor_total_1'),
					valor_total_total = storeAlunos.getAt(qtde_alunos-1).get('valor_total_2'),
										
					Ext.getCmp('txtvalorunitario_total').setText(formatcurrency(valor_unitario_total)),
					Ext.getCmp('txtvalortotal_total').setText(formatcurrency(valor_total_total)),					
					
					//Ext.getCmp('dfdiversos').setValue(formatcurrency(1.5)+' --------- '+formatcurrency((1.5*qtde_alunos)*recTreinamento.get('qdte_dias'))),	
					lucro_total += ((1.5*qtde_alunos)*recTreinamento.get('qdte_dias')),
					$('#tddiversos').html(formatcurrency(1.5));
					$('#tddiversosqtdalunosdias').html(formatcurrency((1.5*qtde_alunos)*recTreinamento.get('qdte_dias')));
					
					//Ext.getCmp('dfcomissaovendas').setValue('2,66%'+' ----------- '+formatcurrency((2.66*valor_unitario_total)/100)),
					lucro_total += ((2.66*valor_unitario_total)/100),
					$('#tdcomissao').html(formatcurrency((2.66*valor_unitario_total)/100));
		
					//Ext.getCmp('dfrisco').setValue('2%'+' --------------- '+formatcurrency((2*valor_unitario_total)/100)),
					lucro_total += ((2*valor_unitario_total)/100),
					$('#tdrisco').html(formatcurrency((2*valor_unitario_total)/100));
					
					//Ext.getCmp('dfcustofixo').setValue('17%'+' ------------- '+formatcurrency((17*valor_unitario_total)/100)),
					lucro_total += ((17*valor_unitario_total)/100),
					$('#tdcustofixo').html(formatcurrency((17*valor_unitario_total)/100));
					
					//Ext.getCmp('dfimpostos').setValue('10%'+' ------------- '+formatcurrency((10*valor_unitario_total)/100)),
					lucro_total += ((10*valor_unitario_total)/100),		
					$('#tdimpostos').html(formatcurrency((10*valor_unitario_total)/100));
					
					//console.log('storealunos',lucro_total)
				}
			}
		});		
		
		valortotal_total = 0;
		valorunitario_total = 0;
		
///////////////////////////////CENTER///////////////////////////////////////
		var gridValoresPagosTreinamento = new Ext.Panel({
			id:'idpanelgridvalorespagostreinamento',
			region: 'center',
			//collapsible: true,
			split:true,
			collapseMode:'mini',
			margins:'2 2 2 2',
			height:'100%',
			border:false,
			layout:'fit',
			padding:0,
			items:[{
				xtype: 'form',
				border:false,
				items:[{
					xtype: "grid",
					id: "grid_alunos",
					store: storeAlunos,
					width: '100%',
					height: 589,
					sm: new Ext.grid.RowSelectionModel({
						singleSelect: true
					}),
					columns: [ new Ext.grid.TemplateColumn({						
						header:'Orçamento',
						width:72,
						dataIndex:'idpedido',
						id:'hdcursos',
						tpl:LinkPermissao.cursoagendado,
						renderer:function(v,metaData,a,i,c,j){
							var recAlunos = storeAlunos.getAt(i);
							if(v == 0)
								return 's/orçamento';
								
							if(recAlunos.get('InTipo') == "J")
								metaData.attr="style='color:rgb(190, 20, 20);'";	
							return v;
						}
					}), new Ext.grid.TemplateColumn({
						header:'Matricula',
						width:110,
						dataIndex:'matricula',
						id:'hdcadastroid',
						tpl:LinkPermissao.matricula,
						renderer:function(v,metaData,a,i,c,j){
							var recAlunos = storeAlunos.getAt(i);
							
							if(recAlunos.get('InTipo') == "J")
								metaData.attr="style='color:rgb(190, 20, 20);'";	
							return v;
						}
					}),{
						header:'Aluno',
						width:204,
						dataIndex:'Aluno',
						renderer:function(v,metaData,a,i,c,j){
							var recAlunos = storeAlunos.getAt(i);
							
							if(recAlunos.get('InTipo') == "J")
								metaData.attr="style='color:rgb(190, 20, 20);'";	
							return v;
						}
					},{
						header:'Tipo',
						width:56,
						dataIndex:'InTipo',
						renderer: function(v,metaData,a,i,c,j){
							var recAlunos = storeAlunos.getAt(i);
							if(v == 'F'){							
								return 'Física';
							}else if(v == 'J'){								
								if(recAlunos.get('Unitario') == 0)
									metaData.attr="style='color:rgb(190, 20, 20);'";
								return 'Jurídica';
							}else
								if(recAlunos.get('Unitario') == 0)
									metaData.attr="style='color:#BE9514;'";
								return 'Indefinido';
						}
					},{
						header:'Observação',
						hidden:true,
						width:348,
						dataIndex:'obsstatus',
						renderer:function(v,metaData,a,i,c,j){
							var recAlunos = storeAlunos.getAt(i);
							
							if(recAlunos.get('InTipo') == "J")
								metaData.attr="style='color:rgb(190, 20, 20);'";	
							return v;
						}
					},{
						header:'Unitário',
						width:84,
						dataIndex:'Unitario',
						renderer: function(v,metaData,a,i,c,j){
							var recAlunos = storeAlunos.getAt(i);
							//console.log(v,metaData,a,i,c,j);
							if(isNaN(v))								
								return formatcurrency(0);
								
							if(recAlunos.get('LojaVirtual') == 0)
								metaData.attr="style='color:#9900FF;'";
							
							if(recAlunos.get('InTipo') == "J")
								metaData.attr="style='color:rgb(190, 20, 20);'";
								
							return formatcurrency(v);	
						}
					},{
						header:'Valor Total',
						width:79,
						dataIndex:'Valor_Total',
						renderer: function(v,metaData,a,i,c,j){
							var recAlunos = storeAlunos.getAt(i);
							if(isNaN(v)){
								return formatcurrency(0);
							}
							if(recAlunos.get('InTipo') == "J")
								metaData.attr="style='color:rgb(190, 20, 20);'";
							valortotal_total += parseFloat(v);
							//Ext.getCmp('txtvalortotal_total').setText(formatcurrency(valortotal_total));							
							return formatcurrency(v);
						}
					}],
					viewConfig: {
						forceFit: true
					},
					bbar:[{
						text:'Expandir',
						id:'btntotais',
						iconCls:'ico_arrow_next',
						enableToggle:true,
						toggleHandler: function(button,state){
							if (state == true) {	
								Ext.getCmp('idpanelgridvalorespagosfinal').collapse();
								Ext.getCmp('btntotais').setText('Totais');
								Ext.getCmp('btntotais').setIconClass('ico_arrow_next');	
							}else{
								Ext.getCmp('idpanelgridvalorespagosfinal').expand();
								Ext.getCmp('btntotais').setText('Expandir');	
								Ext.getCmp('btntotais').setIconClass('ico_arrow_back');	
							}
						}
					},'-',{
						text:'Pesquisar Curso Novo',
						iconCls:'ico_search',
						handler:function(){
							$('.x-shadow').css("display","none");
							$('#mainwin').addClass('animated bounceOut');
							setTimeout(function(){
								mainWIn.close();
								openWindow("/simpacweb/modulos/window/win.trein_valorespagos.js");
							},1000);
							//window.open("/simpacweb/labs/Massaharu/extjsTelas/14.Trein_ValoresPagos/win.trein_valorespagos.php");
						}
					},'->',{
						xtype:'label',
						text:'Total Unitario: ',
						style:'font-weight:bold;margin-right:2px;'
					},{		
						xtype:'label',
						id:'txtvalorunitario_total',
						style:'margin-right:4px;'
					},'-',{
						xtype:'label',
						text:'Total Valor Total: ',
						style:'font-weight:bold;margin-right:2px;'
					},{
						xtype:'label',
						id:'txtvalortotal_total'
					}],
					listeners:{
						'afterrender':function(){
							Ext.getCmp('txtvalorunitario_total').setText(valorunitario_total),
							Ext.getCmp('txtvalortotal_total').setText(valortotal_total)
						}
					}
				}]
			}]
		});
///////////////////////////////WEST///////////////////////////////////////
		var gridValoresPagosAlunos = new Ext.Panel({
			id:'idpanelgridvalorespagosfinal',
			region: 'west',
			//collapsible: true,
			collapsed:false,
			split:true,
			collapseMode:'mini',
			margins:'2 0 2 2',
			width:'40%',
			border:true,
			padding:5,
			layout:'fit',	
			bbar:[/*{
				text:'Imprimir',
				iconCls:'ico_print',
				handler:function(){					
					var id = 'grid_'+new Date().getTime();							
					var toprinter = $('<div id="'+id+'" />');
					
					toprinter.append($('#fstreinamento').clone());
					toprinter.append($('#valorespagos_totais').clone());
					
					
					$('#btntotais').click();
					
					setTimeout(function(){
						toprinter.append($('#grid_alunos .x-panel-body').clone());				
						
						toprinter.append($('.x-window-bbar').clone());
						
						$('body').append(toprinter);
						
						printer(id);
						
						toprinter.remove();
					},1000);
				}
			},*/{
				text:'Imprimir',
				iconCls:'ico_print',
				handler:function(){		
					window.open('print_valorespagos.php?idcursoagendado=idcursoagendado','Print','width=1000, height=700, top=0, left=0, scrollbars=yes, status=no, toolbar=no, location=no, directories=no, addressbar=no, menubar=no, resizable=yes,maximize=yes');
				}
			}],
			items:[{
				xtype:'fieldset',
				id:'fstreinamento',
				autoHeight:true,
				labelWidth:70,	
				defaults:{
					margins:'0 0 0 0',
				},
				items: [{
					xtype: 'displayfield',
					fieldLabel: 'Treinamento',
				},{
					xtype: 'displayfield',
					id: 'displayfielddescurso',
					hideLabel:true,
					style:'font-weight:bold;font-size:15px;'
				},{
					xtype: 'displayfield',
					fieldLabel:'Valor'
				},{
					xtype:'displayfield',
					id:'displayfiedvltotal',
					hideLabel:true,
					style:'font-weight:bold;font-size:15px;'
				}]
			},{
				xtype: 'form',
				id:'formvalorespagos',
				padding: 5,
				height:'100%',
				width:'100%',
				margin:200,
				border: false,										 
				items:[{
					xtype:'fieldset',
					id:'idfdvalorespagos',
					title:'Valores Pagos',
					autoHeight:true,
					collapsed:false,
					width:'95%',
					height:200,
					labelWidth:142,
					html:"<style type='text/css'>"+
							"#idfdvalorespagos{"+
							"	height:365px;"+
							"}"+
							"#trdespesasalunos td{"+
							"	background-color:#EEE;"+
							"}"+
							"#valorespagos_totais table{"+
							"	width:342px;"+
							"	border:0px;"+
							"}"+
							"#valorespagos_totais table tr{"+
							"	height:32px;"+
							"}"+
							"#legenda{"+
							"	color:#F00;"+
							"	margin-top:5px;"+
							"}"+
							"#idfdvalorespagos{"+
							"	height:309px;"+
							"}"+
						"</style>"+					
						"<div id='valorespagos_totais'>"+
							"<table>"+
								"<tr>"+
									"<td>Instrutor - Valor Hora:</td>"+
									"<td id='tdinst_valorhora'></td>"+
									"<td id='tdinst_valorhoraXqtdcargahoraria'></td>"+
								"</tr>"+
								"<tr>"+
									"<td>Apostilas:</td>"+
									"<td id='tdapostilas'></td>"+
									"<td id='tdapostilasXqtdalunos'></td>"+
								"</tr>"+
								"<tr>"+
									"<td>Diversos:</td>"+
									"<td id='tddiversos'></td>"+
									"<td id='tddiversosqtdalunosdias'></td>"+
								"</tr>"+
								"<tr>"+
									"<td>Comissão de Vendas:</td>"+
									"<td>2,66%</td>"+
									"<td id='tdcomissao'></td>"+
								"</tr>"+
								"<tr>"+
									"<td>Risco:</td>"+
									"<td>2%</td>"+
									"<td id='tdrisco'></td>"+
								"</tr>"+
								"<tr>"+
									"<td>Custo Fixo:</td>"+
									"<td>17%</td>"+
									"<td id='tdcustofixo'></td>"+
								"</tr>"+
								"<tr>"+
									"<td>Impostos:</td>"+
									"<td>10%</td>"+
									"<td id='tdimpostos'></td>"+
								"</tr>"+
								"<tr id='trdespesasalunos'>"+
									"<td id='tddespesas'></td>"+
									"<td></td>"+
									"<td id='tddespesasalunos'></td>"+
								"</tr>"+
								"<tr id='trtotallucro'>"+
									"<td>Total (lucro):</td>"+
									"<td></td>"+
									"<td id='tdtotallucro'></td>"+
								"</tr>"+
							"</table>"+	
						"</div>",
				},{
					xtype:'fieldset',
					id:'fslegenda',
					title:'Legenda',
					autoHeight:true,
					labelWidth:70,	
					html:
						"<div id='legenda'>◘ Não foi possível obter o valor correto.</div>"
				}]
			}]
		});
///////////////////////////////MAIN WINDOW/////////////////////////		
		var mainWIn = new Ext.Window({
			title:'Valores Pagos',
			id:'mainwin',
			iconCls:'ico_money',
			width:1000,
			height:628,
			resizable:true,
			minimizable:true,
			modal:true,
			border:false,
			layout:'border',
			items:[	
				   gridValoresPagosAlunos,
				   gridValoresPagosTreinamento
			],
			/*listeners:{
				'afterrender':function(){
					Ext.Ajax.request({
						url:'/simpacweb/modulos/cursosagendados/ajax/treinamento_ValoresPagos-get_idcursoagendado.php',
						success:function(retorno,b,c){
							console.log(retorno);
							//console.log(JSON.parse(retorno.responseText));
						}
					});
				}
			}*/
		}).show();	
	});
</script>
