ALTER TABLE `produtos` ADD `caminho_imagem` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ;
ALTER TABLE `produtos` ADD `ativo` BIT( 1 ) NOT NULL DEFAULT b'1';
