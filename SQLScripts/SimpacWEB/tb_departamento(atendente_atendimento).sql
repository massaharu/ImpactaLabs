USE DEV_TESTE

CREATE TABLE tb_departamentos(
	iddepartamento int identity not null primary key,
	desdepartamento varchar(200) not null,
)

SELECT *FROM tb_departamentos

INSERT INTO tb_departamentos(desdepartamento)
VALUES('Impacta'),('FIT')

CREATE PROC sp_departamentos_list
AS
SELECT *FROM tb_departamentos