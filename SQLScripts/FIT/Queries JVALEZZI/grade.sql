
use sophia


select * from sophia.FISICA
where NOME like '%Gabriel Barbosa%'


select * from sophia.MATRICULA
where FISICA = 23394

----------------------------------------------------------------------------------------------------
--passo a passo para alterar o curriculo de um turma
select * from sophia.TURMAS
where nome like 'ADM%' and periodo = 117

--2296	ADM 2A
--2298	ADM 4A
--2300	ADM 5A
--2301	ADM 6A
--2302	ADM 7A
--2303	ADM 8A

select * from sophia.CURSOS
where NOME like '%Administração%'

--42 -> ADM

select * from sophia.CURRICULO
where CURSO = 42

--250 -> ADM 20132

select * from sophia.SERIE
where CURSO = 42 and CURRICULO = 250

--644	1º Semestre
--645	2º Semestre
--646	3º Semestre
--647	4º Semestre
--648	5º Semestre
--649	6º Semestre
--650	7º Semestre
--651	8º Semestre


--update sophia.TURMAS set SERIE = 651, CURRICULO = 250
--where CODIGO = 2303


--update sophia.MATRICULA set SERIE = 651, CURRICULO = 250
--where CURSO = 42 AND SERIE = 579 AND PERIODO = 117 AND CURRICULO = 114


select * from sophia.TURMAS
where nome like 'ADM%' and periodo = 117
--2303 ADM 8A
-- serie: 578
-- curriculo: 114

select * from sophia.MATRICULA
where CURSO = 42 AND SERIE = 651 AND PERIODO = 117 AND CURRICULO = 250

---------------------------------------------------------------
select * from sophia.SERIE
where CURSO = 42 and CURRICULO = 250

select * from sophia.SERIE
where CODIGO = 651
---------------------------------------------------------------
select * from sophia.CURRICULO
where CODIGO = 250
----------------------------------------------------------------
select * from sophia.QC
where TURMA = 2302
order by DISCIPLINA


select * from sophia.FORMULAS
where CODIGO = 5431

select * from sophia.GRADES
where SERIE = 651
order by DISCIPLINA

-- VINCULAR DISCIPLINA Estágio Profissional NO ACADEMICO DOS ALUNOS DA TURMA DE ADM6A ---------------------------

select * from sophia.DISCIPLINAS
where NOME like '%Atividades Complementares%'


--insert into sophia.QC(TURMA,DISCIPLINA,ORDEM,tipo,TEM_NOTAS,REPROVA,REPROVA_NOTA,TIPO_NOTA,GRADE,APURACAO_FREQUENCIA,
--LANCAMENTO_FREQUENCIA)
--values(2303,382,9,0,1,1,1,0,3614,0,2)

--UPDATE sophia.QC SET GRADE = 3465
--WHERE CODIGO = 13670

select * from sophia.GRADES
where DISCIPLINA = 382



select * from sophia.DISCIPLINAS
where CODIGO = 874

select * from sophia.GRADES
where SERIE = 474

select * from sophia.SERIE
where CODIGO = 474

select * from sophia.CURRICULO
where CODIGO = 250



select * from sophia.DISCIPLINAS
where CODIGO in(220,45,1010,874,1012,207,330,1014)

select * from sophia.GRADES
where DISCIPLINA in(220,45,1010,874,1012,207,330,1014) and serie = 474


select * from sophia.QC
where CODIGO = 13670

--insert into sophia.QC(TURMA,DISCIPLINA,ORDEM,tipo,TEM_NOTAS,REPROVA,REPROVA_NOTA,TIPO_NOTA,APURACAO_FREQUENCIA,
--LANCAMENTO_FREQUENCIA)
--values(2314,1493,6,0,1,1,1,0,0,2)

--UPDATE sophia.QC SET GRADE = 3465
--WHERE CODIGO = 13670


select * from sophia.DISCIPLINAS
where NOME like '%novas midias%'

--1493

select * from sophia.DISCIPLINAS
where NOME like '%Introdução a Circuitos Digitais%'

select * from sophia.TURMAS
where CODIGO = 2253 

--update sophia.TURMAS set SERIE = 636, CURRICULO = 245
--where CODIGO = 2252

select * from sophia.SERIE
where CODIGO = 636
--636

select * from sophia.CURRICULO
WHERE DESCRICAO LIKE '%rc%'
where CODIGO = 245
--245

select * from sophia.CURRICULO_PADRAO
where PRODUTO = 39

select * from sophia.MOVIMENTACOES WHERE curriculo_anterior = 13

select * from sophia.MODULOS
select * from sophia.PRE_REQUISITOS
select * from sophia.COMP_GRADE

select * from [sophia.GRADES]
where SERIE = 636

select * from sophia.COMP_GRADE
select * from sophia.EQUIVALENCIA
select * from sophia.PRE_REQUISITOS
select * from sophia.MATRIZ_CURRICULAR



select * from sophia.DISCIPLINAS
where CODIGO in(167,55,170,376,1497,377,191)

select * from sophia.GRADE_SETOR

select * from sophia.CURSOS
where PRODUTO = 39


select * from sophia.NIVEL


select * from sophia.MATRICULA
where TURMA_REGULAR = 2252


select * from sophia.DISCIPLINAS
where NOME like '%Princípios de Tele%'





