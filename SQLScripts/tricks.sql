
Select * from sys.sysobjects
where parent_obj = OBJECT_id('tb_controlefinanceiro')
and xtype = 'tr'


sp_text_object_show tb_solicitacaobolsaestudos
------------------------------------------------
SELECT *,
       OBJECT_NAME(id)
FROM syscomments
WHERE text LIKE '%tb_solicitacaobolsaestudos%';

---------- PAGINACAO ---------------------------
ALTER proc [dbo].[sp_empresa_list] 
(@ini int = '', @fim int = '')
as

SET NOCOUNT ON

	declare @tb_distinct_empresa table(
		nmempresa varchar(300)
	)

	declare @tb_empresa table(
		linhas int,nmempresa varchar(300)
	)
	
	Insert @tb_distinct_empresa
	SELECT distinct nmempresa 
		from tb_empresa
		
	Insert @tb_empresa
	SELECT ROW_NUMBER() OVER(ORDER BY nmempresa asc)as linhas, 
		nmempresa 
		from @tb_distinct_empresa
	delete @tb_distinct_empresa

	if @ini = '' and @fim = ''
		begin
			select distinct nmempresa from @tb_empresa
		end
	else
		begin
			select distinct nmempresa from @tb_empresa
			where linhas between @ini and @fim
		end

set nocount OFF






--------------------------------
Select * from impacta4..tb_ecommercecliente  
where cidade_cli like '%guarulhos%' and bairro_cli not like 'cumbica' and sexo_cli = 'F' and LEN(senha_cli) > 8 -- até registro 29

Select * from impacta4..tb_ecommercecliente  
where cod_cli = 16340

--cod_cli in(6250, 16340, 105626)




