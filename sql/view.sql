CREATE OR REPLACE VIEW vw_resumo_revisoes AS
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
GROUP BY
    r.id_revisao,
    m.modelo,
    r.horas,
    r.descricao;