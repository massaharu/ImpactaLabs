select * from ecommerce..tb_LojaVirtualRecibo where sessionid = 19856110

select * from simpac..tb_LojaVirtualBaixaRecibo where idrecibo = 377162
--delete tb_LojaVirtualBaixaRecibo where idrecibo = 368407

select * from ecommerce..tb_pagamento where sessionid = 19856110  

select * from simpac..tb_pedido_baixa_robo where idpedido = 865868-15000

select * from simpac..tb_RelacaoReciboMatricula where idrecibo = 377162


select * from simpac..tb_controleFinanceiro WHERE Matricula = '2414050050'
where dtcadastramento > '2013-06-20 17:00' and InTipo = 'F'
wh
-------------------------------
select * from ecommerce..tb_LojaVirtualRecibo where sessionid = 976635403

select * from tb_LojaVirtualBaixaRecibo where idrecibo = 368378
delete tb_LojaVirtualBaixaRecibo where idrecibo = 368411

select * from ecommerce..tb_pagamento where sessionid = 976635403
 
select * from tb_pedido_baixa_robo where idpedido = 578873

select * from tb_RelacaoReciboMatricula where idrecibo = 368378
-----------------


SELECT * FROM Ecommerce..tb_pagamentoItau WHERE sessionid = 19856110
SELECT * FROM Ecommerce..tb_pagamento WHERE sessionid = 19856110
SELECT * FROM Simpac..tb_cliente WHERE IdCliente = 118663
SELECT * FROM Simpac..tb_aluno WHERE idaluno = 118663
SELECT * FROM Simpac..tb_empresa WHERE IdEmpresa = 118663
SELECT * FROM Simpac..tb_pedidos WHERE IdPedido = 865868 - 15000
SELECT * FROM tb_LojaVirtualRecibo WHERE sessionid = 19856110
SELECT * FROM tb_recibo_pedido where idrecibo = 377162
SELECT * FROM Ecommerce..tb_status WHERE idstatus = 89189
SELECT * FROM Ecommerce..tb_tipostatus

SELECT nrparcelas, a.idformapagto, c.nome_cli, c.cod_cli, c.email_cli, c.cpf_cli, c.telefone_cli, idstatus, vltotal, idpedido 
FROM Ecommerce..tb_pagamento a 
inner join Ecommerce..tb_formapagamento b ON a.idformapagto = b.idformapagto 
inner join impacta4.dbo.tb_ecommercecliente c ON a.cod_cli = c.cod_cli 
WHERE sessionid = 19856110

