SELECT * FROM Impacta4..tb_ecommerceCliente where nome_cli like '%Douglas%Pires%'

SELECT DISTINCT d.NOME, b.NOME, a.desfonecel, a.desemail, a.desmsg FROM Relatorios..tb_smssend a
LEFT JOIN SONATA.SOPHIA.SOPHIA.FISICA b ON RTRIM(LTRIM(b.EMAIL)) COLLATE Latin1_General_CI_AI = RTRIM(LTRIM(a.desemail)) COLLATE Latin1_General_CI_AI
LEFT JOIN SONATA.SOPHIA.SOPHIA.MATRICULA c ON c.FISICA  = b.CODIGO AND c.STATUS = 0
LEFT JOIN SONATA.SOPHIA.SOPHIA.CURSOS d ON d.PRODUTO = c.CURSO
WHERE desmsg like 'Faculdade Impacta:Faculdade Impacta: As aulas da pós-graduação iniciam dia 05/08. Visite a Área do Aluno para informações sobre transporte.' 
ORDER BY d.NOME, b.NOME

SELECT *  FROm SONATA.SOPHIA.SOPHIA.MATRICULA