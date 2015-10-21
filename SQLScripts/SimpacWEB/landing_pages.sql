CREATE TABLE tb_landingpage(
	idlandingpage int identity CONSTRAINT PK_landingpage PRIMARY KEY
	, desdiretorio varchar(100) not null
	, desnomearquivo varchar(200) not null
	, deslandingpage varchar(100)
	, idunidade int
	, instatus bit CONSTRAINT DF_landingpage_instatus DEFAULT(0)
	, dtcadastro datetime CONSTRAINT DF_landingpage_dtcadastro DEFAULT(getdate())
)
--------------------------------------------------------------
------------- PROCEDURES -------------------------------------
--------------------------------------------------------------
CREATE PROC sp_landingpage_get 
(@idlandingpage int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.landingPage.php
data: 2013-12-03
author: Massaharu
description: Retorna um registro da tabela tb_landingpage pelo id da mesma
*/
BEGIN
	SELECT
		idlandingpage
		,desdiretorio
		,desnomearquivo
		,deslandingpage
		,idunidade
		,instatus
		,dtcadastro
	FROM tb_landingpage
	WHERE idlandingpage = @idlandingpage
END
--------------------------------------------------------------
ALTER PROC sp_landingpage_list
(@idunidade int = null)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.landingPage.php
data: 2013-12-03
author: Massaharu
description: Lista os registros da tabela tb_landingpage pelo id da unidade
*/
BEGIN 
	IF(@idunidade is null)
		SELECT
			idlandingpage
			,desdiretorio
			,desnomearquivo
			,deslandingpage
			,a.idunidade
			,b.desunidade
			,a.instatus
			,a.dtcadastro
		FROM tb_landingpage a
		INNER JOIN Simpac..tb_unidades b
		ON b.idunidade = a.idunidade
		ORDER BY a.dtcadastro DESC
	ELSE
		SELECT
			idlandingpage
			,desdiretorio
			,desnomearquivo
			,deslandingpage
			,a.idunidade
			,b.desunidade
			,a.instatus
			,a.dtcadastro
		FROM tb_landingpage a
		INNER JOIN Simpac..tb_unidades b
		ON b.idunidade = a.idunidade
		WHERE a.idunidade = @idunidade
		ORDER BY a.dtcadastro DESC
END
----------------------------------------------------
CREATE PROC sp_landingpage_save
(
	@idlandingpage int
	,@desdiretorio varchar(100)
	,@desnomearquivo varchar(200)
	,@deslandingpage varchar(100)
	,@idunidade int
	,@instatus bit
)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.landingPage.php
data: 2013-12-03
author: Massaharu
description: Salva e atualiza os registros da tabela tb_landingpage pelo id da unidade
*/
BEGIN
	SET NOCOUNT ON
	
	IF EXISTS(
		SELECT idlandingpage FROM tb_landingpage
		WHERE idlandingpage = @idlandingpage
	)
	BEGIN
		UPDATE tb_landingpage
		SET desdiretorio = @desdiretorio,
			desnomearquivo = @desnomearquivo,
			deslandingpage = @deslandingpage,
			idunidade = @idunidade,
			instatus = @instatus
		WHERE idlandingpage = @idlandingpage
		
		SET NOCOUNT OFF			
		SELECT @idlandingpage AS idlandingpage
	END
	ELSE
	BEGIN
		INSERT INTO tb_landingpage( 
			desdiretorio,
			desnomearquivo,
			deslandingpage,
			idunidade,
			instatus
		)VALUES(
			@desdiretorio,
			@desnomearquivo,
			@deslandingpage,
			@idunidade,
			@instatus
		)	
		
		SET NOCOUNT OFF			
		SELECT SCOPE_IDENTITY() as idlandingpage	
	END
END

-----------------------------------------------------
SELECT * FROM Simpac..tb_unidade

TRUNCATE TABLE tb_landingpage

sp_landingpage_save 1, 'arquitetura-informacao-experiencia-usuario', 'pag_site_2.jpg', 'Arquitetura da Informação & Experiência do Usuário (UX)', 2, 1
sp_landingpage_save 2, 'design-interacao', 'pag_site_design_de_interacao.jpg', 'Design de Interação (Ênfase em Design Thinking)', 2, 1
sp_landingpage_save 3, 'design-interacao-design-thinking', 'pag_site.jpg', 'Design de Interação (Ênfase em Design Thinking)', 2, 1
sp_landingpage_save 4, 'engenharia-software', 'engenharia-software.jpg', 'Pós Graduação Engenharia de Software', 2, 1
sp_landingpage_save 5, 'SAP', 'landing-faculdade-sap-3.jpg', 'Academias oficiais da SAP', 2, 1

sp_landingpage_get 3
sp_landingpage_list

delete tb_landingpage
where idlandingpage in(6,7)

SELECT * FROM tb_usuario WHERE nmcompleto like '%ohara%'