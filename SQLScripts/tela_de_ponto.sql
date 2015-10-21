SELECT * FROM simpac..tb_usuario

exec Rh..sp_horariosUsuario_list 1495

SELECT * FROM rh..tb_ponto 
where CAST(dtcadastro AS date) = '2014-08-21' and idusuario = 1847
ORDER BY idusuario

INSERT INTO rh..tb_ponto
(dtponto, idtipohorario, idusuario, dtcadastro)


INSERT INTO rh..tb_ponto
(dtponto, idtipohorario, idusuario, dtcadastro)
SELECT dateadd(mi, 15, dateadd(hh, 2, MIN(dtponto))), 3, idusuario, CAST(dtcadastro AS date) FROM rh..tb_ponto
WHERE CAST(dtcadastro AS date) > '2014-07-01'
GROUP BY idusuario, CAST(dtcadastro AS date)
having  COUNT(*) < 4

SELECT dateadd(hh, 2, GETDATE())
dateadd(mi, 15, dateadd(hh, 2, MIN(dtponto)))


SELECT dateadd(mi, 15, dateadd(hh, 2, getdate()))


SELECT  dateadd(mi, -15, dateadd(hh, 2, MIN(dtponto))), 2, idusuario, CAST(dtcadastro AS date) FROM rh..tb_ponto
WHERE CAST(dtcadastro AS date) > '2014-08-01'
GROUP BY idusuario, CAST(dtcadastro AS date)
having  COUNT(*) > 4

SELECT * FROM simpac..tb_usuario where idusuario = 1912
