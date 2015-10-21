USE SIMPAC; exec sp_usuarioAtivos_list;
USE FIT_NEW; exec sp_cursos_list
----------------------------------------------------------------------
-------------------- TABELAS ------------------------------------------
----------------------------------------------------------------------
CREATE TABLE tb_semestres(
	idsemestre int identity not null CONSTRAINT PK_semestres PRIMARY KEY(idsemestre),
	nrsemestre	int not null,
	dessemestre	varchar(50) not null,
	instatus	bit CONSTRAINT DF_semestres_instatus DEFAULT(1),
	dtcadastro	datetime CONSTRAINT DF_semestres_dtcadastro DEFAULT(getdate())
)

INSERT tb_semestres
(nrsemestre, dessemestre)
VALUES
(1, 'Primeiro'),
(2, 'Segundo'),
(3, 'Terceiro'),
(4, 'Quarto'),
(5, 'Quinto'),
(6, 'Sexto'),
(7, 'Sétimo'),
(8, 'Oitavo')

SELECT *FROM tb_semestres
----------------------------------------------------------------------
CREATE TABLE tb_dependente_tipo(
	iddependentetipo int not null identity CONSTRAINT PK_dependente_tipo PRIMARY KEY(iddependentetipo),
	desdependentetipo varchar(50) not null,
	instatus	bit CONSTRAINT DF_dependente_tipo_instatus DEFAULT(1),
	dtcadastro	datetime CONSTRAINT DF_dependente_tipo_dtcadastro DEFAULT(getdate())
)

INSERT tb_dependente_tipo
(desdependentetipo)
VALUES
('Cônjuge'),
('Filho(a)'),
('Pai'),
('Mãe')

SELECT *FROM tb_dependente_tipo

----------------------------------------------------------------------
CREATE TABLE tb_solicitacaobolsaestudostipo(
	idsolicitacaobolsaestudostipo int not null identity CONSTRAINT PK_solicitacaobolsaestudostipo PRIMARY KEY(idsolicitacaobolsaestudostipo),
	dessolicitacaobolsaestudostipo varchar(50) not null,
	instatus	bit CONSTRAINT DF_solicitacaobolsaestudostipo_instatus DEFAULT(1),
	dtcadastro	datetime CONSTRAINT DF_solicitacaobolsaestudostipo_dtcadastro DEFAULT(getdate())
)

INSERT tb_solicitacaobolsaestudostipo
(dessolicitacaobolsaestudostipo )
VALUES
('Titular'),
('Dependente')

SELECT *FROM tb_solicitacaobolsaestudostipo
----------------------------------------------------------------------
CREATE TABLE tb_solicitacaobolsaestudospermissao(
	idpermissao int not null identity CONSTRAINT PK_solicitacaobolsaestudospermissao PRIMARY KEY(idpermissao),
	despermissao varchar(50) not null,
	instatus	bit CONSTRAINT DF_solicitacaobolsaestudospermissao_instatus DEFAULT(1),
	dtcadastro	datetime CONSTRAINT DF_solicitacaobolsaestudospermissao_dtcadastro DEFAULT(getdate())
)

INSERT tb_solicitacaobolsaestudospermissao
(despermissao)
VALUES
('Gestor'),('RH'),('Diretoria')

SELECT *FROM tb_solicitacaobolsaestudospermissao
----------------------------------------------------------------------
CREATE TABLE tb_solicitacaobolsaestudos(
	idsolicitacaobolsaestudo int not null identity CONSTRAINT PK_solicitacaobolsaestudo PRIMARY KEY(idsolicitacaobolsaestudo),
	idusuario	int,
	idsolicitacaobolsaestudostipo int not null,
	curso_id int not null,
	idsemestre int,
	iddependentetipo int,
	desnomedependente varchar(100),
	dtnascimentodependente datetime,
	nrcpfdependente char(11),
	desemaildependente varchar(100),
	desjustificativa varchar(max),
	instatus	bit CONSTRAINT DF_solicitacaobolsaestudos_instatus DEFAULT(1),
	dtcadastro	datetime CONSTRAINT DF_solicitacaobolsaestudos_dtcadastro DEFAULT(getdate())	
	
	CONSTRAINT FK_solicitacaobolsaestudos_solicitacaobolsaestudostipo_idsolicitacaobolsaestudostipo FOREIGN KEY(idsolicitacaobolsaestudostipo)
	REFERENCES tb_solicitacaobolsaestudostipo(idsolicitacaobolsaestudostipo),
	CONSTRAINT FK_solicitacaobolsaestudos_dependente_tipo_iddependentetipo FOREIGN KEY(iddependentetipo)
	REFERENCES tb_dependente_tipo(iddependentetipo),
	CONSTRAINT FK_solicitacaobolsaestudos_cursos_curso_id FOREIGN KEY(curso_id)
	REFERENCES tb_cursos(curso_id),
	CONSTRAINT FK_solicitacaobolsaestudos_semestres_idsemestre FOREIGN KEY(idsemestre)
	REFERENCES tb_semestres(idsemestre)
)

SELECT *FROM tb_solicitacaobolsaestudos where idusuario = 1501
----------------------------------------------------------------------
CREATE TABLE tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao(
	idpermissao	int not null,
	idsolicitacaobolsaestudo int not null,
	idgestor	int not null,
	desmotivo	varchar(max),
	nrpercentual int,
	instatus	bit CONSTRAINT DF_solicitacaobolsaestudos_solicitacaobolsaestudospermissao_instatus DEFAULT(1),
	dtcadastro	datetime CONSTRAINT DF_solicitacaobolsaestudos_solicitacaobolsaestudospermissao_dtcadastro DEFAULT(getdate())	
	
	CONSTRAINT PK_solicitacaobolsaestudos_solicitacaobolsaestudospermissao_idpermissao_idsolicitacaobolsaestudo PRIMARY KEY(idpermissao, idsolicitacaobolsaestudo)
	CONSTRAINT FK_solicitacaobolsaestudos_solicitacaobolsaestudospermissao_idpermissao FOREIGN KEY(idpermissao)
	REFERENCES tb_solicitacaobolsaestudospermissao(idpermissao),
	CONSTRAINT FK_solicitacaobolsaestudos_solicitacaobolsaestudospermissao_solicitacaobolsaestudos FOREIGN KEY(idsolicitacaobolsaestudo)
	REFERENCES tb_solicitacaobolsaestudos(idsolicitacaobolsaestudo)	
)

SELECT *FROM tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao where idsolicitacaobolsaestudo = 76

select *from simpac..tb_usuario where nmcompleto like '%genilda%'
select * from tb_cursos
sp_solicitacaobolsaestudosaprovados_list 1495
-- DROP TABLES
DROP TABLE tb_solicitacaobolsaestudostipo
DROP TABLE _tb_solicitacaobolsaestudos
DROP TABLE tb_solicitacaobolsaestudospermissao
DROP TABLE _tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao
-------------------------------------------------------------------------
-------------------------- FUNCTIONS ------------------------------------
---------------------------------------------------------------------------
CREATE function fnSolicitacaoBolsaEstudosStatus
(@idsolicitacaobolsaestudo int, @idpermissao int)
returns smallint
as
/*
app: SimpacWeb
data: 2013-02-21
author: Massa
*/
begin
	declare @instatus smallint = null
	select @instatus = instatus from tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao 
	where idpermissao = @idpermissao and idsolicitacaobolsaestudo = @idsolicitacaobolsaestudo
	if isnumeric(@instatus) != 1
		set @instatus = 2	
	return @instatus
end

select dbo.fnSolicitacaoBolsaEstudosStatus(3, 76)
---------------------------------------------------------------------------
CREATE function fnSolicitacaoAprovacaoGestor(@idsolicitacaobolsaestudo int, @idpermissao int)
returns int
as
begin
	declare @idgestor int = null
	Select @idgestor = idgestor From tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao 
	where idsolicitacaobolsaestudo = @idsolicitacaobolsaestudo and idpermissao = @idpermissao

	Return @idgestor
end

select dbo.fnSolicitacaoAprovacaoGestor(76, 3)
----------------------------------------------------------------------
-------------------- PROCEDURES --------------------------------------
----------------------------------------------------------------------
ALTER PROC sp_semestres_list
AS
/*
app: SimpacWeb
url: /simpacweb/modulos/RH/solicitacaoBolsaEstudos/json/semestres_list.php
data: 2013-02-21
author: Massa
*/
BEGIN
	SELECT idsemestre,
		   nrsemestre,
		   dessemestre,
		   instatus,
		   dtcadastro
	FROM tb_semestres
END
-------------------------------------------------------------------------
CREATE PROC sp_dependentetipo_list
AS
/*
app: SimpacWeb
url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
data: 2013-02-21
author: Massa
*/
BEGIN
	SELECT iddependentetipo,
		   desdependentetipo,
		   instatus,
		   dtcadastro
	FROM tb_dependente_tipo
END
-------------------------------------------------------------------------
CREATE PROC sp_solicitacaobolsaestudostipo_list
AS
/*
app: SimpacWeb
url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
data: 2013-02-21
author: Massa
*/
BEGIN
	SELECT idsolicitacaobolsaestudostipo,
		   dessolicitacaobolsaestudostipo,
		   instatus,
		   dtcadastro
	FROM tb_solicitacaobolsaestudostipo
END
-------------------------------------------------------------------------
CREATE PROC sp_solicitacaobolsaestudospermissao_list
AS
/*
app: SimpacWeb
url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
data: 2013-02-21
author: Massa
*/
BEGIN
	SELECT idpermissao, despermissao, instatus, dtcadastro
	from tb_solicitacaobolsaestudospermissao
	where instatus = 1
END
-------------------------------------------------------------------------
CREATE PROC sp_solicitacaobolsaestudos_save
(
	@idusuario	int,
	@idsolicitacaobolsaestudostipo int,
	@curso_id int,
	@idsemestre int,
	@iddependentetipo int,
	@desnomedependente varchar(100),
	@dtnascimentodependente datetime,
	@nrcpfdependente char(11),
	@desemaildependente varchar(100),
	@desjustificativa varchar(max)
)
AS
/*
app: SimpacWeb
url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
data: 2013-02-21
author: Massa
*/
BEGIN
	SET NOCOUNT ON
	INSERT tb_solicitacaobolsaestudos
	(
		idusuario,
		idsolicitacaobolsaestudostipo,
		curso_id,
		idsemestre,
		iddependentetipo,
		desnomedependente,
		dtnascimentodependente,
		nrcpfdependente,
		desemaildependente,
		desjustificativa
	)
	VALUES
	(
		@idusuario,
		@idsolicitacaobolsaestudostipo,
		@curso_id,
		@idsemestre,
		@iddependentetipo,
		@desnomedependente,
		@dtnascimentodependente,
		@nrcpfdependente,
		@desemaildependente,
		@desjustificativa
	)
	SET NOCOUNT OFF
	SELECT SCOPE_IDENTITY() AS idsolicitacaobolsaestudo
END
-------------------------------------------------------------------------
ALTER PROC sp_solicitacaobolsaestudos_solicitacaobolsaestudospermissao_save
(
	@idpermissao	int,
	@idsolicitacaobolsaestudo int,
	@idgestor	int,
	@desmotivo	varchar(max),
	@instatus bit
)
AS
/*
app: SimpacWeb
url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
data: 2013-02-21
author: Massa
*/
BEGIN
	INSERT tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao
	(
		idpermissao,
		idsolicitacaobolsaestudo,
		idgestor,
		desmotivo,
		instatus
	)
	VALUES
	(
		@idpermissao,
		@idsolicitacaobolsaestudo,
		@idgestor,
		@desmotivo,
		@instatus
	)
	
END
-------------------------------------------------------------------------
CREATE PROC sp_solicitacaobolsaestudosmotivo_save
(@idsolicitacaobolsaestudos int, @idpermissao int, @desmotivo varchar(max))
AS
/*
app: SimpacWeb
url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
data: 2013-02-21
author: Massa
*/
BEGIN
	UPDATE tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao
	SET desmotivo = @desmotivo
	WHERE idsolicitacaobolsaestudo =  @idsolicitacaobolsaestudos AND
	      idpermissao = @idpermissao
END
-------------------------------------------------------------------------
ALTER PROC sp_solicitacaobolsaestudos_get --76
(@idsolicitacaobolsaestudo int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
data: 2013-02-21
author: Massa
*/
BEGIN
	SELECT 
		idsolicitacaobolsaestudo,
		idusuario,
		idsolicitacaobolsaestudostipo,
		curso_id,
		idsemestre,
		iddependentetipo,
		desnomedependente,
		dtnascimentodependente,
		nrcpfdependente,
		desemaildependente,
		desjustificativa,
		instatus,
		dtcadastro
	FROM tb_solicitacaobolsaestudos
	WHERE idsolicitacaobolsaestudo = @idsolicitacaobolsaestudo
END
-------------------------------------------------------------------------
ALTER PROC sp_solicitacaobolsaestudos_gestor_list --221
(@idgestor int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
data: 2013-02-21
author: Massa
*/
BEGIN
	IF((SELECT ingerente FROM simpac..tb_usuario where InStatus = 1 and IdUsuario = @idgestor) = 1)
		BEGIN
			SELECT a.idsolicitacaobolsaestudo,
				   a.idusuario,
				   a.idsolicitacaobolsaestudostipo,
				   a.curso_id,
				   a.desjustificativa,
				   a.dtcadastro,
				   b.curso_titulo,
				   c.dessemestre,
				   d.NmCompleto,
				   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) as ingestor,
				   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) as inrh,
				   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) as indiretoria
			FROM tb_solicitacaobolsaestudos a
			INNER JOIN tb_cursos b
			ON b.curso_id = a.curso_id
			INNER JOIN tb_semestres c
			ON c.idsemestre = a.idsemestre
			INNER JOIN Simpac..tb_usuario d
			ON d.IdUsuario = a.idusuario 
			WHERE a.idusuario in(
				SELECT b.idusuario FROM simpac..tb_usuarioGerentes a 
				INNER JOIN simpac..tb_usuario b 
				ON a.idusuario = b.idusuario 
				WHERE idgerente = @idgestor and InStatus = 1 
			) AND
			(dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) = 2 AND
			dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) = 2 AND
			dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) = 2)
			ORDER BY a.dtcadastro DESC
		END
END
-------------------------------------------------------------------------
ALTER PROC sp_solicitacaobolsaestudos_rh_list
AS
/*
app: SimpacWeb
url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
data: 2013-02-21
author: Massa
*/
BEGIN
	SELECT a.idsolicitacaobolsaestudo,
		   a.idusuario,
		   a.idsolicitacaobolsaestudostipo,
		   a.curso_id,
		   a.desjustificativa,
		   b.curso_titulo,
		   c.dessemestre,
		   d.NmCompleto,
		   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) as ingestor,
		   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) as inrh,
		   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) as indiretoria
	FROM tb_solicitacaobolsaestudos a
	INNER JOIN tb_cursos b
	ON b.curso_id = a.curso_id
	INNER JOIN tb_semestres c
	ON c.idsemestre = a.idsemestre
	INNER JOIN Simpac..tb_usuario d
	ON d.IdUsuario = a.idusuario 
	WHERE (dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) = 1 AND
		   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) = 2 AND
		   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) = 2)
	ORDER BY a.dtcadastro DESC
END
-------------------------------------------------------------------------
ALTER PROC sp_solicitacaobolsaestudos_diretoria_list
AS
/*
app: SimpacWeb
url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
data: 2013-02-21
author: Massa
*/
BEGIN
	SELECT a.idsolicitacaobolsaestudo,
		   a.idusuario,
		   a.idsolicitacaobolsaestudostipo,
		   a.curso_id,
		   a.desjustificativa,
		   b.curso_titulo,
		   c.dessemestre,
		   d.NmCompleto,
		   (select nrpercentual from tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao
		   where idpermissao = 2 and idsolicitacaobolsaestudo = a.idsolicitacaobolsaestudo) as nrpercentual,
		   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) as ingestor,
		   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) as inrh,
		   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) as indiretoria
	FROM tb_solicitacaobolsaestudos a
	INNER JOIN tb_cursos b
	ON b.curso_id = a.curso_id
	INNER JOIN tb_semestres c
	ON c.idsemestre = a.idsemestre
	INNER JOIN Simpac..tb_usuario d
	ON d.IdUsuario = a.idusuario 
	WHERE (dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) = 1 AND
		   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) = 1 AND
		   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) = 2)
	ORDER BY a.dtcadastro DESC
END
-------------------------------------------------------------------------
ALTER PROC sp_solicitacaobolsaestudospendentes_list
AS
/*
app: SimpacWeb
url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
data: 2013-02-21
author: Massa
*/
BEGIN
	SELECT a.idsolicitacaobolsaestudo,
		   a.idusuario,
		   a.idsolicitacaobolsaestudostipo,
		   a.idsemestre,
		   a.curso_id,
		   a.desjustificativa,
		   b.curso_titulo,	
		   c.nmcompleto,
		   d.dessemestre,
		   e.desdependentetipo,
		   f.dessolicitacaobolsaestudostipo,
		   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) as ingestor,
		   dbo.fnSolicitacaoAprovacaoGestor(a.idsolicitacaobolsaestudo, 1) as idgestor,
		   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) as inrh,
		   dbo.fnSolicitacaoAprovacaoGestor(a.idsolicitacaobolsaestudo, 2) as idgestorrh,
		   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) as indiretoria,
		   dbo.fnSolicitacaoAprovacaoGestor(a.idsolicitacaobolsaestudo, 3) as idgestordiretoria,
		   a.dtcadastro
	FROM tb_solicitacaobolsaestudos a
	LEFT JOIN tb_cursos b
	ON b.curso_id = a.curso_id
	LEFT JOIN Simpac..tb_usuario c
	ON c.idusuario = a.idusuario
	LEFT JOIN tb_semestres d
	ON d.idsemestre = a.idsemestre
	LEFT JOIN tb_dependente_tipo e
	ON e.iddependentetipo = a.iddependentetipo	
	LEFT JOIN tb_solicitacaobolsaestudostipo f
	ON f.idsolicitacaobolsaestudostipo = a.idsolicitacaobolsaestudostipo
	where ((dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) IN (1, 2) and 
		   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) IN (1, 2)) and 
		   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) = 2) 
END

SELECT *FROM simpac..tb_usuario where IdUsuario = 1635
SELECT *FROM tb_solicitacaobolsaestudos where IdUsuario = 1636
SELECT *FROM tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao  where idsolicitacaobolsaestudo = 88
-------------------------------------------------------------------------
ALTER PROC sp_solicitacaobolsaestudos_list --1495
(@idusuario int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
data: 2013-02-21
author: Massa
*/
BEGIN
	SELECT a.idsolicitacaobolsaestudo,
		   a.idusuario,
		   a.idsolicitacaobolsaestudostipo,
		   a.curso_id,
		   a.desjustificativa,
		   b.curso_titulo,
		   c.dessemestre,
		   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) as ingestor,
		   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) as inrh,
		   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) as indiretoria
	FROM tb_solicitacaobolsaestudos a
	INNER JOIN tb_cursos b
	ON b.curso_id = a.curso_id
	INNER JOIN tb_semestres c
	ON c.idsemestre = a.idsemestre
	WHERE a.idusuario = @idusuario AND
	(dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) != 0) AND
	(dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) != 0) AND
	(dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) = 2)
	ORDER by a.dtcadastro DESC
END
-------------------------------------------------------------------------
ALTER PROC sp_solicitacaobolsaestudosaprovados_list --1495
(@idusuario int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
data: 2013-02-21
author: Massa
*/
BEGIN
	SELECT a.idsolicitacaobolsaestudo,
		   a.idusuario,
		   a.idsolicitacaobolsaestudostipo,
		   a.curso_id,
		   a.desjustificativa,
		   b.curso_titulo,
		   c.dessemestre,
		   (select nrpercentual from tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao
		   where idpermissao = 2 and idsolicitacaobolsaestudo = a.idsolicitacaobolsaestudo) as nrpercentual,
		   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) as ingestor,
		   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) as inrh,
		   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) as indiretoria
	FROM tb_solicitacaobolsaestudos a
	INNER JOIN tb_cursos b
	ON b.curso_id = a.curso_id
	INNER JOIN tb_semestres c
	ON c.idsemestre = a.idsemestre
	WHERE a.idusuario = @idusuario AND
	(dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) = 1 AND
	dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) = 1 AND
	dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) = 1)
END
-------------------------------------------------------------------------
CREATE PROC sp_solicitacaobolsaestudosreprovados_list --1495
(@idusuario int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
data: 2013-02-21
author: Massa
*/
BEGIN
	SELECT a.idsolicitacaobolsaestudo,
		   a.idusuario,
		   a.idsolicitacaobolsaestudostipo,
		   a.curso_id,
		   a.desjustificativa,
		   b.curso_titulo,
		   c.dessemestre,
		   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) as ingestor,
		   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) as inrh,
		   dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) as indiretoria
	FROM tb_solicitacaobolsaestudos a
	INNER JOIN tb_cursos b
	ON b.curso_id = a.curso_id
	INNER JOIN tb_semestres c
	ON c.idsemestre = a.idsemestre
	WHERE a.idusuario = @idusuario AND
	(dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) = 0 OR
	dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) = 0 OR
	dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) = 0)
END
-------------------------------------------------------------------------
ALTER PROC sp_solicitacaobolsaestudoscurso_get --1
(@idsolicitacaobolsaestudo int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
data: 2013-02-21
author: Massa
*/
BEGIN
	SELECT a.curso_id,a.curso_titulo, c.dessemestre
	FROM tb_cursos a
	INNER JOIN tb_solicitacaobolsaestudos b
	ON a.curso_id = b.curso_id
	INNER JOIN tb_semestres c
	ON c.idsemestre = b.idsemestre
	WHERE b.idsolicitacaobolsaestudo = @idsolicitacaobolsaestudo
END
---------------------------------------------------------------------------
CREATE PROC sp_solicitacaobolsaestudosdependentetipo_get --28
(@idsolicitacaobolsaestudo int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
data: 2013-02-21
author: Massa
*/
BEGIN
	SELECT a.iddependentetipo, 
		   a.desdependentetipo
	FROM tb_dependente_tipo a
	INNER JOIN tb_solicitacaobolsaestudos b
	ON b.iddependentetipo = a.iddependentetipo	
	WHERE a.instatus = 1 AND b.idsolicitacaobolsaestudo = @idsolicitacaobolsaestudo	
END
---------------------------------------------------------------------------
ALTER PROC sp_solicitacaobolsaestudosaprovacao_get --9, 2
(@idsolicitacaobolsaestudo int, @idpermissao int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
data: 2013-02-21
author: Massa
*/
BEGIN
	SELECT idpermissao, idgestor, desmotivo, instatus, nrpercentual, dtcadastro 
	FROM tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao
	WHERE idsolicitacaobolsaestudo = @idsolicitacaobolsaestudo and idpermissao = @idpermissao
END
---------------------------------------------------------------------------
ALTER PROC sp_solicitacaobolsaestudosmotivo_get --41
(@idsolicitacaobolsaestudo int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
data: 2013-02-21
author: Massa
*/
BEGIN
	SELECT idpermissao, idgestor, desmotivo, instatus, nrpercentual, dtcadastro 
	FROM tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao
	WHERE idsolicitacaobolsaestudo = @idsolicitacaobolsaestudo and instatus = 0
END
-------------------------------------------------------------------------
CREATE PROC sp_solicitacaobolsaestudonotificacao_list
AS
/*
app: SimpacWeb
url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
data: 2013-02-21
author: Massa
*/
BEGIN
	select b.idsolicitacaobolsaestudo, b.idusuario, b.curso_id, a.dtcadastro
	from tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao a
	right join tb_solicitacaobolsaestudos b
	on b.idsolicitacaobolsaestudo = a.idsolicitacaobolsaestudo and (a.idpermissao = 3 and a.instatus = 1)
	where a.idpermissao = 3 and a.instatus = 1 and (GETDATE() between a.dtcadastro and DATEADD(month, 6, a.dtcadastro))
	order by b.idusuario, b.idsolicitacaobolsaestudo
END	


---------------------------------------------------------------------------
USE RH; SELECT *FROM tb_solicitacaopermissao; SELECT *FROM tb_solicitacaoxpermissao; USE FIT_NEW;

SELECT     TOP (200) idexecution, idschedule, dtexecution, dtexecuted, dtcadastro
FROM         tb_SchedulesExecutions
WHERE     (idschedule = 28)

SELECT *FROM tb_cursos

sp_curso_get 2

SELECT *FROM tb_vestibular_tipo
SELECT *FROM tb_vestibular

select * from tb_solicitacaobolsaestudos
Select * from tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao 

SELECT a.idsolicitacaobolsaestudo,
		   a.idusuario,
		   a.idsolicitacaobolsaestudostipo,
		   a.curso_id,
		   b.curso_titulo,
		   c.dessemestre
	FROM tb_solicitacaobolsaestudos a
	INNER JOIN tb_cursos b
	ON b.curso_id = a.curso_id
	INNER JOIN tb_semestres c
	ON c.idsemestre = a.idsemestre
	WHERE 
	(dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) = 1 AND
	dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) = 1 AND
	dbo.fnSolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) = 1)
	
	order by a.curso_id
	
	SELECT DATEDIFF(month, '2005-07-31 23:59:59.9999999',GETDATE());
	
	SELECT DATEADD(month, 1, '2006-08-30');
	
	
	declare @date datetime, @date2 datetime
	set @date = '2013-06-04'
	set @date2 = '2013-12-04'
	
	if (@date2 between @date and DATEADD(month, 6, @date))
	begin
		print @date
	end 
	
	declare @data datetime
	set @data = '2013-02-28' 
	
	select b.idsolicitacaobolsaestudo, b.idusuario, b.curso_id, a.dtcadastro
	from tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao a
	right join tb_solicitacaobolsaestudos b
	on b.idsolicitacaobolsaestudo = a.idsolicitacaobolsaestudo and (a.idpermissao = 3 and a.instatus = 1)
	where a.idpermissao = 3 and a.instatus = 1 --and ('2013-02-27' between a.dtcadastro and DATEADD(day, 2, a.dtcadastro))
	order by b.idusuario, b.idsolicitacaobolsaestudo
	-------------
	
	-------------------------------------------------------------------------
ALTER PROC sp_solicitacaobolsaestudos_diretoria_list
AS
/*
app: SimpacWeb
url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
data: 2013-02-21
author: Massa
*/
BEGIN
	SELECT a.idsolicitacaobolsaestudo,
		   a.idusuario,
		   a.idsolicitacaobolsaestudostipo,
		   a.curso_id,
		   a.desjustificativa,
		   b.curso_titulo,
		   c.dessemestre,
		   d.NmCompleto,
		   (select nrpercentual from tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao
		   where idpermissao = 2 and idsolicitacaobolsaestudo = a.idsolicitacaobolsaestudo) as nrpercentual,
		   dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) as ingestor,
		   dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) as inrh,
		   dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) as indiretoria
	FROM tb_solicitacaobolsaestudos a
	INNER JOIN tb_cursos b
	ON b.curso_id = a.curso_id
	INNER JOIN tb_semestres c
	ON c.idsemestre = a.idsemestre
	INNER JOIN Simpac..tb_usuario d
	ON d.IdUsuario = a.idusuario 
	WHERE (dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) = 1 AND
		   dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) = 1 AND
		   dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) = 2)
	ORDER BY a.dtcadastro DESC
END
-------------------------------------------------------------------------
ALTER PROC sp_solicitacaobolsaestudos_gestor_list --221
(@idgestor int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
data: 2013-02-21
author: Massa
*/
BEGIN
	IF((SELECT ingerente FROM simpac..tb_usuario where InStatus = 1 and IdUsuario = @idgestor) = 1)
		BEGIN
			SELECT a.idsolicitacaobolsaestudo,
				   a.idusuario,
				   a.idsolicitacaobolsaestudostipo,
				   a.curso_id,
				   a.desjustificativa,
				   a.dtcadastro,
				   b.curso_titulo,
				   c.dessemestre,
				   d.NmCompleto,
				   dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) as ingestor,
				   dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) as inrh,
				   dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) as indiretoria
			FROM tb_solicitacaobolsaestudos a
			INNER JOIN tb_cursos b
			ON b.curso_id = a.curso_id
			INNER JOIN tb_semestres c
			ON c.idsemestre = a.idsemestre
			INNER JOIN Simpac..tb_usuario d
			ON d.IdUsuario = a.idusuario 
			WHERE a.idusuario in(
				SELECT b.idusuario FROM simpac..tb_usuarioGerentes a 
				INNER JOIN simpac..tb_usuario b 
				ON a.idusuario = b.idusuario 
				WHERE idgerente = @idgestor and InStatus = 1 
			) AND
			(dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) = 2 AND
			dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) = 2 AND
			dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) = 2)
			ORDER BY a.dtcadastro DESC
		END
END
-------------------------------------------------------------------------
CREATE PROC sp_solicitacaobolsaestudospercentual_save
(@idsolicitacaobolsaestudos int, @idpermissao int, @nrpercentual int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
data: 2013-02-21
author: Massa
*/
BEGIN
	UPDATE tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao
	SET nrpercentual = @nrpercentual
	WHERE idsolicitacaobolsaestudo =  @idsolicitacaobolsaestudos AND
	      idpermissao = @idpermissao
END












--------------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------------
------------------------- VALIDADOS --------------------------------------------------------
--------------------------------------------------------------------------------------------

-- USE FIT_NEW;
----------------------------------------------------------------------
----------------------------------------------------------------------
-- >>>>>>>>>>>>TABLES
----------------------------------------------------------------------
-- OK
CREATE TABLE tb_semestres(
      idsemestre INT IDENTITY NOT NULL CONSTRAINT PK_semestres PRIMARY KEY(idsemestre),
      nrsemestre INT NOT NULL,
      dessemestre VARCHAR(50) NOT NULL,
      instatus BIT CONSTRAINT DF_semestres_instatus DEFAULT(1),
      dtcadastro DATETIME CONSTRAINT DF_semestres_dtcadastro DEFAULT(GETDATE())
);

INSERT tb_semestres(
      nrsemestre,
      dessemestre
)
VALUES (1, 'Primeiro'),
         (2, 'Segundo'),
         (3, 'Terceiro'),
         (4, 'Quarto'),
         (5, 'Quinto'),
         (6, 'Sexto'),
         (7, 'Sétimo'),
         (8, 'Oitavo');

----------------------------------------------------------------------
-- OK
CREATE TABLE tb_dependente_tipo(
      iddependentetipo INT NOT NULL IDENTITY CONSTRAINT PK_dependente_tipo PRIMARY KEY(iddependentetipo),
      desdependentetipo VARCHAR(50) NOT NULL,
      instatus    BIT CONSTRAINT DF_dependente_tipo_instatus DEFAULT(1),
      dtcadastro  DATETIME CONSTRAINT DF_dependente_tipo_dtcadastro DEFAULT(GETDATE())
);

INSERT tb_dependente_tipo(
      desdependentetipo
)
VALUES
      ('Cônjuge'),
      ('Filho(a)'),
      ('Pai'),
      ('Mãe');

----------------------------------------------------------------------
-- OK
CREATE TABLE tb_solicitacaobolsaestudostipo(
      idsolicitacaobolsaestudostipo INT NOT NULL IDENTITY CONSTRAINT PK_solicitacaobolsaestudostipo PRIMARY KEY(idsolicitacaobolsaestudostipo),
      dessolicitacaobolsaestudostipo VARCHAR(50) not null,
      instatus BIT CONSTRAINT DF_solicitacaobolsaestudostipo_instatus DEFAULT(1),
      dtcadastro DATETIME CONSTRAINT DF_solicitacaobolsaestudostipo_dtcadastro DEFAULT(GETDATE())
);

INSERT tb_solicitacaobolsaestudostipo(
      dessolicitacaobolsaestudostipo
)
VALUES
      ('Titular'),
      ('Dependente');

----------------------------------------------------------------------
-- OK
CREATE TABLE tb_solicitacaobolsaestudospermissao(
      idpermissao INT NOT NULL IDENTITY CONSTRAINT PK_solicitacaobolsaestudospermissao PRIMARY KEY(idpermissao),
      despermissao VARCHAR(50) NOT NULL,
      instatus BIT CONSTRAINT DF_solicitacaobolsaestudospermissao_instatus DEFAULT(1),
      dtcadastro DATETIME CONSTRAINT DF_solicitacaobolsaestudospermissao_dtcadastro DEFAULT(GETDATE())
);

INSERT tb_solicitacaobolsaestudospermissao(
      despermissao
)
VALUES
      ('Gestor'),
      ('RH'),
      ('Diretoria');

----------------------------------------------------------------------
-- OK
CREATE TABLE tb_solicitacaobolsaestudos(
      idsolicitacaobolsaestudo INT NOT NULL IDENTITY CONSTRAINT PK_solicitacaobolsaestudo PRIMARY KEY(idsolicitacaobolsaestudo),
      idusuario INT,
      idsolicitacaobolsaestudostipo INT NOT NULL,
      curso_id INT NOT NULL,
      idsemestre INT,
      iddependentetipo INT,
      desnomedependente VARCHAR(100),
      dtnascimentodependente DATETIME,
      nrcpfdependente CHAR(11),
      desemaildependente VARCHAR(100),
      desjustificativa VARCHAR(MAX),
      instatus BIT CONSTRAINT DF_solicitacaobolsaestudos_instatus DEFAULT(1),
      dtcadastro DATETIME CONSTRAINT DF_solicitacaobolsaestudos_dtcadastro DEFAULT(GETDATE())
      
      CONSTRAINT FK_solicitacaobolsaestudos_solicitacaobolsaestudostipo_idsolicitacaobolsaestudostipo FOREIGN KEY(idsolicitacaobolsaestudostipo)
      REFERENCES tb_solicitacaobolsaestudostipo(idsolicitacaobolsaestudostipo),
      CONSTRAINT FK_solicitacaobolsaestudos_dependente_tipo_iddependentetipo FOREIGN KEY(iddependentetipo)
      REFERENCES tb_dependente_tipo(iddependentetipo),
      CONSTRAINT FK_solicitacaobolsaestudos_cursos_curso_id FOREIGN KEY(curso_id)
      REFERENCES tb_cursos(curso_id),
      CONSTRAINT FK_solicitacaobolsaestudos_semestres_idsemestre FOREIGN KEY(idsemestre)
      REFERENCES tb_semestres(idsemestre)
);

----------------------------------------------------------------------
-- OK
CREATE TABLE tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao(
      idpermissao INT NOT NULL,
      idsolicitacaobolsaestudo INT NOT NULL,
      idgestor INT NOT NULL,
      desmotivo VARCHAR(MAX),
      nrpercentual INT,
      instatus BIT CONSTRAINT DF_solicitacaobolsaestudos_solicitacaobolsaestudospermissao_instatus DEFAULT(1),
      dtcadastro DATETIME CONSTRAINT DF_solicitacaobolsaestudos_solicitacaobolsaestudospermissao_dtcadastro DEFAULT(GETDATE())
      
      CONSTRAINT PK_solicitacaobolsaestudos_solicitacaobolsaestudospermissao_idpermissao_idsolicitacaobolsaestudo PRIMARY KEY(idpermissao, idsolicitacaobolsaestudo)
      CONSTRAINT FK_solicitacaobolsaestudos_solicitacaobolsaestudospermissao_idpermissao FOREIGN KEY(idpermissao)
      REFERENCES tb_solicitacaobolsaestudospermissao(idpermissao),
      CONSTRAINT FK_solicitacaobolsaestudos_solicitacaobolsaestudospermissao_solicitacaobolsaestudos FOREIGN KEY(idsolicitacaobolsaestudo)
      REFERENCES tb_solicitacaobolsaestudos(idsolicitacaobolsaestudo)  
);

----------------------------------------------------------------------
----------------------------------------------------------------------
-- >>>>>>>>>>>>FUNCTIONS

----------------------------------------------------------------------
-- Modificações:
  --> O nome da função deve comessar com 'fn_'
  --> Adicione uma descrição sobre qual o objetivo da função
  --> Deixar todos os comandos SQL maiúsculos
  --> Author deve ser seu login ('massaharu' em vez de 'massa')
   
CREATE FUNCTION fn_SolicitacaoBolsaEstudosStatus (
      @idsolicitacaobolsaestudo INT,
      @idpermissao INT
)
RETURNS SMALLINT
AS
/*
      app: SimpacWeb
      data: 2013-02-21
      author: Massaharu
*/
--Function que retorna o status de uma solicitação de bolsa de estudo a partir do id da bolsa e o id da permissão
BEGIN
      DECLARE @instatus SMALLINT = NULL
      
      SELECT @instatus = instatus
        FROM tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao 
      WHERE idpermissao = @idpermissao 
            AND idsolicitacaobolsaestudo = @idsolicitacaobolsaestudo
      
      IF ISNUMERIC(@instatus) != 1
            SET @instatus = 2 
      RETURN @instatus;
END;

----------------------------------------------------------------------
-- Modificações:
  --> O nome da função deve comessar com 'fn_'
  --> Adicione uma descrição sobre qual o objetivo da função
  --> Deixar todos os comandos SQL maiúsculos
  --> Sem descrição e sem os comentarios de identificação!!
  
CREATE FUNCTION fn_SolicitacaoAprovacaoGestor(
      @idsolicitacaobolsaestudo INT,
      @idpermissao INT
)
RETURNS INT
AS
/*
      app: SimpacWeb
      data: 2013-02-21
      author: Massaharu
*/
--Function que retorna o gestor a partir do id da solicitacao de bolsa de estudo e do id de permissão
BEGIN
      DECLARE @idgestor INT = NULL
      
      SELECT @idgestor = idgestor
      FROM tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao
      WHERE idsolicitacaobolsaestudo = @idsolicitacaobolsaestudo
            AND idpermissao = @idpermissao

      RETURN @idgestor;
END;

----------------------------------------------------------------------
----------------------------------------------------------------------
-- >>>>>>>>>>>>Procedures

--ALTERAÇÃO GERAL:  
-->Preifra usar o seu login na identificação da procedure
-->Nas próximas, acrescente uma descrição sobre o que a procedure faz
-->Nas próximas, deixe os comandos SQL em maiúsculo

----------------------------------------------------------------------
-- OK

CREATE PROC sp_semestres_list
AS
/*
      app: SimpacWeb
      url: /simpacweb/modulos/RH/solicitacaoBolsaEstudos/json/semestres_list.php
      data: 2013-02-21
      author: Massaharu
*/
BEGIN
      SELECT   idsemestre,
                     nrsemestre,
                     dessemestre,
                     instatus,
                     dtcadastro
      FROM tb_semestres;
END;


----------------------------------------------------------------------
-- OK
CREATE PROC sp_dependentetipo_list
AS
/*
      app: SimpacWeb
      url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
      data: 2013-02-21
      author: Massaharu
*/
BEGIN
      SELECT iddependentetipo,
               desdependentetipo,
               instatus,
               dtcadastro
      FROM tb_dependente_tipo;
END;


----------------------------------------------------------------------
-- OK
CREATE PROC sp_solicitacaobolsaestudostipo_list
AS
/*
      app: SimpacWeb
      url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
      data: 2013-02-21
      author: Massaharu
*/
BEGIN
      SELECT   idsolicitacaobolsaestudostipo,
               dessolicitacaobolsaestudostipo,
               instatus,
               dtcadastro
      FROM tb_solicitacaobolsaestudostipo;
END;


----------------------------------------------------------------------
-- OK
CREATE PROC sp_solicitacaobolsaestudospermissao_list
AS
/*
      app: SimpacWeb
      url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
      data: 2013-02-21
      author: massaharu
*/
BEGIN
      SELECT idpermissao, despermissao, instatus, dtcadastro
      FROM tb_solicitacaobolsaestudospermissao
      WHERE instatus = 1;
END;


----------------------------------------------------------------------
--OK
CREATE PROC sp_solicitacaobolsaestudos_save
(
      @idusuario  INT,
      @idsolicitacaobolsaestudostipo INT,
      @curso_id INT,
      @idsemestre INT,
      @iddependentetipo INT,
      @desnomedependente VARCHAR(100),
      @dtnascimentodependente DATETIME,
      @nrcpfdependente CHAR(11),
      @desemaildependente VARCHAR(100),
      @desjustificativa VARCHAR(MAX)
)
AS
/*
      app: SimpacWeb
      url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
      data: 2013-02-21
      author: Massaharu
*/
BEGIN
      SET NOCOUNT ON
      INSERT tb_solicitacaobolsaestudos
      (
            idusuario,
            idsolicitacaobolsaestudostipo,
            curso_id,
            idsemestre,
            iddependentetipo,
            desnomedependente,
            dtnascimentodependente,
            nrcpfdependente,
            desemaildependente,
            desjustificativa
      )
      VALUES
      (
            @idusuario,
            @idsolicitacaobolsaestudostipo,
            @curso_id,
            @idsemestre,
            @iddependentetipo,
            @desnomedependente,
            @dtnascimentodependente,
            @nrcpfdependente,
            @desemaildependente,
            @desjustificativa
      )
      SET NOCOUNT OFF
      SELECT SCOPE_IDENTITY() AS idsolicitacaobolsaestudo
END;

----------------------------------------------------------------------
-- OK
CREATE PROC sp_solicitacaobolsaestudos_solicitacaobolsaestudospermissao_save
(
      @idpermissao INT,
      @idsolicitacaobolsaestudo INT,
      @idgestor INT,
      @desmotivo VARCHAR(MAX),
      @instatus BIT
)
AS
/*
      app: SimpacWeb
      url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
      data: 2013-02-21
      author: Massaharu
*/
BEGIN
      INSERT tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao(
            idpermissao,
            idsolicitacaobolsaestudo,
            idgestor,
            desmotivo,
            instatus
      )
      VALUES(
            @idpermissao,
            @idsolicitacaobolsaestudo,
            @idgestor,
            @desmotivo,
            @instatus
      );      
END;

----------------------------------------------------------------------
-- OK
CREATE PROC sp_solicitacaobolsaestudosmotivo_save(
      @idsolicitacaobolsaestudos int,
      @idpermissao int,
      @desmotivo varchar(max)
)
AS
/*
      app: SimpacWeb
      url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
      data: 2013-02-21
      author: Massaharu
*/
BEGIN
      UPDATE tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao
      SET desmotivo = @desmotivo
      WHERE idsolicitacaobolsaestudo = @idsolicitacaobolsaestudos 
            AND idpermissao = @idpermissao;
END;

----------------------------------------------------------------------
-- OK
CREATE PROC sp_solicitacaobolsaestudos_get(
      @idsolicitacaobolsaestudo INT
)
AS
/*
      app: SimpacWeb
      url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
      data: 2013-02-21
      author: Massaharu
*/
BEGIN
      SELECT idsolicitacaobolsaestudo,
             idusuario,
             idsolicitacaobolsaestudostipo,
             curso_id,
             idsemestre,
             iddependentetipo,
             desnomedependente,
             dtnascimentodependente,
             nrcpfdependente,
             desemaildependente,
             desjustificativa,
             instatus,
             dtcadastro
      FROM tb_solicitacaobolsaestudos
      WHERE idsolicitacaobolsaestudo = @idsolicitacaobolsaestudo;
END;

----------------------------------------------------------------------
--Arrumar nomes das functions (lembre-se que eu as criei usando 'fn_')
CREATE PROC sp_solicitacaobolsaestudos_rh_list
AS
/*
      app: SimpacWeb
      url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
      data: 2013-02-21
      author: Massaharu
*/
BEGIN
      SELECT   a.idsolicitacaobolsaestudo,
               a.idusuario,
               a.idsolicitacaobolsaestudostipo,
               a.curso_id,
               a.desjustificativa,
               b.curso_titulo,
               c.dessemestre,
               d.NmCompleto,
               dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) AS ingestor,
               dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) AS inrh,
               dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) AS indiretoria
      FROM tb_solicitacaobolsaestudos a
      INNER JOIN tb_cursos b
            ON b.curso_id = a.curso_id
      INNER JOIN tb_semestres c
            ON c.idsemestre = a.idsemestre
      INNER JOIN Simpac..tb_usuario d
            ON d.IdUsuario = a.idusuario 
      WHERE (dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) = 1 AND
               dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) = 2 AND
               dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) = 2)
      ORDER BY a.dtcadastro DESC;
END;

----------------------------------------------------------------------
--Arrumar nomes das functions (lembre-se que eu as criei usando 'fn_')
CREATE PROC sp_solicitacaobolsaestudospendentes_list
AS
/*
      app: SimpacWeb
      url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
      data: 2013-02-21
      author: Massaharu
*/
BEGIN
      SELECT   a.idsolicitacaobolsaestudo,
               a.idusuario,
               a.idsolicitacaobolsaestudostipo,
               a.idsemestre,
               a.curso_id,
               a.desjustificativa,
               b.curso_titulo,      
               c.nmcompleto,
               d.dessemestre,
               e.desdependentetipo,
               f.dessolicitacaobolsaestudostipo,
               dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) as ingestor,
               dbo.fn_SolicitacaoAprovacaoGestor(a.idsolicitacaobolsaestudo, 1) as idgestor,
               dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) as inrh,
               dbo.fn_SolicitacaoAprovacaoGestor(a.idsolicitacaobolsaestudo, 2) as idgestorrh,
               dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) as indiretoria,
               dbo.fn_SolicitacaoAprovacaoGestor(a.idsolicitacaobolsaestudo, 3) as idgestordiretoria,
               a.dtcadastro
      FROM tb_solicitacaobolsaestudos a
      LEFT JOIN tb_cursos b
            ON b.curso_id = a.curso_id
      LEFT JOIN Simpac..tb_usuario c
            ON c.idusuario = a.idusuario
      LEFT JOIN tb_semestres d
            ON d.idsemestre = a.idsemestre
      LEFT JOIN tb_dependente_tipo e
            ON e.iddependentetipo = a.iddependentetipo     
      LEFT JOIN tb_solicitacaobolsaestudostipo f
            ON f.idsolicitacaobolsaestudostipo = a.idsolicitacaobolsaestudostipo
      WHERE ((dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) IN (1, 2) and 
               dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) IN (1, 2)) and 
               dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) = 2) 
END;

----------------------------------------------------------------------
--Arrumar nomes das functions (lembre-se que eu as criei usando 'fn_')
CREATE PROC sp_solicitacaobolsaestudos_list(
      @idusuario INT
)
AS
/*
      app: SimpacWeb
      url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
      data: 2013-02-21
      author: Massaharu
*/
BEGIN
      SELECT   a.idsolicitacaobolsaestudo,
               a.idusuario,
               a.idsolicitacaobolsaestudostipo,
               a.curso_id,
               a.desjustificativa,
               b.curso_titulo,
               c.dessemestre,
               dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) as ingestor,
               dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) as inrh,
               dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) as indiretoria
      FROM tb_solicitacaobolsaestudos a
      INNER JOIN tb_cursos b
      ON b.curso_id = a.curso_id
      INNER JOIN tb_semestres c
      ON c.idsemestre = a.idsemestre
      WHERE a.idusuario = @idusuario AND
      (dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) != 0) AND
      (dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) != 0) AND
      (dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) = 2)
      ORDER by a.dtcadastro DESC;
END;

----------------------------------------------------------------------
--Arrumar nomes das functions (lembre-se que eu as criei usando 'fn_')
CREATE PROC sp_solicitacaobolsaestudosaprovados_list(
      @idusuario int
)
AS
/*
      app: SimpacWeb
      url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
      data: 2013-02-21
      author: Massaharu
*/
BEGIN
      SELECT   a.idsolicitacaobolsaestudo,
               a.idusuario,
               a.idsolicitacaobolsaestudostipo,
               a.curso_id,
               a.desjustificativa,
               b.curso_titulo,
               c.dessemestre,
               (select nrpercentual from tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao
               where idpermissao = 2 and idsolicitacaobolsaestudo = a.idsolicitacaobolsaestudo) as nrpercentual,
               dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) as ingestor,
               dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) as inrh,
               dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) as indiretoria
      FROM tb_solicitacaobolsaestudos a
      INNER JOIN tb_cursos b
            ON b.curso_id = a.curso_id
      INNER JOIN tb_semestres c
            ON c.idsemestre = a.idsemestre
      WHERE a.idusuario = @idusuario AND
      (dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) = 1 AND
      dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) = 1 AND
      dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) = 1);
END;

----------------------------------------------------------------------
--Arrumar nomes das functions (lembre-se que eu as criei usando 'fn_')
CREATE PROC sp_solicitacaobolsaestudosreprovados_list(
      @idusuario INT
)
AS
/*
      app: SimpacWeb
      url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
      data: 2013-02-21
      author: Massaharu
*/
BEGIN
      SELECT   a.idsolicitacaobolsaestudo,
               a.idusuario,
               a.idsolicitacaobolsaestudostipo,
               a.curso_id,
               a.desjustificativa,
               b.curso_titulo,
               c.dessemestre,
               dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) as ingestor,
               dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) as inrh,
               dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) as indiretoria
      FROM tb_solicitacaobolsaestudos a
      INNER JOIN tb_cursos b
            ON b.curso_id = a.curso_id
      INNER JOIN tb_semestres c
            ON c.idsemestre = a.idsemestre
      WHERE a.idusuario = @idusuario AND
      (dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 1) = 0 OR
      dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 2) = 0 OR
      dbo.fn_SolicitacaoBolsaEstudosStatus(a.idsolicitacaobolsaestudo, 3) = 0);
END;

----------------------------------------------------------------------
-- OK
CREATE PROC sp_solicitacaobolsaestudoscurso_get(
      @idsolicitacaobolsaestudo INT
)
AS
/*
      app: SimpacWeb
      url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
      data: 2013-02-21
      author: Massaharu
*/
BEGIN
      SELECT a.curso_id,
                   a.curso_titulo,
                   c.dessemestre
      FROM tb_cursos a
      INNER JOIN tb_solicitacaobolsaestudos b
             ON a.curso_id = b.curso_id
      INNER JOIN tb_semestres c
             ON c.idsemestre = b.idsemestre
      WHERE b.idsolicitacaobolsaestudo = @idsolicitacaobolsaestudo;
END;

----------------------------------------------------------------------
-- OK
CREATE PROC sp_solicitacaobolsaestudosdependentetipo_get(
      @idsolicitacaobolsaestudo INT
)
AS
/*
      app: SimpacWeb
      url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
      data: 2013-02-21
      author: Massaharu
*/
BEGIN
      SELECT   a.iddependentetipo,
               a.desdependentetipo
      FROM tb_dependente_tipo a
      INNER JOIN tb_solicitacaobolsaestudos b
            ON b.iddependentetipo = a.iddependentetipo     
      WHERE a.instatus = 1
            AND b.idsolicitacaobolsaestudo = @idsolicitacaobolsaestudo;
END;

----------------------------------------------------------------------
-- OK
CREATE PROC sp_solicitacaobolsaestudosaprovacao_get(
      @idsolicitacaobolsaestudo INT,
      @idpermissao INT
)
AS
/*
      app: SimpacWeb
      url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
      data: 2013-02-21
      author: Massaharu
*/
BEGIN
      SELECT idpermissao,
                   idgestor,
                   desmotivo,
                   instatus,
                   nrpercentual,
                   dtcadastro 
      FROM tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao
      WHERE idsolicitacaobolsaestudo = @idsolicitacaobolsaestudo
            AND idpermissao = @idpermissao;
END;

----------------------------------------------------------------------
-- OK
CREATE PROC sp_solicitacaobolsaestudosmotivo_get(
      @idsolicitacaobolsaestudo int
)
AS
/*
      app: SimpacWeb
      url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
      data: 2013-02-21
      author: Massaharu
*/
BEGIN
      SELECT idpermissao,
                   idgestor,
                   desmotivo,
                   instatus,
                   nrpercentual,
                   dtcadastro 
      FROM tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao
      WHERE idsolicitacaobolsaestudo = @idsolicitacaobolsaestudo
            AND instatus = 0;
END;

----------------------------------------------------------------------
-- OK
CREATE PROC sp_solicitacaobolsaestudonotificacao_list
AS
/*
      app: SimpacWeb
      url: /simpacweb/class/solicitacaoBolsaEstudos.class.php
      data: 2013-02-21
      author: Massaharu
*/
BEGIN
      SELECT b.idsolicitacaobolsaestudo,
                   b.idusuario,
                   b.curso_id,
                   a.dtcadastro
      FROM tb_solicitacaobolsaestudos_solicitacaobolsaestudospermissao a
      RIGHT JOIN tb_solicitacaobolsaestudos b
      ON b.idsolicitacaobolsaestudo = a.idsolicitacaobolsaestudo 
            AND (a.idpermissao = 3 AND a.instatus = 1)
      WHERE a.idpermissao = 3
            AND a.instatus = 1 
            AND (GETDATE() BETWEEN a.dtcadastro AND DATEADD(MONTH, 6, a.dtcadastro))
      ORDER BY b.idusuario, b.idsolicitacaobolsaestudo;
END;

----------------------------------------------------------------------
----------------------------------------------------------------------
