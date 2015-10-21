



select * from sophia.FISICA
where CODEXT = '1202370'


select * from sophia.MATRICULA
where FISICA = 19898
--0 - ativo
--1 - trancado
--2 - cancelamento
--3 - transferido
--4 - evasão
--5 - concluido


select * from sophia.PERIODOS
--95 - 2012/2
--114 - 2013/1
--117 - 2013/2
--120 - 2014/1


select * from sophia.CURSOS
where PRODUTO in(23,26)
--23 - Mecatrônica
--26 - Telecomunicações



select * from sophia.FISICA
where CODEXT = '1202955'

select * from sophia.MATRICULA
where FISICA = 23263

------------------------------------------------------------------------------------------------

select * from sophia.FISICA
where CODEXT = '1201505'
--nome - cpf - dtnasc - sexo - raça(join sophia.raca)

select * from sophia.DADOSPF
where FISICA = 16083
--nacionalidade(join sophia.nacionalidades) - local nasc.(join sophia.cidades)

select * from sophia.CIDADES
where CODIGO = 1266

select * from sophia.UNIDADE_FEDERATIVA
where CODIGO = 26

select * from sophia.FAMILIAS
where CODIGO = 5632
--mãe

select b.PRODUTO, b.NOME, c.DESCRICAO from sophia.MATRICULA a
inner join sophia.CURSOS b on a.CURSO = b.PRODUTO
inner join sophia.TURNOS c on a.TURNO = c.CODIGO
--where FISICA = 16083
where a.CODIGO = 31381
--cod.curso - curso - turno

--situação do vinculo do aluno no curso

-------------------------------------------------------------------------------------------------
select * from sophia.MATRICULA a 
inner join sophia.FISICA b on a.FISICA = b.CODIGO
inner join sophia.DADOSPF c on b.CODIGO = c.FISICA
inner join sophia.FAMILIAS d on c.FAMILIA = d.CODIGO
inner join sophia.CURSOS e on a.CURSO = e.PRODUTO
inner join sophia.TURNOS f on a.TURNO = f.CODIGO
where a.FISICA in(
	select distinct FISICA from sophia.MATRICULA
	where PERIODO = 117 and 
	CURSO not in(23,26) 
	-- and STATUS = 5
)
and a.PERIODO = 120
and a.STATUS = 0

----------------------------------------------- CENSO 2013 --------------------------------------------------

-- ATIVOS(cursando)

select b.NOME as Aluno, b.CPF, convert(varchar(20),b.DATANASC,103) as DT_NASC, b.SEXO, d.MAE_NOME as MAE, 
g.DESCRICAO as RAÇA, h.DESCRICAO as NACIONALIDADE,'Brasil' as PAÍS, j.SIGLA as UF_NASC, 
i.DESCRICAO as CIDADE_NASC, e.PRODUTO as COD_CURSO, e.NOME as CURSO, f.DESCRICAO as TURNO
from sophia.MATRICULA a 
inner join sophia.FISICA b on a.FISICA = b.CODIGO
inner join sophia.DADOSPF c on b.CODIGO = c.FISICA
inner join sophia.RACA g on b.RACA = g.CODIGO
inner join sophia.NACIONALIDADES h on c.NACIONALIDADE = h.CODIGO
left join sophia.CIDADES i on c.LOCAL_NASC = i.CODIGO
left join sophia.UNIDADE_FEDERATIVA j on i.UF = j.CODIGO
left join sophia.FAMILIAS d on c.FAMILIA = d.CODIGO
inner join sophia.CURSOS e on a.CURSO = e.PRODUTO
inner join sophia.TURNOS f on a.TURNO = f.CODIGO
where a.FISICA in(
	select distinct FISICA from sophia.MATRICULA
	where PERIODO = 120 and 
	CURSO not in(23,26)
	--and STATUS = 0
)
--and a.PERIODO = 117
--a.PERIODO = 114
and a.PERIODO in(114,117)
and a.STATUS = 5
group by b.NOME,b.CPF,convert(varchar(20),b.DATANASC,103),b.SEXO,d.MAE_NOME,g.DESCRICAO,h.DESCRICAO,j.SIGLA, 
i.DESCRICAO,e.PRODUTO,e.NOME,f.DESCRICAO
order by b.NOME

------------------------------------------------------------------------------------------------------------------

--TRANCADA

select b.NOME as Aluno, b.CPF, convert(varchar(20),b.DATANASC,103) as DT_NASC, b.SEXO, d.MAE_NOME as MAE, 
g.DESCRICAO as RAÇA, h.DESCRICAO as NACIONALIDADE,'Brasil' as PAÍS, j.SIGLA as UF_NASC, 
i.DESCRICAO as CIDADE_NASC, e.PRODUTO as COD_CURSO, e.NOME as CURSO, f.DESCRICAO as TURNO
from sophia.MATRICULA a 
inner join sophia.FISICA b on a.FISICA = b.CODIGO
inner join sophia.DADOSPF c on b.CODIGO = c.FISICA
inner join sophia.RACA g on b.RACA = g.CODIGO
inner join sophia.NACIONALIDADES h on c.NACIONALIDADE = h.CODIGO
left join sophia.CIDADES i on c.LOCAL_NASC = i.CODIGO
left join sophia.UNIDADE_FEDERATIVA j on i.UF = j.CODIGO
left join sophia.FAMILIAS d on c.FAMILIA = d.CODIGO
inner join sophia.CURSOS e on a.CURSO = e.PRODUTO
inner join sophia.TURNOS f on a.TURNO = f.CODIGO
where
	a.PERIODO = 117
	--a.PERIODO = 114
	--a.PERIODO in(114,117)
	and a.STATUS = 1
	and a.CURSO not in(23,26)
group by b.NOME,b.CPF,convert(varchar(20),b.DATANASC,103),b.SEXO,d.MAE_NOME,g.DESCRICAO,h.DESCRICAO,j.SIGLA, 
i.DESCRICAO,e.PRODUTO,e.NOME,f.DESCRICAO
order by b.NOME

--------------------------------------------------------------------------------------------------------

--DESISTENTE(evadido, cancelamento)

--evadido
select b.NOME as Aluno, b.CPF, convert(varchar(20),b.DATANASC,103) as DT_NASC, b.SEXO, d.MAE_NOME as MAE, 
g.DESCRICAO as RAÇA, h.DESCRICAO as NACIONALIDADE,'Brasil' as PAÍS, j.SIGLA as UF_NASC, 
i.DESCRICAO as CIDADE_NASC, e.PRODUTO as COD_CURSO, e.NOME as CURSO, f.DESCRICAO as TURNO
from sophia.MATRICULA a 
inner join sophia.FISICA b on a.FISICA = b.CODIGO
inner join sophia.DADOSPF c on b.CODIGO = c.FISICA
inner join sophia.RACA g on b.RACA = g.CODIGO
inner join sophia.NACIONALIDADES h on c.NACIONALIDADE = h.CODIGO
left join sophia.CIDADES i on c.LOCAL_NASC = i.CODIGO
left join sophia.UNIDADE_FEDERATIVA j on i.UF = j.CODIGO
left join sophia.FAMILIAS d on c.FAMILIA = d.CODIGO
inner join sophia.CURSOS e on a.CURSO = e.PRODUTO
inner join sophia.TURNOS f on a.TURNO = f.CODIGO
where
	--a.PERIODO = 117
	--a.PERIODO = 114
	--a.PERIODO = 95
	a.PERIODO in(95,114)
	--a.PERIODO in(114,117)
	and a.STATUS = 4
	and a.CURSO not in(23,26)
group by b.NOME,b.CPF,convert(varchar(20),b.DATANASC,103),b.SEXO,d.MAE_NOME,g.DESCRICAO,h.DESCRICAO,j.SIGLA, 
i.DESCRICAO,e.PRODUTO,e.NOME,f.DESCRICAO
order by b.NOME

--cancelamento
select b.NOME as Aluno, b.CPF, convert(varchar(20),b.DATANASC,103) as DT_NASC, b.SEXO, d.MAE_NOME as MAE, 
g.DESCRICAO as RAÇA, h.DESCRICAO as NACIONALIDADE,'Brasil' as PAÍS, j.SIGLA as UF_NASC, 
i.DESCRICAO as CIDADE_NASC, e.PRODUTO as COD_CURSO, e.NOME as CURSO, f.DESCRICAO as TURNO
from sophia.MATRICULA a 
inner join sophia.FISICA b on a.FISICA = b.CODIGO
inner join sophia.DADOSPF c on b.CODIGO = c.FISICA
inner join sophia.RACA g on b.RACA = g.CODIGO
inner join sophia.NACIONALIDADES h on c.NACIONALIDADE = h.CODIGO
left join sophia.CIDADES i on c.LOCAL_NASC = i.CODIGO
left join sophia.UNIDADE_FEDERATIVA j on i.UF = j.CODIGO
left join sophia.FAMILIAS d on c.FAMILIA = d.CODIGO
inner join sophia.CURSOS e on a.CURSO = e.PRODUTO
inner join sophia.TURNOS f on a.TURNO = f.CODIGO
where
	--a.PERIODO = 117
	--a.PERIODO = 114
	a.PERIODO in(114,117)
	and a.STATUS = 2
	and a.CURSO not in(23,26)
group by b.NOME,b.CPF,convert(varchar(20),b.DATANASC,103),b.SEXO,d.MAE_NOME,g.DESCRICAO,h.DESCRICAO,j.SIGLA, 
i.DESCRICAO,e.PRODUTO,e.NOME,f.DESCRICAO
order by b.NOME

-------------------------------------------------------------------------------------------------------------------

--TRANSFERIDO

select b.NOME as Aluno, b.CPF, convert(varchar(20),b.DATANASC,103) as DT_NASC, b.SEXO, d.MAE_NOME as MAE, 
g.DESCRICAO as RAÇA, h.DESCRICAO as NACIONALIDADE,'Brasil' as PAÍS, j.SIGLA as UF_NASC, 
i.DESCRICAO as CIDADE_NASC, e.PRODUTO as COD_CURSO, e.NOME as CURSO, f.DESCRICAO as TURNO
from sophia.MATRICULA a 
inner join sophia.FISICA b on a.FISICA = b.CODIGO
inner join sophia.DADOSPF c on b.CODIGO = c.FISICA
inner join sophia.RACA g on b.RACA = g.CODIGO
inner join sophia.NACIONALIDADES h on c.NACIONALIDADE = h.CODIGO
left join sophia.CIDADES i on c.LOCAL_NASC = i.CODIGO
left join sophia.UNIDADE_FEDERATIVA j on i.UF = j.CODIGO
left join sophia.FAMILIAS d on c.FAMILIA = d.CODIGO
inner join sophia.CURSOS e on a.CURSO = e.PRODUTO
inner join sophia.TURNOS f on a.TURNO = f.CODIGO
where
	--a.PERIODO = 117
	--a.PERIODO = 114
	a.PERIODO in(114,117)
	and a.STATUS = 3
	and a.CURSO not in(23,26)
group by b.NOME,b.CPF,convert(varchar(20),b.DATANASC,103),b.SEXO,d.MAE_NOME,g.DESCRICAO,h.DESCRICAO,j.SIGLA, 
i.DESCRICAO,e.PRODUTO,e.NOME,f.DESCRICAO
order by b.NOME

--------------------------------------------------------------------------------------------------------------------

--CONCLUINTES

select b.NOME as Aluno, b.CPF, convert(varchar(20),b.DATANASC,103) as DT_NASC, b.SEXO, d.MAE_NOME as MAE, 
g.DESCRICAO as RAÇA, h.DESCRICAO as NACIONALIDADE,'Brasil' as PAÍS, j.SIGLA as UF_NASC, 
i.DESCRICAO as CIDADE_NASC, e.PRODUTO as COD_CURSO, e.NOME as CURSO, f.DESCRICAO as TURNO
from sophia.MATRICULA a 
inner join sophia.FISICA b on a.FISICA = b.CODIGO
inner join sophia.DADOSPF c on b.CODIGO = c.FISICA
inner join sophia.RACA g on b.RACA = g.CODIGO
inner join sophia.NACIONALIDADES h on c.NACIONALIDADE = h.CODIGO
left join sophia.CIDADES i on c.LOCAL_NASC = i.CODIGO
left join sophia.UNIDADE_FEDERATIVA j on i.UF = j.CODIGO
left join sophia.FAMILIAS d on c.FAMILIA = d.CODIGO
inner join sophia.CURSOS e on a.CURSO = e.PRODUTO
inner join sophia.TURNOS f on a.TURNO = f.CODIGO
where
	b.CODEXT in(
'7202006',
'9200108',
'6104738',
'9100274',
'9200003',
'9100220',
'8101090',
'6107478',
'9200017',
'1200429',
'6108814',
'8243041',
'9100450',
'9100332',
'9100256',
'9200182',
'8243071',
'9200321',
'8101073',
'5110661',
'9200083',
'8243021',
'9100001',
'9200133',
'7201019',
'7201041',
'9200168',
'9200299',
'5101166',
'9100222',
'7100655',
'7201039'
)
	and a.PERIODO = 114
	--a.PERIODO = 114
	--a.PERIODO in(114,117)
	--and a.STATUS = 3
	--and a.CURSO not in(23,26)
group by b.NOME,b.CPF,convert(varchar(20),b.DATANASC,103),b.SEXO,d.MAE_NOME,g.DESCRICAO,h.DESCRICAO,j.SIGLA, 
i.DESCRICAO,e.PRODUTO,e.NOME,f.DESCRICAO
order by b.NOME


select NOME,CODEXT from sophia.FISICA
where NOME in(
'Antonio Micherlanio Rodrigues Lopes',
'Bruna Camillo Marinho Gonçalves',
'Bruna Soares Toledo',
'Bruno Neves Eugenio',
'Carolina Oliveira Martins',
'Daniele Souza dos Santos',
'Diego Antonio de Almeida Costa',
'Diego Valverde de Oliveira',
'Eliani Grassiela Moreira',
'Erick Ferreira Macedo',
'Fabio Roberto da Silva Sousa Silva',
'Fabio Vivas Rodrigues',
'Fabricio Martins',
'Felipe José da Silva Souza',
'Giacomo Carielo Martins',
'Gilliard Salles Okano',
'Glauber Mauch de Carvalho',
'Guilherme Moura Perroni',
'Guilherme Sergio de Brito',
'Henrique Ramos Soares de Carvalho',
'Joyce Pires da Silva',
'Lucas Souza de Amorim',
'Manoel Messias Pereira Araujo',
'Mauricio Nasser',
'Paulo Cesar dos Santos Filho',
'Renato Figueiredo Machado Soares',
'Reynaldo José Mazzante Mendes',
'Rogerio Santos de Souza',
'Samuel Sakae Kodama',
'Veronica Lopes Silva',
'Wallace Ferreira Gomes',
'Willian Eloy Bento'
)
order by NOME


select * from sophia.FISICA
where NOME = 'Marcos Paulo dos Santos'