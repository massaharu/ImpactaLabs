USE FIT_NEW
select *from tb_vestibular
select *from tb_vestibular_datas
select *from tb_vestibular_tipo
sp_pne_list
sp_estadocivil_list
sp_contatodepartamento_list
------------------ TABELAS ----------------------------------------
CREATE TABLE tb_ead_curso(
	idcurso int not null identity CONSTRAINT PK_ead_curso PRIMARY KEY(idcurso),
	descurso varchar(100) not null,
	instatus bit CONSTRAINT DF_ead_curso_instatus DEFAULT(1),
	dtcadastro datetime CONSTRAINT DF_ead_curso_dtcadastro DEFAULT(getdate())
)

CREATE TABLE tb_ead_modulos(
	idmodulo int not null identity CONSTRAINT PK_ead_modulos PRIMARY KEY(idmodulo),
	desmodulo varchar(50) not null,
	instatus bit CONSTRAINT DF_ead_modulos_instatus DEFAULT(1),
	dtcadastro datetime CONSTRAINT DF_ead_modulos_dtcadastro DEFAULT(getdate())
)
CREATE TABLE tb_ead_curso_modulos(
	idcurso int not null,
	idmodulo int not null,
	dtcadastro datetime CONSTRAINT DF_ead_curso_modulos_dtcadastro DEFAULT(getdate()),
	CONSTRAINT PK_ead_curso_modulos_idcurso_idmodulo PRIMARY KEY(idcurso, idmodulo),
	CONSTRAINT FK_ead_curso_modulos_ead_curso_idcurso FOREIGN KEY(idcurso)
	REFERENCES tb_ead_curso(idcurso),
	CONSTRAINT FK_ead_curso_modulos_ead_modulos_idmodulo FOREIGN KEY(idmodulo)
	REFERENCES tb_ead_modulos(idmodulo)
)
CREATE TABLE tb_ead_proc_seletivo(
	idprocessoseletivo int not null identity CONSTRAINT PK_ead_proc_seletivo PRIMARY KEY(idprocessoseletivo),
	idcurso	int not null,
	idestadocivil int,
	nrra	int,
	dessessionid	varchar(200),
	desnome	varchar(200),
	descep	varchar(8),
	desendereco varchar(500),
	desbairro	varchar(200),
	descidade	varchar(200),
	desuf		char(2),
	desnumero	varchar(15),
	descomplemento	varchar(200),
	desfoneres	varchar(20),
	desfonecom	varchar(20),
	desfonecel	varchar(20),
	desemail	varchar(200),
	desrg		char(9),
	descpf		char(11),
	dtnascimento	date,
	desorgaoexpedidor	varchar(5),
	desufemissor	char(2),
	desnacionalidade	varchar(100),
	dessexo	char(1),
	desempresa	varchar(200),
	descargo	varchar(200),
	desinstituicao	varchar(200),
	intreinamento	bit,	
	dtcadastro datetime CONSTRAINT DF_ead_proc_seletivo_dtcadastro DEFAULT(getdate()),
	CONSTRAINT FK_ead_proc_seletivo_estadocivil_idestadocivil FOREIGN KEY(idestadocivil)
	REFERENCES tb_estadocivil(idestadocivil),
	CONSTRAINT FK_ead_proc_seletivo_ead_curso_idcurso FOREIGN KEY(idcurso)
	REFERENCES tb_ead_curso(idcurso)
)

CREATE TABLE tb_ead_proc_seletivo_modulos(
	idprocessoseletivo int not null,
	idmodulo int not null,
	dtcadastro datetime CONSTRAINT DF_ead_proc_seletivo_modulos_dtcadastro DEFAULT(getdate())
	CONSTRAINT PK_ead_proc_seletivo_modulos_idprocessoseletivo_idmodulo PRIMARY KEY(idprocessoseletivo, idmodulo),
	CONSTRAINT FK_ead_proc_seletivo_modulos_ead_proc_seletivo_idprocessoseletivo FOREIGN KEY(idprocessoseletivo)
	REFERENCES tb_ead_proc_seletivo(idprocessoseletivo),
	CONSTRAINT FK_ead_proc_seletivo_modulos_ead_modulos_idmodulo FOREIGN KEY(idmodulo)
	REFERENCES tb_ead_modulos(idmodulo)
)
CREATE TABLE tb_ead_proc_seletivo_pne(
	idprocessoseletivo int not null,
	idpne	int not null,
	despneoutros	varchar(200),
	dtcadastro	datetime CONSTRAINT DF_ead_proc_seletivo_pne_dtcadastro DEFAULT(getdate())
	CONSTRAINT PK_ead_proc_seletivo_pne_idprocessoseletivo_idpne PRIMARY KEY(idprocessoseletivo, idpne),
	CONSTRAINT FK_ead_proc_seletivo_pne_ead_proc_seletivo_idprocessoseletivo FOREIGN KEY(idprocessoseletivo)
	REFERENCES tb_ead_proc_seletivo(idprocessoseletivo),
	CONSTRAINT FK_ead_proc_seletivo_pne_pne_tipos_idpne FOREIGN KEY(idpne)
	REFERENCES tb_pne_tipos(idpne)
)

/*truncate table */select *from tb_ead_curso
/*truncate table */select *from tb_ead_modulos
/*truncate table */select *from tb_ead_curso_modulos
/*truncate table */select *from tb_ead_proc_seletivo
/*truncate table */select *from tb_ead_proc_seletivo_modulos
/*truncate table */select *from tb_ead_proc_seletivo_pne


select *from tb_proc_seletivo_graduacao
select *from tb_proc_seletivo_graduacao_curso
select *from tb_proc_seletivo_graduacao_pne
select *from tb_pne_tipos

--------------------- PROCEDURES ------------------------------------
----------------- SAVES ---------------------------------------------
	-- [ead_curso]
CREATE PROC sp_ead_curso_save
(@descurso varchar(50))
AS
/*
app: FIT_NEW
url: /simpacweb/fit/adm_ead/ajax/ead-curso_save.php
data: 2013-01-30 
author: Massa
*/
BEGIN
	SET NOCOUNT ON
		INSERT tb_ead_curso
		(descurso)
		VALUES
		(@descurso)
	SET NOCOUNT OFF
	
	SELECT SCOPE_IDENTITY() 
	AS idcurso
END
sp_ead_curso_save 'Marketing Digital'
sp_ead_curso_save 'Arquitetura de Informação'

	-- [ead_modulos]
CREATE PROC sp_ead_modulos_save
(@desmodulo varchar(50))
AS
/*
app: FIT_NEW
url: /simpacweb/fit/adm_ead/ajax/ead-modulos_save.php
data: 2013-01-30 
author: Massa
*/
BEGIN
	SET NOCOUNT ON
		INSERT tb_ead_modulos
		(desmodulo)
		VALUES
		(@desmodulo)
	SET NOCOUNT OFF
	
	SELECT SCOPE_IDENTITY() 
	AS idmodulo
END

sp_ead_modulos_save 'Módulo 01'
sp_ead_modulos_save 'Módulo 02'
sp_ead_modulos_save 'Módulo 03'
sp_ead_modulos_save 'Módulo 04'
sp_ead_modulos_save 'Módulo 05'
sp_ead_modulos_save 'Módulo 06'
sp_ead_modulos_save 'Módulo Obrigatório'
sp_ead_modulos_save 'Curso EAD Completo'

 -- [ead_curso_modulos]
 CREATE PROC sp_ead_curso_modulos_save
(@idcurso int, @idmodulo int)
AS
/*
app: FIT_NEW
url: /simpacweb/fit/adm_ead/ajax/ead-curso-modulos_save.php
data: 2013-01-30 
author: Massa
*/
BEGIN
	SET NOCOUNT ON
		INSERT tb_ead_curso_modulos
		(idcurso, idmodulo)
		VALUES
		(@idcurso, @idmodulo)
	SET NOCOUNT OFF
END

sp_ead_curso_modulos_save 1, 1
sp_ead_curso_modulos_save 1, 2
sp_ead_curso_modulos_save 1, 3
sp_ead_curso_modulos_save 2, 1
sp_ead_curso_modulos_save 2, 2
sp_ead_curso_modulos_save 2, 3
sp_ead_curso_modulos_save 2, 4
sp_ead_curso_modulos_save 2, 5
sp_ead_curso_modulos_save 2, 6
sp_ead_curso_modulos_save 2, 7
sp_ead_curso_modulos_save 2, 8

	-- [ead_proc_seletivo]
CREATE PROC sp_ead_proc_seletivo_save	
(
	@idcurso	int ,
	@idestadocivil int,
	@nrra	int,
	@dessessionid	varchar(200),
	@desnome	varchar(200),
	@descep	varchar(8),
	@desendereco varchar(500),
	@desbairro	varchar(200),
	@descidade	varchar(200),
	@desuf		char(2),
	@desnumero	varchar(15),
	@descomplemento	varchar(200),
	@desfoneres	varchar(20),
	@desfonecom	varchar(20),
	@desfonecel	varchar(20),
	@desemail	varchar(200),
	@desrg		char(9),
	@descpf		char(11),
	@dtnascimento	date,
	@desorgaoexpedidor	varchar(5),
	@desufemissor	char(2),
	@desnacionalidade	varchar(100),
	@dessexo	char(1),
	@desempresa	varchar(200),
	@descargo	varchar(200),
	@desinstituicao	varchar(200),
	@intreinamento	bit	
)
AS
/*
app: FIT_NEW
url:  /ead/ajax/processo-seletivo.crud.php
data: 2013-01-30 
author: Massa
*/
BEGIN
	SET NOCOUNT ON
		INSERT INTO tb_ead_proc_seletivo
		(
			idcurso,
			idestadocivil,
			nrra,
			dessessionid,
			desnome,
			descep,
			desendereco,
			desbairro,
			descidade,
			desuf,
			desnumero,
			descomplemento,
			desfoneres,
			desfonecom,
			desfonecel,
			desemail,
			desrg,
			descpf,
			dtnascimento,
			desorgaoexpedidor,
			desufemissor,
			desnacionalidade,
			dessexo,
			desempresa,
			descargo,
			desinstituicao,
			intreinamento
		)
		VALUES
		(
			@idcurso,
			@idestadocivil,
			@nrra,
			@dessessionid,
			@desnome,
			@descep,
			@desendereco,
			@desbairro,
			@descidade,
			@desuf,
			@desnumero,
			@descomplemento,
			@desfoneres,
			@desfonecom,
			@desfonecel,
			@desemail,
			@desrg,
			@descpf,
			@dtnascimento,
			@desorgaoexpedidor,
			@desufemissor,
			@desnacionalidade,
			@dessexo,
			@desempresa,
			@descargo,
			@desinstituicao,
			@intreinamento
		)
	SET NOCOUNT OFF
	SELECT SCOPE_IDENTITY() AS idprocessoseletivo
END		

	-- [ead_proc_seletivo_modulos]
CREATE PROC sp_ead_proc_seletivo_modulos_save
(@idprocessoseletivo int, @idmodulo int)	
AS
/*
app: FIT_NEW
url:  /ead/ajax/processo-seletivo.crud.php
data: 2013-01-30 
author: Massa
*/
BEGIN
	SET NOCOUNT ON
		INSERT INTO tb_ead_proc_seletivo_modulos
		(idprocessoseletivo, idmodulo)
		VALUES
		(@idprocessoseletivo, @idmodulo)
	SET NOCOUNT OFF
END

	-- [ead_proc_seletivo_pne]
CREATE PROC sp_ead_proc_seletivo_pne_save
(@idprocessoseletivo int, @idpne int, @despneoutros varchar(200) )
AS
/*
app: FIT_NEW
url:  /ead/ajax/processo-seletivo.crud.php
data: 2013-01-30 
author: Massa
*/
BEGIN
	SET NOCOUNT ON
		INSERT INTO tb_ead_proc_seletivo_pne
		(idprocessoseletivo, idpne, despneoutros)
		VALUES
		(@idprocessoseletivo, @idpne, @despneoutros)
	SET NOCOUNT OFF
END	
-------------------- LISTS ----------------
	-- [ead_curso]
CREATE PROC sp_ead_curso_list
AS
/*
app: FIT_NEW
url: /ead/processo-seletivo.php
data: 2013-01-30 
author: Massa
*/
BEGIN
	SELECT idcurso, descurso, instatus, dtcadastro 
	from tb_ead_curso
END
	
-------------------- GET ---------------------
	-- [ead_curso_modulos]
CREATE PROC sp_ead_modulosbycurso_get 1
(@idcurso int)
AS	
/*
app: FIT_NEW
url: /ead/ajax/processo-seletivo-modulosbycurso_get.php
data: 2013-01-30 
author: Massa
*/
BEGIN
	SELECT a.idcurso,
		   a.descurso,	
		   b.idmodulo,
		   b.desmodulo,
		   b.instatus,
		   b.dtcadastro
	FROM tb_ead_curso a	
	INNER JOIN tb_ead_curso_modulos c
	ON c.idcurso = a.idcurso
	INNER JOIN tb_ead_modulos b
	ON b.idmodulo = c.idmodulo
	WHERE a.idcurso = @idcurso	   
END	