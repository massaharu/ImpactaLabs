USE DEV_TESTE

CREATE TABLE tb_mei_contato(
	id_mei_contato		INT NOT NULL IDENTITY,
	desid_faleconosco	INT,
	desip_cliente		VARCHAR(100),
	dessession_id		VARCHAR(100),
	desmeinome			VARCHAR(50),
	desmeiemail			VARCHAR(50),
	desmeiddd			VARCHAR(3),
	desmeitelefone		VARCHAR(9),
	desmeicomentario	VARCHAR(400),
	dtcadastro			DATETIME DEFAULT(GETDATE())
	CONSTRAINT PK_id_mei_contato PRIMARY KEY(id_mei_contato)
)
-------------------------------------------------------------------------------------------------------------
CREATE PROC sp_mei_contato_save 
(@desid_faleconosco INT, @desip_cliente VARCHAR(100), @dessession_id VARCHAR(100), @desmeinome VARCHAR(50), @desmeiemail VARCHAR(50), @desmeiddd VARCHAR(3), @desmeitelefone VARCHAR(9), @desmeicomentario VARCHAR(400))
AS
INSERT tb_mei_contato (desid_faleconosco, desip_cliente, dessession_id, desmeinome, desmeiemail, desmeiddd, desmeitelefone, desmeicomentario, dtcadastro)
VALUES
(@desid_faleconosco, @desip_cliente, @dessession_id, @desmeinome, @desmeiemail, @desmeiddd, @desmeitelefone, @desmeicomentario, GETDATE())
-------------------------------------------------------------------------------------------------------------
exec sp_mei_contato_save 
	@desid_faleconosco = 2,
	@desip_cliente = '172.56.59',
	@dessession_id = 'sdf565ds45f6s54df6s645df46s',
	@desmeinome = 'Nome',
	@desmeiemail =  'massa@yahoo.com.br',
	@desmeiddd = '11',
	@desmeitelefone = '45895623',
	@desmeicomentario = 'asdas asd asd d g sfg sghsdffghdgndf '
-------------------------------------------------------------------------------------------------------------
USE Impacta6
GO
SELECT *FROM tb_mei_contato

BEGIN TRAN
TRUNCATE TABLE tb_mei_contato
COMMIT

SELECT @@TRANCOUNT