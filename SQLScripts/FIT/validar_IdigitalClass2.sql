/*********************************************************************/
/****************** SERVIDOR -> SATURN *******************************/
/****************** USE IDIGITALCLASS ********************************/
/*********************************************************************/
-----------------------------------------------------------
-----------------------------------------------------------
-------------------- TABELAS ------------------------------
-----------------------------------------------------------
-----------------------------------------------------------
CREATE TABLE tb_arquivostipos(
      idarquivotipo int IDENTITY CONSTRAINT PK_arquivostipos PRIMARY KEY,
      desarquivotipo varchar(200) not null,
      instatus bit CONSTRAINT DF_arquivostipos_instatus DEFAULT(1),
      dtcadastro datetime CONSTRAINT DF_arquivostipos_dtcadastro DEFAULT(getdate())
)

INSERT INTO tb_arquivostipos
VALUES ('Pré-Aula'), ('Vídeos')

-- CHANGES
	tb_arquivosidigitalclasstipo -> tb_arquivostipos

SELECt * FROM FIT_NEW.dbo.tb_arquivosidigitalclasstipo
SELECt * FROM tb_arquivostipos
-----------------------------------------------------------
CREATE TABLE tb_arquivos(
      idarquivo int IDENTITY CONSTRAINT PK_arquivos PRIMARY KEY,
      desarquivo varchar(300) not null,
      nrtamanho int,
      idarquivotipo int,
      descaminho varchar(300),
      instatus bit CONSTRAINT DF_arquivos_instatus DEFAULT(1),
	  incopiado bit CONSTRAINT DF_arquivos_incopiado DEFAULT 0,
      dtcadastro datetime CONSTRAINT DF_arquivos_dtcadastro DEFAULT(getdate()),
      desarquivoold varchar(300) 
            
      CONSTRAINT FK_arquivos_arquivostipos_idarquivotipo FOREIGN KEY(idarquivotipo)
      REFERENCES tb_arquivostipos(idarquivotipo)
)

-- CHANGES
	tb_arquivosidigitalclass -> tb_arquivos

-- ADDS
	incopiado
	
-- MIGRAÇÃO DE DADOS
	SELECT * FROM FIT_NEW.dbo.tb_arquivosidigitalclass
	SELECT * FROM tb_arquivos

	--SET IDENTITY_INSERT tb_arquivos OFF
	--GO
	--INSERT INTO tb_arquivos
	--(
	--	idarquivo,
	--	desarquivo,
	--	nrtamanho,
	--	idarquivotipo,
	--	descaminho,
	--	instatus,
	--	incopiado
	--)
	--SELECT 
	--	idarquivo,
	--	desarquivo,
	--	nrtamanho,
	--	idarquivotipo,
	--	descaminho,
	--	instatus,
	--	incopiado
	--FROM FIT_NEW.dbo.tb_arquivosidigitalclass
	--GO
	--SET IDENTITY_INSERT tb_aulas OFF


------------------------------------------------
CREATE TABLE tb_aulas(
      idaula int identity CONSTRAINT PK_aulas PRIMARY KEY,
      idcodfisica int,
      idcodturma int,
      idcoddisciplina int,
      desdescricao varchar(5000),
      dtaula datetime not null,
      instatus bit CONSTRAINT DF_aulas_instatus DEFAULT(1),
      dtcadastro datetime CONSTRAINT DF_aulas_dtcadastro DEFAULT(getdate())
)

-- CHANGES
	tb_idigitalclassaulas -> tb_aulas

-- MIGRAÇÃO DE DADOS
	SELECT * FROM FIT_NEW.dbo.tb_idigitalclassaulas
	SELECt * FROM tb_aulas

	--SET IDENTITY_INSERT tb_aulas ON
	--GO
	--INSERT INTO tb_aulas
	--(
	--	idaula,
	--	idcodfisica,
	--	idcodturma,
	--	idcoddisciplina,
	--	desdescricao,
	--	dtaula,
	--	instatus,
	--	dtcadastro
	--)
	--SELECT
	--	idaula,
	--	idcodfisica,
	--	idcodturma,
	--	idcoddisciplina,
	--	desdescricao,
	--	dtaula,
	--	instatus,
	--	dtcadastro
	--FROM FIT_NEW.dbo.tb_idigitalclassaulas
	--GO
	--SET IDENTITY_INSERT tb_aulas OFF
-----------------------------------------------------------
CREATE TABLE tb_aulasarquivos(
      idaula int,
      idarquivo int
      
      CONSTRAINT PK_aulasarquivos_idaula_idarquivo PRIMARY KEY(idaula, idarquivo),
      CONSTRAINT FK_aulasarquivos_aulas_idaula FOREIGN KEY(idaula)
      REFERENCES tb_aulas(idaula),
      CONSTRAINT FK_aulasarquivos_arquivos_idarquivo FOREIGN KEY(idarquivo)
      REFERENCES tb_arquivos(idarquivo)
)

-- CHANGES
	tb_idigitalclassaulas_arquivos -> tb_aulasarquivos
	
-- MIGRAÇÃO DE DADOS

	SELECT * FROM FIT_NEW.dbo.tb_idigitalclassaulas_arquivos
	SELECt * FROM tb_aulasarquivos
	
	--INSERT INTO tb_aulasarquivos
	--(
	--	idaula,
	--	idarquivo
	--)
	--SELECT
	--	idaula,
	--	idarquivo
	--FROM FIT_NEW.dbo.tb_idigitalclassaulas_arquivos

-----------------------------------------------------------
CREATE TABLE tb_avaliacoesaulas(
      idavaliacao int IDENTITY,
      idaula int,
      idaluno int,
      nrnota int,
      instatus bit CONSTRAINT DF_avaliacoesaulas_instatus DEFAULT(1),
      dtcadastro datetime CONSTRAINT DF_avaliacoesaulas_dtcadastro DEFAULT(getdate()) 
      
      CONSTRAINT PK_avaliacoesaulas_idavaliacao_idaula_idaluno PRIMARY KEY(idavaliacao, idaula, idaluno),
      CONSTRAINT FK_avaliacoesaulas_idaula FOREIGN KEY(idaula)
      REFERENCES tb_aulas(idaula)
)

-- CHANGES
	tb_idigitalclassaulas_avaliacao -> tb_avaliacoesaulas
	
-- MIGRAÇÃO DE DADOS
	SELECT * FROM FIT_NEW.dbo.tb_idigitalclassaulas_avaliacao
	SELECT * FROM tb_avaliacoesaulas
	
	--SET IDENTITY_INSERT tb_avaliacoesaulas ON
	--GO
	--INSERT INTO tb_avaliacoesaulas
	--(
	--	idavaliacao,
	--	idaula,
	--	idaluno,
	--	nrnota,
	--	instatus,
	--	dtcadastro
	--)
	--SELECT 
	--	idavaliacao,
	--	idaula,
	--	idaluno,
	--	nrnota,
	--	instatus,
	--	dtcadastro
	--FROM FIT_NEW.dbo.tb_idigitalclassaulas_avaliacao
	--GO
	--SET IDENTITY_INSERT tb_avaliacoesaulas OFF
-----------------------------------------------------------
CREATE TABLE tb_timeexecutions(
      idtimeexecution int identity CONSTRAINT PK_timeexecutions PRIMARY KEY,      
      idturno int,
      nraula int,
      dtinicio time,
      dttermino time
)

-- CHANGES
	tb_idigitalclass_timeexecution -> tb_timeexecutions
	
-- MIGRAÇÃO DE DADOS	
	--SELECT * FROM FIT_NEW.dbo.tb_idigitalclass_timeexecution
	--SELECT * FROM tb_timeexecutions

	--INSERT INTO tb_timeexecutions(idturno, nraula, dtinicio, dttermino)VALUES
	--(1, 1, '19:00:00', '21:59:59'),
	--(1, 2, '19:50:00', '21:59:59'),
	--(1, 3, '21:50:00', '23:59:59'),
	--(1, 4, '21:50:00', '23:59:59'),
	--(2, 1, '08:00:00', '10:59:59'),
	--(2, 2, '08:50:00', '10:59:59'),
	--(2, 3, '10:50:00', '18:59:59'),
	--(2, 4, '10:50:00', '18:59:59'),
	--(6, 1, '08:00:00', '13:59:59'),
	--(6, 2, '11:00:00', '13:59:59'),
	--(6, 3, '14:00:00', '23:59:59'),
	--(6, 4, '14:00:00', '23:59:59'),
	--(7, 1, '08:00:00', '13:59:59'),
	--(7, 2, '11:00:00', '13:59:59'),
	--(7, 3, '14:00:00', '23:59:59'),
	--(7, 4, '14:00:00', '23:59:59')
----------------------------------------------------------
CREATE TABLE tb_xmlteams(
      idturmasophia int,
      idturmaidigitalclass int
)

-- CHANGES
	tb_xmlteam_idigitalclass -> tb_xmlteams
	CODTURMASOPHIA -> idturmasophia
	CODTURMAIDIGITALCLASS -> idturmaidigitalclass

-- MIGRAÇÃO DE DADOS
	SELECT COUNT(*) FROM FIT_NEW.dbo.tb_xmlteam_idigitalclass GROUP BY CODTURMASOPHIA, CODTURMAIDIGITALCLASS HAVING COUNT(*) > 1
	SELECT a.*, c.nome FROM tb_xmlteams a INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON a.idturmasophia = c.codigo WHERE a.idturmasophia = 2785
	
	SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS
----------------------------------------------------------
CREATE TABLE tb_xmldisciplines(
      iddisciplinasophia int,
      iddisciplinaidigitalclass int
)

-- CHANGES	
	tb_xmldiscipline_idigitalclass -> tb_xmldisciplines
	CODDISCIPLINASOPHIA -> iddisciplinasophia
	CODDISCIPLINAIDIGITALCLASS -> iddisciplinaidigitalclass

-- MIGRAÇÃO DE DADOS
	SELECT * FROM FIT_NEW.dbo.tb_xmldiscipline_idigitalclass
	SELECT * FROM tb_xmldisciplines 

----------------------------------------------------------
CREATE TABLE tb_periodosdecursos(
      idperiodosophia int,
      idperiodoidigitalclass int
)

INSERT INTO tb_periodosdecursos VALUES
--(93, 3),
--(95, 4),
--(114, 2),
--(117, 1),
--(120, 8),
--(125, 9),
--(127, 10),
(128, 13)

-- CHANGES
	tb_periododecurso_idigitalclass -> tb_periodosdecursos
	CODPERIODOSOPHIA -> idperiodosophia
	CODPERIODOIDIGITALCLASS -> idperiodoidigitalclass

-- MIGRAÇÃO DE DADOS
	SELECT * FROM FIT_NEW.dbo.tb_periododecurso_idigitalclass
	SELECT * FROM tb_periodosdecursos
	
	--INSERT INTO tb_periodosdecursos
	--(
	--	idperiodosophia,
	--	idperiodoidigitalclass
	--)
	--SELECT
	--	CODPERIODOSOPHIA,
	--	CODPERIODOIDIGITALCLASS
	--FROM FIT_NEW.dbo.tb_periododecurso_idigitalclass
----------------------------------------------------------
CREATE TABLE tb_arquivostemps(
	idarquivotemp int IDENTITY(1,1) CONSTRAINT PK_arquivostemps PRIMARY KEY,
	desprofessor varchar(300),
	dessala varchar(100),
	dtaula datetime,
	instatus bit CONSTRAINT DF_arquivostemps_instatus  DEFAULT 0,
	dtcadastro datetime CONSTRAINT DF_arquivostemps_dtcadastro  DEFAULT getdate(),
	dtalterado datetime,
	destemp varchar(500)
)

-- CHANGES
	tb_arquivosidigitalclass_temp -> tb_arquivostemps

-- MIGRAÇÃO DE DADOS

	SELECT * FROM FIT_NEW.dbo.tb_arquivosidigitalclass_temp
	SELECT * FROM tb_arquivostemps
	
	--SET IDENTITY_INSERT tb_arquivostemps ON
	--GO
	--INSERT INTO tb_arquivostemps
	--(
	--	idarquivotemp,
	--	desprofessor,
	--	dessala,
	--	dtaula,
	--	instatus,
	--	dtcadastro,
	--	dtalterado,
	--	destemp
	--)
	--SELECT
	--	idarquivotemp,
	--	desprofessor,
	--	dessala,
	--	dtaula,
	--	instatus,
	--	dtcadastro,
	--	dtalterado,
	--	destemp
	--FROM FIT_NEW.dbo.tb_arquivosidigitalclass_temp
	--GO
	--SET IDENTITY_INSERT tb_arquivostemps OFF
		
----------------------------------------------------------
CREATE TABLE tb_arquivostempscaminhos(
	idarquivotempcaminho int IDENTITY(1,1) NOT NULL,
	idarquivotemp int NOT NULL,
	descaminho varchar(300),
	idprofessor int NOT NULL,
	idturma int NOT NULL,
	iddisciplina int NOT NULL,
	dtaula datetime
	
	CONSTRAINT PK_arquivostempscaminhos_idarquivotempcaminho_idarquivotemp PRIMARY KEY (idarquivotempcaminho, idarquivotemp),
	CONSTRAINT FK_arquivostempscaminhos_arquivostemps_idarquivotemp FOREIGN KEY(idarquivotemp)
	REFERENCES tb_arquivostemps (idarquivotemp)
)

-- CHANGES
	tb_arquivosidigitalclass_temp_caminho -> tb_arquivostempscaminhos

-- MIGRAÇÃO DE DADOS
	SELECT * FROM FIT_NEW.dbo.tb_arquivosidigitalclass_temp_caminho
	SELECT * FROM tb_arquivostempscaminhos
	
	--SET IDENTITY_INSERT tb_arquivostempscaminhos ON
	--GO
	--INSERT INTO tb_arquivostempscaminhos
	--(
	--	idarquivotempcaminho,
	--	idarquivotemp,
	--	descaminho,
	--	idprofessor,
	--	idturma,
	--	iddisciplina,
	--	dtaula
	--)
	--SELECT 
	--	idarquivotempcaminho,
	--	idarquivotemp,
	--	descaminho,
	--	idprofessor,
	--	idturma,
	--	iddisciplina,
	--	dtaula
	--FROM FIT_NEW.dbo.tb_arquivosidigitalclass_temp_caminho
	--GO
	--SET IDENTITY_INSERT tb_arquivostempscaminhos OFF

----------------------------------------------------------
CREATE TABLE tb_servicelog(
	idservicelog int identity CONSTRAINT PK_servicelog PRIMARY KEY,
	desusuario varchar(200),
	dessala varchar(200),
	dtaula datetime,
	idprofessor int,
	idturma int,
	iddisciplina int,
	desvideo varchar(200),
	desvideosize int,
	descaminho varchar(500),
	deslog varchar(2000)
)

ALTER TABLE tb_servicelog ADD
dtcadastro datetime CONSTRAINT DF_servicelog_dtcadastro DEFAULT (getdate())
--

SELECT * FROM tb_servicelog
----------------------------------------------------------
----------------------------------------------------------
----------------------------------------------------------
------------------------ PROCEDURES ----------------------
----------------------------------------------------------
----------------------------------------------------------
ALTER PROC sp_arquivos_get
(@idarquivo int)
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
      SELECT
            idarquivo,
            desarquivo,
            nrtamanho,
            idarquivotipo,
            descaminho,
            instatus,
			incopiado,
			desarquivoold,
            dtcadastro
      FROM tb_arquivos
      WHERE idarquivo = @idarquivo
END

-- CHANGES 
	sp_arquivosidigitalclass_get -> sp_arquivos_get
-- ADDS
	incopiado
	
sp_arquivos_get 63
-----------------------------------------------------------
ALTER PROC sp_arquivos_list
(
      @idaula int,
      @idturma int = null,
      @iddisciplina int = null,
      @dtaula datetime = null,
	  @idarquivotipo int = null
)
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
      IF @idaula = 0
      BEGIN
      
            SELECT 
                  a.idarquivo,
                  a.desarquivo, 
                  a.nrtamanho,
                  a.idarquivotipo,
                  b.desarquivotipo,
                  a.descaminho,
                  a.instatus,
				  a.incopiado,
				  a.desarquivoold,
                  a.dtcadastro,
                  'new' as desorigem
            FROM tb_arquivos a
            INNER JOIN tb_arquivostipos b ON b.idarquivotipo = a.idarquivotipo
            INNER JOIN tb_aulasarquivos c ON c.idarquivo = a.idarquivo
            INNER JOIN tb_aulas d ON d.idaula = c.idaula
            WHERE
                  d.idcodturma = @idturma AND
                  d.idcoddisciplina = @iddisciplina AND
                  d.dtaula = @dtaula AND
                  a.idarquivotipo = @idarquivotipo AND 
                  a.instatus = 1
            ORDER BY a.dtcadastro
      
      END
      ELSE
      BEGIN
      
            SELECT 
                  a.idarquivo,
                  a.desarquivo, 
                  a.nrtamanho,
                  a.idarquivotipo,
                  b.desarquivotipo,
                  a.descaminho,
                  a.instatus,
				  a.incopiado,
				  a.desarquivoold,
                  a.dtcadastro,
                  'new' as desorigem
            FROM tb_arquivos a
            INNER JOIN tb_arquivostipos b ON b.idarquivotipo = a.idarquivotipo
            INNER JOIN tb_aulasarquivos c ON c.idarquivo = a.idarquivo
            INNER JOIN tb_aulas d ON d.idaula = c.idaula
            WHERE
                  c.idaula = @idaula AND
                  a.idarquivotipo = @idarquivotipo AND 
                  a.instatus = 1
            ORDER BY a.dtcadastro
      END
END 
--
sp_arquivos_list 153, null, null, null, 1

-- CHANGES
	sp_arquivosidigitalclasspreaula_list -> sp_arquivos_list

-- ADDS
	COLUMN incopiado
	PARAMETER idarquivotipo
	
-- Comments:
	Alterar na classe idigitalclassArquivos as procedures 
	sp_arquivosidigitalclasspreaula_list e sp_arquivosidigitalclassvideo_list para
	sp_arquivos_list passando parametro "1" para "Pré-Aula" e "2" para "Vídeos"

-----------------------------------------------------------
ALTER PROC sp_arquivos_save
(
      @idarquivo int,
      @desarquivo varchar(300),
      @nrtamanho int,
      @idarquivotipo int,
      @descaminho varchar(300),
      @desarquivoold varchar(300),
      @instatus bit
)
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
      
      SET NOCOUNT ON
      
      IF EXISTS(
            SELECT idarquivo FROM tb_arquivos
            WHERE idarquivo = @idarquivo
      )
      BEGIN
            UPDATE tb_arquivos
            SET
                  desarquivo = @desarquivo,
                  nrtamanho = @nrtamanho,
                  idarquivotipo = @idarquivotipo,
                  descaminho = @descaminho,
                  desarquivoold = @desarquivoold,
                  instatus = @instatus
            WHERE idarquivo = @idarquivo
            
            SET NOCOUNT OFF
            
            SELECT @idarquivo as idarquivo
      
      END
      ELSE IF @idarquivo = 0
      BEGIN
      
		IF EXISTS(
			SELECT	
				idarquivotipo 
			FROM tb_arquivos
			WHERE 
				desarquivo = @desarquivo AND
				nrtamanho = @nrtamanho AND 
				idarquivotipo = @idarquivotipo AND
				descaminho = @descaminho
		)
		BEGIN
			UPDATE tb_arquivos
            SET
                  desarquivo = @desarquivo,
                  nrtamanho = @nrtamanho,
                  idarquivotipo = @idarquivotipo,
                  descaminho = @descaminho,
                  desarquivoold = @desarquivoold,
                  instatus = @instatus,
                  incopiado = 0
            WHERE 
				desarquivo = @desarquivo AND
				nrtamanho = @nrtamanho AND 
				idarquivotipo = @idarquivotipo AND
				descaminho = @descaminho
            
            SET NOCOUNT OFF
            
            SELECT TOP 1
				idarquivo	
            FROM tb_arquivos
			WHERE 
				desarquivo = @desarquivo AND
				nrtamanho = @nrtamanho AND 
				idarquivotipo = @idarquivotipo AND
				descaminho = @descaminho
            
		END
		ELSE
		BEGIN
			INSERT INTO tb_arquivos
			(
				  desarquivo,
				  nrtamanho,
				  idarquivotipo,
				  descaminho,
				  desarquivoold,
				  instatus
			)VALUES(
				  @desarquivo,
				  @nrtamanho,
				  @idarquivotipo,
				  @descaminho,
				  @desarquivoold,
				  @instatus
			)

			SET NOCOUNT OFF

			SELECT SCOPE_IDENTITY() as idarquivo
	      
		END
	END		 
END

-- CHANGES
	sp_arquivosidigitalclass_save -> sp_arquivos_save


SELECt * FROM tb_arquivos


-----------------------------------------------------------
ALTER PROC sp_arquivos_delete
(@idaula int, @idsarquivo int)
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
      DELETE tb_aulasarquivos
      WHERE 
            idaula = @idaula AND 
            idarquivo in(
                  SELECT id FROM Simpac..fnSplit(REPLACE(@idsarquivo, ' ', ''), ',')
            )
            
      DELETE tb_arquivos
      WHERE 
            idarquivo in(
                  SELECT id FROM Simpac..fnSplit(REPLACE(@idsarquivo, ' ', ''), ',')
            )
END

-- CHANGES
	sp_arquivosidigitalclass_remove -> sp_arquivos_delete
	
-----------------------------------------------------------
ALTER PROC sp_aulas_get
(@idaula int)
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
      SELECT 
            idaula,
            idcodfisica,
            idcodturma,
            idcoddisciplina,
            desdescricao,
            dtaula,
            instatus,
            dtcadastro
      FROM tb_aulas
      WHERE idaula = @idaula
END

-- CHANGES
	sp_idigitalclassaula_get -> sp_aulas_get
-----------------------------------------------------------
ALTER PROC sp_aulasbyperiodo_list
(
      @idcodperiodo int = NULL,
      @data_de datetime,
      @data_ate datetime,
      @idcodprofessor int = NULL
)
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
      -- QUERY PARA AREA DO PROFESSOR ------------------------
      IF @idcodprofessor IS NOT NULL AND @idcodprofessor <> 0
      BEGIN
            -- BUSCA PELO PERIODO
            IF @idcodperiodo IS NOT NULL AND @idcodperiodo <> 0
            BEGIN
                  SELECT DISTINCT
                        a.idaula,
                        a.idcodfisica,
                        b.NOME as desprofessor,
                        c.CURSO as idcurso,
                        e.NOME as descurso,
                        a.idcodturma,
                        c.NOME as desturma,
                        a.idcoddisciplina,
                        d.NOME as desdisciplina,
                        a.desdescricao,
                        a.dtaula,
                        a.instatus,
                        a.dtcadastro,
                        'new' as desorigem
                  FROM tb_aulas a
                  INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA b ON b.CODIGO = a.idcodfisica
                  INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = a.idcodturma
                  INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS d ON d.CODIGO = a.idcoddisciplina
                  INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS e ON e.PRODUTO = c.CURSO
                  WHERE 
                        c.PERIODO = @idcodperiodo AND
                        a.dtaula BETWEEN @data_de AND @data_ate AND
                        a.idcodfisica = @idcodprofessor AND
                        a.instatus = 1 
                  ORDER BY a.dtaula DESC
            END
            -- BUSCA PELAS DATAS
            ELSE
            BEGIN
                  SELECT DISTINCT
                        a.idaula,
                        a.idcodfisica,
                        b.NOME as desprofessor,
                        c.CURSO as idcurso,
                        e.NOME as descurso,
                        a.idcodturma,
                        c.NOME as desturma,
                        a.idcoddisciplina,
                        d.NOME as desdisciplina,
                        a.desdescricao,
                        a.dtaula,
                        a.instatus,
                        a.dtcadastro,
                        'new' as desorigem
                  FROM tb_aulas a
                  INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA b ON b.CODIGO = a.idcodfisica
                  INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = a.idcodturma
                  INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS d ON d.CODIGO = a.idcoddisciplina
                  INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS e ON e.PRODUTO = c.CURSO
                  WHERE 
                        a.dtaula BETWEEN @data_de AND @data_ate AND
                        a.idcodfisica = @idcodprofessor AND
                        a.instatus = 1 
                  ORDER BY a.dtaula DESC
            END
      END
      -- QUERY PARA AREA DO ALUNO
      ELSE
      BEGIN
            -- BUSCA PELO PERIODO
            IF @idcodperiodo IS NOT NULL AND @idcodperiodo <> 0
            BEGIN
                  SELECT DISTINCT
                        a.idaula,
                        a.idcodfisica,
                        b.NOME as desprofessor,
                        c.CURSO as idcurso,
                        e.NOME as descurso,
                        a.idcodturma,
                        c.NOME as desturma,
                        a.idcoddisciplina,
                        d.NOME as desdisciplina,
                        a.desdescricao,
                        a.dtaula,
                        a.instatus,
                        a.dtcadastro,
                        'new' as desorigem
                  FROM tb_aulas a
                  INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA b ON b.CODIGO = a.idcodfisica
                  INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = a.idcodturma
                  INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS d ON d.CODIGO = a.idcoddisciplina
                  INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS e ON e.PRODUTO = c.CURSO
                  WHERE 
                        c.PERIODO = @idcodperiodo AND
                        a.dtaula BETWEEN @data_de AND @data_ate AND
                        a.instatus = 1 
                  ORDER BY a.dtaula DESC
            END
            -- BUSCA PELAS DATAS
            ELSE
            BEGIN
                  SELECT DISTINCT
                        a.idaula,
                        a.idcodfisica,
                        b.NOME as desprofessor,
                        c.CURSO as idcurso,
                        e.NOME as descurso,
                        a.idcodturma,
                        c.NOME as desturma,
                        a.idcoddisciplina,
                        d.NOME as desdisciplina,
                        a.desdescricao,
                        a.dtaula,
                        a.instatus,
                        a.dtcadastro,
                        'new' as desorigem
                  FROM tb_aulas a
                  INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA b ON b.CODIGO = a.idcodfisica
                  INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = a.idcodturma
                  INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS d ON d.CODIGO = a.idcoddisciplina
                  INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS e ON e.PRODUTO = c.CURSO
                  WHERE 
                        a.dtaula BETWEEN @data_de AND @data_ate AND
                        a.instatus = 1 
                  ORDER BY a.dtaula DESC
            END
      END
END

-- CHANGES
	sp_idigitalclassbyperiodo_list -> sp_aulasbyperiodo_list
-----------------------------------------------------------
ALTER PROC sp_aulasbydisciplina_list
(
      @idcoddisciplina int = NULL,
      @idcodturma int,
      @data_de datetime,
      @data_ate datetime,
      @idcodprofessor int = NULL
)
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
      -- QUERY PARA AREA DO PROFESSOR ------------------------------
      IF @idcodprofessor IS NOT NULL AND @idcodprofessor <> 0
      BEGIN
            -- BUSCA PELA DISCIPLINA 
            IF @idcoddisciplina IS NOT NULL AND @idcoddisciplina <> 0
            BEGIN
                  SELECT DISTINCT
                        a.idaula,
                        a.idcodfisica,
                        b.NOME as desprofessor,
                        c.CURSO as idcurso,
                        e.NOME as descurso,
                        a.idcodturma,
                        c.NOME as desturma,
                        a.idcoddisciplina,
                        d.NOME as desdisciplina,
                        a.desdescricao,
                        a.dtaula,
                        a.instatus,
                        a.dtcadastro,
                        'new' as desorigem
                  FROM tb_aulas a
                  INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA b ON b.CODIGO = a.idcodfisica
                  INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = a.idcodturma
                  INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS d ON d.CODIGO = a.idcoddisciplina
                  INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS e ON e.PRODUTO = c.CURSO
                  WHERE 
                        a.idcoddisciplina = @idcoddisciplina AND
                        a.idcodturma = @idcodturma AND
                        a.dtaula BETWEEN @data_de AND @data_ate AND
                        a.idcodfisica = @idcodprofessor AND
                        a.instatus = 1 
                  ORDER BY a.dtaula DESC
            END
            -- BUSCA PELA TURMA
            ELSE
            BEGIN
                  SELECT DISTINCT
                        a.idaula,
                        a.idcodfisica,
                        b.NOME as desprofessor,
                        c.CURSO as idcurso,
                        e.NOME as descurso,
                        a.idcodturma,
                        c.NOME as desturma,
                        a.idcoddisciplina,
                        d.NOME as desdisciplina,
                        a.desdescricao,
                        a.dtaula,
                        a.instatus,
                        a.dtcadastro,
                        'new' as desorigem
                  FROM tb_aulas a
                  INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA b ON b.CODIGO = a.idcodfisica
                  INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = a.idcodturma
                  INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS d ON d.CODIGO = a.idcoddisciplina
                  INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS e ON e.PRODUTO = c.CURSO
                  WHERE 
                        a.idcodturma = @idcodturma AND
                        a.dtaula BETWEEN @data_de AND @data_ate AND
                        a.idcodfisica = @idcodprofessor AND
                        a.instatus = 1 
                  ORDER BY a.dtaula DESC
            END
      END
      -- QUERY PARA AREA DO ALUNO ------------------------------
      ELSE
      BEGIN
            -- BUSCA PELA DISCIPLINA 
            IF @idcoddisciplina IS NOT NULL AND @idcoddisciplina <> 0
            BEGIN
                  SELECT DISTINCT
                        a.idaula,
                        a.idcodfisica,
                        b.NOME as desprofessor,
                        c.CURSO as idcurso,
                        e.NOME as descurso,
                        a.idcodturma,
                        c.NOME as desturma,
                        a.idcoddisciplina,
                        d.NOME as desdisciplina,
                        a.desdescricao,
                        a.dtaula,
                        a.instatus,
                        a.dtcadastro,
                        'new' as desorigem
                  FROM tb_aulas a
                  INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA b ON b.CODIGO = a.idcodfisica
                  INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = a.idcodturma
                  INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS d ON d.CODIGO = a.idcoddisciplina
                  INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS e ON e.PRODUTO = c.CURSO
                  WHERE 
                        a.idcoddisciplina = @idcoddisciplina AND
                        a.idcodturma = @idcodturma AND
                        a.dtaula BETWEEN @data_de AND @data_ate AND
                        a.instatus = 1 
                  ORDER BY a.dtaula DESC
            END
            -- BUSCA PELA TURMA
            ELSE
            BEGIN
                  SELECT DISTINCT
                        a.idaula,
                        a.idcodfisica,
                        b.NOME as desprofessor,
                        c.CURSO as idcurso,
                        e.NOME as descurso,
                        a.idcodturma,
                        c.NOME as desturma,
                        a.idcoddisciplina,
                        d.NOME as desdisciplina,
                        a.desdescricao,
                        a.dtaula,
                        a.instatus,
                        a.dtcadastro,
                        'new' as desorigem
                  FROM tb_aulas a
                  INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA b ON b.CODIGO = a.idcodfisica
                  INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = a.idcodturma
                  INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS d ON d.CODIGO = a.idcoddisciplina
                  INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS e ON e.PRODUTO = c.CURSO
                  WHERE 
                        a.idcodturma = @idcodturma AND
                        a.dtaula BETWEEN @data_de AND @data_ate AND
                        a.instatus = 1
                  ORDER BY a.dtaula DESC
            END
      END
END

-- CHANGES
	sp_idigitalclassaulasbydisciplina_list -> sp_aulasbydisciplina_list
-----------------------------------------------------------
ALTER PROC sp_avaliacoesaulas_save
(@idaula int, @idaluno int, @nrnota int)
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
      SET NOCOUNT ON
      
      IF EXISTS(
            SELECT idavaliacao FROM tb_avaliacoesaulas
            WHERE idaula = @idaula AND idaluno = @idaluno
      )
      BEGIN
            UPDATE tb_avaliacoesaulas
            SET nrnota = @nrnota
            WHERE idaula = @idaula AND idaluno = @idaluno
            
            SET NOCOUNT OFF
            
            SELECT idavaliacao, '0' as innovo FROM tb_avaliacoesaulas
            WHERE idaula = @idaula AND idaluno = @idaluno 
            
      END
      ELSE
      BEGIN
            INSERT INTO tb_avaliacoesaulas
            (idaula, idaluno, nrnota)
            VALUES
            (@idaula, @idaluno, @nrnota)
            
            SET NOCOUNT OFF
            
            SELECT idavaliacao, '1' as innovo FROM tb_avaliacoesaulas
            WHERE idavaliacao = SCOPE_IDENTITY()
            
      END
END

-- CHANGES 
	sp_idigitalclassaulas_avaliacao_save -> sp_avaliacoesaulas_save
	
-----------------------------------------------------------
ALTER PROC sp_avaliacoesaulas_get
(@idaula int)
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
      SELECT AVG(nrnota) media, COUNT(*) nrrates FROM tb_avaliacoesaulas
      WHERE idaula = @idaula
      GROUP BY idaula
END

-- CHANGES 
	sp_idigitalclassaulas_avaliacao_get -> sp_avaliacoesaulas_get
-----------------------------------------------------------
ALTER PROC sp_aulasarquivos_add
(@idaula int, @idarquivo int)
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN

	IF NOT EXISTS(
		SELECT idaula 
		FROM tb_aulasarquivos
		WHERE idaula = @idaula AND idarquivo = @idarquivo
	)
	BEGIN
	
	
      INSERT INTO tb_aulasarquivos
      VALUES (@idaula, @idarquivo)
    END
END

-- CHANGES
	sp_idigitalclassaulaarquivo_add -> sp_aulasarquivos_add
-----------------------------------------------------------
ALTER PROC sp_aulas_save
(
      @idaula int,
      @idcodfisica int,
      @idcodturma int,
      @idcoddisciplina int,
      @desdescricao varchar(5000),
      @dtaula datetime,
      @instatus bit
)
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
      SET NOCOUNT ON
      
      IF EXISTS(
            SELECT 
                  idaula
            FROM tb_aulas 
            WHERE 
                  idaula = @idaula OR 
                  (
                        (
                             YEAR(dtaula) = YEAR(@dtaula) AND
                             MONTH(dtaula) = MONTH(@dtaula) AND
                             DAY(dtaula) = DAY(@dtaula) 
                        ) 
                        AND
                        idcodturma = @idcodturma AND
                        idcoddisciplina = @idcoddisciplina
                  )
      )
      BEGIN
      
            IF @desdescricao = ''
            BEGIN
                  SELECT 
                        @desdescricao = desdescricao
                  FROM tb_aulas 
                  WHERE 
                        idaula = @idaula OR 
                        (
                             (
                                   YEAR(dtaula) = YEAR(@dtaula) AND
                                   MONTH(dtaula) = MONTH(@dtaula) AND
                                   DAY(dtaula) = DAY(@dtaula) 
                             ) 
                             AND
                             idcodturma = @idcodturma AND
                             idcoddisciplina = @idcoddisciplina
                        )
            END
      
            UPDATE tb_aulas
            SET 
                  idcodfisica = @idcodfisica,
                  idcodturma = @idcodturma,
                  idcoddisciplina = @idcoddisciplina,
                  desdescricao = @desdescricao,
                  dtaula = @dtaula,
                  instatus = @instatus
            WHERE idaula = @idaula OR 
                  (
                        (
                             YEAR(dtaula) = YEAR(@dtaula) AND
                             MONTH(dtaula) = MONTH(@dtaula) AND
                             DAY(dtaula) = DAY(@dtaula) 
                        ) 
                        AND
                        idcodturma = @idcodturma AND
                        idcoddisciplina = @idcoddisciplina
                  )
            
            SET NOCOUNT OFF
            
            SELECT idaula FROM tb_aulas
            WHERE idaula = @idaula OR 
                  (
                        (
                             YEAR(dtaula) = YEAR(@dtaula) AND
                             MONTH(dtaula) = MONTH(@dtaula) AND
                             DAY(dtaula) = DAY(@dtaula) 
                        ) 
                        AND
                        idcodturma = @idcodturma AND
                        idcoddisciplina = @idcoddisciplina
                  )
      END
      ELSE
      BEGIN
            INSERT INTO tb_aulas
            (
                  idcodfisica,
                  idcodturma,
                  idcoddisciplina,
                  desdescricao,
                  dtaula,
                  instatus
            )VALUES(
                  @idcodfisica,
                  @idcodturma,
                  @idcoddisciplina,
                  @desdescricao,
                  @dtaula,
                  @instatus
            )
            
            SET NOCOUNT OFF
            
            SELECT SCOPE_IDENTITY() as idaula
            
      END   
END

-- CHANGES
	sp_idigitalclassaula_save -> sp_aulas_save

-----------------------------------------------------------
ALTER PROC sp_periodosdecursosbyidperiodosophia_get
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
            idperiodoidigitalclass 
      FROM tb_periodosdecursos
      WHERE 
            idperiodosophia = @idperiodosophia
END

-- CHANGES
	sp_periodoidigitalclassbysophia_get -> sp_periodosdecursosbyidperiodosophia_get
-----------------------------------------------------------
ALTER PROC sp_turmasbyidturmasophia_get
(@idturmasophia int)
AS
/*
  app: FIT
  url: inc/_class/idigitalClassAula.class.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
      SELECT DISTINCT
            idturmaidigitalclass 
      FROM tb_xmlteams
      WHERE
            idturmasophia = @idturmasophia
END

-- CHANGES 
	sp_turmaidigitalclassbysophia_get -> sp_turmasbyidturmasophia_get
	

-----------------------------------------------------------
ALTER PROC sp_disciplinasbyiddisciplinasophia_get
(@iddisciplinasophia int)
AS
/*
  app: FIT
  url: inc/_class/idigitalClassAula.class.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
      SELECT DISTINCT
            iddisciplinaidigitalclass
      FROM tb_xmldisciplines 
      WHERE
            iddisciplinasophia = @iddisciplinasophia
END

-- CHANGES
	sp_disciplinaidigitalclassbysophia_get -> sp_disciplinasbyiddisciplinasophia_get
-----------------------------------------------------------
ALTER PROC sp_periodossophiabyidperiodoidigitalclass_get
(@idperiodoidigitalclass int)
AS
/*
  app: FIT
  url: inc/_class/idigitalClassAula.class.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
      
      SELECT DISTINCT
            idperiodosophia 
      FROM tb_periodosdecursos
      WHERE 
            idperiodoidigitalclass = @idperiodoidigitalclass
END

-- CHANGES 
	sp_periodosophiabyidigitalclass_get -> sp_periodossophiabyidperiodoidigitalclass_get
-----------------------------------------------------------
ALTER PROC sp_turmassophiabyidturmaidigitalclass_get
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
		FROM tb_xmlteams a
		INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS b ON b.CODIGO = a.idturmasophia
		WHERE
			idturmaidigitalclass = @idturmaidigitalclass
	) = 2
	BEGIN
	
		SELECT DISTINCT TOP 1
			idturmasophia
		FROM tb_xmlteams a
		INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS b ON b.CODIGO = a.idturmasophia
		WHERE
			idturmaidigitalclass = @idturmaidigitalclass
	END
	-- SE A TURMA NÃO FOR PÓS GRADUAÇÃO
	ELSE
	BEGIN
	
		DECLARE @IDPERIODOSOPHIA int
	
		-- RECUPERA O IDPERIODO SOPHIA PELO IDPERIODO IDIGITALCLASS
		SET @IDPERIODOSOPHIA = (
			SELECT TOP 1
				idperiodosophia 
			FROM tb_periodosdecursos 
			WHERE
				idperiodoidigitalclass = @idperiodoidigitalclass
		)
		
		SELECT DISTINCT TOP 1
			idturmasophia
		FROM tb_xmlteams a
		INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS b ON b.CODIGO = a.idturmasophia
		WHERE
			idturmaidigitalclass = @idturmaidigitalclass AND
			b.PERIODO = @IDPERIODOSOPHIA
	END
END

-- CHANGES
	sp_turmasophiabyidigitalclass_get -> sp_turmassophiabyidturmaidigitalclass_get
-----------------------------------------------------------
ALTER PROC sp_disciplinassophiabyiddisciplinaidigitalclass_get
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
            iddisciplinasophia
      FROM tb_xmldisciplines 
      WHERE
            iddisciplinaidigitalclass = @iddisciplinaidigitalclass
END

-- CHANGES
	sp_disciplinasophiabyidigitalclass_get -> sp_disciplinassophiabyiddisciplinaidigitalclass_get

	
--------------------------------------------------------
ALTER PROC sp_timeexecutions_list
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
      FROM tb_timeexecutions a
      INNER JOIN SONATA.SOPHIA.SOPHIA.TURNOS b ON b.CODIGO = a.idturno
      ORDER BY a.idturno, a.nraula
END

-- CHANGES
	sp_idigitalclass_timeexecution_list -> sp_timeexecutions_list
--------------------------------------------------------
ALTER PROC sp_timeexecutions_edit
(@idtimeexecution int, @dtinicio time, @dttermino time )
AS
/*
  app: simpacweb
  url: /simpacweb/modulos/fit/idigitalclass/actions/json/edit_robot_time_execution.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN

      UPDATE tb_timeexecutions
      SET
            dtinicio = @dtinicio,
            dttermino = @dttermino
      WHERE idtimeexecution = @idtimeexecution
END

-- CHANGES
	sp_idigitalclass_timeexecution_edit -> sp_timeexecutions_edit
------------------------------------------------------------------------
ALTER PROC sp_arquivostemps_save
(
      @idarquivotemp int,
      @desprofessor varchar(300),
      @dessala varchar(50),
      @dtaula datetime,
      @instatus bit,
      @destemp varchar(256)
)
AS
/*
  app: simpacweb
  url: /simpacweb/modulos/fit/idigitalclass/actions/json/save_robot_time_execution.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
      SET NOCOUNT ON
      
      IF EXISTS(
            SELECT idarquivotemp FROM tb_arquivostemps
            WHERE idarquivotemp = @idarquivotemp
      )
      BEGIN
      
            UPDATE tb_arquivostemps
            SET
                  desprofessor = @desprofessor,
                  dessala = @dessala,
                  dtaula = @dtaula,
                  instatus = @instatus,
                  dtalterado = GETDATE(),
                  destemp = @destemp
            WHERE idarquivotemp = @idarquivotemp
            
            SET NOCOUNT OFF
            
            SELECT @idarquivotemp as idarquivotemp
      END
      ELSE
      BEGIN
            
            INSERT INTO tb_arquivostemps
            (
                  desprofessor,
                  dessala,
                  dtaula,
                  instatus,
                  destemp
            )VALUES(
                  @desprofessor,
                  @dessala,
                  @dtaula,
                  @instatus,
                  @destemp
            )
            
            SET NOCOUNT OFF
            
            SELECT SCOPE_IDENTITY() as idarquivotemp
            
      END
END

-- CHANGES
	sp_arquivosidigitalclass_temp_save -> sp_arquivostemps_save
	
------------------------------------------------------------------------
ALTER PROC sp_arquivostempscaminhos_list
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
      tb_arquivostempscaminhos a
      INNER JOIN SONATA.SOPHIA.SOPHIA.FUNCIONARIOS b ON b.COD_FUNC = a.idprofessor
      INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = a.idturma
      INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS d ON d.CODIGO = a.iddisciplina
      INNER JOIN SONATA.SOPHIA.SOPHIA.PERIODOS e ON e.CODIGO = c.PERIODO
      WHERE idarquivotemp = @idarquivotemp
END

-- CHANGES
	sp_aula_arquivosidigitalclass_temp_list -> sp_arquivostempscaminhos_list
------------------------------------------------------------------------
ALTER PROC sp_arquivostempsreprocessar_edit
(@idarquivotemp int)
AS
/*
  app: simpacweb
  url: /simpacweb/modulos/fit/idigitalclass/actions/json/reprocessar_arquivotemp.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
      
      UPDATE tb_arquivostemps
      SET
            instatus = 0
      WHERE idarquivotemp = @idarquivotemp
END

-- CHANGES
	sp_arquivosidigitalclass_temp_reprocessar -> sp_arquivostempsreprocessar_edit

------------------------------------------------------------------------
ALTER PROC sp_arquivostemp_list
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
                  FROM tb_arquivostempscaminhos b
                  WHERE
                        b.idarquivotemp = a.idarquivotemp
            ) as nrauladestino
      FROM tb_arquivostemps a
      ORDER BY 
            instatus, a.dtcadastro desc, dtaula desc,  dessala, desprofessor
END

-- CHANGES
	sp_arquivosidigitalclass_temp_list -> sp_arquivostemp_list
------------------------------------------------------------------------
ALTER PROC sp_arquivostempsativar_edit
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
      
      UPDATE tb_arquivostemps
      SET
            dtalterado = GETDATE()
      WHERE idarquivotemp = @idarquivotemp
      
      SET NOCOUNT OFF
      
      SELECT @idarquivotemp as idarquivotemp
END

-- CHANGES
	sp_arquivosidigitalclass_temp_activate -> sp_arquivostempsativar_edit
------------------------------------------------------------------------
ALTER PROC sp_arquivostemps_delete
(@idarquivotemp int)
AS
/*
  app: simpacweb
  url: /simpacweb/modulos/fit/idigitalclass/actions/json/edit_arquivosidigitalclass_temp.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
      DELETE tb_arquivostempscaminhos
      WHERE idarquivotemp = @idarquivotemp
END

-- CHANGES
	sp_arquivosidigitalclass_temp_remove -> sp_arquivostemps_delete
------------------------------------------------------------------------
ALTER PROC sp_arquivostemps_add
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
            REPLACE(CAST((SELECT NOME FROM SONATA.SOPHIA.SOPHIA.TURMAS WHERE CODIGO = @codturma) AS VARCHAR(20)), '/', '-')+'/'+
            CAST(@coddisciplina AS VARCHAR(10))+'/'+
            @dtaula
      
      INSERT INTO tb_arquivostempscaminhos 
      (idarquivotemp, descaminho, idprofessor, idturma, iddisciplina, dtaula)
      VALUES
      (@idarquivotemp, @descaminho, @codprofessor, @codturma, @coddisciplina, @dtaula)
END

-- CHANGES
	sp_arquivosidigitalclass_temp_add -> sp_arquivostemps_add
------------------------------------------------------------------------
ALTER PROC sp_xmlteams_add
(@idturmasophia int, @idturmaidigitalclass int)
AS
/*
  app: simpacweb
  url: /simpacweb/modulos/fit/idigitalclass/actions/json/update_robot_time_execution.php
  author: Massaharu
  date: 01/01/2015
  desc: Procedure que recebe as informações do XML do Idigital Class e salva na tabela que vincula 
            os dados do Idigital Class antigo com o novo
*/
BEGIN
      
      IF NOT EXISTS(
            SELECT * FROM tb_xmlteams
            WHERE idturmasophia = @idturmasophia AND idturmaidigitalclass = @idturmaidigitalclass
      )
      BEGIN
            
            INSERT INTO tb_xmlteams 
            (idturmasophia, idturmaidigitalclass)
            VALUES
            (@idturmasophia, @idturmaidigitalclass)

      END
END

-- CHANGES
	sp_xmlteam_idigitalclass_table_update -> sp_xmlteams_add
	
SELECT * FROM  tb_xmlteams	
-----------------------------------------------------------------------
CREATE PROC sp_xmldisciplines_add
(@iddisciplinasophia int, @iddisciplinaidigitalclass int)
AS
BEGIN
	
	IF NOT EXISTS(
		SELECT * FROM tb_xmldisciplines
		WHERE iddisciplinasophia = @iddisciplinasophia AND iddisciplinaidigitalclass = @iddisciplinaidigitalclass
	)
	BEGIN
	
		INSERT INTO tb_xmldisciplines
		(iddisciplinasophia, iddisciplinaidigitalclass)
		VALUES
		(@iddisciplinasophia, @iddisciplinaidigitalclass)
	END

END

-- CHANGES 
	sp_xmldiscipline_idigitalclass_table_update -> sp_xmldisciplines_add
	
SELECT * FROM tb_xmldisciplines	

-----------------------------------------------------------
ALTER PROC sp_arquivosbyincopiado_list 
(@idarquivotipo int, @incopiado int = NULL)
AS
/*
  app: FIT_NEW
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN

	IF @incopiado IS NULL
	BEGIN
		SELECT
			idarquivo,
			desarquivo,
			nrtamanho,
			idarquivotipo,
			descaminho,
			instatus,
			dtcadastro,
			incopiado
		FROM tb_arquivos
	END
	ELSE
	BEGIN
		SELECT
			idarquivo,
			desarquivo,
			nrtamanho,
			idarquivotipo,
			descaminho,
			instatus,
			dtcadastro,
			incopiado
		FROM tb_arquivos
		WHERE incopiado = @incopiado AND idarquivotipo = @idarquivotipo
	END
END

-- CHANGES
		sp_arquivosidigitalclass_list -> sp_arquivosbyincopiado_list
		
		
sp_arquivosbyincopiado_list 1, 0		

-----------------------------------------------------------
ALTER PROC sp_arquivosfila_get
(@idarquivotipo int)
AS
/*
  app: FIT_NEW
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN

	SELECT TOP 1
		a.idarquivo,
		desarquivo,
		nrtamanho,
		idarquivotipo,
		descaminho,
		instatus,
		dtcadastro,
		incopiado
	FROM tb_arquivos a
	INNER JOIN tb_aulasarquivos b ON b.idarquivo = a.idarquivo
	WHERE 
		idarquivotipo = @idarquivotipo AND 
		incopiado = 0
	ORDER BY a.dtcadastro DESC
END
--
SELECt * FROM tb_arquivos
sp_arquivosfila_get 1
-----------------------------------------------------------
CREATE PROC sp_arquivosincopiado_edit
(@idarquivo int, @incopiado int)
AS
/*
  app: FIT_NEW
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
	
	UPDATE tb_arquivos
	SET
		incopiado = @incopiado
	WHERE 
		idarquivo = @idarquivo
END		

-- CHANGES
	sp_arquivosidigitalclassincopiado -> sp_arquivosincopiado_edit
-----------------------------------------------------------------------
CREATE PROC sp_servicelog_add
(
	@desusuario	varchar(200),
	@dessala	varchar(200),
	@dtaula	datetime,
	@idprofessor	int,
	@idturma	int,
	@iddisciplina	int,
	@desvideo	varchar(500),
	@desvideosize	int,
	@descaminho	varchar(500),
	@deslog	varchar(2000)
)
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
	INSERT INTO tb_servicelog
	(
		desusuario,
		dessala,
		dtaula,
		idprofessor,
		idturma,
		iddisciplina,
		desvideo,
		desvideosize,
		descaminho,
		deslog
	)VALUES(
		@desusuario,
		@dessala,
		@dtaula,
		@idprofessor,
		@idturma,
		@iddisciplina,
		@desvideo,
		@desvideosize,
		@descaminho,
		@deslog
	)
END
-----------------------------------------------------------------------
CREATE PROC sp_aulabyidarquivo_list
(@idarquivo int)
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN

	SELECT 
		a.idaula,
		a.idcodfisica,
		a.idcodturma,
		a.idcoddisciplina,
		a.desdescricao,
		a.dtaula,
		a.instatus,
		a.dtcadastro 
	FROM tb_aulas a
	INNER JOIN tb_aulasarquivos b ON b.idaula = a.idaula
	INNER JOIN tb_arquivos c ON c.idarquivo = b.idarquivo
	WHERE b.idarquivo = @idarquivo
	
END
		
/*********************************************************************/
/****************** SERVIDOR -> SONATA *******************************/
/****************** USE SOPHIA ***************************************/
/*********************************************************************/
-----------------------------------------------------------------------
-------------------------- PROCEDURES ---------------------------------
-----------------------------------------------------------------------

ALTER PROC sp_sophiaaulabypostgree_get
(
	@iddisciplinaidigitalclass int,
	@idturmaidigitalclass int,
	@idperiodoidigitalclass int,
	@loginprofessor varchar(300),
	@DATA datetime
)
AS
/*
	app: IdigitalClass
	author: Massaharu
	date: 01/01/2015
	desc: Retorna as informações de professor e sala a partir do registro retornado
		pela query do postgre que retorna as informações da aula pelo nome do arquivo
*/
BEGIN

	DECLARE @IDDISCIPLINA INT, @DESDISCIPLINA VARCHAR(300)

	------------- SE FOR PóS GRADUAÇÃO -------------
	IF(
		SELECT DISTINCT a.CFG_ACAD FROM SONATA.SOPHIA.SOPHIA.TURMAS a
		INNER JOIN SATURN.idigitalclass.dbo.tb_xmlteams b ON b.idturmasophia = a.CODIGO
		WHERE b.idturmaidigitalclass = @idturmaidigitalclass
	) = 2
	BEGIN
	
		IF EXISTS(
			SELECT DISTINCT iddisciplinasophia FROM tb_xmldisciplines WHERE iddisciplinaidigitalclass = @iddisciplinaidigitalclass
		) AND EXISTS(
			SELECT CODIGO FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE CODEXT = @loginprofessor
		)
		BEGIN
		
			SELECT 
				@IDDISCIPLINA = CODIGO,
				@DESDISCIPLINA = NOME
			FROM SONATA.SOPHIA.SOPHIA.DISCIPLINAS
			WHERE
				CODIGO in(
					SELECT DISTINCT iddisciplinasophia FROM tb_xmldisciplines WHERE iddisciplinaidigitalclass = @iddisciplinaidigitalclass
				)

			SELECT 
				a.CODIGO AS TURMA,
				@IDDISCIPLINA AS DISCIPLINA,
				(SELECT b.APELIDO FROM SONATA.SOPHIA.SOPHIA.FISICA a INNER JOIN SONATA.SOPHIA.SOPHIA.FUNCIONARIOS b ON a.CODIGO = b.COD_FUNC  WHERE a.CODEXT = @loginprofessor) AS DESPROFESSOR,
				(SELECT CODIGO FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE CODEXT = @loginprofessor) AS CODPROFESSOR,
				REPLACE(b.DESCRICAO, '/', '-')+'/'+REPLACE(a.NOME, '/', '-')+'/'+CAST(@IDDISCIPLINA AS VARCHAR(100))+'/'+CAST(CAST(@DATA AS DATE) AS VARCHAR(10)) AS DESCAMINHO,
				@DATA AS DATA
			FROM SONATA.SOPHIA.SOPHIA.TURMAS a
			INNER JOIN SONATA.SOPHIA.SOPHIA.PERIODOS b ON b.CODIGO = a.PERIODO
			WHERE 
				a.CODIGO IN(
					SELECT DISTINCT idturmasophia FROM tb_xmlteams WHERE idturmaidigitalclass = @idturmaidigitalclass
				)
		END	
	END
	------------- SE FOR GRADUAÇÃO -------------
	ELSE
	BEGIN
	
		IF EXISTS(
			SELECT DISTINCT iddisciplinasophia FROM tb_xmldisciplines WHERE iddisciplinaidigitalclass = @iddisciplinaidigitalclass
		) AND EXISTS(
			SELECT CODIGO FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE CODEXT = @loginprofessor
		)
		BEGIN
	
			SELECT 
				@IDDISCIPLINA = CODIGO,
				@DESDISCIPLINA = NOME
			FROM SONATA.SOPHIA.SOPHIA.DISCIPLINAS
			WHERE
				CODIGO in(
					SELECT DISTINCT iddisciplinasophia FROM tb_xmldisciplines WHERE iddisciplinaidigitalclass = @iddisciplinaidigitalclass
				)

			SELECT 
				a.CODIGO AS TURMA,
				@IDDISCIPLINA AS DISCIPLINA,
				(SELECT b.APELIDO FROM SONATA.SOPHIA.SOPHIA.FISICA a INNER JOIN SONATA.SOPHIA.SOPHIA.FUNCIONARIOS b ON a.CODIGO = b.COD_FUNC  WHERE a.CODEXT = @loginprofessor) AS DESPROFESSOR,
				(SELECT CODIGO FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE CODEXT = @loginprofessor) AS CODPROFESSOR,
				REPLACE(b.DESCRICAO, '/', '-')+'/'+REPLACE(a.NOME, '/', '-')+'/'+CAST(@IDDISCIPLINA AS VARCHAR(100))+'/'+CAST(CAST(@DATA AS DATE) AS VARCHAR(10)) AS DESCAMINHO,
				@DATA AS DATA
			FROM SONATA.SOPHIA.SOPHIA.TURMAS a
			INNER JOIN SONATA.SOPHIA.SOPHIA.PERIODOS b ON b.CODIGO = a.PERIODO
			WHERE 
				a.CODIGO IN(
					SELECT DISTINCT idturmasophia FROM tb_xmlteams WHERE idturmaidigitalclass = @idturmaidigitalclass
				) AND 
				b.CODIGO IN(
					SELECT idperiodosophia FROM tb_periodosdecursos WHERE idperiodoidigitalclass = @idperiodoidigitalclass
				)
		END
	END
END	

DECLARE @IDDISCIPLINA INT, @DESDISCIPLINA  VARCHAR(200), @DATA DATETIME
SELECT * FROM SONATA.SOPHIA.SOPHIA.FUNCIONARIOS

SET @DATA = '2015-05-22 19:55:20'

sp_sophiaaulabypostgree_get
	@iddisciplinaidigitalclass = 1073,
	@idturmaidigitalclass = 147,
	@idperiodoidigitalclass = 10,
	@loginprofessor = 'Fernanda.Duarte',
	@DATA = '2015-05-21 22:09:00.737'	
	
	
SELECT * FROM tb_xmlteams WHERE idturmaidigitalclass = 269	
SELECt * FROM tb_xmldisciplines WHERE iddisciplinaidigitalclass = 990
SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE CODEXT = 'Fernanda.Duarte' 
------------------------------------------------------------------------
ALTER PROC sp_idigitalclass_roboinfobypostgreedata_get
(
	@iddisciplinaidigitalclass int,
	@idturmaidigitalclass int,
	@idperiodoidigitalclass int,
	@DATA datetime
)
AS
/*
	app: IdigitalClass
	author: Massaharu
	date: 01/01/2015
	desc: Retorna as informações de professor e sala a partir do registro retornado
		pela query do postgre que retorna as informações da aula pelo nome do arquivo
*/
BEGIN

	------------- SE FOR PóS GRADUAÇÃO -------------
	IF(
		SELECT DISTINCT a.CFG_ACAD FROM SONATA.SOPHIA.SOPHIA.TURMAS a
		INNER JOIN SATURN.idigitalclass.dbo.tb_xmlteams b ON b.idturmasophia = a.CODIGO
		WHERE b.idturmaidigitalclass = @idturmaidigitalclass
	) = 2
	BEGIN
	
		SELECT 
			k.APELIDO,
			i.DESCRICAO as DESSALA
		FROM SONATA.SOPHIA.SOPHIA.LISTA_CHAM a
		INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS b ON b.CODIGO  = a.TURMA
		INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS c ON c.CODIGO = a.DISCIPLINA
		INNER JOIN (
			SELECT DISTINCT * FROM SATURN.idigitalclass.dbo.tb_xmlteams
		) d ON d.idturmasophia = b.CODIGO
		INNER JOIN (
			SELECT DISTINCT * FROM SATURN.idigitalclass.dbo.tb_xmldisciplines
		) e ON e.iddisciplinasophia = c.CODIGO
		INNER JOIN SONATA.SOPHIA.SOPHIA.TURNOS g ON g.CODIGO = b.TURNO
		INNER JOIN SONATA.SOPHIA.SOPHIA.LISTA_CHAM_AULAS h ON h.LISTA = a.CODIGO
		LEFT JOIN SONATA.SOPHIA.SOPHIA.SALAS i ON i.CODIGO = a.SALA
		INNER JOIN SONATA.SOPHIA.SOPHIA.QC j ON j.TURMA = b.CODIGO AND j.DISCIPLINA = c.CODIGO
		INNER JOIN SONATA.SOPHIA.SOPHIA.FUNCIONARIOS k ON k.COD_FUNC = j.PROFESSOR
		WHERE 
			e.iddisciplinaidigitalclass = @iddisciplinaidigitalclass AND
			d.idturmaidigitalclass = @idturmaidigitalclass AND 
			CAST(a.DATA AS DATE) = CAST(@DATA AS DATE) AND
			CAST(@DATA AS TIME) 
				BETWEEN (SELECT dtinicio FROM dbo.fn_lista_cham_by_horario(g.CODIGO, h.AULA)) 
				AND (SELECT dttermino FROM dbo.fn_lista_cham_by_horario(g.CODIGO, h.AULA))
	END
	------------- SE FOR GRADUAÇÃO -------------
	ELSE
	BEGIN
		
		SELECT 
			k.APELIDO,
			i.DESCRICAO as DESSALA
		FROM SONATA.SOPHIA.SOPHIA.LISTA_CHAM a
		INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS b ON b.CODIGO  = a.TURMA
		INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS c ON c.CODIGO = a.DISCIPLINA
		INNER JOIN (
			SELECT DISTINCT * FROM SATURN.idigitalclass.dbo.tb_xmlteams
		) d ON d.idturmasophia = b.CODIGO
		INNER JOIN (
			SELECT DISTINCT * FROM SATURN.idigitalclass.dbo.tb_xmldisciplines
		) e ON e.iddisciplinasophia = c.CODIGO
		INNER JOIN (
			SELECT DISTINCT * FROM SATURN.idigitalclass.dbo.tb_periodosdecursos 
		) f ON f.idperiodosophia = b.PERIODO
		INNER JOIN SONATA.SOPHIA.SOPHIA.TURNOS g ON g.CODIGO = b.TURNO
		INNER JOIN SONATA.SOPHIA.SOPHIA.LISTA_CHAM_AULAS h ON h.LISTA = a.CODIGO
		LEFT JOIN SONATA.SOPHIA.SOPHIA.SALAS i ON i.CODIGO = a.SALA
		INNER JOIN SONATA.SOPHIA.SOPHIA.QC j ON j.TURMA = b.CODIGO AND j.DISCIPLINA = c.CODIGO
		INNER JOIN SONATA.SOPHIA.SOPHIA.FUNCIONARIOS k ON k.COD_FUNC = j.PROFESSOR
		WHERE 
			e.iddisciplinaidigitalclass = @iddisciplinaidigitalclass AND
			d.idturmaidigitalclass = @idturmaidigitalclass AND 
			f.idperiodoidigitalclass = @idperiodoidigitalclass AND
			CAST(a.DATA AS DATE) = CAST(@DATA AS DATE) AND
			CAST(@DATA AS TIME) 
				BETWEEN (SELECT dtinicio FROM dbo.fn_lista_cham_by_horario(g.CODIGO, h.AULA)) 
				AND (SELECT dttermino FROM dbo.fn_lista_cham_by_horario(g.CODIGO, h.AULA))
	END
END	

sp_idigitalclass_roboinfobypostgreedata_get
	@iddisciplinaidigitalclass = 247,
	@idturmaidigitalclass = 37,
	@idperiodoidigitalclass = 8,
	@DATA = '2014-02-11 20:54:33.158'
	

-- CHANGES 
	SATURN.FIT_NEW.dbo.tb_xmlteam_idigitalclass -> SATURN.idigitalclass.dbo.tb_xmlteams
	SATURN.FIT_NEW.dbo.tb_xmldiscipline_idigitalclass -> SATURN.idigitalclass.dbo.tb_xmldisciplines
	SATURN.FIT_NEW.dbo.tb_periododecurso_idigitalclass -> SATURN.idigitalclass.dbo.tb_periodosdecursos
	
	Campos e parâmetros
	
-- ADDS
	Condição IF para casos de Pós e Graduação
-----------------------------------------------------------------------
-------------------------- FUNCTIONS ----------------------------------
-----------------------------------------------------------------------

ALTER FUNCTION dbo.fn_lista_cham_by_horario
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
  desc: Função para retornar o range de execução de um determinado turno e aula no dia
*/
BEGIN
	
	INSERT INTO @idigitalclass_timeexecution
	SELECT idtimeexecution, idturno, nraula, dtinicio, dttermino 
	FROM saturn.idigitalclass.dbo.tb_timeexecutions
	WHERE 
		idturno = @CODTURNO AND nraula = @NRAULA
	
	RETURN 
END

SELECT * from dbo.fn_lista_cham_by_horario(7, 4)

-- CHANGES
	saturn.fit_new.dbo.tb_idigitalclass_timeexecution -> saturn.idigitalclass.dbo.tb_timeexecutions
-----------------------------------------------------------------------

UPDATE tb_arquivostemps
SET instatus =1
WHERE idarquivotemp = 103

SELECt * FROM tb_arquivostemps

SELECt * FROM tb_xmlteams WHERE idturmasophia = 2738
SELECT * FROM tb_xmldisciplines WHERE iddisciplinasophia = 400
SELECT * FROM tb_periodosdecursos


sp_arquivostempsfila_get

sp_arquivostempscaminhos_list 31

SELECT * FROM tb_arquivostemps WHERE idarquivotemp = 25

sp_arquivostempok_save 36


UPDATE tb_arquivostemps
SET destemp = 'C:\Sistemas\IdigitalClass\Service\videos\A001\1430432874177'
WHERE idarquivotemp = 25

SELECT * FROM SATURN.IDIGITALCLASS.dbo.tb_xmlteams where idturmasophia = 2738

SELECT * FROM tb_arquivostemps

sp_arquivostempscaminhos_list 82

SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS WHERE CODIGO = 2966
SELECT * FROM SONATA.SOPHIA.SOPHIA.DISCIPLINAS WHERE CODIGO = 1849
SELECT * FROM tb_arquivos WHERE descaminho like '%CDT - 3A%2015-05-27'
SELECT * FROM tb_aulas where idaula = 428
SELECT * FROM tb_aulasarquivos where idarquivo = 687

SELECT * FROM SONATA.SOPHIA.SOPHIA.DISCIPLINAS WHERE CODIGO = 37



SELECT * FROM tb_servicelog

sp_arquivosfila_get 1

sp_arquivos_get 313
sp_aulabyidarquivo_list 313

UPDATE tb_arquivos
SET incopiado = 0
WHERE idarquivo in (313)


sp_turmasbyidturmasophia_get 2738
sp_disciplinasbyiddisciplinasophia_get 699

SELECT * FROM tb_xmldisciplines where iddisciplinaidigitalclass = 853

exec SONATA.SOPHIA.dbo.sp_aula_by_arquivo_get 'profTeste', '2015-08-04 19:59:00', 'A001'

SELECT dtinicio FROM SONATA.SOPHIA.dbo.fn_lista_cham_by_horario(1, 2)


SELECT CODEXT FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE CODIGO = 27917
SELECT * FROM SONATA.SOPHIA.SOPHIA.SALAS
---------
---------

http://www.impacta.edu.br/professor/idigital-class/pre-aula/2015-2/CDT - 4A/6/2015-09-28/C# 2013 - Fundamentos.pdf
	
SELECt * FROM tb_xmldisciplines WHERE iddisciplinaidigitalclass = 149
SELECt * FROM tb_xmlteams WHERE idturmaidigitalclass = 43,
SELECt * FROM tb_periodosdecursos 

SELECT * FROM tb_aulas
SELECT * FROM tb_arquivos WHERE idarquivotipo = 2
SELECT * FROM tb_arquivos WHERE descaminho like '%WTC%'
 
SELECT * FROM tb_aulasarquivos WHERE idarquivo = 1017
SELECT * FROM tb_arquivostemps 
SELECT * FROM tb_arquivostempscaminhos 
SELECT * FROM tb_servicelog

SELECT * FROM FIT_NEW..tb_cursostipos
SELECT * FROM FIT_NEW..tb_cursos


sp_aulasbydisciplina_list 1194, 2570, '2015-08-02 00:00:00', '2015-12-23 23:59:59', 4002
sp_aulasbydisciplina_list  1194, 3169, '2015-08-02 00:00:00', '2015-12-23 23:59:59', 4002


sp_sophiaaulabypostgree_get
	@iddisciplinaidigitalclass = 1076,
	@idturmaidigitalclass = 11,
	@idperiodoidigitalclass = 13,
	@loginprofessor = '41348753820',
	@DATA = '2015-09-16 11:22:34.391'	
	
SELECT * FROM tb_xmlteams where idturmaidigitalclass = 11
SELECT * FROm SONATA.SOPHIA.SOPHIA.TURMAS WHERE CODIGO = 3169
SELECT * FROm SONATA.SOPHIA.SOPHIA.FISICA WHERE CODEXT = 'pai'
SELECT * FROM tb_xmldisciplines WHERE iddisciplinaidigitalclass = 1076
SELECT * FROM tb_xmldisciplines WHERE iddisciplinasophia = 87
SELECT * FROM SONATA.SOPHIA.SOPHIA.DISCIPLINAS WHERE cODIGO = 400
SELECT * FROM SONATA.SOPHIA.SOPHIA.DISCIPLINAS WHERE NOME LIKE '%comportamento organizacional%'

SELECT * FROM FIT_NEW..tb_turmapai

SONATA.SOPHIA.dbo.sp_disciplinas_list 125

SELECT a.*, b.NOME FROM saturn.idigitalclass.dbo.tb_xmldisciplines a
INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS b ON b.CODIGO = a.iddisciplinasophia
WHERE nome like '%aprendizagem%'


SELECt * FROM tb_xmlteams a
INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS b ON b.CODIGO = a.idturmasophia
WHERE b.NOME LIKE '%DP/%'

SELECt * FROM tb_xmlteams a
LEFT JOIN SONATA.SOPHIA.SOPHIA.TURMAS b ON b.CODIGO = a.idturmasophia
WHERE idturmasophia = 3765

SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS WHERE NOME LIKE '%5°ADS B%'

SELECT * FROM tb_arquivos
WHERE idarquivotipo = 1 AND nrtamanho < 2000000

SELECT * FROM SONATA.SOPHIA.SOPHIA.FUNCIONARIOS

SELECT DISTINCT 
	a.NOME, 
	CASE 
		WHEN a.FORMACONTATO1 = 2 THEN a.CONTATO1
		WHEN a.FORMACONTATO2 = 2 THEN a.CONTATO2
		WHEN a.FORMACONTATO3 = 2 THEN a.CONTATO3
	END
FROM SONATA.SOPHIA.SOPHIA.FISICA a
INNER JOIN SONATA.SOPHIA.SOPHIA.FUNCIONARIOS b ON b.COD_FUNC = a.CODIGO
INNER JOIN SONATA.SOPHIA.SOPHIA.QC c ON c.PROFESSOR = b.COD_FUNC
INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS d ON d.CODIGO = c.TURMA
WHERE b.LECIONA = 1 AND b.SITUACAO = 1 AND (CASE 
		WHEN a.FORMACONTATO1 = 2 THEN a.CONTATO1
		WHEN a.FORMACONTATO2 = 2 THEN a.CONTATO2
		WHEN a.FORMACONTATO3 = 2 THEN a.CONTATO3
	END) IS NOT NULL AND (CASE 
		WHEN a.FORMACONTATO1 = 2 THEN a.CONTATO1
		WHEN a.FORMACONTATO2 = 2 THEN a.CONTATO2
		WHEN a.FORMACONTATO3 = 2 THEN a.CONTATO3
	END) <> ''

SELECT *FROM SONATA.SOPHIA.SOPHIA.FUNCIONARIOS WHERE COD_FUNC = 5681