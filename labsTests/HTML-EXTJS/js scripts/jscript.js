// JavaScript Document
function displayDate(){
	document.getElementById("demo").innerHTML=Date();//Escreve a data na página HTML
	alert(Date());
}

function getYourName(){
	var name=prompt("Entre com o seu nome","");
	
	if(name!=null && name!=""){	
		document.formInt.yourName.value=name;
		alert(name);
		}
		else
			alert('Entre com um	nome valido');	
}

function cumprimentos(){
	var date = new Date();
	var time = date.getHours();
	var day = date.getDay();
	var compliment
	
	if(time<12)
		compliment = 'OHAYOU!, '		
		else
			if(time<18)
				compliment = 'KONNICHIWA!, '
					else
						compliment = 'KONBANWA!, '
	switch(day){
		case 0:alert(compliment + 'Kyou wa nichiyoubi desu...');break;
		case 1:alert(compliment + 'Kyou wa getsuyoubi desu...');break;
		case 2:alert(compliment + 'Kyou wa kayoubi desu...');break;
		case 3:alert(compliment + 'Kyou wa suiyoubi desu...');break;
		case 4:alert(compliment + 'Kyou wa mokuyoubi desu...');break;
		case 5:alert(compliment + 'Kyou wa kinyoubi desu...');break;
		default:
		alert('Kyou wa doyoubi desu...');
	}
}

function verifyPage2(){
		var r=confirm("Deseja entrar nesta página?");
		
		if (r==true){
			var s=confirm("Tem certeza disto?");
				if(s==true){
				var t=confirm("Mesmo?");
					if (t==true){
  					javascript:location.href='calc.html';										
						}	
					}
				}
			else{
  			alert("You made a right decision");
  				}
}

function enviar(){
    var nome = document.formInt.texto1.value;
    window.alert("Você digitou: " + nome);
} 

function calc(){
	var n1= document.formInt.num1.value;
	var n2= document.formInt.num2.value;
	var i, r;
	
	try{
		if(isNaN(n1)||isNaN(n2)){
			throw "err1";
			}
		if((n1=="")||(n1==null)||(n2=="")||(n2==null)){
			throw "err2";
			}
		}
	catch (err){
		if (err = "err1"){
			alert('Dados inseridos são inválidos.');
			}
		if (err = "err2"){
			alert('Insira os numeros corretamente');
			}
		}	
	for(i=0;i<document.formInt.operation.length;i++){
		if(document.formInt.operation[i].checked)
		break;
			if(i==3){ <!--Caso nenhuma operação seja selecionada, o array [i] irá para '3' logo nada fora selecionado-->
				alert('Selecione uma operação.')
			}
		}
		var a = document.formInt.operation[i].value;
		switch(a){ 
		case "mais": r = parseInt(n1)+parseInt(n2);
					document.formInt.resp.value = r;break;
		case "menos": r = n1-n2;
					document.formInt.resp.value = r;break;
		case "mul": r = n1*n2;
					document.formInt.resp.value = r;break;
		case "div": r = n1/n2;
					if(n2!=0){
						document.formInt.resp.value = r;break;
						}
							else{
								document.formInt.resp.value = 'NÃO EXISTE';
								alert('You started a black hole!');
							}
				
		}
}

function resetar(){
	document.formInt.resp.value="";
	document.formInt.num1.value="";
	document.formInt.num2.value="";
	for(var i = 0;i<document.formInt.operation.length;i++)
		if(document.formInt.operation[i].type=="radio")
		document.formInt.operation[i].checked=0;
}

function startTime(){
	var today=new Date();
	var h=today.getHours();
	var m=today.getMinutes();
	var s=today.getSeconds();
// Adicionar zero na frente caso 'm' ou 's' for menor que 10.
	m=checkTime(m);
	s=checkTime(s);
	h=checkTime(h);
	document.getElementById('time').innerHTML=h+":"+m+":"+s;
	t=setTimeout('startTime()',500);
}

function checkTime(i){
	if (i<10){
  		i="0" + i;
  		}
	return i;
}

//JQuery Document///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Simplificação ► $(document).ready = $
//--------------(fadeOut Function)---------------------|
fadeOut = function(id,time,mensagem){
		$(id).fadeOut(time,function(){
			(mensagem) ? alert(mensagem) : '';
	});
}
//---------------------------------------------------|
//--------------(Hello World!, Time)----------------------
$(function(){
	$("#helloworld, #time").click(function(){
		var mensagem = "Abaixo, clique em \"SHOW\" para ver conteúdo novamente.";
		fadeOut(this,2000,mensagem);
/*		$(this).fadeOut(2000,function(){
			alert("Abaixo, clique em \"Mostrar\" para ver conteúdo novamente.");
		});	*/
	});	
	$("#_9gagtext").click(function(){
		fadeOut("#_9gagtext,#imagem1",2000,'');
		//$("#_gagtext,#imagem1").fadeOut(2000);
	});	
});
//--------------(9GAG)--------------------------------------
/*$(document).ready(function(){
	$("#_9gagtext").click(function(){
		$("#_gagtext,#imagem1").fadeOut(2000);
		});
});*/
//-----------------slideToggle---------------------
//------------------- (LISTAS)---------------------------------------
$(document).ready(function(){
	$('.parent').click(function(){
		$(this).next('.fechavel:first').slideToggle("slow");
	});
//Todas as classes "parent" fecham as classes conseguintes "fechavel"
//---------------(INTERAÇÕES)-------------------
	$("#hidePage").click(function(){
		$("#allPage").toggle(2000);
	});
	
	$("#showPage").click(function(){
		$("#allPage,#helloworld").show(2000);
	});
});
//---------------(Validação)------------------------->
