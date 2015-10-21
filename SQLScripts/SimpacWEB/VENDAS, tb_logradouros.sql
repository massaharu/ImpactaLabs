ALTER TABLE tb_contatotipos ADD
instatus int not null,
CONSTRAINT contatotipos_DF_INSTATUS DEFAULT (1) for instatus

CREATE PROCEDURE sp_contatotipos_instatus
(@idcontatotipo int)

AS

IF(SELECT instatus FROM tb_contatotipos 
WHERE idcontatotipo = @idcontatotipo) = 0 
	BEGIN 
		UPDATE tb_contatotipos
		SET instatus = 1
		WHERE idcontatotipo = @idcontatotipo
	END
ELSE
	BEGIN
		UPDATE tb_contatotipos
		SET instatus = 0
		WHERE idcontatotipo = @idcontatotipo
	END
	
CREATE PROCEDURE sp_contatotipos_list

AS

SELECT a.descontatotipo, a.idcontatotipo
FROM tb_contatotipos a
WHERE instatus = 1

CREATE PROCEDURE sp_contatotipos_save
(@descontatotipo varchar(100))
AS
	INSERT INTO tb_contatotipos
	(descontatotipo)
	VALUES
	(@descontatotipo)
	
CREATE PROCEDURE sp_contatotipos_delete
(@idcontatotipo int)
AS
	DELETE tb_contatotipos
	WHERE idcontatotipo = @idcontatotipo
	
	
CREATE PROCEDURE sp_contatotipos_update
(@idcontatotipo int,@descontatotipo varchar(100))
AS
	UPDATE tb_contatotipos
	SET descontatotipo = @descontatotipo
	WHERE idcontatotipo = @idcontatotipo


ALTER TABLE tb_logradouros ADD
instatus int not null,
CONSTRAINT logradouros_DF_INSTATUS DEFAULT (1) FOR instatus

CREATE PROCEDURE sp_logradouros_instatus
(@idlogradouro int)

AS

IF(SELECT instatus FROM tb_logradouros
WHERE idlogradouro = @idlogradouro) = 0 
	BEGIN 
		UPDATE tb_logradouros
		SET instatus = 1
		WHERE idlogradouro = @idlogradouro
	END
ELSE
	BEGIN
		UPDATE tb_logradouros
		SET instatus = 0
		WHERE idlogradouro = @idlogradouro
	END




SELECT *FROM tb_contatotipos

sp_contatotipos_instatus 1

sp_contatotipos_list

sp_contatotipos_save asdasd

sp_contatotipos_delete 5

sp_contatotipos_update 4, Nextel


USE Vendas

SELECT *FROM tb_logradouros

SELECT *FROM tb_logradourotipos

SELECT *FROM tb_bairros

SELECT *FROM tb_enderecotipos



	
	
sp_logradourobytipo_bairro_get 2, 27

sp_logradouros_instatus 1

use vendas

sp_logradourobytipo_bairro_get

CREATE PROCEDURE sp_logradourobytipo_bairro_get
(@idlogradourotipo int, @idbairro int)
AS
	SELECT a.idlogradouro, a.deslogradouro FROM tb_logradouros a
	WHERE idlogradourotipo = @idlogradourotipo AND
	idbairro = @idbairro