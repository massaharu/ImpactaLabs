<?php
require("../inc/configuration.php");
$GLOBALS['JSON'] = true;
$page = new Page(array(
				'css'		=>true
			));
			
$hierarchy = array(
				array(
					'url' 	=> '/',
					'title' => 'Home' 
				),
				array(
					'url' 	=> '',
					'title' => 'Eventos' 
				)
			);

$sql = new Sql();
$sql->conecta('SQL_TESTE','FIT_NEW');

$data = date("m-d-Y"); 

$graduacao = $sql->arrays("sp_Cadcadastro_curso_tipo_list '1,3,4','$data'");

$posgraduacao = $sql->arrays("sp_Cadcadastro_curso_tipo_list '2,5','$data'");



?>

<div class="container container-middle"> 
	<!-- /CATEGORIAS -->
	<div class="row">
	<? require("../inc/panelleft.php");?>
		<!--  container center  -->
		<div class="span9 container-fit-default">
			<div class="row-fluid">
				<? $page->putTitle('eventos', $hierarchy) ?>
				<div class="span9 well-fit-default">
					<div id="graduacaocolegio">
						<h3>Graduação e Colégio</h3>
						<div class="accordion" id="accordion-graduacao"> 
							<!-- 1 -->
							<div class="accordion-group">
								<div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-graduacao" href="#evento1"> 02 Agosto de 2012 </a> </div>
								<div id="evento1" class="accordion-body in collapse">
									<div class="accordion-tituloevento">
										
                                    </div>
									<div class="accordion-inner">
										<div class="main-desevento">
											<p class="desevento">
												
											</p>
											<p class="dadosevento">
												<strong>Data:</strong> 31/7/2012<br />
												<strong>Horário:</strong> 19h às 22h00 horas<br />
												<strong>Focada no curso:</strong> ...:: Selecione o Curso ::...<br />
												<strong>Local:</strong> Rua: Arabé, 71 - Proximo ao Metro Santa Cruz <br />
												<strong>Palestrante:</strong> Sr. Célio Antunes - Presidente do grupo Impacta 
											</p>
											<button class="btn btn-ok" id="btnok"><strong>Inscreva-se Já</strong></button>
										</div>
									</div>
								</div>
							</div>
							<!-- 2 -->
							<div class="accordion-group">
								<div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-graduacao" href="#evento2"> 29 julho de 2012 </a> </div>
								<div id="evento2" class="accordion-body collapse">
									<div class="accordion-tituloevento"> Título do Evento... </div>
									<div class="accordion-inner">
										<div class="main-desevento">
											<p class="desevento"></p>
											<p class="dadosevento">
												<strong>Data:</strong><br />
												<strong>Horário:</strong><br />
												<strong>Focada no curso:</strong><br />
												<strong>Local:</strong><br />
												<strong>Palestrante:</strong>
											</p>
											<button class="btn btn-ok" id="btnok"><strong>Inscreva-se Já</strong></button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="posgraduacao"> 
						<hr />
						<h3>Pós-Graduação e MBA</h3>
						<div class="accordion" id="accordion-posgraduacao"> 		
							<!-- 3 -->
							<div class="accordion-group">
								<div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-posgraduacao" href="#evento3"> 06 Junho de 2012 </a> </div>
								<div id="evento3" class="accordion-body collapse">
									<div class="accordion-tituloevento"> Título do Evento... </div>
									<div class="accordion-inner">
										<div class="main-desevento">
											<p class="desevento"></p>
											<p class="dadosevento">
												<strong>Data:</strong><br />
												<strong>Horário:</strong><br />
												<strong>Focada no curso:</strong><br />
												<strong>Local:</strong><br />
												<strong>Palestrante:</strong>
											</p>
											<button class="btn btn-ok" id="btnok"><strong>Inscreva-se Já</strong></button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>	