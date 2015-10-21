

select * from sonata.sophia.sophia.ATA_NOTA
where TURMA = 2350 AND DISCIPLINA = 400 AND ETAPA = 14


select * from sonata.sophia.sophia.ATA_NOTA
where CODIGO = 19046

SELECT * FROM sophia.AVALS
WHERE CODIGO = 18701
[sophia.ATA_NOTA]

SELECT * FROM sophia.ETAPAS

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
select * from sonata.sophia.sophia.ATA_HISTORICO
where ATA = 19048

-- quando a ata de nota é CRIADA já é inserindo um registro com a opreação 7

-- responsavel(sophia.funcionario) - codigo do professor
-- operacao
	-- 7 - geração
	-- 1 - lançamento
	-- 5 - processamento

----------------------------------------------------------------------------

select * from sonata.sophia.sophia.ATA_HISTORICO_LANCAMENTO
where IDFK_HISTORICO = 57649

-- codigo gerado da sophia.ATA_HISTORICO
------------------------------------------------------------------------------


select * from sophia.ata_aluno
where ata = 19048 

--- situação gerada

-------------------------------------------------------------------------------

select * from sonata.sophia.sophia.academic
where MATRICULA = 31407

select * from SONATA.sophia.sophia.academic
where TURMA = 2457 AND DISCIPLINA = 23 AND MATRICULA = 32286


select * from sophia.academic_lanc
where academic = 232114

SELECT * FROM SONATA.sophia.sophia.AVALUNO WHERE AVALIACAO = 18704
exec dbo.sp_academic_lanc_media 232117

--update sophia.academic set NOTA2 = 6.00, MEDIA2 = 6.00
--where CODIGO = 232117

SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS WHERE NOME like 'SI 4A' AND PERIODO = 120
SELECT * FROM SONATA.SOPHIA.SOPHIA.DISCIPLINAS WHERE NOME LIKE '%Análise, Projeto e Implementação de Sistemas%'
SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE NOME LIKE '%jose luiz de oliveira%'
SELECT * FROM SONATA.SOPHIA.SOPHIA.MATRICULA WHERE FISICA = 11427


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

sp_notasalunos_list 2350,6,1
SELECT 
	CODIGO
	, DISCIPLINA
	, MATRICULA
	, SITUACAO
	, NOTA1 
	, NOTA2
	, NOTA3
	, NOTA4
	, EXAME
	, MEDIA_ANUAL
	, MEDIA_APOS_EXAME
	, MEDIA_FINAL
	, MEDIA_FINALSTR
	, FALTAS1
	, FALTAS2
	, FALTAS3
	, FALTAS4
	, FALTAS5
	, PERC_FALTAS
	, CARGA_HORARIA
FROM sophia.academic a
WHERE TURMA = 2350 AND DISCIPLINA = 6


WHERE FISICA = 16083


SELECT *
FROM sophia.academic 
WHERE TURMA = 2350
WHERE MATRICULA = 28536




select * from sophia.DISCIPLINAS
where CODIGO = 669
where NOME like '%pmbok%'

----------------------------------------------------------------------------------

select * from sophia.academic_lanc
where academic = 232115

select * from sophia.academic
where MATRICULA = 31407


select .from sophia.
----------------------------------------------------------------------------

[sophia.ata_nota]


select * from sophia.ETAPAS
WHERE CFG_ACAD = 1


select d.CODEXT as RA, d.NOME, b.nota  from sophia.ATA_NOTA a
inner join sophia.ata_aluno b on a.CODIGO = b.ata
inner join sophia.MATRICULA c on b.matricula = c.CODIGO
inner join sophia.FISICA d on c.FISICA = d.CODIGO
where a.TURMA = 2350 and a.DISCIPLINA = 6 and a.ETAPA = 2

SELECT * FROM sophia.QC
WHERE TURMA = 2350 AND DISCIPLINA = 6 
-------------------------------------------------------------
------------------------ TABELAS -------------------------
-------------------------------------------------------------
CREATE TABLE tb_ata_nota_log(
	idatanotalog int identity CONSTRAINT PK_ata_nota_log PRIMARY KEY,
	codigo int,
	idsituacao int,
	dtcadastro datetime CONSTRAINT DF_ata_nota_log_dtcadastro DEFAULT (getdate())
)

ALTER TABLE tb_ata_nota_log ADD
inretificado bit CONSTRAINT df_ata_nota_log_inretificado DEFAULT (0)

ALTER TABLE tb_ata_nota_log ADD
desmotivoretificacao varchar(1000)

SELECT * FROM tb_ata_nota_log
-------------------------------------------------------------
------------------------ PROCEDURES -------------------------
-------------------------------------------------------------
ALTER proc sp_etapa_list
(@turma int)
AS
/*
app: SiteFit
url: 
data: 01/10/2013
author: Maluf
*/
BEGIN
	select DISTINCT 
		b.NUMERO
		, b.NOME as ETAPA
		, c.Visualizar_Notas
		, c.Lancar_Notas
		, c.Exportar_Faltas 
	FROM sophia.AVALS a
	INNER JOIN sophia.ETAPAS b ON a.ETAPA = b.CODIGO
	INNER JOIN sophia.Turmas_Etapas_Lcto c ON c.Num_Etapa = b.NUMERO AND c.Cod_Turma = a.TURMA
	WHERE a.TURMA = @turma AND c.Visualizar_Notas = 1
	ORDER BY b.NUMERO
END

select DISTINCT 
	b.NUMERO
	, b.NOME as ETAPA
	, c.Visualizar_Notas
	, c.Lancar_Notas
	, c.Exportar_Faltas 
FROM sophia.AVALS a
INNER JOIN sophia.ETAPAS b ON a.ETAPA = b.CODIGO
INNER JOIN sophia.Turmas_Etapas_Lcto c ON c.Num_Etapa = b.NUMERO AND c.Cod_Turma = a.TURMA
WHERE a.TURMA = 2490

sp_etapa_list 2490

SELECT * FROM sophia.AVALS where TURMA = 2490
SELECT * FROM sophia.Turmas_Etapas_Lcto where cod_TURMA = 2490
SELECT * FROM sophia.academic where MATRICULA = 31801
SELECT * FROM sophia.FISICA where NOME like '%valezzi%'
SELECT * FROM sophia.MATRICULA where FISICA = 23744
-------------------------------------------------------------
-- lista alunos e notas
ALTER PROC sp_notasalunos_list
(@TURMA int, @DISCIPLINA int)
AS
/*
  app:Sophia
  url:../professor/ajax/salva_lista_notas.php
  author: Massaharu
  date: 01/01/2014
*/
BEGIN

	SET NOCOUNT ON
	
	DECLARE @notas TABLE(
		matricula int,
		nota1 numeric(15,4),
		nota2 numeric(15,4),
		nota3 numeric(15,4),
		nota4 numeric(15,4),
		nota14 numeric(15,4)
	)

	INSERT INTO @notas
	SELECT 
		a.matricula
		,sum(c.nota) as nota1
		,sum(d.nota) as nota2
		,sum(e.nota) as nota3
		,sum(f.nota) as nota4
		,sum(g.nota) as nota14
		FROM sonata.sophia.sophia.ATA_aluno a
	inner join sonata.sophia.sophia.ATA_NOTA b
	on b.codigo = a.ata
	left join sonata.sophia.sophia.ATA_aluno c
	on c.matricula = a.matricula and c.ata = a.ata and b.etapa = 1
	left join sonata.sophia.sophia.ATA_aluno d
	on d.matricula = a.matricula and d.ata = a.ata and b.etapa = 2
	left join sonata.sophia.sophia.ATA_aluno e
	on e.matricula = a.matricula and e.ata = a.ata and b.etapa = 3
	left join sonata.sophia.sophia.ATA_aluno f
	on f.matricula = a.matricula and f.ata = a.ata and b.etapa = 4
	left join sonata.sophia.sophia.ATA_aluno g
	on g.matricula = a.matricula and g.ata = a.ata and b.etapa = 14
	where b.TURMA = @TURMA and b.DISCIPLINA = @DISCIPLINA --and b.ETAPA = 1
	group by a.matricula

	SELECT DISTINCT
		--a.CODIGO as CODIGO_ATA_NOTA
		d.CODEXT as RA
		, d.NOME
		, b.matricula as MATRICULA 
		, l.nota1
		, l.nota2
		, l.nota3
		, l.nota4
		, l.nota14
		, h.INICIO
		, h.TERMINO
		, h.Lanc_Ata_Data_Limite as LANC_ATA_DATA_LIMITE
		--, a.ETAPA
		, i.CFG_ACAD
		, h.Lanc_Ata_Data_Limite
		, GETDATE()as data_atual
		, CASE 
			WHEN GETDATE() <= h.Lanc_Ata_Data_Limite + 1 THEN 1
			ELSE 0
		END AS INVISIVEL
		, j.SITUACAO as SITUACAO_ALUNO
		, j.MEDIA_ANUAL
		, j.MEDIA_APOS_EXAME
		, j.MEDIA_FINAL
		, CAST(j.PERC_FALTAS AS numeric(15,2)) as PERC_FALTAS
		,dbo.fn_faltas_get(a.TURMA, a.DISCIPLINA, j.MATRICULA) as FALTAS
	FROM sonata.sophia.sophia.ATA_NOTA a
	INNER JOIN sonata.sophia.sophia.ata_aluno b ON a.CODIGO = b.ata
	INNER JOIN sonata.sophia.sophia.MATRICULA c ON b.matricula = c.CODIGO
	INNER JOIN sonata.sophia.sophia.FISICA d ON c.FISICA = d.CODIGO
	INNER JOIN sonata.sophia.sophia.TURMAS e ON e.CODIGO = a.TURMA
	INNER JOIN sonata.sophia.sophia.PERIODOS f ON f.CODIGO = e.PERIODO
	INNER JOIN sonata.sophia.sophia.CALENDARIOS g ON g.PERIODO = f.CODIGO AND g.CFG_ACAD = e.CFG_ACAD
	INNER JOIN sonata.sophia.sophia.CALEND_ETAPAS h ON h.CALENDARIO = g.CODIGO
	INNER JOIN sonata.sophia.sophia.ETAPAS i ON i.CODIGO = h.ETAPA AND i.CFG_ACAD = e.CFG_ACAD
	INNER JOIN sonata.sophia.sophia.academic j ON j.MATRICULA = c.CODIGO AND a.DISCIPLINA = j.DISCIPLINA AND j.TURMA = a.TURMA
	INNER JOIN @notas l ON l.matricula = b.matricula
	where a.TURMA = @TURMA and a.DISCIPLINA = @DISCIPLINA and i.NUMERO = 1 --and a.ETAPA = 1
	ORDER BY d.NOME
	
	SET NOCOUNT OFF
END



sp_notasalunos_list 2521, 6
sp_notasalunos_list 2371, 872
sp_notasalunos_list 2420, 1406
sp_notasalunos_list 2577, 281

SELECT * FROM sonata.sophia.sophia.ETAPAS
SELECT * FROM sonata.sophia.sophia.TURMAS
SELECT * FROM sonata.sophia.sophia.CFG_ACAD
SELECT * FROM sonata.sophia.sophia.CURSOS
SELECT * FROM sonata.sophia.sophia.academic where turma = 2420 and disciplina = 1406 AND nota1 is not null
SELECT * FROM sonata.sophia.sophia.academic_lanc where academic = 274005
---
	
	DECLARE @notas TABLE(
		matricula int,
		nota1 numeric(15,4),
		nota2 numeric(15,4),
		nota3 numeric(15,4),
		nota4 numeric(15,4),
		nota14 numeric(15,4)
	)

	INSERT INTO @notas
	SELECT 
		a.matricula
		,sum(c.nota) as nota1
		,sum(d.nota) as nota2
		,sum(e.nota) as nota3
		,sum(f.nota) as nota4
		,sum(g.nota) as nota14
		FROM sonata.sophia.sophia.ATA_aluno a
	inner join sonata.sophia.sophia.ATA_NOTA b
	on b.codigo = a.ata
	left join sonata.sophia.sophia.ATA_aluno c
	on c.matricula = a.matricula and c.ata = a.ata and b.etapa = 1
	left join sonata.sophia.sophia.ATA_aluno d
	on d.matricula = a.matricula and d.ata = a.ata and b.etapa = 2
	left join sonata.sophia.sophia.ATA_aluno e
	on e.matricula = a.matricula and e.ata = a.ata and b.etapa = 3
	left join sonata.sophia.sophia.ATA_aluno f
	on f.matricula = a.matricula and f.ata = a.ata and b.etapa = 4
	left join sonata.sophia.sophia.ATA_aluno g
	on g.matricula = a.matricula and g.ata = a.ata and b.etapa = 14
	where b.TURMA = 2371 and b.DISCIPLINA = 872 --and b.ETAPA = 1
	group by a.matricula

	SELECT DISTINCT
		--a.CODIGO as CODIGO_ATA_NOTA
		d.CODEXT as RA
		, d.NOME
		, b.matricula as MATRICULA 
		, l.nota1
		, l.nota2
		, l.nota3
		, l.nota4
		, l.nota14
		, h.INICIO
		, h.TERMINO
		, h.Lanc_Ata_Data_Limite as LANC_ATA_DATA_LIMITE
		--, a.ETAPA
		, i.CFG_ACAD
		, h.Lanc_Ata_Data_Limite
		, GETDATE()as data_atual
		, 'INVISIVEL' = CASE 
			WHEN DAY(GETDATE()) <= DAY(h.Lanc_Ata_Data_Limite) THEN 1
			WHEN DAY(GETDATE()) > DAY(h.Lanc_Ata_Data_Limite) THEN 0
		END
		, j.SITUACAO as SITUACAO_ALUNO
		, j.MEDIA_ANUAL
		, j.MEDIA_APOS_EXAME
		, j.MEDIA_FINAL
		, CAST(j.PERC_FALTAS AS numeric(15,2)) as PERC_FALTAS
		,dbo.fn_faltas_get(a.TURMA, a.DISCIPLINA, j.MATRICULA) as FALTAS
	FROM sonata.sophia.sophia.ATA_NOTA a
	INNER JOIN sonata.sophia.sophia.ata_aluno b ON a.CODIGO = b.ata
	INNER JOIN sonata.sophia.sophia.MATRICULA c ON b.matricula = c.CODIGO
	INNER JOIN sonata.sophia.sophia.FISICA d ON c.FISICA = d.CODIGO
	INNER JOIN sonata.sophia.sophia.TURMAS e ON e.CODIGO = a.TURMA
	INNER JOIN sonata.sophia.sophia.PERIODOS f ON f.CODIGO = e.PERIODO
	INNER JOIN sonata.sophia.sophia.CALENDARIOS g ON g.PERIODO = f.CODIGO AND g.CFG_ACAD = 1
	INNER JOIN sonata.sophia.sophia.CALEND_ETAPAS h ON h.CALENDARIO = g.CODIGO
	INNER JOIN sonata.sophia.sophia.ETAPAS i ON i.CODIGO = h.ETAPA  AND i.CFG_ACAD = 1
	INNER JOIN sonata.sophia.sophia.academic j ON j.MATRICULA = c.CODIGO AND a.DISCIPLINA = j.DISCIPLINA AND j.TURMA = a.TURMA
	INNER JOIN @notas l ON l.matricula = b.matricula
	where a.TURMA = 2371 and a.DISCIPLINA = 872 and i.NUMERO = 1 --and a.ETAPA = 1
	ORDER BY d.NOME
	
-------------------------------------------------------------
-- lista alunos e notas pela etapa
ALTER PROC sp_notasalunosbyetapa_list
(@TURMA int, @DISCIPLINA int, @ETAPA int)
AS
/*
  app:Sophia
  url:../professor/ajax/s alva_lista_notas.php
  author: Massaharu
  date: 1/10/2013
*/
BEGIN
	SELECT 
		d.CODEXT AS RA
		, d.NOME
		, b.matricula AS MATRICULA 
		, b.nota
		, k.idnotaaluno
		, k.nota1
		, dbo.fn_nota_status(k.idcod_ata_nota, 1) AS innota1
		, k.nota2
		, dbo.fn_nota_status(k.idcod_ata_nota, 2) AS innota2
		, k.nota3 
		, dbo.fn_nota_status(k.idcod_ata_nota, 3) AS innota3
		, k.nota4 
		, dbo.fn_nota_status(k.idcod_ata_nota, 4) AS innota4
		, k.nota1peso
		, k.nota2peso
		, CASE
			-- SE o aluno tiver checado para o pai e a turma regular da matrícula for o mesmo para a disciplina que estiver cursando
			WHEN k.inalunopai = 1 and (
					SELECT SERIE FROM SONATA.SOPHIA.SOPHIA.TURMAS
					WHERE CODIGO = c.TURMA_REGULAR
				) = (
					SELECT SERIE FROM SONATA.SOPHIA.SOPHIA.TURMAS
					WHERE CODIGO = e.CODIGO
				) THEN 
				ISNULL(
					k.inalunopai, 
					dbo.fn_inalunopaiB1_get(
						b.matricula, a.disciplina, a.etapa, 
						(
							SELECT PERIODO FROM SONATA.SOPHIA.SOPHIA.TURMAS
							WHERE CODIGO = @TURMA
						)
					)
				) 
			--WHEN k.inalunopai IS NULL and c.TURMA_REGULAR <> e.CODIGO THEN 0
			WHEN k.inalunopai = 1 and (
					SELECT SERIE FROM SONATA.SOPHIA.SOPHIA.TURMAS
					WHERE CODIGO = c.TURMA_REGULAR
				) <> (
					SELECT SERIE FROM SONATA.SOPHIA.SOPHIA.TURMAS
					WHERE CODIGO = e.CODIGO
				) THEN 0
			ELSE
				ISNULL(
					k.inalunopai, 
					dbo.fn_inalunopaiB1_get(
						b.matricula, a.disciplina, a.etapa, 
						(
							SELECT PERIODO FROM SONATA.SOPHIA.SOPHIA.TURMAS
							WHERE CODIGO = @TURMA
						)
					)
				) 
		END AS inalunopai
		, c.TURMA_REGULAR
		, a.SITUACAO  
		, h.INICIO
		, h.TERMINO
		, h.Lanc_Ata_Data_Limite as LANC_ATA_DATA_LIMITE
		, a.ETAPA
		, i.CFG_ACAD
		, CASE 
			WHEN CAST(GETDATE() AS DATE) <= CAST(h.Lanc_Ata_Data_Limite AS DATE) THEN 1
			WHEN CAST(GETDATE() AS DATE) > CAST(h.Lanc_Ata_Data_Limite AS DATE) THEN 0
		END AS INVISIVEL
		, j.SITUACAO as SITUACAO_ALUNO
		, j.MEDIA_ANUAL
		, j.MEDIA_APOS_EXAME
		, j.MEDIA_FINAL
		, CAST(j.PERC_FALTAS AS numeric(15,2)) AS PERC_FALTAS
		, dbo.fn_faltasbyetapa_get(a.TURMA, a.DISCIPLINA, j.MATRICULA, a.ETAPA) AS FALTAS
	FROM sonata.sophia.sophia.ATA_NOTA a
	INNER JOIN sonata.sophia.sophia.ata_aluno b ON a.CODIGO = b.ata
	INNER JOIN sonata.sophia.sophia.MATRICULA c ON b.matricula = c.CODIGO
	INNER JOIN sonata.sophia.sophia.FISICA d ON c.FISICA = d.CODIGO
	INNER JOIN sonata.sophia.sophia.TURMAS e ON e.CODIGO = a.TURMA
	INNER JOIN sonata.sophia.sophia.PERIODOS f ON f.CODIGO = e.PERIODO
	INNER JOIN sonata.sophia.sophia.CALENDARIOS g ON g.PERIODO = f.CODIGO AND g.CFG_ACAD = e.CFG_ACAD
	INNER JOIN sonata.sophia.sophia.CALEND_ETAPAS h ON h.CALENDARIO = g.CODIGO
	INNER JOIN sonata.sophia.sophia.ETAPAS i ON i.CODIGO = h.ETAPA  AND i.CFG_ACAD = e.CFG_ACAD
	INNER JOIN sonata.sophia.sophia.academic j ON j.MATRICULA = c.CODIGO AND a.DISCIPLINA = j.DISCIPLINA AND j.TURMA = a.TURMA
	LEFT JOIN tb_nota_aluno k ON k.idcod_ata_nota = a.CODIGO AND k.matricula = b.matricula
	WHERE a.TURMA = @TURMA and a.DISCIPLINA = @DISCIPLINA and i.NUMERO = @ETAPA and a.ETAPA = @ETAPA
	ORDER BY d.NOME
END
--
sp_notasalunosbyetapa_list 2585,31,1

SELECT PERIODO FROM SONATA.SOPHIA.SOPHIA.TURMAS
WHERE CODIGO = 2440

SELECT * FROM SONATA.SOPHIA.SOPHIA.PERIODOS
SELECT * FROM SONATA.SOPHIA.SOPHIA.MATRICULA

SELECt * FROM tb_nota_aluno a
INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
WHERE a.dtcadastro > '2014-09-01' and b.etapa = 2

selecT * frOM tb_disciplinas_nao_pai WHERE iddisciplina =  1126
SELECT * FROM tb_nota_aluno
SELECT * FROM sonata.sophia.sophia.ata_aluno
SELECT * FROM sonata.sophia.sophia.ata_nota where turma = 2490
 
SELECT a.* FROM tb_nota_aluno a
INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
WHERE b.TURMA = 2440 AND b.DISCIPLINA = 1126

sp_notasalunos_list 2350,400

SELECT SITUACAO, * FROM sophia.academic
WHERE TURMA = 2350 AND DISCIPLINA = 669

SELECT * FROM SONATA.SOPHIA.SOPHIA.ATA_NOTA
WHERE TURMA = 2477 AND disciplina = 1208 AND etapa = 4

SELECT * FROM SONATA.SOPHIA.SOPHIA.ATA_ALUNO
WHERE ATA = 21034

SELECT * FROM SONATA.SOPHIA.SOPHIA.ACADEMIC
WHERE TURMA = 2477 AND disciplina = 1208 AND matricula = 34257

SELECT 
	d.CODEXT AS RA
	, d.NOME
	, b.matricula AS MATRICULA 
	, b.nota
	, k.idnotaaluno
	, k.nota1
	, dbo.fn_nota_status(k.idcod_ata_nota, 1) AS innota1
	, k.nota2
	, dbo.fn_nota_status(k.idcod_ata_nota, 2) AS innota2
	, k.nota3 
	, dbo.fn_nota_status(k.idcod_ata_nota, 3) AS innota3
	, k.nota4 
	, dbo.fn_nota_status(k.idcod_ata_nota, 4) AS innota4
	, k.nota1peso
	, k.nota2peso
	, ISNULL(
		k.inalunopai, 
		dbo.fn_inalunopaiB1_get(b.matricula, a.disciplina, a.etapa, f.CODIGO)
	) AS inalunopai
	, a.SITUACAO  
	, h.INICIO
	, h.TERMINO
	, h.Lanc_Ata_Data_Limite as LANC_ATA_DATA_LIMITE
	, a.ETAPA
	, i.CFG_ACAD
	, CASE 
		WHEN CAST(GETDATE() AS DATE) <= CAST(h.Lanc_Ata_Data_Limite AS DATE) THEN 1
		WHEN CAST(GETDATE() AS DATE) > CAST(h.Lanc_Ata_Data_Limite AS DATE) THEN 0
	END AS INVISIVEL
	, j.SITUACAO as SITUACAO_ALUNO
	, j.MEDIA_ANUAL
	, j.MEDIA_APOS_EXAME
	, j.MEDIA_FINAL
	, CAST(j.PERC_FALTAS AS numeric(15,2)) AS PERC_FALTAS
	, dbo.fn_faltasbyetapa_get(a.TURMA, a.DISCIPLINA, j.MATRICULA, a.ETAPA) AS FALTAS
FROM sonata.sophia.sophia.ATA_NOTA a
INNER JOIN sonata.sophia.sophia.ata_aluno b ON a.CODIGO = b.ata
INNER JOIN sonata.sophia.sophia.MATRICULA c ON b.matricula = c.CODIGO
INNER JOIN sonata.sophia.sophia.FISICA d ON c.FISICA = d.CODIGO
INNER JOIN sonata.sophia.sophia.TURMAS e ON e.CODIGO = a.TURMA
INNER JOIN sonata.sophia.sophia.PERIODOS f ON f.CODIGO = e.PERIODO
INNER JOIN sonata.sophia.sophia.CALENDARIOS g ON g.PERIODO = f.CODIGO AND g.CFG_ACAD = 1
INNER JOIN sonata.sophia.sophia.CALEND_ETAPAS h ON h.CALENDARIO = g.CODIGO
INNER JOIN sonata.sophia.sophia.ETAPAS i ON i.CODIGO = h.ETAPA  AND i.CFG_ACAD = 1
INNER JOIN sonata.sophia.sophia.academic j ON j.MATRICULA = c.CODIGO AND a.DISCIPLINA = j.DISCIPLINA AND j.TURMA = a.TURMA
LEFT JOIN tb_nota_aluno k ON k.idcod_ata_nota = a.CODIGO AND k.matricula = b.matricula
where i.NUMERO in (1, 2, 3, 4) and a.ETAPA in (1, 2, 3, 4) and a.TURMA = 2521 and a.DISCIPLINA = 1438
ORDER BY d.NOME

SELECT CAST(GETDATE() AS DATE)
---
SELECT c.inalunopai FROM sonata.sophia.sophia.ata_nota a
INNER JOIN sonata.sophia.sophia.ata_aluno b ON b.ata = a.codigo 
INNER JOIN tb_nota_aluno c ON c.idcod_ata_nota = b.ata AND c.matricula = b.matricula
WHERE b.matricula = 34100  and a.etapa = 1 and a.disciplina = 1438

SELECT * FROM tb_nota_aluno WHERE idcod_ata_nota = 19992

SELECT * FROM dbo.fn_inalunopaiMb1_get()

select a.*, b.* from sophia.CALENDARIOS a
INNER JOIN sophia.CALEND_ETAPAS b
ON b.CALENDARIO = a.CODIGO
INNER JOIN sophia.ETAPAS c
ON b.ETAPA = c.CODIGO 
WHERE CALENDARIO = 188 and a.CFG_ACAD = 1 and c.NUMERO = 1

SELECT * FROM sonata.sophia.sophia.ATA_NOTA WHERE CODIGO = 20366
SELECT * FROM sonata.sophia.sophia.MATRICULA WHERE CODIGO = 32397
SELECT * FROM sonata.sophia.sophia.ATA_ALUNO
SELECT * FROM sonata.sophia.sophia.ETAPAS WHERE CFG_ACAD = 1
SELECT * FROM sophia.CALEND_ETAPAS  WHERE CALENDARIO = 188
SELECT * FROM sonata.sophia.sophia.CFG_ACAD
SELECT * FROM sophia.CALENDARIOS WHERE PERIODO = 117
SELECT * FROM sophia.AVALS
SELECT * FROM sophia.PERIODOS WHERE CODIGO = 117
SELECT * FROM sophia.QC 
SELECT * FROM sonata.sophia.sophia.TURMAS WHERE CODIGO = 2497
SELECT * FROM sonata.sophia.sophia.FISICA WHERE NOME LIKE '%FURIA%'

SELECT * FROM tb_nota_aluno

SELECT a.*, b.* FROM sophia.ATA_NOTA a
INNER JOIN sophia.ATA_ALUNO b
ON b.ata = a.CODIGO
WHERE a.ETAPA = 1 and a.DISCIPLINA = 400 and a.TURMA = 2350

SELECT * FROM tb_nota_aluno 
where matricula = 33969

SELECT * FROM tb_nota_aluno 
WHERE idnotaaluno in(1582,1583)


---------------------------------------------------------------------------
ALTER PROC sp_ata_nota_situacao_edit
(@TURMA int, @DISCIPLINA int, @ETAPA int, @RESPONSAVEL int, @SITUACAO smallint)
AS
/*
  app:Sophia
  url:../professor/ajax/salva_lista_notas.php
  author: Massaharu
  date: 1/10/2013
*/
BEGIN
	DECLARE @_ATA int, @_SITUACAO int
	
	SET NOCOUNT ON
	
	SELECT 
		@_ATA = CODIGO,
		@_SITUACAO = SITUACAO
	FROM sophia.ATA_NOTA 
	WHERE TURMA = @TURMA AND DISCIPLINA = @DISCIPLINA AND ETAPA = @ETAPA
	
	IF(@SITUACAO = 1)
		SET @SITUACAO = 2
	
	IF(@_SITUACAO <> @SITUACAO)
	BEGIN
		UPDATE sophia.ATA_NOTA
		SET SITUACAO = @SITUACAO
		WHERE TURMA = @TURMA AND DISCIPLINA = @DISCIPLINA AND ETAPA = @ETAPA
	END
	
	IF(@SITUACAO = 2)
		SET @SITUACAO = 1
	
	INSERT INTO sophia.ATA_HISTORICO
	(
		ATA
		,OPERACAO
		,RESPONSAVEL
		,OBSERVACAO
		,MOMENTO
	)VALUES(
		@_ATA
		,@SITUACAO
		,@RESPONSAVEL
		,NULL
		,GETDATE()
	)
	 
	SELECT SCOPE_IDENTITY() as COD_ATA_HISTORICO, @_ATA AS COD_ATA
	SET NOCOUNT OFF
END
--
sp_ata_nota_situacao_edit 2350, 6, 1, 18777, 1

select * from sophia.ATA_NOTA
where TURMA = 2350 AND DISCIPLINA = 400 AND ETAPA = 2

select * from sophia.ATA_HISTORICO
where ATA = 19049

---------------------------------------------------------------------------
ALTER PROC sp_ata_historico_lanc_save
(@COD_ATA_HISTORICO int, @MATRICULA int, @NOTA1 numeric(15, 4))
/*
  app:Sophia
  url:../professor/ajax/salva_lista_notas.php
  author: Massaharu
  date: 1/10/2013
*/
AS
BEGIN
	IF(@NOTA1 IS NOT NULL)
		INSERT INTO sophia.ATA_HISTORICO_LANCAMENTO(
			IDFK_HISTORICO
			,IDFK_MATRICULA
			,NOTA
		)VALUES(
			@COD_ATA_HISTORICO
			,@MATRICULA
			,@NOTA1
		)
END

sp_ata_historico_lanc_save 56863, 31407, null

select * from sophia.ATA_HISTORICO_LANCAMENTO
where IDFK_HISTORICO = 56995
---------------------------------------------------------------------------
ALTER PROC sp_ata_aluno_edit
(@TURMA int, @DISCIPLINA int, @ETAPA int, @MATRICULA int, @NOTA1 numeric(15, 4), @LANC_ATUAL smallint)
AS
/*
  app:Sophia
  url:../professor/ajax/salva_lista_notas.php
  author: Massaharu
  date: 1/10/2013
*/
BEGIN
	DECLARE @_COD_ATA int, @_NOTA1 int
	
	SET @_COD_ATA = (
		SELECT CODIGO FROM sophia.ATA_NOTA
		WHERE TURMA = @TURMA AND DISCIPLINA = @DISCIPLINA AND ETAPA = @ETAPA
	)
	
	SET @_NOTA1 = (SELECT nota FROM sophia.ata_aluno WHERE ata = @_COD_ATA AND matricula = @MATRICULA)
	
	--IF(@NOTA1 <> @_NOTA1)
	--BEGIN
		UPDATE sophia.ata_aluno
		SET nota = @NOTA1,
			LANC_ATUAL = @LANC_ATUAL
		WHERE ata = @_COD_ATA AND matricula = @MATRICULA
	--END
END

sp_ata_aluno_edit 2350, 6, 1, 31407, NULL, 1

select * from sophia.ATA_NOTA
where TURMA = 2350 AND DISCIPLINA = 400 AND ETAPA = 2

select * from sonata.sophia.sophia.ata_aluno
where ata = 19049





DECLARE @NOTA int
SET @NOTA = (select nota from sophia.ata_aluno
where ata = 19044 and matricula = 31407)
SELECT isnull(@NOTA, NULL) 
---------------------------------------------------------------------------
ALTER PROC sp_academic_edit
(@TURMA int, @DISCIPLINA int, @ETAPA int, @MATRICULA int, @NOTA1 numeric(15, 4))
AS
/*
  app:Sophia
  url:../professor/ajax/salva_lista_notas.php
  author: Massaharu
  date: 1/10/2013
*/
BEGIN

	SET NOCOUNT ON

	DECLARE @_COD_AVAL int

	DECLARE @_tb_academic TABLE(
		_COD_ACADEMIC int
		,_SITUACAO int
	) 
	
	INSERT INTO @_tb_academic
	select a.CODIGO, b.SITUACAO FROM sophia.academic a
	inner join sophia.ata_nota b on
	b.TURMA = a.TURMA and b.DISCIPLINA = a.DISCIPLINA
	where a.TURMA = @TURMA AND a.DISCIPLINA = @DISCIPLINA AND  MATRICULA = @MATRICULA AND ETAPA = @ETAPA
	
	SET @_COD_AVAL = (
		SELECT AVALIACAO FROM sophia.ATA_NOTA
		WHERE TURMA = @TURMA AND DISCIPLINA = @DISCIPLINA AND ETAPA = @ETAPA
	)

	UPDATE sophia.academic_lanc
	SET nota = @NOTA1,
		media = @NOTA1
	WHERE academic = (SELECT _COD_ACADEMIC FROM @_tb_academic) AND etapa = @ETAPA 
	
	UPDATE sophia.AVALUNO
	SET NOTA = @NOTA1
	WHERE MATRICULA = @MATRICULA and IDFK_ACADEMIC = (SELECT _COD_ACADEMIC FROM @_tb_academic) AND AVALIACAO = @_COD_AVAL
	
	IF((SELECT _SITUACAO FROM @_tb_academic) = 5)
	BEGIN
		IF(@ETAPA = 1)
			UPDATE sophia.academic
			SET NOTA1 = @NOTA1,
				MEDIA1 = @NOTA1
			WHERE CODIGO = (SELECT _COD_ACADEMIC FROM @_tb_academic)
		
		IF(@ETAPA = 2)
			UPDATE sophia.academic
				SET NOTA2 = @NOTA1,
					MEDIA2 = @NOTA1
				WHERE CODIGO = (SELECT _COD_ACADEMIC FROM @_tb_academic)
		
		IF(@ETAPA = 3)
			UPDATE sophia.academic
			SET NOTA3 = @NOTA1,
				MEDIA3 = @NOTA1
			WHERE CODIGO = (SELECT _COD_ACADEMIC FROM @_tb_academic)
		
		IF(@ETAPA = 4)
			UPDATE sophia.academic
			SET NOTA4 = @NOTA1,
				MEDIA4 = @NOTA1
			WHERE CODIGO = (SELECT _COD_ACADEMIC FROM @_tb_academic)
		
		IF(@ETAPA = 14)
			UPDATE sophia.academic
			SET EXAME = @NOTA1
			WHERE CODIGO = (SELECT _COD_ACADEMIC FROM @_tb_academic)
			
		
			
		--IF NOT EXISTS(SELECT SITUACAO FROM sophia.ata_nota 
		--WHERE TURMA = @TURMA AND DISCIPLINA = @DISCIPLINA AND SITUACAO <> 5 AND ETAPA <> 14)
		--BEGIN
		--	-- AQUI ENTRA O CALCULO DAS MEDIAS
		--	-- PRINT 'MEDIA'
		
		--END
	END
	
	DECLARE @academic int
	SET @academic = (SELECT _COD_ACADEMIC FROM @_tb_academic)
	
	SELECT @academic as CODIGO
	
	SET NOCOUNT OFF
END

------

DECLARE @academic int
SET @academic = 232117

exec sp_academic_lanc_media @academic


sp_academic_edit 2350, 669, 2, 31407, '6.000'

select * from 

select * from sophia.academic
where TURMA = 2350 AND DISCIPLINA = 669  AND  MATRICULA = 31407 

select * from sophia.academic_lanc
where academic = 236494

select * from sophia.ata_nota
where TURMA = 2350 AND DISCIPLINA = 669 AND SITUACAO = 5 AND ETAPA <> 14

select * from sophia.ata_aluno
where ata = 19050

select * from sophia.FISICA
where CODIGO = 31895

SELECT * FROM SONATA.SOPHIA.SOPHIA.ACADEMIC
WHERE TURMA = 2531 AND disciplina = 1120
ORDER BY MATRICULA

select * from sophia.academic_lanc
where academic = 232117

select * from sophia.academic
where codigo = 232117

select a.CODIGO, b.SITUACAO FROM sophia.academic a
inner join sophia.ata_nota b on
b.TURMA = a.TURMA and b.DISCIPLINA = a.DISCIPLINA
where a.TURMA = 2350 AND a.DISCIPLINA = 669 AND  MATRICULA = 31407 AND ETAPA = 2

SELECT * FROM SONATA.SOPHIA.SOPHIA.ACADEMIC WHERE TURMA  = 2556 AND disciplina = 1657

SELECT * FROM sophia.AVALUNO WHERE IDFK_ACADEMIC = 232117 AND AVALIACAO = 18706 and MATRICULA = 31407 
---------------------------------------------------------------------------
ALTER PROC sp_academic_pos_edit
(@TURMA int, @DISCIPLINA int, @ETAPA int, @MATRICULA int, @NOTA1 numeric(15, 4))
AS
/*
  app:Sophia
  url:../professor/ajax/salva_lista_notas.php
  author: Massaharu
  date: 1/10/2013
*/
BEGIN

	SET NOCOUNT ON

	DECLARE @_COD_AVAL int

	DECLARE @_tb_academic TABLE(
		_COD_ACADEMIC int
		,_SITUACAO int
	) 
	
	INSERT INTO @_tb_academic
	select a.CODIGO, b.SITUACAO FROM sophia.academic a
	inner join sophia.ata_nota b on
	b.TURMA = a.TURMA and b.DISCIPLINA = a.DISCIPLINA
	where a.TURMA = @TURMA AND a.DISCIPLINA = @DISCIPLINA AND  MATRICULA = @MATRICULA AND ETAPA = @ETAPA

	
	SET @_COD_AVAL = (
		SELECT AVALIACAO FROM sophia.ATA_NOTA
		WHERE TURMA = @TURMA AND DISCIPLINA = @DISCIPLINA AND ETAPA = @ETAPA
	)
	
	UPDATE sophia.academic_lanc
	SET nota = @NOTA1,
		media = @NOTA1
	WHERE academic = (SELECT _COD_ACADEMIC FROM @_tb_academic) AND etapa = @ETAPA 
	
	UPDATE sophia.AVALUNO
	SET NOTA = @NOTA1
	WHERE MATRICULA = @MATRICULA and IDFK_ACADEMIC = (SELECT _COD_ACADEMIC FROM @_tb_academic) AND AVALIACAO = @_COD_AVAL
	
	IF((SELECT _SITUACAO FROM @_tb_academic) = 5 AND @ETAPA = 1)
	BEGIN
		UPDATE sophia.academic
		SET NOTA1 = @NOTA1,
			MEDIA1 = @NOTA1
		WHERE CODIGO = (SELECT _COD_ACADEMIC FROM @_tb_academic)
	END
	
	DECLARE @academic int
	SET @academic = (SELECT _COD_ACADEMIC FROM @_tb_academic)
	
	SELECT @academic as CODIGO
	
	SET NOCOUNT OFF
END
--

SELECT * FROM sonata.sophia.sophia.ata_nota where turma = 2350

select a.CODIGO, b.SITUACAO FROM sophia.academic a
inner join sophia.ata_nota b on
b.TURMA = a.TURMA and b.DISCIPLINA = a.DISCIPLINA
where a.TURMA = 2636 AND a.DISCIPLINA = 1217 AND  MATRICULA = 36292 AND ETAPA = 1

---------------------------------------------------------------------------
ALTER PROC sp_academic_lanc_media --232114
(@academic int)
AS
/*
  app:Sophia
  url:../professor/ajax/salva_lista_notas.php
  author: Massaharu
  date: 1/10/2013
*/
BEGIN
	DECLARE 
		@b1 numeric(15, 4)
		, @b2 numeric(15, 4)
		, @exame numeric(15, 4) 
		, @fimdasetapas  numeric(15, 4) 
	
	IF((SELECT media FROM sophia.academic_lanc
	WHERE academic = @academic and etapa = 3) IS NOT NULL)
		SET @b1 = (
			select isnull(media, 0) from sophia.academic_lanc
			where academic = @academic and etapa = 3
		)
	ELSE
		SET @b1 = (
			select isnull(media, 0) from sophia.academic_lanc
			where academic = @academic and etapa = 1
		)
	
	IF((SELECT media FROM sophia.academic_lanc
	WHERE academic = @academic and etapa = 4) IS NOT NULL)
		SET @b2 = (
			select isnull(media, 0) from sophia.academic_lanc
			where academic = @academic and etapa = 4
		)
	ELSE
		SET @b2 = (
			select isnull(media, 0) from sophia.academic_lanc
			where academic = @academic and etapa = 2
		)
	
	UPDATE sophia.academic_lanc
	SET media = dbo.fn_arredonda_media((@b1 + @b2) / 2) 
	WHERE academic = @academic and etapa = 13
	
	SET @exame = (
		select isnull(media, 0) from sophia.academic_lanc
		where academic = @academic and etapa = 14
	)
	SET @fimdasetapas = (
		select isnull(media, 0) from sophia.academic_lanc
		where academic = @academic and etapa = 13
	)
	
	IF((SELECT media FROM sophia.academic_lanc
	WHERE academic = @academic and etapa = 14) IS NOT NULL)
		UPDATE sophia.academic_lanc
		SET media = dbo.fn_arredonda_media((@exame + @fimdasetapas) / 2)
		WHERE academic = @academic and etapa = 16
	ELSE
		UPDATE sophia.academic_lanc
		SET media = @fimdasetapas
		WHERE academic = @academic and etapa = 16
END


select * from SONATA.SOPHIA.sophia.academic where turma = 2556 and disciplina = 1657
select * from SONATA.SOPHIA.sophia.academic_lanc
where academic = 262295 and etapa = 14

----------------------------------------------------------------------
CREATE PROC sp_academic_lanc_media_pos --232114
(@academic int)
AS
/*
  app:Sophia
  url:../professor/ajax/salva_lista_notas_pos.php
  author: Massaharu
  date: 1/10/2013
*/
BEGIN
	DECLARE 
		@b1 numeric(15, 4)
		, @fimdasetapas  numeric(15, 4) 
		
	SET @b1 = (
		select isnull(media, 0) from sophia.academic_lanc
		where academic = @academic and etapa = 1
	)
	
	UPDATE sophia.academic_lanc
	SET media = @b1
	WHERE academic = @academic and (etapa = 13 OR etapa = 16)
	
END
----------------------------------------------------------------------
ALTER PROC sp_academic_media
(@academic int, @TURMA int, @DISCIPLINA int, @ETAPA int)
AS
/*
  app:Sophia
  url:../professor/ajax/salva_lista_notas.php
  author: Massaharu
  date: 1/10/2013
*/
BEGIN
	-- Apenas quando todas as etapas (1, 2, 3, 4) Estiverem processadas
	IF NOT EXISTS(SELECT SITUACAO FROM sophia.ata_nota 
		WHERE TURMA = @TURMA AND DISCIPLINA = @DISCIPLINA AND SITUACAO <> 5 AND ETAPA <> 14)
	BEGIN
		DECLARE 
			@b1 numeric(15, 4)
			, @b2 numeric(15, 4)
			, @exame numeric(15, 4) 
			, @fimdasetapas  numeric(15, 4) 
			, @percfaltas numeric(15, 4)
			, @media_apos_exame numeric(15, 4)
			, @media_anual numeric(15, 4)

		IF((SELECT NOTA3 FROM sophia.academic
		WHERE codigo = @academic) IS NOT NULL)
			SET @b1 = (
				select isnull(NOTA3, 0) from sophia.academic
				where codigo = @academic
			)
		ELSE
			SET @b1 = (
				select isnull(NOTA1, 0) from sophia.academic
				where codigo = @academic
			)
		
		IF((SELECT NOTA4 FROM sophia.academic
		WHERE CODIGO = @academic) IS NOT NULL)
			SET @b2 = (
				select isnull(NOTA4, 0) from sophia.academic
				where codigo = @academic 
			)
		ELSE
			SET @b2 = (
				select isnull(NOTA2, 0) from sophia.academic
				where codigo = @academic
			)
			
		SET @exame = (
			select isnull(EXAME, 0) from sophia.academic
			where CODIGO = @academic 
		)
		
		UPDATE sophia.academic
		SET MEDIA_ANUAL = dbo.fn_arredonda_media((@b1 + @b2) / 2) 
		WHERE codigo = @academic 
		
		IF((SELECT MEDIA_ANUAL FROM sophia.academic
		WHERE CODIGO = @academic) IS NOT NULL)
		BEGIN
			SET @fimdasetapas = (
				select isnull(MEDIA_ANUAL, 0) from sophia.academic
				where codigo = @academic 
			)
		   	
		   	IF((SELECT EXAME FROM sophia.academic
			WHERE CODIGO = @academic ) IS NOT NULL)
				UPDATE sophia.academic
				SET MEDIA_APOS_EXAME = dbo.fn_arredonda_media((@exame + @fimdasetapas) / 2)
				WHERE codigo = @academic
			
			IF((SELECT MEDIA_APOS_EXAME FROM sophia.academic
			WHERE CODIGO = @academic) IS NOT NULL)
				UPDATE sophia.academic
				SET MEDIA_FINAL = (
					SELECT MEDIA_APOS_EXAME FROM sophia.academic
					WHERE CODIGO = @academic
				),
				MEDIA_FINALSTR = (
					SELECT CAST(ROUND(MEDIA_APOS_EXAME, 2, 1) AS NUMERIC(15,2)) FROM sophia.academic
					WHERE CODIGO = @academic
				)
				WHERE codigo = @academic
			ELSE
				UPDATE sophia.academic
				SET MEDIA_FINAL = (
					SELECT MEDIA_ANUAL FROM sophia.academic
					WHERE CODIGO = @academic
				),
				MEDIA_FINALSTR = (
					SELECT CAST(ROUND(MEDIA_ANUAL, 2, 1) AS NUMERIC(15,2)) FROM sophia.academic
					WHERE CODIGO = @academic
				)
				WHERE codigo = @academic
				
			SET @percfaltas = (
				SELECT PERC_FALTAS FROM sophia.academic
				WHERE CODIGO = @academic
			)			
			SET @media_apos_exame = (
				SELECT MEDIA_APOS_EXAME FROM sophia.academic
				WHERE CODIGO = @academic
			)			
			SET @media_anual = (
				SELECT MEDIA_ANUAL FROM sophia.academic
				WHERE CODIGO = @academic
			)
			
			-- SE O ALUNO TIVER MENOS OU IGUAL A 25% DE FALTAS
			IF(@percfaltas <= 25)
			BEGIN
				-- SE O ACADEMICO DO ALUNO TIVER MEDIA APOS O EXAME
				IF(@media_apos_exame IS NOT NULL)	
				BEGIN
					-- SE A ATA FOR [FINALIZADA]
					IF((
						SELECT SITUACAO FROM sophia.ata_nota 
						WHERE turma = @TURMA and ETAPA = @ETAPA and disciplina = @DISCIPLINA) = 5)
					BEGIN
						IF(@ETAPA = 14)
						BEGIN
							IF(@media_apos_exame >= 5)
								UPDATE sophia.academic
								SET SITUACAO = 1 -- APROVADO
								WHERE CODIGO = @academic
							ELSE
								UPDATE sophia.academic
								SET SITUACAO = 2 -- REPROVADO
								WHERE CODIGO = @academic
						END
						ELSE
						BEGIN
							IF(@media_anual >= 7)
								UPDATE sophia.academic
								SET SITUACAO = 1 -- APROVADO
								WHERE CODIGO = @academic
							ELSE IF(@media_anual >= 3)
								UPDATE sophia.academic
								SET SITUACAO = 3 -- EM EXAME
								WHERE CODIGO = @academic
							ELSE
								UPDATE sophia.academic
								SET SITUACAO = 2 -- REPROVADO
								WHERE CODIGO = @academic
						END
					END
					-- SE A ATA FOR [SALVA]
					ELSE
					BEGIN
						IF(@media_anual >= 7)
							UPDATE sophia.academic
							SET SITUACAO = 1 -- APROVADO
							WHERE CODIGO = @academic
						ELSE IF(@media_anual >= 3)
							UPDATE sophia.academic
							SET SITUACAO = 3 -- EM EXAME
							WHERE CODIGO = @academic
						ELSE
							UPDATE sophia.academic
							SET SITUACAO = 2 -- REPROVADO
							WHERE CODIGO = @academic
					END
				END
				-- SE O ACADEMICO DO ALUNO [NÃO] TIVER MEDIA APOS O EXAME
				ELSE
				BEGIN
					IF(@ETAPA = 14)
					BEGIN
						-- SE A ATA FOR [FINALIZADA]
						IF((
							SELECT SITUACAO FROM sophia.ata_nota 
							WHERE turma = @TURMA and ETAPA = @ETAPA and disciplina = @DISCIPLINA) = 5)
						BEGIN
							IF(@media_anual >= 7)
								UPDATE sophia.academic
								SET SITUACAO = 1 -- APROVADO
								WHERE CODIGO = @academic
							ELSE 
								UPDATE sophia.academic
								SET SITUACAO = 2 -- REPROVADO
								WHERE CODIGO = @academic
						END
					END
					ELSE
					BEGIN
						IF(@media_anual >= 7)
							UPDATE sophia.academic
							SET SITUACAO = 1 -- APROVADO
							WHERE CODIGO = @academic
						ELSE IF(@media_anual >= 3)
							UPDATE sophia.academic
							SET SITUACAO = 3 -- EM EXAME
							WHERE CODIGO = @academic
						ELSE
							UPDATE sophia.academic
							SET SITUACAO = 2 -- REPROVADO
							WHERE CODIGO = @academic
					END
				END
			END
			ELSE
				UPDATE sophia.academic
				SET SITUACAO = 2 -- REPROVADO
				WHERE CODIGO = @academic
		END
	END
END
---
SELECT 
	CODIGO
	, MATRICULA
	, DISCIPLINA
	, SITUACAO
	, NOTA1 
	, NOTA2
	, NOTA3
	, NOTA4
	, EXAME
	, MEDIA_ANUAL
	, MEDIA_APOS_EXAME
	, MEDIA_FINAL
	, MEDIA_FINALSTR
	, FALTAS1
	, FALTAS2
	, FALTAS3
	, FALTAS4
	, FALTAS5
	, PERC_FALTAS
	, CARGA_HORARIA
FROM sophia.academic
WHERE MATRICULA = 31895 OR SITUACAO = 2 AND PERC_FALTAS <= 25 AND EXAME IS NULL--28536

SELECT b.CODIGO, * FROM sophia.FISICA a
INNER JOIN sophia.MATRICULA b
ON b.FISICA = a.CODIGO
WHERE CODEXT = '1410068'


SELECT SITUACAO,* FROM SONATA.SOPHIA.sophia.ata_nota 
WHERE TURMA = 2521 AND DISCIPLINA = 6 AND ETAPA = 14

SELECT * FROM SONATA.SOPHIA.sophia.academic a
INNER JOIN SONATA.SOPHIA.sophia.ata_aluno b ON b.matricula = a.matricula
INNER JOIN SONATA.SOPHIA.sophia.ata_nota c ON c.CODIGO  = b.ata AND c.TURMA = a.TURMA and c.DISCIPLINA = a.DISCIPLINA
WHERE b.ata = 20003 

SELECT * FROM SONATA.SOPHIA.sophia.ata_aluno 

SELECT * FROM sophia.AVALUNO
WHERE AVALIACAO in(18703
,18707
,18711
,18715
,18719)

sp_academic_media 256964, 2521, 6, 14

SELECT SITUACAO FROM sonata.sophia.sophia.ata_nota 
WHERE turma = 2521 and disciplina = 6 and ETAPA = 14 

SELECT * FROM SONATA.SOPHIA.SOPHIA.ACADEMIC 
WHERE TURMA = 2531 AND DISCIPLINA = 55

SELECT * FROM SONATA.SOPHIA.SOPHIA.HIST_ALUNO
-----------------------------------------------------------------------------
ALTER PROC sp_academic_media_pos
(@academic int, @TURMA int, @DISCIPLINA int, @ETAPA int, @INFINALIZADO int)
AS
/*
  app:Sophia
  url:../professor/ajax/salva_lista_notas.php
  author: Massaharu
  date: 1/10/2013
*/
BEGIN
-- Apenas quando todas as etapas (1, 2, 3, 4) Estiverem processadas
	DECLARE 
		@b1 numeric(15, 4)
		, @fimdasetapas  numeric(15, 4) 
		, @percfaltas numeric(15, 4)
		, @media_anual numeric(15, 4)
		
	SET @b1 = (
		select isnull(NOTA1, 0) from sophia.academic
		where codigo = @academic
	)	
	
	UPDATE sophia.academic
	SET MEDIA_ANUAL = @b1
	WHERE codigo = @academic 
	
	IF((
		SELECT MEDIA_ANUAL FROM sophia.academic
		WHERE CODIGO = @academic) IS NOT NULL
	)
	BEGIN
		SET @fimdasetapas = (
			select isnull(MEDIA_ANUAL, 0) from sophia.academic
			where codigo = @academic 
		)
		
		UPDATE sophia.academic
		SET 
			MEDIA_FINAL = (
				SELECT MEDIA_ANUAL FROM sophia.academic
				WHERE CODIGO = @academic
			),
			MEDIA_FINALSTR = (
				SELECT CAST(ROUND(MEDIA_ANUAL, 2, 1) AS NUMERIC(15,2)) FROM sophia.academic
				WHERE CODIGO = @academic
			)
		WHERE codigo = @academic
			
		SET @percfaltas = (
			SELECT PERC_FALTAS FROM sophia.academic
			WHERE CODIGO = @academic
		)			
		SET @media_anual = (
			SELECT MEDIA_ANUAL FROM sophia.academic
			WHERE CODIGO = @academic
		)
		
		--SE A LISTA FOR SALVO [EM LANCAMENTO]
		IF @INFINALIZADO <> 1
		BEGIN
			-- SE O ALUNO TIVER MENOS OU IGUAL A 25% DE FALTAS
			IF(@percfaltas <= 25)
			BEGIN
					
				IF(@media_anual >= 7)
					UPDATE sophia.academic
					SET SITUACAO = 1 -- APROVADO
					WHERE CODIGO = @academic
				ELSE
					UPDATE sophia.academic
					SET SITUACAO = 2 -- REPROVADO
					WHERE CODIGO = @academic
			END		
			ELSE
			BEGIN
				UPDATE sophia.academic
				SET SITUACAO = 2 -- REPROVADO
				WHERE CODIGO = @academic
			END
		END
	END
END
-----------------------------------------------------------------------------
CREATE PROC sp_ata_nota_situacao_get
(@idturma int, @iddisciplina int)
AS
/*
  app:Sophia
  url:../professor/ajax/ata_nota_situacao_get.php
  author: Massaharu
  date: 1/10/2013
  descricao: retorna as atas de uma mesma turma e disciplina
*/
BEGIN
	SELECT CODIGO, NUMERO, TURMA, DISCIPLINA, SETOR, AVALIACAO, GRUPO, ETAPA, TIPO, SITUACAO, DATA_LIMITE
	FROM SONATA.SOPHIA.SOPHIA.ATA_NOTA
	WHERE TURMA = @idturma AND DISCIPLINA = @iddisciplina
END

sp_ata_nota_situacao_get 2521, 6
-----------------------------------------------------------------------------
ALTER PROC sp_ata_nota_log_save
(@cod_ata int, @situacao int, @inretificado int, @desmotivoretificacao varchar(1000))
AS
/*
  app:Sophia
  url:../professor/ajax/salva_lista_notas.php
  author: Massaharu
  date: 1/10/2013
*/
BEGIN
	INSERT INTO tb_ata_nota_log
	(
		codigo
		, idsituacao
		, inretificado
		, desmotivoretificacao
	)VALUES(
		@cod_ata
		, @situacao
		, @inretificado
		, @desmotivoretificacao
	)
END
--
SELECT 
	a.idatanotalog
	, h.CODIGO as CODTURMA
	, h.NOME as turma
	, g.codigo as cod_ata
	, a.idsituacao as acao
	, g.SITUACAO as situacao_ata
	, a.inretificado
	, a.desmotivoretificacao
	, e.nome as desetapa
	, d.codigo as coddisciplina
	, d.nome as desdisciplina
	, f.nome as desprofessor
	, f.codext
	, f.senha
	, a.dtcadastro
FROM fit_new.dbo.tb_ata_nota_log a
INNER JOIN sonata.sophia.sophia.ata_nota b ON b.codigo = a.codigo
INNER JOIN sonata.sophia.sophia.qc c ON c.turma = b.turma AND c.disciplina = b.disciplina
INNER JOIN sonata.sophia.sophia.disciplinas d ON d.codigo = b.DISCIPLINA
INNER JOIN sonata.sophia.sophia.etapas e ON e.numero = b.etapa and CFG_ACAD = 1
INNER JOIN sonata.sophia.sophia.FISICA f ON f.codigo = c.PROFESSOR
INNER JOIN sonata.sophia.sophia.ATA_NOTA g ON g.CODIGO = a.codigo
INNER JOIN sonata.sophia.sophia.TURMAS h ON h.CODIGO = g.TURMA WHERE inretificado = 1
WHERE h.CODIGO = 2410 AND d.CODIGO = 247
ORDER BY a.dtcadastro

SELECT * FROM sonata.sophia.sophia.TURMAS = 
SELECT * FROM sonata.sophia.sophia.ATA_NOTA WHERE TURMA = 2521 AND DISCIPLINA = 1438 AND ETAPA = 14
SELECT * FROM fit_new.dbo.tb_ata_nota_log

--UPDATE sonata.sophia.sophia.ATA_NOTA
SET SITUACAO = 2
WHERE TURMA = 2521 AND DISCIPLINA = 1438 AND ETAPA = 14
---------------------------------------------------------------------------
CREATE FUNCTION dbo.fn_arredonda_media--('6.24')
(@nota numeric (15, 4))
RETURNS numeric (15, 4)
/*
  app:Sophia
  author: Massaharu
  date: 1/10/2013
*/
AS
BEGIN
	RETURN ROUND((@nota / 0.5) , 0) * 0.5      
END
---------------------------------------------------------------------------
ALTER FUNCTION dbo.fn_nota_status
(@COD_ATA_NOTA int, @coluna int)
RETURNS INT
/*
  app:Sophia
  author: Massaharu
  date: 1/10/2013
  desc: Verifica se as colunas de cada nota estão nulas
*/
BEGIN
	DECLARE @RET INT
	SET @RET = 0
	
	IF(@coluna = 1)
		IF(SELECT SUM(nota1) FROM tb_nota_aluno WHERE idcod_ata_nota = @COD_ATA_NOTA) IS NOT NULL
			SET @RET = 1
			
	IF(@coluna = 2)
		IF(SELECT SUM(nota2) FROM tb_nota_aluno WHERE idcod_ata_nota = @COD_ATA_NOTA) IS NOT NULL
			SET @RET = 1
	
	IF(@coluna = 3)
		IF(SELECT SUM(nota3) FROM tb_nota_aluno WHERE idcod_ata_nota = @COD_ATA_NOTA) IS NOT NULL
			SET @RET = 1
	
	IF(@coluna = 4)
		IF(SELECT SUM(nota4) FROM tb_nota_aluno WHERE idcod_ata_nota = @COD_ATA_NOTA) IS NOT NULL
			SET @RET = 1
	
	RETURN @RET
END
---------------------------------------------------------------------------
sp_rename 'fn_faltas_get', 'fn_faltasbyetapa_get'
CREATE FUNCTION dbo.fn_faltasbyetapa_get
(@TURMA int, @DISCIPLINA int, @MATRICULA int, @ETAPA int)
RETURNS INT
/*
  app:Sophia
  author: Massaharu
  date: 1/10/2013
*/
BEGIN
	DECLARE @FALTAS int
	IF(@ETAPA = 1)
		SET @FALTAS = (
			SELECT FALTAS1 FROM sonata.sophia.sophia.academic 
			WHERE turma = @TURMA and DISCIPLINA = @DISCIPLINA and MATRICULA = @MATRICULA
		)
	ELSE IF(@ETAPA = 2)
		SET @FALTAS = (
			SELECT FALTAS2 FROM sonata.sophia.sophia.academic 
			WHERE turma = @TURMA and DISCIPLINA = @DISCIPLINA and MATRICULA = @MATRICULA
		)
	ELSE IF(@ETAPA = 3)
		SET @FALTAS = (
			SELECT FALTAS3 FROM sonata.sophia.sophia.academic 
			WHERE turma = @TURMA and DISCIPLINA = @DISCIPLINA and MATRICULA = @MATRICULA
		)
	ELSE IF(@ETAPA = 4)
		SET @FALTAS = (
			SELECT FALTAS4 FROM sonata.sophia.sophia.academic 
			WHERE turma = @TURMA and DISCIPLINA = @DISCIPLINA and MATRICULA = @MATRICULA
		)
	ELSE IF(@ETAPA = 14)
		SET @FALTAS = (
			SELECT FALTAS5 FROM sonata.sophia.sophia.academic 
			WHERE turma = @TURMA and DISCIPLINA = @DISCIPLINA and MATRICULA = @MATRICULA
		)
	
	RETURN @FALTAS
END

SELECT dbo.fn_faltasbyetapa_get(2350, 669, 31407, 4)
---------------------------------------------------------------------------
ALTER FUNCTION dbo.fn_faltas_get 
(@TURMA int, @DISCIPLINA int, @MATRICULA int)
RETURNS INT
/*
  app:Sophia
  author: Massaharu
  date: 1/10/2013
*/
BEGIN
	DECLARE @FALTAS int
	
	SET @FALTAS = (
		SELECT (FALTAS1+FALTAS2) FROM sonata.sophia.sophia.academic 
		WHERE turma = @TURMA and DISCIPLINA = @DISCIPLINA and MATRICULA = @MATRICULA
	)
	
	
	RETURN @FALTAS
END

SELECT dbo.fn_faltas_get(2350, 6, 31407)

SELECT FALTAS1, FALTAS2, FALTAS3, FALTAS4, FALTAS5 FROM sonata.sophia.sophia.academic 
WHERE turma = 2350 and DISCIPLINA = 6 and MATRICULA = 31407
-----------------------------------------------------------------------
ALTER proc [dbo].[sp_turmas_grad_tecn_list]
(@idperiodo int = null)
AS
/*
	url: /simpacweb/modulos/fit/adm_contrato/json/list_turmas_por_periodo.php
	data: 12/02/2014
	author: Massaharu
*/
BEGIN
	IF @idperiodo IS NULL or @idperiodo = 0
	BEGIN
		select a.CODIGO, a.NOME AS TURMA, b.DESCRICAO as desperiodo
		from SONATA.SOPHIA.SOPHIA.TURMAS a
		INNER JOIN SONATA.SOPHIA.SOPHIA.PERIODOS b ON b.CODIGO = a.PERIODO
		INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS C ON C.PRODUTO = A.CURSO
		WHERE c.NIVEL in(1,2)
		order by b.CODIGO desc, a.NOME, a.CODIGO
	END
	ELSE
	BEGIN
		select a.CODIGO, a.NOME AS TURMA, b.DESCRICAO as desperiodo 
		from SONATA.SOPHIA.SOPHIA.TURMAS a
		INNER JOIN SONATA.SOPHIA.SOPHIA.PERIODOS b ON b.CODIGO = a.PERIODO
		INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS C ON C.PRODUTO = A.CURSO
		where PERIODO = @idperiodo AND c.NIVEL in(1,2)
		order by a.NOME, a.CODIGO
	END
END
--
sp_turmas_grad_tecn_list 125

SELECT A.CODIGO, NOME AS TURMA, B.DESCRICAO AS DESPERIODO 
FROM SOPHIA.TURMAS A
INNER JOIN SOPHIA.PERIODOS B ON B.CODIGO = A.PERIODO
INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS C ON C.PRODUTO = A.CURSO

WHERE PERIODO = @IDPERIODO
ORDER BY NOME, A.CODIGO

SELECT id FROM Simpac.dbo.fnSplit('1, 2', ',')

SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS
SELECT * FROM SONATA.SOPHIA.SOPHIA.SERIE
SELECT * FROM SONATA.SOPHIA.SOPHIA.CURRICULO
SELECT * FROM SONATA.SOPHIA.SOPHIA.GRADES
SELECT * FROM SONATA.SOPHIA.SOPHIA.NIVEL
SELECT * FROM SONATA.SOPHIA.SOPHIA.CURSOS
-----------------------------------------------------------------------
CREATE PROC sp_academic_by_turmadisciplina_list
(@idturma int, @iddisciplina int)
AS
/*
	url: /simpacweb/modulos/fit/admTurmasPAI/ajax/recalc_disciplina.php
	data: 12/02/2014
	author: Massaharu
	descricao: Lista todos os alunos de uma mesma turma e disciplina
*/
BEGIN
	SELECT * FROM SONATA.SOPHIA.SOPHIA.ACADEMIC
	WHERE TURMA = @idturma AND DISCIPLINA = @iddisciplina
END
-----------------------------------------------------------------------
-----------------------------------------------------------------------
USE FIT_NEW

CREATE TABLE tb_notas_extra(
	idnotaextra int identity CONSTRAINT PK_notas_extra PRIMARY KEY
	,desnotaextra varchar(100) not null
	,instatus bit CONSTRAINT DF_notas_extra_instatus DEFAULT (1)
	,dtcadastro datetime CONSTRAINT DF_notas_extra_dtcadastro DEFAULT (getdate())
)
INSERT INTO tb_notas_extra
(desnotaextra)
VALUES
('Trabalho'), ('Pontos Extras')

SELECT * FROM tb_notas_extra
-----------------------------------------------------------------------
-----------------------------------------------------------------------
--nota1 = nota
--nota2 = trabalho
--nota3 = pontos extras
--nota4 = PAI
CREATE TABLE tb_nota_aluno(
	idnotaaluno int IDENTITY CONSTRAINT PK_nota_aluno PRIMARY KEY
	,idcod_ata_nota int not null
	,matricula int
	,nota1 numeric(15,4)
	,nota2 numeric(15,4)
	,nota3 numeric(15,4)
	,dtcadastro datetime CONSTRAINT DF_nota_aluno_dtcadastro DEFAULT(getdate())
) 
ALTER TABLE tb_nota_aluno
ADD nota4 numeric(15, 4)
ALTER TABLE tb_nota_aluno
ADD nota1peso numeric(2, 1)
ALTER TABLE tb_nota_aluno
ADD nota2peso numeric(2, 1)
ALTER TABLE tb_nota_aluno
ADD inalunopai bit CONSTRAINT DF_nota_aluno_inalunopai DEFAULT(1)


SELECT * FROM [sophia.ata_aluno]
SELECT * FROm tb_nota_aluno
-----------------------------------------------------------------------
CREATE TABLE tb_nota_aluno_alterados(
	idnotaaluno int
	,idcod_ata_nota int not null
	,matricula int
	,nota1 numeric(15,4)
	,nota2 numeric(15,4)
	,nota3 numeric(15,4)
	,dtcadastro datetime
	,nota4 numeric(15, 4)
	,nota1peso numeric(2, 1)
	,nota2peso numeric(2, 1)
	,inalunopai bit
) 
--INSERT INTO tb_nota_aluno_alterados
SELECT * FROM tb_nota_aluno
SELECT * FROM tb_nota_aluno_alterados

-----------------------------------------------------------------------
------------------- PROCEDURES----- -----------------------------------
CREATE PROC sp_notas_extras_list
AS
/*
  app:Site FIT
  url:../professor/ajax/list_notas_alunos.php
  author: Massaharu
  date: 1/12/2013
*/
BEGIN
	SELECT
		idnotaextra
		,desnotaextra
		,instatus
		,dtcadastro
	FROM tb_notas_extra
	WHERE instatus = 1
END
-----------------------------------------------------------------------
sp_nota_aluno_save 5458, 2521, 669, 2, 34100, '5.00', NULL, NULL, '1', NULL, 1, 0
sp_nota_aluno_save 5458, 2521, 669, 2, 34100, '5.00', NULL, NULL, '1', NULL, 0

ALTER PROC sp_nota_aluno_save
(
	@idnotaaluno int
	,@turma int
	,@disciplina int
	,@etapa int
	,@matricula int
	,@nota1 numeric (15, 4)
	,@nota2 numeric (15, 4)
	,@nota3 numeric (15, 4)
	,@nota1peso numeric (2, 1)
	,@nota2peso numeric (2, 1)
	,@inalunopai bit
)
AS
/*
  app:Site FIT
  url:../professor/ajax/salva_lista_notas.php
  author: Massaharu
  date: 1/12/2013
  desc: @nota1 = Nota, @nota2 = Trabalho, @nota3 = Ponto extra, @nota4 = PAI
*/
BEGIN
	SET NOCOUNT ON
	
	DECLARE @COD_ATA_ALUNO int
	
	SET @COD_ATA_ALUNO = (
		SELECT CODIGO FROM sonata.sophia.sophia.ata_nota
		WHERE TURMA = @turma AND ETAPA = @etapa AND DISCIPLINA = @disciplina
	)
		
	IF EXISTS(SELECT idnotaaluno FROM tb_nota_aluno WHERE idnotaaluno = @idnotaaluno)
	BEGIN
		UPDATE tb_nota_aluno
		SET idcod_ata_nota = @COD_ATA_ALUNO
			,matricula = @matricula
			,nota1 = @nota1
			,nota2 = @nota2
			,nota3 = @nota3
			,nota1peso = @nota1peso
			,nota2peso = @nota2peso
			,inalunopai = @inalunopai
		WHERE idnotaaluno = @idnotaaluno
		
		SET NOCOUNT OFF			
		SELECT @idnotaaluno AS idnotaaluno
	END
	ELSE
	BEGIN
		INSERT INTO tb_nota_aluno
		(
			idcod_ata_nota
			,matricula
			,nota1
			,nota2
			,nota3
			,nota1peso
			,nota2peso
			,inalunopai
		)VALUES(
			@COD_ATA_ALUNO
			,@matricula
			,@nota1
			,@nota2
			,@nota3
			,@nota1peso
			,@nota2peso
			,@inalunopai
		)
		
		SET NOCOUNT OFF			
		SELECT SCOPE_IDENTITY() as idnotaaluno	
	END
END

SELECt * FROm tb_nota_aluno
sp_notasalunosbyetapa_list 2573, 1311, 1

SELECT * FROM tb_nota_aluno 

------------------------------------------------------------------
ALTER proc [dbo].[sp_turmas_professor_list]
(@codprofessor int, @desperido varchar(22))
AS
/*
	url: fit/professor/json/list_turmas_prof.php,
	data: 26/03/2014
	author: Massaharu
*/
BEGIN
	IF(@codprofessor != 0)
	BEGIN
		select 
			b.CODIGO as IDTURMA, 
			b.NOME as TURMA, 
			c.CODIGO as IDDISCIPLINA, 
			c.NOME as DISCIPLINA,
			b.CFG_ACAD,
			CASE 
				WHEN f.instatus = 0 THEN 0
				WHEN f.instatus = 1 THEN 
					CASE 
						WHEN f.id_cod_turma IS NULL THEN 0
						WHEN f.id_cod_turma IS NOT NULL THEN 1
					END
			END AS INPAI,
			f.notapaipeso 
		from sonata.sophia.sophia.QC a
		inner join sonata.sophia.sophia.TURMAS b on a.TURMA = b.CODIGO
		inner join sonata.sophia.sophia.DISCIPLINAS c on a.DISCIPLINA = c.CODIGO
		inner join sonata.sophia.sophia.PERIODOS d on b.PERIODO = d.CODIGO
		left join sonata.sophia.sophia.QC_PROFESSOR e on a.CODIGO = e.QC
		left join tb_turmapai f on f.id_cod_turma = b.CODIGO
		where (a.PROFESSOR = @codprofessor or 
			e.PROFESSOR = @codprofessor) and 
			d.DESCRICAO COLLATE Latin1_General_CI_AI in(
				SELECT id COLLATE Latin1_General_CI_AI FROM Simpac..fnSplit(@desperido, ',')
			)
		order by b.NOME,c.NOME
	END
	ELSE
	BEGIN
		SELECT DISTINCT
			b.CODIGO as IDTURMA, 
			b.NOME as TURMA, 
			c.CODIGO as IDDISCIPLINA, 
			c.NOME as DISCIPLINA,
			b.CFG_ACAD,
			CASE 
				WHEN f.instatus = 0 THEN 0
				WHEN f.instatus = 1 THEN 
					CASE 
						WHEN f.id_cod_turma IS NULL THEN 0
						WHEN f.id_cod_turma IS NOT NULL THEN 1
					END
			END AS INPAI,
			f.notapaipeso 
		from sonata.sophia.sophia.QC a
		inner join sonata.sophia.sophia.TURMAS b on a.TURMA = b.CODIGO
		inner join sonata.sophia.sophia.DISCIPLINAS c on a.DISCIPLINA = c.CODIGO
		inner join sonata.sophia.sophia.PERIODOS d on b.PERIODO = d.CODIGO
		left join sonata.sophia.sophia.QC_PROFESSOR e on a.CODIGO = e.QC
		left join tb_turmapai f on f.id_cod_turma = b.CODIGO
		INNER JOIN sonata.sophia.sophia.CURSOS g ON g.PRODUTO = b.CURSO
		INNER JOIN sonata.sophia.sophia.NIVEL h ON h.CODIGO = g.NIVEL
		where 
			d.DESCRICAO COLLATE Latin1_General_CI_AI in(
				SELECT id COLLATE Latin1_General_CI_AI FROM Simpac..fnSplit(@desperido, ',')
			) AND
			h.CODIGO in(1, 2, 3, 5) --TECNOLOGO e BACHAREL
			
		order by b.NOME,c.NOME
	END
END

SELECT * FROM Simpac.dbo.fnSplit('1, 2', ',')
SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE NOME LIKE '%teste%'
SELECT  * FROM SONATA.SOPHIA.SOPHIA.TURMAS
SELECT * FROM SONATA.SOPHIA.SOPHIA.NIVEL
sp_turmas_professor_list 18777, '2014'
sp_turmas_professor_list 0, '2014/1'
----------------------------------------------------------------------
CREATE PROC sp_nota_aluno_removerduplicacoes
AS
/*
	url: fit/professor/json/nota_aluno_removerduplicacoes.php,
	data: 26/04/2014
	author: Massaharu
*/
BEGIN
	WITH tb_nota_aluno_duplicados(
		MATRICULA, IDCOD_ATA_NOTA
	)AS(
		SELECT MATRICULA, IDCOD_ATA_NOTA
		FROM tb_nota_aluno a
		GROUP BY idcod_ata_nota, matricula
		HAVING COUNT(*) > 1
	)

	DELETE tb_nota_aluno
	WHERE idnotaaluno in(
		SELECT idnotaaluno FROM tb_nota_aluno a
		INNER JOIN tb_nota_aluno_duplicados b ON 
			b.matricula = a.matricula AND b.idcod_ata_nota = a.idcod_ata_nota
		WHERE a.idnotaaluno NOT IN (
			SELECT MIN(idnotaaluno) as idnotaaluno
			FROM tb_nota_aluno a
			GROUP BY idcod_ata_nota, matricula
			HAVING COUNT(*) > 1
		)
	)
END
-----
----- verifica duplicados na tabela tb_nota_aluno
WITH tb_nota_aluno_duplicados(
	MATRICULA, IDCOD_ATA_NOTA
)AS(
	SELECT MATRICULA, IDCOD_ATA_NOTA
	FROM tb_nota_aluno a
	GROUP BY idcod_ata_nota, matricula
	HAVING COUNT(*) > 1
)

SELECT * FROM tb_nota_aluno a
INNER JOIN tb_nota_aluno_duplicados b ON 
	b.matricula = a.matricula AND b.idcod_ata_nota = a.idcod_ata_nota
WHERE a.idnotaaluno NOT IN (
	SELECT MIN(idnotaaluno) as idnotaaluno
	FROM tb_nota_aluno a
	GROUP BY idcod_ata_nota, matricula
	HAVING COUNT(*) > 1
)
ORDER BY a.idcod_ata_nota, a.matricula

-- verifica as atas duplicadas (sophia)
SELECT DISTINCT
	*
FROM (
	SELECT 
		MAX(a.CODIGO) as codigo, a.TURMA as COD_TURMA, a.disciplina as cod_disc, MIN(a.ETAPA) as etapa, 
		MAX(b.NOME) as TURMA, MAX(c.NOME) as DISCIPLINA, MAX(b.PERIODO) as periodo, COUNT(*) as agr
	FROM SONATA.SOPHIA.SOPHIA.ATA_NOTA a
	INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS b ON b.CODIGO = a.TURMA
	INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS c ON c.CODIGO = a.DISCIPLINA
	GROUP BY a.TURMA, a.disciplina, a.ETAPA, b.NOME, b.PERIODO, c.NOME
	HAVING COUNT(*) > 1
) a
ORDER BY periodo

SELECT * FROM tb_nota_aluno where idcod_ata_nota = 22272 order by matricula
SELECT * FROM SONATA.SOPHIA.SOPHIA.ATA_NOTA WHERE CODIGO in (22687, 22158, 22786)
SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS WHERE CODIGO in (2582, 2537, 2571)
SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE NOME like '%arthur%quintao%'
SELECT * FROM SONATA.SOPHIA.SOPHIA.FUNCIONARIOS WHERE COD_FUNC  =26171

SELECT b.NOME as TURMA, c.NOME as DISCIPLINA, e.CODIGO as COD_PROFESSOR, e.NOME as PROFESSOR, e.CODEXT, e.SENHA, * FROM SONATA.SOPHIA.SOPHIA.ATA_NOTA a
INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS b ON b.CODIGO = a.TURMA
INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS c ON c.CODIGO = a.DISCIPLINA
INNER JOIN SONATA.SOPHIA.SOPHIA.QC d ON a.TURMA = d.TURMA AND d.DISCIPLINA = a.DISCIPLINA
INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA e ON e.CODIGO = d.PROFESSOR
WHERE a.CODIGO in (22687, 22158, 22786)

SELECT * FROM SONATA.SOPHIA.SOPHIA.ATA_NOTA
SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS

SELECT MAX(a.CODIGO), a.TURMA, a.disciplina, a.ETAPA, b.NOME as TURMA, b.PERIODO, COUNT(*) 
FROM SONATA.SOPHIA.SOPHIA.ATA_NOTA a
INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS b ON b.CODIGO = a.TURMA
GROUP BY a.TURMA, a.disciplina, a.ETAPA, b.NOME, b.PERIODO
HAVING COUNT(*)>1
ORDER BY b.PERIODO


----------------------------------------------------------------------
ALTER PROC [dbo].[sp_notaspai_save]
(@ra varchar(17), @nota numeric(15, 4), @idperiodo int, @etapa int)
/*
	app: Site FIT
	url: /simpacweb/modulos/fit/site/adm_documentos_turmas/ajax/notaspai_save.php
	data: 12/05/2014
	author: massaharu
*/
AS
BEGIN
	SET NOCOUNT ON
	
	IF EXISTS(
		SELECT * FROM tb_nota_aluno a
		INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
		INNER JOIN SONATA.SOPHIA.SOPHIA.MATRICULA d ON d.CODIGO = a.matricula
		INNER JOIN SONATA.SOPHIA.SOPHIA.ACADEMIC e ON e.MATRICULA = d.CODIGO
		INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA f ON f.CODIGO = d.FISICA
		INNER JOIN tb_turmapai g ON g.id_cod_turma = b.TURMA
		WHERE f.CODEXT = @ra AND d.PERIODO = @idperiodo AND ETAPA = @etapa
	)
	BEGIN
		UPDATE tb_nota_aluno
		SET nota4 = @nota
		FROM tb_nota_aluno a
		INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
		INNER JOIN SONATA.SOPHIA.SOPHIA.MATRICULA d ON d.CODIGO = a.matricula
		INNER JOIN SONATA.SOPHIA.SOPHIA.ACADEMIC e ON e.MATRICULA = d.CODIGO
		INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA f ON f.CODIGO = d.FISICA
		INNER JOIN tb_turmapai g ON g.id_cod_turma = b.TURMA
		WHERE f.CODEXT = @ra AND d.PERIODO = @idperiodo AND ETAPA = @etapa
		
		SELECT 1 AS updated
	END
	ELSE
	BEGIN
		SELECT 0 AS updated
	END
END
--
SELECT * FROM tb_nota_aluno
----------------------------------------------------------------------
ALTER FUNCTION dbo.fn_inalunopaiB1_get
(@matricula int, @disciplina int, @etapa int, @idperiodo int)
RETURNS bit
AS
/*
  app: Sophia
  author: Massaharu
  date: 1/10/2013
  desc: Retorna o inalunopai da b1 caso o campo inalunopai das etapas(b1 ou b2) estejam nulas. Se o retorno for nulo, retornará 0
*/
BEGIN
	DECLARE @inalunopai bit
	
	IF(@ETAPA = 1 OR @ETAPA = 2 OR @ETAPA = 3 OR @ETAPA = 4) 
	BEGIN
		-- SE A DISCIPLINA NÃO PARTICIPAR DO PAI
		IF EXISTS(
			SELECT iddisciplina FROM tb_disciplinas_nao_pai 
			WHERE iddisciplina = @disciplina AND idperiodo = @idperiodo
		)
		BEGIN
			SET @inalunopai = 0
		END
		ELSE
		BEGIN
			SET @inalunopai = (
				SELECT c.inalunopai FROM sonata.sophia.sophia.ata_nota a
				INNER JOIN sonata.sophia.sophia.ata_aluno b ON b.ata = a.codigo 
				INNER JOIN tb_nota_aluno c ON c.idcod_ata_nota = b.ata AND c.matricula = b.matricula
				WHERE b.matricula = @matricula  
					and a.etapa = @ETAPA
					and a.disciplina = @disciplina 
					and c.inalunopai IS NOT NULL
			)
		END
	END
	ELSE
	BEGIN
		SET @inalunopai = 0
	END
	
	RETURN ISNULL(@inalunopai, 1)
END
--
SELECT c.inalunopai FROM sonata.sophia.sophia.ata_nota a
INNER JOIN sonata.sophia.sophia.ata_aluno b ON b.ata = a.codigo 
INNER JOIN tb_nota_aluno c ON c.idcod_ata_nota = b.ata AND c.matricula = b.matricula
WHERE b.matricula = 32936  
	and a.etapa in (3) 
	and a.disciplina = 869 
	and c.inalunopai IS NOT NULL
----------------------------------------------------------------------

SELECT * FROM tb_nota_aluno 
----------------------------------------------------------------------
SELECT * FROM fit_new..tb_nota_aluno
SELECT * FROM fit_new..tb_turmapai


select * from sophia.academic_lanc
WHERE academic = 232117

select * from sophia.ata_nota
where TURMA = 2350 AND DISCIPLINA = 6 AND ETAPA <> 14

SELECT * FROM tb_nota_aluno


select * FROM sophia.ETAPAS
[sophia.academic]

SELECT * FROM SophiA.sophia.ACADCOMP
SELECT * FROM SophiA.sophia.academic_lanc
SELECT * FROM SophiA.sophia.acadset_lanc
SELECT * FROM SophiA.sophia.AVALUNO WHERE MATRICULA = 31407
SELECT * FROM sophia.AVALS WHERE CODIGO = 18706
SELECT * FROM SophiA.sophia.LISTA_CHAM_ALUNOS
SELECT * FROM SophiA.sophia.MOVIMENT WHERE MATRICULA = 31407
SELECT * FROM sonata.sophia.sophia.academic WHERE turma = 2521 and DISCIPLINA = 6 and MATRICULA = 31407
SELECT * FROM sonata.sophia.sophia.ata_nota
SELECT * FROM sonata.sophia.sophia.FISICA WHERE NOME like 'cristiane%borges%'
SELECT * FROM sonata.sophia.sophia.FUNCIONARIOS WHERE COD_FUNC = 11782


SELECT a.* FROM sophia.academic a
--inner join sophia.AVALUNO b
--on b.IDFK_ACADEMIC = a.CODIGO
WHERE a.turma = 2350 and a.DISCIPLINA = 669 and a.MATRICULA = 31407

SELECT * FROM [sonata.sophia.sophia.ata_aluno]
SELECT * FROM sonata.sophia.sophia.ata_nota
WHERE turma = 2350 and etapa = 1 and disciplina = 400
  
SELECT * FROM tb_nota_aluno where idcod_ata_nota = 19983

--UPDATE tb_nota_aluno
--SET nota4 = '10.0'
--WHERE idcod_ata_nota = 19983

sp_notasalunosbyetapa_list 2521,6,1

SELECT * FROM sonata.sophia.sophia.CALENDARIOS
WHERE PERIODO = 120
SELECT * FROM sonata.sophia.sophia.CALEND_ETAPAS
WHERE CALENDARIO  = 194
SELECT * FROM sonata.sophia.sophia.ETAPAS
WHERE CODIGO = 5

sp_tipo_doc_liberado_turma_list

SELECT * FROM tb_documento_turma_FIT
SELECT * FROM tb_turmas_acessos_documentos_turmas_FIT

SELECT * FROM tb_turmas_acessos_documentos_turmas_FIT a
INNER JOIN sonata.sophia.sophia.TURMAS b ON b.CODIGO = a.cod_turma_sophia

SELECT DISTINCT
	b.CODIGO as IDTURMA, 
	b.NOME as TURMA, 
	c.CODIGO as IDDISCIPLINA, 
	c.NOME as DISCIPLINA,
	'INPAI' = CASE 
		WHEN f.instatus = 0 THEN 0
		WHEN f.instatus = 1 THEN 
			CASE 
				WHEN f.id_cod_turma IS NULL THEN 0
				WHEN f.id_cod_turma IS NOT NULL THEN 
				CASE 
					WHEN C.CODIGO = 346 THEN 0
					ELSE 1
				END
			END
	END  
from sonata.sophia.sophia.QC a
inner join sonata.sophia.sophia.TURMAS b on a.TURMA = b.CODIGO
inner join sonata.sophia.sophia.DISCIPLINAS c on a.DISCIPLINA = c.CODIGO
inner join sonata.sophia.sophia.PERIODOS d on b.PERIODO = d.CODIGO
left join sonata.sophia.sophia.QC_PROFESSOR e on a.CODIGO = e.QC
inner join tb_turmapai f on f.id_cod_turma = b.CODIGO OR C.CODIGO = 346
where d.DESCRICAO COLLATE Latin1_General_CI_AI in(
	SELECT id COLLATE Latin1_General_CI_AI FROM Simpac..fnSplit('2014/1', ',')
)
order by b.NOME,c.NOME

SELECT * FROM tb_turmapai

SELECT * FROM tb_turmapai
SELECT * FROM tb_nota_aluno where matricula = '31851'
SELECT * FROM tb_nota_aluno where nota2 is not null

sp_notasalunosbyetapa_list 2454,118,1

SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE CODIGO = 11470
SELECT * FROM SONATA.SOPHIA.SOPHIA.MATRICULA WHERE CODIGO = 32449
SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS WHERE CODIGO = 2439
SELECT * FROM SONATA.SOPHIA.SOPHIA.DISCIPLINAS WHERE CODIGO = 7
SELECT * FROM SONATA.SOPHIA.SOPHIA.ATA_NOTA WHERE CODIGO = 20296


SELECT * FROM tb_nota_aluno
WHERE idnotaaluno in(3325,3322,3320,3324,3323,3326,3321,1582,1583,
3327)

SELECT a.*, c.notapaipeso FROM tb_nota_aluno a
INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
INNER JOIN tb_turmapai c ON c.id_cod_turma = b.TURMA
WHERE matricula = 34100 AND idcod_ata_nota = 19984

SELECT * FROM SONATA.SOPHIA.SOPHIA.ATA_NOTA 






SELECT * FROM SONATA.SOPHIA.SOPHIA.ACADEMIC WHERE MATRICULA = 34099
SELECT * FROM SONATA.SOPHIA.SOPHIA.ATA_ALUNO
SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS
SELECT * FROM SONATA.SOPHIA.SOPHIA.DISCIPLINAS
SELECT * FROM SONATA.SOPHIA.SOPHIA.MATRICULA

SELECT a.EXAME, a.SITUACAO, MEDIA_ANUAL, MEDIA_APOS_EXAME, MEDIA_FINAL, * FROM SONATA.SOPHIA.SOPHIA.ACADEMIC a
INNER JOIN SONATA.SOPHIA.SOPHIA.MATRICULA b ON b.CODIGO = a.MATRICULA
INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA c ON c.CODIGO = b.FISICA
WHERE c.CODEXT = '1410758'


SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE NOME LIKE '%FURIA%'

SELECt * FROM SONATA.SOPHIA.SOPHIA.DISCIPLINAS 
WHERE NOME LIKE '%Oficina%' or NOME LIKE '%Trabalho%' or NOME LIKE '%estagio%'



SELECT * FROM SONATA.SOPHIA.SOPHIA.CURSOS
SELECT * FROM SONATA.SOPHIA.SOPHIA.NIVEL
SELECT * FROM SONATA.SOPHIA.SOPHIA.QC
SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS
SELECT * FROM SONATA.SOPHIA.SOPHIA.PROFESSOR

SELECT DISTINCT idcod_ata_nota FROM tb_nota_aluno

SELECT b.ETAPA, b.TURMA, b.DISCIPLINA, a.* FROM tb_nota_aluno a
INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
WHERE idcod_ata_nota = 19994
ORDER BY idcod_ata_nota, turma, disciplina, matricula

SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE NOME LIKE '%FURIA%'

--

sp_notasalunos_list 2521, 6
sp_notasalunos_list 2371, 872

---
-----------------------------------------------------------------------------------------------	
---------------------- QUERIES ----------------------------------------------------------------
-----------------------------------------------------------------------------------------------	
------------ ARRUMA A SITUAÇÔES DE ALUNOS APROVADOS COM NOTA 0 de EXAME ------------------------
------------------------------------------------------------------------------------------------

-- SCRIPT PARA SUBSTITUIR O 0 por N/A no sistema de notas da area do professor -------------
$.each($('#table-notas tr'), function(){
	if($(this).find('.nrnota1').text() == '0.00'){
		if(parseFloat($(this).find('.nrnota1').parent().prev().text()) >= 7){
			console.log($(this).find('.nrnota1').text('N/A'), parseFloat($(this).find('.nrnota1').parent().prev().text()));
		}
	}
})
-- QUERY PARA BUSCAR ALUNOS COM SITUACAO APROVADA MAS COM NOTA 0 DE EXAME
SELECT 
	j.EXAME
	, d.CODEXT AS RA
	, d.NOME
	, b.matricula AS MATRICULA 
	, e.NOME AS TURMA
	, l.NOME DISCIPLINA
	, b.nota
	, k.idnotaaluno
	, k.nota1
	, dbo.fn_nota_status(k.idcod_ata_nota, 1) AS innota1
	, k.nota2
	, dbo.fn_nota_status(k.idcod_ata_nota, 2) AS innota2
	, k.nota3 
	, dbo.fn_nota_status(k.idcod_ata_nota, 3) AS innota3
	, k.nota4 
	, dbo.fn_nota_status(k.idcod_ata_nota, 4) AS innota4
	, k.nota1peso
	, k.nota2peso
	, ISNULL(
		k.inalunopai, 
		dbo.fn_inalunopaiB1_get(b.matricula, a.disciplina, a.etapa, f.CODIGO)
	) AS inalunopai
	, a.SITUACAO  
	, h.INICIO
	, h.TERMINO
	, h.Lanc_Ata_Data_Limite as LANC_ATA_DATA_LIMITE
	, a.ETAPA
	, i.CFG_ACAD
	, CASE 
		WHEN CAST(GETDATE() AS DATE) <= CAST(h.Lanc_Ata_Data_Limite AS DATE) THEN 1
		WHEN CAST(GETDATE() AS DATE) > CAST(h.Lanc_Ata_Data_Limite AS DATE) THEN 0
	END AS INVISIVEL
	, j.SITUACAO as SITUACAO_ALUNO
	, j.MEDIA_ANUAL
	, j.MEDIA_APOS_EXAME
	, j.MEDIA_FINAL
	, CAST(j.PERC_FALTAS AS numeric(15,2)) AS PERC_FALTAS
	, dbo.fn_faltasbyetapa_get(a.TURMA, a.DISCIPLINA, j.MATRICULA, a.ETAPA) AS FALTAS
FROM sonata.sophia.sophia.ATA_NOTA a
INNER JOIN sonata.sophia.sophia.ata_aluno b ON a.CODIGO = b.ata
INNER JOIN sonata.sophia.sophia.MATRICULA c ON b.matricula = c.CODIGO
INNER JOIN sonata.sophia.sophia.FISICA d ON c.FISICA = d.CODIGO
INNER JOIN sonata.sophia.sophia.TURMAS e ON e.CODIGO = a.TURMA
INNER JOIN sonata.sophia.sophia.PERIODOS f ON f.CODIGO = e.PERIODO
INNER JOIN sonata.sophia.sophia.CALENDARIOS g ON g.PERIODO = f.CODIGO AND g.CFG_ACAD = 1
INNER JOIN sonata.sophia.sophia.CALEND_ETAPAS h ON h.CALENDARIO = g.CODIGO
INNER JOIN sonata.sophia.sophia.ETAPAS i ON i.CODIGO = h.ETAPA  AND i.CFG_ACAD = 1
INNER JOIN sonata.sophia.sophia.academic j ON j.MATRICULA = c.CODIGO AND a.DISCIPLINA = j.DISCIPLINA AND j.TURMA = a.TURMA
LEFT JOIN tb_nota_aluno k ON k.idcod_ata_nota = a.CODIGO AND k.matricula = b.matricula
INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS l ON l.CODIGO = a.DISCIPLINA
where i.NUMERO = 14 and a.ETAPA = 14 and e.periodo = 125 and j.SITUACAO IN (1,2) AND j.EXAME = 0 AND MEDIA_ANUAL >= 7
ORDER BY e.NOME, l.NOME, d.NOME
------------------------------------------------------------------------------
------------------------------------------------------------------------------
-- NOTAS DE EXAME AINDA NÃO LANÇADAS
SELECT 
	j.EXAME
	, c.STATUS 
	, d.CODEXT AS RA
	, d.NOME
	, b.matricula AS MATRICULA 
	, e.NOME AS TURMA
	, l.NOME DISCIPLINA
	, n.NOME PROFESSOR
	, b.nota
	, k.idnotaaluno
	, k.nota1
	, dbo.fn_nota_status(k.idcod_ata_nota, 1) AS innota1
	, k.nota2
	, dbo.fn_nota_status(k.idcod_ata_nota, 2) AS innota2
	, k.nota3 
	, dbo.fn_nota_status(k.idcod_ata_nota, 3) AS innota3
	, k.nota4 
	, dbo.fn_nota_status(k.idcod_ata_nota, 4) AS innota4
	, k.nota1peso
	, k.nota2peso
	, ISNULL(
		k.inalunopai, 
		dbo.fn_inalunopaiB1_get(b.matricula, a.disciplina, a.etapa, f.CODIGO)
	) AS inalunopai
	, a.SITUACAO  
	, h.INICIO
	, h.TERMINO
	, h.Lanc_Ata_Data_Limite as LANC_ATA_DATA_LIMITE
	, a.ETAPA
	, i.CFG_ACAD
	, CASE 
		WHEN CAST(GETDATE() AS DATE) <= CAST(h.Lanc_Ata_Data_Limite AS DATE) THEN 1
		WHEN CAST(GETDATE() AS DATE) > CAST(h.Lanc_Ata_Data_Limite AS DATE) THEN 0
	END AS INVISIVEL
	, j.SITUACAO as SITUACAO_ALUNO
	, j.MEDIA_ANUAL
	, j.MEDIA_APOS_EXAME
	, j.MEDIA_FINAL
	, CAST(j.PERC_FALTAS AS numeric(15,2)) AS PERC_FALTAS
	, dbo.fn_faltasbyetapa_get(a.TURMA, a.DISCIPLINA, j.MATRICULA, a.ETAPA) AS FALTAS
FROM sonata.sophia.sophia.ATA_NOTA a
INNER JOIN sonata.sophia.sophia.ata_aluno b ON a.CODIGO = b.ata
INNER JOIN sonata.sophia.sophia.MATRICULA c ON b.matricula = c.CODIGO
INNER JOIN sonata.sophia.sophia.FISICA d ON c.FISICA = d.CODIGO
INNER JOIN sonata.sophia.sophia.TURMAS e ON e.CODIGO = a.TURMA
INNER JOIN sonata.sophia.sophia.PERIODOS f ON f.CODIGO = e.PERIODO
INNER JOIN sonata.sophia.sophia.CALENDARIOS g ON g.PERIODO = f.CODIGO AND g.CFG_ACAD = 1
INNER JOIN sonata.sophia.sophia.CALEND_ETAPAS h ON h.CALENDARIO = g.CODIGO
INNER JOIN sonata.sophia.sophia.ETAPAS i ON i.CODIGO = h.ETAPA  AND i.CFG_ACAD = 1
INNER JOIN sonata.sophia.sophia.academic j ON j.MATRICULA = c.CODIGO AND a.DISCIPLINA = j.DISCIPLINA AND j.TURMA = a.TURMA
LEFT JOIN tb_nota_aluno k ON k.idcod_ata_nota = a.CODIGO AND k.matricula = b.matricula
INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS l ON l.CODIGO = a.DISCIPLINA
INNER JOIN SONATA.SOPHIA.SOPHIA.QC m ON m.TURMA =  e.CODIGO AND m.DISCIPLINA = l.CODIGO
INNER JOIN sonata.sophia.sophia.FISICA n ON n.CODIGO = m.PROFESSOR
where i.NUMERO = 14 and a.ETAPA = 14 and e.periodo = 125 and j.SITUACAO = 3 AND j.EXAME IS NULL 
ORDER BY e.NOME, l.NOME, d.NOME

sp_boletim_aluno_get 1200354

selecT * from SOPHIA.FISICA WHERE CODEXT = '1411224'
SELECT * FROM sophia.MATRICULA where FISICA = 18375

------------------------------------------------------------------------------
------------------------------------------------------------------------------
SELECT * FROM SONATA.SOPHIA.SOPHIA.ATA_NOTA WHERE CODIGO = 23477

SELECT * FROM saturn.fit_new.dbo.tb_nota_aluno WHERE idcod_ata_nota = 23477
SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE CODEXT = '1410530'
SELECT * FROM SONATA.SOPHIA.SOPHIA.MATRICULA WHERE FISICA = 24798

SELECT c.CODEXT, c.NOME, CAST(nota1 AS DECIMAL(10,2)) FROM
saturn.fit_new.dbo.tb_nota_aluno a
INNER JOIN SONATA.SOPHIA.SOPHIA.MATRICULA b ON b.CODIGO = a.matricula
INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA c ON c.CODIGO = b.FISICA
WHERE idcod_ata_nota = 23477
ORDER BY c.NOME




