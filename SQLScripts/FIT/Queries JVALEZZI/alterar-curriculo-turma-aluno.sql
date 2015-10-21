

select * from sophia.TURMAS
where PERIODO = 112

--2417 AI_09


select * from sophia.TURMAS
where CODIGO = 2417

--590 198

select * from sophia.MATRICULA
where TURMA_REGULAR = 2417


select * from sophia.CURRICULO
where DESCRICAO = 'Grade ES_10'

--198 Grade_AI_08

select * from sophia.CURSOS
where PRODUTO = 33

--34	Pós-Graduação em Arquitetura da Informação

select * from sophia.SERIE
where CURSO = 33 and CURRICULO = 266

SELECT * FROM SOPHIA.MATRICULA
where TURMA_REGULAR = 2415

select * from sophia.FISICA
where CODEXT = '1410010'

-- 590

select * from sophia.GRADES
where SERIE = 590

select b.CODIGO,b.NOME,a.* from sophia.GRADES a
inner join sophia.DISCIPLINAS b on a.DISCIPLINA = b.CODIGO
where a.SERIE = 590

select * from sophia.QC
where TURMA = 2274

select b.CODIGO,b.NOME,a.* from sophia.QC a
inner join sophia.DISCIPLINAS b on a.DISCIPLINA = b.CODIGO
where a.TURMA = 2274

select * from sophia.academic
where TURMA = 2274 

select * from sophia.DISCIPLINAS
where NOME like '%cultura organizacional%'

--1547 Cultura Organizacional

select * from sophia.GRADES
where SERIE = 607 and DISCIPLINA = 95

select * from sophia.QC
where TURMA = 2410 and DISCIPLINA = 95

select * from sophia.academic
where TURMA = 2410 and DISCIPLINA = 95

-------------------------------------------------------------------------------

select * from sophia.PERIODOS
--117 2013/2
--120 2014/1

select * from sophia.TURMAS
where PERIODO = 120
--2425 ADS 1B Noite
--2400 ADS 1A Manhã

--2441 BD 2A - Curriculo antigo
--2494 BD 2A

select * from sophia.TURMAS
where CODIGO in(2441,2494)

select * from sophia.CURRICULO
where DESCRICAO like '%BD 2010/1%'
--261 ADS 20141

--262 BD 20141

select * from sophia.SERIE
where CURRICULO = 262
--668 1º Semestre 261

-- 674 2º Semestre 262 - BD

select * from sophia.CURSOS
where PRODUTO = 57


--update sophia.TURMAS set SERIE = 674, CURRICULO = 262
--where CODIGO = 2441

select * from sophia.MATRICULA
where TURMA_REGULAR = 2494

--update sophia.MATRICULA set CURRICULO = 262
--where TURMA_REGULAR = 2494


select * from sophia.FISICA
where CODEXT = '1203003'

select * from sophia.MATRICULA
where FISICA = 23408




