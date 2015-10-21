<?
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 
?>
<script type="text/javascript">
	Ext.onReady(function(){
		//GLOBALS
		var PATH = "/simpacweb/modulos/corporativo/admSolicitacaoCorporativa"; //PRODUÇÃO
		//var PATH = "/simpacweb/labs/Massaharu/extjsTelas/22.AdmSolicitacaoCorporativa"; //TESTE
		var xt = Ext.getCmp;
		var ms = Ext.MessageBox; 
		
		var today = new Date();
		var firstday = new Date(today.getFullYear(), today.getMonth(), 1);
		var lastday = new Date(today.getFullYear(), today.getMonth() + 1, 0);
		var pendenteCount = 0;
		var finalizadoCount = 0;
		
		//STORES
		var storesolicitacaocorporativa = new Ext.data.JsonStore({
			url:PATH+'/json/solicitacaoCorporativa_list.php',
			root:'myData',
			baseParams:{
				dtinicio:fn_getDateString(firstday),
				dtfinal:fn_getDateString(today),
				from:'secretaria'
			},
			fields:[
				{name:'idsolicitacaocorp', type:'int'}, 
				{name:'matricula'}, 
				{name:'idsolicitante', type:'int'}, 
				{name:'dessolicitante'}, 
				{name:'idsolicitado', type:'int'}, 
				{name:'dessolicitado'},
				{name:'idalunoagendado', type:'int'}, 
				{name:'inalunoalterado', type:'bit'}, 
				{name:'incertificado', type:'bit'}, 
				{name:'inlistapresenca', type:'bit'}, 
				{name:'innfalterado', type:'bit'}, 
				{name:'intreinamentoalterado', type:'bit'}, 
				{name:'inalunodesmembrado', type:'bit'}, 
				{name:'inalunodesagendado', type:'bit'},
				{name:'incadimpactaonline', type:'bit'},
				{name:'intreinamentoreposicao', type:'bit'},
				{name:'intreinamentotransfer', type:'bit'},
				{name:'instatus', type:'bit'}, 
				{name:'dtalteracao', type:'date', dateFormat:'timestamp'}, 
				{name:'dtcadastro', type:'date', dateFormat:'timestamp'}
			],
			autoLoad:true
		});
		
		var storesolicitacaocorporativafinalizadoscount = new Ext.data.JsonStore({
			url:PATH+'/json/solicitadoAprovadosPendentesCount_get.php',
			root:'myData',
			fields:[
				{name:'finalizado', type:'int'},
				{name:'instatus', type:'bit'}
			]
		});
		
		//FUNCTIONS
		function fn_getDateInt(data){
			
			var dataRetorno;
			dataRetorno = data.getFullYear()+"";
			
			if(data.getMonth() < 9){
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
			
			if(data.getMonth() < 9){
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
		
		function fn_status(v, metaData){
			if(v == 1){
				metaData.attr='ext:qtip="Solicitado"';
				return '<img src="/simpacweb/images/ico/16/accept.png"/>';
			}else{
				metaData.attr='ext:qtip="Não solicitado"';
				return '<img src="/simpacweb/images/ico/16/Essen_consulting.png"/>';
			}	
		}
		
		function fn_reloadStoreArquivoRetornoByData(dtinicio, dtfinal){
			
			var mask = new Ext.LoadMask(xt('idsolicitacaocorpsecretariavisualizar').body,{msg:'Aguarde...'});
			mask.show();
			
			storesolicitacaocorporativa.reload({
				params:{
					dtinicio:dtinicio,
					dtfinal:dtfinal,
					from:'secretaria'
				},
				callback:function(){
					mask.hide();
				}
			});
		}
		
		function fn_getFinalizadosPendentesCount(){
			
			storesolicitacaocorporativafinalizadoscount.reload({
				callback:function(resp){
					$.each(resp, function(){
						
						if(this.get('instatus')){
							var $descricao_1 = (this.get('finalizado') > 1)? "finalizados" : "finalizado";
							
							xt('iddfsolicitacaosecretariafinalizados').setValue('<span style="font-weight:bolder; font-size:20px; color:green;" alt="'+$descricao_1+'" title="Finalizados" >'+this.get('finalizado')+' </span> <b>'+$descricao_1+'</b>');
							
							if(finalizadoCount != this.get('finalizado')){
								fn_reloadStoreArquivoRetornoByData(
									fn_getDateString(xt('idsolicitacaocorpsecretariadata_inicio').getValue()), 
									fn_getDateString(xt('idsolicitacaocorpsecretariadata_final').getValue())
								);
							}
							
							finalizadoCount = this.get('finalizado');
						}
						
						if(!this.get('instatus')){
							var $descricao_2 = (this.get('finalizado') > 1)? "pendentes" : "pendente";
							
							xt('iddfsolicitacaosecretariapendente').setValue('<span style="font-weight:bolder; font-size:20px; color:red;" alt="'+$descricao_2+'" title="Pendentes" >'+this.get('finalizado')+' </span> <b>'+$descricao_2+'</b>');	
							
							if(pendenteCount != this.get('finalizado')){
								fn_reloadStoreArquivoRetornoByData(
									fn_getDateString(xt('idsolicitacaocorpsecretariadata_inicio').getValue()), 
									fn_getDateString(xt('idsolicitacaocorpsecretariadata_final').getValue())
								);
							}
							
							pendenteCount = this.get('finalizado');
						}
					});
				}
			});
		}
		
		function loadStoresolicitacaocorporativa(){
			storesolicitacaocorporativa.reload({
				params:{
					dtinicio:fn_getDateString(firstday),
					dtfinal:fn_getDateString(today),
					from:'secretaria'
				},
				callback:function(){
					
				}
			})
		}
		
		var mainWin = new Ext.Window({
			title:'Solicitação Corp. (Secretaria)',
			id:'idsolicitacaocorpsecretariamainwin',
			iconCls:'ico_file',
			width:Page.width-10,
			height:510,
			layout:'fit',
			listeners:{
				'afterrender':function(){
					fn_getFinalizadosPendentesCount();
					
					/*setInterval(function(){
						fn_getFinalizadosPendentesCount();
					}, 20000);*/
					
					if(typeof socket == "object"){
						socket.on('salvar_solitacao_corp2', function(data){
							fn_getFinalizadosPendentesCount();
						})
					}
					
					$height = $(window).height() /2 ;
					$width = ($(window).width() / 2) - 75;
					
					$('body').append("<div id='myimageload' style='position:absolute; top: "+$height+"px; left:"+$width+"px;z-index:100'><img style='width:150px;height:30px' src='"+PATH+"/res/img/load.gif' /></div>");
					$('body').append("<div id='modal-load'></div>");
					$('#modal-load').css({position: 'fixed', height: '100%', width: '100%', background: 'rgba(0, 0, 0, 0.5)', 'z-index':'999999'});
					$('#myimageload img').hide();
					$('#modal-load').hide();
				}
			},
			tbar:[{
				text:'<b>Executar Solicitação</b>',
				tooltip:'Clique aqui para executar e finalizar a solicitação',
				id:'idsolicitacaocorpsecretariabtnexecutarsolicitacao',
				disabled:true,
				style:'border: 1px solid #99bbe8; background-image: -webkit-linear-gradient(bottom, rgb(218,227,230) 35%, rgb(210,218,219) 68%, rgb(232,234,235) 84%);margin-right:100px;',
				scale:'medium',
				iconCls:'ico_send_feedback',
				handler:function(){
					var $gridrow = xt('idsolicitacaocorpsecretariagridsolicitacaosecretaria').getSelectionModel().getSelected();
					
					$('#myimageload img').show();
					$('#modal-load').show();
					$('#myimageload').css('z-index', '1000000');
					
					if($gridrow){
						Ext.Ajax.request({
							url:PATH+'/ajax/solicitacao_corporativa_exe.php',
							params:{
								idsolicitacaocorp: $gridrow.get('idsolicitacaocorp')
							},
							success:function(resp){
								var resp = Ext.util.JSON.decode(resp.responseText);
								
								//console.log(resp);
								
								$.each(resp, function(){
									if(this.success){
										fn_reloadStoreArquivoRetornoByData(
											fn_getDateString(xt('idsolicitacaocorpsecretariadata_inicio').getValue()), 
											fn_getDateString(xt('idsolicitacaocorpsecretariadata_final').getValue())
										);
										
										fn_getFinalizadosPendentesCount();
										
										alert(this.titleMsg+"\n\r"+this.msg);
										//ms.info(this.titleMsg, this.msg);
									}else{
										alert(this.titleMsg+"\n\r"+this.msg);
										//ms.info(this.titleMsg, this.msg);
									}	
								});
								
								$('#myimageload img').hide();
								$('#modal-load').hide();					   
							},
							failure:function(){
								$('#myimageload img').hide();
								$('#modal-load').hide();
							}
						});
					}
				}
			},'<b>De: </b>',{
				xtype:'datefield',
				id:'idsolicitacaocorpsecretariadata_inicio',
				width:120,
				value:firstday,
				listeners:{
					'select':function(a){
						
						var $dateDe = xt('idsolicitacaocorpsecretariadata_inicio').getValue();
						var $dateAte = xt('idsolicitacaocorpsecretariadata_final').getValue();
						
						if(fn_getDateInt($dateDe) > fn_getDateInt($dateAte)){
							xt('idsolicitacaocorpsecretariadata_final').setValue($dateDe);
						}
						
						fn_reloadStoreArquivoRetornoByData(fn_getDateString(xt('idsolicitacaocorpsecretariadata_inicio').getValue()), 
														   fn_getDateString(xt('idsolicitacaocorpsecretariadata_final').getValue()));
					}
				}
			},'<b>Até: </b>',{
				xtype:'datefield',
				id:'idsolicitacaocorpsecretariadata_final',
				width:120,
				value:today,
				listeners:{
					'select':function(a){
						
						var $dateDe = xt('idsolicitacaocorpsecretariadata_inicio').getValue();
						var $dateAte = xt('idsolicitacaocorpsecretariadata_final').getValue();
						
						if(fn_getDateInt($dateAte) < fn_getDateInt($dateDe)){
							
							xt('idsolicitacaocorpsecretariadata_inicio').setValue($dateAte);
						}
						
						fn_reloadStoreArquivoRetornoByData(fn_getDateString(xt('idsolicitacaocorpsecretariadata_inicio').getValue()), 
														   fn_getDateString(xt('idsolicitacaocorpsecretariadata_final').getValue()));
					}
				}
			},'-',{
				text:'Ver Todos',
				iconCls:'ico_search',
				handler:function(){
					fn_reloadStoreArquivoRetornoByData('1970-01-01','3000-01-01');
				}
			},'->',{
				xtype:'displayfield',
				value:'<b>Nº Matrícula: </b>',
				style:'margin-left:10px'
			},{
				xtype:'textfield',
				id: 'idsolicitacaocorpsecretariamatricula',
				emptyText:'matricula...',
				style:'margin-left:10px',
				enableKeyEvents:true,
				listeners:{
					keyup:function(a, b){
						if(b.keyCode == 13){
							filterStoreByAllFields(xt('idsolicitacaocorpsecretariamatricula').getValue(), storesolicitacaocorporativa);
						}
					}
				}
			}],
			items:[{
				xtype: "panel",
				id:'idsolicitacaocorpsecretariavisualizar',
				border: false,
				height: 395,
				padding:2,
				layout: "hbox",
				items:[{
					xtype:'grid',
					title:'Lista de Solicitação Realizadas/Concluídas',
					id:'idsolicitacaocorpsecretariagridsolicitacaosecretaria',
					flex: 1,
					height:435,
					store:storesolicitacaocorporativa,
					stripeRows: true,
					viewConfig:{
						forceFit:true,
						getRowClass: function(record, rowIndex, rp, ds){ // rp = rowParams
							//console.log(rp);
							 var _class = record.get('instatus');
							 if (!_class){
								return 'black'
							 }else{
								 return 'green';
							 }
						}
					},
					sm: new Ext.grid.RowSelectionModel({
						singleSelect: true
					}),
					cm: new Ext.grid.ColumnModel({
						defaults:{
							sortable:true
						},
						columns:[new Ext.grid.TemplateColumn({
							header:'Matricula',
							tpl:LinkPermissao.matricula,
							width:135,
							dataIndex:'matricula'
						}),{
							header:'Solicitante',
							width:135,
							dataIndex:'dessolicitante',
							renderer:function(v, metaData){
								metaData.attr='ext:qtip="'+v+'"';
								return v;
							}
						},{
							header:'Solicitado',
							dataIndex:'dessolicitado',
							width:135,
							renderer:function(v, metaData){
								metaData.attr='ext:qtip="'+v+'"';
								return (v)? v : "N/A";
							}
						},{
							header:'Aluno',
							dataIndex:'inalunoalterado',
							tooltip:'Alteração de dados do aluno',
							renderer:fn_status		
						},{
							header:'Certificado',
							dataIndex:'incertificado',
							tooltip:'Solicitação de certificado',
							renderer:fn_status	
						},{
							header:'Lista Presença',
							dataIndex:'inlistapresenca',
		
							tooltip:'Solicitação de lista de presença',
							renderer:fn_status	
						},{
							header:'Faturamento NF',
							dataIndex:'innfalterado',
							tooltip:'Alteração de dados da empresa',
							renderer:fn_status	
						},{
							header:'Reagendado',
							dataIndex:'intreinamentoalterado',
							tooltip:'Reagendamento de treinamento',
							renderer:fn_status	
						},{
							header:'Desmembramento',
							dataIndex:'inalunodesmembrado',
							tooltip:'Desmembramento de alunos jurídicos',
							renderer:fn_status	
						},{
							header:'Desagendamento',
							dataIndex:'inalunodesagendado',
							tooltip:'Desagendamento de alunos',
							renderer:fn_status	
						},{
							header:'Impacta Online',
							dataIndex:'incadimpactaonline',
							tooltip:'Cadastro no Impacta Online',
							renderer:fn_status
						},{
							header:'Reposição',
							dataIndex:'intreinamentoreposicao',
							tooltip:'Reposição de Treinamento',
							renderer:fn_status
						},{
							header:'Transferência',
							dataIndex:'intreinamentotransfer',
							tooltip:'Transferência de Treinamento',
							renderer:fn_status
						},{
							header:'Finalizado',
							dataIndex:'instatus',
							tooltip:'Solicitação finalizada pela Secretaria',
							renderer:fn_status	
						},{
							header:'Cadastrado',
							width:150,
							xtype:'datecolumn',
							dataIndex:'dtcadastro',
							format:'d/m/Y H:i',
							tooltip:'Data de cadastro da solicitação',
							renderer:fn_status
						}]
					}),
					bbar:[{
						text:'Realizadas',
						id:'idsolicitacaocorpsecretariabtnfiltroaprovados',
						tooltip:'Solicitações já realizadas pela secretaria',
						iconCls:'ico_accept',
						enableToggle:true,
						toggleHandler: function(button,state){
							var $btn = Ext.getCmp('idsolicitacaocorpsecretariabtnfiltroaprovados');
							var $fields = ['instatus'];
							if (state == true) {	
								$btn.setText('Em espera');
								$btn.setIconClass('ico_Essen_consulting');	
								$btn.setTooltip('Solicitações em espera');
								storesolicitacaocorporativa.filter('instatus', true, true, false);
							}else{
								$btn.setText('Realizadas')
								$btn.setIconClass('ico_accept');	
								$btn.setTooltip('Solicitações já realizadas pela secretaria');
								storesolicitacaocorporativa.filter('instatus', false, true, false);
							}
						}
					},'-',{
						xtype:'searcher',
						store:storesolicitacaocorporativa,
						style:'margin-left:20px;',
						emptyText:'Pesquisar...'
					},'->',{
						xtype:'displayfield',
						id:'iddfsolicitacaosecretariafinalizados'
					},'-',{
						xtype:'displayfield',
						id:'iddfsolicitacaosecretariapendente'
					}],
					listeners:{
						'rowclick':function(){
							var $gridrow = xt('idsolicitacaocorpsecretariagridsolicitacaosecretaria').getSelectionModel().getSelected();
							
							if($gridrow){
								xt('idsolicitacaocorpsecretariabtnexecutarsolicitacao').enable();
								xt('idsolicitacaocorpsecretariabtnexecutarsolicitacao').enable();
							}else{
								xt('idsolicitacaocorpsecretariabtnexecutarsolicitacao').disable();
							}
						},
						'dblclick':function(){
							if(xt('idwinsolicitacaocorpsecretariasolicitacaocorporativa')){
								xt('idwinsolicitacaocorpsecretariasolicitacaocorporativa').show();
							}else{
								new Ext.Window({
									title:'Solicitação Corporativa',
									id:'idwinsolicitacaocorpsecretariasolicitacaocorporativa',
									width:500,
									height:600,
									autoScroll:true,
									modal:true,
									border:false,
									items:[{
										xtype:'panel',
										border:false,
										id:'idpanelsolicitacaocorpsecretariasolicitacaocorporativa',
										listeners:{
											'afterrender':function(){
												
												var $gridrow = xt('idsolicitacaocorpsecretariagridsolicitacaosecretaria').getSelectionModel().getSelected();
												xt('idpanelsolicitacaocorpsecretariasolicitacaocorporativa').load({
													url:PATH+'/ajax/solicitacao_corporativa_load.php',
													params:{
														idsolicitacaocorp:$gridrow.get('idsolicitacaocorp')
													},
													text: 'Carregando...',
													timeout: 5,
													scripts: true
												});
											}
										}
									}]
								}).show();
							}
						}
					}
				}],
			}]
		}).show();
	});
</script>
