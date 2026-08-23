CREATE TRIGGER padrao_revisao
BEFORE UPDATE ON revisoes
FOR EACH row
begin
	
    SET NEW.descricao = TRIM(NEW.descricao);

END;

SELECT *
FROM revisoes
WHERE id_revisao = 2;

	UPDATE revisoes
	SET descricao = '   Revisão intermediária   '
	WHERE id_revisao = 2;