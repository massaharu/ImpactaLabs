



declare @turma int
declare @dt1 datetime
declare @dt2 datetime

set @turma = 2116
set @dt1 = '2013-01-01 00:00:00'
set @dt2 = '2013-01-31 23:59:59'

select c.DATA_BAIXA, c.CODIGO as TITULO, b.CODIGO ,b.CODEXT AS RA, b.NOME AS ALUNO, e.NOME as CURSO, d.VALOR as PGTO, 
g.vlmensalidade
from sonata.sophia.sophia.MATRICULA a
inner join sonata.sophia.sophia.FISICA b on a.FISICA = b.CODIGO
inner join sonata.sophia.sophia.CURSOS e on a.CURSO = e.PRODUTO
inner join sonata.sophia.sophia.TITULOS c on b.CODIGO = c.CODPF
inner join sonata.sophia.sophia.TIT_PGTO d on c.CODIGO = d.TITULO
inner join tb_cursos_FIT_Sophia f on e.produto = f.idcurso_sophia
inner join tb_curso_valores g on f.idcurso_fit = g.curso_id
where a.TURMA_REGULAR = @turma and c.DATA_BAIXA between @dt1 and @dt2 and g.idperiodo = 1
order by c.DATA_BAIXA, b.NOME, b.CODEXT
--where a.TURMA_REGULAR = @turma and c.DATA_VCTO between @dt1 and @dt2 and g.idperiodo = 1
--order by d.DATA_EFETIVA, b.NOME, b.CODEXT


declare @turma int
declare @dt1 datetime
declare @dt2 datetime

set @turma = 2116
set @dt1 = '2013-01-01 00:00:00'
set @dt2 = '2013-01-31 23:59:59'

select c.DATA_BAIXA, c.CODIGO as TITULO, b.CODIGO ,b.CODEXT AS RA, b.NOME AS ALUNO, e.NOME as CURSO, 
g.vlmensalidade
from sonata.sophia.sophia.MATRICULA a
inner join sonata.sophia.sophia.FISICA b on a.FISICA = b.CODIGO
inner join sonata.sophia.sophia.CURSOS e on a.CURSO = e.PRODUTO
inner join sonata.sophia.sophia.TITULOS c on b.CODIGO = c.CODPF
inner join tb_cursos_FIT_Sophia f on e.produto = f.idcurso_sophia
inner join tb_curso_valores g on f.idcurso_fit = g.curso_id
where a.TURMA_REGULAR = @turma and c.DATA_BAIXA between @dt1 and @dt2 and g.idperiodo = 1
order by c.DATA_BAIXA, b.NOME, b.CODEXT





select * from tb_cursos_FIT_Sophia

select * from tb_curso_valores

select * from tb_periodo






select * from sophia.FISICA
where CODEXT = '1410010'

-- 23744


-- valor da mensalidade bruto


[sophia.TITULOS]

select * from sophia.TITULOS
where CODPF = 23744

select * from sophia.TITULOS
where CODIGO = 755533

select * from sophia.movfin
where TITULO = 755533

-- valor que o aluno pagou
select VALOR from sophia.TIT_PGTO
where TITULO = 755533

-- desconto
select * from sophia.MODALIDADE_DESCONTO
where CODIGO = 404




select * from sophia.MATRICULA
where FISICA = 16083

select * from sophia.ITENS
where VENDA = 28974


select c.* from sophia.MATRICULA a
inner join sophia.ITENS b on a.VENDA = b.VENDA
inner join sophia.MODALIDADE_DESCONTO c on b.DESC_ANTECIPACAO = c.CODIGO


select * from sophia.PERIODOS
--114 - 2013/1

select * from sophia.TURMAS
where PERIODO = 114
order by NOME
-- 2116  - SI 1A

declare @turma int
declare @dt1 datetime
declare @dt2 datetime

set @turma = 2116
set @dt1 = '2013-01-01 00:00:00'
set @dt2 = '2013-01-31 23:59:59'

select d.DATA_EFETIVA, b.CODIGO ,b.CODEXT AS RA, b.NOME AS ALUNO, e.NOME as CURSO, d.VALOR as PGTO
from sophia.MATRICULA a
inner join sophia.FISICA b on a.FISICA = b.CODIGO
inner join sophia.CURSOS e on a.CURSO = e.PRODUTO
inner join sophia.TITULOS c on b.CODIGO = c.CODPF
inner join sophia.TIT_PGTO d on c.CODIGO = d.TITULO
where a.TURMA_REGULAR = @turma and c.DATA_VCTO between @dt1 and @dt2
order by d.DATA_EFETIVA, b.NOME, b.CODEXT





select * from sophia.TITULOS
where CODIGO = 759481

select * from sophia.MOVFIN
where TITULO = 759481

select * from sophia.TIT_PGTO
where TITULO = 759481

[sophia.TITULOS]

select b.CODIGO ,b.CODEXT AS RA, b.NOME AS ALUNO, e.NOME as CURSO, d.VALOR as PGTO 
from sophia.MATRICULA a 
inner join sophia.FISICA b on a.FISICA = b.CODIGO 
inner join sophia.CURSOS e on a.CURSO = e.PRODUTO 
inner join sophia.TITULOS c on b.CODIGO = c.CODPF 
inner join sophia.TIT_PGTO d on c.CODIGO = d.TITULO 
where a.TURMA_REGULAR = 2116 and c.DATA_VCTO between 2013-01-01 and 2013-01-31







