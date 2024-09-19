SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE DATABASE IF NOT EXISTS `future_mob` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `future_mob`;

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) CHARACTER SET utf8 NOT NULL,
  `descricao` varchar(500) CHARACTER SET utf8 NOT NULL,
  `caminho_icone` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

INSERT INTO `categorias` (`id_categoria`, `nome`, `descricao`, `caminho_icone`) VALUES
(1, 'Escritório', 'Móveis de qualidade para o seu escritório!', 'recursos/imagens/icones/escritorio.svg'),
(2, 'Quarto', 'Conforto e elegância para o seu quarto!', 'recursos/imagens/icones/quarto.svg'),
(3, 'Cozinha', 'A combinação perfeita entre sofisticação e culinária!', 'recursos/imagens/icones/cozinha.svg'),
(4, 'Sala de Jantar', 'Que tal ter as suas refeições em um ambiente elegante, dentro da sua casa?', 'recursos/imagens/icones/saladejantar.svg'),
(5, 'Área Externa', 'A beleza e as cores presentes em nossas criações combinam perfeitamente com o seu jardim!', 'recursos/imagens/icones/areaexterna.svg'),
(6, 'Sala de Estar', 'A elegância e o aconchego na sua sala de estar!', 'recursos/imagens/icones/saladeestar.svg');

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id_produto` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) CHARACTER SET utf8 NOT NULL,
  `descricao` varchar(500) CHARACTER SET utf8 NOT NULL,
  `preco_anterior` decimal(10,2) NOT NULL,
  `preco_atual` decimal(10,2) NOT NULL,
  `altura` decimal(5,2) NOT NULL,
  `largura` decimal(5,2) NOT NULL,
  `profundidade` decimal(5,2) NOT NULL,
  `peso` decimal(6,2) NOT NULL,
  `destaque` bit(1) NOT NULL,
  `oferta_relampago` bit(1) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  PRIMARY KEY (`id_produto`),
  KEY `id_categoria` (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


ALTER TABLE `produtos`
  ADD CONSTRAINT `FK_Produto-Categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
