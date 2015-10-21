<?php
	# @AUTOR: massa #
	
	class AvaliacaoFinalLocacoes extends Avaliacao{
		
		private $idquestao;
		
		//Function insere a avaliação final no banco
		
		public function add($idquestao,$idcursoagendado,$idaluno,$msn,$nota){
			
			Sql::query("SQL_TESTE","DEV_TESTE","INSERT INTO tb_AvaliacaoFinalLocacoes_Avaliacao(idquestao, idcursoagendado, idaluno, descomentario, nrnota) VALUES($idquestao, $idcursoagendado, $idaluno, '$msn', $nota)");
			
		}
		
		//Function retorna as questões da avaliação Final
		
		public function getFinalQuestions(){
			
			$avaliacao = Sql::arrays("SQL_TESTE","DEV_TESTE","sp_AvaliacaoFinalLocacoes_list");
			
			return $avaliacao;
		}
		
		/*//Function returns "media" of each topic
		
		public function getItensMedia($idcursoagendado){
		
			return Sql::arrays("Saturn","Simpac","sp_AvalicaoItensMedia $idcursoagendado");
			
		}
		
		//Função retorna dados do treinamento que apresenta o determinado idcursoagendado
		
		public function getFinalReport($idcursoagendado){
		
			return Sql::arrays("Saturn","Simpac","sp_AvaliacaoFinalRelatorio $idcursoagendado");
		
		}*/
	}
?>