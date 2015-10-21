
--PROCESSO SELETIVOS
[sophia.CONCURSOS]

select * from sophia.CONCURSOS
where DESCRICAO like '%11/12/2013 - Processo Seletivo Agendado%'

---------------------------------------------------------------
--CLIENTES - processo seletivo

[sophia.CONC_CLI]

select b.NOME, a.* from sophia.CONC_CLI a
inner join sophia.FISICA b on a.FISICA = b.CODIGO
where CONCURSO = 165
order by b.NOME

---------------------------------------------------------
--ESTABELECIMENTO - processo seletivo

[sophia.CONC_GRUPOS_ESC]

select * from sophia.CONC_GRUPOS_ESC
where COD_ESC = 160

select * from sophia.CONC_GRUPOS
where COD_GRUPO = 166
-------------------------------------------------------
--UNIDADES- processo seletivo

select * from sophia.UNIDADES
where CODIGO = 1

-------------------------------------------------------
--SALAS- processo seletivo

select * from sophia.SALAS
where CODIGO = 14



-------------------------------------------------------
--OPÇÕES - processo seletivo

[sophia.CONC_OPCAO]

select * from sophia.CONC_OPCAO
where CONCURSO = 165

select b.NOME, c.DESCRICAO, a.* from sophia.CONC_OPCAO a
inner join sophia.CURSOS b on a.CURSO = b.PRODUTO
inner join sophia.TURNOS c on a.TURNO = c.CODIGO
where a.CODIGO = 946

select b.NOME, c.DESCRICAO, a.* from sophia.CONC_OPCAO a
inner join sophia.CURSOS b on a.CURSO = b.PRODUTO
inner join sophia.TURNOS c on a.TURNO = c.CODIGO
where a.CONCURSO = 165



select * from sophia.CONC_RESULT
where CONCURSO = 165


select * from sophia.FORMAPGTO


select * from sophia.
