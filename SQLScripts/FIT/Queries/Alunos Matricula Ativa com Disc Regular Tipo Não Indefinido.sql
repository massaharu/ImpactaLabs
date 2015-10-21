
SELECT a.TIPO_MATR, a.SITUACAO, e.NOME, a.* FROM SOPHIA.ACADEMIC a
INNER JOIN SOPHIA.MATRICULA b ON b.CODIGO = a.MATRICULA
INNER JOIN SOPHIA.FISICA c ON c.CODIGO = b.FISICA
INNER JOIN SOPHIA.TURMAS d ON d.CODIGO = a.TURMA
INNER JOIN SOPHIA.FISICA e ON e.CODIGO = b.FISICA
WHERE 
	b.STATUS = 0 AND
	d.PERIODO = 127 AND
	a.TIPO_MATR = 0 AND
	a.SITUACAO <> 0
-----------------------------------------------------------	
--BEGIN TRAN	

--UPDATE 	SOPHIA.ACADEMIC
--SET SITUACAO = 0
--FROM SOPHIA.ACADEMIC a
--INNER JOIN SOPHIA.MATRICULA b ON b.CODIGO = a.MATRICULA
--INNER JOIN SOPHIA.FISICA c ON c.CODIGO = b.FISICA
--INNER JOIN SOPHIA.TURMAS d ON d.CODIGO = a.TURMA
--INNER JOIN SOPHIA.FISICA e ON e.CODIGO = b.FISICA
--WHERE 
--	b.STATUS = 0 AND
--	d.PERIODO = 128 AND
--	a.TIPO_MATR = 0 AND
--	a.SITUACAO <> 0

--COMMIT	
	
--SELECT @@TRANCOUNT	
-----------------------------------------------------------	
