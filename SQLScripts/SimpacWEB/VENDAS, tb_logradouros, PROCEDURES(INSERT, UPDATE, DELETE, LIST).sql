CREATE PROCEDURE sp_getlogradourobytipoandbairro
(@idlogradourotipo int, @idbairro int)
AS
	SELECT a.deslogradouro FROM tb_logradouros a
	WHERE idlogradourotipo = @idlogradourotipo AND
	idbairro = @idbairro