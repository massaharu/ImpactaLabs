sp_OrcamentoAtend_e_Cliente 506730
sp_OrcamentoChequeARetirar 506730
Atendimento..sp_contato_get 1497
sp_orcamentototaltreinamentos_list 521730
sp_matricularecepcao 506730
orcamento..sp_orcamentotosaceitos_get 521730
atendimento..sp_SimpacWebHistoricoAtendimentoIdContato 676424
atendimento..sp_SimpacWebHistoricoAtendimentoCPF 38221818895
simpac..sp_controlefinanceiro_union_cliente_list_matricula 558154
sp_historicopedido_list 552592
sp_OrcamentoFormaPagamento 552592
sp_OrcamentoDataTreins 552592
sp_pedidoaceitorecepcao 552592
sp_text_object_show sp_pedidoaceitorecepcao
simpacweb..sp_simpacwebsearchhistorico 415329, 1495
sp_text_object_show sp_simpacwebsearchorcamento_get 606376
sp_text_object_show sp_simpacwebsearchorcamentofrommatricula_list '571738'
sp_text_object_show sp_simpacwebsearchorcamentofromaluno_list '571738'

sp_text_object_show sp_simpacwebsearchaccount_list '96429'
sp_text_object_show sp_simpacwebsearchaccountfrommatricula_list '556738'

sp_text_object_show sp_simpacwebsearchalunofromorcamento_list 556738 

sp_text_object_show orcamento..sp_orcamentotosaceitos_get 571738

select * from Impacta4.dbo.tb_EcommerceCliente where cod_cli = 96429
select * from tb_pedidos
select * from tb_aluno
select * from tb_alunoagendado
select * from Orcamento..tb_Pedidos_Aceitacao

sp_text_object_show sp_simpacwebsearchaluno_list
sp_text_object_show sp_simpacwebsearchalunofrommatricula_list
sp_text_object_show sp_simpacwebsearchaluno_get 571738

Select * from tb_pedidorecepcao whe

SELECT * FROM simpac.dbo.tb_ChequeARetirarContato
sp_OrcamentoChequeARetirar 400329

--568637
------------------------------------------------------------
--------------- PROCEDURES ---------------------------------
------------------------------------------------------------
ALTER PROC [dbo].[sp_simpacwebsearchaccountfromorcamento_list 395390638]
(
@idpedido INT
)
AS
/*
app: SimpacWeb
url: inc/class/class.search.php
data: 18/05/2013 08:25:33
author: Massaharu
*/

select b.cod_cli, b.nome_cli 
from orcamento..tb_Pedidos_Aceitacao a (nolock) 
full join impacta4..tb_ecommercecliente b (nolock) 
on a.cod_cli = b.cod_cli 
where idpedido = @idpedido




