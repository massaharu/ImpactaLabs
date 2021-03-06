USE FIT_NEW
----------------------------------
--------- TABLE ------------------
----------------------------------

CREATE TABLE tb_faleconoscofit_midias(
	idfaleconoscofitmidia int IDENTITY CONSTRAINT PK_faleconoscofit_midias PRIMARY KEY,
	desfaleconoscofitmidia varchar(200),
	instatus bit CONSTRAINT DF_faleconoscofit_midias_instatus DEFAULT 1,
	dtcadastro datetime CONSTRAINT DF_faleconoscofit_midias_dtcadastro DEFAULT getdate()
)

--INSERT INTO tb_faleconoscofit_midias
--(desfaleconoscofitmidia)
--VALUES
--('Indique um Amigo')
--('Proxis Landing Page'),
--('Ganhe R$ 200,00 de crédito'),
--('Pré-inscrição - Colégio Impacta'),
--('Ganhe R$ 200,00 de crédito - LandingPage'),
--('Formulário de Pré-inscrição Pós-Graduação'),
--('Ganhe R$ 500,00 de crédito'),
--('Contato FIES'),
--('Formulário de Graduação - Processo Seletivo'),
--('Quero mais informações'),
--('Contato - Faculdade Impacta')

SELECT * FROM tb_faleconoscofit_midias

;
---------------------------------------
--------- PROCEDURES ------------------
---------------------------------------
ALTER PROC sp_faleconoscofit_usuarios_edit
(
	@idusuario int,
	@idfaleconoscofitmidia int,
	@nrprioridade int,
	@desemailcc varchar(500)
	
)
AS
/*
app: FIT
url:
data: 11/03/2015
autor: Maluf
*/
BEGIN
 
	UPDATE tb_faleconoscofit_usuarios
	SET desemailcc = @desemailcc, nrprioridade = @nrprioridade
	WHERE 
		idusuario = @idusuario AND
		idfaleconoscofitmidia = @idfaleconoscofitmidia

END
--
SELECT * FROM tb_faleconoscofit_usuarios where idfaleconoscofitmidia = 16

--INSERT INTO tb_faleconoscofit_usuarios
--SELECT idusuario, instatus, GETDATE(), 20, nrprioridade, nrsequencia, NULL  FROM tb_faleconoscofit_usuarios where idfaleconoscofitmidia = 16
--------------------------------------- 
CREATE PROC sp_faleconosco_midias_list
(@instatus bit = NULL)
AS
/*
app: FIT
url:
data: 11/03/2015
autor: Maluf
*/
BEGIN

	IF @instatus IS NULL
	BEGIN
	
		SELECT
			idfaleconoscofitmidia,
			desfaleconoscofitmidia,
			instatus,
			dtcadastro
		FROM tb_faleconoscofit_midias
		
	END
	ELSE
	BEGIN
	
		SELECT
			idfaleconoscofitmidia,
			desfaleconoscofitmidia,
			instatus,
			dtcadastro
		FROM tb_faleconoscofit_midias
		WHERE instatus = @instatus
	END
END
---------------------------------------
ALTER proc [dbo].[sp_dtenviofaleconoscofit_save]
(
	@idusuario int,
	@idfaleconoscofitmidia int = NULL
)
AS
/*
app: FIT
url:
data: 11/03/2015
autor: Maluf
*/
BEGIN

	IF @idfaleconoscofitmidia IS NULL
	BEGIN
	
		update tb_faleconoscofit_usuarios 
		set 
			dtenvio_idusuario = GETDATE()
		where 
			idusuario = @idusuario 
	END
	ELSE
	BEGIN
		-----------------------------------------------------
		DECLARE 
			@nrsequenciaatual int, 
			@nrsequencialimite int, 
			@dtenvio datetime
		-----------------------------------------------------
		SELECT 
			@nrsequenciaatual = nrsequencia,
			@nrsequencialimite = nrprioridade,
			@dtenvio = dtenvio_idusuario
		FROM tb_faleconoscofit_usuarios
		WHERE 
			idusuario = @idusuario AND 
			idfaleconoscofitmidia = @idfaleconoscofitmidia
		-----------------------------------------------------			
		IF @nrsequenciaatual < @nrsequencialimite
		BEGIN			
			SET @nrsequenciaatual = @nrsequenciaatual + 1
		END
		
		IF @nrsequenciaatual = @nrsequencialimite
		BEGIN			
			SET @nrsequenciaatual = 0
			SET @dtenvio = GETDATE()
		END
		-----------------------------------------------------
		UPDATE tb_faleconoscofit_usuarios 
		SET 
			dtenvio_idusuario = @dtenvio,
			nrsequencia = @nrsequenciaatual
		WHERE 
			idusuario = @idusuario AND 
			idfaleconoscofitmidia = @idfaleconoscofitmidia
		-----------------------------------------------------
	END
END

--

sp_faleconoscofit_usuario_bydepto_get 1, 11
sp_dtenviofaleconoscofit_save 2049, 11

SELECT * FROM tb_faleconoscofit_usuarios
WHERE idfaleconoscofitmidia = 11
ORDER BY dtenvio_idusuario

UPDATE tb_faleconoscofit_usuarios
SET desemailcc = 'Marta@impacta.com.br;'
WHERE idusuario = 2049 AND idfaleconoscofitmidia = 11

---------------------------------------

ALTER proc [dbo].[sp_faleconoscofit_usuario_bydepto_get]
(
	@idepartamento int,
	@idfaleconoscofitmidia int = NULL
)
AS
/*
app: FIT
url:
data: 11/03/2015
autor: Maluf
*/
BEGIN
	
	IF @idfaleconoscofitmidia IS NULL
	BEGIN
	
		select top 1
			a.idusuario, 
			c.CdEMail, 
			a.dtenvio_idusuario
		from tb_faleconoscofit_usuarios a 
		inner join tb_faleconoscofit_usuariosxdepartamentos b on a.idusuario = b.idusuario
		inner join Simpac..tb_usuario c on a.idusuario = c.IdUsuario
		where 
			a.instatus = 1 and 
			b.idepartamento = @idepartamento
		GROUP BY 
			a.idusuario, 
			c.CdEMail, 
			a.dtenvio_idusuario
		order by a.dtenvio_idusuario
	END
	ELSE 
	BEGIN
	
		SELECT TOP 1
			a.idusuario, 
			c.CdEMail, 
			a.desemailcc,
			a.dtenvio_idusuario,
			a.idfaleconoscofitmidia,
			a.nrprioridade,
			a.nrsequencia
		FROM tb_faleconoscofit_usuarios a 
		INNER JOIN Simpac..tb_usuario c on a.idusuario = c.IdUsuario
		WHERE 
			a.instatus = 1 AND 
			--b.idepartamento = 1 AND 
			a.idfaleconoscofitmidia = @idfaleconoscofitmidia
		ORDER BY a.dtenvio_idusuario
	END
END
--
sp_faleconoscofit_usuario_bydepto_get 1, 1 
GO
sp_faleconoscofit_usuario_bydepto_get 1, 2 
GO
sp_faleconoscofit_usuario_bydepto_get 1, 3 
GO
sp_faleconoscofit_usuario_bydepto_get 1, 4 
GO
sp_faleconoscofit_usuario_bydepto_get 1, 5 
GO
sp_faleconoscofit_usuario_bydepto_get 1, 6
GO
sp_faleconoscofit_usuario_bydepto_get 1, 7
GO
sp_faleconoscofit_usuario_bydepto_get 1, 8 
GO
sp_faleconoscofit_usuario_bydepto_get 1, 9
GO
sp_faleconoscofit_usuario_bydepto_get 1, 10
GO
sp_faleconoscofit_usuario_bydepto_get 1, 11



---------------------------------------
ALTER proc [dbo].[sp_faleconoscofit_usuario_list]
(@idfaleconoscofitmidia int = NULL)
AS
/*
app: FIT
url: /simpacweb/fit/atendimento/fale_conosco/json/listUsuarioFaleConoscoFIT.php
data: 11/03/2015
autor: Maluf
*/
BEGIN

	IF @idfaleconoscofitmidia IS NULL
	BEGIN
		select 
			a.idusuario,
			b.NmCompleto as desusuario,
			NULL as instatus,
			NULL as dtenvio_idusuario,
			NULL as idfaleconoscofitmidia,
			NULL as nrprioridade,
			NULL as nrsequencia,
			NULL as desemailcc  
		from tb_faleconoscofit_usuarios a
		inner join Simpac..tb_usuario b on a.idusuario = b.IdUsuario
		group by
			a.idusuario,
			b.NmCompleto
		order by b.NmCompleto 
	END
	ELSE
	BEGIN
		select 
			(ROW_NUMBER() OVER(ORDER BY a.instatus DESC, a.dtenvio_idusuario, b.NmCompleto  DESC)) AS row,
			a.idusuario,
			b.NmCompleto as desusuario,
			a.instatus,
			a.dtenvio_idusuario,
			a.idfaleconoscofitmidia,
			a.nrprioridade,
			a.nrsequencia,
			a.desemailcc 
		from tb_faleconoscofit_usuarios a
		inner join Simpac..tb_usuario b on a.idusuario = b.IdUsuario
		where 
			a.idfaleconoscofitmidia = @idfaleconoscofitmidia
		order by 
			a.instatus DESC,
			a.dtenvio_idusuario,
			b.NmCompleto 
	END
END
--
sp_faleconoscofit_usuario_list 9

SELECT * FROM tb_faleconoscofit_usuarios
---------------------------------------
ALTER proc [dbo].[sp_faleconoscofit_usuario_add]
(
	@idusuario int, 
	@iddepto int, 
	@idfaleconoscofitmidia int, 
	@nrprioridade int, 
	@desemailcc varchar(300)
)
AS
/*
app: FIT
url: /simpacweb/fit/atendimento/fale_conosco/json/listUsuarioFaleConoscoFIT.php
data: 11/03/2015
autor: Maluf
*/

BEGIN

	IF @idfaleconoscofitmidia <> 0
	BEGIN
	
		insert into tb_faleconoscofit_usuarios
		(idusuario, idfaleconoscofitmidia, nrprioridade, nrsequencia, desemailcc)
		values
		(@idusuario, @idfaleconoscofitmidia, @nrprioridade, 0, @desemailcc)
		
	END
	ELSE
	BEGIN
	
		insert into tb_faleconoscofit_usuarios
		SELECT @idusuario, 1, getdate(), idfaleconoscofitmidia, @nrprioridade, 0, @desemailcc 
		FROM tb_faleconoscofit_midias
	
	END
	
	IF NOT EXISTS(
		SELECT 
			* 
		FROM tb_faleconoscofit_usuariosxdepartamentos
		WHERE 
			idusuario = @idusuario AND
			idepartamento = @iddepto
	)
	BEGIN
		insert into tb_faleconoscofit_usuariosxdepartamentos(idusuario,idepartamento)
		values(@idusuario,@iddepto)
	END
END
---------------------------------------
---------------------------------------

SELECT b.nmcompleto, a.* 
FROM tb_faleconoscofit_usuarios a 
INNER JOIN Simpac..tb_usuario b ON b.idusuario = a.idusuario
ORDER BY a.idfaleconoscofitmidia, a.idusuario

SELECT * FROM tb_faleconoscofit_usuariosxdepartamentos

SELECT GETDATE() - 1

SELECT * FROM tb_faleconoscofit_usuarios a
ORDER BY a.idfaleconoscofitmidia, a.idusuario

SELECT * FROM tb_faleconoscofit_usuariosxdepartamentos

sp_faleconoscofit_usuario_bydepto_get 1, 11

SELECT * FROM Vendas..tb_midias WHERE idmidiatipo = 13

INSERT INTO Vendas..tb_midias 
(idmidiatipo, desmidia)
VALUES
(13, 'Site novo FIT - Vestibular 2015 (Landing Page)')

SELECT TOP 100 * FROM vendas..tb_pessoas order by idpessoa desc
SELECT * FROM vendas..tb_pessoas where idpessoa = 1353331
SELECT * FROM vendas..tb_midias where idmidiatipo = 13
SELECT * FROM vendas..tb_midiapessoas WHERE idpessoa = 1353371
SELECT * FROM vendas..tb_pessoashistoricos WHERE idpessoa = 1353371
SELECT * FROM vendas..tb_pessoashistoricos_tipos WHERE idhistorico = 21131579
SELECT * FROM vendas..tb_pessoashistoricostipos
 



SELECT * FROM tb_faleconoscofit_log ORDER BY DESORIGEM

SELECT desorigem, COUNT(*) FROM tb_faleconoscofit_log
WHERE RTRIM(LTRIM(desorigem)) <> ''
GROUP BY desorigem

SELECT * FROM vendas..tb_midias where idmidiatipo = 13

SELECT * FROM SImpac..tb_usuario
Simpac..sp_usuariosativosfit_list
sp_faleconoscofit_usuario_list

SELECT * FROM tb_faleconoscofit_midias


--
select 
	a.idusuario, 
	c.CdEMail, 
	a.dtenvio_idusuario
from tb_faleconoscofit_usuarios a 
inner join tb_faleconoscofit_usuariosxdepartamentos b on a.idusuario = b.idusuario
inner join Simpac..tb_usuario c on a.idusuario = c.IdUsuario
where 
	a.instatus = 1 and 
	b.idepartamento = 1
GROUP BY 
	a.idusuario, 
	c.CdEMail, 
	a.dtenvio_idusuario
order by a.dtenvio_idusuario

SELECT * FROM tb_pessoashistoricos
SELECT * FROM VENDAS..tb_pessoashistoricostipos
SELECT * FROM VENDAS..tb_midias


			
			
			
		
DECLARE @TXT VARCHAR(200) = 'Vestibular 2015 (Landing Page) - {{IP: 201.19.143.163}} - {{E-Mail: Tabata@impacta.com.br}}'


		
SELECT 
REPLACE(LEFT(SUBSTRING(@TXT, CHARINDEX('{{IP: ', @TXT) +6, 54),CHARINDEX('}}',SUBSTRING(@TXT, CHARINDEX('{{IP: ', @TXT) +6, 54)) - 1),' ',''),
CHARINDEX('}}',SUBSTRING(@TXT, CHARINDEX('{{IP: ', @TXT) +6, 54))
FROM vendas	
			
SELECT CHARINDEX('{{IP:', @TXT)		
SELECT CHARINDEX('imp', @TXT)			
			