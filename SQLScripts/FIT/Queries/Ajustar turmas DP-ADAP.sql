--------------------------------------------------------------
--------------------------------------------------------------
----------------- CRIAR AS TURMAS ----------------------------
--------------------------------------------------------------

------------------------------------------ OUTRA SOLU��O ---------------------------------------------

-- CRIAR TURMAS


-- INSERT INTO SOPHIA.TURMAS
(NOME, PERIODO, TURMA, TURNO, ESTADO, AL_MAX, AL_VIG, AL_REALOC, AL_CANC, AL_TRANSF, AL_EVAD, AL_TRANC, INICIO, TERMINO, UNIDADE, TIPO_FALTAS, CFG_ACAD, PROF_RESPONSAVEL, controlar_vagas_disciplina, curr_base, lancnota_exige_aut, HABILITA_LCTO_WEB, AL_PRE) 

SELECT 
	MAX(i.CH) as CH,
	e.CODIGO AS CODDISCIPLINA,
	'_DP/ADAP - ' + e.NOME_RESUM + ' - ' + LTRIM(RTRIM(LEFT(g.NOME, CHARINDEX(' ', g.NOME)))) AS NOMETURMA,
	128 AS PERIODO,
	'X' AS TURMA,
	MIN(d.TURNO) AS TURNO,
	d.ESTADO,
	MAX(d.AL_MAX) as AL_MAX,
	0 AS AL_VIG,
	0 AS AL_REALOC,
	0 AS AL_CANC,
	0 AS AL_TRANSF,
	0 AS AL_EVAD,
	0 AS AL_TRANC,
	'2015-08-02 00:00:00.000' AS INICIO,
	'2015-12-23 00:00:00.000' AS TERMINO,
	1 AS UNIDADE,
	0 AS TIPO_FALTAS,
	1 AS CFG_ACAD,
	ISNULL(MAX(d.PROF_RESPONSAVEL), NULL) as PROF_RESPONSAVEL,
	0 AS controlar_vagas_disciplina,
	0 as curr_base,
	0 AS lancnota_exige_aut,
	1 AS HABILITA_LCTO_WEB,
	0 AS AL_PRE
FROM SOPHIA.FISICA a
INNER JOIN SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
INNER JOIN SophiA.ACADEMIC c ON c.MATRICULA = b.CODIGO
INNER JOIN SOPHIA.TURMAS d ON d.CODIGO = c.TURMA
INNER JOIN SOPHIA.DISCIPLINAS e ON e.CODIGO = c.DISCIPLINA
INNER JOIN SOPHIA.TURMAS g ON g.CODIGO = b.TURMA_REGULAR
LEFT JOIN SOPHIA.QC i ON i.TURMA = d.CODIGO AND i.DISCIPLINA = e.CODIGO
WHERE 
	(d.NOME LIKE '%DP/ADAP%' OR d.NOME LIKE '%DP/ADP%' OR d.NOME LIKE '%DP/ADPA%' ) AND d.PERIODO = 128
GROUP BY
	e.CODIGO,
	LEFT(g.NOME, CHARINDEX(' ', g.NOME)),
	e.NOME_RESUM,
	e.CODIGO,
	e.NOME,
	d.PERIODO,
	d.ESTADO
ORDER BY e.NOME, LTRIM(RTRIM(LEFT(g.NOME, CHARINDEX(' ', g.NOME))))

-- CRIAR QC

insert into sophia.QC(TURMA,DISCIPLINA,ORDEM,TIPO,CH,CREDITOS,TEM_NOTAS,REPROVA,REPROVA_NOTA,TIPO_NOTA,AD1,AD2,AD3,AD4,AD5,AD6,AD7,AD8,AD9,AD10,AD11,AD12,TAREFAS1,TAREFAS2,TAREFAS3,TAREFAS4,TAREFAS5,TAREFAS6,TAREFAS7,TAREFAS8,TAREFAS9,TAREFAS10,TAREFAS11,TAREFAS12,CHSEMANAL,APURACAO_FREQUENCIA,LANCAMENTO_FREQUENCIA,OBRIGATORIO,AL_VIG,AL_MAX,CH_TEORIA,CH_PRATICA,CH_PRESENCIAL,CH_N_PRESENCIAL,prof_altera_plano,EXIBE_ATAS_FINAIS)
values(@turma,@disciplina,@ordem,@tipo,@ch,0,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,1,0,@al_max,0,0,@ch,0,1,1)

SELECT 
	d.NOME,
	d.CODIGO AS CODTURMA,
	e.CODIGO AS CODDISCIPLINA,
	1 AS ORDEM,
	0 AS TIPO,
	h.CH,
	0,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,1,0,
	MAX(d.AL_MAX) as AL_MAX,
	0,0,
	h.CH,
	0,1,1
FROM SOPHIA.FISICA a
INNER JOIN SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
INNER JOIN SophiA.ACADEMIC c ON c.MATRICULA = b.CODIGO
INNER JOIN SOPHIA.TURMAS d ON d.CODIGO = c.TURMA
INNER JOIN SOPHIA.DISCIPLINAS e ON e.CODIGO = c.DISCIPLINA
INNER JOIN SOPHIA.TURMAS g ON g.CODIGO = b.TURMA_REGULAR
LEFT JOIN SOPHIA.QC h ON h.TURMA = d.CODIGO AND h.DISCIPLINA = e.CODIGO
WHERE 
	(d.NOME LIKE '%DP/ADAP%' ) AND d.PERIODO = 128
GROUP BY
	e.CODIGO,
	d.NOME,
	d.CODIGO,
	--h.CH,
	LEFT(g.NOME, CHARINDEX(' ', g.NOME)),
	e.NOME_RESUM,
	e.NOME,
	d.PERIODO,
	d.ESTADO
ORDER BY e.NOME, LTRIM(RTRIM(LEFT(g.NOME, CHARINDEX(' ', g.NOME))))


SELECT * FROM SOPHIA.TURMAS WHERE PERIODO = 128 AND NOME LIKE '%[_]DP/ADAP%'


--------------------------------------------------------------
------------------- MIGRAR ALUNOS ----------------------------
--------------------------------------------------------------

SELECT c.* FROM SophiA.FISICA a
INNER JOIN SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
INNER JOIN SOPHIA.ACADEMIC c ON c.MATRICULA = b.CODIGO
WHERE STATUS = 0 AND a.CODEXT = '1510691'

SELECT * FROM SOPHIA.TURMAS WHERE CODIGO in (3662,
3696,
3701)

SELECT 
	a.CODEXT,
	a.NOME,
	d.PERIODO,
	g.NOME AS TURMAS_REGULAR,
	c.CODIGO AS ACADEMIC, 
	d.CODIGO AS CODTURMA,
	d.NOME AS TURMA, 
	e.NOME AS DISCIPLINA,
	f.CODIGO,
	f.NOME,
	f.DISCIPLINA,
	f.DESDISCIPLINA
FROM SOPHIA.FISICA a
INNER JOIN SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
INNER JOIN SophiA.ACADEMIC c ON c.MATRICULA = b.CODIGO
INNER JOIN SOPHIA.TURMAS d ON d.CODIGO = c.TURMA
INNER JOIN SOPHIA.DISCIPLINAS e ON e.CODIGO = c.DISCIPLINA
INNER JOIN SOPHIA.TURMAS g ON g.CODIGO = b.TURMA_REGULAR
LEFT JOIN (
	SELECT aa.CODIGO, aa.NOME, bb.DISCIPLINA, cc.NOME AS DESDISCIPLINA FROM SOPHIA.TURMAS aa
	INNER JOIN SOPHIA.QC bb ON bb.TURMA = aa.CODIGO
	INNER JOIN SOPHIA.DISCIPLINAS cc ON cc.CODIGO = bb.DISCIPLINA
	WHERE PERIODO = 128
)  f ON f.NOME = '_DP/ADAP - ' + e.NOME_RESUM + ' - ' + LTRIM(RTRIM(LEFT(g.NOME, CHARINDEX(' ', g.NOME))))
WHERE 
	(d.NOME LIKE 'DP/ADAP%' OR d.NOME LIKE 'DP/ADP%' OR d.NOME LIKE 'DP/ADPA%' ) AND d.PERIODO = 128 AND a.CODEXT = '1200610'
GROUP BY
	a.CODEXT,
	a.NOME,
	c.CODIGO, 
	d.CODIGO,
	g.NOME,
	d.NOME, 
	e.NOME,
	d.PERIODO,
	f.CODIGO,
	f.NOME,
	f.DISCIPLINA,
	f.DESDISCIPLINA
ORDER BY a.NOME	

----------------------------- UPDATE -----------------------------------------------
-- Migrar os alunos das turmas erradas para as certas

BEGIN TRAN
UPDATE SOPHIA.ACADEMIC
	SET 
		TURMA = f.CODIGO,
		DISCIPLINA = f.DISCIPLINA
FROM SOPHIA.FISICA a
INNER JOIN SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
INNER JOIN SophiA.ACADEMIC c ON c.MATRICULA = b.CODIGO
INNER JOIN SOPHIA.TURMAS d ON d.CODIGO = c.TURMA
INNER JOIN SOPHIA.DISCIPLINAS e ON e.CODIGO = c.DISCIPLINA
INNER JOIN SOPHIA.TURMAS g ON g.CODIGO = b.TURMA_REGULAR
LEFT JOIN (
	SELECT aa.CODIGO, aa.NOME, bb.DISCIPLINA, cc.NOME AS DESDISCIPLINA FROM SOPHIA.TURMAS aa
	INNER JOIN SOPHIA.QC bb ON bb.TURMA = aa.CODIGO
	INNER JOIN SOPHIA.DISCIPLINAS cc ON cc.CODIGO = bb.DISCIPLINA
	WHERE PERIODO = 128
)  f ON f.NOME = '_DP/ADAP - ' + e.NOME_RESUM + ' - ' + LTRIM(RTRIM(LEFT(g.NOME, CHARINDEX(' ', g.NOME))))
WHERE 
	(d.NOME LIKE 'DP/ADAP%' OR d.NOME LIKE 'DP/ADP%' OR d.NOME LIKE 'DP/ADPA%' ) AND d.PERIODO = 128 AND a.CODEXT = '1200610'

COMMIT


--------------------------------------------------------------
-- Arrumar os nomes das turmas de DP/ADAP
SELECT 
	NOME,
	REPLACE(NOME, '_', '' ) 
--UPDATE SOPHIA.TURMAS
--SET NOME = REPLACE(NOME, '_', '' ) 
FROM SONATA.SOPHIA.SOPHIA.TURMAS
WHERE PERIODO = 128 AND NOME LIKE '[_]%'
--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------
-- Verificar se tem alguma ata de nota criada 
SELECT * FROM SOPHIA.ATA_NOTA a
INNER JOIN SophiA.TURMAS d ON d.CODIGO = a.TURMA
WHERE
	(d.NOME LIKE '%DP/ADAP%' OR d.NOME LIKE '%DP/ADP%' OR d.NOME LIKE '%DP/ADPA%' ) AND d.PERIODO = 128 
---------------------------------------------------------------------------------------------------------	
-- Verificar se tem alguma lista de chamada
SELECT * FROM SophiA.LISTA_CHAM a
INNER JOIN SophiA.TURMAS d ON d.CODIGO = a.TURMA
WHERE
	(d.NOME LIKE '%DP/ADAP%' OR d.NOME LIKE '%DP/ADP%' OR d.NOME LIKE '%DP/ADPA%' ) AND d.PERIODO = 128
---------------------------------------------------------------------------------------------------------	
-- Verificar se tem algum quadro curricular
SELECT * FROM SophiA.QC a
INNER JOIN SophiA.TURMAS d ON d.CODIGO = a.TURMA
WHERE
	(d.NOME LIKE '%[_]DP/ADAP%' ) AND d.PERIODO = 128
---------------------------------------------------------------------------------------------------------
-- Listar as disciplinas de DP/ADAP com o nome da disciplina
SELECT a.CODIGO, a.NOME, a.NOME_RESUM, b.* FROM SOPHIA.DISCIPLINAS a
INNER JOIN (

	SELECT LTRIM(RTRIM(bb.id)) as id,aa.* FROM SOPHIA.TURMAS aa
	CROSS APPLY dbo.fnSplit(aa.nome, '-') bb
	WHERE (bb.Id NOT LIKE '%DP/ADAP%' OR bb.Id NOT LIKE '%DP/ADP%' OR bb.Id NOT LIKE '%DP/ADPA%' ) AND aa.PERIODO = 128
) b ON b.id = a.NOME_RESUM AND a.NOME_RESUM <> ''
---------------------------------------------------------------------------------------------------------
SELECT b.NOME AS TURMA, a.* FROM SOPHIA.ACADEMIC a
INNER JOIN SOPHIA.TURMAS b ON b.CODIGO = a.TURMA
WHERE b.PERIODO = 128 AND b.NOME LIKE '%DP/ADAP%'

---------------------------------------------------------------------------------------------------------
-- Listar alunos das turmas de DP/ADA
SELECT 
	d.NOME AS TURMA, 
	h.NOME_RESUM AS CURSO,
	e.NOME AS DISCIPLINA,
	a.CODEXT,
	a.NOME
FROM SOPHIA.FISICA a
INNER JOIN SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
INNER JOIN SophiA.ACADEMIC c ON c.MATRICULA = b.CODIGO
INNER JOIN SOPHIA.TURMAS d ON d.CODIGO = c.TURMA
INNER JOIN SOPHIA.DISCIPLINAS e ON e.CODIGO = c.DISCIPLINA
INNER JOIN SOPHIA.TURMAS g ON g.CODIGO = b.TURMA_REGULAR
LEFT JOIN (
	SELECT aa.CODIGO, aa.NOME, bb.DISCIPLINA, cc.NOME AS DESDISCIPLINA FROM SOPHIA.TURMAS aa
	INNER JOIN SOPHIA.QC bb ON bb.TURMA = aa.CODIGO
	INNER JOIN SOPHIA.DISCIPLINAS cc ON cc.CODIGO = bb.DISCIPLINA
	WHERE PERIODO = 128
)  f ON f.NOME = '_DP/ADAP - ' + e.NOME_RESUM + ' - ' + LTRIM(RTRIM(LEFT(g.NOME, CHARINDEX(' ', g.NOME))))
INNER JOIN SOPHIA.CURSOS h ON h.PRODUTO = g.CURSO
WHERE 
	(d.NOME LIKE '_DP/ADAP%' OR d.NOME LIKE '_DP/ADP%' OR d.NOME LIKE '_DP/ADPA%' ) AND d.PERIODO = 128-- AND a.CODEXT = '1510198'
GROUP BY
	a.CODEXT,
	a.NOME,
	h.NOME_RESUM,
	d.NOME,
	e.NOME
ORDER BY 
	d.NOME,
	e.NOME,
	h.NOME_RESUM,
	a.NOME	
---------------------------------------------------------------------------------------------------------
-- Listar alunos de DP
SELECT 
	d.NOME AS TURMA, 
	e.NOME AS DISCIPLINA,
	a.CODEXT,
	a.NOME,
	h.destipomatr AS TIPO
FROM SOPHIA.FISICA a
INNER JOIN SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
INNER JOIN SophiA.ACADEMIC c ON c.MATRICULA = b.CODIGO
INNER JOIN SOPHIA.TURMAS d ON d.CODIGO = c.TURMA
INNER JOIN SOPHIA.DISCIPLINAS e ON e.CODIGO = c.DISCIPLINA
INNER JOIN SOPHIA.TURMAS g ON g.CODIGO = b.TURMA_REGULAR
INNER JOIN dbo.tb_academic_tipomatr h ON h.idtipomatr = c.TIPO_MATR
WHERE 
	h.idtipomatr in (7,6,2,3) AND 
	d.PERIODO = 128 AND-- AND a.CODEXT = '1510198'
	d.TURNO NOT in(6,7) AND
	d.CFG_ACAD = 1
GROUP BY
	a.CODEXT,
	a.NOME,
	d.NOME,
	e.NOME,
	h.destipomatr
ORDER BY 
	d.NOME,
	e.NOME,
	a.NOME	

SELECT * FROM dbo.tb_academic_tipomatr
SELECT * FROM SOPHIA.TURNOS
6, 7
---------------------------------------------------------------------------------------------------------
SELECT LEFT('BD 4A', CHARINDEX(' ', 'BD 4A'))

SELECT CHARINDEX(' ', 'BD 4A')

SELECT LEFT('BD 4A', 3)


SELECT * FROM SOPHIA.TURMAS WHERE NOME LIKE '%DP/ADAP%' AND PERIODO in (127, 128)
SELECT * FROM SOPHIA.CURSOS
SELECT * FROM SOPHIA.DISCIPLINAS
SELECT * FROM SOPHIA.TURMAS WHERE CODIGO in( 2914, 2918)

SELECT 
	a.CODEXT,
	a.NOME,
	c.CODIGO AS ACADEMIC, 
	d.NOME AS TURMA, 
	e.NOME AS DISCIPLINA,
	d.PERIODO
FROM SOPHIA.FISICA a
INNER JOIN SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
INNER JOIN SophiA.ACADEMIC c ON c.MATRICULA = b.CODIGO
INNER JOIN SOPHIA.TURMAS d ON d.CODIGO = c.TURMA
INNER JOIN SOPHIA.DISCIPLINAS e ON e.CODIGO = c.DISCIPLINA
WHERE 
	(d.NOME LIKE '%DP/ADAP%' OR d.NOME LIKE '%DP/ADP%' OR d.NOME LIKE '%DP/ADPA%' ) AND d.PERIODO = 128
GROUP BY
	a.CODEXT,
	a.NOME,
	c.CODIGO, 
	d.NOME, 
	e.NOME,
	d.PERIODO
ORDER BY a.NOME
---------------------------------------------------------------------------------------------------------

SELECT 
'(''' + NOME + ''', ''' + NOME + ''', ''t''),' 
FROM SOPHIA.TURMAS
WHERE PERIODO = 128 AND NOME LIKE '%[_]DP/ADAP%'

SELECT * FROm SOPHIA.TURMAS WHERE CODIGO = 2893

SELECT * FROM SOPHIA.DISCIPLINAS WHERE NOME_RESUM LIKE 'SRIII%'
