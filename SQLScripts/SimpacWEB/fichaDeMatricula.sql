USE Simpac

SELECT * FROM tb_matriculas
SELECT * FROM tb_controlefinanceiro
SELECT * FROM tb_alunoagendado where InFinanceiro = 0
SELECT * FROM tb_alunoagendado where IdAlunoAgendado = 1568615
SELECT * FROM tb_pedidos
SELECT * FROM tb_historicosecretaria where Matricula = '2814020087'
SELECT * FROM tb_historicosecretaria where DesHistorico like '% bloqueado pelo financeiro%'
SELECT * FROM Impacta4..tb_ecommerceCliente where cpf_cli like '00135056616'
SELECT * FROM tb_aluno where NmAluno like '%braulio%'

SELECT DISTINCT e.* FROM tb_alunoagendado a 
INNER JOIN tb_cursosagendados b ON b.IdCursoAgendado = a.IdCursoAgendado
INNER JOIN tb_cursos c ON c.IdCurso = b.IDCurso
INNER JOIN tb_aluno d ON d.IdAluno = a.IdAluno
INNER JOIN Impacta4..tb_ecommerceCliente e ON e.cpf_cli = d.NrCPF
WHERE c.DesCurso like '%web ao vivo%'

ALTER FUNCTION dbo.fnIsBlockBySecretaria
(@idalunoagendado varchar(20), @infinanceiro bit)
RETURNS BIT
AS
BEGIN
	
	DECLARE @insecretaria bit

	IF EXISTS(
		SELECT a.NmCompleto, b.DesDepartamento, c.* FROM tb_usuario a 
		INNER JOIN tb_depto b ON b.Iddepto = a.IdDepto
		INNER JOIN SimpacWeb..tb_SimpacWebPHPAcoes c ON c.idusuario = a.IdUsuario
		WHERE c.desacao like '%o%idalunoagendado%'+@idalunoagendado+'%foi%bloqueado%' and b.IdDepto = 58
	) AND (@infinanceiro = 0)
	BEGIN
		SET @insecretaria = 0
	END
	ELSE
	BEGIN	
		SET @insecretaria = 1
	END
	
	RETURN @insecretaria
END


SELECT a.NmCompleto, b.DesDepartamento, c.* FROM tb_usuario a 
INNER JOIN tb_depto b ON b.Iddepto = a.IdDepto
INNER JOIN SimpacWeb..tb_SimpacWebPHPAcoes c ON c.idusuario = a.IdUsuario
WHERE c.desacao like '%o%idalunoagendado%foi%bloqueado%' and b.IdDepto = 58

SELECt * FROm tb_depto where DesDepartamento like '%financ%'
SELECT * FROM SimpacWeb..tb_SimpacWebPHPAcoes
WHERE desacao like '%o%idalunoagendado%foi%bloqueado%'


SELECT dbo.fnIsBlockBySecretaria(1583460, 1)

sp_FichaAlunosEmpresaTreinamentos_2 '3513120005'
sp_FichaEmpresaTreinamentosv2 '3610102468'

SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE NOME LIKE '%FURIA%'
 
SELECT 
	infinanceiro,
	dbo.fnIsBlockBySecretaria(IdAlunoAgendado, InFinanceiro) AS insecretaria,
	* 
FROM tb_alunoagendado 
where 
	IdAlunoAgendado = 1356936

	InFinanceiro = 0 AND 
	dbo.fnIsBlockBySecretaria(Matricula, InFinanceiro) = 0
	
	
	sp_FichaEmpresaTreinamentosv2 '3610102468'
	sp_FichaAlunosEmpresaTreinamentos_2 '9214050588'
	
SELECT * FROM tb_alunoagendado WHERE IdAlunoAgendado = 1554769
idAlunoAgendado 1554769 foi bloqueado(inFinanceiro: 0)
	
	
SELECT 
	tb_Aluno.NmAluno ,tb_Empresa.NmEmpresa,
    tb_Cursos.DesCurso, tb_CursosAgendados.Dtinicio, 
    tb_CursosAgendados.DtTermino,tb_CursosAgendados.DesOBS,    
	tb_Salas.DesSala,tb_salas.DesEndereco ,tb_CursosAgendados.QtCargaHoraria, 
    tb_Periodo.DesPeriodo,tb_Instrutor.NmUsual,tb_AlunoAgendado.IdAlunoAgendado,
	tb_AlunoAgendado.InFinanceiro,tb_AlunoAgendado.NrFalta,
	tb_CursosAgendados.IdCursoAgendado,tb_salas.DesUnidade,
	tb_salas.IdSala
	
FROM tb_Aluno  (nolock)

left JOIN tb_AlunoAgendado  (nolock) ON  tb_Aluno.IdAluno = tb_AlunoAgendado.IdAluno 
left JOIN tb_AlunoEmpresa  (nolock)  ON tb_AlunoAgendado.IdAlunoAgendado = tb_AlunoEmpresa.IdAlunoAgendado
left JOIN tb_Empresa  (nolock) ON tb_AlunoEmpresa.IdEmpresa = tb_Empresa.IdEmpresa 
left JOIN tb_CursosAgendados  (nolock) ON tb_AlunoAgendado.IdCursoAgendado = tb_CursosAgendados.IdCursoAgendado
left JOIN tb_Cursos  (nolock) ON tb_CursosAgendados.IDCurso = tb_Cursos.IdCurso 
left JOIN tb_Periodo  (nolock) ON tb_Periodo.IdPeriodo = tb_CursosAgendados.IdPeriodo
LEFT JOIN tb_Instrutor  (nolock) ON tb_CursosAgendados.IdInstrutor = tb_Instrutor.IdInstrutor 
left JOIN tb_Salas  (nolock) ON tb_CursosAgendados.IdSala = tb_Salas.IdSala
LEFT JOIN tb_controlefinanceiro ON tb_AlunoAgendado.Matricula = tb_controlefinanceiro.Matricula
LEFT JOIN tb_BloqueioFinanceiro ON tb_BloqueioFinanceiro.NrCPF = tb_aluno.NrCPF
LEFT JOIN tb_usuario ON tb_usuario.IdUsuario = tb_BloqueioFinanceiro.IdUsuario
LEFT JOIN tb_depto ON tb_depto.Iddepto = tb_usuario.IdDepto
WHERE tb_controlefinanceiro.InTipo = 'J' AND tb_depto.DesDepartamento like '%financeira%'
GROUP BY tb_Aluno.NmAluno ,tb_Empresa.NmEmpresa,
    tb_Cursos.DesCurso, tb_CursosAgendados.Dtinicio, 
    tb_CursosAgendados.DtTermino,tb_CursosAgendados.DesOBS, 
    tb_Salas.DesSala,tb_CursosAgendados.QtCargaHoraria, 
    tb_Periodo.DesPeriodo,tb_Instrutor.NmUsual,tb_AlunoAgendado.IdAlunoAgendado,tb_AlunoAgendado.InFinanceiro
    ,tb_AlunoAgendado.NrFalta,tb_Salas.DesEndereco,tb_salas.DesEndereco,tb_CursosAgendados.IdCursoAgendado,
    tb_salas.DesUnidade,tb_salas.IdSala
    
   
    
sp_FichaEmpresaTreinamentosv2 '3610102468'
sp_FichaAlunosEmpresaTreinamentos_2 '2313100159'
k
SELECt * FROM tb_eadbox_cursos
SELECT * FROM tb_depto where Iddepto = 55

SELECT * FROM Impacta4..tb_ECOMMERCECLIENTE WHERE email_cli = 'julio_maluf@hotmail.com'

SELECT * FROM tb_BloqueioFinanceiro
SELECT * FROM tb_alunoagendado order by IdAlunoAgendado desc
SELECT * FROM tb_usuario WHERE IdUsuario = 1884
SELECT * FROM Impacta4..tb_ecommercecliente where cpf_cli =  '27260024801'
SELECT * FROM

SELECT a.*, c.IdUsuario iduser_bloqueado FROM tb_alunoagendado a
INNER JOIN tb_empresa b ON b.IdEmpresa = a.idempresa
LEFT JOIN tb_BloqueioFinanceiro c ON c.NrCPF = b.NrCPF
WHERE a.IdAlunoAgendado = 1111964
------------------------------------
---------- FISICA ------------------
SELECT
	tb_Aluno.NmAluno, tb_Cursos.DesCurso, tb_CursosAgendados.Dtinicio, tb_Aluno.NrCPF,
    tb_CursosAgendados.DtTermino,tb_CursosAgendados.DesOBS,    
    tb_Salas.DesSala,tb_CursosAgendados.QtCargaHoraria, 
    tb_Periodo.DesPeriodo,tb_Instrutor.NmUsual,tb_AlunoAgendado.IdAlunoAgendado,
	tb_AlunoAgendado.InFinanceiro,tb_Salas.DesUnidade,tb_AlunoAgendado.NrFalta,
	tb_Salas.idsala, tb_CursosAgendados.idcursoagendado, tb_AlunoAgendado.idaluno, 
	tb_Instrutor.idinstrutor, 
	tb_alunoagendado.InFinanceiro,
	tb_usuario.NmCompleto,
	tb_depto.DesDepartamento,
	tb_BloqueioFinanceiro.InFinanceiro
FROM tb_AlunoAgendado  (nolock)
    INNER JOIN tb_Aluno  (nolock) ON tb_AlunoAgendado.IdAluno = tb_Aluno.IdAluno
    INNER JOIN tb_CursosAgendados  (nolock)
    ON tb_AlunoAgendado.IdCursoAgendado  = tb_CursosAgendados.IdCursoAgendado
    INNER JOIN tb_Cursos   (nolock) 
    ON tb_CursosAgendados.IDCurso = tb_Cursos.IdCurso 
    INNER JOIN tb_Periodo (nolock)
    ON tb_Periodo.IdPeriodo = tb_CursosAgendados.IdPeriodo
    LEFT JOIN tb_Instrutor   (nolock)
    ON tb_CursosAgendados.IdInstrutor = tb_Instrutor.IdInstrutor 
    INNER JOIN tb_Salas   (nolock)
    ON tb_CursosAgendados.IdSala = tb_Salas.IdSala
	LEFT JOIN tb_controlefinanceiro
	ON tb_AlunoAgendado.Matricula = tb_controlefinanceiro.Matricula
	LEFT JOIN (
		SELECT bf.* FROM (
			SELECT a.* FROM tb_BloqueioFinanceiro	a
			INNER JOIN (
				SELECT NrCPF, max(DtCadastramento) as dtcadastramento FROM tb_BloqueioFinanceiro
				GROUP BY NrCPF
			) b ON b.NrCPF = a.NrCPF AND b.dtcadastramento = a.DtCadastramento
		) bf 
	) a
	ON a.NrCPF = tb_aluno.NrCPF
	LEFT JOIN tb_BloqueioFinanceiro ON tb_BloqueioFinanceiro.IdRegistro = a.IdRegistro
	LEFT JOIN tb_usuario ON tb_usuario.IdUsuario = tb_BloqueioFinanceiro.IdUsuario
	LEFT JOIN tb_depto ON tb_depto.Iddepto = tb_usuario.IdDepto
WHERE (tb_AlunoAgendado.Matricula = '3610102468') and 
	tb_controlefinanceiro.InTipo = 'F' 
ORDER BY tb_alunoagendado.DtCadastramento desc, tb_Aluno.NmAluno, tb_Cursos.DesCurso, tb_CursosAgendados.Dtinicio

SELECT * FROM tb_aluno WHERE NmAluno = 'Júlio Cesar Maluf Valezzi'

SELECT * FROM tb_BloqueioFinanceiro WHERE NrCPF = '34784785884'

SELECT a.* FROM tb_alunoagendado a
INNER JOIN tb_controleFinanceiro b ON b.Matricula = a.Matricula
WHERE a.infinanceiro = 0 and b.InTipo = 'F'
ORDER BY a.DtCadastramento desc

SELECT * FROM tb_controleFinanceiro WHERE Matricula = '3513120005'


SELECT a.NrCPF FROM (
	SELECT NrCPF, max(DtCadastramento) as dtcadastramento FROM tb_BloqueioFinanceiro
	GROUP BY NrCPF
)  a
----------------------------
------------------------------
ALTER  PROCEDURE [dbo].[sp_AlunoBloqueioFinanceiro ]
(@NrCPF varchar(50))
AS
BEGIN
	SELECT 
		a.IdRegistro, a.NrCPF, a.NrCGC, a.InFinanceiro, a.DtCadastramento, a.IdUsuario,
		b.NmLogin, c.DesDepartamento 
	FROM tb_BloqueioFinanceiro a
	INNER JOIN tb_usuario b on b.IdUsuario = a.IdUsuario
	INNER JOIN tb_depto c ON c.Iddepto = b.IdDepto
	WHERE a.NRCPF = @NrCPF and a.InFinanceiro = 1
END

SELECT 
	a.IdRegistro, a.NrCPF, a.NrCGC, a.InFinanceiro, a.DtCadastramento, a.IdUsuario,
	b.NmLogin, c.DesDepartamento 
FROM tb_BloqueioFinanceiro a
INNER JOIN tb_usuario b on b.IdUsuario = a.IdUsuario
INNER JOIN tb_depto c ON c.Iddepto = b.IdDepto

sp_AlunoBloqueioFinanceiro '5914050097'

SELECT * FROM tb_historicofinanceiro

sp_bloqueiofinanceiro_list_cpf '34784785884'