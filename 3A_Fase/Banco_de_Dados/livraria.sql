-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tempo de Geração: 05/06/2025 às 18h18min
-- Versão do Servidor: 5.5.20
-- Versão do PHP: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `livraria`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `autor`
--

CREATE TABLE IF NOT EXISTS `autor` (
  `codigo` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `pais` varchar(50) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Extraindo dados da tabela `autor`
--

INSERT INTO `autor` (`codigo`, `nome`, `pais`) VALUES
(1, 'Miguel de Cervantes', 'Espanha'),
(2, 'Gabriel GarcÃ­a MÃ¡rquez', 'ColÃ´mbia'),
(3, 'Jane Austen', 'Inglaterra (Reino Unido)'),
(4, 'Dante Alighieri', 'ItÃ¡lia'),
(5, 'William Shakespeare', 'Inglaterra (Reino Unido)'),
(6, 'Leon TolstÃ³i', 'RÃºssia'),
(7, 'Gustave Flaubert', 'FranÃ§a'),
(8, 'Marcel Proust', 'FranÃ§a'),
(9, 'James Joyce', 'Irlanda'),
(10, 'Herman Melville', 'Estados Unidos'),
(11, 'FiÃ³dor DostoiÃ©vski', 'RÃºssia'),
(12, 'F. Scott Fitzgerald', 'Estados Unidos'),
(13, 'George Orwell', 'Ãndia BritÃ¢nica'),
(14, 'Homero', 'GrÃ©cia'),
(15, 'Mary Shelley', 'Inglaterra (Reino Unido)'),
(16, 'Victor Hugo', 'FranÃ§a'),
(17, 'Antoine de Saint-ExupÃ©ry', 'FranÃ§a'),
(18, 'Machado de Assis', 'Brasil'),
(19, 'Leon TolstÃ³i', 'RÃºssia'),
(20, 'J.R.R. Tolkien', 'Ãfrica do Sul');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `codigo` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`codigo`, `nome`) VALUES
(1, 'Romance'),
(2, 'FicÃ§Ã£o CientÃ­fica'),
(3, 'Fantasia'),
(4, 'MistÃ©rio'),
(5, 'Thriller/Suspense'),
(6, 'Terror/Horror'),
(7, 'FicÃ§Ã£o HistÃ³rica'),
(8, 'FicÃ§Ã£o ContemporÃ¢nea'),
(9, 'Realismo MÃ¡gico'),
(10, 'Literatura Infantojuvenil'),
(11, 'Poesia'),
(12, 'Drama/PeÃ§a Teatral'),
(13, 'ComÃ©dia'),
(14, 'TragÃ©dia'),
(15, 'SÃ¡tira'),
(16, 'FÃ¡bula'),
(17, 'Biografia/Autobiografia'),
(18, 'Ensaio'),
(19, 'CrÃ´nica'),
(20, 'FicÃ§Ã£o de Aventura');

-- --------------------------------------------------------

--
-- Estrutura da tabela `editora`
--

CREATE TABLE IF NOT EXISTS `editora` (
  `codigo` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Extraindo dados da tabela `editora`
--

INSERT INTO `editora` (`codigo`, `nome`) VALUES
(1, 'IntrÃ­nseca'),
(2, 'Sextante'),
(3, 'Rocco'),
(4, 'HarperCollins'),
(5, 'DarkSide Books'),
(6, 'AntofÃ¡gica'),
(7, 'Companhia Penguin'),
(8, 'Zahar'),
(9, 'Arqueiro'),
(10, 'Citadel'),
(11, 'Fato Editorial'),
(12, 'Pipoca e Nanquim'),
(13, 'Buzz Editora'),
(14, 'Objetiva'),
(15, 'Wish'),
(16, 'Editorial Record'),
(17, 'Cosac Naify'),
(18, 'Companhia das Letras'),
(19, 'Editora 34'),
(20, 'PrincÃ­pia');

-- --------------------------------------------------------

--
-- Estrutura da tabela `livro`
--

CREATE TABLE IF NOT EXISTS `livro` (
  `codigo` int(5) NOT NULL AUTO_INCREMENT,
  `isbn` int(20) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `numero_paginas` int(4) NOT NULL,
  `ano` int(4) NOT NULL,
  `cod_autor` int(5) NOT NULL,
  `cod_categoria` int(5) NOT NULL,
  `cod_editora` int(5) NOT NULL,
  `sinopse` text NOT NULL,
  `preco` float(6,2) NOT NULL,
  `foto_capa` varchar(100) NOT NULL,
  `foto_contracapa` varchar(100) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `cod_autor` (`cod_autor`),
  KEY `cod_categoria` (`cod_categoria`),
  KEY `cod_editora` (`cod_editora`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `livro`
--

INSERT INTO `livro` (`codigo`, `isbn`, `titulo`, `numero_paginas`, `ano`, `cod_autor`, `cod_categoria`, `cod_editora`, `sinopse`, `preco`, `foto_capa`, `foto_contracapa`) VALUES
(9, 123456, 'Teste de Livro', 123, 2025, 1, 2, 3, 'rgrgrgrgrgrgrgrgrgr', 152.00, 'a400929570618d93a183aad79e3a8fb3.jpg', '771fe68f089e54b482d08217ca6845eb.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `codigo` int(5) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `senha` varchar(10) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`codigo`, `email`, `senha`) VALUES
(1, 'pedrohnurbano@gmail.com', '1234');

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `livro`
--
ALTER TABLE `livro`
  ADD CONSTRAINT `livro_ibfk_1` FOREIGN KEY (`cod_autor`) REFERENCES `autor` (`codigo`),
  ADD CONSTRAINT `livro_ibfk_2` FOREIGN KEY (`cod_categoria`) REFERENCES `categoria` (`codigo`),
  ADD CONSTRAINT `livro_ibfk_3` FOREIGN KEY (`cod_editora`) REFERENCES `editora` (`codigo`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
