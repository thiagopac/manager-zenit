SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Banco de dados: `owner398_zenit`
--

--
-- Estrutura para tabela `deposit`
--

CREATE TABLE `deposit` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `number` int UNSIGNED NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` char(2) NOT NULL,
  `status` varchar(255) DEFAULT 'active' NOT NULL,
  PRIMARY KEY (`id`));

--
-- Estrutura para tabela `stock_area`
--
CREATE TABLE `stock_area` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT 'active' NOT NULL,
  PRIMARY KEY (`id`));

--
-- Estrutura para tabela `materials`
--

CREATE TABLE `material` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `description` varchar(45) NOT NULL,
  `unity` ENUM('unity') NOT NULL,
  `stock_area_id` int UNSIGNED NOT NULL,
  `status` varchar(255) DEFAULT 'active' NOT NULL,
  PRIMARY KEY (`id`));


--
-- Estrutura para tabela `deposit_stock_area`
--

CREATE TABLE `deposit_stock_area` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `deposit_id` int UNSIGNED NOT NULL,
  `stock_area_id` int UNSIGNED NOT NULL,
  `capacity` int UNSIGNED NOT NULL,
  `status` varchar(255) DEFAULT 'active' NOT NULL
  PRIMARY KEY (`id`));