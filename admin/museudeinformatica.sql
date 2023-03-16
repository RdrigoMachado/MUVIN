-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2023 at 04:24 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `museudeinformatica`
--

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`id`, `nome`) VALUES
(1, 'DispositivosArmazenamento'),
(2, 'Periferico');

-- --------------------------------------------------------

--
-- Table structure for table `colaboradores`
--

CREATE TABLE `colaboradores` (
  `id` int(11) NOT NULL,
  `Nome` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Telefone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `componente`
--

CREATE TABLE `componente` (
  `id` int(11) NOT NULL,
  `tipo_id` int(11) DEFAULT NULL,
  `pais_id` int(11) DEFAULT NULL,
  `fabricante_id` int(11) DEFAULT NULL,
  `ano_fabricacao` varchar(4) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `curiosidades` text DEFAULT NULL,
  `cid` varchar(10) DEFAULT NULL,
  `ultima_atualizacao` date DEFAULT NULL,
  `criacao` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `componente`
--

INSERT INTO `componente` (`id`, `tipo_id`, `pais_id`, `fabricante_id`, `ano_fabricacao`, `modelo`, `curiosidades`, `cid`, `ultima_atualizacao`, `criacao`) VALUES
(18, 6, 1, 2, '2020', 'Allo Origings Pro', '', 'hx001', '2022-11-22', '2022-11-22'),
(19, 14, 3, 4, '2002', 'Compaq nx9010', '', 'hp001', '2022-11-29', '2022-11-29'),
(20, 14, 4, 5, '2007', 'pcg-4n4l', '', 'va001', '2022-11-29', '2022-11-29'),
(21, 14, 5, 6, '2000', 'travelmate 345t', '', 'ac001', '2022-11-29', '2022-11-29'),
(22, 13, 7, 3, '2006', 'wd800jd', '', 'wd001', '2023-03-16', '2023-03-16'),
(23, 15, 1, 8, '1985', '2s/2d-md 550-01', '', 'vb001', '2022-11-29', '2022-11-29'),
(24, 16, 2, 9, '1992', 'a80486sx-33', '', 'in002', '2022-11-29', '2022-11-29'),
(25, 17, 9, 10, '2007', 'm470t5663eh3-cf7', '', 'sg013', '2022-11-29', '2022-11-29'),
(26, 21, 2, 6, '123', '123', '123', '123rr', '2023-03-16', '2023-03-16');

-- --------------------------------------------------------

--
-- Table structure for table `disco_rigido`
--

CREATE TABLE `disco_rigido` (
  `id` int(11) NOT NULL,
  `rpm` int(11) DEFAULT NULL,
  `componente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `disco_rigido`
--

INSERT INTO `disco_rigido` (`id`, `rpm`, `componente_id`) VALUES
(3, 0, 22);

-- --------------------------------------------------------

--
-- Table structure for table `disquete`
--

CREATE TABLE `disquete` (
  `id` int(11) NOT NULL,
  `polegadas` varchar(5) DEFAULT NULL,
  `componente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `disquete`
--

INSERT INTO `disquete` (`id`, `polegadas`, `componente_id`) VALUES
(1, '5 1/4', 23);

-- --------------------------------------------------------

--
-- Table structure for table `fabricante`
--

CREATE TABLE `fabricante` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fabricante`
--

INSERT INTO `fabricante` (`id`, `nome`) VALUES
(6, 'Acer'),
(1, 'DELL'),
(4, 'HP'),
(2, 'HyperX'),
(9, 'Intel'),
(10, 'Samsung'),
(5, 'Sony'),
(7, 'Toshiba'),
(8, 'Verbatim '),
(3, 'Western Digital');

-- --------------------------------------------------------

--
-- Table structure for table `imagem`
--

CREATE TABLE `imagem` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `principal` varchar(1) DEFAULT NULL,
  `componente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `imagem`
--

INSERT INTO `imagem` (`id`, `nome`, `principal`, `componente_id`) VALUES
(6, 'shopping.webp', '', 18),
(7, 'HyperX-Alloy-Origins-60-Review-Backside.jpg', '', 18),
(8, 'maxresdefault.jpg', '', 18),
(9, 'hp0011.jpg', '', 19),
(10, 'hp0012.jpg', '', 19),
(11, 'va0011.jpg', '', 20),
(12, 'va0012.jpg', '', 20),
(15, 'ac001.jpg', '', 21),
(16, 'ac0012.jpg', '', 21),
(18, 'wd800jd.jpg', '', 22),
(20, '2-md 550-01.jpg', '', 23),
(21, 'a80486sx-33.jpg', '', 24),
(22, 'a80486sx-331.jpg', '', 24),
(23, 'm470t5663eh3-cf7.jpg', '', 25);

-- --------------------------------------------------------

--
-- Table structure for table `notebook`
--

CREATE TABLE `notebook` (
  `id` int(11) NOT NULL,
  `ram` varchar(10) DEFAULT NULL,
  `processador` varchar(50) DEFAULT NULL,
  `componente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notebook`
--

INSERT INTO `notebook` (`id`, `ram`, `processador`, `componente_id`) VALUES
(1, '', '', 19),
(2, '', '', 20),
(3, '', '', 21);

-- --------------------------------------------------------

--
-- Table structure for table `pais`
--

CREATE TABLE `pais` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pais`
--

INSERT INTO `pais` (`id`, `nome`) VALUES
(1, 'Brasil'),
(2, 'Malasia'),
(3, 'Canadá'),
(4, 'Japão'),
(5, 'Taiwan'),
(6, 'Filipinas'),
(7, 'Malasia'),
(8, 'Tailândia'),
(9, 'China'),
(10, 'Costa Rica');

-- --------------------------------------------------------

--
-- Table structure for table `processador`
--

CREATE TABLE `processador` (
  `id` int(11) NOT NULL,
  `clock` varchar(10) DEFAULT NULL,
  `l1` varchar(10) DEFAULT NULL,
  `l2` varchar(10) DEFAULT NULL,
  `l3` varchar(10) DEFAULT NULL,
  `nucleos` int(11) DEFAULT NULL,
  `threads` int(11) DEFAULT NULL,
  `componente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `processador`
--

INSERT INTO `processador` (`id`, `clock`, `l1`, `l2`, `l3`, `nucleos`, `threads`, `componente_id`) VALUES
(1, '', '', '', '', 0, 0, 24);

-- --------------------------------------------------------

--
-- Table structure for table `ram`
--

CREATE TABLE `ram` (
  `id` int(11) NOT NULL,
  `componente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ram`
--

INSERT INTO `ram` (`id`, `componente_id`) VALUES
(1, 25);

-- --------------------------------------------------------

--
-- Table structure for table `tartaruga`
--

CREATE TABLE `tartaruga` (
  `id` int(11) NOT NULL,
  `carapaca` int(11) DEFAULT NULL,
  `componente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tartaruga`
--

INSERT INTO `tartaruga` (`id`, `carapaca`, `componente_id`) VALUES
(1, 12, 26);

-- --------------------------------------------------------

--
-- Table structure for table `teclado`
--

CREATE TABLE `teclado` (
  `id` int(11) NOT NULL,
  `layout` varchar(20) DEFAULT NULL,
  `numero_teclas` int(11) DEFAULT NULL,
  `interface` varchar(10) DEFAULT NULL,
  `tipo` varchar(10) DEFAULT NULL,
  `componente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teclado`
--

INSERT INTO `teclado` (`id`, `layout`, `numero_teclas`, `interface`, `tipo`, `componente_id`) VALUES
(26, 'ANSI', 75, 'USB', 'Mecânico', 18);

-- --------------------------------------------------------

--
-- Table structure for table `tipo`
--

CREATE TABLE `tipo` (
  `id` int(11) NOT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `nome` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tipo`
--

INSERT INTO `tipo` (`id`, `categoria_id`, `nome`) VALUES
(6, 2, 'teclado'),
(13, NULL, 'disco_rigido'),
(14, NULL, 'notebook'),
(15, NULL, 'disquete'),
(16, NULL, 'processador'),
(17, NULL, 'ram'),
(21, NULL, 'tartaruga');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `senha`) VALUES
(1, 'admin', '$2y$10$FI4H3rUrxIWSfBedOUBXwO4BrQ/vewgpETgQAwMAoQll4XJBBC2gG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome_UNIQUE` (`nome`);

--
-- Indexes for table `colaboradores`
--
ALTER TABLE `colaboradores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `componente`
--
ALTER TABLE `componente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_id` (`tipo_id`),
  ADD KEY `pais_id` (`pais_id`),
  ADD KEY `fabricante_id` (`fabricante_id`);

--
-- Indexes for table `disco_rigido`
--
ALTER TABLE `disco_rigido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `componente_id` (`componente_id`);

--
-- Indexes for table `disquete`
--
ALTER TABLE `disquete`
  ADD PRIMARY KEY (`id`),
  ADD KEY `componente_id` (`componente_id`);

--
-- Indexes for table `fabricante`
--
ALTER TABLE `fabricante`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome_UNIQUE` (`nome`);

--
-- Indexes for table `imagem`
--
ALTER TABLE `imagem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `imagem_componente` (`componente_id`);

--
-- Indexes for table `notebook`
--
ALTER TABLE `notebook`
  ADD PRIMARY KEY (`id`),
  ADD KEY `componente_id` (`componente_id`);

--
-- Indexes for table `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `processador`
--
ALTER TABLE `processador`
  ADD PRIMARY KEY (`id`),
  ADD KEY `componente_id` (`componente_id`);

--
-- Indexes for table `ram`
--
ALTER TABLE `ram`
  ADD PRIMARY KEY (`id`),
  ADD KEY `componente_id` (`componente_id`);

--
-- Indexes for table `tartaruga`
--
ALTER TABLE `tartaruga`
  ADD PRIMARY KEY (`id`),
  ADD KEY `componente_id` (`componente_id`);

--
-- Indexes for table `teclado`
--
ALTER TABLE `teclado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `componente_id` (`componente_id`);

--
-- Indexes for table `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome_UNIQUE` (`nome`),
  ADD KEY `categoria_idx` (`categoria_id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `colaboradores`
--
ALTER TABLE `colaboradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `componente`
--
ALTER TABLE `componente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `disco_rigido`
--
ALTER TABLE `disco_rigido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `disquete`
--
ALTER TABLE `disquete`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fabricante`
--
ALTER TABLE `fabricante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `imagem`
--
ALTER TABLE `imagem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `notebook`
--
ALTER TABLE `notebook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pais`
--
ALTER TABLE `pais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `processador`
--
ALTER TABLE `processador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ram`
--
ALTER TABLE `ram`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tartaruga`
--
ALTER TABLE `tartaruga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teclado`
--
ALTER TABLE `teclado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tipo`
--
ALTER TABLE `tipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `componente`
--
ALTER TABLE `componente`
  ADD CONSTRAINT `componente_ibfk_1` FOREIGN KEY (`tipo_id`) REFERENCES `tipo` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `componente_ibfk_2` FOREIGN KEY (`pais_id`) REFERENCES `pais` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `componente_ibfk_3` FOREIGN KEY (`fabricante_id`) REFERENCES `fabricante` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `disco_rigido`
--
ALTER TABLE `disco_rigido`
  ADD CONSTRAINT `disco_rigido_ibfk_1` FOREIGN KEY (`componente_id`) REFERENCES `componente` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `disquete`
--
ALTER TABLE `disquete`
  ADD CONSTRAINT `disquete_ibfk_1` FOREIGN KEY (`componente_id`) REFERENCES `componente` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `imagem`
--
ALTER TABLE `imagem`
  ADD CONSTRAINT `imagem_componente` FOREIGN KEY (`componente_id`) REFERENCES `componente` (`id`);

--
-- Constraints for table `notebook`
--
ALTER TABLE `notebook`
  ADD CONSTRAINT `notebook_ibfk_1` FOREIGN KEY (`componente_id`) REFERENCES `componente` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `processador`
--
ALTER TABLE `processador`
  ADD CONSTRAINT `processador_ibfk_1` FOREIGN KEY (`componente_id`) REFERENCES `componente` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ram`
--
ALTER TABLE `ram`
  ADD CONSTRAINT `ram_ibfk_1` FOREIGN KEY (`componente_id`) REFERENCES `componente` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tartaruga`
--
ALTER TABLE `tartaruga`
  ADD CONSTRAINT `tartaruga_ibfk_1` FOREIGN KEY (`componente_id`) REFERENCES `componente` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teclado`
--
ALTER TABLE `teclado`
  ADD CONSTRAINT `teclado_ibfk_1` FOREIGN KEY (`componente_id`) REFERENCES `componente` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tipo`
--
ALTER TABLE `tipo`
  ADD CONSTRAINT `categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
