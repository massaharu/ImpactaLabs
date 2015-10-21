select * from sophia.TURMAS
where NOME like '%cdt%'
--código - 2350(Turma criada para Teste)

--------------------------------------------Lista de chamadas------------------------------------------------

/*Nesta tabela ficam armazenadas as listas de chamada criadas com suas 
informações(turma, disciplina, data das aulas, qtde das aulas, sala, situação e etc)*/

--campos da tabela:
	--situação:
		--0 -> Gerada
		--4 -> Processada

	--tipo_proc:
		--1(normal)
		--2(Falta coletiva)
		--4(Presença coletiva)

select * from sophia.LISTA_CHAM
where TURMA = 2457 AND DISCIPLINA = 23 AND ETAPA = 1

select * from sophia.LISTA_CHAM --WHERE CODIGO = 114259
where TURMA = 2350 and DISCIPLINA = 400

select * from sophia.LISTA_CHAM_WEB
where TURMA = 2350 and DISCIPLINA = 400

select * from sophia.TURMAS
where PERIODO = 117 and NOME like '%RC 1A%'

select * from sophia.DISCIPLINAS
where NOME like '%Introdução a Redes de Computadores%'

SELECT * FROM [SONATA.SOPHIA.SOPHIA.LISTA_CHAM]
---------------------------------------------------------------------------------------------------------

/*Nesta tabela ficam armazenadas a quantidade de aulas de cada lista, gerando um código para cada aula*/

select * from sophia.LISTA_CHAM_AULAS
where LISTA = 114259

select * from sophia.LISTA_CHAM_AULAS
where LISTA = 86324

select * from sophia.LISTA_CHAM_AULAS
where AULA = 

-------------------------------------------------------------------------------------------------------
/*Nesta tabela ficam armazenados o(s) professor(es) de cada lista*/

select * from sophia.LISTA_CHAM_PROF
where LISTA = 87324

/*Nesta tabela ficam armazenados todos os alunos e funcionários, pelo código consegue saber qual é o professor */

select * from sophia.FISICA
where CODIGO = 18777

-----------------------------------------------------------------------------------------------------------

/*Nesta tabela onde são salvas as faltas dos alunos, cada falta é vinculada a uma aula, 
sendo que uma lista pode ter até 4 aulas, as faltas são vinculadas a matrícula do aluno*/

select * from sophia.LISTA_CHAM_ALUNOS WHERE AULA  = 345588


select * from sophia.LISTA_CHAM_ALUNOS
where MATRICULA = 31407

select * from sophia.LISTA_CHAM_ALUNOS
where AULA in(269259,269260,269261,269262)

/*Nesta tabela retorna as informações do aluno ou funcionário*/
select * from sophia.FISICA
where NOME like '%rulio%'

/*Nesta tabela com o código do aluno, retorna a matrícula*/
select * from sophia.MATRICULA
where FISICA = 23500


---------------------------------TESTES-------------------------------------------

select * from sophia.LISTA_CHAM_WEB
where TURMA = 2343 and DISCIPLINA = 1152
--where TURMA = 2350

select * from sophia.LISTA_CHAM
where TURMA = 2343 and DISCIPLINA = 1152

select * from sophia.DISCIPLINAS
where CODIGO = 1152

select * from sophia.LISTA_CHAM_AULAS_WEB
where LISTA = 87266

select * from sophia.LISTA_CHAM_ALUNOS_WEB
where AULA in(269096,269097,269098,269099)




------------------------------TESTES------------------------------------------------------

select a.* from sophia.LISTA_CHAM a
inner join sophia.LISTA_CHAM_AULAS b on a.CODIGO = b.LISTA
inner join sophia.LISTA_CHAM_PROF c on a.CODIGO = c.LISTA
where a.TURMA = 2350 and a.DISCIPLINA = 6
--inner join sophia.LISTA_CHAM_ALUNOS d on 


select * from sophia.DISCIPLINAS
where NOME like '%Administração de conflitos%'
--6

select * from sophia.qc

select * from sophia.ETAPAS

select * from sophia.CALENDARIOS WHERE PERIODO = 117 


select b.NOME, a.*, b.* from sophia.CALEND_ETAPAS a
INNER JOIN sophia.ETAPAS b
ON a.ETAPA = b.CODIGO
WHERE CALENDARIO = 188


select * from [sophia.LISTA_CHAM ]
where TURMA = 2350 and DISCIPLINA = 6


select * from sophia.LISTA_CHAM_PROF

select * from sophia.LISTA_CHAM_AULAS 
where LISTA = 87320

select * from sophia.LISTA_CHAM_ALUNOS
where AULA in(269243,269244,269245,269246)


select * from sophia.DISCIPLINAS
where CODIGO in(6
,400
,669
,669
,1438)
----------------------------------------------------------------------------------
----------------------------------------- TABELAS --------------------------------
----------------------------------------------------------------------------------
CREATE TABLE sophia.LISTA_CHAM_LOG(
	idlog int identity CONSTRAINT PK_LISTA_CHAM_LOG primary key,
	CODIGO int,
	SITUACAO smallint,
	TIPO_PROC smallint,
	dtcadastro datetime CONSTRAINT DF_LISTA_CHAM_LOG_dtcadastro DEFAULT (getdate())
	
	ALTER TABLE sophia.LISTA_CHAM_LOG ADD
	INRETIFICADO bit CONSTRAINT DF_LISTA_CHAM_LOG_INRETIFICADO DEFAULT (0)
	
	ALTER TABLE sophia.LISTA_CHAM_LOG ADD
	DESMOTIVORETIFICACAO varchar(1000)
	
)
--FIT_NEW
CREATE TABLE tb_lista_cham_log(
	idlog int identity CONSTRAINT PK_LISTA_CHAM_LOG primary key,
	CODIGO int,
	SITUACAO smallint,
	TIPO_PROC smallint,
	dtcadastro datetime CONSTRAINT DF_LISTA_CHAM_LOG_dtcadastro DEFAULT (getdate())
)

SELECT * FROM saturn.FIT_NEW.dbo.tb_lista_cham_log
SELECT * FROM SOPHIA.LISTA_CHAM_LOG
----------------------------------------------------------------------------------
----------------------------------------------------------------------------------
------------------------------------PROCEDURES------------------------------------

sp_turmas_professor_list 4170,'2013/2,2013'
-- FIT_NEW
ALTER proc [dbo].[sp_turmas_professor_list]
(@codprofessor int, @desperido varchar(22) = null)
AS
/*
	url: fit/professor/json/list_turmas_prof.php,
	data: 26/03/2014
	author: Massaharu
	obs:
		COLUNA ESTADO:
			FORMAÇÃO = 0
			VIGENTE = 1
			ENCERRADO = 2
*/
BEGIN
	IF(@codprofessor != 0)
	BEGIN
		select 
			b.CODIGO as IDTURMA, 
			b.NOME as TURMA, 
			c.CODIGO as IDDISCIPLINA, 
			c.NOME as DISCIPLINA,
			b.CFG_ACAD,
			d.DESCRICAO as PERIODO,
			CASE 
				WHEN f.instatus = 0 THEN 0
				WHEN f.instatus = 1 THEN 
					CASE 
						WHEN f.id_cod_turma IS NULL THEN 0
						WHEN f.id_cod_turma IS NOT NULL THEN 1
					END
			END AS INPAI,
			f.notapaipeso 
		from sonata.sophia.sophia.QC a
		inner join sonata.sophia.sophia.TURMAS b on a.TURMA = b.CODIGO
		inner join sonata.sophia.sophia.DISCIPLINAS c on a.DISCIPLINA = c.CODIGO
		inner join sonata.sophia.sophia.PERIODOS d on b.PERIODO = d.CODIGO
		left join sonata.sophia.sophia.QC_PROFESSOR e on a.CODIGO = e.QC
		left join tb_turmapai f on f.id_cod_turma = b.CODIGO
		where (
				a.PROFESSOR = @codprofessor or 
				e.PROFESSOR = @codprofessor
			) and 
			b.ESTADO = 1
		order by b.NOME,c.NOME
	END
	ELSE
	BEGIN
		SELECT DISTINCT
			b.CODIGO as IDTURMA, 
			b.NOME as TURMA, 
			c.CODIGO as IDDISCIPLINA, 
			c.NOME as DISCIPLINA,
			h.DESCRICAO as NIVEL,
			b.CFG_ACAD,
			d.DESCRICAO as PERIODO,
			CASE 
				WHEN f.instatus = 0 THEN 0
				WHEN f.instatus = 1 THEN 
					CASE 
						WHEN f.id_cod_turma IS NULL THEN 0
						WHEN f.id_cod_turma IS NOT NULL THEN 1
					END
			END AS INPAI,
			f.notapaipeso 
		from sonata.sophia.sophia.QC a
		inner join sonata.sophia.sophia.TURMAS b on a.TURMA = b.CODIGO
		inner join sonata.sophia.sophia.DISCIPLINAS c on a.DISCIPLINA = c.CODIGO
		inner join sonata.sophia.sophia.PERIODOS d on b.PERIODO = d.CODIGO
		left join sonata.sophia.sophia.QC_PROFESSOR e on a.CODIGO = e.QC
		left join tb_turmapai f on f.id_cod_turma = b.CODIGO
		INNER JOIN sonata.sophia.sophia.CURSOS g ON g.PRODUTO = b.CURSO
		INNER JOIN sonata.sophia.sophia.NIVEL h ON h.CODIGO = g.NIVEL
		where 
			d.DESCRICAO COLLATE Latin1_General_CI_AI in(
				SELECT id COLLATE Latin1_General_CI_AI FROM Simpac..fnSplit(@desperido, ',')
			) AND
			h.CODIGO in(1, 2, 3, 5) --TECNOLOGO e BACHAREL
			
		order by b.NOME,c.NOME
	END
END

--
select * from sophia.FISICA
where NOME like '%ricardo ro%'


select * from sophia.TURMAS
where PERIODO = 117


select * from sophia.PERIODOS

select * from sophia.qc


select * from sophia.PROF_DISCIPLINAS
where COD_FUNC = 4170

SELECT id FROM fnSplit('1,3,3,3', ',');

-------------------------------------------------------------------------
alter proc sp_lista_chamada_list
(@turma int, @disciplina int)
AS
/*
	url: ,
	data: 25/09/2013
	author: Maluf
*/
BEGIN
	select 
		a.CODIGO, 
		a.DATA, 
		'1 - ' + cast(a.AULAS_CONSE as CHAR(1)) as QTDE_AULAS, 
		c.NOME as TURMA, 
		b.NOME as DISCIPLINA,
		d.DESCRICAO as SALA, 
		a.SITUACAO
	from sophia.LISTA_CHAM a 
	inner join sophia.DISCIPLINAS b on a.DISCIPLINA = b.CODIGO
	inner join sophia.TURMAS c on a.TURMA = c.CODIGO
	left join sophia.SALAS d on a.SALA = d.CODIGO
	where a.TURMA = @turma and a.DISCIPLINA = @disciplina
	order by a.DATA, a.CODIGO
END
--
sp_lista_chamada_list 2325,31

select * from sophia.TURMAS
where PERIODO = 117
--2325 - SI5A 

select * from sophia.academic
where turma = 2325

select * from sophia.DISCIPLINAS
where CODIGO = 31

SELECT * FROM SONATA.SOPHIA.sophia.LISTA_CHAM_WEB

-------------------------------------------------------------------------
ALTER PROC sp_listas_nao_finalizadas
(@COD_PROF int, @periodo datetime = NULL)
AS
/*
	url: /simpacweb/autobots/Schedule/sistemaFaltasFit/lista_cham_nao_finalizadas.php,
	data: 25/09/2014
	author: Massaharu
	descricao: Lista as listas de chamadas não finalizadas do professor
*/
BEGIN
	
	SELECT 
		'1 - ' + cast(a.AULAS_CONSE as CHAR(1)) as QTDE_AULAS, 
		c.CODIGO as COD_TURMA,
		c.NOME as TURMA, 
		b.CODIGO as COD_DISCIPLINA,
		b.NOME as DISCIPLINA,		
		d.DESCRICAO as SALA, 
		a.SITUACAO,
		COUNT (*) as LISTAS_NAO_FINALIZADAS
	FROM SONATA.SOPHIA.SOPHIA.LISTA_CHAM A 
	INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS B ON A.DISCIPLINA = B.CODIGO
	INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS C ON A.TURMA = C.CODIGO
	LEFT JOIN SONATA.SOPHIA.SOPHIA.SALAS D ON A.SALA = D.CODIGO
	LEFT JOIN SONATA.SOPHIA.SOPHIA.LISTA_CHAM_WEB E ON E.CODIGO = A.CODIGO
	INNER JOIN SONATA.SOPHIA.SOPHIA.PERIODOS F ON F.CODIGO = C.PERIODO
	INNER JOIN SONATA.SOPHIA.SOPHIA.QC G ON G.DISCIPLINA = B.CODIGO AND G.TURMA = C.CODIGO
	WHERE 
		a.SITUACAO = 0 AND 
		G.PROFESSOR = @COD_PROF AND 
		F.DESCRICAO COLLATE Latin1_General_CI_AI = (SELECT desperiodo FROM dbo.fn_periodoAtualGet(@periodo)) AND 
		a.DATA < DATEADD(day, -1, (SELECT periodo FROM dbo.fn_periodoAtualGet(@periodo))) 
	GROUP BY a.AULAS_CONSE, c.CODIGO, c.NOME, b.CODIGO, b.NOME, d.DESCRICAO, a.SITUACAO
	HAVING COUNT (*) > 0
	ORDER BY TURMA, DISCIPLINA
END
--
SELECT DATEPART(q, '2014-12-01')
SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE NOME LIKE '%furia%'
SELECT * FROM SONATA.SOPHIA.SOPHIA.DISCIPLINAS
SELECT * FROM SONATA.SOPHIA.SOPHIA.LISTA_CHAM WHERE TURMA = 2559
SELECT * FROM SONATA.SOPHIA.SOPHIA.SERIE
SELECT * FROM SONATA.SOPHIA.SOPHIA.CURRICULO
SELECT * FROM SONATA.SOPHIA.SOPHIA.QC WHERE TURMA = 2559
SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS
 
SELECT 
	'1 - ' + cast(a.AULAS_CONSE as CHAR(1)) as QTDE_AULAS, 
	c.CODIGO as COD_TURMA,
	c.NOME as TURMA, 
	b.CODIGO as COD_DISCIPLINA,
	b.NOME as DISCIPLINA,		
	d.DESCRICAO as SALA, 
	a.SITUACAO--,
	--COUNT (*) as LISTAS_NAO_FINALIZADAS
FROM SONATA.SOPHIA.SOPHIA.LISTA_CHAM A 
INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS B ON A.DISCIPLINA = B.CODIGO
INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS C ON A.TURMA = C.CODIGO
LEFT JOIN SONATA.SOPHIA.SOPHIA.SALAS D ON A.SALA = D.CODIGO
LEFT JOIN SONATA.SOPHIA.SOPHIA.LISTA_CHAM_WEB E ON E.CODIGO = A.CODIGO
INNER JOIN SONATA.SOPHIA.SOPHIA.PERIODOS F ON F.CODIGO = C.PERIODO
INNER JOIN SONATA.SOPHIA.SOPHIA.QC G ON G.DISCIPLINA = B.CODIGO AND G.TURMA = C.CODIGO
WHERE 
	a.SITUACAO = 0 AND 
	G.PROFESSOR = 3936 AND 
	F.DESCRICAO COLLATE Latin1_General_CI_AI = '2014/2' AND 
	a.DATA < DATEADD(day, -1, '2014-08-15 08:36:49.530') 
GROUP BY a.AULAS_CONSE, c.CODIGO, c.NOME, b.CODIGO, b.NOME, d.DESCRICAO, a.SITUACAO
HAVING COUNT (*) > 0
ORDER BY TURMA, DISCIPLINA

sp_listas_nao_finalizadas_prof
sp_listas_nao_finalizadas 4032, NULL--, '2014-03-02 00:00:01'

SELECT periodo FROM dbo.fn_periodoAtualGet(NULL)

-------------------------------------------------------------------------
ALTER PROC sp_listas_nao_finalizadas_dias
(@COD_TURMA int, @COD_DISCIPLINA int, @periodo datetime = NULL)
AS
/*
	url: /simpacweb/autobots/Schedule/sistemaFaltasFit/lista_cham_nao_finalizadas.php,
	data: 25/09/2014
	author: Massaharu
	descricao: Lista as os dias das listas de chamadas não finalizadas do professor
*/
BEGIN
	
	SELECT 
		CODIGO, TURMA, DISCIPLINA, SETOR, DATA, ETAPA, MATERIA, GRUPO, SALA, AULAS_CONSE, SITUACAO, 
		TIPO_PROC, JUSTIFICATIVA, TOT_FALTAS, CATRACA, ORIGEM_PROC, confirmada
	FROM SONATA.SOPHIA.SOPHIA.LISTA_CHAM
	WHERE 
		disciplina = @COD_DISCIPLINA AND 
		TURMA = @COD_TURMA AND 
		SITUACAO = 0 AND
		DATA < DATEADD(day, -1, (SELECT periodo FROM dbo.fn_periodoAtualGet(@periodo)))
	ORDER BY DATA
END

exec sp_listas_nao_finalizadas 18777, '2014-05-01 00:00:01'
GO
exec sp_listas_nao_finalizadas_dias 2521, 1438,  '2014-03-14 00:00:01'
-------------------------------------------------------------------------
ALTER PROC sp_listas_nao_finalizadas_prof
(@periodo datetime = NULL)
AS 
/*
	url: /simpacweb/autobots/Schedule/sistemaFaltasFit/lista_cham_nao_finalizadas.php,
	data: 25/09/2014
	author: Massaharu
	descricao: Lista os professores que possuem listas de chamadas não finalizadas
*/
BEGIN
	
	SELECT DISTINCT
		e.CODIGO, e.NOME, e.EMAIL
	FROM SONATA.SOPHIA.SOPHIA.LISTA_CHAM a
	INNER JOIN SONATA.SOPHIA.SOPHIA.QC b ON b.TURMA = a.TURMA AND b.DISCIPLINA = a.DISCIPLINA
	INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = b.TURMA
	INNER JOIN SONATA.SOPHIA.SOPHIA.PERIODOS d ON d.CODIGO = c.PERIODO
	INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA e ON e.CODIGO = b.PROFESSOR
	WHERE 
		a.SITUACAO = 0 AND 
		d.DESCRICAO COLLATE Latin1_General_CI_AI = (SELECT desperiodo FROM dbo.fn_periodoAtualGet(@periodo)) AND
		a.DATA < DATEADD(day, -1, (SELECT periodo FROM dbo.fn_periodoAtualGet(@periodo)))
END

sp_listas_nao_finalizadas_prof NULL '2014-08-15 08:27:01'

sp_listas_nao_finalizadas 18777, NULL
SELECT DATEADD(day, -1, getdate())
-------------------------------------------------------------------------------------------------------
CREATE FUNCTION fn_periodoAtualGet(@periodo DATETIME = NULL)
RETURNS @tb_periodo_atual TABLE(
	periodo datetime,
	desperiodo varchar(10)
)
AS
BEGIN
	DECLARE @desperiodo varchar(10)
	
	--	SE NÃO PASSAR PERIODO, PEGAR O ATUAL
	IF @periodo IS NULL
		SET @periodo = GETDATE()
	ELSE
		SET @periodo = @periodo		
	
	-- SETAR PERIODO
	IF ((SELECT DATEPART(q, @periodo)) <= 2)
	BEGIN
		SET @desperiodo = CAST(YEAR(GETDATE()) AS char(4)) + '/1'
	END
	ELSE
	BEGIN
		SET @desperiodo = CAST(YEAR(GETDATE()) AS char(4)) + '/2'
	END	
	
	INSERT INTO @tb_periodo_atual VALUES
	(@periodo, @desperiodo)
	
	RETURN
END

SELECT * FROM dbo.fn_periodoAtualGet(NULL)
-------------------------------------------------------------------------------------------------------
ALTER PROC sp_alunos_lista_chamada_list
(@codigo int)
AS
/*
	url: ,
	data: 25/09/2013
	author: Maluf
	descricao: @instatus: 1 = sendo processado, 0 = finalizado ou lancar
*/
BEGIN
	DECLARE @SITUACAO int, @TIPO_PROC int, @instatus int, @TURMA int, @DISCIPLINA INT, @ETAPA INT
	
	SET @TURMA = (select TURMA from sophia.LISTA_CHAM WHERE CODIGO = @codigo)
	SET @DISCIPLINA = (select DISCIPLINA from sophia.LISTA_CHAM WHERE CODIGO = @codigo)
	SET @ETAPA = (select ETAPA from sophia.LISTA_CHAM WHERE CODIGO = @codigo)
	
	
	IF EXISTS(select * from sophia.LISTA_CHAM_WEB WHERE CODIGO = @codigo)
	BEGIN
		SET @SITUACAO = (select SITUACAO from sophia.LISTA_CHAM_WEB WHERE CODIGO = @codigo)
		SET @TIPO_PROC = (select TIPO_PROC from sophia.LISTA_CHAM_WEB WHERE CODIGO = @codigo)
		SET @instatus = 1
	END
	ELSE
	BEGIN
		SET @SITUACAO = (select SITUACAO from sophia.LISTA_CHAM WHERE CODIGO = @codigo)
		SET @TIPO_PROC = (select TIPO_PROC from sophia.LISTA_CHAM WHERE CODIGO = @codigo)
		SET @instatus = 0
	END
	
	-- SE A LISTA AINDA ESTIVER SENDO PROCESSADA
	IF EXISTS(select SITUACAO from sophia.LISTA_CHAM WHERE CODIGO = @codigo AND SITUACAO = 0) AND @instatus = 1
	BEGIN
		select 
			d.CODIGO
			, d.CODEXT as RA
			, d.NOME as ALUNO
			, b.AULA
			, b.MATRICULA
			, b.FALTA
			, 0 as SITUACAO
			, @TIPO_PROC as TIPO_PROC
			, @TURMA as TURMA
			, @DISCIPLINA as DISCIPLINA
			, @ETAPA as ETAPA
			, a.MATERIA
			, a.TAREFA
			, a.AULA as NRAULA
			, @instatus as instatus
		from sophia.LISTA_CHAM_AULAS_WEB a 
		inner join sophia.LISTA_CHAM_ALUNOS_WEB b on a.CODIGO = b.AULA
		inner join sophia.MATRICULA c on b.MATRICULA = c.CODIGO
		inner join sophia.FISICA d on c.FISICA = d.CODIGO
		where a.LISTA = @codigo
		order by d.NOME, a.AULA 
	END
	-- SE A LISTA JÁ FOI PROCESSADA OU GERADA E AINDA NÃO MODIFICADA
	ELSE
	BEGIN
		select 
			d.CODIGO
			, d.CODEXT as RA
			, d.NOME as ALUNO
			, b.AULA
			, b.MATRICULA
			, b.FALTA
			, @SITUACAO as SITUACAO
			, @TIPO_PROC as TIPO_PROC
			, @TURMA as TURMA
			, @DISCIPLINA as DISCIPLINA
			, @ETAPA as ETAPA
			, a.MATERIA
			, a.TAREFA
			, a.AULA as NRAULA
			, @instatus as instatus
		from sophia.LISTA_CHAM_AULAS a 
		inner join sophia.LISTA_CHAM_ALUNOS b on a.CODIGO = b.AULA
		inner join sophia.MATRICULA c on b.MATRICULA = c.CODIGO
		inner join sophia.FISICA d on c.FISICA = d.CODIGO
		where a.LISTA = @codigo
		order by d.NOME,a.AULA  
	END
END
--
SELECT * from sophia.LISTA_CHAM_AULAS_WEB a 
left join sophia.LISTA_CHAM_ALUNOS_WEB b on a.CODIGO = b.AULA
left join sophia.MATRICULA c on b.MATRICULA = c.CODIGO
left join sophia.FISICA d on c.FISICA = d.CODIGO
where a.LISTA = 114259
order by d.NOME, a.AULA 

SELECT * from sophia.LISTA_CHAM_AULAS a 
inner join sophia.LISTA_CHAM_ALUNOS b on a.CODIGO = b.AULA
inner join sophia.MATRICULA c on b.MATRICULA = c.CODIGO
inner join sophia.FISICA d on c.FISICA = d.CODIGO
where a.LISTA = 114259
order by d.NOME,a.AULA  

select * from sophia.LISTA_CHAM WHERE CODIGO = 114259 AND SITUACAO = 0
		
sp_alunos_lista_chamada_list 91764



select top(100)* from sophia.LISTA_CHAM WHERE CODIGO = 91764
select top(100)* from sophia.LISTA_CHAM_WEB WHERE CODIGO = 91764
select top(100)* from sophia.LISTA_CHAM_AULAS WHERE LISTA = 91764
select top(100)* from sophia.LISTA_CHAM_AULAS_WEB WHERE LISTA = 91764
select top(100)* from sophia.LISTA_CHAM_ALUNOS WHERE MATRICULA = 31896 AND AULA = 282067
select top(100)* from sophia.LISTA_CHAM_ALUNOS_WEB WHERE MATRICULA = 31896 AND AULA = 282067



--87320
----------------------------------------------------
----------------------------------------------------
----------------------------------------------------
ALTER PROC sp_lista_chamada_get 91854

(@codigo int)
/*
	url: ,
	data: 25/09/2013
	author: Maluf
*/
AS
BEGIN
	DECLARE @TURMA int, @DISCIPLINA INT, @ETAPA INT
	
	SET @TURMA = (select TURMA from sophia.LISTA_CHAM WHERE CODIGO = @codigo)
	SET @DISCIPLINA = (select DISCIPLINA from sophia.LISTA_CHAM WHERE CODIGO = @codigo)
	SET @ETAPA = (select ETAPA from sophia.LISTA_CHAM WHERE CODIGO = @codigo)

	IF EXISTS(select * from sophia.LISTA_CHAM_WEB WHERE CODIGO = @codigo)
	BEGIN
		select 
			b.NOME as desdisciplina
			, (select DATA from sophia.LISTA_CHAM WHERE CODIGO = @codigo) as data
			, (select AULAS_CONSE from sophia.LISTA_CHAM WHERE CODIGO = @codigo) as qtd_aulas
			, a.CODIGO
			, c.CODIGO as COD_AULA
			, 0 as SITUACAO
			, a.TIPO_PROC
			, @TURMA as TURMA
			, @DISCIPLINA as DISCIPLINA
			, @ETAPA as ETAPA
			, c.AULA
			, c.MATERIA
			, c.TAREFA
			, 1 as instatus
		from sophia.LISTA_CHAM_WEB a
		inner join sophia.DISCIPLINAS b on a.DISCIPLINA = b.CODIGO
		inner join sophia.LISTA_CHAM_AULAS_WEB c on a.CODIGO = c.LISTA
		where a.CODIGO = @codigo
		order by c.CODIGO
	END
	ELSE
	BEGIN
		select 
			b.NOME as desdisciplina
			, a.DATA as data
			, a.AULAS_CONSE as qtd_aulas
			, a.CODIGO
			, c.CODIGO as COD_AULA
			, a.SITUACAO
			, a.TIPO_PROC
			, @TURMA as TURMA
			, @DISCIPLINA as DISCIPLINA
			, @ETAPA as ETAPA
			, c.AULA
			, c.MATERIA
			, c.TAREFA
			, 0 as instatus
		from sophia.LISTA_CHAM a
		inner join sophia.DISCIPLINAS b on a.DISCIPLINA = b.CODIGO
		inner join sophia.LISTA_CHAM_AULAS c on a.CODIGO = c.LISTA
		where a.CODIGO = @codigo
		order by c.CODIGO
	END
END

SELECT TOP (100) * FROM sophia.LISTA_CHAM_WEB WHERE CODIGO = 87323
SELECT TOP (100) * FROM sophia.LISTA_CHAM
SELECT TOP (100) * FROM sophia.LISTA_CHAM_AULAS_WEB
SELECT TOP (100) * FROM sophia.DISCIPLINAS
-----------------------------------------------------------------
ALTER proc sp_lista_cham_web_save
(@codigo int, @tipo_proc int = 1, @situacao int = 4)
as
/*
  app:Sophia
  url:unknown
  author: renan
  date: 1/10/2013
*/
BEGIN
	IF((SELECT SITUACAO FROM SOPHIA.LISTA_CHAM WHERE CODIGO = @codigo) = 0)
	BEGIN
		IF NOT EXISTS(SELECT * FROM SOPHIA.LISTA_CHAM_WEB WHERE CODIGO = @codigo)
		BEGIN	
			
			INSERT SOPHIA.LISTA_CHAM_WEB
			(
				CODIGO,
				TURMA,
				DISCIPLINA,
				DATA,
				MATERIA,
				SITUACAO,
				TIPO_PROC,
				JUSTIFICATIVA,
				ORIGEM_PROC,
				confirmada
			)
			SELECT 
				CODIGO,
				TURMA,
				DISCIPLINA,
				DATA,
				MATERIA,
				4,
				@tipo_proc,
				JUSTIFICATIVA,
				ORIGEM_PROC,
				confirmada
			FROM SOPHIA.LISTA_CHAM
			WHERE CODIGO = @codigo
			
			--SALVA NO LOG
			IF(@situacao = 0)
				INSERT sophia.LISTA_CHAM_LOG(CODIGO, SITUACAO, TIPO_PROC) 
				SELECT CODIGO, SITUACAO, @tipo_proc FROM SOPHIA.LISTA_CHAM
				WHERE CODIGO = @codigo
		END
		ELSE
		BEGIN
			UPDATE SOPHIA.LISTA_CHAM_WEB
			SET SITUACAO = 4, 
				TIPO_PROC = @tipo_proc
			WHERE CODIGO = @codigo
			
			
			--SALVA NO LOG
			IF(@situacao = 0)
				INSERT sophia.LISTA_CHAM_LOG(CODIGO, SITUACAO, TIPO_PROC) 
				SELECT CODIGO, SITUACAO, @tipo_proc FROM SOPHIA.LISTA_CHAM
				WHERE CODIGO = @codigo
		END
	END
END

SELECT * FROM SOPHIA.LISTA_CHAM_WEB
-----------------------------------------------------------------
ALTER proc sp_lista_cham_save
(@codigo int, @inretificado bit = 0, @desmotivoretificacao varchar(1000) = NULL)
AS
/*
  app:Sophia
  url:..professor/ajax/salva_lista_chamada.php
  author: Massaharu
  date: 1/10/2013
*/
BEGIN
	DECLARE @lista_cham_web TABLE(
		CODIGO int,
		TURMA int,
		DISCIPLINA int,
		DATA datetime,
		MATERIA varchar(max),
		SITUACAO int,
		TIPO_PROC int,
		JUSTIFICATIVA varchar(max),
		ORIGEM_PROC smallint,	
		confirmada smallint	 	 
	)
	
	BEGIN TRAN
	
	INSERT @lista_cham_web
	SELECT 
		CODIGO,
		TURMA,
		DISCIPLINA,
		DATA,
		MATERIA,
		SITUACAO,
		TIPO_PROC,
		JUSTIFICATIVA,
		ORIGEM_PROC,	
		confirmada	 	 
	FROM SOPHIA.LISTA_CHAM_WEB
	WHERE CODIGO = @codigo

	IF @@ERROR = 0
	BEGIN
		UPDATE SOPHIA.LISTA_CHAM
		SET 
			TURMA =			(SELECT TURMA FROM @lista_cham_web),
			DISCIPLINA =	(SELECT DISCIPLINA FROM @lista_cham_web),
			DATA =			(SELECT DATA FROM @lista_cham_web),
			MATERIA =		(SELECT MATERIA FROM @lista_cham_web),
			SITUACAO =		(SELECT SITUACAO FROM @lista_cham_web),
			TIPO_PROC =		(SELECT TIPO_PROC FROM @lista_cham_web),
			JUSTIFICATIVA = (SELECT JUSTIFICATIVA FROM @lista_cham_web),
			ORIGEM_PROC =	(SELECT ORIGEM_PROC FROM @lista_cham_web),	
			confirmada =	(SELECT confirmada FROM @lista_cham_web)	 	
		WHERE CODIGO = @codigo 
		
		--SALVA NO LOG
		INSERT sophia.LISTA_CHAM_LOG(CODIGO, SITUACAO, TIPO_PROC, INRETIFICADO, DESMOTIVORETIFICACAO) 
		SELECT CODIGO, SITUACAO, TIPO_PROC, @inretificado, @desmotivoretificacao 
		FROM SOPHIA.LISTA_CHAM_WEB
		WHERE CODIGO = @codigo
		
		IF @@ERROR = 0
		BEGIN
			DELETE SOPHIA.LISTA_CHAM_WEB
			WHERE CODIGO = @codigo
			
			COMMIT
		END
	END
	ELSE
	ROLLBACK
END
--
SELECT * FROM sophia.LISTA_CHAM_LOG 
-----------------------------------------------------------------
CREATE PROC sp_lista_cham_aulas_web_save
(@codigo int, @cod_aula int, @materia varchar(max))
AS
/*
  app:Sophia
  url:..professor/ajax/salva_lista_chamada.php
  author: Massaharu
  date: 1/10/2013
*/
BEGIN
	IF((SELECT SITUACAO FROM SOPHIA.LISTA_CHAM WHERE CODIGO = @codigo) = 0)
	BEGIN
		IF NOT EXISTS(SELECT * FROM sophia.LISTA_CHAM_AULAS_WEB WHERE CODIGO = @cod_aula AND LISTA = @codigo)
		BEGIN
			INSERT sophia.LISTA_CHAM_AULAS_WEB
			SELECT 
				CODIGO
				, LISTA
				, AULA
				, TAREFA
				, @materia
			FROM sophia.LISTA_CHAM_AULAS 
			WHERE CODIGO = @cod_aula AND LISTA = @codigo 
		END
		ELSE
		BEGIN
			UPDATE sophia.LISTA_CHAM_AULAS_WEB
			SET MATERIA = @materia
			WHERE CODIGO = @cod_aula AND LISTA = @codigo 
		END
	END
END
-----------------------------------------------------------------
ALTER PROC sp_lista_cham_aulas_save
(@codigo int, @cod_aula int)
AS
/*
  app:Sophia
  url:..professor/ajax/salva_lista_chamada.php
  author: Massaharu
  date: 1/10/2013
*/
BEGIN
	DECLARE @lista_cham_aulas_web TABLE(
		CODIGO int,
		LISTA int,
		AULA int,
		TAREFA int,
		MATERIA varchar(max)
	)
	
	BEGIN TRAN
	
	INSERT @lista_cham_aulas_web
	SELECT
		CODIGO
		, LISTA
		, AULA
		, TAREFA
		, MATERIA
	FROM sophia.LISTA_CHAM_AULAS_WEB
	WHERE CODIGO = @cod_aula AND LISTA = @codigo 
	
	IF @@ERROR = 0
	BEGIN
		UPDATE sophia.LISTA_CHAM_AULAS
		SET 
			LISTA =		(SELECT LISTA FROM @lista_cham_aulas_web),
			AULA =		(SELECT AULA FROM @lista_cham_aulas_web),
			TAREFA =	(SELECT TAREFA FROM @lista_cham_aulas_web),
			MATERIA =	(SELECT MATERIA FROM @lista_cham_aulas_web)
		WHERE CODIGO = @cod_aula AND LISTA = @codigo 
		
		IF @@ERROR = 0
		BEGIN
			DELETE FROM sophia.LISTA_CHAM_AULAS_WEB
			WHERE CODIGO = @cod_aula AND LISTA = @codigo 
			
			COMMIT
		END
	END
	ELSE
		ROLLBACK
END
-----------------------------------------------------------------
ALTER proc sp_lista_cham_alunos_web_save
(@codigo int, @aula int, @matricula varchar(20), @falta int = 0)
as
/*
  app:Sophia
  url:..professor/ajax/salva_lista_chamada.php
  author: Massaharu
  date: 1/10/2013
*/
BEGIN
	IF((SELECT SITUACAO FROM SOPHIA.LISTA_CHAM WHERE CODIGO = @codigo) = 0)
	BEGIN
		IF NOT EXISTS(SELECT * FROM sophia.LISTA_CHAM_ALUNOS_WEB WHERE AULA = @aula and	MATRICULA = @matricula)
		BEGIN
			INSERT sophia.LISTA_CHAM_ALUNOS_WEB
			SELECT 
				AULA
				,MATRICULA
				,@falta
				,TAREFA
				,CONTABILIZA
				,MotTarefaNRealizada
			FROM sophia.LISTA_CHAM_ALUNOS
			WHERE AULA = @aula and	MATRICULA = @matricula
		END
		ELSE
		BEGIN
			UPDATE sophia.LISTA_CHAM_ALUNOS_WEB 
			SET 
				FALTA = @falta
			WHERE	AULA = @aula and 
					MATRICULA = @matricula
		END
	END
END
-----------------------------------------------------------------
ALTER proc sp_lista_cham_alunos_save
(@aula int, @matricula varchar(20))
as
/*
  app:Sophia
  url:..professor/ajax/salva_lista_chamada.php
  author: Massaharu
  date: 1/10/2013
*/
BEGIN
	DECLARE @lista_cham_alunos_web TABLE(
		AULA int
		,MATRICULA int
		,FALTA smallint
		,TAREFA smallint
		,CONTABILIZA smallint
		,MotTarefaNRealizada smallint
	)
	
	BEGIN TRAN
	
	INSERT @lista_cham_alunos_web
	SELECT
		AULA
		,MATRICULA
		,FALTA
		,TAREFA
		,CONTABILIZA
		,MotTarefaNRealizada
	FROM sophia.LISTA_CHAM_ALUNOS_WEB
	WHERE AULA = @aula and	MATRICULA = @matricula 
	
	IF @@ERROR = 0
	BEGIN
		UPDATE sophia.LISTA_CHAM_ALUNOS
		SET
			AULA				= (SELECT AULA FROM @lista_cham_alunos_web),
			MATRICULA			= (SELECT MATRICULA FROM @lista_cham_alunos_web),
			FALTA				= (SELECT FALTA FROM @lista_cham_alunos_web),
			TAREFA				= (SELECT TAREFA FROM @lista_cham_alunos_web),
			CONTABILIZA			= (SELECT CONTABILIZA FROM @lista_cham_alunos_web),
			MotTarefaNRealizada = (SELECT MotTarefaNRealizada FROM @lista_cham_alunos_web)
		WHERE AULA = @aula and	MATRICULA = @matricula 
		
		IF @@ERROR = 0
		BEGIN
			DELETE sophia.LISTA_CHAM_ALUNOS_WEB
			WHERE AULA = @aula and	MATRICULA = @matricula 
			
			COMMIT
		END
		ELSE
			ROLLBACK
	END
	ELSE
		ROLLBACK
END
-----------------------------------------------------------------
ALTER PROC sp_lista_cham_alunos_faltas_save --31164, 2316, 164, 1
(@MATRICULA INT, @TURMA INT, @ETAPA INT, @DISCIPLINA INT)
AS
/*
  app:Sophia
  url:..professor/ajax/salva_lista_chamada.php
  author: Massaharu
  date: 1/10/2013
*/
BEGIN
	
	DECLARE @NRFALTA INT, @FALTAS INT, @CARGA_HORARIA INT, @PERIODO INT, @SERIE INT
	
	SELECT 
		@FALTAS = FALTAS1+FALTAS2,
		@CARGA_HORARIA = CARGA_HORARIA 
	FROM sophia.academic
	WHERE MATRICULA = @MATRICULA and TURMA = @TURMA and DISCIPLINA = @DISCIPLINA
	
	SELECT 
		@PERIODO = PERIODO,
		@SERIE = SERIE
	FROM SOPHIA.TURMAS
	WHERE CODIGO = @TURMA

	SET @NRFALTA = (
		select 
			 SUM(b.FALTA)
		from sophia.LISTA_CHAM_AULAS a 
		inner join sophia.LISTA_CHAM_ALUNOS b on a.CODIGO = b.AULA
		inner join sophia.MATRICULA c on b.MATRICULA = c.CODIGO
		inner join sophia.LISTA_CHAM e on e.CODIGO = a.LISTA
		inner join sophia.TURMAS f on f.CODIGO = e.TURMA
		where C.CODIGO = @MATRICULA and e.TURMA = @TURMA and e.ETAPA = @ETAPA and e.DISCIPLINA = @DISCIPLINA
		GROUP BY b.MATRICULA
	)	

	IF(@ETAPA = 1)
	BEGIN
		UPDATE sophia.ACADEMIC
		SET FALTAS1 = @NRFALTA
		WHERE MATRICULA = @MATRICULA and TURMA = @TURMA and DISCIPLINA = @DISCIPLINA
	END
	ELSE IF(@ETAPA = 2)
	BEGIN
		UPDATE sophia.ACADEMIC
		SET FALTAS2 = @NRFALTA
		WHERE MATRICULA = @MATRICULA and TURMA = @TURMA and DISCIPLINA = @DISCIPLINA
	END
	ELSE IF(@ETAPA = 3)
	BEGIN
		UPDATE sophia.ACADEMIC
		SET FALTAS3 = @NRFALTA
		WHERE MATRICULA = @MATRICULA and TURMA = @TURMA and DISCIPLINA = @DISCIPLINA
	END
	ELSE IF(@ETAPA = 4)
	BEGIN
		UPDATE sophia.ACADEMIC
		SET FALTAS4 = @NRFALTA
		WHERE MATRICULA = @MATRICULA and TURMA = @TURMA and DISCIPLINA = @DISCIPLINA
	END
	
	--Atualiza o campo de percentual de faltas do sophia.academic
	UPDATE sophia.ACADEMIC
	SET PERC_FALTAS = dbo.fn_perc_faltas_calc(@FALTAS, CARGA_HORARIA)
	WHERE MATRICULA = @MATRICULA and TURMA = @TURMA and DISCIPLINA = @DISCIPLINA
	
	UPDATE sophia.HIST_CURR_ALUNO
	SET		
		PERC_FREQ = 100 - dbo.fn_perc_faltas_calc(@FALTAS, CARGA_HORARIA),
		SITUACAO = (
			CASE 
				WHEN(
					SELECT 100 - dbo.fn_perc_faltas_calc(@FALTAS, CARGA_HORARIA)
				) >= 75 THEN
					'Aprovado'
				ELSE
					'Reprovado por falta'
			END
		)
	WHERE INSCRICAO = 
		(
			SELECT TOP 1 c.CODIGO FROM SOPHIA.MATRICULA a
			INNER JOIN SOPHIA.FISICA b ON b.CODIGO = a.FISICA
			INNER JOIN SOPHIA.INSCRICAO c ON c.FISICA = b.CODIGO AND a.CURSO = C.CURSO
			WHERE a.CODIGO = @MATRICULA			
		) AND
		DISCIPLINA = @DISCIPLINA AND
		PERIODO = @PERIODO AND
		SERIE = @SERIE
END


SELECT * FROM sophia.academic
WHERE MATRICULA = 34837

SELECT 
	CODIGO
	, NOTA1 
	, NOTA2
	, NOTA3
	, NOTA4
	, EXAME
	, MEDIA_ANUAL
	, MEDIA_APOS_EXAME
	, MEDIA_FINAL
	, MEDIA_FINALSTR
	, FALTAS1
	, FALTAS2
	, FALTAS3
	, FALTAS4
	, FALTAS5
	, PERC_FALTAS
	, CARGA_HORARIA
FROM sophia.academic
WHERE FALTAS3 <> 0 OR FALTAS4 <> 0 OR FALTAS5 <> 0 AND CODIGO = 187050

SELECT * FROm SONATA.SOPHIA.SOPHIA.LISTA_CHAM
SELECT * FROM SONATA.SOPHIA.SOPHIA.HIST_CURR_ALUNO WHERE INSCRICAO = 13124 AND DISCIPLINA = 925 AND PERIODO = 120 AND SERIE = 674
SELECT * FROM SONATA.SOPHIA.SOPHIA.INSCRICAO WHERE FISICA = 23072
SELECT * FROM SONATA.SOPHIA.SOPHIA.MATRICULA WHERE FISICA = 23072	
SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS WHERE CODIGO = 2494
SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE NOME LIKE 'vinicius%silva%barbosa'

SELECT c.CODIGO FROM SOPHIA.MATRICULA a
INNER JOIN SOPHIA.FISICA b ON b.CODIGO = a.FISICA
INNER JOIN SOPHIA.INSCRICAO c ON c.FISICA = b.CODIGO AND a.CURSO = C.CURSO
WHERE a.CODIGO = 33723	

DECLARE @sit varchar(200) 
SET @sit = (
	CASE 
		WHEN(
			SELECT 100 - dbo.fn_perc_faltas_calc(21, 80)
		) >= 75 THEN
			'Aprovado'
		ELSE
			'Reprovado por falta'
	END
)
print @sit

sp_alunos_lista_chamada_list 116415
sp_lista_chamada_get 116415
-----------------------------------------------------------------
CREATE PROC sp_lista_cham_situacao
(@CODIGO int, @SITUACAO int)
AS
/*
  app:Sophia
  url:..professor/ajax/salva_lista_chamada.php
  author: Massaharu
  date: 1/08/2014
*/
BEGIN
	UPDATE SOPHIA.LISTA_CHAM
	SET SITUACAO = @SITUACAO
	WHERE CODIGO = @CODIGO
END
--
SELECT * FROM SOPHIA.LISTA_CHAM
-----------------------------------------------------------------
ALTER PROC sp_lista_cham_log_list
(@idturma int, @iddisciplina int)
AS
/*
  app:Sophia
  url:..professor/ajax/salva_lista_chamada.php
  author: Massaharu
  date: 1/08/2014
  descricao: historico de ações nas listas de chamadas da area do professor
*/
BEGIN
	SELECT 
		a.idlog
		, a.CODIGO as COD_LISTA
		, e.NOME as desdisciplina
		, f.NOME as desetapa
		, b.DATA as DATA_LISTA
		, b.TURMA
		, a.SITUACAO
		, a.INRETIFICADO
		, a.DESMOTIVORETIFICACAO
		, a.TIPO_PROC
		, d.NOME as desprofessor
		, c.PROFESSOR
		, d.CODEXT
		, a.dtcadastro  
	FROM sonata.sophia.sophia.LISTA_CHAM_LOG a
	INNER JOIN sonata.sophia.sophia.LISTA_CHAM b
	ON b.CODIGO = a.CODIGO
	INNER JOIN sonata.sophia.sophia.LISTA_CHAM_PROF c
	ON c.LISTA = a.CODIGO
	INNER JOIN sonata.sophia.sophia.FISICA d
	ON d.CODIGO = c.PROFESSOR
	INNER JOIN sonata.sophia.sophia.DISCIPLINAS e
	ON e.CODIGO = b.DISCIPLINA
	INNER JOIN sonata.sophia.sophia.ETAPAS f
	ON f.NUMERO = b.ETAPA and CFG_ACAD = 1
	WHERE b.TURMA = @idturma AND e.CODIGO = @iddisciplina
	ORDER BY idlog DESC
END

--
SELECT * FROM sonata.sophia.sophia.LISTA_CHAM_LOG
SELECT * FROM sonata.sophia.sophia.LISTA_CHAM WHERE
SELECT * FROM sonata.sophia.sophia.LISTA_CHAM_AULAS_WEB WHERE LISTA = 98185
SELECT * FROM sonata.sophia.sophia.LISTA_CHAM_AULAS WHERE LISTA = 98787

SELECT 
	a.idlog
	, a.CODIGO as COD_LISTA
	, e.NOME as desdisciplina
	, f.NOME as desetapa
	, b.DATA as DATA_LISTA
	, b.TURMA
	, a.SITUACAO
	, a.INRETIFICADO
	, a.DESMOTIVORETIFICACAO
	, a.TIPO_PROC
	, d.NOME as desprofessor
	, c.PROFESSOR
	, d.CODEXT
	, (SELECT MATERIA FROM sonata.sophia.sophia.LISTA_CHAM_AULAS WHERE AULA = 1 AND LISTA = b.CODIGO)
	, (SELECT MATERIA FROM sonata.sophia.sophia.LISTA_CHAM_AULAS WHERE AULA = 2 AND LISTA = b.CODIGO)
	, (SELECT MATERIA FROM sonata.sophia.sophia.LISTA_CHAM_AULAS WHERE AULA = 3 AND LISTA = b.CODIGO)
	, (SELECT MATERIA FROM sonata.sophia.sophia.LISTA_CHAM_AULAS WHERE AULA = 4 AND LISTA = b.CODIGO)
	, a.dtcadastro  
FROM sonata.sophia.sophia.LISTA_CHAM_LOG a
INNER JOIN sonata.sophia.sophia.LISTA_CHAM b
ON b.CODIGO = a.CODIGO
INNER JOIN sonata.sophia.sophia.LISTA_CHAM_PROF c
ON c.LISTA = a.CODIGO
INNER JOIN sonata.sophia.sophia.FISICA d
ON d.CODIGO = c.PROFESSOR
INNER JOIN sonata.sophia.sophia.DISCIPLINAS e
ON e.CODIGO = b.DISCIPLINA
INNER JOIN sonata.sophia.sophia.ETAPAS f
ON f.NUMERO = b.ETAPA and CFG_ACAD = 2
WHERE b.TURMA = 2492 AND e.CODIGO = 805
ORDER BY idlog --DESC


SELECT * FROM sonata.sophia.sophia.LISTA_CHAM_LOG
-----------------------------------------------------------------
CREATE PROC sp_lista_cham_aulas_list
(@idlista int)
AS
/*
  app:Sophia
  url:..professor/ajax/salva_lista_chamada.php
  author: Massaharu
  date: 1/08/2014
  descricao: retorna as aulas de uma lista
*/
BEGIN
	--SE A LISTA ESTIVER COMO SITUACAO GERADA
	IF (SELECT SITUACAO FROM SONATA.SOPHIA.SOPHIA.LISTA_CHAM WHERE CODIGO = @idlista) = 0
	BEGIN
		SELECT CODIGO, LISTA, AULA, TAREFA, MATERIA, ATIVIDADE_EXTRA_CLASSE 
		FROM SONATA.SOPHIA.SOPHIA.LISTA_CHAM_AULAS_WEB
		WHERE LISTA = @idlista
	END
	ELSE
	BEGIN
		SELECT CODIGO, LISTA, AULA, TAREFA, MATERIA, ATIVIDADE_EXTRA_CLASSE
		FROM SONATA.SOPHIA.SOPHIA.LISTA_CHAM_AULAS
		WHERE LISTA = @idlista
	END
END
--
exec saturn.fit_NEW.DBO.sp_lista_cham_aulas_list 98185
-----------------------------------------------------------------
select dbo.fn_perc_faltas_calc(NULL, 80)

ALTER FUNCTION fn_perc_faltas_calc
(@nrfaltas numeric(10,4), @cargahoraria numeric(10,4))
RETURNS numeric(10,4)
/*
  app:Sophia
  author: Massaharu
  date: 1/10/2013
*/
AS
BEGIN
	RETURN (@nrfaltas / @cargahoraria) * 100
END

SELECT 20 / 80



-----------------------------------------------------------------
-- LISTA O HISTORICO
SELECT 
	a.idlog
	, a.CODIGO
	, e.NOME as desdisciplina
	, f.NOME as desetapa
	, b.DATA
	, b.TURMA
	, a.SITUACAO
	, a.INRETIFICADO
	, a.DESMOTIVORETIFICACAO
	, a.TIPO_PROC
	, d.NOME as desprofessor
	, c.PROFESSOR
	, d.CODEXT
	, a.dtcadastro  
FROM sonata.sophia.sophia.LISTA_CHAM_LOG a
INNER JOIN sonata.sophia.sophia.LISTA_CHAM b
ON b.CODIGO = a.CODIGO
INNER JOIN sonata.sophia.sophia.LISTA_CHAM_PROF c
ON c.LISTA = a.CODIGO
INNER JOIN sonata.sophia.sophia.FISICA d
ON d.CODIGO = c.PROFESSOR
INNER JOIN sonata.sophia.sophia.DISCIPLINAS e
ON e.CODIGO = b.DISCIPLINA
INNER JOIN sonata.sophia.sophia.ETAPAS f
ON f.NUMERO = b.ETAPA and CFG_ACAD = 1
ORDER BY idlog
------------------------------------------------------------
SELECT * FROM sophia.LISTA_CHAM_LOG
SELECT * FROM sophia.LISTA_CHAM WHERE CODIGO = 98740
SELECT * FROM sophia.LISTA_CHAM_WEB WHERE CODIGO = 98740
SELECT * FROM sophia.LISTA_CHAM_PROF
SELECT * FROM sophia.LISTA_CHAM_AULAS WHERE LISTA = 98740
SELECT * FROM sophia.LISTA_CHAM_ALUNOS WHERE AULA = 301245
SELECT * FROM sophia.FISICA
SELECT * FROM sophia.ETAPAS
SELECT * FROM sophia.DISCIPLINAS
SELECT * FROM sophia.AVALS WHERE TURMA = 2350



sp_lista_chamada_get 98740
--DELETE sophia.LISTA_CHAM_LOG WHERE PROFESSOR = 18777

--DELETE sophia.LISTA_CHAM_LOG
--WHERE idlog in(
--SELECT a.idlog FROM sophia.LISTA_CHAM_LOG a
--INNER JOIN sophia.LISTA_CHAM b
--ON b.CODIGO = a.CODIGO
--INNER JOIN sophia.LISTA_CHAM_PROF c
--ON c.LISTA = a.CODIGO
--INNER JOIN sophia.FISICA d
--ON d.CODIGO = c.PROFESSOR
--INNER JOIN sophia.DISCIPLINAS e
--ON e.CODIGO = b.DISCIPLINA
--INNER JOIN sophia.ETAPAS f
--ON f.NUMERO = b.ETAPA
--WHERE c.PROFESSOR = 18777
--)
-----------------------------------------------------------------
-----------------------------------------------------------------
-----------------------------------------------------------------


sp_lista_cham_alunos_faltas_save 31164, 2316, 164, 1

DECLARE @NRFALTA INT, @MATRICULA int, @TURMA int, @ETAPA int, @DISCIPLINA int
 
	SET @MATRICULA = 31164
	SET @TURMA = 2316
	SET @ETAPA = 2
	SET @DISCIPLINA = 164

select 
	 SUM(b.FALTA)
from sophia.LISTA_CHAM_AULAS a 
inner join sophia.LISTA_CHAM_ALUNOS b on a.CODIGO = b.AULA
inner join sophia.MATRICULA c on b.MATRICULA = c.CODIGO
inner join sophia.LISTA_CHAM e on e.CODIGO = a.LISTA
inner join sophia.TURMAS f on f.CODIGO = e.TURMA
where C.CODIGO = @MATRICULA and e.TURMA = @TURMA and e.ETAPA = @ETAPA and e.DISCIPLINA = @DISCIPLINA
GROUP BY b.MATRICULA

	IF(@ETAPA = 1)
	BEGIN
		PRINT 'UPDATE sophia.ACADEMIC
		SET FALTAS1 = @NRFALTA
		WHERE MATRICULA = @MATRICULA and TURMA = @TURMA and DISCIPLINA = @DISCIPLINA'
	END
	ELSE IF(@ETAPA = 2)
	BEGIN
		PRINT 'UPDATE sophia.ACADEMIC
		SET FALTAS2 = @NRFALTA
		WHERE MATRICULA = @MATRICULA and TURMA = @TURMA and DISCIPLINA = @DISCIPLINA'
	END
	ELSE IF(@ETAPA = 3)
	BEGIN
		PRINT 'UPDATE sophia.ACADEMIC
		SET FALTAS3 = @NRFALTA
		WHERE MATRICULA = @MATRICULA and TURMA = @TURMA and DISCIPLINA = @DISCIPLINA'
	END
	ELSE IF(@ETAPA = 4)
	BEGIN
		PRINT 'UPDATE sophia.ACADEMIC
		SET FALTAS4 = @NRFALTA
		WHERE MATRICULA = @MATRICULA and TURMA = @TURMA and DISCIPLINA = @DISCIPLINA'
	END

		

select * from sophia.matricula
where FISICA = 16083

SELECT * FROM SOPHIA.ACADEMIC
WHERE MATRICULA = 31381

-- no botão FINALIZAR alterar o status da lista para 4(PROCESSADA) e alterar o tipo_proc

select * FROM sophia.LISTA_CHAM_ALUNOS where AULA = 87326

select top(100) * from sophia.LISTA_CHAM_ALUNOS
select top(100) * from sophia.MATRICULA
select top(100) * from sophia.FISICA
select top(100) * from sophia.LISTA_CHAM WHERE CODIGO = 91877
select top(100) * from sophia.LISTA_CHAM_AULAS
select * from SONATA.SOPHIA.sophia.DISCIPLINAS WHERE NOME like '%Projeto de Jogos Digitais%'
select top(100) * from sophia.TURMAS WHERE PERIODO = 125 ORDER BY NOME
select top(100) * from sophia.SALAS
select top(100) * from sophia.ACADEMIC WHERE TURMA = 2350 and DISCIPLINA = 1438 AND MATRICULA = 31407


sp_alunos_lista_chamada_list 91834

select * from SONATA.SOPHIA.sophia.DISCIPLINAS WHERE CODIGO IN(1544, 1341, 1360)
select * from SONATA.SOPHIA.sophia.TURMAS WHERE CODIGO IN(2594,2553,2608)
select * from SONATA.SOPHIA.sophia.TURMAS WHERE NOME like '%ux%'


select top(100) * from sophia.LISTA_CHAM WHERE CODIGO = 91877
select top(100) * from sophia.LISTA_CHAM_WEB WHERE CODIGO = 91877
select top(100) * from sophia.LISTA_CHAM_ALUNOS WHERE AULA = 282303  AND MATRICULA = 31407
select top(100) * from sophia.LISTA_CHAM_ALUNOS_WEB WHERE AULA = 282303  AND MATRICULA = 31407
select top(100) * from sophia.LISTA_CHAM_AULAS WHERE LISTA = 91826
select top(100) * from sophia.LISTA_CHAM_AULAS_WEB WHERE LISTA = 91877
select top(100) * from sophia.ACADEMIC WHERE MATRICULA = 31407 and TURMA = 2350 AND DISCIPLINA = 164

--sp_lista_cham_alunos_faltas_save 31164, 2316, 2, 164

select top(100) * from sophia.LISTA_CHAM WHERE SITUACAO = 1
select top(100) * from sophia.LISTA_CHAM_WEB WHERE SITUACAO = 1



sp_lista_cham_aulas_web_save 87320, 269243, 'asd' 
sp_lista_cham_aulas_web_save 87320, 269244, 'asd' 
sp_lista_cham_aulas_web_save 87320, 269245, 'sad' 
sp_lista_cham_aulas_web_save 87320, 269246, 'sad' 
sp_lista_cham_alunos_web_save 87320, 269243, 31407, 1 
sp_lista_cham_alunos_web_save 87320, 269244, 31407, 1 
sp_lista_cham_alunos_web_save 87320, 269245, 31407, 1 
sp_lista_cham_alunos_web_save 87320, 269246, 31407, 0 
sp_lista_cham_web_save 87320, 1 

sp_lista_cham_alunos_save  269263, 31407
sp_lista_cham_alunos_save  269264, 31407
sp_lista_cham_alunos_save  269265, 31407
sp_lista_cham_alunos_save  269266, 31407
sp_lista_cham_save 87325


DECLARE @tb_listapresenca TABLE(
	CODIGO int
	,RA int
	,ALUNO varchar(200)
	,AULA int
	,MATRICULA int
	,FALTA INT 
)
INSERT @tb_listapresenca
SELECT 
	d.CODIGO
	, d.CODEXT as RA
	, d.NOME as ALUNO
	, b.AULA
	, b.MATRICULA
	, b.FALTA
from sophia.LISTA_CHAM_AULAS a 
inner join sophia.LISTA_CHAM_ALUNOS b on a.CODIGO = b.AULA
inner join sophia.MATRICULA c on b.MATRICULA = c.CODIGO
inner join sophia.FISICA d on c.FISICA = d.CODIGO
where a.LISTA = 87320

SELECT * FROM @tb_listapresenca


select * from sophia.LISTA_CHAM_ALUNOS
where MATRICULA = 31407 and aula = 269251

select * from sophia.DISCIPLINAS
where CODIGO = 31


select * from sophia.MATRICULA
where FISICA = 23500 


select * from sophia.LISTA_CHAM
where TURMA = 2350 and DISCIPLINA = 31


select * from sophia.LISTA_CHAM_AULAS
where LISTA = 87322




SELECT top(100)* FROM sophia.LISTA_CHAM 


sp_lista_cham_alunos_edit (@aula int, @matricula varchar(20), @falta int);

sp_lista_cham_edit (@codigo int, @tipo_proc int, @situacao int)


select * from sophia.LISTA_CHAM_AULAS
WHERE LISTA IN(
	select CODIGO from sophia.LISTA_CHAM
	where TURMA = 2457 AND DISCIPLINA = 23 AND ETAPA IN (1, 2)
)

select * from sophia.LISTA_CHAM_ALUNOS_WEB 
WHERE AULA IN(
	select CODIGO from sophia.LISTA_CHAM_AULAS_WEB
	WHERE LISTA IN(
		select CODIGO from sophia.LISTA_CHAM_WEB
		where TURMA = 2457 AND DISCIPLINA = 23 AND ETAPA IN (1, 2)
	)
) AND MATRICULA = 32286 AND FALTA = 1

SELECT c.FALTA, * FROM SONATA.SOPHIA.SOPHIA.LISTA_CHAM a
INNER JOIN SONATA.SOPHIA.SOPHIA.LISTA_CHAM_AULAS b ON b.LISTA = a.CODIGO
INNER JOIN SONATA.SOPHIA.SOPHIA.LISTA_CHAM_ALUNOS c ON c.AULA = b.CODIGO
WHERE a.TURMA = 2483 AND a.DISCIPLINA  = 1523 AND c.FALTA <> 0

SELECT * FROM SONATA.SOPHIA.SOPHIA.LISTA_CHAM WHERE TURMA = 2483 AND DISCIPLINA  = 1523
SELECT * FROM SONATA.SOPHIA.SOPHIA.LISTA_CHAM_AULAS 
SELECT TOP(100 )* FROM SONATA.SOPHIA.SOPHIA.LISTA_CHAM_ALUNOS 
SELECT TOP(100 )* FROM SONATA.SOPHIA.SOPHIA.LISTA_CHAM_ALUNOS_WEB 
SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS WHERE NOME LIKE '%JD 1%'
SELECT * FROM SONATA.SOPHIA.SOPHIA.DISCIPLINAS WHERE NOME LIKE '%introdu%jogo%'

SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA a
INNER JOIN SONATA.SOPHIA.SOPHIA.FUNCIONARIOS b ON b.COD_FUNC = a.CODIGO
WHERE b.LECIONA = 1
-------------

declare @idturma int = 1
declare @idalunos varchar(500) = '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20'
declare @faltas varchar(500) =   '0,1,1,1,0,1,1,1,0,1,1,1,1,0,1,1,1,0,0,0'


select ROW_NUMBER() over(ORDER BY NEWID()) as 'row',  * from  dbo.fnSplitTeste(',', @faltas,  @idalunos, @idalunos, @idalunos )



--with tb_result
--as
--(
--      Select id as isfalta from dbo.fnSplit(@faltas,',') 

--)

Select @idturma as idturma, id as idaluno, b.isfalta from dbo.fnSplit(@idalunos,',') a
left join (Select ROW_NUMBER() over(order by isfalta) as idaluno, isfalta from tb_result) b
on a.Id = b.idaluno

sp_alunos_lista_chamada_list 114259
sp_lista_chamada_get 114259

ALTER Function fnSplitTeste ( 
	@Separador nVarchar ( 50 ) , 
	@String Varchar ( max ) , 
	@String2 Varchar ( max ) = '',
	@String3 Varchar ( max ) = '',
	@String4 Varchar ( max ) = ''
)
Returns @Table Table (
	Id nVarchar ( 4000 ),
	Id2 nVarchar ( 4000 ),
	Id3 nVarchar ( 4000 ),
	Id4 nVarchar ( 4000 )
)
As

Begin
	Declare 
		@Temp Varchar ( max ), 
		@Temp2 Varchar ( max ), 
		@Temp3 Varchar ( max ), 
		@Temp4 Varchar ( max )
		
	Declare 
		@Index Int, 
		@Index2 Int,
		@Index3 Int,
		@Index4 Int
		
	Declare 
		@VarTeste Varchar ( max ), 
		@VarTeste2 Varchar ( max ),
		@VarTeste3 Varchar ( max ),
		@VarTeste4 Varchar ( max )
	
	Set @VarTeste =  LTrim ( RTrim ( @String ) ) --Replace ( @Parametros , ' ' , '' )
	Set @VarTeste2 =  LTrim ( RTrim ( @String2 ) )
	Set @VarTeste3 =  LTrim ( RTrim ( @String3 ) )
	Set @VarTeste4 =  LTrim ( RTrim ( @String4 ) )
	
	While @VarTeste <> '' or @VarTeste2 <> '' or @VarTeste3 <> '' or @VarTeste4 <> '' 
		Begin
			Set @Index = Charindex (  @Separador , @VarTeste )
			Set @Index2 = Charindex (  @Separador , @VarTeste2 )
			Set @Index3 = Charindex (  @Separador , @VarTeste3 )
			Set @Index4 = Charindex (  @Separador , @VarTeste4 )
			
			If  @Index > 1 or @Index2 > 1 or @Index3 > 1 or @Index4 > 1 
				Begin
					Set @Temp 	= Left ( @VarTeste , @Index - 1 )
					Set @VarTeste = Right ( @VarTeste , Len ( @VarTeste ) - @Index )
					
					Set @Temp2 	= Left ( @VarTeste2 , @Index2 - 1 )
					Set @VarTeste2 = Right ( @VarTeste2 , Len ( @VarTeste2 ) - @Index2 )
					
					Set @Temp3 	= Left ( @VarTeste3 , @Index3 - 1 )
					Set @VarTeste3 = Right ( @VarTeste3 , Len ( @VarTeste3 ) - @Index3 )
					
					Set @Temp4 	= Left ( @VarTeste4 , @Index4 - 1 )
					Set @VarTeste4 = Right ( @VarTeste4 , Len ( @VarTeste4 ) - @Index4 )
					
					Insert Into @Table Values ( @Temp, @Temp2, @Temp3, @Temp4)			
					Set @Temp = ''
					Set @Index = Charindex (  @Separador , @VarTeste )	
					Set @Temp2 = ''
					Set @Index2 = Charindex (  @Separador , @VarTeste2 )	
					Set @Temp3 = ''
					Set @Index3 = Charindex (  @Separador , @VarTeste3 )	
					Set @Temp4 = ''
					Set @Index4 = Charindex (  @Separador , @VarTeste4 )	
				End
			Else
				Begin
					Insert Into @Table Values ( @VarTeste, @VarTeste2, @VarTeste3, @VarTeste4 )			
					Set @VarTeste = ''	
					Set @VarTeste2 = ''	
					Set @VarTeste3 = ''	
					Set @VarTeste4 = ''	
				End
		End
	Return
End		


