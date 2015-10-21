select * from tb_clientespagamentos where idpagamento = 2437

select * from tb_clientespagamentos where idpagamento = 2437


select * from tb_clientespagamentosrecibos where idpagamento = 2437

Select * from tb_clientespagamentospedidos where idpagamento = 2437

select * from tb_clientespagamentosrecibosmatriculas where idrecibo = 3933

select * from simpac..tb_controlefinanceiro where IdPedido = 920496 + 15000


SELECT * FROM simpac..tb_pedido_baixa_robo where idpedido = 919855

--UPDATE tb_clientespagamentosrecibos SET inbaixa = 0 WHERE idpagamento = 2198

SELECT * FROM tb_clientespagamentos where dessession = 'h6qohkovid55r4pomk6rvicvl5'
-----------------------------------------------------------------
select * from tb_clientespagamentos where idpagamento = 6901	

select * from tb_clientespagamentosrecibos where idpagamento = 6901	

Select * from tb_clientespagamentospedidos where idpagamento = 6901	

--select * from tb_clientespagamentosrecibosmatriculas where idrecibo = 3933

Select * from tb_clientespagamentospedidos where idpedido = 942459

--SELECt * from tb_clientespagamentosstatus where idpagamento = 2497

SELECT * FROM simpac..tb_pedidoparcelacobranca a
LEFT JOIN simpac..tb_pedidoparcela b ON b.IdPedidoParcela = a.idpedidoparcela
WHERE b.IdPedido = 942459

select * from tb_clientespagamentospedidosparcelas where idpedido = 942459

SELECT * FROM simpac..tb_controlefinanceiro where IdPedido = 942459+15000

SELECT * FROM tb_creditos where idpessoa = 1363649

SELECT simpac.dbo.fn_pedido_pago_full_get(942459)
----------------------------------------------------------------------------
SELECT * FROM simpac..tb_PedidoCursos where IdPedido = 933037-15000

SELECt * FROM Simpac..tb_pedido_baixa_robo WHERE idpedido = 923879

--INSERT INTO Simpac..tb_pedido_baixa_robo (idpedido, inbaixado, idpessoa)
--VALUES(923879, 0, 1022199)

--UPDATE tb_reciboparcelapedido SET nrparcela = 1
WHERE idpedidoparcela = 4636099

SELECT * FROM simpac..tb_pedidocheque where idpedido = 923879


SELECT * FROM simpac..tb_pedidoparcela WHERE IdPedido = 933724

SELECT * FROM simpac..tb_pedidoparcela a
INNER JOIN simpac..tb_reciboparcelapedido b ON b.idpedidoparcela = a.IdPedidoParcela --AND b.nrparcela = a.NrParcela
WHERE a.IdPedido = 935716

SELECT * FROM simpac..tb_reciboparcelapedido where idreciboparcelapedido = 119617

--update simpac..tb_reciboparcelapedido SET nrparcela = 2 where idreciboparcelapedido = 119618

SELECT * FROM tb_clientespagamentosrecibos where inbaixa = 0

------------------------------------------------------------------------

select 

simpac..sp_depends tb_pedidoparcelacobranca
simpac..sp_text_object_show fn_pedido_pago_full_get


SELECT * FROM tb_creditos where idpessoa = 1075434 

SELECT * FROM tb_formapagamento

select * from tb_clientespagamentospedidosparcelas where dessession = '39N15EJQFS3HOS9SBQMP7REFN1'

--UPDATE tb_clientespagamentospedidosparcelas SET idpedidoparcela = 4570175 WHERE idregistro = 7832
--UPDATE tb_clientespagamentospedidosparcelas set dessession = 'iug7nkt1vnkffv2id8a4nj6235' where idregistro = 21238
--UPDATE tb_clientespagamentosrecibos set inbaixa = 0 WHERE idrecibo in (4582)

----------

--SELECT * DELETE FROM simpac..tb_pedidoparcela where IdPedidoParcela = 4573322.

--SELECT * DELETE FROM simpac..tb_pedidoparcelacobranca where IdPedidoParcela = 4572140

--SELECT * DELETE FROM tb_clientespagamentospedidosparcelas where idregistro in(4580)

--exec simpac.dbo.sp_pedidoparcela_remove 4661073

SELECT * FROM Simpac..tb_controleFinanceiro where Matricula = '2115040021'



SELECT * FROM simpac..tb_pedidoparcela WHERE IdPedido = 937687
SELECT * FROM simpac..tb_reciboparcelapedido where idpedidoparcela = 4646586
SELECT * FROM simpac..tb_pedidoparcelacobranca where idpedidoparcela = 4646586
 
--UPDATE simpac..tb_pedidoparcela SET NrParcela = 1 WHERE idpedidoparcela = 4646386
--UPDATE simpac..tb_pedidoparcela SET NrParcela = 2 WHERE idpedidoparcela = 4646387
--UPDATE simpac..tb_pedidoparcela SET NrParcela = 3 WHERE idpedidoparcela = 4646586

--UPDATE simpac..tb_reciboparcelapedido set nrparcela = 1 where idpedidoparcela = 4646386
--UPDATE simpac..tb_reciboparcelapedido set nrparcela = 2 where idpedidoparcela = 4646387
--UPDATE simpac..tb_reciboparcelapedido set nrparcela = 3 where idpedidoparcela = 4646586

--INSERT INTO simpac..tb_reciboparcelapedido
--(idpedidoparcela, nrparcela, idtipoformapagamento, idrecibopedido, nrvalor)
--VALUES
--(4630072, 1, 25, 33864, 300)

SELECT * FROM simpac..tb_pedidocheque WHERE idpedido = 937687

SELECT * FROM simpac..tb_pedido_cv where idpedidoparcela = 4630072
 

Select 
		max(a.nrparcela),
		count(distinct b.idreciboparcelapedido) 
	from tb_PedidoParcela a
	left join tb_ReciboParcelapedido b
	on a.IdPedidoParcela = b.idpedidoparcela and a.NrParcela = b.nrparcela
	inner join tb_recibo_pedido  c
	on a.IdPedido = c.idpedido
	left join tb_pedidoparcelacobranca d
	on a.idpedidoparcela = d.idpedidoparcela
	where a.idpedido = 937687