----------Criação de Tabela0

create table tb_teste(
	idteste int identity not null,
	nrvalor decimal(10,2) not null,
	dtcadastro datetime not null default getdate(),
	desnome varchar(80) not null,
	
	constraint pk_teste primary key(idteste)

)

----------------------------------------------

insert into tb_teste(nrvalor,dtcadastro,desnome) values (12.50,DEFAULT,'Wilson'),(19.20,Default,'Wilson'),(50.48,Default,'Renan'),(80.65,Default,'Renan'),(90.80,Default,'Massa'); 

----------------------------------------------

Select COUNT(*) from tb_teste 

Select SUM(nrvalor) from tb_teste

Select MAX(nrvalor) from tb_teste

Select MIN(idteste) from tb_teste

Select AVG(nrvalor) from tb_teste

Select sum(nrvalor),desnome from tb_teste 
Group by desnome


Select min(nrvalor),desnome from tb_teste 
Group by desnome


Select max(nrvalor),desnome from tb_teste 
Group by desnome


Select Avg(nrvalor),desnome from tb_teste 
Group by desnome


Select count(nrvalor),desnome,idteste from tb_teste 
Group by desnome,idteste

Select * from tb_teste
Update tb_teste
set dtcadastro = getdate()
where idteste = 1


Select top 1 * from tb_teste
order by dtcadastro DESC

