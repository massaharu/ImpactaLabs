SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS WHERE CODIGO = 2577

SELECT b.* FROM tb_aluno b WHERE (b.NmAluno like '%+%' OR b.NmAluno like '%æ%' OR b.NmAluno like '%&#39;%') 
select * FROm Atendimento..tb_contato WHERE NrCPF like '%33712179812%'

SELECT * FROM tb_matriculas WHERE dtcadastramento 

SELECT * FROM vendas..tb_documentos

SELECT *
FROM tb_PedidoCursos
WHERE IdPedido = (880686 - 15000);

SELECT *
FROM tb_pedidosrenegociacoes
WHERE idpedido = (880686);

SELECT * FROM vendas..tb_pessoas a
INNER JOIN vendas..tb_documentos b ON b.idpessoa = a.idpessoa
WHERE b.desdocumento IN (
	SELECT b.NrCPF FROM tb_controleFinanceiro a
	INNER JOIN tb_aluno b ON b.IdAluno = a.IdCliente
	WHERE InTipo = 'F' AND (b.NmAluno like '%+%' OR b.NmAluno like '%æ%' OR b.NmAluno like '%&#39;%') 
)

SELECT * FROM Ecommerce..tb_LojaVirtualRecibo b WHERE nmCliente like '%Luiz%de%Oliveira%Filho%'
WHERE (b.nmcliente like '%+%' OR b.nmcliente like '%æ%' OR b.nmcliente like '%&#39;%') 


SELECT * FROM tb_ecommercecliente where nome_cli = ''
Joæo Raphael Silva de Araujo
Jos&#39; Luiz de Oliveira Filho