DECLARE @dt1 DATETIME = '2015-08-01 00:00:00'
DECLARE @dt2 DATETIME = '2015-08-30 23:59:59'
DECLARE @table table(
	curso varchar(200), 
	vlbruto decimal(10,2), 
	vldesconto decimal(10,2), 
	vlliquido decimal(10,2), 
	vlrecebido decimal(10,2)
)

INSERT @table
SELECT 
	CASE WHEN b.MATRICULA IS NULL then 
		CASE WHEN (
				SELECT TOP 1 a3.NOME from sophia.TITULOS a1
				LEFT join sophia.MATRICULA a2 on a1.CODPF = a2.FISICA
				LEFT join sophia.CURSOS a3 on a2.CURSO = a3.PRODUTO
				where a1.CODIGO = a.CODIGO and @dt1 < a2.DATA_MATRICULA
			) IS NULL AND b.CODPJ IS NOT NULL then
			  'PJ' 
		ELSE
			(
				SELECT TOP 1 a3.NOME from sophia.TITULOS a1
				LEFT join sophia.MATRICULA a2 on a1.CODPF = a2.FISICA
				LEFT join sophia.CURSOS a3 on a2.CURSO = a3.PRODUTO
				where a1.CODIGO = a.CODIGO and @dt1 < a2.DATA_MATRICULA
			)
		END
	ELSE 
		d.NOME 
	END NOME, 
	SUM(b.BRUTO) as vlbruto, 
	SUM(b.DESCONTO) as vldesconto, 
	SUM(b.LIQUIDO) as vlliquido, 
	SUM(b.RECEBIDO)  
FROM sophia.TITULOS a
cross apply sophia.INFO_TIT(a.codigo, a.DATA_BAIXA) b
left join sophia.MATRICULA c on b.MATRICULA = c.CODIGO
left join sophia.CURSOS d on c.CURSO = d.PRODUTO
WHERE 
	DATA_BAIXA between @dt1 and @dt2 and
	TITULAR = 2724
	--and CEDENTE not in(10)
	--order by NOME
GROUP BY 
	NOME, 
	b.MATRICULA, 
	a.CODIGO, 
	b.CODPJ

SELECT 
	curso, 
	convert(money,SUM(vlbruto)) vlbruto, 
	convert(money,SUM(vldesconto)) vldesconto, 
	convert(money,SUM(vlliquido)) vlliquido
FROM 
	@table 
GROUP BY 
	curso
