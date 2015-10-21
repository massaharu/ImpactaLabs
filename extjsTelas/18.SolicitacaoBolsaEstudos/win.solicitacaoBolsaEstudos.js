	
if(Ext.getCmp('winsolicitacaobolsaestudos')){
	Ext.getCmp('winsolicitacaobolsaestudos').show();
}else{
	
	//CONSTANTES
	var SOLICITACAOBOLSAESTUDOTIPO = new Array();
	var DEPENDENTETIPO = new Array();
	
	//Imported scripts
		//MASK
	$.getScript('/simpacweb/modulos/RH/solicitacaoBolsaEstudos/js/jquery.maskedinput.js');
	
	//AJAX
		//Lista os tipos de Dependentes e Solicitações de Bolsa
	$.ajax({
		url:'/simpacweb/modulos/RH/solicitacaoBolsaEstudos/json/tipos_list.php',
		type:"POST",
		dataType:'json',
		success:function(response){	
		
			//DependenteTipo
			$.each(response.myData1, function(){					
				var $DependenteTipo = new Object();	
				
				$dependentetipo = this.desdependentetipo.toLowerCase();
				
				if($dependentetipo == 'cônjuge' || $dependentetipo == 'filho(a)'){
					$DependenteTipo.id = this.iddependentetipo;
					$DependenteTipo.nome = this.desdependentetipo;
					
					DEPENDENTETIPO.push($DependenteTipo);						
				}
			});
			
			//SolicitacaoBolsaEstudosTipo
			$.each(response.myData2, function(){
				var $SolicitacaoBolsaEstudosTipo = new Object();
				
				$solicitacaobolsaestudostipo = this.dessolicitacaobolsaestudostipo.toLowerCase();
				
				if($solicitacaobolsaestudostipo == 'titular' || $solicitacaobolsaestudostipo == 'dependente'){
					 $SolicitacaoBolsaEstudosTipo.id = this.idsolicitacaobolsaestudostipo;
					 $SolicitacaoBolsaEstudosTipo.nome = this.dessolicitacaobolsaestudostipo;
					
					SOLICITACAOBOLSAESTUDOTIPO.push($SolicitacaoBolsaEstudosTipo);						
				}
			});
				
			
			var xt = Ext.getCmp;
			
			var storeusuariosativos = new Ext.data.JsonStore({
				url:'/simpacweb/modulos/RH/solicitacaoBolsaEstudos/json/usuarios_list.php',
				root:'myData',
				fields:[{name:'idusuario', type:'int'},
						{name:'nmcompleto', type:'string'},
						{name:'desusuario', type:'string'},
						{name:'nmusuario', type:'string'}],
				autoLoad:true
			});	
			
			var storecursos = new Ext.data.JsonStore({
				url:'/simpacweb/modulos/RH/solicitacaoBolsaEstudos/json/cursos_list.php',
				root:'myData',
				fields:[{name:'curso_id', type:'int'},
						{name:'curso_tipo', type:'int'},
						{name:'curso_titulo', type:'string'}],
				autoLoad:true
			});	
			
			var storesemestres = new Ext.data.JsonStore({
				url:'/simpacweb/modulos/RH/solicitacaoBolsaEstudos/json/semestres_list.php',
				root:'myData',
				fields:[{name:'idsemestre', type:'int'},
						{name:'nrsemestre', type:'int'},
						{name:'dessemestre', type:'string'}],
				autoLoad:true
			});	
			
			var solicitacaobolsaestudos = new Ext.data.JsonStore({
				url:'/simpacweb/modulos/RH/solicitacaoBolsaEstudos/json/solicitacaobolsaestudos_list.php',
				root:'myData',
				fields:[{name:'idsolicitacaobolsaestudo', type:'int'},
						{name:'idusuario', type:'int'},
						{name:'idsolicitacaobolsaestudostipo', type:'int'},
						{name:'curso_id', type:'int'},
						{name:'curso_titulo', type:'string'},
						{name:'dessemestre', type:'string'},
						{name:'desjustificativa', type:'string'},
						{name:'ingestor', type:'int'},
						{name:'inrh', type:'int'},
						{name:'indiretoria', type:'int'}],
				autoLoad:true
			});	
			
			var solicitacaobolsaestudosaprovados = new Ext.data.JsonStore({
				url:'/simpacweb/modulos/RH/solicitacaoBolsaEstudos/json/solicitacaobolsaestudosaprovados_list.php',
				root:'myData',
				fields:[{name:'idsolicitacaobolsaestudo', type:'int'},
						{name:'idusuario', type:'int'},
						{name:'idsolicitacaobolsaestudostipo', type:'int'},
						{name:'curso_id', type:'int'},
						{name:'curso_titulo', type:'string'},
						{name:'dessemestre', type:'string'},
						{name:'nrpercentual', type:'int'},
						{name:'desjustificativa', type:'string'},
						{name:'ingestor', type:'int'},
						{name:'inrh', type:'int'},
						{name:'indiretoria', type:'int'}],
				autoLoad:true
			});	
			
			var solicitacaobolsaestudosreprovados = new Ext.data.JsonStore({
				url:'/simpacweb/modulos/RH/solicitacaoBolsaEstudos/json/solicitacaobolsaestudosreprovados_list.php',
				root:'myData',
				fields:[{name:'idsolicitacaobolsaestudo', type:'int'},
						{name:'idusuario', type:'int'},
						{name:'idsolicitacaobolsaestudostipo', type:'int'},
						{name:'curso_id', type:'int'},
						{name:'curso_titulo', type:'string'},
						{name:'dessemestre', type:'string'},
						{name:'desjustificativa', type:'string'},
						{name:'ingestor', type:'int'},
						{name:'inrh', type:'int'},
						{name:'indiretoria', type:'int'}],
				autoLoad:true
			});	
			
			//EXPANDERS
			var expander1 = new Ext.ux.grid.RowExpander({
				tpl : new Ext.Template(
					'<p style="margin-left:60px;"><b>Justificativa:</b></br>{desjustificativa}</p>'
				)
			});	
			var expander2 = new Ext.ux.grid.RowExpander({
				tpl : new Ext.Template(
					'<p style="margin-left:60px;"><b>Justificativa:</b></br>{desjustificativa}</p>'
				)
			});	
			var expander3 = new Ext.ux.grid.RowExpander({
				tpl : new Ext.Template(
					'<p style="margin-left:60px;"><b>Justificativa:</b></br>{desjustificativa}</p>'
				)
			});	
			
			//FUNCTIONS
			function fn_status(v){	
				if(v == true){
					return '<img src="/simpacweb/images/ico/16/accept.png"/>';
				}else{
					return '<img src="/simpacweb/images/ico/16/remove.png"/>';

				}														  
			}		
			function fn_solicitacaoStatus(v){
				if(v == 1){
					return '<img src="/simpacweb/images/ico/16/Apply.png" />';
				}else if(v == 0){
					return '<img src="/simpacweb/images/ico/16/cross.png" />';
				}else if(v == 2){
					return '<img src="/simpacweb/images/ico/16/Essen_consulting.png" />';
				}			
			}
			function resetFormDependentes(){
				$('#idnomealuno').val('');
				$('#iddatanascimento').val('');
				$('#idcpfluno').val('');
				$('#idemailaluno').val('');
				$('#fsdependente input[type="radio"]:checked').each(function(){
				  $(this).attr('checked', false);  
				});
				xt('fsdependente').collapse();
			}
			
			function validDependentes(){
				if($('#idnomealuno').val() == ""){
					$('#idnomealuno').addClass('x-form-invalid');
				}
				if($('#iddatanascimento').val() == ""){
					$('#iddatanascimento').addClass('x-form-invalid');
				}
				if($('#idcpfluno').val() == ""){
					$('#idcpfluno').addClass('x-form-invalid');
				}
				if($("[name='dependentetipo']").is(':checked') == false){
					$('#radiogroupdependente').addClass('x-form-invalid');
				}
			}
	//////////////////////////////////////////////////////////////////////////////////////////////////
			var relatoriosolicitacaobolsa = new Ext.Panel({
				id:'panelrelatoriosolicitacaobolsa', 
				height:590,
				width:700,
				border:false,
				items: [{
					xtype: 'form',
					id:'formsolicitacaobolsa',
					padding: 15,
					height:570,
					width:675,
					margin:'10',
					border: false,
					buttonAlign:'left',										 
					items:[{
						xtype:'fieldset',
						title:'Dados do Solicitante',
						iconCls:'ico_user',
						autoHeight:true,
						collapsed:false,
						width:'100%',
						height:550,
						buttonAlign:'center',
						items: [{
							xtype:'combo',
							fieldLabel: 'Nome do Colaborador(a) *',
							id:'idnomecolaborador',
							name:'nomecolaborador',
							autoHeight:true,
							store:storeusuariosativos,
							displayField:'nmcompleto',
							valueField:'idusuario',
							typeAhead:true,
							triggerAction:'all',
							lazyRender:true,
							mode:'local',
							allowBlank:false,
							anchor:'100%',
							listeners:{
								'select':function(){
									$.ajax({
										url:'/simpacweb/modulos/RH/solicitacaoBolsaEstudos/json/usuarioDados_get.php',
										type:"POST",
										dataType:'json',
										data:{
											idnomecolaborador:xt('idnomecolaborador').getValue()
										},
										success:function(response){
											var $myData = response.myData[0];
											
											xt('iddepartamento').setValue(($myData.desdepartamento)?$myData.desdepartamento:'N/A');
											xt('idcargo').setValue(($myData.descargo)?$myData.descargo:'N/A');
											xt('iddatadeadmissao').setValue(($myData.dtadmissao)?$myData.dtadmissao:'N/A');
											xt('idcpf').setValue(($myData.nrcpf)?$myData.nrcpf:'N/A');
											
											$('#idcpf').mask('999.999.999.99');
										}
									});
								}
							}
						},{
							xtype:'compositefield',
							defaults: {
								xtype: 'textfield',	
								readOnly:true,											
							},
							items:[{
								fieldLabel: 'Departamento',
								id:'iddepartamento',
								name:'departamento',
								width:230
							},{
								xtype:'displayfield',
								style:"margin-left:10",
								width:45,
								value:'Cargo: '
							},{
								id:'idcargo',
								name:'cargo',
								width:230
							}]
						},{
							xtype:'compositefield',
							defaults: {
								xtype: 'textfield',	
								readOnly:true											
							},
							items:[{
								fieldLabel: 'Data de Admissão',
								name:'datadeadmissao',
								id:'iddatadeadmissao',		
								width:230
							},{
								xtype:'displayfield',
								style:"margin-left:10",
								width:45,
								value:'CPF: '
							},{												
								id:"idcpf",
								name:'cpf',
								width:230,
							}]
						},{
							xtype:'fieldset',
							title:'Beneficiario',
							iconCls:'ico_user2',
							autoHeight:true,
							width:'90%',
							height:'100%',
							items:[{
								xtype:"radiogroup",
								id:'radiogroupbeneficiario',
								columns:2,
								hideLabel:true,
								allowBlank:false,
								items:[{
									boxLabel:SOLICITACAOBOLSAESTUDOTIPO[0].nome,
									id:'id'+SOLICITACAOBOLSAESTUDOTIPO[0].nome.toLowerCase(),
									name:'beneficiariotipo',
									inputValue:SOLICITACAOBOLSAESTUDOTIPO[0].id,
									listeners:{
										'check':function(){
											//$('#fsdependente').show('slow');
										}
									}
								},{
									boxLabel:SOLICITACAOBOLSAESTUDOTIPO[1].nome,
									id:'id'+SOLICITACAOBOLSAESTUDOTIPO[1].nome.toLowerCase(),
									name:'beneficiariotipo',
									inputValue:SOLICITACAOBOLSAESTUDOTIPO[1].id,
									listeners:{
										afterrender:function(){
											$("[name='beneficiariotipo']").on('change', function(){
												$beneficiarioValue = $(this).val().toLowerCase();
												
												if($beneficiarioValue == SOLICITACAOBOLSAESTUDOTIPO[1].id){
													
													xt('fsdependente').expand();														
													
												}else{
													resetFormDependentes();													
												}											
											});
										}
									}
								}]
							},{
								xtype:'fieldset',
								id:'fsdependente',
								title:'Dependente',
								iconCls:'ico_User_group',
								collapsible:true,
								collapsed:true,
								autoHeight:true,
								width:'90%',
								height:'100%',
								items:[{
									xtype:"radiogroup",
									id:'radiogroupdependente',
									columns:2,
									hideLabel:true,
									items:[{
										boxLabel:DEPENDENTETIPO[0].nome,
										id:'id'+DEPENDENTETIPO[0].nome.toLowerCase(),
										name:'dependentetipo',
										inputValue:DEPENDENTETIPO[0].id
									},{
										boxLabel:DEPENDENTETIPO[1].nome,
										id:'id'+DEPENDENTETIPO[1].nome.toLowerCase(),
										name:'dependentetipo',
										inputValue:DEPENDENTETIPO[1].id
									}]
								},{
									xtype:'compositefield',
									items:[{
										xtype:'textfield',
										fieldLabel:'Nome do Aluno',
										id:'idnomealuno',
										name:'nomealuno',
										width:240
									},{
										xtype:'displayfield',
										style:"margin-left:10",
										width:115,
										value:'Data Nascimento: '
									},{
										xtype:'datefield',
										id:'iddatanascimento',
										name:'datanascimento',
										width:100,
										listeners:{
											afterrender:function(){
												$('#iddatanascimento').mask('99/99/9999');
											}
										}
									}]
								},{									
									xtype:'compositefield',
									defaults:{xtype:'textfield'},
									items:[{
										fieldLabel:'CPF',
										id:'idcpfluno',
										name:'cpfaluno',
										width:150
									},{
										xtype:'displayfield',
										style:"margin-left:10",
										width:55,
										value:'E-mail: '
									},{
										id:'idemailaluno',
										name:'emailaluno',
										width:250,
										listeners:{
											afterrender:function(){
												$('#idcpfluno').mask('999.999.999-99');
											}
										}
									}]								
								}]
							},{
								xtype:'compositefield',
								defaults:{xtype:'textfield'},
								items:[{
									xtype:'combo',
									fieldLabel: 'Nome do Curso',
									id:'idcurso',
									name:'curso',
									autoHeight:true,
									store:storecursos,
									displayField:'curso_titulo',
									valueField:'curso_id',
									typeAhead:true,
									triggerAction:'all',
									lazyRender:true,
									mode:'local',
									editable:false,
									allowBlank:false,
									width:272
								},{
									xtype:'displayfield',
									style:"margin-left:10",
									width:115,
									value:'Semestre Letivo: '
								},{
									xtype:'combo',
									id:'idsemestre',
									name:'semestre',
									autoHeight:true,
									store:storesemestres,
									displayField:'dessemestre',
									valueField:'idsemestre',
									typeAhead:true,
									triggerAction:'all',
									lazyRender:true,
									mode:'local',
									editable:false,
									allowBlank:false,
									width:100
								}]
							},{
								xtype:'textarea',
								fieldLabel:'Justificativa',
								id:'idjustificative',
								name:'justificativa',
								allowBlank:false,
								width:488
							}]
						}],
						buttons:[{
							text:'Cadastrar',
							iconCls:'ico_add',
							scale:'large',
							handler:function(){
								//TRATAMENTO DE PARTE DOS DADOS
								$idnomealuno = $('#idnomealuno').val();
								$iddatanascimento = $('#iddatanascimento').val();
								$idcpfluno = $('#idcpfluno').val();								
								$dependentetipo = $("[name='dependentetipo']").is(':checked');
								
								var $status = true;
								
								if($("#iddependente").is(':checked')){
									if($idnomealuno != "" && $iddatanascimento != "" && $idcpfluno != "" && $dependentetipo != false){
										$status = true;
									}else{
										$status = false;
									}
								}else{
									$status = true
								}
								
								//SUBMIT
								if(xt('formsolicitacaobolsa').getForm().isValid() && $status == true){
									xt('formsolicitacaobolsa').getForm().submit({
										url:'/simpacweb/modulos/RH/solicitacaoBolsaEstudos/ajax/solicitacaoBolsaEstudos_save.php',
										params:{
											idnomecolaborador:xt('idnomecolaborador').getValue(),
											idcurso:xt('idcurso').getValue(),
											idsemestre:xt('idsemestre').getValue(),
											desdependentetipo:$("[name='dependentetipo']:checked").parent().find('label').text()
										},
										success:function(){
											
											Ext.MessageBox.info('','Solicitacão para: '+xt('idnomecolaborador').getRawValue()+' efetuado!',function(btnok){
												if(btnok == 'ok'){
													resetFormDependentes();	
													xt('formsolicitacaobolsa').getForm().reset();
												}
											});	
										},
										failure:function(){
											
											Ext.MessageBox.warning('Aviso!','Preecha todos os campos corretamente.');
										}
									})
								}else{
									validDependentes();
									Ext.MessageBox.warning('Aviso!','Preecha todos os campos obrigatórios.');
								}
							}
						}]			
					}]
				}]
			});
//////////////////// VISUALIZAÇÃO SOLICITAÇÕES PENDENTES ////////////////////////////////////////			
			var visualizacaobolsapendente = new Ext.Panel({
				id:'idpanelvisualizacaobolsapendente', 
				height:580,
				width:700,
				border:false,
				items: [{
					xtype: "panel",
					id:'panelsolicitacoespendentes',
					iconCls:'ico_clock',
					title:'Solicitações Pendentes',
					border: false,
					padding: 5,
					height: 350,
					items:[{
						xtype:'grid',
						id:'gridsolicitacoespendentes',
						store:solicitacaobolsaestudos,
						plugins:expander1,
						height:320,
						loadMask:true,
						stripeRows:true,
						autoScroll:true,
						border:false,
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
								hidden:true,
								dataIndex:'idsolicitacaobolsaestudo'
							},{
								hidden:true,
								dataIndex:'idsolicitacaobolsaestudostipo'
							},{
								hidden:true,
								dataIndex:'idusuario'
							},{ 
								header:'Curso',
								width:200,
								sortable:true,
								dataIndex:'curso_titulo'
							},{ 
								header:'Semestre',
								width:50,
								sortable:true,
								dataIndex:'dessemestre'
							},{ 
								header:'Gestor',
								width:30,
								sortable:true,
								dataIndex:'ingestor',
								renderer:fn_solicitacaoStatus
							},{ 
								header:'RH',
								width:30,
								sortable:true,
								dataIndex:'inrh',
								renderer:fn_solicitacaoStatus
							},{
								header:'Diretoria',
								width:30,
								sortable:true,
								dataIndex:'indiretoria',
								renderer:fn_solicitacaoStatus
							}],
						}),
						listeners:{						
							'rowclick':function(a, index){/*	
								var $grid_pendentes = xt('gridsolicitacoespendentes').getStore();	
								var $ingestor = $grid_pendentes.getAt(index).get('ingestor');
								var $inrh = $grid_pendentes.getAt(index).get('inrh');
								var $indiretoria = $grid_pendentes.getAt(index).get('indiretoria');
														
								if(xt('gridsolicitacoespendentes').getSelectionModel().getSelected() && 
								   ($ingestor == 0 || $inrh == 0 || $indiretoria == 0)){
									xt('btnvermotivo').enable();
								}else{
									xt('btnvermotivo').disable();
								}							
							*/}						
						},
						bbar:[{/*
							text:'Ver Motivo',
							id:'btnvermotivo',
							disabled:true,
							tooltip:'Ver o motivo do bloqueio da solicitação',
							iconCls:'ico_cross',
							handler:function(){
								var $grid_pendentes = xt('gridsolicitacoespendentes').getSelectionModel().getSelected();
								
								Ext.Ajax.request({
									url: '/simpacweb/modulos/RH/solicitacaoBolsaEstudos/json/motivo_get.php',
									params: {
										idsolicitacaobolsaestudo:$grid_pendentes.get('idsolicitacaobolsaestudo')
									},
									success: function(response){
										
										var $json = Ext.util.JSON.decode(response.responseText).myData[0];
										
										if(Ext.getCmp('winmotivo')){
											Ext.getCmp('winmotivo').show();
										}else{																																																									
											new Ext.Window({
												id:'winmotivo',
												iconCls:'ico_cross',
												title:'Motivo do Bloqueio Soliçitação',
												border:false,
												resizable:false,
												width:500,
												height:165,
												bbar:[{
													xtype:'button',
													text:'Fechar',
													iconCls:'ico_fechar',
													handler:function(){
														xt('winmotivo').close();
													}
												}],
												items:[{
													xtype:'form',
													id:'formmotivo',
													border:false,
													padding:10,
													items:[{
														xtype:'fieldset',
														items:[{
															xtype:'textarea',
															id:'textmotivo',
															anchor:'98%',
															allowBlank:false,
															height:60,
															autoScroll:true,
															hideLabel:true,
															value:$json.desmotivo
														}]
													}]
												}]
											}).show();
										}
									}
								});
							}
						*/}]
					}]
				},{
//////////////////// VISUALIZAÇÃO SOLICITAÇÕES REPROVADAS ////////////////////////////////////////						
					xtype:'panel',
					id:'panelsolicitacoesreprovadas',
					title:'Solicitações Reprovadas',
					iconCls:'ico_no',
					border: false,
					style:'margin-top:0px',
					padding: 5,
					height: 190,
					autoScroll:true,
					items: [{
						xtype:'grid',
						id:'gridsolicitacoesreprovados',
						store:solicitacaobolsaestudosreprovados,
						height:153,
						plugins:expander3,
						loadMask:true,
						stripeRows:true,
						autoScroll:true,
						border:false,
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
							}),expander3,{
								hidden:true,
								dataIndex:'idsolicitacaobolsaestudo'
							},{
								hidden:true,
								dataIndex:'idsolicitacaobolsaestudostipo'
							},{
								hidden:true,
								dataIndex:'idusuario'
							},{ 
								header:'Curso',
								width:200,
								sortable:true,
								dataIndex:'curso_titulo'
							},{ 
								header:'Semestre',
								width:50,
								sortable:true,
								dataIndex:'dessemestre'
							},{ 
								header:'Gestor',
								width:30,
								sortable:true,
								dataIndex:'ingestor',
								renderer:fn_solicitacaoStatus
							},{ 
								header:'RH',
								width:30,
								sortable:true,
								dataIndex:'inrh',
								renderer:fn_solicitacaoStatus
							},{
								header:'Diretoria',
								width:30,
								sortable:true,
								dataIndex:'indiretoria',
								renderer:fn_solicitacaoStatus
							}],
						}),
						bbar:[{
							text:'Imprimir Formulário',
							id:'btnimprimirreprovado',
							iconCls:'ico_print',
							disabled:true,
							handler:function(){
								
								var $grid_reprovados = xt('gridsolicitacoesreprovados').getSelectionModel().getSelected();
								
								window.open('/simpacweb/modulos/RH/solicitacaoBolsaEstudos/print_solicitacaoBolsaEstudos.php?idsolicitacaobolsaestudo='+$grid_reprovados.get('idsolicitacaobolsaestudo'),'Print','width=1000, height=700, top=0, left=0, scrollbars=yes, status=no, toolbar=no, location=no, directories=no, addressbar=no, menubar=no, resizable=yes,maximize=yes');
							
							}
						},'-',{
							text:'Ver Motivo',
							id:'btnvermotivo',
							disabled:true,
							tooltip:'Ver o motivo do bloqueio da solicitação',
							iconCls:'ico_cross',
							handler:function(){
								var $grid_reprovados = xt('gridsolicitacoesreprovados').getSelectionModel().getSelected();
								
								Ext.Ajax.request({
									url: '/simpacweb/modulos/RH/solicitacaoBolsaEstudos/json/motivo_get.php',
									params: {
										idsolicitacaobolsaestudo:$grid_reprovados.get('idsolicitacaobolsaestudo')
									},
									success: function(response){
										
										var $json = Ext.util.JSON.decode(response.responseText).myData[0];
										
										if(Ext.getCmp('winmotivo')){
											Ext.getCmp('winmotivo').show();
										}else{																																																									
											new Ext.Window({
												id:'winmotivo',
												iconCls:'ico_cross',
												title:'Motivo do Bloqueio Soliçitação',
												border:false,
												resizable:false,
												width:500,
												height:165,
												bbar:[{
													xtype:'button',
													text:'Fechar',
													iconCls:'ico_fechar',
													handler:function(){
														xt('winmotivo').close();
													}
												}],
												items:[{
													xtype:'form',
													id:'formmotivo',
													border:false,
													padding:10,
													items:[{
														xtype:'fieldset',
														items:[{
															xtype:'textarea',
															id:'textmotivo',
															anchor:'98%',
															allowBlank:false,
															height:60,
															autoScroll:true,
															hideLabel:true,
															value:$json.desmotivo
														}]
													}]
												}]
											}).show();
										}
									}
								});
							}
						}],
						listeners:{
							'rowclick':function(a, index, c){								
								if(xt('gridsolicitacoesreprovados').getSelectionModel().getSelected()){
									xt('btnimprimirreprovado').enable();
									xt('btnvermotivo').enable();
								}else{
									xt('btnimprimirreprovado').disable();
									xt('btnvermotivo').disable();
								}								
							}
						}
					}]
				}]
			});
//////////////////// VISUALIZAÇÃO SOLICITAÇÕES APROVADAS ////////////////////////////////////////			
			var visualizacaobolsaaprovada = new Ext.Panel({
				id:'idpanelvisualizacaobolsaaprovada', 
				height:580,
				width:700,
				border:false,	
				items:[{
					xtype:'grid',
					id:'gridsolicitacoesaprovadas',
					store:solicitacaobolsaestudosaprovados,
					plugins:expander2,
					height:535,
					loadMask:true,
					stripeRows:true,
					autoScroll:true,
					border:false,
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
						}),expander2,{
							hidden:true,
							dataIndex:'idsolicitacaobolsaestudo'
						},{
							hidden:true,
							dataIndex:'idsolicitacaobolsaestudostipo'
						},{
							hidden:true,
							dataIndex:'idusuario'
						},{ 
							header:'Curso',
							width:200,
							sortable:true,
							dataIndex:'curso_titulo'
						},{ 
							header:'Semestre',
							width:50,
							sortable:true,
							dataIndex:'dessemestre'
						},{ 
							header:'% Concedido',
							tooltip:'Percentual de desconto concedido para a bolsa',
							width:55,
							sortable:true,
							dataIndex:'nrpercentual',
							renderer:function(v){
								return v+'%';
							}
						},{ 
							header:'Gestor',
							width:30,
							sortable:true,
							dataIndex:'ingestor',
							renderer:fn_solicitacaoStatus
						},{ 
							header:'RH',
							width:30,
							sortable:true,
							dataIndex:'inrh',
							renderer:fn_solicitacaoStatus
						},{
							header:'Diretoria',
							width:30,
							sortable:true,
							dataIndex:'indiretoria',
							renderer:fn_solicitacaoStatus
						}],
					}),
					bbar:[{
						text:'Imprimir Formulário',
						id:'btnimprimir',
						iconCls:'ico_print',
						disabled:true,
						handler:function(){
							
							var $grid_aprovados = xt('gridsolicitacoesaprovadas').getSelectionModel().getSelected();
							
							console.log($grid_aprovados.get('idsolicitacaobolsaestudo'));
							window.open('/simpacweb/modulos/RH/solicitacaoBolsaEstudos/print_solicitacaoBolsaEstudos.php?idsolicitacaobolsaestudo='+$grid_aprovados.get('idsolicitacaobolsaestudo'),'Print','width=1000, height=700, top=0, left=0, scrollbars=yes, status=no, toolbar=no, location=no, directories=no, addressbar=no, menubar=no, resizable=yes,maximize=yes');
						
						}
					}],
					listeners:{
						'rowclick':function(a, index, c){								
							if(xt('gridsolicitacoesaprovadas').getSelectionModel().getSelected()){
								xt('btnimprimir').enable();
							}else{
								xt('btnimprimir').disable();
							}								
						}
					}
				}],		
			});
			
////////////// MAIN WINDOW ///////////////////////////////////////////////////////////////////////		
			var mainWin = new Ext.Window({
				title:'Cadastro e Visualização de Bolsa de Estudos',		
				id:'winsolicitacaobolsaestudos',
				iconCls:'ico_aluno',
				height: 595,
				width: 710,
				modal:true,
				resizable: false,
				minimizable:true,
				items:new Ext.TabPanel({
					id:'idtabpanel',							 
					activeTab: 0,
					height:560,
					border:false,
					tabPosition:'bottom',
					autoScroll:false,
					items:[{
						title:'Solicitações Pendentes/Reprovadas',
						layout:'table',
						border:false,
						items:[visualizacaobolsapendente],
						listeners:{
							'activate':function(){
								solicitacaobolsaestudosreprovados.reload();
								solicitacaobolsaestudos.reload();
							}
						}
					},{
						title:'Solicitações Aprovadas',
						layout:'fit',
						items:[visualizacaobolsaaprovada],
						listeners:{
							'activate':function(){
								solicitacaobolsaestudosaprovados.reload();
							}
						}
					},{
						title:'Cadastro',
						layout: "table",
						border:false,
						items:[relatoriosolicitacaobolsa],
					}]
				})
			}).show();
		}
	});
}