create table tb_prestadorservico_treinamento
(
	idtreinamento int PRIMARY KEY not null,
	nmtreinamento varchar(20),
	idservico int,
)
alter table tb_prestadorservico_treinamento add
constraint fk_id_servico foreign key(idservico)
references tb_prestadorservico_informacao (idservico)