findobj 'sp_notafiscal_emit',p
findobj 'object',p
sp_text_object_show sp_notaFiscal_Emitir_list

-----------------------------------------------------
ALTER proc [dbo].[sp_notaFiscal_Emitir_list]
(@ano int,@mes int,@inTipo char(1))
/*
app: SimpacWeb
url: /simpacweb/modulos/financeiro/ajax/notafiscal/store_emitir_list.php
data: 22/07/2011 14:50:18
author: framires
*/
AS
BEGIN
	--declare @ano int,@mes int,@inTipo char(1)
	--set @mes = 05
	--set @ano = 2012
	--set @inTipo = 'F'

	--DECLARE @TABELA TABLE (PrimeiroVencimento datetime,Matricula varchar(20),cliente varchar(100),idcliente int,Dtfatura datetime,idpedido int,
	--VlTotal decimal,InTipo char(1),QtNotaFiscalASerEmitida int,Usuario varchar(50),InStatusNotaFiscalEmitida bit,
	--IdControleFinanceiro int,inDesmembra bit)

	declare @ano int,@mes int,@inTipo char(1)
	set @mes = '04'
	set @ano = 2014
	set @inTipo = 'J'

	with tabelaPesq
	(
		PrimeiroVencimento,Matricula,cliente,idcliente,Dtfatura,idpedido,
		VlTotal,InTipo,QtNotaFiscalASerEmitida,Usuario,InStatusNotaFiscalEmitida,
		IdControleFinanceiro,inDesmembra
		,idflag
	)AS(

		--INSERT @TABELA
		SELECT  Min(Distinct tb_Parcelas.DtVencimento) As PrimeiroVencimento,
		tb_ControleFinanceiro.Matricula, 
		CASE when tb_ControleFinanceiro.InTipo = 'F' 
			 then  tb_Aluno.NmAluno 
			 else tb_Empresa.NmEmpresa 
		END as cliente,
		tb_controlefinanceiro.idcliente,
		Case When tb_Pedidos_Faturamento.DtNotaFiscal Is Null 
			 Then tb_ControleFinanceiro.dtfatura
 			 Else 
 			 CASE
 				WHEN tb_Pedidos_Faturamento.idpedido = 0
				THEN tb_ControleFinanceiro.dtfatura
				ELSE tb_Pedidos_Faturamento.DtNotaFiscal 
			END				
		END as Dtfatura,
		tb_ControleFinanceiro.IdPedido, 
		tb_ControleFinanceiro.VlTotal, tb_ControleFinanceiro.InTipo,
		CASE WHEN tb_controlefinanceiro.inDesmembra = 1 
			 then tb_ControleFinanceiro.QtNotaFiscalASerEmitida 
			 else tb_controlefinanceiro.QtParcelas 
		end as [QtNotaFiscalASerEmitida], 
		tb_Usuario.NmUsuario,
		tb_controlefinanceiro.InStatusNotaFiscalEmitida,	
		tb_ControleFinanceiro.IdControleFinanceiro,
		tb_ControleFinanceiro.inDesmembra,
		tab_cursosagendadosflags.idflag
		FROM tb_ControleFinanceiro

		LEFT OUTER JOIN tb_Empresa ON  tb_ControleFinanceiro.IdCliente = tb_Empresa.IdEmpresa
		LEFT JOIN tb_Aluno ON tb_ControleFinanceiro.IdCliente = tb_Aluno.IdAluno   

		INNER JOIN tb_Parcelas
		ON tb_ControleFinanceiro.IdControleFinanceiro = tb_Parcelas.IdControleFinanceiro		

		LEFT JOIN tb_Usuario
		ON tb_ControleFinanceiro.IdUsuario = tb_Usuario.IdUsuario

		LEFT JOIN tb_Pedidos_Faturamento ON 
		(tb_ControleFinanceiro.IdPedido - 15000) = tb_Pedidos_Faturamento.IdPedido

		LEFT JOIN tb_cancelamentoSAC 
		ON tb_cancelamentoSAC.matricula = tb_ControleFinanceiro.matricula --and tb_cancelamentoSAC.InTipo = 'T'

		LEFT JOIN tb_alunoagendado
		ON tb_alunoagendado.Matricula = tb_ControleFinanceiro.Matricula

		LEFT JOIN tab_cursosagendados
		ON tab_cursosagendados.idcursoagendado = tb_alunoagendado.IdCursoAgendado

		LEFT JOIN tab_cursosagendados_Flags
		ON tab_cursosagendados_Flags.idcursoagendado = tab_cursosagendados.idcursoagendado

		-- JOIN para identificar apenas os cursos agendados de locação
		LEFT JOIN tab_cursosagendadosFlags
		ON tab_cursosagendadosFlags.idflag = tab_cursosagendados_Flags.idflag AND tab_cursosagendados_Flags.idflag = 6 

		--LEFT JOIN v_QntParcelasChequePre 
		--	ON tb_ControleFinanceiro.Matricula=v_QntParcelasChequePre.Matricula AND 
		--tb_ControleFinanceiro.qtParcelas=v_QntParcelasChequePre.qntParcelas 

		WHERE tb_ControleFinanceiro.InStatusNotaFiscalEmitida = 0 		
		AND tb_ControleFinanceiro.IdUsuario Not In (3, 13, 52, 99,65)
		AND tb_ControleFinanceiro.InTipo= @inTipo
		AND tb_ControleFinanceiro.vltotal > 0
		AND tb_ControleFinanceiro.InStatus = 1
		AND tb_controlefinanceiro.InDesmembra = 0
		AND tb_cancelamentosac.matricula is null

		GROUP BY tb_ControleFinanceiro.Matricula, tb_Aluno.NmAluno, tb_ControleFinanceiro.VlTotal,
			tb_ControleFinanceiro.InTipo, 
			tb_ControleFinanceiro.IdCliente,
			tb_ControleFinanceiro.IdPedido, 
			tb_Usuario.NmUsuario, tb_ControleFinanceiro.QtNotaFiscalASerEmitida,
			tb_ControleFinanceiro.IdControleFinanceiro,
			tb_controlefinanceiro.QtParcelas,
			tb_ControleFinanceiro.DtFatura, tb_Pedidos_Faturamento.DtNotaFiscal,
			tb_Empresa.NmEmpresa,tb_controlefinanceiro.InStatusNotaFiscalEmitida,
			tb_ControleFinanceiro.inDesmembra,
			tb_Pedidos_Faturamento.idpedido,
			tab_cursosagendadosflags.idflag
	)

	SELECT Min(distinct tb_Parcelas.DtVencimento) As PrimeiroVencimento,
		tb_ControleFinanceiro.matricula,
		CASE WHEN tb_ControleFinanceiroDesmembrado.InTipo = 'F' THEN tb_Aluno.NmAluno ELSE tb_Empresa.NmEmpresa END AS cliente,	 
		tb_ControleFinanceiroDesmembrado.idcliente, 
		tb_ControleFinanceiroDesmembrado.DtNota as Dtfatura,
		tb_ControleFinanceiro.IdPedido, 
		tb_ControleFinanceiroDesmembrado.VlTotalDesmembrado as VlTotal, 
		tb_ControleFinanceiroDesmembrado.InTipo, 
		tb_ControleFinanceiroDesmembrado.QtNotaFiscalASerEmitida, 
		tb_Usuario.NmUsuario,
		tb_ControleFinanceiroDesmembrado.InStatusNotaFiscalEmitida,
		tb_ControleFinanceiro.IdControleFinanceiro,
		tb_ControleFinanceiro.inDesmembra,
		tb_ControleFinanceiroDesmembrado.IdControleFinanceiroDesmembrado as IdControleFinancDesmembrado,
		tab_cursosagendadosflags.idflag
	FROM tb_ControleFinanceiro    
		INNER JOIN tb_ControleFinanceiroDesmembrado ON 
		tb_ControleFinanceiroDesmembrado.matricula = tb_ControleFinanceiro.matricula    
		INNER JOIN tb_Parcelas ON tb_ControleFinanceiroDesmembrado.IdControleFinanceiro = tb_Parcelas.IdControleFinanceiro
		LEFT OUTER JOIN tb_Aluno ON  tb_ControleFinanceiroDesmembrado.IdCliente = tb_Aluno.IdAluno 
		LEFT OUTER JOIN tb_Empresa ON  tb_ControleFinanceiroDesmembrado.IdCliente = tb_Empresa.IdEmpresa 
		LEFT OUTER JOIN tb_Usuario ON  tb_ControleFinanceiro.IdUsuario = tb_Usuario.IdUsuario
		LEFT JOIN tb_alunoagendado ON tb_alunoagendado.Matricula = tb_ControleFinanceiro.Matricula
		LEFT JOIN tab_cursosagendados ON tab_cursosagendados.idcursoagendado = tb_alunoagendado.IdCursoAgendado
		LEFT JOIN tab_cursosagendados_Flags ON tab_cursosagendados_Flags.idcursoagendado = tab_cursosagendados.idcursoagendado
		-- JOIN para identificar apenas os cursos agendados de locação
		LEFT JOIN tab_cursosagendadosFlags ON tab_cursosagendadosFlags.idflag = tab_cursosagendados_Flags.idflag AND tab_cursosagendados_Flags.idflag = 6
	WHERE (
			year(tb_ControleFinanceiroDesmembrado.DtNota) = @ano and 
			month(tb_ControleFinanceiroDesmembrado.DtNota)= @mes
		)
		AND tb_ControleFinanceiroDesmembrado.InStatusNotaFiscalEmitida = 0
		AND tb_ControleFinanceiroDesmembrado.InTipo = @inTipo
		AND tb_ControleFinanceiro.vltotal > 0
	GROUP BY 
		tb_ControleFinanceiro.Matricula, 
		tb_Empresa.NmEmpresa, 
		tb_Aluno.NmAluno,
		tb_ControleFinanceiroDesmembrado.IdCliente, 
		tb_ControleFinanceiroDesmembrado.DtNota,
		tb_ControleFinanceiro.IdPedido, 
		tb_ControleFinanceiroDesmembrado.VlTotalDesmembrado, 
		tb_ControleFinanceiroDesmembrado.InTipo, 
		tb_ControleFinanceiroDesmembrado.IdControleFinanceiroDesmembrado,
		tb_ControleFinanceiroDesmembrado.QtNotaFiscalASerEmitida, 
		tb_Usuario.NmUsuario,
		tb_ControleFinanceiroDesmembrado.InStatusNotaFiscalEmitida,
		tb_ControleFinanceiro.IdControleFinanceiro,
		tb_ControleFinanceiro.inDesmembra,
		tab_cursosagendadosflags.idflag

	Union ALL

	SELECT 
		PrimeiroVencimento,Matricula,cliente,idcliente,Dtfatura,IdPedido,VlTotal,
		InTipo,QtNotaFiscalASerEmitida,Usuario,InStatusNotaFiscalEmitida,
		IdControleFinanceiro,inDesmembra,'', idflag FROM tabelaPesq 
	where Month(Dtfatura) = @mes and YEAR(Dtfatura)= @ano 
	order by dtfatura
END
-----------------------------------------
USE [Simpac]
GO
/****** Object:  StoredProcedure [dbo].[sp_NotaFiscal_matricula_get]    Script Date: 04/11/2014 14:39:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER    PROCEDURE [dbo].[sp_NotaFiscal_matricula_get]
 (@Matricula varchar(20)) 
AS


/*
app: SimpacWeb
url: /simpacweb/modulos/financeiro/ajax/?/store_nfmatricula_list.php
data: 22/07/2011 14:50:18
author: framires
*/

--declare @Matricula varchar(20)
--set @Matricula = '6113080236          '

SELECT 
	Min (distinct tb_Parcelas.DtVencimento) As PrimeiroVencimento ,
	tb_ControleFinanceiro.matricula ,
	CASE
		WHEN  tb_ControleFinanceiro.InTipo= 'F' 
		then tb_aluno.NmAluno 
		else tb_Empresa.NmEmpresa  
	end as cliente,
	tb_ControleFinanceiro.idcliente,
	CASE 
		WHEN tb_Pedidos_Faturamento.DtNotaFiscal IS NULL 
		THEN tb_ControleFinanceiro.dtfatura 
		ELSE 
			CASE
				WHEN tb_Pedidos_Faturamento.idpedido = 0
				THEN tb_ControleFinanceiro.dtfatura
				ELSE tb_Pedidos_Faturamento.DtNotaFiscal 
			END						
	END Dtfatura,
	tb_ControleFinanceiro.IdPedido,
	tb_ControleFinanceiro.VlTotal as VlTotal,
	tb_ControleFinanceiro.InTipo,
	CASE WHEN tb_controlefinanceiro.inDesmembra = 1 then tb_ControleFinanceiro.QtNotaFiscalASerEmitida else tb_controlefinanceiro.QtParcelas end as [QtNotaFiscalASerEmitida], 
	tb_Usuario.NmUsuario,
	tb_ControleFinanceiro.IdControleFinanceiro,''IdControleFinancDesmembrado,tb_controlefinanceiro.inDesmembra
	,tab_cursosagendadosFlags.idflag
	FROM tb_ControleFinanceiro
		
	left JOIN tb_Empresa
	ON tb_ControleFinanceiro.IdCliente = tb_Empresa.IdEmpresa

	LEFT JOIN tb_aluno
	on tb_aluno.idaluno = tb_controlefinanceiro.idcliente    

	INNER JOIN tb_Parcelas
	ON tb_ControleFinanceiro.IdControleFinanceiro = tb_Parcelas.IdControleFinanceiro

	LEFT JOIN tb_Usuario
	ON tb_ControleFinanceiro.IdUsuario = tb_Usuario.IdUsuario
	
	LEFT JOIN tb_Pedidos_Faturamento
	ON tb_Pedidos_Faturamento.IdPedido = tb_ControleFinanceiro.IdPedido - 15000
	
	LEFT JOIN tb_cancelamentoSAC 
	ON tb_cancelamentoSAC.matricula = tb_ControleFinanceiro.matricula and tb_cancelamentoSAC.InTipo = 'T'
	
	LEFT JOIN tb_alunoagendado
		ON tb_alunoagendado.Matricula = tb_ControleFinanceiro.Matricula

	LEFT JOIN tab_cursosagendados
	ON tab_cursosagendados.idcursoagendado = tb_alunoagendado.IdCursoAgendado

	LEFT JOIN tab_cursosagendados_Flags
	ON tab_cursosagendados_Flags.idcursoagendado = tab_cursosagendados.idcursoagendado AND tab_cursosagendados_Flags.idflag = 6

	-- JOIN para identificar apenas os cursos agendados de locação
	LEFT JOIN tab_cursosagendadosFlags
	ON tab_cursosagendadosFlags.idflag = tab_cursosagendados_Flags.idflag 
		
	WHERE  ( tb_ControleFinanceiro.Matricula = @Matricula)
	and (tb_ControleFinanceiro.InDesmembra = 0)
	and tb_ControleFinanceiro.InStatusNotaFiscalEmitida =0
	and	tb_ControleFinanceiro.idusuario not in (65)
	and tb_cancelamentoSAC.Matricula is null 
	GROUP BY 	tb_ControleFinanceiro.Matricula , tb_Empresa.NmEmpresa ,tb_aluno.NmAluno,
		tb_ControleFinanceiro.idcliente,
		tb_ControleFinanceiro.VlTotal , tb_ControleFinanceiro.InTipo,     
		tb_Usuario.NmUsuario , tb_ControleFinanceiro.QtNotaFiscalASerEmitida ,
		tb_ControleFinanceiro.IdPedido,tb_ControleFinanceiro.QtParcelas,
		tb_ControleFinanceiro.IdControleFinanceiro,tb_ControleFinanceiro.dtfatura,tb_Pedidos_Faturamento.DtNotaFiscal,
		tb_controlefinanceiro.inDesmembra,tb_Pedidos_Faturamento.idpedido 
		,tab_cursosagendadosFlags.idflag
		 
UNION ALL

SELECT 
	Min(distinct tb_Parcelas.DtVencimento) As PrimeiroVencimento,
	tb_ControleFinanceiro.Matricula,
	CASE WHEN  tb_ControleFinanceiroDesmembrado.InTipo= 'F' then tb_aluno.NmAluno else tb_Empresa.NmEmpresa  end as cliente,
	tb_ControleFinanceiro.idcliente,
    tb_ControleFinanceiroDesmembrado.dtnota as dtfatura, 
    tb_ControleFinanceiro.IdPedido,
    tb_ControleFinanceiroDesmembrado.VlTotalDesmembrado as VlTotal,tb_ControleFinanceiroDesmembrado.InTipo,
    tb_ControleFinanceiroDesmembrado.QtNotaFiscalASerEmitida,
    tb_Usuario.NmUsuario,
    tb_ControleFinanceiro.IdControleFinanceiro,
    tb_ControleFinanceiroDesmembrado.IdControleFinanceiroDesmembrado as IdControleFinancDesmembrado,
    tb_controlefinanceiro.inDesmembra   
    ,tab_cursosagendadosFlags.idflag
FROM tb_ControleFinanceiro 
	INNER JOIN  tb_ControleFinanceiroDesmembrado ON 
	tb_ControleFinanceiro.IdControleFinanceiro = tb_ControleFinanceiroDesmembrado.IdControleFinanceiro
	INNER JOIN tb_Cliente ON  tb_ControleFinanceiroDesmembrado.IdCliente = tb_Cliente.IdCliente
	INNER JOIN tb_Parcelas  ON tb_ControleFinanceiroDesmembrado.Matricula = tb_Parcelas.Matricula
	and tb_ControleFinanceiroDesmembrado.QtNotaFiscalASerEmitida = tb_Parcelas.nrparcela
	LEFT OUTER JOIN  tb_Aluno ON  tb_Cliente.IdCliente = tb_Aluno.IdAluno 
	LEFT OUTER JOIN  tb_Empresa ON  tb_Cliente.IdCliente = tb_Empresa.IdEmpresa 
	LEFT OUTER JOIN  tb_Usuario ON  tb_ControleFinanceiro.IdUsuario = tb_Usuario.IdUsuario
	LEFT OUTER JOIN  tb_ChequeARetirar ON tb_ControleFinanceiro.IdControleFinanceiro = tb_ChequeARetirar.IdControleFinanceiro
	LEFT JOIN tb_alunoagendado ON tb_alunoagendado.Matricula = tb_ControleFinanceiro.Matricula
	LEFT JOIN tab_cursosagendados ON tab_cursosagendados.idcursoagendado = tb_alunoagendado.IdCursoAgendado
	LEFT JOIN tab_cursosagendados_Flags ON tab_cursosagendados_Flags.idcursoagendado = tab_cursosagendados.idcursoagendado AND tab_cursosagendados_Flags.idflag = 6
	-- JOIN para identificar apenas os cursos agendados de locação
	LEFT JOIN tab_cursosagendadosFlags ON tab_cursosagendadosFlags.idflag = tab_cursosagendados_Flags.idflag
WHERE  
	tb_ControleFinanceiro.Matricula = @Matricula and 
	tb_ControleFinanceiroDesmembrado.InStatusNotaFiscalEmitida = 0 and 
	tb_ControleFinanceiro.idusuario not in(65)
GROUP BY tb_ControleFinanceiro.Matricula, tb_Empresa.NmEmpresa, 
    tb_Aluno.NmAluno,tb_ControleFinanceiroDesmembrado.DtNota,
    tb_ControleFinanceiro.idcliente,
    tb_ControleFinanceiro.IdPedido,
    tb_ControleFinanceiroDesmembrado.VlTotalDesmembrado, 
    tb_ControleFinanceiroDesmembrado.InTipo, tb_ControleFinanceiroDesmembrado.IdControleFinanceiroDesmembrado,
    tb_ControleFinanceiroDesmembrado.QtNotaFiscalASerEmitida, 
    tb_Usuario.NmUsuario,
    tb_ControleFinanceiro.IdControleFinanceiro,tb_controlefinanceiro.inDesmembra
    ,tab_cursosagendadosFlags.idflag   
-------------------------------------------
-------------------------------------------
-------------------------------------------
-------------------------------------------

SELECT* FROM tb_cursosagendados where DesOBS like '%locacao%'

SELECT * FROM tb_ControleFinanceiro
SELECT * FROM tb_alunoagendado
SELECT * FROM tb_cursosagendados
SELECT * FROM tab_cursosagendados
SELECT * FROM tab_cursosagendados_flags where idflag in(4,6,7)
SELECT * FROM tab_cursosagendadosflags where idflag in(4,6,7)

SELECT * FROM tab_cursosagendados_Flags
WHERE idcursoagendado in(
	SELECT DISTINCT idcursoagendado FROM tb_alunoagendado
	WHERE Matricula IN('6913120071')
)


SELECT * FROM tb_alunoagendado
WHERE IdCursoAgendado in(
	119991,
119993,
120178,
120403,
120530,
120678

sp_NotaFiscal_matricula_get '6913120071'
sp_NotaFiscal_matricula_get '0114030156'       
       

DECLARE @ano int,@mes int,@inTipo char(1)
set @ano = '2014'
SET @mes = '05'
set @inTipo = 'j'

 WITH tabelaPesq
	(
		PrimeiroVencimento,Matricula,cliente,idcliente,Dtfatura,idpedido,
		VlTotal,InTipo,QtNotaFiscalASerEmitida,Usuario,InStatusNotaFiscalEmitida,
		IdControleFinanceiro,inDesmembra
		,idflag
	)AS(

		--INSERT @TABELA
		SELECT  Min(Distinct tb_Parcelas.DtVencimento) As PrimeiroVencimento,
		tb_ControleFinanceiro.Matricula, 
		CASE when tb_ControleFinanceiro.InTipo = 'F' 
			   then  tb_Aluno.NmAluno 
			   else tb_Empresa.NmEmpresa 
		END as cliente,
		tb_controlefinanceiro.idcliente,
		Case When tb_Pedidos_Faturamento.DtNotaFiscal Is Null 
			   Then tb_ControleFinanceiro.dtfatura
			  Else 
			   CASE
				   WHEN tb_Pedidos_Faturamento.idpedido = 0
					THEN tb_ControleFinanceiro.dtfatura
					ELSE tb_Pedidos_Faturamento.DtNotaFiscal 
			  END                     
		END as Dtfatura,
		tb_ControleFinanceiro.IdPedido, 
		tb_ControleFinanceiro.VlTotal, tb_ControleFinanceiro.InTipo,
		CASE WHEN tb_controlefinanceiro.inDesmembra = 1 
			   then tb_ControleFinanceiro.QtNotaFiscalASerEmitida 
			   else tb_controlefinanceiro.QtParcelas 
		end as [QtNotaFiscalASerEmitida], 
		tb_Usuario.NmUsuario,
		tb_controlefinanceiro.InStatusNotaFiscalEmitida,     
		tb_ControleFinanceiro.IdControleFinanceiro,
		tb_ControleFinanceiro.inDesmembra,
		sum(tab_cursosagendadosflags.idflag) as idflag
		FROM tb_ControleFinanceiro

		LEFT OUTER JOIN tb_Empresa ON  tb_ControleFinanceiro.IdCliente = tb_Empresa.IdEmpresa
		LEFT JOIN tb_Aluno ON tb_ControleFinanceiro.IdCliente = tb_Aluno.IdAluno   

		INNER JOIN tb_Parcelas
		ON tb_ControleFinanceiro.IdControleFinanceiro = tb_Parcelas.IdControleFinanceiro            

		LEFT JOIN tb_Usuario
		ON tb_ControleFinanceiro.IdUsuario = tb_Usuario.IdUsuario

		LEFT JOIN tb_Pedidos_Faturamento ON 
		(tb_ControleFinanceiro.IdPedido - 15000) = tb_Pedidos_Faturamento.IdPedido

		LEFT JOIN tb_cancelamentoSAC 
		ON tb_cancelamentoSAC.matricula = tb_ControleFinanceiro.matricula and tb_cancelamentoSAC.InTipo = 'T'

		LEFT JOIN tb_alunoagendado
		ON tb_alunoagendado.Matricula = tb_ControleFinanceiro.Matricula

		LEFT JOIN tab_cursosagendados
		ON tab_cursosagendados.idcursoagendado = tb_alunoagendado.IdCursoAgendado

		-- JOIN para identificar apenas os cursos agendados de locação
		LEFT JOIN tab_cursosagendados_Flags
		ON tab_cursosagendados_Flags.idcursoagendado = tab_cursosagendados.idcursoagendado AND tab_cursosagendados_Flags.idflag = 6

		LEFT JOIN tab_cursosagendadosFlags
		ON tab_cursosagendadosFlags.idflag = tab_cursosagendados_Flags.idflag --AND tab_cursosagendados_Flags.idflag = 6

		--LEFT JOIN v_QntParcelasChequePre 
		--    ON tb_ControleFinanceiro.Matricula=v_QntParcelasChequePre.Matricula AND 
		--tb_ControleFinanceiro.qtParcelas=v_QntParcelasChequePre.qntParcelas 

		WHERE tb_ControleFinanceiro.InStatusNotaFiscalEmitida = 0        
		AND tb_ControleFinanceiro.IdUsuario Not In (3, 13, 52, 99,65)
		AND tb_ControleFinanceiro.InTipo= @inTipo
		AND tb_ControleFinanceiro.vltotal > 0
		AND tb_ControleFinanceiro.InStatus = 1
		AND tb_controlefinanceiro.InDesmembra = 0
		AND tb_cancelamentosac.matricula is null

		GROUP BY tb_ControleFinanceiro.Matricula, tb_Aluno.NmAluno, tb_ControleFinanceiro.VlTotal,
			  tb_ControleFinanceiro.InTipo, 
			  tb_ControleFinanceiro.IdCliente,
			  tb_ControleFinanceiro.IdPedido, 
			  tb_Usuario.NmUsuario, tb_ControleFinanceiro.QtNotaFiscalASerEmitida,
			  tb_ControleFinanceiro.IdControleFinanceiro,
			  tb_controlefinanceiro.QtParcelas,
			  tb_ControleFinanceiro.DtFatura, tb_Pedidos_Faturamento.DtNotaFiscal,
			  tb_Empresa.NmEmpresa,tb_controlefinanceiro.InStatusNotaFiscalEmitida,
			  tb_ControleFinanceiro.inDesmembra,
			  tb_Pedidos_Faturamento.idpedido
	)

	SELECT Min(distinct tb_Parcelas.DtVencimento) As PrimeiroVencimento,
		tb_ControleFinanceiro.matricula,
		CASE WHEN tb_ControleFinanceiroDesmembrado.InTipo = 'F' THEN tb_Aluno.NmAluno ELSE tb_Empresa.NmEmpresa END AS cliente,      
		tb_ControleFinanceiroDesmembrado.idcliente, 
		tb_ControleFinanceiroDesmembrado.DtNota as Dtfatura,
		tb_ControleFinanceiro.IdPedido, 
		tb_ControleFinanceiroDesmembrado.VlTotalDesmembrado as VlTotal, 
		tb_ControleFinanceiroDesmembrado.InTipo, 
		tb_ControleFinanceiroDesmembrado.QtNotaFiscalASerEmitida, 
		tb_Usuario.NmUsuario,
		tb_ControleFinanceiroDesmembrado.InStatusNotaFiscalEmitida,
		tb_ControleFinanceiro.IdControleFinanceiro,
		tb_ControleFinanceiro.inDesmembra,
		tb_ControleFinanceiroDesmembrado.IdControleFinanceiroDesmembrado as IdControleFinancDesmembrado,
		sum(tab_cursosagendadosflags.idflag) as idflag
	FROM tb_ControleFinanceiro    
		INNER JOIN tb_ControleFinanceiroDesmembrado ON 
		tb_ControleFinanceiroDesmembrado.matricula = tb_ControleFinanceiro.matricula    
		INNER JOIN tb_Parcelas ON tb_ControleFinanceiroDesmembrado.IdControleFinanceiro = tb_Parcelas.IdControleFinanceiro
		LEFT OUTER JOIN tb_Aluno ON  tb_ControleFinanceiroDesmembrado.IdCliente = tb_Aluno.IdAluno 
		LEFT OUTER JOIN tb_Empresa ON  tb_ControleFinanceiroDesmembrado.IdCliente = tb_Empresa.IdEmpresa 
		LEFT OUTER JOIN tb_Usuario ON  tb_ControleFinanceiro.IdUsuario = tb_Usuario.IdUsuario
		LEFT JOIN tb_alunoagendado ON tb_alunoagendado.Matricula = tb_ControleFinanceiro.Matricula
		LEFT JOIN tab_cursosagendados ON tab_cursosagendados.idcursoagendado = tb_alunoagendado.IdCursoAgendado
	    
		LEFT JOIN tab_cursosagendados_Flags ON tab_cursosagendados_Flags.idcursoagendado = tab_cursosagendados.idcursoagendado AND tab_cursosagendados_Flags.idflag = 6 
	    
		-- JOIN para identificar apenas os cursos agendados de locação
		LEFT JOIN tab_cursosagendadosFlags ON tab_cursosagendadosFlags.idflag = tab_cursosagendados_Flags.idflag --AND tab_cursosagendados_Flags.idflag = 6
	WHERE (
			  year(tb_ControleFinanceiroDesmembrado.DtNota) = @ano and 
			  month(tb_ControleFinanceiroDesmembrado.DtNota)= @mes
		)
		AND tb_ControleFinanceiroDesmembrado.InStatusNotaFiscalEmitida = 0
		AND tb_ControleFinanceiroDesmembrado.InTipo = @inTipo
		AND tb_ControleFinanceiro.vltotal > 0
	GROUP BY 
		tb_ControleFinanceiro.Matricula, 
		tb_Empresa.NmEmpresa, 
		tb_Aluno.NmAluno,
		tb_ControleFinanceiroDesmembrado.IdCliente, 
		tb_ControleFinanceiroDesmembrado.DtNota,
		tb_ControleFinanceiro.IdPedido, 
		tb_ControleFinanceiroDesmembrado.VlTotalDesmembrado, 
		tb_ControleFinanceiroDesmembrado.InTipo, 
		tb_ControleFinanceiroDesmembrado.IdControleFinanceiroDesmembrado,
		tb_ControleFinanceiroDesmembrado.QtNotaFiscalASerEmitida, 
		tb_Usuario.NmUsuario,
		tb_ControleFinanceiroDesmembrado.InStatusNotaFiscalEmitida,
		tb_ControleFinanceiro.IdControleFinanceiro,
		tb_ControleFinanceiro.inDesmembra
	    
	UNION

	SELECT
		PrimeiroVencimento,Matricula,cliente,idcliente,Dtfatura,IdPedido,VlTotal,
		InTipo,QtNotaFiscalASerEmitida,Usuario,InStatusNotaFiscalEmitida,
		IdControleFinanceiro,inDesmembra,'', count(idflag)  as idflag
	FROM tabelaPesq 
	WHERE Month(Dtfatura) = @mes and YEAR(Dtfatura)= @ano 
	GROUP BY PrimeiroVencimento,Matricula,cliente,idcliente,Dtfatura,IdPedido,VlTotal,
		InTipo,QtNotaFiscalASerEmitida,Usuario,InStatusNotaFiscalEmitida,
		IdControleFinanceiro,inDesmembra
	ORDER BY dtfatura
----------------------------------------------------------
DECLARE @ano int,@mes int,@inTipo char(1)
set @ano = '2014'
SET @mes = '04'
set @inTipo = 'j'
with tabelaPesq
(
    PrimeiroVencimento,Matricula,cliente,idcliente,Dtfatura,idpedido,
    VlTotal,InTipo,QtNotaFiscalASerEmitida,Usuario,InStatusNotaFiscalEmitida,
    IdControleFinanceiro,inDesmembra
    ,idflag
)AS(

    --INSERT @TABELA
    SELECT  Min(Distinct tb_Parcelas.DtVencimento) As PrimeiroVencimento,
    tb_ControleFinanceiro.Matricula, 
    CASE when tb_ControleFinanceiro.InTipo = 'F' 
           then  tb_Aluno.NmAluno 
           else tb_Empresa.NmEmpresa 
    END as cliente,
    tb_controlefinanceiro.idcliente,
    Case When tb_Pedidos_Faturamento.DtNotaFiscal Is Null 
           Then tb_ControleFinanceiro.dtfatura
          Else 
           CASE
               WHEN tb_Pedidos_Faturamento.idpedido = 0
                THEN tb_ControleFinanceiro.dtfatura
                ELSE tb_Pedidos_Faturamento.DtNotaFiscal 
          END                     
    END as Dtfatura,
    tb_ControleFinanceiro.IdPedido, 
    tb_ControleFinanceiro.VlTotal, tb_ControleFinanceiro.InTipo,
    CASE WHEN tb_controlefinanceiro.inDesmembra = 1 
           then tb_ControleFinanceiro.QtNotaFiscalASerEmitida 
           else tb_controlefinanceiro.QtParcelas 
    end as [QtNotaFiscalASerEmitida], 
    tb_Usuario.NmUsuario,
    tb_controlefinanceiro.InStatusNotaFiscalEmitida,     
    tb_ControleFinanceiro.IdControleFinanceiro,
    tb_ControleFinanceiro.inDesmembra,
    count(tab_cursosagendadosflags.idflag) as idflag
    FROM tb_ControleFinanceiro

    LEFT OUTER JOIN tb_Empresa ON  tb_ControleFinanceiro.IdCliente = tb_Empresa.IdEmpresa
    LEFT JOIN tb_Aluno ON tb_ControleFinanceiro.IdCliente = tb_Aluno.IdAluno   

    INNER JOIN tb_Parcelas
    ON tb_ControleFinanceiro.IdControleFinanceiro = tb_Parcelas.IdControleFinanceiro            

    LEFT JOIN tb_Usuario
    ON tb_ControleFinanceiro.IdUsuario = tb_Usuario.IdUsuario

    LEFT JOIN tb_Pedidos_Faturamento ON 
    (tb_ControleFinanceiro.IdPedido - 15000) = tb_Pedidos_Faturamento.IdPedido

    LEFT JOIN tb_cancelamentoSAC 
    ON tb_cancelamentoSAC.matricula = tb_ControleFinanceiro.matricula and tb_cancelamentoSAC.InTipo = 'T'

    LEFT JOIN tb_alunoagendado
    ON tb_alunoagendado.Matricula = tb_ControleFinanceiro.Matricula

    LEFT JOIN tab_cursosagendados
    ON tab_cursosagendados.idcursoagendado = tb_alunoagendado.IdCursoAgendado

    -- JOIN para identificar apenas os cursos agendados de locação
    LEFT JOIN tab_cursosagendados_Flags
    ON tab_cursosagendados_Flags.idcursoagendado = tab_cursosagendados.idcursoagendado AND tab_cursosagendados_Flags.idflag = 6

    LEFT JOIN tab_cursosagendadosFlags
    ON tab_cursosagendadosFlags.idflag = tab_cursosagendados_Flags.idflag --AND tab_cursosagendados_Flags.idflag = 6

    --LEFT JOIN v_QntParcelasChequePre 
    --    ON tb_ControleFinanceiro.Matricula=v_QntParcelasChequePre.Matricula AND 
    --tb_ControleFinanceiro.qtParcelas=v_QntParcelasChequePre.qntParcelas 

    WHERE tb_ControleFinanceiro.InStatusNotaFiscalEmitida = 0        
    AND tb_ControleFinanceiro.IdUsuario Not In (3, 13, 52, 99,65)
    AND tb_ControleFinanceiro.InTipo= @inTipo
    AND tb_ControleFinanceiro.vltotal > 0
    AND tb_ControleFinanceiro.InStatus = 1
    AND tb_controlefinanceiro.InDesmembra = 0
    AND tb_cancelamentosac.matricula is null

    GROUP BY tb_ControleFinanceiro.Matricula, tb_Aluno.NmAluno, tb_ControleFinanceiro.VlTotal,
          tb_ControleFinanceiro.InTipo, 
          tb_ControleFinanceiro.IdCliente,
          tb_ControleFinanceiro.IdPedido, 
          tb_Usuario.NmUsuario, tb_ControleFinanceiro.QtNotaFiscalASerEmitida,
          tb_ControleFinanceiro.IdControleFinanceiro,
          tb_controlefinanceiro.QtParcelas,
          tb_ControleFinanceiro.DtFatura, tb_Pedidos_Faturamento.DtNotaFiscal,
          tb_Empresa.NmEmpresa,tb_controlefinanceiro.InStatusNotaFiscalEmitida,
          tb_ControleFinanceiro.inDesmembra,
          tb_Pedidos_Faturamento.idpedido,
          tab_cursosagendadosflags.idflag
)
SELECT * FROM tabelaPesq
WHERE Month(Dtfatura) = @mes and YEAR(Dtfatura)= @ano 
------------------------------------------------------
DECLARE @ano int,@mes int,@inTipo char(1)
set @ano = '2014'
SET @mes = '04'
set @inTipo = 'j'

SELECT Min(distinct tb_Parcelas.DtVencimento) As PrimeiroVencimento,
    tb_ControleFinanceiro.matricula,
    CASE WHEN tb_ControleFinanceiroDesmembrado.InTipo = 'F' THEN tb_Aluno.NmAluno ELSE tb_Empresa.NmEmpresa END AS cliente,      
    tb_ControleFinanceiroDesmembrado.idcliente, 
    tb_ControleFinanceiroDesmembrado.DtNota as Dtfatura,
    tb_ControleFinanceiro.IdPedido, 
    tb_ControleFinanceiroDesmembrado.VlTotalDesmembrado as VlTotal, 
    tb_ControleFinanceiroDesmembrado.InTipo, 
    tb_ControleFinanceiroDesmembrado.QtNotaFiscalASerEmitida, 
    tb_Usuario.NmUsuario,
    tb_ControleFinanceiroDesmembrado.InStatusNotaFiscalEmitida,
    tb_ControleFinanceiro.IdControleFinanceiro,
    tb_ControleFinanceiro.inDesmembra,
    tb_ControleFinanceiroDesmembrado.IdControleFinanceiroDesmembrado as IdControleFinancDesmembrado,
    sum(tab_cursosagendadosflags.idflag) as idflag
FROM tb_ControleFinanceiro    
    INNER JOIN tb_ControleFinanceiroDesmembrado ON tb_ControleFinanceiroDesmembrado.matricula = tb_ControleFinanceiro.matricula    
    INNER JOIN tb_Parcelas ON tb_ControleFinanceiroDesmembrado.IdControleFinanceiro = tb_Parcelas.IdControleFinanceiro
    LEFT OUTER JOIN tb_Aluno ON  tb_ControleFinanceiroDesmembrado.IdCliente = tb_Aluno.IdAluno 
    LEFT OUTER JOIN tb_Empresa ON  tb_ControleFinanceiroDesmembrado.IdCliente = tb_Empresa.IdEmpresa 
    LEFT OUTER JOIN tb_Usuario ON  tb_ControleFinanceiro.IdUsuario = tb_Usuario.IdUsuario
    LEFT JOIN tb_alunoagendado ON tb_alunoagendado.Matricula = tb_ControleFinanceiro.Matricula
    LEFT JOIN tab_cursosagendados ON tab_cursosagendados.idcursoagendado = tb_alunoagendado.IdCursoAgendado
    
    LEFT JOIN tab_cursosagendados_Flags ON tab_cursosagendados_Flags.idcursoagendado = tab_cursosagendados.idcursoagendado AND tab_cursosagendados_Flags.idflag = 6 
    
    -- JOIN para identificar apenas os cursos agendados de locação
    LEFT JOIN tab_cursosagendadosFlags ON tab_cursosagendadosFlags.idflag = tab_cursosagendados_Flags.idflag --AND tab_cursosagendados_Flags.idflag = 6
WHERE (
          year(tb_ControleFinanceiroDesmembrado.DtNota) = @ano and 
          month(tb_ControleFinanceiroDesmembrado.DtNota)= @mes
    )
    AND tb_ControleFinanceiroDesmembrado.InStatusNotaFiscalEmitida = 0
    AND tb_ControleFinanceiroDesmembrado.InTipo = @inTipo
    AND tb_ControleFinanceiro.vltotal > 0
GROUP BY 
    tb_ControleFinanceiro.Matricula, 
    tb_Empresa.NmEmpresa, 
    tb_Aluno.NmAluno,
    tb_ControleFinanceiroDesmembrado.IdCliente, 
    tb_ControleFinanceiroDesmembrado.DtNota,
    tb_ControleFinanceiro.IdPedido, 
    tb_ControleFinanceiroDesmembrado.VlTotalDesmembrado, 
    tb_ControleFinanceiroDesmembrado.InTipo, 
    tb_ControleFinanceiroDesmembrado.IdControleFinanceiroDesmembrado,
    tb_ControleFinanceiroDesmembrado.QtNotaFiscalASerEmitida, 
    tb_Usuario.NmUsuario,
    tb_ControleFinanceiroDesmembrado.InStatusNotaFiscalEmitida,
    tb_ControleFinanceiro.IdControleFinanceiro,
    tb_ControleFinanceiro.inDesmembra
    
--verifica tipos da matricula e cursos agendados   
SELECT DISTINCT a.matricula, a.IdCursoAgendado, c.* FROM tb_alunoagendado a
INNER JOIN tab_cursosagendados_flags b ON b.idcursoagendado = a.IdCursoAgendado
INNER JOIN tab_cursosagendadosFlags c ON c.idflag = b.idflag
WHERE a.Matricula in ('6714060621',  '5914070183', '9214070146', '0214070009')

SELECT * FROM tab_cursosagendadosFlags


SELECT * FROM tab_cursosagendados WHERE idcursoagendado = 122348
SELECT * FROM tab_cursosagendados_flags WHERE idcursoagendado = 122348
