USE FIT_NEW

select *from tb_contato
select *from tb_contatoassunto

ALTER TABLE tb_contatoassunto ADD
CONSTRAINT DF_contatoassunto_instatus DEFAULT(1) for instatus,
CONSTRAINT PK_contatoassunto PRIMARY KEY(idcontatoassunto)

BEGIN TRAN
INSERT INTO tb_contatoassunto(desassunto)
VALUES('Curso')

sp_contatoassunto_get
---------- TABELAS --------------------------------------------
CREATE TABLE tb_ead_contato(
	idcontato	int not null identity CONSTRAINT PK_ead_contato PRIMARY KEY(idcontato),
	idcontatoassunto int not null,
	nrra	int,
	dessessionid	varchar(200),
	desnome	varchar(200),
	desemail varchar(200),
	desfonecomercial varchar(20),
	desfonecelular varchar(20),
	desmensagem	varchar(550),
	instatus	bit CONSTRAINT DF_ead_contato_instatus DEFAULT(1),
	dtcadastro	datetime CONSTRAINT DF_ead_contato_dtcadastro DEFAULT(getdate())		
)

select *from tb_ead_contato

---------- PROCEDURES --------------------------------------------
	-- save
CREATE PROC sp_ead_contato_save
(
	@idcontatoassunto int,
	@nrra	int,
	@dessessionid varchar(200),
	@desnome	varchar(200),
	@desemail varchar(200),
	@desfonecomercial varchar(20),
	@desfonecelular varchar(20),
	@desmensagem	varchar(550)
)
AS
/*
app: FIT_NEW
url:  /ead/ajax/duvidas.crud.php
data: 2013-01-30 
author: Massa
*/
BEGIN
	SET NOCOUNT ON
		INSERT INTO tb_ead_contato(
			idcontatoassunto,
			nrra,
			dessessionid,
			desnome,
			desemail,
			desfonecomercial,
			desfonecelular,
			desmensagem
		)
		VALUES
		(
			@idcontatoassunto,
			@nrra,
			@dessessionid ,
			@desnome,
			@desemail,
			@desfonecomercial ,
			@desfonecelular,
			@desmensagem
		)
	SET NOCOUNT OFF
	SELECT SCOPE_IDENTITY() AS idcontato
END