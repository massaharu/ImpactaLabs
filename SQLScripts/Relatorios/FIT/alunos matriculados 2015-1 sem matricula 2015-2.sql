
SELECT 
	c.NOME AS TURMA,  a.CODEXT, a.NOME, a.EMAIL, a.CONTATO1, a.CONTATO2, a.CONTATO3
FROM SOPHIA.FISICA a
INNER JOIN SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
INNER JOIN SOPHIA.TURMAS c ON c.CODIGO = b.TURMA_REGULAR
INNER JOIN SOPHIA.CURSOS d ON d.PRODUTO = c.CURSO
WHERE 
	d.NIVEL in (1, 2) AND 
	c.PERIODO = 127 AND 
	(
		SELECT 
			COUNT(*) 
		FROM SOPHIA.MATRICULA
		WHERE 
			FISICA = a.CODIGO AND PERIODO = 128
		GROUP BY 
			FISICA
			
	) IS NULL AND 
	c.CODIGO NOT IN (
		2718,
		2683,
		2789,
		2687,
		2698,
		2705
	) AND 
	a.CODEXT COLLATE SQL_Latin1_General_CP850_CI_AI NOT IN(
		
		SELECT 
			desra COLLATE SQL_Latin1_General_CP850_CI_AI 
		FROM 
			SATURN.FIT_NEW.dbo.tb_solicitacao_rematricula	
		WHERE 
			idperiodo = 128
			
	)
ORDER BY 
	c.NOME, a.NOME	
	
------------------------------------------------
------------------------------------------------
 