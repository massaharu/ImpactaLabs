------------------------------------------------------------------------
------------------------------------------------------------------------
-------------------- LEADS ---------------------------------------------
------------------------------------------------------------------------
------------------------------------------------------------------------
CREATE PROC sp_midiassitenovotipo_list
AS
/*
app: SimpacWeb
url: 
data: 01/10/2015
author: Massaharu
*/
BEGIN

	SELECT 
		idmidia,
		idmidiatipo,
		desmidia,
		instatus,
		dtcadastro
	FROM tb_midias
	WHERE 
		desmidia like 'Site novo FIT - %' AND
		instatus = 1
END
--
sp_midiassitenovotipo_list
------------------------------------------------------------------------
ALTER PROC [dbo].[sp_midiassitenovobymidia_list]
(@idmidia int = NULL, @de datetime, @ate datetime)
AS
/*
app: SimpacWeb
url: 
data: 01/10/2015
author: Massaharu
*/
BEGIN

	SET NOCOUNT ON 
	
	SET ANSI_WARNINGS OFF;
	
	DECLARE @tb_leads TABLE(
		idpessoa int,
		despessoa varchar(500),
		desemail varchar(200),
		descurso1 varchar(500),
		descurso2 varchar(500),
		nrtelresidencial  varchar(50),
		nrcelular  varchar(50),
		nrcpf  varchar(50),
		descursointeresse  varchar(500),
		destransferencia  varchar(500),
		descontatoassunto  varchar(200),
		descontatomsg  varchar(5000),
		desamigoinfo varchar(2000) ,
		idmidia int,
		desmidia varchar(200),
		dtcadastro datetime
	)
	
	------------------------------------------------
	-- Newsletter Impacta
	------------------------------------------------
	IF @idmidia = 84
	BEGIN
	
		INSERT INTO @tb_leads 
		(
			idpessoa,
			despessoa,
			desemail,
			idmidia,
			desmidia,
			dtcadastro
		)
	
		SELECT 
			a.idpessoa,
			a.despessoa, 
			c.descontato,
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		FROM tb_pessoas a 
		INNER JOIN tb_midiapessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
		INNER JOIN tb_midias d ON d.idmidia = b.idmidia
		LEFT JOIN tb_pessoashistoricos j ON j.idpessoa = b.idpessoa 
		LEFT JOIN tb_pessoashistoricos_tipos k ON k.idhistorico = j.idhistorico AND k.idhistoricotipo = 24
		WHERE
			b.idmidia = 84 AND b.dtcadastro BETWEEN @de AND (@ate + 1) AND k.idhistoricotipo = 24
		GROUP BY
			a.idpessoa,
			a.despessoa, 
			c.descontato,
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		ORDER BY
			b.dtcadastro DESC
			
	END
	
	------------------------------------------------
	-- Formulário de Inscrição Vestibular
	------------------------------------------------
	ELSE IF @idmidia = 85
	BEGIN
	
		INSERT INTO @tb_leads 
		(
			idpessoa,
			despessoa,
			desemail,
			nrcelular,
			nrtelresidencial,
			nrcpf,
			descurso1,
			descurso2,
			idmidia,
			desmidia,
			dtcadastro
		)
	
		SELECT 
			a.idpessoa,
			a.despessoa, 
			MAX(c.descontato) as desemail,
			MAX(d.descontato) as nrcelular,
			MAX(e.descontato) as nrtelefone,
			MAX(g.desdocumento) as nrcpf,
			(SELECT desinteresse FROM tb_interesses aa INNER JOIN tb_pessoasinteresses bb ON bb.idinteresse = aa.idinteresse INNER JOIN tb_pessoas cc ON cc.idpessoa = bb.idpessoa WHERE bb.idpessoainteresse = MIN(h.idpessoainteresse)) as curso1,
			(SELECT desinteresse FROM tb_interesses aa INNER JOIN tb_pessoasinteresses bb ON bb.idinteresse = aa.idinteresse INNER JOIN tb_pessoas cc ON cc.idpessoa = bb.idpessoa WHERE bb.idpessoainteresse = MAX(h.idpessoainteresse)) as curso2,
			f.idmidia,
			f.desmidia,
			b.dtcadastro
		FROM tb_pessoas a 
		INNER JOIN tb_midiapessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
		LEFT JOIN tb_contatos d ON d.idpessoa = a.idpessoa AND d.idcontatotipo = 2
		LEFT JOIN tb_contatos e ON e.idpessoa = a.idpessoa AND e.idcontatotipo = 3
		INNER JOIN tb_midias f ON f.idmidia = b.idmidia
		LEFT JOIN tb_documentos g ON g.idpessoa = a.idpessoa AND g.iddocumentotipo = 1
		LEFT JOIN tb_pessoasinteresses h ON h.idpessoa = a.idpessoa AND DAY(h.dtcadastro) = DAY(b.dtcadastro) AND MONTH(h.dtcadastro) = MONTH(b.dtcadastro) AND YEAR(h.dtcadastro) = YEAR(b.dtcadastro) AND DATEPART(hh, h.dtcadastro) = DATEPART(hh, b.dtcadastro)  
		LEFT JOIN tb_interesses i ON i.idinteresse = h.idinteresse
		LEFT JOIN tb_pessoashistoricos j ON j.idpessoa = b.idpessoa
		LEFT JOIN tb_pessoashistoricos_tipos k ON k.idhistorico = j.idhistorico AND k.idhistoricotipo = 31
		WHERE
			b.idmidia = 85 AND b.dtcadastro BETWEEN @de AND (@ate + 1) AND k.idhistoricotipo = 31
		GROUP BY
			a.idpessoa,
			a.despessoa, 
			f.idmidia,
			f.desmidia,
			b.dtcadastro
		ORDER BY
			b.dtcadastro DESC
			
			
	END
	
	------------------------------------------------
	-- Formulário de Transferência
	------------------------------------------------
	ELSE IF @idmidia = 86
	BEGIN
	
		INSERT INTO @tb_leads 
		(
			idpessoa,
			despessoa,
			desemail,
			nrcelular,
			nrtelresidencial,
			nrcpf,
			descursointeresse,
			destransferencia,
			idmidia,
			desmidia,
			dtcadastro
		)
	
		SELECT 
			a.idpessoa,
			a.despessoa, 
			MAX(c.descontato) as desemail,
			MAX(d.descontato) as nrcelular,
			MAX(e.descontato) as nrtelefone,
			MAX(g.desdocumento) as nrcpf,
			(SELECT desinteresse FROM tb_interesses aa INNER JOIN tb_pessoasinteresses bb ON bb.idinteresse = aa.idinteresse INNER JOIN tb_pessoas cc ON cc.idpessoa = bb.idpessoa WHERE bb.idpessoainteresse = MAX(h.idpessoainteresse)) as cursointeresse,
			j.deshistorico,
			f.idmidia,
			f.desmidia,
			b.dtcadastro
		FROM tb_pessoas a 
		INNER JOIN tb_midiapessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
		LEFT JOIN tb_contatos d ON d.idpessoa = a.idpessoa AND d.idcontatotipo = 2
		LEFT JOIN tb_contatos e ON e.idpessoa = a.idpessoa AND e.idcontatotipo = 3
		INNER JOIN tb_midias f ON f.idmidia = b.idmidia
		LEFT JOIN tb_documentos g ON g.idpessoa = a.idpessoa AND g.iddocumentotipo = 1
		LEFT JOIN tb_pessoasinteresses h ON h.idpessoa = a.idpessoa AND DAY(h.dtcadastro) = DAY(b.dtcadastro) AND MONTH(h.dtcadastro) = MONTH(b.dtcadastro) AND YEAR(h.dtcadastro) = YEAR(b.dtcadastro) AND DATEPART(hh, h.dtcadastro) = DATEPART(hh, b.dtcadastro)  
		LEFT JOIN tb_interesses i ON i.idinteresse = h.idinteresse
		LEFT JOIN tb_pessoashistoricos j ON j.idpessoa = b.idpessoa 
		LEFT JOIN tb_pessoashistoricos_tipos k ON k.idhistorico = j.idhistorico AND k.idhistoricotipo = 20
		WHERE
			b.idmidia = 86 AND b.dtcadastro BETWEEN @de AND (@ate + 1) AND k.idhistoricotipo = 20
		GROUP BY
			a.idpessoa,
			a.despessoa, 
			j.destitulo,
			j.deshistorico,
			f.idmidia,
			f.desmidia,
			b.dtcadastro
		ORDER BY
			b.dtcadastro DESC
			
	END
	
	------------------------------------------------
	-- Formulário de Contato
	------------------------------------------------
	ELSE IF @idmidia = 87
	BEGIN
	
		INSERT INTO @tb_leads 
		(
			idpessoa,
			despessoa,
			desemail,
			nrcelular,
			nrtelresidencial,
			nrcpf,
			descontatoassunto,
			descontatomsg,
			idmidia,
			desmidia,
			dtcadastro
		)
	
		SELECT 
			a.idpessoa,
			a.despessoa, 
			MAX(c.descontato) as desemail,
			MAX(d.descontato) as nrcelular,
			MAX(e.descontato) as nrtelresidencial,
			MAX(g.desdocumento) as nrcpf,
			j.destitulo,
			j.deshistorico,
			f.idmidia,
			f.desmidia,
			b.dtcadastro
		FROM tb_pessoas a 
		INNER JOIN tb_midiapessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
		LEFT JOIN tb_contatos d ON d.idpessoa = a.idpessoa AND d.idcontatotipo = 2
		LEFT JOIN tb_contatos e ON e.idpessoa = a.idpessoa AND e.idcontatotipo = 3
		INNER JOIN tb_midias f ON f.idmidia = b.idmidia
		LEFT JOIN tb_documentos g ON g.idpessoa = a.idpessoa AND g.iddocumentotipo = 1
		LEFT JOIN tb_pessoashistoricos j ON j.idpessoa = b.idpessoa
		LEFT JOIN tb_pessoashistoricos_tipos k ON k.idhistorico = j.idhistorico AND k.idhistoricotipo = 21
		WHERE
			b.idmidia = 87 AND b.dtcadastro BETWEEN @de AND (@ate + 1) AND k.idhistoricotipo = 21
		GROUP BY
			a.idpessoa,
			a.despessoa, 
			j.destitulo,
			j.deshistorico,
			f.idmidia,
			f.desmidia,
			b.dtcadastro
		ORDER BY
			b.dtcadastro DESC
			
	END
	
	------------------------------------------------
	-- Formulário Inscreva-se Curso
	------------------------------------------------
	ELSE IF @idmidia = 88
	BEGIN
		
		INSERT INTO @tb_leads 
		(
			idpessoa,
			despessoa,
			desemail,
			nrcelular,
			nrtelresidencial,
			descursointeresse,
			idmidia,
			desmidia,
			dtcadastro
		)
	
		SELECT 
			a.idpessoa,
			a.despessoa, 
			MAX(c.descontato),
			MAX(e.descontato),
			MAX(f.descontato),
			(SELECT desinteresse FROM tb_interesses aa INNER JOIN tb_pessoasinteresses bb ON bb.idinteresse = aa.idinteresse INNER JOIN tb_pessoas cc ON cc.idpessoa = bb.idpessoa WHERE bb.idpessoainteresse = MAX(h.idpessoainteresse)) as cursointeresse,
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		FROM tb_pessoas a 
		INNER JOIN tb_midiapessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
		LEFT JOIN tb_contatos e ON e.idpessoa = a.idpessoa AND e.idcontatotipo = 2
		LEFT JOIN tb_contatos f ON f.idpessoa = a.idpessoa AND f.idcontatotipo = 2
		INNER JOIN tb_midias d ON d.idmidia = b.idmidia
		LEFT JOIN tb_pessoasinteresses h ON h.idpessoa = b.idpessoa AND DAY(h.dtcadastro) = DAY(b.dtcadastro) AND MONTH(h.dtcadastro) = MONTH(b.dtcadastro) AND YEAR(h.dtcadastro) = YEAR(b.dtcadastro) AND DATEPART(hh, h.dtcadastro) = DATEPART(hh, b.dtcadastro)  
		LEFT JOIN tb_interesses i ON i.idinteresse = h.idinteresse
		LEFT JOIN tb_pessoashistoricos j ON j.idpessoa = b.idpessoa
		LEFT JOIN tb_pessoashistoricos_tipos k ON k.idhistorico = j.idhistorico AND k.idhistoricotipo = 23
		WHERE
			b.idmidia = 88 AND b.dtcadastro BETWEEN @de AND (@ate + 1) AND k.idhistoricotipo = 23
		GROUP BY
			a.idpessoa,
			a.despessoa, 
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		ORDER BY
			b.dtcadastro DESC
			
	END
	
	------------------------------------------------
	-- Formulário Processo Seletivo
	------------------------------------------------
	ELSE IF @idmidia = 89
	BEGIN
		
		INSERT INTO @tb_leads 
		(
			idpessoa,
			despessoa,
			desemail,
			nrcelular,
			nrtelresidencial,
			descursointeresse,
			idmidia,
			desmidia,
			dtcadastro
		)
	
		SELECT 
			a.idpessoa,
			a.despessoa, 
			MAX(c.descontato),
			MAX(e.descontato),
			MAX(f.descontato),
			(SELECT desinteresse FROM tb_interesses aa INNER JOIN tb_pessoasinteresses bb ON bb.idinteresse = aa.idinteresse INNER JOIN tb_pessoas cc ON cc.idpessoa = bb.idpessoa WHERE bb.idpessoainteresse = MAX(h.idpessoainteresse)) as cursointeresse,
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		FROM tb_pessoas a 
		INNER JOIN tb_midiapessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
		LEFT JOIN tb_contatos e ON e.idpessoa = a.idpessoa AND e.idcontatotipo = 2
		LEFT JOIN tb_contatos f ON f.idpessoa = a.idpessoa AND f.idcontatotipo = 2
		INNER JOIN tb_midias d ON d.idmidia = b.idmidia
		LEFT JOIN tb_pessoasinteresses h ON h.idpessoa = b.idpessoa AND DAY(h.dtcadastro) = DAY(b.dtcadastro) AND MONTH(h.dtcadastro) = MONTH(b.dtcadastro) AND YEAR(h.dtcadastro) = YEAR(b.dtcadastro) AND DATEPART(hh, h.dtcadastro) = DATEPART(hh, b.dtcadastro)  
		LEFT JOIN tb_interesses i ON i.idinteresse = h.idinteresse
		LEFT JOIN tb_pessoashistoricos j ON j.idpessoa = b.idpessoa
		LEFT JOIN tb_pessoashistoricos_tipos k ON k.idhistorico = j.idhistorico AND k.idhistoricotipo = 25
		WHERE
			b.idmidia = 89 AND b.dtcadastro BETWEEN @de AND (@ate + 1) AND k.idhistoricotipo = 25
		GROUP BY
			a.idpessoa,
			a.despessoa, 
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		ORDER BY
			b.dtcadastro DESC
		
	END
	
	------------------------------------------------
	-- Indique um amigo
	------------------------------------------------
	ELSE IF @idmidia = 90
	BEGIN
		
		INSERT INTO @tb_leads 
		(
			idpessoa,
			despessoa,
			desemail,
			nrcelular,
			nrtelresidencial,
			nrcpf,
			desamigoinfo,
			idmidia,
			desmidia,
			dtcadastro
		)
	
		SELECT 
			a.idpessoa,
			a.despessoa, 
			MAX(c.descontato),
			MAX(e.descontato),
			MAX(f.descontato),
			MAX(g.desdocumento) as nrcpf,
			j.deshistorico,
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		FROM tb_pessoas a 
		INNER JOIN tb_midiapessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
		LEFT JOIN tb_contatos e ON e.idpessoa = a.idpessoa AND e.idcontatotipo = 2
		LEFT JOIN tb_contatos f ON f.idpessoa = a.idpessoa AND f.idcontatotipo = 2
		INNER JOIN tb_midias d ON d.idmidia = b.idmidia
		LEFT JOIN tb_documentos g ON g.idpessoa = a.idpessoa AND g.iddocumentotipo = 1
		LEFT JOIN tb_pessoashistoricos j ON j.idpessoa = b.idpessoa 
		LEFT JOIN tb_pessoashistoricos_tipos k ON k.idhistorico = j.idhistorico AND k.idhistoricotipo = 26
		WHERE
			b.idmidia = 90 AND b.dtcadastro BETWEEN @de AND (@ate + 1) AND k.idhistoricotipo = 26
		GROUP BY
			a.idpessoa,
			a.despessoa, 
			j.destitulo, 
			j.deshistorico,
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		ORDER BY
			b.dtcadastro DESC
		
	END
	
	------------------------------------------------
	-- Landing Page Vestibular
	------------------------------------------------
	ELSE IF @idmidia = 91
	BEGIN
	
		INSERT INTO @tb_leads 
		(
			idpessoa,
			despessoa,
			desemail,
			nrtelresidencial,
			nrcelular,
			idmidia,
			desmidia,
			dtcadastro
		)
	
		SELECT 
			a.idpessoa,
			a.despessoa, 
			max(c.descontato),
			max(e.descontato),
			max(f.descontato),
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		FROM tb_pessoas a 
		INNER JOIN tb_midiapessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
		LEFT JOIN tb_contatos e ON e.idpessoa = a.idpessoa AND e.idcontatotipo = 2
		LEFT JOIN tb_contatos f ON f.idpessoa = a.idpessoa AND f.idcontatotipo = 3
		INNER JOIN tb_midias d ON d.idmidia = b.idmidia
		LEFT JOIN tb_pessoashistoricos j ON j.idpessoa = b.idpessoa 
		LEFT JOIN tb_pessoashistoricos_tipos k ON k.idhistorico = j.idhistorico AND k.idhistoricotipo = 28
		WHERE
			b.idmidia = 91 AND b.dtcadastro BETWEEN @de AND (@ate + 1) AND k.idhistoricotipo = 28
		GROUP BY
			a.idpessoa,
			a.despessoa, 
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		ORDER BY
			b.dtcadastro DESC
			
	END
	
	------------------------------------------------
	-- Ganhe R$ 200 de credito na sua graduacao
	------------------------------------------------
	ELSE IF @idmidia = 43
	BEGIN
	
		
		INSERT INTO @tb_leads 
		(
			idpessoa,
			despessoa,
			desemail,
			nrcelular,
			nrtelresidencial,
			descursointeresse,
			idmidia,
			desmidia,
			dtcadastro
		)
	
		SELECT 
			a.idpessoa,
			a.despessoa, 
			MAX(c.descontato),
			MAX(e.descontato),
			MAX(f.descontato),
			(SELECT desinteresse FROM tb_interesses aa INNER JOIN tb_pessoasinteresses bb ON bb.idinteresse = aa.idinteresse INNER JOIN tb_pessoas cc ON cc.idpessoa = bb.idpessoa WHERE bb.idpessoainteresse = MAX(h.idpessoainteresse)) as cursointeresse,
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		FROM tb_pessoas a 
		INNER JOIN tb_midiapessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
		LEFT JOIN tb_contatos e ON e.idpessoa = a.idpessoa AND e.idcontatotipo = 2
		LEFT JOIN tb_contatos f ON f.idpessoa = a.idpessoa AND f.idcontatotipo = 2
		INNER JOIN tb_midias d ON d.idmidia = b.idmidia
		LEFT JOIN tb_pessoasinteresses h ON h.idpessoa = b.idpessoa AND DAY(h.dtcadastro) = DAY(b.dtcadastro) AND MONTH(h.dtcadastro) = MONTH(b.dtcadastro) AND YEAR(h.dtcadastro) = YEAR(b.dtcadastro) AND DATEPART(hh, h.dtcadastro) = DATEPART(hh, b.dtcadastro)  
		LEFT JOIN tb_interesses i ON i.idinteresse = h.idinteresse
		LEFT JOIN tb_pessoashistoricos j ON j.idpessoa = b.idpessoa
		LEFT JOIN tb_pessoashistoricos_tipos k ON k.idhistorico = j.idhistorico AND k.idhistoricotipo = 32
		WHERE
			b.idmidia = 43 AND b.dtcadastro BETWEEN @de AND (@ate + 1) AND k.idhistoricotipo = 32
		GROUP BY
			a.idpessoa,
			a.despessoa, 
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		ORDER BY
			b.dtcadastro DESC
			
	END
	
	------------------------------------------------
	-- Ganhe R$ 500 de credito na sua pos ou MBA
	------------------------------------------------
	ELSE IF @idmidia = 45
	BEGIN
	
		
		INSERT INTO @tb_leads 
		(
			idpessoa,
			despessoa,
			desemail,
			nrcelular,
			nrtelresidencial,
			descursointeresse,
			idmidia,
			desmidia,
			dtcadastro
		)
	
		SELECT 
			a.idpessoa,
			a.despessoa, 
			MAX(c.descontato),
			MAX(e.descontato),
			MAX(f.descontato),
			(SELECT desinteresse FROM tb_interesses aa INNER JOIN tb_pessoasinteresses bb ON bb.idinteresse = aa.idinteresse INNER JOIN tb_pessoas cc ON cc.idpessoa = bb.idpessoa WHERE bb.idpessoainteresse = MAX(h.idpessoainteresse)) as cursointeresse,
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		FROM tb_pessoas a 
		INNER JOIN tb_midiapessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
		LEFT JOIN tb_contatos e ON e.idpessoa = a.idpessoa AND e.idcontatotipo = 2
		LEFT JOIN tb_contatos f ON f.idpessoa = a.idpessoa AND f.idcontatotipo = 2
		INNER JOIN tb_midias d ON d.idmidia = b.idmidia
		LEFT JOIN tb_pessoasinteresses h ON h.idpessoa = b.idpessoa AND DAY(h.dtcadastro) = DAY(b.dtcadastro) AND MONTH(h.dtcadastro) = MONTH(b.dtcadastro) AND YEAR(h.dtcadastro) = YEAR(b.dtcadastro) AND DATEPART(hh, h.dtcadastro) = DATEPART(hh, b.dtcadastro)  
		LEFT JOIN tb_interesses i ON i.idinteresse = h.idinteresse
		LEFT JOIN tb_pessoashistoricos j ON j.idpessoa = b.idpessoa
		LEFT JOIN tb_pessoashistoricos_tipos k ON k.idhistorico = j.idhistorico AND k.idhistoricotipo = 33
		WHERE
			b.idmidia = 45 AND b.dtcadastro BETWEEN @de AND (@ate + 1) AND k.idhistoricotipo = 33
		GROUP BY
			a.idpessoa,
			a.despessoa, 
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		ORDER BY
			b.dtcadastro DESC
			
	END
	
	------------------------------------------------
	-- Quero mais informações
	------------------------------------------------
	ELSE IF @idmidia = 75
	BEGIN
		
		INSERT INTO @tb_leads 
		(
			idpessoa,
			despessoa,
			desemail,
			nrcelular,
			nrtelresidencial,
			descursointeresse,
			idmidia,
			desmidia,
			dtcadastro
		)
	
		SELECT 
			a.idpessoa,
			a.despessoa, 
			MAX(c.descontato),
			MAX(e.descontato),
			MAX(f.descontato),
			(SELECT desinteresse FROM tb_interesses aa INNER JOIN tb_pessoasinteresses bb ON bb.idinteresse = aa.idinteresse INNER JOIN tb_pessoas cc ON cc.idpessoa = bb.idpessoa WHERE bb.idpessoainteresse = MAX(h.idpessoainteresse)) as cursointeresse,
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		FROM tb_pessoas a 
		INNER JOIN tb_midiapessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
		LEFT JOIN tb_contatos e ON e.idpessoa = a.idpessoa AND e.idcontatotipo = 2
		LEFT JOIN tb_contatos f ON f.idpessoa = a.idpessoa AND f.idcontatotipo = 2
		INNER JOIN tb_midias d ON d.idmidia = b.idmidia
		LEFT JOIN tb_pessoasinteresses h ON h.idpessoa = b.idpessoa AND DAY(h.dtcadastro) = DAY(b.dtcadastro) AND MONTH(h.dtcadastro) = MONTH(b.dtcadastro) AND YEAR(h.dtcadastro) = YEAR(b.dtcadastro) AND DATEPART(hh, h.dtcadastro) = DATEPART(hh, b.dtcadastro)  
		LEFT JOIN tb_interesses i ON i.idinteresse = h.idinteresse
		LEFT JOIN tb_pessoashistoricos j ON j.idpessoa = b.idpessoa
		LEFT JOIN tb_pessoashistoricos_tipos k ON k.idhistorico = j.idhistorico AND k.idhistoricotipo = 34
		WHERE
			b.idmidia = 75 AND b.dtcadastro BETWEEN @de AND (@ate + 1) AND k.idhistoricotipo = 34
		GROUP BY
			a.idpessoa,
			a.despessoa, 
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		ORDER BY
			b.dtcadastro DESC
			
	END
	-----------------------------------------------------------------------------------
	-----------------------------------------------------------------------------------
	------------------------------- TODOS ---------------------------------------------
	-----------------------------------------------------------------------------------
	-----------------------------------------------------------------------------------
	ELSE IF @idmidia IS NULL
	BEGIN
		
		--------------------------------
		-- Newsletter Impacta		
		--------------------------------
		INSERT INTO @tb_leads 
		(
			idpessoa,
			despessoa,
			desemail,
			idmidia,
			desmidia,
			dtcadastro
		)
	
		SELECT 
			a.idpessoa,
			a.despessoa, 
			c.descontato,
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		FROM tb_pessoas a 
		INNER JOIN tb_midiapessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
		INNER JOIN tb_midias d ON d.idmidia = b.idmidia
		LEFT JOIN tb_pessoashistoricos j ON j.idpessoa = b.idpessoa 
		LEFT JOIN tb_pessoashistoricos_tipos k ON k.idhistorico = j.idhistorico AND k.idhistoricotipo = 24
		WHERE
			b.idmidia = 84 AND b.dtcadastro BETWEEN @de AND (@ate + 1) AND k.idhistoricotipo = 24
		GROUP BY
			a.idpessoa,
			a.despessoa, 
			c.descontato,
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		ORDER BY
			b.dtcadastro DESC
			
		----------------------------------------------------------------
		-- Formulário de Inscrição Vestibular
		----------------------------------------------------------------
		INSERT INTO @tb_leads 
		(
			idpessoa,
			despessoa,
			desemail,
			nrcelular,
			nrtelresidencial,
			nrcpf,
			descurso1,
			descurso2,
			idmidia,
			desmidia,
			dtcadastro
		)
	
		SELECT 
			a.idpessoa,
			a.despessoa, 
			MAX(c.descontato) as desemail,
			MAX(d.descontato) as nrcelular,
			MAX(e.descontato) as nrtelefone,
			MAX(g.desdocumento) as nrcpf,
			(SELECT desinteresse FROM tb_interesses aa INNER JOIN tb_pessoasinteresses bb ON bb.idinteresse = aa.idinteresse INNER JOIN tb_pessoas cc ON cc.idpessoa = bb.idpessoa WHERE bb.idpessoainteresse = MIN(h.idpessoainteresse)) as curso1,
			(SELECT desinteresse FROM tb_interesses aa INNER JOIN tb_pessoasinteresses bb ON bb.idinteresse = aa.idinteresse INNER JOIN tb_pessoas cc ON cc.idpessoa = bb.idpessoa WHERE bb.idpessoainteresse = MAX(h.idpessoainteresse)) as curso2,
			f.idmidia,
			f.desmidia,
			b.dtcadastro
		FROM tb_pessoas a 
		INNER JOIN tb_midiapessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
		LEFT JOIN tb_contatos d ON d.idpessoa = a.idpessoa AND d.idcontatotipo = 2
		LEFT JOIN tb_contatos e ON e.idpessoa = a.idpessoa AND e.idcontatotipo = 3
		INNER JOIN tb_midias f ON f.idmidia = b.idmidia
		LEFT JOIN tb_documentos g ON g.idpessoa = a.idpessoa AND g.iddocumentotipo = 1
		LEFT JOIN tb_pessoasinteresses h ON h.idpessoa = a.idpessoa AND DAY(h.dtcadastro) = DAY(b.dtcadastro) AND MONTH(h.dtcadastro) = MONTH(b.dtcadastro) AND YEAR(h.dtcadastro) = YEAR(b.dtcadastro) AND DATEPART(hh, h.dtcadastro) = DATEPART(hh, b.dtcadastro)  
		LEFT JOIN tb_interesses i ON i.idinteresse = h.idinteresse
		LEFT JOIN tb_pessoashistoricos j ON j.idpessoa = b.idpessoa
		LEFT JOIN tb_pessoashistoricos_tipos k ON k.idhistorico = j.idhistorico AND k.idhistoricotipo = 27
		WHERE
			b.idmidia = 85 AND b.dtcadastro BETWEEN @de AND (@ate + 1) AND k.idhistoricotipo = 27
		GROUP BY
			a.idpessoa,
			a.despessoa, 
			f.idmidia,
			f.desmidia,
			b.dtcadastro
		ORDER BY
			b.dtcadastro DESC
			
		--------------------------------
		-- Formulário de Transferência
		--------------------------------
		INSERT INTO @tb_leads 
		(
			idpessoa,
			despessoa,
			desemail,
			nrcelular,
			nrtelresidencial,
			nrcpf,
			descursointeresse,
			destransferencia,
			idmidia,
			desmidia,
			dtcadastro
		)
	
		SELECT 
			a.idpessoa,
			a.despessoa, 
			MAX(c.descontato) as desemail,
			MAX(d.descontato) as nrcelular,
			MAX(e.descontato) as nrtelefone,
			MAX(g.desdocumento) as nrcpf,
			(SELECT desinteresse FROM tb_interesses aa INNER JOIN tb_pessoasinteresses bb ON bb.idinteresse = aa.idinteresse INNER JOIN tb_pessoas cc ON cc.idpessoa = bb.idpessoa WHERE bb.idpessoainteresse = MAX(h.idpessoainteresse)) as cursointeresse,
			j.deshistorico,
			f.idmidia,
			f.desmidia,
			b.dtcadastro
		FROM tb_pessoas a 
		INNER JOIN tb_midiapessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
		LEFT JOIN tb_contatos d ON d.idpessoa = a.idpessoa AND d.idcontatotipo = 2
		LEFT JOIN tb_contatos e ON e.idpessoa = a.idpessoa AND e.idcontatotipo = 3
		INNER JOIN tb_midias f ON f.idmidia = b.idmidia
		LEFT JOIN tb_documentos g ON g.idpessoa = a.idpessoa AND g.iddocumentotipo = 1
		LEFT JOIN tb_pessoasinteresses h ON h.idpessoa = a.idpessoa AND DAY(h.dtcadastro) = DAY(b.dtcadastro) AND MONTH(h.dtcadastro) = MONTH(b.dtcadastro) AND YEAR(h.dtcadastro) = YEAR(b.dtcadastro) AND DATEPART(hh, h.dtcadastro) = DATEPART(hh, b.dtcadastro)  
		LEFT JOIN tb_interesses i ON i.idinteresse = h.idinteresse
		LEFT JOIN tb_pessoashistoricos j ON j.idpessoa = b.idpessoa
		LEFT JOIN tb_pessoashistoricos_tipos k ON k.idhistorico = j.idhistorico AND k.idhistoricotipo = 20
		WHERE
			b.idmidia = 86 AND b.dtcadastro BETWEEN @de AND (@ate + 1) AND k.idhistoricotipo = 20
		GROUP BY
			a.idpessoa,
			a.despessoa, 
			j.destitulo,
			j.deshistorico,
			f.idmidia,
			f.desmidia,
			b.dtcadastro
		ORDER BY
			b.dtcadastro DESC
			
		--------------------------------
		-- Formulário de Contato
		--------------------------------
		INSERT INTO @tb_leads 
		(
			idpessoa,
			despessoa,
			desemail,
			nrcelular,
			nrtelresidencial,
			nrcpf,
			descontatoassunto,
			descontatomsg,
			idmidia,
			desmidia,
			dtcadastro
		)
	
		SELECT 
			a.idpessoa,
			a.despessoa, 
			MAX(c.descontato) as desemail,
			MAX(d.descontato) as nrcelular,
			MAX(e.descontato) as nrtelresidencial,
			MAX(g.desdocumento) as nrcpf,
			j.destitulo,
			j.deshistorico,
			f.idmidia,
			f.desmidia,
			b.dtcadastro
		FROM tb_pessoas a 
		INNER JOIN tb_midiapessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
		LEFT JOIN tb_contatos d ON d.idpessoa = a.idpessoa AND d.idcontatotipo = 2
		LEFT JOIN tb_contatos e ON e.idpessoa = a.idpessoa AND e.idcontatotipo = 3
		INNER JOIN tb_midias f ON f.idmidia = b.idmidia
		LEFT JOIN tb_documentos g ON g.idpessoa = a.idpessoa AND g.iddocumentotipo = 1
		LEFT JOIN tb_pessoashistoricos j ON j.idpessoa = b.idpessoa 
		LEFT JOIN tb_pessoashistoricos_tipos k ON k.idhistorico = j.idhistorico AND k.idhistoricotipo = 21
		WHERE
			b.idmidia = 87 AND b.dtcadastro BETWEEN @de AND (@ate + 1) AND k.idhistoricotipo = 21
		GROUP BY
			a.idpessoa,
			a.despessoa, 
			j.destitulo,
			j.deshistorico,
			f.idmidia,
			f.desmidia,
			b.dtcadastro
		ORDER BY
			b.dtcadastro DESC
		
		--------------------------------			
		-- Formulário Inscreva-se Curso
		--------------------------------
		INSERT INTO @tb_leads 
		(
			idpessoa,
			despessoa,
			desemail,
			nrcelular,
			nrtelresidencial,
			descursointeresse,
			idmidia,
			desmidia,
			dtcadastro
		)
	
		SELECT 
			a.idpessoa,
			a.despessoa, 
			MAX(c.descontato),
			MAX(e.descontato),
			MAX(f.descontato),
			(SELECT desinteresse FROM tb_interesses aa INNER JOIN tb_pessoasinteresses bb ON bb.idinteresse = aa.idinteresse INNER JOIN tb_pessoas cc ON cc.idpessoa = bb.idpessoa WHERE bb.idpessoainteresse = MAX(h.idpessoainteresse)) as cursointeresse,
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		FROM tb_pessoas a 
		INNER JOIN tb_midiapessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
		LEFT JOIN tb_contatos e ON e.idpessoa = a.idpessoa AND e.idcontatotipo = 2
		LEFT JOIN tb_contatos f ON f.idpessoa = a.idpessoa AND f.idcontatotipo = 2
		INNER JOIN tb_midias d ON d.idmidia = b.idmidia
		LEFT JOIN tb_pessoasinteresses h ON h.idpessoa = b.idpessoa AND DAY(h.dtcadastro) = DAY(b.dtcadastro) AND MONTH(h.dtcadastro) = MONTH(b.dtcadastro) AND YEAR(h.dtcadastro) = YEAR(b.dtcadastro) AND DATEPART(hh, h.dtcadastro) = DATEPART(hh, b.dtcadastro)  
		LEFT JOIN tb_interesses i ON i.idinteresse = h.idinteresse
		LEFT JOIN tb_pessoashistoricos j ON j.idpessoa = b.idpessoa 
		LEFT JOIN tb_pessoashistoricos_tipos k ON k.idhistorico = j.idhistorico AND k.idhistoricotipo = 23
		WHERE
			b.idmidia = 88 AND b.dtcadastro BETWEEN @de AND (@ate + 1) AND k.idhistoricotipo = 23
		GROUP BY
			a.idpessoa,
			a.despessoa, 
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		ORDER BY
			b.dtcadastro DESC
		
		--------------------------------
		-- Formulário Processo Seletivo
		--------------------------------
		INSERT INTO @tb_leads 
		(
			idpessoa,
			despessoa,
			desemail,
			nrcelular,
			nrtelresidencial,
			descursointeresse,
			idmidia,
			desmidia,
			dtcadastro
		)
	
		SELECT 
			a.idpessoa,
			a.despessoa, 
			MAX(c.descontato),
			MAX(e.descontato),
			MAX(f.descontato),
			(SELECT desinteresse FROM tb_interesses aa INNER JOIN tb_pessoasinteresses bb ON bb.idinteresse = aa.idinteresse INNER JOIN tb_pessoas cc ON cc.idpessoa = bb.idpessoa WHERE bb.idpessoainteresse = MAX(h.idpessoainteresse)) as cursointeresse,
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		FROM tb_pessoas a 
		INNER JOIN tb_midiapessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
		LEFT JOIN tb_contatos e ON e.idpessoa = a.idpessoa AND e.idcontatotipo = 2
		LEFT JOIN tb_contatos f ON f.idpessoa = a.idpessoa AND f.idcontatotipo = 2
		INNER JOIN tb_midias d ON d.idmidia = b.idmidia
		LEFT JOIN tb_pessoasinteresses h ON h.idpessoa = b.idpessoa AND DAY(h.dtcadastro) = DAY(b.dtcadastro) AND MONTH(h.dtcadastro) = MONTH(b.dtcadastro) AND YEAR(h.dtcadastro) = YEAR(b.dtcadastro) AND DATEPART(hh, h.dtcadastro) = DATEPART(hh, b.dtcadastro)  
		LEFT JOIN tb_interesses i ON i.idinteresse = h.idinteresse
		LEFT JOIN tb_pessoashistoricos j ON j.idpessoa = b.idpessoa
		LEFT JOIN tb_pessoashistoricos_tipos k ON k.idhistorico = j.idhistorico AND k.idhistoricotipo = 25
		WHERE
			b.idmidia = 89 AND b.dtcadastro BETWEEN @de AND (@ate + 1) AND k.idhistoricotipo = 25 
		GROUP BY
			a.idpessoa,
			a.despessoa, 
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		ORDER BY
			b.dtcadastro DESC
		
		--------------------------------
		-- Indique um amigo
		--------------------------------
		INSERT INTO @tb_leads 
		(
			idpessoa,
			despessoa,
			desemail,
			nrcelular,
			nrtelresidencial,
			nrcpf,
			desamigoinfo,
			idmidia,
			desmidia,
			dtcadastro
		)
	
		SELECT 
			a.idpessoa,
			a.despessoa, 
			MAX(c.descontato),
			MAX(e.descontato),
			MAX(f.descontato),
			MAX(g.desdocumento) as nrcpf,
			j.deshistorico,
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		FROM tb_pessoas a 
		INNER JOIN tb_midiapessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
		LEFT JOIN tb_contatos e ON e.idpessoa = a.idpessoa AND e.idcontatotipo = 2
		LEFT JOIN tb_contatos f ON f.idpessoa = a.idpessoa AND f.idcontatotipo = 2
		INNER JOIN tb_midias d ON d.idmidia = b.idmidia
		LEFT JOIN tb_documentos g ON g.idpessoa = a.idpessoa AND g.iddocumentotipo = 1
		LEFT JOIN tb_pessoashistoricos j ON j.idpessoa = b.idpessoa 
		LEFT JOIN tb_pessoashistoricos_tipos k ON k.idhistorico = j.idhistorico AND k.idhistoricotipo = 26
		WHERE
			b.idmidia = 90 AND b.dtcadastro BETWEEN @de AND (@ate + 1) AND k.idhistoricotipo = 26
		GROUP BY
			a.idpessoa,
			a.despessoa, 
			j.destitulo, 
			j.deshistorico,
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		ORDER BY
			b.dtcadastro DESC
		
		--------------------------------
		-- Landing Page Vestibular
		--------------------------------
		INSERT INTO @tb_leads 
		(
			idpessoa,
			despessoa,
			desemail,
			nrtelresidencial,
			nrcelular,
			idmidia,
			desmidia,
			dtcadastro
		)
	
		SELECT 
			a.idpessoa,
			a.despessoa, 
			max(c.descontato),
			max(e.descontato),
			max(f.descontato),
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		FROM tb_pessoas a 
		INNER JOIN tb_midiapessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
		LEFT JOIN tb_contatos e ON e.idpessoa = a.idpessoa AND e.idcontatotipo = 2
		LEFT JOIN tb_contatos f ON f.idpessoa = a.idpessoa AND f.idcontatotipo = 3
		INNER JOIN tb_midias d ON d.idmidia = b.idmidia
		LEFT JOIN tb_pessoashistoricos j ON j.idpessoa = b.idpessoa 
		LEFT JOIN tb_pessoashistoricos_tipos k ON k.idhistorico = j.idhistorico AND k.idhistoricotipo = 28
		WHERE
			b.idmidia = 91 AND b.dtcadastro BETWEEN @de AND (@ate + 1) AND k.idhistoricotipo = 28
		GROUP BY
			a.idpessoa,
			a.despessoa, 
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		ORDER BY
			b.dtcadastro DESC
			
		----------------------------------------------------------------			
		-- Landing Page Vestibular Conveniados
		----------------------------------------------------------------
		INSERT INTO @tb_leads 
		(
			idpessoa,
			despessoa,
			desemail,
			nrtelresidencial,
			nrcelular,
			idmidia,
			desmidia,
			dtcadastro
		)
	
		SELECT 
			a.idpessoa,
			a.despessoa, 
			max(c.descontato),
			max(e.descontato),
			max(f.descontato),
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		FROM tb_pessoas a 
		INNER JOIN tb_midiapessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
		LEFT JOIN tb_contatos e ON e.idpessoa = a.idpessoa AND e.idcontatotipo = 2
		LEFT JOIN tb_contatos f ON f.idpessoa = a.idpessoa AND f.idcontatotipo = 3
		INNER JOIN tb_midias d ON d.idmidia = b.idmidia
		LEFT JOIN tb_pessoashistoricos j ON j.idpessoa = b.idpessoa 
		LEFT JOIN tb_pessoashistoricos_tipos k ON k.idhistorico = j.idhistorico AND k.idhistoricotipo = 35
		WHERE
			b.idmidia = 119 AND b.dtcadastro BETWEEN @de AND (@ate + 1) AND k.idhistoricotipo = 35
		GROUP BY
			a.idpessoa,
			a.despessoa, 
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		ORDER BY
			b.dtcadastro DESC
			
		------------------------------------------------
		-- Ganhe R$ 200 de credito na sua graduacao
		------------------------------------------------
		
		INSERT INTO @tb_leads 
		(
			idpessoa,
			despessoa,
			desemail,
			nrcelular,
			nrtelresidencial,
			descursointeresse,
			idmidia,
			desmidia,
			dtcadastro
		)
	
		SELECT 
			a.idpessoa,
			a.despessoa, 
			MAX(c.descontato),
			MAX(e.descontato),
			MAX(f.descontato),
			(SELECT desinteresse FROM tb_interesses aa INNER JOIN tb_pessoasinteresses bb ON bb.idinteresse = aa.idinteresse INNER JOIN tb_pessoas cc ON cc.idpessoa = bb.idpessoa WHERE bb.idpessoainteresse = MAX(h.idpessoainteresse)) as cursointeresse,
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		FROM tb_pessoas a 
		INNER JOIN tb_midiapessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
		LEFT JOIN tb_contatos e ON e.idpessoa = a.idpessoa AND e.idcontatotipo = 2
		LEFT JOIN tb_contatos f ON f.idpessoa = a.idpessoa AND f.idcontatotipo = 2
		INNER JOIN tb_midias d ON d.idmidia = b.idmidia
		LEFT JOIN tb_pessoasinteresses h ON h.idpessoa = b.idpessoa AND DAY(h.dtcadastro) = DAY(b.dtcadastro) AND MONTH(h.dtcadastro) = MONTH(b.dtcadastro) AND YEAR(h.dtcadastro) = YEAR(b.dtcadastro) AND DATEPART(hh, h.dtcadastro) = DATEPART(hh, b.dtcadastro)  
		LEFT JOIN tb_interesses i ON i.idinteresse = h.idinteresse
		LEFT JOIN tb_pessoashistoricos j ON j.idpessoa = b.idpessoa
		LEFT JOIN tb_pessoashistoricos_tipos k ON k.idhistorico = j.idhistorico AND k.idhistoricotipo = 32
		WHERE
			b.idmidia = 43 AND b.dtcadastro BETWEEN @de AND (@ate + 1) AND k.idhistoricotipo = 32
		GROUP BY
			a.idpessoa,
			a.despessoa, 
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		ORDER BY
			b.dtcadastro DESC
			
	
		------------------------------------------------
		-- Ganhe R$ 500 de credito na sua pos ou MBA
		------------------------------------------------
		
		INSERT INTO @tb_leads 
		(
			idpessoa,
			despessoa,
			desemail,
			nrcelular,
			nrtelresidencial,
			descursointeresse,
			idmidia,
			desmidia,
			dtcadastro
		)
	
		SELECT 
			a.idpessoa,
			a.despessoa, 
			MAX(c.descontato),
			MAX(e.descontato),
			MAX(f.descontato),
			(SELECT desinteresse FROM tb_interesses aa INNER JOIN tb_pessoasinteresses bb ON bb.idinteresse = aa.idinteresse INNER JOIN tb_pessoas cc ON cc.idpessoa = bb.idpessoa WHERE bb.idpessoainteresse = MAX(h.idpessoainteresse)) as cursointeresse,
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		FROM tb_pessoas a 
		INNER JOIN tb_midiapessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
		LEFT JOIN tb_contatos e ON e.idpessoa = a.idpessoa AND e.idcontatotipo = 2
		LEFT JOIN tb_contatos f ON f.idpessoa = a.idpessoa AND f.idcontatotipo = 2
		INNER JOIN tb_midias d ON d.idmidia = b.idmidia
		LEFT JOIN tb_pessoasinteresses h ON h.idpessoa = b.idpessoa AND DAY(h.dtcadastro) = DAY(b.dtcadastro) AND MONTH(h.dtcadastro) = MONTH(b.dtcadastro) AND YEAR(h.dtcadastro) = YEAR(b.dtcadastro) AND DATEPART(hh, h.dtcadastro) = DATEPART(hh, b.dtcadastro)  
		LEFT JOIN tb_interesses i ON i.idinteresse = h.idinteresse
		LEFT JOIN tb_pessoashistoricos j ON j.idpessoa = b.idpessoa
		LEFT JOIN tb_pessoashistoricos_tipos k ON k.idhistorico = j.idhistorico AND k.idhistoricotipo = 33
		WHERE
			b.idmidia = 45 AND b.dtcadastro BETWEEN @de AND (@ate + 1) AND k.idhistoricotipo = 33
		GROUP BY
			a.idpessoa,
			a.despessoa, 
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		ORDER BY
			b.dtcadastro DESC
			
	
		------------------------------------------------
		-- Quero mais informações
		------------------------------------------------
		
		INSERT INTO @tb_leads 
		(
			idpessoa,
			despessoa,
			desemail,
			nrcelular,
			nrtelresidencial,
			descursointeresse,
			idmidia,
			desmidia,
			dtcadastro
		)
	
		SELECT 
			a.idpessoa,
			a.despessoa, 
			MAX(c.descontato),
			MAX(e.descontato),
			MAX(f.descontato),
			(SELECT desinteresse FROM tb_interesses aa INNER JOIN tb_pessoasinteresses bb ON bb.idinteresse = aa.idinteresse INNER JOIN tb_pessoas cc ON cc.idpessoa = bb.idpessoa WHERE bb.idpessoainteresse = MAX(h.idpessoainteresse)) as cursointeresse,
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		FROM tb_pessoas a 
		INNER JOIN tb_midiapessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
		LEFT JOIN tb_contatos e ON e.idpessoa = a.idpessoa AND e.idcontatotipo = 2
		LEFT JOIN tb_contatos f ON f.idpessoa = a.idpessoa AND f.idcontatotipo = 2
		INNER JOIN tb_midias d ON d.idmidia = b.idmidia
		LEFT JOIN tb_pessoasinteresses h ON h.idpessoa = b.idpessoa AND DAY(h.dtcadastro) = DAY(b.dtcadastro) AND MONTH(h.dtcadastro) = MONTH(b.dtcadastro) AND YEAR(h.dtcadastro) = YEAR(b.dtcadastro) AND DATEPART(hh, h.dtcadastro) = DATEPART(hh, b.dtcadastro)  
		LEFT JOIN tb_interesses i ON i.idinteresse = h.idinteresse
		LEFT JOIN tb_pessoashistoricos j ON j.idpessoa = b.idpessoa
		LEFT JOIN tb_pessoashistoricos_tipos k ON k.idhistorico = j.idhistorico AND k.idhistoricotipo = 34
		WHERE
			b.idmidia = 75 AND b.dtcadastro BETWEEN @de AND (@ate + 1) AND k.idhistoricotipo = 34
		GROUP BY
			a.idpessoa,
			a.despessoa, 
			d.idmidia,
			d.desmidia,
			b.dtcadastro
		ORDER BY
			b.dtcadastro DESC
	END
	
	SET NOCOUNT OFF
	
	SELECT * FROM @tb_leads ORDER BY dtcadastro DESC

END
--
sp_midiassitenovobymidia_list NULL, '2015-07-01', '2015-07-30'
------------------------------------------------------------------------
------------------------------------------------------------------------
------------------------------------------------------------------------

SELECT DATEPART(hh, GETDATE())
SELECT CAST(CAST(GETDATE() AS DATE) AS DATETIME) + 1

sp_midias_get 90

SELECT *FROM tb_midiapessoas

select * from tb_pessoas

--contato

select * from tb_midias

select * from tb_midiapessoas

select * from tb_interesses

select * from tb_pessoasinteresseshistoricos

select * from tb_pessoasinteresses

select * from tb_pessoashistoricos

SELECT * FROM tb_contatotipos

SELECT * FROM tb_documentos

SELECT * FROM tb_documentotipos

select * from tb_midiatipos


SELECT * FROM tb_documentos where idpessoa = 1346316

SELECT * FROM tb_midias a
INNER JOIN tb_midiapessoas b oN b.idmidia = a.idmidia
WHERE b.idpessoa = 1346694

SELECT * FROM tb_interesses a
INNER JOIN tb_pessoasinteresses b ON b.idinteresse = a.idinteresse
WHERE b.idpessoa = 1346305

SELECT TOP 100 * FROM tb_pessoas ORDER BY dtcadastro DESC

SELECT * FROM tb_contatos WHERE idpessoa = 1346694
SELECT * FROM tb_documentos  WHERE idpessoa = 1346694

select * from tb_pessoashistoricos WHERE idpessoa = 1347361 order by dtcadastro
SELECT * FROM tb_pessoashistoricos WHERE idhistorico = 21124105
SELECT * FROM tb_pessoashistoricostipos





INSERT INTO tb_pessoashistoricostipos
(deshistoricotipo, desdescricao, desicon, instatus, ininteracao)
VALUES
--('Site - Faculdade [Transferência]', 'Quando alguma informação é vinda do site da Faculdade no formulario de transferência, ele deve estar vinculado à este tipo', 'account.png', 1, 0),
--('Site - Faculdade [Contato]', 'Quando alguma informação é vinda do site da Faculdade no formulario de contato, ele deve estar vinculado à este tipo', 'account.png', 1, 0),
--('Site - Faculdade [Inscreva-se Curso]', 'Quando alguma informação é vinda do site da Faculdade no formulario de Inscreva-se Curso, ele deve estar vinculado à este tipo', 'account.png', 1, 0)
('Site - Faculdade [Indique um Amigo]', 'Quando alguma informação é vinda do site da Faculdade no formulario de Indique um Amigo, ele deve estar vinculado à este tipo', 'account.png', 1, 0)

SELECT * FROM tb_contatotipos
SELECT * FROM tb_produtos
SELECT * FROM tb_produtotipos

SELECT * FROM tb_pessoashistoricostipos

SELECT * FROM tb_midias

--INSERT INTO tb_pessoashistoricostipos
--(deshistoricotipo, desdescricao, desicon, instatus, ininteracao)
--VALUES
--('Site - Faculdade [Inscrição Vestibular]','Quando alguma informação é vinda do site da Faculdade no formulario de Inscrição Vestibular, ele deve estar vinculado à este tipo', 'account.png', 1, 0 )