<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript">
var idcursoagendado = SimpacWeb.vars.rec.get("idcursoagendado");
var treinamento  = SimpacWeb.vars.rec.get("destreinamento");
var dtinicio 	 = SimpacWeb.vars.rec.get("dtinicio"); 				//Inicio do treinamento
var dttermino 	 = SimpacWeb.vars.rec.get("dttermino");				//Termino do treinamento
var hinicio		 = SimpacWeb.vars.rec.get("dtinicio");				//Horario Inicio
var htermino	 = SimpacWeb.vars.rec.get("dttermino");				//Horario Termino
var count = 1;
var index;
var avaliacao = [0,0,0,0,0,0,0,0,0,0,0,0,0]; //Array que informa se foi informado uma avalição para cada questão
var avaliacaoNota = [0,0,0,0,0,0,0,0,0,0,0,0,0]; //Array que informa a nota de cada questão
if(xt("TM_avaliacao_final"))
	xt("TM_avaliacao_final").show();
else{
	var alunosStore = new Ext.data.JsonStore({
		root:"mydata",
		fields:['name','id'],
	});
	
	new Ext.Window({
		id:"TM_avaliacao_final",
		title:"Avaliação Final. Curso: " + idcursoagendado,
		width:510,
		height:400,
		resizable:true,
		border:false, 
		modal:true,
		items:[{
			xtype:"form",
			id:"avaliacao_final_form",
			border:false,
			labelWidth:50,
			padding:10,
			items:[{
				xtype:"fieldset",
				title:"Treinamento",
				iconCls:"ico_curso",
				border: false,
				items:[{
					html: '<span style="font-weight:bold">'+treinamento + ' ' + dtinicio.format("d/m/Y") + ' ' + hinicio.format("H:i:s") + ' ' + dttermino.format("d/m/Y") + ' ' + htermino.format("H:i:s")+'</span>',
					height:40,
					border:false,
				}]
			},{
				style:"margin-top:-20",
				xtype:"fieldset",
				iconCls:"ico_aluno",
				title:"Aluno",
				border: false,
				items:[{
					xtype:"combo",
					store:alunosStore,
					hideLabel:true,
					displayField:"name",
					valueField:"id",
					triggerAction:"all",
					mode:"local",
					id:"avaliacao_final_combo",
					anchor:"90%",
					listeners:{
						'select':function(a,b,c){
							index = c;
						}
					}
				}]
			},{
				style:"margin-top:-15",
				xtype:"fieldset",
				id:'fsquestoes',
				title:"Questões",
				iconCls:"ico_question",
				items:[{
//////////////////////////////////////////////////////////QUESTÃO 1////////////////////////////////////////////////////////////////////////////
					xtype:"compositefield",
					id:"compositefields1",
					hideLabel:true,
					width:500,
					border:false,
					items:[{
						style:"margin-top:25",
						xtype:"displayfield",
						id:"avaliacao_final_imagem1",
						width:60
					},{
						border:false,
						width:360,
						items:[{
							xtype:"displayfield",
							height:50,
							id:"avaliacao_final_idquestao1",
							hidden:true,
						},{
							xtype:"displayfield",
							id:"avaliacao_final_questao1",
							width:360,
							height:50,
						},{
							xtype:"textarea",
							id:"avaliacao_final_information1",
							width:340,
							height:50,
						}]
					},{
						id:"avaliacao_final_radio1",
						border:false,
						width:40,
						columns:1,
						items:[{
							style:"margin-top:10",
							xtype:"button",
							icon:'/simpacweb/images/ico/16/avaliacao_10_cinza.png',
							id:"avaliacao_final_radio1_1",
							tooltip:"<b>Ótimo</b>",
							enableToggle:true,
							inputValue:10,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio1_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
									xt("avaliacao_final_radio1_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									xt("avaliacao_final_radio1_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									xt("avaliacao_final_radio1_2").toggle(false);
									xt("avaliacao_final_radio1_3").toggle(false);
									avaliacao[0] = 1;
									avaliacaoNota[0] = 10;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio1_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									avaliacao[0] = 0;
									avaliacaoNota[0] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio1_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio1_1").pressed)
										xt("avaliacao_final_radio1_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
								}
							}
						},{
							style:"margin-top:10",
							xtype:"button",
							icon:'/simpacweb/images/ico/16/avaliacao_5_cinza.png',
							id:"avaliacao_final_radio1_2",
							tooltip:"<b>Bom</b>",
							inputValue:5,
							enableToggle:true,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio1_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									xt("avaliacao_final_radio1_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
									xt("avaliacao_final_radio1_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									xt("avaliacao_final_radio1_1").toggle(false);
									xt("avaliacao_final_radio1_3").toggle(false);
									avaliacao[0] = 1;
									avaliacaoNota[0] = 5;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio1_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									avaliacao[0] = 0;
									avaliacaoNota[0] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio1_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio1_2").pressed)
										xt("avaliacao_final_radio1_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
								}
							}
						},{
							style:"margin-top:10",
							xtype:"button",
							tooltip:"<b>Ruim</b>",
							icon:'/simpacweb/images/ico/16/avaliacao_0_cinza.png',
							id:"avaliacao_final_radio1_3",
							inputValue:0,
							enableToggle:true,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio1_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									xt("avaliacao_final_radio1_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									xt("avaliacao_final_radio1_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
									xt("avaliacao_final_radio1_1").toggle(false);
									xt("avaliacao_final_radio1_2").toggle(false);
									avaliacao[0] = 1;
									avaliacaoNota[0] = 0;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio1_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									avaliacao[0] = 0;
									avaliacaoNota[0] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio1_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio1_3").pressed)
										xt("avaliacao_final_radio1_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
								}
							}
						}]
					}]
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				},{
//////////////////////////////////////////////////////////QUESTÃO 2////////////////////////////////////////////////////////////////////////////
					xtype:"compositefield",
					id:"compositefields2",
					hidden:true,
					width:500,
					hideLabel:true,
					border:false,
					items:[{
						style:"margin-top:25",
						xtype:"displayfield",
						id:"avaliacao_final_imagem2",
						width:60
					},{
						border:false,
						width:360,
						items:[{
							xtype:"displayfield",
							id:"avaliacao_final_idquestao2",
							hidden:true,
						},{
							xtype:"displayfield",
							id:"avaliacao_final_questao2",
							width:360,
							height:50
						},{
							xtype:"textarea",
							id:"avaliacao_final_information2",
							width:340,
							height:50,
						}]
					},{
						id:"avaliacao_final_radio2",
						border:false,
						width:40,
						columns:1,
						items:[{
							style:"margin-top:10",
							xtype:"button",
							icon:'/simpacweb/images/ico/16/avaliacao_10_cinza.png',
							id:"avaliacao_final_radio2_1",
							tooltip:"<b>Ótimo</b>",
							enableToggle:true,
							inputValue:10,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio2_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
									xt("avaliacao_final_radio2_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									xt("avaliacao_final_radio2_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									xt("avaliacao_final_radio2_2").toggle(false);
									xt("avaliacao_final_radio2_3").toggle(false);
									avaliacao[1] = 1;
									avaliacaoNota[1] = 10;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio2_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									avaliacao[1] = 0;
									avaliacaoNota[1] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio2_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio2_1").pressed)
										xt("avaliacao_final_radio2_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
								}
							}
						},{
							style:"margin-top:10",
							xtype:"button",
							icon:'/simpacweb/images/ico/16/avaliacao_5_cinza.png',
							id:"avaliacao_final_radio2_2",
							tooltip:"<b>Bom</b>",
							inputValue:5,
							enableToggle:true,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio2_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									xt("avaliacao_final_radio2_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
									xt("avaliacao_final_radio2_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									xt("avaliacao_final_radio2_1").toggle(false);
									xt("avaliacao_final_radio2_3").toggle(false);
									avaliacao[1] = 1;
									avaliacaoNota[1] = 5;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio2_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									avaliacao[1] = 0;
									avaliacaoNota[1] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio2_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio2_2").pressed)
										xt("avaliacao_final_radio2_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
								}
							}
						},{
							style:"margin-top:10",
							xtype:"button",
							tooltip:"<b>Ruim</b>",
							icon:'/simpacweb/images/ico/16/avaliacao_0_cinza.png',
							id:"avaliacao_final_radio2_3",
							inputValue:0,
							enableToggle:true,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio2_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									xt("avaliacao_final_radio2_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									xt("avaliacao_final_radio2_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
									xt("avaliacao_final_radio2_1").toggle(false);
									xt("avaliacao_final_radio2_2").toggle(false);
									avaliacao[1] = 1;
									avaliacaoNota[1] = 0;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio2_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									avaliacao[1] = 0;
									avaliacaoNota[1] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio2_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio2_3").pressed)
										xt("avaliacao_final_radio2_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
								}
							}
						}]
					}]
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				},{
//////////////////////////////////////////////////////////QUESTÃO 3////////////////////////////////////////////////////////////////////////////
					xtype:"compositefield",
					id:"compositefields3",
					hidden:true,
					width:500,
					hideLabel:true,
					border:false,
					items:[{
						style:"margin-top:25",
						xtype:"displayfield",
						id:"avaliacao_final_imagem3",
						width:60
					},{
						border:false,
						width:360,
						items:[{
							xtype:"displayfield",
							id:"avaliacao_final_idquestao3",
							hidden:true,
						},{
							xtype:"displayfield",
							id:"avaliacao_final_questao3",
							width:360,
							height:50
						},{
							xtype:"textarea",
							id:"avaliacao_final_information3",
							width:340,
							height:50,
						}]
					},{
						id:"avaliacao_final_radio3",
						border:false,
						width:40,
						columns:1,
						items:[{
							style:"margin-top:10",
							xtype:"button",
							icon:'/simpacweb/images/ico/16/avaliacao_10_cinza.png',
							id:"avaliacao_final_radio3_1",
							tooltip:"<b>Ótimo</b>",
							enableToggle:true,
							inputValue:10,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio3_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
									xt("avaliacao_final_radio3_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									xt("avaliacao_final_radio3_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									xt("avaliacao_final_radio3_2").toggle(false);
									xt("avaliacao_final_radio3_3").toggle(false);
									avaliacao[2] = 1;
									avaliacaoNota[2] = 10;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio3_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									avaliacao[2] = 0;
									avaliacaoNota[2] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio3_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio3_1").pressed)
										xt("avaliacao_final_radio3_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
								}
							}
						},{
							style:"margin-top:10",
							xtype:"button",
							icon:'/simpacweb/images/ico/16/avaliacao_5_cinza.png',
							id:"avaliacao_final_radio3_2",
							tooltip:"<b>Bom</b>",
							inputValue:5,
							enableToggle:true,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio3_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									xt("avaliacao_final_radio3_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
									xt("avaliacao_final_radio3_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									xt("avaliacao_final_radio3_1").toggle(false);
									xt("avaliacao_final_radio3_3").toggle(false);
									avaliacao[2] = 1;
									avaliacaoNota[2] = 5;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio3_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									avaliacao[2] = 0;
									avaliacaoNota[2] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio3_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio3_2").pressed)
										xt("avaliacao_final_radio3_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
								}
							}
						},{
							style:"margin-top:10",
							xtype:"button",
							tooltip:"<b>Ruim</b>",
							icon:'/simpacweb/images/ico/16/avaliacao_0_cinza.png',
							id:"avaliacao_final_radio3_3",
							inputValue:0,
							enableToggle:true,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio3_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									xt("avaliacao_final_radio3_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									xt("avaliacao_final_radio3_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
									xt("avaliacao_final_radio3_1").toggle(false);
									xt("avaliacao_final_radio3_2").toggle(false);
									avaliacao[2] = 1;
									avaliacaoNota[2] = 0;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio3_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									avaliacao[2] = 0;
									avaliacaoNota[2] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio3_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio3_3").pressed)
										xt("avaliacao_final_radio3_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
								}
							}
						}]
					}]
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				},{
//////////////////////////////////////////////////////////QUESTÃO 4////////////////////////////////////////////////////////////////////////////
					xtype:"compositefield",
					id:"compositefields4",
					hidden:true,
					width:500,
					hideLabel:true,
					border:false,
					items:[{
						style:"margin-top:25",
						xtype:"displayfield",
						id:"avaliacao_final_imagem4",
						width:60
					},{
						border:false,
						width:360,
						items:[{
							xtype:"displayfield",
							id:"avaliacao_final_idquestao4",
							hidden:true,
						},{
							xtype:"displayfield",
							id:"avaliacao_final_questao4",
							width:360,
							height:50
						},{
							xtype:"textarea",
							id:"avaliacao_final_information4",
							width:340,
							height:50,
						}]
					},{
						id:"avaliacao_final_radio4",
						border:false,
						width:40,
						columns:1,
						items:[{
							style:"margin-top:10",
							xtype:"button",
							icon:'/simpacweb/images/ico/16/avaliacao_10_cinza.png',
							id:"avaliacao_final_radio4_1",
							tooltip:"<b>Ótimo</b>",
							enableToggle:true,
							inputValue:10,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio4_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
									xt("avaliacao_final_radio4_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									xt("avaliacao_final_radio4_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									xt("avaliacao_final_radio4_2").toggle(false);
									xt("avaliacao_final_radio4_3").toggle(false);
									avaliacao[3] = 1;
									avaliacaoNota[3] = 10;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio4_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									avaliacao[3] = 0;
									avaliacaoNota[3] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio4_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio4_1").pressed)
										xt("avaliacao_final_radio4_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
								}
							}
						},{
							style:"margin-top:10",
							xtype:"button",
							icon:'/simpacweb/images/ico/16/avaliacao_5_cinza.png',
							id:"avaliacao_final_radio4_2",
							tooltip:"<b>Bom</b>",
							inputValue:5,
							enableToggle:true,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio4_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									xt("avaliacao_final_radio4_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
									xt("avaliacao_final_radio4_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									xt("avaliacao_final_radio4_1").toggle(false);
									xt("avaliacao_final_radio4_3").toggle(false);
									avaliacao[3] = 1;
									avaliacaoNota[3] = 5;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio4_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									avaliacao[3] = 0;
									avaliacaoNota[3] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio4_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio4_2").pressed)
										xt("avaliacao_final_radio4_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
								}
							}
						},{
							style:"margin-top:10",
							xtype:"button",
							tooltip:"<b>Ruim</b>",
							icon:'/simpacweb/images/ico/16/avaliacao_0_cinza.png',
							id:"avaliacao_final_radio4_3",
							inputValue:0,
							enableToggle:true,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio4_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									xt("avaliacao_final_radio4_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									xt("avaliacao_final_radio4_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
									xt("avaliacao_final_radio4_1").toggle(false);
									xt("avaliacao_final_radio4_2").toggle(false);
									avaliacao[3] = 1;
									avaliacaoNota[3] = 0;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio4_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									avaliacao[3] = 0;
									avaliacaoNota[3] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio4_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio4_3").pressed)
										xt("avaliacao_final_radio4_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
								}
							}
						}]
					}]
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				},{
//////////////////////////////////////////////////////////QUESTÃO 5////////////////////////////////////////////////////////////////////////////
					xtype:"compositefield",
					id:"compositefields5",
					hidden:true,
					width:500,
					hideLabel:true,
					border:false,
					items:[{
						style:"margin-top:25",
						xtype:"displayfield",
						id:"avaliacao_final_imagem5",
						width:60
					},{
						border:false,
						width:360,
						items:[{
							xtype:"displayfield",
							id:"avaliacao_final_idquestao5",
							hidden:true,
						},{
							xtype:"displayfield",
							id:"avaliacao_final_questao5",
							width:360,
							height:50
						},{
							xtype:"textarea",
							id:"avaliacao_final_information5",
							width:340,
							height:50,
						}]
					},{
						id:"avaliacao_final_radio5",
						border:false,
						width:40,
						columns:1,
						items:[{
							style:"margin-top:10",
							xtype:"button",
							icon:'/simpacweb/images/ico/16/avaliacao_10_cinza.png',
							id:"avaliacao_final_radio5_1",
							tooltip:"<b>Ótimo</b>",
							enableToggle:true,
							inputValue:10,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio5_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
									xt("avaliacao_final_radio5_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									xt("avaliacao_final_radio5_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									xt("avaliacao_final_radio5_2").toggle(false);
									xt("avaliacao_final_radio5_3").toggle(false);
									avaliacao[4] = 1;
									avaliacaoNota[4] = 10;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio5_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									avaliacao[4] = 0;
									avaliacaoNota[4] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio5_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio5_1").pressed)
										xt("avaliacao_final_radio5_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
								}
							}
						},{
							style:"margin-top:10",
							xtype:"button",
							icon:'/simpacweb/images/ico/16/avaliacao_5_cinza.png',
							id:"avaliacao_final_radio5_2",
							tooltip:"<b>Bom</b>",
							inputValue:5,
							enableToggle:true,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio5_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									xt("avaliacao_final_radio5_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
									xt("avaliacao_final_radio5_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									xt("avaliacao_final_radio5_1").toggle(false);
									xt("avaliacao_final_radio5_3").toggle(false);
									avaliacao[4] = 1;
									avaliacaoNota[4] = 5;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio5_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									avaliacao[4] = 0;
									avaliacaoNota[4] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio5_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio5_2").pressed)
										xt("avaliacao_final_radio5_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
								}
							}
						},{
							style:"margin-top:10",
							xtype:"button",
							tooltip:"<b>Ruim</b>",
							icon:'/simpacweb/images/ico/16/avaliacao_0_cinza.png',
							id:"avaliacao_final_radio5_3",
							inputValue:0,
							enableToggle:true,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio5_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									xt("avaliacao_final_radio5_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									xt("avaliacao_final_radio5_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
									xt("avaliacao_final_radio5_1").toggle(false);
									xt("avaliacao_final_radio5_2").toggle(false);
									avaliacao[4] = 1;
									avaliacaoNota[4] = 0;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio5_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									avaliacao[4] = 0;
									avaliacaoNota[4] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio5_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio5_3").pressed)
										xt("avaliacao_final_radio5_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
								}
							}
						}]
					}]
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				},{
//////////////////////////////////////////////////////////QUESTÃO 6////////////////////////////////////////////////////////////////////////////
					xtype:"compositefield",
					id:"compositefields6",
					hidden:true,
					width:500,
					hideLabel:true,
					border:false,
					items:[{
						style:"margin-top:25",
						xtype:"displayfield",
						id:"avaliacao_final_imagem6",
						width:60
					},{
						border:false,
						width:360,
						items:[{
							xtype:"displayfield",
							id:"avaliacao_final_idquestao6",
							hidden:true,
						},{
							xtype:"displayfield",
							id:"avaliacao_final_questao6",
							width:360,
							height:50
						},{
							xtype:"textarea",
							id:"avaliacao_final_information6",
							width:340,
							height:50,
						}]
					},{
						id:"avaliacao_final_radio6",
						border:false,
						width:40,
						columns:1,
						items:[{
							style:"margin-top:10",
							xtype:"button",
							icon:'/simpacweb/images/ico/16/avaliacao_10_cinza.png',
							id:"avaliacao_final_radio6_1",
							tooltip:"<b>Ótimo</b>",
							enableToggle:true,
							inputValue:10,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio6_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
									xt("avaliacao_final_radio6_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									xt("avaliacao_final_radio6_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									xt("avaliacao_final_radio6_2").toggle(false);
									xt("avaliacao_final_radio6_3").toggle(false);
									avaliacao[5] = 1;
									avaliacaoNota[5] = 10;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio6_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									avaliacao[5] = 0;
									avaliacaoNota[5] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio6_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio6_1").pressed)
										xt("avaliacao_final_radio6_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
								}
							}
						},{
							style:"margin-top:10",
							xtype:"button",
							icon:'/simpacweb/images/ico/16/avaliacao_5_cinza.png',
							id:"avaliacao_final_radio6_2",
							tooltip:"<b>Bom</b>",
							inputValue:5,
							enableToggle:true,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio6_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									xt("avaliacao_final_radio6_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
									xt("avaliacao_final_radio6_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									xt("avaliacao_final_radio6_1").toggle(false);
									xt("avaliacao_final_radio6_3").toggle(false);
									avaliacao[5] = 1;
									avaliacaoNota[5] = 5;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio6_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									avaliacao[5] = 0;
									avaliacaoNota[5] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio6_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio6_2").pressed)
										xt("avaliacao_final_radio6_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
								}
							}
						},{
							style:"margin-top:10",
							xtype:"button",
							tooltip:"<b>Ruim</b>",
							icon:'/simpacweb/images/ico/16/avaliacao_0_cinza.png',
							id:"avaliacao_final_radio6_3",
							inputValue:0,
							enableToggle:true,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio6_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									xt("avaliacao_final_radio6_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									xt("avaliacao_final_radio6_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
									xt("avaliacao_final_radio6_1").toggle(false);
									xt("avaliacao_final_radio6_2").toggle(false);
									avaliacao[5] = 1;
									avaliacaoNota[5] = 0;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio6_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									avaliacao[5] = 0;
									avaliacaoNota[5] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio6_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio6_3").pressed)
										xt("avaliacao_final_radio6_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
								}
							}
						}]
					}]
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				},{
//////////////////////////////////////////////////////////QUESTÃO 7////////////////////////////////////////////////////////////////////////////
					xtype:"compositefield",
					id:"compositefields7",
					hidden:true,
					width:500,
					hideLabel:true,
					border:false,
					items:[{
						style:"margin-top:25",
						xtype:"displayfield",
						id:"avaliacao_final_imagem7",
						width:60
					},{
						border:false,
						width:360,
						items:[{
							xtype:"displayfield",
							id:"avaliacao_final_idquestao7",
							hidden:true,
						},{
							xtype:"displayfield",
							id:"avaliacao_final_questao7",
							width:360,
							height:50
						},{
							xtype:"textarea",
							id:"avaliacao_final_information7",
							width:340,
							height:50,
						}]
					},{
						id:"avaliacao_final_radio7",
						border:false,
						width:40,
						columns:1,
						items:[{
							style:"margin-top:10",
							xtype:"button",
							icon:'/simpacweb/images/ico/16/avaliacao_10_cinza.png',
							id:"avaliacao_final_radio7_1",
							tooltip:"<b>Ótimo</b>",
							enableToggle:true,
							inputValue:10,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio7_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
									xt("avaliacao_final_radio7_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									xt("avaliacao_final_radio7_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									xt("avaliacao_final_radio7_2").toggle(false);
									xt("avaliacao_final_radio7_3").toggle(false);
									avaliacao[6] = 1;
									avaliacaoNota[6] = 10;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio7_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									avaliacao[6] = 0;
									avaliacaoNota[6] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio7_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio7_1").pressed)
										xt("avaliacao_final_radio7_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
								}
							}
						},{
							style:"margin-top:10",
							xtype:"button",
							icon:'/simpacweb/images/ico/16/avaliacao_5_cinza.png',
							id:"avaliacao_final_radio7_2",
							tooltip:"<b>Bom</b>",
							inputValue:5,
							enableToggle:true,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio7_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									xt("avaliacao_final_radio7_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
									xt("avaliacao_final_radio7_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									xt("avaliacao_final_radio7_1").toggle(false);
									xt("avaliacao_final_radio7_3").toggle(false);
									avaliacao[6] = 1;
									avaliacaoNota[6] = 5;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio7_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									avaliacao[6] = 0;
									avaliacaoNota[6] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio7_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio7_2").pressed)
										xt("avaliacao_final_radio7_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
								}
							}
						},{
							style:"margin-top:10",
							xtype:"button",
							tooltip:"<b>Ruim</b>",
							icon:'/simpacweb/images/ico/16/avaliacao_0_cinza.png',
							id:"avaliacao_final_radio7_3",
							inputValue:0,
							enableToggle:true,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio7_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									xt("avaliacao_final_radio7_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									xt("avaliacao_final_radio7_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
									xt("avaliacao_final_radio7_1").toggle(false);
									xt("avaliacao_final_radio7_2").toggle(false);
									avaliacao[6] = 1;
									avaliacaoNota[6] = 0;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio7_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									avaliacao[6] = 0;
									avaliacaoNota[6] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio7_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio7_3").pressed)
										xt("avaliacao_final_radio7_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
								}
							}
						}]
					}]
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				},{
//////////////////////////////////////////////////////////QUESTÃO 8////////////////////////////////////////////////////////////////////////////
					xtype:"compositefield",
					id:"compositefields8",
					hidden:true,
					width:500,
					hideLabel:true,
					border:false,
					items:[{
						style:"margin-top:25",
						xtype:"displayfield",
						id:"avaliacao_final_imagem8",
						width:60
					},{
						border:false,
						width:360,
						items:[{
							xtype:"displayfield",
							id:"avaliacao_final_idquestao8",
							hidden:true,
						},{
							xtype:"displayfield",
							id:"avaliacao_final_questao8",
							width:360,
							height:50
						},{
							xtype:"textarea",
							id:"avaliacao_final_information8",
							width:340,
							height:50,
						}]
					},{
						id:"avaliacao_final_radio8",
						border:false,
						width:40,
						columns:1,
						items:[{
							style:"margin-top:10",
							xtype:"button",
							icon:'/simpacweb/images/ico/16/avaliacao_10_cinza.png',
							id:"avaliacao_final_radio8_1",
							tooltip:"<b>Ótimo</b>",
							enableToggle:true,
							inputValue:10,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio8_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
									xt("avaliacao_final_radio8_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									xt("avaliacao_final_radio8_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									xt("avaliacao_final_radio8_2").toggle(false);
									xt("avaliacao_final_radio8_3").toggle(false);
									avaliacao[7] = 1;
									avaliacaoNota[7] = 10;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio8_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									avaliacao[7] = 0;
									avaliacaoNota[7] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio8_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio8_1").pressed)
										xt("avaliacao_final_radio8_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
								}
							}
						},{
							style:"margin-top:10",
							xtype:"button",
							icon:'/simpacweb/images/ico/16/avaliacao_5_cinza.png',
							id:"avaliacao_final_radio8_2",
							tooltip:"<b>Bom</b>",
							inputValue:5,
							enableToggle:true,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio8_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									xt("avaliacao_final_radio8_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
									xt("avaliacao_final_radio8_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									xt("avaliacao_final_radio8_1").toggle(false);
									xt("avaliacao_final_radio8_3").toggle(false);
									avaliacao[7] = 1;
									avaliacaoNota[7] = 5;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio8_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									avaliacao[7] = 0;
									avaliacaoNota[7] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio8_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio8_2").pressed)
										xt("avaliacao_final_radio8_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
								}
							}
						},{
							style:"margin-top:10",
							xtype:"button",
							tooltip:"<b>Ruim</b>",
							icon:'/simpacweb/images/ico/16/avaliacao_0_cinza.png',
							id:"avaliacao_final_radio8_3",
							inputValue:0,
							enableToggle:true,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio8_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									xt("avaliacao_final_radio8_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									xt("avaliacao_final_radio8_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
									xt("avaliacao_final_radio8_1").toggle(false);
									xt("avaliacao_final_radio8_2").toggle(false);
									avaliacao[7] = 1;
									avaliacaoNota[7] = 0;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio8_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									avaliacao[7] = 0;
									avaliacaoNota[7] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio8_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio8_3").pressed)
										xt("avaliacao_final_radio8_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
								}
							}
						}]
					}]
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				},{
//////////////////////////////////////////////////////////QUESTÃO 9////////////////////////////////////////////////////////////////////////////
					xtype:"compositefield",
					id:"compositefields9",
					hidden:true,
					width:500,
					hideLabel:true,
					border:false,
					items:[{
						style:"margin-top:25",
						xtype:"displayfield",
						id:"avaliacao_final_imagem9",
						width:60
					},{
						border:false,
						width:360,
						items:[{
							xtype:"displayfield",
							id:"avaliacao_final_idquestao9",
							hidden:true,
						},{
							xtype:"displayfield",
							id:"avaliacao_final_questao9",
							width:360,
							height:50
						},{
							xtype:"textarea",
							id:"avaliacao_final_information9",
							width:340,
							height:50,
						}]
					},{
						id:"avaliacao_final_radio9",
						border:false,
						width:40,
						columns:1,
						items:[{
							style:"margin-top:10",
							xtype:"button",
							icon:'/simpacweb/images/ico/16/avaliacao_10_cinza.png',
							id:"avaliacao_final_radio9_1",
							tooltip:"<b>Ótimo</b>",
							enableToggle:true,
							inputValue:10,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio9_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
									xt("avaliacao_final_radio9_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									xt("avaliacao_final_radio9_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									xt("avaliacao_final_radio9_2").toggle(false);
									xt("avaliacao_final_radio9_3").toggle(false);
									avaliacao[8] = 1;
									avaliacaoNota[8] = 10;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio9_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									avaliacao[8] = 0;
									avaliacaoNota[8] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio9_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio9_1").pressed)
										xt("avaliacao_final_radio9_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
								}
							}
						},{
							style:"margin-top:10",
							xtype:"button",
							icon:'/simpacweb/images/ico/16/avaliacao_5_cinza.png',
							id:"avaliacao_final_radio9_2",
							tooltip:"<b>Bom</b>",
							inputValue:5,
							enableToggle:true,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio9_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									xt("avaliacao_final_radio9_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
									xt("avaliacao_final_radio9_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									xt("avaliacao_final_radio9_1").toggle(false);
									xt("avaliacao_final_radio9_3").toggle(false);
									avaliacao[8] = 1;
									avaliacaoNota[8] = 5;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio9_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									avaliacao[8] = 0;
									avaliacaoNota[8] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio9_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio9_2").pressed)
										xt("avaliacao_final_radio9_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
								}
							}
						},{
							style:"margin-top:10",
							xtype:"button",
							tooltip:"<b>Ruim</b>",
							icon:'/simpacweb/images/ico/16/avaliacao_0_cinza.png',
							id:"avaliacao_final_radio9_3",
							inputValue:0,
							enableToggle:true,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio9_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									xt("avaliacao_final_radio9_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									xt("avaliacao_final_radio9_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
									xt("avaliacao_final_radio9_1").toggle(false);
									xt("avaliacao_final_radio9_2").toggle(false);
									avaliacao[8] = 1;
									avaliacaoNota[8] = 0;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio9_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									avaliacao[8] = 0;
									avaliacaoNota[8] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio9_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio9_3").pressed)
										xt("avaliacao_final_radio9_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
								}
							}
						}]
					}]
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				},{
//////////////////////////////////////////////////////////QUESTÃO 10///////////////////////////////////////////////////////////////////////////
					xtype:"compositefield",
					id:"compositefields10",
					hidden:true,
					width:500,
					hideLabel:true,
					border:false,
					items:[{
						style:"margin-top:25",
						xtype:"displayfield",
						id:"avaliacao_final_imagem10",
						width:60
					},{
						border:false,
						width:360,
						items:[{
							xtype:"displayfield",
							id:"avaliacao_final_idquestao10",
							hidden:true,
						},{
							xtype:"displayfield",
							id:"avaliacao_final_questao10",
							width:360,
							height:50
						},{
							xtype:"textarea",
							id:"avaliacao_final_information10",
							width:340,
							height:50,
						}]
					},{
						id:"avaliacao_final_radio10",
						border:false,
						width:40,
						columns:1,
						items:[{
							style:"margin-top:10",
							xtype:"button",
							icon:'/simpacweb/images/ico/16/avaliacao_10_cinza.png',
							id:"avaliacao_final_radio10_1",
							tooltip:"<b>Ótimo</b>",
							enableToggle:true,
							inputValue:10,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio10_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
									xt("avaliacao_final_radio10_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									xt("avaliacao_final_radio10_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									xt("avaliacao_final_radio10_2").toggle(false);
									xt("avaliacao_final_radio10_3").toggle(false);
									avaliacao[9] = 1;
									avaliacaoNota[9] = 10;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio10_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									avaliacao[9] = 0;
									avaliacaoNota[9] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio10_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio10_1").pressed)
										xt("avaliacao_final_radio10_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
								}
							}
						},{
							style:"margin-top:10",
							xtype:"button",
							icon:'/simpacweb/images/ico/16/avaliacao_5_cinza.png',
							id:"avaliacao_final_radio10_2",
							tooltip:"<b>Bom</b>",
							inputValue:5,
							enableToggle:true,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio10_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									xt("avaliacao_final_radio10_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
									xt("avaliacao_final_radio10_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									xt("avaliacao_final_radio10_1").toggle(false);
									xt("avaliacao_final_radio10_3").toggle(false);
									avaliacao[9] = 1;
									avaliacaoNota[9] = 5;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio10_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									avaliacao[9] = 0;
									avaliacaoNota[9] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio10_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio10_2").pressed)
										xt("avaliacao_final_radio10_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
								}
							}
						},{
							style:"margin-top:10",
							xtype:"button",
							tooltip:"<b>Ruim</b>",
							icon:'/simpacweb/images/ico/16/avaliacao_0_cinza.png',
							id:"avaliacao_final_radio10_3",
							inputValue:0,
							enableToggle:true,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio10_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									xt("avaliacao_final_radio10_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									xt("avaliacao_final_radio10_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
									xt("avaliacao_final_radio10_1").toggle(false);
									xt("avaliacao_final_radio10_2").toggle(false);
									avaliacao[9] = 1;
									avaliacaoNota[9] = 0;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio10_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									avaliacao[9] = 0;
									avaliacaoNota[9] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio10_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio10_3").pressed)
										xt("avaliacao_final_radio10_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
								}
							}
						}]
					}]
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				},{
//////////////////////////////////////////////////////////QUESTÃO 11///////////////////////////////////////////////////////////////////////////
					xtype:"compositefield",
					id:"compositefields11",
					hidden:true,
					width:500,
					hideLabel:true,
					border:false,
					items:[{
						style:"margin-top:25",
						xtype:"displayfield",
						id:"avaliacao_final_imagem11",
						width:60
					},{
						border:false,
						width:360,
						items:[{
							xtype:"displayfield",
							id:"avaliacao_final_idquestao11",
							hidden:true,
						},{
							xtype:"displayfield",
							id:"avaliacao_final_questao11",
							width:360,
							height:50
						},{
							xtype:"textarea",
							id:"avaliacao_final_information11",
							width:340,
							height:50,
						}]
					},{
						id:"avaliacao_final_radio11",
						border:false,
						width:40,
						columns:1,
						items:[{
							style:"margin-top:10",
							xtype:"button",
							icon:'/simpacweb/images/ico/16/avaliacao_10_cinza.png',
							id:"avaliacao_final_radio11_1",
							tooltip:"<b>Ótimo</b>",
							enableToggle:true,
							inputValue:10,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio11_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
									xt("avaliacao_final_radio11_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									xt("avaliacao_final_radio11_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									xt("avaliacao_final_radio11_2").toggle(false);
									xt("avaliacao_final_radio11_3").toggle(false);
									avaliacao[10] = 1;
									avaliacaoNota[10] = 10;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio11_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									avaliacao[10] = 0;
									avaliacaoNota[10] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio11_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio11_1").pressed)
										xt("avaliacao_final_radio11_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
								}
							}
						},{
							style:"margin-top:10",
							xtype:"button",
							icon:'/simpacweb/images/ico/16/avaliacao_5_cinza.png',
							id:"avaliacao_final_radio11_2",
							tooltip:"<b>Bom</b>",
							inputValue:5,
							enableToggle:true,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio11_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									xt("avaliacao_final_radio11_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
									xt("avaliacao_final_radio11_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									xt("avaliacao_final_radio11_1").toggle(false);
									xt("avaliacao_final_radio11_3").toggle(false);
									avaliacao[10] = 1;
									avaliacaoNota[10] = 5;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio11_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									avaliacao[10] = 0;
									avaliacaoNota[10] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio11_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio11_2").pressed)
										xt("avaliacao_final_radio11_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
								}
							}
						},{
							style:"margin-top:10",
							xtype:"button",
							tooltip:"<b>Ruim</b>",
							icon:'/simpacweb/images/ico/16/avaliacao_0_cinza.png',
							id:"avaliacao_final_radio11_3",
							inputValue:0,
							enableToggle:true,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio11_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									xt("avaliacao_final_radio11_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									xt("avaliacao_final_radio11_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
									xt("avaliacao_final_radio11_1").toggle(false);
									xt("avaliacao_final_radio11_2").toggle(false);
									avaliacao[10] = 1;
									avaliacaoNota[10] = 0;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio11_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									avaliacao[10] = 0;
									avaliacaoNota[0] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio11_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio11_3").pressed)
										xt("avaliacao_final_radio11_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
								}
							}
						}]
					}]
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				},{
//////////////////////////////////////////////////////////QUESTÃO 12///////////////////////////////////////////////////////////////////////////
					xtype:"compositefield",
					id:"compositefields12",
					hidden:true,
					width:500,
					hideLabel:true,
					border:false,
					items:[{
					style:"margin-top:25",
					xtype:"displayfield",
					id:"avaliacao_final_imagem12",
					width:60
				},{
					border:false,
					width:360,
					items:[{
						xtype:"displayfield",
						id:"avaliacao_final_idquestao12",
						hidden:true,
					},{
						xtype:"displayfield",
						id:"avaliacao_final_questao12",
						width:360,
						height:50
					},{
						xtype:"textarea",
						id:"avaliacao_final_information12",
						width:340,
						height:50,
					}]
				},{
					id:"avaliacao_final_radio12",
					border:false,
					width:40,
					columns:1,
					items:[{
						style:"margin-top:10",
						xtype:"button",
						icon:'/simpacweb/images/ico/16/avaliacao_10_cinza.png',
						id:"avaliacao_final_radio12_1",
						tooltip:"<b>Ótimo</b>",
						enableToggle:true,
						inputValue:10,
						handler:function(){
							if(this.pressed){
								xt("avaliacao_final_radio12_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
								xt("avaliacao_final_radio12_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
								xt("avaliacao_final_radio12_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
								xt("avaliacao_final_radio12_2").toggle(false);
								xt("avaliacao_final_radio12_3").toggle(false);
								avaliacao[11] = 1;
								avaliacaoNota[11] = 10;
								xt('btnproximo').enable();
							}else{
								xt("avaliacao_final_radio12_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
								avaliacao[11] = 0;
								avaliacaoNota[11] = 0;
								xt('btnproximo').disable();
							}
						},
						listeners:{
							'mouseover':function(){
								xt("avaliacao_final_radio12_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
							},
							'mouseout':function(){
								if(!xt("avaliacao_final_radio12_1").pressed)
									xt("avaliacao_final_radio12_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
							}
						}
					},{
						style:"margin-top:10",
						xtype:"button",
						icon:'/simpacweb/images/ico/16/avaliacao_5_cinza.png',
						id:"avaliacao_final_radio12_2",
						tooltip:"<b>Bom</b>",
						inputValue:5,
						enableToggle:true,
						handler:function(){
							if(this.pressed){
								xt("avaliacao_final_radio12_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
								xt("avaliacao_final_radio12_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
								xt("avaliacao_final_radio12_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
								xt("avaliacao_final_radio12_1").toggle(false);
								xt("avaliacao_final_radio12_3").toggle(false);
								avaliacao[11] = 1;
								avaliacaoNota[11] = 5;
								xt('btnproximo').enable();
							}else{
								xt("avaliacao_final_radio12_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
								avaliacao[11] = 0;
								avaliacaoNota[11] = 0;
								xt('btnproximo').disable();
							}
						},
						listeners:{
							'mouseover':function(){
								xt("avaliacao_final_radio12_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
							},
							'mouseout':function(){
								if(!xt("avaliacao_final_radio12_2").pressed)
									xt("avaliacao_final_radio12_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
							}
						}
					},{
						style:"margin-top:10",
						xtype:"button",
						tooltip:"<b>Ruim</b>",
						icon:'/simpacweb/images/ico/16/avaliacao_0_cinza.png',
						id:"avaliacao_final_radio12_3",
						inputValue:0,
						enableToggle:true,
						handler:function(){
							if(this.pressed){
								xt("avaliacao_final_radio12_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
								xt("avaliacao_final_radio12_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
								xt("avaliacao_final_radio12_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
								xt("avaliacao_final_radio12_1").toggle(false);
								xt("avaliacao_final_radio12_2").toggle(false);
								avaliacao[11] = 1;
								avaliacaoNota[11] = 0;
								xt('btnproximo').enable();
							}else{
								xt("avaliacao_final_radio12_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
								avaliacao[11] = 0;
								avaliacaoNota[11] = 0;
								xt('btnproximo').disable();
							}
						},
						listeners:{
							'mouseover':function(){
								xt("avaliacao_final_radio12_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
							},
							'mouseout':function(){
								if(!xt("avaliacao_final_radio12_3").pressed)
									xt("avaliacao_final_radio12_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
							}
						}
					}]
				}]
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				},{
//////////////////////////////////////////////////////////QUESTÃO 13//////////////////////////////////////////////////////////////////////////
					xtype:"compositefield",
					id:"compositefields13",
					hidden:true,
					width:500,
					hideLabel:true,
					border:false,
					items:[{
						style:"margin-top:25",
						xtype:"displayfield",
						id:"avaliacao_final_imagem13",
						width:60
					},{
						border:false,
						width:360,
						items:[{
							xtype:"displayfield",
							id:"avaliacao_final_idquestao13",
							hidden:true,
						},{
							xtype:"displayfield",
							id:"avaliacao_final_questao13",
							width:360,
							height:50
						},{
							xtype:"textarea",
							id:"avaliacao_final_information13",
							width:340,
							height:50,
						}]
					},{
						id:"avaliacao_final_radio13",
						border:false,
						width:40,
						columns:1,
						items:[{
							style:"margin-top:10",
							xtype:"button",
							icon:'/simpacweb/images/ico/16/avaliacao_10_cinza.png',
							id:"avaliacao_final_radio13_1",
							tooltip:"<b>Ótimo</b>",
							enableToggle:true,
							inputValue:10,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio13_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
									xt("avaliacao_final_radio13_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									xt("avaliacao_final_radio13_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									xt("avaliacao_final_radio13_2").toggle(false);
									xt("avaliacao_final_radio13_3").toggle(false);
									avaliacao[12] = 1;
									avaliacaoNota[12] = 10;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio13_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									avaliacao[12] = 0;
									avaliacaoNota[12] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio13_1").setIcon('/simpacweb/images/ico/16/avaliacao_10.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio13_1").pressed)
										xt("avaliacao_final_radio13_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
								}
							}
						},{
							style:"margin-top:10",
							xtype:"button",
							icon:'/simpacweb/images/ico/16/avaliacao_5_cinza.png',
							id:"avaliacao_final_radio13_2",
							tooltip:"<b>Bom</b>",
							inputValue:5,
							enableToggle:true,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio13_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									xt("avaliacao_final_radio13_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
									xt("avaliacao_final_radio13_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									xt("avaliacao_final_radio13_1").toggle(false);
									xt("avaliacao_final_radio13_3").toggle(false);
									avaliacao[12] = 1;
									avaliacaoNota[12] = 5;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio13_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									avaliacao[12] = 0;
									avaliacaoNota[12] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio13_2").setIcon('/simpacweb/images/ico/16/avaliacao_5.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio13_2").pressed)
										xt("avaliacao_final_radio13_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
								}
							}

						},{
							style:"margin-top:10",
							xtype:"button",
							tooltip:"<b>Ruim</b>",
							icon:'/simpacweb/images/ico/16/avaliacao_0_cinza.png',
							id:"avaliacao_final_radio13_3",
							inputValue:0,
							enableToggle:true,
							handler:function(){
								if(this.pressed){
									xt("avaliacao_final_radio13_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
									xt("avaliacao_final_radio13_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
									xt("avaliacao_final_radio13_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
									xt("avaliacao_final_radio13_1").toggle(false);
									xt("avaliacao_final_radio13_2").toggle(false);
									avaliacao[12] = 1;
									avaliacaoNota[12] = 0;
									xt('btnproximo').enable();
								}else{
									xt("avaliacao_final_radio13_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
									avaliacao[12] = 0;
									avaliacaoNota[12] = 0;
									xt('btnproximo').disable();
								}
							},
							listeners:{
								'mouseover':function(){
									xt("avaliacao_final_radio13_3").setIcon('/simpacweb/images/ico/16/avaliacao_0.png');
								},
								'mouseout':function(){
									if(!xt("avaliacao_final_radio13_3").pressed)
										xt("avaliacao_final_radio13_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
								}
							}

						}]
					}]
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				}]
			}],
			buttons:[{
				text:"Salvar",
				id:'btnsalvar',
				iconCls:"ico_save",
				disabled:true,
				handler:function(){
					var total = 0;
					var info = new Array();
					var idquestao = new Array();
					var texto;
					for(i=0;i<avaliacao.length;i++){
						total += avaliacao[i];
						idquestao.push(xt("avaliacao_final_idquestao"+(i+1)).getValue());
						texto = xt("avaliacao_final_information"+(i+1)).getValue().replace(",","&"); 
						info.push(texto);
					}
					if(total == 13){
						Ext.Ajax.request({
							url:"/simpacweb/modulos/treinamentos/ajax/TM_salvAvaliacaoFinal.php",
							params:{
								idquestao: idquestao.toString(),
								msn: info.toString(),
								idcursgoagendado: idcursoagendado,
								idaluno: xt("avaliacao_final_combo").getValue(),
								nota: avaliacaoNota.toString()
							}
						});
						alunosStore.removeAt(index);
						xt("avaliacao_final_combo").reset();
						
					}else{
						Ext.Msg.alert("Aviso","Você não informou a nota atribuída pelo aluno.<br /> Favor verificar");
					}
				}
			}/*,{
				text:"Anterior",
				iconCls:"ico_back",
				handler:function(){
					xt("compositefields"+count).setVisible(false);
					if(count > 1){	
						count--;
						xt('fsquestoes').setTitle("Questão "+(count));	
					}else{ 
						count = 13;
						xt('fsquestoes').setTitle("Questão "+(count));
					}
					xt("compositefields"+count).setVisible(true);
				}
			}*/,{
				text:"Próximo",
				id:'btnproximo',
				iconCls:"ico_forward",
				disabled:true,				
				handler:function(){
					xt("compositefields"+count).setVisible(false);
					if(count < 13){
						count++;
						xt('fsquestoes').setTitle("Questão "+(count));
					}else{
						count = 1;
						xt('fsquestoes').setTitle("Questão "+(count));	
						xt('btnsalvar').enable();
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////						
						Ext.MessageBox.show({
						   // title: 'Deseja Salvar?',
						    msg: 'Deseja Salvar?',
						    width:300,
						    buttons: Ext.MessageBox.YESNOCANCEL,
							icon:Ext.MessageBox.QUESTION,
						    fn:function(btn){ 
					            if(btn == 'yes'){
									var total = 0;
									var info = new Array();
									var idquestao = new Array();
									var texto;
									for(i=0;i<avaliacao.length;i++){
										total += avaliacao[i];
										idquestao.push(xt("avaliacao_final_idquestao"+(i+1)).getValue());
										texto = xt("avaliacao_final_information"+(i+1)).getValue().replace(",","&"); 
										info.push(texto);
									}
									if(total == 13){
										Ext.Ajax.request({
											url:"/simpacweb/modulos/treinamentos/ajax/TM_salvAvaliacaoFinal.php",
											params:{
												idquestao: idquestao.toString(),
												msn: info.toString(),
												idcursgoagendado: idcursoagendado,
												idaluno: xt("avaliacao_final_combo").getValue(),
												nota: avaliacaoNota.toString()
											}
										});
										alunosStore.removeAt(index);
										xt("avaliacao_final_combo").reset();
										
									}else{
										Ext.Msg.alert("Aviso","Você não informou a nota atribuída pelo aluno.<br /> Favor verificar");
									}
					            }else if(btn == 'no'){
									for(i = 1;i <= avaliacao.length;i++){
										xt("avaliacao_final_radio"+i+"_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
										if(xt("avaliacao_final_radio"+i+"_1").pressed){
											xt("avaliacao_final_radio"+i+"_1").toggle();
										}										
										xt("avaliacao_final_radio"+i+"_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
										if(xt("avaliacao_final_radio"+i+"_2").pressed){
											xt("avaliacao_final_radio"+i+"_2").toggle();
										}
										xt("avaliacao_final_radio"+i+"_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
										if(xt("avaliacao_final_radio"+i+"_3").pressed){
											xt("avaliacao_final_radio"+i+"_3").toggle();
										}
									}
								}else{
									for(i = 1;i <= avaliacao.length;i++){
										xt("avaliacao_final_radio"+i+"_1").setIcon('/simpacweb/images/ico/16/avaliacao_10_cinza.png');
										if(xt("avaliacao_final_radio"+i+"_1").pressed){
											xt("avaliacao_final_radio"+i+"_1").toggle();
										}										
										xt("avaliacao_final_radio"+i+"_2").setIcon('/simpacweb/images/ico/16/avaliacao_5_cinza.png');
										if(xt("avaliacao_final_radio"+i+"_2").pressed){
											xt("avaliacao_final_radio"+i+"_2").toggle();
										}
										xt("avaliacao_final_radio"+i+"_3").setIcon('/simpacweb/images/ico/16/avaliacao_0_cinza.png');
										if(xt("avaliacao_final_radio"+i+"_3").pressed){
											xt("avaliacao_final_radio"+i+"_3").toggle();
										}
									}
								}
					    	}
						});
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////						
					}
					xt("compositefields"+count).setVisible(true);	
					this.disable();
				}
			},{
				text:"Fechar",
				iconCls:"ico_exit",
				handler:function(){
					xt("TM_avaliacao_final").close();
				}
			}]
		}],
		listeners:{
			'afterrender':function(){
				xt("avaliacao_final_form").getForm().load({
					url:"/simpacweb/modulos/treinamentos/ajax/TM_avaliacaoFinal.php",
					params:{
						idcursoagendado: idcursoagendado
					},
					success:function(a,b,c){
						eval("var data = "+b.response.responseText);
						alunosStore.loadData(data);
					}
				});
			}
		}
	}).show();
}
</script>