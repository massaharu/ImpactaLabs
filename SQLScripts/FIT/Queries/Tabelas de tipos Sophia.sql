------------------------------------------------------------------
CREATE TABLE tb_academic_tipomatr(
	idtipomatr int,
	destipomatr varchar(100)
)

INSERT INTO tb_academic_tipomatr
VALUES
( 17, 'Mat. Cancelada'),
( 14, 'Cancelada'),
( 13, 'Optativa'),
( 12, 'Complementação de currículo'),
( 11, 'Extra-curricular'),
( 10, 'Opcional'),
( 9, 'Impedida'),
( 8, 'Trancada'),
( 7, 'Adiantamento de estudos'),
( 6, 'Adaptação'),
( 5, 'Dispensa'),
(4, 'Dispensa Médica'),
(3, 'Aproveitamento de estudos'),
(2, 'DP'),
(1, 'Regular Adicional'),
(0, 'Regular')

SELECT * FROM tb_academic_tipomatr
----------------------------------------------
CREATE TABLE tb_academic_situacao(
	idsituacao int,
	dessituacao varchar(100)
)

INSERT INTO tb_academic_situacao
VALUES
(8, 'Cancelado'),
(0, 'Indefinido'),
(9, 'Trancado'),
(1, 'Aprovado'),
(2, 'Reprovado'),
(3, 'Em exame')

SELECT * FROM tb_academic_situacao