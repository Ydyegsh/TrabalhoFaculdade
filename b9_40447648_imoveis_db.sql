-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql100.byethost9.com
-- Tempo de geração: 27/11/2025 às 08:15
-- Versão do servidor: 10.6.22-MariaDB
-- Versão do PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `b9_40447648_imoveis_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `imoveis`
--

CREATE TABLE `imoveis` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descricao` text DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `tipo` enum('Apartamento','Casa','Terreno','Comercial','Outro') DEFAULT 'Outro',
  `area_m2` decimal(10,2) DEFAULT NULL,
  `quartos` int(11) DEFAULT NULL,
  `valor` decimal(14,2) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `imoveis`
--

INSERT INTO `imoveis` (`id`, `titulo`, `descricao`, `endereco`, `cidade`, `estado`, `tipo`, `area_m2`, `quartos`, `valor`, `imagem`, `criado_em`, `atualizado_em`) VALUES
(7, 'Casa de Praia', 'Casa próxima à praia, com vista pro mar', '', 'Fortaleza', 'Ceará', 'Casa', '1600.00', 5, '800000.00', '870b52e01dd626d8.jpg', '2025-11-19 13:49:39', '2025-11-19 13:50:52'),
(9, 'Vendo Apartamento na Praia', 'Vendo casa na beira mar', 'Beira Mar, 1312', 'Fortaleza', 'Ceara', 'Apartamento', '25.00', 3, '100000.00', NULL, '2025-11-27 11:02:20', NULL),
(10, 'Vendo casa', 'vendo', 'Rua Padre Texeira, 141', 'São Paulo', 'Sao Paulo', 'Casa', '50.00', 4, '200000.00', NULL, '2025-11-27 12:10:57', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`email`, `senha`, `id`) VALUES
('aleatorio1@gmail.com', '$2y$10$MUEdDEC13JC4XUIcvlCc3uZZ02484UfP76zsh3OHMt2KI541seBUe', 0),
('pexew80179@moondyal.com', '$2y$10$lajJ3DN0ezoY5X.NAt6Ou.M02Wkj2l0.NkSwPuKvNuNpK0b5IZDQS', 0),
('aleatorio12@gmail.com', '$2y$10$fAigfzFM6MeZ42OqdjabGOLVmttpmwzDIMlNyIGYzoDUKu07PjkIS', 0),
('aleatorio13@gmail.com', '$2y$10$tl3CP9RTCqKiV1nSMjfO7.NsessgRrWVQ28ZpA34ET5E8kcrW5YN6', 0);

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `imoveis`
--
ALTER TABLE `imoveis`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `imoveis`
--
ALTER TABLE `imoveis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
