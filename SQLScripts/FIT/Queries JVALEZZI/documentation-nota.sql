use SophiA

select * from sophia.FISICA
where CODEXT = '1201505'

select * from sophia.MATRICULA
where FISICA = 16083
--31381

select * from sophia.MATRICULA
where FISICA = 23500
--31407

select * from sophia.TURMAS
where PERIODO = 117 and NOME like '%SI%'
--2350 - CDT - Teste
--2325 - SI 5A

select * from sophia.DISCIPLINAS
where CODIGO = 103
--31 - Banco de Dados I 
--103 - Fundamentos de Marketing


[sophia.ATA_NOTA]

select * from sophia.ATA_NOTA

select * from sophia.ATA_NOTA
where TURMA = 2325

select * from sophia.ATA_NOTA
where TURMA = 2350

-- Situa��o da Ata de Notas
	-- 1 - Gerada
	-- 2 - em lan�amento
	-- 5 - Processada
-- Etapa
	-- 1 - 1� Bimestre
	-- 2 - 2� Bimestre
	-- 3 - Sub 1
	-- 4 - Sub 2
	-- 14 - Exame
	
[sophia.AVALS]	

select * from sophia.CLASSIFICACAO_AVALS
--2 - Nota

select * from sophia.ETAPAS
--5 - 1� Bimestre

select * from sophia.TIPOS_AVAL
--1 - Semestral

select * from sophia.AVALS

select * from sophia.AVALS
where CODIGO = 18582

select * from sophia.AVALS
where CODIGO = 18565

select * from sophia.AVALS
where TURMA = 2325 and DISCIPLINA = 31


select * from sophia.ETAPAS

-- M�dia - ? (possa ser quando a ata � finalizada, � inserido a M�dia de todas as notas desta ata)

select * from sophia.ATA_NOTA
where CODIGO = 18917



select * from sophia.ATA_NOTA
where TURMA = 2350

select * from sophia.DISCIPLINAS
where CODIGO = 6

select * from sophia.TURMAS
where CODIGO = 2350

select * from sophia.ETAPAS


select * from sophia.ATA_NOTA
where NUMERO = 1113



-- Processos para inserir notas no Sophia
--------------------------------------------------------------------------------------------------
--proc para listar os alunos e as notas
select d.CODEXT as RA, c.NUM_CHAMADA ,d.NOME, b.nota, c.CODIGO as MATRICULA, a.CODIGO as ATA 
from sophia.ATA_NOTA a 
inner join sophia.ata_aluno b on a.CODIGO = b.ata
inner join sophia.MATRICULA c on b.matricula = c.CODIGO
inner join sophia.FISICA d on c.FISICA = d.CODIGO
where a.TURMA = 2325 and a.DISCIPLINA = 31 and a.ETAPA = 1
order by d.NOME,c.NUM_CHAMADA

--teste
select d.CODEXT as RA, c.NUM_CHAMADA, d.NOME, b.nota, c.CODIGO as MATRICULA, a.CODIGO as ATA 
from sophia.ATA_NOTA a 
inner join sophia.ata_aluno b on a.CODIGO = b.ata
inner join sophia.MATRICULA c on b.matricula = c.CODIGO
inner join sophia.FISICA d on c.FISICA = d.CODIGO
where a.TURMA = 2350 and a.DISCIPLINA = 6 and a.ETAPA = 1
order by d.NOME,c.NUM_CHAMADA

/*
	adicionar as notas na tabela SOPHIA.ATA_ALUNO,
	e dependendo da etapa escolhida ir� adicionar na coluna do academic
	
	-- ACADEMIC
		-- NOTA1, MEDIA1 - 1�Bimestre(MB1)
		-- NOTA2, MEDIA2 - 2�Bimestre(MB2)
		-- NOTA3, MEDIA3 - Sub1(SUB1)
		-- NOTA4, MEDIA4 - Sub2(SUB2)
		-- EXAME - Exame(EX)
		-- MEDIA_ANUAL - Media Parcial(MP)
		-- MEDIA_APOS_EXAME - Media Final(MF), CASO O ALUNO TENHA FEITO O EXAME
		-- MEDIA_FINAL - Media Final(MF)
		-- MEDIA_FINALSTR - Media Final(MF)

		-- SITUACAO
			-- 1 - APROVADO
			-- 2 - REPROVADO

		-- FALTAS1 - 1�Bimestre(FB)
		-- FALTAS2 - 2�Bimestre(FB)
		
		
	-- ACADEMIC_LANC
		-- 1 - 1� Bimestre
		-- 2 - 2� Bimestre
		-- 3 - Sub1
		-- 4 - Sub2
		-- 13 - Fim das etapas - Media Parcial(MP)
		-- 14 - Exame -  SE HOUVER NOTA DE EXAME
		-- 16 - Situa��o Final - Media Final(MF)	
	
*/
-----------------------------------------------------------------------------------------------

select * from sophia.ATA_NOTA
where TURMA = 2350

-- inserir as opera��es das atas de notas
select * from sophia.ATA_HISTORICO
where ATA = 18921

--teste
select * from sophia.ATA_HISTORICO
where ATA = 18917

--teste
select * from sophia.ATA_HISTORICO
where ATA = 18918

-- quando a ata de nota � CRIADA j� � inserindo um registro com a oprea��o 7

-- responsavel(sophia.funcionario) - codigo do professor
-- operacao
	-- 7 - gera��o
	-- 1 - lan�amento
	-- 5 - processamento

------------------------------------------------------------------------------------------------
/* nesta tabela somente � adicionado os alunos sem notas(null), e depois do lan�amento inseri
nesta tabela
*/

--teste
select * from sophia.ATA_HISTORICO_LANCAMENTO
where IDFK_HISTORICO = 56525

-- codigos do hist�rico da ata de nota
-- 55532 - gera��o
-- 55926 - lan�amento
-- 55927 - processamento

--teste
select * from sophia.ATA_HISTORICO_LANCAMENTO
where IDFK_HISTORICO = 55533

-- quando a ata de nota � criada, � inserido todos os registros de alunos com a nota(null) -> referente a opera��o 7(gera��o) -> vinculando o codigo referente a opera��o(sophia.ATA_HISTORICO)
-- � preciso inserir os registros nesta tabela quando as notas forem lan�adas, inserindo a matr�cula e as notas -> referente a opera��o 1(lan�amento) -> vinculando o codigo referente a opera��o(sophia.ATA_HISTORICO)

--	IDFK_HISTORICO(� o C�DIGO - sophia.ATA_HISTORICO)
	-- 54568 - este historico da ata(18781) a opera��o dele � GERA��O, ent�o salva nesta tabela sem as notas(null)
	-- 55041 - este historico da ata(18781) a opera��o dele � LAN�AMENTO, ent�o salva nesta tabela com as notas, 
	--		   caso algum aluno estja com a nota NULL, n�o � inserido na tabela - somente alunos com notas
	
-- IDFK_MATRICULA(� o C�DIGO - sophia.MATRICULA)

-----------------------------------------------------------------------------------------

[sophia.ata_aluno]

select * from sophia.ata_aluno
where matricula = 31381

select * from sophia.ata_aluno
where matricula = 31407 and ata = 18917

select * from sophia.ata_aluno
where ata = 18917 

select * from sophia.ata_aluno
where ata = 18781 

select * from sophia.ata_aluno
where ata = 18781 and matricula = 31381

--------------------------------------------------------------------------------------------

[sophia.ATA_HISTORICO]

select * from sophia.ATA_HISTORICO
where ATA = 18781

select * from sophia.ATA_HISTORICO
where ATA = 18917

-- responsavel(sophia.funcionario) - codigo do professor
-- operacao
	-- 7 - gera��o
	-- 1 - lan�amento
	-- 5 - processamento

----------------------------------------------------------------------------------------------

[sophia.ATA_HISTORICO_LANCAMENTO]

select * from sophia.ATA_HISTORICO_LANCAMENTO
where IDFK_HISTORICO = 54568

select * from sophia.ATA_HISTORICO_LANCAMENTO
where IDFK_HISTORICO = 55041

--	IDFK_HISTORICO(� o C�DIGO - sophia.ATA_HISTORICO)
	-- 54568 - este historico da ata(18781) a opera��o dele � GERA��O, ent�o salva nesta tabela sem as notas(null)
	-- 55041 - este historico da ata(18781) a opera��o dele � LAN�AMENTO, ent�o salva nesta tabela com as notas, 
	--		   caso algum aluno estja com a nota NULL, n�o � inserido na tabela - somente alunos com notas
	
-- IDFK_MATRICULA(� o C�DIGO - sophia.MATRICULA)

----------------------------------------------------------------------------------------------


select * from sophia.ata_aluno
where matricula = 31381

select * from sophia.ata_aluno
where ata = 18781 

select * from sophia.ata_aluno
where ata = 18781 and matricula = 31381

select * from sophia.academic
where MATRICULA = 31381

select * from sophia.academic
where MATRICULA = 31407

-- NOTA1, MEDIA1 - 1�Bimestre(MB1)
-- NOTA2, MEDIA2 - 2�Bimestre(MB2)
-- NOTA3, MEDIA3 - Sub1(SUB1)
-- NOTA4, MEDIA4 - Sub2(SUB2)
-- EXAME - Exame(EX)
-- MEDIA_ANUAL - Media Parcial(MP)
-- MEDIA_APOS_EXAME - Media Final(MF), CASO O ALUNO TENHA FEITO O EXAME
-- MEDIA_FINAL - Media Final(MF)
-- MEDIA_FINALSTR - Media Final(MF)

-- SITUACAO
	-- 1 - APROVADO
	-- 2 - REPROVADO

-- FALTAS1 - 1�Bimestre(FB)
-- FALTAS2 - 2�Bimestre(FB)
-- PERC_FALTAS ->verificar


select * from sophia.academic_lanc
where academic = 231940

select * from sophia.academic_lanc
where academic = 232114
-- 1 - 1� Bimestre
-- 2 - 2� Bimestre
-- 3 - Sub1
-- 4 - Sub2
-- 13 - Fim das etapas - Media Parcial(MP)
-- 14 - Exame -  SE HOUVER NOTA DE EXAME
-- 16 - Situa��o Final - Media Final(MF)

--------------------------------------TESTE-----------------------------------------------------------
-- matricula(2013/1) - 28536(AZZI)

select * from sophia.ATA_NOTA
where CODIGO = 15114

select * from sophia.ata_aluno
where ata = 15114 

select * from sophia.ata_aluno
where matricula = 28536

select * from sophia.ata_aluno
where ata = 15114 and matricula = 28536

select * from sophia.academic
where MATRICULA = 28536


select * from sophia.ETAPAS

select * from sophia.academic_lanc
where academic = 209299



select * from sophia.TURMAS
where CODIGO = 2177

select * from sophia.DISCIPLINAS
where CODIGO = 192


select * from sophia.FISICA
--where CODIGO = 10279
where NOME like '%Hugo Mucciolo%'
--10067

select * from sophia.MATRICULA
where FISICA = 16083
--28991
--28235


----------------------------------------turma - teste---------------------------------------------
[sophia.ETAPAS]
select * from sophia.ETAPAS

select * from sophia.ATA_NOTA
where TURMA = 2350

select * from sophia.ETAPAS

select * from sophia.AVALS
where TURMA = 2350

select * from sophia.AVALS
where CODIGO = 18700

select * from sophia.ETAPAS

--------------------------------------------------

select * from sophia.ata_aluno
where ata = 18917

select * from sophia.ata_aluno
where ata = 18925

select * from sophia.ata_aluno
where ata = 18917 and matricula = 31407
-- update para inserir a nota

---------------------------------------------------

select * from sophia.ATA_HISTORICO
where ATA = 18917

-- 7 - gera��o o sophia j� inseri

-- INSERIR a opera��o e o respons�vel($_session['codigo'])
	-- 1 - lan�amento
	-- 5 - processamento

---------------------------------------------------

select * from sophia.ATA_HISTORICO_LANCAMENTO
where IDFK_HISTORICO = 55532--(CODIGO - sophia.ATA_HISTORICO)

--	IDFK_HISTORICO(� o C�DIGO - sophia.ATA_HISTORICO)
	-- 55532 - este historico da ata(18917) a opera��o dele � GERA��O, J� EST� SALVO OS REGISTROS SEM AS NOTAS(NULL)
	--  - este historico da ata(18781) a opera��o dele � LAN�AMENTO, ent�o salva nesta tabela com as notas, 
	--		   caso algum aluno estja com a nota NULL, n�o � inserido na tabela - somente alunos com notas
	
-- IDFK_MATRICULA(� o C�DIGO - sophia.MATRICULA)

--------------------------------------------------

select * from sophia.academic
where MATRICULA = 31407

-- update para inserir a nota

-- NOTA1, MEDIA1 - 1�Bimestre(MB1)
-- NOTA2, MEDIA2 - 2�Bimestre(MB2)
-- NOTA3, MEDIA3 - Sub1(SUB1)
-- NOTA4, MEDIA4 - Sub2(SUB2)
-- EXAME - Exame(EX)
-- MEDIA_ANUAL - Media Parcial(MP)
-- MEDIA_APOS_EXAME - Media Final(MF), CASO O ALUNO TENHA FEITO O EXAME
-- MEDIA_FINAL - Media Final(MF)
-- MEDIA_FINALSTR - Media Final(MF)

-- SITUACAO
	-- 1 - APROVADO
	-- 2 - REPROVADO

-- FALTAS1 - 1�Bimestre(FB)
-- FALTAS2 - 2�Bimestre(FB)
-- PERC_FALTAS ->verificar

-----------------------------------------------

select * from sophia.academic_lanc
where academic = 232116 --(CODIGO - sophia.academic)

-- update para inserir a nota


select * from sophia.TURMAS
where CODIGO = 2350




select * from sophia.FISICA
where CODEXT = '1020273'


select * from sophia.MATRICULA
where FISICA = 8061


select * from sophia.academic
where MATRICULA = 30511


alter proc sp_etapa_list
(@turma int)
AS
/*
app: SiteFit
url: 
data: 01/10/2013
author: Maluf
*/
select distinct b.NUMERO, b.NOME as ETAPA from sophia.AVALS a
inner join sophia.ETAPAS b on a.ETAPA = b.CODIGO
where a.TURMA = @turma





