CREATE TABLE tb_prestadorservico_observacao
(
	idobservacao int identity(1,1),
	desobservacao varchar(500) not null,
	desformacao varchar(500) not null,
	descertificacao varchar(500) not null,
	desatividade varchar(500) not null,
	desqualificacao varchar(500) not null,
	idservico int not null,
	CONSTRAINT pk_id_observacao PRIMARY KEY(idobservacao)
)
ALTER TABLE tb_prestadorservico_observacao ADD
	CONSTRAINT fk_observacao_id_servico FOREIGN KEY(idservico)
	REFERENCES tb_prestadorservico_informacao(idservico)

	