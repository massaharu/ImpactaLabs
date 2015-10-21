USE Suporte

select  * from tb_escalas
order by idusuario,dtescala, nrcoluna


SELECT A.*, B.* FROM tb_escalas A, tb_escalas B
WHERE A.dtescala = B.dtescala AND
	  A.nrcoluna = B.nrcoluna AND
	  A.idusuario = B.idusuario
order by b.dtescala, b.nrcoluna, b.idusuario

SELECT distinct dtescala, nrcoluna, idusuario 
FROM tb_escalas

SELECT * FROM tb_escalas
WHERE EXISTS(
	SELECT distinct idusuario, dtescala, nrcoluna 
	FROM tb_escalas)
	
SELECT MAX(idusuario) FROM tb_escalas
WHERE idusuario = 1480
------------------------------------
BEGIN TRAN
SELECT  * FROM tb_escalas  
WHERE idusuario NOT IN (
		SELECT distinct idusuario FROM tb_escalas
GROUP BY idusuario,dtescala,nrcoluna
HAVING count(idescala) != 1 AND count(dtcadastro) != 1)

ROLLBACK
		
SELECT idusuario,dtescala,nrcoluna,count(idescala) FROM tb_escalas
GROUP BY idusuario,dtescala,nrcoluna
HAVING count(idescala) != 1 AND count(dtcadastro) != 1
	  
USE DEV_TESTE
GO
create table #teste (ID int, Nome varchar(50)); 
GO
insert #teste values (1,'AAA'),(2,'BBB'),(2,'BBB'),(3,'CCC'); 
GO
select * from #teste; 
GO
delete top (1) #teste where ID IN (1,3,2); 
GO
select* from #teste; 
GO 	  
  
