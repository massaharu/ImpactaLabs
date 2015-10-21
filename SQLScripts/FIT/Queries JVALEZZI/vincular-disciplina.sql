



select * from sophia.FISICA
where CODEXT = '9200234'

select * from sophia.MATRICULA
where FISICA = 5189
-- 31784

[sophia.academic]

select * from sophia.academic
where MATRICULA = 31784

select * from sophia.TURMAS
WHERE PERIODO = 117
--2310 - BD 3A
--1195 - Data Warehousing I


insert into sophia.academic(MATRICULA,TIPO_MATR,TURMA,DISCIPLINA,ORDEM,NUM_CHAMADA,CARGA_HORARIA)
values(31784,2,2310,1195,2,38,80)

--update sophia.academic set CARGA_HORARIA = 80
--where MATRICULA = 31559 and TURMA = 2304


select * from sophia.QC
where TURMA = 2310

select * from sophia.DISCIPLINAS
where CODIGO in(1195)



---------------------------------comparar com a matricula do azzi------------------------------

select * from sophia.MATRICULA
where FISICA = 16083
--31381

select * from sophia.academic
where MATRICULA = 31381




