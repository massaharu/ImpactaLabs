USE FIT_NEW

DBCC CHECKIDENT ('tb_vestibular', RESEED,0); --Zera o identity
sp_vestibular_aprovados_list

select * from tb_vestibular
select * from tb_vestibular_datas
select * from tb_vestibular_reprovados
select * from tb_vestibular_aprovados
------------------------------------------------------------------------------
-------------------INSERT---------------------------------------------------------
ALTER PROC sp_vestibular_save
(@desvestibular varchar(100),@dtinicio datetime,@dttermino datetime)
AS
begin tran
INSERT INTO tb_vestibular(desvestibular)
VALUES(@desvestibular)

IF (scope_identity() is not null)
	BEGIN
		INSERT INTO tb_vestibular_datas(idvestibular,dtinicio,dttermino)
		VALUES(scope_identity(),@dtinicio,@dttermino)
	END

IF @@ERROR <> 0
	ROLLBACK TRAN
ELSE
	COMMIT TRAN

sp_vestibular_save 'Vestibular','2012-07-24','2012-12-12'
----------------------------------------------------------------------------
ALTER PROC [dbo].[sp_vestibular_aprovados_save]
(@idvestibular int,@desnome varchar(200),@descurso varchar(200),@desempresa varchar(200), @idaluno int)
AS
BEGIN
	INSERT INTO tb_vestibular_aprovados(idvestibular,desnome,descurso,desempresa)
	VALUES(@idvestibular,@desnome,@descurso,@desempresa)
	
	INSERT INTO tb_vestibular_aprovados_conc_cli VALUES(SCOPE_IDENTITY(), @idaluno)
END
--
sp_vestibular_aprovados_save 4,'Clécio da Silva Ribeiro','Sistemas da Informação','Toshiba'
------------------------------------------------------------------------------
ALTER PROC sp_vestibular_reprovados_save
(@idvestibular int,@desnome varchar(200),@descurso varchar(200),@desempresa varchar(200))
AS
INSERT INTO tb_vestibular_reprovados(idvestibular,desnome,descurso,desempresa)
VALUES(@idvestibular,@desnome,@descurso,@desempresa)

sp_vestibular_reprovados_save 1,'Julio Valezzi','Sistemas da Informação','Impacta'
------------------------------------------------------------------------------
----------UPDATE ISPRIMEIRO LUGAR------------------------------------------
ALTER PROC [dbo].[sp_vestibular_isprimeirolugar]
(@idvestibular_aprovados int,@idvestibular int )
AS
IF exists(Select * from tb_vestibular_aprovados 
where idvestibular = @idvestibular and isprimeirolugar = 1)
	begin 
		Update tb_vestibular_aprovados
		set isprimeirolugar = 0
		where idvestibular_aprovados = @idvestibular_aprovados and
			  idvestibular = @idvestibular
	end
else
	begin
		Update tb_vestibular_aprovados
		set isprimeirolugar = 1
		where idvestibular_aprovados = @idvestibular_aprovados and
			  idvestibular = @idvestibular
	end

sp_vestibular_isprimeirolugar 209,2

------------------UPDATE INSTATUS------------------------------------------
ALTER PROCEDURE sp_vestibular_instatus
(@idvestibular int)
AS
IF(SELECT instatus FROM tb_vestibular 
WHERE idvestibular = @idvestibular) = 0 
	BEGIN 
		UPDATE tb_vestibular
		SET instatus = 1
		WHERE idvestibular = @idvestibular
	END
ELSE
	BEGIN
		UPDATE tb_vestibular
		SET instatus = 0
		WHERE idvestibular = @idvestibular
	END
	
	sp_vestibular_instatus 1
----------------------------------------------------------------------------
CREATE PROC sp_alunoaprovado_instatus
(@idvestibular_aprovados int)
AS
IF(SELECT instatus FROM tb_vestibular_aprovados
WHERE idvestibular_aprovados = @idvestibular_aprovados) = 0
	BEGIN
		UPDATE tb_vestibular_aprovados
		SET instatus = 1
		WHERE idvestibular_aprovados = @idvestibular_aprovados
	END
ELSE
	BEGIN
		UPDATE tb_vestibular_aprovados
		SET instatus = 0
		WHERE idvestibular_aprovados = @idvestibular_aprovados
	END
----------------------------------------------------------------------------
CREATE PROC sp_alunoreprovado_instatus
(@idvestibular_reprovados int)
AS
IF(SELECT instatus FROM tb_vestibular_reprovados
WHERE idvestibular_reprovados = @idvestibular_reprovados) = 0
	BEGIN
		UPDATE tb_vestibular_reprovados
		SET instatus = 1
		WHERE idvestibular_reprovados = @idvestibular_reprovados
	END
ELSE
	BEGIN
		UPDATE tb_vestibular_reprovados
		SET instatus = 0
		WHERE idvestibular_reprovados = @idvestibular_reprovados
	END	
			
--------------UPDATE----------------------------------------------------
ALTER PROC sp_vestibular_update
(@idvestibular int,@desvestibular varchar(100),@dtinicio datetime,@dttermino datetime)
AS
UPDATE tb_vestibular
SET desvestibular = @desvestibular
WHERE idvestibular = @idvestibular
IF (@idvestibular is not null)
	BEGIN
		UPDATE tb_vestibular_datas
		SET dtinicio = @dtinicio,
			dttermino = @dttermino
		WHERE idvestibular = @idvestibular
	END
	
sp_vestibular_update 7,'Vestibular','2012-06-23','2012-12-01'
-------------------------------------------------------------------------
ALTER PROC sp_alunoaprovado_update
(@idvestibular int,@idvestibular_aprovados int,@desnome varchar(100),@descurso varchar(200),@desempresa varchar(100))
AS
BEGIN
	UPDATE tb_vestibular_aprovados
	SET desnome = @desnome,
		descurso = @descurso,
		desempresa = @desempresa
	WHERE idvestibular = @idvestibular AND
		idvestibular_aprovados = @idvestibular_aprovados
	
	UPDATE SONATA.SOPHIA.SOPHIA.FISICA
	SET NOME = @desnome
	WHERE CODIGO  = (
		SELECT
			FISICA 
		FROM tb_vestibular_aprovados_conc_cli
		WHERE idvestibular_aprovados = @idvestibular_aprovados
	)
	
END
--
SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE NOME = 'Ademar Vitor Pereira Mendess'
-------------------------------------------------------------------------	
CREATE PROC sp_alunoreprovado_update
(@idvestibular int,@idvestibular_reprovados int,@desnome varchar(100),@descurso varchar(200),@desempresa varchar(100))
AS
UPDATE tb_vestibular_reprovados
SET desnome = @desnome,
	descurso = @descurso,
	desempresa = @desempresa
WHERE idvestibular = @idvestibular AND
	idvestibular_reprovados = @idvestibular_reprovados	
	
	begin tran
	sp_alunoreprovado_update 26,16,'Roberta','Secretaria','Microsoft'
	commit tran

------------------------------------------------------------------------------
----------------DELETE--------------------------------------------------------
CREATE PROC sp_vestibular_delete
(@idvestibular int)
AS
DELETE tb_vestibular
WHERE idvestibular = @idvestibular

sp_vestibular_delete 23
------------------------------------------------------------------------------
ALTER PROC sp_vestibularaprovados_delete 
(@idvestibular_aprovados int)
AS
BEGIN
	DELETE tb_vestibular_aprovados_conc_cli 
	WHERE idvestibular_aprovados = @idvestibular_aprovados

	IF @@ERROR = 0
	BEGIN	
		DELETE tb_vestibular_aprovados
		WHERE idvestibular_aprovados = @idvestibular_aprovados
	END
END
--
SELECT * FROM tb_vestibular_aprovados_conc_cli
SELECT * FROM tb_vestibular_aprovados
------------------------------------------------------------------------------
CREATE PROC sp_vestibularreprovados_delete 
(@idvestibular_reprovados int)
AS
DELETE tb_vestibular_reprovados
WHERE idvestibular_reprovados = @idvestibular_reprovados

sp_vestibularreprovados_delete 15

------------------------------------------------------------------------------
--------------INSERTS-------------------------------------------------
--Salva descrição do vestibular, data de inicio, data de termino
sp_vestibular_save 'PROUNI','2012-01-01','2012-12-12'

--Modifica o instatus do aluno que ficou em primeiro lugar, idvestibular_aprovados e idvestibular
sp_vestibular_isprimeirolugar 210,7

--Salva os alunos aprovados

sp_vestibular_aprovados_save 7,'Leonardo Maziero de Siqueira','',''

--Salva os alunos reprovados
sp_vestibular_reprovados_save 1,'Julio Valezzi','Sistemas da Informação','Impacta'
------------------------------------------------------------------------------
------------------LISTS----------------------------------------------
ALTER PROC sp_vestibular_aprovados_list
AS
BEGIN
	SELECT 
		a.idvestibular,a.desvestibular,a.instatus,b.idvestibular,b.dtinicio,b.dttermino,
		c.idvestibular,c.desnome,c.descurso,c.dtcadastro,c.isprimeirolugar,c.desempresa,
		c.idvestibular_aprovados,c.instatus AS[alunoaprovado_instatus],
		ISNULL(e.NOME, c.desnome)  as nome_fisica
	FROM tb_vestibular a 
	INNER JOIN tb_vestibular_datas b on a.idvestibular = b.idvestibular
	INNER JOIN tb_vestibular_aprovados c on a.idvestibular = c.idvestibular
	LEFT JOIN tb_vestibular_aprovados_conc_cli d ON d.idvestibular_aprovados = c.idvestibular_aprovados
	LEFT JOIN SONATA.SOPHIA.SOPHIA.FISICA e ON e.CODIGO = d.fisica
	WHERE a.instatus = 1
	ORDER BY c.isprimeirolugar DESC,c.desnome
END
--

sp_vestibular_aprovados_list
--byinstatus
CREATE PROC sp_vestibular_aprovadosbyinstatus_list
AS
SELECT a.idvestibular,a.desvestibular,a.instatus,b.idvestibular,b.dtinicio,b.dttermino,c.idvestibular,c.desnome,c.descurso,c.dtcadastro,c.isprimeirolugar,c.desempresa,c.idvestibular_aprovados,c.instatus AS[alunoaprovado_instatus]
FROM tb_vestibular a
INNER JOIN tb_vestibular_datas b
on a.idvestibular = b.idvestibular
INNER JOIN tb_vestibular_aprovados c
on a.idvestibular = c.idvestibular
WHERE a.instatus = 1 AND c.instatus = 1
ORDER BY c.isprimeirolugar DESC,c.desnome
--------------------------------------------------------------------------
ALTER PROC sp_vestibular_reprovados_list
AS
SELECT a.idvestibular,a.desvestibular,a.instatus,b.idvestibular,b.dtinicio,b.dttermino,c.idvestibular,c.desnome,c.descurso,c.dtcadastro,c.desempresa,c.idvestibular_reprovados,c.instatus AS[alunoreprovado_instatus] 
FROM tb_vestibular a
INNER JOIN tb_vestibular_datas b
on a.idvestibular = b.idvestibular
INNER JOIN tb_vestibular_reprovados c
on a.idvestibular = c.idvestibular
WHERE a.instatus = 1
ORDER BY c.desnome

sp_vestibular_reprovados_list
--byinstatus

----------------------------------------------------------------------------
CREATE PROC sp_vestibularbyinstatus_list
AS
SELECT a.idvestibular,a.desvestibular,a.instatus,a.dtcadasdtro,b.idvestibular,b.dtinicio,b.dttermino FROM tb_vestibular a
INNER JOIN tb_vestibular_datas b
on a.idvestibular = b.idvestibular
WHERE instatus = 1
ORDER BY b.dtinicio DESC

SELECT * FROM tb_vestibular
--------------------------byinstatus-----------------------------------------
ALTER PROC sp_vestibular_list
AS
SELECT a.idvestibular,a.desvestibular,a.instatus,a.dtcadasdtro,b.idvestibular,b.dtinicio,b.dttermino FROM tb_vestibular a
INNER JOIN tb_vestibular_datas b
on a.idvestibular = b.idvestibular
ORDER BY b.dtinicio DESC
------------------------------------------------------------------
CREATE PROC sp_vestibulardatas_list
AS
SELECT *from tb_vestibular_datas

sp_vestibulardatas_list
------------------------------------------------------------------
------------------------ TABLE -----------------------------------
------------------------------------------------------------------
CREATE TABLE tb_vestibular_aprovados_conc_cli(
	idvestibular_aprovados int,
	fisica int,
	
	CONSTRAINT FK_vestibular_aprovados_conc_cli_vestibular_aprovados_idvestibular_aprovados FOREIGN KEY(idvestibular_aprovados) 
	REFERENCES tb_vestibular_aprovados (idvestibular_aprovados)
)
------------------------------------------------------------------
------------------------ PROCS -----------------------------------
------------------------------------------------------------------
ALTER PROC sp_alunoaprovadobyvestibularsophia_list
(@idvestibular int)
AS
BEGIN
	SELECT 
		c.CODIGO as idaluno,
		c.NOME as desaluno
	FROM SONATA.SOPHIA.SOPHIA.CONC_CLI a
	INNER JOIN SONATA.SOPHIA.SOPHIA.CONCURSOS b ON b.CODIGO = a.CONCURSO
	INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA c ON c.CODIGO = a.FISICA
	INNER JOIN tb_vestibular_sophia_concurso d ON d.codigo = b.CODIGO
	INNER JOIN tb_vestibular e ON e.idvestibular = d.idvestibular
	LEFT JOIn tb_vestibular_aprovados_conc_cli f ON f.fisica = c.CODIGO
	WHERE d.idvestibular = @idvestibular AND f.fisica IS NULL
	ORDER BY c.NOME
END
--
sp_alunoaprovadobyvestibularsophia_list 143
SELECT * FROM tb_vestibular_aprovados_conc_cli
------------------------------------------------------------------

--
SELECT * FROM Impacta4..tb_ecommerceCliente
SELECT * FROM tb_usuario
SELECT * FROM FIT_NEW..tb_vestibular_aprovados
SELECT * FROM FIT_NEW..tb_vestibular
SELECT * FROM tb_vestibular_sophia_concurso

SELECT * FROM FIT_NEW..tb_vestibular_sophia_concurso
WHERE desvestibular like '%Vestibular 2o Semestre/2014%'

SELECT * FROM SONATA.SOPHIA.SOPHIA.CONCURSOS
SELECT * FROM SONATA.SOPHIA.SOPHIA.CONC_CLI WHERE CONCURSO = 194
SELECT EMPRESA, * FROM SONATA.SOPHIA.SOPHIA.FISICA 
 
--EXCEL-------
=CONCATENAR("sp_vestibular_aprovados_save 2,'";B2;"'";",";"'";C2;"'")

















