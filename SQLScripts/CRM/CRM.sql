sp_text_object_show sp_curso_get

USE Vendas
GO
sp_departamento_list

SELECT *FROm tb_departamentos

sp_paises_list

sp_cargo_list
---------------------------------------------------------------------
---------------------------------------------------------------------
---------FORM(MEUS DADOS)--------------------------------------------
use simpac
go
SELECT *FROM tb_usuario
where idusuario = 1495

exec sp_usuario_list 1495

exec sp_usuario_get 1495

SELECT *FROM tb_pessoas
where idusuario like '%massaharu%'

exec sp_usuario_list 1495
sp_text_object_show sp_usuario_set
------UPDATE PROCEDURE------------------------------------------------
ALTER PROC sp_usuariobasic_set
(@IdUsuario int, @NmCompleto varchar(100),@NmUsuario varchar(50),@NrRamal char(10),@nrcpf char(11),@Sexo char(1))
AS
/*
app:Simpacweb\CRM
url:simpacweb\class\class.usuario.php
data: 2012-11-08 11:06:45.657
user: Massaharu
*/

BEGIN
	BEGIN TRAN
		SET NOCOUNT ON
		UPDATE tb_usuario
		SET NmCompleto = @NmCompleto,
			NmUsuario = @NmUsuario,
			NrRamal = @NrRamal,
			nrcpf = @nrcpf,
			Sexo = @Sexo
		WHERE IdUsuario	= @IdUsuario
		SET NOCOUNT OFF
	IF @@ERROR <> 0
		ROLLBACK TRAN
	ELSE
		COMMIT TRAN
END		
--------------------------------------------------------------------------
BEGIN TRAN
exec sp_usuariobasic_set
	@idUsuario = 1495,
	@NmCompleto = 'Massaharu Kunikane',
	@NmUsuario = 'massaharu',
	@NrRamal = '2200',
	@nrcpf = '39539063809',
	@Sexo = 'M'
ROLLBACK

COMMIT TRAN

SELECT @@TRANCOUNT

sp_text_object_show sp_usuariobasic_set
--------------------------------------------------------------------------
--------------------------------------------------------------------------
----------BOTAO SEGUIR (Verifica se o usuario atual segue tal usuario)-----
ALTER PROC sp_pessoaseguidas_isseguindo
(@idpessoa int, @idusuario int)
AS
/*
app:Simpacweb\CRM
url:CRM\inc\class\objects\pessoa.class.php
data: 2012-11-13 08:25:22.970
user: Massaharu
*/
BEGIN
	SELECT COUNT(*) AS TOTAL FROM tb_pessoaseguidas
	WHERE idpessoa = @idpessoa AND
		  idusuario = @idusuario
END


sp_pessoaseguidas_isseguindo 65, 1495
----------------------------------------------------
SELECT *FROM tb_pessoaseguidas
SELECT *FROM simpac..tb_usuario
SELECT *FROM Vendas..tb_pessoas

SELECT a.nmusuario as seguidor, count(b.despessoa) as seguido from Simpac..tb_usuario a
INNER JOIN tb_pessoaseguidas c
ON c.idusuario = a.idusuario
INNER JOIN tb_pessoas b
ON b.idpessoa = c.idpessoa
GROUP BY a.nmusuario
ORDER by seguidor



