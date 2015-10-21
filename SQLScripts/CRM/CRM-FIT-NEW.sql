SELECT *FROM tb_descontos;
select * from tb_produtotipos
select * from tb_produtos_sophiacursos
select * from tb_produtos
select * from tb_produtos where idproduto in(1004002, 1004003, 1003990, 1003992, 1003991)

--INSERT INTO tb_produtos(idprodutotipo, desproduto)
--VALUES
--(16, 'Sistema de Informação - Manhã'),
--(16, 'Análise e Desenvolvimento de Sistemas - Manhã'),
--(16, 'Redes de Computadores - Manhã'),
--(16, 'Mecatrônica - Manhã'),
--(16, 'Telecomunicações - Manhã')
--tb_oportunidadefit

-----------------------------------------------------------
-------------------- TABELAS -----------------------------
-----------------------------------------------------------
CREATE table tb_oportunidadesfit(
      idoportunidadefit int not null identity,
      idoportunidade int not null,
      idprodutotipo int not null,
      idproduto int not null,
      idvestibular int null,
      intransferido bit not null constraint DF_oportunidadesfit_intransferido default 0,
      infies bit not null constraint DF_oportunidadesfit_infies default 0,
      inprouni bit not null constraint DF_oportunidadesfit_inprouni default 0,
      dtcadastro datetime not null constraint DF_oportunidadesfit_dtcadastro default getdate(),
      instatus bit not null constraint DF_oportunidadesfit_instatus default 1
      
      constraint PK_oportunidadesfit primary key(idoportunidadefit),
      constraint FK_oportunidadesfit_oportunidade_idoportunidade foreign key(idoportunidade) references tb_oportunidades(idoportunidade),
      constraint FK_oportunidadesfit_produtotipos_idprodutotipo foreign key(idprodutotipo) references tb_produtotipos(idprodutotipo)
);
-----------------------------------------------------------
--tb_transferidofaculdade
CREATE table tb_transferidofaculdades(
      idoportunidadefit int not null,
      idpessoa int not null
      
      constraint PK_transferidofaculdades_idoportunidadefit_idpessoa primary key(idoportunidadefit, idpessoa)
)

alter table tb_transferidofaculdades
add constraint FK_transferidofaculdades_oportunidadesfit_idoportunidadefit foreign key(idoportunidadefit)references tb_oportunidadesfit(idoportunidadefit)

alter table tb_transferidofaculdades
add constraint fk_transferidofaculdades_pessoas_idpessoa foreign key(idpessoa)references tb_pessoas(idpessoa)

-----------------------------------------------------------
--tb_tipodesconto
CREATE table tb_tipodescontos(
      idtipodesconto int not null identity,
      destipodesconto varchar(30) not null,
      instatus bit not null constraint DF_tipodescontos_instatus default 1,
      dtcadastro datetime not null  constraint DF_tipodescontos_dtcadastrodefault default getdate(),
      
      constraint PK_tipodescontos primary key(idtipodesconto)
)

SELECT * FROM tb_descontostipos
-----------------------------------------------------------
create table tb_descontos(
      iddesconto int not null identity,
      idtipodesconto int not null,
      desdesconto varchar(100) not null,
      instatus bit not null constraint DF_descontos_instatus default 1,
      dtcadastro datetime not null constraint DF_descontos_dtcadastro default getdate()
      
      constraint PK_descontos primary key(iddesconto),
      constraint FK_descontos_tipodescontos_idtipodesconto foreign key(idtipodesconto) references tb_tipodescontos(idtipodesconto)
)
-----------------------------------------------------------
--tb_desconto_produtostipos
create table tb_descontos_produtostipos(
      iddesconto int not null,
      idprodutotipo int not null
      
      constraint PK_descontos_produtostipos_iddesconto_idprodutotipo primary key(iddesconto,idprodutotipo)
)

alter table tb_descontos_produtostipos
add constraint FK_descontos_produtostipos_iddesconto foreign key(iddesconto)references tb_descontos(iddesconto)

alter table tb_descontos_produtostipos
add constraint FK_descontos_produtostipos_idprodutotipo foreign key(idprodutotipo)references tb_produtotipos(idprodutotipo)
-----------------------------------------------------------
--tb_oportunidadefit_descontos
CREATE table tb_oportunidadesfitdescontos(
      idoportunidadefit int not null,
      iddescontoitemtipo int not null,
      iddesconto int,
      nrparcelasoportunidadefit int,
      dtcadastro datetime not null constraint DF_oportunidadesfitdescontos_dtcadastro default getdate(),
      instatus BIT not null constraint DF_oportunidadesfitdescontos_instatus default 1
      
      constraint PK_oportunidadesfitdescontos_idoportunidadefit_iddescontoitemtipo primary key(idoportunidadefit,iddescontoitemtipo)
)

alter table tb_oportunidadesfitdescontos
add constraint FK_oportunidadesfitdescontos_oportunidadesfit_idoportunidadefit foreign key(idoportunidadefit) references tb_oportunidadesfit(idoportunidadefit)

/*alter table tb_oportunidadesfitdescontos
add constraint FK_oportunidadesfitdescontos_descontos_produtostipos_iddescontoitemtipo foreign key(iddescontoitemtipo) references tb_descontos_produtostipos(iddescontoitemtipo)*/

alter table tb_oportunidadesfitdescontos
add constraint fk_oportunidadesfitdescontos_descontos_iddesconto foreign key(iddesconto) references tb_descontos(iddesconto)

-----------------------------------------------------------
--tb_desconto_produtos
CREATE table tb_descontos_produtos(
      iddesconto int not null,
      idproduto int not null
      
      constraint pk_descontos_produtos_iddesconto_idproduto primary key(iddesconto, idproduto)
)

alter table tb_descontos_produtos
add constraint fk_descontos_produtos_iddesconto foreign key(iddesconto)references tb_descontos(iddesconto)

alter table tb_descontos_produtos
add constraint fk_descontos_produtos_produtos_idproduto foreign key(idproduto)references tb_produtos(idproduto)
-----------------------------------------------------------

CREATE table tb_descontositemtipos(
      iddescontoitemtipo int not null identity,
      destipoitem varchar(30) not null,
      instatus bit not null constraint DF_descontositemtipos_instatus default 1,
      dtcadastro datetime not null constraint DF_descontositemtipos_dtcadastro default getdate()
      
      constraint PK_descontositemtipos_iddescontoitemtipo primary key(iddescontoitemtipo)
)

-----------------------------------------------------------
create table tb_descontositens(
      iddescontoitem int not null identity,
      iddesconto int not null,
      iditemtipo int not null,
      nrdia int not null,
      nrporc int not null 
      
      constraint PK_descontositens_iddescontoitem primary key(iddescontoitem)
)

alter table tb_descontositens
add constraint fk_descontositens_descontos_iddesconto foreign key(iddesconto)references tb_descontos(iddesconto)

/*alter table tb_descontositens
add constraint fk_descontositens_descontositemtipos_iddescontoitemtipo foreign key(iddescontoitemtipo)references tb_descontositemtipos(iddescontoitemtipo)*/

-----------------------------------------------------------
create table tb_descontoscampanhasfit(
      iddescontocampanhafit int not null identity,
      iddesconto int not null,
      dtinicio datetime not null,
      dttermino datetime not null,
      desobservacao varchar(1000),
      nrparcelas int,
      instatus bit not null constraint DF_descontoscampanhasfit_instatus default 1,
      dtcadastro datetime not null constraint DF_descontoscampanhasfit_dtcadastro default getdate()
      
      constraint PK_descontoscampanhasfit_iddescontocampanhafit primary key(iddescontocampanhafit)   
)

alter table tb_descontoscampanhasfit
add constraint fk_descontoscampanhasfit_descontos_iddesconto foreign key(iddesconto)references tb_descontos(iddesconto)

--------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------
----------------- PROCEDURE -------------------------------------------------------
--------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------
CREATE PROC sp_descontotipo_academico_list
AS
/*
  app:CRM
  url:/simpacweb/modulos/fit/financeiro/admDescontos/actions/json/descontotipoacademico_list.php
  author: Massaharu
  date: 1/10/2013
*/
BEGIN
	SELECT 
		DISTINCT 
		d.idprodutotipo, d.desprodutotipo, d.dtcadastro
	FROM tb_produtos a
	INNER JOIN tb_produtos_sophia_cursos b ON b.idproduto = a.idproduto
	INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS c ON c.PRODUTO = b.produto
	INNER JOIN tb_produtotipos d ON d.idprodutotipo = a.idprodutotipo
END

sp_depends tb_produtos

exec dbo.sp_produtobyidprodutotipo_list 15
SELECT * FROM SONATA.SOPHIA.SOPHIA.CURSOS 
SELECT * FROM tb_produtotipos
SELECT * FROM tb_produtos
--------------------------------------------------------------------------------------
ALTER PROC sp_produtos_sophiacursos_list
(@idprodutotipo int = NULL)
AS
/*
  app:CRM
  url:/simpacweb/modulos/fit/financeiro/admDescontos/actions/json/produtos_sophiacursos_list.php
  author: Massaharu
  date: 1/10/2013
*/
BEGIN
	IF @idprodutotipo IS NULL
	BEGIN
		SELECT  
			a.idproduto,
			a.idprodutotipo,
			a.desproduto,
			a.instatus,
			a.dtcadastro,
			a.idimagem,
			a.nrestoque,
			a.dtvalidade,
			a.nrparcelas,
			d.desprodutotipo
		FROM tb_produtos a
		INNER JOIN tb_produtos_sophia_cursos b ON b.idproduto = a.idproduto
		INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS c ON c.PRODUTO = b.produto
		INNER JOIN tb_produtotipos d ON d.idprodutotipo = a.idprodutotipo
		WHERE a.instatus = 1
		ORDER BY d.desprodutotipo, a.desproduto
	END
	ELSE
	BEGIN
		SELECT  
			a.idproduto,
			a.idprodutotipo,
			a.desproduto,
			a.instatus,
			a.dtcadastro,
			a.idimagem,
			a.nrestoque,
			a.dtvalidade,
			a.nrparcelas,
			d.desprodutotipo
		FROM tb_produtos a
		INNER JOIN tb_produtos_sophia_cursos b ON b.idproduto = a.idproduto
		INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS c ON c.PRODUTO = b.produto
		INNER JOIN tb_produtotipos d ON d.idprodutotipo = a.idprodutotipo
		WHERE d.idprodutotipo = @idprodutotipo AND a.instatus = 1
		ORDER BY d.desprodutotipo, a.desproduto
	END
END

SELECT * FROM SONATA.SOPHIA.SOPHIA.CURSOS