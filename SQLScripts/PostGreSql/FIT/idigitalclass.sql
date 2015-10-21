
-----------------------------------------------------------------------
------------------- PEGA A AULA PELO IDAULA(NOME ARQUIVO) -------------
-----------------------------------------------------------------------
SELECT 
	c.id as id_aula,  
	b.id as id_preaula,
	b.descricao as desc_preaula,
	c.nomearquivo as nomearquivo_aulabase,
	d.id as idprogramadeaula,
	f.id as idperiodo,
	f.nome as periodo,
	e.id as idcurso,
	e.nome as curso,
	g.id as idturma,
	g.nome as turma,
	i.id as iddisciplina,
	i.nome as disciplina,
	h.nome as professor,
	c.inicio as inicio_aulabase,
	a.termino as termino_aula
FROM tblaulabase c
LEFT JOIN tblaula a ON a.id = c.id
LEFT JOIN tblpreaula b ON b.id = a.fk_preaula
LEFT JOIN tblprogramadeaula d ON d.id = c.fk_programadeaula
LEFT JOIN tblcurso e ON e.id = d.fk_curso
INNER JOIN tblperiododecurso f ON f.id = d.fk_periodo
INNER JOIN tblturma g ON g.id = d.fk_turma
INNER JOIN tblusuario h ON h.id = d.fk_professor
INNER JOIN tbldisciplina i ON i.id = d.fk_disciplina
INNER JOIN tblpreaulaarquivo j ON j.fk_preaula = b.id
WHERE j.nome='FIT 2015 Met Cen.xlsx'--c.id = 25197 -- nome do arquivo sem extenção
ORDER BY c.id
     
SELECT * FROM tblaulabase where id = 34117
SELECT * FROM tblaula where id = 34117-id = 35711 
SELECT * FROM tblpreaula where id = 34117
SELECT * FROM tblpreaulaarquivo WHERE fk_preaula = 34117
SELECT * FROM tblpreaulaarquivo WHERE nome='IA_06.pdf'

SELECT * FROM tblaulabase WHERE fk_professor = 4 AND inicio = '2014-09-10'
SELECT * FROM tblsaladeaula where id = 39
SELECT * FROM tblprogramadeaula
SELECT * FROM tblusuario WHERE login = '264'
-----------------------------------------------------------------------
------------------- VERIFICA SE A AULA JÀ EXISTE ----------------------
-----------------------------------------------------------------------
SELECT 
	max(c.id) as idaula,  
	max(b.id) as idpreaula,
	max(a.id) as idaula,
	h.id as idprofessor,
	h.nome as desprofessor,
	e.id as idcurso,
	e.nome as descurso,
	g.id as idturma,
	g.nome as desturma,
	i.id as iddisciplina,
	i.nome as desdisciplina,
	max(b.descricao) as desdescricao,
	CAST(max(c.inicio) AS DATE) as dtaula,
	max(a.termino) as dtaula_termino,
	f.id as idperiodo,
	f.nome as periodo,
	'old' as desorigem
FROM tblaulabase c
LEFT JOIN tblaula a ON c.id = a.id
LEFT JOIN tblpreaula b ON b.id = c.id
LEFT JOIN tblprogramadeaula d ON d.id = c.fk_programadeaula
LEFT JOIN tblcurso e ON e.id = d.fk_curso
LEFT JOIN tblperiododecurso f ON f.id = d.fk_periodo
LEFT JOIN tblturma g ON g.id = d.fk_turma
LEFT JOIN tblusuario h ON h.id = d.fk_professor
LEFT JOIN tbldisciplina i ON i.id = d.fk_disciplina
INNER JOIN tblpreaulaarquivo j ON j.fk_preaula = b.id
WHERE 
	CAST(c.inicio AS date) = '2014-08-27' AND
	g.id = 37 AND
	i.id = 247
GROUP BY
	h.id,
	b.id,
	h.nome,
	e.id,
	e.nome,
	g.id,
	g.nome,
	i.id,
	i.nome,
	CAST(c.inicio AS DATE),
	f.id,
	f.nome,
	desorigem	
ORDER BY max(c.inicio)
-----------------------------------------------------------------------
------------------- LISTA AS AULAS ------------------------------------
-----------------------------------------------------------------------
SELECT 
	max(c.id) as idaula,  
	max(a.id) as id,
	max(b.id) as idpreaula,
	h.id as idprofessor,
	h.nome as desprofessor,
	e.id as idcurso,
	e.nome as descurso,
	g.id as idturma,
	g.nome as desturma,
	i.id as iddisciplina,
	i.nome as desdisciplina,
	max(b.descricao) as desdescricao,
	CAST(max(c.inicio) AS DATE) as dtaula,
	max(a.termino) as dtaula_termino,
	f.id as idperiodo,
	f.nome as periodo,
	'old' as desorigem
FROM tblaulabase c
LEFT JOIN tblaula a ON c.id = a.id
LEFT JOIN tblpreaula b ON b.id = c.id
LEFT JOIN tblprogramadeaula d ON d.id = c.fk_programadeaula
LEFT JOIN tblcurso e ON e.id = d.fk_curso
INNER JOIN tblperiododecurso f ON f.id = d.fk_periodo
INNER JOIN tblturma g ON g.id = d.fk_turma
INNER JOIN tblusuario h ON h.id = d.fk_professor
INNER JOIN tbldisciplina i ON i.id = d.fk_disciplina
INNER JOIN tblpreaulaarquivo j ON j.fk_preaula = b.id
WHERE 
	f.id = 10 AND 
	--(c.inicio >= '2014-08-20' AND c.inicio <= '2014-12-30') AND
	c.inicio BETWEEN 
		'2015-02-02' AND '2015-06-24 23:59:59' AND
	h.login = '264' 
GROUP BY
	h.id,
	h.nome,
	e.id,
	e.nome,
	g.id,
	g.nome,
	i.id,
	i.nome,
	CAST(c.inicio AS DATE),
	f.id,
	f.nome,
	desorigem	
ORDER BY max(c.inicio)
--
SELECt * FROM tblaulabase a
LEFT JOIN tblaula b ON b.id = a.id
LEFT JOIN tblpreaula c ON c.id = b.fk_preaula
WHERE a.id = 33105

SELECT * FROM tblaulabase WHERE id = 33105
SELECT * FROM tblaula WHERE 

SELECt * FROM tblpreaula a
INNER JOIN tblpreaulaarquivo b ON a.id = b.fk_preaula
where b.nome like '%Projeto%de%Pesquisa%Cientifica%assinado%'

SELECT * FROM tblaulabase a
INNER JOIN tblprogramadeaula b ON b.id = a.fk_programadeaula
INNER JOIN tblusuario c ON c.id = b.fk_professor
INNER JOIN tblaula d ON d.id = a.id
WHERE a.inicio = '2014-08-27' AND c.login = '264'

SELECT * FROM tblperiododecurso
SELECT * FROM tblusuario where login = '264'
-------------------------------------------------------------------------
---------------- LISTA AS PRE-AULAS DA AULA -----------------------------
-------------------------------------------------------------------------
SELECT
	j.id as idarquivo,
	j.nome as desarquivo,
	NULL as nrtamanho,
	1 as idarquivotipo,
	'Pre-aula' as desarquivotipo,
	j.caminho as descaminho,
	1 as instatus,
	max(c.inicio) as dtcadastro
FROM tblaulabase c
LEFT JOIN tblaula a ON c.id = a.id
LEFT JOIN tblpreaula b ON b.id = a.fk_preaula
LEFT JOIN tblprogramadeaula d ON d.id = c.fk_programadeaula
LEFT JOIN tblcurso e ON e.id = d.fk_curso
INNER JOIN tblperiododecurso f ON f.id = d.fk_periodo
INNER JOIN tblturma g ON g.id = d.fk_turma
INNER JOIN tblusuario h ON h.id = d.fk_professor
INNER JOIN tbldisciplina i ON i.id = d.fk_disciplina
INNER JOIN tblpreaulaarquivo j ON j.fk_preaula = b.id
WHERE 
	g.id = 37 AND
	i.id = 247 AND
	CAST(c.inicio as date) = CAST('2015-02-24' AS DATE)	
GROUP BY
	j.id,
	desarquivo,
	nrtamanho,
	idarquivotipo,
	desarquivotipo,
	j.caminho,
	instatus
ORDER BY 
	j.id
---
SELECT * FROM tblaula WHERE id IN(17764,17861,18432,18756,18823,23488)
SELECT * FROM tblpreaula
SELECT * FROM tblpreaulaarquivo

-------------------------------------------------------------------------
------------------ LISTA OS VIDEOS DA AULA ------------------------------
-------------------------------------------------------------------------
SELECT 
	a.id as idarquivo,  
	c.nomearquivo as desarquivo,
	NULL as nrtamanho,
	2 as idarquivotipo,
	'Vídeos' as desarquivotipo,
	('/storages/video/'||a.id ||'/'||c.nomearquivo) as descaminho,
	1 as instatus,
	max(c.inicio) as dtcadastro
FROM tblaulabase c
LEFT JOIN tblaula a ON c.id = a.id
LEFT JOIN tblpreaula b ON b.id = a.fk_preaula
LEFT JOIN tblprogramadeaula d ON d.id = c.fk_programadeaula
LEFT JOIN tblcurso e ON e.id = d.fk_curso
INNER JOIN tblperiododecurso f ON f.id = d.fk_periodo
INNER JOIN tblturma g ON g.id = d.fk_turma
INNER JOIN tblusuario h ON h.id = d.fk_professor
INNER JOIN tbldisciplina i ON i.id = d.fk_disciplina
WHERE 
	g.id = 38 AND
	i.id = 305 AND
	CAST(c.inicio as date) = CAST('2014-09-10' AS DATE) AND
	trim(c.nomearquivo) <> ''
GROUP BY	
	a.id,  
	c.nomearquivo,
	nrtamanho,
	idarquivotipo,
	desarquivotipo,
	descaminho,
	instatus
--
SELECT * FROM tblaulabase where id = 34138
SELECT * FROM tblaula where id = 34138

-------------------------------------------------------------------------
------------ CRIAR AULA e ARQUIVOS Pré-aula -----------------------------
-------------------------------------------------------------------------
"INSERT INTO tblaulabase
(id, fk_professor, fk_programadeaula, nomearquivo, contempreaula, inicio) 
VALUES
(nextval('tblaulabase_id_seq'), ".$idprofessor.", ".$idprogramadeaula.", '', 't', now());

INSERT INTO tblpreaula
(id, descricao)
VALUES
((SELECT COALESCE(max(id), 0) + 1 FROM tblpreaula), ".$descricaopreaula.");

INSERT INTO tblaula 
(id, fk_sala, termino, fk_preaula, nomearquivo)	
VALUES 
(CURRVAL('tblaulabase_id_seq'), ".$idsala.",null, (SELECT max(id) FROM tblpreaula), '');

foreach
INSERT INTO tblpreaulaarquivo 
(nome, caminho, fk_preaula)
VALUES 
('".$nomearquivo."', '/preclass/".$nomearquivo."', (SELECT max(id) FROM tblpreaula)");""
-------------------------------------------------------------------------
------------ CRIAR LOGIN TEMPORARIO -------------------------------------
-------------------------------------------------------------------------

INSERT INTO tblusuario
(id, nome, login, password, email, ativo, perfil, coordenador, fk_coordenador)
VALUES
(
	nextval('tblaulabase_id_seq'), '".
	$idcaccount['nome']."', '".
	$login."', '".
	$idcaccount['dessenha']."', '".
	$idcaccount['desemail']."', 
	'f',
	'Aluno',
	'f',
	''
);
-------------------------------------------------------------------------
-------------------------------------------------------------------------
-------------------------------------------------------------------------
-------------------------------------------------------------------------

CREATE TABLE tblteste2
(
  id serial NOT NULL,
  descricao character varying(1000),
  data timestamp without time zone,
  CONSTRAINT tblteste2_pkey PRIMARY KEY (id )
)

INSERT INTO tblteste (id, descricao)
VALUES ((SELECT COALESCE(max(id), 0) + 1 FROM tblteste),'desc1')

INSERT INTO tblteste2(descricao, data)
VALUES ('desc1', null);

INSERT INTO tblteste(descricao, data)
VALUES ('desc2', null) returning id;

 
SELECT * FROM tblteste
SELECT * FROM tblteste2

SELECT COALESCE(max(id), 1) FROM tblteste

SELECT c.relname FROM pg_class c WHERE c.relkind = 'S';
select * from information_schema.columns where table_name = 'tblpreaula'

"INSERT INTO tblaulabase
(id, fk_professor, fk_programadeaula, nomearquivo, contempreaula, inicio) 
VALUES
(nextval('tblaulabase_id_seq'), ".$idprofessor.", ".$idprogramadeaula.", '', 't', now());

INSERT INTO tblpreaula
(id, descricao)
VALUES
((SELECT COALESCE(max(id), 0) + 1 FROM tblpreaula), ".$descricaopreaula.");

INSERT INTO tblaula 
(id, fk_sala, termino, fk_preaula, nomearquivo)	
VALUES 
(CURRVAL('tblaulabase_id_seq'), ".$idsala.",null, (SELECT max(id) FROM tblpreaula), '');

foreach
INSERT INTO tblpreaulaarquivo 
(nome, caminho, fk_preaula)
VALUES 
('".$nomearquivo."', '/preclass/".$nomearquivo."', (SELECT max(id) FROM tblpreaula)");""


SELECT 

SELECT des('exerc_cont_ CMV_22_03_res.xls')





SELECT currval('tblaulabase_id_seq');
SELECT * FROM tblusuario WHERE nome like '%Wender%Alves%Valentim%'

-------------------------------------------------------------------------
-------------------------------------------------------------------------
SELECT * FROM tblusuario where nome like '%Iza%'

SELECT * FROM tblaula WHERE fk_preaula = 25182
SELECT * FROM tblaulaaluno
SELECT * FROM tblaulaaudio
SELECT * FROM tblaulabase where contempreaula = 't'
SELECT * FROM tblpreaula WHERE id = 25182
SELECT * FROM tblpreaulaarquivo WHERE fk_preaula = 25182

SELECT * FROM tblprogramadeaula WHERE fk_professor = 2 ORDER BY id
SELECT * FROM tblsaladeaula 
SELECT * FROM tblsaladeaulastatus

SELECT * FROM tblperiododecurso
SELECT * FROM tblcurso
SELECT * FROM tblcurso_x_disciplina
SELECT * FROM tbldisciplina
SELECT * FROM tblturma
SELECT * FROM tblusuario WHERE login = '123456' 
SELECT * FROM tblusuario_x_disciplina
SELECT * FROM tblusuario_x_turma

SELECT * FROM tblusuario WHERE perfil = 'Professor'
SELECT * FROM tblusuario WHERE nome = 'Suporte' 


SELECT * FROM tblusuario_x_turma a
INNER JOIN tblusuario b ON b.id = a.fk_usuario
WHERE fk_turma = 161
order by b.nome
----------------------------------------------------------------------------------------------
SELECT 
	a.id as id_aula,  
	b.id as id_preaula,
	b.descricao as desc_preaula,
	c.nomearquivo as nomearquivo_aulabase,
	j.nome as nomearquivo_preaulaarquivo,
	j.caminho as caminho_preaulaarquivo,
	d.id as idprogramadeaula,
	f.id as idperiodo,
	f.nome as periodo,
	e.id as idcurso,
	e.nome as curso,
	g.id as idturma,
	g.nome as turma,
	i.id as iddisciplina,
	i.nome as disciplina,
	h.nome as professor,
	c.inicio as inicio_aulabase,
	a.termino as termino_aula
FROM tblaula a
LEFT JOIN tblpreaula b ON b.id = a.fk_preaula
LEFT JOIN tblaulabase c ON c.id = a.id
LEFT JOIN tblprogramadeaula d ON d.id = c.fk_programadeaula
LEFT JOIN tblcurso e ON e.id = d.fk_curso
INNER JOIN tblperiododecurso f ON f.id = d.fk_periodo
INNER JOIN tblturma g ON g.id = d.fk_turma
INNER JOIN tblusuario h ON h.id = d.fk_professor
INNER JOIN tbldisciplina i ON i.id = d.fk_disciplina
INNER JOIN tblpreaulaarquivo j ON j.fk_preaula = b.id
--WHERE a.id = 25197 -- nome do arquivo sem extenção
ORDER BY a.id


SELECT *
FROM tblaulabase a 
LEFT JOIN tblaula b ON b.id = a.id
LEFT JOIN tblpreaula c ON c.id = b.fk_preaula
ORDER BY a.id

SELECT * 
FROM tblpreaula a
INNER JOIN tblaulabase b ON a.id = b.id

SELECT * FROM tblusuario where nome like '%rafael%'

SELECT * FROM tblusuario WHERE nome like '%Roberto%' AND perfil = 'Professor' 


SELECT substr(nome, position('.' in nome), length(nome)), count(*) FROM tblpreaulaarquivo
WHERE length(substr(nome, position('.' in nome), length(nome))) < 6
GROUP BY substr(nome, position('.' in nome), length(nome))
ORDER BY count(*), substr(nome, position('.' in nome), length(nome))

SELECT * 
FROM tblaula a
INNER JOIN tblaulabase b ON b.id = a.fk_preaula

CREATE TEMP TABLE TB_TEMP AS
SELECT 1 as id, '0' as descricao

SELECT * FROM TB_TEMP

INSERT  @TB_TEMP VALUES(1)

SELECT * FROM @TB_TEMP

DROP TABLE TB_TEMP

SELECT * FROM tblusuario where nome like '%Vitalina%'


--
SELECT 
                c.id as id_aula,  
                b.id as id_preaula,
                b.descricao as desc_preaula,
                c.nomearquivo as nomearquivo_aulabase,
                d.id as idprogramadeaula,
                f.id as idperiodo,
                f.nome as periodo,
                e.id as idcurso,
                e.nome as curso,
                g.id as idturma,
                g.nome as turma,
                i.id as iddisciplina,
                i.nome as disciplina,
                h.nome as professor,
                c.inicio as inicio_aulabase,
                a.termino as termino_aula
FROM tblaulabase c
LEFT JOIN tblaula a ON a.id = c.id
LEFT JOIN tblpreaula b ON b.id = a.fk_preaula
LEFT JOIN tblprogramadeaula d ON d.id = c.fk_programadeaula
LEFT JOIN tblcurso e ON e.id = d.fk_curso
INNER JOIN tblperiododecurso f ON f.id = d.fk_periodo
INNER JOIN tblturma g ON g.id = d.fk_turma
INNER JOIN tblusuario h ON h.id = d.fk_professor
INNER JOIN tbldisciplina i ON i.id = d.fk_disciplina
WHERE c.id in (SELECT i FROM tblaulabase) -- nome do arquivo sem extensão
ORDER BY c.id

SELECT 
	* 
FROM tblprogramadeaula 
WHERE 
	fk_periodo = 9 AND 
	fk_turma = 153 AND
	fk_disciplina = 8
SELECT * FROM tblprogramadeaula where id = 2880

INSERT INTO tblaulabase
(id, fk_professor, fk_programadeaula, nomearquivo, contempreaula, inicio) 
VALUES
(nextval('tblaulabase_id_seq'), 5541, 2880, '', 't', now());

INSERT INTO tblpreaula
(id, descricao)
VALUES
(CURRVAL('tblaulabase_id_seq'), 'asda')

RETURNING id;

INSERT INTO tblpreaulaarquivo 
(nome, caminho, fk_preaula)
VALUES 
('arquivo.txt', '/preclass/arquivo.txt', 41925);


SELECT * FROM now()
SELECT CAST('2015-03-17' AS timestamp)
SELECT * FROM tblaulabase where fk_professor = 5541	
SELECT * FROM tblaulabase where id in(41931)	
SELECT * FROM tblpreaula where id in(41931)
--
SELECT * FROM tblprogramadeaula where id = 2880
SELECT * FROM tblperiododecurso WHERE id = 9
SELECT * FROM tblusuario WHERE login like '%francisca%'
SELECT * FROM tblpreaulaarquivo WHERE fk_preaula = 41925 

SELECT 
	max(c.id) as idaulabase,  
	max(b.id) as idpreaula,
	max(a.id) as idaula,  
	h.id as idprofessor,
	h.nome as desprofessor,
	e.id as idcurso,
	e.nome as descurso,
	g.id as idturma,
	g.nome as desturma,
	i.id as iddisciplina,
	i.nome as desdisciplina,
	max(b.descricao) as desdescricao,
	CAST(max(c.inicio) AS DATE) as dtaula,
	max(a.termino) as dtaula_termino,
	f.id as idperiodo,
	f.nome as periodo,
	'old' as desorigem
	FROM tblaulabase c
	LEFT JOIN tblaula a ON c.id = a.id
	LEFT JOIN tblpreaula b ON b.id = c.id
	LEFT JOIN tblprogramadeaula d ON d.id = c.fk_programadeaula
	LEFT JOIN tblcurso e ON e.id = d.fk_curso
	LEFT JOIN tblperiododecurso f ON f.id = d.fk_periodo
	LEFT JOIN tblturma g ON g.id = d.fk_turma
	LEFT JOIN tblusuario h ON h.id = d.fk_professor
	LEFT JOIN tbldisciplina i ON i.id = d.fk_disciplina
	LEFT JOIN tblpreaulaarquivo j ON j.fk_preaula = b.id
	WHERE 
		CAST(c.inicio AS date) = '2015-03-17' AND
		g.id = 153 AND
		i.id = 8
	GROUP BY
	h.id,
	h.nome,
	e.id,
	e.nome,
	g.id,
	g.nome,
	i.id,
	i.nome,
	CAST(c.inicio AS DATE),
	f.id,
	f.nome,
	desorigem