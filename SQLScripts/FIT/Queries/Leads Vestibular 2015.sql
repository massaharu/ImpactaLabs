SELECT 
	a.idpessoa,
	a.despessoa, 
	MAX(c.descontato) AS EMAIL,
	MAX(l.descontato) AS TELEFONE,
	d.idmidia,
	d.desmidia,
	j.deshistorico,
	CASE 
		WHEN REPLACE(LEFT(SUBSTRING(j.deshistorico, CHARINDEX('{{IP: ', j.deshistorico) +6, LEN(j.deshistorico)),CHARINDEX('}}',SUBSTRING(j.deshistorico, CHARINDEX('{{IP: ', j.deshistorico) +6, LEN(j.deshistorico)))),' ','') <> ''
		then REPLACE(LEFT(SUBSTRING(j.deshistorico, CHARINDEX('{{IP: ', j.deshistorico) +6, LEN(j.deshistorico)),CHARINDEX('}}',SUBSTRING(j.deshistorico, CHARINDEX('{{IP: ', j.deshistorico) +6, LEN(j.deshistorico))) - 1),' ','')
		else ''
	end AS IP,
	CASE 
		WHEN REPLACE(LEFT(SUBSTRING(j.deshistorico, CHARINDEX('{{E-Mail: ', j.deshistorico) +9, LEN(j.deshistorico)),CHARINDEX('}}',SUBSTRING(j.deshistorico, CHARINDEX('{{E-Mail: ', j.deshistorico) +6, LEN(j.deshistorico)))),' ','') <> ''
		then REPLACE(LEFT(SUBSTRING(j.deshistorico, CHARINDEX('{{E-Mail: ', j.deshistorico) +9, LEN(j.deshistorico)),CHARINDEX('}}',SUBSTRING(j.deshistorico, CHARINDEX('{{E-Mail: ', j.deshistorico) +6, LEN(j.deshistorico))) - 4),' ','')
		else ''
	end,
	j.dtcadastro
FROM tb_pessoas a 
INNER JOIN tb_midiapessoas b ON b.idpessoa = a.idpessoa
LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
LEFT JOIN tb_contatos l ON l.idpessoa = a.idpessoa AND l.idcontatotipo = 2
INNER JOIN tb_midias d ON d.idmidia = b.idmidia
LEFT JOIN tb_pessoashistoricos j ON j.idpessoa = b.idpessoa 
LEFT JOIN tb_pessoashistoricos_tipos k ON k.idhistorico = j.idhistorico AND k.idhistoricotipo = 28
WHERE
	(a.despessoa NOT LIKE '%test%' or c.descontato NOT LIKE '%TEST%') AND
	b.idmidia = 91 AND k.idhistoricotipo = 28-- AND
	--j.dtcadastro BETWEEN '2015-08-26' AND '2015-09-01' AND
	--j.deshistorico LIKE '%comercial-proxis@impacta.com.br%'
GROUP BY
	a.idpessoa,
	a.despessoa, 
	d.idmidia,
	d.desmidia,
	j.deshistorico,
	j.dtcadastro
ORDER BY
	j.dtcadastro DESC
	
SELECT * FROM saturn.fit_new..tb_faleconoscofit_log	

SELECT * FROM saturn.vendas.dbo.tb_pessoashistoricos