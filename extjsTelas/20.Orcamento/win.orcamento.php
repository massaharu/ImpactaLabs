<?
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; //$GLOBALS['JSON'] = true; 
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 
?>
<script type="text/javascript">
	Ext.onReady(function(){
		SimpacWeb.vars.idpedido = 521730;
		//SimpacWeb.vars.idpedido = 567592;
		//CONSTANTS
		var $IDPEDIDO = SimpacWeb.vars.idpedido;
		var xt = Ext.getCmp;
		var idorcamento = "orcamento_";
		var ms = Ext.MessageBox;
		//VARIAVEIS
		var setIntervalajax_status_orcamento;
		var mask;
		//FUNCTIONS
		function ajax_status_orcamento(orcamento, idpanel)
		{
			if(!intervalOnline) clearInterval(setIntervalajax_status_orcamento);
			var parametros = {idpedido:orcamento};
			$.ajax({
				type: "POST",
				url:"/simpacweb/labs/Massaharu/extjsTelas/20.Orcamento/ajax/load_orcamento_dados_status.php?code=true",
				data: $.param(parametros),
				success: function(msg){
					$("#"+idpanel).html(msg);
					$("#"+idpanel).parent().css({
						'background-color' : '#FFFFFF'
					});
					if(idpanel == idorcamento+'orcamentoidpaneleast'){
						$("#"+idpanel+"-xsplit, #"+idorcamento+"orcamentoidpanelwest-xsplit").css({
							'background-color' : '#a9bfd3',
						});
						$("#"+idpanel).css({
							'background-color' : '#FFFFFF',
							'overflow' : 'auto',
							'height':Page.height-171,
						});
					}
				}
			});
		}
		//EVENTO ABRE ABA OPÇÔES
		$(window).keyup(function(event){
			$input = $('#'+idorcamento+'txtfieldorcamentosearch').is(':focus');
			
			if (event.keyCode == 32 && $input == false){
				xt(idorcamento+'tabpanel').setActiveTab(0);
				var w = xt(idorcamento+'orcamentoidpanelwest');
				
				if(w.collapsed){
					xt(idorcamento+'orcamentoidpaneleast').setWidth((Page.width-20)/3);
					xt('orcamento_gridstatusatual').setWidth((Page.width-20)/3);
					w.expand();
				}else{
					xt(idorcamento+'orcamentoidpaneleast').setWidth((Page.width-20)/2);
					xt('orcamento_gridstatusatual').setWidth((Page.width-20)/2);
					w.collapse();
				}
			}
			return false;
		});
		
		if(xt(idorcamento+'mainwindow')){
			xt(idorcamento+'mainwindow').show();
		}else{
			
			
			var $NrCPF = "";
			var $idcontato = "";
			var IDPEDIDO = "";
			var IDCONTATO = "";
			
			var $orcamentoAtend_Cliente;
			
			var storeOrcamentoAtendClientes_list = new Ext.data.JsonStore({
				url:'/simpacweb/labs/Massaharu/extjsTelas/20.Orcamento/json/orcamentoAtend_cliente_list.php',
				root:'myData',
				baseParams:{
					idpedido:$IDPEDIDO
				},
				fields:[{name:'idpedido', 	type:'int'},
					{name:'idcontato', 		type:'int'},
					{name:'idusuario', 		type:'int'},
					{name:'idvendedor', 	type:'int'},
					{name:'nrramal', 		type:'int'},
					{name:'dtcadastro', 	type:'date', dateFormat:'timestamp'},
					{name:'nome', 			type:'string'},
					{name:'email', 			type:'string'},
					{name:'nmCompleto', 	type:'string'},
					{name:'cdemail', 		type:'string'},
					{name:'nmCompleto2', 	type:'string'},
					{name:'cdemail2', 		type:'string'}],
				listeners:{
					'load':function(a){
						//console.log(a.getAt(0).get('idpedido'));
						IDPEDIDO = a.getAt(0).get('idpedido') + 15000;
						IDCONTATO = a.getAt(0).get('idcontato');
						
						xt(idorcamento+'mainwindow').setTitle('Orçamento Nº '+IDPEDIDO);
						
						//Pega as informações do contato a partir do pedido(Orçamento)
						Ext.Ajax.request({
							url:'/simpacweb/labs/Massaharu/extjsTelas/20.Orcamento/json/contato_get.php',
							params:{
								idcontato: IDCONTATO
							},
							success:function(response){
							
								$NrCPF = $.trim(Ext.util.JSON.decode(response.responseText).myData[0].NrCPF);		
							}
						});
						
						//Habilita/Desabilita Tab(Cheque à retirar)
						Ext.Ajax.request({
							url:'/simpacweb/labs/Massaharu/extjsTelas/20.Orcamento/json/orcamentoChequeARetirar.php',
							params:{
								idpedido:IDPEDIDO
							},
							success:function(response){
								$qtdObj = Ext.util.JSON.decode(response.responseText).myData.length;
								
								if($qtdObj > 0){
									xt(idorcamento+"chequeretirar").enable();		
								}else{
									xt(idorcamento+"chequeretirar").disable();
								}
							}
						});
						
						//Habilita/Desabilita Tab(Opções de Data)
						Ext.Ajax.request({
							url:'/simpacweb/labs/Massaharu/extjsTelas/20.Orcamento/json/orcamentoDataTreinamento.php',
							params:{
								idpedido:IDPEDIDO
							},
							success:function(response){
								$qtdObj = Ext.util.JSON.decode(response.responseText).myData.length;
								
								if($qtdObj > 0){
									xt(idorcamento+'opcaodata').enable();		
								}else{
									xt(idorcamento+'opcaodata').disable();
								}
							}
						});	
					}
				},
				
				autoLoad:true
				
			});	
			
			
			
			/////////////////// TAB ORÇAMENTO ////////////////////////////////////////////////////////////	
			var orcamentoCenterPanel = new Ext.Panel({
				title:'Dados do Orçamento',
				region: 'center',
				split: true,
				collapsed:false,
				id:idorcamento+'orcamentopanelcenter',
				autoScroll:true,
				border:false,
				layout:'fit',
				listeners:{
					'afterrender':function(){
						//mask = new Ext.LoadMask(xt(idorcamento+'mainwindow').body,{msg:'Aguarde...'});
						//mask.show();
						
						xt(idorcamento+'orcamentopanelcenter').load({
							url:'/simpacweb/labs/Massaharu/extjsTelas/20.Orcamento/ajax/load_orcamento_descricao.php?code=true', 
							params:{idpedido:SimpacWeb.vars.idpedido}, 
							scripts:true/*,
							callback:function(){
								mask.hide();
							}*/
						});
					}
				}
			});
			
			var orcamentoEastPanel = new Ext.Panel({
				region: 'east',
				id:idorcamento+'orcamentoidpaneleast',
				split: true,
				collapsed:false,
				collpasible:true,
				collapseMode:'mini',
				width:(Page.width-20)/2,
				border:false,
				autoScroll:true,
				layout:'fit',
				listeners:{
					'afterrender':function(){
						ajax_status_orcamento(SimpacWeb.vars.idpedido, idorcamento+"orcamentoidpaneleast");
						setIntervalajax_status_orcamento = setInterval("ajax_status_orcamento(SimpacWeb.vars.idpedido,  idorcamento+'orcamentoidpaneleast')",5000);
					}
				}
			});
			
			var orcamentoWestPanel = new Ext.Panel({
				title:'Opções do Orçamento',
				region: 'west',
				id:idorcamento+'orcamentoidpanelwest',
				split: true,
				collapsed:true,
				collpasible:true,
				collapseMode:'mini',
				width:(Page.width-20)/8,
				border:false,
				autoScroll:true,
				listeners:{
					'afterrender':function(){
						xt(idorcamento+'orcamentoidpanelwest').load({
							url:'/simpacweb/labs/Massaharu/extjsTelas/20.Orcamento/ajax/load_orcamento_dados_opcoes.php?code=true', params:{idpedido:SimpacWeb.vars.idpedido}, scripts:true
						});
					}
				}
			});
		/////////////////// MAIN WINDOW ////////////////////////////////////////////////////////////			
			var winorcamento = new Ext.Window({
				id:idorcamento+'mainwindow', 
				iconCls:'ico_orcamento',
				title:'Orçamento Nº '+SimpacWeb.vars.idpedido,
				height:Page.height-90,
				width:Page.width-140,
				border:false,
				layout:'fit',
				tbar:['->','Orçamento: ',{
					xtype:'textfield',
					id:idorcamento+'txtfieldorcamentosearch',
					value:SimpacWeb.vars.idpedido,
					enableKeyEvents:true,
					listeners:{
						'keyup':function(a, b){
							if(b.keyCode == 13){
								
								storeOrcamentoAtendClientes_list.reload({
									params:{idpedido: xt(idorcamento+'txtfieldorcamentosearch').getValue()},
									callback:function(){
										xt(idorcamento+'tabpanel').setActiveTab(0);	
										
										xt(idorcamento+'orcamentopanelcenter').load({
											url:'/simpacweb/labs/Massaharu/extjsTelas/20.Orcamento/ajax/load_orcamento_descricao.php?code=true', params:{idpedido:IDPEDIDO}, scripts:true
										});
										xt(idorcamento+'orcamentoidpanelwest').load({
											url:'/simpacweb/labs/Massaharu/extjsTelas/20.Orcamento/ajax/load_orcamento_dados_opcoes.php?code=true', params:{idpedido:IDPEDIDO}, scripts:true
										});
										
										ajax_status_orcamento(IDPEDIDO, idorcamento+"orcamentoidpaneleast");
										setIntervalajax_status_orcamento = setInterval("ajax_status_orcamento(IDPEDIDO,  idorcamento+'orcamentoidpaneleast')",5000);
									}
								});
							}
						}
					}
				}],
				items:[{
					xtype:'tabpanel',
					id:idorcamento+'tabpanel',
					margins:'2 2 2 2', 
					activeTab: 0,
					height:500,
					tabPosition:'bottom',
					autoScroll:false,
					border:false,
					items:[{
						title:'Orçamento',
						layout:'border',
						items:[orcamentoCenterPanel, orcamentoEastPanel, orcamentoWestPanel]
					},{
						title:'Descrição do Serviço',
						xtype : "panel",
						id:idorcamento+'paneldesservico',
						listeners:{
							'activate':function(){
								xt(idorcamento+'paneldesservico').load({
									url:'/simpacweb/labs/Massaharu/extjsTelas/20.Orcamento/ajax/load_descricao_do_servico.php?code=true', 
									params:{idpedido:IDPEDIDO}, 
									scripts:true
								});
							}
						}
					},{
						title:'Forma de Pagamento',
						xtype : "panel",
						layout:'fit',
						id:idorcamento+'panelformapagamento',
						listeners:{
							'activate':function(){
								xt(idorcamento+'panelformapagamento').load({
									url:'/simpacweb/labs/Massaharu/extjsTelas/20.Orcamento/ajax/load_forma_de_pagto.php?code=true', params:{idpedido:IDPEDIDO}, scripts:true
								});
							}
						}
					},{
						title:'Cheque à Retirar',
						xtype : "panel",
						id:idorcamento+'chequeretirar',
						listeners:{
							'activate':function(){
								xt(idorcamento+'chequeretirar').load({
									url:"/simpacweb/labs/Massaharu/extjsTelas/20.Orcamento/ajax/load_cheque_a_retirar.php?code=true", params:{idpedido:IDPEDIDO}, scripts:true
								});
							}
						}
					},{
						title:'Opção de Data',
						xtype:'panel',
						id:idorcamento+'opcaodata',
						layout:'fit',
						listeners:{
							'activate':function(){
								xt(idorcamento+'opcaodata').load({
									url:'/simpacweb/labs/Massaharu/extjsTelas/20.Orcamento/ajax/load_opcoes_de_data.php?code=true', params:{idpedido:IDPEDIDO}, scripts:true
								});
							}
						}
					},{
						title:'Histórico Atendimento',
						id:idorcamento+'historicoatendimento',
						xtype:'panel',
						listeners:{
							'activate':function(){
								xt(idorcamento+'historicoatendimento').load({
									url:'/simpacweb/labs/Massaharu/extjsTelas/20.Orcamento/ajax/load_historico_atendimento.php?code=true', 
									params:{
										idpedido:IDPEDIDO, 
										nrcpf:$NrCPF, 
										idcontato:IDCONTATO, 
										height:Page.height-265
									}
								});	
							}
						}
					},{
						title:'Histórico Orçamento',
						xtype:'panel',
						id:idorcamento+'historicoorcamento',
						listeners:{
							'activate':function(){
								xt(idorcamento+'historicoorcamento').load({
									url:'/simpacweb/labs/Massaharu/extjsTelas/20.Orcamento/ajax/load_historico_orcamento.php?code=true', 
									params:{
										idpedido:IDPEDIDO,
										height:Page.height-250
									}, 
									scripts:true
								});
							}
						}
					}]
				}]
			}).show();
		}
	});
</script>