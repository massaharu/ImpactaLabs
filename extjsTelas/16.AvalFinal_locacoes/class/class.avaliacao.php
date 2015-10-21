<?php
	# @AUTOR: renan #
	
	class Avaliacao {
		
		private $idaluno;
		private $idavaliacao;
		private $idcursoagendado;
		private $nota;
		private $descomentario;
		private $dtcadastro;
		
		public function __construct($idcursoagendado = 0){
			
			if($idcursoagendado > 0) $this->load($idcursoagendado);
		}
		
		public function load($idcursoagendado){
			
			$this->idcursoagendado = $idcursoagendado;
			
		}
		
		public function getAlunosAgendado(){
		
			return Sql::arrays("Saturn","Simpac","sp_AvaliacaoInstrutorAluno_list $this->idcursoagendado");
		
		}
	}
	
?>