

select * from tb_atendentes where iddepartamento = 1

select * from simpac..tb_usuario where nmcompleto like '%andrea%'
select * from simpac..tb_usuario where nmcompleto like '%deurivan%'
select * from tb_atendentes  where desatendente like '%deurivan%'
select * from tb_atendentes  where desatendente like '%andrea%'
select * from simpac..tb_usuario where idusuario = 1
select * from simpac..tb_depto

select * from simpac..tb_Unidade

select * from simpac..tb_aluno where nmaluno like '%massaharu kunikane%'
select * from simpac..tb_aluno_alterados  where nmaluno like '%massaharu kunikane%'

select * from simpac..tb_empresa where NmEmpresa like '%impacta%' --59069914000151 400.777.438-22
select * from tb_NotaFiscal_Faturamento where Matricula = '6713080219'
 
select * from simpac..tb_alunoagendado where idcursoagendado = 115256--114508 --114509


select * from simpac..tb_controleFinanceiro where Matricula = '9713080251'

select * from simpac..tb_matriculas where Matricula = '9713080248'

select * from simpac..tb_matriculas 
order by dtcadastramento desc 

sp_parcelaMatricula_get '9713070242'
sp_matriculacontrolefinanceiro_list '9713070242'

sp_ControleFinanceiro_add '9713070242', 97, 'J', '3.598,15', 6, 945468, '', '','','0','0','','0','','','0','','2013-07-30T00:00:00',97,'','',1,558310

-
sp_matricula_exist '9713080001'
exec findobj ultima

sp_ultimaMatricula
select * from guardaultmatricula

select * from tb_matriculas order by dtcadastramento desc

select * from tb_pedidos
select * from tb_controleFinanceiro where Matricula = '9713080001'
select * from tb_matriculas where matricula = '9713080001'

select b.NmAluno, a.* from simpac..tb_alunoagendado a 
inner join tb_aluno b on b.IdAluno = a.IdAluno where a.idcursoagendado = 114508 
sp_aluno_get 980832
select * from tb_aluno_alterados where nrcpf = '34784785884'
select * from tb_aluno_alterados where IdAluno = 985587
select * from tb_aluno where nrcpf = '34784785884'
select * from tb_aluno where IdAluno = 980726
select * from tb_AlunoEmpresa where idcursoagendado = 980832
select * from tb_AlunoEmpresa where IdAluno = 985587
select * from tb_empresa where IdEmpresa = 395951 
select * from tb_empresa where NrCGC = '59069914000151' and idempresa = 395951
select * from tb_empresa_alterados where NrCGC = '59069914000151'  and idempresa = 395951 order by dtalterado desc

sp_EmpresaAluno 985587, 115256
 
update tb_empresa
set nmempresa = 'UNIAO EDUCACIONAL E TECNOLOGIA IMPACTA UNI-IMPACTA LTDA',
nmcontatoempresa = 'Amanda Machereth',
NrInscricaoEstadual = '112.141.403.114',
Complemento = '9º andar',
email = 'amanda.machareth@impacta.com.br'
WHERE idempresa = 395951

sp_NotaFiscalFaturamentoEnderecosLocaliza 9713080150

select * from tb_NotaFiscal_Faturamento-- where NrInscricaoMunicipal = '2.853.466-2'--where Matricula = '9713080002'
where Matricula = '9713090008'
order by DtCadastro desc
--orcamentos
587417
558310
558314

select * from tb_alunoagendado where Matricula = '6713080219'
select * from tb_alunoagendado where idcursoagendado = 115256
select * from tb_AlunoEmpresa where IdAluno = 980640 
select * from tb_empresa where IdEmpresa = 397887
select * from tb_aluno where idaluno = 980640
select * from tb_aluno where NmAluno like '%marcia regina reis%'
select * from tb_AlunoEmpresa where Matricula = '9713090075'

sp_empresa_get 397887

sp_RemoveEmAberto 

sp_AlunoAgendadoSalva2 

sp_matriculacontrolefinanceiro_list '9713080032'

sp_parcelaMatricula_get '9713080066'

sp_empresaById_get 395951
sp_empresa_get 395951

select * from Impacta4..tb_ecommerceCliente where email_cli like '%gabisinha%'
select * from Impacta4..tb_ecommerceCliente where senha_cli like '%buc%'


select * from Impacta4..tb_ecommercecliente where email_cli = 'djmalmeida@gmail.com'

select * from tb_usuario where nmcompleto like '%clodomiro%'


sp_relatorio_vendas_consolidada_fisica_list '2013-07-01 00:00:00','2013-08-28 23:59:59'


sp_empresa_get 395951

