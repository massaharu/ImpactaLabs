
--QUERY PARA LIBERAR PERMISS�ES DE ACESSO NO SIMPAC



use simpac


select * from tb_usuario
where NmCompleto like '%joyce%'

--obs: sempre verificar a quantidade de permiss�es que seram copiadas dos usuarios
--se s�o as mesmas  

-- copiar permiss�es de: (idusuario:341) roberta  ou
-- copiar permiss�es de: (idusuario:144) hemerson

-- para: (idusuario:1499) ana claudia 



--insert tb_Direitos(IdUsuario,IdGrupo)
DECLARE @de int, @para int

SET @de = 303
SET @para = 1789



select @para,a.idgrupo from tb_Direitos a 
left join tb_Direitos b on a.IdGrupo = b.IdGrupo and b.IdUsuario = @para 
where a.IdUsuario in(@de)
and b.IdUsuario is null

---
--insert tb_Direitos(IdUsuario,IdGrupo)
--select 1499,a.idgrupo from tb_Direitos a 
--left join tb_Direitos b on a.IdGrupo = b.IdGrupo and b.IdUsuario = 1499 
--where a.IdUsuario in(341)
--and b.IdUsuario is null

select * from tb_Direitos
where IdUsuario = 1495


--select * from tb_Grupos