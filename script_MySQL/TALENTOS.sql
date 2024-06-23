-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 23/06/2024 às 16:32
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
-- Banco de dados: `talentos`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `curriculo`
--

CREATE TABLE `curriculo` (
  `id_curriculo` int(11) NOT NULL,
  `conteudo` text DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `usuarios_id_usuarios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `curriculo`
--

INSERT INTO `curriculo` (`id_curriculo`, `conteudo`, `foto`, `usuarios_id_usuarios`) VALUES
(1, 'apenas um testt', 'uploads/Lamarckismo .pdf', 5),
(2, 'sdaaaaaa', NULL, 7);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuarios` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(50) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT 'Candidato' COMMENT 'Administrador\nEmpresa\nCandidato',
  `endereco` varchar(100) DEFAULT NULL,
  `telefone` varchar(45) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuarios`, `nome`, `email`, `senha`, `tipo`, `endereco`, `telefone`, `status`) VALUES
(1, 'Administrar do Sistema', 'adm@gmail.com', '123', 'Administrador', NULL, NULL, 1),
(2, '77XPG Recursos Humanos', 'xpg@gmail.com', '123', 'Empresa', 'Av. das Palmeiras, Taguatinga Centro', '(61)9876545', 1),
(4, 'Mateus', 'Mateus@gmail.com', '123', 'CANDIDATO', 'Av. das arvores, CEILANDIA Centro', '(61)98756524', 1),


-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios_concorre_vaga`
--

CREATE TABLE `usuarios_concorre_vaga` (
  `usuarios_id_usuarios` int(11) NOT NULL,
  `vagas_id_vagas` int(11) NOT NULL,
  `status_vaga` varchar(15) DEFAULT 'Aguardando' COMMENT 'Aguardando\nSelecionado(a)',
  `comunicacao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `usuarios_concorre_vaga`
--

INSERT INTO `usuarios_concorre_vaga` (`usuarios_id_usuarios`, `vagas_id_vagas`, `status_vaga`, `comunicacao`) VALUES
(5, 17, 'Aguardando', NULL),
(5, 19, 'Aguardando', NULL),
(5, 20, 'Aguardando', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `vagas`
--

CREATE TABLE `vagas` (
  `id_vagas` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `descricao` varchar(245) DEFAULT NULL,
  `requisitos` text DEFAULT NULL,
  `remuneracao` decimal(13,2) DEFAULT 0.00,
  `situacao` varchar(15) DEFAULT 'Aberta' COMMENT 'Aberta\nPreenchida\nCancelada',
  `logotipo_empresa` varchar(100) DEFAULT NULL COMMENT 'Imagem do logotipo da empresa',
  `quantidade_vagas` int(11) DEFAULT 1 COMMENT 'Quantidade de vagas oferecidas',
  `usuarios_id_empresa_vaga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `vagas`
--

INSERT INTO `vagas` (`id_vagas`, `titulo`, `categoria`, `descricao`, `requisitos`, `remuneracao`, `situacao`, `logotipo_empresa`, `quantidade_vagas`, `usuarios_id_empresa_vaga`) VALUES
(8, 'ddddddd', NULL, 'dddddddd', 'ddddddd', 0.52, 'Aberta', NULL, 18, 4),
(9, NULL, NULL, NULL, NULL, NULL, NULL, 'uploads/logos/default.jpg', NULL, 8),
(17, 'Usa essa ', NULL, 'sssssssssssssssssssss', 'ssssssssssssssssss', 5000.00, 'Aberta', NULL, 1, 11),
(19, 'ssssss', 'Manual de Identidade de Marca', 'ssssssssss', 'sssssssssss', 8000000000.00, 'Aberta', NULL, 13, 7),
(20, 'fdsf', 'Design de Logo', 'fdddddddd', 'fdsfsf', 6000.00, 'Aberta', NULL, 14, 6);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `curriculo`
--
ALTER TABLE `curriculo`
  ADD PRIMARY KEY (`id_curriculo`),
  ADD KEY `fk_curriculo_usuarios_idx` (`usuarios_id_usuarios`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuarios`);

--
-- Índices de tabela `usuarios_concorre_vaga`
--
ALTER TABLE `usuarios_concorre_vaga`
  ADD PRIMARY KEY (`usuarios_id_usuarios`,`vagas_id_vagas`),
  ADD KEY `fk_usuarios_has_vagas_vagas1_idx` (`vagas_id_vagas`),
  ADD KEY `fk_usuarios_has_vagas_usuarios1_idx` (`usuarios_id_usuarios`);

--
-- Índices de tabela `vagas`
--
ALTER TABLE `vagas`
  ADD PRIMARY KEY (`id_vagas`),
  ADD KEY `fk_vagas_usuarios1_idx` (`usuarios_id_empresa_vaga`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `curriculo`
--
ALTER TABLE `curriculo`
  MODIFY `id_curriculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `vagas`
--
ALTER TABLE `vagas`
  MODIFY `id_vagas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `curriculo`
--
ALTER TABLE `curriculo`
  ADD CONSTRAINT `fk_curriculo_usuarios` FOREIGN KEY (`usuarios_id_usuarios`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `usuarios_concorre_vaga`
--
ALTER TABLE `usuarios_concorre_vaga`
  ADD CONSTRAINT `fk_usuarios_has_vagas_usuarios1` FOREIGN KEY (`usuarios_id_usuarios`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuarios_has_vagas_vagas1` FOREIGN KEY (`vagas_id_vagas`) REFERENCES `vagas` (`id_vagas`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `vagas`
--
ALTER TABLE `vagas`
  ADD CONSTRAINT `fk_vagas_usuarios1` FOREIGN KEY (`usuarios_id_empresa_vaga`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
