USE SimpacWeb

SELECT * FROM tb_Menu where text like '%Adm. Turmas%' and parent = 620
SELECT * FROM tb_grupos
SELECT * FROM tb_grupos_to_usuarios
SELECT * FROM tb_usuarios_to_menu
SELECT * FROM tb_grupos_to_menu
-------------------------------------------------------------------------------
-------------------- COPIAR PERMISSAO DE USUARIO DE MENU PARA MENU ------------
-------------------------------------------------------------------------------
DECLARE 
	@toMenu int = 894,
	@fromMenu varchar(200) = '964'

-- usuarios
INSERT INTO tb_usuarios_to_menu
SELECT 
	DISTINCT idusuario, @toMenu as idmenu FROM tb_usuarios_to_menu
WHERE 
	idmenu IN(
		SELECT id FROM Simpac.dbo.fnSplit(@fromMenu, ',')
	) AND 
	idusuario NOT IN(
		SELECT 
			DISTINCT idusuario 
		FROM tb_usuarios_to_menu
		WHERE 
			idmenu = @toMenu AND idusuario IN(
				SELECT 
					DISTINCT idusuario FROM tb_usuarios_to_menu
				WHERE 
					idmenu IN(
						SELECT id FROM Simpac.dbo.fnSplit(@fromMenu, ',')
					)
			)
	)
-- grupos	
INSERT INTO tb_grupos_to_menu
SELECT 
	DISTINCT idgrupo, @toMenu as idmenu FROM tb_grupos_to_menu
WHERE 
	idmenu IN(
		SELECT id FROM Simpac.dbo.fnSplit(@fromMenu, ',')
	) AND 
	idgrupo NOT IN(
		SELECT 
			DISTINCT idgrupo 
		FROM tb_grupos_to_menu
		WHERE 
			idmenu = @toMenu AND idgrupo IN(
				SELECT 
					DISTINCT idgrupo FROM tb_grupos_to_menu
				WHERE 
					idmenu IN(
						SELECT id FROM Simpac.dbo.fnSplit(@fromMenu, ',')
					)
			)
	)	
-------------------------------------------------------------------------------
-------------------------------------------------------------------------------
-------------------------------------------------------------------------------

