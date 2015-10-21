--------------------------------------------------------------------------------
----------------- PROCEDURES ---------------------------------------------------
--------------------------------------------------------------------------------
ALTER PROC sp_cursoscoordenador_list  
(@prof_responsavel int)
AS
BEGIN
	SELECt a.CURSO as idcurso, b.NOME AS descurso FROM SOPHIA.SOPHIA.TURMAS a
	INNER JOIN SOPHIA.SOPHIA.CURSOS b ON b.PRODUTO = a.CURSO
	WHERE PROF_RESPONSAVEL = @prof_responsavel AND NIVEL IN(3, 5) --POS, MBA
	GROUP BY a.CURSO, b.NOME
END
--
SELECT * FROM SOPHIA.SOPHIA.FISICA WHERE EMAIL  =  'anacris.santos@gmail.com'
SELECT * FROM SOPHIA.SOPHIA.NIVEL
sp_cursoscoordenador_list  3566
--------------------------------------------------------------------------------
ALTER PROC [dbo].[sp_oportunidadealuno_coordenador_list]
(
	@cursos varchar(100),
	@data_de datetime = NULL,
	@data_ate datetime = NULL
)
AS
BEGIN
	
	IF @data_de IS NOT NULL AND @data_ate IS NOT NULL
	BEGIN
		SELECT
			d.idoportunidade,
			e.idoportunidadefit, 
			m.produto,
			e.idproduto,
			e.idprodutotipo,
			g.idusuario as idvendedor,
			g.NmCompleto as desvendedor,
			p.codigo as fisica,
			a.idpessoa,
			a.despessoa,
			b.desdocumento as nrcpf,
			c.desdocumento as nrrg,
			h.descontato as desemail,
			i.descontato as desfone,
			j.descontato as descelular, 	
			e.dtcadastro as dtoportunidadefit,
			e.indocumentoliberado,
			d.idoportunidadepai,
			l.desetapa,
			l.idoportunidadeetapatipo,
			n.nome as descurso,
			s.NOME as desturma
		FROM tb_pessoas a 
		LEFT JOIN tb_documentos b ON b.idpessoa = a.idpessoa AND b.iddocumentotipo = 1
		LEFT JOIN tb_documentos c ON b.idpessoa = c.idpessoa AND c.iddocumentotipo = 5
		INNER JOIN tb_oportunidades d ON d.idpessoa = a.idpessoa
		INNER JOIN tb_oportunidadesfit e ON e.idoportunidade = d.idoportunidade
		LEFT JOIN tb_oportunidadeusuarios f ON f.idoportunidade = d.idoportunidade
		LEFT JOIN Simpac..tb_usuario g ON g.idusuario = f.idusuario
		LEFT JOIN tb_contatos h ON a.idpessoa = h.idpessoa AND h.idcontatotipo = 1
		LEFT JOIN tb_contatos i ON a.idpessoa = i.idpessoa AND h.idcontatotipo = 2
		LEFT JOIN tb_contatos j ON a.idpessoa = j.idpessoa AND h.idcontatotipo = 3
		LEFT JOIN tb_oportunidadeetapas k ON k.idoportunidade = d.idoportunidade AND k.instatus = 1
		LEFT JOIN tb_oportunidadeetapatipos l ON l.idoportunidadeetapatipo = k.idoportunidadeetapatipo
		LEFT JOIN tb_produtos_sophiacursos m ON m.idproduto = e.idproduto 
		LEFT JOIN SOPHIA.SOPHIA.CURSOS n ON n.PRODUTO = m.produto
		LEFT JOIN tb_pessoassophia o ON o.idpessoa = a.idpessoa
		LEFT JOIN SOPHIA.SOPHIA.FISICA p ON p.CODIGO = o.codigo		
		INNER JOIN (SELECT id FROM Simpac.dbo.fnSplit(@cursos,',')) q ON CAST(q.Id AS INT) = m.produto
		LEFT JOIN tb_oportunidadesfitsophia r ON r.idoportunidadefit = e.idoportunidadefit
		LEFT JOIN SOPHIA.SOPHIA.TURMAS s ON s.CODIGO = r.idturma
		WHERE e.dtcadastro BETWEEN @data_de AND DATEADD(SECOND, 59, DATEADD(MINUTE, 59, DATEADD(HOUR, 23, @data_ate)))
		ORDER BY e.dtcadastro DESC
	END
	ELSE
	BEGIN
		SELECT
			d.idoportunidade,
			e.idoportunidadefit, 
			m.produto,
			e.idproduto,
			e.idprodutotipo,
			g.idusuario as idvendedor,
			g.NmCompleto as desvendedor,
			p.codigo as fisica,
			a.idpessoa,
			a.despessoa,
			b.desdocumento as nrcpf,
			c.desdocumento as nrrg,
			h.descontato as desemail,
			i.descontato as desfone,
			j.descontato as descelular, 	
			e.dtcadastro as dtoportunidadefit,
			e.indocumentoliberado,
			d.idoportunidadepai,
			l.desetapa,
			l.idoportunidadeetapatipo,
			n.nome as descurso,
			s.NOME as desturma
		FROM tb_pessoas a 
		LEFT JOIN tb_documentos b ON b.idpessoa = a.idpessoa AND b.iddocumentotipo = 1
		LEFT JOIN tb_documentos c ON b.idpessoa = c.idpessoa AND c.iddocumentotipo = 5
		INNER JOIN tb_oportunidades d ON d.idpessoa = a.idpessoa
		INNER JOIN tb_oportunidadesfit e ON e.idoportunidade = d.idoportunidade
		LEFT JOIN tb_oportunidadeusuarios f ON f.idoportunidade = d.idoportunidade
		LEFT JOIN Simpac..tb_usuario g ON g.idusuario = f.idusuario
		LEFT JOIN tb_contatos h ON a.idpessoa = h.idpessoa AND h.idcontatotipo = 1
		LEFT JOIN tb_contatos i ON a.idpessoa = i.idpessoa AND h.idcontatotipo = 2
		LEFT JOIN tb_contatos j ON a.idpessoa = j.idpessoa AND h.idcontatotipo = 3
		LEFT JOIN tb_oportunidadeetapas k ON k.idoportunidade = d.idoportunidade AND k.instatus = 1
		LEFT JOIN tb_oportunidadeetapatipos l ON l.idoportunidadeetapatipo = k.idoportunidadeetapatipo
		LEFT JOIN tb_produtos_sophiacursos m ON m.idproduto = e.idproduto 
		LEFT JOIN SOPHIA.SOPHIA.CURSOS n ON n.PRODUTO = m.produto
		LEFT JOIN tb_pessoassophia o ON o.idpessoa = a.idpessoa
		LEFT JOIN SOPHIA.SOPHIA.FISICA p ON p.CODIGO = o.codigo		
		INNER JOIN (SELECT id FROM Simpac.dbo.fnSplit(@cursos,',')) q ON CAST(q.Id AS INT) = m.produto
		LEFT JOIN tb_oportunidadesfitsophia r ON r.idoportunidadefit = e.idoportunidadefit
		LEFT JOIN SOPHIA.SOPHIA.TURMAS s ON s.CODIGO = r.idturma
		ORDER BY e.dtcadastro DESC
	END
END
--
sp_oportunidadealuno_coordenador_list 32
SELECT * FROM Vendas..tb_oportunidadesfitsophia
SELECT * FROM Vendas..tb_oportunidadesfit
--------------------------------------------------------------------------------
ALTER PROC sp_oportunidadequestoes_list
(@produto int, @email varchar(100))
AS
/*
  app:SiteFit
  url:professor/json/oportunidadequestoes_list.php
  author: Massaharu
  date: 1/10/2014
  desc: Lista as questões dos formularios da fit
*/
BEGIN
	SELECT TOP 1
		a.idprocessoseletivo, a.dtcadastro, a.nrra, a.dessessionid, a.idcurso, a.desnome, a.desemail, 
		a.destelefone, a.desmotivoareaatuacao, a.desmotivointeressecurso, a.desesperacurso, 
		a.desexpectativaposcurso, a.desnecessidadeespecial, a.descaminhocurriculum
	FROM tb_proc_seletivo_posgraduacao a
	LEFT JOIN tb_cursos_FIT_Sophia b ON b.idcurso_fit = a.idcurso
	LEFT JOIN SONATA.SOPHIA.SOPHIA.CURSOS c ON c.PRODUTO = b.idcurso_sophia
	WHERE 
		RTRIM(LTRIM(a.desemail)) = @email AND 
		c.PRODUTO = @produto
	ORDER BY a.dtcadastro DESC
END
--
sp_oportunidadequestoes_list 7, 'sgcn28@gmail.com'

SELECT * FROM tb_cursos_
--------------------------------------------------------------------------------
ALTER PROC sp_oportunidadealuno_get
(@idoportunidade int)
AS
/*
  app:SiteFit
  url:professor/json/oportunidadealuno_get.php
  author: Massaharu
  date: 1/10/2014
  desc: retorna a oportunidade do aluno
*/
BEGIN
	SELECT
		d.idoportunidade,
		e.idoportunidadefit, 
		m.produto,
		e.idproduto,
		e.idprodutotipo,
		g.idusuario as idvendedor,
		g.NmCompleto as desvendedor,
		g.CdEMail as desemailvendedor,
		p.codigo as fisica,
		a.idpessoa,
		a.despessoa,
		b.desdocumento as nrcpf,
		c.desdocumento as nrrg,
		h.descontato as desemail,
		i.descontato as desfone,
		j.descontato as descelular, 	
		e.dtcadastro as dtoportunidadefit,
		e.indocumentoliberado,
		d.idoportunidadepai,
		l.desetapa,
		l.idoportunidadeetapatipo,
		n.nome as descurso,
		s.NOME as desturma
	FROM tb_pessoas a 
	LEFT JOIN tb_documentos b ON b.idpessoa = a.idpessoa AND b.iddocumentotipo = 1
	LEFT JOIN tb_documentos c ON b.idpessoa = c.idpessoa AND c.iddocumentotipo = 5
	INNER JOIN tb_oportunidades d ON d.idpessoa = a.idpessoa
	INNER JOIN tb_oportunidadesfit e ON e.idoportunidade = d.idoportunidade
	LEFT JOIN tb_oportunidadeusuarios f ON f.idoportunidade = d.idoportunidade
	LEFT JOIN Simpac..tb_usuario g ON g.idusuario = f.idusuario
	LEFT JOIN tb_contatos h ON a.idpessoa = h.idpessoa AND h.idcontatotipo = 1
	LEFT JOIN tb_contatos i ON a.idpessoa = i.idpessoa AND h.idcontatotipo = 2
	LEFT JOIN tb_contatos j ON a.idpessoa = j.idpessoa AND h.idcontatotipo = 3
	LEFT JOIN tb_oportunidadeetapas k ON k.idoportunidade = d.idoportunidade AND k.instatus = 1
	LEFT JOIN tb_oportunidadeetapatipos l ON l.idoportunidadeetapatipo = k.idoportunidadeetapatipo
	LEFT JOIN tb_produtos_sophiacursos m ON m.idproduto = e.idproduto 
	LEFT JOIN SOPHIA.SOPHIA.CURSOS n ON n.PRODUTO = m.produto
	LEFT JOIN tb_pessoassophia o ON o.idpessoa = a.idpessoa
	LEFT JOIN SOPHIA.SOPHIA.FISICA p ON p.CODIGO = o.codigo		
	LEFT JOIN tb_oportunidadesfitsophia r ON r.idoportunidadefit = e.idoportunidadefit
	LEFT JOIN SOPHIA.SOPHIA.TURMAS s ON s.CODIGO = r.idturma
	WHERE d.idoportunidade = @idoportunidade
	ORDER BY e.dtcadastro DESC
END

sp_oportunidadealuno_get 427

SELECT * FROM tb_oportunidadeetapas where idoportunidade = 427
SELECT * FROM tb_oportunidadeetapatipos 

INSERT INTO tb_oportunidadeetapatipos (desetapa) VALUES('Reprovado pelo coordenador')

sp_oportunidadealuno_get 427
--------------------------------------------------------------------------------
--------------------------------------------------------------------------------
--------------------------------------------------------------------------------
SELECT DATEADD(SECOND, 59, DATEADD(MINUTE, 59, DATEADD(HOUR, 23, '2014-10-08')))

SELECt * FROM  tb_proc_seletivo_posgraduacao
SELECT * FROM tb_oportunidadeetapatipos

exec Vendas..sp_oportunidadedescontos_list 123, 2
exec Vendas..sp_descontositensbydesconto_list 23, 123
 
 sp_oportunidadebyvestibularpessoa_get  26283, 194
 
 select
	  c.idoportunidade,
	  f.codigo AS fisica,
	  a.idpessoa,
	  a.despessoa,
	  b.descontato as desemail,
	  j.nmcompleto,
	  j.cdemail,
	  k.NOME as descurso,
	  e.idvestibular,
	  g.produto,
	  f.codigo,
	  g.codturno,
	  c.idoportunidade
from tb_pessoas a
left join tb_contatos b on a.idpessoa = b.idpessoa and b.idcontatotipo = 1
inner join tb_oportunidades c on b.idpessoa = c.idpessoa
inner join tb_oportunidadesfit d on c.idoportunidade = d.idoportunidade
inner join tb_oportunidadefitpalestravestibulares e on d.idoportunidadefit = e.idoportunidadefit
inner join tb_pessoassophia f on b.idpessoa = f.idpessoa
inner join tb_produtos_sophiacursos g on d.idproduto = g.idproduto
inner join tb_oportunidadeusuarios h on h.idoportunidade = c.idoportunidade
inner join tb_oportunidadeusuariotipos i ON i.idoportunidadeusuariotipo = h.idoportunidadeusuariotipo and i.idoportunidadeusuariotipo = 1
inner join Simpac..tb_usuario j ON j.idusuario = h.idusuario
inner join sophia.sophia.CURSOS k ON k.PRODUTO = g.produto
where 
		--f.codigo = @cod_fisica and
		--e.idvestibular = @idvestibular  and
		d.instatus = 1 and
		e.instatus = 1
		
SELECT * FROM tb_oportunidadefitpalestravestibulares	
SELECT * FROM SOPHIA.SOPHIA.CONCURSOS 

SELECT * FROM tb_oportunidades where idoportunidade = 329
SELECT * FROM tb_oportunidadeetapas where idoportunidade = 329
SELECT * FROM tb_oportunidadeetapatipos