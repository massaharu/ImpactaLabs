USE SOPHIA

SELECT * FROM SOPHIA.PERIODOS
-- 112 2013

SELECT * FROM sonata.sophia.SOPHIA.TURMAS 
WHERE PERIODO = 117 ORDE
-- 2246 MBA - GP_15 

SELECT * FROM SOPHIA.SERIE
WHERE CODIGO = 628

SELECT * FROM SOPHIA.CURRICULO --ORDER BY DESCRICAO
WHERE CODIGO = 242

SELECT B.NOME ,A.* FROM SOPHIA.GRADES A
INNER JOIN SOPHIA.DISCIPLINAS B ON A.DISCIPLINA = B.CODIGO
WHERE SERIE = 628

SELECT B.NOME ,A.* FROM SOPHIA.QC A
INNER JOIN SOPHIA.DISCIPLINAS B ON A.DISCIPLINA = B.CODIGO
WHERE TURMA = 2253

SELECT b.NOME, * FROM SOPHIA.CURRICULO a
INNER JOIN sophia.CURSOS b ON b.PRODUTO = a.CURSO
WHERE ATIVO = 1 ORDER BY DESCRICAO

SELECT * FROM sophia.AULAS_QH
SELECT * FROM sophia.HORARIO_TURMA
SELECT * FROM sophia.HORARIO_AULA WHERE disciplina = 241
SELECT * FROM sophia.QUADRO_HORARIO
SELECT * FROM sophia.CALEND_DIAS
SELECT * FROM sophia.CALEND_DIAS_TURMA
SELECT * FROM sophia.CALEND_ETAPAS
SELECT * FROM sophia.CALENDARIOS
SELECT * FROM sophia.CONFIG_WEB_CALENDARIO_EVENTO
SELECT * FROM sonata.sophia.sophia.PERIODOS
SELECT * FROM sonata.sophia.sophia.CURSOS

SELECT * FROM sophia.CFG_ACAD
SELECT * FROM sonata.sophia.sophia.TURMAS WHERE PERIODO = 120 ORDER BY NOME
SELECT * FROM sophia.ETAPAS
SELECT * FROM sonata.sophia.sophia.DISCIPLINAS ORDER BY NOME
SELECT * FROM sophia.SALAS ORDER BY DESCRICAO
SELECT * FROM sophia.PROF_AULA
SELECT * FROM sophia.FUNCIONARIOS
SELECT * FROM sophia.FISICA
SELECT * FROM sonata.sophia.sophia.CURSOS ORDER BY NOME 
SELECT * FROM sonata.sophia.sophia.ATEND_CURSOS WHERE TURMA = 2253
SELECT * FROM sonata.sophia.sophia.PRODUTOS
SELECT * FROM sonata.sophia.sophia.SERIE WHERE CODIGO = 644
SELECT * FROM sonata.sophia.sophia.NIVEL WHERE 

[sophia.CALENDARIOS]
[sophia.CALEND_DIAS]
[sophia.CALEND_DIAS_TURMA]
[sophia.TURMAS]
[sophia.CALEND_ETAPAS]
[sophia.CONFIG_WEB_CALENDARIO_EVENTO]
[sophia.QUADRO_HORARIO]
[sophia.HORARIO_AULA]
[sophia.PROF_AULA]
[sophia.FISICA]
[sophia.FUNCIONARIOS]
[sophia.CURSOS]
[sophia.ATEND_CURSOS]
[sophia.PRODUTOS]
[sophia.DISCIPLINAS]
[sophia.SERIE]
[sophia.CURRICULO]

DECLARE @COD_PERIODO int = 117, @PRODUTO int = 39, @COD_TURMA int = 2321
IF(@COD_TURMA IS NULL)
BEGIN
	SELECT DISTINCT	 
		a.CODIGO, 
		n.DESCRICAO as CURRICULO, 
		m.CODIGO AS COD_SEMESTRE, 
		m.DESCRICAO as SEMESTRE, 
		o.NOME as CURSO, 
		e.NOME as TURMA, 		
		e.CODIGO AS COD_TURMA,
		b.DESCRICAO, 
		a.PERIODO, 
		c.DESCRICAO, 
		c.INICIO, 
		c.TERMINO, 
		a.SEGUNDA,		
		a.TERCA, 
		a.QUARTA, 
		a.QUINTA,
		a.SEXTA, 
		a.SABADO, 
		a.DOMINGO, 
		g.dia_semana,
		m.ORDEM
	FROM sonata.sophia.sophia.CALENDARIOS a
	INNER JOIN sonata.sophia.sophia.CFG_ACAD b ON b.CODIGO = a.CFG_ACAD
	INNER JOIN sonata.sophia.sophia.PERIODOS c ON c.CODIGO = a.PERIODO
	INNER JOIN sonata.sophia.sophia.TURMAS e ON e.CFG_ACAD = b.CODIGO AND e.PERIODO = @COD_PERIODO AND CURSO = @PRODUTO
	INNER JOIN sonata.sophia.sophia.QUADRO_HORARIO f ON f.turma = e.CODIGO
	INNER JOIN sonata.sophia.sophia.HORARIO_AULA g ON g.cod_qh = f.codigo
	INNER JOIN sonata.sophia.sophia.SERIE m ON m.CODIGO = e.SERIE
	INNER JOIN sonata.sophia.sophia.CURRICULO n ON n.CODIGO = m.CURRICULO
	INNER JOIN sonata.sophia.sophia.CURSOS o ON o.PRODUTO = n.CURSO
	WHERE o.PRODUTO = @PRODUTO AND c.CODIGO = @COD_PERIODO --AND n.CODIGO = 242-- AND e.CODIGO = @COD_TURMA 
	ORDER BY m.ORDEM, g.dia_semana
END
ELSE
BEGIN
	SELECT DISTINCT
		a.CODIGO, 
		n.DESCRICAO as CURRICULO, 
		m.CODIGO AS COD_SEMESTRE, 
		m.DESCRICAO as SEMESTRE, 
		o.NOME as CURSO, 
		e.NOME as TURMA, 		
		e.CODIGO AS COD_TURMA,
		b.DESCRICAO, 
		a.PERIODO, 
		c.DESCRICAO, 
		c.INICIO, 
		c.TERMINO, 
		a.SEGUNDA,		
		a.TERCA, 
		a.QUARTA, 
		a.QUINTA,
		a.SEXTA, 
		a.SABADO, 
		a.DOMINGO, 
		g.dia_semana,
		m.ORDEM
	FROM sonata.sophia.sophia.CALENDARIOS a
	INNER JOIN sonata.sophia.sophia.CFG_ACAD b ON b.CODIGO = a.CFG_ACAD
	INNER JOIN sonata.sophia.sophia.PERIODOS c ON c.CODIGO = a.PERIODO
	INNER JOIN sonata.sophia.sophia.TURMAS e ON e.CFG_ACAD = b.CODIGO AND e.PERIODO = @COD_PERIODO AND CURSO = @PRODUTO
	INNER JOIN sonata.sophia.sophia.QUADRO_HORARIO f ON f.turma = e.CODIGO
	INNER JOIN sonata.sophia.sophia.HORARIO_AULA g ON g.cod_qh = f.codigo
	INNER JOIN sonata.sophia.sophia.DISCIPLINAS h ON h.CODIGO = g.disciplina
	LEFT JOIN sonata.sophia.sophia.SALAS i ON i.CODIGO = g.sala
	INNER JOIN sonata.sophia.sophia.PROF_AULA j ON j.cod_aula = g.cod_ha
	INNER JOIN sonata.sophia.sophia.FUNCIONARIOS k ON k.COD_FUNC = j.professor
	INNER JOIN sonata.sophia.sophia.FISICA l ON l.CODIGO = k.COD_FUNC
	INNER JOIN sonata.sophia.sophia.SERIE m ON m.CODIGO = e.SERIE
	INNER JOIN sonata.sophia.sophia.CURRICULO n ON n.CODIGO = m.CURRICULO
	INNER JOIN sonata.sophia.sophia.CURSOS o ON o.PRODUTO = n.CURSO
	WHERE o.PRODUTO = @PRODUTO AND c.CODIGO = @COD_PERIODO AND e.CODIGO = @COD_TURMA--AND n.CODIGO = 242-- AND e.CODIGO = @COD_TURMA 
	ORDER BY m.ORDEM, g.dia_semana
END
----
DECLARE @PERIODO int = 117, @PRODUTO int = 39
SELECT a.CODIGO, a.NOME as SIGLA, c.DESCRICAO, a.CURSO, a.SERIE, a.INICIO, a.TERMINO 
FROM sonata.sophia.sophia.TURMAS a
INNER JOIN sonata.sophia.sophia.QUADRO_HORARIO b ON b.turma = a.CODIGO
INNER JOIN sonata.sophia.sophia.SERIE c ON c.CODIGO = a.SERIE
WHERE a.PERIODO = @PERIODO AND a.CURSO = @PRODUTO 
ORDER BY c.ORDEM, a.NOME
--
2252 - 2453
DECLARE @COD_TURMA int = 2461, @COD_SEMESTRE int = 248, @DIA_SEMANA int = 3
SELECT 
	c.CODIGO	AS COD_TURMA,
	g.codigo	AS COD_DISCIPLINA,
	g.NOME		AS DISCIPLINA,
	k.CODIGO	AS COD_PROF,
	k.NOME		AS PROFESSOR,
	h.CODIGO	AS COD_SALA,
	h.DESCRICAO AS SALA,
	b.cod_ha,
	b.cod_qh,
	b.aula
FROM sonata.sophia.sophia.QUADRO_HORARIO a
INNER JOIN sonata.sophia.sophia.HORARIO_AULA b	ON b.cod_qh = a.codigo
INNER JOIN sonata.sophia.sophia.TURMAS c		ON c.CODIGO = a.turma
INNER JOIN sonata.sophia.sophia.SERIE d		ON d.CURSO = c.CURSO
INNER JOIN sonata.sophia.sophia.CURRICULO e	ON e.CODIGO = d.CURRICULO
INNER JOIN sonata.sophia.sophia.CURSOS f		ON f.PRODUTO = e.CURSO
INNER JOIN sonata.sophia.sophia.DISCIPLINAS g	ON g.CODIGO = b.disciplina
LEFT JOIN sonata.sophia.sophia.SALAS h			ON h.CODIGO = b.sala
LEFT JOIN sonata.sophia.sophia.PROF_AULA i	ON i.cod_aula = b.cod_ha
LEFT JOIN sonata.sophia.sophia.FUNCIONARIOS j	ON j.COD_FUNC = i.professor
LEFT JOIN sonata.sophia.sophia.FISICA k		ON k.CODIGO = j.COD_FUNC
WHERE c.CODIGO = @COD_TURMA AND d.CODIGO = @COD_SEMESTRE AND b.dia_semana = @DIA_SEMANA 
ORDER BY d.ORDEM, b.aula
---
DECLARE @COD_PERIODO int = 117, @PRODUTO int = 39, @COD_TURMA int = 2320
SELECT DISTINCT
	a.CODIGO, 
	n.DESCRICAO as CURRICULO, 
	m.CODIGO AS COD_SEMESTRE, 
	m.DESCRICAO as SEMESTRE, 
	o.NOME as CURSO, 
	e.NOME as TURMA, 		
	e.CODIGO AS COD_TURMA,
	b.DESCRICAO, 
	a.PERIODO, 
	c.DESCRICAO, 
	p.DATA,
	c.INICIO, 
	c.TERMINO, 
	a.SEGUNDA,		
	a.TERCA, 
	a.QUARTA, 
	a.QUINTA,
	a.SEXTA, 
	a.SABADO, 
	a.DOMINGO, 
	g.dia_semana,
	m.ORDEM
FROM sonata.sophia.sophia.CALENDARIOS a
INNER JOIN sonata.sophia.sophia.CFG_ACAD b ON b.CODIGO = a.CFG_ACAD
INNER JOIN sonata.sophia.sophia.PERIODOS c ON c.CODIGO = a.PERIODO
INNER JOIN sonata.sophia.sophia.TURMAS e ON e.CFG_ACAD = b.CODIGO AND e.PERIODO = @COD_PERIODO
INNER JOIN sonata.sophia.sophia.QUADRO_HORARIO f ON f.turma = e.CODIGO
INNER JOIN sonata.sophia.sophia.HORARIO_AULA g ON g.cod_qh = f.codigo
INNER JOIN sonata.sophia.sophia.DISCIPLINAS h ON h.CODIGO = g.disciplina
LEFT JOIN sonata.sophia.sophia.SALAS i ON i.CODIGO = g.sala
INNER JOIN sonata.sophia.sophia.PROF_AULA j ON j.cod_aula = g.cod_ha
INNER JOIN sonata.sophia.sophia.FUNCIONARIOS k ON k.COD_FUNC = j.professor
INNER JOIN sonata.sophia.sophia.FISICA l ON l.CODIGO = k.COD_FUNC
INNER JOIN sonata.sophia.sophia.SERIE m ON m.CODIGO = e.SERIE
INNER JOIN sonata.sophia.sophia.CURRICULO n ON n.CODIGO = m.CURRICULO
INNER JOIN sonata.sophia.sophia.CURSOS o ON o.PRODUTO = n.CURSO
LEFT JOIN sonata.sophia.sophia.PLANEJAMENTO_AULAS p ON p.COD_HA = g.cod_ha
WHERE c.CODIGO = @COD_PERIODO AND e.CODIGO = @COD_TURMA--AND n.CODIGO = 242-- AND e.CODIGO = @COD_TURMA 
ORDER BY e.CODIGO, p.DATA, m.ORDEM, g.dia_semana
------------------------------------------------------------------------
---------------------- PROCEDURES -------------------------------------
------------------------------------------------------------------------
USE FIT_NEW

sp_quadro_horario_list 117, 39, 2321

ALTER PROC sp_quadro_horario_list 
( @COD_PERIODO int, @PRODUTO int, @COD_TURMA int = NULL)
AS
/*
  app: FIT
  url:..aluno/quadro-horario.php
  author: Massaharu
  date: 1/02/2014
*/
BEGIN
	IF(@COD_TURMA IS NULL)
	BEGIN
		SELECT DISTINCT	 
			a.CODIGO, 
			n.DESCRICAO as CURRICULO, 
			m.CODIGO AS COD_SEMESTRE, 
			m.DESCRICAO as SEMESTRE, 
			o.NOME as CURSO, 
			e.NOME as TURMA, 		
			e.CODIGO AS COD_TURMA,
			b.DESCRICAO, 
			a.PERIODO, 
			c.DESCRICAO, 
			c.INICIO, 
			c.TERMINO, 
			a.SEGUNDA,		
			a.TERCA, 
			a.QUARTA, 
			a.QUINTA,
			a.SEXTA, 
			a.SABADO, 
			a.DOMINGO, 
			g.dia_semana,
			m.ORDEM
		FROM sonata.sophia.sophia.CALENDARIOS a
		INNER JOIN sonata.sophia.sophia.CFG_ACAD b ON b.CODIGO = a.CFG_ACAD
		INNER JOIN sonata.sophia.sophia.PERIODOS c ON c.CODIGO = a.PERIODO
		INNER JOIN sonata.sophia.sophia.TURMAS e ON e.CFG_ACAD = b.CODIGO AND e.PERIODO = @COD_PERIODO AND CURSO = @PRODUTO
		INNER JOIN sonata.sophia.sophia.QUADRO_HORARIO f ON f.turma = e.CODIGO
		INNER JOIN sonata.sophia.sophia.HORARIO_AULA g ON g.cod_qh = f.codigo
		INNER JOIN sonata.sophia.sophia.SERIE m ON m.CODIGO = e.SERIE
		INNER JOIN sonata.sophia.sophia.CURRICULO n ON n.CODIGO = m.CURRICULO
		INNER JOIN sonata.sophia.sophia.CURSOS o ON o.PRODUTO = n.CURSO
		WHERE o.PRODUTO = @PRODUTO AND c.CODIGO = @COD_PERIODO --AND n.CODIGO = 242-- AND e.CODIGO = @COD_TURMA 
		ORDER BY m.ORDEM, g.dia_semana
	END
	ELSE
	BEGIN
		SELECT DISTINCT
			a.CODIGO, 
			n.DESCRICAO as CURRICULO, 
			m.CODIGO AS COD_SEMESTRE, 
			m.DESCRICAO as SEMESTRE, 
			o.NOME as CURSO, 
			e.NOME as TURMA, 		
			e.CODIGO AS COD_TURMA,
			b.DESCRICAO, 
			a.PERIODO, 
			c.DESCRICAO, 
			c.INICIO, 
			c.TERMINO, 
			a.SEGUNDA,		
			a.TERCA, 
			a.QUARTA, 
			a.QUINTA,
			a.SEXTA, 
			a.SABADO, 
			a.DOMINGO, 
			g.dia_semana,
			m.ORDEM
		FROM sonata.sophia.sophia.CALENDARIOS a
		INNER JOIN sonata.sophia.sophia.CFG_ACAD b ON b.CODIGO = a.CFG_ACAD
		INNER JOIN sonata.sophia.sophia.PERIODOS c ON c.CODIGO = a.PERIODO
		INNER JOIN sonata.sophia.sophia.TURMAS e ON e.CFG_ACAD = b.CODIGO AND e.PERIODO = @COD_PERIODO AND CURSO = @PRODUTO
		INNER JOIN sonata.sophia.sophia.QUADRO_HORARIO f ON f.turma = e.CODIGO
		INNER JOIN sonata.sophia.sophia.HORARIO_AULA g ON g.cod_qh = f.codigo
		INNER JOIN sonata.sophia.sophia.DISCIPLINAS h ON h.CODIGO = g.disciplina
		LEFT JOIN sonata.sophia.sophia.SALAS i ON i.CODIGO = g.sala
		INNER JOIN sonata.sophia.sophia.PROF_AULA j ON j.cod_aula = g.cod_ha
		INNER JOIN sonata.sophia.sophia.FUNCIONARIOS k ON k.COD_FUNC = j.professor
		INNER JOIN sonata.sophia.sophia.FISICA l ON l.CODIGO = k.COD_FUNC
		INNER JOIN sonata.sophia.sophia.SERIE m ON m.CODIGO = e.SERIE
		INNER JOIN sonata.sophia.sophia.CURRICULO n ON n.CODIGO = m.CURRICULO
		INNER JOIN sonata.sophia.sophia.CURSOS o ON o.PRODUTO = n.CURSO
		WHERE o.PRODUTO = @PRODUTO AND c.CODIGO = @COD_PERIODO AND e.CODIGO = @COD_TURMA--AND n.CODIGO = 242-- AND e.CODIGO = @COD_TURMA 
		ORDER BY d.ORDEM, b.dia_semana
	END
END
--------------------------------------------------------------------------------
sp_turmasbycurso_list 117, 39
ALTER PROC sp_turmasbycurso_list 
(@PERIODO int, @PRODUTO int)
AS
/*
  app: FIT
  url:..aluno/quadro-horario.php
  author: Massaharu
  date: 1/02/2014
*/
BEGIN
	SELECT a.CODIGO, a.NOME as SIGLA, c.DESCRICAO, a.CURSO, a.SERIE, a.INICIO, a.TERMINO 
	FROM sonata.sophia.sophia.TURMAS a
	INNER JOIN sonata.sophia.sophia.QUADRO_HORARIO b ON b.turma = a.CODIGO
	INNER JOIN sonata.sophia.sophia.SERIE c ON c.CODIGO = a.SERIE
	WHERE a.PERIODO = @PERIODO AND a.CURSO = @PRODUTO 
	ORDER BY c.ORDEM, a.NOME
END
--------------------------------------------------------------------------------
sp_aulasbysemestre_list 2321, 265, 1
ALTER PROC sp_aulasbysemestre_list
(@COD_TURMA int, @COD_SEMESTRE int, @DIA_SEMANA int, @AULA int  = NULL)
AS
/*
  app: FIT
  url:..aluno/quadro-horario.php
  author: Massaharu
  date: 1/02/2014
*/
BEGIN
	IF(@AULA IS NULL)
	BEGIN
		SELECT 
			c.CODIGO	AS COD_TURMA,
			g.codigo	AS COD_DISCIPLINA,
			g.NOME		AS DISCIPLINA,
			k.CODIGO	AS COD_PROF,
			k.NOME		AS PROFESSOR,
			h.CODIGO	AS COD_SALA,
			h.DESCRICAO AS SALA,
			b.cod_ha,
			b.cod_qh,
			b.aula
		FROM sonata.sophia.sophia.QUADRO_HORARIO a
		INNER JOIN sonata.sophia.sophia.HORARIO_AULA b	ON b.cod_qh = a.codigo
		INNER JOIN sonata.sophia.sophia.TURMAS c		ON c.CODIGO = a.turma
		INNER JOIN sonata.sophia.sophia.SERIE d		ON d.CURSO = c.CURSO
		INNER JOIN sonata.sophia.sophia.CURRICULO e	ON e.CODIGO = d.CURRICULO
		INNER JOIN sonata.sophia.sophia.CURSOS f		ON f.PRODUTO = e.CURSO
		INNER JOIN sonata.sophia.sophia.DISCIPLINAS g	ON g.CODIGO = b.disciplina
		LEFT JOIN sonata.sophia.sophia.SALAS h			ON h.CODIGO = b.sala
		LEFT JOIN sonata.sophia.sophia.PROF_AULA i	ON i.cod_aula = b.cod_ha
		LEFT JOIN sonata.sophia.sophia.FUNCIONARIOS j	ON j.COD_FUNC = i.professor
		LEFT JOIN sonata.sophia.sophia.FISICA k		ON k.CODIGO = j.COD_FUNC
		WHERE c.CODIGO = @COD_TURMA AND d.CODIGO = @COD_SEMESTRE AND b.dia_semana = @DIA_SEMANA 
		ORDER BY d.ORDEM, b.aula
	END
	ELSE
	BEGIN
		SELECT 
			c.CODIGO	AS COD_TURMA,
			g.codigo	AS COD_DISCIPLINA,
			g.NOME		AS DISCIPLINA,
			k.CODIGO	AS COD_PROF,
			k.NOME		AS PROFESSOR,
			h.CODIGO	AS COD_SALA,
			h.DESCRICAO AS SALA,
			b.cod_ha,
			b.cod_qh,
			b.aula
		FROM sonata.sophia.sophia.QUADRO_HORARIO a
		INNER JOIN sonata.sophia.sophia.HORARIO_AULA b	ON b.cod_qh = a.codigo
		INNER JOIN sonata.sophia.sophia.TURMAS c		ON c.CODIGO = a.turma
		INNER JOIN sonata.sophia.sophia.SERIE d		ON d.CURSO = c.CURSO
		INNER JOIN sonata.sophia.sophia.CURRICULO e	ON e.CODIGO = d.CURRICULO
		INNER JOIN sonata.sophia.sophia.CURSOS f		ON f.PRODUTO = e.CURSO
		INNER JOIN sonata.sophia.sophia.DISCIPLINAS g	ON g.CODIGO = b.disciplina
		LEFT JOIN sonata.sophia.sophia.SALAS h			ON h.CODIGO = b.sala
		LEFT JOIN sonata.sophia.sophia.PROF_AULA i	ON i.cod_aula = b.cod_ha
		LEFT JOIN sonata.sophia.sophia.FUNCIONARIOS j	ON j.COD_FUNC = i.professor
		LEFT JOIN sonata.sophia.sophia.FISICA k		ON k.CODIGO = j.COD_FUNC
		WHERE c.CODIGO = @COD_TURMA AND d.CODIGO = @COD_SEMESTRE AND b.dia_semana = @DIA_SEMANA AND b.aula = @AULA
		ORDER BY d.ORDEM, b.aula
	END
END
--------------------------------------------------------------------------------
sp_quadro_horario_dias_list 120, 2461
ALTER PROC sp_quadro_horario_dias_list --120, 2461
(@COD_PERIODO int, @COD_TURMA int)
AS
/*
  app: FIT
  url:..aluno/quadro-horario.php
  author: Massaharu
  date: 1/02/2014
*/
BEGIN
	SELECT DISTINCT
		a.CODIGO, 
		n.DESCRICAO as CURRICULO, 
		m.CODIGO AS COD_SEMESTRE, 
		m.DESCRICAO as SEMESTRE, 
		o.NOME as CURSO, 
		e.NOME as TURMA, 		
		e.CODIGO AS COD_TURMA,
		b.DESCRICAO, 
		a.PERIODO, 
		c.DESCRICAO, 
		p.DATA,
		c.INICIO, 
		c.TERMINO, 
		a.SEGUNDA,		
		a.TERCA, 
		a.QUARTA, 
		a.QUINTA,
		a.SEXTA, 
		a.SABADO, 
		a.DOMINGO, 
		g.dia_semana,
		m.ORDEM
	FROM sonata.sophia.sophia.CALENDARIOS a
	INNER JOIN sonata.sophia.sophia.CFG_ACAD b ON b.CODIGO = a.CFG_ACAD
	INNER JOIN sonata.sophia.sophia.PERIODOS c ON c.CODIGO = a.PERIODO
	INNER JOIN sonata.sophia.sophia.TURMAS e ON e.CFG_ACAD = b.CODIGO AND e.PERIODO = @COD_PERIODO
	INNER JOIN sonata.sophia.sophia.QUADRO_HORARIO f ON f.turma = e.CODIGO
	INNER JOIN sonata.sophia.sophia.HORARIO_AULA g ON g.cod_qh = f.codigo
	INNER JOIN sonata.sophia.sophia.DISCIPLINAS h ON h.CODIGO = g.disciplina
	LEFT JOIN sonata.sophia.sophia.SALAS i ON i.CODIGO = g.sala
	INNER JOIN sonata.sophia.sophia.PROF_AULA j ON j.cod_aula = g.cod_ha
	INNER JOIN sonata.sophia.sophia.FUNCIONARIOS k ON k.COD_FUNC = j.professor
	INNER JOIN sonata.sophia.sophia.FISICA l ON l.CODIGO = k.COD_FUNC
	INNER JOIN sonata.sophia.sophia.SERIE m ON m.CODIGO = e.SERIE
	INNER JOIN sonata.sophia.sophia.CURRICULO n ON n.CODIGO = m.CURRICULO
	INNER JOIN sonata.sophia.sophia.CURSOS o ON o.PRODUTO = n.CURSO
	INNER JOIN sonata.sophia.sophia.PLANEJAMENTO_AULAS p ON p.COD_HA = g.cod_ha
	WHERE c.CODIGO = @COD_PERIODO AND e.CODIGO = @COD_TURMA--AND n.CODIGO = 242-- AND e.CODIGO = @COD_TURMA 
	ORDER BY p.DATA, m.ORDEM, g.dia_semana
END
--------------------------------------------------------------------------------
sp_cursos_graduacao_tecnologo_list '2,1', '72, 24'
ALTER PROC sp_cursos_graduacao_tecnologo_list 
(@idnivel varchar(50), @COD_PRODUTO varchar(50) = NULL)
AS
/*
  app: FIT
  url:..aluno/quadro-horario.php
  author: Massaharu
  date: 1/02/2014
*/
BEGIN
	SELECT 
		a.PRODUTO
		,a.NOME
		,a.NOME_RESUM
		,a.PROX_CURSO
		,a.ANT_CURSO
		,a.AREA
		,a.PERIODICIDADE
		,a.COORDENADOR
		,a.RESPONSAVEL
		,a.DURACAO_MIN
		,a.DURACAO_MAX
		,a.QTDE_ETAPAS
		,a.QTDE_CREDITOS_OBR
		,a.QTDE_CREDITOS_ELE
		,a.QTDE_CREDITOS_OPT
		,a.HORAS_ESTAGIO
		,a.HORAS_LAB
		,a.MODELO_CERTIFICADO
		,a.MONOGRAFIA
		,a.TEM_CURSO_ADMISSAO
		,a.HIST_MODELO
		,a.MAX_TRANCAMENTOS
		,a.NIVEL
		,a.USA_CURRICULO
		,a.CURR_DIF_TURNO
		,a.DIVISAO
		,a.USA_TESE
		,a.CONT_CREDITOS
		,a.EXA_LINGUA
		,a.EXA_QUALIFICACAO
		,a.USA_AVAL_COMPET
		,a.CODIGO_EXTERNO
		,a.curr_base
		,a.titulo_feminino2 
		,b.CODIGO
		,b.DESCRICAO
		,b.TIPO
	FROM sonata.sophia.sophia.CURSOS a
	INNER JOIN sonata.sophia.sophia.NIVEL b ON b.CODIGO = a.NIVEL
	WHERE b.CODIGO IN (SELECT id FROM Simpac.dbo.fnSplit(@idnivel, ',')) AND
		a.PRODUTO NOT IN (SELECT id FROM Simpac.dbo.fnSplit(@COD_PRODUTO, ','))
END

SELECT *FROM Simpac.dbo.fnSplit('1, 2', ',')
--------------------------------------------------------------------------------
--------------------------------------------------------------------------------


Select  from sonata.sophia.sophia.fisica

sp_turmasbycurso_list 120, 39

SELECT * FROM sonata.sophia.sophia.PLANEJAMENTO_AULAS
WHERE TURMA = 2450

sonata.sophia.sys.sp_help N'sophia.turmas'
sonata.sophia.sys.sp_help N'sophia.produtos'
sonata.sophia.sys.sp_help N'sophia.cursos'

select * from tb_cursos
