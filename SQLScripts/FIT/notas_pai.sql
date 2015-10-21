----------------------------------------------------------------------
--------------------- PAI --------------------------------------------
----------------------------------------------------------------------
CREATE TABLE tb_turmapai(
	idturmapai int identity CONSTRAINT PK_turmapai PRIMARY KEY,
	id_cod_turma int, --CODIGO da tabela TURMAS do sophia
	instatus bit CONSTRAINT DF_turmapai_instatus DEFAULT(1),
	dtcadastro datetime CONSTRAINT DF_turmapai_dtcadastro DEFAULT(getdate())
)
--SET IDENTITY_INSERT tb_turmapai OFF
--INSERT INTO tb_turmapai(id_cod_turma,instatus,dtcadastro)
--SELECT cod_turma_sophia, instatus, dtcadastro FROM tb_turmas_acessos_documentos_turmas_FIT
ALTER TABLE tb_turmapai
ADD idusuario int

ALTER TABLE tb_turmapai
ALTER COLUMN notapaipeso numeric(2,1)

SELECT * FROM tb_turmapai
SELECT * FROM tb_nota_aluno

----------------------------------------------------------------------
CREATE TABLE tb_turmapai_documento_turma_fit(
	iddocumento int,
	idturmapai int,
	instatus bit CONSTRAINT DF_turmapai_documento_turma_fit_instatus DEFAULT(1),
	dtcadastro datetime CONSTRAINT DF_turmapai_documento_turma_fit_dtcadastro DEFAULT(getdate())
	
	CONSTRAINT PK_turmapai_docturmafit_iddocumento_idturmapai PRIMARY KEY(iddocumento, idturmapai)
	CONSTRAINT FK_turmapai_docturmafit_iddocumento FOREIGN KEY(iddocumento)
	REFERENCES tb_documento_turma_FIT (iddocumento),
	CONSTRAINT FK_turmapai_docturmafit_idturmapai FOREIGN KEY(idturmapai)
	REFERENCES tb_turmapai(idturmapai)
)
--INSERT tb_turmapai_documento_turma_fit(iddocumento, idturmapai)
--SELECT b.iddocumento, a.idturmapai FROM tb_turmapai a
--INNER JOIN tb_turmas_acessos_documentos_turmas_FIT b ON b.cod_turma_sophia = a.id_cod_turma

SELECT * FROM tb_turmapai
SELECT * FROM tb_turmapai_documento_turma_fit
SELECT * FROM tb_documento_turma_FIT
--SELECT * FROM tb_turmas_acessos_documentos_turmas_FIT <- Não será mais usada
-----------------------------------------------------------------------
CREATE TABLE tb_disciplinas_nao_pai(
	iddiscnaopai int IDENTITY CONSTRAINT PK_disciplinas_nao_pai PRIMARY KEY,
	iddisciplina int NOT NULL,
	dtcadastro datetime CONSTRAINT DF_disciplinas_nao_pai_dtcadastro DEFAULT (getdate())
)

ALTER TABLE tb_disciplinas_nao_pai ADD
idperiodo int
ALTER TABLE tb_disciplinas_nao_pai ADD
idusuario int


SELECT * FROM tb_disciplinas_nao_pai a
INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS b ON b.CODIGO = a.iddisciplina
--

SELECT DISTINCT 
	e.CODIGO COD_DISC--, e.NOME DISCIPLINA, a.NOME TURMA
FROM SONATA.SOPHIA.SOPHIA.TURMAS a
INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS b ON b.PRODUTO = a.CURSO
INNER JOIN SONATA.SOPHIA.SOPHIA.NIVEL c ON c.CODIGO = b.NIVEL
INNER JOIN SONATA.SOPHIA.SOPHIA.QC d ON d.TURMA = a.CODIGO
INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS e ON e.CODIGO = d.DISCIPLINA
WHERE b.NIVEL in(1, 2) AND(
	e.NOME LIKE '%Oficina%' or e.NOME LIKE '%Trabalho%' or e.NOME LIKE '%estagio%'
)

-----------------------------------------------------------------------
CREATE TABLE tb_notaspaihistorico(
	idnotaspaihistorico int IDENTITY CONSTRAINT PK_notaspaihistorico PRIMARY KEY,
	idusuario int not null,
	idperiodo int not null,
	nrbimestre smallint not null,
	descaminho varchar(200),
	isponderado bit,
	dtcadastro datetime CONSTRAINT DF_notaspaihistorico_dtcadastro DEFAULT getdate()
)
-----------------------------------------------------------------------

CREATE TABLE tb_notaspaihistoricoarquivos(
	idnotaspaihistoricoarquivos int IDENTITY CONSTRAINT PK_notaspaihistoricoarquivos PRIMARY KEY,
	idnotaspaihistorico int not null,
	nrlinha int,
	desra varchar(200),
	desnome varchar(300),
	nota numeric(15, 4)
	
	CONSTRAINT FK_notaspaihistoricoarquivo_notaspaihistoric_idnotaspaihistorico FOREIGN KEY(idnotaspaihistorico)
	REFERENCES tb_notaspaihistorico (idnotaspaihistorico)
)
----------------------------------------------------------------------
----------------------------- PROCEDURES -----------------------------
----------------------------------------------------------------------
ALTER PROC sp_turmapai_list 
(@periodo int = null)
AS
/*
  app:Site FIT
  url:/simpacweb/modulos/fit/adm_turmas_pai/json/list_turmapai.php
  author: Massaharu
  date: 26/03/2014
  desc: Lista as turmas do sophia vinculado ao PAI
*/
BEGIN
	IF @periodo IS NULL
	BEGIN
		SELECT 
			a.idturmapai,
			a.id_cod_turma,
			b.NOME as desnome,
			b.PERIODO as idperiodo,
			c.DESCRICAO as desperiodo,
			d.PRODUTO as idcurso_sophia,
			d.NOME as descurso_sophia,
			e.nmlogin as nmlogin,
			a.notapaipeso,
			a.instatus,
			a.dtcadastro
		FROM tb_turmapai a
		INNER JOIN sonata.sophia.sophia.TURMAS b ON b.CODIGO = a.id_cod_turma
		INNER JOIN sonata.sophia.sophia.PERIODOS c ON c.CODIGO = b.PERIODO
		LEFT JOIN sonata.sophia.sophia.CURSOS d ON d.PRODUTO = b.CURSO
		INNER JOIN simpac..tb_usuario e ON e.IdUsuario = a.idusuario 
		ORDER BY desnome
	END
	ELSE
	BEGIN
		SELECT 
			a.idturmapai,
			a.id_cod_turma,
			b.NOME as desnome,
			b.PERIODO as idperiodo,
			c.DESCRICAO as desperiodo,
			d.PRODUTO as idcurso_sophia,
			d.NOME as descurso_sophia,
			e.nmlogin as nmlogin,
			a.notapaipeso,
			a.instatus,
			a.dtcadastro
		FROM tb_turmapai a
		INNER JOIN sonata.sophia.sophia.TURMAS b ON b.CODIGO = a.id_cod_turma
		INNER JOIN sonata.sophia.sophia.PERIODOS c ON c.CODIGO = b.PERIODO
		LEFT JOIN sonata.sophia.sophia.CURSOS d ON d.PRODUTO = b.CURSO
		INNER JOIN simpac..tb_usuario e ON e.IdUsuario = a.idusuario 
		WHERE b.periodo = @periodo
		ORDER BY desnome
	END
END

sp_turmapai_list 120
SELECT * FROM tb_turmapai
---------------------------------------------------------------------
ALTER PROC sp_turmapai_save
(@id_cod_turma int, @idusuario int, @notapaipeso numeric(2, 1) = null)
AS
/*
  app:Site FIT
  url:/simpacweb/modulos/fit/adm_turmas_pai/ajax/save_turmapai.php
  author: Massaharu
  date: 26/03/2014
  desc: Lista as turmas do sophia vinculado ao PAI
*/
BEGIN
	SET NOCOUNT ON
	INSERT INTO tb_turmapai(id_cod_turma, idusuario, notapaipeso)
	VALUES(@id_cod_turma, @idusuario, @notapaipeso)
	
	SELECT SCOPE_IDENTITY() as idturmapai
	
	SET NOCOUNT OFF
END
--
sp_turmapai_save 2494, 1495, 0,1
SELECT * FROm tb_turmapai
---------------------------------------------------------------------
CREATE PROC sp_turmapai_periodo_list
(@idperiodo int = null)
AS
/*
	url: /simpacweb/modulos/fit/adm_contrato/json/list_turmapai_periodo.php
	data: 12/02/2014
	author: massaharu
*/
BEGIN
	IF @idperiodo IS NULL
	BEGIN
		select a.CODIGO, NOME AS TURMA, b.DESCRICAO as desperiodo
		from sonata.sophia.sophia.TURMAS a
		INNER JOIN sonata.sophia.sophia.PERIODOS b ON b.CODIGO = a.PERIODO
		LEFT JOIN tb_turmapai c ON c.id_cod_turma = a.CODIGO
		WHERE c.id_cod_turma IS NULL
		order by b.CODIGO desc, NOME, a.CODIGO
	END
	ELSE
	BEGIN
		select a.CODIGO, NOME AS TURMA, b.DESCRICAO as desperiodo 
		from sonata.sophia.sophia.TURMAS a
		INNER JOIN sonata.sophia.sophia.PERIODOS b ON b.CODIGO = a.PERIODO
		LEFT JOIN tb_turmapai c ON c.id_cod_turma = a.CODIGO
		WHERE c.id_cod_turma IS NULL AND PERIODO = @idperiodo
		order by NOME, a.CODIGO
	END
END
---------------------------------------------------------------------
CREATE PROC sp_turmapai_delete
(@idturmapai int)
AS
/*
	url: /simpacweb/modulos/fit/adm_contrato/json/delete_turmapai.php
	data: 12/03/2014
	author: massaharu
*/
BEGIN

	BEGIN TRAN
	
	DELETE tb_turmapai_documento_turma_fit
	WHERE idturmapai = @idturmapai
	
	IF @@ERROR = 0
	BEGIN
		DELETE tb_turmapai
		WHERE idturmapai = @idturmapai	
		
		IF @@ERROR = 0
			COMMIT
		ELSE
			ROLLBACK
	END
	ELSE
		ROLLBACK
END

sp_turmapai_delete 2568

SELECT * FROM tb_turmapai
---------------------------------------------------------------------
ALTER proc sp_tipo_doc_liberado_turma_list
(@cod_turma int = null, @tipo_doc int = null)
AS
/*
	url: /simpacweb/modulos/fit/admTurmasPAI/json/tipo_doc_liberado_turma_list.php
	data: 12/03/2014
	author: jvalezzi, massaharu
*/
BEGIN
	select b.desdocumento, b.deslink from tb_turmas_acessos_documentos_turmas_FIT a
	inner join tb_documento_turma_FIT b on a.iddocumento = b.iddocumento
	where a.cod_turma_sophia = @cod_turma and b.idtipodocumento = @tipo_doc and a.instatus = 1
	order by b.desdocumento
	--DECLARE
	--@sqlStatement nvarchar(max),
	--@WHERE nvarchar(300)
	--SET @WHERE = ''
	
	--IF (@cod_turma IS NULL) AND (@tipo_doc IS NULL)
	--	SET @WHERE = ''
	--ELSE IF @cod_turma IS NULL
	--	SET @WHERE = 'WHERE c.idtipodocumento = @tipo_doc AND b.instatus = 1'
	--ELSE IF @tipo_doc IS NULL
	--	SET @WHERE = 'WHERE a.id_cod_turma = @cod_turma AND b.instatus = 1'
	--ELSE	
	--	SET @WHERE = 'WHERE c.idtipodocumento = @tipo_doc AND a.id_cod_turma = @cod_turma AND b.instatus = 1'
		
	
	--SET @sqlStatement = 
	--	'SELECT 
	--		a.id_cod_turma,
	--		a.idturmapai, 
	--		c.iddocumento, 
	--		c.desdocumento, 
	--		c.idtipodocumento,
	--		c.deslink,
	--		b.instatus,
	--		b.dtcadastro  
	--	FROM tb_turmapai a
	--	INNER JOIN tb_turmapai_documento_turma_fit b ON b.idturmapai = a.idturmapai
	--	INNER JOIN tb_documento_turma_FIT c ON c.iddocumento = b.iddocumento
	--	'+@WHERE+''
	 
	--exec sp_ExecuteSQL @sqlStatement, N'@cod_turma int, @tipo_doc int', @cod_turma,@tipo_doc
END

sp_tipo_doc_liberado_turma_list 2477, 1
---------------------------------------------------------------------
CREATE PROC sp_turmapai_professores_list
AS
/*
	app: Site FIT
	url: /professores/json/turmapai_professores_list.php
	data: 12/03/2014
	author: massaharu
*/
BEGIN
	SELECT DISTINCT
		d.CODIGO as idprofessor
		,d.NOME as desprofessor
	FROM tb_turmapai a
	INNER JOIN sonata.sophia.sophia.TURMAS b ON b.CODIGO = a.id_cod_turma
	INNER JOIN sonata.sophia.sophia.QC c ON c.TURMA = b.CODIGO
	INNER JOIN sonata.sophia.sophia.FISICA d ON d.CODIGO = c.PROFESSOR
	ORDER BY d.NOME
END
---------------------------------------------------------------------
CREATE PROC sp_documento_turma_FIT_delete 
(@iddocumento int)
/*
	app: Site FIT
	url: /simpacweb/modulos/fit/site/adm_documentos_turmas/ajax/deletar_documento.php
	data: 12/03/2014
	author: massaharu
*/
AS
BEGIN
	BEGIN TRAN
	
	DELETE tb_turmas_acessos_documentos_turmas_FIT
	WHERE iddocumento = @iddocumento
	
	IF @@ERROR = 0
	BEGIN
		DELETE tb_documento_turma_FIT
		WHERE iddocumento = @iddocumento	
		
		IF @@ERROR = 0
			COMMIT
		ELSE
			ROLLBACK
	END
	ELSE
		ROLLBACK
END
---------------------------------------------------------------------
ALTER PROC sp_notaspai_save
(@ra varchar(17), @nota numeric(15, 4), @idperiodo int, @etapa varchar(50))
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
		WHERE f.CODEXT = @ra AND d.PERIODO = @idperiodo AND ETAPA in (
			SELECT LTRIM(RTRIM(id)) FROM Simpac..fnSplit(@etapa, ',')
		)
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
		WHERE f.CODEXT = @ra AND d.PERIODO = @idperiodo AND ETAPA in (
			SELECT LTRIM(RTRIM(id)) FROM Simpac..fnSplit(@etapa, ',')
		)
		
		SELECT 1 AS updated
	END
	ELSE
	BEGIN
		SELECT 0 AS updated
	END
END
--
SELECT g.idturmapai, b.turma ,* FROM tb_nota_aluno a
INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
INNER JOIN SONATA.SOPHIA.SOPHIA.MATRICULA d ON d.CODIGO = a.matricula
INNER JOIN SONATA.SOPHIA.SOPHIA.ACADEMIC e ON e.MATRICULA = d.CODIGO
INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA f ON f.CODIGO = d.FISICA
LEFT JOIN tb_turmapai g ON g.id_cod_turma = b.TURMA
WHERE f.CODEXT = '1020557' AND d.PERIODO = 125 AND ETAPA in (
	SELECT LTRIM(RTRIM(id)) FROM Simpac..fnSplit('1,3', ',')
)

SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE CODEXT = '02468'
SELECT * FROM SONATA.SOPHIA.SOPHIA.MATRICULA WHERE FISICA = 8504
SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS WHERE CODIGO = 2535
SELECT * FROM tb_turmapai where id_cod_turma = 2535
		
SELECT * FROm tb_nota_aluno
sp_notaspai_save 'João Henrique Silva de Souza', '10', 120
sp_notaspai_save 'Vinicius Tarazona Gonçalves', '0.00', 120
sp_notaspai_save 'Hugo Mucciolo Guizeline', '0.00', 120
sp_notaspai_save 'Bruno Daniel Santos Silva', '7.50', 120
sp_notaspai_save '1201883', '10.00', 120, '2'
sp_notaspai_save '1020557', '0.00', 125, '1, 3'
---------------------------------------------------------------------
ALTER PROC sp_boletim_aluno_get
(@matricula int)
AS
/*
app: Site FIT
url: fit/aluno/boletim.content.php
data: 12/05/2014
author: massaharu
*/
BEGIN
	WITH
		tb_boletim_geral(
			MATRICULA, ACADEMIC, DESDISCIPLINA, TURMA, CARGAHORARIA, 
			MB1, SUB1, FALTAS1, MB2, SUB2, FALTAS2, MEDIA_FINAL, 
			EXAME, TF, SITUACAO, MEDIA_ANUAL, PERC_FALTAS, IDCOD_TURMA_PAI, NOTAPAIPESO
		)AS(
		select 
			a.CODIGO MATRICULA, b.CODIGO ACADEMIC, d.nome DESDISCIPLINA, c.NOME TURMA, b.CARGA_HORARIA AS CARGAHORARIA, b.NOTA1 MB1, 
			b.NOTA3 SUB1, b.FALTAS1, b.NOTA2 MB2, b.NOTA4 SUB2, b.FALTAS2, b.MEDIA_FINAL, 
			b.EXAME, b.FALTAS1+b.FALTAS2 AS TF, b.SITUACAO,b.MEDIA_ANUAL,b.PERC_FALTAS, ISNULL(e.id_cod_turma, 0), e.notapaipeso
		from sonata.sophia.sophia.MATRICULA a 
		inner join sonata.sophia.sophia.ACADEMIC b on a.codigo = b.matricula
		inner join sonata.sophia.sophia.TURMAS c on b.turma = c.codigo
		inner join sonata.sophia.sophia.DISCIPLINAS d on d.codigo = b.disciplina
		LEFT JOIN tb_turmapai e ON e.id_cod_turma = c.CODIGO
	),
	tb_boletim_etapa1(
		ACADEMIC, ETAPA, PROVA1, PROVAPESO1, TRABALHO1, TRABALHOPESO1, PONTO_EXTRA1, PAI1, INALUNOPAI1, SIT_ATA1
	)AS(
		select 
			b.CODIGO, g.ETAPA, f.nota1 AS PROVA, f.nota1peso, f.nota2 AS TRABALHO, f.nota2peso, f.nota3 AS PONTO_EXTRA, f.nota4 AS PAI, f.inalunopai, g.SITUACAO
		from sonata.sophia.sophia.MATRICULA a 
		inner join sonata.sophia.sophia.ACADEMIC b on a.codigo = b.matricula
		inner join sonata.sophia.sophia.TURMAS c on b.turma = c.codigo
		inner join sonata.sophia.sophia.DISCIPLINAS d on d.codigo = b.disciplina
		INNER JOIN tb_nota_aluno f ON f.matricula = a.CODIGO 
		INNER JOIN sonata.sophia.sophia.ATA_NOTA g ON g.CODIGO = f.idcod_ata_nota AND d.CODIGO = g.DISCIPLINA AND g.ETAPA = 1
	),
	tb_boletim_etapa2(
		ACADEMIC, ETAPA, PROVA2, PROVAPESO2, TRABALHO2, TRABALHOPESO2, PONTO_EXTRA2, PAI2, INALUNOPAI2, SIT_ATA2
	)AS(
		select 
			b.CODIGO, g.ETAPA, f.nota1 AS PROVA, f.nota1peso, f.nota2 AS TRABALHO, f.nota2peso, f.nota3 AS PONTO_EXTRA, f.nota4 AS PAI, f.inalunopai, g.SITUACAO
		from sonata.sophia.sophia.MATRICULA a 
		inner join sonata.sophia.sophia.ACADEMIC b on a.codigo = b.matricula
		inner join sonata.sophia.sophia.TURMAS c on b.turma = c.codigo
		inner join sonata.sophia.sophia.DISCIPLINAS d on d.codigo = b.disciplina
		inner JOIN tb_nota_aluno f ON f.matricula = a.CODIGO 
		inner JOIN sonata.sophia.sophia.ATA_NOTA g ON g.CODIGO = f.idcod_ata_nota AND d.CODIGO = g.DISCIPLINA AND g.ETAPA = 2
	),
	tb_boletim_etapa3(
		ACADEMIC, ETAPA, PROVA3, PROVAPESO3, TRABALHO3, TRABALHOPESO3, PONTO_EXTRA3, PAI3, INALUNOPAI3, SIT_ATA3
	)AS(
		select 
			b.CODIGO, g.ETAPA, f.nota1 AS PROVA, f.nota1peso, f.nota2 AS TRABALHO, f.nota2peso, f.nota3 AS PONTO_EXTRA, f.nota4 AS PAI, f.inalunopai, g.SITUACAO
		from sonata.sophia.sophia.MATRICULA a 
		inner join sonata.sophia.sophia.ACADEMIC b on a.codigo = b.matricula
		inner join sonata.sophia.sophia.TURMAS c on b.turma = c.codigo
		inner join sonata.sophia.sophia.DISCIPLINAS d on d.codigo = b.disciplina
		inner JOIN tb_nota_aluno f ON f.matricula = a.CODIGO 
		inner JOIN sonata.sophia.sophia.ATA_NOTA g ON g.CODIGO = f.idcod_ata_nota AND d.CODIGO = g.DISCIPLINA AND g.ETAPA = 3
	),
	tb_boletim_etapa4(
		ACADEMIC, ETAPA, PROVA4, PROVAPESO4, TRABALHO4, TRABALHOPESO4, PONTO_EXTRA4, PAI4, INALUNOPAI4, SIT_ATA4
	)AS(
		select 
			b.CODIGO, g.ETAPA, f.nota1 AS PROVA, f.nota1peso, f.nota2 AS TRABALHO, f.nota2peso, f.nota3 AS PONTO_EXTRA, f.nota4 AS PAI, f.inalunopai, g.SITUACAO
		from sonata.sophia.sophia.MATRICULA a 
		inner join sonata.sophia.sophia.ACADEMIC b on a.codigo = b.matricula
		inner join sonata.sophia.sophia.TURMAS c on b.turma = c.codigo
		inner join sonata.sophia.sophia.DISCIPLINAS d on d.codigo = b.disciplina
		inner JOIN tb_nota_aluno f ON f.matricula = a.CODIGO 
		inner JOIN sonata.sophia.sophia.ATA_NOTA g ON g.CODIGO = f.idcod_ata_nota AND d.CODIGO = g.DISCIPLINA AND g.ETAPA = 4
	)
	SELECT DISTINCT
		c.MATRICULA, c.ACADEMIC, c.DESDISCIPLINA, c.TURMA, c.CARGAHORARIA, c.IDCOD_TURMA_PAI, c.NOTAPAIPESO,
		a.ETAPA, c.MB1, a.PROVA1, a.PROVAPESO1, a.TRABALHO1, a.TRABALHOPESO1, a.PONTO_EXTRA1, a.PAI1,  a.SIT_ATA1, ISNULL(a.INALUNOPAI1, 0) AS INALUNOPAI1, c.FALTAS1,
		b.ETAPA, c.MB2, b.PROVA2, b.PROVAPESO2, b.TRABALHO2, b.TRABALHOPESO2, b.PONTO_EXTRA2, b.PAI2,  b.SIT_ATA2, ISNULL(b.INALUNOPAI2, 0) AS INALUNOPAI2, c.FALTAS2,
		d.ETAPA, c.SUB1, d.PROVA3, d.PROVAPESO3, d.TRABALHO3, d.TRABALHOPESO3, d.PONTO_EXTRA3, d.PAI3, d.SIT_ATA3, ISNULL(d.INALUNOPAI3, 0) AS INALUNOPAI3, 
		e.ETAPA, c.SUB2, e.PROVA4, e.PROVAPESO4, e.TRABALHO4, e.TRABALHOPESO4, e.PONTO_EXTRA4, e.PAI4, e.SIT_ATA4, ISNULL(e.INALUNOPAI4, 0) AS INALUNOPAI4, 
		c.MEDIA_FINAL, c.EXAME, c.TF, c.SITUACAO, c.MEDIA_ANUAL, c.PERC_FALTAS, c.IDCOD_TURMA_PAI
	FROM tb_boletim_geral c
	left JOIN tb_boletim_etapa1 a ON a.ACADEMIC = c.ACADEMIC
	left JOIN tb_boletim_etapa2 b ON b.ACADEMIC = c.ACADEMIC
	left JOIN tb_boletim_etapa3 d ON d.ACADEMIC = c.ACADEMIC
	left JOIN tb_boletim_etapa4 e ON e.ACADEMIC = c.ACADEMIC
	WHERE c.MATRICULA = @matricula
	ORDER BY c.DESDISCIPLINA
END

sp_boletim_aluno_get 35833

SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE CODEXT = '1410515'
SELECT * FROM SONATA.SOPHIA.SOPHIA.MATRICULA WHERE FISICA = 24813
SELECT * FROM tb_nota_aluno WHERE matricula = 34049 ORDER by idcod_ata_nota
SELECT * FROM SONATA.SOPHIA.SOPHIA.ACADEMIC WHERE CODIGO = 268655
SELECT * FROM SONATA.SOPHIA.SOPHIA.ACADEMIC WHERE matricula = 35449
SELECT * FROM SONATA.SOPHIA.SOPHIA.ATA_NOTA WHERE CODIGO = 22924
SELECT * FROM SONATA.SOPHIA.SOPHIA.ATA_NOTA WHERE TURMA = 2532 AND disciplina = 5
SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS WHERE CODIGo IN(2573)
SELECT * FROM SONATA.SOPHIA.SOPHIA.DISCIPLINAS WHERE CODIGO = 1311
SELECT * FROM tb_nota_aluno
SELECT idcod_ata_nota, matricula, COUNT(*) FROM tb_nota_aluno where dtcadastro > '2014-07-30'
GROUP BY idcod_ata_nota, matricula
HAVING COUNT(*) > 1
order by idcod_ata_nota, matricula



SELECT * FROM tb_nota_aluno



select 
	a.CODIGO MATRICULA, b.CODIGO ACADEMIC, d.nome DESDISCIPLINA, c.NOME TURMA, b.CARGA_HORARIA AS CARGAHORARIA, b.NOTA1 MB1, 
	b.NOTA3 SUB1, b.FALTAS1, b.NOTA2 MB2, b.NOTA4 SUB2, b.FALTAS2, b.MEDIA_FINAL, 
	b.EXAME, b.FALTAS1+b.FALTAS2 AS TF, b.SITUACAO,b.MEDIA_ANUAL,b.PERC_FALTAS, ISNULL(e.id_cod_turma, 0), e.notapaipeso
from sonata.sophia.sophia.MATRICULA a 
inner join sonata.sophia.sophia.ACADEMIC b on a.codigo = b.matricula
inner join sonata.sophia.sophia.TURMAS c on b.turma = c.codigo
inner join sonata.sophia.sophia.DISCIPLINAS d on d.codigo = b.disciplina
LEFT JOIN tb_turmapai e ON e.id_cod_turma = c.CODIGO
WHERE c.CODIGO = 2532 AND d.CODIGO = 5
ORDER BY ACADEMIC

select 
	b.CODIGO, g.ETAPA, f.nota1 AS PROVA, f.nota1peso, f.nota2 AS TRABALHO, f.nota2peso, f.nota3 AS PONTO_EXTRA, f.nota4 AS PAI, f.inalunopai, g.SITUACAO
from sonata.sophia.sophia.MATRICULA a 
inner join sonata.sophia.sophia.ACADEMIC b on a.codigo = b.matricula
inner join sonata.sophia.sophia.TURMAS c on b.turma = c.codigo
inner join sonata.sophia.sophia.DISCIPLINAS d on d.codigo = b.disciplina
INNER JOIN tb_nota_aluno f ON f.matricula = a.CODIGO 
INNER JOIN sonata.sophia.sophia.ATA_NOTA g ON g.CODIGO = f.idcod_ata_nota AND d.CODIGO = g.DISCIPLINA AND g.ETAPA = 1
WHERE c.CODIGO = 2532 AND d.CODIGO = 191


---------------------------------------------------------------------
ALTER PROC [dbo].[sp_nota_aluno_ata_pai_create]
(@turma int, @inPorTurma bit = null)
AS
/*
	url: fit/professor/json/nota_aluno_ata_create.php,
	data: 26/06/2014
	author: Massaharu
	desc: Cria as atas na tabela tb_nota_aluno verificando se a disciplina e turma é 
		pai e se já não existe a ata criada na tabela
*/
BEGIN
	IF @inPorTurma IS NOT NULL OR @inPorTurma = 1
	BEGIN
		INSERT INTO tb_nota_aluno 
		(idcod_ata_nota, matricula, nota1, nota1peso, nota2peso, inalunopai)
		SELECT 
			a.CODIGO idcod_ata_nota,
			c.matricula,
			c.nota,
			CASE
				WHEN a.ETAPA in(1, 2) THEN 0.7
				ELSE
					CASE
						WHEN a.ETAPA in (3, 4) THEN 1.0
						ELSE NULL
					END
			END nota1peso,
			CASE
				WHEN a.ETAPA in(1, 2) THEN 0.3
				ELSE NULL
			END nota2peso,
			1 as inalunopai
			--a.etapa, 
			--d.NOME TURMA,
			--e.NOME DISCIPLINA,
			--* 
		FROM SONATA.SOPHIA.SOPHIA.ATA_NOTA a
		INNER JOIN tb_turmapai b ON b.id_cod_turma = a.TURMA
		INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_ALUNO c ON c.ata = a.CODIGO
		INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS d ON d.CODIGO = a.TURMA
		INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS e ON e.CODIGO = a.DISCIPLINA
		WHERE 
			a.ETAPA <> 14 AND 
			a.CODIGO NOT IN (
				SELECT DISTINCT idcod_ata_nota FROM tb_nota_aluno
			) AND 
			a.DISCIPLINA NOT IN(
				SELECT iddisciplina FROM tb_disciplinas_nao_pai WHERE idperiodo = d.PERIODO
			) AND
			d.CODIGO = @turma
		ORDER BY a.CODIGO, a.TURMA, a.DISCIPLINA, c.MATRICULA
	END
	ELSE 
	BEGIN
		INSERT INTO tb_nota_aluno 
		(idcod_ata_nota, matricula, nota1, nota1peso, nota2peso, inalunopai)
		SELECT 
			a.CODIGO idcod_ata_nota,
			c.matricula,
			c.nota,
			CASE
				WHEN a.ETAPA in(1, 2) THEN 0.7
				ELSE
					CASE
						WHEN a.ETAPA in (3, 4) THEN 1.0
						ELSE NULL
					END
			END nota1peso,
			CASE
				WHEN a.ETAPA in(1, 2) THEN 0.3
				ELSE NULL
			END nota2peso,
			1 as inalunopai
			--a.etapa, 
			--d.NOME TURMA,
			--e.NOME DISCIPLINA,
			--* 
		FROM SONATA.SOPHIA.SOPHIA.ATA_NOTA a
		INNER JOIN tb_turmapai b ON b.id_cod_turma = a.TURMA
		INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_ALUNO c ON c.ata = a.CODIGO
		INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS d ON d.CODIGO = a.TURMA
		INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS e ON e.CODIGO = a.DISCIPLINA
		WHERE 
			a.ETAPA <> 14 AND 
			a.CODIGO NOT IN (
				SELECT DISTINCT idcod_ata_nota FROM tb_nota_aluno
			) AND 
			a.DISCIPLINA NOT IN(
				SELECT iddisciplina FROM tb_disciplinas_nao_pai 
				WHERE idperiodo = (SELECT PERIODO FROM SONATA.SOPHIA.SOPHIA.TURMAS WHERE TURMA = @turma)
			) AND
			d.PERIODO = (SELECT PERIODO FROM SONATA.SOPHIA.SOPHIA.TURMAS WHERE TURMA = @turma)
		ORDER BY a.CODIGO, a.TURMA, a.DISCIPLINA, c.MATRICULA
	END
END


--
SELECT 
	a.CODIGO idcod_ata_nota,
	c.matricula,
	c.nota,
	CASE
		WHEN a.ETAPA in(1, 2) THEN 0.7
		ELSE
			CASE
				WHEN a.ETAPA in (3, 4) THEN 1.0
				ELSE NULL
			END
	END nota1peso,
	CASE
		WHEN a.ETAPA in(1, 2) THEN 0.3
		ELSE NULL
	END nota2peso,
	1 as inalunopai
	--a.etapa, 
	--d.NOME TURMA,
	--e.NOME DISCIPLINA,
	--* 
FROM SONATA.SOPHIA.SOPHIA.ATA_NOTA a
INNER JOIN tb_turmapai b ON b.id_cod_turma = a.TURMA
INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_ALUNO c ON c.ata = a.CODIGO
INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS d ON d.CODIGO = a.TURMA
INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS e ON e.CODIGO = a.DISCIPLINA
WHERE 
a.ETAPA <> 14 AND 
a.DISCIPLINA NOT IN(
	SELECT iddisciplina FROM tb_disciplinas_nao_pai WHERE idperiodo = d.PERIODO
) AND
d.CODIGO = 2590
ORDER BY a.CODIGO, a.TURMA, a.DISCIPLINA, c.MATRICULA

SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS WHERE CODIGO = 2521
---------------------------------------------------------------------
ALTER PROC sp_nota_aluno_pai_merge_prova_sub
(@deetapa int, @paraetapa int, @periodo int = null, @turma int = null)
AS
/*
	url: fit/professor/json/nota_aluno_pai_merge_b1_sub1.php
	data: 26/06/2014
	author: Massaharu
	desc: Copia as notas do pai (nota4) de uma etapa para a outra, e 
	também o status(inalunopai) de cada aluno se ele é participante do pai ou não
*/
BEGIN
	IF((@turma IS NULL OR @turma = 0 or @turma = '') AND @periodo IS NOT NULL)
	BEGIN
		UPDATE tb_nota_aluno
		SET inalunopai = CAST((dbo.fn_nota_aluno_notas_get(matricula, b.TURMA, b.DISCIPLINA, @deetapa, 'inalunopai')) AS BIT),
			nota2 = (dbo.fn_nota_aluno_notas_get(matricula, b.TURMA, b.DISCIPLINA, @deetapa, 'trabalho')),
			nota3 = (dbo.fn_nota_aluno_notas_get(matricula, b.TURMA, b.DISCIPLINA, @deetapa, 'pontoextra')),
			nota4 = (dbo.fn_nota_aluno_notas_get(matricula, b.TURMA, b.DISCIPLINA, @deetapa, 'pai')),
			nota1peso = CAST((dbo.fn_nota_aluno_notas_get(matricula, b.TURMA, b.DISCIPLINA, @deetapa, 'nota1peso')) AS numeric(2, 1)),
			nota2peso = CAST((dbo.fn_nota_aluno_notas_get(matricula, b.TURMA, b.DISCIPLINA, @deetapa, 'nota2peso')) AS numeric(2, 1))
		FROM tb_nota_aluno a
		INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
		INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = b.TURMA
		WHERE 
			b.disciplina NOT IN(
				SELECT iddisciplina FROM tb_disciplinas_nao_pai WHERE idperiodo = @periodo
			) 
			AND c.PERIODO = @periodo
			AND b.ETAPA = @paraetapa
				
	END
	-- Faz a cópia de determinadas turmas que são pai naquele periodo
	ELSE IF(@turma IS NOT NULL)
	BEGIN
		UPDATE tb_nota_aluno
		SET inalunopai = CAST((dbo.fn_nota_aluno_notas_get(matricula, b.TURMA, b.DISCIPLINA, @deetapa, 'inalunopai')) AS BIT),
			nota2 = (dbo.fn_nota_aluno_notas_get(matricula, b.TURMA, b.DISCIPLINA, @deetapa, 'trabalho')),
			nota3 = (dbo.fn_nota_aluno_notas_get(matricula, b.TURMA, b.DISCIPLINA, @deetapa, 'pontoextra')),
			nota4 = (dbo.fn_nota_aluno_notas_get(matricula, b.TURMA, b.DISCIPLINA, @deetapa, 'pai')),
			nota1peso = CAST((dbo.fn_nota_aluno_notas_get(matricula, b.TURMA, b.DISCIPLINA, @deetapa, 'nota1peso')) AS numeric(2, 1)),
			nota2peso = CAST((dbo.fn_nota_aluno_notas_get(matricula, b.TURMA, b.DISCIPLINA, @deetapa, 'nota2peso')) AS numeric(2, 1))
		FROM tb_nota_aluno a
		INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
		INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = b.TURMA
		WHERE 
			b.disciplina NOT IN(
				SELECT iddisciplina FROM tb_disciplinas_nao_pai WHERE idperiodo = (
					SELECT PERIODO FROM SONATA.SOPHIA.SOPHIA.TURMAS WHERE CODIGO = @TURMA
				) 
			) 
			AND b.ETAPA = @paraetapa
			AND b.TURMA = @turma		
	END
END

BEGIN TRAN
sp_nota_aluno_pai_merge_prova_sub 1, 2, 120, 2440
COMMIT
SELECT @@TRANCOUNT
--
SELECT *
FROM tb_nota_aluno a
INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = b.TURMA
WHERE 
	b.disciplina NOT IN(
		SELECT iddisciplina FROM tb_disciplinas_nao_pai WHERE idperiodo = 120
	) 
	AND c.PERIODO = 120
	AND b.ETAPA = 3
	AND b.TURMA = 2521
	
SELECT * FROM SONATA

SELECT * FROM  SONATA.SOPHIA.SOPHIA.TURMAS WHERE NOME LIKE '%TESTE%'
SELECt dbo.fn_nota_aluno_notas_get(34100, 2521, 400, 1, 'no')
SELECT * FROM tb_disciplinas_nao_pai
---------------------------------------------------------------------
ALTER PROC sp_nota_aluno_merge_prova_sub
(@deetapa int, @paraetapa int, @periodo int = null, @turma int = null)
AS
/*
	url: fit/professor/json/nota_aluno_merge_b1_sub1.php
	data: 26/06/2014
	author: Massaharu
	desc: Copia as notas do pai (nota4), trabalho e ponto extra de uma etapa para a outra
*/
BEGIN
	IF((@turma IS NULL OR @turma = 0 or @turma = '') AND @periodo IS NOT NULL)
	BEGIN
		UPDATE tb_nota_aluno
		SET 
			nota2 = (dbo.fn_nota_aluno_notas_get(matricula, b.TURMA, b.DISCIPLINA, @deetapa, 'trabalho')),
			nota3 = (dbo.fn_nota_aluno_notas_get(matricula, b.TURMA, b.DISCIPLINA, @deetapa, 'pontoextra')),
			nota4 = (dbo.fn_nota_aluno_notas_get(matricula, b.TURMA, b.DISCIPLINA, @deetapa, 'pai')),
			nota1peso = CAST((dbo.fn_nota_aluno_notas_get(matricula, b.TURMA, b.DISCIPLINA, @deetapa, 'nota1peso')) AS numeric(2, 1)),
			nota2peso = CAST((dbo.fn_nota_aluno_notas_get(matricula, b.TURMA, b.DISCIPLINA, @deetapa, 'nota2peso')) AS numeric(2, 1))
		FROM tb_nota_aluno a
		INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
		INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = b.TURMA
		WHERE 
			b.disciplina NOT IN(
				SELECT iddisciplina FROM tb_disciplinas_nao_pai WHERE idperiodo = @periodo
			) 
			AND c.PERIODO = @periodo
			AND b.ETAPA = @paraetapa
				
	END
	-- Faz a cópia de determinadas turmas que são pai naquele periodo
	ELSE IF(@turma IS NOT NULL)
	BEGIN
		UPDATE tb_nota_aluno
		SET 
			nota2 = (dbo.fn_nota_aluno_notas_get(matricula, b.TURMA, b.DISCIPLINA, @deetapa, 'trabalho')),
			nota3 = (dbo.fn_nota_aluno_notas_get(matricula, b.TURMA, b.DISCIPLINA, @deetapa, 'pontoextra')),
			nota4 = (dbo.fn_nota_aluno_notas_get(matricula, b.TURMA, b.DISCIPLINA, @deetapa, 'pai')),
			nota1peso = CAST((dbo.fn_nota_aluno_notas_get(matricula, b.TURMA, b.DISCIPLINA, @deetapa, 'nota1peso')) AS numeric(2, 1)),
			nota2peso = CAST((dbo.fn_nota_aluno_notas_get(matricula, b.TURMA, b.DISCIPLINA, @deetapa, 'nota2peso')) AS numeric(2, 1))
		FROM tb_nota_aluno a
		INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
		INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = b.TURMA
		WHERE 
			b.disciplina NOT IN(
				SELECT iddisciplina FROM tb_disciplinas_nao_pai WHERE idperiodo = @periodo
			) 
			AND b.ETAPA = @paraetapa
			AND b.TURMA = @turma		
	END
END
---------------------------------------------------------------------
ALTER FUNCTION dbo.fn_nota_aluno_notas_get
(@matricula int, @turma int, @disciplina int, @etapa int, @searchcolumn varchar(100))
RETURNS numeric (15, 4)
AS
BEGIN
	
	DECLARE 
		@nota1 numeric(15, 4),
		@nota2 numeric(15, 4),
		@nota3 numeric(15, 4),
		@nota4 numeric(15, 4),
		@inalunopai bit,
		@nota1peso numeric(2, 1),
		@nota2peso numeric(2, 1),
		@nota numeric(15, 4)
		
	SELECT 
		@nota1 = a.nota1, 
		@nota2 = a.nota2, 
		@nota3 = a.nota3, 
		@nota4 = a.nota4,
		@inalunopai = a.inalunopai,
		@nota1peso = nota1peso,
		@nota2peso = nota2peso
	FROM tb_nota_aluno a
	INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
	WHERE 
		a.matricula = @matricula AND 
		b.turma = @turma AND 
		b.disciplina = @disciplina AND 
		b.ETAPA = @etapa
	
	IF @searchcolumn = 'prova'
		SET @nota = @nota1
	IF @searchcolumn = 'trabalho'
		SET @nota = @nota2
	IF @searchcolumn = 'pontoextra'
		SET @nota = @nota3
	IF @searchcolumn = 'pai'
		SET @nota = @nota4
	IF @searchcolumn = 'inalunopai'
		SET @nota = CAST(@inalunopai AS numeric(15, 4))
	IF @searchcolumn = 'nota1peso'
		SET @nota = CAST(@nota1peso AS numeric(2, 1))
	IF @searchcolumn = 'nota2peso'
		SET @nota = CAST(@nota2peso AS numeric(2, 1))
		
	RETURN (@nota)
END 
---------------------------------------------------------------------
CREATE PROC sp_disciplinas_nao_pai_save
(@iddisciplina int, @idperiodo int, @idusuario int)
AS
/*
  app:Site FIT
  url:/simpacweb/modulos/fit/adm_turmas_pai/ajax/save_turmapai.php
  author: Massaharu
  date: 26/03/2014
  desc: salva as disciplinas que não farão parte do PAI
*/
BEGIN
	SET NOCOUNT ON
	
	INSERT INTO tb_disciplinas_nao_pai
	(iddisciplina, idperiodo, idusuario)
	VALUES
	(@iddisciplina, @idperiodo, @idusuario)
	
	SELECT SCOPE_IDENTITY() as iddiscnaopai
	
	SET NOCOUNT OFF
END

SELECT * FROM tb_disciplinas_nao_pai
---------------------------------------------------------------------
CREATE PROC sp_disciplinas_nao_pai_delete
(@iddiscnaopai int)
AS
/*
  app:Site FIT
  url:/simpacweb/modulos/fit/adm_turmas_pai/ajax/save_turmapai.php
  author: Massaharu
  date: 26/03/2014
  desc: salva as disciplinas que não farão parte do PAI
*/
BEGIN
	DELETE tb_disciplinas_nao_pai
	WHERE iddiscnaopai = @iddiscnaopai
END
---------------------------------------------------------------------
CREATE PROC sp_disciplinas_nao_pai_list
(@idperiodo int = NULL)
AS
/*
url: fit/professor/json/disciplinas_nao_pai_list.php
data: 26/06/2014
author: Massaharu
desc: Lista as disciplinas que não farão parte do pai por periodo(opcional)
*/
BEGIN
	IF @idperiodo IS NULL or @idperiodo = 0
	BEGIN
		SELECT
			a.iddiscnaopai, 
			a.iddisciplina, 
			b.nome as desdisciplina,
			b.nome_resum as dessigla,
			a.dtcadastro, 
			a.idperiodo, 
			c.descricao as desperiodo,
			a.idusuario,
			d.nmlogin
		FROM tb_disciplinas_nao_pai a
		INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS b ON b.CODIGO = a.iddisciplina
		INNER JOIN SONATA.SOPHIA.SOPHIA.PERIODOS c ON c.CODIGO = a.idperiodo
		INNER JOIN Simpac..tb_usuario d ON d.IdUsuario = a.idusuario
	END
	ELSE
	BEGIN
		SELECT
			a.iddiscnaopai, 
			a.iddisciplina, 
			b.nome as desdisciplina,
			b.nome_resum as dessigla,
			a.dtcadastro, 
			a.idperiodo, 
			c.descricao as desperiodo,
			a.idusuario,
			d.nmlogin
		FROM tb_disciplinas_nao_pai a
		INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS b ON b.CODIGO = a.iddisciplina
		INNER JOIN SONATA.SOPHIA.SOPHIA.PERIODOS c ON c.CODIGO = a.idperiodo
		INNER JOIN Simpac..tb_usuario d ON d.IdUsuario = a.idusuario
		WHERE c.CODIGO = @idperiodo
	END
END

sp_disciplinas_nao_pai_list 125
SELECT * FROM tb_disciplinas_nao_pai
SELECT * FROM SONATA.SOPHIA.SOPHIA.CURSOS 
SELECT * FROM SONATA.SOPHIA.SOPHIA.CURRICULO
SELECT * FROM SONATA.SOPHIA.SOPHIA.SERIE
SELECT * FROM SONATA.SOPHIA.SOPHIA.QC
SELECT * FROM SONATA.SOPHIA.SOPHIA.GRADES
WHERE NIVEL IN (1,2)
ORDER BY NIVEL
---------------------------------------------------------------------
CREATE PROC sp_disciplinas_porperiodo_list
(@idperiodo int = NULL)
AS
/*
	url: fit/professor/json/disciplinas_nao_pai_list.php
	data: 26/06/2014
	author: Massaharu
	desc: Lista as disciplinas que não farão parte do pai por periodo(opcional)
*/
BEGIN
	SELECT DISTINCT 
		a.CODIGO,
		a.NOME,
		a.NOME_RESUM 
	FROM SONATA.SOPHIA.SOPHIA.DISCIPLINAS a
	INNER JOIN SONATA.SOPHIA.SOPHIA.GRADES b ON b.DISCIPLINA = a.CODIGO
	INNER JOIN SONATA.SOPHIA.SOPHIA.SERIE c ON c.CODIGO = b.SERIE
	INNER JOIN SONATA.SOPHIA.SOPHIA.CURRICULO d ON d.CODIGO = c.CURRICULO
	INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS e ON e.PRODUTO = d.CURSO
	LEFT JOIN tb_disciplinas_nao_pai f ON f.iddisciplina = a.CODIGO AND f.idperiodo = @idperiodo
	WHERE e.NIVEL in(1, 2) AND f.iddisciplina IS NULL 
END
---------------------------------------------------------------------
ALTER PROC sp_disciplinas_porturma_list
(@idturma int)
AS
/*
	url: fit/professor/json/list_disciplinas_porturma.php
	data: 26/06/2014
	author: Massaharu
	desc: Lista as disciplinas pertencentes aquela turma
*/
BEGIN

	

	SELECT 
		a.CODIGO as idturma,
		a.NOME as desturma,
		a.PERIODO as idperiodo,
		e.DESCRICAO AS desperiodo,
		a.CURSO as idcurso,
		c.CODIGO as iddisciplina,
		c.NOME as desdisciplina,
		c.NOME_RESUM as dessigla,
		a.SERIE as idserie,
		a.INICIO as dtinicio,
		a.TERMINO as dttermino,
		b.PROFESSOR as idprofessor,
		d.NOME as desprofessor,
		b.ch as nrcargahoraria,
		ISNULL(MAX(f.CODIGO), 0) as qtd_ata_nota
	FROM SONATA.SOPHIA.SOPHIA.TURMAS a
	INNER JOIN SONATA.SOPHIA.SOPHIA.QC b ON b.TURMA = a.CODIGO
	INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS c ON c.CODIGO = b.DISCIPLINA
	INNER JOIN SONATA.SOPHIA.SOPHIA.PERIODOS e ON e.CODIGO = a.PERIODO
	LEFT JOIN SONATA.SOPHIA.SOPHIA.FISICA d ON d.CODIGO = b.PROFESSOR
	LEFT JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA f ON f.TURMA = a.CODIGO AND f.DISCIPLINA = c.CODIGO
	WHERE a.CODIGO = @idturma
	GROUP BY a.CODIGO, a.NOME, a.PERIODO, e.DESCRICAO, a.CURSO, c.CODIGO, c.NOME, c.NOME_RESUM, a.SERIE,
		a.INICIO, a.TERMINO, b.PROFESSOR, d.NOME, b.ch
END
--

sp_disciplinas_porturma_list 2450

SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS WHERE CODIGO = 2531
SELECT * FROM SONATA.SOPHIA.SOPHIA.GRADES
SELECT * FROM SONATA.SOPHIA.SOPHIA.CURRICULO
SELECT * FROM SONATA.SOPHIA.SOPHIA.DISCIPLINAS
SELECT * FROM SONATA.SOPHIA.SOPHIA.SERIE
SELECT * FROM SONATA.SOPHIA.SOPHIA.FUNCIONARIOS
SELECT * FROM SONATA.SOPHIA.SOPHIA.PERIODOS
SELECT * FROM SONATA.SOPHIA.SOPHIA.ATA_NOTA WHERE TURMA = 2450
---------------------------------------------------------------------
ALTER PROC sp_notaspaihistorico_save
(
	@idusuario int,
	@idperiodo int,
	@nrbimestre smallint,
	@filename varchar(200),
	@isponderado bit
)
AS
/*
  app:Site FIT
  url:/simpacweb/modulos/fit/adm_turmas_pai/json/list_turmapai.php
  author: Massaharu
  date: 26/03/2015
  desc: salva o histórico
*/
BEGIN
	SET NOCOUNT ON
	
	INSERT INTO tb_notaspaihistorico
	(
		idusuario,
		idperiodo,
		nrbimestre,
		descaminho,
		isponderado
	)VALUES(
		@idusuario,
		@idperiodo,
		@nrbimestre,
		(
			SELECT 
				replace(DESCRICAO, '/', '-') + '/' +  CAST(@nrbimestre AS CHAR(1)) + '/' + @filename
			FROM SONATA.SOPHIA.SOPHIA.PERIODOS 
			WHERE 
				CODIGO = @idperiodo
		),
		@isponderado
	)
	
	SET NOCOUNT OFF
	
	SELECT SCOPE_IDENTITY() as idnotaspaihistorico
	
END
--

SELECT * FROM tb_notaspaihistorico
--DELETE tb_notaspaihistorico
----------------------------------------------------------------------
CREATE PROC sp_notaspaihistoricoarquivos_add
(
	@idnotaspaihistorico int,
	@nrlinha int,
	@desra varchar(200),
	@desnome varchar(300),
	@nota numeric(15, 4)
)
AS
/*
  app:Site FIT
  url:/simpacweb/modulos/fit/adm_turmas_pai/json/list_turmapai.php
  author: Massaharu
  date: 26/03/2015
  desc: salva o histórico
*/
BEGIN
	
	INSERT INTO tb_notaspaihistoricoarquivos
	(
		idnotaspaihistorico,
		nrlinha,
		desra,
		desnome,
		nota
	)VALUES(
		@idnotaspaihistorico,
		@nrlinha,
		@desra,
		@desnome,
		@nota
	)
END
--
SELECT * FROM tb_notaspaihistoricoarquivos
---------------------------------------------------------------------
ALTER PROC sp_notaspaihistorico_list
AS
/*
  app:Site FIT
  url:/simpacweb/modulos/fit/adm_turmas_pai/json/list_turmapai.php
  author: Massaharu
  date: 26/03/2015
  desc: lista o histórico
*/
BEGIN
	
	SELECT
		a.idnotaspaihistorico,
		a.idusuario,
		c.nmlogin,
		a.idperiodo,
		b.DESCRICAO as desperiodo,
		a.nrbimestre,
		a.descaminho,
		a.isponderado,
		a.dtcadastro
	FROM tb_notaspaihistorico a
	INNER JOIN SONATA.SOPHIA.SOPHIA.PERIODOS b ON b.CODIGO = a.idperiodo
	INNER JOIN Simpac.dbo.tb_usuario c ON c.idusuario = a.idusuario
	ORDER BY
		dtcadastro desc, c.NmCompleto
END
---------------------------------------------------------------------
CREATE PROC sp_notaspaihistoricoarquivos_list
(@idnotaspaihistorico int = null)
AS
/*
  app:Site FIT
  url:/simpacweb/modulos/fit/adm_turmas_pai/json/list_turmapai.php
  author: Massaharu
  date: 26/03/2015
  desc: lista o histórico notas
*/
BEGIN

	IF @idnotaspaihistorico IS NULL
	BEGIN
		SELECT 
			idnotaspaihistoricoarquivos,
			idnotaspaihistorico,
			nrlinha,
			desra,
			desnome,
			nota
		FROM tb_notaspaihistoricoarquivos
	END
	ELSE
	BEGIN
		SELECT 
			idnotaspaihistoricoarquivos
			idnotaspaihistorico,
			nrlinha,
			desra,
			desnome,
			nota
		FROM tb_notaspaihistoricoarquivos
		WHERE	
			idnotaspaihistorico = @idnotaspaihistorico
	END
END
---------------------------------------------------------------------
---------------------------------------------------------------------
---------------- VERIFICAR ALUNOS DUPLICADOS NO EXCEL ---------------
---------------------------------------------------------------------
USE DEV_TESTE
-- TABELA PARA SALVAR AS NOTAS
CREATE TABLE tb_notaspai_teste(
	id int IDENTITY,
	ra varchar(100) not null,
	nome varchar(200)  not null,
	nota numeric(15,4)  not null
)
--DELETE tb_notaspai_teste

-- VERIFICA ALUNOS DUPLCIADOS
SELECT * FROM tb_notaspai_teste
WHERE ra IN(
	SELECT 
	ra
	FROM tb_notaspai_teste
	GROUP BY ra
	HAVING COUNT(*) > 1
)
ORDER BY RA


SELECT * FROM tb_notaspai_teste
---------------------------------------------------------------------
---------------------------------------------------------------------
---------------------------------------------------------------------
---------------------------------------------------------------------
---------------------------------------------------------------------
---------------------------------------------------------------------
---------------------------------------------------------------------
---------------------------------------------------------------------
---------------------------------------------------------------------
---------------------------------------------------------------------

SELECT 
	a.idturmapai,
	a.id_cod_turma,
	b.NOME as desnome,
	b.PERIODO as idperiodo,
	c.DESCRICAO as desperiodo,
	d.PRODUTO as idcurso_sophia,
	d.NOME as descurso_sophia,
	e.nmlogin as nmlogin,
	a.instatus,
	a.dtcadastro
FROM tb_turmapai a
INNER JOIN sonata.sophia.sophia.TURMAS b ON b.CODIGO = a.id_cod_turma
INNER JOIN sonata.sophia.sophia.PERIODOS c ON c.CODIGO = b.PERIODO
INNER JOIN sonata.sophia.sophia.CURSOS d ON d.PRODUTO = b.CURSO
INNER JOIN simpac..tb_usuario e ON e.IdUsuario = a.idusuario 

SELECT * FROM  sonata.sophia.sophia.FISICA
SELECT * FROM  sonata.sophia.sophia.TURMAS
SELECT * FROM  sonata.sophia.sophia.PERIODOS
SELECT * FROM  sonata.sophia.sophia.CURSOS
SELECT * FROM  sonata.sophia.sophia.QC_PROFESSOR WHERE QC = 14784
SELECT * FROM  sonata.sophia.sophia.QC WHERE TURMA = 2521

SELECT * FROM sonata.sophia.sophia.periodoS
SELECT * FROM tb_valor_cursos

SELECT * FROM tb_turmapai
SELECT * FROM tb_turmapai_documento_turma_fit
SELECT * FROM tb_documento_turma_FIT

SELECT * FROM tb_documento_turma_FIT
SELECT * FROM tb_tipo_documento_turma_FIT
SELECT * FROM tb_turmas_acessos_documentos_turmas_FIT

sp_turmapai_list
SELECT * FROM SONATA.SOPHIA.SOPHIA.ATA_NOTA WHERE TURMA = 2439 AND ETAPA = 1

SELECT * FROM tb_nota_aluno

SELECT DISTINCT * FROM tb_turmapai a
INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.TURMA = a.id_cod_turma
LEFT JOIN tb_nota_aluno c ON c.idcod_ata_nota = b.CODIGO
WHERE ETAPA = 1 AND TURMA in (
	SELECT id_cod_turma FROM tb_turmapai
) AND b.DISCIPLINA = 1199

SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA
SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS WHERE CODIGO = 2497

--------------------------------------------------------
SELECT DISTINCT
	a.CODIGO COD_TURMA, e.CODIGO ATA, a.NOME TURMA, c.NOME DISCIPLINA, c.CODIGO as cod_disciplina  
FROM SONATA.SOPHIA.SOPHIA.TURMAS a
INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA e ON e.TURMA = a.CODIGO
INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS c ON c.CODIGO = e.DISCIPLINA
WHERE 
	c.NOME NOT LIKE '%estagio%' AND
	c.NOME NOT LIKE '%oficina de projeto%' AND
	c.NOME NOT LIKE '%trabalho de conc%' AND
	a.PERIODO = 120 AND e.CODIGO IN(
		SELECT DISTINCT b.CODIGO FROM tb_turmapai a
		INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.TURMA = a.id_cod_turma
		LEFT JOIN tb_nota_aluno c ON c.idcod_ata_nota = b.CODIGO
		WHERE b.ETAPA = 2 AND c.idnotaaluno IS NULL
	)
ORDER BY a.CODIGO

SELECT DISTINCT a.*, f.CODEXT, f.NOME, d.PERIODO	
FROM tb_nota_aluno a
INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
INNER JOIN SONATA.SOPHIA.SOPHIA.MATRICULA d ON d.CODIGO = a.matricula
INNER JOIN SONATA.SOPHIA.SOPHIA.ACADEMIC e ON e.MATRICULA = d.CODIGO
INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA f ON f.CODIGO = d.FISICA
INNER JOIN tb_turmapai g ON g.id_cod_turma = b.TURMA
WHERE f.CODEXT = '1202211' AND d.PERIODO = 120
ORDER BY f.NOME

SELECT 
	c.CODIGO TURMA, 
	* 
FROM tb_nota_aluno a
INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = b.TURMA
--WHERE c.CODIGO = 2438
ORDER BY a.dtcadastro

SELECT * FROM tb_turmapai
SELECT * FROM tb_nota_aluno where matricula = 33221
SELECT * FROM SONATA.SOPHIA.SOPHIA.QC 

SELECT * FROM SONATA.SOPHIA.SOPHIA.ATA_NOTA WHERE CODIGO IN(
	SELECT DISTINCT b.CODIGO FROM tb_turmapai a
	INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.TURMA = a.id_cod_turma
	LEFT JOIN tb_nota_aluno c ON c.idcod_ata_nota = b.CODIGO
	WHERE b.ETAPA = 2 AND c.idnotaaluno IS NULL
)

SELECT RTRIM(LTRIM(id)) FROM Simpac.dbo.fnSplit('cassio, leal', ',')

SELECT * FROm SONATA.SOPHIA.SOPHIA.ACADEMIC
SELECT * FROm SONATA.SOPHIA.SOPHIA.PERIODOS
SELECT * FROm SONATA.SOPHIA.SOPHIA.MATRICULA
SELECT * FROm SONATA.SOPHIA.SOPHIA.ATA_NOTA WHERE CODIGO = 20409
SELECT * FROm SONATA.SOPHIA.SOPHIA.TURMAS WHERE CODIGO = 2442 
--SELECT a.*, e.CODEXT	
--UPDATE tb_nota_aluno
--SET nota5 = NULL
--FROM tb_nota_aluno a
--INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
----INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = b.TURMA
--INNER JOIN SONATA.SOPHIA.SOPHIA.MATRICULA d ON d.CODIGO = a.matricula
--INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA e ON e.CODIGO = d.FISICA
--WHERE d.TURMA_REGULAR = 2439

SELECT NOME, CODEXT, STATUS, * FROM SONATA.SOPHIA.SOPHIA.FISICA a 
INNER JOIN SONATA.SOPHIA.SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
WHERE a.CODEXT = '7106011' AND b.PERIODO = 120

SELECT NOME, CODEXT, STATUS FROM SONATA.SOPHIA.SOPHIA.FISICA a
INNER JOIN SONATA.SOPHIA.SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO

SELECT * FROM SONATA.SOPHIA.SOPHIA.MATRICULA
SELECT * FROM SONATA.SOPHIA.SOPHIA.ATA_NOTA
SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS
SELECT * FROM SONATA.SOPHIA.SOPHIA.ACADEMIC

SELECT * FROM tb_nota_aluno
SELECT * FROM tb_turmapai
-------------------------------------------
WITH
	tb_boletim_geral(
		MATRICULA, ACADEMIC, DESDISCIPLINA, TURMA, CARGAHORARIA, 
		SUB1, FALTAS1, SUB2, FALTAS2, MEDIA_FINAL, 
		EXAME, TF, SITUACAO, MEDIA_ANUAL, PERC_FALTAS, IDCOD_TURMA_PAI
	)AS(
	select 
		a.CODIGO, b.CODIGO ACADEMIC, d.nome DESDISCIPLINA, c.NOME TURMA, b.CARGA_HORARIA AS CARGAHORARIA, 
		b.NOTA3 SUB1, b.FALTAS1, b.NOTA4 SUB2, b.FALTAS2, b.MEDIA_FINAL, 
		b.EXAME, b.FALTAS1+b.FALTAS2 AS TF, b.SITUACAO,b.MEDIA_ANUAL,b.PERC_FALTAS, ISNULL(e.id_cod_turma, 0)
	from sonata.sophia.sophia.MATRICULA a 
	inner join sonata.sophia.sophia.ACADEMIC b on a.codigo = b.matricula
	inner join sonata.sophia.sophia.TURMAS c on b.turma = c.codigo
	inner join sonata.sophia.sophia.DISCIPLINAS d on d.codigo = b.disciplina
	LEFT JOIN tb_turmapai e ON e.id_cod_turma = c.CODIGO
)
SELECT * FROM tb_boletim_geral
WHERE MATRICULA = 33067

WITH
tb_boletim_etapa1(
	MATRICULA, ACADEMIC, ETAPA, DESDISCIPLINA, TURMA, CARGAHORARIA, 
	MB1, PROVA1, PROVAPESO1, TRABALHO1, TRABALHOPESO1, PONTO_EXTRA1, PAI1, SUB1, FALTAS1, 
	MEDIA_FINAL, EXAME, TF, SITUACAO,MEDIA_ANUAL,PERC_FALTAS
)AS(
	select a.CODIGO, b.CODIGO ACADEMIC, g.ETAPA, d.nome DESDISCIPLINA, c.NOME AS TURMA, b.CARGA_HORARIA AS CARGAHORARIA, 
		b.NOTA1 MB1, f.nota1 AS PROVA, f.nota1peso, f.nota2 AS TRABALHO, f.nota1peso, f.nota3 AS PONTO_EXTRA, f.nota4 AS PAI,b.NOTA3 SUB1, b.FALTAS1, 
		b.MEDIA_FINAL, b.EXAME, b.FALTAS1+b.FALTAS2 AS TF, b.SITUACAO,b.MEDIA_ANUAL,b.PERC_FALTAS
	from sonata.sophia.sophia.MATRICULA a 
	inner join sonata.sophia.sophia.ACADEMIC b on a.codigo = b.matricula
	inner join sonata.sophia.sophia.TURMAS c on b.turma = c.codigo
	inner join sonata.sophia.sophia.DISCIPLINAS d on d.codigo = b.disciplina
	INNER JOIN tb_nota_aluno f ON f.matricula = a.CODIGO 
	INNER JOIN sonata.sophia.sophia.ATA_NOTA g ON g.CODIGO = f.idcod_ata_nota AND d.CODIGO = g.DISCIPLINA AND g.ETAPA = 1
)
SELECT * FROM tb_boletim_etapa1
WHERE MATRICULA = 33067

WITH
tb_boletim_etapa2(
	MATRICULA, ACADEMIC, ETAPA, DESDISCIPLINA, TURMA, CARGAHORARIA, 
	MB2, PROVA2, PROVAPESO2, TRABALHO2, TRABALHOPESO2, PONTO_EXTRA2, PAI2,SUB2, FALTAS2, 
	MEDIA_FINAL, EXAME, TF, SITUACAO,MEDIA_ANUAL,PERC_FALTAS
)AS(
	select a.CODIGO, b.CODIGO ACADEMIC, g.ETAPA, d.nome DESDISCIPLINA, c.NOME TURMA, b.CARGA_HORARIA AS CARGAHORARIA, 
		b.NOTA1 MB2, f.nota1 AS PROVA2, f.nota1peso, f.nota2 AS TRABALHO2, f.nota2peso, f.nota3 AS PONTO_EXTRA2, f.nota4 AS PAI2,b.NOTA3 SUB2, b.FALTAS2, 
		b.MEDIA_FINAL, b.EXAME, b.FALTAS1+b.FALTAS2 AS TF, b.SITUACAO,b.MEDIA_ANUAL,b.PERC_FALTAS
	from sonata.sophia.sophia.MATRICULA a 
	inner join sonata.sophia.sophia.ACADEMIC b on a.codigo = b.matricula
	inner join sonata.sophia.sophia.TURMAS c on b.turma = c.codigo
	inner join sonata.sophia.sophia.DISCIPLINAS d on d.codigo = b.disciplina
	INNER JOIN tb_nota_aluno f ON f.matricula = a.CODIGO 
	INNER JOIN sonata.sophia.sophia.ATA_NOTA g ON g.CODIGO = f.idcod_ata_nota AND d.CODIGO = g.DISCIPLINA AND g.ETAPA = 2
)
SELECT * FROM tb_boletim_etapa2
WHERE MATRICULA = 33067
--------------------------------------------
WITH
	tb_boletim_geral(
		MATRICULA, ACADEMIC, DESDISCIPLINA, TURMA, CARGAHORARIA, 
		MB1, SUB1, FALTAS1, MB2, SUB2, FALTAS2, MEDIA_FINAL, 
		EXAME, TF, SITUACAO, MEDIA_ANUAL, PERC_FALTAS, IDCOD_TURMA_PAI
	)AS(
	select 
		a.CODIGO MATRICULA, b.CODIGO ACADEMIC, d.nome DESDISCIPLINA, c.NOME TURMA, b.CARGA_HORARIA AS CARGAHORARIA, b.NOTA1 MB1, 
		b.NOTA3 SUB1, b.FALTAS1, b.NOTA2 MB2, b.NOTA4 SUB2, b.FALTAS2, b.MEDIA_FINAL, 
		b.EXAME, b.FALTAS1+b.FALTAS2 AS TF, b.SITUACAO,b.MEDIA_ANUAL,b.PERC_FALTAS, ISNULL(e.id_cod_turma, 0)
	from sonata.sophia.sophia.MATRICULA a 
	inner join sonata.sophia.sophia.ACADEMIC b on a.codigo = b.matricula
	inner join sonata.sophia.sophia.TURMAS c on b.turma = c.codigo
	inner join sonata.sophia.sophia.DISCIPLINAS d on d.codigo = b.disciplina
	LEFT JOIN tb_turmapai e ON e.id_cod_turma = c.CODIGO
),
tb_boletim_etapa1(
	ACADEMIC, ETAPA, PROVA1, PROVAPESO1, TRABALHO1, TRABALHOPESO1, PONTO_EXTRA1, PAI1
)AS(
	select 
		b.CODIGO, g.ETAPA, f.nota1 AS PROVA, f.nota1peso, f.nota2 AS TRABALHO, f.nota2peso, f.nota3 AS PONTO_EXTRA, f.nota4 AS PAI
	from sonata.sophia.sophia.MATRICULA a 
	inner join sonata.sophia.sophia.ACADEMIC b on a.codigo = b.matricula
	inner join sonata.sophia.sophia.TURMAS c on b.turma = c.codigo
	inner join sonata.sophia.sophia.DISCIPLINAS d on d.codigo = b.disciplina
	INNER JOIN tb_nota_aluno f ON f.matricula = a.CODIGO 
	INNER JOIN sonata.sophia.sophia.ATA_NOTA g ON g.CODIGO = f.idcod_ata_nota AND d.CODIGO = g.DISCIPLINA AND g.ETAPA = 1
),
tb_boletim_etapa2(
	ACADEMIC, ETAPA, PROVA2, PROVAPESO2, TRABALHO2, TRABALHOPESO2, PONTO_EXTRA2, PAI2
)AS(
	select 
		b.CODIGO, g.ETAPA, f.nota1 AS PROVA, f.nota1peso, f.nota2 AS TRABALHO, f.nota2peso, f.nota3 AS PONTO_EXTRA, f.nota4 AS PAI
	from sonata.sophia.sophia.MATRICULA a 
	inner join sonata.sophia.sophia.ACADEMIC b on a.codigo = b.matricula
	inner join sonata.sophia.sophia.TURMAS c on b.turma = c.codigo
	inner join sonata.sophia.sophia.DISCIPLINAS d on d.codigo = b.disciplina
	inner JOIN tb_nota_aluno f ON f.matricula = a.CODIGO 
	inner JOIN sonata.sophia.sophia.ATA_NOTA g ON g.CODIGO = f.idcod_ata_nota AND d.CODIGO = g.DISCIPLINA AND g.ETAPA = 2
)
SELECT 
	c.MATRICULA, c.ACADEMIC, c.DESDISCIPLINA, c.TURMA, c.CARGAHORARIA, 
	a.ETAPA, c.MB1, a.PROVA1, a.PROVAPESO1, a.TRABALHO1, a.TRABALHOPESO1, a.PONTO_EXTRA1, a.PAI1, c.SUB1, c.FALTAS1, 
	b.ETAPA, c.MB2, b.PROVA2, b.PROVAPESO2, b.TRABALHO2, b.TRABALHOPESO2, b.PONTO_EXTRA2, b.PAI2, c.SUB2, c.FALTAS2, 
	c.MEDIA_FINAL, c.EXAME, c.TF, c.SITUACAO, c.MEDIA_ANUAL, c.PERC_FALTAS, c.IDCOD_TURMA_PAI
FROM tb_boletim_geral c
left JOIN tb_boletim_etapa1 a ON a.ACADEMIC = c.ACADEMIC
left JOIN tb_boletim_etapa2 b ON b.ACADEMIC = a.ACADEMIC
WHERE c.MATRICULA = 33067
ORDER BY c.DESDISCIPLINA


--------
select d.nome DESDISCIPLINA, c.NOME, b.CARGA_HORARIA AS CARGAHORARIA, b.NOTA1 MB1, 
b.NOTA3 SUB1, b.FALTAS1, b.NOTA2 MB2, b.NOTA4 SUB2, b.FALTAS2, b.MEDIA_FINAL, 
b.EXAME, b.FALTAS1+b.FALTAS2 AS TF, b.SITUACAO,b.MEDIA_ANUAL,b.PERC_FALTAS
from sonata.sophia.sophia.MATRICULA a 
inner join sonata.sophia.sophia.ACADEMIC b on a.codigo = b.matricula
inner join sonata.sophia.sophia.TURMAS c on b.turma = c.codigo
inner join sonata.sophia.sophia.DISCIPLINAS d on d.codigo = b.disciplina
--inner join sophia.GRADES e on d.codigo = e.DISCIPLINA
where a.codigo = 33067 --25156 --25398
order by d.NOME

SELECT * FROM tb_turmapai
select * from tb_nota_aluno
where matricula = 33771

SELECT * FROM SONATA.sophia.sophia.fisica where codext = '1703058'
SELECT * FROM SONATA.sophia.sophia.MATRICULA where FISICA = 25156
SELECT * FROM SONATA.SOPHIA.SOPHIA.ACADEMIC
SELECT * FROM Saturn.fit_new.dbo.tb_turmapai
SELECT * FROM Saturn.fit_new.dbo.tb_nota_aluno
SELECT * FROM SONATA.SOPHIA.SOPHIA.ATA_NOTA

SELECT * FROM Saturn.fit_new.dbo.tb_nota_aluno a
INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
INNER JOIN SONATA.SOPHIA.SOPHIA.MATRICULA d ON d.CODIGO = a.matricula
INNER JOIN SONATA.SOPHIA.SOPHIA.ACADEMIC e ON e.MATRICULA = d.CODIGO
INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA f ON f.CODIGO = d.FISICA
INNER JOIN Saturn.fit_new.dbo.tb_turmapai g ON g.id_cod_turma = b.TURMA
WHERE d.PERIODO = 120 AND ETAPA = 1


SELECT DISTINCT a.NOME NOME, d.NOME TURMA, CODEXT, STATUS 
FROM SONATA.SOPHIA.SOPHIA.FISICA a 
INNER JOIN SONATA.SOPHIA.SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO 
INNER JOIN SONATA.SOPHIA.SOPHIA.ACADEMIC c ON c.MATRICULA = b.CODIGO
INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS d ON d.CODIGO = c.TURMA
INNER JOIN Saturn.fit_new.dbo.tb_turmapai e ON e.id_cod_turma = d.CODIGO
WHERE a.CODEXT in (
	'1201815',
'1201700',
'1201166',
'1201238',
'1202381',
'1202373',
'1201017',
'1201727',
'1201302',
'1111002',
'12020259',
'1201326',
'10100195',
'1202944',
'1110948',
'1111266',
'10100448',
'1110678',
'9200132',
'12020516',
'1020315',
'1020062'
)
AND b.PERIODO = 120 AND STATUS = 0
--0 = ativo 
--1 = trancado
--2 = cancela
--3 = transferido 
--4 = evadido
--5 = concluído

SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE NOME LIKE '%teste%' AND SENHA IS NOT NULL

SELECT  * 
FROM tb_nota_aluno a
INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
INNER JOIN SONATA.SOPHIA.SOPHIA.MATRICULA d ON d.CODIGO = a.matricula
INNER JOIN SONATA.SOPHIA.SOPHIA.ACADEMIC e ON e.MATRICULA = d.CODIGO
INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA f ON f.CODIGO = d.FISICA
INNER JOIN tb_turmapai g ON g.id_cod_turma = b.TURMA
WHERE f.CODEXT = '1201883' AND d.PERIODO = 120 AND ETAPA in (
	SELECT LTRIM(RTRIM(id)) FROM Simpac..fnSplit('2, 4', ',')
)

SELECT DISTINCT h.NOME, i.NOME, a.* 
FROM tb_nota_aluno a
INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
INNER JOIN SONATA.SOPHIA.SOPHIA.MATRICULA d ON d.CODIGO = a.matricula
INNER JOIN SONATA.SOPHIA.SOPHIA.ACADEMIC e ON e.MATRICULA = d.CODIGO
INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA f ON f.CODIGO = d.FISICA
INNER JOIN tb_turmapai g ON g.id_cod_turma = b.TURMA
INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS h ON h.CODIGO = b.TURMA
INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS i ON i.CODIGO = b.DISCIPLINA
WHERE d.PERIODO = 120 AND ETAPA in (1,2) AND a.nota4 IS NULL


sp_notaspai_save '1201883', '10.00', 120, '2, 4'

SELECT 
	d.NOME TURMA, 
	f.NOME DISCIPLINA,
	c.ETAPA,
	a.idcod_ata_nota,
	a.matricula,
	a.nota1,
	a.nota2,
	a.nota3,
	a.nota4,
	a.nota1peso,
	a.nota2peso,
	a.inalunopai,
	b.idcod_ata_nota,
	b.matricula,
	b.nota1,
	b.nota2,
	b.nota3,
	b.nota4,
	b.nota1peso,
	b.nota2peso,
	b.inalunopai
FROM tb_nota_aluno a
INNER JOIN tb_nota_aluno b on b.matricula = a.matricula AND b.idcod_ata_nota = a.idcod_ata_nota
INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA c ON c.CODIGO = a.idcod_ata_nota
INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS d ON d.CODIGO = c.TURMA
INNER JOIN tb_turmapai e ON e.id_cod_turma = d.CODIGO
INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS f ON f.CODIGO = c.DISCIPLINA
WHERE c.disciplina NOT IN(
	SELECT iddisciplina FROM tb_disciplinas_nao_pai WHERE idperiodo = d.PERIODO
) AND d.CODIGO NOT IN(
	SELECT CODIGO FROM SONATA.SOPHIA.SOPHIA.TURMAS
	WHERE NOME LIKE '%TESTE%'
) AND d.PERIODO = 120
ORDER BY c.CODIGO
-----
WITH tb_nota_aluno_etapa1(
	idcod_ata_nota,
	matricula,
	nota1,
	nota2,
	nota3,
	nota4,
	nota1peso,
	nota2peso,
	inalunopai
)AS(
	SELECT 		
		idcod_ata_nota,
		matricula,
		nota1,
		nota2,
		nota3,
		nota4,
		nota1peso,
		nota2peso,
		inalunopai
	FROM tb_nota_aluno a
	INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
	INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS c ON c.CODIGO = b.DISCIPLINA
	INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS d ON d.CODIGO = b.TURMA
	INNER JOIN tb_turmapai e ON e.id_cod_turma = d.CODIGO
	WHERE b.disciplina NOT IN(
		SELECT iddisciplina FROM tb_disciplinas_nao_pai WHERE idperiodo = 120
	) AND d.PERIODO = 120
	AND b.ETAPA = 1
),
tb_nota_aluno_etapa2(
	idcod_ata_nota,
	matricula,
	nota1,
	nota2,
	nota3,
	nota4,
	nota1peso,
	nota2peso,
	inalunopai
)AS(
	SELECT 		
		idcod_ata_nota,
		matricula,
		nota1,
		nota2,
		nota3,
		nota4,
		nota1peso,
		nota2peso,
		inalunopai
	FROM tb_nota_aluno a
	INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
	INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS c ON c.CODIGO = b.DISCIPLINA
	INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS d ON d.CODIGO = b.TURMA
	INNER JOIN tb_turmapai e ON e.id_cod_turma = d.CODIGO
	WHERE b.disciplina NOT IN(
		SELECT iddisciplina FROM tb_disciplinas_nao_pai WHERE idperiodo = 120
	) AND d.PERIODO = 120
	AND b.ETAPA = 2
),
tb_nota_aluno_etapa3(
	idcod_ata_nota,
	matricula,
	nota1,
	nota2,
	nota3,
	nota4,
	nota1peso,
	nota2peso,
	inalunopai
)AS(
	SELECT 		
		idcod_ata_nota,
		matricula,
		nota1,
		nota2,
		nota3,
		nota4,
		nota1peso,
		nota2peso,
		inalunopai
	FROM tb_nota_aluno a
	INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
	INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS c ON c.CODIGO = b.DISCIPLINA
	INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS d ON d.CODIGO = b.TURMA
	INNER JOIN tb_turmapai e ON e.id_cod_turma = d.CODIGO
	WHERE b.disciplina NOT IN(
		SELECT iddisciplina FROM tb_disciplinas_nao_pai WHERE idperiodo = 120
	) AND d.PERIODO = 120
	AND b.ETAPA = 3
),
tb_nota_aluno_etapa4(
	idcod_ata_nota,
	matricula,
	nota1,
	nota2,
	nota3,
	nota4,
	nota1peso,
	nota2peso,
	inalunopai
)AS(
	SELECT 		
		idcod_ata_nota,
		matricula,
		nota1,
		nota2,
		nota3,
		nota4,
		nota1peso,
		nota2peso,
		inalunopai
	FROM tb_nota_aluno a
	INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
	INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS c ON c.CODIGO = b.DISCIPLINA
	INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS d ON d.CODIGO = b.TURMA
	INNER JOIN tb_turmapai e ON e.id_cod_turma = d.CODIGO
	WHERE b.disciplina NOT IN(
		SELECT iddisciplina FROM tb_disciplinas_nao_pai WHERE idperiodo = 120
	) AND d.PERIODO = 120
	AND b.ETAPA = 4
)
SELECT 
	b.nota4,
	c.nota4,
	d.nota4,
	e.nota4
FROM tb_nota_aluno a
INNER JOIN tb_nota_aluno_etapa1 b ON b.matricula = a.matricula
INNER JOIN tb_nota_aluno_etapa2 c ON c.matricula = a.matricula
INNER JOIN tb_nota_aluno_etapa3 d ON d.matricula = a.matricula
INNER JOIN tb_nota_aluno_etapa4 e ON e.matricula = a.matricula



SELECT @@TRANCOUNT
BEGIN TRAN
ROLLBACK
SELECt * FROm SONATA.SOPHIA.SOPHIA.ATA_NOTA
SELECt * FROm SONATA.SOPHIA.SOPHIA.ACADEMIC





SELECT nota1 FROM dbo.fn_nota_aluno_get(31902, 2350, 669, 1)

SELECT c.NOME TURMA, d.NOME DISCIPLINA, b.ETAPA, * FROM tb_nota_aluno a 
INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = b.TURMA
INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS d ON d.CODIGO = b.DISCIPLINA
WHERE idcod_ata_nota IN(
	SELECT a.idcod_ata_nota FROM tb_nota_aluno a
	INNER JOIN SONATA.SOPHIA.SOPHIA.ATA_NOTA b ON b.CODIGO = a.idcod_ata_nota
	GROUP BY  a.idcod_ata_nota, a.matricula, b.turma, b.disciplina, b.etapa
	HAVING COUNT(*) > 1
)
ORDER BY b.TURMA, b.DISCIPLINA, b.ETAPA, a.matricula

SELECT * FROM tb_disciplinas_nao_pai a
INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS b ON b.CODIGO = a.iddisciplina

------------------------------------------------------------------------
-------------------------------------------------------------------------
-------------------------------------------------------------------------
$.each($('#table-notas tr'), function(){
	var ra = $.trim($(this).find('.nrnota1').parent().prev().prev().text());
	var nota = $(this).find('.nrnota1');
	
	$.each($('#table-planilha tr'), function(){
		var ra_copy = $.trim($(this).find('td.td-nome-aluno').prev().text());
		
		if(ra == ra_copy){
			nota.text($(this).find('td.td-nome-aluno').next().text());
		}
	});
});

sada233423[]]