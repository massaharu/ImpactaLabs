	/* @AUTOR: massa*/
var idcursoagendado = SimpacWeb.vars.rec.get("idcursoagendado");
var treinamento  = SimpacWeb.vars.rec.get("destreinamento");
var dtinicio 	 = SimpacWeb.vars.rec.get("dtinicio"); 				//Inicio do treinamento
var dttermino 	 = SimpacWeb.vars.rec.get("dttermino");				//Termino do treinamento
var hinicio		 = SimpacWeb.vars.rec.get("dtinicio");				//Horario Inicio
var htermino	 = SimpacWeb.vars.rec.get("dttermino");				//Horario Termino
var instrutor	 = SimpacWeb.vars.rec.get("desinstrutor");
var periodo		 = SimpacWeb.vars.rec.get("desperiodo");
var desala 		 = SimpacWeb.vars.rec.get("dessala");
var index;
var avaliacao1_status = false;
var avaliacao2_status = false;
var avaliacao3_status = false;
var avaliacao4_status = false;
var avaliacao5_status = false;
var avaliacao6_status = false;
var aval_nome_status = false;
var aval_email_status = false;
var aval_sala_status = false;
var aval_data_status = false;
var aval_dtincio_status = false;
var aval_dttermino_status = false;

var avaliacao1_value = 0;
var avaliacao2_value = 0;
var avaliacao3_value = 0;
var avaliacao4_value = 0
var avaliacao5_value = 0;
var avaliacao6_value = 0;
var countQuestions = 12;

var comentario1 = "";
var comentario2 = "";
var comentario3 = "";
var comentario4 = "";
var comentario5 = "";
var comentario6 = "";
var aval_nome = "";
var aval_email = "";
var aval_empresa = "";
var aval_sala = "";
var aval_data = "";
var aval_dtinicio = "";
var aval_dttermino = "";

if(xt("TM_avaliacao_final_locacoes"))
	xt("TM_avaliacao_final_locacoes").show();
else{
	var alunosStore = new Ext.data.JsonStore({
		root:"mydata",
		fields:['name','id'],
	});
	var alunosDadosStore = new Ext.data.JsonStore({
		root:"mydata",
		fields:['idaluno','nmaluno','nmempresa'],
	});
	var alunosDadosStore_email = new Ext.data.JsonStore({
		root:"data",
		fields:['email'],
	});	
	
	var formatTime = function(unixTimestamp) {
		var dt = new Date(unixTimestamp);
	
		var hours = dt.getHours();
		var minutes = dt.getMinutes();
		//var seconds = dt.getSeconds();
	
		if (hours < 10) 
		 hours = '0' + hours;
	
		if (minutes < 10) 
		 minutes = '0' + minutes;
	
		/*if (seconds < 10) 
		 seconds = '0' + seconds;*/
	
		return hours + ":" + minutes/* + ":" + seconds*/;
	}       
	
	function fn_avalNota(avl){
		var numberquestion = avl.charAt(avl.length-1);
		var nota = avl.split('_')[0].substr(4,2);
		switch(Number(numberquestion)){
			case 1: avaliacao1_value = nota; break;
			case 2: avaliacao2_value = nota; break;
			case 3: avaliacao3_value = nota; break;
			case 4: avaliacao4_value = nota; break;
			case 5: avaliacao5_value = nota; break;
			case 6: avaliacao6_value = nota; break;
		}
	}
	function fn_countValidQuestions(avaliacao_status){
		if(avaliacao_status == false){
			countQuestions -= 1;
			Ext.getCmp('countquestions').setText("<b>Faltam <span style='color:red;font-weight:bold;'>"+countQuestions+"</span> item(s) a serem preenchidos e/ou avaliados</b>");
		}
	}
	function fn_showValidStatus(){
		if(countQuestions == 0){	
			console.log(countQuestions);
			Ext.getCmp('countquestions').setText("<b>Dados prontos para serem salvos... </b>");
		}else{
			console.log(countQuestions);
			Ext.getCmp('countquestions').setText("<b>Faltam <span style='color:red;font-weight:bold;'>"+countQuestions+"</span> item(s) a serem preenchidos e/ou avaliados</b>");	
		}
	}
	
	function fn_hover_image(avl10, avl5, avl0){
		$(avl10).attr('title','Ótimo');
		$(avl5).attr('title','Bom');
		$(avl0).attr('title','Ruim');
		
		$(avl10).hover(
			function(){
				$(avl10).addClass('animated tada');
			},
			function(){
				$(avl10).removeClass('animated tada');
			}
		);
		$(avl5).hover(
			function(){
				$(avl5).addClass('animated tada');
			},
			function(){
				$(avl5).removeClass('animated tada');
			}
		);
		$(avl0).hover(
			function(){
				$(avl0).addClass('animated tada');
			},
			function(){
				$(avl0).removeClass('animated tada');
			}
		);
	}
	function fn_click_image(selectorClass, avl10, avl5, avl0, txtarea){	
		$(selectorClass).stop().animate({"opacity": "0.5"}, "slow");
		
		$(avl10).click(function(){									
			$(avl10).stop().animate({"opacity": "1.0"}, "slow");
			$(avl5).stop().animate({"opacity": "0.4"}, "slow");
			$(avl0).stop().animate({"opacity": "0.4"}, "slow");
			$(txtarea).css({
				"border-color":"rgb(33, 100, 33)",
				"box-shadow" : "inset 0px 0px 7px rgba(33, 100, 33, .475)"
			});
			
			fn_avalNota(avl10);
			
		});
		$(avl5).click(function(){									
			$(avl5).stop().animate({"opacity": "1.0"}, "slow");
			$(avl10).stop().animate({"opacity": "0.4"}, "slow");
			$(avl0).stop().animate({"opacity": "0.4"}, "slow");
			$(txtarea).css({"border-color":"rgb(221, 221, 81)"});
			$(txtarea).css({
				"border-color":"rgb(221, 221, 81)",
				"box-shadow" : "inset 0px 0px 7px rgba(221, 221, 81, .475)"
			});
			
			fn_avalNota(avl5);
			
		});
		$(avl0).click(function(){									
			$(avl0).stop().animate({"opacity": "1.0"}, "slow");
			$(avl10).stop().animate({"opacity": "0.4"}, "slow");
			$(avl5).stop().animate({"opacity": "0.4"}, "slow");
			$(txtarea).css({"border-color":"rgb(207, 5, 5)"});
			$(txtarea).css({
				"border-color":"rgb(207, 5, 5)",
				"box-shadow" : "inset 0px 0px 7px rgba(207, 5, 5, .475)"
			});
			
			fn_avalNota(avl0);
			
		});
		
		$(avl10+","+avl5+","+avl0).click(function(){
		//	console.log("'"+avl10+","+avl5+","+avl10+"'");	
			if((avl10.charAt(avl10.length-1) == 1) || (avl5.charAt(avl5.length-1) == 1) || (avl0.charAt(avl0.length-1) == 1)){				
				fn_countValidQuestions(avaliacao1_status);
				avaliacao1_status = true;	
			}else if((avl10.charAt(avl10.length-1) == 2) || (avl5.charAt(avl5.length-1) == 2) || (avl0.charAt(avl0.length-1) == 2)){
				fn_countValidQuestions(avaliacao2_status);
				avaliacao2_status = true;
			}else if((avl10.charAt(avl10.length-1) == 3) || (avl5.charAt(avl5.length-1) == 3) || (avl0.charAt(avl0.length-1) == 3)){
				fn_countValidQuestions(avaliacao3_status);
				avaliacao3_status = true;
			}else if((avl10.charAt(avl10.length-1) == 4) || (avl5.charAt(avl5.length-1) == 4) || (avl0.charAt(avl0.length-1) == 4)){
				fn_countValidQuestions(avaliacao4_status);
				avaliacao4_status = true;	
			}else if((avl10.charAt(avl10.length-1) == 5) || (avl5.charAt(avl5.length-1) == 5) || (avl0.charAt(avl0.length-1) == 5)){
				fn_countValidQuestions(avaliacao5_status);
				avaliacao5_status = true;
			}else if((avl10.charAt(avl10.length-1) == 6) || (avl5.charAt(avl5.length-1) == 6) || (avl0.charAt(avl0.length-1) == 6)){
				fn_countValidQuestions(avaliacao6_status);
				avaliacao6_status = true;
			}				
			
			fn_valida();
		});	
	}
	
	function fn_valida(){
		
		aval_nome = $('#TM_window_avaliacao_final_locacoes_nome').val();
		aval_email = $('#TM_window_avaliacao_final_locacoes_email').val();
		aval_empresa = $('#TM_window_avaliacao_final_locacoes_empresa').val();
		aval_sala = $('#TM_window_avaliacao_final_locacoes_sala').val();
		aval_data = $('#TM_window_avaliacao_final_locacoes_data').val();
		aval_dtinicio = $('#TM_window_avaliacao_final_locacoes_data_inicio').val();
		aval_dttermino = $('#TM_window_avaliacao_final_locacoes_data_termino').val();
		
		//nome	
		if(aval_nome_status == false){
			if((aval_nome.trim() != "")  && (aval_nome != null) && (aval_nome != "Escolha um aluno...")){
				countQuestions -= 1;
				aval_nome_status = true;
				fn_showValidStatus();
			}
		}else{
			if((aval_nome.trim() == "") || (aval_nome == null) || (aval_nome == "Escolha um aluno...")){
				countQuestions += 1;
				aval_nome_status = false;
				fn_showValidStatus();
			}
		}
		
		//email
		if(aval_email_status == false){
			if((aval_email.trim() != "")  && (aval_email != null)){
				countQuestions -= 1;
				aval_email_status = true;
				fn_showValidStatus();
			}
		}else{
			if((aval_email.trim() == "") || (aval_email == null)){
				//console.log(aval_email.length);
				countQuestions += 1;
				aval_email_status = false;
				fn_showValidStatus();
			}
		}
		
		//sala
		if(aval_sala_status == false){
			if((aval_sala.trim() != '')  && (aval_sala != null)){
				countQuestions -= 1;
				aval_sala_status = true;
				fn_showValidStatus();
			}
		}else{
			if((aval_sala.trim() == '') || (aval_sala == null)){
				countQuestions += 1;
				aval_sala_status = false;
				fn_showValidStatus();
			}
		}
		
		//data
		if(aval_data_status == false){
			if((aval_data.trim() != '')  && (aval_data != null)){
				countQuestions -= 1;
				aval_data_status = true;
				fn_showValidStatus();
			}
		}else{
			if((aval_data.trim() == '') || (aval_data == null)){
				countQuestions += 1;
				aval_data_status = false;
				fn_showValidStatus();
			}
		}
		
		//datainicio
		if(aval_dtincio_status == false){
			if((aval_dtinicio.trim() != '')  && (aval_dtinicio != null)){
				countQuestions -= 1;
				aval_dtincio_status = true;
				fn_showValidStatus();
			}
		}else{
			if((aval_dtinicio.trim() == '') || (aval_dtinicio == null)){
				countQuestions += 1;
				aval_dtincio_status = false;
				fn_showValidStatus();
			}
		}
		
		//datatermino
		if(aval_dttermino_status == false){
			if((aval_dttermino.trim() != '')  && (aval_dttermino != null)){
				countQuestions -= 1;
				aval_dttermino_status = true;
				fn_showValidStatus();
			}
		}else{
			if((aval_dttermino.trim() == '') || (aval_dttermino == null)){
				countQuestions += 1;
				aval_dttermino_status = false;
				fn_showValidStatus();
			}
		}
		
		fn_showValidStatus();
		
		if(avaliacao1_status == true && avaliacao2_status == true && 
		   avaliacao3_status == true && avaliacao4_status == true && 
		   avaliacao5_status == true && avaliacao6_status == true &&
		   (aval_nome != 'Escolha um aluno...' && aval_nome.trim() != '' && aval_nome != null) &&
		   (aval_email.trim() != '' && aval_email != null) &&
		   (aval_sala.trim() != '' && aval_sala != null) &&
		   (aval_data.trim() != '' && aval_data != null) &&
		   (aval_dtinicio.trim() != '' && aval_dtinicio != null) &&
		   (aval_dttermino.trim() != '' && aval_dttermino != null)
		   ){
			Ext.getCmp('save_form').enable();
		}else{
			Ext.getCmp('save_form').disable();
		}
	}
	
	function fn_enviaDados(){
		
		comentario1 = $('#TM_window_avaliacao_final_locacoes_txtarea1').val();
		comentario2 = $('#TM_window_avaliacao_final_locacoes_txtarea2').val();
		comentario3 = $('#TM_window_avaliacao_final_locacoes_txtarea3').val();
		comentario4 = $('#TM_window_avaliacao_final_locacoes_txtarea4').val();
		comentario5 = $('#TM_window_avaliacao_final_locacoes_txtarea5').val();
		comentario6 = $('#TM_window_avaliacao_final_locacoes_txtarea6').val();
		coffeeoptions = $('input[name=radiocoffee]:checked', '#avaliacao_final_form').val();
		
		/*var dados = 
		'Nome: '+aval_nome+'<br />'+
		'Email: '+aval_email+'<br />'+
		'Empresa: '+aval_empresa+'<br />'+
		'Sala: '+aval_sala+'<br />'+
		'Data: '+aval_data+'<br />'+
		'Data de Início: '+aval_dtinicio+'<br />'+
		'Data de Termino: '+aval_dttermino+'<br />'+
		'Opções Cafe: '+coffeeoptions+'<br />'+
		'Comentário 1: '+comentario1+' - '+avaliacao1_value+'<br />'+
		'Comentário 2: '+comentario2+' - '+avaliacao2_value+'<br />'+
		'Comentário 3: '+comentario3+' - '+avaliacao3_value+'<br />'+
		'Comentário 4: '+comentario4+' - '+avaliacao4_value+'<br />'+
		'Comentário 5: '+comentario5+' - '+avaliacao5_value+'<br />'+
		'Comentário 6: '+comentario6+' - '+avaliacao6_value;*/
		
		/*Ext.MessageBox.alert('',dados,
			function(btn){
				if(btn == 'ok'){
				setTimeout(function(){
					fn_resetaForm();
				},700);
			}
		});*/
		
		$.ajax({
			url:"/simpacweb/modulos/treinamentos/ajax/TM_salvAvaliacaoFinal_locacoes.php",
			type:"POST",
			dataType:"json",
			data:{
				idalunoagendado:alunosDadosStore.getAt(0).get('idaluno'),
				idcursoagendado:idcursoagendado,
				coffee_options:coffeeoptions,
				coment1:'['+coffeeoptions+']'+': '+comentario1,
				idquestao1:Ext.getCmp('avaliacao_final_locacoes_idquestao1').getValue(),
				ava1_value:avaliacao1_value,
				coment2:comentario2,
				idquestao2:Ext.getCmp('avaliacao_final_locacoes_idquestao2').getValue(),
				ava2_value:avaliacao2_value,
				coment3:comentario3,
				idquestao3:Ext.getCmp('avaliacao_final_locacoes_idquestao3').getValue(),
				ava3_value:avaliacao3_value,
				coment4:comentario4,
				idquestao4:Ext.getCmp('avaliacao_final_locacoes_idquestao4').getValue(),
				ava4_value:avaliacao4_value,
				coment5:comentario5,
				idquestao5:Ext.getCmp('avaliacao_final_locacoes_idquestao5').getValue(),
				ava5_value:avaliacao5_value,
				coment6:comentario6,
				idquestao6:Ext.getCmp('avaliacao_final_locacoes_idquestao6').getValue(),
				ava6_value:avaliacao6_value
			},
			success:function(){
				Ext.MessageBox.info('Salvo!','Dados salvos com sucesso...',function(btn){
					if(btn == 'ok'){
						
						fn_resetaForm();
					}
				});
				
				
			}
		});
	}
	
	function fn_resetaForm(){
		Ext.MessageBox.show({
			title:'Cancelado...',
			msg:'Deseja limpar o formulário?',
			buttons: Ext.MessageBox.OKCANCEL,
			icon:Ext.MessageBox.QUESTION,
			fn:function(btn){
				if(btn == 'ok'){
					
					avaliacao1_status = false;
					avaliacao2_status = false;
					avaliacao3_status = false;
					avaliacao4_status = false;
					avaliacao5_status = false;
					avaliacao6_status = false;
					aval_nome_status = false;
					aval_email_status = false;
					aval_sala_status = false;
					aval_data_status = false;
					aval_dtincio_status = false;
					aval_dttermino_status = false;
					avaliacao1_value = 0;
					avaliacao2_value = 0;
					avaliacao3_value = 0;
					avaliacao4_value = 0
					avaliacao5_value = 0;
					avaliacao6_value = 0;
					countQuestions = 12;	
					var arrQuestions = [1,2,3,4,5,6];
					
					$('#TM_window_avaliacao_final_locacoes_nome').val('');
					$('#TM_window_avaliacao_final_locacoes_email').val('');
					$('#TM_window_avaliacao_final_locacoes_empresa').val('');
					$('#TM_window_avaliacao_final_locacoes_radio-bistro').attr("checked",true);
					
					jQuery.each(arrQuestions,function(){						  
						$("#avl10_"+this).stop().animate({"opacity": "0.5"}, "slow");
						$("#avl5_"+this).stop().animate({"opacity": "0.5"}, "slow");
						$("#avl0_"+this).stop().animate({"opacity": "0.5"}, "slow");
						$("#TM_window_avaliacao_final_locacoes_txtarea"+this).val('');
						$("#TM_window_avaliacao_final_locacoes_txtarea"+this).css({
							"border-color":"#B5B8C8",
							"box-shadow":"0px 0px 0px #FFFFFF"
						})
					});
					
					fn_valida();
					
				}
			}
		});
	}
	
	
	new Ext.Window({
		id:"TM_avaliacao_final_locacoes",
		title:"Avaliação Final das Locações. Curso: " + treinamento+" - Das "+formatTime(hinicio)+" às "+formatTime(htermino)+" - Instrutor: "+instrutor,
		width:670,
		height:600,
		resizable:true,
		border:false, 
		modal:true,
		autoScroll:true,
		bbar:['->',{
			text:'',
			id:'countquestions'
		},'-',{
			text:'Salvar',
			id:'save_form',
			disabled:true,
			iconCls:'ico_save',
			listeners:{
				'click':function(){
					Ext.MessageBox.show({
						title:'Salvar...',
						msg:'Deseja salvar este formulário?',
						buttons: Ext.MessageBox.OKCANCEL,
						icon:Ext.MessageBox.QUESTION,
						fn:function(btn){
							if(btn=='ok'){
								fn_enviaDados();
							}else{
								fn_resetaForm();
							}
						}
					});
				}
			}
		}],
		items:[{
			xtype:"form",
			id:"avaliacao_final_form",
			border:false,
			labelWidth:50,
			padding:10,	
			width:645,
			items:[{
////////////////////////////////////FORMULARIO////////////////////////////////////////////////////////////////////////////////				   
				xtype:'fieldset',
				collapsible:false,
				title:'Formulário',				
				iconCls:'ico_curso',
				items:[{
					xtype:'compositefield',
					items:[{
						xtype:"combo",
						store:alunosStore,
						fieldLabel:'Nome',
						displayField:"name",
						valueField:"id",
						editable:false,
						triggerAction:"all",
						mode:"local",
						id:"TM_window_avaliacao_final_locacoes_nome",
						width:200,
						enableKeyEvents:true,
						emptyText:'Escolha um aluno...',
						listeners:{
							'select':function( combo, record, c ){
								index = c;
								Ext.Ajax.request({
									url:'/simpacweb/modulos/treinamentos/ajax/TM_avaliacaoFinal_locacoes-get_dadosaluno.php',
									params:{
										idaluno:record.id,
										idcursoagendado:idcursoagendado
									},
									success:function(combo,record,index){
										eval("var data = "+combo.responseText+";");
										alunosDadosStore.loadData(data);
										//alunosDadosStore_email.loadData(data);
										Ext.getCmp('TM_window_avaliacao_final_locacoes_empresa').setValue(alunosDadosStore.getAt(0).get('nmempresa'));
										Ext.getCmp('TM_window_avaliacao_final_locacoes_email').setValue(data.data.email);
									}
								});
								setTimeout(function(){
									console.log('select');
									fn_valida();
								},300);
								
							},
							keyup:function(){
								fn_valida();
							},
							change:function(){
								console.log('change');
								fn_valida();
							}
						}						   
					},{
						xtype:"displayfield",
						style:"margin-left:4",
						value:"Email: "
					},{
						xtype:'textfield',
						id:'TM_window_avaliacao_final_locacoes_email',
						style:"margin-left:2",
						enableKeyEvents:true,
						readOnly:true,
						width:269,
						listeners:{
							keyup:function(){
								fn_valida();
							}
						}
					}]
				},{
					xtype:'compositefield',
					items:[{
						xtype:'textfield',
						fieldLabel:'Empresa',
						enableKeyEvents:true,
						readOnly:true,
						width:200,
						id:'TM_window_avaliacao_final_locacoes_empresa',
						listeners:{
							keyup:function(){
								fn_valida();
							}
						}
					},{
						xtype:'displayfield',
						style:"margin-left:10",
						width:45,
						value:'Sala:'
					},{						
						xtype:"textfield",
						style:"margin-left:-8",
						enableKeyEvents:true,
						readOnly:true,
						id:"TM_window_avaliacao_final_locacoes_sala",
						value:desala,	
						listeners:{
							keyup:function(){
								fn_valida();
							}
						}
					},{
						style:"margin-left:-4",
						xtype:"displayfield",
						value:"Data: "
					},{
						style:"margin-left:-4",
						xtype:"datefield",
						enableKeyEvents:true,
						id:"TM_window_avaliacao_final_locacoes_data",
						width:100,
						value:new Date(),//dtinicio,
						readOnly:true,
						listeners:{
							'select':function(a){
								alunos.load({
									params:{
										idcursoagendado:idcursoagendado,
										dtinicio:a.getValue().format("Y-m-d")
									}
								});
								
								fn_valida();
							},
							keyup:function(){
								fn_valida();
							}
						}
					}]
				},{
					xtype:'compositefield',
					items:[{
						xtype:"datefield",
						fieldLabel:'Data de Início',	
						enableKeyEvents:true,
						id:"TM_window_avaliacao_final_locacoes_data_inicio",
						//width:100,
						value:hinicio,//dtinicio,
						readOnly:true,
						listeners:{
							'select':function(a){
								alunos.load({
									params:{
										idcursoagendado:idcursoagendado,
										dtinicio:a.getValue().format("Y-m-d")
									}
								});
								
								fn_valida();
							},
							keyup:function(){
								fn_valida();
							}
						}
					},{
						style:"margin-left:42",
						xtype:"displayfield",
						value:"Data de Término: "
					},{
						style:"margin-left:41",
						xtype:"datefield",
						enableKeyEvents:true,
						id:"TM_window_avaliacao_final_locacoes_data_termino",
						width:100,
						value:dttermino,//dtinicio,
						readOnly:true,
						listeners:{
							'select':function(a){
								alunos.load({
									params:{
										idcursoagendado:idcursoagendado,
										dtinicio:a.getValue().format("Y-m-d")
									}
								});
								
								fn_valida();
							},
							keyup:function(){
								fn_valida();
							}
						}
					},{
						style:"margin-left:50",
						xtype:"displayfield",
						value:"Período: "
					},{
						style:"margin-left:54",
						xtype:"textfield",
						enableKeyEvents:true,
						id:"TM_window_avaliacao_final_locacoes_periodo",
						width:100,
						value:periodo,
						readOnly:true,
						listeners:{
							keyup:function(){
								fn_valida();
							}
						}
					}]
				}]
////////////////////////////////////Foi utilizado serviço café?////////////////////////////////////////////////////////////////////////////////						
			},{
				xtype:'fieldset',
				id:'TM_window_avaliacao_final_locacoes_cafe',
				title:'default',
				collapsible:true,
				iconCls:'ico_coffee',
				items:[{
					xtype:"displayfield",
					height:50,
					id:"avaliacao_final_locacoes_idquestao1",
					hidden:true,
				},{
					xtype:'compositefield',	
					style:'padding-left:10px;',
					items:[{
						xtype:'radio',
						id:'TM_window_avaliacao_final_locacoes_radio-bistro',
						boxLabel:'Bistrô ',
						style:'margin:0px 0px 0px 3px',
						checked:true,
						inputValue:'Bistro',
						name:'radiocoffee',						
					},{				
						xtype:'radio',
						id:'TM_window_avaliacao_final_locacoes_radio-coffeebreak',
						boxLabel:'Coffee Break ',
						style:'margin:0px 0px 0px 3px',
						checked:false,
						inputValue:'CoffeeBreak',
						name:'radiocoffee',	
					}]					
				},{
					xtype:'compositefield',
					style:'margin-left:13px;',
					items:[{
						xtype:'textarea',
						id:'TM_window_avaliacao_final_locacoes_txtarea1',
						fieldLabel:'Comente',
						width:300,
						
					},{
						html:
							 "<a href='#'><img id='avl10_1' class='transit' src='/simpacweb/images/ico/72/avaliacao_10.png' style='width:52px;heigth:52px;margin-right:10px;'/></a>"+
							 "<a href='#'><img id='avl5_1' class='transit' src='/simpacweb/images/ico/72/avaliacao_5.png' style='width:52px;heigth:52px;margin-right:10px;'/></a>"+
							 "<a href='#'><img id='avl0_1' class='transit' src='/simpacweb/images/ico/72/avaliacao_0.png' style='width:52px;heigth:52px;margin-right:10px;'/></a>",
						border:false,
						style:'margin-left:15px;',
						listeners: {
							afterrender: function() {
								fn_click_image('img.transit', '#avl10_1', '#avl5_1', '#avl0_1','#TM_window_avaliacao_final_locacoes_txtarea1');
								fn_hover_image('#avl10_1', '#avl5_1', '#avl0_1');
							}
						}
					}]
				}]
////////////////////////////////////1. Avalie o atendimento recebido pela equipe da Impacta/////////////////////////////////////////////////////////////////			
			},{				
				xtype:'fieldset',
				collapsible:true,
				id:'TM_window_avaliacao_final_locacoes1',
				title:'default',
				iconCls:'ico_user_red',
				items:[{
					xtype:"displayfield",
					height:50,
					id:"avaliacao_final_locacoes_idquestao2",
					hidden:true,
				},{
					xtype:'displayfield',
					id:'TM_window_avaliacao_final_locacoes1.1',
					hideLabel:true,
					style:'font-weight:bold;color:#AAA;margin-top:-5px;margin-bottom:20px;',
					//value:'[recepção, equipe técnica, administração]'
				},{
					xtype:'compositefield',
					style:'margin-left:13px;',
					items:[{
						xtype:'textarea',
						id:'TM_window_avaliacao_final_locacoes_txtarea2',
						fieldLabel:'Comente',
						width:300,						
					},{
						html: 
							 "<a href='#'><img id='avl10_2' class='transit' src='/simpacweb/images/ico/72/avaliacao_10.png' style='width:52px;heigth:52px;margin-right:10px;'/></a>"+
							 "<a href='#'><img id='avl5_2' class='transit' src='/simpacweb/images/ico/72/avaliacao_5.png' style='width:52px;heigth:52px;margin-right:10px;'/></a>"+
							 "<a href='#'><img id='avl0_2' class='transit' src='/simpacweb/images/ico/72/avaliacao_0.png' style='width:52px;heigth:52px;margin-right:10px;'/></a>",
						border:false,
						style:'margin-left:15px;',
						listeners: {
							afterrender: function() {
								fn_click_image('img.transit', '#avl10_2', '#avl5_2', '#avl0_2','#TM_window_avaliacao_final_locacoes_txtarea2');	
								fn_hover_image('#avl10_2', '#avl5_2', '#avl0_2');
							}
						}
					}]
				}]			
			},{
////////////////////////////////////2. Avalie a Infraestrutura do serviço utilizado////////////////////////////////////////////////////////////////									
				xtype:'fieldset',
				id:'TM_window_avaliacao_final_locacoes2',
				collapsible:true,
				title:'default',
				iconCls:'ico_companys_128',
			/////////////////////////	2.1 Iluminação, móveis, ar-condicionado, banheiro, e outros ////////////////////////////////////////////////
				items:[{
					xtype:"displayfield",
					height:50,
					id:"avaliacao_final_locacoes_idquestao3",
					hidden:true,
				},{
					xtype:'displayfield',
					id:'TM_window_avaliacao_final_locacoes2.1',
					hideLabel:true,
					style:'font-weight:bold;margin-top:-5px;margin-bottom:20px;color:#15428B',
					value:'2.1 Iluminação, móveis, ar-condicionado, banheiro, e outros',
				},{
					xtype:'compositefield',
					style:'margin-left:13px;',
					items:[{
						xtype:'textarea',
						id:'TM_window_avaliacao_final_locacoes_txtarea3',
						fieldLabel:'Comente',
						width:300,						
					},{
						html:
							 "<a href='#'><img id='avl10_3' class='transit' src='/simpacweb/images/ico/72/avaliacao_10.png' style='width:52px;heigth:52px;margin-right:10px;'/></a>"+
							 "<a href='#'><img id='avl5_3' class='transit' src='/simpacweb/images/ico/72/avaliacao_5.png' style='width:52px;heigth:52px;margin-right:10px;'/></a>"+
							 "<a href='#'><img id='avl0_3' class='transit' src='/simpacweb/images/ico/72/avaliacao_0.png' style='width:52px;heigth:52px;margin-right:10px;'/></a>",
						border:false,
						style:'margin-left:15px;',
						listeners: {
							afterrender: function() {
								fn_click_image('img.transit', '#avl10_3', '#avl5_3', '#avl0_3','#TM_window_avaliacao_final_locacoes_txtarea3');
								fn_hover_image('#avl10_3', '#avl5_3', '#avl0_3');
							}
						}
					}]
		///////////////////////// 2.2 Avalie os recursos técnicos da sala de aula [TV ou projetor, rede, internet, e micro computadores]/////////////
			////////////////////////Estão de acordo com os objetivos contratados?			
				},{
					xtype:"displayfield",
					height:50,
					id:"avaliacao_final_locacoes_idquestao4",
					hidden:true,
				},{		
					xtype:'displayfield',
					id:'TM_window_avaliacao_final_locacoes2.2',
					hideLabel:true,
					style:'font-weight:bold;margin-top:25px;margin-bottom:20px;color:#15428B',
					value:'2.2 Avalie os recursos técnicos da sala de aula [TV ou projetor, rede, internet, e micro computadores]. Estão de acordo com os objetivos contratados?',
				},{
					xtype:'compositefield',
					style:'margin-left:13px;',
					items:[{
						xtype:'textarea',
						id:'TM_window_avaliacao_final_locacoes_txtarea4',
						fieldLabel:'Comente',
						width:300,						
					},{
						html:
							 "<a href='#'><img id='avl10_4' class='transit' src='/simpacweb/images/ico/72/avaliacao_10.png' style='width:52px;heigth:52px;margin-right:10px;'/></a>"+
							 "<a href='#'><img id='avl5_4' class='transit' src='/simpacweb/images/ico/72/avaliacao_5.png' style='width:52px;heigth:52px;margin-right:10px;'/></a>"+
							 "<a href='#'><img id='avl0_4' class='transit' src='/simpacweb/images/ico/72/avaliacao_0.png' style='width:52px;heigth:52px;margin-right:10px;'/></a>",
						border:false,
						style:'margin-left:15px;',
						listeners: {
							afterrender: function() {
								fn_click_image('img.transit', '#avl10_4', '#avl5_4', '#avl0_4','#TM_window_avaliacao_final_locacoes_txtarea4');
								fn_hover_image('#avl10_4', '#avl5_4', '#avl0_4');
							}
						}
					}]
				}]
			},{	
		////////////////////////////////3. Avalie a Localização//////////////////////////////////////////////////////////////////////////////////////////////	
				xtype:'fieldset',
				collapsible:true,
				id:'TM_window_avaliacao_final_locacoes3',
				title:'default',
				iconCls:'ico_location_256',
				items:[{
					xtype:"displayfield",
					height:50,
					id:"avaliacao_final_locacoes_idquestao5",
					hidden:true,
				},{
					xtype:'compositefield',
					style:'margin-left:13px;',
					items:[{
						xtype:'textarea',
						id:'TM_window_avaliacao_final_locacoes_txtarea5',
						fieldLabel:'Comente',
						width:300,						
					},{
						html:
							 "<a href='#'><img id='avl10_5' class='transit' src='/simpacweb/images/ico/72/avaliacao_10.png' style='width:52px;heigth:52px;margin-right:10px;'/></a>"+
							 "<a href='#'><img id='avl5_5' class='transit' src='/simpacweb/images/ico/72/avaliacao_5.png' style='width:52px;heigth:52px;margin-right:10px;'/></a>"+
							 "<a href='#'><img id='avl0_5' class='transit' src='/simpacweb/images/ico/72/avaliacao_0.png' style='width:52px;heigth:52px;margin-right:10px;'/></a>",
						border:false,
						style:'margin-left:15px;',
						listeners: {
							afterrender: function() {
								fn_click_image('img.transit', '#avl10_5', '#avl5_5', '#avl0_5','#TM_window_avaliacao_final_locacoes_txtarea5');
								fn_hover_image('#avl10_5', '#avl5_5', '#avl0_5');
							}
						}
					}]
				}]	
			},{
		////////////////////////////////4. A Impacta sempre inovando para melhor atender seus clientes.////////////////////////////////////
				xtype:'fieldset',
				collapsible:true,
				id:'TM_window_avaliacao_final_locacoes4',
				title:'default',
				iconCls:'ico_Message',
				items:[{
					xtype:"displayfield",
					height:50,
					id:"avaliacao_final_locacoes_idquestao6",
					hidden:true,
				},{
					xtype:'displayfield',	
					hideLabel:true,
					style:'font-weight:bold;margin-top:0px;margin-bottom:20px;color:#15428B',
					value:'Deixe suas Sugestões: '
				},{
					xtype:'compositefield',
					style:'margin-left:13px;',
					items:[{
						xtype:'textarea',
						id:'TM_window_avaliacao_final_locacoes_txtarea6',
						fieldLabel:'Comente',
						width:300,						
					},{
						html:
							 "<a href='#'><img id='avl10_6' class='transit' src='/simpacweb/images/ico/72/avaliacao_10.png' style='width:52px;heigth:52px;margin-right:10px;'/></a>"+
							 "<a href='#'><img id='avl5_6' class='transit' src='/simpacweb/images/ico/72/avaliacao_5.png' style='width:52px;heigth:52px;margin-right:10px;'/></a>"+
							 "<a href='#'><img id='avl0_6' class='transit' src='/simpacweb/images/ico/72/avaliacao_0.png' style='width:52px;heigth:52px;margin-right:10px;'/></a>",
						border:false,
						style:'margin-left:15px;',
						listeners: {
							afterrender: function() {
								fn_click_image('img.transit', '#avl10_6', '#avl5_6', '#avl0_6','#TM_window_avaliacao_final_locacoes_txtarea6');
								fn_hover_image('#avl10_6', '#avl5_6', '#avl0_6');
							}
						}
					}]
				}]	
			}]
		}],
		listeners:{
			'afterrender':function(){
				xt("avaliacao_final_form").getForm().load({
					url:"/simpacweb/modulos/treinamentos/ajax/TM_avaliacaoFinal_locacoes.php",
					params:{
						idcursoagendado:idcursoagendado
					},
					success:function(a,b,c){						
						eval("var data = "+b.response.responseText);
						alunosStore.loadData(data);
						Ext.getCmp('TM_window_avaliacao_final_locacoes_cafe').setTitle(data.data.avaliacao_final_locacoes_questao1);
						Ext.getCmp('TM_window_avaliacao_final_locacoes1').setTitle('1. '+data.data.avaliacao_final_locacoes_questao2.split(' - ')[0]);
						Ext.getCmp('TM_window_avaliacao_final_locacoes1.1').setValue(data.data.avaliacao_final_locacoes_questao2.split('-')[1]);
						Ext.getCmp('TM_window_avaliacao_final_locacoes2').setTitle('2. '+data.data.avaliacao_final_locacoes_questao3.split(' - ')[0]);
						Ext.getCmp('TM_window_avaliacao_final_locacoes2.1').setValue('2.1 '+data.data.avaliacao_final_locacoes_questao3.split(' - ')[1]);
						Ext.getCmp('TM_window_avaliacao_final_locacoes2.2').setValue('2.2 '+data.data.avaliacao_final_locacoes_questao4);
						Ext.getCmp('TM_window_avaliacao_final_locacoes3').setTitle('3. '+data.data.avaliacao_final_locacoes_questao5);
						Ext.getCmp('TM_window_avaliacao_final_locacoes4').setTitle('4. '+data.data.avaliacao_final_locacoes_questao6);
					}
				});
			}
		}
	}).show();
}