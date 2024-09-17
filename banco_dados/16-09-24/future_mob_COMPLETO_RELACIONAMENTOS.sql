SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE DATABASE IF NOT EXISTS `future_mob` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `future_mob`;

DROP TABLE IF EXISTS `avaliacoes`;
CREATE TABLE IF NOT EXISTS `avaliacoes` (
  `id_avaliacao` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `avaliacao` decimal(2,1) NOT NULL,
  `dt_avaliacao` date NOT NULL,
  `titulo` varchar(50) CHARACTER SET utf8 NOT NULL,
  `descricao` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  `imagem` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `verificado` bit(1) NOT NULL,
  PRIMARY KEY (`id_avaliacao`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_produto` (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `avaliacoes_curtidas`;
CREATE TABLE IF NOT EXISTS `avaliacoes_curtidas` (
  `id_usuario` int(11) NOT NULL,
  `id_avaliacao` int(11) NOT NULL,
  `curtiu` bit(1) NOT NULL,
  `descurtiu` bit(1) NOT NULL,
  `dt_interacao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `id_cliente` (`id_usuario`),
  KEY `id_avaliacao` (`id_avaliacao`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_avaliacao_2` (`id_avaliacao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `carrinho`;
CREATE TABLE IF NOT EXISTS `carrinho` (
  `id_usuario` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(3) NOT NULL,
  KEY `id_cliente` (`id_usuario`),
  KEY `id_produto` (`id_produto`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_produto_2` (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nome` varchar(50) CHARACTER SET utf8 NOT NULL,
  `descricao` varchar(500) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `enderecos`;
CREATE TABLE IF NOT EXISTS `enderecos` (
  `id_endereco` int(11) NOT NULL AUTO_INCREMENT,
  `cep` char(8) CHARACTER SET utf8 NOT NULL,
  `logradouro` varchar(50) CHARACTER SET utf8 NOT NULL,
  `numero` varchar(7) CHARACTER SET utf8 NOT NULL,
  `complemento` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `bairro` int(20) NOT NULL,
  `cidade` varchar(60) CHARACTER SET utf8 NOT NULL,
  `uf` char(2) CHARACTER SET utf8 NOT NULL,
  `dt_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_endereco`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `enderecos_usuarios`;
CREATE TABLE IF NOT EXISTS `enderecos_usuarios` (
  `id_endereco` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  KEY `id_endereco` (`id_endereco`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id_usuario` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `dt_inclusao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `id_cliente` (`id_usuario`),
  KEY `id_produto` (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `pagamentos`;
CREATE TABLE IF NOT EXISTS `pagamentos` (
  `id_pagamento` int(11) NOT NULL AUTO_INCREMENT,
  `numero_cartao` int(16) NOT NULL,
  `nome_impresso` varchar(20) CHARACTER SET utf8 NOT NULL,
  `dt_expiracao` date NOT NULL,
  `codigo_seguranca` int(3) NOT NULL,
  `bandeira` varchar(20) CHARACTER SET utf8 NOT NULL,
  `dt_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `apelido` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id_pagamento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `pagamentos_usuarios`;
CREATE TABLE IF NOT EXISTS `pagamentos_usuarios` (
  `id_pagamento` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `credito` bit(1) NOT NULL,
  `debito` bit(1) NOT NULL,
  KEY `id_pagamento` (`id_pagamento`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `dt_pedido` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `subtotal` decimal(10,2) NOT NULL,
  `frete` decimal(5,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `id_pagamento` int(11) NOT NULL,
  `id_endereco` int(11) NOT NULL,
  `id_status` int(11) NOT NULL,
  `dt_entrega` date DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `id_pagamento` (`id_pagamento`),
  KEY `id_endereco` (`id_endereco`),
  KEY `id_status` (`id_status`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `pedidos_produtos`;
CREATE TABLE IF NOT EXISTS `pedidos_produtos` (
  `id_pedido` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(3) NOT NULL,
  KEY `id_pedido` (`id_pedido`),
  KEY `id_produto` (`id_produto`),
  KEY `id_produto_2` (`id_produto`),
  KEY `id_pedido_2` (`id_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `id_status` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(25) NOT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome_completo` varchar(80) CHARACTER SET utf8 NOT NULL,
  `cpf` char(11) CHARACTER SET utf8 NOT NULL,
  `rg` char(9) CHARACTER SET utf8 NOT NULL,
  `dt_nascimento` date NOT NULL,
  `sexo` char(1) CHARACTER SET utf8 NOT NULL,
  `telefone_celular` char(11) CHARACTER SET utf8 NOT NULL,
  `email` varchar(80) CHARACTER SET utf8 NOT NULL,
  `senha` varchar(255) CHARACTER SET utf8 NOT NULL,
  `admin` bit(1) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `cpf` (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


ALTER TABLE `avaliacoes`
  ADD CONSTRAINT `FK_Produto-Avaliacao` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Usuario-Avaliacao` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `avaliacoes_curtidas`
  ADD CONSTRAINT `FK_AvaliacaoCurtida-Usuario` FOREIGN KEY (`id_avaliacao`) REFERENCES `avaliacoes` (`id_avaliacao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Usuario-AvaliacaoCurtida` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `carrinho`
  ADD CONSTRAINT `FK_Usuario-Carrinho` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Produto-Carrinho` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `enderecos_usuarios`
  ADD CONSTRAINT `FK_Usuario-Endereco` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Endereco-Usuario` FOREIGN KEY (`id_endereco`) REFERENCES `enderecos` (`id_endereco`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `favoritos`
  ADD CONSTRAINT `FK_ProdutoFavorito` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Usuario-ProdutoFavorito` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `pagamentos_usuarios`
  ADD CONSTRAINT `FK_Usuario-Pagamento` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Pagamento-Usuario` FOREIGN KEY (`id_pagamento`) REFERENCES `pagamentos` (`id_pagamento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `pedidos`
  ADD CONSTRAINT `FK_Usuario-Pedido` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Endereco-Pedido` FOREIGN KEY (`id_endereco`) REFERENCES `enderecos` (`id_endereco`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Pagamento-Pedido` FOREIGN KEY (`id_pagamento`) REFERENCES `pagamentos` (`id_pagamento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Status-Pedido` FOREIGN KEY (`id_status`) REFERENCES `status` (`id_status`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `pedidos_produtos`
  ADD CONSTRAINT `FK_Produto-Pedido` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Pedido-Produto` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `produtos`
  ADD CONSTRAINT `FK_Produto-Categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
