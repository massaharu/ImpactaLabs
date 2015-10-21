<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PHP Page</title>
</head>

<body>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" >
$(function(){
    btn=$("#btn_enviar")
   	 btn.click(function(){
   	 alert("OK");
   	 });   
    
    $.ajax({
   	 url:'acao.php',
   	 data:$.param({
   		 id:val,
   	 })
    });
   	 
   	 
});
</script>
<form action="acao.php" method="POST">
	<p>Seu nome: <input type="text" name="nome"/></p>
	<p>Sua idade: <input type="text" name="idade"/></p>
	<p>Gênero: <input type="radio" name="gen" value="Masculino">Masculino </ >
   	 			<input type="radio" name="gen" value="Feminino">Feminino </ ></p>
	<p>Linguagens: <input type="checkbox" name="php" value="Php">PHP</ >
   				<input type="checkbox" name="java" value="Java">Java</ >
   		 	    <input type="checkbox" name="pascal" value="Pascal">Pascal</ ></p>
                <input type="submit" value="Enviar" name="enviar" />
    			<input id="btn_enviar" type="button" value="cadastrar"/>    
</form>
</body>
</html>