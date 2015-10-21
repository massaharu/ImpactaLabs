
-- VERIFICA AS AVALIACOES QUE NAO POSSUEM ATAS GERADAS
SELECT 
	a.CODIGO as AVALIACAO, b.CODIGO as CODTURMA, b.NOME as TURMA, d.CODIGO as CODDISCIPLINA, d.NOME as DISCIPLINA, f.NOME As ETAPA
FROM SOPHIA.AVALS a
INNER JOIN SOPHIA.ETAPAs f ON f.CODIGO = a.ETAPA
INNER JOIN SOPHIA.TURMAS b ON b.CODIGO = a.TURMA
INNER JOIN SOPHIA.CURSOS c ON c.PRODUTO = b.CURSO
INNER JOIN SOPHIA.DISCIPLINAS d ON d.CODIGO = a.DISCIPLINA
LEFT JOIN SOPHIA.ATA_NOTA e ON e.AVALIACAO = a.CODIGO
WHERE b.PERIODO = 127 AND c.NIVEL in (1,2) AND e.CODIGO IS NULL
ORDER BY b.NOME, d.NOME, f.NUMERO


SELECT * FROM SOPHIA.ETAPAS ORDER BY CFG_ACAD
SELECT * FROM SOPHIA.ATA_NOTA WHERE AVALIACAO = 24153
SELECT * FROM SOPHIA.NIVEL
SELECT * FROM SOPHIA.CFG_ACAD
SELECT * FROM SOPHIA.AVALS WHERE CODIGO = 24143
SELECT * FROM SOPHIA.AVALS WHERE TURMA = 2643 AND DISCIPLINA = 851 AND ETAPA = 5
SELECT * FROM SOPHIA.TIPOS_AVAL
SELECT * FROM SONATA.SOPHIA.SOPHIA.FUNCIONARIOS WHERE IDENTIFICACAO = 'SRIBEIRO'
