[sophia.MATRICULA]

SELECT * FROM sophia.TITULOS

SELECT * FROM sophia.FISICA WHERE NOME like '%Ricardo Duridan de Carvalho%'

SELECT * FROM sophia.MATRICULA WHERE FISICA = 23351

SELECT * FROM sophia.CURSOS WHERE PRODUTO in (43)
SELECT * FROM sophia.TITULOS WHERE CODPF in(10077)

804511
815046

SELECT * FROM sophia.VENDAS WHERE CODIGO in (27551,28972)

SELECT * FROM sophia.PLANOS_PGTO WHERE CODIGO in (418,750)
SELECT * FROM sophia.PLANOS_PGTO_COND WHERE PLANO_PGTO in(418,750) AND ITEM = 1
SELECT * FROM sophia.PLANOS_PGTO_PARCELAS WHERE PLANO_PGTO_COND in (708,
709,
1295,
1296,
1298) AND NUMERO = 1
 


SELECT c.DESCRICAO, e.VALOR, a.*
FROM sophia.MATRICULA a
INNER JOIN sophia.VENDAS b ON b.CODIGO = a.VENDA
INNER JOIN sophia.PLANOS_PGTO c ON c.CODIGO = b.PLANO_PGTO
INNER JOIN sophia.PLANOS_PGTO_COND d ON d.PLANO_PGTO = c.CODIGO
INNER JOIN sophia.PLANOS_PGTO_PARCELAS e ON e.PLANO_PGTO_COND = d.COD_CONDICAO
WHERE a.FISICA = 16083 AND YEAR(DATA_MATRICULA) = YEAR('2013-03-01') AND 
YEAR(a.DATA_MATRICULA) = YEAR('2014-03-01') AND dbo.fn_get_semestre(a.DATA_MATRICULA) = (dbo.fn_get_semestre('2014-03-01'))
------------------------------------------------------------------------------------------------------------------
select c.DATA_BAIXA, c.CODIGO as TITULO, b.CODIGO ,b.CODEXT AS RA, b.NOME AS ALUNO, e.NOME as CURSO, 
g.vlmensalidade
from sonata.sophia.sophia.MATRICULA a
inner join sonata.sophia.sophia.FISICA b on a.FISICA = b.CODIGO
inner join sonata.sophia.sophia.CURSOS e on a.CURSO = e.PRODUTO
inner join sonata.sophia.sophia.TITULOS c on b.CODIGO = c.CODPF
inner join tb_cursos_FIT_Sophia f on e.produto = f.idcurso_sophia
inner join tb_curso_valores g on f.idcurso_fit = g.curso_id
where a.TURMA_REGULAR = 2371 
	and c.DATA_BAIXA between '2014-01-01' and '2014-01-30' 
	and g.idperiodo = 1 and g.status = 1
order by b.NOME, c.DATA_BAIXA, b.CODEXT

sonata..sophia.sp_desconto_mensalidade_aluno_fit_get 24781, '03', '2013'

select * FROM sonata.sonata

SELECT * FROM tb_curso_valores

select DISTINCT c.DATA_BAIXA, c.CODIGO as TITULO, b.CODIGO ,b.CODEXT AS RA, b.NOME AS ALUNO, e.NOME as CURSO, 
g.vlmensalidade, k.VALOR, i.DESCRICAO
from sonata.sophia.sophia.MATRICULA a
inner join sonata.sophia.sophia.FISICA b on a.FISICA = b.CODIGO
inner join sonata.sophia.sophia.CURSOS e on a.CURSO = e.PRODUTO
inner join sonata.sophia.sophia.TITULOS c on b.CODIGO = c.CODPF
inner join tb_cursos_FIT_Sophia f on e.produto = f.idcurso_sophia
inner join tb_curso_valores g on f.idcurso_fit = g.curso_id
INNER JOIN sonata.sophia.sophia.VENDAS h ON h.CODIGO = a.VENDA
INNER JOIN sonata.sophia.sophia.PLANOS_PGTO i ON i.CODIGO = h.PLANO_PGTO
INNER JOIN sonata.sophia.sophia.PLANOS_PGTO_COND j ON j.PLANO_PGTO = i.CODIGO AND j.ITEM = 1
INNER JOIN sonata.sophia.sophia.PLANOS_PGTO_PARCELAS k ON k.PLANO_PGTO_COND = j.COD_CONDICAO AND k.NUMERO = 1
where a.TURMA_REGULAR = 2459 
	and c.DATA_BAIXA between '2014-03-03' and '2014-03-31' 
	and g.idperiodo = 1 and g.status = 1
	AND YEAR(a.DATA_MATRICULA) = YEAR('2014-03-03') 
	AND dbo.fn_get_semestre(a.DATA_MATRICULA) = (dbo.fn_get_semestre('2014-03-03'))
order by b.NOME, c.DATA_BAIXA, b.CODEXT


select DISTINCT c.DATA_BAIXA, 
c.CODIGO as TITULO, b.CODIGO ,b.CODEXT AS RA, 
b.NOME AS ALUNO, e.NOME as CURSO, g.vlmensalidade, 
k.VALOR, i.DESCRICAO, a.DATA_MATRICULA, dbo.fn_get_semestre(a.DATA_MATRICULA) as nrsemestre, a.DATA_MATRICULA
from sonata.sophia.sophia.MATRICULA a
inner join sonata.sophia.sophia.FISICA b on a.FISICA = b.CODIGO
inner join sonata.sophia.sophia.CURSOS e on a.CURSO = e.PRODUTO
inner join sonata.sophia.sophia.TITULOS c on b.CODIGO = c.CODPF
inner join tb_cursos_FIT_Sophia f on e.produto = f.idcurso_sophia
inner join tb_curso_valores g on f.idcurso_fit = g.curso_id
INNER JOIN sonata.sophia.sophia.VENDAS h ON h.CODIGO = a.VENDA
INNER JOIN sonata.sophia.sophia.PLANOS_PGTO i ON i.CODIGO = h.PLANO_PGTO
INNER JOIN sonata.sophia.sophia.PLANOS_PGTO_COND j ON j.PLANO_PGTO = i.CODIGO
INNER JOIN sonata.sophia.sophia.PLANOS_PGTO_PARCELAS k ON k.PLANO_PGTO_COND = j.COD_CONDICAO
where a.TURMA_REGULAR = 2459 
	and c.DATA_BAIXA between '2014-03-01' and '2014-04-30' 
	and g.idperiodo = 1 and g.status = 1 
	AND YEAR(a.DATA_MATRICULA) = YEAR('2014-03-01') 
	AND dbo.fn_get_semestre(a.DATA_MATRICULA) = (dbo.fn_get_semestre('2014-03-01'))
group by c.DATA_BAIXA, c.CODIGO, b.CODIGO ,b.CODEXT, b.NOME, e.NOME, g.vlmensalidade, k.VALOR, i.DESCRICAO, dbo.fn_get_semestre(a.DATA_MATRICULA), a.DATA_MATRICULA 
order by e.NOME, b.NOME, c.DATA_BAIXA, b.CODEXT


CREATE FUNCTION dbo.fn_get_semestre
(@data datetime)
RETURNS int
/*
  app:Sophia
  author: Massaharu
  date: 1/03/2014
*/
AS
BEGIN
	DECLARE @SEMESTER int
	IF(MONTH(@data) <= 6)
	BEGIN
		SET @SEMESTER = 1      
	END
	ELSE
	BEGIN
		SET @SEMESTER = 2
	END
	
	RETURN @SEMESTER 
END

SELECT  dbo.fn_get_semestre('2014-01-02')


SELECT c.DESCRICAO, e.VALOR, a.*
FROM sonata.sophia.sophia.MATRICULA a
INNER JOIN sonata.sophia.sophia.VENDAS b ON b.CODIGO = a.VENDA
INNER JOIN sonata.sophia.sophia.PLANOS_PGTO c ON c.CODIGO = b.PLANO_PGTO
INNER JOIN sonata.sophia.sophia.PLANOS_PGTO_COND d ON d.PLANO_PGTO = c.CODIGO
INNER JOIN sonata.sophia.sophia.PLANOS_PGTO_PARCELAS e ON e.PLANO_PGTO_COND = d.COD_CONDICAO
WHERE a.FISICA = 16083 AND YEAR(DATA_MATRICULA) = YEAR('2013-03-01') 
AND dbo.fn_get_semestre(a.DATA_MATRICULA) = (dbo.fn_get_semestre('2014-03-01'))
--

select DISTINCT c.DATA_BAIXA, c.CODIGO as TITULO, b.CODIGO ,b.CODEXT AS RA, b.NOME AS ALUNO, e.NOME as CURSO, 
g.vlmensalidade, k.valor, i.descricao, k.PLANO_PGTO_COND, j.DESCRICAO as plano_pag_cond
from sonata.sophia.sophia.MATRICULA a
inner join sonata.sophia.sophia.FISICA b on a.FISICA = b.CODIGO
inner join sonata.sophia.sophia.CURSOS e on a.CURSO = e.PRODUTO
inner join sonata.sophia.sophia.TITULOS c on b.CODIGO = c.CODPF
inner join tb_cursos_FIT_Sophia f on e.produto = f.idcurso_sophia
inner join tb_curso_valores g on f.idcurso_fit = g.curso_id
INNER JOIN sonata.sophia.sophia.VENDAS h ON h.CODIGO = a.VENDA
INNER JOIN sonata.sophia.sophia.PLANOS_PGTO i ON i.CODIGO = h.PLANO_PGTO
INNER JOIN sonata.sophia.sophia.PLANOS_PGTO_COND j ON j.PLANO_PGTO = i.CODIGO AND j.item = 1
INNER JOIN sonata.sophia.sophia.PLANOS_PGTO_PARCELAS k ON k.PLANO_PGTO_COND = j.COD_CONDICAO AND k.NUMERO = 1
where a.TURMA_REGULAR = 2459 
	and c.DATA_BAIXA between '2014-03-01' and '2014-04-30' 
	and g.idperiodo = 1 and g.status = 1
	AND YEAR(a.DATA_MATRICULA) = YEAR('2014-04-30') 
	AND dbo.fn_get_semestre(a.DATA_MATRICULA) = (dbo.fn_get_semestre('2014-04-30'))
order by b.NOME, c.DATA_BAIXA, b.CODEXT
---------------------------

select c.DATA_BAIXA, c.CODIGO as TITULO, b.CODIGO ,b.CODEXT AS RA, b.NOME AS ALUNO, e.NOME as CURSO, 
g.vlmensalidade
from sonata.sophia.sophia.MATRICULA a
inner join sonata.sophia.sophia.FISICA b on a.FISICA = b.CODIGO
inner join sonata.sophia.sophia.CURSOS e on a.CURSO = e.PRODUTO
inner join sonata.sophia.sophia.TITULOS c on b.CODIGO = c.CODPF
inner join tb_cursos_FIT_Sophia f on e.produto = f.idcurso_sophia
inner join tb_curso_valores g on f.idcurso_fit = g.curso_id
where a.TURMA_REGULAR = 2459 
	and c.DATA_BAIXA between '2014-03-01' and '2014-04-30' 
	and g.idperiodo = 1 and g.status = 1
order by b.NOME, c.DATA_BAIXA, b.CODEXT