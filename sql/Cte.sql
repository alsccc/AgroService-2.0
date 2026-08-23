with resumo_revisoes AS (
select
    r.id_revisao,
    r.horas,
    r.descricao,
    m.modelo,
    COUNT(ri.id_item) AS total_itens
FROM revisoes r
INNER JOIN modelostratores m
    ON r.id_modelo = m.id_modelo
INNER JOIN revisaoitens ri
    ON r.id_revisao = ri.id_revisao
GROUP BY
    r.id_revisao,
    r.horas,
    r.descricao,
    m.modelo
)
select *
from resumo_revisoes;