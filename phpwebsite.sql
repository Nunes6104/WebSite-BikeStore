-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 21-Jan-2025 às 14:11
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `phpwebsite`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `bikes`
--

CREATE TABLE `bikes` (
  `idBike` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `typeB` enum('Road','MTB','Gravel','City') DEFAULT NULL,
  `brand` enum('BH Bikes','BMC','Cannondale','Cervelo','Focus','Merida','MMR','Pinarello','Scott','Specialized') DEFAULT NULL,
  `model` varchar(200) NOT NULL,
  `price` int(11) NOT NULL,
  `dta_upload` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `bikes`
--

INSERT INTO `bikes` (`idBike`, `name`, `typeB`, `brand`, `model`, `price`, `dta_upload`) VALUES
(1, 'Ultralight 9.0', 'Road', 'BH Bikes', 'Ultralight 9.0', 10100, '2025-01-05 13:57:43'),
(2, 'Aerolight 7.0', 'Road', 'BH Bikes', 'Aerolight 7.0', 6200, '2025-01-05 13:57:43'),
(3, 'RS1 4.0', 'Road', 'BH Bikes', 'RS1 4.0', 3600, '2025-01-05 13:57:43'),
(4, 'LYNX Trail 9.5', 'MTB', 'BH Bikes', 'LYNX Trail 9.5', 4400, '2025-01-05 14:00:34'),
(5, 'LYNX Race LT 7.5', 'MTB', 'BH Bikes', 'LYNX Race LT 7.5', 4700, '2025-01-05 14:00:34'),
(6, 'AERO TT 8.0', 'MTB', 'BH Bikes', 'AERO TT 8.0', 9200, '2025-01-05 14:00:34'),
(7, 'Alpenchallenge AL ONE', 'City', 'BMC', 'Alpenchallenge', 2000, '2025-01-05 16:11:39'),
(8, 'Speedmachine 01 ONE', 'Road', 'BMC', 'Speedmachine 01 ONE', 17000, '2025-01-05 16:11:39'),
(9, 'URS 01 THREE', 'Gravel', 'BMC', 'URS 01 THREE', 7900, '2025-01-05 16:11:39'),
(10, 'Kaius 01 THREE', 'Gravel', 'BMC', 'Kaius 01 THREE', 6700, '2025-01-05 16:11:39'),
(11, 'TWOSTROKE AL 24', 'City', 'BMC', 'TWOSTROKE AL 24', 700, '2025-01-05 16:11:39'),
(12, 'Teammachine R 01 ONE', 'Road', 'BMC', 'Teammachine R 01 ONE', 15000, '2025-01-05 16:11:39');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cart`
--

CREATE TABLE `cart` (
  `idCart` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL,
  `IdBike` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 1,
  `dta_Create` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cart`
--

INSERT INTO `cart` (`idCart`, `IdUser`, `IdBike`, `quantidade`, `dta_Create`) VALUES
(11, 7, 5, 1, '2025-01-21 09:32:14');

-- --------------------------------------------------------

--
-- Estrutura da tabela `favourites`
--

CREATE TABLE `favourites` (
  `idFav` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL,
  `IdBike` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `favourites`
--

INSERT INTO `favourites` (`idFav`, `IdUser`, `IdBike`) VALUES
(11, 7, 10),
(12, 7, 6),
(13, 13, 5),
(14, 7, 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--

CREATE TABLE `login` (
  `idUser` int(11) NOT NULL,
  `first_Name` varchar(50) NOT NULL,
  `last_Name` varchar(50) NOT NULL,
  `user_Name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `nif` bigint(20) NOT NULL,
  `country` enum('Albânia','Alemanha','Andorra','Áustria','Bélgica','Bielorrússia','Bósnia e Herzegovina','Bulgária','Chipre','Croácia','Dinamarca','Eslováquia','Eslovénia','Espanha','Estónia','Finlândia','França','Grécia','Hungria','Irlanda','Islândia','Itália','Kosovo','Letónia','Liechtenstein','Lituânia','Luxemburgo','Macedónia do Norte','Malta','Moldávia','Mónaco','Montenegro','Noruega','Países Baixos','Polónia','Portugal','Reino Unido','República Checa','Roménia','Rússia','San Marino','Sérvia','Suécia','Suíça','Turquia','Ucrânia','Vaticano') DEFAULT NULL,
  `distric` varchar(100) NOT NULL,
  `street` varchar(100) NOT NULL,
  `postal_Code` varchar(10) NOT NULL,
  `dta_Nasc` date DEFAULT NULL,
  `dta_Create` timestamp NOT NULL DEFAULT current_timestamp()
) ;

--
-- Extraindo dados da tabela `login`
--

INSERT INTO `login` (`idUser`, `first_Name`, `last_Name`, `user_Name`, `email`, `password`, `phone`, `nif`, `country`, `distric`, `street`, `postal_Code`, `dta_Nasc`, `dta_Create`) VALUES
(7, 'Mário', 'Nunes', 'marionunes', 'm.mario.nunes@gmail.com', 'Admin1234', 927402094, 246012188, 'Portugal', 'Lisboa', 'Bairro José Daniel s/n', '2615-683', '2004-01-06', '2025-01-03 17:42:08'),
(8, 'Admin', 'Motion Bikes', 'AdminUser', 'admin@motionbike.pt', 'Admin1234', 0, 0, '', 'Lisboa', '00000', '0000', '0001-01-01', '2025-01-07 11:27:24'),
(12, 'João', 'Nunes', 'joaonunes', 'jmmnunes6104@gmail.com', 'Admin1234', 927402094, 246012188, 'Finlândia', 'Helsinki', 'Helsinki', '0000', '2004-01-06', '2025-01-19 19:28:57'),
(13, 'Leandro', 'Fernandes', 'leofer', 'leandro.fernandes@my.istec.pt', 'Admin1234', 913114907, 1234567, 'Portugal', 'Lisboa', 'Sobral Monte Agraço', '2590-007', '2025-01-13', '2025-01-21 09:11:16'),
(14, 'Rodrigo', 'Mira', 'RodrigoMira', 'rodrigomira2005@gmail.com', 'Admin1234', 0, 1234567, 'Portugal', 'Lisboa', 'Margem Sul Fogueteiros', '0000', '2025-01-07', '2025-01-21 09:19:56');

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendas`
--

CREATE TABLE `vendas` (
  `idVenda` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL,
  `IdBike` int(11) NOT NULL,
  `dta_Venda` timestamp NOT NULL DEFAULT current_timestamp(),
  `totalPrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `vendas`
--

INSERT INTO `vendas` (`idVenda`, `IdUser`, `IdBike`, `dta_Venda`, `totalPrice`) VALUES
(1, 7, 1, '2025-01-14 09:43:15', 10100),
(2, 7, 12, '2025-01-14 13:42:45', 15000),
(3, 7, 11, '2025-01-14 13:45:21', 700),
(4, 7, 6, '2025-01-15 13:28:43', 9200),
(5, 7, 1, '2025-01-17 00:00:15', 10100),
(6, 13, 11, '2025-01-21 09:14:37', 1400),
(7, 13, 2, '2025-01-21 09:15:14', 6200);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `bikes`
--
ALTER TABLE `bikes`
  ADD PRIMARY KEY (`idBike`);

--
-- Índices para tabela `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`idCart`),
  ADD KEY `IdUser` (`IdUser`),
  ADD KEY `IdBike` (`IdBike`);

--
-- Índices para tabela `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`idFav`),
  ADD KEY `IdUser` (`IdUser`),
  ADD KEY `IdBike` (`IdBike`);

--
-- Índices para tabela `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`idUser`);

--
-- Índices para tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`idVenda`),
  ADD KEY `IdUser` (`IdUser`),
  ADD KEY `IdBike` (`IdBike`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `bikes`
--
ALTER TABLE `bikes`
  MODIFY `idBike` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `cart`
--
ALTER TABLE `cart`
  MODIFY `idCart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `favourites`
--
ALTER TABLE `favourites`
  MODIFY `idFav` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `login`
--
ALTER TABLE `login`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `idVenda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`IdUser`) REFERENCES `login` (`idUser`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`IdBike`) REFERENCES `bikes` (`idBike`);

--
-- Limitadores para a tabela `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `favourites_ibfk_1` FOREIGN KEY (`IdUser`) REFERENCES `login` (`idUser`),
  ADD CONSTRAINT `favourites_ibfk_2` FOREIGN KEY (`IdBike`) REFERENCES `bikes` (`idBike`);

--
-- Limitadores para a tabela `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `vendas_ibfk_1` FOREIGN KEY (`IdUser`) REFERENCES `login` (`idUser`),
  ADD CONSTRAINT `vendas_ibfk_2` FOREIGN KEY (`IdBike`) REFERENCES `bikes` (`idBike`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
