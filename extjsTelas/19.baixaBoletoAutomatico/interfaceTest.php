<?
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['BOOTSTRAP'] = false;//$GLOBALS['JSON'] = true; 
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 
?>
<!--<style type="text/css">
	#maindiv{
		margin:20px;
	}
	#maindiv input[type="file"]{
		float:left;
		width: 315px;
	}
	#maindiv button{
		width: 100px;
	}
</style>-->
<script type="text/javascript">
	
			
	Ext.onReady(function(){
		
	//CONSTANTS
		var xt = Ext.getCmp;
		var mask;
		var today = new Date();
		var date = new Date();
		date.setDate(1);
		date.setMonth(0);
		date.setYear(1970);		
		
		/*$uploadform = '<div id="maindiv"><form id="myForm" enctype="multipart/form-data"'+
			 'action="/simpacweb/labs/Massaharu/extjsTelas/19.baixaBoletoAutomatico/exemplo_itau.php" method="post">'+
				'<p>'+
					'<input type="hidden" name="MAX_FILE_SIZE" value="200000000000">'+
				'</p>'+
				'<label><input type="file" name="file"/></label>'+
				//'<input type="submit" value="enviar">'+
			'</form>'+
			'<button class="btn btn-primary"/>Enviar</button>'+	
		'</div>';*/
		
	//GENERAL FUNCTIONS
		function fn_moneyFormat(v){
				v = v.toString();
				return 'R$ '+v.replace(".",",");
		}
		
		function fn_getDateInt(data){
			
			var dataRetorno;
			dataRetorno = data.getFullYear()+"";
			
			if(data.getMonth() < 10){
				dataRetorno+= "0"+(data.getMonth()+1).toString();
			}else{
				dataRetorno+= (data.getMonth()+1).toString();
			}
			
			if(data.getDate() < 10){
				dataRetorno+= "0"+data.getDate().toString();
			}else{			
				dataRetorno+= data.getDate().toString();
			}
			
			return parseInt(dataRetorno);
		}
		
		function fn_getDateString(data){
			
			var dataRetorno;
			dataRetorno = data.getFullYear()+"-";
			
			if(data.getMonth() < 10){
				dataRetorno+= "0"+(data.getMonth()+1)+"-".toString();
			}else{
				dataRetorno+= (data.getMonth()+1)+"-".toString();
			}
			
			if(data.getDate() < 10){
				dataRetorno+= "0"+data.getDate().toString();
			}else{			
				dataRetorno+= data.getDate().toString();
			}
			
			return dataRetorno;
		}
		
		function fn_getDateStringFormated(data){
			
			var dataRetorno = "";
			
			
			if(data.getDate() < 10){
				dataRetorno+= "0"+data.getDate()+"/".toString();
			}else{			
				dataRetorno+= data.getDate()+"/".toString();
			}
			
			if(data.getMonth() < 10){
				dataRetorno+= "0"+(data.getMonth()+1)+"/".toString();
			}else{
				dataRetorno+= (data.getMonth()+1)+"/".toString();
			}
			
			dataRetorno+= data.getFullYear();
			
			return dataRetorno;
		}
		
		function fn_getTimeStringFormated(data){
			
			var dataRetorno = "";
			
			if(data.getHours() < 10){
				dataRetorno+= "0"+data.getHours()+":".toString();
			}else{			
				dataRetorno+= data.getHours()+":".toString();
			}
			
			if(data.getMinutes() < 10){
				dataRetorno+= "0"+data.getMinutes().toString();
			}else{			
				dataRetorno+= data.getMinutes().toString();
			}
			
			return dataRetorno;
			
		}
		
		function fn_reloadStoreArquivoRetornoByData(dtinicio, dtfinal){
			
			storearquivoretorno_list.reload({
				params:{
					dtinicio:dtinicio,
					dtfinal:dtfinal
				},
				callback:function(){
					xt('idpanelsouth').collapse();
					xt('gridarquivoretorno').setHeight(321);
				}
			});
		}
		
		function fncolor(value, metaData, record, rowIndex, colIndex, store){
			var nrdocumento = parseInt($.trim(record.data.num_documento));
			if(!isNaN(nrdocumento)){
				Ext.Ajax.request({
					url:'/simpacweb/ajax/loadPagamento.php',
					params:{
						idpagamento:nrdocumento
					},
					success:function(response){
						var data = Ext.util.JSON.decode(response.responseText).data;
						
						if(data.idrecibo){
							
							//console.log(data.idrecibo, record.data.nome_sacado);
							return value = 1;
							
						}
						/*var data = b.result.data;
						
						if(data.idrecibo){
							Ext.Msg.alert('','Este pagamento já foi confirmado!');
							Ext.getCmp('btn-confirmarPagamento').setDisabled(true);
						}*/
					}
				})
			}
		}
		
	//STORES
		var storearquivoretorno_list = new Ext.data.JsonStore({
				url:'/simpacweb/labs/Massaharu/extjsTelas/19.baixaBoletoAutomatico/json/arquivoretorno_list.php',
				root:'myData',
				fields:[{name:'idarquivo', 			 type:'int'},
					{name:'cod_registrotipo', 		 type:'int'},
					{name:'desregistrotipo', 		 type:'string'},
					{name:'servicotipo', 			 type:'string'},
					{name:'agencia', 				 type:'string'},
					{name:'conta', 					 type:'string'},
					{name:'dac', 					 type:'string'},
					{name:'desempresa', 			 type:'string'},
					{name:'cod_banco', 				 type:'string'},
					{name:'desbanco', 				 type:'string'},
					{name:'dtgeracao', 				 type:'date', dateFormat:'timestamp'},
					{name:'nrseq_arq_retorno',		 type:'string'},
					{name:'dtcredito', 				 type:'date', dateFormat:'timestamp'},
					{name:'cob_direta_num_aviso',    type:'string'},
					{name:'cob_direta_qtd_titulos',  type:'string'},
					{name:'cob_direta_vlr_total',    type:'float'},
					{name:'cob_simples_num_aviso', 	 type:'string'},
					{name:'cob_simples_qtd_titulos', type:'string'},
					{name:'cob_simples_vlr_total',   type:'float'},
					{name:'cob_vinc_num_aviso', 	 type:'string'},
					{name:'cob_vinc_qtd_titulos', 	 type:'string'},
					{name:'cob_vinc_valor_total', 	 type:'float'},	
					{name:'nrparcela', 				 type:'string'},
					{name:'vlr_total_arquivo', 		 type:'string'},	
					{name:'instatus', 				 type:'bit'},
					{name:'dtcadastro', 			 type:'date', dateFormat:'timestamp'}]
			});	
			
			var storearquivoretornotransacaobyarquivo_list = new Ext.data.JsonStore({
				url:'/simpacweb/labs/Massaharu/extjsTelas/19.baixaBoletoAutomatico/json/arquivoretornotransacao_list.php',
				root:'myData',
				fields:[{name:'idarquivotransacao', 		 type:'int'},
					{name:'idarquivo', 						 type:'int'},
					{name:'cod_registrotipo', 				 type:'string'},
					{name:'desregistrotipo', 				 type:'string'},
					{name:'agencia_cobradora', 				 type:'string'},
					{name:'cod_carteira', 					 type:'string'},
					{name:'num_carteira', 					 type:'string'},
					{name:'cod_inscricao', 					 type:'string'},
					{name:'num_inscricao', 					 type:'string'},
					{name:'cod_instr_cancelada', 			 type:'string'},
					{name:'cod_liquidacao', 				 type:'string'},
					{name:'cod_ocorrencia', 				 type:'string'},
					{name:'desocorrencia', 					 type:'string'},
					{name:'dac_agencia_cobradora', 			 type:'string'},
					{name:'dac_nosso_numero', 				 type:'string'},
					{name:'data_credito', 					 type:'date', dateFormat:'timestamp'},
					{name:'data_ocorrencia', 				 type:'date', dateFormat:'timestamp'},
					{name:'data_vencimento', 				 type:'date', dateFormat:'timestamp'},
					{name:'erros', 							 type:'string'},
					{name:'especie', 						 type:'string'},
					{name:'nome_sacado', 					 type:'string'},
					{name:'nosso_numero', 					 type:'string'},
					{name:'num_documento', 					 type:'string'},
					{name:'tarifa_cobranca', 				 type:'string'},
					{name:'uso_empresa', 					 type:'string'},
					{name:'valor_abatimento', 				 type:'float'},
					{name:'valor_desconto', 				 type:'float'},
					{name:'valor_iof', 						 type:'float'},
					{name:'valor_juros_mora', 				 type:'float'},
					{name:'valor_outros_creditos', 			 type:'float'},
					{name:'valor_principal', 				 type:'float'},
					{name:'valor_titulo', 					 type:'float'},
					{name:'instatus', 						 type:'bit'},
					{name:'dtcadastro', 					 type:'date', dateFormat:'timestamp'}]
			});	
			
			var storearquivoocorrencias_list = new Ext.data.JsonStore({
				url:'/simpacweb/labs/Massaharu/extjsTelas/19.baixaBoletoAutomatico/json/arquivoocorrencias_list.php',
				root:'myData',
				fields:[{name:'idocorrencia', 	type:'int'},
					{name:'cod_ocorrencia', 	type:'int'},
					{name:'desocorrencia', 		type:'string'},
					{name:'instatus', 			type:'bit'},
					{name:'dtcadastro', 		type:'date', dateFormat:'timestamp'}]
			});	
			
		//EXPANDERS
			var expander1 = new Ext.ux.grid.RowExpander({
				tpl : new Ext.Template(
					'<div style="background-color:rgb(223, 223, 223);;"><table><tr><td><p style="margin-left:60px;"><b>Cobrança Direta - Nrº Aviso:</b> {cob_direta_num_aviso}</p><p style="margin-left:60px;"><b>Cobrança Direta - Qtde. Títulos:</b> {cob_direta_qtd_titulos}</p><p style="margin-left:60px;"><b>Cobrança Direta - Valor Total:</b> R$ {cob_direta_vlr_total}</p></td><td><p style="margin-left:60px;"><b>Cobrança Simples - Nrº Aviso:</b> {cob_simples_num_aviso}</p><p style="margin-left:60px;"><b>Cobrança Simples - Qtde. Títulos:</b> {cob_simples_qtd_titulos}</p><p style="margin-left:60px;"><b>Cobrança Simples - Valor Total:</b> R$ {cob_simples_vlr_total}</p></td><td><p style="margin-left:60px;"><b>Cobrança Vinculada - Nrº Aviso:</b> {cob_vinc_num_aviso}</p><p style="margin-left:60px;"><b>Cobrança Vinculada - Qtde. Títulos:</b> {cob_vinc_qtd_titulos}</p><p style="margin-left:60px;"><b>Cobrança Vinculada - Valor Total:</b> R$ {cob_vinc_valor_total}</p></td></tr></table></div>'
				)
			});	
			var expander2 = new Ext.ux.grid.RowExpander({
				tpl : new Ext.Template(
					'<div style="background-color:rgb(223, 223, 223);">'+
					'<table>'+
						'<tr>'+
							'<td>'+
								'<p style="margin-left:60px;"><b>Erros:</b> {erros}</p>'+
								'<p style="margin-left:60px;"><b>Espécie:</b> {especie}</p>'+
							'</td>'+
							'<td>'+
								'<p style="margin-left:60px;"><b>Data de Crédito:</b> {data_credito}</p>'+
								'<p style="margin-left:60px;"><b>Código da Carteira:</b> {cod_carteira}</p>'+
							'</td>'+
						'</tr>'+
					'</table></div>'
				)
			});	
		
		var mainWin = new Ext.Window({
			title:'Baixa de Boleto Automática (Arq. Retorno CNAB 400) Itaú v7',		
			id:'winarquivoretornocnab400itauv7',
			iconCls:'ico_folder_files',
			height: 300,
			width: 520,
			modal:true,
			resizable: false,
			minimizable:true,
			//html:$uploadform,
			items:[{
				xtype:'form',
				id:'formsolicitacaobolsa',
				padding: 15,
				height:490,
				width:515,
				margin:'10',
				border: false,
				buttonAlign:'right',
				labelWidth:120,
				defaults:{
					labelWidth:300
				},
				items:[{
					xtype:'compositefield',
					items:[{
						xtype:'textfield',
						fieldLabel:"Arquivo",
						id:'file_to_input',
						name:'file_to_input',
						margins:'0 20 30 0',
						inputType:'file'
					},{
						xtype:'button',
						text:'Enviar',
						id:'send_file',
						scale:'medium',
						iconCls:'ico_send_feedback'
					}]
				},{
					xtype:'textfield',
					fieldLabel:"Tamanho do Arquivo",
					anchor:'100%',
					margins:'50 0 0 0',
					id:'file_data_size',
				},{
					xtype:'textfield',
					fieldLabel: "Número de registro",
					anchor:'100%',
					id:'file_data_register',
				},{
					xtype:'textfield',
					fieldLabel:"Quantidade de lotes",
					anchor:'100%',
					id:'file_data_lote',
				}],
			}],
			buttons:[{
/////////////////////// ADMINISTRATIVO DE OCORRÊNCIAS /////////////////////////////////////////////////////////
					text:'Administrativo de Ocorrências',
					id:'btnadmocorrencias',
					iconCls:'ico_essen_config',
					scale:'large',
					width:200,
					style:'margin-left:-90px; margin-right:50px',
					handler:function(){
						if(xt('winadmocorrencias')){
							xt('winadmocorrencias').show();
						}else{
							var windowadmocorrencias = new Ext.Window({
								id:'winadmocorrencias', 
								iconCls:'ico_essen_config',
								title:'Administrativo de Ocorrências',
								height:569,
								width:570,
								modal:true,
								border:false,
								layout:'fit',
								bbar:['Cod. Ocorrência: ',{
									xtype:'numberfield',
									id:'nrcodocorrencia',
									width:50,
									height:20,
									style:'margin-right:5px;'
								},'Ocorrência: ',{
									xtype:'textfield',
									id:'txtocorrencia',
									width:250,
									height:20,
									style:'margin-right:5px;'
								},'-',{
									text:'Salvar',
									iconCls:'ico_save',
									handler:function(){
										function fn_validFields(id){
											if(xt(id).getValue() != ""){
												$('#'+id).css('border-color','green');
												Ext.MessageBox.info("Info!","Ocorrência :\""+xt(id).getValue()+"\" <br /> Salvo com sucesso!");
												
												return true;
											}else{
												$('#'+id).css('border-color','red');
												Ext.MessageBox.warning("Alerta!","Insira todos os campos.");
												return false;
											}
										}
											
											
										if(fn_validFields('nrcodocorrencia') && fn_validFields('txtocorrencia')){
											Ext.Ajax.request({ 
												url:'/simpacweb/labs/Massaharu/extjsTelas/19.baixaBoletoAutomatico/ajax/arquivoocorrencias_save.php',
												params:{
													cod_ocorrencia:xt('nrcodocorrencia').getValue(),
													desocorrencia:xt('txtocorrencia').getValue()
												},			
												success:function(){
												  	xt('nrcodocorrencia').setValue("");
													xt('txtocorrencia').setValue("");
													
													mask.show();
													
													storearquivoocorrencias_list.reload({
														callback:function(){
															mask.hide();
														}
													});
												}
											});	
										}	
									}
								},'-',{
									text:'Excluir',
									iconCls:'ico_remove',
									id:'btnexcluirocorrencia',
									disabled:true,
									handler:function(){
										Ext.Ajax.request({ 
											url:'/simpacweb/labs/Massaharu/extjsTelas/19.baixaBoletoAutomatico/ajax/arquivoocorrencias_delete.php',
											params:{
												idocorrencia:xt('gridadmocorrencias').getSelectionModel().getSelected().get('idocorrencia')
											},			
											success:function(){
												mask.show();
												storearquivoocorrencias_list.reload({
													callback:function(){
														mask.hide();
													}
												});
											}
										});	
									}
								}],
								items:[{
									xtype:'editorgrid',
									id:'gridadmocorrencias',
									store:storearquivoocorrencias_list,
									height:145,
									width:3500,
									autoScroll:true,
									loadMask:true,
									stripeRows:true,
									border:false,
									viewConfig:{
										 forceFit:true
									},
									sm: new Ext.grid.RowSelectionModel({
										singleSelect: true,
									}),
									cm:new Ext.grid.ColumnModel({
										columns:[{
											hidden:true,
											dataIndex:'idocorrencia'
										},{
											header:'Cód. da Ocorrência',
											width:40,
											dataIndex:'cod_ocorrencia',
											editor: new Ext.form.TextField({
												AllowBlank: false,							  
											})
										},{
											header:'Ocorrência',
											dataIndex:'desocorrencia',
											editor: new Ext.form.TextField({
												AllowBlank: false,							  
											})
										}]
									}),
									listeners:{					
										afteredit: function(e){	
											Ext.Ajax.request({ 
												  url:'/simpacweb/labs/Massaharu/extjsTelas/19.baixaBoletoAutomatico/ajax/arquivoocorrencias_save.php',
												  params:{
													 idocorrencia:e.record.get('idocorrencia'),
													 cod_ocorrencia:e.record.get('cod_ocorrencia'),
													 desocorrencia:e.record.get('desocorrencia')
												  },			
												  success:function(){
													 e.record.commit();
												}
											});	
										},
										rowclick:function(){
											if(xt('gridadmocorrencias').getSelectionModel().getSelected()){
												xt('btnexcluirocorrencia').enable();		
											}else{
												xt('btnexcluirocorrencia').disable();		
											}
										}
									}
								}],
								listeners:{
									'afterrender':function(){
										mask = new Ext.LoadMask(xt('winadmocorrencias').body,{msg:'Aguarde...'});
										
										mask.show();
										storearquivoocorrencias_list.reload({
											callback:function(){
												mask.hide();
											}
										});
									}
								}
							}).show();
						}
					}
				},{
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////// RELATÓRIO DE DADOS DO ARQUIVO DE RETORNO /////////////////////////////////////////////////////////					
					text:'Relatório Dados Arquivo Retorno',
					id:'btnrelatorioarquivo',
					iconCls:'ico_file',
					scale:'large',
					width:200,
					handler:function(){
						if(xt('winarquivoretorno')){
							xt('winarquivoretorno').show();
						}else{
							var southPanel = new Ext.Panel({
								region: 'south',
								id:'idpanelsouth',
								split: true,
								collapsible:true,
								height:190,
								autoScroll:true,
								collapsed:true,
								border:false,
								items:[{
									xtype:'grid',
									id:'gridarquivoretornodetalhes',
									store:storearquivoretornotransacaobyarquivo_list,
									height:145,
									width:3500,
									//plugins:expander2,
									autoScroll:true,
									loadMask:true,
									stripeRows:true,
									border:false,
									viewConfig:{
										 forceFit: true
									},
									sm: new Ext.grid.RowSelectionModel({
										singleSelect: true,
									}),
									cm:new Ext.grid.ColumnModel({
										columns:[/*expander2,*/{
											hidden:true,
											header:'idarquivo Transação ',
											width:25,
											dataIndex:'idarquivotransacao'
										},{
											hidden:true,
											header:'Id do Arquivo',
											width:45,
											dataIndex:'idarquivo'
										},{ 
											hidden:true,
											header:'Tipo de Registro',
											dataIndex:'desregistrotipo'
										},{
											header:'Agência Cobradora',
											width:45,
											dataIndex:'agencia_cobradora'
										},{ 
											header:'Nrº Carteira',
											width:25,
											dataIndex:'num_carteira'
										},{ 
											header:'Cod. Inscrição',
											width:35,
											dataIndex:'cod_inscricao'
										},{ 
											header:'Nrº Incrição',
											dataIndex:'num_inscricao'
										},{ 
											header:'Cod. Instrução Cancelada',
											dataIndex:'cod_instr_cancelada'
										},{ 
											header:'Cod. Liquidação',
											width:40,
											dataIndex:'cod_liquidacao'
										},{ 
											header:'Ocorrência',
											dataIndex:'desocorrencia'
										},{ 
											header:'DAC Agência Cobradora',
											dataIndex:'dac_agencia_cobradora'
										},{ 
											header:'DAC Nosso número',
											dataIndex:'dac_nosso_numero'
										},{ 
											xtype:'datecolumn',
											header:'Data de Ocorrência',
											dataIndex:'data_ocorrencia',
											format:'d/m/Y'
										},{ 
											xtype:'datecolumn',
											header:'Data de Vencimento',
											dataIndex:'data_vencimento',
											format:'d/m/Y'
										},{ 
											header:'Nome Sacado',
											dataIndex:'nome_sacado'
										},{ 
											header:'Nosso número',
											width:40,
											dataIndex:'nosso_numero'
										},{ 
											header:'Nrº Documento',
											width:40,
											dataIndex:'num_documento'
										},{ 
											header:'Tarifa Cobrança',
											width:50,
											dataIndex:'tarifa_cobranca'
										},{ 
											header:'Abatimento',
											width:40,
											dataIndex:'valor_abatimento',
											renderer:fn_moneyFormat
										},{ 
											header:'Desconto',
											width:40,
											dataIndex:'valor_desconto',
											renderer:fn_moneyFormat
										},{ 
											header:'IOF',
											width:40,
											dataIndex:'valor_iof',
											renderer:fn_moneyFormat
										},{ 
											header:'Valor Título',
											width:40,
											dataIndex:'valor_titulo',
											renderer:fn_moneyFormat
										},{ 
											header:'Juros Mora',
											width:40,
											dataIndex:'valor_juros_mora',
											renderer:fn_moneyFormat
										},{ 
											header:'Outros Créditos',
											width:40,
											dataIndex:'valor_outros_creditos',
											renderer:fn_moneyFormat
										},{ 
											header:'Valor Principal',
											dataIndex:'valor_principal',
											renderer:fn_moneyFormat
										}]
									}),
									listeners:{
										'cellcontextmenu':function(grid,row,cell,e){
											//console.log(grid,row,cell,e);
											new Ext.menu.Menu({
												items:[{
													text:'Confirmar Pagamento',
													iconCls:'ico_accept'
												}]
											}).showAt(e.xy);
										}
									}
								}]
							});
							
							var centerPanel = new Ext.Panel({
								region: 'center',
								id:'idpanelcenter',
								split: true,
								collapsed:false,
								autoScroll:true,
								tbar:['De: ',{
									xtype:'datefield',
									id:'arquivoretorno_inicio',
									width:100,
									minValue:date,
									value:today,
									listeners:{
										'select':function(a){
											xt('arquivoretorno_final').setMinValue(a.getValue());
											
											var $dateDe = xt('arquivoretorno_inicio').getValue();
											var $dateAte = xt('arquivoretorno_final').getValue();
											
											if(fn_getDateInt($dateDe) > fn_getDateInt($dateAte)){
												xt('arquivoretorno_final').setValue($dateDe);
											}
											
											fn_reloadStoreArquivoRetornoByData(fn_getDateString(xt('arquivoretorno_inicio').getValue()), 
																			   fn_getDateString(xt('arquivoretorno_final').getValue()));
										}
									}
								},'Até: ',{
									xtype:'datefield',
									id:'arquivoretorno_final',
									width:100,
									minValue:date,
									value:today,
									listeners:{
										'select':function(a){
											xt('arquivoretorno_inicio').setMaxValue(a.getValue());
											
											fn_reloadStoreArquivoRetornoByData(fn_getDateString(xt('arquivoretorno_inicio').getValue()), 
																			   fn_getDateString(xt('arquivoretorno_final').getValue()));
										}
									}
								},'->','-',{
									text:'Ver Todos',
									iconCls:'ico_search',
									handler:function(){
										fn_reloadStoreArquivoRetornoByData('1970-01-01','3000-01-01');
									}
								}],
								items:[{
									xtype:'grid',
									id:'gridarquivoretorno',
									store:storearquivoretorno_list,
									height:381,
									width:1500,
									loadMask:true,
									stripeRows:true,
									autoScroll:true,
									border:false,
									plugins:expander1,
									viewConfig:{
										 forceFit:true
									},
									sm: new Ext.grid.RowSelectionModel({
										singleSelect: true,
									}),
									cm:new Ext.grid.ColumnModel({
										columns:[new Ext.grid.RowNumberer({
											width:30,
											header:'nº',
										}),expander1,{
											header:'Id do Arquivo',
											width:25,
											dataIndex:'idarquivo'
										},{
											hidden:true,
											header:'Tipo de Registro',
											width:45,
											dataIndex:'desregistrotipo'
										},{
											header:'Tipo de Serviço',
											width:45,
											dataIndex:'servicotipo'
										},{ 
											header:'Agencia',
											width:25,
											dataIndex:'agencia'
										},{ 
											header:'Conta',
											width:25,
											dataIndex:'conta'
										},{ 
											header:'DAC',
											width:25,
											dataIndex:'dac'
										},{ 
											header:'Empresa',
											sortable:true,
											dataIndex:'desempresa'
										},{
											header:'Código do Banco',
											width:40,
											dataIndex:'cod_banco'
										},{
											header:'Banco',
											dataIndex:'desbanco'
										},{
											xtype:'datecolumn',
											header:'Data de Geração',
											width:40,
											dataIndex:'dtgeracao',
											format:'d/m/Y'
										},{
											header:'Nrº Sequencial',
											width:30,
											dataIndex:'nrseq_arq_retorno'
										},{
											xtype:'datecolumn',
											header:'Data de Crédito',
											width:40,
											dataIndex:'dtcredito',
											format:'d/m/Y'
										},{
											header:'Nrº Parcelas',
											width:35,
											dataIndex:'nrparcela',
										},{
											header:'Valor Total',
											width:40,
											dataIndex:'vlr_total_arquivo',
											renderer:fn_moneyFormat
										},{
											xtype:'datecolumn',
											header:'Data de Cadastro',
											width:40,
											dataIndex:'dtcadastro',
											format:'d/m/Y'
										}],
									}),
									listeners:{
										'rowclick':function(a, i){
											if(xt('gridarquivoretorno').getSelectionModel().getSelected()){
												//var mask = new Ext.LoadMask(xt('idpanelsouth').body,{msg:'Aguarde...'});
												mask.show();
												
												$idarquivo = xt('gridarquivoretorno').getStore().getAt(i).get('idarquivo');
												storearquivoretornotransacaobyarquivo_list.reload({
													params:{
														idarquivo:$idarquivo 
													},
													callback:function(a, b, success){
														if(success){
															$('#idpanelsouth div:first').find('div:last span').html(' [id do arquivo : '+$idarquivo+']');
															xt('idpanelsouth').collapse();
															xt('gridarquivoretorno').setHeight(321);
															
															setTimeout(function(){
																xt('idpanelsouth').expand();
																xt('gridarquivoretorno').setHeight(191);
															}, 550);
															
															mask.hide();
														}
													}
												});
											}else{
												xt('idpanelsouth').collapse();
												xt('gridarquivoretorno').setHeight(381);
											}
										}
									}
								}]
							});
							
							var arquivodetalhes = new Ext.Window({
								id:'winarquivoretorno', 
								iconCls:'ico_pencil',
								title:'Relatório de Dados do arquivo de retorno',
								height:469,
								width:1011,
								border:false,
								layout:'border',
								items:[centerPanel, southPanel],
								listeners:{
									'afterrender':function(){										
										mask = new Ext.LoadMask(xt('idpanelsouth').body,{msg:'Aguarde...'});
										
										mask.show();
										
										xt('idpanelsouth').collapse();
										
										storearquivoretorno_list.reload({
											params:{
												dtinicio:fn_getDateString(xt('arquivoretorno_inicio').getValue()),
												dtfinal:fn_getDateString(xt('arquivoretorno_final').getValue())
											},
											callback:function(){
												mask.hide();
											}
										});
										$('#idpanelsouth div:first').append('<div>Detalhes da transação do arquivo de retorno <span></span></div>')
									}
								}
							}).show();
						}
					}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////					
				}],
			listeners:{
				'afterrender':function(){
					$('#btnrelatorioarquivo button').css('background-size', '32px');
					$('#btnadmocorrencias button').css('background-size', '22px');
					
					var mask = new Ext.LoadMask(xt('winarquivoretornocnab400itauv7').body,{msg:'Aguarde...'});
					
					var file = function(file){
	
						var upload_file = function(File, new_name){
							var form = new FormData();
							form.append('picture', File);
							var xhr = new XMLHttpRequest();
							xhr.open('POST', '/simpacweb/labs/Massaharu/extjsTelas/19.baixaBoletoAutomatico/ajax/arqRetornoBoletoItau_save.php', true);
							$('#file_to_input').after("<progress value='1' max='100' style='width:268px;margin-top:30px'></progress>");
							
							xhr.onprogress = function(e){
								if(e.lengthComputable){
									$('progress').val(((e.loaded/e.total)*100));
								}
							}
							
							xhr.onreadystatechange = function(response){
								if (xhr.readyState == 4 && xhr.status == 200){
									
									var result = $.parseJSON(xhr.responseText);
									
									if(result.success){
										xt('file_data_size').setValue(result.archive_details[0].size+' bytes');
										xt('file_data_register').setValue(result.archive_details[0].nr_registros+' registros');
										xt('file_data_lote').setValue(result.archive_details[0].nr_lotes+' lotes');
										
										$('#file_to_input').next().fadeOut(2000, function(){
											Ext.MessageBox.info("Arquivo salvo e processado com sucesso!"," Clique em OK para visualizar os pagamentos baixados/não baixados.", function(){
												
												mask.show();
												
												Ext.Ajax.request({
													url:'/simpacweb/labs/Massaharu/extjsTelas/19.baixaBoletoAutomatico/ajax/pagamentoBaixaBoleto_load.php',
													params:{
														idarquivo:result.archive_details[0].idarquivo
													},
													success:function(response){
														$myJson = Ext.util.JSON.decode(response.responseText);
														
														var $pagtonaobaixado_count = $myJson.details.pagtonaobaixado_count;
														$pagtonaobaixado_count = ($pagtonaobaixado_count)? $pagtonaobaixado_count : 0;
														var $pagtonaoencontrado_count = $myJson.details.pagtonaoencontrado_count;
														$pagtonaoencontrado_count = ($pagtonaoencontrado_count)? $pagtonaoencontrado_count : 0;
														var $pagtonaobaixado_dac = "";
														var $pagtonaoencontrado_dac = "";
														
														var $content_data = "";
														
														//CSS da tabela de dados dos pagamentos
														var $myStyle = (
															'<style>'+
															'#myTable tr, #myTable tr th, #myTable tr td{'+
															'	border: 2px dashed #d0def0;'+
															'	text-align: center;'+
															'	transition: all 300ms'+
															'}'+
															'#myTable{'+
															'	width: 100%;'+
															'}'+
															'#myTable tr th{'+
															'	text-shadow: 1px 1px 4px rgba(0, 0, 0, .4);'+
															'}'+
															'#myTable tr td input[type=time]{'+
															'	margin-left: 10px;'+
															'}'+
															'#myTable tr td input[type=text]{'+
															'	width: 80px;'+
															'}'+
															'</style>'
														)														
														$('head').append($myStyle);
														
														//Detalhes dos pagamentos que não é possível efetuar a baixa
														//console.log($pagtonaoencontrado_count, $pagtonaobaixado_count);
														
														$.each($myJson.pagtoNaoBaixado, function(){
															$pagtonaobaixado_dac+= this.nosso_numero+'/'+this.dac_nosso_numero+', ';
														});
														$.each($myJson.pagtoNaoEncontrado, function(){
															$pagtonaoencontrado_dac+= this.num_documento+' - '+this.nome_sacado+', ';
														});
														
														
														//Para cada registro de pagamento retornado
														$.each($myJson.myData, function(){
															//console.log(this,this.nome_cli);	
															
															var $recibostatus = "", $recibostatus_icon = "";
															
															//Se EXISTE o id do recibo
															if(this.idrecibo){
																$recibostatus = true;
																$recibostatus_icon = '<img src="/simpacweb/images/ico/16/accept.png"></img>';
															//Se NÃO existe o id do recibo
															}else{
																$recibostatus = false;
																$recibostatus_icon = '<img src="/simpacweb/images/ico/16/stop_round.png"></img>';
															}		
															
															//LinkPermissao
															var $LinkPermissaoMatricula = LinkPermissao.matricula.apply({
																matricula:this.matricula
															});		
															var $PermissaoAccount = LinkPermissao.account.apply({
																cod_cli: this.cod_cli,
																nome_cli: this.nome_cli
															});													
															
															//registros do pagamento
															$content_data+= (
																'<tr data-recibostatus="'+$recibostatus+'" data-sessionid="'+this.sessionid+'">'+
																	'<td class="recibostatus">'+$recibostatus_icon+'</td>'+
																	'<td class="nome_cli">'+$PermissaoAccount+'</td>'+
																	'<td class="vltotal"> R$ '+this.vltotal+'</td>'+
																	'<td class="desformapagto">'+this.desformapagto+'</td>'+
																	'<td class="matricula">'+$LinkPermissaoMatricula+'</td>'+
																	'<td class="dtconfirmpagto">'+
																		'<input type="text" class="myDatepicker">'+
																		'<input type="time" class="myTimefield">'+	
																	'</td>'+
																'</tr>'
															);
														});
														
														//Tabela com os registros dos pagamentos
														$content = (
															'<table id="myTable">'+
																'<tr>'+
																	'<th>Pago</th>'+
																	'<th>Nome</th>'+
																	'<th>Valor Total</th>'+
																	'<th>Forma de Pagto.</th>'+
																	'<th>Matrícula</th>'+
																	'<th>Data de Pagto</th>'+
																'</tr>'
																+$content_data+	
																'<tr>'+
																	'<td rowspan="2" colspan="2"><b>Pagamento não encontrado: </b></td>'+
																	'<td colspan="1">Quantidade: </td>'+
																	'<td colspan="3">'+$pagtonaoencontrado_count+'</td>'+
																'</tr>'+
																'<tr>'+
																	'<td colspan="1">Seu nº/Nome sacado</td>'+
																	'<td colspan="3">'+$pagtonaoencontrado_dac+'</td>'+
																'</tr>'+
																'<tr>'+
																	'<td rowspan="2" colspan="2"><b>Pagamento sem "Seu nº": </b></td>'+
																	'<td colspan="1">Quantidade: </td>'+
																	'<td colspan="3">'+$pagtonaobaixado_count+'</td>'+
																'</tr>'+
																'<tr>'+
																	'<td colspan="1">Nosso nº/DAC</td>'+
																	'<td colspan="3">'+$pagtonaobaixado_dac+'</td>'+
																'</tr>'+
															'</table>'
														);		
														
														if(xt('idwinPagamentoNaoBaixado')){
															mask.hide();															
															xt('idwinPagamentoNaoBaixado').show();
														}else{
															mask.hide();
															var winPagamentoNaoBaixado = new Ext.Window({
																title:'Pagamentos a Baixar',
																id:'idwinPagamentoNaoBaixado',
																iconCls:'ico_file',
																height:'auto',
																width:800,
																modal:true,
																html:$content,
																buttons:[{
																	text:'Confirmar Pagamento',
																	id:'btnconfirmpagto',
																	iconCls:'ico_accept',
																	scale:'large',
																	buttonAlign:'center'
																}],
																listeners:{
																	'afterrender':function(){
																		$(function() {
																			$( ".myDatepicker" ).datepicker({
																				showOn: "button",
																				buttonImage: "http://jqueryui.com/resources/demos/datepicker/images/calendar.gif",
																				buttonImageOnly: true
																			});
																			
																			$(".myDatepicker").val(fn_getDateStringFormated(new Date));
																			$(".myTimefield").val(fn_getTimeStringFormated(new Date));
																			
																			$('#myTable tr').on('mouseenter', function(){
																				$(this).find('td, th').css({
																					'padding' : '5px 0px 5px 0px',
																					'background' : '#d0def0'
																				});
																			});
																			
																			$('#myTable tr').on('mouseleave', function(){
																				$(this).find('td, th').css({
																					'padding' : '0px',
																					'background' : '#FFFFFF'
																				});
																			});
																			
																			//EVENTO CLICK DO BOTAO CONFIRMAR PAGAMENTO
																			$('#btnconfirmpagto').on('click', function(){
																				
																				var $hasSessionid = true;
																				var $isAllPago = true;
																				var $baixaDados = $('#myTable tr[data-sessionid] > td').parent();
																				var $objBaixaDados = [];
																				
																				//Para cada linha de registro de pagamento na tabela
																				$.each($baixaDados, function(){
																					
																					var $nome_cli = $(this).find('td.nome_cli').text();
																					var $vltotal = $.trim($(this).find('td.vltotal').text().replace("R$",""));
																					var $desformapagto = $(this).find('td.desformapagto').text();
																					var $dtconfirmpagto = $(this).find('td.dtconfirmpagto input[type=text]').val();
																					if($dtconfirmpagto){
																						$dt = $dtconfirmpagto.split('/');
																						$dtconfirmpagto = $dt[2]+'-'+$dt[0]+'-'+$dt[1];
																					}
																					var $hrconfirmpagto = $(this).find('td.dtconfirmpagto input[type=time]').val();
																					var $sessionid = $(this).attr("data-sessionid");
																					var $recibostatus = $(this).attr("data-recibostatus");
																					
																					//Cria o array de obj para enviar o ajax
																					var $arrBaixaDados = { 
																						'sessionid' : $sessionid, 
																						'dtconfirmpagto' : $dtconfirmpagto,  
																						'hrconfirmpagto' : $hrconfirmpagto,
																						'recibostatus' : $recibostatus
																					};
																						
																					$objBaixaDados.push($arrBaixaDados);
																				});
																-				
																				$.each($objBaixaDados, function(){
																					if(!this.sessionid) $hasSessionid = false;
																					if(!this.recibostatus) $isAllPago = false;
																				});
																				
																				if($hasSessionid){
																					if(!$isAllPago){
																						Ext.Ajax.request({
																							url:'/simpacweb/labs/Massaharu/extjsTelas/19.baixaBoletoAutomatico/ajax/pagamentoBaixaBoleto_save.php',
																							params: {
																								baixadados: JSON.stringify($objBaixaDados)
																							},
																							success: function(response){
																								$myJson2 = Ext.util.JSON.decode(response.responseText);
																								Ext.MessageBox.info("Baixas Efetuadas!", "Todas as baixas foram efetuadas com sucesso.", function(){
																									xt('btnconfirmpagto').disable();
																									$('#btnconfirmpagto').off('click');
																								});
																								console.log($myJson2);
																							}
																						});
																					}else{
																						Ext.MessageBox.info("Aviso", "Todos os pagamentos já tiveram as baixas efetuadas");
																					}
																				}else{
																					Ext.MessageBox.warning("Aviso", "As baixas não puderam ser efetuadas");
																				}
																				
																				//console.log(JSON.stringify($objBaixaDados));
																			});
																		});
																	}
																}
															}).show();
														}
													}
												})
											});
										});
										//storage.load();
									}else{
										//$('#Loading .info').html('');
										//$('#picturePreview #Loading').fadeOut();
										//Ext.Msg.erro('',result.msg);
										$('#file_to_input').next().fadeOut(2000, function(){
											Ext.MessageBox.erro("Falha! State: "+xhr.readyState+", Status: "+xhr.status, "O Arquivo não pode ser Salvo e/ou processado. Favor, verifique se o arquivo está no padrão do sistema ou se há conexão de internet. "+result.exception);
										});
									}
								}
							};							
							xhr.send(form);
						}
					
						var show_file = function(file_list){
							[].forEach.call(file_list, function(File){
								var reader = new FileReader();
						  
								reader.onload = (function(theFile) {
								})(File);
														  
								reader.readAsDataURL(File);
							});	
						}
					
						var read_file = function(file_list,new_name){
							[].forEach.call(file_list, function(File){
							  var reader = new FileReader();
						
							  reader.onload = (function(theFile) {
								return function(e) {
								  
									upload_file(theFile,new_name);
								  
								};
							  })(File);
						
							  reader.readAsDataURL(File);
							  
							});	
						}
						
						this.reading_file = function(file, new_name){
							read_file(file,new_name);
						}
						
						this.call_show_file = function(file_list){
							show_file(file_list)
						}
					}
					
					var fn = new file();
					var data = '';
		
					$('#file_to_input').on('change',function(){
						data = this.files
					});
							
					$('#send_file').on('click', function(){
						if($.trim($('#file_to_input').val()) != ""){
							fn.reading_file(data);
						}else{
							Ext.MessageBox.info("Aviso!", "Selecione um arquivo para enviar.");
						}
					});
					
				}
			}
		}).show();
	});
</script>

