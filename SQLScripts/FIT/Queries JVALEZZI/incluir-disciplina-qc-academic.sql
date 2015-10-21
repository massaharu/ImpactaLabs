
----------------------------- ADICIONAR DISICPLINA NO QC DA TURMA E NO ACADEMIC DOS ALUNOS------------------------

SELECT * FROM SOPHIA.PERIODOS
-- 112 2013

SELECT * FROM SOPHIA.TURMAS
WHERE PERIODO = 112
-- 2246 MBA - GP_15

SELECT * FROM SOPHIA.SERIE
WHERE CODIGO = 608

SELECT * FROM SOPHIA.CURRICULO
WHERE CODIGO = 222

SELECT B.NOME ,A.* FROM SOPHIA.GRADES A
INNER JOIN SOPHIA.DISCIPLINAS B ON A.DISCIPLINA = B.CODIGO
WHERE SERIE = 608

-- DISICPLINA ----------- COD.DISICPLINA --- COD.GRADE
--Governança Corporativa    1606				3864
--Marketing					1608				3865
--Tecnologia da Informação  1610				3866
--Projeto Aplicado			1612				3867

select * from sophia.DISCIPLINAS
where CODIGO in(1606,1608,1610,1612)

-- no campo grade é o codigo da grade referente a disicplina(SOPHIA.GRADES) - caso a disciplina não esteja 
-- inserida na grade, insira pelo Sophia e pegue o código gerado na tabela

SELECT B.NOME ,A.* FROM SOPHIA.QC A
INNER JOIN SOPHIA.DISCIPLINAS B ON A.DISCIPLINA = B.CODIGO
WHERE TURMA = 2246
ORDER BY ORDEM


------ inseri no QC da turma-------------------------------------------------------------
--begin tran

--select @@TRANCOUNT

--insert into sophia.QC(TURMA,DISCIPLINA,ORDEM,TIPO,CH,CREDITOS,TEM_NOTAS,REPROVA,REPROVA_NOTA,TIPO_NOTA,
--AD1,AD2,AD3,AD4,AD5,AD6,AD7,AD8,AD9,AD10,AD11,AD12,TAREFAS1,TAREFAS2,TAREFAS3,TAREFAS4,TAREFAS5,TAREFAS6,TAREFAS7,
--TAREFAS8,TAREFAS9,TAREFAS10,TAREFAS11,TAREFAS12,GRADE,CHSEMANAL,APURACAO_FREQUENCIA,LANCAMENTO_FREQUENCIA,OBRIGATORIO,
--AL_VIG,AL_MAX,CH_TEORIA,CH_PRATICA,CH_PRESENCIAL,CH_N_PRESENCIAL,prof_altera_plano,QtdeAvals,EXIBE_ATAS_FINAIS)
--values(2246,1612,20,0,22,0,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,3867,0,0,0,1,39,43,0,0,20,0,1,0,1)

--commit

-------------------------------------------------------------------------------------------------------

[sophia.academic]

select * from sophia.academic
where TURMA = 2246 and DISCIPLINA = 1606
order by ORDEM, NUM_CHAMADA


------ inseri no ACADEMIC de cada aluno--------------------------------------------

--begin tran

--select @@TRANCOUNT

--insert into sophia.academic(MATRICULA,TIPO_MATR,TURMA,DISCIPLINA,ORDEM,NUM_CHAMADA,CARGA_HORARIA,SITUACAO)
--select MATRICULA,0,2246,1612,22,NUM_CHAMADA,20,0 from sophia.academic
--where TURMA = 2246 and DISCIPLINA = 243
--order by ORDEM, NUM_CHAMADA

--commit
----------------------------------------------------------------------------



