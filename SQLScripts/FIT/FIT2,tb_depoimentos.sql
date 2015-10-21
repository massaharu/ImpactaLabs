

ALTER PROC sp_depoimentotexto_update
(@depoimentoid int,@depoimentotexto text)
AS
UPDATE tb_depoimentos
SET depoimento_texto = @depoimentotexto
WHERE depoimento_id = @depoimentoid

ALTER PROC sp_depoimentovideo_update
(@depoimentoid int,@depoimentovideo text)
AS
UPDATE tb_depoimentos
SET depoimento_video = @depoimentovideo
WHERE depoimento_id = @depoimentoid

CREATE PROC sp_depoimentoativo_update
(@depoimentoid int,@depoimentoativo bit)
AS
UPDATE tb_depoimentos
SET depoimento_ativo = @depoimentoativo
WHERE depoimento_id = @depoimentoid

CREATE PROC sp_depoimento_depoimentostatus_update
(@depoimentoid int,@depoimentostatus bit)
AS
UPDATE tb_depoimentos
SET depoimento_depoimentostatus = @depoimentostatus
WHERE depoimento_id = @depoimentoid

sp_depoimentovideo_update 24,'<p><object width="520" height="390"><param name="movie" value="http://www.youtube.com/v/IJJBmEEAfLA?version=3&amp;hl=pt_BR&amp;rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/IJJBmEEAfLA?version=3&amp;hl=pt_BR&amp;rel=0" type="application/x-shockwave-flash" width="520" height="390" allowscriptaccess="always" allowfullscreen="true"></embed></object></p>'
								 
sp_depoimentotexto_update 22,'<span id="aspas-abre">&ldquo;</span><span class="depoimento_autor"><p>&quot;Primeiramente, gostaria de agradecer &agrave; FIT (Faculdade Impacta Tecnologia) pela presteza de seus servi&ccedil;os no &acirc;mbito acad&ecirc;mico, bem como promover v&iacute;nculos motivacionais com os docentes, que tamb&eacute;m exercem a fun&ccedil;&atilde;o de consultores uma vez que nos orientam sobre as perspectivas de mercado e as ferramentas essenciais para explor&aacute;-lo, a fim de obter um desempenho satisfat&oacute;rio e maximizar os resultados. Uma vez que eu vim transferido de outra Institui&ccedil;&atilde;o de ensino (CEFET-SP), fiquei admirado com o ambiente de vanguarda que encontrei na Impacta.</p>  <p>Outros aspectos a ressaltar foram as palestras fornecidas na Semana Integrada e as parcerias com as grandes empresas de TI e tamb&eacute;m com o Cadwell Community And Technical Institute, que permitiu verificar a seriedade do trabalho e a inter-rela&ccedil;&atilde;o com a cultura americana, proporcionando-me ampliar meus conhecimentos e tamb&eacute;m grandes oportunidades no Brasil&quot;.&nbsp;</p></span><span id="aspas-fecha">&rdquo;</span>'

sp_depoimento_depoimentostatus_update 23,0


select *from tb_depoimentos

SELECT * FROM tb_depoimentos WHERE depoimento_ativo = 1

UPDATE tb_depoimentos
SET depoimento_ativo = 1
WHERE depoimento_ativo = 0

UPDATE tb_depoimentos
SET depoimento_curso = 'Sistema de Informação'
WHERE depoimento_id = 23

				  
select depoimento_nome,depoimento_texto from tb_depoimentos

ALTER TABLE tb_depoimentos ADD
depoimento_video text

ALTER TABLE tb_depoimentos ADD
depoimento_depoimentostatus bit not null,
CONSTRAINT DF_DEPOIMENTOSTATUS DEFAULT(1) FOR depoimento_depoimentostatus

ALTER TABLE tb_depoimentos DROP
COLUMN depoimento_video

ALTER TABLE tb_depoimentos DROP
CONSTRAINT DF_DEPOIMENTOSTATUS 


UPDATE tb_depoimentos
SET depoimento_depoimentostatus = 0
WHERE depoimento_texto = ''