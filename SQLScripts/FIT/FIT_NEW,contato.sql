USE FIT_NEW

SELECT *FROM tb_contatodepartamento

select * from tb_contato

CREATE TABLE tb_contato(
	idcontato	int not null primary key identity(1,1),
	ra			int,
	session_id	varchar(200),
	desnome		varchar(200),
	descurso	varchar(200),
	desturma	varchar(200),
	desemail	varchar(200),
	destelefone	varchar(20),
	idassunto	int,
	iddepartamento	int,
	desmensagem	varchar(max),
	instatus	int not null,
	dtcadastro	datetime
)
ALTER TABLE tb_contato ADD
CONSTRAINT DF_tb_contato_instatus DEFAULT(1) for instatus,
CONSTRAINT DF_tb_contato_dtcadastro DEFAULT(getdate()) for dtcadastro,
CONSTRAINT FK_tb_contato_idassunto	FOREIGN KEY(idassunto)
REFERENCES tb_contatoassunto(idassunto),
CONSTRAINT FK_tb_contato_iddepartamento FOREIGN KEY (iddepartamento)
REFERENCES tb_contatodepartamento(iddepartamento)

CREATE TABLE tb_contatodepartamento(
	iddepartamento	int not null primary key identity(1,1),
	desdepartamento	varchar(200)
)
CREATE TABLE tb_contatoassunto(
	idassunto	int not null primary key identity(1,1),
	desassunto	varchar(200)
)

------------------------------------------------------------------------
SELECT a.idcontato,a.ra,a.session_id,a.desnome,a.descurso,a.desturma,a.desemail,a.destelefone,a.desmensagem,a.instatus,a.dtcadastro,b.desdepartamento,c.desassunto
FROM tb_contato a
INNER JOIN tb_contatodepartamento b
ON b.iddepartamento = a.iddepartamento
INNER JOIN tb_contatoassunto c
ON c.idassunto = a.idassunto 

ALTER PROC sp_contatodepartamento_list
AS
SELECT *FROM tb_contatodepartamento
ORDER BY desdepartamento

CREATE PROC sp_contatoassunto_list
AS
SELECT *FROM tb_contatoassunto

sp_contato_save NULL,'istvaanonpjf122vag3egt98d6','werer','ewrwr','werwre','massa.kunikane@hotmail.com','(22) 2222-2222',1,1,'wew'

ALTER PROC sp_contato_save
(@ra int,@session_id varchar(200),@desnome varchar(200),@descurso varchar(200),@desturma varchar(200),@desemail varchar(200),@destel varchar(200),@idassunto int,@iddepartamento int,@desmensagem varchar(max))
AS
INSERT tb_contato
(ra,session_id,desnome,descurso,desturma,desemail,destelefone,idassunto,iddepartamento,desmensagem)
VALUES
(@ra,@session_id,@desnome,@descurso,@desturma,@desemail,@destel,@idassunto,@iddepartamento,@desmensagem)


INSERT tb_contatoassunto
VALUES
('Criticas'),('Elogios'),('Sugestoes')

SELECT *FROM tb_contatoassunto

INSERT tb_contatodepartamento
VALUES
('Graduação'),('Pós-Graduação'),('Colégio Impacta'),('Biblioteca'),('Núcleo de Estágios')

UPDATE tb_contatodepartamento
SET desdepartamento = 'Outros'
WHERE iddepartamento = 3

