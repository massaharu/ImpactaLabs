CREATE TABLE ##tb_leads(
	id int IDENTITY,
	nome varchar(500),
	email varchar(500)
)

SELECT a.*, 
CASE 
	WHEN b.CODIGO IS NULL THEN 'NÃO'
	ELSE 'SIM'
END
FROM ##tb_leads a
LEFT JOIN (
	SELECT y.codigo, nome, email FROM SONATA.SOPHIA.SOPHIA.MATRICULA z
	INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA y ON y.CODIGO = z.FISICA
	GROUP BY nome, email, y.codigo
) b ON b.email COLLATE SQL_Latin1_General_CP850_CI_AI = a.email COLLATE SQL_Latin1_General_CP850_CI_AI
ORDER BY a.id


TRUNCATE TABLE ##tb_leads

INSERT INTO ##tb_leads
(nome, email)
VALUES
('André Ferro Napoli', 'andre_vlss@yahoo.com.br'),
('Isadora', 'isadoracarvalho.si@gmail.com'),
('Caê Teixeira de Almeida', 'cae.addams@gmail.com'),
('Fernanda', 'rds.fernanda@hotmail.com'),
('anderson silva campos ', 'bigse@hotmail.com'),
('Jardel Feitosa de Lima', 'jardelflima@gmail.com'),
('Katherine Andrade', 'kthy_n@yahoo.com.br'),
('Paulo Felício', 'paulo_f_elicio@hotmail.com'),
('Gustavo Henrique Graniso Souza Santos', 'gustavo.graniso@hotmail.com'),
('Erika Iglesias', 'lakika48@hotmail.com'),
('Pamela Molina', 'pamymolina@yahoo.com.br'),
('Natalia Ortega', 'nsantos@netconn.com.br'),
('Mariana', 'mariana.mabelini@gmail.com'),
('DANIEL PAIOTTI', 'adm.danielpaiotti@gmail.com'),
('Camila Gomes do Nascimento', 'milacgn@gmail.com'),
('Douglas Gomes', 'douglas229@gmail.com'),
('brenda silva de medeiros', 'bre1medeiros@gmail.com'),
('Wilson ', 'wilsonalmeida@me.com'),
('Felipe Fernandes Soares', 'felipe_tete13@hotmail.com'),
('Marlon Aguiar de Melo', 'marlonrpg4@hotmail.com'),
('Silvia Conti', 'silviaclpedra@hotmail.com'),
('Daniel Kabata', 'youitik@hotmail.com'),
('Rafael Herculano de Sousa', 'rafalbertino@gmail.com'),
('Leandro Vasco da Rocha', 'leeeandroo@gmail.com'),
('Alexandre Pixel4', 'alexandreperez85@gmail.com'),
('alexandre', 'alexandreperez85@gmail.com'),
('Alexandre Pixel4', 'alexandreperez85@gmail.com'),
('Rodrigo de Arruda Lobo Vitoria', 'rodrigo-dalvit@hotmail.com'),
('Fabiola Magossi', 'calliop@gmail.com'),
('Alexandre Pixel4', 'alexandreperez85@gmail.com'),
('alexandre', 'alexandreperez85@gmail.com'),
('Alexandre ', 'alexandreperez85@gmail.com'),
('Alexandre', 'alexandreperez85@gmail.com'),
('Alexandre Almeida', 'alexandreperez85@gmail.com'),
('Alexandre', 'alexandreperez85@gmail.com'),
('roberto angelino filho', 'angelino.rf@gmail.com'),
('alexandre', 'alexandreperez85@gmail.com'),
('alexandre', 'antoniofagnergodoi@gmail.com'),
('alexandre', 'alexandre@bol.com.br'),
('Henrique Leoni', 'h.ponnciano@gmail.com')







SELECT * FROM ##tb_leads