SELECT 
	d.NOME_RESUM as CURSO,
	MAX(e.DESCRICAO) as PERIODO,
	MAX(C.NOME) AS TURMA,	
	MAX(b.DATA_MATRICULA) as DATA_MATRICULA,
	a.CODEXT as RA,
	LTRIM(RTRIM(LEFT(a.NOME, CHARINDEX(' ', a.NOME, 0)))) AS NOME,
	LTRIM(RTRIM(SUBSTRING(a.NOME, CHARINDEX(' ', a.NOME, 0), LEN(a.NOME)))) AS SOBRENOME,
	a.EMAIL,
	CASE 
		WHEN a.FORMACONTATO1 = 2 THEN dbo.fn_remove_caracter('-, ,	,(,)',',', a.CONTATO1) 
		WHEN a.FORMACONTATO2 = 2 THEN dbo.fn_remove_caracter('-, ,	,(,)',',', a.CONTATO2) 
		WHEN a.FORMACONTATO3 = 2 THEN dbo.fn_remove_caracter('-, ,	,(,)',',', a.CONTATO3) 
	END AS CELULAR
FROM SOPHIA.FISICA a
INNER JOIN SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
INNER JOIN SOPHIA.TURMAS c ON c.CODIGO = b.TURMA_REGULAR
INNER JOIN SOPHIA.CURSOS d ON d.PRODUTO = c.CURSO
INNER JOIN SOPHIA.PERIODOS e ON e.CODIGO = c.PERIODO
WHERE 
	d.PRODUTO in (65, 73) AND b.STATUS in(0, 5)
GROUP BY
	a.CODEXT,
	a.NOME,
	CASE 
		WHEN a.FORMACONTATO1 = 2 THEN dbo.fn_remove_caracter('-, ,	,(,)',',', a.CONTATO1) 
		WHEN a.FORMACONTATO2 = 2 THEN dbo.fn_remove_caracter('-, ,	,(,)',',', a.CONTATO2) 
		WHEN a.FORMACONTATO3 = 2 THEN dbo.fn_remove_caracter('-, ,	,(,)',',', a.CONTATO3) 
	END ,
	a.EMAIL,
	d.NOME_RESUM
ORDER BY 
	d.NOME_RESUM,
	MAX(e.DESCRICAO),
	MAX(C.NOME) ,
	A.NOME