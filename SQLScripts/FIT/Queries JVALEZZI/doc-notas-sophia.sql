

select * from sophia.ATA_NOTA
where TURMA = 2350


select * from sophia.ATA_NOTA
where CODIGO = 18920




-- Situação da Ata de Notas
	-- 1 - Gerada
	-- 2 - em lançamento
	-- 5 - Processada
-- Etapa
	-- 1 - 1º Bimestre
	-- 2 - 2º Bimestre
	-- 3 - Sub 1
	-- 4 - Sub 2
	-- 14 - Exame

-----------------------------------------------------------------------------
select * from sophia.ATA_HISTORICO
where ATA = 18919

-- quando a ata de nota é CRIADA já é inserindo um registro com a opreação 7

-- responsavel(sophia.funcionario) - codigo do professor
-- operacao
	-- 7 - geração
	-- 1 - lançamento
	-- 5 - processamento

----------------------------------------------------------------------------

select * from sophia.ATA_HISTORICO_LANCAMENTO
where IDFK_HISTORICO = 56571

-- codigo gerado da sophia.ATA_HISTORICO
------------------------------------------------------------------------------


select * from sophia.ata_aluno
where ata = 18918 

--- situação gerada
select * from sophia.ata_aluno
where ata = 18920

-------------------------------------------------------------------------------

select * from sophia.academic
where MATRICULA = 31407

select * from sophia.academic
where CODIGO = 232115

--update sophia.academic set NOTA2 = 6.00, MEDIA2 = 6.00
--where CODIGO = 232117



-- NOTA1, MEDIA1 - 1ºBimestre(MB1)
-- NOTA2, MEDIA2 - 2ºBimestre(MB2)
-- NOTA3, MEDIA3 - Sub1(SUB1)
-- NOTA4, MEDIA4 - Sub2(SUB2)
-- EXAME - Exame(EX)


-- SOPHIA FAZ O CALCULO AUTOMATICO
-- MEDIA_ANUAL - Media Parcial(MP)
-- MEDIA_FINAL - Media Final(MF)
-- MEDIA_FINALSTR - Media Final(MF)
-- MEDIA_APOS_EXAME - Media Final(MF), CASO O ALUNO TENHA FEITO O EXAME
-- SITUACAO
	-- 1 - APROVADO
	-- 2 - REPROVADO


-- FALTAS1 - 1ºBimestre(FB)
-- FALTAS2 - 2ºBimestre(FB)
-- PERC_FALTAS ->verificar


select * from sophia.DISCIPLINAS
where CODIGO = 400
where NOME like '%gestão de Projetos%'

----------------------------------------------------------------------------------

select * from sophia.academic_lanc
where academic = 232114


select .from sophia.
----------------------------------------------------------------------------

[sophia.ata_nota]


select * from sophia.ETAPAS



-------------------------------------------------------------
-- lista alunos e notas
select d.CODEXT as RA, d.NOME, b.nota from sophia.ATA_NOTA a
inner join sophia.ata_aluno b on a.CODIGO = b.ata
inner join sophia.MATRICULA c on b.matricula = c.CODIGO
inner join sophia.FISICA d on c.FISICA = d.CODIGO
where a.TURMA = 2350 and a.DISCIPLINA = 6 and a.ETAPA = 1


---------------------------------------------------------------------------------
select * from sophia.ATA_NOTA
where TURMA = 2350

--18924 -- dis -1438
--18932

select * from sophia.ATA_HISTORICO
where ATA = 18932

select * from sophia.ATA_HISTORICO_LANCAMENTO
where IDFK_HISTORICO = 56609

select * from sophia.ata_aluno
where ata = 18932

select * from sophia.academic
where MATRICULA = 31407

select * from sophia.academic_lanc
where academic = 232116

select * from sophia.AVALUNO
where IDFK_ACADEMIC = 232116

--select * from sophia.AVALUNO
--where MATRICULA = 31407

select * from sophia.AVALS
where CODIGO = 18703

select * from sophia.AVALUNO
where MATRICULA = 31407 and AVALIACAO = 18715


update sophia.AVALUNO set NOTA = 10.00
where MATRICULA = 31407 and AVALIACAO = 18715