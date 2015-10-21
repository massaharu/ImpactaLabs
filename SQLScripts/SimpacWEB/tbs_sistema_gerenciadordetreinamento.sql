/*CREATE TABLE tb_treinamentos(
	idtreinamento int identity(1,1) not null primary key,
	destreinamento varchar(200) not null,
)

CREATE TABLE tb_prerequisito(
	idprerequisito int identity(1,1) not null primary key,
	desprerequisito varchar(200) not null,
)

CREATE TABLE tb_prerequisito_treinamentos(
	idprerequisito_treinamento int identity(1,1)not null,
	idprerequisito int,
	idtreinamento int,
	CONSTRAINT UQ_prereq_trein_prereqtrein_idprereqidtrein UNIQUE(idprerequisito,idtreinamento)
)
ALTER TABLE tb_prerequisito_treinamentos ADD
CONSTRAINT FK_PREREQ_TREIN_PREREQUISITO_IDPREREQUISITO FOREIGN KEY(idprerequisito)
REFERENCES tb_prerequisito(idprerequisito),
CONSTRAINT FK_PREREQ_TREIN_PREREQUISITO_IDTREINAMENTO FOREIGN KEY(idtreinamento)
REFERENCES tb_treinamentos(idtreinamento)

CREATE TABLE tb_prerequisito(
	idprerequisito int identity(1,1) not null primary key,
	desprerequisito varchar(200) not null,
	idtreinamento int not null,
	CONSTRAINT FK_PREREQUISITO_TREINAMENTO_IDTREINAMENTO FOREIGN KEY(idtreinamento)
	REFERENCES tb_treinamentos(idtreinamento)
)


CREATE TABLE tb_avancado(
	idavancado int identity(1,1) not null primary key,
	desavancado varchar(200) not null,
	idtreinamento int not null,
	CONSTRAINT FK_AVANCADO_TREINAMENTO_IDTREINAMENTO FOREIGN KEY(idtreinamento)
	REFERENCES tb_treinamentos(idtreinamento)
)
*/
CREATE TABLE tb_cursos_classificacao(
	idclassificacao int identity(1,1) not null primary key,
	idprerequisito int not null,
	idcurso int not null,
	idavancado int not null,
	dtcadastro datetime default getdate(),
	CONSTRAINT UQ_cursosclassificacao UNIQUE(idprerequisito,idcurso,idavancado)
)

DROP TABLE tb_cursos_classificacao
------------------------------------------PROCEDURE(DELETE)---------------------------------------------------------------
/*CREATE PROCEDURE sp_avancado_delete
   (@idavancado int)
AS
   DELETE tb_avancado
   WHERE idavancado = @idavancado	
   
CREATE PROCEDURE sp_prerequisito_delete
   (@idprerequisito int)
AS
   DELETE tb_prerequisito
   WHERE idprerequisito = @idprerequisito
   
ALTER PROCEDURE sp_treinamento_delete
   (@idtreinamento int)
AS
   DELETE tb_treinamentos
   WHERE idtreinamento = @idtreinamento*/	
   
ALTER PROCEDURE sp_gerenciadortreinamentos_remove
(@idclassificacao int)
AS
DELETE tb_cursos_classificacao
WHERE idclassificacao = @idclassificacao	

------------------------------------PROCEDURE(SAVES)---------------------------------------------------------------------------

/*ALTER PROC sp_treinamentoprerequisito_save
(@destreinamento varchar(200),@desprerequisito varchar(200))
AS
IF @destreinamento <> @desprerequisito
BEGIN
	INSERT INTO tb_treinamentos
	(destreinamento)
	VALUES(@destreinamento)
	INSERT INTO tb_prerequisito
	(desprerequisito)
	VALUES(@desprerequisito)
END

CREATE PROC sp_treinamento_save
(@destreinamento varchar(200))
AS
INSERT INTO tb_treinamentos
(destreinamento)
VALUES(@destreinamento)

CREATE PROC sp_prerequisito_save
(@idtreinamento int,@desprerequisito varchar(200))
AS
INSERT INTO tb_prerequisito
(idtreinamento,desprerequisito)
VALUES(@idtreinamento,@desprerequisito)

CREATE PROC sp_avancado_save
(@idtreinamento int,@desavancado varchar(200))
AS
INSERT INTO tb_avancado
(idtreinamento,desavancado)
VALUES(@idtreinamento,@desavancado)

CREATE PROC sp_prerequisitoavancado_save
(@idtreinamento int,@desprerequisito varchar(200),@desavancado varchar(200))
AS
INSERT INTO tb_prerequisito
(idtreinamento,desprerequisito)
VALUES(@idtreinamento,@desprerequisito)
INSERT INTO tb_avancado
(idtreinamento,desavancado)
VALUES(@idtreinamento,@desavancado)*/

CREATE PROC sp_gerenciadortreinamentos_save
(@idcurso int, @idprerequisito int,@idavancado int)
AS
INSERT INTO tb_cursos_classificacao
(idcurso,idprerequisito,idavancado)
VALUES
(@idcurso,@idprerequisito,@idavancado)
------------------------------PROCEDURE(UPDATE)-----------------------------------------------------------------
/*ALTER PROC sp_avancado_update
(@idavancado int,@desavancado varchar(200))
AS
UPDATE tb_avancado
SET desavancado = @desavancado
WHERE 
	idavancado = @idavancado
	
CREATE PROC sp_prerequisito_update
(@idprerequisito int,@desprerequisito varchar(200))
AS
UPDATE tb_prerequisito
SET desprerequisito = @desprerequisito
WHERE 
	idprerequisito = @idprerequisito
	
ALTER PROC sp_treinamento_update
(@idtreinamento int,@destreinamento varchar(200))
AS
UPDATE tb_treinamentos
SET destreinamento = @destreinamento
WHERE 
	idtreinamento = @idtreinamento*/
	
CREATE PROC sp_gerenciadortreinamentos_update
(@idclassificacao int ,@idcurso varchar(200),@idprerequisito varchar(200),@idavancado varchar(200))
AS
UPDATE tb_cursos_classificacao
SET idcurso = @idcurso,
	idprerequisito = @idprerequisito,
	idavancado = @idavancado
WHERE 
	idclassificacao = @idclassificacao
-------------------------PROCEDURE(LISTS)----------------------------------------------------------------------
/*CREATE PROC sp_gerenciadortreinamentos_list
AS
SELECT tb_prerequisito.idprerequisito,
	   tb_prerequisito.desprerequisito,
	   tb_treinamentos.idtreinamento,
	   tb_treinamentos.destreinamento,
	   tb_avancado.idavancado,
	   tb_avancado.desavancado
FROM tb_treinamentos
INNER JOIN tb_avancado
on tb_avancado.idtreinamento = tb_treinamentos.idtreinamento	
INNER JOIN tb_prerequisito
on tb_prerequisito.idtreinamento = tb_treinamentos.idtreinamento*/ 

ALTER PROC sp_gerenciadortreinamentos_list
AS
Select idprerequisito,dbo.fn_getNomeCurso(idprerequisito) as descursoprerequisito,
         idcurso,dbo.fn_getNomeCurso(idcurso)descurso,
         idavancado,dbo.fn_getNomeCurso(idavancado)descursoavancado,
         idclassificacao
from tb_cursos_classificacao  	

ALTER PROC sp_treinamentoslistados_list
AS
SELECT idcurso,descurso
FROM simpac..tb_cursos
--------------------------------------FUNCTIONS----------------------------------------------------
ALTER function [dbo].[fn_getCurso_url](@idcurso int)
returns varchar(200)
as

begin
	
	declare @desurl  varchar(200)
	
	Select @desurl  = desurl from impacta6..tb_cursosurl
	where  idcurso= @idcurso
	
	return @desurl 
end 


ALTER function [dbo].[fn_getNomeCurso](@idcurso int)
returns varchar(200)
as

begin
	
	declare @curso varchar(200)
	
	Select @curso = descurso from simpac..tb_cursos
	where  idcurso= @idcurso
	
	return @curso 
end
----------------------------------QUERIES FERNANDO-----------------------------------------------------
--(with INNER JOINS)
Select 
      a.idprerequisito,
      c_requisito.descurso,
      e_url_requisito.desurl,
      a.idcurso,
      b_curso.descurso,
      a.idavancado,
      d_avancado.descurso,
      f_url_avancado.desurl
from 
      tb_cursos_classificacao a
inner join simpac..tb_cursos b_curso
on    a.idcurso = b_curso.IdCurso
inner join simpac..tb_cursos c_requisito
on    a.idprerequisito = c_requisito.IdCurso
inner join simpac..tb_cursos d_avancado
on    a.idavancado = d_avancado.IdCurso
inner join impacta6..tb_cursosurl e_url_requisito
on a.idprerequisito = e_url_requisito.idcurso
inner join impacta6..tb_cursosurl f_url_avancado
on a.idavancado = f_url_avancado.idcurso

--(with FUNCTIONS)
Select idprerequisito,dbo.fn_getNomeCurso(idprerequisito) as descursoprerequisito,
         idcurso,dbo.fn_getNomeCurso(idcurso)descurso,
         idavancado,dbo.fn_getNomeCurso(idavancado)descursoavancado
from tb_cursos_classificacao


---------------------------CONSULTAS-----------------------------------------------------------------------------------------
USE DEV_TESTE
/*SELECT *FROM tb_treinamentos
SELECT *FROM tb_prerequisito 
SELECT *FROM tb_avancado*/
SELECT *FROM tb_cursos_classificacao

USE Simpac
SELECT *FROM tb_cursos

SELECT *FROM tb_prerequisito_treinamentos

sp_gerenciadortreinamentos_update 2,2,1,14

/*sp_avancado_delete 6

sp_prerequisito_delete 8

sp_treinamento_delete 1*/


--sp_treinamentoprerequisito_save 'SQL SERVER 2008-I','SQL SERVER 2008-I'

/*sp_avancado_save 5,''

sp_treinamento_save 'SQL-III'

sp_prerequisito_save 5,'SQL-II'

sp_avancado_update 5,'SQL III'

sp_prerequisito_update 6,'SQL-II'

sp_treinamento_update 5,'SQL-III'

sp_prerequisitoavancado_save

sp_gerenciadortreinamentos_list

sp_treinamentoslistados_list*/

------------------------------------------------------------------------------------------
/*Insere todos os valores do campo DesCursoOficial de um determinado banco e 
tabela para o campo destreinamento de um outro banco e tabela*/
INSERT INTO DEV_TESTE.dbo.tb_treinamentos
(destreinamento)
SELECT DesCursoOficial FROM Simpac.dbo.tb_Cursos