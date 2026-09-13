DELIMITER $$

CREATE PROCEDURE buscar_revisoes(
    IN p_modelo INT,
    IN p_limite INT,
    IN p_offset INT
)
BEGIN
    SELECT
        r.id_revisao,
        m.modelo,
        r.horas,
        r.descricao,
        COUNT(ri.id_item) AS total_itens
    FROM revisoes r
    INNER JOIN modelostratores m
        ON r.id_modelo = m.id_modelo
    LEFT JOIN revisaoItens ri
        ON r.id_revisao = ri.id_revisao
    WHERE
        p_modelo IS NULL
        OR r.id_modelo = p_modelo
    GROUP BY
        r.id_revisao,
        m.modelo,
        r.horas,
        r.descricao
    ORDER BY r.horas
    LIMIT p_limite OFFSET p_offset;
END $$

DELIMITER ;