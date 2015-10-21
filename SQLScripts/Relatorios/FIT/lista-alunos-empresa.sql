SELECT DISTINCT
	f.NOME as CURSO
	,a.NOME
	, a.EMAIL
	,CASE 
		WHEN a.CONTATO1 = '' THEN 
			CASE 
				WHEN a.CONTATO2 = '' THEN
					a.CONTATO3
				ELSE
					a.CONTATO2  				
			END
		ELSE
			a.CONTATO1
	END AS CONTATO
	, d.NOMEFANTASIA
	, e.DESCRICAO
FROM sophia.FISICA a
INNER JOIN sophia.MATRICULA b ON b.FISICA = a.CODIGO
INNER JOIN sophia.DADOSPF c ON c.FISICA = a.CODIGO
INNER JOIN sophia.JURIDICA d ON d.CODIGO = c.EMPRESA
LEFT JOIN sophia.OCUPACOES e ON e.CODIGO = c.OCUPACAO
INNER JOIN sophia.CURSOS f ON f.PRODUTO = b.CURSO 
WHERE b.CURSO in(62, 33, 71, 56, 59, 61) 
ORDER BY f.NOME, a.NOME
----------------------------------------------------------------
----------------------------------------------------------------
SELECT * FROM sophia.FISICA
SELECT * FROM [sophia.DADOSPF] WHERE EMPRESA IS NOT NULL
SELECT * FROM sophia.CURSOS where NOME like '%e-comme%'
SELECt * FROM sophia.JURIDICA WHERE CODIGO = 634
SELECt * FROM sophia.MATRICULA
SELECT * FROM sophia.OCUPACOES