SELECT 
	b.CODEXT as RA, 
	b.NOME, 
	e.NOME AS TURMA,
	a.dtmatricula  AS DATA_MATRICULA
FROM SATURN.FIT_NEW.dbo.tb_solicitacao_rematricula a
INNER JOIN SOPHIA.FISICA b ON b.CODEXT COLLATE SQL_Latin1_General_CP850_CI_AI = a.desra COLLATE SQL_Latin1_General_CP850_CI_AI 
INNER JOIN SOPHIA.MATRICULA c ON c.FISICA = b.CODIGO
INNER JOIN SOPHIA.ACADEMIC d ON d.MATRICULA = c.CODIGO
INNER JOIN SOPHIA.TURMAS e ON e.CODIGO = d.TURMA
WHERE a.idperiodo = 128 AND a.dtmatricula IS NOT NULL AND e.NOME LIKE '%DP/ADAP%' AND e.PERIODO = 128
ORDER BY a.dtmatricula 
------------------------------------------
SELECT * FROM SATURN.FIT_NEW.dbo.tb_solicitacao_rematricula
WHERE idperiodo = 128 AND dtmatricula IS NOT NULL
ORDER BY dtmatricula
------------------------------------------
SELECT * FROM SATURN.FIT_NEW.dbo.tb_solicitacao_rematricula
WHERE idperiodo = 128
ORDER BY dtmatricula

SELECT * FROM SOPHIA.FISICA WHERE CODEXT =  '1510584'
---------------------------------------------------
SELECT 
	b.CODEXT as RA, 
	b.NOME, 
	e.NOME AS TURMA,
	a.dtmatricula  AS DATA_MATRICULA
FROM SATURN.FIT_NEW.dbo.tb_solicitacao_rematricula a
INNER JOIN SOPHIA.FISICA b ON b.CODEXT COLLATE SQL_Latin1_General_CP850_CI_AI = a.desra COLLATE SQL_Latin1_General_CP850_CI_AI 
INNER JOIN SOPHIA.MATRICULA c ON c.FISICA = b.CODIGO
INNER JOIN SOPHIA.ACADEMIC d ON d.MATRICULA = c.CODIGO
INNER JOIN SOPHIA.TURMAS e ON e.CODIGO = d.TURMA
WHERE a.idperiodo = 128 AND a.dtmatricula IS NOT NULL AND e.PERIODO = 128 AND b.NOME like 'guilherme%'
ORDER BY a.dtmatricula 