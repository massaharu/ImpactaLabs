// JavaScript Document

function teste(){
		alert("Seja bem vindo ao meu site!");
			if(confirm("Deseja continuar?")){
			var nome = prompt("Digite seu nome");
			document.write("Olá "+nome+"! Obrigado por visitar meu site!");
		}
	}
	
	function janelaAviso(){
	janela = window.open('','Cadastro', 'width=200, height=200,	toolbar=no,	location=no, status=no,	scrollbars=no, resizable=no');
	janela.document.write("<p>Para acessar o site você precisa se cadastrar</p>");
	janela.document.write("<p><a href='javascript:window.close();'>Fechar</a></p>");
	}
	
function increment(){
	document.formName.textNum.value++;
	}

function verificarCheckbox(){
	if(document.formName.checkboxName.checked==false)
		alert("Você deve aceitar os termos do contrato!");
	else
		alert("Concluído");
	}

function propriedades(){
	var indice = document.form.avaliar.selectedIndex;
	var texto = "Indice da opção escolhida: " + index;
	texto+= "\nNumeros de opções do select: " + document.form.avaliar.length;
	texto+= "\nValor da opção escolhida: " + document.form.avaliar.options[indice].value;
	texto+= "\nTexto da opção escolhida: " + document.form.avaliar.options[indice].text;
	alert(texto);
}

function extJs(){
	Ext.onReady(function(){
		var win = new Ext.Window({
			width:300,
			height:150,
			maximizable:true,
			closable:true,
			collapsible:true,
			layout:'hbox',
			layoutConfig:{align:'middle', pack:'center'},
			defaults:{xtype:'button', flex:1, margins:'10', padding:10, height:30, width:100},
			items:[{
				text:'Teste',
				handler: teste,
				iconCls:'ico_action_check'
			},{
				text:'Janela Aviso',
				handler: janelaAviso,
			}],
		}).show();
	});
}
