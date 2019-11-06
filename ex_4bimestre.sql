-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 06-Nov-2019 às 16:02
-- Versão do servidor: 5.6.13
-- versão do PHP: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `ex_4bimestre`
--
CREATE DATABASE IF NOT EXISTS `ex_4bimestre` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ex_4bimestre`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cadastro`
--

CREATE TABLE IF NOT EXISTS `cadastro` (
  `id_cadastro` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `sexo` char(1) NOT NULL,
  `salario` float NOT NULL,
  `cod_cidade` int(11) NOT NULL,
  PRIMARY KEY (`id_cadastro`),
  KEY `cod-cidade` (`cod_cidade`),
  KEY `cod-cidade_2` (`cod_cidade`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Extraindo dados da tabela `cadastro`
--

INSERT INTO `cadastro` (`id_cadastro`, `nome`, `email`, `sexo`, `salario`, `cod_cidade`) VALUES
(28, 'Ana Julia Cunha', 'annaju@h', 'f', 5000, 1),
(29, 'Bianca Maria', 'bibi@m', 'f', 1222, 1),
(30, 'Carolina Souza', 'carol@s', 'f', 500, 2),
(31, 'Carlos Andrade', 'carlito@a', 'm', 2600, 1),
(32, 'Davi Picoli', 'davi@p', 'm', 4600, 1),
(33, 'Daniela Silva', 'dani@s', 'f', 1650, 2),
(35, 'Eduarda Oliveira', 'duda@o', 'f', 500, 1),
(36, 'rosa', 'gsvf@c', 'f', 20000, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cidade`
--

CREATE TABLE IF NOT EXISTS `cidade` (
  `id_cidade` int(11) NOT NULL AUTO_INCREMENT,
  `nome_cidade` varchar(50) NOT NULL,
  `cod_estado` int(11) NOT NULL,
  PRIMARY KEY (`id_cidade`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Extraindo dados da tabela `cidade`
--

INSERT INTO `cidade` (`id_cidade`, `nome_cidade`, `cod_estado`) VALUES
(1, 'araraquara', 1),
(2, 'Sao Carlos', 1),
(3, 'Rio Branco', 3),
(4, 'Mácapa', 4),
(5, 'Manaus', 4),
(6, 'Belém', 5),
(7, 'Porto Velho', 6),
(8, 'Palmas', 7),
(9, 'Sao Luis', 8),
(10, 'Teresina', 9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `estado`
--

CREATE TABLE IF NOT EXISTS `estado` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `uf` char(2) NOT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `estado`
--

INSERT INTO `estado` (`id_estado`, `nome`, `uf`) VALUES
(1, 'São Paulo', 'SP'),
(2, 'Distrito Federal', 'DF'),
(3, 'Acre', 'AC'),
(4, 'Alagoas', 'AL'),
(5, 'Amapá', 'AP'),
(6, 'Amazonas', 'AM'),
(7, 'Bahia', 'BA'),
(8, 'Amapá', 'AP'),
(9, 'Amazonas', 'AM');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
