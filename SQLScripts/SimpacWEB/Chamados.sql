-- ALTERADO
DECLARE @idchamado INT

set @idchamado = 1297

SELECT
a.idchamado,
a.idsolicitante,
a.deschamado,
i.descomentario as desobs,
a.dtprevisao,
a.dtcadastro,
a.idusuario,
a.idstatus,
g.desstatus,
min(b.dtinicio) dtiniciotarefas,
max(b.dttermino) dtterminotarefas,
sum(b.nrduracao) nrduracaototal,
DATEDIFF(SECOND, GETDATE(), max(b.dttermino)) as nrsegundosrestantes,
(
	SELECT COUNT(*)
	FROM tb_chamados c
	INNER JOIN tb_tarefas d ON c.idchamado = d.idchamado
	INNER JOIN tb_chamadoprogress e On d.idtarefa = e.idtarefa
	WHERE c.idchamado = a.idchamado AND e.dttermino IS NULL
) AS intrabalhando,
(SELECT SUM(DATEDIFF(SECOND, g.dtinicio, ISNULL(g.dttermino,GETDATE())))
FROM tb_tarefas f
INNER JOIN tb_chamadoprogress g On f.idtarefa = g.idtarefa
WHERE f.idchamado = a.idchamado) AS nrsegundostrabalhados
FROM tb_chamados a
INNER JOIN tb_tarefas b ON a.idchamado = b.idchamado
INNER JOIN tb_status g ON a.idstatus = g.idstatus
INNER JOIN tb_relacaochamadosprechamados h ON h.idchamado = a.idchamado
INNER JOIN tb_prechamado i ON i.idprechamado = h.idprechamado
WHERE a.idchamado = @idchamado
GROUP BY 
a.idchamado,
a.idsolicitante,
a.deschamado,
i.descomentario,
a.dtprevisao,
a.dtcadastro,
a.idusuario,
a.idstatus,
g.desstatus
---------------------
---------------------
---------------------
-- ORIGINAL
SELECT
a.idchamado,
a.idsolicitante,
a.deschamado,
a.desobs,
a.dtprevisao,
a.dtcadastro,
a.idusuario,
a.idstatus,
g.desstatus,
min(b.dtinicio) dtiniciotarefas,
max(b.dttermino) dtterminotarefas,
sum(b.nrduracao) nrduracaototal,
DATEDIFF(SECOND, GETDATE(), max(b.dttermino)) as nrsegundosrestantes,
(
	SELECT COUNT(*)
	FROM tb_chamados c
	INNER JOIN tb_tarefas d ON c.idchamado = d.idchamado
	INNER JOIN tb_chamadoprogress e On d.idtarefa = e.idtarefa
	WHERE c.idchamado = a.idchamado AND e.dttermino IS NULL
) AS intrabalhando,
(SELECT SUM(DATEDIFF(SECOND, g.dtinicio, ISNULL(g.dttermino,GETDATE())))
FROM tb_tarefas f
INNER JOIN tb_chamadoprogress g On f.idtarefa = g.idtarefa
WHERE f.idchamado = a.idchamado) AS nrsegundostrabalhados
FROM tb_chamados a
INNER JOIN tb_tarefas b ON a.idchamado = b.idchamado
INNER JOIN tb_status g ON a.idstatus = g.idstatus
WHERE a.idchamado = @idchamado
GROUP BY 
a.idchamado,
a.idsolicitante,
a.deschamado,
a.desobs,
a.dtprevisao,
a.dtcadastro,
a.idusuario,
a.idstatus,
g.desstatus
-----------------------------------------------------------

select * from tb_chamados 
select * from tb_prechamado where idprechamado = 1616
select * from tb_relacaochamadosprechamados where idprechamado = 1616
sp_meusprechamados_list 67


select * from simpac..tb_usuario where nmlogin = 'faraujo'

sp_chamado_get 1297

select * from tb_chamados where idchamado = 1297


select a.idchamado, a.desobs, LEN(a.desobs), c.descomentario, LEN(c.descomentario)
FROM tb_chamados a 
LEFT JOIN tb_relacaochamadosprechamados b ON b.idchamado = a.idchamado
LEFT JOIN tb_prechamado c ON c.idprechamado = b.idprechamado