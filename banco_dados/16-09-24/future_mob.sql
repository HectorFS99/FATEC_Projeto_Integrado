-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 16-Set-2024 às 22:27
-- Versão do servidor: 5.6.13
-- versão do PHP: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `future_mob`
--
CREATE DATABASE IF NOT EXISTS `future_mob` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `future_mob`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE IF NOT EXISTS `produtos` (
  `id_produto` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `descricao` varchar(500) NOT NULL,
  `preco_anterior` decimal(10,2) NOT NULL,
  `preco_atual` decimal(10,2) NOT NULL,
  `altura` decimal(5,2) NOT NULL,
  `largura` decimal(5,2) NOT NULL,
  `profundidade` decimal(5,2) NOT NULL,
  `peso` decimal(6,2) NOT NULL,
  `destaque` bit(1) NOT NULL,
  `oferta_relampago` bit(1) NOT NULL,
  PRIMARY KEY (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome_completo` varchar(80) CHARACTER SET utf8 NOT NULL,
  `cpf` char(11) NOT NULL,
  `rg` char(9) NOT NULL,
  `dt_nascimento` date NOT NULL,
  `sexo` char(1) NOT NULL,
  `telefone_celular` char(11) NOT NULL,
  `email` varchar(80) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `admin` bit(1) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `cpf` (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
