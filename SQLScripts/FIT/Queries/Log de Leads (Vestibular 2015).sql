SELECT 
	desnome as Nome,
	desemail as Email,
	destelefone as Telefone,
	dtenviousuario as Data,
	b.NmUsuario
FROM FIT_NEW..tb_faleconoscofit_log a
INNER JOIN SIMPAC..tb_usuario b on b.IdUsuario = a.idusuario
WHERE desorigem like '%Site novo FIT - Vestibular 2015 (Landing Page)%'
ORDER BY dtenviousuario