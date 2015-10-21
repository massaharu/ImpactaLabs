With tb_horario_instrutor
as
(
select 
      c.idcursoagendado,a.NmNF as NF, a.DesMotivo Motivo, a.IdContrato as Contrato, b.Instrutor, 
      a.VlHoraAcordado as 'vlhora', b.NmEmpresa as Empresa, 
      b.Treinamento,
      CASE 
		WHEN e.idperiodo in (1,3,4)
		THEN DATEDIFF(MINUTE,c.dtinicio,c.dttermino)- 60
		ELSE DATEDIFF(MINUTE,c.dtinicio,c.dttermino)
	END as DIF,		
      COUNT(treinamento) as total, d.QtCargaHoraria as CH, 
      e.DesPeriodo as Periodo,e.idperiodo
      from tb_contrato a 
            inner join v_InstrutorCursosMinistrados b
      on b.idinstrutor = a.idinstrutor 
            inner join tab_cursosagendados_datas c
      on c.idinstrutor = b.idinstrutor and a.idcursoagendado = c.idcursoagendado
            inner join tb_cursosagendados d
      on c.idcursoagendado = d.idcursoagendado and d.idcurso = b.idcurso
            inner join tb_periodo e
      on c.idperiodo = e.idperiodo
      
      group by c.idcursoagendado,a.NmNF,a.DesMotivo, a.IdContrato, b.Instrutor, a.VlHoraAcordado, 
               b.NmEmpresa, b.Treinamento, d.QtCargaHoraria, e.DesPeriodo, c.dtinicio, 
               c.dttermino,e.idperiodo
)
Select 
	a.contrato as 'Nrº Contrato',a.instrutor,'R$ '+cast(a.vlhora as varchar(20)), a.empresa, a.treinamento,sum(dif) as minutos,
	 a.ch, a.periodo, CONVERT(VARCHAR(10),b.dtinicio, 103) as 'Inicio', CONVERT(VARCHAR(10),b.dttermino, 103) as 'Termino',a.motivo,
	 'R$ '+cast(dbo.fn_myfunction(sum(dif), a.ch, a.vlhora) as varchar(20)) as 'Valor Total'
from tb_horario_instrutor a
inner join tb_cursosagendados b
on a.idcursoagendado = b.idcursoagendado
Group by 
	a.idcursoagendado,a.nf,a.motivo,a.contrato,a.instrutor,a.vlhora,a.empresa,a.treinamento,
	a.total,
	a.ch, a.periodo, a.idperiodo,b.dtinicio,b.dttermino 
order by a.Instrutor, b.dtinicio

------------------------------------------------------------------------------------------------
ALTER FUNCTION fn_myfunction
(@min int, @ch int, @vlhora decimal(10,2))
RETURNS decimal(10,2)
AS
BEGIN
	DECLARE @DIFF decimal(10,2), @VALUE decimal(10, 2)
	SET @DIFF = cast(@min as decimal(10,2))/60
	
	IF(@DIFF < @ch)
		SET @DIFF = @ch
	
	SET @VALUE = @DIFF * @vlhora
	RETURN @VALUE
	
END
------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------

select cast(60 as decimal(10,2))/60


-------
SELECT CONVERT(VARCHAR(10), GETDATE(), 108)
	
	
------SELECT * FROM v_InstrutorCursosMinistrado
SELECT    TOP (100) PERCENT dbo.tb_Instrutor.NmInstrutor AS Instrutor, dbo.tb_EmpresaInstrutor.NmEmpresa, dbo.tb_Cursos.DesCurso AS Treinamento, 
                      dbo.tb_CursosMinistrados.Valor, dbo.tb_Cursos.IdCurso, dbo.tb_Instrutor.IdInstrutor
FROM         dbo.tb_Instrutor INNER JOIN
                      dbo.tb_CursosMinistrados ON dbo.tb_Instrutor.IdInstrutor = dbo.tb_CursosMinistrados.IdInstrutor INNER JOIN
                      dbo.tb_EmpresaInstrutor ON dbo.tb_EmpresaInstrutor.IdEmpresa = dbo.tb_Instrutor.IdEmpresa INNER JOIN
                      dbo.tb_Cursos ON dbo.tb_CursosMinistrados.IdCurso = dbo.tb_Cursos.IdCurso
WHERE     (dbo.tb_Instrutor.InStatus = 1)
GROUP BY dbo.tb_Instrutor.NmInstrutor, dbo.tb_EmpresaInstrutor.NmEmpresa, dbo.tb_CursosMinistrados.Valor, dbo.tb_Instrutor.IdInstrutor, dbo.tb_CursosMinistrados.IdCurso, 
                      dbo.tb_Cursos.DesCurso, dbo.tb_Cursos.IdCurso
order by dbo.tb_instrutor.NmInstrutor