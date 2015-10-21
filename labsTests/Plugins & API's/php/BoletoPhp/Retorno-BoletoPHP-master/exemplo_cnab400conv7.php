<?
/**Exemplo de uso da classe para processamento de arquivo de retorno de cobranças em formato FEBRABAN/CNAB400,
* testado com arquivo de retorno do Banco do Brasil com convênio de 7 posições.<br/>
*/

//Adiciona a classe strategy RetornoBanco que vincula um objeto de uma sub-classe
//de RetornoBase, e assim, executa o processamento do arquivo de uma determinada
//carteira de um banco específico.
require_once("class.RetornoBanco.php");
require_once("class.RetornoFactory.php");

/**Função handler a ser associada ao evento aoProcessarLinha de um objeto da classe
* RetornoBase. A função será chamada cada vez que o evento for disparado.
* @param RetornoBase $self Objeto da classe RetornoBase que está processando o arquivo de retorno
* @param $numLn Número da linha processada.
* @param $vlinha Vetor contendo a linha processada, contendo os valores da armazenados
* nas colunas deste vetor. Nesta função o usuário pode fazer o que desejar,
* como setar um campo em uma tabela do banco de dados, para indicar
* o pagamento de um boleto de um determinado cliente.
* @see linhaProcessada1
*/
function linhaProcessada($self, $numLn, $vlinha) {
	if($vlinha) {
		if($vlinha["tipo_registro"] == $self::DETALHE) {
			printf("%08d: ", $numLn);
			echo "Nosso N&uacute;mero <b>".$vlinha['nosso_numero']."</b> ".
			   "Data <b>".$vlinha["data_ocorrencia"]."</b> ". 
			   "Valor <b>".$vlinha["valor"]."</b><br/>\n";
		}
	} else echo "Tipo da linha n&atilde;o identificado<br/>\n";
}


/**Outro exemplo de função handler, a ser associada ao evento
* aoProcessarLinha de um objeto da classe RetornoBase.
* Neste exemplo, é utilizado um laço foreach para percorrer
* o vetor associativo $vlinha, mostrando os nomes das chaves
* e os valores obtidos da linha processada.
* @see linhaProcessada */
function linhaProcessada1($self, $numLn, $vlinha) {
	printf("%08d) ", $numLn);
	
	if($vlinha) {
		foreach($vlinha as $nome_indice => $valor)
			echo "$nome_indice: <b>$valor</b><br/>\n ";
			echo "<br/>\n";
		} 
	else 
		echo "Tipo da linha n&atilde;o identificado<br/>\n";
}


//--------------------------------------INÍCIO DA EXECUÇÃO DO CÓDIGO-----------------------------------------------------
$fileName_b = "returned/retorno_cnab400conv7.ret";
//$fileName = "returned/CN11033A.ret";

//Use uma das duas instrucões abaixo (comente uma e descomente a outra)
//$cnab400 = RetornoFactory::getRetorno($fileName, "linhaProcessada1");
$cnab400_b = RetornoFactory::getRetorno($fileName_b, "linhaProcessada");
//$cnab400 = RetornoFactory::getRetorno($fileName, "linhaProcessada");

//$retorno = new RetornoBanco($cnab400);
//$retorno->processar();
//echo "<hr />";
$retorno = new RetornoBanco($cnab400_b);
$retorno->processar();
?>  