$(function() {
	$( "#accordion" ).accordion({
		icons:''		
	});
	
	$('#btn-reenviar-email').on('click', function(){
		var $btnThis = $(this);
		var nrcpf = $btnThis.data('nrcpf');
		var email = $btnThis.data('email');
		var path = $btnThis.data('path');
		var idusuario = $btnThis.data('idusuario');
		var solicitante = $btnThis.data('solicitante');
		
		$(this).text('Enviando e-mail para: '+email+'...');
		
		$.ajax({
			url:path+"/ajax/solicitacao_corporativa_reenviaremail.php",
			type: 'POST',
			dataType: 'json',
			data:{
				nrcpf: nrcpf,
				email: email,
				solicitante: solicitante
			},
			success:function(resp){
				$btnThis.text('Reenviar Email');
				
				if(resp.success){
					alert('SUCESSO!\n\rO email foi enviado com sucesso. Você receberá uma cópia deste email.\n\r'+resp.msg);
				}else{
					alert('ERRO!\n\r'+resp.msg);
				}
			},
			error: function(resp){
				
				$btnThis.text('Reenviar Email');
				alert('ERRO!');
			}
		});
	});
});