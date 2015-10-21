USE FIT_NEW 

SELECT * FROM tb_cursos where curso_ativo = 1 and curso_tipo = 5
SELECT * FROM tb_cursos_links

--delete tb_cursos 
where curso_id = 74

sp_cursoslinkslast_list

select 
	E.cursoduracao_duracao as duracao
	, B.cursotipo_titulo
	, C.coordenador_nome as coordenador_geral
	, D.coordenador_nome as coordenador_curso
	, A.*  
from tb_cursos A
inner join tb_cursostipos B
on A.curso_tipo = B.cursotipo_id
inner join tb_coordenadores C
on C.coordenador_id = A.curso_coordenacaogeral
left join tb_coordenadores D
on D.coordenador_id = A.curso_coordenador1
left join tb_cursosduracao E
on E.cursoduracao_id = A.curso_duracao
where curso_ativo = 1 and A.curso_id = 72
order by A.curso_tipo

--------------------------------------------------------
--------------------------------------------------------
------------------- TABLES -----------------------------
--------------------------------------------------------
CREATE TABLE tb_cursos_links(
	idcursolink int IDENTITY CONSTRAINT PK_cursos_links PRIMARY KEY
	,curso_id int not null
	,descursolink varchar(200)
	,instatus bit CONSTRAINT DF_cursos_links_instatus DEFAULT(1) 
	,dtcadastro datetime CONSTRAINT DF_cursos_links_dtcadastro DEFAULT(getdate())
	
	CONSTRAINT FK_cursos_links_cursos_curso_id FOREIGN KEY(curso_id)
	REFERENCES tb_cursos (curso_id)
)

INSERT INTO tb_cursos_links
(curso_id, descursolink)
VALUES
(1,'bacharelado-em-administracao-enfase-em-tecnologia-da-informacao'),
(6,'tecnologo-em-analise-e-desenvolvimento-de-sistemas'),
(9,'arquitetura-da-informacao-e-experiencia-do-usuario-ux'),
(5,'tecnologo-em-banco-de-dados'),
(7,'pos-graduacao-em-business-intelligence'),
(33,'curso-internacional-de-auditor-ambiental'),
(8,'pos-graduacao-em-engenharia-de-software'),
(48,'mba-em-gestao-da-tecnologia-da-informacao'),
(10,'mba-em-gestao-de-projetos-enfase-no-pmbok'),
(11,'mba-em-gestao-e-tecnologia-em-seguranca-da-informacao'),
(17,'pos-graduacao-em-pericia-forense-computacional-investigacao-de-fraudes-e-aspectos-legais'),
(45,'mba-em-marketing-digital'),
(50,'Pos-Graduacao-em-Design-de-Interacao-(Enfase-em-Design-Thinking)'),
(57,'mba-em-gestao-estrategica-de-ecommerce'),
(39,'mba-executivo-internacional-em-gestao-de-negocios-mercados-e-projetos-interativos-parceria-i-group'),
(55,'mba-em-projeto-e-gerenciamento-de-data-center'),
(49,'mba-executivo-master-em-gestao-de-negocios-e-tecnologia'),
(46,'mba-executivo-internacional-em-planejamento-e-estrategia-de-negocios-alinhado-a-ti'),
(36,'mecatronica'),
(32,'mercado-de-carbono'),
(4,'tecnologo-em-redes-de-computadores'),
(2,'bacharelado-em-sistemas-de-informacao'),
(35,'telecomunicacoes'),
(38,'mba-em-gestao-ambiental-parceria-proenco'),
(60,'pos-graduacao-em-mobile'),
(61,'pos-graduacao-em-usabilidade-e-experiencia-do-usuario-ux'),
(3,'tecnologo-em-producao-multimidia-enfase-em-design-de-midia-digital'),
(62,'gestao-da-tecnologia-da-informacao'),
(63,'tecnologia-marketing-enfase-em-marketing-digital'),
(64,'mba-em-negocios-digitais'),
(69,'capacitacao-de-conciliadores-e-mediadores'),
(70,'jogos-digitais'),
(71,'mba-executivo-em-direito-digital'),
(72,'mba-teste')

INSERT INTO tb_cursos_links
(curso_id, descursolink)
VALUES
(72, 'mba-teste')

delete from tb_cursos_links
--------------------------------------------------------
----------- PROCEDURES ---------------------------------
--------------------------------------------------------
ALTER PROC sp_cursoslinksbycursotipo_list 5
(@curso_tipo int = 0)
AS
/*
app: SimpacWeb
data: 2013-02-21
author: Massa
*/
BEGIN
	IF(@curso_tipo != 0)
		select 
			a.curso_id
			, a.curso_count
			, a.curso_tipo
			, a.curso_subtipo
			, a.curso_titulo
			, a.curso_imagem
			, a.curso_keywords
			, a.curso_description
			, a.curso_inicio
			, a.curso_resenha
			, a.curso_descritivo
			, a.curso_coordenacaogeral
			, a.curso_coordenador1
			, a.curso_coordenador2
			, a.curso_coordenador3
			, a.curso_objetivo
			, a.curso_publicoalvo
			, a.curso_processoseletivo
			, a.curso_programa
			, a.curso_metodologia
			, a.curso_diasaulas
			, a.curso_parceria
			, a.curso_corpodocente
			, a.curso_duracao
			, a.curso_cargahoraria
			, a.curso_disciplinas
			, a.curso_documentos
			, a.curso_reservamatricula
			, a.curso_valor
			, a.curso_obs
			, a.curso_updated
			, a.curso_dateupdated
			, a.curso_ativo
			, a.curso_video
			, a.curso_video_titulo
			, a.curso_video_descricao
			, b.descursolink
			, b.dtcadastro as dtcadastro_link
		from tb_cursos a
		left join tb_cursos_links b
		on b.curso_id = a.curso_id and b.dtcadastro = (
			SELECT MAX(dtcadastro) FROM tb_cursos_links
			WHERE curso_id = b.curso_id
		)
		where curso_tipo = @curso_tipo  and curso_ativo = 1 
		order by a.curso_titulo
	ELSE
		select 
			a.curso_id
			, a.curso_count
			, a.curso_tipo
			, a.curso_subtipo
			, a.curso_titulo
			, a.curso_imagem
			, a.curso_keywords
			, a.curso_description
			, a.curso_inicio
			, a.curso_resenha
			, a.curso_descritivo
			, a.curso_coordenacaogeral
			, a.curso_coordenador1
			, a.curso_coordenador2
			, a.curso_coordenador3
			, a.curso_objetivo
			, a.curso_publicoalvo
			, a.curso_processoseletivo
			, a.curso_programa
			, a.curso_metodologia
			, a.curso_diasaulas
			, a.curso_parceria
			, a.curso_corpodocente
			, a.curso_duracao
			, a.curso_cargahoraria
			, a.curso_disciplinas
			, a.curso_documentos
			, a.curso_reservamatricula
			, a.curso_valor
			, a.curso_obs
			, a.curso_updated
			, a.curso_dateupdated
			, a.curso_ativo
			, a.curso_video
			, a.curso_video_titulo
			, a.curso_video_descricao
			, b.descursolink
			, b.dtcadastro as dtcadastro_link
		from tb_cursos a
		left join tb_cursos_links b
		on b.curso_id = a.curso_id and b.dtcadastro = (
			SELECT MAX(dtcadastro) FROM tb_cursos_links
			WHERE curso_id = b.curso_id
		)
		where curso_ativo = 1 
		order by a.curso_titulo
END
--------------------------------------------------------
CREATE PROC sp_cursoslinks_list
AS
/*
app: SimpacWeb
data: 2013-02-21
author: Massa
*/
BEGIN
	SELECT 
		idcursolink
		, curso_id
		, descursolink
		, instatus
		, dtcadastro
	FROM tb_cursos_links a
	WHERE instatus = 1 and dtcadastro = (
		SELECT MAX(dtcadastro) FROM tb_cursos_links
		WHERE a.curso_id = curso_id
	)
END
--------------------------------------------------------
CREATE PROC sp_cursoslinkslast_list
AS
/*
app: SimpacWeb
data: 2013-02-21
author: Massa
*/
BEGIN
	SELECT 
		idcursolink
		, curso_id
		, descursolink
		, instatus
		, dtcadastro
	FROM tb_cursos_links a
	WHERE instatus = 1 and dtcadastro = (
		SELECT MAX(dtcadastro) FROM tb_cursos_links
		WHERE a.curso_id = curso_id
	)
END
--------------------------------------------------------
CREATE PROC sp_cursoslinksfirst_list
AS
/*
app: SimpacWeb
data: 2013-02-21
author: Massa
*/
BEGIN
	SELECT 
		idcursolink
		, curso_id
		, descursolink
		, instatus
		, dtcadastro
	FROM tb_cursos_links a
	WHERE instatus = 1 and dtcadastro = (
		SELECT MIN(dtcadastro) FROM tb_cursos_links
		WHERE a.curso_id = curso_id
	)
END
--------------------------------------------------------
CREATE PROC sp_cursoslinks_save
(
	@idcursolink int
	, @curso_id int
	, @descursolink varchar(200)
	, @instatus bit = 1
)
AS
/*
app: SimpacWeb
url: /simpacweb/modulos/fit/adm_site/action/create_curso_page.php
data: 2013-02-21
author: Massa
*/
BEGIN
	SET NOCOUNT ON
	
	IF EXISTS( SELECT idcursolink FROM tb_cursos_links WHERE idcursolink = @idcursolink)
	BEGIN
		UPDATE tb_cursos_links
		SET	
			 curso_id = @curso_id
			, descursolink = @descursolink
			, instatus = @instatus
		WHERE idcursolink = idcursolink
		
		SELECT @idcursolink as idcursolink
		SET NOCOUNT OFF
	END
	ELSE
	BEGIN
		INSERT INTO tb_cursos_links
		(
			  curso_id
			, descursolink
			, instatus
		)VALUES(
			  @curso_id
			, @descursolink
			, @instatus
		)
		
		SELECT SCOPE_IDENTITY() as idcursolink
		SET NOCOUNT OFF
	END
END
--------------------------------------------------------
--------------------------------------------------------
--------------------------------------------------------
--------------------------------------------------------
