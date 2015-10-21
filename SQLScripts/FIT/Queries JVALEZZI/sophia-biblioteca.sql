
--acessos usuários
[Biblioteca.ACE_PERFIL]

select * from Biblioteca.ACE_PERFIL

select * from Biblioteca.ACE_OPERACAO
order by DESCRICAO

select * from Biblioteca.ACE_PERFIL_OPERACAO
where COD_PERFIL = 2 and COD_OPERACAO in(274,276,277,275,278)

--update Biblioteca.ACE_PERFIL_OPERACAO set ACESSO = 1
--where COD_PERFIL = 2 and COD_OPERACAO in(274,276,277,275,278)
--------------------------------------------------

select * from Biblioteca.dbo.Bibliotecas

select * from Biblioteca.Biblioteca.DEPARTAMENTO

--tabela de usuários(funcionario) - biblioteca

select * from TAB_Usuario
where codigo = 1

--UPDATE TAB_Usuario
--SET senha = 'vzhs{t{'
--WHERE codigo = 2

--UPDATE TAB_Usuario
--SET supervisor = 1
--WHERE codigo = 1

--insert into TAB_Usuario(codigo,nome,identificacao,senha,supervisor,perfil,Marc,Bib_Default,ATIVO,DEPARTAMENTO,DATA_EXC,
--SISTEMA,ACESSOU_PORTAL)
--values(1,'Supervisor','SUPERVISOR','q1a2s3',1,2,1,1,1,11,GETDATE(),0,1)

insert into TAB_Usuario(codigo,nome,identificacao,senha,supervisor,perfil,Marc,Bib_Default,ATIVO,DEPARTAMENTO,DATA_EXC,
SISTEMA,ACESSOU_PORTAL)
values(2,'Karina da Silva Lunghi','KSLUNGHI','123456',0,2,1,1,1,2,GETDATE(),0,1)

--tabela de usuarios(alunos) - biblioteca

select SENHA, * from OUTRUSU WHERE Nome LIKE 'LUIZ NETO%'
--where Codigo = 2685
where Nome like '%karina%'
where Nome like '%ricardo azzi%'

select * from OUTRUSU_SENHAS WHERE USUARIO = 14310

SELECT * FROM biblioteca.ENQ_USUARIOS

select * from OUTRUSU_SENHAS 
ORDER BY USUARIO DESC



select * from Biblioteca.dbo.REGISTRO

select * from Biblioteca.dbo.Usu_Config

select * from Biblioteca.dbo.UsuBib