SELECT * FROM tb_usuario 
where InAtendente = 1 and InCorporativo = 0 and InStatus = 0 and IdUsuario < 100
order by dtadmissao

SELECT * FROM tb_usuario WHERE nmcompleto like '%tiago%'
WHERE idusuario = 41

--UPDATE tb_usuario
SET instatus = 1,
	incorporativo = 1
WHERE idusuario = 62

--criar usuario no banco
exec Simpac..sp_addusersystem 'B.Kalkevicius'
GO
--Atribuir permissão SimpacWeb
exec SimpacWeb..sp_permissaoauto_add 'B.Kalkevicius'
GO
--Atribuir link permissão SimpacWeb
exec SimpacWeb..sp_linkpermissao_add 'B.Kalkevicius'
GO
--Atribuir usuario no SimpacWeb beta 3
exec SimpacWeb..sp_userimpacwebbeta3_add 'B.Kalkevicius'
GO
--Adicionando permissão no SimpacWeb Beta 3
exec SimpacWeb..sp_userimpacwebbeta3permissao_add 'BKalkevicius'
GO
--Atribuir permissão no Simpac
exec Simpac..sp_permissaosimpacauto_add 'B.Kalkevicius'

------------- CRIAR USUARIO ATENDENTE -----------

SELECT * FROM ChatV2..tb_atendentes where idusuario = 41


--UPDATE ChatV2..tb_atendentes
SET desatendente = 'Klemenz',
	deslogin = 'Klemenz',
	desemail = 'Klemenz@impacta.com.br'
WHERE idusuario = 25

SELECT * FROM simpac..tb_usuario
where NmLogin in ('Klemenz')

SELECT * FROM SIMPAC..tb_usuario
SELECT * FROM chatv2..tb_departamentos
SELECT * FROM chatv2..tb_atendentes WHERE instatus = 0

SELECT * FROM chatv2..tb_atendentes 
WHERE idusuario = 49
order by desatendente

------------ PROCEDIMENTO PARA ALTERAR UM USUÁRIO DO ATENDIMENTO FIT --------------
SELECT * FROM chatv2..tb_departamentos
SELECT * FROM chatv2..tb_atendentes WHERE instatus = 0
SELECT * FROM chatv2..tb_atendentes WHERE idusuario = 24
SELECT * FROM chatv2..tb_atendentes WHERE desatendente like '%fernando%'
SELECT * FROM chatv2..tb_atendentes WHERE desatendente like '%fernando%'
SELECT * FROM simpac..tb_usuario WHERE NmLogin = 'Pcorreia'

DECLARE 
	@idusuario int,
	@desatendente varchar(100),
	@deslogin varchar(100),
	@desemail varchar(100),
	@iddepartamento int = 1,
	@dtcriacao datetime = getdate(),
	@dtsistemas datetime = getdate(),
	@dtlogin datetime = getdate()
	
-- usuario novo	
SELECT 
	@idusuario		= idusuario,
	@desatendente	= NmCompleto,
	@deslogin		= NmLogin,
	@desemail		= CdEMail
FROM tb_usuario
WHERE IdUsuario = 41


-- usuário a ser alterado
UPDATE chatv2..tb_atendentes 
SET desatendente	= @desatendente,
	deslogin		= @deslogin ,
	desemail		= @desemail,
	iddepartamento	= @iddepartamento,
	dtcriacao		= @dtcriacao ,
	dtsistemas		= @dtsistemas ,
	dtlogin			= @dtlogin ,
	idusuario		= @idusuario,
	instatus		= 1
WHERE idusuario = 41
-------------------------------------------------------------------
