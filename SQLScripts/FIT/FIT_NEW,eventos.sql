SELECT *FROM Cadcadastro
ORDER BY cadastroId

SELECT *FROM CadPalestra
ORDER BY palestraId

SELECT *INTO BKP_Cadcadastro
FROM Cadcadastro

SELECT *FROM BKP_Cadcadastro
ORDER BY cadastroid


SELECT *FROM CursosPos

SELECT *FROM tb_cursos
ORDER BY curso_titulo

sp_cadcadastro_curso_tipo_list '1,3,4','20110808'


sp_Cadcadastro_save 'werwe', 'werwe', '2012-08-22 00:00', 'werwer', 'werw', '', 'wer', 'Banco de Dados', 'werwer', 2

sp_cursostipos_list

---------------------------------------------------------------------
BEGIN TRAN
UPDATE BKP_Cadcadastro
SET Ativo = 0
WHERE Ativo IS NULL
COMMIT TRAN

ALTER TABLE BKP_Cadcadastro ADD
CONSTRAINT DF_BKP_cadcadastro_ativo DEFAULT (1) for ativo

ALTER TABLE CadPalestra
ADD dtcadastro datetime not null default getdate()
-----------------------LIST----------------------------------------------
CREATE PROC sp_cursos_list
AS
SELECT *FROM tb_cursos
ORDER BY curso_titulo

ALTER PROCEDURE [dbo].[sp_cadpalestra_get] (@palestra INT) AS
SELECT palestraNome as alunonome, *--palestraId, palestraCadastroId
FROM CadPalestra 
WHERE palestraCadastroId = @palestra 
ORDER BY palestraNome

ALTER PROCEDURE [dbo].[sp_cadpalestrabyaluno_get] 
(@palestraCadastroId INT) 
AS
SELECT *FROM CadPalestra 
WHERE palestraCadastroId = @palestraCadastroId
ORDER BY palestraNome

CREATE PROCEDURE sp_cadpalestrabyalunoid_get
(@palestraCadastroId INT,@palestraId INT) 
AS
SELECT *FROM CadPalestra 
WHERE palestraCadastroId = @palestraCadastroId AND
palestraId = @palestraId
ORDER BY palestraNome

ALTER PROC sp_getcursobytipo_list 
(@cursotipo_id INT)
AS
BEGIN
	IF(@cursotipo_id = 6)
		BEGIN
			SELECT DesCursoOficial AS [curso_titulo],IdCurso as [curso_id] FROM Simpac..tb_Cursos
			WHERE InStatus = 1
			ORDER BY [curso_titulo]
		END
	ELSE
		BEGIN
			SELECT curso_titulo, curso_id FROM tb_cursos 
			WHERE curso_tipo = @cursotipo_id
		END 	
END
-------------------------SAVE--------------------------------------------
ALTER PROC sp_Cadcadastro_save
(@cadastroTitulo nvarchar(510),@cadastroDescricao nvarchar(max),@cadastroData datetime,@cadastroHora nvarchar(100),@cadastroLink nvarchar(510),@cadastrovagas int,@cadastroPalestra nvarchar(510),@cadastroCurso nvarchar(510),@cadastroLocal nvarchar(510),@cursotipo_id int)
AS
INSERT Cadcadastro
(cadastroTitulo,cadastroDescricao,cadastroData,cadastroHora,cadastroLink,cadastrovagas,cadastroPalestrante,cadastroCurso ,cadastroLocal ,cursos)
VALUES
(@cadastroTitulo,@cadastroDescricao,@cadastroData,@cadastroHora,@cadastroLink,@cadastrovagas,@cadastroPalestra,@cadastroCurso,@cadastroLocal,@cursotipo_id)
-----------------------INSTATUS----------------------------------------------------------------------------------
ALTER PROCEDURE sp_cadcadastro_instatus
(@cadastroid int)
AS
IF(SELECT ativo FROM Cadcadastro 
WHERE cadastroId = @cadastroid) = 0 
	BEGIN 
		UPDATE Cadcadastro
		SET Ativo = 1
		WHERE cadastroId = @cadastroid
	END
ELSE
	BEGIN
		UPDATE Cadcadastro
		SET Ativo = 0
		WHERE cadastroId = @cadastroid
	END
------------------------UPDATE---------------------------------------------------------------------------------
ALTER PROC sp_cadcadastro_update
(@cadastroid int, @cadastroTitulo nvarchar(510),@cadastroDescricao nvarchar(max),@cadastroData datetime,@cadastroHora nvarchar(100),@cadastroLink nvarchar(510),@cadastrovagas int,@cadastroPalestra nvarchar(510),@cadastroCurso nvarchar(510),@cadastroLocal nvarchar(510),@cursotipo_id int)
AS
UPDATE Cadcadastro
SET	cadastroTitulo = @cadastroTitulo,
	cadastroDescricao = @cadastroDescricao,
	cadastroData = @cadastroData,
	cadastroHora = @cadastroHora,
	cadastroLink = @cadastroLink,
	cadastrovagas = @cadastrovagas,
	cadastroPalestrante = @cadastroPalestra,
	cadastroCurso =  @cadastroCurso,
	cadastroLocal =  @cadastroLocal,
	cursos = @cursotipo_id
WHERE cadastroid = @cadastroid
---------------------DELETE------------------------------------------------------
CREATE PROC sp_cadcadastro_delete
(@cadastroid int)
AS
DELETE Cadcadastro
WHERE cadastroId = @cadastroid

CREATE PROC sp_cadpalestra_delete
(@palestraid int)
AS
DELETE CadPalestra
WHERE palestraId = @palestraid
-----------------------------------------------------------------------
BEGIN TRAN

sp_cadpalestra_delete 121295

COMMIT TRAN


sp_cadcadastro_curso_tipo_list '1,2,7','2012-09-01'

sp_cursostipos_list 
.
sp_cursos_list

sp_cadpalestra_get 927

select * from tb_cursos

select *from tb_cursostipos 

select *from Simpac..tb_Cursos
WHERE  InCursoLiberado = 1 AND InStatus = 1
ORDER BY DesCursoOficial

sp_cadpalestrabyaluno_get 927