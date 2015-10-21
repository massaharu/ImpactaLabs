CREATE PROC sp_oportunidadeatendentes_list
AS
/*
  app:CRM
  url:/simpacweb/modulos/fit/atendimento/acompanhamento_oportunidade/actions/json/oportunidadeatendentes_list.php
  author: Massaharu
  date: 1/10/2013
  desc: Lista todos os atendentes que possuem alguma oportunidade
*/
BEGIN		
	SELECT 
		b.idusuario, nmusuario, nmlogin, cdemail, nrramal, inatendente, 
		nrpercentualdesconto, instatus, nmcompleto, idnivel, iddepto, idcargo, idfranquia, sexo, 
		centrocusto, ingerente, codigo, incorporativo, inatendenteativo, nrcpf, idunidade, desfoto, dtcadastro, dtadmissao
	FROM (
		SELECT DISTINCT idusuario FROM tb_oportunidadeusuarios a
		INNER JOIN tb_oportunidadesfit b on b.idoportunidade = a.idoportunidade
	) a
	INNER JOIN Simpac..tb_usuario b ON b.idusuario = a.idusuario
	WHERE 
		(b.inatendente = 1 and b.InStatus = 1) OR
		b.IdDepto = 19 -- Desenvolvimento
END
--------------------------------------------------------------------------------
ALTER PROC sp_oportunidadesbyatendente_list 
(
	@idusuario int,
	@data_de datetime,
	@data_ate datetime,
	@idsprodutotipo varchar(50),
	@idoportunidadeetapatipo int = NULL
)
AS
/*
  app:CRM
  url:/simpacweb/modulos/fit/atendimento/acompanhamento_oportunidade/actions/json/oportunidadesbyatendente_list.php
  author: Massaharu
  date: 1/10/2013
  desc: Lista todos as oportunidades cadastradas por um atendente
*/
BEGIN
	IF @idoportunidadeetapatipo IS NULL
	BEGIN
		IF @idusuario IS NOT NULL AND @idusuario <> ''
		BEGIN
			SELECt 
				b.idoportunidade,
				g.idoportunidadefit,
				a.idusuario, 
				i.nmcompleto, 
				c.despessoa, 
				j.idoportunidadeetapatipo, 
				j.desetapa, 
				c.*,
				g.idprodutotipo,
				d.descontato as desemail,
				e.descontato as desfone,
				f.descontato as descelular,	
				k.desproduto,
				b.dtcadastro,
				b.instatus 
			FROM tb_oportunidadeusuarios a
			INNER JOIN tb_oportunidades b ON b.idoportunidade = a.idoportunidade
			INNER JOIN tb_pessoas c ON c.idpessoa = b.idpessoa
			LEFT JOIN (SELECT TOP 1 * FROM tb_contatos) d ON d.idpessoa = c.idpessoa AND d.idcontatotipo = 1
			LEFT JOIN (SELECT TOP 1 * FROM tb_contatos) e ON d.idpessoa = e.idpessoa AND d.idcontatotipo = 2
			LEFT JOIN (SELECT TOP 1 * FROM tb_contatos) f ON d.idpessoa = f.idpessoa AND d.idcontatotipo = 3
			INNER JOIN tb_oportunidadesfit g ON g.idoportunidade = b.idoportunidade
			LEFT JOIN tb_oportunidadeetapas h ON h.idoportunidade = b.idoportunidade AND h.instatus = 1
			INNER JOIN Simpac..tb_usuario i ON i.IdUsuario = a.idusuario
			LEFT JOIN tb_oportunidadeetapatipos j ON j.idoportunidadeetapatipo = h.idoportunidadeetapatipo
			INNER JOIN tb_produtos k ON k.idproduto = g.idproduto
			INNER JOIN tb_oportunidadeusuariotipos l ON l.idoportunidadeusuariotipo = a.idoportunidadeusuariotipo AND a.idoportunidadeusuariotipo = 1
			WHERE 
				a.idusuario = @idusuario AND 
				b.dtcadastro BETWEEN @data_de AND DATEADD(SECOND, 59, DATEADD(MINUTE, 59, DATEADD(HOUR, 23, @data_ate))) AND
				g.idprodutotipo in (
					SELECT id FROM Simpac..fnSplit(@idsprodutotipo, ',')
				)
			ORDER BY b.idoportunidade DESC
		END
		ELSE
		BEGIN
			SELECt 
				b.idoportunidade,
				g.idoportunidadefit,
				a.idusuario, 
				i.nmcompleto, 
				c.despessoa, 
				j.idoportunidadeetapatipo, 
				j.desetapa, 
				c.*,
				g.idprodutotipo,
				d.descontato as desemail,
				e.descontato as desfone,
				f.descontato as descelular,	
				k.desproduto,
				b.dtcadastro,
				b.instatus 
			FROM tb_oportunidadeusuarios a
			INNER JOIN tb_oportunidades b ON b.idoportunidade = a.idoportunidade
			INNER JOIN tb_pessoas c ON c.idpessoa = b.idpessoa
			LEFT JOIN (SELECT TOP 1 * FROM tb_contatos) d ON d.idpessoa = c.idpessoa AND d.idcontatotipo = 1
			LEFT JOIN (SELECT TOP 1 * FROM tb_contatos) e ON d.idpessoa = e.idpessoa AND d.idcontatotipo = 2
			LEFT JOIN (SELECT TOP 1 * FROM tb_contatos) f ON d.idpessoa = f.idpessoa AND d.idcontatotipo = 3
			INNER JOIN tb_oportunidadesfit g ON g.idoportunidade = b.idoportunidade
			LEFT JOIN tb_oportunidadeetapas h ON h.idoportunidade = b.idoportunidade AND h.instatus = 1
			INNER JOIN Simpac..tb_usuario i ON i.IdUsuario = a.idusuario
			LEFT JOIN tb_oportunidadeetapatipos j ON j.idoportunidadeetapatipo = h.idoportunidadeetapatipo
			INNER JOIN tb_produtos k ON k.idproduto = g.idproduto
			INNER JOIN tb_oportunidadeusuariotipos l ON l.idoportunidadeusuariotipo = a.idoportunidadeusuariotipo AND a.idoportunidadeusuariotipo = 1
			WHERE 
				b.dtcadastro BETWEEN @data_de AND DATEADD(SECOND, 59, DATEADD(MINUTE, 59, DATEADD(HOUR, 23, @data_ate))) AND
				g.idprodutotipo in (
					SELECT id FROM Simpac..fnSplit(@idsprodutotipo, ',')
				)
			ORDER BY b.idoportunidade DESC
		END
	END
	ELSE
	BEGIN
		IF @idusuario IS NOT NULL AND @idusuario <> ''
		BEGIN
			SELECT 
				b.idoportunidade,
				g.idoportunidadefit,
				a.idusuario, 
				i.nmcompleto, 
				c.despessoa, 
				j.idoportunidadeetapatipo, 
				j.desetapa, 
				c.*,
				g.idprodutotipo,
				d.descontato as desemail,
				e.descontato as desfone,
				f.descontato as descelular,	
				k.desproduto,
				b.dtcadastro,
				b.instatus 
			FROM tb_oportunidadeusuarios a
			INNER JOIN tb_oportunidades b ON b.idoportunidade = a.idoportunidade
			INNER JOIN tb_pessoas c ON c.idpessoa = b.idpessoa
			LEFT JOIN (SELECT TOP 1 * FROM tb_contatos) d ON d.idpessoa = c.idpessoa AND d.idcontatotipo = 1
			LEFT JOIN (SELECT TOP 1 * FROM tb_contatos) e ON d.idpessoa = e.idpessoa AND d.idcontatotipo = 2
			LEFT JOIN (SELECT TOP 1 * FROM tb_contatos) f ON d.idpessoa = f.idpessoa AND d.idcontatotipo = 3
			INNER JOIN tb_oportunidadesfit g ON g.idoportunidade = b.idoportunidade
			LEFT JOIN tb_oportunidadeetapas h ON h.idoportunidade = b.idoportunidade AND h.instatus = 1
			INNER JOIN Simpac..tb_usuario i ON i.IdUsuario = a.idusuario
			LEFT JOIN tb_oportunidadeetapatipos j ON j.idoportunidadeetapatipo = h.idoportunidadeetapatipo
			INNER JOIN tb_produtos k ON k.idproduto = g.idproduto
			INNER JOIN tb_oportunidadeusuariotipos l ON l.idoportunidadeusuariotipo = a.idoportunidadeusuariotipo AND a.idoportunidadeusuariotipo = 1
			WHERE 
				a.idusuario = @idusuario AND 
				b.dtcadastro BETWEEN @data_de AND DATEADD(SECOND, 59, DATEADD(MINUTE, 59, DATEADD(HOUR, 23, @data_ate))) AND
				g.idprodutotipo in (
					SELECT id FROM Simpac..fnSplit(@idsprodutotipo, ',')
				) AND
				h.idoportunidadeetapatipo = @idoportunidadeetapatipo
			ORDER BY b.idoportunidade DESC
		END
		ELSE
		BEGIN
			SELECt 
				b.idoportunidade,
				g.idoportunidadefit,
				a.idusuario, 
				i.nmcompleto, 
				c.despessoa, 
				j.idoportunidadeetapatipo, 
				j.desetapa, 
				c.*,
				g.idprodutotipo,
				d.descontato as desemail,
				e.descontato as desfone,
				f.descontato as descelular,	
				k.desproduto,
				b.dtcadastro,
				b.instatus 
			FROM tb_oportunidadeusuarios a
			INNER JOIN tb_oportunidades b ON b.idoportunidade = a.idoportunidade
			INNER JOIN tb_pessoas c ON c.idpessoa = b.idpessoa
			LEFT JOIN (SELECT TOP 1 * FROM tb_contatos) d ON d.idpessoa = c.idpessoa AND d.idcontatotipo = 1
			LEFT JOIN (SELECT TOP 1 * FROM tb_contatos) e ON d.idpessoa = e.idpessoa AND d.idcontatotipo = 2
			LEFT JOIN (SELECT TOP 1 * FROM tb_contatos) f ON d.idpessoa = f.idpessoa AND d.idcontatotipo = 3
			INNER JOIN tb_oportunidadesfit g ON g.idoportunidade = b.idoportunidade
			LEFT JOIN tb_oportunidadeetapas h ON h.idoportunidade = b.idoportunidade AND h.instatus = 1
			INNER JOIN Simpac..tb_usuario i ON i.IdUsuario = a.idusuario
			LEFT JOIN tb_oportunidadeetapatipos j ON j.idoportunidadeetapatipo = h.idoportunidadeetapatipo
			INNER JOIN tb_produtos k ON k.idproduto = g.idproduto
			INNER JOIN tb_oportunidadeusuariotipos l ON l.idoportunidadeusuariotipo = a.idoportunidadeusuariotipo AND a.idoportunidadeusuariotipo = 1
			WHERE 
				b.dtcadastro BETWEEN @data_de AND DATEADD(SECOND, 59, DATEADD(MINUTE, 59, DATEADD(HOUR, 23, @data_ate))) AND
				g.idprodutotipo in (
					SELECT id FROM Simpac..fnSplit(@idsprodutotipo, ',')
				) AND
				h.idoportunidadeetapatipo = @idoportunidadeetapatipo
			ORDER BY b.idoportunidade DESC
		END
	END
END
--
sp_oportunidadesbyatendente_list NULL, '2010-06-01', '2014-12-31', '14,15,16,17'

SELECT * FROM tb_oportunidades
SELECT * FROM tb_oportunidadesfit
SELECT * FROM tb_produtotipos
SELECT * FROM tb_produtos
SELECT * FROM tb_oportunidadeetapatipos
SELECT * FROM Simpac..tb_usuario WHERE NmLogin =  'marta'
SELECT * FROM tb_oportunidadeusuarios
SELECT * FROM tb_oportunidadeusuariotipos

sp_oportunidadeetapas_tipos_list