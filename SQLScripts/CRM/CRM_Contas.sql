------------------------------------------------------------------
---------------------- CONTAS ------------------------------------
----------------------------------------------------------------------
/******************************************************************/
/*****************************************************************/
/********************* TABELAS **********************************/
/***************************************************************/
/**************************************************************/
CREATE TABLE tb_contas(
	idconta		int not null identity constraint PK_tb_contas PRIMARY KEY (idconta),
	desconta	varchar(100) not null,
	dtcadastro	datetime constraint DF_contas_dtcadastro DEFAULT(getdate()) 
)
CREATE TABLE tb_contasusuarios(
	idconta		int not null,
	idusuario	int not null,
	dtcadastro  datetime constraint DF_contasusuarios_dtcadastro DEFAULT(getdate()),
	CONSTRAINT PK_contasusuarios_idconta_idusuario PRIMARY KEY(idconta,idusuario),
	CONSTRAINT FK_contasusuarios_contas_idconta FOREIGN KEY(idconta) 
	REFERENCES tb_contas(idconta)ON DELETE CASCADE
)
ALTER TABLE tb_contasusuarios ADD
incontaedit	bit CONSTRAINT DF_contasusuarios_incontaedit DEFAULT(0)

CREATE TABLE tb_contaspessoas(
	idconta		int not null,
	idpessoa	int not null,
	dtcadastro	datetime constraint DF_contaspessoas_dtcadastro DEFAULT(getdate()),
	CONSTRAINT PK_contaspessoas_idlista_idpessoa PRIMARY KEY(idconta,idpessoa),
	CONSTRAINT FK_contaspessoas_idconta FOREIGN KEY(idconta) 
	REFERENCES tb_contas(idconta)ON DELETE CASCADE,
	CONSTRAINT FK_contaspessoas_idpessoa FOREIGN KEY(idpessoa)
	REFERENCES tb_pessoas(idpessoa)
)
SELECT *FROM tb_contaspessoas
SELECT *FROM tb_contasusuarios
SELECT *FROM tb_contas


/******************************************************************/
/*****************************************************************/
/********************* PROCEDURES *******************************/
/***************************************************************/
/**************************************************************/
---------------------------------------------------------------
------------------- CONTAS -----------------------------------
-------------------------------------------------------------
-------------------------------------------------------------
-----------------(contas_save)-------------------------------
ALTER PROC [dbo].[sp_conta_save]
(@idconta int, @desconta varchar(100)
AS
/*
app: CRM
url: /CRM/inc/class/objects/contas.class.php
data: 2012-11-14 09:38:17.983
author: Massa
*/
BEGIN
	SET NOCOUNT ON
	IF @idconta <> 0
		BEGIN
			UPDATE tb_contas
			SET desconta = @desconta
			WHERE idconta = @idconta
			
			SET NOCOUNT OFF
			
			SELECT @idconta AS idconta
		END
	ELSE
		BEGIN		
			INSERT INTO tb_contas
			(desconta)
			VALUES
			(@desconta)			
			SET NOCOUNT OFF			
			SELECT SCOPE_IDENTITY() as idconta				
		END		
END

sp_conta_save
	@idconta = '',
	@desconta = '',
---------------------------------------------------------------
-----------------(contas_delete)-------------------------------
CREATE PROC sp_contas_delete
(@idconta int)
/*
app: SimpacCRM
url: /CRM/inc/class/objects/contas.class.php
data: 2012-11-14 09:38:17.983
author: Massa
*/
AS
BEGIN 
	DELETE tb_contas
	WHERE idconta = @idconta	
END

sp_contas_delete
	@idconta = 118
---------------------------------------------------------------
-----------------(contas_get)----------------------------------
ALTER PROC sp_contas_get
(@idconta int)
AS
/*
app: SimpacCRM
url: /CRM/inc/class/objects/contas.class.php
data: 2012-11-21 08:40:31.060
author: Massa
*/
BEGIN
	SELECT idconta, desconta FROM tb_contas
	WHERE idconta = @idconta
END	

sp_contas_get 1
---------------------------------------------------------------
-----------------(contas_list)---------------------------------
ALTER PROC sp_contas_list
AS
/*
app: SimpacCRM
url: /CRM/inc/class/objects/contas.class.php
data: 2012-11-21 08:40:31.060
author: Massa
*/
BEGIN
	SELECT idconta, desconta FROM tb_contas
	ORDER BY dtcadastro
END	
--------------------------------------------------------------
SELECT C.*, CU.*, CP.*, P.*, U.* FROM tb_Contas C
INNER JOIN tb_contasusuarios CU
ON CU.idconta = C.idconta
INNER JOIN Simpac..tb_Usuario U
ON U.IdUsuario = CU.idusuario
INNER JOIN tb_contaspessoas CP
ON CP.idconta = C.idconta
INNER JOIN tb_pessoas P
ON P.idpessoa = CP.idpessoa
---------------------------------------------------------------
------------------- CONTAS-USUARIOS ---------------------------
---------------------------------------------------------------
-----------------(contasusuarios_save)-------------------------
--ALTER PROC sp_contasusuario_save
--(@idconta int, @desconta varchar(100), @idusuario int)
--AS
--/*
--app: SimpacCRM
--url: /CRM/inc/class/objects/contas.class.php
--data: 2012-11-14 09:38:17.983
--author: Massa
--*/
--BEGIN
--	SET NOCOUNT ON
--	IF @idconta <> 0
--		BEGIN
--			UPDATE tb_contas
--			SET desconta = @desconta
--			WHERE idconta = @idconta
			
--			SET NOCOUNT OFF
			
--			SELECT @idconta AS idconta
--		END
--	ELSE
--		BEGIN
--			BEGIN TRAN
--				INSERT INTO tb_contas
--				(desconta)
--				VALUES
--				(@desconta)
				
--				SET NOCOUNT OFF
				
--				SELECT SCOPE_IDENTITY() as idconta
				
--				IF(SCOPE_IDENTITY() IS NOT NULL)
--					BEGIN
--						INSERT INTO tb_contasusuarios
--						(idconta, idusuario)
--						VALUES(SCOPE_IDENTITY(), @idusuario)
--					END
--				IF @@ERROR <> 0
--					ROLLBACK TRAN
--				ELSE
--					COMMIT TRAN	
--		END		
--END

alter PROC [dbo].[sp_contasusuario_save]
(@idconta int, @idusuario int)
AS
/*
app: SimpacCRM
url: /CRM/inc/class/objects/contas.class.php
data: 2012-11-14 09:38:17.983
author: Massa
descrição: Procedure usada somente na criação de uma nova conta passando o parâmetro 1
		   em incontaedit
*/
DELETE FROM tb_contasusuarios WHERE idconta = @idconta AND idusuario = @idusuario
INSERT INTO tb_contasusuarios (idconta, idusuario, incontaedit) VALUES(@idconta, @idusuario, 1)

sp_contasusuario_save
	@idconta = 1087,
	@idusuario = 1495
	
SELECT *FROM tb_contas
-----------------(contasusuarioshare_save)-------------------------
---------Compartilha uma conta com um usuário------------
ALTER PROC sp_contasusuarioshare_save
(@idconta int, @idusuario int)
AS
/*
app: SimpacCRM
url: /CRM/inc/class/objects/contas.class.php
data: 2012-11-14 09:38:17.983
author: Massa
descrição: Procedure usada somente para compartilhar uma conta passando o parâmetro 0
		   em incontaedit se o usuario atual não for o dono da conta
*/
BEGIN
	IF((SELECT incontaedit FROM tb_contasusuarios WHERE idconta = @idconta AND idusuario = @idusuario) = 1)
		BEGIN
			DELETE FROM tb_contasusuarios WHERE idconta = @idconta AND idusuario = @idusuario
			INSERT INTO tb_contasusuarios (idconta, idusuario, incontaedit) VALUES(@idconta, @idusuario, 1)
		END
	ELSE
		BEGIN
			DELETE FROM tb_contasusuarios WHERE idconta = @idconta AND idusuario = @idusuario
			INSERT INTO tb_contasusuarios (idconta, idusuario, incontaedit) VALUES(@idconta, @idusuario, 0)
		END
END


sp_contasusuarioshare_save
	@idconta = 1492, 
	@idusuario = 1498


---------------------------------------------------------------
-----------------(usuarioscontas_list)-------------------------
---------Todas as contas de um determinado usuario)------------
ALTER PROC sp_usuarioscontas_list
(@idusuario int)
AS
/*
app: SimpacCRM
url: /CRM/inc/class/objects/usuario.class.php
data: 2012-11-14 09:38:17.983
author: Massa
*/
BEGIN
	SELECT a.idconta, a.idusuario, a.dtcadastro, a.incontaedit,
		   b.desconta, count(c.idconta) as nrpessoas
	FROM tb_contasusuarios a
	INNER JOIN tb_contas b
	ON b.idconta = a.idconta 
	LEFT JOIN tb_contaspessoas c
	ON c.idconta = b.idconta
 	WHERE idusuario = @idusuario	
 	GROUP BY a.idconta,  a.idusuario, a.dtcadastro, a.incontaedit,
		   b.desconta
END

sp_usuarioscontas_list
	@idusuario = 1498

SELECT *FROM tb_contasusuarios	
SELECT *FROM tb_pessoas
---------------------------------------------------------------
-----------------(contasusuarios_list)-------------------------
---------Todas os usuarios de uma determinada conta------------
ALTER PROC sp_contasusuarios_list
(@idconta int)
AS
/*
app: SimpacCRM
url: /CRM/inc/class/objects/contas.class.php
data: 2012-11-29 
author: Massa
*/
BEGIN
	select a.idusuario, nmusuario, cdemail, nmcompleto, nmlogin, sexo, nrcpf, inatendente, nrpercentualdesconto, a.instatus, idnivel, a.iddepto, a.idcargo, idfranquia, centrocusto, ingerente, codigo, incorporativo, inatendenteativo, desdepartamento, descargo, 
		   e.idconta, e.desconta, e.dtcadastro as dtcadastro_conta, d.incontaedit
	from Simpac.dbo.tb_Usuario a 
	INNER JOIN Simpac.dbo.tb_Depto b ON a.iddepto = b.iddepto
	INNER JOIN Curriculo.dbo.tb_Cargos c ON a.idcargo = c.idcargo
	INNER JOIN Vendas.dbo.tb_contasusuarios d ON d.idusuario = a.idusuario
	INNER JOIN Vendas.dbo.tb_contas e ON e.idconta = d.idconta
	where d.idconta = @idconta
	order by nmcompleto
END

sp_contasusuarios_list
	@idconta = 1500
-----------------------------------------------------------------
-----------------(contasusuarios_delete)-------------------------
----------Desassocia um usuario de uma conta---------------------
CREATE PROC sp_contasusuarios_delete
(@idconta int, @idusuario int)
AS
/*
app: SimpacCRM
url: /CRM/inc/class/objects/contas.class.php
data: 2012-11-29 09:38:17.983
author: Massa
*/
BEGIN
	DELETE tb_contasusuarios
	WHERE idconta = @idconta AND
		  idusuario = @idusuario
END

sp_contasusuarios_delete
	@idconta = '',
	 @idusuario = ''
SELECT *FROM tb_contasusuarios	
---------------------------------------------------------------
------------------- CONTAS-PESSOAS ---------------------------
--------------------------------------------------------------
-----------------(contaspessoas_save)-------------------------
ALTER PROC [dbo].[sp_contaspessoas_save]
(@idconta int, @idpessoa int)
AS
/*
app: SimpacCRM
url: /CRM/inc/class/objects/contas.class.php
data: 2012-11-14 09:38:17.983
author: Massa
*/
BEGIN
	DELETE tb_contaspessoas WHERE idconta = @idconta AND idpessoa = @idpessoa
	INSERT INTO tb_contaspessoas (idconta, idpessoa) VALUES(@idconta, @idpessoa)
END

[sp_contaspessoas_save]
	@idconta = 169,
	@idpessoa = 48

SELECT *FROM tb_contaspessoas
-----------------------------------------------------------------
-----------------(contaspessoas_list)----------------------------	
---------Todas as pessoas de uma determinada conta---------------
CREATE PROC sp_contaspessoas_list
(
@idconta INT
)
AS
/*
app: SimpacCRM
url: /CRM/inc/class/objects/contas.class.php
data: 2012-11-14 09:38:17.983
author: Massa
*/
select 
a.idpessoa,
a.idpessoatipo,
a.despessoa,
a.desresumo,
a.dtcadastro,
a.idproprietario,
a.idpessoaimportancia,
b.despessoatipo,
c.despessoaimportancia,
d.idusuario,
d.nmlogin,
d.nmusuario,
a.idimagem,
e.dtnascimento as pf_dtnascimento,
e.dessexo as pf_dessexo,
e.idcargo as pf_idcargo,
e.iddepartamento as pf_iddepartamento,
e.idpessoapai as pf_idpessoapai,
e.nrniveldecisorio as pf_nrniveldecisorio,
f.iddepartamento as pj_iddepartamento,
f.idpessoajuridicatipo as pj_idpessoajuridicatipo,
f.vlreceita as pj_vlreceita,
f.idpessoapai as pj_idpessoapai,
g.despessoajuridicatipo,
h.idconta,
h.desconta,
i.dtcadastro as cadastropessoaconta
from tb_pessoas a
inner join tb_pessoatipos b on a.idpessoatipo = b.idpessoatipo
inner join tb_pessoaimportancias c on a.idpessoaimportancia = c.idpessoaimportancia
inner join simpac.dbo.tb_usuario d on a.idproprietario = d.IdUsuario
left join tb_pessoafisica e on a.idpessoa = e.idpessoa
left join tb_pessoajuridica f on a.idpessoa = f.idpessoa
left join tb_pessoajuridicatipos g on g.idpessoajuridicatipo = f.idpessoajuridicatipo
inner join tb_contaspessoas i on i.idpessoa = a.idpessoa
inner join tb_contas h on h.idconta = i.idconta 
where i.idconta = @idconta and a.indeletado = 0

sp_contaspessoas_list
	@idconta = 169
-----------------------------------------------------------------
-----------------(pessoascontas_list)----------------------------	
---------Todas as contas de uma determinada pessoa---------------
ALTER PROC sp_pessoascontas_list
(@idpessoa int)
AS
/*
app: SimpacCRM
url: /CRM/inc/class/objects/pessoa.class.php
data: 2012-11-14 09:38:17.983
author: Massa
*/
BEGIN
	SELECT a.idconta, a.desconta, a.dtcadastro,
		   b.idpessoa, b.despessoa
	FROM tb_contas a
	INNER JOIN tb_contaspessoas c
	ON a.idconta = c.idconta
	INNER JOIN tb_pessoas b
	ON b.idpessoa = c.idpessoa	
	WHERE c.idpessoa = @idpessoa
END

sp_pessoascontas_list
	@idpessoa = 47
--------------------------------------------------------------
-----------------(contaspessoas_remove)-----------------------	
-------------Desassocia uma pessoa de uma conta---------------
CREATE PROC sp_contaspessoa_delete
(@idconta int, @idpessoa int)
AS
/*
app: SimpacCRM
url: /CRM/inc/class/objects/contas.class.php
data: 2012-11-14 09:38:17.983
author: Massa
*/
BEGIN
	DELETE tb_contaspessoas
	WHERE idconta = @idconta AND
		  idpessoa = @idpessoa
END

sp_contaspessoa_delete
	@idconta = 169, 
	@idpessoa = 225
		
SELECT *FROM tb_contaspessoas
------------------------------------------------------------------
------------------------------------------------------------------
--Script que tira a duplicidade do campo contaedit em tb_contasusuarios
declare @idconta int
SET @idconta = 0
WHILE (@idconta <= (SELECT MAX(idusuario) FROM tb_contasusuarios))
	BEGIN
		UPDATE tb_contasusuarios
		SET incontaedit = 1
		WHERE idconta = @idconta AND
			  idusuario IN (SELECT MAX(idusuario) FROM tb_contasusuarios
							   WHERE idconta = @idconta
							   GROUP BY idconta
						   )
		SET @idconta = @idconta + 1  					   
	END	
------------------------------------------------------------------
------------------------------------------------------------------
SELECT *FROM Simpac.dbo.tb_usuario	
SELECT *FROM tb_pessoas  where idimagem is null
SELECT *FROM tb_contas
SELECT *FROM tb_contaspessoas where idpessoa = 225
SELECT *FROM tb_contasusuarios


sp_contasusuarioshare_save
	@idconta = 1108, 
	@idusuario = 1495

[sp_pessoa_get 63]

simpac..sp_usuarios_list 

--Todos usuarios de uma conta
SELECT a.desconta, a.idconta,   COUNT(b.idconta) as nrusuarios
FROM tb_contas a
INNER JOIN tb_contasusuarios b
ON b.idconta = a.idconta
GROUP BY a.desconta, a.idconta


SELECT idconta, COUNT(*) from tb_contasusuarios
group by idconta



