SELECT 
	a.CODIGO AS COD_ATA,
	c.NOME AS CURSOS,
	b.NOME as TURMA,
	e.NOME AS DISCIPLINA,
	a.ETAPA,
	SUM(f.nota)
FROM SophiA.ATA_NOTA a
INNER JOIN SophiA.TURMAS b ON b.CODIGO = a.TURMA
INNER JOIN sophia.CURSOS c ON c.PRODUTO = b.CURSO
INNER JOIN SOPHIA.NIVEL d ON d.CODIGO = c.NIVEL
INNER JOIN SOPHIA.DISCIPLINAS e ON e.CODIGO = a.DISCIPLINA
INNER JOIN SOPHIA.ata_aluno f ON f.ata = a.CODIGO
INNER JOIN SOPHIA.MATRICULA g ON g.CODIGO = f.matricula
INNER JOIN SOPHIA.FISICA h ON h.CODIGO = g.FISICA
WHERE b.PERIODO = 127 AND ETAPA NOT IN (14,3, 4) AND c.NIVEL IN(1, 2)
GROUP BY
	a.CODIGO,
	c.NOME,
	b.NOME,
	e.NOME,
	a.ETAPA
HAVING SUM(f.nota) < 0.001 OR SUM(f.nota) IS NULL	
ORDER BY b.NOME

SELECT * FROM SOPHIA.NIVEL
SELECT * FROM SophiA.ATA_NOTA WHERE TURMA = 2643
SELECT * FROM SOPHIA.ATA_ALUNO
