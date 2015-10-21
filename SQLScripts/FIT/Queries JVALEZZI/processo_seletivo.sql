

SELECT * FROM SOPHIA.FISICA
WHERE CODEXT = '1410010'



select * from sophiA.CONCURSOS
where DESCRICAO like '18/01/2014 - Processo Seletivo'

-- 161 - 08/03/2014 - Processo Seletivo

select b.NOME, a.* from sophia.CONC_CLI a 
inner join sophia.FISICA b ON a.FISICA = b.CODIGO
where CONCURSO = 158
order by b.NOME


