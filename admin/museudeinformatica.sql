-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07-Jun-2023 às 04:23
-- Versão do servidor: 10.4.28-MariaDB
-- versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `museudeinformatica`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`id`, `nome`) VALUES
(1, 'DispositivosArmazenamento'),
(2, 'Periferico');

-- --------------------------------------------------------

--
-- Estrutura da tabela `colaboradores`
--

CREATE TABLE `colaboradores` (
  `id` int(11) NOT NULL,
  `Nome` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Telefone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `componente`
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
  `criacao` date DEFAULT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `componente`
--

INSERT INTO `componente` (`id`, `tipo_id`, `pais_id`, `fabricante_id`, `ano_fabricacao`, `modelo`, `curiosidades`, `cid`, `ultima_atualizacao`, `criacao`, `descricao`) VALUES
(27, 22, 1, 11, '1983', 'TK85', '', '', '2023-06-07', '2023-06-07', 'Outras Características: O TK85 era baseado no Sinclair ZX81. Compacto e com processador Z80A de 3,25 MHz, tinha 16 KB de RAM e possibilidade de expansão. Utilizava fita cassete para armazenamento e tinha saída de vídeo para conectar a um televisor. O TK85 possuía teclado de membrana, que era mais suscetível a problemas de resposta, o qual tinha 40 teclas e exibia gráficos em preto e branco. Seu sistema operacional era o Sinclair BASIC, permitindo a programação própria. Foi popular no Brasil, sendo usado em escolas, escritórios e residências devido ao preço acessível. Também foi vendido em outros países da América Latina, como Argentina e Uruguai. Curiosidades: O nome &#34;TK85&#34; era uma combinação de &#34;Termokim&#34; e &#34;85&#34;. Apesar da obsolescência, é lembrado com carinho por entusiastas da computação, no Brasil.'),
(28, 22, 1, 11, '1985', 'TK90X', '', '', '2023-06-07', '2023-06-07', 'Outras Características: Memória expandida de 16 KB para 48 KB, permitindo a execução de programas mais complexos. Teclado embutido com melhor qualidade e design moderno. Modo de vídeo aprimorado, com maior resolução e mais cores, possibilitando gráficos avançados em comparação com o TK85. Porta de expansão para conexão de periféricos, como impressoras e drives de fita cassete para carregar e salvar programas. Amplamente utilizado para fins educacionais, programação e jogos. Compatível com jogos famosos da época, como &#34;JetPac&#34;, &#34;Chuckie Egg&#34; e &#34;Pac-Man&#34;. Possibilidade de conexão de joystick ou controlador de jogo para melhorar a experiência de jogos. Compatível com várias impressoras disponíveis no mercado, utilizando interfaces específicas, como a interface paralela Centronics. Porta de expansão para conexão de placas de expansão adicionais, permitindo adicionar recursos extras, como interfaces de rede, memória adicional ou dispositivos de armazenamento.'),
(30, 22, 12, 12, '1987', 'Macintosh SE', '', '', '2023-06-07', '2023-06-07', 'Outras Informações: Foi descontinuado em 15 de outubro de 1990 Memória expansível até 4 MB Tela em preto e branco'),
(31, 22, 12, 12, '1998', 'IMac G3', '', '', '2023-06-07', '2023-06-07', 'Outras Informações: Faz parte da série de computadores tudo-em-um Design Inovador Fim da unidade de disquete Introdução do USB O iMac teve um papel fundamental na revitalização da Apple no final dos anos 90'),
(32, 23, 12, 12, '1980', 'Monitor III', '', '', '2023-06-07', '2023-06-07', 'Outras Informações: Monitor do computador Apple III que foi o primeiro computador da marca destinado ao mercado empresarial. Computador Apple III Processador: Synertek 6502A de 1,8 MHz Memória RAM: variava de 128 KB até 512 KB Sistema Operacional: Apple SOS'),
(33, 14, 12, 12, '2009', 'Macbook White 5.2', '', '', '2023-06-07', '2023-06-07', ''),
(34, 22, 1, 13, '1986', 'CP500 - M80C', '', '', '2023-06-07', '2023-06-07', 'Outras Informações: Computador pessoal nacional Projetado pelo designer Luciano Deviá Usava a linguagem BASIC Level II Com um ou dois drives de disco de 5&#34; 1/4, 178 KiB 30% mais compacto que seu predecessor (daí o &#34;C&#34; no nome), graças ao uso de drives de 5&#34; 1/4 slim height, agora colocados em uma posição vertical no gabinete Este modelo não tinha mais a porta do gravador de cassetes'),
(35, 14, 4, 7, '1987', 'T1000', '', '', '2023-06-07', '2023-06-07', 'Outras Informações: Possuía unidade de disquete de 3,5 polegadas que podia ler e gravar disquetes de 720 KB Possuía uma porta serial RS-232, uma porta paralela para impressora e uma porta de vídeo externa Foi um dos primeiros laptops a utilizar tecnologia de economia de energia, com a bateria original podendo durar cerca de 10 horas Pesa aproximadamente 3 KG O sistema operacional padrão era o MS-DOS 2.11 Foi um dos primeiros laptops a oferecer uma função de hibernação, permitindo que os usuários salvassem o estado do sistema em um disquete e retomassem o trabalho de onde pararam Foi um dos primeiros laptops &#34;ultraportáteis&#34; a incorporar um disco rígido interno. Pausava a CPU quando não estava em uso para economizar energia e prolongar a vida útil da bateria É geralmente lembrado como um dos primeiros laptops verdadeiramente portáteis que conseguiu equilibrar tamanho, peso e funcionalidade, preparando o caminho para os laptops modernos que conhecemos hoje'),
(36, 14, 6, 7, '2000', 'Satellite 2800', '', '', '2023-06-07', '2023-06-07', ''),
(37, 14, 3, 4, '2002', 'Compaq NX9010', '', '', '2023-06-07', '2023-06-07', ''),
(38, 14, 4, 5, '2008', 'Sony Vaio P Series', 'Vinha com receptor de TV Digital.', '', '2023-06-07', '2023-06-07', ''),
(39, 6, 1, 14, '1985', 'MSX', '', '', '2023-06-07', '2023-06-07', ''),
(40, 6, 1, 15, '1986', 'TCL-251', '', '', '2023-06-07', '2023-06-07', ''),
(41, 6, 9, 16, '2020', 'TM410', '', '', '2023-06-07', '2023-06-07', 'Wireless - Utiliza 1 pilha AAA'),
(42, 6, 1, 17, '1985', 'Teclado do I-7000 PC-XT', '', '', '2023-06-07', '2023-06-07', ''),
(43, 6, 9, 18, '1985', ' EKB-804PRO', '1985 ±', '', '2023-06-07', '2023-06-07', 'Outras Informações: O design contornado permite que as mãos e os antebraços descansem em um ângulo natural. Isso ajuda a aliviar o estresse no pescoço e nos ombros. O design de teclas divididas permite mover os cotovelos para longe do torso, aliviando o estresse no pescoço e nos ombros. Modelo ergonômico de 107 teclas, com 22 teclas de atalho. Ele também possui teclas de ENTER e BACKSPACE extragrandes. Utiliza teclas de membrana de alta qualidade para uma vida útil mais longa.'),
(44, 6, 9, 19, '2009', '810739', '', '', '2023-06-07', '2023-06-07', ''),
(45, 24, 9, 12, '2005', 'a1152', '', '', '2023-06-07', '2023-06-07', ''),
(46, 24, 12, 12, '1986', 'M0100', '', '', '2023-06-07', '2023-06-07', ''),
(47, 24, 5, 20, '1990', 'E6QMOUSE X31', '', '', '2023-06-07', '2023-06-07', ''),
(48, 24, 1, 21, '1980', 'mouse 700', '', '', '2023-06-07', '2023-06-07', '1980 ±'),
(49, 6, 12, 12, '1991', 'Apple Keyboard II', '', '', '2023-06-07', '2023-06-07', ''),
(50, 25, 4, 12, '1994', 'Plain Talk Microphone 590-0670', '', '', '2023-06-07', '2023-06-07', 'Outras Informações: Utiliza um conector 3,5 mm proprietário mais longo que o padrão Projetado para que o microfone pudesse ser colocado no topo do monitor'),
(51, 24, 9, 22, '1999', 'www-11', '', '', '2023-06-07', '2023-06-07', ''),
(52, 24, 9, 23, '1990', 'M-S38', '', '', '2023-06-07', '2023-06-07', '1990 ±'),
(53, 24, 9, 12, '1993', 'Desktop Bus Mouse II', '', '', '2023-06-07', '2023-06-07', ''),
(54, 24, 9, 12, '2009', 'a1296', '', '', '2023-06-07', '2023-06-07', ''),
(55, 24, 9, 12, '2000', 'Pro Mouse', '', '', '2023-06-07', '2023-06-07', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `computador`
--

CREATE TABLE `computador` (
  `id` int(11) NOT NULL,
  `processador` text DEFAULT NULL,
  `memoria` text DEFAULT NULL,
  `tela` text DEFAULT NULL,
  `conexoes` text DEFAULT NULL,
  `armazenamento` text DEFAULT NULL,
  `sistema_operacional` text DEFAULT NULL,
  `componente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `computador`
--

INSERT INTO `computador` (`id`, `processador`, `memoria`, `tela`, `conexoes`, `armazenamento`, `sistema_operacional`, `componente_id`) VALUES
(1, ' Z80A de 3,25 MHz', '16 KB de RAM', '', '1 entrada joystick, saída e entrada de áudio mono para K7, 1 saída para TV. ', 'fita cassete', 'Sinclair BASIC', 27),
(2, 'Z-80A de 3,58 MHz', '16/48KB RAM ', '', 'Joystick: Entrada de 9 pinos padrão Atari 2600', 'fita cassete', 'TK Basic', 28),
(4, 'Motorola 68000 de 7,8 MHz', '1MB RAM', ' 9&#34; com resolução de 512x342 pixels ', '', '', '', 30),
(5, 'PowerPC G3 de 233 MHz', '32 MB de RAM', '15”', '', '', '', 31),
(6, 'Zilog Z80A a 2 MHz', '48 KB de RAM', '16 linhas x 64 colunas', '', '', '', 34);

-- --------------------------------------------------------

--
-- Estrutura da tabela `disco_rigido`
--

CREATE TABLE `disco_rigido` (
  `id` int(11) NOT NULL,
  `rpm` int(11) DEFAULT NULL,
  `componente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `disquete`
--

CREATE TABLE `disquete` (
  `id` int(11) NOT NULL,
  `polegadas` varchar(5) DEFAULT NULL,
  `componente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fabricante`
--

CREATE TABLE `fabricante` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `fabricante`
--

INSERT INTO `fabricante` (`id`, `nome`) VALUES
(22, 'A4Tech'),
(6, 'Acer'),
(12, 'Apple Inc.'),
(1, 'DELL'),
(15, 'Edisa'),
(14, 'Gradiente'),
(4, 'HP'),
(2, 'HyperX'),
(19, 'Inland'),
(9, 'Intel'),
(17, 'Itautec'),
(20, 'Jow Dian Enterprise Co Ltda.'),
(18, 'Liteon'),
(23, 'Logitech'),
(21, 'Magitronic'),
(11, 'Microdigital Eletrônica Ltda.'),
(16, 'OEX'),
(13, 'Prológica'),
(10, 'Samsung'),
(5, 'Sony'),
(7, 'Toshiba'),
(8, 'Verbatim '),
(3, 'Western Digital');

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagem`
--

CREATE TABLE `imagem` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `principal` varchar(1) DEFAULT NULL,
  `componente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `imagem`
--

INSERT INTO `imagem` (`id`, `nome`, `principal`, `componente_id`) VALUES
(29, 'tk85.jpeg', '', 27),
(31, 'tk90.jpeg', '', 28),
(33, 'Macintosh_SE_b.jpg', '', 30),
(34, 'imac g3.jpg', '', 31),
(35, 'monitor iii.webp', '', 32),
(36, 'macbook white.jpg', '', 33),
(37, 'cp500m80cv.jpg', '', 34),
(38, 't1000.jpeg', '', 35),
(39, 'satellite_2800.jpg', '', 36),
(40, 'HP-Compaq-nx9010-scaled.jpg', '', 37),
(41, 'sony-vayo-p-series.webp', '', 38),
(42, 'gradiente.jpg', '', 39),
(43, 'edisa.jpeg', '', 40),
(44, 'oex.jpeg', '', 41),
(45, 'itautec.jpeg', '', 42),
(46, 'ekb.jpeg', '', 43),
(47, 'inland.jpeg', '', 44),
(48, 'A1152.JPG', '', 45),
(49, 'M0100_frente.JPG', '', 46),
(50, 'M0100_costas.JPG', '', 46),
(51, 'E6QMOUSEX31_frente.jpg', '', 47),
(52, 'E6QMOUSEX31_costas.jpg', '', 47),
(54, 'magitronic.png', '', 48),
(55, 'apple-keyboard-frente.jpg', '', 49),
(56, 'apple-keyboard-frente-2.jpg', '', 49),
(57, 'apple-keyboard-costas.jpg', '', 49),
(58, 'microfone.jpg', '', 50),
(59, 'a4tech.png', '', 51),
(60, 'ms38.jpg', '', 52),
(61, 'Desktop-Bus-Mouse-II.JPG', '', 53),
(62, 'A1296.jpeg', '', 54),
(63, 'ProMouse.jpg', '', 55);

-- --------------------------------------------------------

--
-- Estrutura da tabela `microfone`
--

CREATE TABLE `microfone` (
  `id` int(11) NOT NULL,
  `componente_id` int(11) DEFAULT NULL,
  `conector` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `microfone`
--

INSERT INTO `microfone` (`id`, `componente_id`, `conector`) VALUES
(1, 50, 'Jack P2 3.5mm');

-- --------------------------------------------------------

--
-- Estrutura da tabela `monitor`
--

CREATE TABLE `monitor` (
  `id` int(11) NOT NULL,
  `tipo` text DEFAULT NULL,
  `componente_id` int(11) DEFAULT NULL,
  `tamanho` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `monitor`
--

INSERT INTO `monitor` (`id`, `tipo`, `componente_id`, `tamanho`) VALUES
(1, '', 32, '12&#34;');

-- --------------------------------------------------------

--
-- Estrutura da tabela `mouse`
--

CREATE TABLE `mouse` (
  `id` int(11) NOT NULL,
  `rastreamento` text DEFAULT NULL,
  `interface` text DEFAULT NULL,
  `componente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `mouse`
--

INSERT INTO `mouse` (`id`, `rastreamento`, `interface`, `componente_id`) VALUES
(1, 'Óptico', 'USB', 45),
(2, 'Bolinha', 'Serial', 46),
(3, 'Bolinha', 'Serial', 47),
(4, 'Bolinha', 'Serial', 48),
(5, 'Bolinha', 'PS/2', 51),
(6, 'Bolinha', 'PS/2', 52),
(7, 'Bolinha', 'Apple Desktop Bus', 53),
(8, 'Óptico', 'Bluetooth', 54),
(9, 'Óptico', 'USB', 55);

-- --------------------------------------------------------

--
-- Estrutura da tabela `notebook`
--

CREATE TABLE `notebook` (
  `id` int(11) NOT NULL,
  `ram` varchar(10) DEFAULT NULL,
  `processador` varchar(50) DEFAULT NULL,
  `componente_id` int(11) DEFAULT NULL,
  `sistema_operacional` text NOT NULL,
  `tela` text NOT NULL,
  `armazenamento` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `notebook`
--

INSERT INTO `notebook` (`id`, `ram`, `processador`, `componente_id`, `sistema_operacional`, `tela`, `armazenamento`) VALUES
(4, '2 GB de RA', 'Intel Core 2 Duo de  2.1 GHz', 33, 'Mac OS X', '13,3”', 'HD de 250 GB'),
(5, '512 KB', 'Intel 8OC86TM de 4.77 MHz', 35, 'MS-DOS 2.11', 'LCD monocromático de 600x200 pixels', ''),
(6, '256 MB', 'Pentium III de 1 GHz', 36, '', '14.1&#34;', ''),
(7, '512 MB', 'Intel Pentium 4 de 2,66 GHz', 37, 'Windows XP', '', ''),
(8, ' 2 GB', 'Intel Atom Z530 de 1,60 GHz', 38, 'Windows XP', ' 8” de 1600×768 pixels', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pais`
--

CREATE TABLE `pais` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `pais`
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
(10, 'Costa Rica'),
(12, 'EUA');

-- --------------------------------------------------------

--
-- Estrutura da tabela `processador`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ram`
--

CREATE TABLE `ram` (
  `id` int(11) NOT NULL,
  `componente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tartaruga`
--

CREATE TABLE `tartaruga` (
  `id` int(11) NOT NULL,
  `carapaca` int(11) DEFAULT NULL,
  `componente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `teclado`
--

CREATE TABLE `teclado` (
  `id` int(11) NOT NULL,
  `layout` varchar(20) DEFAULT NULL,
  `numero_teclas` int(11) DEFAULT NULL,
  `interface` varchar(10) DEFAULT NULL,
  `tipo` varchar(10) DEFAULT NULL,
  `componente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `teclado`
--

INSERT INTO `teclado` (`id`, `layout`, `numero_teclas`, `interface`, `tipo`, `componente_id`) VALUES
(27, '', 0, '', '', 39),
(28, '', 0, '', '', 40),
(29, '', 0, '', '', 41),
(30, '', 0, '', '', 42),
(31, '', 0, 'PS/2', '', 43),
(32, '', 0, 'USB', '', 44),
(33, '', 0, 'ADB (Apple', '', 49);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo`
--

CREATE TABLE `tipo` (
  `id` int(11) NOT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `nome` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `tipo`
--

INSERT INTO `tipo` (`id`, `categoria_id`, `nome`) VALUES
(6, 2, 'teclado'),
(13, NULL, 'disco_rigido'),
(14, NULL, 'notebook'),
(15, NULL, 'disquete'),
(16, NULL, 'processador'),
(17, NULL, 'ram'),
(21, NULL, 'tartaruga'),
(22, NULL, 'computador'),
(23, NULL, 'monitor'),
(24, NULL, 'mouse'),
(25, NULL, 'microfone');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `senha`) VALUES
(1, 'admin', '$2y$10$FI4H3rUrxIWSfBedOUBXwO4BrQ/vewgpETgQAwMAoQll4XJBBC2gG');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome_UNIQUE` (`nome`);

--
-- Índices para tabela `colaboradores`
--
ALTER TABLE `colaboradores`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `componente`
--
ALTER TABLE `componente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_id` (`tipo_id`),
  ADD KEY `pais_id` (`pais_id`),
  ADD KEY `fabricante_id` (`fabricante_id`);

--
-- Índices para tabela `computador`
--
ALTER TABLE `computador`
  ADD PRIMARY KEY (`id`),
  ADD KEY `componente_id` (`componente_id`);

--
-- Índices para tabela `disco_rigido`
--
ALTER TABLE `disco_rigido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `componente_id` (`componente_id`);

--
-- Índices para tabela `disquete`
--
ALTER TABLE `disquete`
  ADD PRIMARY KEY (`id`),
  ADD KEY `componente_id` (`componente_id`);

--
-- Índices para tabela `fabricante`
--
ALTER TABLE `fabricante`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome_UNIQUE` (`nome`);

--
-- Índices para tabela `imagem`
--
ALTER TABLE `imagem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `imagem_componente` (`componente_id`);

--
-- Índices para tabela `microfone`
--
ALTER TABLE `microfone`
  ADD PRIMARY KEY (`id`),
  ADD KEY `componente_id` (`componente_id`);

--
-- Índices para tabela `monitor`
--
ALTER TABLE `monitor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `componente_id` (`componente_id`);

--
-- Índices para tabela `mouse`
--
ALTER TABLE `mouse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `componente_id` (`componente_id`);

--
-- Índices para tabela `notebook`
--
ALTER TABLE `notebook`
  ADD PRIMARY KEY (`id`),
  ADD KEY `componente_id` (`componente_id`);

--
-- Índices para tabela `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `processador`
--
ALTER TABLE `processador`
  ADD PRIMARY KEY (`id`),
  ADD KEY `componente_id` (`componente_id`);

--
-- Índices para tabela `ram`
--
ALTER TABLE `ram`
  ADD PRIMARY KEY (`id`),
  ADD KEY `componente_id` (`componente_id`);

--
-- Índices para tabela `tartaruga`
--
ALTER TABLE `tartaruga`
  ADD PRIMARY KEY (`id`),
  ADD KEY `componente_id` (`componente_id`);

--
-- Índices para tabela `teclado`
--
ALTER TABLE `teclado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `componente_id` (`componente_id`);

--
-- Índices para tabela `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome_UNIQUE` (`nome`),
  ADD KEY `categoria_idx` (`categoria_id`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `colaboradores`
--
ALTER TABLE `colaboradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `componente`
--
ALTER TABLE `componente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de tabela `computador`
--
ALTER TABLE `computador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `disco_rigido`
--
ALTER TABLE `disco_rigido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `disquete`
--
ALTER TABLE `disquete`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `fabricante`
--
ALTER TABLE `fabricante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `imagem`
--
ALTER TABLE `imagem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de tabela `microfone`
--
ALTER TABLE `microfone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `monitor`
--
ALTER TABLE `monitor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `mouse`
--
ALTER TABLE `mouse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `notebook`
--
ALTER TABLE `notebook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `pais`
--
ALTER TABLE `pais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `processador`
--
ALTER TABLE `processador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `ram`
--
ALTER TABLE `ram`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tartaruga`
--
ALTER TABLE `tartaruga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `teclado`
--
ALTER TABLE `teclado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `tipo`
--
ALTER TABLE `tipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `componente`
--
ALTER TABLE `componente`
  ADD CONSTRAINT `componente_ibfk_1` FOREIGN KEY (`tipo_id`) REFERENCES `tipo` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `componente_ibfk_2` FOREIGN KEY (`pais_id`) REFERENCES `pais` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `componente_ibfk_3` FOREIGN KEY (`fabricante_id`) REFERENCES `fabricante` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `computador`
--
ALTER TABLE `computador`
  ADD CONSTRAINT `computador_ibfk_1` FOREIGN KEY (`componente_id`) REFERENCES `componente` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `disco_rigido`
--
ALTER TABLE `disco_rigido`
  ADD CONSTRAINT `disco_rigido_ibfk_1` FOREIGN KEY (`componente_id`) REFERENCES `componente` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `disquete`
--
ALTER TABLE `disquete`
  ADD CONSTRAINT `disquete_ibfk_1` FOREIGN KEY (`componente_id`) REFERENCES `componente` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `imagem`
--
ALTER TABLE `imagem`
  ADD CONSTRAINT `imagem_componente` FOREIGN KEY (`componente_id`) REFERENCES `componente` (`id`);

--
-- Limitadores para a tabela `microfone`
--
ALTER TABLE `microfone`
  ADD CONSTRAINT `microfone_ibfk_1` FOREIGN KEY (`componente_id`) REFERENCES `componente` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `monitor`
--
ALTER TABLE `monitor`
  ADD CONSTRAINT `monitor_ibfk_1` FOREIGN KEY (`componente_id`) REFERENCES `componente` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `mouse`
--
ALTER TABLE `mouse`
  ADD CONSTRAINT `mouse_ibfk_1` FOREIGN KEY (`componente_id`) REFERENCES `componente` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `notebook`
--
ALTER TABLE `notebook`
  ADD CONSTRAINT `notebook_ibfk_1` FOREIGN KEY (`componente_id`) REFERENCES `componente` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `processador`
--
ALTER TABLE `processador`
  ADD CONSTRAINT `processador_ibfk_1` FOREIGN KEY (`componente_id`) REFERENCES `componente` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `ram`
--
ALTER TABLE `ram`
  ADD CONSTRAINT `ram_ibfk_1` FOREIGN KEY (`componente_id`) REFERENCES `componente` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `tartaruga`
--
ALTER TABLE `tartaruga`
  ADD CONSTRAINT `tartaruga_ibfk_1` FOREIGN KEY (`componente_id`) REFERENCES `componente` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `teclado`
--
ALTER TABLE `teclado`
  ADD CONSTRAINT `teclado_ibfk_1` FOREIGN KEY (`componente_id`) REFERENCES `componente` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `tipo`
--
ALTER TABLE `tipo`
  ADD CONSTRAINT `categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
