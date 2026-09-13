-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13/09/2026 às 21:49
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `agroservicebd`
--

DELIMITER $$
--
-- Procedimentos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `buscar_revisoes` (IN `p_modelo` INT, IN `p_limite` INT, IN `p_offset` INT)   BEGIN
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
END$$

--
-- Funções
--
CREATE DEFINER=`root`@`localhost` FUNCTION `tempo_estimado_revisao` (`qtd_itens` INT) RETURNS INT(11) DETERMINISTIC BEGIN
    RETURN qtd_itens * 30;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens`
--

CREATE TABLE `itens` (
  `id_item` int(11) NOT NULL,
  `nome_item` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itens`
--

INSERT INTO `itens` (`id_item`, `nome_item`) VALUES
(1, 'Troca de óleo do motor'),
(2, 'Troca do filtro de óleo'),
(3, 'Verificação do sistema de arrefecimento'),
(4, 'Lubrificação dos pontos de graxa'),
(5, 'Troca do filtro de combustível'),
(6, 'Regulagem de válvulas'),
(7, 'Troca de correias'),
(8, 'Inspeção do sistema hidráulico'),
(9, 'Inspeção completa do trator');

-- --------------------------------------------------------

--
-- Estrutura para tabela `modelostratores`
--

CREATE TABLE `modelostratores` (
  `id_modelo` int(11) NOT NULL,
  `modelo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `modelostratores`
--

INSERT INTO `modelostratores` (`id_modelo`, `modelo`) VALUES
(1, '5060E'),
(2, '5078E'),
(3, '5080E'),
(4, '5090E');

-- --------------------------------------------------------

--
-- Estrutura para tabela `revisaoitens`
--

CREATE TABLE `revisaoitens` (
  `id_revisao` int(11) NOT NULL,
  `id_item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `revisaoitens`
--

INSERT INTO `revisaoitens` (`id_revisao`, `id_item`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(3, 6),
(3, 7),
(3, 8),
(3, 9);

-- --------------------------------------------------------

--
-- Estrutura para tabela `revisoes`
--

CREATE TABLE `revisoes` (
  `id_revisao` int(11) NOT NULL,
  `id_modelo` int(11) NOT NULL,
  `horas` int(11) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `revisoes`
--

INSERT INTO `revisoes` (`id_revisao`, `id_modelo`, `horas`, `descricao`) VALUES
(1, 1, 250, 'Primeira revisão preventiva'),
(2, 1, 500, 'Revisão intermediária'),
(3, 1, 1000, 'Revisão completa');

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `vw_resumo_revisoes`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `vw_resumo_revisoes` (
`id_revisao` int(11)
,`modelo` varchar(50)
,`horas` int(11)
,`descricao` varchar(255)
,`total_itens` bigint(21)
);

-- --------------------------------------------------------

--
-- Estrutura para view `vw_resumo_revisoes`
--
DROP TABLE IF EXISTS `vw_resumo_revisoes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_resumo_revisoes`  AS SELECT `r`.`id_revisao` AS `id_revisao`, `m`.`modelo` AS `modelo`, `r`.`horas` AS `horas`, `r`.`descricao` AS `descricao`, count(`ri`.`id_item`) AS `total_itens` FROM ((`revisoes` `r` join `modelostratores` `m` on(`r`.`id_modelo` = `m`.`id_modelo`)) left join `revisaoitens` `ri` on(`r`.`id_revisao` = `ri`.`id_revisao`)) GROUP BY `r`.`id_revisao`, `m`.`modelo`, `r`.`horas`, `r`.`descricao` ;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `itens`
--
ALTER TABLE `itens`
  ADD PRIMARY KEY (`id_item`);

--
-- Índices de tabela `modelostratores`
--
ALTER TABLE `modelostratores`
  ADD PRIMARY KEY (`id_modelo`);

--
-- Índices de tabela `revisaoitens`
--
ALTER TABLE `revisaoitens`
  ADD PRIMARY KEY (`id_revisao`,`id_item`),
  ADD KEY `id_item` (`id_item`);

--
-- Índices de tabela `revisoes`
--
ALTER TABLE `revisoes`
  ADD PRIMARY KEY (`id_revisao`),
  ADD KEY `id_modelo` (`id_modelo`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `itens`
--
ALTER TABLE `itens`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `modelostratores`
--
ALTER TABLE `modelostratores`
  MODIFY `id_modelo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `revisoes`
--
ALTER TABLE `revisoes`
  MODIFY `id_revisao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `revisaoitens`
--
ALTER TABLE `revisaoitens`
  ADD CONSTRAINT `revisaoitens_ibfk_1` FOREIGN KEY (`id_revisao`) REFERENCES `revisoes` (`id_revisao`),
  ADD CONSTRAINT `revisaoitens_ibfk_2` FOREIGN KEY (`id_item`) REFERENCES `itens` (`id_item`);

--
-- Restrições para tabelas `revisoes`
--
ALTER TABLE `revisoes`
  ADD CONSTRAINT `revisoes_ibfk_1` FOREIGN KEY (`id_modelo`) REFERENCES `modelostratores` (`id_modelo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
