USE Avaliacao
GO
SELECT top(100) *FROM tb_AvaliacaoFinal_Avaliacao
ORDER BY dtcadastramento DESC
----------------------------------------------------
USE Avaliacao
GO
Select *from tb_AvaliacaoFinal_Categoria
----------------------------------------------------
USE Simpac
GO
exec sp_AvaliacaoFinal_list

sp_text_object_show sp_AvaliacaoFinalRelatorio
sp_text_object_show sp_AvalicaoItensMedia
sp_text_object_show sp_AvaliacaoFinal_list
sp_text_object_show sp_cursoagendadolalunos_list2 sp_AvaliacaoFinal_list

SELECT *FROM tb_alunoempresa
WHERE idempresa = 398764
SELECT nmEmpresa FROM tb_Empresa
WHERE idempresa = 398764
SELECT *FROM tb_alunoagendado
SELECT *FROM tb_CursosAgendados
----------------------------------------------------
USE Avaliacao
GO
select *from tb_AvaliacaoFinal_Questoes
select *from tb_AvaliacaoFinal_Categoria
----------------------------------------------------
USE DEV_TESTE
CREATE TABLE tb_AvaliacaoFinalLocacoes_Categoria(
	idcategoria		int not null identity,
	descategoria	varchar(50) not null,
	nrordem			int,
	dtcadastro		datetime
CONSTRAINT PK_AvaliacaoFinalLocacoes_Categoria PRIMARY KEY(idcategoria),
CONSTRAINT DF_AvaliacaoFinalLocacoes_Categoria_dtcadastro DEFAULT(getdate()) FOR dtcadastro

)
--
CREATE TABLE tb_AvaliacaoFinalLocacoes_Questoes(
	idquestao		int not null identity,
	desquestao		varchar(500) not null,
	idcategoria		int,
	instatus		bit default(1),
	desimagem		varchar(100),
	dtcadastro		datetime 
CONSTRAINT PK_AvaliacaoFinalLocacoes_Questoes PRIMARY KEY(idquestao),
CONSTRAINT FK_AvaliacaoFinalLocacoes_Questoes_AvaliacaoFinalLocacoes_Categoria_idcategoria FOREIGN KEY(idcategoria)
REFERENCES tb_AvaliacaoFinalLocacoes_Categoria(idcategoria),
CONSTRAINT DF_AvaliacaoFinalLocacoes_Questoes_dtcadastro DEFAULT(getdate()) FOR dtcadastro
)
--
CREATE TABLE tb_AvaliacaoFinalLocacoes_Avaliacao(
	idavaliacao		int not null identity,
	idquestao		int not null,
	idcursoagendado	int not null,
	desresposavel		varchar(200),
	desemailresponsavel	varchar(200),
	descomentario	varchar(1000),
	nrnota			tinyint,
	dtcadastro		datetime
CONSTRAINT PK_AvaliacaoFinalLocacoes_Avaliacao PRIMARY KEY(idavaliacao),
CONSTRAINT FK_AvaliacaoFinalLocacoes_Avaliacao_AvaliacaoFinalLocacoes_Questoes_idquestao FOREIGN KEY(idquestao)
REFERENCES tb_AvaliacaoFinalLocacoes_Questoes(idquestao),
CONSTRAINT DF_AvaliacaoFinalLocacoes_Avaliacao_dtcadastro DEFAULT(getdate()) FOR dtcadastro
)
------------------
USE DEV_TESTE
GO
INSERT tb_AvaliacaoFinalLocacoes_Categoria
VALUES
('Atendimento',0,DEFAULT),
('Infra-Estrutura',1,DEFAULT),
('Localização',2,DEFAULT),
('Café',3,DEFAULT)

SELECT *FROM tb_AvaliacaoFinalLocacoes_Categoria
--------------
USE DEV_TESTE
GO
INSERT tb_AvaliacaoFinalLocacoes_Questoes
VALUES
('Foi utilizado o serviço do Café?',4,DEFAULT,NULL,DEFAULT),
('Avalie o atendimento recebido pela equipe da Impacta.',1,DEFAULT,NULL,DEFAULT),
('Avalie a Infraestrutura do serviço utilizado. - [Iluminação, móveis, ar-condicionado, banheiro, e outros]',2,DEFAULT,NULL,DEFAULT),
('Avalie os recursos técnicos da sala de aula. - [TV ou projetor, rede, internet, e microcomputadores] estão de acordo com os objetivos contratados?',3,DEFAULT,NULL,DEFAULT),
('Avalie a Localização.',3,DEFAULT,NULL,DEFAULT),
('A Impacta sempre inovando para melhor atender seus clientes.',3,DEFAULT,NULL,DEFAULT)

SELECT *FROM tb_AvaliacaoFinalLocacoes_Questoes
---------------------------------------------------------------------------------------------

CREATE PROC sp_AvaliacaoFinalLocacoes_list
AS
BEGIN
	/*
	app:Simpacweb
	url:class/class.avaliacaofinallocacoes.php
	data: 2012/10/31 11:22
	user: Massaharu
	*/
	SELECT idquestao, desquestao FROM tb_AvaliacaoFinalLocacoes_Questoes
	WHERE instatus = 1
END	

sp_AvaliacaoFinalLocacoes_list
----------------------------------------
--
Select *from Avaliacao.dbo.tb_AvaliacaoFinalLocacoes_Avaliacao
