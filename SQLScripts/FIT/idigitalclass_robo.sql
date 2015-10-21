-- POSTGREE IDIGITAL CLASS (QUERY)
SELECT 
	a.id as id_aula,  
	b.id as id_preaula,
	b.descricao as desc_preaula,
	c.nomearquivo as nomearquivo_aulabase,
	d.id as idprogramadeaula,
	f.id as idperiodo,
	f.nome as periodo,
	e.id as idcurso,
	e.nome as curso,
	g.id as idturma,
	g.nome as turma,
	i.id as iddisciplina,
	i.nome as disciplina,
	h.nome as professor,
	c.inicio as inicio_aulabase,
	a.termino as termino_aula
FROM tblaula a
LEFT JOIN tblpreaula b ON b.id = a.fk_preaula
LEFT JOIN tblaulabase c ON c.id = a.id
LEFT JOIN tblprogramadeaula d ON d.id = c.fk_programadeaula
LEFT JOIN tblcurso e ON e.id = d.fk_curso
INNER JOIN tblperiododecurso f ON f.id = d.fk_periodo
INNER JOIN tblturma g ON g.id = d.fk_turma
INNER JOIN tblusuario h ON h.id = d.fk_professor
INNER JOIN tbldisciplina i ON i.id = d.fk_disciplina
WHERE a.id = 25197 -- nome do arquivo sem extesção
ORDER BY a.id


--------------------------------------------
USE FIT_NEW [SATURN]
-- Tabela para salvar os ranges de execução de cada aula por turno
CREATE TABLE tb_idigitalclass_timeexecution(
	idtimeexecution int identity CONSTRAINT PK_idigitalclass_timeexecution PRIMARY KEY,	
	idturno int,
	nraula int,
	dtinicio time,
	dttermino time
)

INSERT INTO tb_idigitalclass_timeexecution(idturno, nraula, dtinicio, dttermino)VALUES
(1, 1, '19:00:00', '21:59:59'),
(1, 2, '19:50:00', '21:59:59'),
(1, 3, '21:50:00', '23:59:59'),
(1, 4, '21:50:00', '23:59:59'),
(2, 1, '08:00:00', '10:59:59'),
(2, 2, '08:50:00', '10:59:59'),
(2, 3, '10:50:00', '18:59:59'),
(2, 4, '10:50:00', '18:59:59'),
(6, 1, '08:00:00', '13:59:59'),
(6, 2, '11:00:00', '13:59:59'),
(6, 3, '14:00:00', '23:59:59'),
(6, 4, '14:00:00', '23:59:59'),
(7, 1, '08:00:00', '13:59:59'),
(7, 2, '11:00:00', '13:59:59'),
(7, 3, '14:00:00', '23:59:59'),
(7, 4, '14:00:00', '23:59:59')

SELECT * FROM saturn.fit_new.dbo.tb_idigitalclass_timeexecution

----------------------------------------------------------
CREATE TABLE tb_xmlteam_idigitalclass(
	CODTURMASOPHIA int,
	CODTURMAIDIGITALCLASS int
)

SELECT 
	MAX(CODTURMASOPHIA) as CODTURMASOPHIA, 
	MAX(CODTURMAIDIGITALCLASS) as CODTURMAIDIGITALCLASS,
	COUNT(*) as 'COUNT' 
FROM tb_xmlteam_idigitalclass
GROUP BY CODTURMAIDIGITALCLASS, CODTURMASOPHIA
HAVING COUNT(*) > 1

SELECT * FROM tb_xmlteam_idigitalclass
----------------------------------------------------------
CREATE TABLE tb_xmldiscipline_idigitalclass(
	CODDISCIPLINASOPHIA int,
	CODDISCIPLINAIDIGITALCLASS int
)

SELECT 
	MAX(CODDISCIPLINASOPHIA) as CODDISCIPLINASOPHIA,
	MAX(CODDISCIPLINAIDIGITALCLASS) as CODDISCIPLINAIDIGITALCLASS, 
	COUNT(*) as 'COUNT'
FROM tb_xmldiscipline_idigitalclass
GROUP BY CODDISCIPLINAIDIGITALCLASS, CODDISCIPLINASOPHIA
----------------------------------------------------------
CREATE TABLE tb_periododecurso_idigitalclass(
	CODPERIODOSOPHIA int,
	CODPERIODOIDIGITALCLASS int
)

INSERT INTO tb_periododecurso_idigitalclass VALUES
(93, 3),
(95, 4),
(114, 2),
(117, 1),
(120, 8),
(125, 9),
(127, 10)

SELECT * FROM tb_periododecurso_idigitalclass
----------------------------------------------------------
-- Função para retornar o range de execução de um determinado turno e aula no dia
CREATE FUNCTION dbo.fn_lista_cham_by_horario
(@CODTURNO int, @NRAULA int)
RETURNS @idigitalclass_timeexecution TABLE(
	idtimeexecution int,	
	idturno int,
	nraula int,
	dtinicio time,
	dttermino time
)
/*
  app:Sophia
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
	
	INSERT INTO @idigitalclass_timeexecution
	SELECT idtimeexecution, idturno, nraula, dtinicio, dttermino 
	FROM saturn.fit_new.dbo.tb_idigitalclass_timeexecution
	WHERE 
		idturno = @CODTURNO AND nraula = @NRAULA
	
	RETURN 
END

SELECT * from dbo.fn_lista_cham_by_horario(7, 4)
--------------------------------------------------------
ALTER PROC sp_idigitalclass_timeexecution_list
AS
/*
  app: simpacweb
  url: /simpacweb/modulos/fit/idigitalclass/actions/json/list_arquivos_temp.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN

	SELECT 
		idtimeexecution,	
		idturno,
		b.descricao as desturno,
		nraula,
		dtinicio,
		dttermino
	FROM tb_idigitalclass_timeexecution a
	INNER JOIN SONATA.SOPHIA.SOPHIA.TURNOS b ON b.CODIGO = a.idturno
	ORDER BY a.idturno, a.nraula
END

SELECT * FROM tb_idigitalclass_timeexecution
--------------------------------------------------------
CREATE PROC sp_idigitalclass_timeexecution_edit
(@idtimeexecution int, @dtinicio time, @dttermino time )
AS
/*
  app: simpacweb
  url: /simpacweb/modulos/fit/idigitalclass/actions/json/edit_robot_time_execution.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN

	UPDATE tb_idigitalclass_timeexecution
	SET
		dtinicio = @dtinicio,
		dttermino = @dttermino
	WHERE idtimeexecution = @idtimeexecution
END
--------------------------------------------------------
ALTER PROC sp_aula_by_arquivo_get
(@NMLOGINPROF VARCHAR(20), @DATA DATETIME, @SALA VARCHAR(20))
AS
BEGIN
		
	WITH TB_AULA_BY_ARQUIVO(
		CODLISTA,
		NRAULA,
		NIVEL,
		PERIODO,
		CURSO,
		TURMA,
		DISCIPLINA,
		DATA,
		SALA,
		TURNO,
		CODPROFESSOR,
		DESPROFESSOR,
		DESCAMINHO
	)AS(
		SELECT 
			a.CODIGO AS CODLISTA,
			j.AULA AS NRAULA,
			e.DESCRICAO AS NIVEL,
			b.PERIODO,
			b.CURSO,
			a.TURMA,
			a.DISCIPLINA,
			a.DATA,
			h.DESCRICAO AS SALA,
			i.DESCRICAO AS TURNO,
			c.PROFESSOR AS CODPROFESSOR,
			f.APELIDO as DESPROFESSOR,
			REPLACE(g.DESCRICAO, '/', '-')+'/'+b.NOME+'/'+CAST(a.DISCIPLINA AS VARCHAR(100))+'/'+CAST(YEAR(a.DATA) AS VARCHAR(4))+'-'+CAST(MONTH(a.DATA) AS VARCHAR(4))+'-'+CAST(DAY(a.DATA) AS VARCHAR(4)) AS DESCAMINHO
		FROM SOPHIA.LISTA_CHAM a
		INNER JOIN SOPHIA.TURMAS b ON b.CODIGO = a.TURMA
		INNER JOIN SOPHIA.LISTA_CHAM_PROF c ON c.LISTA = a.CODIGO 
		INNER JOIN SOPHIA.CURSOS d ON d.PRODUTO = b.CURSO
		INNER JOIN SophiA.NIVEL e ON e.CODIGO = d.NIVEL
		INNER JOIN SophiA.FUNCIONARIOS f ON f.COD_FUNC = c.PROFESSOR
		INNER JOIN SOPHIA.PERIODOS g ON g.CODIGO = b.PERIODO
		LEFT JOIN  SOPHIA.SALAS h ON h.CODIGO = a.SALA
		INNER JOIN SOPHIA.TURNOS i ON i.CODIGO = b.TURNO
		INNER JOIN SOPHIA.LISTA_CHAM_AULAS j ON j.LISTA = a.CODIGO
		WHERE 
			f.APELIDO = @NMLOGINPROF
			AND CAST(a.DATA AS DATE) = CAST(@DATA AS DATE)
			AND h.DESCRICAO = @SALA
			AND CAST(@DATA AS TIME) 
				BETWEEN (SELECT dtinicio FROM dbo.fn_lista_cham_by_horario(i.CODIGO, j.AULA)) 
				AND (SELECT dttermino FROM dbo.fn_lista_cham_by_horario(i.CODIGO, j.AULA))
		GROUP BY
			a.CODIGO,
			j.AULA,
			e.DESCRICAO,
			b.PERIODO,
			b.CURSO,
			a.TURMA,
			a.DISCIPLINA,
			a.DATA,
			h.DESCRICAO,
			i.DESCRICAO,
			c.PROFESSOR,
			f.APELIDO,
			REPLACE(g.DESCRICAO, '/', '-')+'/'+b.NOME+'/'+CAST(a.DISCIPLINA AS VARCHAR(100))+'/'+CAST(CAST(a.DATA AS DATE) AS VARCHAR(10))
	)	

	SELECT 
		NIVEL,
		PERIODO,
		CURSO,
		TURMA,
		DISCIPLINA,
		DATA,
		SALA,
		TURNO,
		CODPROFESSOR,
		DESPROFESSOR,
		DESCAMINHO
	FROM TB_AULA_BY_ARQUIVO
	GROUP BY
		NIVEL,
		PERIODO,
		CURSO,
		TURMA,
		DISCIPLINA,
		DATA,
		SALA,
		TURNO,
		CODPROFESSOR,
		DESPROFESSOR,
		DESCAMINHO
END	
--

SELECT CAST(CAST(GETDATE() AS DATE) AS VARCHAR(10))
------------------------------------------------------------------------
ALTER PROC sp_idigitalclass_roboinfobypostgreedata_get
(
	@CODDISCIPLINAIDIGITALCLASS int,
	@CODTURMAIDIGITALCLASS int,
	@CODPERIODOIDIGITALCLASS int,
	@DATA datetime
)
AS
BEGIN

	SELECT 
		 k.APELIDO,
		 i.DESCRICAO as DESSALA
	FROM SONATA.SOPHIA.SOPHIA.LISTA_CHAM a
	INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS b ON b.CODIGO  = a.TURMA
	INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS c ON c.CODIGO = a.DISCIPLINA
	INNER JOIN (
		SELECT DISTINCT * FROM SATURN.FIT_NEW.dbo.tb_xmlteam_idigitalclass
	) d ON d.CODTURMASOPHIA = b.CODIGO
	INNER JOIN (
		SELECT DISTINCT * FROM SATURN.FIT_NEW.dbo.tb_xmldiscipline_idigitalclass
	) e ON e.CODDISCIPLINASOPHIA = c.CODIGO
	INNER JOIN (
		SELECT DISTINCT * FROM SATURN.FIT_NEW.dbo.tb_periododecurso_idigitalclass 
	) f ON f.CODPERIODOSOPHIA = b.PERIODO
	INNER JOIN SONATA.SOPHIA.SOPHIA.TURNOS g ON g.CODIGO = b.TURNO
	INNER JOIN SONATA.SOPHIA.SOPHIA.LISTA_CHAM_AULAS h ON h.LISTA = a.CODIGO
	LEFT JOIN SONATA.SOPHIA.SOPHIA.SALAS i ON i.CODIGO = a.SALA
	INNER JOIN SONATA.SOPHIA.SOPHIA.QC j ON j.TURMA = b.CODIGO AND j.DISCIPLINA = c.CODIGO
	INNER JOIN SONATA.SOPHIA.SOPHIA.FUNCIONARIOS k ON k.COD_FUNC = j.PROFESSOR
	WHERE 
		e.CODDISCIPLINAIDIGITALCLASS = @CODDISCIPLINAIDIGITALCLASS AND
		d.CODTURMAIDIGITALCLASS = @CODTURMAIDIGITALCLASS AND 
		f.CODPERIODOIDIGITALCLASS = @CODPERIODOIDIGITALCLASS AND
		CAST(a.DATA AS DATE) = CAST(@DATA AS DATE) AND
		CAST(@DATA AS TIME) 
			BETWEEN (SELECT dtinicio FROM dbo.fn_lista_cham_by_horario(g.CODIGO, h.AULA)) 
			AND (SELECT dttermino FROM dbo.fn_lista_cham_by_horario(g.CODIGO, h.AULA))
END	

sp_idigitalclass_roboinfobypostgreedata_get
	@CODDISCIPLINAIDIGITALCLASS = 247,
	@CODTURMAIDIGITALCLASS = 37,
	@CODPERIODOIDIGITALCLASS = 8,
	@DATA = '2014-02-11 20:54:33.158'
------------------------------------------------------------------------
ALTER PROC [dbo].[sp_arquivosidigitalclass_temp_save]
(
	@idarquivotemp int,
	@desprofessor varchar(300),
	@dessala varchar(50),
	@dtaula datetime,
	@instatus bit,
	@destemp varchar(256),
	@descaminho varchar(300) = NULL
)
AS
BEGIN
	SET NOCOUNT ON
	
	IF EXISTS(
		SELECT idarquivotemp FROM tb_arquivosidigitalclass_temp
		WHERE idarquivotemp = @idarquivotemp
	)
	BEGIN
	
		UPDATE tb_arquivosidigitalclass_temp
		SET
			desprofessor = @desprofessor,
			dessala = @dessala,
			dtaula = @dtaula,
			instatus = @instatus,
			dtalterado = GETDATE(),
			destemp = @destemp,
			descaminho = @descaminho
		WHERE idarquivotemp = @idarquivotemp
		
		SET NOCOUNT OFF
		
		SELECT @idarquivotemp as idarquivotemp
	END
	ELSE
	BEGIN
		
		INSERT INTO tb_arquivosidigitalclass_temp
		(
			desprofessor,
			dessala,
			dtaula,
			instatus,
			destemp,
			descaminho
		)VALUES(
			@desprofessor,
			@dessala,
			@dtaula,
			@instatus,
			@destemp,
			@descaminho
		)
		
		SET NOCOUNT OFF
		
		SELECT SCOPE_IDENTITY() as idarquivotemp
		
	END
END
------------------------------------------------------------------------
ALTER PROC sp_aula_arquivosidigitalclass_temp_list 
(@idarquivotemp int)
AS
/*
  app: simpacweb
  url: /simpacweb/modulos/fit/idigitalclass/actions/json/list_aula_arquivos_temp.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
	SELECT 
		a.idarquivotempcaminho,
		a.idarquivotemp,
		a.idprofessor,
		b.apelido as desprofessor,
		e.CODIGO as idperiodo,
		e.DESCRICAO as desperiodo,
		a.idturma,
		c.NOME as desturma,
		a.iddisciplina,
		d.NOME as desdisciplina,
		a.dtaula,
		a.descaminho
	FROM 
	tb_arquivosidigitalclass_temp_caminho a
	INNER JOIN SONATA.SOPHIA.SOPHIA.FUNCIONARIOS b ON b.COD_FUNC = a.idprofessor
	INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = a.idturma
	INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS d ON d.CODIGO = a.iddisciplina
	INNER JOIN SONATA.SOPHIA.SOPHIA.PERIODOS e ON e.CODIGO = c.PERIODO
	WHERE idarquivotemp = @idarquivotemp
END
--
sp_aula_arquivosidigitalclass_temp_list 7
SELECT * FROM tb_arquivosidigitalclass_temp_caminho
------------------------------------------------------------------------
CREATE PROC sp_arquivosidigitalclass_temp_reprocessar
(@idarquivotemp int)
AS
/*
  app: simpacweb
  url: /simpacweb/modulos/fit/idigitalclass/actions/json/reprocessar_arquivotemp.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
	
	UPDATE tb_arquivosidigitalclass_temp
	SET
		instatus = 0
	WHERE idarquivotemp = @idarquivotemp
END
------------------------------------------------------------------------
ALTER PROC sp_arquivosidigitalclass_temp_list
AS
/*
  app: simpacweb
  url: /simpacweb/modulos/fit/idigitalclass/actions/json/list_arquivos_temp.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
	SELECT 
		a.idarquivotemp,
		a.desprofessor,
		a.dessala,
		a.dtaula,
		a.instatus,
		a.dtalterado,
		a.destemp,
		a.dtcadastro,
		(	
			SELECT ISNULL(COUNT(idarquivotemp), 0) 
			FROM tb_arquivosidigitalclass_temp_caminho b
			WHERE
				b.idarquivotemp = a.idarquivotemp
		) as nrauladestino
	FROM tb_arquivosidigitalclass_temp a
	ORDER BY 
		instatus, dtaula desc, dessala, desprofessor
END
--
SELECT * FROM tb_arquivosidigitalclass_temp_caminho

------------------------------------------------------------------------
CREATE PROC sp_arquivosidigitalclass_temp_activate
(@idarquivotemp int)
AS
/*
  app: simpacweb
  url: /simpacweb/modulos/fit/idigitalclass/actions/json/edit_arquivosidigitalclass_temp.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
	SET NOCOUNT ON
	
	UPDATE tb_arquivosidigitalclass_temp
	SET
		dtalterado = GETDATE()
	WHERE idarquivotemp = @idarquivotemp
	
	SET NOCOUNT OFF
	
	SELECT @idarquivotemp as idarquivotemp
END
--
SELECT * FROM tb_arquivosidigitalclass_temp
------------------------------------------------------------------------
CREATE PROC sp_arquivosidigitalclass_temp_remove
(@idarquivotemp int)
AS
/*
  app: simpacweb
  url: /simpacweb/modulos/fit/idigitalclass/actions/json/edit_arquivosidigitalclass_temp.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
	DELETE tb_arquivosidigitalclass_temp_caminho
	WHERE idarquivotemp = @idarquivotemp
END
------------------------------------------------------------------------
ALTER PROC sp_arquivosidigitalclass_temp_add
(@idarquivotemp int, @codprofessor int, @codperiodo int, @codturma int, @coddisciplina int, @dtaula varchar(10))
AS
/*
  app: simpacweb
  url: /simpacweb/modulos/fit/idigitalclass/actions/json/edit_arquivosidigitalclass_temp.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
	
	DECLARE @descaminho varchar(300)
	
	SET @descaminho = 
		CAST(REPLACE((SELECT DESCRICAO FROM SONATA.SOPHIA.SOPHIA.PERIODOS WHERE CODIGO = @codperiodo), '/', '-') AS VARCHAR(10))+'/'+
		CAST((SELECT NOME FROM SONATA.SOPHIA.SOPHIA.TURMAS WHERE CODIGO = @codturma) AS VARCHAR(20))+'/'+
		CAST(@coddisciplina AS VARCHAR(10))+'/'+
		@dtaula
	
	INSERT INTO tb_arquivosidigitalclass_temp_caminho 
	(idarquivotemp, descaminho, idprofessor, idturma, iddisciplina, dtaula)
	VALUES
	(@idarquivotemp, @descaminho, @codprofessor, @codturma, @coddisciplina, @dtaula)
END
--
sp_arquivosidigitalclass_temp_edit 1, 125, 2560, 14, '2015-01-27'
SELECt * FROM tb_arquivosidigitalclass_temp
SELECt * FROM tb_arquivosidigitalclass_temp_caminho
------------------------------------------------------------------------
CREATE PROC sp_xmlteam_idigitalclass_table_update
(@CODTURMASOPHIA int, @CODTURMAIDIGITALCLASS int)
AS
BEGIN
	
	IF NOT EXISTS(
		SELECT * FROM tb_xmlteam_idigitalclass
		WHERE CODTURMASOPHIA = @CODTURMASOPHIA AND CODTURMAIDIGITALCLASS = @CODTURMAIDIGITALCLASS
	)
	BEGIN
		
		INSERT INTO tb_xmlteam_idigitalclass 
		(CODTURMASOPHIA, CODTURMAIDIGITALCLASS)
		VALUES
		(@CODTURMASOPHIA, @CODTURMAIDIGITALCLASS)

	END
END
--
SELECT * FROM tb_xmlteam_idigitalclass

------------------------------------------------------------------------
CREATE PROC sp_xmldiscipline_idigitalclass_table_update
(@CODDISCIPLINASOPHIA int, @CODDISCIPLINAIDIGITALCLASS int)
AS
BEGIN
	
	IF NOT EXISTS(
		SELECT * FROM tb_xmldiscipline_idigitalclass
		WHERE CODDISCIPLINASOPHIA = @CODDISCIPLINASOPHIA AND CODDISCIPLINAIDIGITALCLASS = @CODDISCIPLINAIDIGITALCLASS
	)
	BEGIN
	
		INSERT INTO tb_xmldiscipline_idigitalclass
		(CODDISCIPLINASOPHIA, CODDISCIPLINAIDIGITALCLASS)
		VALUES
		(@CODDISCIPLINASOPHIA, @CODDISCIPLINAIDIGITALCLASS)
	END

END
--


------------------------------------------------------------------------
ALTER PROC sp_periodoidigitalclassbysophia_get
(@idperiodosophia int)
AS
/*
  app: FIT
  url: inc/_class/idigitalClassAula.class.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
	
	SELECT DISTINCT TOP 1
		CODPERIODOIDIGITALCLASS 
	FROM tb_periododecurso_idigitalclass
	WHERE 
		CODPERIODOSOPHIA = @idperiodosophia
END
--
sp_periodoidigitalclassbysophia_get 127
------------------------------------------------------------------------
ALTER PROC sp_turmaidigitalclassbysophia_get
(@idturmasophia int)
AS
/*
  app: FIT
  url: inc/_class/idigitalClassAula.class.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
	SELECT 
		CODTURMAIDIGITALCLASS 
	FROM tb_xmlteam_idigitalclass
	WHERE
		CODTURMASOPHIA = @idturmasophia
END
--
sp_turmaidigitalclassbysophia_get 2785
sp_disciplinaidigitalclassbysophia_get 1290
------------------------------------------------------------------------
ALTER PROC sp_disciplinaidigitalclassbysophia_get
(@iddisciplinasophia int)
AS
/*
  app: FIT
  url: inc/_class/idigitalClassAula.class.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
	SELECT 
		CODDISCIPLINAIDIGITALCLASS
	FROM tb_xmldiscipline_idigitalclass 
	WHERE
		CODDISCIPLINASOPHIA = @iddisciplinasophia
	GROUP
	
END
--
sp_disciplinaidigitalclassbysophia_get 1159
------------------------------------------------------------------------
ALTER PROC sp_periodosophiabyidigitalclass_get
(@idperiodoidigitalclass int)
AS
/*
  app: FIT
  url: inc/_class/idigitalClassAula.class.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
	
	SELECT DISTINCT TOP 1
		CODPERIODOSOPHIA 
	FROM tb_periododecurso_idigitalclass
	WHERE 
		CODPERIODOIDIGITALCLASS = @idperiodoidigitalclass
END
--
sp_periodoidigitalclassbysophia_get 127
------------------------------------------------------------------------
ALTER PROC sp_turmasophiabyidigitalclass_get
(@idturmaidigitalclass int, @idperiodoidigitalclass int)
AS
/*
  app: FIT
  url: inc/_class/idigitalClassAula.class.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN

	-- SE A TURMA FOR PÓS GRADUAÇÃO
	IF (
		SELECT DISTINCT TOP 1
			b.CFG_ACAD
		FROM tb_xmlteam_idigitalclass a
		INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS b ON b.CODIGO = a.CODTURMASOPHIA
		WHERE
			CODTURMAIDIGITALCLASS = @idturmaidigitalclass
	) = 2
	BEGIN
	
		SELECT DISTINCT TOP 1
			CODTURMASOPHIA
		FROM tb_xmlteam_idigitalclass a
		INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS b ON b.CODIGO = a.CODTURMASOPHIA
		WHERE
			CODTURMAIDIGITALCLASS = @idturmaidigitalclass
	END
	-- SE A TURMA NÃO FOR PÓS GRADUAÇÃO
	ELSE
	BEGIN
		DECLARE @IDPERIODOSOPHIA int
	
		-- RECUPERA O IDPERIODO SOPHIA PELO IDPERIODO IDIGITALCLASS
		SET @IDPERIODOSOPHIA = (
			SELECT TOP 1
				CODPERIODOSOPHIA 
			FROM tb_periododecurso_idigitalclass 
			WHERE
				CODPERIODOIDIGITALCLASS = @idperiodoidigitalclass
		)
		
		SELECT DISTINCT TOP 1
			CODTURMASOPHIA
		FROM tb_xmlteam_idigitalclass a
		INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS b ON b.CODIGO = a.CODTURMASOPHIA
		WHERE
			CODTURMAIDIGITALCLASS = @idturmaidigitalclass AND
			b.PERIODO = @IDPERIODOSOPHIA
	END
END
--
sp_turmasophiabyidigitalclass_get 128, 9
SELECT * FROM tb_periododecurso_idigitalclass

SELECT
		CODTURMASOPHIA, b.PERIODO, b.NOME
	FROM tb_xmlteam_idigitalclass a
	INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS b ON b.CODIGO = a.CODTURMASOPHIA
	INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS c ON c.PRODUTO = b.CURSO
	WHERE b.CFG_ACAD = 2
	ORDER BY b.NOME
	WHERE
		c.NI
		CODTURMAIDIGITALCLASS = 37 AND
		b.PERIODO = @IDPERIODOIDC
		
SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS WHERE CODIGO in (2495)
SELECT * FROM SONATA.SOPHIA.SOPHIA.CFG_ACAD

SELECT COUNT(*)
FROM tb_xmlteam_idigitalclass
GROUP BY
	CODTURMASOPHIA, CODTURMAIDIGITALCLASS
HAVING COUNT(*) > 1

------------------------------------------------------------------------
ALTER PROC sp_disciplinasophiabyidigitalclass_get
(@iddisciplinaidigitalclass int)
AS
/*
  app: FIT
  url: inc/_class/idigitalClassAula.class.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
	SELECT DISTINCT TOP 1
		CODDISCIPLINASOPHIA
	FROM tb_xmldiscipline_idigitalclass 
	WHERE
		CODDISCIPLINAIDIGITALCLASS = @iddisciplinaidigitalclass
END
--
sp_disciplinasophiabyidigitalclass_get 233
------------------------------------------------------------------------

SONATA.SOPHIA.dbo.sp_AULA_BY_ARQUIVO_get 
	@NMLOGINPROF = 'LPontes',
	@DATA = '2014-12-18 19:30:00', 
	@SALA = 'A110'

-------------------------------------------------------------------------
SELECT * FROM SOPHIA.TURMAS WHERE PERIODO NOT IN (1, 2)
SELECT * FROM SOPHIA.TURNOS
SELECT * FROM SOPHIA.SALAS
SELECT * FROM SOPHIA.NIVEL
SELECT * FROM SOPHIA.LISTA_CHAM_AULAS WHERE LISTA = 116096
SELECT DATEADD(n, 50, (dbo.fn_lista_cham_by_horario(1, 2)))
---------------
SELECT	
	g.DESCRICAO AS PERIODO, h.DESCRICAO AS SALA, e.APELIDO, a.DATA, COUNT(*) 
FROM SOPHIA.LISTA_CHAM a
INNER JOIN SOPHIA.TURMAS b ON b.CODIGO = a.TURMA
INNER JOIN SOPHIA.CURSOS c ON c.PRODUTO = b.CURSO
INNER JOIN SOPHIA.LISTA_CHAM_PROF d ON d.LISTA = a.CODIGO
INNER JOIN SOPHIA.FUNCIONARIOS e ON e.COD_FUNC = d.PROFESSOR
INNER JOIN SOPHIA.DISCIPLINAS f ON f.CODIGO = a.DISCIPLINA
INNER JOIN SOPHIA.PERIODOS g ON g.CODIGO = b.PERIODO
LEFT JOIN SOPHIA.SALAS h ON h.CODIGO = a.SALA
WHERE b.TURNO = 6 AND c.NIVEL IN (3, 5)
GROUP BY g.DESCRICAO, h.DESCRICAO, e.APELIDO, a.DATA
HAVING  COUNT(*) > 1
ORDER BY a.DATA
------------
WITH TB_AULA_BY_ARQUIVO(
	CODLISTA,
	NRAULA,
	NIVEL,
	PERIODO,
	CURSO,
	TURMA,
	DISCIPLINA,
	DATA,
	SALA,
	TURNO,
	CODPROFESSOR,
	DESPROFESSOR,
	DESCAMINHO
)AS(
	SELECT 
		a.CODIGO AS CODLISTA,
		j.AULA AS NRAULA,
		e.DESCRICAO AS NIVEL,
		b.PERIODO,
		b.CURSO,
		a.TURMA,
		a.DISCIPLINA,
		a.DATA,
		h.DESCRICAO AS SALA,
		i.DESCRICAO AS TURNO,
		c.PROFESSOR AS CODPROFESSOR,
		f.APELIDO as DESPROFESSOR,
		REPLACE(g.DESCRICAO, '/', '-')+'/'+b.NOME+'/'+CAST(a.DISCIPLINA AS VARCHAR(100))+'/'+CAST(YEAR(a.DATA) AS VARCHAR(4))+'/'+CAST(MONTH(a.DATA) AS VARCHAR(4))+'/'+CAST(DAY(a.DATA) AS VARCHAR(4)) AS DESCAMINHO
	FROM SOPHIA.LISTA_CHAM a
	INNER JOIN SOPHIA.TURMAS b ON b.CODIGO = a.TURMA
	INNER JOIN SOPHIA.LISTA_CHAM_PROF c ON c.LISTA = a.CODIGO 
	INNER JOIN SOPHIA.CURSOS d ON d.PRODUTO = b.CURSO
	INNER JOIN SophiA.NIVEL e ON e.CODIGO = d.NIVEL
	INNER JOIN SophiA.FUNCIONARIOS f ON f.COD_FUNC = c.PROFESSOR
	INNER JOIN SOPHIA.PERIODOS g ON g.CODIGO = b.PERIODO
	LEFT JOIN  SOPHIA.SALAS h ON h.CODIGO = a.SALA
	INNER JOIN SOPHIA.TURNOS i ON i.CODIGO = b.TURNO
	INNER JOIN SOPHIA.LISTA_CHAM_AULAS j ON j.LISTA = a.CODIGO
	GROUP BY
		a.CODIGO,
		j.AULA,
		e.DESCRICAO,
		b.PERIODO,
		b.CURSO,
		a.TURMA,
		a.DISCIPLINA,
		a.DATA,
		h.DESCRICAO,
		i.DESCRICAO,
		c.PROFESSOR,
		f.APELIDO,
		'/'+REPLACE(g.DESCRICAO, '/', '-')+'/'+b.NOME+'/'+CAST(a.DISCIPLINA AS VARCHAR(100))+'/'+CAST(YEAR(a.DATA) AS VARCHAR(4))+'/'
)	

SELECT 
	NIVEL,
	PERIODO,
	CURSO,
	TURMA,
	DISCIPLINA,
	DATA,
	SALA,
	TURNO,
	CODPROFESSOR
	DESPROFESSOR,
	DESCAMINHO,
	COUNT(*)
FROM TB_AULA_BY_ARQUIVO
GROUP BY
	NIVEL,
	PERIODO,
	CURSO,
	TURMA,
	DISCIPLINA,
	DATA,
	SALA,
	TURNO,
	PROFESSOR,
	DESCAMINHO
ORDER BY DATA, CURSO, TURMA, DISCIPLINA	

SELECT * FROM tb_arquivosidigitalclass_temp

--UPDATE tb_arquivosidigitalclass_temp
--SET 
--	descaminho = NULL,
--	dtalterado = NULL

SELECT * FROM SOPHIA.FISICA a
INNER JOIN SOPHIA.FUNCIONARIOS b ON b.COD_FUNC = a.CODIGO
WHERE a.NOME LIKE '%MARCELO%' AND LECIONA = 1

SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS WHERE NOME LIKE 'AI (UX)_Módulo II - Projetos AI_01'

SELECT (exec sonata.Sophia.dbo.fn_qtdsemestrecurso_get 43)

SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA  WHERE nomE like '%francisca elane%'
SELECT * FROM SONATA.SOPHIA.SOPHIA.FUNCIONARIOS WHERE COD_FUNC = 8415

CREATE TABLE tb_xmlteams(
      idturmasophia int,
      idturmaidigitalclass int
)