USE SIMPAC;
--Criar o usuario

Insert tb_Usuario (IdUsuario,NmUsuario,NmLogin,CdEMail,NrRamal,InAtendente,NrPercentualDesconto,InStatus,
NmCompleto,IdNivel,IdDepto,IdCargo,IdFranquia,Sexo,CentroCusto,InGerente,Codigo,InCorporativo,
InAtendenteAtivo,nrcpf,dtcadastro)

Select IdUsuario,NmUsuario,NmLogin,CdEMail,NrRamal,inAtendente,0[nrPercentual],instatus,
nmcompleto,idnivel,iddepto,idcargo,null [idfranquia],sexo,null [CentroCusto],0 [inGerente],
null [Codigo],inCorporativo,inAtendenteAtivo,nrCPf,Dtcadastro from Saturn.simpac.dbo.tb_usuario
where nmlogin like 'anna%' and idusuario = 1613


--Adiciona os direitos
Insert tb_direitos(Idusuario,idgrupo)
Select idusuario,idgrupo from saturn.simpac.dbo.tb_direitos
where idusuario = 1613


--Cria o usuario no servidor 

exec sp_addlogin @loginame='fsantos',
@passwd='impacta1',
@defdb='Simpac',
@deflanguage='English'


--Adiciona o Login do servidor

USE SIMPAC
GO
EXEC sp_grantdbaccess 'fsantos', 'fsantos'
EXEC sp_addrolemember 'db_owner', 'fsantos'

USE Atendimento
GO
EXEC sp_grantdbaccess 'fsantos', 'fsantos'
EXEC sp_addrolemember 'db_owner', 'fsantos'

USE Auditoria
GO
EXEC sp_grantdbaccess 'fsantos', 'fsantos'
EXEC sp_addrolemember 'db_owner', 'fsantos'

---Remover o usuario do banco
USE SIMPAC
GO
EXEC sp_revokedbaccess 'Thayla'
GO
exec sp_droprolemember 'db_owner','Thayla'

USE Atendimento
GO
EXEC sp_revokedbaccess 'Thayla'
GO
exec sp_droprolemember 'db_owner','Thayla'

USE Auditoria
GO
EXEC sp_revokedbaccess 'Thayla'
GO
exec sp_droprolemember 'db_owner','Thayla'