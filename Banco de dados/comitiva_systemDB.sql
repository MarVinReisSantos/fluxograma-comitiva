-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 10-Jan-2018 às 13:09
-- Versão do servidor: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `comitiva_system`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `conteudo`
--

CREATE TABLE `conteudo` (
  `nome` varchar(60) CHARACTER SET latin1 NOT NULL,
  `didatica` varchar(500) CHARACTER SET latin1 DEFAULT NULL,
  `tempo` int(1) DEFAULT NULL,
  `ritmo` varchar(30) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `conteudo`
--

INSERT INTO `conteudo` (`nome`, `didatica`, `tempo`, `ritmo`) VALUES
('', '', 1, 'Forró'),
('Banana', '', 1, 'Forró'),
('Banana com Saída em Letra', '', 1, 'Forró'),
('Base 0', 'Ir diminuindo a Base 1, e fazendo aos lados, sempre diminuindo a ida até a marcação estar no lugar.', 1, 'Forró'),
('Base 1', 'Ensinar andando para frente e para trás depois restringir a dois pra frente e dois pra trás.', 1, 'Forró'),
('Base 1 Redonda', '', 1, 'Forró'),
('Base 2', '', 1, 'Forró'),
('Base 2 Aberta', '', 1, 'Forró'),
('Base 2 Fechada', '', 1, 'Forró'),
('Base 3', '', 1, 'Forró'),
('Base de rastapé', '', 1, 'Forró'),
('Cestinho', '', 1, 'Forró'),
('Chave', '', 1, 'Forró'),
('Chave com a Mão Trocada', '', 1, 'Forró'),
('Chicote', '', 1, 'Forró'),
('Chuveirinho', '', 1, 'Forró'),
('Enfeite da Base 2 com Rebolada', '', 1, 'Forró'),
('Enfeite da Base 2 de Três Projeções ao Lado', '', 1, 'Forró'),
('Enfeite da Base 2 em Duplo \'S\'', '', 1, 'Forró'),
('Enfeite da Base 2 Marcando à Frente', '', 1, 'Forró'),
('Enfeite da Chave com Troca de Mão', '', 1, 'Forró'),
('Meia Base 1', '', 1, 'Forró'),
('Paradinha', '', 1, 'Forró'),
('Passagem com a Mão Invertida', '', 1, 'Forró'),
('Passagem com as Duas Mãos', '', 1, 'Forró'),
('Passagem com uma Mão', '', 1, 'Forró'),
('Passagem Trocando a Mão', '', 1, 'Forró'),
('Sacada de braço', '', 1, 'Forró');

-- --------------------------------------------------------

--
-- Estrutura da tabela `conteudo_requisitos`
--

CREATE TABLE `conteudo_requisitos` (
  `conteudo_nome` varchar(60) CHARACTER SET latin1 NOT NULL,
  `conteudo_ritmo` varchar(30) NOT NULL,
  `requisito_nome` varchar(60) CHARACTER SET latin1 NOT NULL,
  `requisito_ritmo` varchar(30) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `conteudo_requisitos`
--

INSERT INTO `conteudo_requisitos` (`conteudo_nome`, `conteudo_ritmo`, `requisito_nome`, `requisito_ritmo`) VALUES
('Banana com Saída em Letra', 'Forró', 'Banana', 'Forró'),
('Base 1 Redonda', 'Forró', 'Base 1', 'Forró'),
('Base 2', 'Forró', 'Base 1', 'Forró'),
('Chicote', 'Forró', 'Base 1', 'Forró'),
('Meia Base 1', 'Forró', 'Base 1', 'Forró'),
('Paradinha', 'Forró', 'Base 1', 'Forró'),
('Base 2 Aberta', 'Forró', 'Base 2', 'Forró'),
('Base 2 Fechada', 'Forró', 'Base 2', 'Forró'),
('Enfeite da Base 2 com Rebolada', 'Forró', 'Base 2', 'Forró'),
('Enfeite da Base 2 de Três Projeções ao Lado', 'Forró', 'Base 2', 'Forró'),
('Enfeite da Base 2 em Duplo \'S\'', 'Forró', 'Base 2', 'Forró'),
('Enfeite da Base 2 Marcando à Frente', 'Forró', 'Base 2', 'Forró'),
('Chave', 'Forró', 'Base 2 Aberta', 'Forró'),
('Chave com a Mão Trocada', 'Forró', 'Base 2 Aberta', 'Forró'),
('Passagem com a Mão Invertida', 'Forró', 'Base 2 Aberta', 'Forró'),
('Passagem com as Duas Mãos', 'Forró', 'Base 2 Aberta', 'Forró'),
('Passagem com uma Mão', 'Forró', 'Base 2 Aberta', 'Forró'),
('Passagem Trocando a Mão', 'Forró', 'Base 2 Aberta', 'Forró'),
('Enfeite da Chave com Troca de Mão', 'Forró', 'Chave', 'Forró'),
('Enfeite da Chave com Troca de Mão', 'Forró', 'Chave com a Mão Trocada', 'Forró'),
('Banana', 'Forró', 'Passagem com as Duas Mãos', 'Forró'),
('Cestinho', 'Forró', 'Passagem com as Duas Mãos', 'Forró'),
('Chuveirinho', 'Forró', 'Passagem com as Duas Mãos', 'Forró');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `conteudo`
--
ALTER TABLE `conteudo`
  ADD PRIMARY KEY (`nome`,`ritmo`);

--
-- Indexes for table `conteudo_requisitos`
--
ALTER TABLE `conteudo_requisitos`
  ADD PRIMARY KEY (`conteudo_ritmo`,`requisito_nome`,`requisito_ritmo`,`conteudo_nome`),
  ADD KEY `requisito_nome` (`requisito_nome`,`requisito_ritmo`),
  ADD KEY `CONTEUDO_REQUISITOS_ibfk_1` (`conteudo_nome`,`conteudo_ritmo`);

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `conteudo_requisitos`
--
ALTER TABLE `conteudo_requisitos`
  ADD CONSTRAINT `CONTEUDO_REQUISITOS_ibfk_2` FOREIGN KEY (`requisito_nome`,`requisito_ritmo`) REFERENCES `conteudo` (`nome`, `ritmo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
