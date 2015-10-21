USE SimpacWEB;
select * from tb_SimpacWebPHP_desktop_icons
select * from tb_SimpacWebPHP_desktop_icons_permissoes

select a.nmcompleto, b.* from simpac..tb_usuario a
inner join tb_SimpacWebPHP_desktop_icons_permissoes b
on b.idusuario = a.idusuario
order by NmCompleto 

--criar ícones
insert into tb_SimpacWebPHP_desktop_icons 
(desid, desicone, x, y, desico, dbclick)
VALUES
('ico_todosUsuarios', 'Todos Usuários', 500, 500, 'focus_group_128.png', 'openWindowDefault(''win.todosUsuarios.js'');')

--relacionar icones com usuário
insert tb_SimpacWebPHP_desktop_icons_permissoes (idusuario, idicone) values 
(1495, 19)


--delete from tb_SimpacWebPHP_desktop_icons_permissoes
--where idusuario = 1495 and idicone in(5, 10)


select * from tb_SimpacWebPHP_desktop_icons
select * from tb_menu

select * from tb_Menu
where LTRIM(RTRIM(handler)) != '' 

and
text like '%ponto%'

sp_simpacwebmenuchildsid_list 
sp_simpacwebmenuchildsid_list 110 


select * from simpac..tb_usuario where nmlogin like '%ana%'

win_listaTodosUsuarios

-------------------------------------------------------------
---------------- PROCEDURES ---------------------------------
-------------------------------------------------------------
CREATE PROC sp_simpacwebphp_desktop_icons_get 2
(@idicone int)
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.icone.php
data: 2013-03-21
author: Massaharu
description: Seleciona todos os campos da tabela a partir de seu id(único)
*/
BEGIN
	SELECT 
		idicone
		, desid
		, desicone
		, x
		, y
		, desico
		, dbclick
	FROM tb_SimpacWebPHP_desktop_icons
	WHERE idicone = @idicone
END
-------------------------------------------------------------
CREATE PROC sp_simpacwebphp_desktop_icons_list
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.icone.php
data: 2013-03-21
author: Massaharu
description: Lista todos os campos da tabela trazendo todos os registros
*/
BEGIN
	SELECT 
		idicone
		, desid
		, desicone
		, x
		, y
		, desico
		, dbclick
	FROM tb_SimpacWebPHP_desktop_icons
END
--------------------------------------------------------
CREATE PROC sp_simpacwebmenulastchilds_list
AS
/*
app: SimpacWeb
url: /simpacweb/class/class.icone.php
data: 2013-03-21
author: Massaharu
description: Retorna todos os últimos filhos de cada menu
*/
BEGIN
	SELECT idmenu, [text], parent, handler, nrordem, iconCls 
	FROM tb_Menu WHERE LTRIM(RTRIM(handler)) != '' 
END