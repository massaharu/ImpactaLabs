<?
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");


$alunos = Sql::arrays("SONATA", "SOPHIA", 
	"SELECT 
		e.DESCRICAO as NIVEL, 
		d.NOME as CURSO, 
		c.NOME as TURMA, 
		a.CODEXT as RA, 
		a.NOME, 
		a.CEP
	FROM SOPHIA.FISICA a
	INNER JOIN SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
	INNER JOIN SOPHIA.TURMAS c ON c.CODIGO = b.TURMA_REGULAR
	INNER JOIN SOPHIA.CURSOS d ON d.PRODUTO = c.CURSO
	INNER JOIN SOPHIA.CFG_ACAD e ON e.CODIGO = c.CFG_ACAD
	INNER JOIN SOPHIA.PERIODOS f ON f.CODIGO = c.PERIODO
	WHERE 
		b.STATUS = 0 AND c.PERIODO >= 109
	ORDER BY 
		e.DESCRICAO, d.NOME, c.NOME, a.NOME 
");



?>
<table>
	<thead>
    	<tr>
        	<th>Nível</th>
            <th>Curso</th>
            <th>Turma</th>
            <th>RA</th>
            <th>NOME</th>
            <th>CEP</th>
            <th>REGIÃO</th>
        </tr>
    </thead>
    <tbody>
    

	<?
    foreach($alunos as $aluno){
		echo 
		"<tr>
			<td>".$aluno['NIVEL']."</td>
			<td>".$aluno['CURSO']."</td>
			<td>".$aluno['TURMA']."</td>
			<td>".$aluno['RA']."</td>
			<td>".$aluno['NOME']."</td>
			<td>".$aluno['CEP']."</td>
			<td>".regiao($aluno['CEP'])."</td>
		</tr>";
    }
    ?>
	</tbody>
</table>