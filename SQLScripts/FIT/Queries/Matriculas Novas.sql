------------------------------------------------------------------------------
-- GRADUACAO

SELECT c.NOME, a.NOME, a.EMAIL , a.CODEXT AS RA, a.SENHA FROM SOPHIA.FISICA a
INNER JOIN SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
INNER JOIN SOPHIA.TURMAS c ON c.CODIGO = b.TURMA_REGULAR
WHERE b.STATUS = 0 AND b.NOVA = 1 AND c.PERIODO = 128 AND c.CFG_ACAD = 1 
ORDER BY c.NOME, a.NOME


------------------------------------------------------------------------------
-- POS-GRADUACAO

SELECT c.NOME, a.NOME, a.CODEXT AS RA, a.SENHA FROM SOPHIA.FISICA a
INNER JOIN SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
INNER JOIN SOPHIA.TURMAS c ON c.CODIGO = b.TURMA_REGULAR
WHERE 
	b.STATUS = 0 AND 
	c.CODIGO in(
		2858, --  BI 11
		2616, -- MBA Data Center 03
		2893 -- MBA GTSI 17
	)
ORDER BY c.NOME, a.NOME

--MBA em Projeto e Gerenciamento de Data Center – turma 03
--Business Intelligence com Big Data – turma 11
--MBA em Gestão da Tecnologia e Segurança da Informação – turma 17

