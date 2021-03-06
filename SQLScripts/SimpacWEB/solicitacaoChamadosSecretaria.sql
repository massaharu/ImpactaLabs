-- Matricula juridica teste: 9714070296, 7014070423

]USE Chamados
------------------------------------------------ 
SELECT * from Chamados..tb_chamados
where idsolicitante in(
		SELECT  idusuario FROM Simpac..tb_usuario a
		INNER JOIN Simpac..tb_depto b
		ON b.Iddepto = a.IdDepto
		WHERE b.DesDepartamento = 'corporativo' --or
			  --b.DesDepartamento like '%negocios%' or
			 -- b.DesDepartamento like '%secretaria%' 
	)
	--and deschamado like '%alteração%' 
	--and deschamado like '%certificado%' 
	and deschamado like '%presença%'


USE Simpac
SELECT * FROM Simpac..tb_usuario where IdUsuario = 115
SELECT * FROM Simpac..tb_usuario where NmCompleto like '%Juliana%'
SELECT * FROM tb_depto where Iddepto = 7
SELECT * FROM sp_spaceused tb_historicosecretaria
SELECT TOP 200 * FROM tb_historicosecretaria ORDER BY idhistorico DESC
SELECT TOP 200 * FROM tb_historicosecretaria where DesHistorico like '%justificativa%'
SELECT * FROM tb_controlefinanceiro_alterados where matricula = '9213100173'
select * from tb_cancelamentosac where Matricula = '9213100173'
SELECT * FROM tb_alunoagendado where Matricula = '6714060166'
------------------------------------------------------------------------------
SELECT top 100 * FROM tb_alunoagendado order by IdAlunoAgendado desc
select * from tab_cursosagendados_datas
SELECT * FROM tb_cursosagendados where dtinicio is null and desobs not like '%treinamento em aberto%' IdCursoAgendado = 62120
SELECT * FROM tb_alunoagendado --where idalunoagendado = 1420844 where IdCursoAgendado = 111549 and IdAluno =370096 --'9911073368 -- 9211064467          
where matricula = '9213100173'
Select * from tb_Matriculas WHERE matricula = '9213100173'

select * from tb_alunoagendado
where Matricula = '5312121167' and 
IdAluno = 712727

select Matricula, IdAluno, COUNT(*) from tb_alunoagendado 
group by  Matricula, IdAluno 
having COUNT(*) >  1

select idcursoagendado, idaluno, COUNT(*) from tb_alunoagendado 
group by idcursoagendado, idaluno 
having COUNT(*) >  1

where idaluno = 916544
-- IdAluno = 968893 and IdCursoAgendado = 108321

SELECT top 200  * FROM tb_alunoagendado order by idalunoagendado desc
SELECT * FROM tb_alunoagendado WHERE idalunoagendado = 1462507
SELECT * FROM tb_controlefinanceiro where Matricula = '4313011050' --em aberto 5913011101
SELECT * FROM tb_cursosagendados where IdCursoAgendado = 1479299
SELECT * FROM tb_cursos where idcurso = 2539
SELECT * FROM tb_aluno where IdAluno = 983602 --NmAluno like 'massaharu%'--IdAluno = 965937
SELECT * FROM tb_aluno_alterados where IdAluno = 573497 
SELECT * FROM tb_aluno_alterados where idaluno = 964781--NmAluno like 'massaharu%' 
SELECT * FROM tb_alunoagendado where Matricula = '9213100173'
SELECT * FROM tb_alunoagendado where idcursoagendado = 1207797 
SELECT * FROM tb_alunoagendado where idalunoagendado = 1490374 
SELECT * FROM tb_AlunoAgendado_Alterados where idalunoagendado = 1490374 
SELECT * FROM tb_alunoempresa where Matricula = '9213100173'
SELECT * FROM tb_AlunoEmpresa where IdAlunoAgendado = 1207797
SELECT * FROM tb_empresa
sp_alunoempresa_get '5913011101'
sp_empresa_get 485715
sp_alunos_list_matricula '6714060619'
SELECT * FROM tb_alunoagendado 
WHERE DesComentario != '' AND DesComentario != 'REPOSIÇÃO' AND DesComentario NOT LIKE '%SimpacWeb auto%'

UPDATE tb_solicitacaocorp 
SET instatus = 0
WHERE idsolicitacaocorp = 53

select * from tb_aluno
where NmAluno like '3 participantes%'
order by DtCadastramento desc

--
select * from tb_solicitacaocorp where matricula = '5913011101'--innfalterado = 1 and instatus = 0
select * from tb_solicitacaocorp_alunoalterado
select * from tb_solicitacaocorp_reagendamento where idsolicitacaocorp = 67
select * from tb_solicitacaocorp_nffaturamentoalterado

select * from tb_alunoagendado where idalunoagendado = 1483973
select * from tb_alunoagendado_alterados where idalunoagendado = 1483973

select * from tb_aluno where IdAluno = 614633
select * from tb_alunoagendado where IdAlunoAgendado = 1487303
select * from tb_alunoagendado_alterados where IdAlunoAgendado = 1487303
select * from tb_CursosAgendados where IdCursoAgendado = 107529
select * from tb_cursos where IdCurso =  1444
SELECT TOP 1000 * FROM tb_HistoricoSecretaria ORDER BY idHistorico desc

select * from tb_NotaFiscal_Faturamento where Matricula = '9213100173'
select * from tb_NotaFiscal_Faturamento_Alterados where Matricula = '9213100173'

select * from tb_alunoagendado_alterados

sp_alunoempresa_get 9713090023

SELECT * FROM tb_solicitacaocorp where idsolicitante = 1495
SELECT * FROM tb_solicitacaocorp where idsolicitacaocorp = 2793
SELECT * FROM tb_solicitacaocorp_alunoalterado where idsolicitacaocorp = 2802
SELECT * FROM tb_solicitacaocorp_reagendamento where idsolicitacaocorp = 2795
SELECT * FROM tb_alunoagendado where matricula = '6714030273'
SELECT * FROM tb_cursosagendados where 
SELECT * FROM tb_alunoagendado where DesComentario <> ''
SELECT * FROM tb_alunoagendado where idalunoagendado = 1599108

SELECT * FROM tb_controlefinanceiro where IdControleFinanceiro = 295002
SELECT * FROM tb_controlefinanceiro where Matricula = '6714030273'
SELECT * FROM tb_pedidoparcela
SELECT * FROM tb_parcelas where IdControleFinanceiro = 295002
SELECT * FROM tb_cursos
exec vendas..sp_pessoabymatricula_get '6714030273'
exec vendas..sp_creditomatricula_get '6714030273'

SELECT * FROM tb_matriculas WHERE matricula = '6714050428'
SELECT * FROM tb_controleFinanceiro WHERE Matricula = '6714050428'
SELECT * FROM tb_pedidos WHERE IdPedido = 858572-15000
SELECT * FROM tb_PedidoCursos where IdPedido = 850944
SELECT * FROM tb_pedidoparcela WHERE IdPedido = 850944
SELECT * FROM tb_alunoagendado where Matricula = '6714050428'
SELECT * FROM tb_Proposta


UPDATE tb_solicitacaocorp
set instatus = 0
WHERE idsolicitacaocorp = 2795

where Matricula in (
select  matricula, COUNT(*)  from tb_NotaFiscal_Faturamento
group by matricula
having COUNT(*) >1)
order by DtCadastro 

select matricula, COUNT(*)  from tb_controleFinanceiro 
group by matricula
having COUNT(*) >1

select IdAlunoAgendado, COUNT(*)
FROM tb_alunoempresa 
group by IdAlunoAgendado
HAVING COUNT(*) > 1

select IdAlunoAgendado, COUNT(*)
FROM tb_alunoagendado
group by IdAlunoAgendado
HAVING COUNT(*) > 1

select * from tb_aluno where LEN(num) > 20

select * from tb_NotaFiscal_Faturamento where Matricula = '9713080165'
select * from tb_NotaFiscal_Faturamento_alterados 
select * from tb_NotaFiscal_Faturamento order by IdRegistro desc


sp_text_object_show sp_notafiscal_edit
sp_notafiscal_edit 
'9211064467', 'BARAO DE PIRACICABA', '01216-010', 'C ELISEOS', 'SAO PAULO', 'SP', 
'BARAO DE PIRACICABA', 'C ELISEOS', 'SAO PAULO', 'SP', '01216-010', 'Fernando Fernando', 
'3366-8721', '', 'luisfernando.melo@portoseguro.com.br', '', 'BARAO DE PIRACICABA', 
'AL', '740', 'asdasd', 'luisfernando.melo@portoseguro.com.br', ''

sp_text_object_show sp_NotasMatricula '9213060192'
sp_text_object_show sp_NotaFiscalFaturamentoEnderecosLocaliza '5913060190'
sp_agendamentos_list_matricula '9211064467'

SELECT Matricula, count(idaluno) as 'qtd'
FROM tb_alunoagendado
GROUP BY matricula
ORDER BY qtd

SELECT Matricula, COUNT(idalunoagendado) as 'qtd'
from tb_AlunoEmpresa
group by Matricula
order by qtd desc

SELECT * FROM simpac..tb_usuario 
sp_agendamentos_list_matricula '0413030782'

sp_text_object_show sp_orcamentototaltreinamentos_list
sp_text_object_show sp_agendamentos_list_matricula
sp_text_object_show sp_alunos_list_matricula

SELECT * FROM Simpac..tb_usuario 
where Sexo = 'F' and NmCompleto like '%Juliana Mara%' 
sp_text_object_show sp_agendamentos_list_matricula

sp_text_object_show sp_cursosagendadosemaberto_get 1614, 4


select* from tb_cursos where DesCurso like '%java%'
select * from tb_Periodo
-- Treinamentos
-- - Alteração da data
-- - Agendamento

-- Aluno 
-- - Troca de turmas
-- - Alteração dos dados


-- Certificado
-- - Emissao

3013030716

sp_NotaFiscalFaturamentoEnderecosLocaliza 9713090008

--------------------------------------------------------------------------------
------------------- PROCEDURES --------------------------------------------------
-----------------------------------------------------------------------------
CREATE proc sp_alunoempresa_get
(@matricula varchar(20))
as
begin
	select top 1 idalunoagendado
		, idaluno
		, idempresa
		, idcursoagendado
		, matricula
	from tb_alunoempresa
	where matricula = @matricula
end
-----------------------------------------------------------------------------
CREATE PROC sp_cursoagendadonaoiniciados_list 1614
(@idcurso int)
AS
/*
app: SimpacWeb
url: /simpacweb/modulos/corporativo/solicitacaocorporativa/..
data: 2013-06-21
author: Massaharu
*/
BEGIN
	SELECT idcursoagendado, * from tb_cursosagendados
	WHERE Dtinicio > GETDATE() AND
		  IDCurso = @idcurso
	ORDER BY dtinicio
END
---------------------------------------------------------
CREATE PROC sp_cursosagendadosemaberto_list 1614
(
@idcurso INT
)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.cursoagendado.php
data: 14/06/2013 16:31
author: Massaharu
*/

select a.idcursoagendado from tab_cursosagendados a 
inner join tab_cursosagendados_flags b on a.idcursoagendado = b.idcursoagendado
inner join tab_cursosagendados_datas c on a.idcursoagendado = c.idcursoagendado
where idflag = 1 and idcurso = @idcurso 
-----------------------------------------------------------
CREATE PROC sp_alunos_list_matricula '5913011101'
(
@matricula udt_matricula
)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.matricula.php
data: 16/06/2013 07:08:43
author: Massaharu
*/

select distinct idaluno from tb_alunoagendado where matricula = @matricula
----------------------------------------------------------------------------------
ALTER PROC sp_alunoagendadoalterados_get
(@idalunoagendado int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massaharu
description: Retorna o numero de solicitacoes aprovadas e pendentes
*/
BEGIN
	SELECT idlancamento
		, idalunoagendado
		, idcursoagendado
		, idaluno
		, idusuario
		, descomentario
		, dtcadastramento
		, inemissaocartaaviso
		, instatus
		, idmidia
		, idcontrolefinanceiro
		, matricula
		, nrfalta
		, infinanceiro
		, idfechamento
		, naoreplicar
		, dtcadastro
		, usuario
	FROM tb_alunoagendado_alterados
	WHERE IdAlunoAgendado = @idalunoagendado
	ORDER BY dtcadastro DESC
END

select COUNT(*) from tb_alunoagendado_alterados
group by idalunoagendado

select * from tb_AlunoAgendado_Alterados where idalunoagendado = 1483973
--------------------------------------------------------------------------------
ALTER PROC sp_alunoalterados_get 
(@idaluno int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massaharu
description: Retorna o alunoalterado pelo id do aluno
*/
BEGIN
	SELECT 
		idregistro
		, idaluno
		, nmaluno
		, dtnascimento
		, nrrg
		, nrcpf
		, desendereco
		, desbairro
		, descidade
		, sgestado
		, nrcep
		, cdemail
		, nrtelefoneresidencial
		, nrtelefonecomercial
		, nrcelular
		, dtcadastramento
		, dessexo
		, cdemailempresa
		, num
		, complemento
		, ddd_residencial
		, naoreplicar
		, usuario
		, endereco
		, tipoendereco
		, dtalterado
	FROM tb_aluno_alterados
	WHERE idaluno = @idaluno
	ORDER BY dtcadastramento DESC
END
--------------------------------------------------------------------------------
------------------- TRIGGER-----------------------------------------------------
--------------------------------------------------------------------------------
CREATE TRIGGER TRG_NotaFiscal_Faturamento
On [dbo].[tb_NotaFiscal_Faturamento]
FOR DELETE,UPDATE
AS
/*
data: 16/06/2013 07:08:43
author: Massaharu
description: Trigger que salva o historico de alteracoes e exclusoes da tabela tb_NotaFiscal_Faturamento
*/
INSERT INTO tb_NotaFiscal_Faturamento_Alterados (IdRegistro, Matricula, Endereco, 
CEP, Bairro, Cidade, Estado, EnderecoEntrega, BairroEntrega, CidadeEntrega, 
EstadoEntrega, CEPEntrega, Contato, Fone, Fax, Email, OBS, DtCadastro, 
Usuario, EnderecoNF, TipoEndereco, NumeroEndereco, Complemento, EmailNF, NrInscricaoMunicipal)

Select IdRegistro, Matricula, Endereco, 
CEP, Bairro, Cidade, Estado, EnderecoEntrega, BairroEntrega, CidadeEntrega, 
EstadoEntrega, CEPEntrega, Contato, Fone, Fax, Email, OBS, DtCadastro, 
Usuario, EnderecoNF, TipoEndereco, NumeroEndereco, Complemento, EmailNF, NrInscricaoMunicipal  from DELETED

--------------------------------------------------------------------------------
------------------- FUNCTIONS --------------------------------------------------
-----------------------------------------------------------------------------
ALTER FUNCTION fn_solicitacaoCorpFinalizadosCount
(@idusuario int)
RETURNS  
@count TABLE(
	instatus int,
	finalizado int
)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massaharu
description: Retorna o numero de solicitacoes aprovadas e pendentes
*/
BEGIN
	IF @idusuario != 0
	BEGIN
		INSERT @count
		SELECT instatus, COUNT(*) as 'finalizado' FROM tb_solicitacaocorp
		WHERE idsolicitante = @idusuario AND invisivel = 1
		GROUP BY instatus
		ORDER BY instatus
	END
	ELSE
	BEGIN
		INSERT @count
		SELECT instatus, COUNT(*) as 'finalizado' FROM tb_solicitacaocorp
		WHERE invisivel = 1
		GROUP BY instatus
		ORDER BY instatus
	END
	
	RETURN
END

select * from tb_solicitacaocorp

--select * FROM dbo.fn_solicitacaoCorpFinalizadosCount(1495)
-----------------------------------------------------------
---------- TABELAS ----------------------------------------
-----------------------------------------------------------
CREATE TABLE tb_NotaFiscal_Faturamento_Alterados(
	idnffaturamentoalterado int identity CONSTRAINT PK_NotaFiscal_Faturamento_Alterados PRIMARY KEY(idnffaturamentoalterado),
	IdRegistro int, 
	Matricula varchar(20), 
	Endereco varchar(100), 
	CEP varchar(10), 
	Bairro varchar(100), 
	Cidade varchar(100), 
	Estado char(2), 
	EnderecoEntrega varchar(100), 
	BairroEntrega varchar(100), 
	CidadeEntrega varchar(100), 
	EstadoEntrega char(2), 
	CEPEntrega varchar(10), 
	Contato varchar(100), 
	Fone varchar(30), 
	Fax varchar(30), 
	Email varchar(150), 
	OBS varchar(3000), 
	DtCadastro datetime, 
	Usuario varchar(100), 
	EnderecoNF varchar(50), 
	TipoEndereco char(3), 
	NumeroEndereco char(10), 
	Complemento varchar(50), 
	EmailNF varchar(150), 
	NrInscricaoMunicipal char(20)
)
-----------------------------------------------------------
CREATE TABLE tb_solicitacaocorp(
	idsolicitacaocorp int identity CONSTRAINT PK_solicitacaocorp primary key(idsolicitacaocorp),
	matricula varchar(20) not null,
	idsolicitante int not null,
	idsolicitado int CONSTRAINT DF_solicitacaocorp_idsolicitado DEFAULT(NULL),
	idalunoagendado int null,
	inalunoalterado bit CONSTRAINT DF_solicitacaocorp_inalunoalterado DEFAULT(0),
	incertificado bit CONSTRAINT DF_solicitacaocorp_incertificado DEFAULT(0),
	inlistapresenca bit CONSTRAINT DF_solicitacaocorp_inlistapresenca DEFAULT(0),
	innfalterado bit CONSTRAINT DF_solicitacaocorp_innfalterado DEFAULT(0),
	intreinamentoalterado bit CONSTRAINT DF_solicitacaocorp_intreinamentoalterado DEFAULT(0),
	instatus bit CONSTRAINT DF_solicitacaocorp_instatus DEFAULT(0),
	dtalteracao datetime CONSTRAINT DF_solicitacaocorp_dtalteracao DEFAULT(getdate()),	
	dtcadastro datetime CONSTRAINT DF_solicitacaocorp_dtcadastro DEFAULT(getdate())	
	 
	CONSTRAINT FK_solicitacaocorp_usuario_idsolicitante FOREIGN KEY(idsolicitante)
	REFERENCES tb_usuario(idusuario),
	CONSTRAINT FK_solicitacaocorp_usuario_idsolicitado FOREIGN KEY(idsolicitado)
	REFERENCES tb_usuario(idusuario)
)
ALTER TABLE tb_solicitacaocorp
ADD invisivel bit CONSTRAINT DF_solicitacaocorp_invisivel DEFAULT(1)
UPDATE tb_solicitacaocorp
SET invisivel = 1

ALTER TABLE tb_solicitacaocorp
ADD inalunodesmembrado bit CONSTRAINT DF_solicitacaocorp_inalunodesmembrado DEFAULT(0)
UPDATE tb_solicitacaocorp
SET inalunodesmembrado = 0

ALTER TABLE tb_solicitacaocorp
ADD inalunodesagendado bit CONSTRAINT DF_solicitacaocorp_indesagendado DEFAULT(0)
UPDATE tb_solicitacaocorp
SET inalunodesagendado = 0

ALTER TABLE tb_solicitacaocorp
ADD incadimpactaonline bit CONSTRAINT DF_solicitacaocorp_incadimpactaonline DEFAULT(0)
UPDATE tb_solicitacaocorp
SET incadimpactaonline = 0

ALTER TABLE tb_solicitacaocorp
ADD intreinamentoreposicao bit CONSTRAINT DF_solicitacaocorp_intreinamentoreposicao DEFAULT(0)
UPDATE tb_solicitacaocorp
SET intreinamentoreposicao = 0

ALTER TABLE tb_solicitacaocorp
ADD intreinamentotransfer bit CONSTRAINT DF_solicitacaocorp_intreinamentotransfer DEFAULT(0)
UPDATE tb_solicitacaocorp
SET intreinamentotransfer = 0

ALTER TABLE tb_solicitacaocorp
ADD introcaaluno bit CONSTRAINT DF_solicitacaocorp_introcaaluno DEFAULT(0)
UPDATE tb_solicitacaocorp
SET introcaaluno = 0

SELECT * FROM tb_solicitacaocorp
--UPDATE tb_solicitacaocorp
--SET incadimpactaonline = 1
--WHERE inalunoalterado = 0 AND
--	incertificado = 0 AND
--	inlistapresenca = 0 AND
--	innfalterado = 0 AND 
--	intreinamentoalterado = 0 AND
--	inalunodesmembrado = 0 AND
--	inalunodesagendado = 0 AND
--	incadimpactaonline = 0

--UPDATE tb_solicitacaocorp
SET instatus = 0
WHERE idsolicitacaocorp = 2864
--delete from tb_solicitacaocorp

SELECT * FROM tb_solicitacaocorp

-----------------------------------------------------------
CREATE TABLE tb_solicitacaocorp_alunoalterado(
	idalunoalterado int identity CONSTRAINT PK_solicitacaocorp_alunoalterado primary key(idalunoalterado),
	idsolicitacaocorp int not null,
	desemail varchar(100),
	desemailempresa varchar(75), 
	descomplemento nvarchar(100), 
	desaluno varchar(100),  
	desbairro varchar(50), 
	descidade varchar(50), 
	desendereco varchar(100), 
	dessexo char(1), 
	dtnascimento datetime,
	idaluno int not null, 
	idalunoagendado int not null,
	nrcelular varchar(50), 
	nrcep varchar(10), 
	nrcpf varchar(50), 
	nrrg varchar(50), 
	nrtelefonecomercial varchar(50), 
	nrtelefoneresidencial varchar(50), 
	nr varchar(20), 
	desestadosigla char(2),
	desenderecotipo char(3), 
	instatus bit CONSTRAINT DF_solicitacaocorp_alunoalterado_instatus DEFAULT(1),
	dtcadastro datetime CONSTRAINT DF_solicitacaocorp_alunoalterado_dtcadastro DEFAULT(getdate())	
	
	CONSTRAINT FK_solicitacaocorp_alunoalterado_idsolicitacaocorp FOREIGN KEY(idsolicitacaocorp)
	REFERENCES  tb_solicitacaocorp(idsolicitacaocorp) ON DELETE CASCADE
)

ALTER TABLE tb_solicitacaocorp_alunoalterado  
ALTER COLUMN idalunoagendado int null

SELECT * FROM tb_solicitacaocorp_alunoalterado 
---------------------------------------------------------------------------------------
CREATE TABLE tb_solicitacaocorp_reagendamento(
	idreagendamento int identity CONSTRAINT PK_solicitacaocorp_reagendamento PRIMARY KEY(idreagendamento),
	idsolicitacaocorp int not null,
	idcursoagendadoatual int not null,
	idcursoagendadonovo int,
	idalunoagendado int not null,
	instatus bit CONSTRAINT DF_solicitacaocorp_reagendamento_instatus DEFAULT(1),
	dtcadastro datetime CONSTRAINT DF_solicitacaocorp_reagendamento_dtcadastro DEFAULT(getdate())	
	
	CONSTRAINT FK_solicitacaocorp_reagendamento_idsolicitacaocorp FOREIGN KEY(idsolicitacaocorp)
	REFERENCES  tb_solicitacaocorp(idsolicitacaocorp) ON DELETE CASCADE
)

ALTER TABLE tb_solicitacaocorp_reagendamento
ADD desmotivo varchar(1000)

ALTER TABLE tb_solicitacaocorp_reagendamento
ADD idtipoagendamento int

UPDATE tb_solicitacaocorp_reagendamento
SET idtipoagendamento = 1

-- 1 = reagendamento
-- 2 = desagendamento
-- 3 = reposição

SELECT * FROM tb_solicitacaocorp_reagendamento WHERE idsolicitacaocorp = 2778
---------------------------------------------------------------------------------------
CREATE TABLE tb_solicitacaocorp_nffaturamentoalterado(
	idnffaturamentoalterado int identity CONSTRAINT PK_solicitacaocorp_nffaturamentoalterado PRIMARY KEY(idnffaturamentoalterado ), 
	idsolicitacaocorp int not null,
	matricula varchar(20), 
	desendereco varchar(100), 
	descep varchar(10), 
	desbairro varchar(100), 
	descidade varchar(100), 
	desestado varchar(2), 
	desenderecoentrega varchar(100), 
	desbairroentrega varchar(100), 
	descidadeentrega varchar(100), 
	desestadoentrega varchar(2), 
	descepentrega varchar(10), 
	descontato varchar(100), 
	desfone varchar(30), 
	desfax varchar(30), 
	desemail varchar(150), 
	desobs varchar(3000), 
	dtcadastro datetime CONSTRAINT DF_solicitacaocorp_nffaturamentoalterado_dtcadastro DEFAULT(getdate()), 
	desendereconf varchar(50), 
	desenderecotipo char(3), 
	nrendereco char(10), 
	descomplemento varchar(50), 
	desemailnf varchar(150), 
	nrinscricaomunicipal char(20),
	instatus bit CONSTRAINT DF_solicitacaocorp_nffaturamentoalterado_instatus DEFAULT(1)
	
	CONSTRAINT FK_solicitacaocorp_nffaturamentoalterado_idsolicitacaocorp FOREIGN KEY(idsolicitacaocorp)
	REFERENCES  tb_solicitacaocorp(idsolicitacaocorp) ON DELETE CASCADE
)
-----------------------------------------------------------------------------------------
CREATE TABLE tb_solicitacaocorp_alunodesmembrado(
	idalunodesmembrado int identity CONSTRAINT PK_solicitacaocorp_alunodesmembrado PRIMARY KEY(idalunodesmembrado),
	idsolicitacaocorp int not null,
	idaluno int  not null,
	idalunoagendado int  not null,
	nralunos int,
	instatus bit CONSTRAINT DF_solicitacaocorp_alunodesmembrado_instatus DEFAULT(1)
	
	CONSTRAINT FK_solicitacaocorp_alunodesmembrado_idsolicitacaocorp FOREIGN KEY(idsolicitacaocorp)
	REFERENCES  tb_solicitacaocorp(idsolicitacaocorp) ON DELETE CASCADE
)
ALTER TABLE tb_solicitacaocorp_alunodesmembrado ADD 
idempresa int,
dtcadastro datetime CONSTRAINT DF_solicitacaocorp_alunodesmembrado_dtcadastro DEFAULT(getdate())

ALTER TABLE tb_solicitacaocorp_alunodesmembrado  
ALTER COLUMN idalunoagendado int null
-----------------------------------------------------------------------------------------
CREATE TABLE tb_solicitacaocorp_transferencia(
	idtreinamentotransferencia int IDENTITY CONSTRAINT PK_solicitacaocorp_transferencia PRIMARY KEY (idtreinamentotransferencia),
	idsolicitacaocorp int not null,
	incortesia bit,
	descursosantigos varchar(1000),
	descursosnovos varchar(1000),
	idcursosagendadosnovos varchar(500),
	idcursosantigos varchar(500),
	idcursosnovos varchar(500),
	idpedido int,
	matricula varchar(20),
	inneworcamento bit,
	qtdeparcela int,
	inreposicao bit,
	vlrcursosantigos varchar(100),
	vlrcursosnovos varchar(100),
	vlrorcamentoantigo money,
	vlrorcamentodiferenca money,
	vlrorcamentonovo money
	
	CONSTRAINT FK_solicitacaocorp_transferencia_idsolicitacaocorp FOREIGN KEY(idsolicitacaocorp)
	REFERENCES  tb_solicitacaocorp(idsolicitacaocorp) ON DELETE CASCADE
)

ALTER TABLE tb_solicitacaocorp_transferencia ADD
instatus bit CONSTRAINT DF_solicitacaocorp_transferencia_instatus DEFAULT 1

ALTER TABLE tb_solicitacaocorp_transferencia
ADD desmotivo varchar(1000)

ALTER TABLE tb_solicitacaocorp_transferencia
ADD idalunosagendadosantigos varchar(500)

ALTER TABLE tb_solicitacaocorp_transferencia
ADD idcursosagendadosantigos varchar(500)
--
select * from tb_solicitacaocorp
select * from tb_solicitacaocorp_alunoalterado
select * from tb_solicitacaocorp_reagendamento
select * from tb_solicitacaocorp_nffaturamentoalterado
select * from tb_solicitacaocorp_alunodesmembrado
select * from tb_solicitacaocorp_transferencia
--
--drop table tb_solicitacaocorp
--drop table tb_solicitacaocorp_alunoalterado
--drop table tb_solicitacaocorp_reagendamento
--drop table tb_solicitacaocorp_nffaturamentoalterado
-----------------------------------------------------------------------------------------
CREATE TABLE tb_solicitacaocorp_trocaaluno(
	idtrocaaluno int IDENTITY CONSTRAINT pk_solicitacaocorp_trocaaluno PRIMARY KEY(idtrocaaluno),
	idsolicitacaocorp int NOT NULL,
	idalunoto int,
	idsalunoagendado varchar(500)
	
	CONSTRAINT FK_solicitacaocorp_trocaaluno_idsolicitacaocorp FOREIGN KEY (idsolicitacaocorp)
	REFERENCES tb_solicitacaocorp(idsolicitacaocorp) ON DELETE CASCADE
	
	ALTER TABLE tb_solicitacaocorp_trocaaluno ADD
	desmotivo varchar(1000)
)
-----------------------------------------------------------------------------------------
CREATE TABLE tb_solicitacaocorp_reserva(
	idreserva int,
	idsolicitacaocorp int
	
	CONSTRAINT PK_solicitacaocorp_reserva_idreserva_idsolicitacaocorp PRIMARY KEY(idreserva, idsolicitacaocorp)
	CONSTRAINT FK_solicitacaocorp_reserva_idreserva FOREIGN KEY (idreserva)
	REFERENCES tb_reserva(idreserva) ON DELETE CASCADE,
	CONSTRAINT FK_solicitacaocorp_reserva_idsolicitacaocorp FOREIGN KEY (idsolicitacaocorp)
	REFERENCES tb_solicitacaocorp(idsolicitacaocorp) ON DELETE CASCADE

)
SELECT * FROM Ecommerce..tb_LojaVirtualRecibo
SELECT * FROM Ecommerce..tb_pagamento
SELECT * FROM Ecommerce..tb_pagamentopedidoparcela
SELECT * FROM Simpac..tb_PedidoParcela

SELECT * FROM tb_Reserva where IdUsuario = 1495
SELECT * FROM tb_solicitacaocorp where idsolicitante = 1495
SELECT * FROM tb_solicitacaocorp where idsolicitacaocorp = 5230
SELECT * FROM tb_solicitacaocorp_trocaaluno where idsolicitacaocorp = 5204
SELECT * FROM tb_solicitacaocorp_reagendamento where idsolicitacaocorp = 5190
SELECT * FROM tb_solicitacaocorp_transferencia where idsolicitacaocorp = 5286

SELECT * FROM tb_solicitacaocorp_alunodesmembrado
SELECT * FROM tb_alunoagendado where IdAlunoAgendado = 1672653
SELECT * FROM tb_controlefinanceiro where Matricula = '9214110004'
SELECT * FROM tb_AlunoEmpresa where Matricula = '9214110004'
SELECT * FROM tb_empresa WHERE IdEmpresa = 395951
select * fROM tb_Aluno where IdAluno = 997763
SELECT * FROM tb_alunoagendado where Matricula = '9214110004'
SELECT * FROM tb_alunoagendado where IdCursoAgendado = 125039

sp_alunoagendado_alteradoslast_get 1671772

SELECT * FROM tb_aluno where IdAluno = 370096

SELECT * FROM tb_usuario where iddepto = 19
SELECT * FROM tb_solicitacaocorp where idsolicitacaocorp = 5265
SELECT * FROM tb_alunoagendado 
WHERE IdAlunoAgendado in(
	SELECT IdAlunoAgendado FROM tb_reserva
	WHERE IdReserva in(364497)
)

sp_solicitacaocorp_reserva_get 5297

--DELETE tb_solicitacaocorp_reserva
--WHERE idreserva in (364497)
--GO
--UPDATE tb_reserva
--SET InStatus = 0
--WHERE IdReserva in (364497)
--GO
--DELETE tb_alunoagendado 
--WHERE IdAlunoAgendado in(
--	SELECT IdAlunoAgendado FROM tb_reserva
--	WHERE IdReserva in(364497)
--)


sp_cursoagendadolalunos_list2 125039

SELECT  aa.email_cli
					FROM impacta4.dbo.tb_EcommerceCliente aa
					WHERE aa.cpf_cli = ''


--UPDATE tb_reserva
SET InStatus = 0
where IdUsuario = 1495

SELECT * FROM tb_alunoagendado WHERE IdCursoAgendado = 124389

SELECT * FROM tb_AlunoEmpresa where IdAluno = 370096
SELECT * FROM tb_reserva where IdUsuario = 1495


SELECT * FROM tb_cursosagendados where idcursoagendado = 124389

SELECT * FROM tb_solicitacaocorp_reserva
------------------------------------------------------------------------------------
------------------------------------------------------------------------------------
---------- PROCEDURES --------------------------------------------------------------
------------------------------------------------------------------------------------
ALTER PROC sp_solicitacaocorp_save
(
	@idsolicitacaocorp int,
	@matricula varchar(20), 
	@idsolicitante int, 
	@idsolicitado int, 
	@idalunoagendado int, 
	@inalunoalterado bit, 
	@incertificado bit, 
	@inlistapresenca bit, 
	@innfalterado bit, 
	@intreinamentoalterado bit,
	@inalunodesmembrado bit,
	@inalunodesagendado bit,
	@incadimpactaonline bit,
	@instatus bit,
	@intreinamentoreposicao bit,
	@intreinamentotransfer bit,
	@introcaaluno bit 
)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massaharu
description: Salva e atualiza a tabela tb_solicitacaocorp
*/
BEGIN
	SET NOCOUNT ON
	
	--IF @introcaaluno IS NULL
	--BEGIN
	--	IF EXISTS(SELECT idsolicitacaocorp FROM tb_solicitacaocorp WHERE idsolicitacaocorp = @idsolicitacaocorp)
	--		BEGIN 
	--			UPDATE tb_solicitacaocorp
	--			SET matricula = @matricula, 
	--				idsolicitante = @idsolicitante, 
	--				idsolicitado = @idsolicitado, 
	--				idalunoagendado = @idalunoagendado,
	--				inalunoalterado = @inalunoalterado, 
	--				incertificado = @incertificado, 
	--				inlistapresenca = @inlistapresenca, 
	--				innfalterado = @innfalterado, 
	--				intreinamentoalterado = @intreinamentoalterado,
	--				inalunodesmembrado = @inalunodesmembrado,
	--				inalunodesagendado = @inalunodesagendado,
	--				incadimpactaonline = @incadimpactaonline,
	--				intreinamentoreposicao = @intreinamentoreposicao,
	--				introcaaluno = 0,
	--				instatus = @instatus,
	--				dtalteracao = getdate()
	--			WHERE idsolicitacaocorp = @idsolicitacaocorp
			
	--			SET NOCOUNT OFF			
	--			SELECT @idsolicitacaocorp AS idsolicitacaocorp
	--		END
	--	ELSE
	--		BEGIN
	--			INSERT INTO tb_solicitacaocorp
	--			(
	--				matricula, 
	--				idsolicitante, 
	--				idsolicitado, 
	--				idalunoagendado,
	--				inalunoalterado, 
	--				incertificado, 
	--				inlistapresenca, 
	--				innfalterado, 
	--				intreinamentoalterado,
	--				inalunodesmembrado,
	--				inalunodesagendado,
	--				incadimpactaonline,
	--				intreinamentoreposicao,
	--				introcaaluno
	--			)VALUES(
	--				@matricula, 
	--				@idsolicitante, 
	--				@idsolicitado, 
	--				@idalunoagendado,
	--				@inalunoalterado, 
	--				@incertificado, 
	--				@inlistapresenca, 
	--				@innfalterado, 
	--				@intreinamentoalterado,
	--				@inalunodesmembrado,
	--				@inalunodesagendado,
	--				@incadimpactaonline,
	--				@intreinamentoreposicao,
	--				@introcaaluno
	--			)
	--			SET NOCOUNT OFF			
	--			SELECT SCOPE_IDENTITY() as idsolicitacaocorp		
	--		END
	--END
	--ELSE
	--BEGIN
		IF EXISTS(SELECT idsolicitacaocorp FROM tb_solicitacaocorp WHERE idsolicitacaocorp = @idsolicitacaocorp)
			BEGIN 
				UPDATE tb_solicitacaocorp
				SET matricula = @matricula, 
					idsolicitante = @idsolicitante, 
					idsolicitado = @idsolicitado, 
					idalunoagendado = @idalunoagendado,
					inalunoalterado = @inalunoalterado, 
					incertificado = @incertificado, 
					inlistapresenca = @inlistapresenca, 
					innfalterado = @innfalterado, 
					intreinamentoalterado = @intreinamentoalterado,
					inalunodesmembrado = @inalunodesmembrado,
					inalunodesagendado = @inalunodesagendado,
					incadimpactaonline = @incadimpactaonline,
					intreinamentoreposicao = @intreinamentoreposicao,
					intreinamentotransfer = @intreinamentotransfer,
					introcaaluno = @introcaaluno,
					instatus = @instatus,
					dtalteracao = getdate()
				WHERE idsolicitacaocorp = @idsolicitacaocorp
			
				SET NOCOUNT OFF			
				SELECT @idsolicitacaocorp AS idsolicitacaocorp
			END
		ELSE
			BEGIN
				INSERT INTO tb_solicitacaocorp
				(
					matricula, 
					idsolicitante, 
					idsolicitado, 
					idalunoagendado,
					inalunoalterado, 
					incertificado, 
					inlistapresenca, 
					innfalterado, 
					intreinamentoalterado,
					inalunodesmembrado,
					inalunodesagendado,
					incadimpactaonline,
					intreinamentoreposicao,
					intreinamentotransfer,
					introcaaluno
				)VALUES(
					@matricula, 
					@idsolicitante, 
					@idsolicitado, 
					@idalunoagendado,
					@inalunoalterado, 
					@incertificado, 
					@inlistapresenca, 
					@innfalterado, 
					@intreinamentoalterado,
					@inalunodesmembrado,
					@inalunodesagendado,
					@incadimpactaonline,
					@intreinamentoreposicao,
					@intreinamentotransfer,
					@introcaaluno
				)
				SET NOCOUNT OFF			
				SELECT SCOPE_IDENTITY() as idsolicitacaocorp		
			END
	--END
END

SELECT * FROM tb_solicitacaocorp where idalunoagendado IS NULL

SELECT * FROM tb_CursosAgendados a 
INNER JOIN tb_cursos b ON b.IdCurso = a.IDCurso
WHERE Dtinicio >= '2014-11-17 00:00:000' AND a.IDCurso = 2274
ORDER BY a.Dtinicio

SELECT * FROM tb_alunoagendado a
INNER JOIN tb_aluno b on b.IdAluno = a.IdAluno
WHERE IdCursoAgendado = 121784

SELECT * FROM tb_reserva
SELECT * FROM tb_pedido_reserva
SELECT * FROM tb_alunoagendado where IdAlunoAgendado = 1669764
SELECT * FROM tb_controlefinanceiro
SELECT * FROM tb_empresa WHERE IdEmpresa = 594397

sp_cursoagendadolalunos_list2 121784
------------------------------------------------------------------------------------
sp_solicitacaocorp_list '2013-07-01','2013-09-18 23:59:59'
ALTER PROC sp_solicitacaocorp_list 
(@dtinicio datetime, @dtfinal datetime)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massaharu
description: Lista a tabela tb_solicitacaocorp por um período de duas datas
*/

BEGIN
	SELECT idsolicitacaocorp, 
		   matricula, 
		   idsolicitante, 
		   idsolicitado, 
		   idalunoagendado,
		   inalunoalterado, 
		   incertificado, 
		   inlistapresenca, 
		   innfalterado, 
		   intreinamentoalterado, 
		   inalunodesmembrado,
		   inalunodesagendado,
		   incadimpactaonline,
		   intreinamentoreposicao,
		   intreinamentotransfer,
		   introcaaluno,
		   instatus, 
		   invisivel,
		   dtalteracao, 
		   dtcadastro
	FROM tb_solicitacaocorp
	WHERE invisivel = 1 AND dtcadastro BETWEEN @dtinicio AND @dtfinal
	ORDER BY instatus, dtalteracao DESC, dtcadastro DESC
END
---------------------------------------------------------------------------
sp_solicitacaocorpbysolicitante_list '2013-07-01','2014-07-18 23:59:59', 1495
ALTER PROC sp_solicitacaocorpbysolicitante_list --'2013-07-01','2013-07-18 23:59:59', 221
(@dtinicio datetime, @dtfinal datetime, @idsolicitante int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massaharu
description: Lista somente as solicitações realizadas pelo solicitante e um período de duas datas
*/
BEGIN
	SELECT idsolicitacaocorp, 
		   matricula, 
		   idsolicitante, 
		   idsolicitado, 
		   idalunoagendado,
		   inalunoalterado, 
		   incertificado, 
		   inlistapresenca, 
		   innfalterado, 
		   intreinamentoalterado, 
		   inalunodesmembrado,
		   inalunodesagendado,
		   incadimpactaonline,
		   intreinamentoreposicao,
		   intreinamentotransfer,
		   introcaaluno,
		   instatus, 
		   dtalteracao, 
		   dtcadastro
	FROM tb_solicitacaocorp
	WHERE idsolicitante = @idsolicitante AND
			dtcadastro BETWEEN @dtinicio AND @dtfinal
	ORDER BY instatus, dtalteracao DESC, dtcadastro DESC
END
------------------------------------------------------------------------------------
ALTER PROC sp_solicitacaocorpfinalizados_count --1495
(@idusuario int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massaharu
description: Retorna o numero de solicitacoes aprovadas e pendentes
*/
BEGIN
	SET NOCOUNT ON
	
	DECLARE @default TABLE(
		instatus int,
		finalizado int
	)
	
	-- Se o contador for baseado por solicitante
	IF EXISTS(SELECT idusuario FROM tb_usuario WHERE idusuario = @idusuario)
	BEGIN
		--Se o solicitante não tiver nenhuma solicitacao
		IF  NOT EXISTS(SELECT idsolicitacaocorp FROM tb_solicitacaocorp WHERE idsolicitante = @idusuario AND invisivel = 1)
		BEGIN
			INSERT @default VALUES (0, 0), (1, 0)
			SELECT instatus, finalizado FROM @default ORDER BY instatus
		END
		-- Se não existir solicitações pendentes
		ELSE IF NOT EXISTS(SELECT instatus FROM tb_solicitacaocorp WHERE instatus = 0 and idsolicitante = @idusuario AND invisivel = 1)
		BEGIN
			INSERT @default VALUES (0, 0)
			INSERT @default 
			SELECT * FROM dbo.fn_solicitacaoCorpFinalizadosCount(@idusuario)
			
			SELECT instatus, finalizado FROM @default ORDER BY instatus
		END
		-- Se não existir solicitações pendentes
		ELSE IF NOT EXISTS(SELECT instatus FROM tb_solicitacaocorp WHERE instatus = 1 and idsolicitante = @idusuario AND invisivel = 1)
		BEGIN
			INSERT @default VALUES (1, 0)
			INSERT @default 
			SELECT * FROM dbo.fn_solicitacaoCorpFinalizadosCount(@idusuario)
			
			SELECT instatus, finalizado FROM @default ORDER BY instatus
		END
		-- Se existirem solicitações pendentes e aprovadas
		ELSE 
		BEGIN
			SELECT * FROM dbo.fn_solicitacaoCorpFinalizadosCount(@idusuario)
		END
	END
	-- Se o contador for baseado em relação a todas as solicitacoes
	ELSE
	BEGIN
		-- Se não existir nenhuma solicitação
		IF  NOT EXISTS(SELECT idsolicitacaocorp FROM tb_solicitacaocorp WHERE invisivel = 1)
		BEGIN
			INSERT @default VALUES (0, 0), (1, 0)
			SELECT instatus, finalizado FROM @default ORDER BY instatus
		END
		-- Se não existir solicitações pendentes
		ELSE IF NOT EXISTS(SELECT instatus FROM tb_solicitacaocorp WHERE instatus = 0 AND invisivel = 1)
		BEGIN
			INSERT @default VALUES (0, 0)
			INSERT @default 
			SELECT * FROM dbo.fn_solicitacaoCorpFinalizadosCount(0)
			
			SELECT instatus, finalizado FROM @default ORDER BY instatus
		END
		-- Se não existir solicitações pendentes
		ELSE IF NOT EXISTS(SELECT instatus FROM tb_solicitacaocorp WHERE instatus = 1 AND invisivel = 1)
		BEGIN
			INSERT @default VALUES (1, 0)
			INSERT @default 
			SELECT * FROM dbo.fn_solicitacaoCorpFinalizadosCount(0)
			
			SELECT instatus, finalizado FROM @default ORDER BY instatus
		END
		-- Se existirem solicitações pendentes e aprovadas
		ELSE
		BEGIN
			SELECT * FROM dbo.fn_solicitacaoCorpFinalizadosCount(0)
		END
	END
	
	SET NOCOUNT OFF
END
--

SELECT * FROM tb_solicitacaocorp 
UPDATE tb_solicitacaocorp
SET invisivel = 1
WHERE idsolicitacaocorp = 5265

SELECT * FROM tb_solicitacaocorp WHERE idsolicitacaocorp = 5265
------------------------------------------------------------------------------------
ALTER PROC sp_solicitacaocorp_get --1
(@idsolicitacaocorp int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massaharu
description: Retorna uma solicitação pelo id do mesmo
*/
BEGIN
	SELECT idsolicitacaocorp, 
		   matricula, 
		   idsolicitante, 
		   idsolicitado, 
		   idalunoagendado,
		   inalunoalterado, 
		   incertificado, 
		   inlistapresenca, 
		   innfalterado, 
		   intreinamentoalterado, 
		   inalunodesmembrado,
		   inalunodesagendado,
		   incadimpactaonline,
		   intreinamentoreposicao,
		   intreinamentotransfer,
		   introcaaluno,
		   instatus,
		   invisivel, 
		   dtalteracao, 
		   dtcadastro
	FROM tb_solicitacaocorp
	WHERE idsolicitacaocorp = @idsolicitacaocorp
END

sp_solicitacaocorp_get 5105
------------------------------------------------------------------------------------
CREATE PROC sp_solicitacaocorp_delete --6
(@idsolicitacaocorp int)
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massaharu
description: Exclui uma solicitação
*/
AS
BEGIN
	DELETE FROM tb_solicitacaocorp
	WHERE idsolicitacaocorp = @idsolicitacaocorp
END
------------------------------------------------------------------------------------
CREATE PROC sp_solicitacaocorp_invisivel
(@idsolicitacaocorp int)
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massaharu
description: Exclui uma solicitação
*/
AS
BEGIN

	IF (
		SELECT invisivel FROM tb_solicitacaocorp 
		WHERE idsolicitacaocorp = @idsolicitacaocorp
	) = 1
	BEGIN
		UPDATE tb_solicitacaocorp
		SET invisivel = 0
		WHERE idsolicitacaocorp = @idsolicitacaocorp
	END
	ELSE
	BEGIN
		UPDATE tb_solicitacaocorp
		SET invisivel = 1
		WHERE idsolicitacaocorp = @idsolicitacaocorp
	END
END
------------------------------------------------------------------------------------
CREATE PROC sp_solicitacaocorp_alunoalterado_save
(
	@idalunoalterado int,
	@idsolicitacaocorp int,
	@desemail varchar(100),
	@desemailempresa varchar(75), 
	@descomplemento nvarchar(100), 
	@desaluno varchar(100),  
	@desbairro varchar(50), 
	@descidade varchar(50), 
	@desendereco varchar(100), 
	@dessexo char(1), 
	@dtnascimento datetime,
	@idaluno int , 
	@idalunoagendado int,
	@nrcelular varchar(50), 
	@nrcep varchar(10), 
	@nrcpf varchar(50), 
	@nrrg varchar(50), 
	@nrtelefonecomercial varchar(50), 
	@nrtelefoneresidencial varchar(50), 
	@nr varchar(20), 
	@desestadosigla char(2),
	@desenderecotipo char(3)
)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massaharu
description: Altera e salva a tabela tb_solicitacaocorp_alunoalterado
*/
BEGIN
	SET NOCOUNT ON
	IF EXISTS(SELECT idalunoalterado FROM tb_solicitacaocorp_alunoalterado WHERE idalunoalterado = @idalunoalterado)
		BEGIN
			UPDATE tb_solicitacaocorp_alunoalterado
			SET idsolicitacaocorp = @idsolicitacaocorp, 
				desemail = @desemail, 
				desemailempresa = @desemailempresa, 
				descomplemento = @descomplemento, 
				desaluno = @desaluno, 
				desbairro = @desbairro, 
				descidade = @descidade, 
				desendereco = @desendereco, 
				dessexo = @dessexo, 
				dtnascimento = @dtnascimento, 
				idaluno = @idaluno, 
				idalunoagendado = @idalunoagendado, 
				nrcelular = @nrcelular, 
				nrcep = @nrcep, 
				nrcpf = @nrcpf, 
				nrrg = @nrrg, 
				nrtelefonecomercial = @nrtelefonecomercial, 
				nrtelefoneresidencial = @nrtelefoneresidencial,
				nr = @nr, 
				desestadosigla = @desestadosigla, 
				desenderecotipo = @desenderecotipo
			WHERE idalunoalterado = @idalunoalterado
				
			SET NOCOUNT OFF			
			SELECT @idalunoalterado AS idalunoalterado
		END
	ELSE
		BEGIN
			INSERT INTO	tb_solicitacaocorp_alunoalterado
			( 
				idsolicitacaocorp, 
				desemail, 
				desemailempresa, 
				descomplemento, 
				desaluno, 
				desbairro, 
				descidade, 
				desendereco, 
				dessexo, 
				dtnascimento, 
				idaluno, 
				idalunoagendado, 
				nrcelular, 
				nrcep, 
				nrcpf, 
				nrrg, 
				nrtelefonecomercial, 
				nrtelefoneresidencial,
				nr, 
				desestadosigla, 
				desenderecotipo
			)VALUES(
				@idsolicitacaocorp, 
				@desemail, 
				@desemailempresa, 
				@descomplemento, 
				@desaluno, 
				@desbairro, 
				@descidade, 
				@desendereco, 
				@dessexo, 
				@dtnascimento, 
				@idaluno, 
				@idalunoagendado, 
				@nrcelular, 
				@nrcep, 
				@nrcpf, 
				@nrrg, 
				@nrtelefonecomercial, 
				@nrtelefoneresidencial,
				@nr, 
				@desestadosigla, 
				@desenderecotipo
			)
			
			SET NOCOUNT OFF			
			SELECT SCOPE_IDENTITY() as idalunoalterado	
		
		END
END
------------------------------------------------------------------------------------
CREATE PROC sp_solicitacaocorp_alunoalterado_get --51
(@idsolicitacaocorp int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massa
description: Retorna um registro da tabela tb_solicitacaocorp_alunoalterado pelo id do mesmo
*/
BEGIN
	SELECT idalunoalterado
		, idsolicitacaocorp
		, desemail
		, desemailempresa
		, descomplemento
		, desaluno
		, desbairro
		, descidade
		, desendereco
		, dessexo
		, dtnascimento
		, idaluno
		, idalunoagendado
		, nrcelular
		, nrcep
		, nrcpf
		, nrrg
		, nrtelefonecomercial
		, nrtelefoneresidencial
		, nr
		, desestadosigla
		, desenderecotipo
		, instatus
		, dtcadastro
	FROM tb_solicitacaocorp_alunoalterado
	WHERE idsolicitacaocorp = @idsolicitacaocorp
END


select * from tb_solicitacaocorp_alunoalterado
------------------------------------------------------------------------------------
------------------------------------------------------------------------------------
ALTER PROC sp_solicitacaocorp_reagendamento_save
(
	@idreagendamento int,
	@idsolicitacaocorp int,
	@idcursoagendadoatual int,
	@idcursoagendadonovo int,
	@idalunoagendado int,
	@desmotivo varchar(1000),
	@idtipoagendamento int	
)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massa
description: Salva e altera a tabela tb_solicitacaocorp_reagendamento
*/
BEGIN
	SET NOCOUNT ON
	IF EXISTS(SELECT idreagendamento FROM tb_solicitacaocorp_reagendamento WHERE idreagendamento = @idreagendamento)
		BEGIN
			UPDATE tb_solicitacaocorp_reagendamento
			SET idcursoagendadoatual = @idcursoagendadoatual, 
				idcursoagendadonovo = @idcursoagendadonovo, 
				idalunoagendado = @idalunoagendado,
				idtipoagendamento = @idtipoagendamento,
				desmotivo = @desmotivo
			WHERE idreagendamento = @idreagendamento
			
			SET NOCOUNT OFF			
			SELECT @idreagendamento AS idreagendamento
		END
	ELSE
		BEGIN
			INSERT INTO tb_solicitacaocorp_reagendamento
			(
				idsolicitacaocorp, 
				idcursoagendadoatual, 
				idcursoagendadonovo, 
				idalunoagendado,
				desmotivo,
				idtipoagendamento
			)VALUES(
				@idsolicitacaocorp, 
				@idcursoagendadoatual, 
				@idcursoagendadonovo, 
				@idalunoagendado,
				@desmotivo,
				@idtipoagendamento
			) 
			
			SET NOCOUNT OFF			
			SELECT SCOPE_IDENTITY() as idreagendamento	
		END	
END
------------------------------------------------------------------------------------
ALTER PROC sp_solicitacaocorp_reagendamento_get
(@idsolicitacaocorp int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massaharu
description: Retorna um registro da tabela tb_solicitacaocorp_reagendamento pelo id do mesmo
*/
BEGIN
	SELECT idreagendamento
		, idsolicitacaocorp
		, idcursoagendadoatual
		, idcursoagendadonovo
		, idalunoagendado
		, instatus
		, dtcadastro
		, desmotivo
		, idtipoagendamento
	FROM tb_solicitacaocorp_reagendamento
	WHERE idsolicitacaocorp = @idsolicitacaocorp
END

sp_solicitacaocorp_reagendamento_get 2864

SELECT * FROM tb_alunoagendado where idaluno = 370096
SELECT * FROM tb_controleFinanceiro
------------------------------------------------------------------------------------
------------------------------------------------------------------------------------
CREATE PROC sp_solicitacaocorp_nffaturamentoalterado_save
(
	@idnffaturamentoalterado int, 
	@idsolicitac
	aocorp int,
	@matricula varchar(20), 
	@desendereco varchar(100), 
	@descep varchar(10), 
	@desbairro varchar(100), 
	@descidade varchar(100), 
	@desestado varchar(2), 
	@desenderecoentrega varchar(100), 
	@desbairroentrega varchar(100), 
	@descidadeentrega varchar(100), 
	@desestadoentrega varchar(2), 
	@descepentrega varchar(10), 
	@descontato varchar(100), 
	@desfone varchar(30), 
	@desfax varchar(30), 
	@desemail varchar(150), 
	@desobs varchar(3000), 
	@desendereconf varchar(50), 
	@desenderecotipo char(3), 
	@nrendereco char(10), 
	@descomplemento varchar(50), 
	@desemailnf varchar(150), 
	@nrinscricaomunicipal char(20)
)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massaharu
description: Salva e altera a tabela tb_solicitacaocorp_nffaturamentoalterado
*/
BEGIN
	SET NOCOUNT ON
	IF EXISTS(SELECT idnffaturamentoalterado FROM tb_solicitacaocorp_nffaturamentoalterado WHERE idnffaturamentoalterado = @idnffaturamentoalterado)
		BEGIN
			UPDATE tb_solicitacaocorp_nffaturamentoalterado
			SET 
				idsolicitacaocorp = @idsolicitacaocorp, 
				matricula = @matricula, 
				desendereco = @desendereco, 
				descep = @descep, 
				desbairro = @desbairro, 
				descidade = @descidade, 
				desestado = @desestado, 
				desenderecoentrega = @desenderecoentrega, 
				desbairroentrega = @desbairroentrega, 
				descidadeentrega = @descidadeentrega, 
				desestadoentrega = @desestadoentrega, 
				descepentrega = @descepentrega, 
				descontato = @descontato, 
				desfone = @desfone, 
				desfax = @desfax, 
				desemail = @desemail, 
				desobs = @desobs,  
				desendereconf = @desendereconf, 
				desenderecotipo = @desenderecotipo, 
				nrendereco = @nrendereco, 
				descomplemento = @descomplemento, 
				desemailnf = @desemailnf, 
				nrinscricaomunicipal = @nrinscricaomunicipal
			WHERE idnffaturamentoalterado = @idnffaturamentoalterado
			
			SET NOCOUNT OFF			
			SELECT @idnffaturamentoalterado AS idnffaturamentoalterado
		END
	ELSE
		BEGIN
			INSERT INTO tb_solicitacaocorp_nffaturamentoalterado
			(
				idsolicitacaocorp, 
				matricula, 
				desendereco, 
				descep, 
				desbairro, 
				descidade, 
				desestado, 
				desenderecoentrega, 
				desbairroentrega, 
				descidadeentrega, 
				desestadoentrega, 
				descepentrega, 
				descontato, 
				desfone, 
				desfax, 
				desemail, 
				desobs, 
				desendereconf, 
				desenderecotipo, 
				nrendereco, 
				descomplemento, 
				desemailnf, 
				nrinscricaomunicipal
			)VALUES(
				@idsolicitacaocorp, 
				@matricula, 
				@desendereco, 
				@descep, 
				@desbairro, 
				@descidade, 
				@desestado, 
				@desenderecoentrega, 
				@desbairroentrega, 
				@descidadeentrega, 
				@desestadoentrega, 
				@descepentrega, 
				@descontato, 
				@desfone, 
				@desfax, 
				@desemail, 
				@desobs, 
				@desendereconf, 
				@desenderecotipo, 
				@nrendereco, 
				@descomplemento, 
				@desemailnf, 
				@nrinscricaomunicipal
			)
			
			SET NOCOUNT OFF			
			SELECT SCOPE_IDENTITY() as idnffaturamentoalterado	
		END
END
------------------------------------------------------------------------------------
--exec sp_rename 'sp_nffaturamentoalterado_get','sp_solicitacaocorp_nffaturamentoalterado_get'

CREATE PROC sp_solicitacaocorp_nffaturamentoalterado_get --39
(@idsolicitacaocorp int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massaharu
description: seleciona um registro na tabela tb_solicitacaocorp_nffaturamentoalterado pelo @idsolicitacaocorp
*/
BEGIN
	SELECT idnffaturamentoalterado
		, idsolicitacaocorp
		, matricula
		, desendereco
		, descep
		, desbairro
		, descidade
		, desestado
		, desenderecoentrega
		, desbairroentrega
		, descidadeentrega
		, desestadoentrega
		, descepentrega
		, descontato
		, desfone
		, desfax
		, desemail
		, desobs
		, dtcadastro
		, desendereconf
		, desenderecotipo
		, nrendereco
		, descomplemento
		, desemailnf
		, nrinscricaomunicipal
		, instatus
	FROM tb_solicitacaocorp_nffaturamentoalterado
	WHERE idsolicitacaocorp = @idsolicitacaocorp
END

------------------------------------------------------------------------------------
ALTER PROC sp_solicitacaocorp_alunodesmembrado_save
(
	@idalunodesmembrado int,
	@idsolicitacaocorp int,
	@idaluno int,
	@idalunoagendado int,
	@nralunos int,
	@idempresa int
)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massaharu
description: Salva e altera a tabela tb_solicitacaocorp_alunodesmembrado_save
*/
BEGIN
	SET NOCOUNT ON
	IF EXISTS(SELECT * FROM tb_solicitacaocorp_alunodesmembrado WHERE idalunodesmembrado = @idalunodesmembrado)
		BEGIN
			UPDATE tb_solicitacaocorp_alunodesmembrado
			SET idsolicitacaocorp = @idsolicitacaocorp,
				idaluno = @idaluno,
				idalunoagendado = @idalunoagendado,
				nralunos = @nralunos,
				idempresa = @idempresa
			WHERE idalunodesmembrado = @idalunodesmembrado
			
			SET NOCOUNT OFF			
			SELECT @idalunodesmembrado AS idalunodesmembrado
		END
	ELSE
		BEGIN
			INSERT INTO tb_solicitacaocorp_alunodesmembrado
			(
				idsolicitacaocorp,
				idaluno,
				idalunoagendado,
				nralunos,
				idempresa
			)VALUES(
				@idsolicitacaocorp,
				@idaluno,
				@idalunoagendado,
				@nralunos,
				@idempresa
			)
			
			SET NOCOUNT OFF			
			SELECT SCOPE_IDENTITY() as idalunodesmembrado	
		END
END
------------------------------------------------------------------------------------
ALTER PROC sp_solicitacaocorp_alunodesmembrado_get
(@idsolicitacaocorp int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massaharu
description: Seleciona um registro na tabela tb_solicitacaocorp_alunodesmembrado pelo @idsolicitacaocorp
*/
BEGIN
	SELECT idalunodesmembrado,
		idsolicitacaocorp,
		idaluno,
		idalunoagendado,
		nralunos,
		idempresa,
		instatus,
		dtcadastro
	FROM tb_solicitacaocorp_alunodesmembrado
	WHERE idsolicitacaocorp = @idsolicitacaocorp AND
		instatus = 1
END
------------------------------------------------------------------------------------
ALTER PROC sp_solicitacaocorp_transferencia_get
(@idsolicitacaocorp int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massaharu
description: Seleciona um registro na tabela tb_solicitacaocorp_transferencia pelo @idtreinamentotransferencia
*/
BEGIN
	SELECT
		idtreinamentotransferencia,
		idsolicitacaocorp,
		incortesia,
		descursosantigos,
		descursosnovos,
		idcursosagendadosnovos,
		idcursosantigos,
		idcursosnovos,
		idpedido,
		matricula,
		inneworcamento,
		qtdeparcela,
		inreposicao,
		vlrcursosantigos,
		vlrcursosnovos,
		vlrorcamentoantigo,
		vlrorcamentodiferenca,
		vlrorcamentonovo,
		instatus,
		desmotivo,
		idalunosagendadosantigos,
		idcursosagendadosantigos
	FROM tb_solicitacaocorp_transferencia
	WHERE idsolicitacaocorp = @idsolicitacaocorp AND
		instatus = 1
END

sp_solicitacaocorp_get 3433
------------------------------------------------------------------------------------
ALTEr PROC sp_solicitacaocorp_transferencia_save
(
	@idtreinamentotransferencia int,
	@idsolicitacaocorp int,
	@incortesia bit,
	@descursosantigos varchar(1000),
	@descursosnovos varchar(1000),
	@idcursosagendadosnovos varchar(500),
	@idcursosantigos varchar(500),
	@idcursosnovos varchar(500),
	@idpedido int,
	@matricula varchar(20),
	@inneworcamento bit,
	@qtdeparcela int,
	@inreposicao bit,
	@vlrcursosantigos varchar(100),
	@vlrcursosnovos varchar(100),
	@vlrorcamentoantigo money,
	@vlrorcamentodiferenca money,
	@vlrorcamentonovo money,
	@desmotivo varchar(1000),
	@idalunosagendadosantigos varchar(500),
	@idcursosagendadosantigos varchar(500),
	@instatus bit = 1
)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massaharu
description: Salva uma solicitação de transferencia de cursos
*/
BEGIN
	SET NOCOUNT ON
	
	IF EXISTS(
		SELECT idtreinamentotransferencia FROM tb_solicitacaocorp_transferencia
		WHERE idtreinamentotransferencia = @idtreinamentotransferencia
	)
	BEGIN
		UPDATE tb_solicitacaocorp_transferencia
		SET idsolicitacaocorp = @idsolicitacaocorp,
			incortesia = @incortesia,
			descursosantigos = @descursosantigos,
			descursosnovos = @descursosnovos,
			idcursosagendadosnovos = @idcursosagendadosnovos,
			idcursosantigos = @idcursosantigos,
			idcursosnovos = @idcursosnovos,
			idpedido = @idpedido,
			matricula = @matricula,
			inneworcamento = @inneworcamento,
			qtdeparcela = @qtdeparcela,
			inreposicao = @inreposicao,
			vlrcursosantigos = @vlrcursosantigos,
			vlrcursosnovos = @vlrcursosnovos,
			vlrorcamentoantigo = @vlrorcamentoantigo,
			vlrorcamentodiferenca = @vlrorcamentodiferenca,
			vlrorcamentonovo = @vlrorcamentonovo,
			desmotivo = @desmotivo,
			instatus = @instatus,
			idalunosagendadosantigos = @idalunosagendadosantigos,
			idcursosagendadosantigos = @idcursosagendadosantigos
		WHERE idtreinamentotransferencia = @idtreinamentotransferencia
		
		SET NOCOUNT OFF
		SELECT @idtreinamentotransferencia as idtreinamentotransferencia
	END
	ELSE
	BEGIN
		INSERT INTO tb_solicitacaocorp_transferencia
		(
			idsolicitacaocorp,
			incortesia,
			descursosantigos,
			descursosnovos,
			idcursosagendadosnovos,
			idcursosantigos,
			idcursosnovos,
			idpedido,
			matricula,
			inneworcamento,
			qtdeparcela,
			inreposicao,
			vlrcursosantigos,
			vlrcursosnovos,
			vlrorcamentoantigo,
			vlrorcamentodiferenca,
			vlrorcamentonovo,
			desmotivo,
			idalunosagendadosantigos,
			idcursosagendadosantigos
		)VALUES(
			@idsolicitacaocorp,
			@incortesia,
			@descursosantigos,
			@descursosnovos,
			@idcursosagendadosnovos,
			@idcursosantigos,
			@idcursosnovos,
			@idpedido,
			@matricula,
			@inneworcamento,
			@qtdeparcela,
			@inreposicao,
			@vlrcursosantigos,
			@vlrcursosnovos,
			@vlrorcamentoantigo,
			@vlrorcamentodiferenca,
			@vlrorcamentonovo,
			@desmotivo,
			@idalunosagendadosantigos,
			@idcursosagendadosantigos
		)
	
		SET NOCOUNT OFF			
		SELECT SCOPE_IDENTITY() as idtreinamentotransferencia
	END
END

SELECT * FROM tb_solicitacaocorp_transferencia

------------------------------------------------------------------------------------
ALTER PROC sp_solicitacaocorp_trocaaluno_get
(@idsolicitacaocorp int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2014-10-21
author: Massaharu
description: Retorna uma solicitacao de troca de aluno pelo id da solicitação corporativa
*/
BEGIN
	
	SELECT 
		idtrocaaluno,
		idsolicitacaocorp,
		idalunoto,
		idsalunoagendado,
		desmotivo	
	FROM tb_solicitacaocorp_trocaaluno
	WHERE idsolicitacaocorp = @idsolicitacaocorp
END
------------------------------------------------------------------------------------
ALTER PROC sp_solicitacaocorp_trocaaluno_save
(
	@idtrocaaluno int,
	@idsolicitacaocorp int,
	@idalunoto int,
	@idsalunoagendado varchar(500),
	@desmotivo varchar(1000)
)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2014-10-21
author: Massaharu
description: Salva uma solicitação corporativa de troca de aluno
*/
BEGIN
	
	SET NOCOUNT ON

	IF EXISTS(
		SELECT idtrocaaluno FROM tb_solicitacaocorp_trocaaluno
		WHERE idtrocaaluno = @idtrocaaluno
	)
	BEGIN
		UPDATE tb_solicitacaocorp_trocaaluno
		SET
			idsolicitacaocorp = @idsolicitacaocorp,
			idalunoto = @idalunoto,
			idsalunoagendado = @idsalunoagendado,
			desmotivo = @desmotivo
		WHERE idtrocaaluno = @idtrocaaluno
		
		SET NOCOUNT OFF
		
		SELECT @idtrocaaluno as idtrocaaluno
	END
	ELSE
	BEGIN
		INSERT INTO tb_solicitacaocorp_trocaaluno
		(
			idsolicitacaocorp,
			idalunoto,
			idsalunoagendado,
			desmotivo
		)VALUES(
			@idsolicitacaocorp,
			@idalunoto,
			@idsalunoagendado,
			@desmotivo
		)
		
		SELECT SCOPE_IDENTITY() as idtrocaaluno
	END
END
--
SELECT * FROM tb_solicitacaocorp_trocaaluno
SELECT * FROM tb_solicitacaocorp
------------------------------------------------------------------------------------
------------------------------------------------------------------------------------
--DROP PROC sp_aluno_alterados_save 946390
--(
--	@IdAluno int
--)
--AS
--/*
--app: SimpacWeb
--url: /simpacweb/class/class.solicitacaocorporativa.php
--data: 2013-03-21
--author: Massaharu
--*/
--BEGIN
--	INSERT INTO tb_aluno_alterados 
--	(
--		IdAluno
--		, NmAluno
--		, DtNascimento
--		, NrRG
--		, NrCPF
--		, DesEndereco
--		, DesBairro
--		, DesCidade
--		, SgEstado
--		, NrCEP
--		, CdEMail
--		, NrTelefoneResidencial
--		, NrTelefoneComercial
--		, NrCelular
--		, DtCadastramento
--		, DesSexo
--		, CdEmailEmpresa
--		, Num
--		, Complemento
--		, DDD_Residencial
--		, NaoReplicar
--		, Usuario
--		, Endereco
--		, TipoEndereco
--	)
--	SELECT IdAluno
--		, NmAluno
--		, DtNascimento
--		, NrRG
--		, NrCPF
--		, DesEndereco
--		, DesBairro
--		, DesCidade
--		, SgEstado
--		, NrCEP
--		, CdEMail
--		, NrTelefoneResidencial
--		, NrTelefoneComercial
--		, NrCelular
--		, DtCadastramento
--		, DesSexo
--		, CdEmailEmpresa
--		, Num
--		, Complemento
--		, DDD_Residencial
--		, NaoReplicar
--		, Usuario
--		, Endereco
--		, TipoEndereco
--	FROM tb_aluno
--	WHERE IdAluno = @IdAluno
--END
------------------------------------------------------------------------------------
------------------------------------------------------------------------------------
CREATE PROC sp_aluno_edit
(
	@cdemail varchar(100),
	@cdemailempresa varchar(75), 
	@complemento nvarchar(100), 
	@nmaluno varchar(100),  
	@desbairro varchar(50), 
	@descidade varchar(50), 
	@desendereco varchar(100), 
	@dessexo char(1), 
	@dtnascimento datetime,
	@idaluno int , 
	@nrcelular varchar(50), 
	@nrcep varchar(10), 
	@nrcpf varchar(50), 
	@nrrg varchar(50), 
	@nrtelefonecomercial varchar(50), 
	@nrtelefoneresidencial varchar(50), 
	@num nvarchar(100), 
	@sgestado char(2),
	@tipoendereco char(3)
)
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massaharu
description: Altera um registro da tabela tb_aluno pelo id do mesmo
*/
AS
BEGIN
	UPDATE tb_aluno
	SET cdemail = @cdemail,
		cdemailempresa = @cdemailempresa, 
		complemento = @complemento, 
		nmaluno = @nmaluno,  
		desbairro = @desbairro, 
		descidade = @descidade, 
		desendereco = @desendereco, 
		dessexo = @dessexo, 
		dtnascimento = @dtnascimento,
		idaluno = @idaluno, 
		nrcelular = @nrcelular, 
		nrcep = @nrcep, 
		nrcpf = @nrcpf, 
		nrrg = @nrrg, 
		nrtelefonecomercial = @nrtelefonecomercial, 
		nrtelefoneresidencial = @nrtelefoneresidencial, 
		num = @num, 
		sgestado = @sgestado,
		tipoendereco = @tipoendereco
	WHERE IdAluno = @idaluno
END

SELECT * FROM tb_aluno	WHERE NmAluno like '%MASSAHARU%'
tb_aluno_alterados
------------------------------------------------------------------------------------
------------------------------------------------------------------------------------
ALTER PROC sp_alunoagendado_reagendamento
(@matricula varchar(20), @idcursoagendado int, @idalunoagendado int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massaharu
description: Faz o reagendamento de um aluno(físico ou jurídico) para outros cursos
*/
BEGIN
	BEGIN TRAN
	
	INSERT INTO tb_alunoagendado 
	(
		IdCursoAgendado
		, IdAluno
		, IdUsuario
		, DesComentario
		, DtCadastramento
		, InEmissaoCartaAviso
		, InStatus
		, IdMidia
		, IdControleFinanceiro
		, Matricula
		, NrFalta
		, InFinanceiro
		, IdFechamento
		, NaoReplicar
		, InReposicao
	)
	SELECT @idcursoagendado as idcursoagendado
		, IdAluno
		, IdUsuario
		, DesComentario
		, GETDATE()
		, InEmissaoCartaAviso
		, InStatus
		, IdMidia
		, IdControleFinanceiro
		, Matricula
		, NrFalta
		, InFinanceiro
		, IdFechamento
		, NaoReplicar
		, InReposicao
	FROM tb_alunoagendado
	WHERE IdAlunoAgendado = @idalunoagendado
	
	-- Se a matricula for jurídica
	IF EXISTS(SELECT matricula FROM tb_alunoempresa WHERE Matricula = @matricula)
	BEGIN
		IF (@@ERROR = 0 AND scope_identity() is not null)
		BEGIN
			INSERT INTO tb_alunoempresa 
			(
				IdAlunoAgendado
				, IdAluno
				, IdEmpresa
				, IdCursoAgendado
				, Matricula
			)
			SELECT scope_identity()
				, IdAluno
				, (SELECT top(1)idempresa from tb_AlunoEmpresa where Matricula = @matricula)
				, @idcursoagendado
				, Matricula
			FROM tb_alunoagendado
			WHERE idalunoagendado = @idalunoagendado
			
			IF @@ERROR = 0 
			BEGIN
				DELETE tb_alunoempresa
				WHERE idalunoagendado = @idalunoagendado
			END
			ELSE
			BEGIN
				ROLLBACK
			END
		END
		ELSE
		BEGIN
			ROLLBACK
		END
	END
	
	--se todas as queries acima derem certo, deleta o alunoagendado
	IF @@ERROR = 0 AND @@TRANCOUNT <> 0
	BEGIN
		DELETE tb_alunoagendado
		WHERE idalunoagendado = @idalunoagendado
		COMMIT
	END
	ELSE IF @@TRANCOUNT <> 0
		ROLLBACK
END
------------------------------------------------------------------------------------
------------------------------------------------------------------------------------
ALTER PROC sp_alunoagendado_reposicao
(@matricula varchar(20), @idcursoagendado int, @idalunoagendado int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massaharu
description: Faz a reposicao de um aluno(físico ou jurídico) 
*/
BEGIN
	BEGIN TRAN
	
	INSERT INTO tb_alunoagendado 
	(
		IdCursoAgendado
		, IdAluno
		, IdUsuario
		, DesComentario
		, DtCadastramento
		, InEmissaoCartaAviso
		, InStatus
		, IdMidia
		, IdControleFinanceiro
		, Matricula
		, NrFalta
		, InFinanceiro
		, IdFechamento
		, NaoReplicar
		, InReposicao
	)
	SELECT @idcursoagendado as idcursoagendado
		, IdAluno
		, IdUsuario
		, 'REPOSICAO' 
		, GETDATE()
		, InEmissaoCartaAviso
		, InStatus
		, IdMidia
		, IdControleFinanceiro
		, Matricula
		, NrFalta
		, InFinanceiro
		, IdFechamento
		, NaoReplicar
		, 1
	FROM tb_alunoagendado
	WHERE IdAlunoAgendado = @idalunoagendado
	
	-- Se a matricula for jurídica
	IF EXISTS(SELECT matricula FROM tb_alunoempresa WHERE Matricula = @matricula)
	BEGIN
		IF (@@ERROR = 0 AND scope_identity() is not null)
		BEGIN
			INSERT INTO tb_alunoempresa 
			(
				IdAlunoAgendado
				, IdAluno
				, IdEmpresa
				, IdCursoAgendado
				, Matricula
			)
			SELECT scope_identity()
				, IdAluno
				, (SELECT top(1)idempresa from tb_AlunoEmpresa where Matricula = @matricula)
				, @idcursoagendado
				, Matricula
			FROM tb_alunoagendado
			WHERE idalunoagendado = @idalunoagendado
			
			IF @@ERROR <> 0 
			BEGIN
				ROLLBACK
			END
		END
		ELSE
		BEGIN
			ROLLBACK
		END
	END
	
	--se todas as queries acima derem certo
	IF @@ERROR = 0 
		COMMIT
	ELSE
		ROLLBACK
END

SELECT * FROM tb_alunoempresa
SELECT * FROM tb_alunoagendado where IdAlunoAgendado = 1599108
SELECT * FROM tb_aluno where IdAluno = 907484 
SELECT matricula FROM tb_alunoempresa WHERE Matricula = '3610102468'
------------------------------------------------------------------------------------
--------------------------------------.----------------------------------------------
ALTER PROC sp_alunoagendado_desmembramento
(
	@matricula varchar(20)
	, @idaluno int
	, @idalunoagendado int
	, @nmaluno varchar(100)
	, @qtdalunos int
	, @idusuario int
	, @intipocliente char(1)
)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massaharu
description: Faz o desmembramento de um aluno(jurídico) para criação de outros alunos
*/
BEGIN
	
	SET NOCOUNT ON
	
	DECLARE @varidaluno int, @varidalunoagendado int
		
	DECLARE @tb_idalunodesmembrado TABLE(
		idaluno int		
	);
	
	BEGIN TRAN
	
	WHILE @qtdalunos > 0
	BEGIN
		
		INSERT INTO tb_cliente
		(
			idusuario,
			intipocliente
		)VALUES(
			@idusuario,
			@intipocliente
		)
		
		IF @@ERROR = 0
		BEGIN 
			SET @varidaluno = scope_identity()
			
			INSERT @tb_idalunodesmembrado
			SELECT @varidaluno
	
			INSERT INTO tb_aluno
			(
				idAluno,
				NmAluno, 
				DtNascimento, 
				NrRG, 
				NrCPF, 
				DesEndereco, 
				DesBairro, 
				DesCidade, 
				SgEstado, 
				NrCEP, 
				CdEMail, 
				NrTelefoneResidencial, 
				NrTelefoneComercial, 
				NrCelular, 
				DtCadastramento, 
				DesSexo, 
				CdEmailEmpresa, 
				Num, 
				Complemento, 
				DDD_Residencial, 
				NaoReplicar, 
				Usuario, 
				Endereco, 
				TipoEndereco
			)
			SELECT @varidaluno,
				SUBSTRING(@nmaluno, 0, 25)+' '+cast(@qtdalunos as varchar(3)), 
				DtNascimento, 
				NrRG, 
				NrCPF, 
				DesEndereco, 
				DesBairro, 
				DesCidade, 
				SgEstado, 
				NrCEP, 
				CdEMail, 
				NrTelefoneResidencial, 
				NrTelefoneComercial, 
				NrCelular, 
				GETDATE(), 
				DesSexo, 
				CdEmailEmpresa, 
				Num, 
				Complemento, 
				DDD_Residencial, 
				NaoReplicar, 
				Usuario, 
				Endereco, 
				TipoEndereco
			FROM tb_aluno 
			WHERE IdAluno = @idaluno
			
			IF @@ERROR = 0
			BEGIN
				INSERT INTO tb_alunoagendado 
				(
					IdCursoAgendado
					, IdAluno
					, IdUsuario
					, DesComentario
					, DtCadastramento
					, InEmissaoCartaAviso
					, InStatus
					, IdMidia
					, IdControleFinanceiro
					, Matricula
					, NrFalta
					, InFinanceiro
					, IdFechamento
					, NaoReplicar
					, InReposicao
				)
				SELECT idcursoagendado
					, @varidaluno
					, IdUsuario
					, DesComentario
					, GETDATE()
					, InEmissaoCartaAviso
					, InStatus
					, IdMidia
					, IdControleFinanceiro
					, Matricula
					, NrFalta
					, InFinanceiro
					, IdFechamento
					, NaoReplicar
					, InReposicao
				FROM tb_alunoagendado
				WHERE IdAlunoAgendado = @idalunoagendado
				
				IF @@ERROR = 0
				BEGIN
					SET @varidalunoagendado = scope_identity()
		
					IF EXISTS(SELECT matricula FROM tb_alunoempresa WHERE Matricula = @matricula)
					BEGIN
						IF (scope_identity() is not null)
						BEGIN
							INSERT INTO tb_alunoempresa 
							(
								IdAlunoAgendado
								, IdAluno
								, IdEmpresa
								, IdCursoAgendado
								, Matricula
							)
							SELECT @varidalunoagendado
								, @varidaluno
								, IdEmpresa
								, IdCursoAgendado
								, Matricula
							FROM tb_alunoempresa
							WHERE idalunoagendado = @idalunoagendado
						END	
						ELSE
						BEGIN
							ROLLBACK
							BREAK
						END
					END	
				END
				ELSE
				BEGIN
					ROLLBACK
					BREAK
				END
			END
			ELSE
			BEGIN
				ROLLBACK
				BREAK
			END
		END 
		ELSE
		BEGIN
			ROLLBACK
			BREAK
		END
			
		SET @qtdalunos = @qtdalunos - 1
	END -- Fim do WHILE
	
	--se todas as queries acima derem certo, deleta
	IF @@ERROR = 0 AND @@TRANCOUNT <> 0
	BEGIN
		--DELETE tb_alunoempresa
		--WHERE idalunoagendado = @idalunoagendado
		
		--DELETE tb_alunoagendado
		--WHERE idalunoagendado = @idalunoagendado
		
		--DELETE tb_aluno
		--WHERE idaluno = @idaluno
		
		--DELETE tb_cliente
		--WHERE idcliente = @idaluno
		
		COMMIT
		
		SELECT idaluno FROM @tb_idalunodesmembrado
	END
	ELSE IF @@TRANCOUNT <> 0
		ROLLBACK
		
	SET NOCOUNT OFF
END
------------------------------------------------------------------------------------
------------------------------------------------------------------------------------
ALTER PROC sp_aluno_agendamento
(
	@matricula varchar(20)
	, @idaluno int
	, @idalunoagendado int
)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massaharu
description: Faz o agendamento de um aluno(J) gerado a partir da execução da sp_alunoagendado_desmembramento
*/
BEGIN
	DECLARE @varidalunoagendado int
	
	BEGIN TRAN
	
	INSERT INTO tb_alunoagendado 
	(
		IdCursoAgendado
		, IdAluno
		, IdUsuario
		, DesComentario
		, DtCadastramento
		, InEmissaoCartaAviso
		, InStatus
		, IdMidia
		, IdControleFinanceiro
		, Matricula
		, NrFalta
		, InFinanceiro
		, IdFechamento
		, NaoReplicar
		, InReposicao
	)
	SELECT idcursoagendado
		, @idaluno
		, IdUsuario
		, DesComentario
		, GETDATE()
		, InEmissaoCartaAviso
		, InStatus
		, IdMidia
		, IdControleFinanceiro
		, Matricula
		, NrFalta
		, InFinanceiro
		, IdFechamento
		, NaoReplicar
		, InReposicao
	FROM tb_alunoagendado
	WHERE IdAlunoAgendado = @idalunoagendado
	
	IF @@ERROR = 0
	BEGIN
		SET @varidalunoagendado = scope_identity()

		IF EXISTS(SELECT matricula FROM tb_alunoempresa WHERE Matricula = @matricula)
		BEGIN
			IF (scope_identity() is not null)
			BEGIN
				INSERT INTO tb_alunoempresa 
				(
					IdAlunoAgendado
					, IdAluno
					, IdEmpresa
					, IdCursoAgendado
					, Matricula
				)
				SELECT @varidalunoagendado
					, @idaluno
					, IdEmpresa
					, IdCursoAgendado
					, Matricula
				FROM tb_alunoempresa
				WHERE idalunoagendado = @idalunoagendado
			END	
			ELSE
				ROLLBACK
		END	
	END
	ELSE
		ROLLBACK
	
	--se todas as queries acima derem certo, deleta
	IF @@ERROR = 0 AND @@TRANCOUNT <> 0
		COMMIT
	ELSE IF @@TRANCOUNT <> 0
		ROLLBACK
END
------------------------------------------------------------------------------------
------------------------------------------------------------------------------------
--DROP PROC sp_solicitacaocorp_reagendamentopendente_get
--(@idalunoagendado int)
--AS
--/*
--app: SimpacWeb
--url: /simpacweb/class/class.solicitacaocorporativa.php
--data: 2013-03-21
--author: Massaharu
--description: Verifica se existe um reagendamento ainda pendente para o alunoagendado
--*/
--BEGIN
--	SELECT 
--		idsolicitacaocorp
--		, matricula
--		, idsolicitante
--		, idsolicitado
--		, idalunoagendado
--		, inalunoalterado
--		, incertificado
--		, inlistapresenca
--		, innfalterado
--		, intreinamentoalterado
--		, instatus
--		, dtalteracao
--		, dtcadastro
--		, invisivel
--	FROM tb_solicitacaocorp
--	WHERE invisivel = 1 AND
--		instatus = 0 AND
--		intreinamentoalterado = 1 AND
--		idalunoagendado = @idalunoagendado
--END
------------------------------------------------------------------------------------
ALTER PROC sp_alunoagendado_trocaaluno
(
	@matricula varchar(20),
	@idalunofrom int,
	@idalunoto int,
	@idsalunoagendado varchar(200)
)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2014-10-21
author: Massaharu
description: troca o aluno de turma
*/
BEGIN
	UPDATE tb_AlunoEmpresa
	SET
		IdAluno = @idalunoto
	WHERE IdAlunoAgendado IN(
		SELECT id FROM Simpac.dbo.fnSplit(@idsalunoagendado, ',')
	) AND IdAluno = @idalunofrom AND Matricula = @matricula
	
	UPDATE tb_alunoagendado
	SET
		IdAluno = @idalunoto
	WHERE IdAlunoAgendado IN(
		SELECT id FROM Simpac.dbo.fnSplit(@idsalunoagendado, ',')
	) AND IdAluno = @idalunofrom AND Matricula = @matricula
	
END
--
SELECT * FROM tb_alunoagendado_alterados where Matricula = '3610102468'
order by DtCadastro
SELECT * FROM tb_aluno where IdAluno = 945468
------------------------------------------------------------------------------------
CREATE PROC sp_alunoagendado_alteradoslast_get
(@idalunoagendado int)
AS
BEGIN
	SELECT TOP 1 * FROM tb_alunoagendado_alterados where IdAlunoAgendado = @idalunoagendado
	order by DtCadastro DESC 
END

sp_alunoagendado_alteradoslast_get 1653972
------------------------------------------------------------------------------------
ALTER PROC sp_solicitacaocorp_pendente_get 
(@idalunoagendado int)
/*
app: SimpacWeb
url: /simpacweb/class/class.solicitacaocorporativa.php
data: 2013-03-21
author: Massaharu
description: Verifica se existe uma solicitação pendente, e quais são
*/
AS
BEGIN
	DECLARE 
		@intreinamentopendente int, 
		@indesmembramentopendente int, 
		@indesagendamentopendente int, 
		@incadimpactaonline int,
		@intreinamentoreposicao int,
		@intreinamentotransfer int,
		@introcaaluno int

	-- Reagendamento
	IF EXISTS(SELECT * FROM tb_solicitacaocorp
			  WHERE invisivel = 1 AND instatus = 0 AND intreinamentoalterado = 1 AND idalunoagendado = @idalunoagendado
			 ) 
		SET @intreinamentopendente = 1
	ELSE
		SET @intreinamentopendente = 0

	-- Desmembramento
	IF EXISTS(SELECT * FROM tb_solicitacaocorp
			  WHERE invisivel = 1 AND instatus = 0 AND inalunodesmembrado = 1 AND idalunoagendado = @idalunoagendado
			 ) 
		SET @indesmembramentopendente = 1
	ELSE
		SET @indesmembramentopendente = 0
		
	-- Desagendamento
	IF EXISTS(SELECT * FROM tb_solicitacaocorp
			  WHERE invisivel = 1 AND instatus = 0 AND inalunodesagendado = 1 AND idalunoagendado = @idalunoagendado
			 ) 
		SET @indesagendamentopendente = 1
	ELSE
		SET @indesagendamentopendente = 0
	
	-- Cadastro Impacta Online
	IF EXISTS(SELECT * FROM tb_solicitacaocorp
			  WHERE invisivel = 1 AND instatus = 0 AND incadimpactaonline = 1 AND idalunoagendado = @idalunoagendado
			 ) 
		SET @incadimpactaonline = 1
	ELSE
		SET @incadimpactaonline = 0
		
	-- Reposição
	IF EXISTS(SELECT * FROM tb_solicitacaocorp
		  WHERE invisivel = 1 AND instatus = 0 AND intreinamentoreposicao = 1 AND idalunoagendado = @idalunoagendado
		 ) 
		SET @intreinamentoreposicao = 1
	ELSE
		SET @intreinamentoreposicao = 0

	-- Transferência
	IF EXISTS(SELECT * FROM tb_solicitacaocorp
		  WHERE invisivel = 1 AND instatus = 0 AND intreinamentotransfer = 1 AND idalunoagendado = @idalunoagendado
		 ) 
		SET @intreinamentotransfer = 1
	ELSE
		SET @intreinamentotransfer = 0
	
	-- Troca de Aluno
	IF EXISTS(SELECT * FROM tb_solicitacaocorp
		  WHERE invisivel = 1 AND instatus = 0 AND introcaaluno = 1 AND idalunoagendado = @idalunoagendado
		 ) 
		SET @introcaaluno = 1
	ELSE
		SET @introcaaluno = 0
	
	SELECT @intreinamentopendente as intreinamentopendente
		, @indesmembramentopendente as indesmembramentopendente
		, @indesagendamentopendente as indesagendamentopendente
		, @incadimpactaonline as incadimpactaonline
		, @intreinamentoreposicao as intreinamentoreposicao
		, @intreinamentotransfer as intreinamentotransfer
		, @introcaaluno as introcaaluno
END
--
sp_solicitacaocorp_pendente_get 1599108
SELECT * FROM tb_solicitacaocorp
SELECT * FROM tb_solicitacaocorp_reagendamento WHERE idsolicitacaocorp = 2864
------------------------------------------------------------------------------------
CREATE PROc sp_solicitacaocorp_reserva_save
(
	@idreserva int,
	@idsolicitacaocorp int
)
As
/*
app: SimpacWeb
url: /simpacweb/class/class.matricula.php
data: 2014-10-21
author: Massaharu
description: Salva as reservas vinculando com a solicitação corporativa
*/
BEGIN
	INSERT INTO tb_solicitacaocorp_reserva
	VALUES (@idreserva, @idsolicitacaocorp)
END
------------------------------------------------------------------------------------
ALTER PROC sp_solicitacaocorp_reserva_remove
(@idsolicitacaocorp int, @idalunoagendado int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.matricula.php
data: 2014-10-21
author: Massaharu
description: Derruba as reservas vinculando com a solicitação corporativa
*/
BEGIN
	
	DELETE tb_solicitacaocorp_reserva
	WHERE 
		idsolicitacaocorp = @idsolicitacaocorp AND
		idreserva = (
			SELECT TOP 1 idreserva FROM tb_reserva
			WHERE idalunoagendado = @idalunoagendado
			ORDER BY DtCadastramento DESC
		)
		
	UPDATE tb_reserva
	SET InStatus = 0
	WHERE IdReserva = (
		SELECT TOP 1 idreserva FROM tb_reserva
		WHERE idalunoagendado = @idalunoagendado
		ORDER BY DtCadastramento DESC
	)
END
--
sp_solicitacaocorp_reserva_remove 5173, 1671568


SELECT MAX(idreserva), COUNT(*) FROM tb_reserva
GROUP BY IdAlunoAgendado
HAVING COUNT(*) > 1

SELECT * FROM tb_reserva where IdUsuario = 1495
SELECT * FROm tb_solicitacaocorp_reagendamento
SELECT * FROM tb_solicitacaocorp_reserva
SELECT * FROM tb_alunoagendado

SELECT * FROM tb_alunoagendado where idcursoagendado = 124389 AND IdAlunoAgendado = 1671568
sp_solicitacaocorp_reserva_get 5297
------------------------------------------------------------------------------------
ALTER PROC sp_solicitacaocorp_reserva_get
(@idsolicitacaocorp int)
AS
BEGIN 
	SELECT * FROM tb_reserva
	WHERE IdReserva in (
		SELECT IdReserva FROM tb_solicitacaocorp_reserva
		WHERE idsolicitacaocorp = @idsolicitacaocorp
	)
END
------------------------------------------------------------------------------------
ALTER PROC [dbo].[sp_pedidocursos_alunosagendados_list]
(@matricula varchar(20), @idaluno int)
/*
app: SimpacWeb
url: /simpacweb/class/class.matricula.php
data: 2013-03-21
author: Massaharu
description: Lista os agendamentos relacionando com os pedidos cursos pela Matricula e Aluno
*/
AS
BEGIN
	--Matricula cortesia
	IF SUBSTRING(@matricula, 1, 2) = '99' or SUBSTRING(@matricula, 1, 2) = '70'
	BEGIN
		SELECT DISTINCT
			NULL idpedidocurso, 
			d.idpedido, 
			d.idcurso, 
			NULL tabela, 
			NULL perc, 
			NULL unitario, 
			NULL total, 
			NULL qtde,
			NULL Curso, 
			a.*
		FROM tb_alunoagendado a
		INNER JOIN tb_cursosagendados b ON b.IdCursoAgendado = a.IdCursoAgendado
		INNER JOIN tb_controlefinanceiro c ON c.Matricula = a.Matricula
		INNER JOIN tb_Periodo f ON f.IdPeriodo = b.IdPeriodo
		LEFT JOIN tb_PedidoCortesia d ON d.IdCurso = b.IDCurso AND (d.IdPedido + 15000) = c.IdPedido 
		LEFT JOIN tb_pedidos e ON e.IdPedido = d.IdPedido
		WHERE a.Matricula = @matricula AND a.IdAluno = @idaluno 
	END
	--Matricula normal
	ELSE
	BEGIN
		SELECT DISTINCT
			d.idpedidocurso, 
			d.idpedido, 
			d.idcurso, 
			d.tabela, 
			CASE 
				WHEN e.valor != 0 THEN 
					(d.unitario/e.valor)*100 
				ELSE 
					0 
			END perc, 
			d.unitario, 
			d.total, 
			d.qtde,
			d.Curso, 
			a.*
		FROM tb_alunoagendado a
		INNER JOIN tb_cursosagendados b ON b.IdCursoAgendado = a.IdCursoAgendado
		INNER JOIN tb_controlefinanceiro c ON c.Matricula = a.Matricula
		INNER JOIN tb_Periodo f ON f.IdPeriodo = b.IdPeriodo
		LEFT JOIN tb_PedidoCursos d ON d.IdCurso = b.IDCurso AND (d.IdPedido + 15000) = c.IdPedido 
		LEFT JOIN tb_pedidos e ON e.IdPedido = d.IdPedido
		WHERE a.Matricula = @matricula AND a.IdAluno = @idaluno 
	END
END

sp_pedidocursos_alunosagendados_list '7014040150'

SELECT SUBSTRING('9714070296', 1, 2)
------------------------------------------------------------------------------------
CREATE PROCEDURE [dbo].[sp_AlunoAgendadoJuridicoDelete]
(@IdCursoAgendado int, @IdAlunoAgendado int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.matricula.php
data: 2013-03-21
author: Massaharu
description: Exclui os agendamentos juridicos
*/
BEGIN
	DELETE tb_alunoempresa 
	WHERE IdCursoAgendado = @IdCursoAgendado AND IdAlunoAgendado = @IdAlunoAgendado
	
	DELETE tb_AlunoAgendado 
	WHERE IdAlunoAgendado = @IdAlunoAgendado
END
------------------------------------------------------------------------------------
CREATE PROCEDURE [dbo].[sp_AlunoAgendadoJuridicoSalva]
(
	@IdCursoAgendado int, @IdAluno int, @IdUsuario int, @IdControleFinanceiro int,
	@Matricula varchar(20), @DesComentario varchar(50), @InFinanceiro bit
)
AS

/*
app: SimpacWeb
url: /simpacweb/modulos/treinamentos/ajax/TM_inscricaoGeral.php
data: 06/12/2011
author: Renan
*/
BEGIN
	SET NOCOUNT ON
	
	BEGIN TRAN
	
	INSERT INTO tb_AlunoAgendado (
		IdCursoAgendado,IdAluno,IdUsuario,IdControleFinanceiro,
		Matricula,DesComentario,InFinanceiro
	)VALUES(
		@IdCursoAgendado,@IdAluno,@IdUsuario,@IdControleFinanceiro,
		@Matricula,@DesComentario,@InFinanceiro
	)
	
	IF @@ERROR = 0
	BEGIN
		INSERT INTO tb_AlunoEmpresa (
			IdAlunoAgendado, IdAluno, IdEmpresa, IdCursoAgendado, Matricula
		) VALUES (
			SCOPE_IDENTITY(), @IdAluno, 
			(SELECT TOP 1 idcliente FROM tb_controlefinanceiro WHERE IdControleFinanceiro = @IdControleFinanceiro),
			@IdCursoAgendado,
			@Matricula
		)
		
		IF @@ERROR = 0
		BEGIN
			SET NOCOUNT OFF
			SELECT SCOPE_IDENTITY( ) as id
			
			COMMIT
		END
		ELSE
			ROLLBACK
	END
	ELSE
		ROLLBACK
END

SELECT * FROM tb_AlunoEmpresa
SELECT TOP 1 intipo FROM tb_controlefinanceiro WHERE Matricula like '9213100173'
--------------------------------------------------------------------------------------
ALTER PROCEDURE [dbo].[sp_pedidocursos_atualizar_juridico_save](
	@matricula VARCHAR(20)
)
AS
/*
	author: BCunha
	date: 08/04/2014
	url: simpacweb/class/class.pedido.php
	app: simpacweb
	info: Atualiza as informações de pedidos cursos referentes as matriculas
*/
BEGIN
	-------------------------------------------------------------------------------------
	--Desconsiderar o retorno para aplicação desde aqui
	SET NOCOUNT ON;
	
	-------------------------------------------------------------------------------------
	--Inicia a Transação
	BEGIN TRAN;
	
	-------------------------------------------------------------------------------------
	--Variáveis necessárias
	DECLARE @idpedido INT;
	DECLARE @idaluno INT;
	DECLARE @somaValoresRetirados MONEY;
	DECLARE @somaValoresRetiradosRestante MONEY;
	DECLARE @qtdeCursosRetirados INT;

	-------------------------------------------------------------------------------------
	--Controle financeiro onde a maior parte das informações serão obtidas
	SELECT @idpedido = (IdPedido - 15000),
		   @idaluno = IdCliente
	FROM tb_controleFinanceiro
	WHERE Matricula = @matricula;
	
	--Obtem a soma do valor dos cursos que serão retirados
	SELECT @somaValoresRetirados = SUM(a.Total) FROM tb_PedidoCursos a LEFT JOIN (	SELECT a.IdAlunoAgendado, a.IdCursoAgendado, a.IdAluno, a.Matricula, b.IDCurso, b.Dtinicio, b.DtTermino, b.IdPeriodo, b.IdSala, b.IdInstrutor, c.DesCurso, c.QtCargaHoraria, c.VlTotal	FROM tb_alunoagendado a	INNER JOIN tb_cursosagendados b	ON a.IdCursoAgendado = b.IdCursoAgendado INNER JOIN tb_cursos c	ON b.IDCurso = c.IdCurso WHERE a.IdAluno = @idaluno AND a.Matricula = @matricula) bb	ON a.IdCurso = bb.IDCurso WHERE a.IdPedido = (@idpedido) AND bb.IdAlunoAgendado IS NULL;
	
	--Valida para que o valor não seja nulo
	IF @somaValoresRetirados IS NULL BEGIN
		SET @somaValoresRetirados = 0;
	END
	
	--Copia o valor
	SET @somaValoresRetiradosRestante = @somaValoresRetirados;

	--Conta o numero de novos cursos serão inseridos na tb_pedidoCurso
	SELECT @qtdeCursosRetirados = COUNT(b.IDCurso) FROM tb_alunoagendado a INNER JOIN tb_cursosagendados b	ON a.IdCursoAgendado = b.IdCursoAgendado INNER JOIN tb_cursos c	ON b.IDCurso = c.IdCurso LEFT JOIN tb_PedidoCursos d	ON d.IdPedido = (@idpedido) AND b.IDCurso = d.IdCurso WHERE a.IdAluno = @idaluno AND a.Matricula = @matricula AND d.IdPedidoCurso IS NULL;
	
	-------------------------------------------------------------------------------------
	--Cursos que deverão ser retirados da tb_pedidoCurso
	DELETE tb_PedidoCursos
	WHERE IdPedidoCurso IN (
		SELECT IdPedidoCurso
		FROM tb_PedidoCursos a
		LEFT JOIN (
			SELECT a.IdAlunoAgendado, a.IdCursoAgendado, a.IdAluno, a.Matricula, b.IDCurso, b.Dtinicio, b.DtTermino, b.IdPeriodo, b.IdSala, b.IdInstrutor, c.DesCurso, c.QtCargaHoraria, c.VlTotal
			FROM tb_alunoagendado a
			INNER JOIN tb_cursosagendados b
				ON a.IdCursoAgendado = b.IdCursoAgendado
			INNER JOIN tb_cursos c
				ON b.IDCurso = c.IdCurso
			WHERE a.IdAluno = @idaluno AND a.Matricula = @matricula
		) bb
			ON a.IdCurso = bb.IDCurso
		WHERE a.IdPedido = (@idpedido) AND bb.IdAlunoAgendado IS NULL
	);

	-------------------------------------------------------
	--Declaração do cursor
	DECLARE cur_teste CURSOR
	FOR 
		SELECT DISTINCT
			a.idusuario, MAX(a.dtcadastramento) as dtcadastramento, 
			b.idcursoagendado, b.dtinicio, b.dttermino, b.idperiodo, 
			b.idsala, c.idcurso, c.descurso, c.qtcargahoraria, d.desperiodo, COUNT(*) as qtde
		FROM tb_alunoagendado a
		INNER JOIN tb_cursosagendados b
			ON a.IdCursoAgendado = b.IdCursoAgendado
		INNER JOIN tb_cursos c
			ON b.IDCurso = c.IdCurso
		INNER JOIN tb_periodo d
			ON b.idperiodo = d.idperiodo
		LEFT JOIN tb_PedidoCursos e
			ON e.IdPedido = (@idpedido) AND b.IDCurso = e.IdCurso
		WHERE --a.IdAluno = @idaluno AND 
		  a.Matricula = @matricula
		  AND e.IdPedidoCurso IS NULL
		--ORDER BY c.VlTotal;
		GROUP BY 
			a.idusuario,b.idcursoagendado, b.dtinicio, 
			b.dttermino, b.idperiodo, b.idsala, c.idcurso, c.descurso, c.qtcargahoraria, d.desperiodo

	-----------------------------------------
	-----------------------------------------
	--Abre o cursor
	OPEN cur_teste;
	
	--Variáveis necessárias
	DECLARE 
		@idusuario INT, @dtcadastramento DATETIME, @idcursoagendado INT, @dtinicio DATETIME, 
		@dttermino DATETIME,  @idperiodo INT, @idsala INT, @idcurso INT, @descurso VARCHAR(500), 
		@qtcargahoraria INT, @desperiodo VARCHAR(100), @qtde int;

	--Aplica o primeiro registro à variável
	FETCH NEXT FROM cur_teste INTO @idusuario, @dtcadastramento, @idcursoagendado, @dtinicio, @dttermino, @idperiodo, @idsala, @idcurso, @descurso, @qtcargahoraria, @desperiodo, @qtde;

	--Enquanto houver registros
	WHILE @@FETCH_STATUS = 0
	BEGIN
		--Variavel que guardara o valor tabela do curso
		DECLARE @vltabela MONEY;
		DECLARE @vlreal MONEY;
		
		--Obtem o valor tabela da epoca
		IF (EXISTS(SELECT TOP 1 * FROM tb_Cursos_Alterados WHERE dtAlterado < @dtcadastramento AND IdCurso = @idcurso))	BEGIN
			SELECT TOP 1 @vltabela = VlTotal FROM tb_Cursos_Alterados WHERE dtAlterado < @dtcadastramento AND IdCurso = @idcurso AND VlTotal > 0 ORDER BY dtAlterado DESC;
		END
		ELSE BEGIN
			SELECT TOP 1 @vltabela = VlTotal FROM tb_Cursos WHERE IdCurso = @idcurso;
		END;
		
		
		IF @qtdeCursosRetirados = 0
		BEGIN
			SET @vlreal = @vltabela;
		END
		ELSE
		BEGIN
			--Verifica se o valor que seria colocado no pedidocurso é maior que o valor tabela
			IF (@vltabela > (@somaValoresRetirados / @qtdeCursosRetirados)) BEGIN
				SET @vlreal = (@somaValoresRetirados / @qtdeCursosRetirados);
			END
			ELSE BEGIN
				SET @vlreal = @vltabela;
			END;
		END
		
		--Insere na tabela pedidos cursos
		INSERT INTO tb_PedidoCursos(
			IdPedido,
			Curso,
			CH,
			Periodo,
			Tabela,
			IdCurso,
			IdUsuario,
			Desconto,
			Unitario,
			Qtde,
			Total	
		)
		VALUES (
			@idpedido,
			@descurso,
			@qtcargahoraria,
			@desperiodo,
			@vltabela,
			@idcurso,
			@idusuario,
			0,
			@vlreal,
			@qtde,
			@vlreal * @qtde
		);
		
		--Reduz da soma dos valores cursos retirados por causa da inserção
		IF @somaValoresRetiradosRestante > 0
			SET @somaValoresRetiradosRestante = @somaValoresRetiradosRestante - @vlreal;
		
		--Passa para o proximo elemento do cursor
		FETCH NEXT FROM cur_teste INTO @idusuario, @dtcadastramento, @idcursoagendado, @dtinicio, @dttermino, @idperiodo, @idsala, @idcurso, @descurso, @qtcargahoraria, @desperiodo, @qtde;

		--Verifica se acabou
		IF @@FETCH_STATUS = -1 BEGIN
			--Atualiza o ultimo inserido com o valor restante
			DECLARE @idpc INT;
			DECLARE @vlultimocurso MONEY;
			
			--Obtem o id do ultimo inserido
			SELECT @idpc = SCOPE_IDENTITY();
			
			--Obtem o ultimo valor inserido
			SELECT @vlultimocurso = Unitario
			FROM tb_PedidoCursos
			WHERE IdPedidoCurso = @idpc;
			
			--Atualiza o valor do ultimo curso inserido
			UPDATE tb_PedidoCursos
			SET Unitario = (@vlultimocurso + @somaValoresRetiradosRestante),
				Total = (@vlultimocurso + @somaValoresRetiradosRestante)
			WHERE IdPedidoCurso = @idpc;
		END
	END;

	--Fecha o cursor
	CLOSE cur_teste;

	--Desaloca o cursor
	DEALLOCATE cur_teste;

	----------------------------------------------------------------------------
	--Finaliza a Transação aprovando caso de TUDO certo ou retornando caso tenha acontecido qualquer tipo de erro
	IF @@ERROR = 0 BEGIN
		COMMIT TRAN;
	END
	ELSE BEGIN
		ROLLBACK TRAN;
	END;
	
	----------------------------------------------------------------------------
	--Desconsiderar o retorno para aplicação até aqui
	SET NOCOUNT OFF;
	
	----------------------------------------------------------------------------
	--Retorna o ultimo id inserido na tb_pedidos
	SELECT SCOPE_IDENTITY() AS [idpedidocurso];
END;
--------------------------------------------------------------------------------------
ALTER PROC sp_pedidocursoscortesia_atualizar_juridico 
(@matricula varchar(20))
AS
BEGIN

	DECLARE 
		@idcliente_atual int,
		@idcliente_novo int,  
		@intipo char(1), 
		@dtcadastramento datetime, 
		@idpedido_novo int, 
		@idpedido_atual int,
		@idcurso int,
		@idcursoagendado int,
		@idperiodo int,
		@usuario varchar(100)
	
	SELECT TOP 1
		@idcliente_atual = idcliente,
		@intipo = intipo,
		@dtcadastramento = dtcadastramento,
		@idpedido_atual = idpedido,
		@usuario = usuario
	FROM tb_controlefinanceiro 
	WHERE Matricula = @matricula
	
	-- SE A MATRICULA JURIDICA ESTIVER CORRETA [J]
	IF @intipo = 'J'
	BEGIN
	
		-- BUSCA A MATRICULA CRIADA ANTERIORMENTE DA MATRICULA CORTESIA (CASO A MAT. CORTESIA NÃO TENHA PEDIDO)
		SET @idpedido_novo = (
			SELECT TOP 1 IdPedido FROM tb_controlefinanceiro 
			WHERE 
				IdCliente = @idcliente_atual AND 
				DtCadastramento < @dtcadastramento
			ORDER BY DtCadastramento DESC 
		)
		
		--EXCLUI OS PEDIDOS CORTESIA SEM AGENDAMENTO
		DELETE tb_PedidoCortesia
		WHERE Idregistro IN(
			SELECT a.idregistro
			FROM tb_PedidoCortesia a
			INNER JOIN tb_controlefinanceiro b ON b.IdPedido-15000 = a.IdPedido
			LEFT JOIN tb_AlunoEmpresa c ON c.Matricula = b.Matricula
			LEFT JOIN tb_alunoagendado d ON d.IdAlunoAgendado = c.IdAlunoAgendado
			LEFT JOIN tb_cursosagendados e ON e.IdCursoAgendado = d.IdCursoAgendado AND e.IDCurso = a.IdCurso
			WHERE c.IdEmpresa = @idcliente_atual AND c.Matricula = @matricula AND e.IdCursoAgendado IS NULL		
		)
		
		-- SE O CONTROLE FINANCEIRO NÃO TIVER PEDIDO
		IF @idpedido_atual = 0 OR @idpedido_atual IS NULL
		BEGIN
			IF @idpedido_novo IS NOT NULL 
			BEGIN		
			
				-- ATUALIZA O ID DO PEDIDO BUSCANDO A MATRICULA ANTERIOR DA MATRICULA CORTESIA
				UPDATE tb_controlefinanceiro
				SET IdPedido = @idpedido_novo
				WHERE Matricula = @matricula
				
				INSERT INTO tb_PedidoCortesia
				(idpedido, idcurso, idcursoagendadp, usuario, idperiodo)
				SELECT 
					@idpedido_atual-15000,
					a.IDCurso,
					a.IdCursoAgendado,
					@usuario,
					a.IdPeriodo
				FROM tb_CursosAgendados a
				INNER JOIN tb_alunoempresa b ON b.IdCursoAgendado = a.IdCursoAgendado
				INNER JOIN tb_controlefinanceiro d ON d.Matricula = b.Matricula
				LEFT JOIN tb_PedidoCortesia c ON c.IdCurso = a.idcurso AND c.IdPedido = d.IdPedido-15000
				WHERE b.IdEmpresa = @idcliente_atual AND b.Matricula = @matricula AND Idregistro IS NULL		
				
			END
		END	
		-- SE O CONTROLE FINANCEIRO JÁ TIVER O PEDIDO	
		ELSE 
		BEGIN
			INSERT INTO tb_PedidoCortesia
			(idpedido, idcurso, idcursoagendadp, usuario, idperiodo)
			SELECT 
				@idpedido_atual-15000,
				a.IDCurso,
				a.IdCursoAgendado,
				@usuario,
				a.IdPeriodo
			FROM tb_CursosAgendados a
			INNER JOIN tb_alunoempresa b ON b.IdCursoAgendado = a.IdCursoAgendado
			INNER JOIN tb_controlefinanceiro d ON d.Matricula = b.Matricula
			LEFT JOIN tb_PedidoCortesia c ON c.IdCurso = a.idcurso AND c.IdPedido = d.IdPedido-15000
			WHERE b.IdEmpresa = @idcliente_atual AND b.Matricula = @matricula AND Idregistro IS NULL			
		END
	END
	-- SE A MATRICULA JURIDICA ESTIVER INCORRETA [F]
	ELSE IF @intipo = 'F'
	BEGIN
		-- PROCURA PELO CLIENTE CORRETO (IDEMPRESA)
		SET @idcliente_novo = (
			SELECT TOP 1 
				ISNULL(	
					-- Verifica se existe uma empresa na tb_alunoempresa pelo (@idcliente) e (@matricula)					
					SUM(idempresa),  
					-- Se não encontrar busca apenas pelo @idcliente
					(
						SELECT TOP 1 idempresa FROM tb_alunoempresa
						WHERE IdAluno = @idcliente_atual
					)
				) 
			FROM tb_alunoempresa
			WHERE IdAluno = @idcliente_atual AND Matricula = @matricula
		)
		
		-- BUSCA A MATRICULA CRIADA ANTERIORMENTE DA MATRICULA CORTESIA (CASO A MAT. CORTESIA NÃO TENHA PEDIDO)
		SET @idpedido_novo = (
			SELECT TOP 1 IdPedido FROM tb_controlefinanceiro 
			WHERE 
				IdCliente = @idcliente_novo AND 
				DtCadastramento < @dtcadastramento
			ORDER BY DtCadastramento DESC 
		)
		
		--EXCLUI OS PEDIDOS CORTESIA SEM AGENDAMENTO
		DELETE tb_PedidoCortesia
		WHERE Idregistro IN(
			SELECT a.idregistro
			FROM tb_PedidoCortesia a
			INNER JOIN tb_controlefinanceiro b ON b.IdPedido-15000 = a.IdPedido
			LEFT JOIN tb_AlunoEmpresa c ON c.Matricula = b.Matricula
			LEFT JOIN tb_alunoagendado d ON d.IdAlunoAgendado = c.IdAlunoAgendado
			LEFT JOIN tb_cursosagendados e ON e.IdCursoAgendado = d.IdCursoAgendado AND e.IDCurso = a.IdCurso
			WHERE c.IdEmpresa = @idcliente_novo AND c.Matricula = @matricula AND e.IdCursoAgendado IS NULL		
		)
		
		-- SE O CONTROLE FINANCEIRO NÃO TIVER PEDIDO
		IF @idpedido_atual = 0 OR @idpedido_atual IS NULL
		BEGIN		
			-- SE O CLIENTE FOR IDENTIFICADO
			IF @idcliente_novo IS NOT NULL AND @idpedido_novo IS NOT NULL
			BEGIN
			
				UPDATE tb_controlefinanceiro
				SET InTipo = 'J',
					-- ATUALIZA O CLIENTE
					IdCliente = @idcliente_novo,
					-- ATUALIZA O ID DO PEDIDO BUSCANDO A MATRICULA ANTERIOR DA MATRICULA CORTESIA
					IdPedido = @idpedido_novo
				WHERE Matricula = @matricula
				
				-- CRIA O PEDIDO CORTESIA
				INSERT INTO tb_PedidoCortesia
				(idpedido, idcurso, idcursoagendadp, usuario, idperiodo)
				SELECT 
					@idpedido_novo-15000,
					a.IDCurso,
					a.IdCursoAgendado,
					@usuario,
					a.IdPeriodo
				FROM tb_CursosAgendados a
				INNER JOIN tb_alunoempresa b ON b.IdCursoAgendado = a.IdCursoAgendado
				INNER JOIN tb_controlefinanceiro d ON d.Matricula = b.Matricula
				LEFT JOIN tb_PedidoCortesia c ON c.IdCurso = a.idcurso AND c.IdPedido = d.IdPedido-15000
				WHERE b.IdEmpresa = @idcliente_novo AND b.Matricula = @matricula AND Idregistro IS NULL				
			END
		END
		-- SE O CONTROLE FINANCEIRO TIVER PEDIDO
		ELSE
		BEGIN	
		
			-- CRIA O PEDIDO CORTESIA
			INSERT INTO tb_PedidoCortesia
			(idpedido, idcurso, idcursoagendadp, usuario, idperiodo)
			SELECT 
				@idpedido_atual-15000,
				a.IDCurso,
				a.IdCursoAgendado,
				@usuario,
				a.IdPeriodo
			FROM tb_CursosAgendados a
			INNER JOIN tb_alunoempresa b ON b.IdCursoAgendado = a.IdCursoAgendado
			INNER JOIN tb_controlefinanceiro d ON d.Matricula = b.Matricula
			LEFT JOIN tb_PedidoCortesia c ON c.IdCurso = a.idcurso AND c.IdPedido = d.IdPedido-15000
			WHERE b.IdEmpresa = @idcliente_novo AND b.Matricula = @matricula AND Idregistro IS NULL		
		END
	END
END
---
SELECT * FROM tb_controlefinanceiro WHERE Matricula = '7014070137'
SELECT * FROM tb_controlefinanceiro WHERE Matricula = '7014070423'
SELECT * FROM tb_controlefinanceiro WHERE IdPedido = 867616
SELECT * FROM tb_controlefinanceiro WHERE IdCliente = 399465
SELECT * FROM tb_aluno WHERE IdAluno = 1012332
SELECt * FROM tb_AlunoEmpresa where IdAluno = 1012332
SELECt * FROM tb_AlunoEmpresa WHERE Matricula = '7014070423'
SELECT * FROM tb_alunoagendado WHERE Matricula = '7014070137'
SELECT * FROM tb_empresa WHERE idempresa = 420827
SELECT * FROM tb_pedidocursos WHERE IdPedido = 875530-15000
SELECT * FROM tb_pedidocortesia WHERE IdPedido = 875530-15000
SELECT * FROM tb_solicitacaocorp_transferencia
SELECT * FROM tb_cursos WHERE IdCurso = 2478

sp_pedidocursoscortesia_atualizar_juridico '7014070423'

sp_pedidocursoscortesia_atualizar_juridico

SELECT * FROM tb_usuario where NmLogin = 'juliana'

SELECT 
	ISNULL(
		SUM(
			idcontrolefinanceiro
		),
		(SELECT TOP 1 idcontrolefinanceiro FROM tb_controlefinanceiro)
	) 
FROM tb_controlefinanceiro 
WHERE matricula = 'fgdfgdfg' 

DECLARE @idcliente int

SET @idcliente = (
	SELECT TOP 1 
		ISNULL(	
			-- Verifica se existe uma empresa na tb_alunoempresa pelo (@idcliente) e (@matricula)					
			SUM(idempresa),  
			-- Se não encontrar busca apenas pelo @idcliente
			(
				SELECT TOP 1 idempresa FROM tb_alunoempresa
				WHERE IdAluno = 1006973
			)
		) 
	FROM tb_alunoempresa
	WHERE IdAluno = 1006973 AND Matricula = '7014040085'
)

SELECT @idcliente

SELECT * FROM tb_pedidocursos
WHERE IdCurso = 2676 AND
	IdCursoAgendado = 121865 AND
	IdPeriodo = 2	

SELECT TOP 1 IdPedido FROM tb_controlefinanceiro 
WHERE 
	IdCliente = 1006973 AND 
	DtCadastramento < '2014-04-17 19:37:00'
ORDER BY DtCadastramento DESC 

SELECT 
	a.IDCurso,
	a.IdCursoAgendado,
	a.IdPeriodo,
	c.*
FROM tb_CursosAgendados a
INNER JOIN tb_alunoempresa b ON b.IdCursoAgendado = a.IdCursoAgendado
INNER JOIN tb_controlefinanceiro d ON d.Matricula = b.Matricula
LEFT JOIN tb_PedidoCortesia c ON c.IdCurso = a.idcurso AND c.IdPedido = d.IdPedido-15000
WHERE b.Matricula = '7014070423' AND Idregistro IS NULL	

SELECT a.idregistro, e.*
FROM tb_PedidoCortesia a
INNER JOIN tb_controlefinanceiro b ON b.IdPedido-15000 = a.IdPedido
LEFT JOIN tb_AlunoEmpresa c ON c.Matricula = b.Matricula
LEFT JOIN tb_alunoagendado d ON d.IdAlunoAgendado = c.IdAlunoAgendado
LEFT JOIN tb_cursosagendados e ON e.IdCursoAgendado = d.IdCursoAgendado AND e.IDCurso = a.IdCurso
WHERE c.Matricula = '7014070423' AND e.IdCursoAgendado IS NULL 

SELECT * FROM tb_alunoagendado WHERE Matricula = '7014070423'
SELECT * FROM tb_pedidoCortesia where Idregistro in (206250,206260)

SELECt * FROM tb_solicitacaocorp_transferencia		
--------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------
SELECT * FROM tb_alunoagendado where Matricula =  '0213090179' and IdAluno = 986811
------------------------------------------------------------------------------------
select * from tb_solicitacaocorp where idsolicitacaocorp = 2292
select * from tb_solicitacaocorp_reagendamento 
select * from tb_solicitacaocorp_alunodesmembrado where idsolicitacaocorp = 2292
select * from tb_alunoagendado where idalunoagendado = 1584853 
select * from tb_alunoagendado where idaluno = 1006206 
select * from tb_alunoagendado where idcursoagendado = 61795 order by 
select * from tb_CursosAgendados where idcursoagendado = 61795  
select * from tb_AlunoAgendado_Alterados where idalunoagendado = 1584853
select * from tb_alunoagendado where matricula = '9213100173'
select * from tb_AlunoEmpresa where  matricula = '9213100173'
select * from tb_aluno_alterados
exec sp_alunoagendado_list 984959
select * from tb_aluno where IdAluno = 1006206
select * from tb_cliente where IdCliente = 984959
select * from tb_alunoagendado where IdAluno = 984959
select SUBSTRING(NmEmpresa, 0, 35) from tb_empresa
select TOP 100 * from tb_Cliente order by IdCliente desc

select * from tb_alunoagendado where matricula = '9714070296'

sp_controlefinanceiro_get_matricula  '9714070296'


select * from tb_presencas where idaluno in (
	select idaluno from tb_alunoagendado where matricula = '5912120966'
) and idcursoagendado  in(
	select idcursoagendado from tb_alunoagendado_alterados where matricula = '5912120966'
)

select * from tb_solicitacaocorp
where idsolicitacaocorp = 372

update tb_solicitacaocorp
set instatus = 0,
idsolicitado = NULL
where idsolicitacaocorp = 372

sp_alunoagendado_alterados_list 9713090220

select top 100 * from tb_controleFinanceiro where matricula = '0213090052'
sp_controlefinanceiro_get_matricula '0213090052'

select * from tb_presencas where idcursoagendado = 114804     

select * from tb_aluno where idaluno in (select idaluno from tb_Aluno_Enderecos)
select * from tb_aluno_telefones

select idaluno, nmaluno from tb_aluno
where IdAluno in (
select idaluno from tb_alunoagendado
where IdAlunoAgendado in (select IdAlunoAgendado from tb_AlunoEmpresa where  matricula = '5912120966'))
order by nmaluno

select top 1000 * from tb_aluno_alterados order by idRegistro desc

sp_EmpresaAluno 
sp_alunoagendado_list 936221
sp_alunoagendado_alterados_list 902155
sp_SimpacWebPHPExcluirMatriculaMaster

select * from tb_empresa where IdEmpresa  = 882957 
 
select * from tb_AlunoEmpresa where idempresa = 936243

SELECT CHARINDEX( ' ', 'IMPACTA TECNOLOGIA' ) 
sp_alunoagendado_desmembramento '9713090130', 984959, 1491053, 'UNIAO EDUCACIONAL E TECNOLOGIA IMPACTA UNI-IMPACTA LTDA', 3, 1495, 'J'
sp_alunoagendado_desmembramento '4313080321', 984905, 1485794, 'SKY BRASIL SERVIï¿½OS LTDA.', 1
sp_EmpresaAluno 984905, 1490265
SELECT top 100 * FROM tb_aluno order by idaluno desc
SELECT top 100 * FROM tb_alunoagendado where matricula = '9713090113'
SELECT SUBSTRING('Impacta4 tecno', 0, 35)+' '+cast(10 as varchar(3))
SELECT * FROM tb_cliente order by idcliente desc
SELECT * FROM tb_AlunoEmpresa where IdAlunoAgendado = 1485794
SELECT * FROM tb_Alunoagendado where IdAlunoAgendado = 1485794
SELECT * FROM tb_controlefinanceiro where Matricula = '9213100173'
SELECT * FROM tb_cancelamentosac where Matricula = '9213100173'

SELECT * FROM tb_AlunoEmpresa
where IdAluno in(SELECT idcliente FROM tb_Cliente
WHERE IdUsuario = 1495)


select * from tb_solicitacaocorp
select * from tb_aluno

--

cdemailempresa:
sgestado: "SP"
complemento: ""
num: ""
dessexo: "F"
tipoendereco: null
nrcelular: null
nrtelefonecomercial: "3366-8721"
nrtelefoneresidencial: null

idsolicitacaosecretariaeemailempresaaluno
idsolicitacaosecretariaufaluno
idsolicitacaosecretariacompaluno
idsolicitacaosecretarianaluno
idsolicitacaosecretariasexoaluno
idsolicitacaosecretarialogradouroaluno
idsolicitacaosecretariacelularaluno
idsolicitacaosecretariatelcomercialaluno
idsolicitacaosecretariatelresidencialaluno

tb_notafiscal_faturamento

create table teste1(id int identity,descr varchar(20))
select * from teste1

insert into teste1 (descr) values('oi')

if
(SELECT COUNT(*) FROM tb_alunoempresa 
		WHERE Matricula = '5913011101'
		GROUP BY matricula) > 0
begin
	IF @@ERROR = 0-- AND scope_identity() is not null)
	begin
		select scope_identity() as scope	
	end
end

RAISERROR(N'Message', 16, 1);
select @@ERROR


select a.*, b.* from tab_cursosagendados a 
inner join tab_cursosagendados_flags b on a.idcursoagendado = b.idcursoagendado
inner join tab_cursosagendados_datas c on a.idcursoagendado = c.idcursoagendado
where idflag = 1 

select top 1000 *  from tb_cursosagendados WHERE DesOBS LIKE '%TREINAMENTO EM ABERTO%'

sp_empresa_list


	
	sp_NotaFiscalFaturamentoEnderecosLocaliza 9713090008


select * from tb_solicitacaocorp_nffaturamentoalterado
tb_notafiscal_faturamento_alterados

select * from tb_empresa where NmEmpresa like '%impacta%'

sp_empresa_get 395951

sp_alunos_list_matricula '6714030120'

sp_solicitacaocorp_list '1970-01-01', '3000-01-01'

sp_cursotipo_get 2041   

SELECT * FROM tb_eadbox_cursos

SELECT * FROM tb_solicitacaocorp where instatus = 0


SELECT * FROM tb_alunoagendado where IdAlunoAgendado in(1574957,1574958)
SELECT * FROM tb_cursosagendados where idcurso = 2772 where idcursoagendado = 102372
SELECT * FROM tb_cursos where IdCurso = 2041    
SELECT * FROM tb_cursotipo
SELECT * FROM tb_cursocalendario where  IdTipo in (10, 15)
SELECT * FROM tb_cursos

sp_matriculacontrolefinanceiro_list '3610102468'

SELECT * FROM tb_AlunoEmpresa WHERE Matricula = '0214020127'
SELECT * FROM tb_matriculas where Matricula = '0214020127'
SELECT * FROM tb_controleFinanceiro WHERE Matricula = '3610102468'
SELECT * FROM tb_aluno WHERE IdAluno = 999595
SELECT * FROM tb_Cliente WHERE IdCliente = 999594
SELECT * FROM tb_empresa WHERE IdEmpresa = 999594
SELECT * FROM tb_alunoempresa WHERE IdEmpresa = 999594
SELECT * FROM tb_alunoagendado WHERE Matricula = '3610102468'
SELECT * FROM tb_cursosagendados
sp_ControleFinanceiro '0214020127'
SELECT * FROM tb_solicitacaocorp_transferencia
SELECT * FROM 


SELECT * FROM tb_PedidoCursos where IdPedido = 864818-15000
SELECT * FROM tb_Pedidos where IdPedido = 864818-15000
SELECT * FROM tb_Pedidoparcela where IdPedido = 611685-15000
SELECT * FROM tb_Proposta where NrProposta = 18703


INSERT INTO tb_alunoempresa
VALUES
(1561183, 999595, 999594, 117150, '0214020127')


sp_FichaEmpresaVersao2 999594

sp_pedidocursosporcentagem_list 851771


SELECT 
	a.idpedidocurso, 
	a.idpedido, 
	a.idcurso, 
	e.descurso, 
	a.tabela, 
	CASE 
		WHEN f.valor != 0 THEN 
			(a.unitario/f.valor)*100 
		ELSE 
			0 
	END perc, 
	a.unitario, 
	a.total, 
	a.qtde,
	a.Curso, 
	e.DesCurso, 
	g.NmAluno,
	c.*
FROM tb_PedidoCursos a
INNER JOIN tb_controleFinanceiro b ON (a.IdPedido + 15000) = b.IdPedido
INNER JOIN tb_alunoagendado c ON b.Matricula = c.matricula
INNER JOIN tb_CursosAgendados d ON c.IdCursoAgendado = d.IdCursoAgendado AND a.IdCurso = d.IDCurso
INNER JOIN tb_cursos e ON e.IdCurso = d.IDCurso
INNER JOIN tb_pedidos f ON f.idpedido = a.idpedido
INNER JOIN tb_aluno g ON g.IdAluno = c.IdAluno
WHERE a.IdPedido = 596685 and c.Matricula = '4313110110' 

SELECT 
	DISTINCT
	c.idpedidocurso, 
	c.idpedido, 
	c.idcurso, 
	c.tabela, 
	--f.descurso, 
	--CASE 
	--	WHEN e.valor != 0 THEN 
	--		(c.unitario/e.valor)*100 
	--	ELSE 
	--		0 
	--END perc, 
	c.unitario, 
	c.total, 
	c.qtde,
	c.Curso, 
	a.* 
FROM tb_alunoagendado a
INNER JOIN tb_controleFinanceiro b ON b.Matricula = a.Matricula
LEFT JOIN tb_PedidoCursos c ON (c.IdPedido + 15000) = b.IdPedido
--LEFT JOIN tb_CursosAgendados d ON d.IdCursoAgendado = a.IdCursoAgendado AND d.IdCurso = c.IDCurso
--LEFT JOIN tb_cursos f ON f.IdCurso = d.IDCurso
--INNER JOIN tb_pedidos e ON e.idpedido = c.idpedido
WHERE c.IdPedido = 596685 and a.Matricula = '4313110110' 

SELECT 
	b.IDCurso
	, c.IdPedido
	, a.* 
	, d.*
FROM tb_alunoagendado a
INNER JOIN tb_cursosagendados b ON b.IdCursoAgendado = a.IdCursoAgendado
INNER JOIN tb_controlefinanceiro c ON c.Matricula = a.Matricula
LEFT JOIN tb_PedidoCursos d ON d.IdCurso = b.IDCurso AND (d.IdPedido + 15000) = c.IdPedido
WHERE a.Matricula = '7014040150' AND c.IdPedido = 611685

1859
1861
1887
1912
SELECT * FROM tb_PedidoCortesia WHERE IdPedido = 875530-15000 
SELECT * FROM tb_PedidoCursos WHERE IdPedido = 875530-15000 
SELECT * FROM tb_Pedidos WHERE IdPedido =  875530-15000
SELECT * FROM tb_controleFinanceiro where Matricula = '7014070423'
SELECT * FROM tb_controlefinanceiro where IdPedido = 872824
SELECT * FROM tb_controlefinanceiro where IdCliente = 399465
select * from tb_empresa_alterados WHERE IdEmpresa = 395951
select * from tb_Empresa WHERE NmEmpresa like '%impacta%'
SELECT * FROM tb_AlunoEmpresa WHERE IdEmpresa = 399465
SELECT * FROM tb_reciboparcelapedido
select * FROM tb_pedidorecepcao
SELECT * FROM tb_matriculaspedidosrecriadas

SELECt * FROM tb_solicitacaocorp_transferencia

SELECT * FROM tb_AlunoAgendado where Matricula = '7014050676'
SELECT * FROM tb_AlunoEmpresa where Matricula = '7014050676'

sp_pedidocursos_atualizar_juridico_save '7014070423'

sp_pedidocursos_atualizar_save '9714070296'

select * from tb_empresa_alterados 
WHERE IdEmpresa = 395951
order by dtAlterado

--update tb_Empresa
SET nmempresa = 'UNIAO EDUCACIONAL E TECNOLOGIA IMPACTA UNI-IMPACTA LTDA'
--SELECT *  FROM tb_Empresa
WHERE idempresa = 395951

sp_pedidocursos_alunosagendados_list '3610102468', 907484

SELECT * FROM tb_PedidoCursos a
INNER JOIN tb_controleFinanceiro b ON (a.IdPedido + 15000) = b.IdPedido
INNER JOIN tb_alunoagendado c ON b.Matricula = c.matricula
INNER JOIN tb_CursosAgendados d ON c.IdCursoAgendado = d.IdCursoAgendado AND a.IdCurso = d.IDCurso
WHERE a.IdPedido = 620396 and c.Matricula = '4313110110' 

SELECT * FROM tb_alunoagendado WHERE Matricula = '4314040027' 
SELECT * FROM tb_PedidoCursos WHERE IdPedido = 620396

SELECT * FROM tb_controlefinanceiro WHERE IdControleFinanceiro = 412721    
SELECT * FROM tb_empresa WHERE idempresa = 1001291

SELECT * FROM IMPACTA4..tb_ecommercecliente WHERE  nome_cli like '%Tiago Santesso Felipe da Silva%'
SELECT * FROM IMPACTA4..tb_ecommercecliente WHERE  nome_cli like '%Amanda Moreira Camara%'
SELECT * FROM IMPACTA4..tb_ecommercecliente WHERE  nome_cli like '%Jefferson Carvalho Magalhaes%'

SELECT * FROM tb_aluno WHERE NmAluno like '%Tiago Santesso Felipe da Silva%'
SELECT * FROM tb_aluno WHERE NmAluno like '%Amanda Moreira Camara%' 
SELECT * FROM tb_aluno WHERE NmAluno like '%Jefferson Carvalho Magalhaes%' 

SELECT * FROM tb_alunoagendado WHERE IdAluno = 944848
exec Impacta6..sp_cursosagendadosapostilaspdfbynrcpf_list '30592234835'

--UPDATE IMPACTA4..tb_ecommercecliente
SET cpf_cli = '30592234835'
--SELECt * FROM IMPACTA4..tb_ecommercecliente
WHERE cod_cli = 120695

--UPDATE tb_solicitacaocorp
SET instatus = 0
--SELECT * FROM tb_solicitacaocorp 
where idsolicitacaocorp = 3395

--UPDATE tb_aluno
SET nrcpf = '30592234835'
--SELECT * FROM tb_aluno
WHERE IdAluno =  944848

SELECT * FROM tb_alunoagendado WHERE matricula = '3610102468'
SELECT * FROM tb_alunoempresa WHERE matricula = '9714070296'
SELECT * FROM tb_alunoagendado WHERE matricula = '9714070296'
SELECT * FROM tb_controleFinanceiro WHERE matricula = '9714070296'
SELECT * FROM tb_aluno WHERE IdAluno = 1014564
SELECT * FROM tb_empresa WHERE IdEmpresa = 1014564
SELECT * FROM tb_AlunoEmpresa WHERE matricula = '6714070193'
SELECT * FROM Impacta4..tb_ecommerceCliente where nome_cli like '%Ciro%Fernandes%'
SELECT * FROM tb_usuario WHERE IdUsuario = 67

SELECT * FROM tb_usuario
SELECT * FROM tb_solicitacaocorp
UPDATE tb_solicitacaocorp
SET instatus = 0
WHERE idsolicitacaocorp = 3458
--
SELECT * FROM tb_solicitacaocorp_transferencia WHERE idsolicitacaocorp = 3440
SELECT * FROM tb_cursosagendados WHERE IdCursoAgendado = 121929

sp_matriculacontrolefinanceiro_list '3610102468'

SELECT * FROM tb_aluno WHERE IdAluno = 907484

sp_alunoagendado_list 907484,'3610102468'

SELECT * FROM tb_cursosagendados WHERE idcursoagendado IN (8915, 8827,119164,119163,119181,66474,118103)
--2608,1247,1884

SELECT * FROM tb_PedidoCortesia

SELECT * FROM tb_pedidosrenegociacoes

SELECT * FROm tb_historicopedido

SELECT * FROM Vendas..tb_creditos

sp_pedido_renegociar_save_v2 860365, 6438.32, '2565', '121925', '29', '122012', 1

SELECT * FROM tb_controleFinanceiro
WHERE Matricula in (
	'0614070024',
	'7114070013',
	'2614070046', 
	'1413060449', 
	'8314070010', 
	'3714070020', 
	'8314070010' 
)

SELECT * FROM tb_aluno
WHERE idaluno in(
1014785,
974379,
1011992,
1014577,
1014532,
1014359
)


SELECT * FROM Impacta4..tb_ecommercecliente WHERE cpf_cli like '45026521800'

select * FROM tb_empresa where NmEmpresa like '%impacta%'

SELECT DISTINCT 
	a.idusuario, MAX(a.dtcadastramento) as dtcadastramento, COUNT(*) as qtd, b.idcursoagendado, b.dtinicio, 
	b.dttermino, b.idperiodo, b.idsala, c.idcurso, c.descurso, c.qtcargahoraria, d.desperiodo
FROM tb_alunoagendado a
INNER JOIN tb_cursosagendados b
	ON a.IdCursoAgendado = b.IdCursoAgendado
INNER JOIN tb_cursos c
	ON b.IDCurso = c.IdCurso
INNER JOIN tb_periodo d
	ON b.idperiodo = d.idperiodo
LEFT JOIN tb_PedidoCursos e
	ON e.IdPedido = (875530-15000 ) AND b.IDCurso = e.IdCurso
WHERE --a.IdAluno = @idaluno  AND 
a.Matricula = '9714070296'
GROUP BY a.idusuario,b.idcursoagendado, b.dtinicio, 
	b.dttermino, b.idperiodo, b.idsala, c.idcurso, c.descurso, c.qtcargahoraria, d.desperiodo
  
  
  AND e.IdPedidoCurso IS NULL
ORDER BY c.VlTotal;



SELECT DISTINCT
	d.idpedidocurso, 
	d.idpedido, 
	d.idcurso, 
	d.tabela, 
	CASE 
		WHEN e.valor != 0 THEN 
			(d.unitario/e.valor)*100 
		ELSE 
			0 
	END perc, 
	d.unitario, 
	d.total, 
	d.qtde,
	d.Curso, 
	a.*
FROM tb_alunoagendado a
INNER JOIN tb_cursosagendados b ON b.IdCursoAgendado = a.IdCursoAgendado
INNER JOIN tb_controlefinanceiro c ON c.Matricula = a.Matricula
INNER JOIN tb_Periodo f ON f.IdPeriodo = b.IdPeriodo
LEFT JOIN tb_PedidoCursos d ON d.IdCurso = b.IDCurso AND (d.IdPedido + 15000) = c.IdPedido AND d.Periodo = f.DesPeriodo
LEFT JOIN tb_pedidos e ON e.IdPedido = d.IdPedido
WHERE a.Matricula = '9714070296' AND a.IdAluno = 573497 

SELECT * FROM tb_aluno
SELECT * FROM tb_cursosagendados
SELECT * FROM tb_PedidoCursos where IdPedido = 875530-15000
SELECT * FROM tb_Pedidos where IdPedido = 875530-15000
SELECT * FROM tb_Cursos 
SELECT * FROM tb_orcamentoOpcoesDeData
SELECT * FROM TB_ORCAMENTOTREINAMENTOS where IdPedido = 558310-15000
findobj '%opcoes%'

tb_orcamentoOpcoesDeData

sp_OpcaoDeData

sp_localizaMail_list 'massaharu.kunikane@yahoo.com.br'
sp_consultaAlunoMatricula_get 812642

SELECT * FROM tb_alunoagendado WHERE matricula = '6714060166'
SELECT * FROM tb_cursosagendados WHERE IdCursoAgendado = 124389

SELECT * FROM tb_cursosagendados where IDCurso = 2557 and Dtinicio >= '2014-08-25' order by Dtinicio

UPDATE tb_alunoagendado
set idcursoagendado = 122443
where idalunoagendado = 1671191