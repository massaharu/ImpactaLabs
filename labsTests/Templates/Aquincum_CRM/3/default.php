<?
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
$data = Instrutor::getTodosInstrutores();
?>
<!DOCTYPE html>
<html>
<head>
<meta name="author" content="Bruno Bove Barbosa - @brunobbarbosa" />
<meta name="description" content="Template for Company" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Template your Company</title>
<link href="res/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
	<div class="container">
    	<h1>Lista de Instrutores Ativos X treinamentos ministrados</h1>
    	<?
        foreach($data as $val){
			$instrutor = new Instrutor($val['idinstrutor']);
		?>
            <div class="media">
              <a class="pull-left" href="#">
              	<? if($instrutor->descaminhofoto) { ?>
                	<img class="media-object" src="http://parceiros.impacta.com.br/a/images/instrutores_fotos/<?=$instrutor->descaminhofoto?>" width="64" height="64" />
                <? } else { ?>
                	<img class="media-object" src="http://placehold.it/64x64">
                <? } ?>
              </a>
              <div class="media-body">
                <h4 class="media-heading"><?=$instrutor->nminstrutor;?> - <?=$instrutor->cdemail;?></h4>
                <ul style="list-style:circle !important;">
                <? foreach($instrutor->getCursosMinistrados() as $val2){ ?>
                    <li><?=$val2['descurso']?></li>
                <? } ?>
                </ul>
              </div>
            </div>
        
        <?
			}
		?>
    </div>    
	<!-- start: Java Script -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="res/js/jquery-1.8.2.js"></script>
    <script src="res/js/bootstrap.min.js"></script>
    <!-- end: Java Script -->
</body>
</html>
