-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 28-Dez-2016 às 01:33
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lojavirtual`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id`, `titulo`) VALUES
(1, 'Sapato'),
(2, 'Camisa'),
(3, 'Calça'),
(4, 'Bonés');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamentos`
--

CREATE TABLE IF NOT EXISTS `pagamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `pagamentos`
--

INSERT INTO `pagamentos` (`id`, `nome`) VALUES
(1, 'Cortesia'),
(2, 'Pagseguro'),
(3, 'Paypal'),
(4, 'Boleto'),
(5, 'MoIP');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `imagem` varchar(36) NOT NULL,
  `preco` float NOT NULL,
  `quantidade` int(11) NOT NULL,
  `descricao` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `id_categoria`, `nome`, `imagem`, `preco`, `quantidade`, `descricao`) VALUES
(1, 1, 'Produto 1', 'sapato1.png', 110, 200, 'Descrição do produto 1'),
(2, 1, 'Produto 2', 'sapato2.png', 80, 200, 'Descrição do produto 2'),
(3, 1, 'Produto 3', 'sapato3.png', 130, 200, 'Descrição do produto 3'),
(4, 1, 'Produto 4', 'sapato4.png', 150, 200, 'Descrição do produto 4'),
(5, 1, 'Produto 5', 'sapato5.png', 250, 200, 'Descrição do produto 5'),
(6, 2, 'Produto 6', 'camisa3.png', 60, 200, 'Descrição do produto 1'),
(7, 2, 'Produto 7', 'camisa1.png', 50, 200, 'Descrição do produto 2'),
(8, 2, 'Produto 8', 'camisa2.png', 70, 200, 'Descrição do produto 3'),
(9, 2, 'Produto 9', 'camisa4.png', 80, 200, 'Descrição do produto 4'),
(10, 2, 'Produto 10', 'camisa5.png', 40, 200, 'Descrição do produto 5'),
(11, 3, 'Produto 11', 'calca1.png', 60, 200, 'Descrição do produto 1'),
(12, 3, 'Produto 12', 'calca2.png', 90, 200, 'Descrição do produto 2'),
(13, 3, 'Produto 13', 'calca3.png', 95, 200, 'Descrição do produto 3'),
(14, 3, 'Produto 14', 'calca4.png', 55, 200, 'Descrição do produto 4'),
(15, 3, 'Produto 15', 'calca5.png', 65, 200, 'Descrição do produto 5'),
(16, 4, 'Produto 16', 'bones1.png', 40, 200, 'Descrição do produto 1'),
(17, 4, 'Produto 17', 'bones2.png', 45, 200, 'Descrição do produto 2'),
(18, 4, 'Produto 18', 'bones3.png', 63, 200, 'Descrição do produto 3'),
(19, 4, 'Produto 19', 'bones4.png', 94, 200, 'Descrição do produto 4'),
(20, 4, 'Produto 20', 'bones5.png', 66, 200, 'Descrição do produto 5');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`) VALUES
(1, 'Orlando', 'orlandocorreia2@hotmail.com', '202cb962ac59075b964b07152d234b70'),
(2, 'Orlando', 'ocnascimento2@gmail.com', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendas`
--

CREATE TABLE IF NOT EXISTS `vendas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `endereco` text,
  `valor` float NOT NULL,
  `forma_pg` int(11) NOT NULL,
  `status_pg` tinyint(1) DEFAULT NULL,
  `pg_link` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `vendas`
--

INSERT INTO `vendas` (`id`, `id_usuario`, `endereco`, `valor`, `forma_pg`, `status_pg`, `pg_link`) VALUES
(1, 1, 'rua manuel', 400, 1, 2, '/carrinho/obrigado'),
(2, 1, 'rua manuel', 420, 2, 1, ''),
(3, 1, 'rua manuel', 290, 2, 1, ''),
(4, 2, 'rua manuel', 250, 2, 1, ''),
(5, 2, 'rua manuel', 80, 2, 1, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendas_produto`
--

CREATE TABLE IF NOT EXISTS `vendas_produto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_venda` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Extraindo dados da tabela `vendas_produto`
--

INSERT INTO `vendas_produto` (`id`, `id_venda`, `id_produto`, `quantidade`) VALUES
(1, 1, 5, 1),
(2, 1, 7, 1),
(3, 1, 11, 1),
(4, 1, 16, 1),
(5, 2, 5, 1),
(6, 2, 9, 1),
(7, 2, 12, 1),
(8, 3, 5, 1),
(9, 3, 10, 1),
(10, 4, 5, 1),
(11, 5, 9, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
