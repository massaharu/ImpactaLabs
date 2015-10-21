SELECT 
	MAX(d.NOME) as Curso,
	MAX(f.DESCRICAO) as Periodo,
	MAX(c.NOME) as Turma,
	a.NOME as Nome,
	a.EMAIL as Email
FROM SOPHIA.FISICA a
INNER JOIN SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
INNER JOIN SOPHIA.TURMAS c ON c.CODIGO = b.TURMA_REGULAR
INNER JOIN SOPHIA.CURSOS d ON d.PRODUTO = c.CURSO
INNER JOIN SOPHIA.NIVEL e ON e.CODIGO = d.NIVEL
INNER JOIN SOPHIA.PERIODOS f ON f.CODIGO = b.PERIODO
WHERE 
	b.STATUS IN (0, 5) AND d.NIVEL <> 4 AND 
	f.CODIGO IN(
		112,
		114,
		117,
		119,
		120,
		124,
		125,
		127,
		128
	)
GROUP BY
	a.NOME,
	a.EMAIL
ORDER BY MAX(d.NOME), MAX(f.DESCRICAO), MAX(c.NOME), a.NOME

-----------------------------------------------------------------


-----------------------------------------------------------------

SELECT * FROM SOPHIA.NIVEL
SELECT * FROM SOPHIA.PERIODOS 
SELECT * FROM SOPHIA.CURSOS

Graduação em Sistemas de Informação 43
Graduação em Gestão de Tecnologia da Informação 
Curso de Análise e Desenvolvimento de Sistemas
Curso de Redes de Computadores
MBA em Projeto e Gerenciamento de Data Center
MBA em Gestão e Tecnologia em Segurança da Informação - Parceria Daryus
MBA em Gestão de Projetos (Ênfase no PMBoK)
MBA em Gestão da Tecnologia da Informação
Pós-Graduação em Engenharia de Software
Pós-Graduação em Business Intelligence com Big Data


SELECT  d.NOME, c.* FROM SOPHIA.FISICA a
INNER JOIN SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
INNER JOIN SOPHIA.ACADEMIC c ON c.MATRICULA = b.CODIGO
INNER JOIN SophiA.DISCIPLINAS d ON d.CODIGO = c.DISCIPLINA
WHERE b.STATUS = 0 AND a.CODEXT = '1202642'

SELECT * FROM SOPHIA.TURMAS WHERE CODIGO = 2837