
select * from tb_RetiradaDeCheque_DiasSemRetirada
------------------------------------------------------------
ALTER PROC sp_retiradadecheque_diasemretirada_list
AS
/*
app: SimpacWeb
url: /simpacweb/modulos/Financeiro/retiradacheque_diassemretirada_list
data: 2013-03-21
author: Massa
*/
SELECT iddata, dtdata FROM tb_RetiradaDeCheque_DiasSemRetirada
ORDER BY dtdata

------------------------------------------------------------

CREATE PROC sp_retiradadecheque_diasemretirada_save
(@iddata int, @dtdata datetime)
AS
/*
app: SimpacWeb
url: /simpacweb/modulos/Financeiro/retiradacheque_diassemretirada_save
data: 2013-03-21
author: Massa
*/
BEGIN
	SET NOCOUNT ON
	
	IF(@iddata <> 0)
		BEGIN
			UPDATE tb_RetiradaDeCheque_DiasSemRetirada
			SET dtdata = @dtdata
			WHERE iddata = @iddata
			
			SET NOCOUNT OFF
			SELECT @iddata as iddata
		END
	ELSE
		BEGIN
			INSERT INTO tb_RetiradaDeCheque_DiasSemRetirada(dtdata)
			VALUES(@dtdata)
			
			SET NOCOUNT OFF
			SELECT SCOPE_IDENTITY() as iddata
		END
END
------------------------------------------------------------
CREATE PROC sp_retiradadecheque_diasemretirada_delete
(@iddata int)
AS
/*
app: SimpacWeb
url: /simpacweb/modulos/Financeiro/retiradacheque_diassemretirada_delete
data: 2013-03-21
author: Massa
*/
BEGIN
	DELETE tb_RetiradaDeCheque_DiasSemRetirada
	WHERE iddata = @iddata
END

