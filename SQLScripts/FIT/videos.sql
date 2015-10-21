USE DEV_TESTE
USE FIT_NEW
------------------------------------------------------------------------
------------------------ TABELAS (VIDEOS) ------------------------------
------------------------------------------------------------------------
CREATE TABLE tb_videos_tipos(
	idvideotipo		int not null IDENTITY CONSTRAINT PK_videos_tipos PRIMARY KEY(idvideotipo),
	desvideotipo	varchar(100),
	instatus		bit CONSTRAINT DF_videos_tipos_instatus DEFAULT(1),
	dtcadastro		datetime CONSTRAINT DF_videos_tipos_dtcadastro DEFAULT(getdate())
)

TRUNCATE TABLE tb_videos(
	idvideo		int not null IDENTITY CONSTRAINT PK_videos PRIMARY KEY(idvideo),
	idvideotipo	int not null,
	curso_id	int,	
	destitulo	varchar(200),
	desvideo	varchar(1000),
	desurl		varchar(200),
	instatus	bit CONSTRAINT DF_videos_instatus DEFAULT(1),
	dtcadastro	datetime CONSTRAINT DF_videos_dtcadastro DEFAULT(getdate())
	CONSTRAINT FK_videos_videos_tipos_idvideotipo FOREIGN KEY(idvideotipo)
	REFERENCES tb_videos_tipos(idvideotipo),
	CONSTRAINT FK_videos_cursos_curso_id FOREIGN KEY(curso_id)
	REFERENCES tb_cursos(curso_id)
)

INSERT INTO tb_videos
(idvideotipo, destitulo, desurl, desvideo)
VALUES
(2,'Diogo Torquato','http://www.youtube.com/embed/IJJBmEEAfLA','Depoimento do aluno Diogo sobre o curso de Administração (Ênfase em Tecnologia da Informação) realizado na Faculdade Impacta Tecnologia.'),
(2,'Thiago Rolon','http://www.youtube.com/embed/r_ryDhUlnr4','Depoimento do aluno Thiago sobre o curso de Design de Mídia Digital realizado na Faculdade Impacta Tecnologia.'),
(2,'Karina Kelly','http://www.youtube.com/embed/ZSkFaGrvvwI','Depoimento da aluna Karina Kelly sobre o curso de Redes de Computadores realizado na Faculdade Impacta Tecnologia.'),
(2,'Luiz Canguini','http://www.youtube.com/embed/RpSYJh-N_W0','Depoimento do aluno Luiz Canguini sobre o curso de Sistemas de Informação realizado na Faculdade Impacta Tecnologia.'),
(2,'Entrevista - Fernando Moreira (IPEN)','http://www.youtube.com/v/xNJqmyeML58','Entrevista com Fernando Moreira, Gerente de Ensino do Instituto de Pesquisas Energéticas e Nucleares (IPEN), sobre a parceria com a Faculdade Impacta Tecnologia.'),
(2,'Paulo Araújo - MBA','http://www.youtube.com/embed/6UPUunpeLl4','Depoimento de Paulo Araújo, ex- aluno do MBA Planejamento e Estratégia de Negócios com Suporte da TI, apresentando os benefícios que a realização do curso na Faculdade Impacta lhe proporcionaram.'),
(2,'Claudio Yamashita','http://www.youtube.com/v/46x6M8zTtxE','Depoimento do ex-aluno Claudio Yamashita sobre o curso de Sistemas de Informação realizado na Faculdade Impacta Tecnologia.'),
(2,'Rodrigo Oliveira da Silva','http://www.youtube.com/embed/x2XZD6lUCJM','Depoimento do aluno Rodrigo Oliveira da Silva sobre o curso de Administração (Ênfase em Tecnologia da Informação) realizado na Faculdade Impacta Tecnologia.  '),
(2,'aluno Douglas Vinicius Torres','http://www.youtube.com/embed/mgFnaD7o4ew','Depoimento do aluno Douglas Vinicius Torres sobre o curso de Administração (Ênfase em Tecnologia da Informação) realizado na Faculdade Impacta Tecnologia.  '),
(2,'Giwoo Gustavo Lee','http://www.youtube.com/embed/RhowwBkDPrY','Depoimento do aluno Giwoo Gustavo Lee sobre o curso de Sistemas de Informação realizado na Faculdade Impacta Tecnologia.'),
(2,'Parceria Gartner','http://www.youtube.com/embed/XyUKftnh4r4','Lino Quagliariello, Gerente de Negócios Gartner Brasil, apresenta dicas para quem deseja alcançar o sucesso no mercado de TI.'),
(2,'Parceria Caldwell Community College & Technical Institute','http://youtu.be/bMIy7BBLZKA','Depoimento do Presidente da Caldwell Community College & Technical Institute.')

INSERT INTO tb_videos
(idvideotipo, curso_id, destitulo, desurl, desvideo)
VALUES
(1, 3, '01/10', 'http://www.youtube.com/watch?v=JGwwNPaUzJ4&list=PLLYAssox6ydWyzo9m-1mIhkExZhUuCxAP', 'Aula de Comunicação, com a Profª Gláucia Jacuk Herman, do Curso de Design de Mídia Digital [DMD] na Faculdade Impacta Tecnologia.'),
(1, 3, '02/10', 'http://www.youtube.com/watch?v=L34WgxjIzsw&list=PLLYAssox6ydWyzo9m-1mIhkExZhUuCxAP', 'Aula de Comunicação, com a Profª Gláucia Jacuk Herman, do Curso de Design de Mídia Digital [DMD] na Faculdade Impacta Tecnologia.'),
(1, 3, '03/10', 'http://www.youtube.com/watch?v=wKaaw2ZXZaE&list=PLLYAssox6ydWyzo9m-1mIhkExZhUuCxAP', 'Aula de Comunicação, com a Profª Gláucia Jacuk Herman, do Curso de Design de Mídia Digital [DMD] na Faculdade Impacta Tecnologia.'),
(1, 3, '04/10', 'http://www.youtube.com/watch?v=iNjlC6oh3nc&list=PLLYAssox6ydWyzo9m-1mIhkExZhUuCxAP', 'Aula de Comunicação, com a Profª Gláucia Jacuk Herman, do Curso de Design de Mídia Digital [DMD] na Faculdade Impacta Tecnologia.'),
(1, 3, '05/10', 'http://www.youtube.com/watch?v=_dQTlpPFjzg&list=PLLYAssox6ydWyzo9m-1mIhkExZhUuCxAP', 'Aula de Comunicação, com a Profª Gláucia Jacuk Herman, do Curso de Design de Mídia Digital [DMD] na Faculdade Impacta Tecnologia.'),
(1, 3, '06/10', 'http://www.youtube.com/watch?v=m7oQJ10ygeM&list=PLLYAssox6ydWyzo9m-1mIhkExZhUuCxAP&index=33', 'Aula de Comunicação, com a Profª Gláucia Jacuk Herman, do Curso de Design de Mídia Digital [DMD] na Faculdade Impacta Tecnologia.'),
(1, 3, '07/10', 'http://www.youtube.com/watch?v=5TSW0X32iDY&list=PLLYAssox6ydWyzo9m-1mIhkExZhUuCxAP', 'Aula de Comunicação, com a Profª Gláucia Jacuk Herman, do Curso de Design de Mídia Digital [DMD] na Faculdade Impacta Tecnologia.'),
(1, 3, '08/10', 'http://www.youtube.com/watch?v=dtFK5_DFgvc', 'Aula de Comunicação, com a Profª Gláucia Jacuk Herman, do Curso de Design de Mídia Digital [DMD] na Faculdade Impacta Tecnologia.'),
(1, 3, '09/10', 'http://www.youtube.com/watch?v=wUp7fwHxhcM&list=PLLYAssox6ydWyzo9m-1mIhkExZhUuCxAP', 'Aula de Comunicação, com a Profª Gláucia Jacuk Herman, do Curso de Design de Mídia Digital [DMD] na Faculdade Impacta Tecnologia.'),
(1, 3, '10/10', 'http://www.youtube.com/watch?v=7Klbhh6xBs4&list=PLLYAssox6ydWyzo9m-1mIhkExZhUuCxAP', 'Aula de Comunicação, com a Profª Gláucia Jacuk Herman, do Curso de Design de Mídia Digital [DMD] na Faculdade Impacta Tecnologia.'),
(1, 1, '01/04', 'http://www.youtube.com/watch?v=I6mHIHIlTuQ&list=PLLYAssox6ydWyzo9m-1mIhkExZhUuCxAP', 'Aula de Administração de Recursos Humanos, com a Profª Barbara Cunha do Curso de Administração de Empresas com Ênfase em Tecnologia da Informação na Faculdade Impacta Tecnologia.'),
(1, 1, '02/04', 'http://www.youtube.com/watch?v=XP5uQKyV4cE', 'Aula de Administração de Recursos Humanos, com a Profª Barbara Cunha do Curso de Administração de Empresas com Ênfase em Tecnologia da Informação na Faculdade Impacta Tecnologia.'),
(1, 1, '03/04', 'http://www.youtube.com/watch?v=77c1cpiMtHA', 'Aula de Administração de Recursos Humanos, com a Profª Barbara Cunha do Curso de Administração de Empresas com Ênfase em Tecnologia da Informação na Faculdade Impacta Tecnologia.'),
(1, 1, '04/04', 'http://www.youtube.com/watch?v=oB4yNYmbpjw', 'Aula de Administração de Recursos Humanos, com a Profª Barbara Cunha do Curso de Administração de Empresas com Ênfase em Tecnologia da Informação na Faculdade Impacta Tecnologia.'),
(1, 4, '01/06', 'http://www.youtube.com/watch?v=0eWiQ7oUsrA&list=UUHXOychi5DHOE-v0HoOqhQA&index=3', ''),
(1, 4, '02/06', 'http://www.youtube.com/watch?v=ZxWbGhq2IlY&list=UUHXOychi5DHOE-v0HoOqhQA&index=2', ''),
(1, 4, '03/06', 'http://www.youtube.com/watch?v=aQCDIB87Qqc&list=UUHXOychi5DHOE-v0HoOqhQA&index=1', ''),
(1, 4, '04/06', 'http://www.youtube.com/watch?v=ZM2d8V_g8Ls', '')
(1, 4, '05/06', 'http://www.youtube.com/watch?v=Rx2SqhPvBP0', ''),
(1, 4, '06/06', 'http://www.youtube.com/watch?v=1WbOzfq4Q8o', '')



SELECT *FROM tb_videos_tipos
SELECT *FROM tb_videos
------------------------------------------------------------------------
------------------------ TABELAS (PROCEDURES) --------------------------
------------------------------------------------------------------------
------------------------ VIDEOS TIPOS ----------------------------------
CREATE PROC sp_videostipos_save
(@desvideotipo varchar(100))
AS
/*
app: SIMPACWEB
url: simpacweb/modulos/fit/adm_videos/json/videostipos_add.php
data: 2013-01-07
author: Massa
*/
BEGIN
	SET NOCOUNT ON
	INSERT tb_videos_tipos(desvideotipo)
	VALUES(@desvideotipo)
	SET NOCOUNT OFF
END

sp_videostipos_save 'Aulas Modelo'
sp_videostipos_save 'Depoimentos'
------------------------------------------------------------------------
CREATE PROC sp_videostiposbyinstatus_list
AS
/*
app: SimpacWEB
url: simpacweb/modulos/fit/adm_videos/json/videostiposbyinstatus_list.php
data: 2013-01-07
author: Massa
*/
BEGIN
	SELECT idvideotipo, desvideotipo
	FROM tb_videos_tipos
	WHERE instatus = 1
END
------------------------------------------------------------------------
------------------------ VIDEOS ----------------------------------------
------------------------------------------------------------------------
ALTER PROC sp_videos_save
(@idvideotipo int, @curso_id int, @destitulo varchar(200), @desvideo varchar(1000), @desurl varchar(200))
AS
/*
app: SimpacWEB
url: simpacweb/modulos/fit/adm_videos/json/videos_save.php
data: 2013-01-07
author: Massa
*/
BEGIN
	SET NOCOUNT ON
	IF((@curso_id <> 0) AND (@curso_id <> ''))
		BEGIN 			
			INSERT tb_videos(idvideotipo, curso_id, destitulo, desvideo, desurl)
			VALUES(@idvideotipo, @curso_id, @destitulo, @desvideo, @desurl)
		END
	ELSE
		BEGIN
			INSERT tb_videos(idvideotipo, destitulo, desvideo, desurl)
			VALUES(@idvideotipo, @destitulo, @desvideo, @desurl)
		END
	SET NOCOUNT OFF
	SELECT SCOPE_IDENTITY() as idvideo
END

--------------------------------------------------------------------------------
ALTER PROC sp_videosbyinstatus_list
AS
/*
app: SimpacWeb
url: simpacweb/modulos/fit/adm_videos/json/videosbyinstatus_list.php
data: 2013-01-07
author: Massa
*/
BEGIN
	SELECT a.desvideotipo,
		   a.idvideotipo,
		   c.curso_titulo,	
		   b.destitulo,
		   b.desvideo,
		   b.desurl
	FROM tb_videos_tipos a
	INNER JOIN tb_videos b
	ON b.idvideotipo = a.idvideotipo
	LEFT JOIN tb_cursos c
	ON c.curso_id = b.curso_id
	WHERE b.instatus = 1 AND a.instatus = 1
	ORDER BY b.dtcadastro DESC, b.idvideo desc		   
END
--------------------------------------------------------------------------------
ALTER PROC sp_videos_list
AS
/*
app: SimpacWeb
url: simpacweb/modulos/fit/adm_videos/json/videos_list.php
data: 2013-01-07
author: Massa
*/
BEGIN
	SELECT a.desvideotipo,
		   a.idvideotipo,
		   c.curso_titulo,
		   b.idvideo,	
		   b.destitulo,
		   b.desvideo,
		   b.desurl,
		   b.instatus,
		   b.dtcadastro
	FROM tb_videos_tipos a
	INNER JOIN tb_videos b
	ON b.idvideotipo = a.idvideotipo
	LEFT JOIN tb_cursos c
	ON c.curso_id = b.curso_id
	ORDER BY b.dtcadastro DESC, b.idvideo desc		   
END
--------------------------------------------------------------------------------
ALTER PROC sp_cursosbyvideos_list
AS
/*
app: SimpacWeb
url: simpacweb/modulos/fit/adm_videos/json/cursosbyvideo_list.php
data: 2013-01-07
author: Massa
*/
BEGIN
	select DISTINCT c.curso_id, 
					c.curso_titulo
	FROM tb_videos_tipos a
	INNER JOIN tb_videos b
	ON b.idvideotipo = a.idvideotipo 
	INNER JOIN tb_cursos c
	ON c.curso_id = b.curso_id
	WHERE b.instatus = 1 AND a.instatus = 1 AND a.idvideotipo = 1			
	order by c.curso_titulo desc	   
END

sp_cursosbyvideos_list 
--------------------------------------------------------------------------------
CREATE PROC sp_videos_delete
(@idvideo int)
AS
/*
app: SimpacWeb
url: simpacweb/modulos/fit/adm_videos/json/videos_delete.php
data: 2013-01-07
author: Massa
*/
BEGIN
	DELETE tb_videos
	WHERE idvideo = @idvideo
END
--------------------------------------------------------------------------------
ALTER PROC sp_videos_update
(@idvideo int, @curso_id int, @idvideotipo int, @destitulo varchar(200), @desvideo varchar(500), @desurl varchar(200))
AS
/*
app: SimpacWeb
url: simpacweb/modulos/fit/adm_videos/json/videos_update.php
data: 2013-01-07
author: Massa
*/
BEGIN
	IF((@curso_id <> 0) AND (@curso_id <> ''))
		BEGIN 		
			UPDATE tb_videos
			SET idvideotipo = @idvideotipo,
				curso_id = @curso_id,
				destitulo = @destitulo,
				desvideo = @desvideo,
				desurl = @desurl
			WHERE idvideo = @idvideo		
		END
	ELSE
		BEGIN
			UPDATE tb_videos
			SET idvideotipo = @idvideotipo,
				destitulo = @destitulo,
				desvideo = @desvideo,
				desurl = @desurl
			WHERE idvideo = @idvideo	
		END		
END
--------------------------------------------------------------------------------
CREATE PROC sp_videos_instatus
(@idvideo int)
AS
/*
app: SimpacWeb
url: simpacweb/modulos/fit/adm_videos/json/videos_instatus.php
data: 2013-01-07
author: Massa
*/
IF(SELECT instatus FROM tb_videos WHERE idvideo = @idvideo) = 0
	BEGIN
		UPDATE tb_videos
		SET instatus = 1
		WHERE idvideo = @idvideo
	END
ELSE
	BEGIN
		UPDATE tb_videos
		SET instatus = 0
		WHERE idvideo = @idvideo
	END	
--------------------------------------------------------------------------------

select * from (

	select top 5 * from (
	
		select top 10 a.desvideotipo,
						a.idvideotipo,
						c.curso_titulo,
						b.idvideo,
						b.destitulo,
						b.desvideo,
						b.desurl,
						b.dtcadastro
		FROM tb_videos_tipos a
		INNER JOIN tb_videos b
		ON b.idvideotipo = a.idvideotipo 
		LEFT JOIN tb_cursos c
		ON c.curso_id = b.curso_id
		WHERE b.instatus = 1 AND a.instatus = 1 AND a.idvideotipo = 1
		
		order by b.dtcadastro desc, b.idvideo desc 
	
	) as newtbl order by dtcadastro asc,  idvideo asc 

) as newtbl2 order by dtcadastro desc,  idvideo desc 


--by combo Curso
select * from (

	select top 5 * from (
	
		select DISTINCT c.curso_id,
						c.curso_titulo
		FROM tb_videos_tipos a
		INNER JOIN tb_videos b
		ON b.idvideotipo = a.idvideotipo 
		INNER JOIN tb_cursos c
		ON c.curso_id = b.curso_id
		WHERE b.instatus = 1 AND a.instatus = 1 AND a.idvideotipo = 1 --AND c.curso_id = 4
		
		order by c.curso_titulo desc
	
	) as newtbl order by curso_titulo asc

) as newtbl2 order by curso_titulo desc

--Count
SELECT COUNT(*) as totalregistro 
FROM tb_videos_tipos a
INNER JOIN tb_videos b
ON b.idvideotipo = a.idvideotipo
INNER JOIN tb_cursos c
ON c.curso_id = b.curso_id
where destitulo like '%%' OR desvideo like '%""%' AND
	 b.instatus = 1 AND a.instatus = 1 AND a.idvideotipo = 1
	
----------------------------------------------------------	
USE FIT_NEW
SELECT * FROM tb_cursos where curso_titulo like '%adm%'

sp_cursos_list

sp_helpdb fit_new

Administração <span class=menor>- Ênfase em Tecnologia da Informação</span>