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
where TURMA = 2350

select * from sophia.LISTA_CHAM
where TURMA = 2252 and DISCIPLINA = 170

select * from sophia.TURMAS
where PERIODO = 117 and NOME like '%RC 1A%'

select * from sophia.DISCIPLINAS
where NOME like '%Introdução a Redes de Computadores%'



select * from sophia.LISTA_CHAM
where codigo = 75016

select * from sophia.TURMAS
where CODIGO = 2019

select * from sophia.DISCIPLINAS
where CODIGO = 469

select * from sophia.LISTA_CHAM
where SITUACAO not in(0,4)

---------------------------------------------------------------------------------------------------------

/*Nesta tabela ficam armazenadas a quantidade de aulas de cada lista, gerando um código para cada aula*/

-- campo MATERIA - onde é salvo a materia lecionada do dia - pelo CODIGO da aula
select * from sophia.LISTA_CHAM_AULAS
where LISTA = 91304

select * from sophia.LISTA_CHAM_AULAS
where LISTA = 75016

select * from sophia.LISTA_CHAM_AULAS
where LISTA = 87321

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

select * from sophia.LISTA_CHAM_ALUNOS


select * from sophia.LISTA_CHAM_ALUNOS
where MATRICULA = 31407

select * from sophia.LISTA_CHAM_ALUNOS
where AULA in(269247
,269248
,269249
,269250)

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

select * from sophia.LISTA_CHAM_WEB
where CODIGO = 87321

select * from sophia.LISTA_CHAM_AULAS_WEB
where LISTA = 87321

select * from sophia.LISTA_CHAM_ALUNOS_WEB
where AULA in(269247,269248,269249,269250)



select * from sophia.LISTA_CHAM
where CODIGO = 87329

select * from sophia.LISTA_CHAM_WEB
where CODIGO = 87329

select * from sophia.LISTA_CHAM_AULAS_WEB
where LISTA = 87329

select * from sophia.LISTA_CHAM_AULAS
where LISTA = 87329

select * from sophia.LISTA_CHAM_ALUNOS_WEB
where AULA in(269279,269280,269281,269282)







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


select * from sophia.LISTA_CHAM 
where TURMA = 2350 and DISCIPLINA = 6

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

------------------------------------PROCEDURES--------------------------------------------------

sp_turmas_professor_list 4170,'2013/2,2013'

alter proc sp_turmas_professor_list
(@codprofessor int, @desperido varchar(22))
AS
/*
	url: ,
	data: 26/09/2013
	author: Maluf
*/

select b.CODIGO as IDTURMA, b.NOME as TURMA, c.CODIGO as IDDISCIPLINA, c.NOME as DISCIPLINA 
from sophia.QC a
inner join sophia.TURMAS b on a.TURMA = b.CODIGO
inner join sophia.DISCIPLINAS c on a.DISCIPLINA = c.CODIGO
inner join sophia.PERIODOS d on b.PERIODO = d.CODIGO
where a.PROFESSOR = @codprofessor and d.DESCRICAO in(SELECT id FROM fnSplit(@desperido, ','))
order by b.NOME,c.NOME 

select * from sophia.FISICA
where NOME like '%ricardo ro%'


select * from sophia.TURMAS
where PERIODO = 117


select * from sophia.PERIODOS


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
select a.CODIGO, a.DATA, '1 - ' + cast(a.AULAS_CONSE as CHAR(1)) as QTDE_AULAS, c.NOME as TURMA, b.NOME as DISCIPLINA,
d.DESCRICAO as SALA, a.SITUACAO
from sophia.LISTA_CHAM a 
inner join sophia.DISCIPLINAS b on a.DISCIPLINA = b.CODIGO
inner join sophia.TURMAS c on a.TURMA = c.CODIGO
inner join sophia.SALAS d on a.SALA = d.CODIGO
where a.TURMA = @turma and a.DISCIPLINA = @disciplina
order by a.DATA, a.CODIGO

sp_lista_chamada_list 2350,6
-------------------------------------------------------------------------------------------------------

alter proc sp_alunos_lista_chamada_list
(@lista int)
AS
/*
	url: ,
	data: 25/09/2013
	author: Maluf
*/

select d.CODIGO, d.CODEXT as RA, d.NOME as ALUNO, b.* from sophia.LISTA_CHAM_AULAS a 
inner join sophia.LISTA_CHAM_ALUNOS b on a.CODIGO = b.AULA
inner join sophia.MATRICULA c on b.MATRICULA = c.CODIGO
inner join sophia.FISICA d on c.FISICA = d.CODIGO
where a.LISTA = @lista


sp_alunos_lista_chamada_list 87320
--87320

------------------------------------------------------------------------

alter proc sp_lista_chamada_web_get
(@lista int)
AS
/*
	url: ,
	data: 25/09/2013
	author: Maluf
*/
select CODIGO from sophia.LISTA_CHAM_WEB
WHERE CODIGO = @lista

-- no botão FINALIZAR alterar o status da lista para 4(PROCESSADA) e alterar o tipo_proc


select * from sophia.LISTA_CHAM
where CODIGO = 85050
































