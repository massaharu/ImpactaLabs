USE SimpacWeb;
sp_linkpermissao_user_list 1495

USE simpac;
ALTER PROCEDURE sp_permissaosimpacantigo_copy
(@de int, @para int)
/*
app: SimpacWeb
url: /simpacweb/modulos/simpacweb/ajax/copy_permission_simpacantigo.crud.php
data: 2013-08-12
author: Massaharu
*/
AS
BEGIN
	insert tb_Direitos(IdUsuario,IdGrupo)
	select @para,a.idgrupo from tb_Direitos a 
	left join tb_Direitos b on a.IdGrupo = b.IdGrupo and b.IdUsuario = @para 
	where a.IdUsuario in(@de)
	and b.IdUsuario is null
END
-----------------------------------------------------------------------------
select * from tb_usuario
where nmcompleto like '%juliana%'

select * from tb_Direitos
where IdUsuario = --1019
				1804

1019 = 62 perm
1804 = 26 perm