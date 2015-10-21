use DEV_TESTE

select * from tb_teste

insert into tb_teste values('Bruna Sanches Sant'' Ana')

sp_checklist_sala_list 1, '2014-01-24', NULL, NULL, NULL

sp_checklist_combo_list 1, '2014-05-08 00:00', NULL, NULL, '1,2,4,6,7,8'

sp_checklist_ativo_list 1, '2014-05-08 00:00', NULL, NULL, NULL, '1,2,4,6,7,8'

sp_checklist_list 1, '2014-05-08 00:00', NULL, NULL, '1,2,4,6,7,8'

sp_checklist_tarefas_info_list 116788, '2014-01-21 00:00'

sp_atividade_extra_get 1, 141 , '2014-05-07 00:00', '2014-05-07 23:59'

select * from simpac..tb_periodo

select * from simpac..tb_salas b 
inner join iv..tb_andares b1 on b.idandar = b1.idandar

select * from iv..tb_andares where idunidade = 1

UPDATE tb_atividadeextra_check 
SET descricao = '2342'
WHERE idatividade = 1256

USE suporte
SELECT * FROM tb_atividadeextra_suporte
SELECT * FROM tb_atividadeextra_check order by idatividade desc where idcursoagendado = 117018
SELECT * FROM tb_categoriaatividade
SELECT * FROM tb_checklist
SELECT * FROM tb_checklist_tarefas_curso
SELECT * FROM Simpac..tb_cursosagendados WHERE idcursoagendado = 118718
SELECT * FROM Simpac..tab_cursosagendados_datas WHERE idcursoagendado = 118718
SELECT * FROM tb_checklist_tarefas_curso
SELECT * FROM tb_checklist_tarefas
SELECT * FROM simpac..tb_periodo

select a.idcursoagendado,e.idcurso, e.descurso, a.idsala, b.dessala, a.idperiodo, c.desperiodo, d.dtinicio,d.dttermino, 
suporte.dbo.getChecklistStatus(a.idcursoagendado, '2014-01-22 00:00'), f.idcursoagendado as idatividadecomputador, desandar, 
b.idandar, g.idchecklist, f.idatividade, h.idcategoria, h.descategoria 
from simpac..tab_cursosagendados_datas a
inner join simpac..tb_salas b on a.idsala = b.idsala
inner join iv..tb_andares b1 on b.idandar = b1.idandar
inner join simpac..tb_periodo c on a.idperiodo = c.idperiodo
inner join simpac..tb_cursosagendados d on a.idcursoagendado = d.idcursoagendado
inner join simpac..tb_cursos e on d.idcurso = e.idcurso
left join tb_atividadeextra_check f on a.idcursoagendado = f.idcursoagendado
left join tb_checklist g on a.idcursoagendado = g.idcursoagendado
left join tb_categoriaatividade h on h.idcategoria = f.idcategoria
where (convert(date,f.dtcadastro) = CONVERT(date, '2014-01-22 00:00') or convert(date,g.dtcadastro) = CONVERT(date, '2014-01-22 00:00'))
and b1.idunidade = 1
and a.idsala not in(13,30)

<span style="background-color: rgb(255, 255, 255);"><span style="color: rgb(0, 0, 0);">Descrição des</span>crição&nbsp;descrição&nbsp;descrição&nbsp;descriçã</span><span style="background-color: rgb(51, 51, 0);">o&nbsp;des</span><span style="background-color: rgb(255, 255, 255);">crição&nbsp;descrição&nbsp;descrição&nbsp;descrição</span>

select d.idcursoagendado,e.idcurso, e.descurso, d.idsala, b.dessala, d.idperiodo, c.desperiodo, d.dtinicio,d.dttermino,
 desandar, b.idandar, f.idatividade from simpac..tb_cursosagendados d
inner join simpac..tb_salas b on d.idsala = b.idsala
inner join iv..tb_andares b1 on b.idandar = b1.idandar
inner join simpac..tb_periodo c on d.idperiodo = c.idperiodo
inner join simpac..tb_cursos e on d.idcurso = e.idcurso
inner join tb_atividadeextra_check f on d.idcursoagendado = f.idcursoagendado
where convert(date,f.dtcadastro) = CONVERT(date, '2014-01-22 00:00')
and b1.idunidade = 1
and d.idsala not in(13,30)
and d.idsala = 0
order by f.idatividade

select * from tb_checklist
WHERE idchecklist in(
	SELECT g.idchecklist
		FROM simpac..tb_cursosagendados d
		INNER JOIN simpac..tb_salas b		ON d.idsala = b.idsala
		INNER JOIN iv..tb_andares b1		ON b.idandar = b1.idandar
		INNER JOIN simpac..tb_periodo c		ON d.idperiodo = c.idperiodo
		INNER JOIN simpac..tb_cursos e		ON d.idcurso = e.idcurso
		INNER JOIN tb_checklist g			ON d.idcursoagendado = g.idcursoagendado
		WHERE convert(DATE,g.dtcadastro) = CONVERT(DATE, '2014-01-22 00:00:00')
			AND b1.idunidade = 1
			AND d.idsala not in(13,30)
)

sp_checklist_tarefas_list
sp_checklist_tarefas_get 36
sp_checklist_tarefas_curso_get 36
sp_checklist_tarefas_curso_list 116272, '2014-02-17'

SELECT * FROM tb_checklist_tarefas_curso
SELECT * FROM tb_checklist_tarefas

select *
from tb_checklist_tarefas a
left join tb_checklist_tarefas_curso c on a.idtarefa = c.idtarefa
where c.idtarefa is null 


--ATIVIDADE
idcursoagendado,
idunidade,
idsala,
idperiodo

--CHECKLIST 


-----------------------------------------------------------------------------
ALTER TABLE tb_atividadeextra_check
	ALTER COLUMN descrição varchar(max)

---------------------------------------------------------------------------
--------------------- PROCEDURES ------------------------------------------
---------------------------------------------------------------------------
ALTER PROC sp_atividadeextra_check_remove --'2014-01-22', 6, 182
(@idsatividade varchar(500))
AS
/*
app: SimpacWeb
url: /simpacweb/modulos/suporte/checklist_sala/json/atividadeextra_check_remove.php
data: 2013-03-21
author: Massa
*/
BEGIN
	DELETE tb_atividadeextra_check
	WHERE idatividade IN (
		SELECT id FROM fnSplit(@idsatividade, ',')
	)
END
--
SELECT * FROM tb_atividadeextra_check
WHERE idatividade in (
	SELECT id FROM fnSplit('1308, 1309', ',')
)

SELECT * FROM tb_atividadeextra_check
WHERE idatividade IN (
		select f.idatividade 
		FROM simpac..tb_cursosagendados d
		INNER JOIN simpac..tb_salas b			ON d.idsala = b.idsala
		INNER JOIN iv..tb_andares b1			ON b.idandar = b1.idandar
		INNER JOIN simpac..tb_periodo c			ON d.idperiodo = c.idperiodo
		INNER JOIN simpac..tb_cursos e			ON d.idcurso = e.idcurso
		INNER JOIN tb_atividadeextra_check f	ON d.idcursoagendado = f.idcursoagendado
		WHERE convert(DATE, f.dtcadastro) = CONVERT(DATE, '2014-05-06')
			AND b1.idunidade = 1
			AND d.idsala NOT IN(13,30)
			AND d.idsala = 141 
			AND c.idperiodo = 1
	)
---------------------------------------------------------------------------
ALTER PROC sp_checklist_tarefa_remove --'2014-01-22 00:00:00', 6, 52
(@idcursoagendado int, @data datetime, @idperiodo int, @idsala int, @idunidade int = 1)
AS
/*
app: SimpacWeb
url: /simpacweb/modulos/suporte/checklist_sala/json/checklist_remove.php
data: 2013-03-21
author: Massa
*/
BEGIN
	DELETE tb_checklist
	WHERE idchecklist IN (
		SELECT g.idchecklist
		FROM simpac..tb_cursosagendados d
		INNER JOIN simpac..tb_salas b		ON d.idsala = b.idsala
		INNER JOIN iv..tb_andares b1		ON b.idandar = b1.idandar
		INNER JOIN simpac..tb_periodo c		ON d.idperiodo = c.idperiodo
		INNER JOIN simpac..tb_cursos e		ON d.idcurso = e.idcurso
		INNER JOIN tb_checklist g			ON d.idcursoagendado = g.idcursoagendado
		WHERE convert(DATE,g.dtcadastro) = CONVERT(DATE, @data)
			AND b1.idunidade = @idunidade
			AND d.idsala not in(13,30)
			AND d.idsala = @idsala
			AND c.IdPeriodo = @idperiodo
			AND d.IdCursoAgendado = @idcursoagendado
	)
END
--
SELECT g.idchecklist
FROM simpac..tb_cursosagendados d
INNER JOIN simpac..tb_salas b		ON d.idsala = b.idsala
INNER JOIN iv..tb_andares b1		ON b.idandar = b1.idandar
INNER JOIN simpac..tb_periodo c		ON d.idperiodo = c.idperiodo
INNER JOIN simpac..tb_cursos e		ON d.idcurso = e.idcurso
INNER JOIN tb_checklist g			ON d.idcursoagendado = g.idcursoagendado
WHERE convert(DATE,g.dtcadastro) = CONVERT(DATE, @data)
	AND b1.idunidade = @idunidade
	AND d.idsala not in(13,30)
	AND d.idsala = @idsala
	AND c.IdPeriodo = @idperiodo
	AND d.IdCursoAgendado = 
---------------------------------------------------------------------------
ALTER PROC sp_atividadeextra_suporte_remove
(@idatividadesuporte int)
AS
/*
app: SimpacWeb
url: /simpacweb/modulos/suporte/checklist_sala/ajax/atividadeSuporte_remove.php
data: 2013-03-21
author: Massa
*/
BEGIN
	DELETE tb_atividadeextra_suporte
	WHERE idatividadesuporte = @idatividadesuporte
END

SELECT * FROM tb_atividadeextra_suporte
---------------------------------------------------------------------------
CREATE PROC sp_atividadedepartamento_remove
(@idatividadedepartamento int)
AS
/*
app: SimpacWeb
url: /simpacweb/modulos/suporte/checklist_sala/ajax/atividadeDeptSuporte_remove.php
data: 2013-03-21
author: Massa
*/
BEGIN
	DELETE tb_atividadedepartamento
	WHERE idatividadedepartamento = @idatividadedepartamento
END

SELECT * FROM tb_atividadedepartamento

sp_atividadedepartamento_list 
-----------------------------------------------------------------
ALTER PROC sp_atividadeextra_by_sala_list
(@idcursoagendado int, @idunidade int, @idsala int, @dti DATETIME, @dtf DATETIME)
AS
/*
app: SimpacWeb
url: /simpacweb/modulos/suporte/checklist_sala/ajax/atividadeextra_by_sala_list.php
data: 2014-05-26
author: Massa
*/
BEGIN
	SELECT DISTINCT
		a.idcursoagendado
		,a.idsala
		,a.idunidade
		,a.idcategoria
		,e.descategoria
		,a.descricao
		,f.nmlogin
		,f.idusuario
	FROM tb_atividadeextra_check a
	LEFT JOIN simpac..tb_usuario f		ON a.idusuario = f.idusuario
	INNER JOIN tb_categoriaatividade e	ON a.idcategoria = e.idcategoria
	WHERE 
		e.instatus = 1 AND 
		a.idunidade = @idunidade AND 
		a.idsala = @idsala AND 
		a.dtcadastro BETWEEN @dti AND @dtf AND
		a.idcursoagendado = @idcursoagendado
	ORDER BY  a.idcategoria, a.descricao
END
--
SELECT * FROM tb_atividadeextra_check
sp_atividadeextra_by_sala_list 1, 141, '2014-05-07 00:00', '2014-05-07 23:59'
sp_atividadeextra_by_sala_list 1, 123,'2014-05-08 00:00:00','2014-05-08 23:59:59'


sp_atividadeextra_by_sala_list 1, 123,'2014-05-08 00:00:00','2014-05-08 23:59:59'

-----------------------------------------------------------------
ALTER PROC sp_atividadeextra_computadores_list
(
	@idcursoagendado int,
	@idunidade int, 
	@idsala int, 
	@idcategoria int, 
	@descricao varchar(5000),
	@dti DATETIME, 
	@dtf DATETIME
)
/*
app: SimpacWeb
url: /simpacweb/modulos/suporte/checklist_sala/ajax/atividadeextra_computadores_list.php
data: 2014-05-26
author: Massa
*/
AS
BEGIN
	SELECT
		a.idatividade
		,a.idcomputador
		,ISNULL(d.desnomecomputador, 'Sem Máquina') as desnomecomputador
		,a.idsala
		,a.idunidade
		,a.idcategoria
		,e.descategoria
		,a.descricao
		,a.dtcadastro
		, f.nmlogin
		, f.idusuario
	FROM tb_atividadeextra_check a
	LEFT JOIN IV..tb_itenssalacomputadores b	on a.idcomputador = b.idcomputador
	LEFT JOIN IV..tb_itenssala c				on b.iditemsala = c.iditemsala
	LEFT JOIN IV..tb_computadores d				on b.idcomputador = d.idcomputador
	LEFT JOIN simpac..tb_usuario f				on a.idusuario = f.idusuario
	INNER JOIN tb_categoriaatividade e			on a.idcategoria = e.idcategoria
	WHERE 
		e.instatus = 1 and 
		a.idunidade = @idunidade and 
		a.idsala = @idsala and 
		a.idcategoria = @idcategoria and
		a.descricao = @descricao and
		a.dtcadastro between @dti and @dtf and
		a.idcursoagendado = @idcursoagendado
	ORDER BY d.desnomecomputador, a.idcategoria, a.descricao
END

SELECT * FROM tb_atividadeextra_check

sp_atividadeextra_computadores_list 1, 141, 3, 'Rede ZUADA', '2014-05-07 00:00', '2014-05-07 23:59'
sp_atividadeextra_computadores_list 1, 47, 2, 'aa', '2014-05-07 00:00', '2014-05-07 23:59'
sp_atividadeextra_computadores_list 1, 140, 5, 'descrição', '2014-05-08 00:00', '2014-05-08 23:59'
sp_atividadeextra_computadores_list 116725, 1, 123, 7, '<span style=background-color: rgb(255, 255, 255);>Zuada </span><span style=background-color: rgb(153, 51, 0);>zuada</span>', '2014-05-08 00:00', '2014-05-08 23:59'

-----------------------------------------------------------------
-----------------------------------------------------------------
-----------------------------------------------------------------
SELECT
	a.idcursoagendado
	,a.idatividade
	,a.idcomputador
	,ISNULL(d.desnomecomputador, 'Sem Máquina') as desnomecomputador
	,a.idsala
	,a.idunidade
	,a.idcategoria
	,e.descategoria
	,a.descricao
	,a.dtcadastro
	, f.nmlogin
	, f.idusuario
FROM tb_atividadeextra_check a
LEFT JOIN IV..tb_itenssalacomputadores b	on a.idcomputador = b.idcomputador
LEFT JOIN IV..tb_itenssala c				on b.iditemsala = c.iditemsala
LEFT JOIN IV..tb_computadores d				on b.idcomputador = d.idcomputador
LEFT JOIN simpac..tb_usuario f				on a.idusuario = f.idusuario
INNER JOIN tb_categoriaatividade e			on a.idcategoria = e.idcategoria
WHERE 
	e.instatus = 1 and 
	a.idunidade = 1 and 
	a.idsala = 123 and 
	a.idcategoria = 7 and
	a.descricao like '<span style=background-color: rgb(255, 255, 255);>Zuada </span><span style=background-color: rgb(153, 51, 0);>zuada</span>' and
	a.dtcadastro between '2014-05-08 00:00' and '2014-05-08 23:59' 
	--a.idcursoagendado = 116725
ORDER BY d.desnomecomputador, a.idcategoria, a.descricao
<span style="background-color: rgb(255, 255, 255);">Zuada </span><span style="background-color: rgb(153, 51, 0);">zuada</span>	
<span style="background-color: rgb(255, 255, 255);">Zuada </span><span style="background-color: rgb(153, 51, 0);">zuada</span>
<span style="background-color: rgb(255, 255, 255);">Zuada </span><span style="background-color: rgb(153, 51, 0);">zuada</span>
<span style="background-color: rgb(255, 255, 255);>Zuada </span><span style=background-color: rgb(153, 51, 0);>zuada</span>
	
SELECT * FROM tb_atividadeextra_check
DELETE tb_atividadeextra_check
WHERE idatividade IN (
		select f.idatividade 
		FROM simpac..tb_cursosagendados d
		INNER JOIN simpac..tb_salas b			ON d.idsala = b.idsala
		INNER JOIN iv..tb_andares b1			ON b.idandar = b1.idandar
		INNER JOIN simpac..tb_periodo c			ON d.idperiodo = c.idperiodo
		INNER JOIN simpac..tb_cursos e			ON d.idcurso = e.idcurso
		INNER JOIN tb_atividadeextra_check f	ON d.idcursoagendado = f.idcursoagendado
		WHERE convert(DATE, f.dtcadastro) = CONVERT(DATE, '2014-05-07')
			AND b1.idunidade = 1
			AND d.idsala NOT IN(13,30)
			AND d.idsala = 141 
			AND c.idperiodo = 1
	)
	
	
SELECT * FROM tb_atividadeextra_check
WHERE descricao = '~´´;;´;´43;5;5´2´345~´1~´4~12´;3'
sp_atividadeextra_computadores_list 1, 139, 4, '~´´;;´;´43;5;5´2´345~´1~´4~12´;3', '2014-05-08 00:00', '2014-05-08 23:59'

SELECT
	a.idatividade
	,a.idcomputador
	,ISNULL(d.desnomecomputador, 'Sem Máquina') as desnomecomputador
	,a.idsala
	,a.idunidade
	,a.idcategoria
	,e.descategoria
	,a.descricao
	,a.dtcadastro
	, f.nmlogin
	, f.idusuario
FROM tb_atividadeextra_check a
LEFT JOIN IV..tb_itenssalacomputadores b	on a.idcomputador = b.idcomputador
LEFT JOIN IV..tb_itenssala c				on b.iditemsala = c.iditemsala
LEFT JOIN IV..tb_computadores d				on b.idcomputador = d.idcomputador
LEFT JOIN simpac..tb_usuario f				on a.idusuario = f.idusuario
INNER JOIN tb_categoriaatividade e			on a.idcategoria = e.idcategoria
WHERE 
	e.instatus = 1 and 
	a.idunidade = 1 and 
	a.idsala = 139 and 
	a.idcategoria = 4 and
	a.dtcadastro between '2014-05-08 00:00' and '2014-05-08 23:59'
GROUP BY a.idatividade
	,a.idcomputador
	, desnomecomputador
	,a.idsala
	,a.idunidade
	,a.idcategoria
	,e.descategoria
	,a.descricao
	,a.dtcadastro
	, f.nmlogin
	, f.idusuario
ORDER BY d.desnomecomputador, a.idcategoria, a.descricao

SELECT idcategoria, descricao FROM tb_atividadeextra_check
GROUP BY idcategoria, descricao

select 
	a.idcursoagendado,e.idcurso, e.descurso, a.idsala, b.dessala, a.idperiodo, c.desperiodo, 
	a.dtinicio, a.dtinicio,a.dttermino, suporte.dbo.getChecklistStatus(a.idcursoagendado, '2014-05-08') 
from simpac..tb_cursosagendados a
inner join simpac..tb_salas b			on a.idsala = b.idsala
inner join iv..tb_andares b1			on b.idandar = b1.idandar
inner join simpac..tb_periodo c			on a.idperiodo = c.idperiodo
inner join simpac..tb_cursos e			on a.idcurso = e.idcurso
where (
		convert(date,a.dtinicio) <= CONVERT(date, '2014-05-08') and
		convert(date,a.dttermino) >= CONVERT(date, '2014-05-08')
	)
	and b1.idunidade = 1
	and a.idsala not in(13,30)
		
SELECT * FROM simpac..tb_cursosagendados		


SELECt * FROM simpac..tb_cursosagendados 
WHERE idcursoagendado = 120799	
SELECt * FROM simpac..tab_cursosagendados 
WHERE idcursoagendado = 120799	
SELECT * FROM simpac..tab_cursosagendados_datas	
WHERE idcursoagendado = 120799	