USE Vendas

SELECT *FROM tb_PAISES

SELECT *FROM tb_estados

SELECT *FROM tb_cidades

SELECT *FROM tb_bairros

SELECT desbairro FROM tb_bairros
WHERE idcidade = 12

SELECT a.despais,b.desestado,c.descidade,d.desbairro
FROM tb_paises a
INNER JOIN tb_estados b
ON b.idpais = a.idpais
INNER JOIN tb_cidades c
ON c.idestado = b.idestado
INNER JOIN tb_bairros d
ON d.idcidade = c.idcidade

SELECT *FROM tb_paises a
WHERE EXISTS(
	SELECT *FROM tb_estados b
	WHERE a.idpais = b.idpais AND
	EXISTS(
		SELECT *FROM tb_cidades c
		WHERE c.idestado = b.idestado AND
		EXISTS(
			SELECT *FROM tb_bairros d
			WHERE d.idcidade = c.idcidade
			AND d.desbairro = 'santana')))
			
ORDER BY a.despais,b.desestado,c.descidade,d.desbairro

SELECT desbairro FROM tb_bairros 
WHERE desbairro = 'santana'

	