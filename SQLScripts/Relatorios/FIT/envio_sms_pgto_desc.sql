SELECT * FROM SOPHIA.HISTORICO_DESCONTOS WHERE VENDA = 34341
SELECT * FROM SOPHIA.MATRICULA WHERE FISICA = 23076
SELECT * FROM SophiA.VENDAS WHERE CODIGO = 34341
SELECT * FROM SOPHIA.FISICA WHERE CODIGO = 24939
SELECT * FROM SOPHIA.TITULOS WHERE CODPF = 23076
SELECT * FROM SOPHIA.TITULOS WHERE CODIGO = 857236
SELECT * FROM SOPHIA.MOVFIN
SELECT * FROM SOPHIA.NIVEL
SELECT * FROM SOPHIA.PLANOS_PGTO WHERE CODIGO = 1416
SELECT * FROM SOPHIA.JURIDICA WHERE ESCOLA = 0
SELECT * FROM SOPHIA.PLANOCONTAS
SELECT * FROM SOPHIA.MOTDESCONTO
SELECT * FROM SOPHIA.NATUREZA_DESC
SELECT * FROM SOPHIA.TIT_BAIXA
SELECT * FROM SOPHIA.MOTIVO_BAIXA
SELECT * FROM SOPHIA.TIT_RENEG
SELECT * FROM SOPHIA.FISICA WHERE NOME like '%Willyan Rodrigues Cordeiro%'

select * from sophia.TITULOS where CODIGO = 758120

select * from sophia.TIT_RENEG where RENEGOCIACAO = 4038

select * from sophia.RENEGOCIACOES where CODIGO = 4038

SELECT DISTINCT
	a.CODIGO as COD_CANCELADO
FROM SOPHIA.HISTORICO_DESCONTOS a
RIGHT JOIN SOPHIA.HISTORICO_DESCONTOS b ON b.COD_HISTORICO = a.CODIGO AND b.OPERACAO = 1
WHERE 
	--a.VENDA = 34341 AND
	a.CODIGO <> b.CODIGO
	
SELECT COUNT(*), VENDA FROM SOPHIA.HISTORICO_DESCONTOS
GROUP BY VENDA
HAVING COUNT(*) > 1

SELECT * FROM SOPHIA.TITULOS 
WHERE 
	CODPJ = 4714 AND
	YEAR(DATA_VCTO) = 2015 AND
	MONTH(DATA_VCTO) = 5
---------------------------------------------------------------
--------------------- PRATO FEITO -----------------------------
---------------------------------------------------------------
SELECT DISTINCT TOP 1

	a.NOME,
	a.CODEXT,
	a.EMAIL,
	CASE
	
		WHEN a.FORMACONTATO1 = 2 THEN -- SE CONTATO 1 FOR CELULAR
			CASE 
				WHEN a.CONTATO1 IS NOT NULL AND a.CONTATO1 <> '' THEN -- SE TIVER O CELULAR 
					replace(replace(replace(replace(a.CONTATO1, '-', ''), '(', ''), ')', ''), ' ', '')
				ELSE
					CASE 
						WHEN a.CONTATO2 IS NOT NULL AND a.CONTATO2 <> '' THEN
							replace(replace(replace(replace(a.CONTATO2, '-', ''), '(', ''), ')', ''), ' ', '')
						ELSE
							replace(replace(replace(replace(a.CONTATO3, '-', ''), '(', ''), ')', ''), ' ', '')
					END
			END
			
		ELSE 
		
			CASE
				
				WHEN a.FORMACONTATO2 = 2 THEN -- SE CONATATO 2 FOR CELULAR
					CASE 
						WHEN a.CONTATO2 IS NOT NULL AND a.CONTATO2 <> '' THEN -- SE TIVER O CELULAR 
							replace(replace(replace(replace(a.CONTATO2, '-', ''), '(', ''), ')', ''), ' ', '')
						ELSE
							CASE 
								WHEN a.CONTATO3 IS NOT NULL AND a.CONTATO3 <> '' THEN
									replace(replace(replace(replace(a.CONTATO3, '-', ''), '(', ''), ')', ''), ' ', '')
								ELSE
									replace(replace(replace(replace(a.CONTATO1, '-', ''), '(', ''), ')', ''), ' ', '')
							END
					END
				
				ELSE
					
					CASE
				
						WHEN a.FORMACONTATO3 = 2 THEN -- SE FOR CELULAR
							CASE 
								WHEN a.CONTATO3 IS NOT NULL AND a.CONTATO3 <> '' THEN -- SE TIVER O CELULAR 
									replace(replace(replace(replace(a.CONTATO3, '-', ''), '(', ''), ')', ''), ' ', '')
								ELSE
									CASE 
										WHEN a.CONTATO1 IS NOT NULL AND a.CONTATO1 <> '' THEN
											replace(replace(replace(replace(a.CONTATO1, '-', ''), '(', ''), ')', ''), ' ', '')
										ELSE
											replace(replace(replace(replace(a.CONTATO2, '-', ''), '(', ''), ')', ''), ' ', '')
									END
							END
						
						ELSE
						
							CASE
							
								WHEN a.CONTATO1 IS NOT NULL AND a.CONTATO1 <> '' THEN -- SE TIVER O CONTATO 
									replace(replace(replace(replace(a.CONTATO1, '-', ''), '(', ''), ')', ''), ' ', '')
								ELSE
									CASE 
										WHEN a.CONTATO2 IS NOT NULL AND a.CONTATO2 <> '' THEN
											replace(replace(replace(replace(a.CONTATO2, '-', ''), '(', ''), ')', ''), ' ', '')
										ELSE
											replace(replace(replace(replace(a.CONTATO3, '-', ''), '(', ''), ')', ''), ' ', '')
									END	
							END
					END
			END
	END AS CELULAR,
	e.DATA_VCTO,
	g.descricao,
	curso.NOME AS CURSO,
	e.CODIGO AS CODTITULO,
	e.* 
FROM SOPHIA.FISICA a
INNER JOIN SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO AND b.STATUS = 0
INNER JOIN SOPHIA.CURSOS curso ON curso.PRODUTO = b.CURSO AND (curso.NIVEL = 1 OR curso.NIVEL = 2 OR curso.NIVEL = 4)
INNER JOIN SophiA.VENDAS c ON c.CODIGO = b.VENDA
INNER JOIN SOPHIA.TITULOS e ON e.CODPF = a.CODIGO
INNER JOIN SOPHIA.MOVFIN f ON f.TITULO = e.CODIGO
INNER JOIN SOPHIA.PLANOCONTAS g ON g.CODIGO = f.CLASSIFICACAO
WHERE 
	YEAR(e.DATA_VCTO) = 2015 AND
	MONTH(e.DATA_VCTO) = 5 AND
	g.DESCRICAO like '%mens%' AND
	e.RECEBIDO = 0 AND
	e.RECEBIDO <> 2 AND
	e.CODIGO NOT IN (
		SELECT TITULO FROM SOPHIA.TIT_RENEG
	)
ORDER BY a.NOME
	
---------------------------------------------------------------
--------------------- PJ --------------------------------------
---------------------------------------------------------------
	
SELECT DISTINCT 
	a.NOME,
	a.EMAIL,
	a.CONTATO1,
	a.CONTATO2,
	a.CONTATO3,
	d.valor as nrdesconto, 
	e.* 
FROM SOPHIA.FISICA a
INNER JOIN SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
INNER JOIN SOPHIA.CURSOS curso ON curso.PRODUTO = b.CURSO
INNER JOIN SOPHIA.NIVEL nv ON nv.CODIGO = curso.NIVEL
INNER JOIN SophiA.VENDAS c ON c.CODIGO = b.VENDA
INNER JOIN SOPHIA.HISTORICO_DESCONTOS d ON d.VENDA  = c.CODIGO
INNER JOIN SOPHIA.JURIDICA f ON f.CODIGO = d.EMPRESA
INNER JOIN SOPHIA.TITULOS e ON e.CODPJ = f.CODIGO
INNER JOIN SOPHIA.MOVFIN g ON g.TITULO = e.CODIGO
INNER JOIN SOPHIA.PLANOCONTAS h ON h.CODIGO = g.CLASSIFICACAO
INNER JOIN SOPHIA.MOTDESCONTO i ON i.CODIGO = d.MOTIVO_DESCONTO
INNER JOIN SOPHIA.NATUREZA_DESC j ON j.CODIGO = i.NATUREZA
WHERE 
	nv.CODIGO IN(1, 2, 4) AND
	YEAR(e.DATA_VCTO) = 2015 AND
	MONTH(e.DATA_VCTO) = 5 AND
	h.DESCRICAO like '%mens%' AND
	e.RECEBIDO = 0	AND
	j.CODIGO = 5 -- financiamento
	
SELECT * FROM  SOPHiA.JURIDICA WHERE CODIGO = 6095	