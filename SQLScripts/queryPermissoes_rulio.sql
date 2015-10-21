
--QUERY PARA LIBERAR PERMISS�ES DE ACESSO NO SIMPAC



use simpac


select * from tb_usuario
where NmCompleto like '%Ana Claudia%'

--obs: sempre verificar a quantidade de permiss�es que seram copiadas dos usuarios
--se s�o as mesmas  

-- copiar permiss�es de: (idusuario:341) roberta  ou
-- copiar permiss�es de: (idusuario:144) hemerson

-- para: (idusuario:1499) ana claudia 

insert tb_Direitos(IdUsuario,IdGrupo)
select 1499,a.idgrupo from tb_Direitos a 
left join tb_Direitos b on a.IdGrupo = b.IdGrupo and b.IdUsuario = 1499 
where a.IdUsuario in(341)
and b.IdUsuario is null

select * from tb_Direitos
where IdUsuario = 1499


--select * from tb_Grupos



--------------------
SELECT a.nmcompleto, c.Nome  
FROM tb_usuario a
INNER JOIN tb_Direitos b
ON b.IdUsuario = a.IdUsuario
INNER JOIN tb_Grupos c
ON c.IDGrupo = b.IdGrupo
where a.NmCompleto like 'grace%'