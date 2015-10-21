ALTER TABLE tb_pessoajuridicatipos ADD
instatus int not null,
CONSTRAINT pessoajuridicatipos_DF_INSTATUS DEFAULT (1) for instatus

CREATE PROCEDURE sp_pessoajuridicatipos_instatus
(@idpessoajuridicatipo int)

AS

IF(SELECT instatus FROM tb_pessoajuridicatipos 
WHERE idpessoajuridicatipo = @idpessoajuridicatipo) = 0 
	BEGIN 
		UPDATE tb_pessoajuridicatipos
		SET instatus = 1
		WHERE idpessoajuridicatipo = @idpessoajuridicatipo
	END
ELSE
	BEGIN
		UPDATE tb_pessoajuridicatipos
		SET instatus = 0
		WHERE idpessoajuridicatipo = @idpessoajuridicatipo
	END

	
CREATE PROCEDURE sp_pessoajuridicatipos_list

AS

SELECT a.despessoajuridicatipo, a.idpessoajuridicatipo
FROM tb_pessoajuridicatipos a
WHERE instatus = 1

	
CREATE PROCEDURE sp_pessoajuridicatipos_save
(@despessoajuridicatipo varchar(100))
AS
	INSERT INTO tb_pessoajuridicatipos
	(despessoajuridicatipo)
	VALUES
	(@despessoajuridicatipo)
	
CREATE PROCEDURE sp_pessoajuridicatipos_delete
(@idpessoajuridicatipo int)
AS
	DELETE tb_pessoajuridicatipos
	WHERE idpessoajuridicatipo = @idpessoajuridicatipo	
	

CREATE PROCEDURE sp_pessoajuridicatipos_update
(@idpessoajuridicatipo int,@despessoajuridicatipo varchar(100))
AS
	UPDATE tb_pessoajuridicatipos
	SET despessoajuridicatipo = @despessoajuridicatipo
	WHERE idpessoajuridicatipo = @idpessoajuridicatipo
	


USE Vendas

select *from tb_pessoajuridicatipos

sp_pessoajuridicatipos_instatus 5

sp_pessoajuridicatipos_list

sp_pessoajuridicatipos_save teste

sp_pessoajuridicatipos_delete 9

sp_pessoajuridicatipos_update 7,testyuiyuies
	



	
