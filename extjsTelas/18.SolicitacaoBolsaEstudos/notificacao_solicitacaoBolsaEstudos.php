<?php
//require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 

$solicitacaobolsaestudo =  new SolicitacaoBolsaEstudos(0);
$notificacao_list = $solicitacaobolsaestudo->solicitacaoBolsaEstudosNotificacao_List();

foreach($notificacao_list as $notificacoes){
	if($notificacoes['idusuario'] == 1495){
		$solicitacaobolsaestudo = new SolicitacaoBolsaEstudos($notificacoes['idsolicitacaobolsaestudo']);
		$curso = $solicitacaobolsaestudo->getCursoBySolicitacaobolsaestudos();
		$usuario = new Usuario($notificacoes['idusuario']);
		
		$aluno = $usuario->nmcompleto;
		$curso = utf8_encode($curso['curso_titulo']);
		$para = $usuario->cdemail;	
		$assunto = 'Rematrícula';
		
		$mensagem = emailpadrao(utf8_decode('Olá <b>'.$aluno.'</b>, solicitamos que faça o quanto antes a rematrícula referente ao curso de <b>'.$curso.'</b>'));
		
		envia_email($assunto, $mensagem, $para);
	}
}
?>
