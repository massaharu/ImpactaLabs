
CREATE PROC sp_proc_seletivo_save
(@curso_id int,@ra int,@session_id varchar(200),@desnome varchar(200),@descep varchar(15),@desendereco varchar(200),@destelefone varchar(15),@descelular	varchar(15),@desemail varchar(50),@dt_nascimento datetime,@desexo char(1),@desrg varchar(20),@descpf char(11),@desempresa	varchar(200),@descargo		varchar(200),@desatividades varchar(max),@descertificacao varchar(max),@desconhecimento	varchar(max),@desescolhacurso varchar(max),@desobjetivocurso varchar(max),@descurso_academica varchar(200),@desinstituicao	varchar(200),@desanoconclusao datetime,@desempresa_experiencia varchar(200),@descargo_experiencia varchar(200),@dtentrada datetime,@dtsaida datetime,@desatividade varchar(200),@descurso_realizado varchar(200),@desinstituicao_realizado varchar(200),@descargahoraria varchar(100),@descertificado char(1),@ididiomatipo int)
AS
INSERT tb_proc_seletivo
(curso_id,ra,session_id,desnome,descep,desendereco,destelefone,descelular,desemail,dt_nascimento,desexo,desrg,descpf,desempresa,descargo,desatividades,descertificacao,desconhecimento,desescolhacurso,desobjetivocurso)
VALUES
	(@cursoid,@ra,@session_id,@desnome,@descep,@desendereco,@destelefone,@descelular,@desemail,@dt_nascimento,@desexo,@desrg,@descpf,@desempresa,@descargo,@desatividades,@descertificacao,@desconhecimento,@desescolhacurso,@desobjetivocurso)	
IF (scope_identity() is not null)
	BEGIN
		INSERT tb_formacao_academica
		(idprocessoseletivo,descurso_academica,desinstituicao,desanoconclusao)
		VALUES	
		(SCOPE_IDENTITY(),@descurso_academica,@desinstituicao,@desanoconclusao)
		INSERT tb_experiencia_profissional
		(idprocessoseletivo,desempresa_experiencia,descargo_experiencia,dtentrada,dtsaida,desatividade)
		VALUES	
		(scope_identity(),@desempresa_experiencia,@descargo_experiencia,@dtentrada,@dtsaida,@desatividade)	
		INSERT tb_curso_realizado
		(idprocessoseletivo,descurso_realizado,desinstituicao_realizado,descargahoraria,descertificado)
		VALUES
		(scope_identity(),@descurso_realizado,@desinstituicao_realizado,@descargahoraria,@descertificado)	
		INSERT tb_idioma	
		(idprocessoseletivo,ididiomatipo)
		(scope_identity(),@ididiomatipo)
	END			


CREATE TABLE tb_proc_seletivo_posgraduacao(
	idprocessoseletivo	int not null identity primary key,
	curso_id			int not null,
	ra					int,
	session_id			varchar(200),
	desnome				varchar(200),
	descep				varchar(15),
	desendereco			varchar(200),
	destelefone			varchar(15),	
	descelular			varchar(15),
	desemail			varchar(50),
	dt_nascimento		datetime not null,
	desexo				char(1),
	desrg				varchar(20),
	descpf				char(11),
	desempresa			varchar(200),
	descargo			varchar(200),
	desatividades		varchar(max),
	descertificacao		varchar(max),
	desconhecimento		varchar(max),
	desescolhacurso		varchar(max),
	desobjetivocurso	varchar(max),
	instatus			int not null,
	dtcadastro			datetime			
)
ALTER TABLE tb_proc_seletivo_posgraduacao ADD
CONSTRAINT DF_tb_proc_seletivo_posgraduacao_instatus DEFAULT(1)for instatus,
CONSTRAINT DF_tb_proc_seletivo_posgraduacao_dtcadstro DEFAULT(getdate()) for dtcadastro,
CONSTRAINT FK_tb_proc_seletivo_posgraduacao_curso_id FOREIGN KEY (curso_id)
REFERENCES tb_cursos (curso_id)

CREATE TABLE tb_formacao_academica(
	idformacao		int not null primary key identity,
	idprocessoseletivo	int not null,
	descurso_academica		varchar(200),
	desinstituicao	varchar(200),
	desanoconclusao	datetime,
	CONSTRAINT FK_tb_formacao_academica_idprocessoseletivo FOREIGN KEY(idprocessoseletivo)REFERENCES tb_proc_seletivo(idprocessoseletivo)
)
CREATE TABLE tb_experiencia_profissional(
	idexperiencia		int not null primary key identity,
	idprocessoseletivo	int not null,
	desempresa_experiencia			varchar(200),
	descargo_experiencia			varchar(200),
	dtentrada			datetime,
	dtsaida				datetime,
	desatividade		varchar(200)
	CONSTRAINT FK_tb_experiencia_profissional_idprocessoseletivo FOREIGN KEY(idprocessoseletivo)REFERENCES tb_proc_seletivo(idprocessoseletivo)
)
CREATE TABLE tb_curso_realizado(
	idcursorealizado	int not null primary key identity,
	idprocessoseletivo	int not null,
	descurso_realizado			varchar(200),
	desinstituicao_realizado		varchar(200),
	descargahoraria		varchar(100),
	descertificado		char(1),	
	CONSTRAINT FK_tb_curso_realizado_idprocessoseletivo FOREIGN KEY(idprocessoseletivo)REFERENCES tb_proc_seletivo(idprocessoseletivo)
)

CREATE TABLE tb_idioma(
	ididioma		int not null identity primary key,
	ididiomatipo	int not null,
	idprocessoseletivo	int not null,
	CONSTRAINT FK_tb_idioma_ididiomatipo FOREIGN KEY(ididiomatipo)
	REFERENCES tb_idiomatipo(ididiomatipo),
	CONSTRAINT	FK_tb_idioma_idprocessoseletivo FOREIGN KEY(idprocessoseletivo)REFERENCES tb_proc_seletivo(idprocessoseletivo)
)


CREATE TABLE tb_idiomatipo(
	ididiomatipo	int not null identity primary key,
	ididiomanivel	int not null,
	desidiomatipo	varchar(200),
	CONSTRAINT	FK_tb_idiomatipo_ididiomanivel FOREIGN KEY (ididiomanivel)
	REFERENCES tb_idiomanivel(ididiomanivel)
)

CREATE TABLE tb_idiomanivel(
	ididiomanivel	int not null identity primary key,
	desidiomanivel	varchar(100)
)


SELECT *FROM tb_idiomatipo 

select * from tb_cursos
WHERE curso_tipo = 2
	and curso_ativo = 1