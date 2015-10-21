<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PHP Page</title>
</head>

<body>
<?php 
$name = $_POST["nome"];
$idade = $_POST["idade"];
$gen = $_POST["gen"];
$php = $_POST["php"];
$java = $_POST["java"];
$pascal = $_POST["pascal"];


echo "Meu nome é $name, tenho $idade anos. $gen, domino as linguagens $php, $java, $pascal";









/*echo "O seu nome é $nome e sua idade é $idade<br/ >";
echo 'O seu nome é $nome e sua idade é $idade<br/ >';

foreach($_POST as $item_post)(
    var_dump($item_post) .'<br/>';*/

 
?>
</body>
</html>