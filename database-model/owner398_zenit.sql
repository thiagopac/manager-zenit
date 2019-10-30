-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 30/10/2019 às 18:19
-- Versão do servidor: 10.4.8-MariaDB
-- Versão do PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Banco de dados: `owner398_zenit`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `article_attachment`
--

CREATE TABLE `article_attachment` (
  `id` bigint(20) NOT NULL,
  `article_id` bigint(20) DEFAULT NULL,
  `filename` varchar(250) DEFAULT NULL,
  `savename` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `company_id` int(140) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `email` varchar(180) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `mobile` varchar(25) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `zipcode` varchar(30) DEFAULT NULL,
  `userpic` varchar(150) DEFAULT 'no-pic.png',
  `city` varchar(45) DEFAULT NULL,
  `hashed_password` varchar(255) DEFAULT NULL,
  `inactive` tinyint(4) DEFAULT 0,
  `access` varchar(150) DEFAULT '0',
  `last_active` varchar(50) DEFAULT NULL,
  `last_login` varchar(50) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `signature` text DEFAULT NULL,
  `push_active` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `reference` int(11) NOT NULL,
  `name` varchar(140) DEFAULT NULL,
  `client_id` varchar(140) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `mobile` varchar(25) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `zipcode` varchar(30) NOT NULL,
  `city` varchar(45) DEFAULT NULL,
  `inactive` tinyint(4) DEFAULT 0,
  `website` varchar(250) DEFAULT NULL,
  `country` varchar(250) DEFAULT NULL,
  `vat` varchar(250) DEFAULT NULL,
  `note` longtext DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `terms` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `company`
--

INSERT INTO `company` (`id`, `reference`, `name`, `client_id`, `phone`, `mobile`, `address`, `zipcode`, `city`, `inactive`, `website`, `country`, `vat`, `note`, `province`, `terms`) VALUES
(1, 1, 'Cliente Base ', '0', '(31)0000-0000', '', '', '', 'Belo Horizonte', 0, NULL, 'Brasil', NULL, NULL, 'MG', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `company_admin`
--

CREATE TABLE `company_admin` (
  `id` int(10) NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `access` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `company_admin`
--

INSERT INTO `company_admin` (`id`, `company_id`, `user_id`, `access`) VALUES
(1, 1, 3, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `core`
--

CREATE TABLE `core` (
  `id` int(11) NOT NULL,
  `version` char(10) NOT NULL DEFAULT '0',
  `domain` varchar(65) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `contact` varchar(200) DEFAULT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `autobackup` int(11) DEFAULT NULL,
  `cronjob` int(11) DEFAULT NULL,
  `last_cronjob` int(11) DEFAULT NULL,
  `last_autobackup` int(11) DEFAULT NULL,
  `company_reference` int(6) DEFAULT NULL,
  `project_reference` int(6) DEFAULT NULL,
  `ticket_reference` int(10) DEFAULT NULL,
  `date_format` varchar(20) DEFAULT NULL,
  `date_time_format` varchar(20) DEFAULT NULL,
  `pw_reset_mail_subject` varchar(150) DEFAULT NULL,
  `pw_reset_link_mail_subject` varchar(150) DEFAULT NULL,
  `credentials_mail_subject` varchar(150) DEFAULT NULL,
  `notification_mail_subject` varchar(150) DEFAULT NULL,
  `language` varchar(150) DEFAULT NULL,
  `subscription_mail_subject` varchar(250) DEFAULT NULL,
  `logo` varchar(150) DEFAULT NULL,
  `template` varchar(200) DEFAULT 'default',
  `paypal` varchar(5) DEFAULT '1',
  `company_logo` varchar(150) DEFAULT 'assets/blueline/img/company_logo.png',
  `ticket_email` varchar(250) DEFAULT NULL,
  `ticket_default_owner` int(10) DEFAULT 1,
  `ticket_default_queue` int(10) DEFAULT 1,
  `ticket_default_type` int(10) DEFAULT 1,
  `ticket_default_status` varchar(200) DEFAULT 'new',
  `ticket_config_host` varchar(250) DEFAULT NULL,
  `ticket_config_login` varchar(250) DEFAULT NULL,
  `ticket_config_pass` varchar(250) DEFAULT NULL,
  `ticket_config_port` varchar(250) DEFAULT NULL,
  `ticket_config_ssl` varchar(250) DEFAULT NULL,
  `ticket_config_email` varchar(250) DEFAULT NULL,
  `ticket_config_flags` varchar(250) DEFAULT '/notls',
  `ticket_config_search` varchar(250) DEFAULT 'UNSEEN',
  `ticket_config_timestamp` int(11) DEFAULT NULL,
  `ticket_config_mailbox` varchar(250) DEFAULT NULL,
  `ticket_config_delete` int(11) DEFAULT NULL,
  `ticket_config_active` int(11) DEFAULT NULL,
  `ticket_config_imap` int(11) DEFAULT 1,
  `money_currency_position` int(5) NOT NULL DEFAULT 1,
  `money_format` int(5) NOT NULL DEFAULT 1,
  `pdf_font` varchar(255) NOT NULL DEFAULT 'NotoSans',
  `pdf_path` int(10) NOT NULL DEFAULT 1,
  `registration` int(10) NOT NULL DEFAULT 0,
  `authorize_api_login_id` varchar(255) DEFAULT NULL,
  `company_prefix` varchar(255) DEFAULT NULL,
  `project_prefix` varchar(255) DEFAULT NULL,
  `calendar_google_api_key` varchar(255) DEFAULT NULL,
  `calendar_google_event_address` varchar(255) DEFAULT NULL,
  `default_client_modules` varchar(255) DEFAULT NULL,
  `login_background` varchar(255) DEFAULT 'blur.jpg',
  `custom_colors` int(1) DEFAULT 1,
  `top_bar_background` varchar(60) DEFAULT '#FFFFFF',
  `top_bar_color` varchar(60) DEFAULT '#333333',
  `body_background` varchar(60) DEFAULT '#e3e6ed',
  `menu_background` varchar(60) DEFAULT '#173240',
  `menu_color` varchar(60) DEFAULT '#FFFFFF',
  `primary_color` varchar(60) DEFAULT '#356cc9',
  `login_logo` varchar(255) DEFAULT NULL,
  `login_style` varchar(255) DEFAULT 'left',
  `reference_lenght` int(20) DEFAULT NULL,
  `zip_position` varchar(60) DEFAULT 'left',
  `timezone` varchar(255) DEFAULT NULL,
  `notifications` int(1) UNSIGNED DEFAULT 0,
  `last_notification` varchar(100) DEFAULT NULL,
  `receipt_mail_subject` varchar(200) DEFAULT NULL,
  `push_active` tinyint(1) DEFAULT 0,
  `push_rest_api_key` varchar(50) DEFAULT NULL,
  `push_app_id` varchar(50) DEFAULT NULL,
  `money_symbol` varchar(10) NOT NULL,
  `rated_power_measurement` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `core`
--

INSERT INTO `core` (`id`, `version`, `domain`, `email`, `company`, `address`, `city`, `contact`, `tel`, `currency`, `autobackup`, `cronjob`, `last_cronjob`, `last_autobackup`, `company_reference`, `project_reference`, `ticket_reference`, `date_format`, `date_time_format`, `pw_reset_mail_subject`, `pw_reset_link_mail_subject`, `credentials_mail_subject`, `notification_mail_subject`, `language`, `subscription_mail_subject`, `logo`, `template`, `paypal`, `company_logo`, `ticket_email`, `ticket_default_owner`, `ticket_default_queue`, `ticket_default_type`, `ticket_default_status`, `ticket_config_host`, `ticket_config_login`, `ticket_config_pass`, `ticket_config_port`, `ticket_config_ssl`, `ticket_config_email`, `ticket_config_flags`, `ticket_config_search`, `ticket_config_timestamp`, `ticket_config_mailbox`, `ticket_config_delete`, `ticket_config_active`, `ticket_config_imap`, `money_currency_position`, `money_format`, `pdf_font`, `pdf_path`, `registration`, `authorize_api_login_id`, `company_prefix`, `project_prefix`, `calendar_google_api_key`, `calendar_google_event_address`, `default_client_modules`, `login_background`, `custom_colors`, `top_bar_background`, `top_bar_color`, `body_background`, `menu_background`, `menu_color`, `primary_color`, `login_logo`, `login_style`, `reference_lenght`, `zip_position`, `timezone`, `notifications`, `last_notification`, `receipt_mail_subject`, `push_active`, `push_rest_api_key`, `push_app_id`, `money_symbol`, `rated_power_measurement`) VALUES
(1, '1.0.0', 'http://localhost/zenit/', 'contato@ownergy.com.br', 'Ownergy Solar', 'Rua Araguari, 1156', 'Belo Horizonte', 'Ownergy Solar', '(31)3654-0098', 'BRL', 1, 1, 1549591207, 1549591210, 2, 4, 2, 'd/m/Y', 'H:i', 'Senha redefinida', 'Redefinição de senha', 'Detalhes do seu usuário', 'Notificação', 'portuguese', 'Nova inscrição', 'files/media/zenit_logo.png', 'blueline', '0', 'files/media/ownergy_logo.png', NULL, 1, 1, 1, 'new', '', 'thiago.pires', 'GRanada11', '', '1', '', '/notls', 'UNSEEN', 1549627210, '', 0, 1, 1, 1, 2, 'NotoSans', 1, 0, NULL, 'CLI', 'UFV', '1022232899186-1k9itl671m7t18t81b6dj7k02m10bms3.apps.googleusercontent.com', '', NULL, 'Hexagon-2.jpg', 1, '#0081ff', '#ffffff', '#f1f4fa', '#0073e5', '#ffffff', '#0081ff', NULL, 'center', NULL, 'left', 'America/Argentina/Mendoza', 1, '1571846403', NULL, 1, 'YWM0ZmE3MDEtODgzNC00NmJlLWEzNGEtYTE0ZjkyZGUwMGU0', 'b9fad76b-873f-4f47-9d0f-d341c4d222a1', 'R$', 'kWp');

-- --------------------------------------------------------

--
-- Estrutura para tabela `department`
--

CREATE TABLE `department` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `orderindex` int(11) DEFAULT 0,
  `public` int(10) DEFAULT NULL,
  `status` enum('active','inactive','deleted') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `department`
--

INSERT INTO `department` (`id`, `name`, `orderindex`, `public`, `status`) VALUES
(1, 'Engenharia', 0, NULL, 'active'),
(2, 'Comercial', 1, NULL, 'active'),
(3, 'RH', 2, NULL, 'active'),
(4, 'Jurídico', 3, NULL, 'active'),
(5, 'Financeiro', 0, NULL, 'active');

-- --------------------------------------------------------

--
-- Estrutura para tabela `department_area`
--

CREATE TABLE `department_area` (
  `id` int(11) UNSIGNED NOT NULL,
  `department_id` int(11) DEFAULT 0,
  `name` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `orderindex` int(11) DEFAULT 0,
  `public` int(10) DEFAULT NULL,
  `status` enum('active','inactive','deleted') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `department_area`
--

INSERT INTO `department_area` (`id`, `department_id`, `name`, `description`, `orderindex`, `public`, `status`) VALUES
(1, 1, 'Suprimentos', NULL, 0, NULL, 'active'),
(2, 1, 'Gestão', '', 1, NULL, 'active'),
(3, 1, 'Execução', NULL, 2, NULL, 'active'),
(4, 1, 'Almoxarifado', '', 3, NULL, 'active');

-- --------------------------------------------------------

--
-- Estrutura para tabela `department_worker`
--

CREATE TABLE `department_worker` (
  `id` int(10) NOT NULL,
  `department_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `department_worker`
--

INSERT INTO `department_worker` (`id`, `department_id`, `user_id`) VALUES
(1, 2, 1),
(3, 1, 1),
(5, 2, 4),
(6, 2, 6),
(7, 1, 5),
(8, 2, 5),
(9, 1, 3),
(10, 2, 3),
(12, 1, 9),
(13, 2, 9),
(14, 3, 6),
(15, 5, 6),
(16, 2, 11),
(17, 3, 11),
(18, 5, 11),
(19, 1, 12),
(20, 1, 14),
(21, 2, 14),
(22, 3, 14),
(23, 4, 14),
(24, 5, 14);

-- --------------------------------------------------------

--
-- Estrutura para tabela `event`
--

CREATE TABLE `event` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `allday` varchar(30) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `classname` varchar(255) DEFAULT NULL,
  `start` varchar(255) DEFAULT NULL,
  `end` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT 0,
  `access` varchar(255) DEFAULT NULL,
  `reminder` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `lead`
--

CREATE TABLE `lead` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status_id` bigint(20) DEFAULT 0,
  `source` varchar(250) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `position` varchar(250) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `city` varchar(250) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `country` varchar(250) DEFAULT NULL,
  `zipcode` varchar(250) DEFAULT NULL,
  `language` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `owner` varchar(500) DEFAULT NULL,
  `phone` varchar(250) DEFAULT NULL,
  `mobile` varchar(250) DEFAULT NULL,
  `company` varchar(250) DEFAULT NULL,
  `tags` varchar(10000) NOT NULL,
  `description` text DEFAULT NULL,
  `proposal_value` varchar(20) DEFAULT '0,00',
  `rated_power_mod` varchar(10) NOT NULL,
  `last_contact` varchar(250) DEFAULT NULL,
  `last_landing` varchar(250) DEFAULT NULL,
  `created` varchar(20) DEFAULT NULL,
  `modified` varchar(20) DEFAULT NULL,
  `private` tinyint(1) DEFAULT 1,
  `completed` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT 0,
  `icon` varchar(255) DEFAULT NULL,
  `order` float DEFAULT 0,
  `payment` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `lead`
--

INSERT INTO `lead` (`id`, `status_id`, `source`, `name`, `position`, `address`, `city`, `state`, `country`, `zipcode`, `language`, `email`, `owner`, `phone`, `mobile`, `company`, `tags`, `description`, `proposal_value`, `rated_power_mod`, `last_contact`, `last_landing`, `created`, `modified`, `private`, `completed`, `user_id`, `icon`, `order`, `payment`) VALUES
(1, 5, '', 'Shopping Oi - Contagem', 'Gerente de Compras ', '', 'Contagem', 'MG', 'Brasil', '', NULL, 'ricardo.oliveira@grupomariovaladares.com.br', 'Coutinho', '', '(31)98787-2147', 'Ricardo Oliveira', 'Comércio', '																		<p>Reunião ocorrida na Ownergy em 26/03</p><p>Planta do estacionamento da unidade Eldorado (Contagem) enviado por e-mail </p><p>Conta de luz ainda não foi disponibilizada para análise do consumo. </p><p>Uma estimativa foi realizada em cima da área disponível</p>												', '', '324.47', NULL, '2019-10-21 19:17', '2019-04-15 17:23', '2019-08-12 15:24', 0, NULL, 1, NULL, 14.9, ''),
(2, 5, NULL, 'Auto Peças Rei', 'Gerente de Compras', 'RDV SP 338 ABRCO ASSED S/N1 LG A P REI - ', 'Cajuru', 'SP', 'Brasil', '14240-000', NULL, 'compras.lessandro@suporterei.com.br', 'Ownergy Solar', '(16)3667-9400', '', 'Lessandro Rocha', 'Comércio', '									<p>Envio da 1a proposta em 13/02/2019</p><p>Revisão da proposta e reenvio em 15/04/2019</p>						', '1.647.215,81', '396.18', NULL, '2019-08-07 10:19', '2019-04-16 11:17', '2019-08-12 15:28', 0, NULL, 1, NULL, 15, ''),
(3, 0, NULL, 'Colégio Nossa Sra das Dores', 'Diretor', 'Rua Iara 171, Pompéia', 'Belo Horizonte', 'MG', 'Brasil', '30280-370', NULL, 'diretor@saofranciscobh.com.br', 'Ownergy BH', '(31)3467-4848', '', 'Frei João Junior', 'Escola / Colégio', '						<p>Prospecção resgatada do levantamento feito em 2018 pela ferramenta do Exact Sales.</p><p>1a reunião foi ocorrida em 31/01/2019 para entendimento da demanda e apresentação da versão #1 da proposta.&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p><br></p>				', '453.599,40', '101.84', NULL, '2019-07-04 10:49', '2019-04-16 12:14', '2019-04-29 11:21', 0, NULL, 8, NULL, 15, ''),
(4, 5, NULL, 'Supermercado Stella', 'Gerente de Compras', 'AV SENADOR NILO COELHO 525', 'Guanambi', 'BA', 'Brasil', '46430-000', NULL, 'rodrigosartori@hiperstella.com.br', 'Ownergy Solar', '', '(77)98849-9229', 'Rodrigo Sartori', 'Comércio', '						<p>Contato realizado em 07/03/19 quando foi feito o envio do 1o orçamento.</p><p>Call para alinhamento e esclarecimento de dúvidas em 01/04/19.</p><p>Proposta readequada para a área disponível de 3.000m2. Reenviada em 16/04/19. </p>				', '2.786.921,00', '607.50', NULL, '2019-08-07 10:19', '2019-04-16 14:48', '2019-08-12 15:28', 0, NULL, 1, NULL, 15, 'bank financing'),
(5, 0, NULL, 'Hotel Verde Mar', '', 'Av. Octavio Mangabeira, 513 - Pituba', 'Salvador', 'BA', 'Brasil', '41830-050', NULL, 'marcelo.fonda@hotmail.com', 'DMC', '', '(31)99911-2340', 'Hotel Verde Mar', 'Comércio', '						<p>Oportunidade trazida pelo Marcelo DMC.</p><p>Proposta enviada em 07/03/19.</p><p><br></p>				', '227.245,66', '50.41', NULL, '2019-07-08 17:33', '2019-04-16 15:27', '2019-05-10 11:38', 0, NULL, 8, NULL, 15, 'own resources'),
(6, 5, NULL, 'Associação Residencial Gran Park', '', 'Rodovia  MG - 010 591 CD ', 'Vespasiano', 'MG', 'Brasil', '33200-000', NULL, 'brunoc7@gmail.com', 'Ownergy Solar', '', '(31)99200-0610', 'Bruno', 'Condomínio', '			<p>Solicitação de proposta feita em 13/03/19 como estrutura de solo</p><p>Revisão da proposta e alteração para estrutura de telhado metálico</p><p>Reenviada em 03/04/19. Aguardando retorno<br></p><p><br></p>		', '137.661,59', '30.15', NULL, '2019-08-12 15:16', '2019-04-16 16:20', '2019-08-12 15:28', 0, NULL, 1, NULL, 14.9, ''),
(7, 9, NULL, 'Robson Antônio Proença', 'Proprietário', 'Rua Azalea 164 csa, Vila Valqueire', 'Rio de Janeiro', 'RJ', 'Brasil', '21330-150', NULL, 'proencar01@gmail.com', 'Filial RJ', '', '(21)97036-2578', 'Robson Antônio Proença', '', '															Robson fechou contrato, contudo não efetuou pagamento pois o gatilho está vinculado ao parecer de acesso. O parecer de acesso está pendente devido ao debito junto a Light. Enviado e-mail solicitado exceção para instalação da usina. 										', '24.252,74', '4.62', NULL, '2019-08-12 15:16', '2019-04-16 16:45', '2019-08-12 15:29', 0, NULL, 1, NULL, 14.9, 'own resources'),
(8, 9, NULL, 'Renato Sanches Rodrigues ', 'Proprietario', 'Rua 04 Lte 03, quadra F - Bairro Piratininga ', 'Niteroi', 'RJ', 'Brasil', '23340-000', NULL, 'rrodrigues.renato@gmail.com', 'Filial RJ', '', '(22)98121-6688', 'Renato Sanches Rodrigues', 'Residência', '						Renato já assinou o contrato, parecer de acesso liberado, aguardando pagamento para continuar o processo. 				', '50.688,63', '9.10', NULL, '2019-08-07 10:20', '2019-04-16 17:28', '2019-08-12 15:29', 0, NULL, 1, NULL, 15, ''),
(9, 0, NULL, 'Patrus Transportes ', 'Analista de Manutenção', '', 'Viana', 'ES', 'Brasil', '', NULL, 'gabrielarodrigues@patrus.com.br', 'Breno Marcolino', '(31)2191-5290', '(31)97525-7473', 'Gabriela Rodrigues', 'Transportadora', '															<p>Solicitação de proposta em Fev/19.</p><p>Alteração e nivelamento das informações para nova proposta em Abril/19.</p><p><br></p><p>Proposta enviada. Teste02</p>										', '594.185,00', '127.80', NULL, '2019-10-21 19:02', '2019-04-22 15:01', '2019-08-12 15:27', 0, NULL, 1, NULL, 15, ''),
(10, 0, NULL, 'Elias Donato ', 'Proprietário ', 'Rua Professor José Renault, 572                ', 'Belo Horizonte', 'MG', 'Brasil', '30350-342', NULL, '', 'Ownergy BH', '', '(31)98791-2407', 'Elias Donato ', 'Residência', '						Prospect indicado pelo Pai do JF, proposta dimensionada. 				', '157.596,19', '28.04', NULL, '2019-05-10 10:04', '2019-04-23 11:01', '2019-04-30 13:12', 0, NULL, 7, NULL, 15, ''),
(11, 0, NULL, 'Maria Geralda Pinho', '', 'Rua Afonso Barbosa de Melo, 288 - São Bento', 'Belo Horizonte', 'MG', 'Brasil', '30360-090', NULL, 'mgqpinho@yahoo.com.br', 'Ownergy Solar', '', '(31)99541-8385', 'Maria Geralda Pinho', 'Residência', '			<p>Contato feito em 24/04. Solicitação de orçamento para instalação de uma usina em casa a ser reformada.</p><p><br></p>		', '29.340,00', '4.95', NULL, '2019-10-21 19:02', '2019-04-29 16:42', '2019-08-12 15:27', 0, NULL, 1, NULL, 15, ''),
(12, 0, NULL, 'Clínica Uromaster', 'Departamento Pessoal', 'Rua Manaus, 645 e 635 Bairro São Lucas', 'Belo Horizonte', 'MG', 'Brasil', '30150-350', NULL, 'sol.uromaster@gmail.com', 'Ownergy BH', '(31)3241-4244', '', 'Sol Silva', 'Clínica / Hospital', '			A clínica foi indicada pelo Sr Josias (Dr. Paulo é o médico responsável pela Clínica e da fazenda na cidade de Conselheiro Navarro - MG ). A estrutura da clínica é bastante comprometida pelo sombreamentos dos prédios, portanto a proposta foi dimensionada para instalação na fazenda(solo). Enviado para a Sol Silva, departamento Pessoal que está responsável em receber as propostas, coloquei-me a disposição para esclarecimentos. 		', '145.589,01', '27.47', NULL, '2019-07-04 11:08', '2019-05-03 11:55', '2019-05-24 15:38', 0, NULL, 8, NULL, 15, 'own resources'),
(13, 5, NULL, 'Above Coffees', 'Proprietário', '', 'Lambari', 'MG', 'Brasil', '', NULL, 'contato@abovecoffees.com', 'JF', '', '(11)99685-6225', 'Bruno Alves Pinto', 'Indústria', '									<p>Indicação de JF. </p><p>Galpão para beneficiamento de café ainda em construção em Lambari/MG</p>						', '304.913,00', '57.10', NULL, '2019-10-21 18:55', '2019-05-10 12:01', '2019-08-12 15:24', 0, NULL, 1, NULL, 14.9, ''),
(14, 0, NULL, 'Padaria Vitoria', 'Proprietária', '', 'Macaé', 'RJ', 'Brasil', '', NULL, 'marcia@padaria.com', 'Ownergy RJ', '', '', 'Marcia Andrade', '', '										', '250.000,00', '45', NULL, '2019-06-07 09:58', '2019-06-06 16:52', '2019-06-06 16:53', 0, NULL, 4, NULL, 15, 'bank financing'),
(15, 4, NULL, 'Assessa', '', 'Rua Cardoso Quintão, 110, Piedade', 'Rio de Janeiro', 'RJ', 'Brasil', '21381-460', NULL, '', 'Filial RJ', '', '', 'Assessa Ind Com Expo LTDA', '', '															', '171.136,20', '35.70', NULL, '2019-10-21 19:20', '2019-06-12 12:42', '2019-08-12 15:26', 0, NULL, 1, NULL, 15, 'own resources'),
(16, 0, NULL, 'Marcus Amaral', 'Dono', 'Rua Sapucaia, 255, Retiro das Pedras', 'Brumadinho', 'MG', 'Brasil', '35460-000', NULL, '', 'José Francisco', '', '', 'Marcus Vinícius Fonseca Amaral', '', '					', '39.937,55', '7.14', NULL, '2019-06-26 15:10', '2019-06-12 12:45', '2019-06-12 12:45', 0, NULL, 10, NULL, 15, 'own resources'),
(17, 0, NULL, 'Luiz Roberto Andrade', 'Dono', 'A. M. das Araucárias,95 - Residencial Sonho verde', 'Lagoa Santa', 'MG', 'Brasil', '33400-000', NULL, 'luizroberto@laboroil.com.br', 'Patrick Ludtke', '', '(31)99342-8375', 'Luiz Roberto Andrade', '', '																									', '56.079,19', '10.05', NULL, '2019-10-21 19:22', '2019-06-17 11:44', '2019-08-12 15:29', 0, NULL, 1, NULL, 15, 'own resources'),
(18, 0, NULL, 'Maria Áurea Faria', 'Dona', 'Sitio Rozeral,46 - Porto do Horizonte KM 9 - Zona Rural', 'Prudente de Morais', 'MG', 'Brasil', '35715-000', NULL, '', 'Ownergy Solar', '(31)3278-1692', '(31)99886-6613', 'Maria Áurea Faria', '', '															', '33.292,29', '4.62', NULL, '2019-10-21 19:22', '2019-06-17 11:51', '2019-08-12 15:30', 0, NULL, 1, NULL, 15, 'own resources'),
(19, 6, NULL, 'EMC Empreendimentos', '', 'Av. Afonso Pena ', 'Belo Horizonte ', 'MG', 'Brasil', '', NULL, '', 'Horizonte Solar ', '', '', 'Eduardo Meira de Carvalho', '', '																																													', '177.698,42', '36.48', NULL, '2019-10-21 18:56', '2019-07-08 15:09', '2019-08-12 15:48', 0, NULL, 1, NULL, 15, ''),
(20, 4, NULL, 'Centro Espirita Joaquim ', '', 'Rua Caobi, 107 - Arajá', 'Rio de Janeiro', 'RJ', 'Brasil', '21361-470', NULL, '', 'Filial RJ', '', '', 'Centro Espirita Joaquim Murtinho', '', '										', '148.850,01', '29.82', NULL, '2019-10-21 19:20', '2019-07-09 17:44', '2019-08-12 15:26', 0, NULL, 1, NULL, 15, ''),
(21, 4, NULL, 'Condomínio Verdant Valley', '', 'End. Estrada do Camorim, 1003 - Camorim', 'Rio de Janeiro', 'RJ', 'Brasil', '', NULL, '', 'Filial RJ', '', '', 'Condomínio Verdant Valley', '', '																									', '1.180.486,34', '237.85', NULL, '2019-10-21 19:20', '2019-07-10 15:05', '2019-08-12 15:26', 0, NULL, 1, NULL, 15, ''),
(22, 0, NULL, 'Condimínio verdant Valley (Area Externa)', '', 'End. Estrada do Camorim, 1003', 'Rio de Janeiro', 'RJ', 'Brasil', '', NULL, '', 'Ownergy Rio', '', '', 'Condimínio verdant Valley', '', '					', '', '106.92', NULL, '2019-07-12 11:06', '2019-07-10 15:08', '2019-07-10 15:08', 0, NULL, 10, NULL, 15, ''),
(23, 0, NULL, 'Fernando Zanandrea', '', '', 'Caxias do Sul', 'RS', 'Brasil', '', NULL, '', 'Filial RJ', '', '', 'Fernando Zanandrea', '', '																									', '1.754.671,90', '335.00', NULL, '2019-10-21 19:12', '2019-07-10 17:20', '2019-08-12 15:25', 0, NULL, 1, NULL, 15, ''),
(24, 0, NULL, 'Pousada Vidinha Bela', '', 'Brazopolis', '', '', 'Brasil', '', NULL, '', 'José Francisco', '', '', 'Isabel', '', '					', '24.866,36', '4.76', NULL, '2019-08-12 14:50', '2019-07-17 10:49', '2019-07-17 10:49', 0, NULL, 10, NULL, 15, ''),
(25, 0, NULL, 'Gizela Abras', 'Gestora', '', 'Belo Horizonte', 'MG', 'Brasil', '', NULL, '', 'JF', '', '(31)98455-0014', 'Cliente retorna de férias em 23/08', 'Indústria', '					', '', '', NULL, '2019-10-21 18:47', '2019-08-12 15:23', '2019-08-12 15:23', 0, NULL, 4, NULL, 15, ''),
(26, 0, NULL, 'José Roberto Salgado', '', '', 'Curvelo', 'MG', 'Brasil', '', NULL, '', 'JF', '', '(31)99874-1282', 'José Roberto Salgado', 'Residência', 'Cliente tem três contas de luz em Curvelo e quer colocar usina solar de solo em uma de suas fazendas para abater as três contas.', '72.324,44', '15.20', NULL, '2019-10-21 19:01', '2019-08-15 17:12', '2019-08-15 17:12', 0, NULL, 4, NULL, 15, 'own resources'),
(27, 0, NULL, 'Lacca', '', '', 'Rio de Janeiro', 'RJ', 'Brasil', '', NULL, '', 'Filial RJ', '', '', 'Lacca', 'Indústria', 'Cliente do Rodrgo, havia optado por uma opcao mais barata , mas agoar Rodrigo está tentando mostrar algo com Santander e Patrick ficou de achar investidor para bancar a usina.', '', '340.00', NULL, '2019-10-21 19:12', '2019-08-15 17:14', '2019-08-15 17:14', 0, NULL, 4, NULL, 15, ''),
(28, 3, NULL, 'Churrascaria Vamo', '', '', 'Rio de Janeiro', 'RJ', 'Brasil', '', NULL, '', 'Filial RJ', '', '', '', 'Comércio', '<p>Cliente é amigo do Rodrigo, tem área na Barra e Nova Iguaçu e vários restaurantes pelo Rio, cada restaurante é um CNPJ.</p><p>Ideia é fazer a usina em um dos galpões, em nome da Holding dele, bota todas as contas de luz no mesmo CNPJ.</p><p>Rodrigo ia pedir as contas de luz dele.</p>', '', '', NULL, '2019-10-21 19:12', '2019-08-15 17:21', '2019-08-15 17:21', 0, NULL, 4, NULL, 15, ''),
(29, 2, NULL, 'Farma', '', '', 'Rio de Janeiro', 'RJ', 'Brasil', '', NULL, '', 'Filial RJ', '', '', '', 'Indústria', 'Cliente do Rodrigo, que havia recusado uma proposta de aproximadamente R$ 600.000,00, segundo o Rodrigo voltou agora ao jogo. Acompanhar', '600.000,00', '150.00', NULL, '2019-10-21 18:53', '2019-08-15 17:33', '2019-08-15 17:33', 0, NULL, 4, NULL, 15, ''),
(30, 2, NULL, 'MRV Joanápolis', '', 'Av. Professor Mário Werneck, 621 - Estoril', 'Belo Horizonte ', 'MG', 'Brasil', '30455-610', NULL, 'luis.capanema@mrv.com.br', '', '', '', 'MRV Engenharia', 'Comércio,Sirius', 'Projeto de 400kWp para a MRV localizado em Joanápolis-GO a ser feito toda etapa de desenhos, memorial descritivo, entrada na concessionária, projeto executivo e instalação (Projeto Turn-Key).					', '1.526.953,33', '400.00', NULL, '2019-10-16 11:33', '2019-10-16 11:33', '2019-10-16 11:33', 0, NULL, 12, NULL, 15, ''),
(31, 1, NULL, 'Alnutri', 'Gerente', '', 'Belo Horizonte', 'MG', 'Brasil', '', NULL, '', 'JF', '', '(31)98476-4449', 'Acácio', '', '					', '1.099.889,56', '300.00', NULL, '2019-10-21 18:50', '2019-10-21 18:50', '2019-10-21 18:50', 0, NULL, 4, NULL, -49, 'own resources');

-- --------------------------------------------------------

--
-- Estrutura para tabela `lead_comment`
--

CREATE TABLE `lead_comment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `attachment` varchar(250) DEFAULT NULL,
  `attachment_link` varchar(250) DEFAULT NULL,
  `datetime` varchar(250) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `user_id` bigint(20) DEFAULT 0,
  `lead_id` bigint(20) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `lead_comment`
--

INSERT INTO `lead_comment` (`id`, `attachment`, `attachment_link`, `datetime`, `message`, `user_id`, `lead_id`) VALUES
(1, '', '', '1556542080', 'Contato com Marcelo em 01/04 - disse que verificaria.\n\nContato novamente no dia 05/04 mas sem sucesso.\n\nEm 16/04 disse que verificaria. Em 23/04 contato sem sucesso.', 4, 5),
(2, '', '', '1556542894', '10/01/19 - 1a visita ocorrida em Janeiro', 4, 3),
(3, '', '', '1556542922', '04/02/19 - Após a reformatação do telhado, novo layout foi apresentado', 4, 3),
(4, '', '', '1556542942', '03/03/19 - Revisão da proposta em Abril com 3 opções: a escolhida foi a simulação da usina no colégio gerando para 8 conventos em MG', 4, 3),
(5, '', '', '1556543163', 'Bernardo, precisa de uma quarta opcao que é com telhado ceramico', 4, 3),
(6, '', '', '1556545694', 'Dimensionamento refeito e enviado para Horizonte Solar em 25/04.', 8, 1),
(7, '', '', '1556548543', 'Reunião ocorrida em 10/04 para apresentação da proposta revisada de acordo com as modificações apresentadas no projeto arquitetônico.\nReunião com Sicoob ocorrida em 16/04 para avaliar financiamento.\nAguardando retorno da reunião do conselho da congregação ocorrida em 25 e 26/04.', 8, 3),
(8, '', '', '1556549314', 'Proposta enviada em 25/04 para avaliação.', 8, 9),
(9, 'WhatsApp_Image_2019-04-30_at_15.09.38.jpeg', 'd7b22ec40d32a80f2c64fe4edb622378.jpeg', '1556653068', 'Renato pagou 50% do valor do contrato, o Rodrigo Lopes, enviou o comprovante de pagamento.', 7, 8),
(10, '', '', '1557490671', 'Bernardo vai ligar em 10/05 para Tatiana e Roberto Carlos para uma abordagem lateral para sentir a temperatura. Em seguida, dependendo da conversa, falar com o Frei João', 4, 3),
(11, '', '', '1557491090', 'Bernardo vi ligar para Bruno na segunda-feira 13/05 para uma apertada', 4, 6),
(12, '', '', '1557491538', 'JF mandou zap para Vinicius em 10/05 para sondar', 4, 9),
(13, '', '', '1557491577', 'Aguardar retorno do Vinicius para depois Bernardo voltar com Gabriela lá pela terça-feira 14/05', 4, 9),
(14, '', '', '1557491937', 'JF mandou zap em 10/05 para Rodrigo para sondar. Após retorno do Rodrigo, avliar melhor maneira de Bernardo entrar matando', 4, 4),
(15, '', '', '1557492009', 'Contato com Lessandro realizado na segunda dia 06/05 por Bernardo. Ele disse que está com outras propostas e está avaliando a nossa', 4, 2),
(16, '', '', '1557492155', 'Aguardar duas semanas para novo contato', 4, 2),
(17, '', '', '1557493723', 'Bernardo vai fazer uma visita ao Alessandro acompanhado do Coutinho', 4, 1),
(18, '', '', '1557498264', 'Contato telefônico feito em 10/05. Proposta em análise pelo Dr. Paulo, dono da clínica.', 8, 12),
(19, '', '', '1559044364', 'Novo contato feito em 27/05 com Frei João. Processo ainda parado aguardando outras cotações. Haverá nova reunião do Conselho na próxima semana para atualização interna.', 8, 3),
(20, '', '', '1559044417', 'Contato feito em 27/05. Processo ainda em avaliação.', 8, 2),
(21, '', '', '1559045019', 'Seguidas tentativas de contato sem retorno', 8, 6),
(22, '', '', '1559045250', 'Contato feito em 27/05. Processo de análise das propostas ainda ainda em andamento.', 8, 5),
(23, '', '', '1559045322', 'Msg abaixo postada incorretamente. Desconsiderar', 8, 5),
(24, '', '', '1559045670', 'Contato feito em 27/05. Processo ainda em andamento aguardando análise da diretoria.', 8, 9),
(25, '', '', '1559046962', 'Acompanhamento junto a Horizonte Solar. Proposta a ser apresentada em Junho.', 8, 1),
(26, '', '', '1559048834', 'Tentativa de contato sem retorno.', 8, 12),
(27, '', '', '1559850952', 'Enviei conta de luz ao PEdro em 06/06, solicitando retorno até 08/06', 6, 14),
(28, '', '', '1559851133', 'Tentei contato com a MArcia no dia 06/06 e me disseram que ela estava doente', 6, 14),
(29, '', '', '1559851186', 'MArcia pediu para eu ligar de volta no dia 09/06', 6, 14),
(30, '', '', '1559852215', 'fjs;lslfjfd', 6, 14),
(31, '', '', '1562246368', 'Mensagem enviada a Coutinho pedindo atualizacao', 10, 1),
(32, '', '', '1562246479', 'Coutinho enviou proposta para o dono por volta do dia 26 e entrará em contato assim que conseguir a resposta', 10, 1),
(33, '', '', '1562247206', 'Jota entrou em contato com Bruno sobre o andamento da proposta', 10, 13),
(34, '', '', '1562247384', 'Bruno disse que terá definicao clara no fim de Julho', 10, 13),
(35, '', '', '1562247641', 'JF trocou mensagens com Rodrigo no dia 03/07 e ele disse que já enviou a proposta ao cliente', 10, 15),
(36, '', '', '1562248035', 'Ligamos no dia 04/07 mas ela estava com 3 pessoas na obra e pediu para ligar em meia hora', 10, 11),
(37, '', '', '1562248345', 'Enviei mensagem pro Marcelo p saber se ele está atualizado sobre a proposta', 10, 5),
(38, '', '', '1562249001', 'Falei com a Gabriela p saber se ela tem alguma novidade sobre a proposta que foi enviada pra ela', 10, 9),
(39, '', '', '1562249554', 'Ligamos para a recepcao e a mulher disse que ele não estava na empresa. Pediu para ligar a partir das 16 horas', 10, 2),
(40, '', '', '1562249858', 'Mandei mensagem pro Rodrigo pra saber se ele tem alguma atualizacao da proposta', 10, 4),
(41, '', '', '1562250071', 'Rodrigo disse que assim que tiver reposta entra em contato', 10, 4),
(42, '', '', '1562250245', 'Tentativa de contato no dia 04/07 por telefone sem sucesso', 10, 6),
(43, '', '', '1562253587', 'Liguei pra ela meia hora depois do registro abaixo , mas n tive sucesso de contato', 10, 11),
(44, '', '', '1562263592', 'Contactei a Gabriela novamente no dia 04/07 e ela me reportou que não tem posicionamento sobre a proposta, mas que assim que tiver entra em contato conosco.', 10, 9),
(45, '', '', '1562609566', 'Patrick enviou uma e-mail no dia 08/07/19 pro Cesar enviando a proposta atualizada', 10, 19),
(46, '', '', '1562616486', 'Conversei com a Maria e ela vai me enviar uma mensagem por wpp pra gente mandar um novo orçamento , pois o enviado não atendia', 10, 11),
(47, '', '', '1562617475', 'Contato feito dia 08/07 sem sucesso.', 10, 2),
(48, '', '', '1562617658', 'Marcelo visualiza as mensagens mas não responde', 10, 5),
(49, '', '', '1562617912', 'Conversei com o Bruno e ele disse que terá q levar a proposta pra assembleia aprovar , que irá acontecer no final do ano', 10, 6),
(50, '', '', '1562618015', 'O Marcelo disse que o cliente não tem interesse', 10, 5),
(51, '', '', '1562692767', 'A portaria disse que por ser feriado o Lessandro não estaria e pediu p ligar dia 10/07', 10, 2),
(52, '', '', '1562780199', 'Contactei Rodrigo sobre posicionamento do cliente e estou aguardando reposta', 10, 15),
(53, '', '', '1562780547', 'Rodrigo disse que eles irão demorar um pouco p dar resposta', 10, 15),
(54, '', '', '1562851088', 'Conversei com Coutinho e ele disse que o dono irá dar a resposta semana que vem.', 10, 1),
(55, '', '', '1562851955', 'Liguei pra la , mas não consegui falar com Lessandro', 10, 2),
(56, '', '', '1563218718', 'Contato feito dia 15/07 , mas Lessandro estava em reunião', 10, 2),
(57, '', '', '1563219289', 'Patrick Enviou um e-mail para César dia 12 , fazendo uma atualização de  preços. César disse que iria avaliar as condições da proposta e daria uma resposta', 10, 19),
(58, '', '', '1563307346', 'Conversei com Lessandro e ele informou que a diretoria está avaliando e pediu pra entrar em contato em um mês.', 10, 2),
(59, '', '', '1563824790', 'Tentei contactar Coutinho por WPP , ele visualizou mas não respondeu', 10, 1),
(60, '', '', '1563884683', 'O cliente solicitou uma alteração nas condições de pagamento para o Patrick e ele irá avaliar e enviar nova proposta', 10, 19),
(61, '', '', '1565632232', 'Tarifa do cliente é muito baixa - rural - e o payback ficaria muito longo.', 4, 24),
(62, '', '', '1565632517', 'Enviado zap ao Rodrigo em 12/08, aguardando retorno', 4, 15),
(63, '', '', '1565632543', 'Enviado zap para Rodrigo em 12/08, aguardando retorno', 4, 21),
(64, '', '', '1565632567', 'Enviado zap para Rodrigo em 12/08, aguardando retorno', 4, 20),
(65, '', '', '1565632594', 'Enviado zap para Rodrigo em 12/08, aguardando retorno', 4, 23),
(66, '', '', '1565632654', 'Enviado zap para Patrick em 12/08, aguardando retorno', 4, 19),
(67, '', '', '1565632679', 'Enviado zap para Coutinho em 12/08, aguardando retorno', 4, 1),
(68, '', '', '1565632821', 'Enviado zap para Gabriela em 12/08, aguardando retorno', 4, 9),
(69, '', '', '1565633348', 'Enviado zap para cliente e m12/08, aguardando retorno', 4, 11),
(70, '', '', '1565633449', 'Enviado zap para cliente em 12/08, aguardando retorno', 4, 13),
(71, '', '', '1565633586', 'Voltar a fazer contato em 16/08', 4, 2),
(72, '', '', '1565633679', 'Aguardar até 19/08 para contato telefônico final', 4, 4),
(73, '', '', '1565633748', 'Contatar Bruno em 19/08', 4, 6),
(74, '', '', '1565635069', 'Rodrigo disse que vai estar com ele em Caxias na quinta-feira 15/08 e irá visitar o Sicredi junto com ele. Fazer contato na segunda-feira 19/08', 4, 23),
(75, '', '', '1565635135', 'Rodrigo disse que o condomínio ainda está recebendo orçamentos. Aguardar', 4, 21),
(76, '', '', '1565635161', 'Rodrigo disse que estão arrecadando fundos para fazer. Acompanhar', 4, 20),
(77, '', '', '1565635223', 'Patrick orientou a contatar o cliente dentro de aproximadamente 15 dias, para coincidir com as encomendas dos Hospitais.', 4, 19),
(78, '', '', '1565635313', 'Coutinho disse que cobrou do Ricardo na ultima sexta, que disse que conversaria com o M\'rio esta semana e daria retorno. Coutinho sugeriu aguardar até o meio da semana. Cobrar dele na próxima segunda 19/08', 4, 1),
(79, '', '', '1565899618', 'Rodrigo esteve com o cliente em Caxias em 15/08 e foram ao SICREDI. Cliente deve conseguir financiamento de até 100%, Rodrigo passou novas condições e refizemos a proposta para 2.1000 múdulos de 400 W.', 4, 23),
(80, '', '', '1571694772', 'Enviado zap em 21/10 para saber como anda', 4, 26),
(81, '', '', '1571694800', 'Enviado zap para Rodrigo em 21/10 para saber como anda', 4, 28),
(82, '', '', '1571694825', 'Enviado zap para Rodrigo em 21/10 para saber como anda,', 4, 29),
(83, '', '', '1571694927', 'Enviado zap em 21/10 ara Bruno para saber como anda', 4, 13),
(84, '', '', '1571695030', 'Enviado zap para Coutinho em 21/10 para saber como anda', 4, 1),
(85, '', '', '1571695108', 'Enviado zap para Rodrigo em 21/10 para saber como anda', 4, 20),
(86, '', '', '1571695137', 'Enviado zap para Rodrigo em 21/10 para asaber como anda', 4, 15),
(87, '', '', '1571695156', 'Enviado zap para Rodrigo em 21/10 para saber como anda', 4, 21),
(88, '', '', '1571696132', 'Enviado email para Lessandro em 21/10 para saber como anda', 4, 2),
(89, '', '', '1571696213', 'Coutinho disse que falou com Ricardo e que está parado e que vai ficar para o final do ano', 4, 1),
(90, '', '', '1571696315', 'enviado zap para Rodrigo em 21/10 para saber como anda', 4, 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `lead_history`
--

CREATE TABLE `lead_history` (
  `id` int(11) UNSIGNED NOT NULL,
  `lead_id` int(10) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `lead_history`
--

INSERT INTO `lead_history` (`id`, `lead_id`, `message`, `created_at`) VALUES
(1, 1, 'Bernardo criou o lead Ricardo Oliveira', '2019-04-15 17:23:07'),
(2, 1, 'Bernardo alterou os seguintes dados de Ricardo Oliveira: Cliente; Descrição; ', '2019-04-15 17:36:52'),
(3, 2, 'Bernardo criou o lead AUTO PEÇAS REI', '2019-04-16 11:17:34'),
(4, 2, 'Bernardo alterou os seguintes dados de AUTO PEÇAS REI: Tags; ', '2019-04-16 11:18:55'),
(5, 2, 'Bernardo alterou os seguintes dados de AUTO PEÇAS REI: Descrição; Dados de endereço; Dados de contato; Tags; Valor da proposta; Potência nominal; ', '2019-04-16 11:24:38'),
(6, 2, 'Bernardo moveu AUTO PEÇAS REI para Follow up 2', '2019-04-16 11:24:51'),
(7, 2, 'Bernardo alterou os seguintes dados de AUTO PEÇAS REI: Dados de endereço; ', '2019-04-16 11:38:00'),
(8, 3, 'Bernardo criou o lead Colégio Nossa Sra das Dores', '2019-04-16 12:14:44'),
(9, 4, 'Bernardo criou o lead Supermercado Stella', '2019-04-16 14:48:48'),
(10, 5, 'Bernardo criou o lead Hotel Verde Mar', '2019-04-16 15:27:51'),
(11, 6, 'Bernardo criou o lead Associação Residencial Gran Park', '2019-04-16 16:20:46'),
(12, 6, 'Bernardo moveu Associação Residencial Gran Park para Follow up 2', '2019-04-16 16:22:31'),
(13, 7, 'Andreia criou o lead Robson Antonio ', '2019-04-16 16:45:36'),
(14, 8, 'Andreia criou o lead Renato Sanches Rodrigues ', '2019-04-16 17:28:06'),
(15, 7, 'Andreia alterou os seguintes dados de Robson Antonio : Descrição; Dados de endereço; Dado do lead; Valor da proposta; Potência nominal; ', '2019-04-16 17:33:04'),
(16, 8, 'Andreia alterou os seguintes dados de Renato Sanches Rodrigues : Descrição; Dados de endereço; Dados de contato; Dado do lead; Tags; Valor da proposta; Potência nominal; ', '2019-04-22 09:54:29'),
(17, 9, 'Bernardo criou o lead PATRUS TRANSPORTES', '2019-04-22 15:01:33'),
(18, 9, 'Bernardo alterou os seguintes dados de PATRUS TRANSPORTES: Dado do lead; Tags; ', '2019-04-22 15:03:03'),
(19, 10, 'Andreia criou o lead Elias Donato ', '2019-04-23 11:01:04'),
(20, 9, 'Bernardo moveu PATRUS TRANSPORTES para Proposta Enviada', '2019-04-25 16:55:09'),
(21, 10, 'José moveu Elias Donato  para Proposta Enviada', '2019-04-29 09:40:47'),
(22, 5, 'José moveu Hotel Verde Mar para Follow up', '2019-04-29 09:45:51'),
(23, 5, 'José alterou os seguintes dados de Hotel Verde Mar: Dado do lead; ', '2019-04-29 09:54:04'),
(24, 3, 'José alterou os seguintes dados de Colégio Nossa Sra das Dores: Descrição; ', '2019-04-29 10:02:57'),
(25, 1, 'Bernardo alterou os seguintes dados de Shopping OI - Contagem: Dados de endereço; Tags; Potência nominal; ', '2019-04-29 10:49:02'),
(26, 1, 'Bernardo moveu Shopping OI - Contagem para Proposta Enviada', '2019-04-29 10:49:11'),
(27, 3, 'Bernardo alterou os seguintes dados de Colégio Nossa Sra das Dores: Descrição; Tags; ', '2019-04-29 11:21:18'),
(28, 11, 'Bernardo criou o lead Maria Geralda Pinho', '2019-04-29 16:42:11'),
(29, 9, 'Bernardo alterou os seguintes dados de PATRUS TRANSPORTES: Descrição; ', '2019-04-29 16:43:06'),
(30, 11, 'Bernardo moveu Maria Geralda Pinho para Proposta Enviada', '2019-04-29 16:49:29'),
(31, 10, 'Andreia alterou os seguintes dados de Elias Donato : Descrição; Dados de endereço; ', '2019-04-30 13:12:30'),
(32, 9, 'Andreia alterou os seguintes dados de PATRUS TRANSPORTES: Descrição; ', '2019-04-30 13:19:23'),
(33, 8, 'Andreia moveu Renato Sanches Rodrigues  para Fluxo Financeiro', '2019-04-30 14:02:34'),
(34, 8, 'Andreia alterou os seguintes dados de Renato Sanches Rodrigues : Descrição; ', '2019-04-30 16:29:29'),
(35, 8, 'Andreia moveu Renato Sanches Rodrigues  para Fluxo Financeiro', '2019-04-30 16:36:23'),
(36, 8, 'Bernardo moveu Renato Sanches Rodrigues  para Execução', '2019-05-02 14:18:58'),
(37, 7, 'Bernardo moveu Robson Antonio  para Parecer de Acesso e pgto da 1a parcela', '2019-05-02 14:19:00'),
(38, 7, 'Bernardo alterou os seguintes dados de Robson Antonio : Descrição; ', '2019-05-02 15:12:16'),
(39, 12, 'Andreia criou o lead Clínica Uromaster', '2019-05-03 11:55:58'),
(40, 12, 'Andreia moveu Clínica Uromaster para Proposta Enviada', '2019-05-03 11:56:05'),
(41, 1, 'Bernardo moveu Shopping OI - Contagem para Elaboração de Propostas', '2019-05-08 16:28:25'),
(42, 9, 'Bernardo moveu Patrus Transportes  para Follow up', '2019-05-10 08:38:56'),
(43, 10, 'José moveu Elias Donato  para perdidos', '2019-05-10 10:04:41'),
(44, 12, 'Bernardo moveu Clínica Uromaster para Follow up', '2019-05-10 11:23:44'),
(45, 5, 'Bernardo alterou os seguintes dados de Hotel Verde Mar: Dados de contato; ', '2019-05-10 11:38:40'),
(46, 4, 'Bernardo alterou os seguintes dados de Supermercado Stella: Descrição; ', '2019-05-10 11:39:10'),
(47, 13, 'Bernardo criou o lead Above Coffees', '2019-05-10 12:01:07'),
(48, 13, 'Bernardo alterou os seguintes dados de Above Coffees: Descrição; Dado do lead; ', '2019-05-10 12:01:30'),
(49, 13, 'Bernardo alterou os seguintes dados de Above Coffees: Dados de endereço; Dados de contato; ', '2019-05-10 12:02:28'),
(50, 12, 'Thiago alterou os seguintes dados de Clínica Uromaster: Descrição; Responsável pelo lead; ', '2019-05-24 15:38:48'),
(51, 11, 'Marlem moveu Maria Geralda Pinho para Follow up', '2019-05-28 14:10:59'),
(52, 7, 'Marlem moveu Robson Antonio  para Execução', '2019-05-31 12:22:14'),
(53, 1, 'Marlem moveu Shopping OI - Contagem para Proposta Enviada', '2019-06-06 16:48:46'),
(54, 4, 'Marlem moveu Supermercado Stella para Negociação', '2019-06-06 16:48:56'),
(55, 4, 'Marlem moveu Supermercado Stella para Follow up 2', '2019-06-06 16:49:03'),
(56, 1, 'Marlem moveu Shopping OI - Contagem para Elaboração de Propostas', '2019-06-06 16:49:06'),
(57, 14, 'Marlem criou o lead Padaria Vitoria', '2019-06-06 16:52:43'),
(58, 14, 'Marlem alterou os seguintes dados de Padaria Vitoria: Dados de endereço; ', '2019-06-06 16:53:24'),
(59, 14, 'Marlem moveu Padaria Vitoria para Proposta Enviada', '2019-06-06 16:56:30'),
(60, 14, 'Marlem moveu Padaria Vitoria para Follow up', '2019-06-06 16:58:44'),
(61, 14, 'Marlem moveu Padaria Vitoria para Proposta Enviada', '2019-06-06 16:58:52'),
(62, 2, 'Marlem moveu Auto Peças Rei para Negociação', '2019-06-06 17:16:44'),
(63, 2, 'Marlem moveu Auto Peças Rei para Follow up 2', '2019-06-06 17:16:46'),
(64, 14, 'Lucas moveu Padaria Vitoria para perdidos', '2019-06-07 09:58:34'),
(65, 15, 'Lucas criou o lead Assessa', '2019-06-12 12:42:19'),
(66, 16, 'Lucas criou o lead Marcus Amaral', '2019-06-12 12:45:34'),
(67, 17, 'Lucas criou o lead Luiz Roberto', '2019-06-17 11:44:17'),
(68, 18, 'Lucas criou o lead Maria Aurea', '2019-06-17 11:51:56'),
(69, 15, 'Lucas moveu Assessa para Proposta Enviada', '2019-06-26 14:46:08'),
(70, 16, 'Lucas moveu Marcus Amaral para Proposta Enviada', '2019-06-26 14:46:11'),
(71, 16, 'Lucas moveu Marcus Amaral para perdidos', '2019-06-26 15:10:36'),
(72, 18, 'Lucas moveu Maria Aurea para Parecer de Acesso e pgto da 1a parcela', '2019-07-04 09:46:47'),
(73, 15, 'Lucas alterou os seguintes dados de Assessa: Dado do lead; ', '2019-07-04 10:11:32'),
(74, 1, 'Lucas moveu Shopping OI - Contagem para Proposta Enviada', '2019-07-04 10:30:10'),
(75, 1, 'Lucas moveu Shopping OI - Contagem para Proposta Enviada', '2019-07-04 10:31:08'),
(76, 13, 'Lucas moveu Above Coffees para Follow up', '2019-07-04 10:36:56'),
(77, 3, 'Lucas moveu Colégio Nossa Sra das Dores para perdidos', '2019-07-04 10:49:00'),
(78, 12, 'Lucas moveu Clínica Uromaster para perdidos', '2019-07-04 11:08:09'),
(79, 17, 'Lucas alterou os seguintes dados de Luiz Roberto: Dados de endereço; ', '2019-07-04 11:25:53'),
(80, 17, 'Lucas moveu Luiz Roberto para Parecer de Acesso e pgto da 1a parcela', '2019-07-04 11:26:30'),
(81, 7, 'Lucas moveu Robson Antonio  para Parecer de Acesso e pgto da 1a parcela', '2019-07-04 11:28:11'),
(82, 19, 'Lucas criou o lead EMC Empreendimentos', '2019-07-08 15:09:29'),
(83, 19, 'Lucas alterou os seguintes dados de EMC Empreendimentos: Cliente; Dados de endereço; Dado do lead; Valor da proposta; Potência nominal; ', '2019-07-08 15:10:46'),
(84, 19, 'Lucas moveu EMC Empreendimentos para Proposta Enviada', '2019-07-08 15:10:55'),
(85, 19, 'Lucas alterou os seguintes dados de EMC Empreendimentos: Dado do lead; ', '2019-07-08 15:11:45'),
(86, 5, 'Lucas moveu Hotel Verde Mar para perdidos', '2019-07-08 17:33:52'),
(87, 20, 'Lucas criou o lead Centro Espirita Joaquim ', '2019-07-09 17:44:40'),
(88, 20, 'Lucas moveu Centro Espirita Joaquim  para Proposta Enviada', '2019-07-09 17:46:40'),
(89, 19, 'Lucas alterou os seguintes dados de EMC Empreendimentos: Dado do lead; ', '2019-07-10 13:52:00'),
(90, 19, 'Lucas alterou os seguintes dados de EMC Empreendimentos: Dado do lead; ', '2019-07-10 13:52:27'),
(91, 19, 'Lucas alterou os seguintes dados de EMC Empreendimentos: Dado do lead; ', '2019-07-10 13:52:54'),
(92, 19, 'Thiago alterou os seguintes dados de EMC Empreendimentos: Dado do lead; ', '2019-07-10 13:54:40'),
(93, 19, 'Lucas alterou os seguintes dados de EMC Empreendimentos: Dado do lead; ', '2019-07-10 13:55:44'),
(94, 19, 'Lucas alterou os seguintes dados de EMC Empreendimentos: Dado do lead; ', '2019-07-10 13:56:20'),
(95, 19, 'Lucas alterou os seguintes dados de EMC Empreendimentos: Dado do lead; ', '2019-07-10 13:59:07'),
(96, 19, 'Lucas alterou os seguintes dados de EMC Empreendimentos: Dado do lead; ', '2019-07-10 14:00:53'),
(97, 19, 'Lucas alterou os seguintes dados de EMC Empreendimentos: Dado do lead; ', '2019-07-10 14:01:17'),
(98, 19, 'Lucas alterou os seguintes dados de EMC Empreendimentos: Dado do lead; ', '2019-07-10 14:04:17'),
(99, 19, 'Lucas alterou os seguintes dados de EMC Empreendimentos: Dado do lead; ', '2019-07-10 14:08:59'),
(100, 21, 'Lucas criou o lead Condomínio verdant Valley', '2019-07-10 15:05:49'),
(101, 22, 'Lucas criou o lead Condimínio verdant Valley (Area Externa)', '2019-07-10 15:08:40'),
(102, 21, 'Lucas alterou os seguintes dados de Condomínio verdant Valley: Potência nominal; ', '2019-07-10 15:09:59'),
(103, 23, 'Lucas criou o lead Fernando Zanandrea', '2019-07-10 17:20:31'),
(104, 22, 'Lucas moveu Condimínio verdant Valley (Area Externa) para perdidos', '2019-07-12 11:06:16'),
(105, 21, 'Lucas alterou os seguintes dados de Condomínio verdant Valley: Valor da proposta; Potência nominal; ', '2019-07-12 11:07:48'),
(106, 21, 'Lucas moveu Condomínio verdant Valley para Proposta Enviada', '2019-07-12 11:11:50'),
(107, 23, 'Lucas moveu Fernando Zanandrea para Proposta Enviada', '2019-07-12 11:14:15'),
(108, 24, 'Lucas criou o lead Pousada Vidinha Bela', '2019-07-17 10:49:15'),
(109, 1, 'Lucas moveu Shopping OI - Contagem para Proposta Enviada', '2019-07-19 13:54:09'),
(110, 18, 'Lucas moveu Maria Aurea para Execução', '2019-07-30 09:58:13'),
(111, 24, 'Thiago moveu Pousada Vidinha Bela para Coluna temporária para zerar status das propostas', '2019-08-07 10:18:11'),
(112, 24, 'Thiago moveu Pousada Vidinha Bela para Elaboração de Propostas', '2019-08-07 10:18:19'),
(113, 1, 'Thiago moveu Shopping OI - Contagem para Coluna temporária para zerar status das propostas', '2019-08-07 10:18:32'),
(114, 23, 'Thiago moveu Fernando Zanandrea para Coluna temporária para zerar status das propostas', '2019-08-07 10:18:34'),
(115, 20, 'Thiago moveu Centro Espirita Joaquim  para Coluna temporária para zerar status das propostas', '2019-08-07 10:18:35'),
(116, 21, 'Thiago moveu Condomínio verdant Valley para Coluna temporária para zerar status das propostas', '2019-08-07 10:18:37'),
(117, 19, 'Thiago moveu EMC Empreendimentos para Coluna temporária para zerar status das propostas', '2019-08-07 10:18:39'),
(118, 15, 'Thiago moveu Assessa para Coluna temporária para zerar status das propostas', '2019-08-07 10:18:42'),
(119, 1, 'Thiago moveu Shopping OI - Contagem para Proposta Enviada', '2019-08-07 10:18:44'),
(120, 23, 'Thiago moveu Fernando Zanandrea para Proposta Enviada', '2019-08-07 10:18:45'),
(121, 20, 'Thiago moveu Centro Espirita Joaquim  para Proposta Enviada', '2019-08-07 10:18:47'),
(122, 19, 'Thiago moveu EMC Empreendimentos para Proposta Enviada', '2019-08-07 10:18:48'),
(123, 21, 'Thiago moveu Condomínio verdant Valley para Proposta Enviada', '2019-08-07 10:18:50'),
(124, 15, 'Thiago moveu Assessa para Proposta Enviada', '2019-08-07 10:18:51'),
(125, 11, 'Thiago moveu Maria Geralda Pinho para Coluna temporária para zerar status das propostas', '2019-08-07 10:19:01'),
(126, 13, 'Thiago moveu Above Coffees para Coluna temporária para zerar status das propostas', '2019-08-07 10:19:02'),
(127, 9, 'Thiago moveu Patrus Transportes  para Coluna temporária para zerar status das propostas', '2019-08-07 10:19:03'),
(128, 11, 'Thiago moveu Maria Geralda Pinho para Follow up', '2019-08-07 10:19:04'),
(129, 13, 'Thiago moveu Above Coffees para Follow up', '2019-08-07 10:19:05'),
(130, 9, 'Thiago moveu Patrus Transportes  para Follow up', '2019-08-07 10:19:06'),
(131, 2, 'Thiago moveu Auto Peças Rei para Coluna temporária para zerar status das propostas', '2019-08-07 10:19:18'),
(132, 4, 'Thiago moveu Supermercado Stella para Coluna temporária para zerar status das propostas', '2019-08-07 10:19:19'),
(133, 6, 'Thiago moveu Associação Residencial Gran Park para Coluna temporária para zerar status das propostas', '2019-08-07 10:19:20'),
(134, 2, 'Thiago moveu Auto Peças Rei para Follow up 2', '2019-08-07 10:19:21'),
(135, 4, 'Thiago moveu Supermercado Stella para Follow up 2', '2019-08-07 10:19:22'),
(136, 6, 'Thiago moveu Associação Residencial Gran Park para Follow up 2', '2019-08-07 10:19:23'),
(137, 7, 'Thiago moveu Robson Antonio  para Coluna temporária para zerar status das propostas', '2019-08-07 10:20:05'),
(138, 17, 'Thiago moveu Luiz Roberto para Coluna temporária para zerar status das propostas', '2019-08-07 10:20:06'),
(139, 7, 'Thiago moveu Robson Antonio  para Parecer de Acesso e pgto da 1a parcela', '2019-08-07 10:20:07'),
(140, 17, 'Thiago moveu Luiz Roberto para Parecer de Acesso e pgto da 1a parcela', '2019-08-07 10:20:08'),
(141, 8, 'Thiago moveu Renato Sanches Rodrigues  para Coluna temporária para zerar status das propostas', '2019-08-07 10:20:16'),
(142, 18, 'Thiago moveu Maria Aurea para Coluna temporária para zerar status das propostas', '2019-08-07 10:20:17'),
(143, 8, 'Thiago moveu Renato Sanches Rodrigues  para Execução', '2019-08-07 10:20:18'),
(144, 18, 'Thiago moveu Maria Aurea para Execução', '2019-08-07 10:20:19'),
(145, 24, 'José moveu Pousada Vidinha Bela para perdidos', '2019-08-12 14:50:42'),
(146, 21, 'José alterou os seguintes dados de Condomínio verdant Valley: Cliente; Responsável pelo lead; ', '2019-08-12 14:54:28'),
(147, 15, 'José moveu Assessa para Follow up', '2019-08-12 14:55:23'),
(148, 21, 'José moveu Condomínio Verdant Valley para Follow up', '2019-08-12 14:55:46'),
(149, 20, 'José moveu Centro Espirita Joaquim  para Follow up', '2019-08-12 14:56:10'),
(150, 23, 'José moveu Fernando Zanandrea para Follow up', '2019-08-12 14:56:37'),
(151, 19, 'José moveu EMC Empreendimentos para Follow up', '2019-08-12 14:57:38'),
(152, 1, 'José moveu Shopping OI - Contagem para Follow up', '2019-08-12 14:58:03'),
(153, 1, 'José alterou os seguintes dados de Shopping OI - Contagem: Dados de endereço; Responsável pelo lead; ', '2019-08-12 14:59:33'),
(154, 9, 'José moveu Patrus Transportes  para Revisão de Proposta', '2019-08-12 15:00:43'),
(155, 9, 'José moveu Patrus Transportes  para Follow up', '2019-08-12 15:00:46'),
(156, 23, 'José moveu Fernando Zanandrea para Follow up', '2019-08-12 15:11:07'),
(157, 13, 'José moveu Above Coffees para Follow up', '2019-08-12 15:11:18'),
(158, 13, 'José moveu Above Coffees para Follow up', '2019-08-12 15:11:21'),
(159, 13, 'José moveu Above Coffees para Follow up', '2019-08-12 15:11:23'),
(160, 13, 'José moveu Above Coffees para Follow up', '2019-08-12 15:11:27'),
(161, 23, 'José alterou os seguintes dados de Fernando Zanandrea: Dados de endereço; Responsável pelo lead; ', '2019-08-12 15:11:58'),
(162, 23, 'José alterou os seguintes dados de Fernando Zanandrea: Dados de endereço; ', '2019-08-12 15:12:15'),
(163, 23, 'José moveu Fernando Zanandrea para Follow up', '2019-08-12 15:12:24'),
(164, 19, 'José moveu EMC Empreendimentos para Follow up', '2019-08-12 15:12:32'),
(165, 6, 'José moveu Associação Residencial Gran Park para Follow up 2', '2019-08-12 15:16:28'),
(166, 7, 'José moveu Robson Antonio  para Execução', '2019-08-12 15:16:56'),
(167, 17, 'José alterou os seguintes dados de Luiz Roberto: Dados de endereço; Responsável pelo lead; ', '2019-08-12 15:17:19'),
(168, 17, 'José moveu Luiz Roberto para Execução', '2019-08-12 15:17:43'),
(169, 18, 'José alterou os seguintes dados de Maria Aurea: Cliente; Responsável pelo lead; ', '2019-08-12 15:18:24'),
(170, 7, 'José alterou os seguintes dados de Robson Antonio : Cliente; Responsável pelo lead; ', '2019-08-12 15:20:16'),
(171, 25, 'José criou o lead Gizela Abras', '2019-08-12 15:23:22'),
(172, 13, 'José alterou os seguintes dados de Above Coffees: Dado do lead; Responsável pelo lead; ', '2019-08-12 15:24:16'),
(173, 1, 'José alterou os seguintes dados de Shopping Oi - Contagem: Dado do lead; ', '2019-08-12 15:24:47'),
(174, 23, 'José alterou os seguintes dados de Fernando Zanandrea: Dado do lead; ', '2019-08-12 15:25:28'),
(175, 23, 'José alterou os seguintes dados de Fernando Zanandrea: Dado do lead; ', '2019-08-12 15:25:40'),
(176, 20, 'José alterou os seguintes dados de Centro Espirita Joaquim : Dado do lead; Responsável pelo lead; ', '2019-08-12 15:26:00'),
(177, 15, 'José alterou os seguintes dados de Assessa: Dado do lead; Responsável pelo lead; ', '2019-08-12 15:26:16'),
(178, 21, 'José alterou os seguintes dados de Condomínio Verdant Valley: Dado do lead; ', '2019-08-12 15:26:31'),
(179, 11, 'José alterou os seguintes dados de Maria Geralda Pinho: Dado do lead; Responsável pelo lead; ', '2019-08-12 15:27:12'),
(180, 9, 'José alterou os seguintes dados de Patrus Transportes : Dado do lead; Responsável pelo lead; ', '2019-08-12 15:27:40'),
(181, 6, 'José alterou os seguintes dados de Associação Residencial Gran Park: Dado do lead; Responsável pelo lead; ', '2019-08-12 15:28:07'),
(182, 2, 'José alterou os seguintes dados de Auto Peças Rei: Dado do lead; Responsável pelo lead; ', '2019-08-12 15:28:40'),
(183, 4, 'José alterou os seguintes dados de Supermercado Stella: Dado do lead; Responsável pelo lead; ', '2019-08-12 15:28:55'),
(184, 17, 'José alterou os seguintes dados de Luiz Roberto Andrade: Dado do lead; ', '2019-08-12 15:29:17'),
(185, 7, 'José alterou os seguintes dados de Robson Antônio Proença: Dado do lead; ', '2019-08-12 15:29:35'),
(186, 8, 'José alterou os seguintes dados de Renato Sanches Rodrigues : Dado do lead; Responsável pelo lead; ', '2019-08-12 15:29:52'),
(187, 18, 'José alterou os seguintes dados de Maria Áurea Faria: Dado do lead; ', '2019-08-12 15:30:16'),
(188, 19, 'José alterou os seguintes dados de EMC Empreendimentos: Cliente; Responsável pelo lead; ', '2019-08-12 15:48:17'),
(189, 23, 'José moveu Fernando Zanandrea para Revisão de Proposta', '2019-08-15 17:07:04'),
(190, 26, 'José criou o lead José Roberto Salgado', '2019-08-15 17:12:45'),
(191, 26, 'José moveu José Roberto Salgado para Proposta Enviada', '2019-08-15 17:12:56'),
(192, 27, 'José criou o lead Lacca', '2019-08-15 17:14:56'),
(193, 27, 'José moveu Lacca para Revisão de Proposta', '2019-08-15 17:15:19'),
(194, 28, 'José criou o lead Churrascaria Vamo', '2019-08-15 17:21:39'),
(195, 23, 'José moveu Fernando Zanandrea para Negociação', '2019-08-15 17:31:36'),
(196, 29, 'José criou o lead Farma', '2019-08-15 17:33:29'),
(197, 30, 'Vinícius criou o lead MRV Joanápolis', '2019-10-16 11:33:16'),
(198, 30, 'Vinícius moveu MRV Joanápolis para Proposta Enviada', '2019-10-16 11:33:27'),
(199, 25, 'Thiago moveu Gizela Abras para Elaboração de Propostas', '2019-10-18 12:20:04'),
(200, 25, 'José moveu Gizela Abras para perdidos', '2019-10-21 18:47:37'),
(201, 31, 'José criou o lead Alnutri', '2019-10-21 18:50:19'),
(202, 26, 'José moveu José Roberto Salgado para Follow up', '2019-10-21 18:52:28'),
(203, 28, 'José moveu Churrascaria Vamo para Proposta Enviada', '2019-10-21 18:53:23'),
(204, 29, 'José moveu Farma para Proposta Enviada', '2019-10-21 18:53:50'),
(205, 13, 'José moveu Above Coffees para Follow up', '2019-10-21 18:55:34'),
(206, 13, 'José moveu Above Coffees para Follow up 2', '2019-10-21 18:55:38'),
(207, 19, 'José moveu EMC Empreendimentos para Negociação', '2019-10-21 18:56:29'),
(208, 1, 'José moveu Shopping Oi - Contagem para Follow up 2', '2019-10-21 18:57:48'),
(209, 20, 'José moveu Centro Espirita Joaquim  para Revisão de Proposta', '2019-10-21 18:58:34'),
(210, 20, 'José moveu Centro Espirita Joaquim  para Follow up 2', '2019-10-21 18:58:38'),
(211, 15, 'José moveu Assessa para Follow up 2', '2019-10-21 18:59:02'),
(212, 21, 'José moveu Condomínio Verdant Valley para Revisão de Proposta', '2019-10-21 18:59:20'),
(213, 21, 'José moveu Condomínio Verdant Valley para Follow up 2', '2019-10-21 18:59:21'),
(214, 26, 'José moveu José Roberto Salgado para perdidos', '2019-10-21 19:01:56'),
(215, 9, 'José moveu Patrus Transportes  para perdidos', '2019-10-21 19:02:13'),
(216, 11, 'José moveu Maria Geralda Pinho para perdidos', '2019-10-21 19:02:19'),
(217, 27, 'José moveu Lacca para perdidos', '2019-10-21 19:12:14'),
(218, 23, 'José moveu Fernando Zanandrea para perdidos', '2019-10-21 19:12:18'),
(219, 28, 'José moveu Churrascaria Vamo para Follow up', '2019-10-21 19:12:41'),
(220, 1, 'José moveu Shopping Oi - Contagem para Negociação', '2019-10-21 19:16:58'),
(221, 1, 'José moveu Shopping Oi - Contagem para Follow up 2', '2019-10-21 19:17:06'),
(222, 21, 'José moveu Condomínio Verdant Valley para Revisão de Proposta', '2019-10-21 19:20:03'),
(223, 15, 'José moveu Assessa para Revisão de Proposta', '2019-10-21 19:20:08'),
(224, 20, 'José moveu Centro Espirita Joaquim  para Revisão de Proposta', '2019-10-21 19:20:15'),
(225, 18, 'José moveu Maria Áurea Faria para perdidos', '2019-10-21 19:20:50'),
(226, 17, 'José moveu Luiz Roberto Andrade para perdidos', '2019-10-21 19:20:57'),
(227, 18, 'José moveu Maria Áurea Faria para perdidos', '2019-10-21 19:21:08'),
(228, 17, 'José moveu Luiz Roberto Andrade para perdidos', '2019-10-21 19:21:12'),
(229, 18, 'José moveu Maria Áurea Faria para perdidos', '2019-10-21 19:22:47'),
(230, 17, 'José moveu Luiz Roberto Andrade para perdidos', '2019-10-21 19:22:53');

-- --------------------------------------------------------

--
-- Estrutura para tabela `lead_status`
--

CREATE TABLE `lead_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `order` float DEFAULT 0,
  `offset` bigint(200) DEFAULT 0,
  `limit` bigint(200) DEFAULT 50,
  `color` varchar(100) DEFAULT '#5071ab',
  `duration` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `lead_status`
--

INSERT INTO `lead_status` (`id`, `name`, `description`, `order`, `offset`, `limit`, `color`, `duration`) VALUES
(1, 'Elaboração de Propostas', '', 1, 0, 50, '#1261cb', 3),
(2, 'Proposta Enviada', '', 2, 0, 50, '#1261cb', 3),
(3, 'Follow up', '', 3, 0, 50, '#1261cb', 15),
(4, 'Revisão de Proposta', '', 4, 0, 50, '#1261cb', 3),
(5, 'Follow up 2', '', 5, 0, 50, '#1261cb', 25),
(6, 'Negociação', '', 6, 0, 50, '#1261cb', 10),
(7, 'Contrato com pgto do sinal ', '', 7, 0, 50, '#1261cb', 5),
(8, 'Parecer de Acesso e pgto da 1a parcela', '', 8, 0, 50, '#1261cb', 30),
(9, 'Execução', '', 9, 0, 50, '#1261cb', 45);

-- --------------------------------------------------------

--
-- Estrutura para tabela `lead_status_receiver`
--

CREATE TABLE `lead_status_receiver` (
  `id` int(10) NOT NULL,
  `lead_status_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `lead_status_receiver`
--

INSERT INTO `lead_status_receiver` (`id`, `lead_status_id`, `user_id`) VALUES
(1, 1, 7),
(2, 1, 8),
(11, 6, 4),
(14, 7, 4),
(15, 7, 6),
(16, 7, 7),
(17, 7, 8),
(18, 8, 4),
(19, 8, 6),
(22, 9, 4),
(23, 9, 6),
(27, 7, 5),
(28, 8, 3),
(29, 9, 3),
(30, 9, 5),
(31, 7, 3),
(32, 8, 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `lead_warning_user`
--

CREATE TABLE `lead_warning_user` (
  `id` int(10) NOT NULL,
  `lead_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `lead_warning_user`
--

INSERT INTO `lead_warning_user` (`id`, `lead_id`, `user_id`) VALUES
(1, 5, 4),
(2, NULL, 10),
(4, NULL, 10),
(5, 19, 10),
(7, NULL, 10),
(8, NULL, 10),
(9, NULL, 10),
(10, NULL, 10);

-- --------------------------------------------------------

--
-- Estrutura para tabela `module`
--

CREATE TABLE `module` (
  `id` int(10) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `link` varchar(250) DEFAULT NULL,
  `type` varchar(250) DEFAULT NULL,
  `icon` varchar(150) DEFAULT NULL,
  `sort` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `module`
--

INSERT INTO `module` (`id`, `name`, `link`, `type`, `icon`, `sort`) VALUES
(1, 'Dashboard', 'dashboard', 'main', 'icon dripicons-meter', 1),
(2, 'Messages', 'messages', 'main', 'icon dripicons-message', 2),
(3, 'Projects', 'projects', 'main', 'icon dripicons-briefcase', 3),
(4, 'Clients', 'clients', 'main', 'icon dripicons-user', 4),
(9, 'Settings', 'settings', 'main', 'icon dripicons-gear', 20),
(10, 'QuickAccess', 'quickaccess', 'widget', '', 50),
(11, 'User Online', 'useronline', 'widget', '', 51),
(20, 'Calendar', 'calendar', 'main', 'icon dripicons-calendar', 8),
(34, 'Parameterization', 'parameterization', 'main', 'icon dripicons-list', 5),
(101, 'Projects', 'cprojects', 'client', 'icon dripicons-briefcase', 2),
(103, 'Messages', 'cmessages', 'client', 'icon dripicons-message', 1),
(105, 'Tickets', 'tickets', 'main', 'icon dripicons-ticket', 8),
(106, 'Tickets', 'ctickets', 'client', 'icon dripicons-ticket', 4),
(108, 'Leads', 'leads', 'main', 'icon dripicons-experiment', 4),
(109, 'Terrains', 'terrains', 'main', 'icon dripicons-store', 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `notification`
--

CREATE TABLE `notification` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` varchar(50) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  `status` enum('new','read') DEFAULT 'new'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `notification`
--

INSERT INTO `notification` (`id`, `user_id`, `message`, `created_at`, `url`, `status`) VALUES
(1, 1, '<p><b>Thiago</b> atribuiu uma tarefa a você. </p>[[UFV 132] - Amanda FSL]', '2019-02-07 22:31:49', 'http://www.ownergy.com.br/zenit/projects/view/2', 'read'),
(2, 1, '<p><b>Thiago</b> atribuiu uma tarefa a você. </p>[[UFV 132] - Amanda FSL]', '2019-02-07 22:31:49', 'http://www.ownergy.com.br/zenit/projects/view/2', 'read'),
(3, 1, '<p><b>Thiago</b> atribuiu uma tarefa a você. </p>[[UFV 132] - Amanda FSL]', '2019-02-07 22:31:49', 'http://www.ownergy.com.br/zenit/projects/view/2', 'read'),
(4, 1, '<p><b>Thiago</b> atribuiu uma tarefa a você. </p>[[UFV 132] - Amanda FSL]', '2019-02-07 22:31:49', 'http://www.ownergy.com.br/zenit/projects/view/2', 'read'),
(5, 1, '<p><b>Thiago</b> atribuiu uma tarefa a você. </p>[[UFV 132] - Amanda FSL]', '2019-02-09 06:26:27', 'https://www.ownergy.com.br/zenit/projects/view/2', 'read'),
(6, 1, '<p>Um projeto foi atribuído a você.</p>[Projeto base]', '2019-02-12 06:41:22', 'http://www.ownergy.com.br/zenit/projects/view/1', 'read'),
(7, 2, '<p>Um projeto foi atribuído a você.</p>[Projeto base]', '2019-02-12 06:41:22', 'http://www.ownergy.com.br/zenit/projects/view/1', 'new'),
(8, 4, '<p>Um projeto foi atribuído a você.</p>[Projeto base]', '2019-02-12 06:41:22', 'http://www.ownergy.com.br/zenit/projects/view/1', 'new'),
(9, 5, '<p>Um projeto foi atribuído a você.</p>[Projeto base]', '2019-02-12 06:41:22', 'http://www.ownergy.com.br/zenit/projects/view/1', 'read'),
(10, 6, '<p>Um projeto foi atribuído a você.</p>[Projeto base]', '2019-02-12 06:41:22', 'http://www.ownergy.com.br/zenit/projects/view/1', 'read'),
(11, 7, '<p>Um projeto foi atribuído a você.</p>[Projeto base]', '2019-02-12 06:41:22', 'http://www.ownergy.com.br/zenit/projects/view/1', 'read'),
(12, 8, '<p>Um projeto foi atribuído a você.</p>[Projeto base]', '2019-02-12 06:41:22', 'http://www.ownergy.com.br/zenit/projects/view/1', 'read'),
(13, 3, '<p><b>Patrick</b> efetuou uma alteração em um ticket atribuído à você. </p>[Projeto base]', '2019-02-12 07:00:15', 'http://www.ownergy.com.br/zenit/projects/view/1', 'read'),
(14, 3, '<p><b>Patrick</b> atribuiu uma tarefa a você. </p>[Projeto base]', '2019-02-12 07:36:17', 'http://www.ownergy.com.br/zenit/projects/view/1', 'read'),
(15, 1, '<p><b>Patrick</b> atribuiu uma tarefa a você. </p>[Projeto base]', '2019-02-12 07:36:35', 'http://www.ownergy.com.br/zenit/projects/view/1', 'read'),
(16, 4, '<p><b>Patrick</b> atribuiu uma tarefa a você. </p>[Projeto base]', '2019-02-12 07:36:51', 'http://www.ownergy.com.br/zenit/projects/view/1', 'new'),
(17, 1, '<b>Bernardo</b> moveu <b>Lead Teste 1</b> para <b>Estágio 1</b>', '2019-03-13 10:11:06', NULL, 'read'),
(18, 7, '<b>Bernardo</b> moveu <b>Lead Teste 1</b> para <b>Estágio 1</b>', '2019-03-13 10:11:06', NULL, 'read'),
(19, 8, '<b>Bernardo</b> moveu <b>Lead Teste 1</b> para <b>Estágio 1</b>', '2019-03-13 10:11:06', NULL, 'read'),
(20, 3, '<b>Thiago</b> moveu <b>Lead Teste 1</b> para <b>Estagio 2</b>', '2019-03-14 14:34:42', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(21, 1, '<b>Thiago</b> moveu <b>Lead Teste 1</b> para <b>Estagio 2</b>', '2019-03-14 14:34:42', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(22, 5, '<b>Thiago</b> moveu <b>Lead Teste 1</b> para <b>Feedback 1</b>', '2019-03-18 17:09:14', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(23, 3, '<b>[Lembrete]</b> - lembrar Alan de Comer Menos', '2019-03-19 09:27:06', 'https://www.ownergy.com.br/zenit/', 'read'),
(24, 1, '<b>[Lembrete]</b> - Teste push cronjob', '2019-03-19 09:37:04', 'https://www.ownergy.com.br/zenit/', 'read'),
(25, 1, '<b>[Lembrete]</b> - 2o Test push cronjob', '2019-03-19 09:42:04', 'https://www.ownergy.com.br/zenit/', 'read'),
(26, 5, '<b>[Lembrete]</b> - Teste push cronjob', '2019-03-19 09:45:03', 'https://www.ownergy.com.br/zenit/', 'read'),
(27, 5, '<b>[Lembrete]</b> - Teste push cronjob', '2019-03-19 09:46:03', 'https://www.ownergy.com.br/zenit/', 'read'),
(28, 1, '<b>[Lembrete]</b> - Teste push cronjob', '2019-03-19 10:23:03', 'https://www.ownergy.com.br/zenit/', 'read'),
(29, 1, '<b>[Lembrete]</b> - Teste push cronjob', '2019-03-19 10:24:04', 'https://www.ownergy.com.br/zenit/', 'read'),
(30, 1, '<b>Thiago</b> moveu <b>Lead Teste 1</b> para <b>Feedback 1</b>', '2019-03-19 17:24:21', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(31, 1, '<b>Thiago</b> moveu <b>Lead Teste 1</b> para <b>Feedback 1</b>', '2019-03-19 17:25:20', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(32, 1, '<b>Thiago</b> moveu <b>Lead Teste 1</b> para <b>Feedback 1</b>', '2019-03-19 17:25:59', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(33, 1, '<p><b>Thiago</b> concluiu a tarefa  <b>Confirmar Previsão da Data de Entrega</b> e você já pode iniciar a tarefa <b>Confirmar Qualidade e Quantidade</b> </p>[Projeto base]', '2019-03-25 11:06:51', 'https://www.ownergy.com.br/zenit/projects/view/1', 'read'),
(34, 3, '<p><b>Patrick</b> concluiu a tarefa  <b>Negociar Preço e Forma de Pagamento com WEG</b> e você já pode iniciar a tarefa <b>Confirmar Data da Coleta</b> </p>[Projeto base]', '2019-03-26 10:29:19', 'http://www.ownergy.com.br/zenit/projects/view/1', 'read'),
(35, 1, '<b>José</b> moveu <b>Lead Teste 2</b> para <b>Elaboração de proposta</b>', '2019-03-26 11:34:45', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(36, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Elaboração de proposta</b>', '2019-03-26 12:17:11', 'https://ownergy.com.br/zenit/leads/', 'read'),
(37, 1, '<b>Thiago</b> moveu <b>Lead Teste 1</b> para <b>Feedback 1</b>', '2019-03-26 12:49:42', 'https://ownergy.com.br/zenit/leads/', 'read'),
(38, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-03-26 12:57:58', 'https://ownergy.com.br/zenit/leads/', 'read'),
(39, 7, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-03-26 12:57:58', 'https://ownergy.com.br/zenit/leads/', 'read'),
(40, 8, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-03-26 12:57:58', 'https://ownergy.com.br/zenit/leads/', 'read'),
(41, 1, '<p><b>Thiago</b> concluiu a tarefa  <b>Confirmar Previsão da Data de Entrega</b> e você já pode iniciar a tarefa <b>Confirmar Qualidade e Quantidade</b> </p>[Projeto base]', '2019-03-27 17:25:52', 'https://www.ownergy.com.br/zenit/projects/view/1', 'read'),
(42, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-01 15:34:18', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(43, 7, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-01 15:34:18', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(44, 8, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-01 15:34:18', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(45, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-03 11:45:57', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(46, 7, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-03 11:45:57', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(47, 8, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-03 11:45:57', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(48, 1, '<b>Thiago</b> moveu <b>Lead Teste 1</b> para <b>Feedback 1</b>', '2019-04-03 11:46:11', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(49, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-05 11:05:09', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(50, 7, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-05 11:05:09', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(51, 8, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-05 11:05:09', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(52, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Backlog</b>', '2019-04-05 11:05:50', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(53, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Elaboração de proposta</b>', '2019-04-05 11:06:44', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(54, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Backlog</b>', '2019-04-05 11:07:01', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(55, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Backlog</b>', '2019-04-05 11:07:25', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(56, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-05 11:23:45', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(57, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-05 11:23:45', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(58, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Backlog</b>', '2019-04-05 11:32:05', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(59, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-05 11:34:49', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(60, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-05 11:36:03', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(61, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-05 11:37:08', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(62, 8, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-05 11:38:17', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(63, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-05 12:09:13', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(64, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Elaboração de proposta</b>', '2019-04-05 12:09:43', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(65, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-05 12:10:17', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(66, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-05 12:10:17', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(67, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-05 13:50:49', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(68, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-05 13:51:15', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(69, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-05 13:52:02', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(70, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-05 13:57:55', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(71, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-05 14:17:40', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(72, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-05 14:18:02', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(73, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-05 14:18:44', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(74, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Elaboração de proposta</b>', '2019-04-05 14:19:53', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(75, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Backlog</b>', '2019-04-05 14:20:23', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(76, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Elaboração de proposta</b>', '2019-04-05 14:21:09', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(77, 1, '<b>[Atenção ao Lead]</b> - Thiago chamou sua atenção para o Lead Lead Teste 2', '2019-04-09 10:48:14', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(78, 8, '<b>[Atenção ao Lead]</b> - Thiago chamou sua atenção para o Lead Lead Teste 2', '2019-04-09 10:48:14', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(79, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-13 14:37:52', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(80, 1, '<b>Thiago</b> moveu <b>Lead Teste 2</b> para <b>Estágio 1</b>', '2019-04-13 14:37:53', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(81, 5, '<b>Bernardo</b> moveu <b>AUTO PEÇAS REI</b> para <b>Follow up 2</b>', '2019-04-16 11:24:51', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(82, 8, '<b>Bernardo</b> moveu <b>AUTO PEÇAS REI</b> para <b>Follow up 2</b>', '2019-04-16 11:24:51', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(83, 8, '<b>Bernardo</b> moveu <b>Associação Residencial Gran Park</b> para <b>Follow up 2</b>', '2019-04-16 16:22:30', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(84, 7, '<b>Bernardo</b> moveu <b>Associação Residencial Gran Park</b> para <b>Follow up 2</b>', '2019-04-16 16:22:30', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(85, 7, '<b>Bernardo</b> moveu <b>PATRUS TRANSPORTES</b> para <b>Proposta Enviada</b>', '2019-04-25 16:55:08', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(86, 8, '<b>Bernardo</b> moveu <b>PATRUS TRANSPORTES</b> para <b>Proposta Enviada</b>', '2019-04-25 16:55:09', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(87, 7, '<b>José</b> moveu <b>Elias Donato </b> para <b>Proposta Enviada</b>', '2019-04-29 09:40:46', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(88, 8, '<b>José</b> moveu <b>Elias Donato </b> para <b>Proposta Enviada</b>', '2019-04-29 09:40:46', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(89, 7, '<b>José</b> moveu <b>Hotel Verde Mar</b> para <b>Follow up</b>', '2019-04-29 09:45:51', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(90, 8, '<b>José</b> moveu <b>Hotel Verde Mar</b> para <b>Follow up</b>', '2019-04-29 09:45:51', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(91, 1, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:51:48', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(92, 8, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:51:48', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(93, 7, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:51:48', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(94, 4, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:51:48', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(95, 6, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:51:48', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(96, 5, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:51:48', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(97, 3, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:51:48', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(98, 1, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:51:51', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(99, 8, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:51:51', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(100, 7, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:51:51', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(101, 4, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:51:51', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(102, 6, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:51:51', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(103, 5, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:51:51', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(104, 3, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:51:51', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(105, 1, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:52:12', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(106, 8, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:52:12', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(107, 7, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:52:12', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(108, 4, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:52:12', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(109, 6, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:52:12', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(110, 5, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:52:12', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(111, 3, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:52:12', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(112, 1, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:52:53', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(113, 8, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:52:53', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(114, 7, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:52:53', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(115, 4, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:52:53', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(116, 6, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:52:53', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(117, 5, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:52:53', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(118, 3, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:52:53', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(119, 1, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:53:06', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(120, 8, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:53:06', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(121, 7, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:53:06', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(122, 4, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:53:06', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(123, 6, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:53:06', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(124, 5, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:53:06', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(125, 3, '<b>[Atenção ao Lead]</b> - José chamou sua atenção para o Lead Hotel Verde Mar', '2019-04-29 09:53:06', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(126, 4, '<b>[Lembrete]</b> - Lembrete', '2019-04-29 10:00:09', 'https://www.ownergy.com.br/zenit/', 'new'),
(127, 7, '<b>Bernardo</b> moveu <b>Shopping OI - Contagem</b> para <b>Proposta Enviada</b>', '2019-04-29 10:49:10', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(128, 8, '<b>Bernardo</b> moveu <b>Shopping OI - Contagem</b> para <b>Proposta Enviada</b>', '2019-04-29 10:49:10', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(129, 7, '<b>Bernardo</b> moveu <b>Maria Geralda Pinho</b> para <b>Proposta Enviada</b>', '2019-04-29 16:49:29', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(130, 8, '<b>Bernardo</b> moveu <b>Maria Geralda Pinho</b> para <b>Proposta Enviada</b>', '2019-04-29 16:49:29', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(131, 4, '<b>Andreia</b> moveu <b>Renato Sanches Rodrigues </b> para <b>Fluxo Financeiro</b>', '2019-04-30 14:02:33', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(132, 6, '<b>Andreia</b> moveu <b>Renato Sanches Rodrigues </b> para <b>Fluxo Financeiro</b>', '2019-04-30 14:02:33', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(133, 7, '<b>Andreia</b> moveu <b>Renato Sanches Rodrigues </b> para <b>Fluxo Financeiro</b>', '2019-04-30 14:02:33', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(134, 8, '<b>Andreia</b> moveu <b>Renato Sanches Rodrigues </b> para <b>Fluxo Financeiro</b>', '2019-04-30 14:02:33', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(135, 4, '<b>Andreia</b> moveu <b>Renato Sanches Rodrigues </b> para <b>Fluxo Financeiro</b>', '2019-04-30 16:36:23', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(136, 6, '<b>Andreia</b> moveu <b>Renato Sanches Rodrigues </b> para <b>Fluxo Financeiro</b>', '2019-04-30 16:36:23', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(137, 7, '<b>Andreia</b> moveu <b>Renato Sanches Rodrigues </b> para <b>Fluxo Financeiro</b>', '2019-04-30 16:36:23', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(138, 8, '<b>Andreia</b> moveu <b>Renato Sanches Rodrigues </b> para <b>Fluxo Financeiro</b>', '2019-04-30 16:36:23', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(139, 3, '<b>Andreia</b> moveu <b>Renato Sanches Rodrigues </b> para <b>Fluxo Financeiro</b>', '2019-04-30 16:36:23', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(140, 4, '<b>Bernardo</b> moveu <b>Renato Sanches Rodrigues </b> para <b>Execução</b>', '2019-05-02 14:18:57', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(141, 6, '<b>Bernardo</b> moveu <b>Renato Sanches Rodrigues </b> para <b>Execução</b>', '2019-05-02 14:18:57', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(142, 7, '<b>Bernardo</b> moveu <b>Renato Sanches Rodrigues </b> para <b>Execução</b>', '2019-05-02 14:18:57', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(143, 8, '<b>Bernardo</b> moveu <b>Renato Sanches Rodrigues </b> para <b>Execução</b>', '2019-05-02 14:18:57', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(144, 3, '<b>Bernardo</b> moveu <b>Renato Sanches Rodrigues </b> para <b>Execução</b>', '2019-05-02 14:18:57', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(145, 5, '<b>Bernardo</b> moveu <b>Renato Sanches Rodrigues </b> para <b>Execução</b>', '2019-05-02 14:18:57', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(146, 4, '<b>Bernardo</b> moveu <b>Robson Antonio </b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-05-02 14:19:00', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(147, 6, '<b>Bernardo</b> moveu <b>Robson Antonio </b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-05-02 14:19:00', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(148, 7, '<b>Bernardo</b> moveu <b>Robson Antonio </b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-05-02 14:19:00', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(149, 8, '<b>Bernardo</b> moveu <b>Robson Antonio </b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-05-02 14:19:00', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(150, 3, '<b>Bernardo</b> moveu <b>Robson Antonio </b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-05-02 14:19:00', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(151, 5, '<b>Bernardo</b> moveu <b>Robson Antonio </b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-05-02 14:19:00', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(152, 7, '<b>Andreia</b> moveu <b>Clínica Uromaster</b> para <b>Proposta Enviada</b>', '2019-05-03 11:56:05', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(153, 8, '<b>Andreia</b> moveu <b>Clínica Uromaster</b> para <b>Proposta Enviada</b>', '2019-05-03 11:56:05', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(154, 7, '<b>Bernardo</b> moveu <b>Shopping OI - Contagem</b> para <b>Elaboração de Propostas</b>', '2019-05-08 16:28:25', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(155, 8, '<b>Bernardo</b> moveu <b>Shopping OI - Contagem</b> para <b>Elaboração de Propostas</b>', '2019-05-08 16:28:25', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(156, 7, '<b>Bernardo</b> moveu <b>Patrus Transportes </b> para <b>Follow up</b>', '2019-05-10 08:38:56', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(157, 8, '<b>Bernardo</b> moveu <b>Patrus Transportes </b> para <b>Follow up</b>', '2019-05-10 08:38:56', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(158, 7, '<b>Bernardo</b> moveu <b>Clínica Uromaster</b> para <b>Follow up</b>', '2019-05-10 11:23:44', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(159, 8, '<b>Bernardo</b> moveu <b>Clínica Uromaster</b> para <b>Follow up</b>', '2019-05-10 11:23:44', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(160, 4, '<b>[Lembrete]</b> - Retornar contato com Lessandro', '2019-05-27 12:00:06', 'https://www.ownergy.com.br/zenit/', 'new'),
(161, 7, '<b>Marlem</b> moveu <b>Maria Geralda Pinho</b> para <b>Follow up</b>', '2019-05-28 14:10:59', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(162, 8, '<b>Marlem</b> moveu <b>Maria Geralda Pinho</b> para <b>Follow up</b>', '2019-05-28 14:10:59', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(163, 4, '<b>Marlem</b> moveu <b>Robson Antonio </b> para <b>Execução</b>', '2019-05-31 12:22:14', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(164, 6, '<b>Marlem</b> moveu <b>Robson Antonio </b> para <b>Execução</b>', '2019-05-31 12:22:14', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(165, 7, '<b>Marlem</b> moveu <b>Robson Antonio </b> para <b>Execução</b>', '2019-05-31 12:22:14', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(166, 8, '<b>Marlem</b> moveu <b>Robson Antonio </b> para <b>Execução</b>', '2019-05-31 12:22:14', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(167, 3, '<b>Marlem</b> moveu <b>Robson Antonio </b> para <b>Execução</b>', '2019-05-31 12:22:14', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(168, 5, '<b>Marlem</b> moveu <b>Robson Antonio </b> para <b>Execução</b>', '2019-05-31 12:22:14', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(169, 7, '<b>Marlem</b> moveu <b>Shopping OI - Contagem</b> para <b>Proposta Enviada</b>', '2019-06-06 16:48:46', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(170, 8, '<b>Marlem</b> moveu <b>Shopping OI - Contagem</b> para <b>Proposta Enviada</b>', '2019-06-06 16:48:46', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(171, 4, '<b>Marlem</b> moveu <b>Supermercado Stella</b> para <b>Negociação</b>', '2019-06-06 16:48:55', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(172, 7, '<b>Marlem</b> moveu <b>Supermercado Stella</b> para <b>Negociação</b>', '2019-06-06 16:48:55', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(173, 8, '<b>Marlem</b> moveu <b>Supermercado Stella</b> para <b>Negociação</b>', '2019-06-06 16:48:55', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(174, 8, '<b>Marlem</b> moveu <b>Supermercado Stella</b> para <b>Follow up 2</b>', '2019-06-06 16:49:03', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(175, 7, '<b>Marlem</b> moveu <b>Supermercado Stella</b> para <b>Follow up 2</b>', '2019-06-06 16:49:03', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(176, 7, '<b>Marlem</b> moveu <b>Shopping OI - Contagem</b> para <b>Elaboração de Propostas</b>', '2019-06-06 16:49:05', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(177, 8, '<b>Marlem</b> moveu <b>Shopping OI - Contagem</b> para <b>Elaboração de Propostas</b>', '2019-06-06 16:49:05', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(178, 7, '<b>Marlem</b> moveu <b>Padaria Vitoria</b> para <b>Proposta Enviada</b>', '2019-06-06 16:56:29', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(179, 8, '<b>Marlem</b> moveu <b>Padaria Vitoria</b> para <b>Proposta Enviada</b>', '2019-06-06 16:56:29', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(180, 7, '<b>Marlem</b> moveu <b>Padaria Vitoria</b> para <b>Follow up</b>', '2019-06-06 16:58:44', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(181, 8, '<b>Marlem</b> moveu <b>Padaria Vitoria</b> para <b>Follow up</b>', '2019-06-06 16:58:44', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(182, 7, '<b>Marlem</b> moveu <b>Padaria Vitoria</b> para <b>Proposta Enviada</b>', '2019-06-06 16:58:52', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(183, 8, '<b>Marlem</b> moveu <b>Padaria Vitoria</b> para <b>Proposta Enviada</b>', '2019-06-06 16:58:52', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(184, 4, '<b>Marlem</b> moveu <b>Auto Peças Rei</b> para <b>Negociação</b>', '2019-06-06 17:16:44', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(185, 7, '<b>Marlem</b> moveu <b>Auto Peças Rei</b> para <b>Negociação</b>', '2019-06-06 17:16:44', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(186, 8, '<b>Marlem</b> moveu <b>Auto Peças Rei</b> para <b>Negociação</b>', '2019-06-06 17:16:44', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(187, 8, '<b>Marlem</b> moveu <b>Auto Peças Rei</b> para <b>Follow up 2</b>', '2019-06-06 17:16:46', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(188, 7, '<b>Marlem</b> moveu <b>Auto Peças Rei</b> para <b>Follow up 2</b>', '2019-06-06 17:16:46', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(189, 0, '<p><b>Alan</b> atribuiu uma tarefa à você. </p>[Projeto base]', '2019-06-07 14:22:07', 'https://ownergy.com.br/zenit/projects/view/1', 'new'),
(190, 0, '<p><b>Alan</b> atribuiu uma tarefa à você. </p>[Projeto base]', '2019-06-07 14:23:25', 'https://ownergy.com.br/zenit/projects/view/1', 'new'),
(191, 0, '<p><b>Alan</b> atribuiu uma tarefa à você. </p>[Projeto base]', '2019-06-07 14:23:50', 'https://ownergy.com.br/zenit/projects/view/1', 'new'),
(192, 0, '<p><b>Alan</b> atribuiu uma tarefa à você. </p>[Projeto base]', '2019-06-07 14:25:08', 'https://ownergy.com.br/zenit/projects/view/1', 'new'),
(193, 7, '<b>Lucas</b> moveu <b>Assessa</b> para <b>Proposta Enviada</b>', '2019-06-26 14:46:07', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(194, 8, '<b>Lucas</b> moveu <b>Assessa</b> para <b>Proposta Enviada</b>', '2019-06-26 14:46:07', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(195, 7, '<b>Lucas</b> moveu <b>Marcus Amaral</b> para <b>Proposta Enviada</b>', '2019-06-26 14:46:10', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(196, 8, '<b>Lucas</b> moveu <b>Marcus Amaral</b> para <b>Proposta Enviada</b>', '2019-06-26 14:46:10', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(197, 1, '<p>Um projeto foi atribuído a você.</p>[Base LED nas Escolas]', '2019-07-04 09:31:18', 'https://www.ownergy.com.br/zenit/projects/view/2', 'read'),
(198, 5, '<p>Um projeto foi atribuído a você.</p>[Base LED nas Escolas]', '2019-07-04 09:31:18', 'https://www.ownergy.com.br/zenit/projects/view/2', 'new'),
(199, 6, '<p>Um projeto foi atribuído a você.</p>[Base LED nas Escolas]', '2019-07-04 09:31:18', 'https://www.ownergy.com.br/zenit/projects/view/2', 'new'),
(200, 3, '<p>Um projeto foi atribuído a você.</p>[Base LED nas Escolas]', '2019-07-04 09:32:14', 'https://www.ownergy.com.br/zenit/projects/view/2', 'read'),
(201, 4, '<b>Lucas</b> moveu <b>Maria Aurea</b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-07-04 09:46:46', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(202, 6, '<b>Lucas</b> moveu <b>Maria Aurea</b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-07-04 09:46:46', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(203, 7, '<b>Lucas</b> moveu <b>Maria Aurea</b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-07-04 09:46:47', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(204, 8, '<b>Lucas</b> moveu <b>Maria Aurea</b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-07-04 09:46:47', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(205, 3, '<b>Lucas</b> moveu <b>Maria Aurea</b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-07-04 09:46:47', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(206, 5, '<b>Lucas</b> moveu <b>Maria Aurea</b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-07-04 09:46:47', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(207, 7, '<b>Lucas</b> moveu <b>Shopping OI - Contagem</b> para <b>Proposta Enviada</b>', '2019-07-04 10:30:09', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(208, 8, '<b>Lucas</b> moveu <b>Shopping OI - Contagem</b> para <b>Proposta Enviada</b>', '2019-07-04 10:30:09', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(209, 7, '<b>Lucas</b> moveu <b>Shopping OI - Contagem</b> para <b>Proposta Enviada</b>', '2019-07-04 10:31:08', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(210, 8, '<b>Lucas</b> moveu <b>Shopping OI - Contagem</b> para <b>Proposta Enviada</b>', '2019-07-04 10:31:08', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(211, 7, '<b>Lucas</b> moveu <b>Above Coffees</b> para <b>Follow up</b>', '2019-07-04 10:36:56', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(212, 8, '<b>Lucas</b> moveu <b>Above Coffees</b> para <b>Follow up</b>', '2019-07-04 10:36:56', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(213, 10, '<b>[Lembrete]</b> - Ligar p/ Maria Geralda', '2019-07-04 11:17:03', 'https://www.ownergy.com.br/zenit/', 'read'),
(214, 4, '<b>Lucas</b> moveu <b>Luiz Roberto</b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-07-04 11:26:29', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(215, 6, '<b>Lucas</b> moveu <b>Luiz Roberto</b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-07-04 11:26:29', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(216, 7, '<b>Lucas</b> moveu <b>Luiz Roberto</b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-07-04 11:26:29', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(217, 8, '<b>Lucas</b> moveu <b>Luiz Roberto</b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-07-04 11:26:29', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(218, 3, '<b>Lucas</b> moveu <b>Luiz Roberto</b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-07-04 11:26:29', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(219, 5, '<b>Lucas</b> moveu <b>Luiz Roberto</b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-07-04 11:26:29', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(220, 4, '<b>Lucas</b> moveu <b>Robson Antonio </b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-07-04 11:28:11', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(221, 6, '<b>Lucas</b> moveu <b>Robson Antonio </b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-07-04 11:28:11', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(222, 7, '<b>Lucas</b> moveu <b>Robson Antonio </b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-07-04 11:28:11', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(223, 8, '<b>Lucas</b> moveu <b>Robson Antonio </b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-07-04 11:28:11', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(224, 3, '<b>Lucas</b> moveu <b>Robson Antonio </b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-07-04 11:28:11', 'http://www.ownergy.com.br/zenit/leads/', 'read'),
(225, 5, '<b>Lucas</b> moveu <b>Robson Antonio </b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-07-04 11:28:11', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(226, 10, '<b>[Lembrete]</b> - Verificar WPP', '2019-07-04 16:00:05', 'https://www.ownergy.com.br/zenit/', 'read'),
(227, 10, '<b>[Lembrete]</b> - Ligar p/ Bruno', '2019-07-05 09:34:04', 'https://www.ownergy.com.br/zenit/', 'read'),
(228, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Solicitação de Acesso</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-05 09:59:49', 'https://www.ownergy.com.br/zenit/projects/view/3', 'new'),
(229, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Julho]', '2019-07-05 09:59:51', 'https://www.ownergy.com.br/zenit/projects/view/3', 'new'),
(230, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-05 09:59:51', 'https://www.ownergy.com.br/zenit/projects/view/3', 'read'),
(231, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Julho]', '2019-07-05 09:59:51', 'https://www.ownergy.com.br/zenit/projects/view/3', 'read'),
(232, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-05 09:59:59', 'https://www.ownergy.com.br/zenit/projects/view/3', 'read'),
(233, 1, '<p>Um projeto foi atribuído a você.</p>[LED nas Escolas - Julho]', '2019-07-05 14:01:28', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(234, 3, '<p>Um projeto foi atribuído a você.</p>[LED nas Escolas - Julho]', '2019-07-05 14:01:28', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(235, 5, '<p>Um projeto foi atribuído a você.</p>[LED nas Escolas - Julho]', '2019-07-05 14:01:28', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(236, 6, '<p>Um projeto foi atribuído a você.</p>[LED nas Escolas - Julho]', '2019-07-05 14:01:28', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(237, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:06:44', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(238, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:06:45', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(239, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:06:45', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(240, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:06:48', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(241, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:06:48', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(242, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:06:49', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(243, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:06:49', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(244, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:06:51', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(245, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:06:51', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(246, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:06:53', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(247, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:06:53', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(248, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:20', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(249, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:20', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(250, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:23', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(251, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:23', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(252, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:24', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(253, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:24', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(254, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:26', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(255, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:26', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(256, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:28', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(257, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:28', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(258, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:30', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(259, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:30', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(260, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:31', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(261, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:31', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(262, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:39', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(263, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:39', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(264, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:39', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(265, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:43', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(266, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:43', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(267, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:43', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(268, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:46', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(269, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:46', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(270, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:46', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(271, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:48', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(272, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:48', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(273, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:48', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(274, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:50', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(275, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:50', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(276, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:50', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(277, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:51', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(278, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:51', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(279, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:51', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(280, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:54', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(281, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:54', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(282, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Julho]', '2019-07-08 11:08:54', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(283, 7, '<b>Lucas</b> moveu <b>EMC Empreendimentos</b> para <b>Proposta Enviada</b>', '2019-07-08 15:10:54', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(284, 8, '<b>Lucas</b> moveu <b>EMC Empreendimentos</b> para <b>Proposta Enviada</b>', '2019-07-08 15:10:54', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(285, 10, '<b>Lucas</b> moveu <b>EMC Empreendimentos</b> para <b>Proposta Enviada</b>', '2019-07-08 15:10:54', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(286, 4, '<b>Lucas</b> moveu <b>Hotel Verde Mar</b> para <b>perdidos</b>', '2019-07-08 17:33:52', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(287, 10, '<b>[Lembrete]</b> - Ligar novamente', '2019-07-09 14:17:03', 'https://www.ownergy.com.br/zenit/', 'read'),
(288, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-09 16:13:28', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(289, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-09 16:13:28', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(290, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-09 16:26:00', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(291, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-09 16:26:00', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new');
INSERT INTO `notification` (`id`, `user_id`, `message`, `created_at`, `url`, `status`) VALUES
(292, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-09 16:29:04', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(293, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-09 16:29:04', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(294, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-09 16:32:39', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(295, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-09 16:32:39', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(296, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-09 16:42:42', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(297, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-09 16:42:42', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(298, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-09 16:50:48', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(299, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-09 16:50:48', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(300, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-09 16:54:46', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(301, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-09 16:54:46', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(302, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-09 17:08:03', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(303, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-09 17:08:03', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(304, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-09 17:14:36', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(305, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-09 17:14:36', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(306, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-09 17:21:32', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(307, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-09 17:21:32', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(308, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-09 17:27:37', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(309, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-09 17:27:37', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(310, 7, '<b>Lucas</b> moveu <b>Centro Espirita Joaquim </b> para <b>Proposta Enviada</b>', '2019-07-09 17:46:40', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(311, 8, '<b>Lucas</b> moveu <b>Centro Espirita Joaquim </b> para <b>Proposta Enviada</b>', '2019-07-09 17:46:40', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(312, 10, '<b>[Lembrete]</b> - Contactar Rodrigo', '2019-07-10 11:00:05', 'https://www.ownergy.com.br/zenit/', 'read'),
(313, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:16:24', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(314, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:16:24', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(315, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:22:29', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(316, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:22:29', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(317, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:22:29', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(318, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:22:33', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(319, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:22:33', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(320, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:22:33', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(321, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:22:35', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(322, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:22:35', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(323, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:22:35', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(324, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:22:38', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(325, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:22:39', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(326, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:22:39', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(327, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:23:00', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(328, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:23:00', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(329, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:23:00', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(330, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:23:03', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(331, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:23:03', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(332, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:23:03', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(333, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:23:05', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(334, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:23:06', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(335, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:23:06', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(336, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:23:06', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(337, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:23:06', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(338, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:23:06', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(339, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:23:39', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(340, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:23:40', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(341, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:23:40', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(342, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:23:40', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(343, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:23:40', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(344, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Julho]', '2019-07-10 11:23:40', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(345, 10, '<b>[Lembrete]</b> - Lead OI', '2019-07-11 10:00:04', 'https://www.ownergy.com.br/zenit/', 'read'),
(346, 7, '<b>Lucas</b> moveu <b>Condomínio verdant Valley</b> para <b>Proposta Enviada</b>', '2019-07-12 11:11:49', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(347, 8, '<b>Lucas</b> moveu <b>Condomínio verdant Valley</b> para <b>Proposta Enviada</b>', '2019-07-12 11:11:49', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(348, 7, '<b>Lucas</b> moveu <b>Fernando Zanandrea</b> para <b>Proposta Enviada</b>', '2019-07-12 11:14:14', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(349, 8, '<b>Lucas</b> moveu <b>Fernando Zanandrea</b> para <b>Proposta Enviada</b>', '2019-07-12 11:14:14', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(350, 10, '<b>[Lembrete]</b> - Falar com César', '2019-07-15 15:00:06', 'https://www.ownergy.com.br/zenit/', 'read'),
(351, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Solicitação de Acesso</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-17 12:23:08', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(352, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Solicitação de Acesso</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-17 12:23:11', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(353, 1, '<b>[Lembrete]</b> - Teste de lembrete', '2019-07-17 14:51:04', 'https://www.ownergy.com.br/zenit/', 'read'),
(354, 1, '<b>[Lembrete]</b> - Teste lembrete', '2019-07-17 15:21:03', 'https://www.ownergy.com.br/zenit/', 'read'),
(355, 10, '<b>[Lembrete]</b> - fgfgfdg', '2019-07-17 15:22:02', 'https://www.ownergy.com.br/zenit/', 'read'),
(356, 7, '<b>Lucas</b> moveu <b>Shopping OI - Contagem</b> para <b>Proposta Enviada</b>', '2019-07-19 13:54:09', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(357, 8, '<b>Lucas</b> moveu <b>Shopping OI - Contagem</b> para <b>Proposta Enviada</b>', '2019-07-19 13:54:09', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(358, 10, '<b>[Lembrete]</b> - Ver se Coutinho respondeu wpp', '2019-07-22 11:00:08', 'https://www.ownergy.com.br/zenit/', 'read'),
(359, 10, '<b>[Lembrete]</b> - Ver cm Rodrigo', '2019-07-24 14:00:06', 'https://www.ownergy.com.br/zenit/', 'read'),
(360, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Solicitação de Acesso</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-25 10:15:13', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(361, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Solicitação de Acesso</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-25 10:15:15', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(362, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Solicitação de Acesso</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-25 10:16:01', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(363, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Solicitação de Acesso</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-25 10:16:23', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(364, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Solicitação de Acesso</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-25 10:16:33', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(365, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Solicitação de Acesso</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-25 10:16:50', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(366, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Solicitação de Acesso</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-25 10:17:26', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(367, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Solicitação de Acesso</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-25 10:17:32', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(368, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Julho]', '2019-07-25 10:17:36', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(369, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-25 10:17:36', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(370, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Julho]', '2019-07-25 10:17:36', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(371, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Julho]', '2019-07-25 10:17:41', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(372, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-25 10:17:41', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(373, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Julho]', '2019-07-25 10:17:41', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(374, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Julho]', '2019-07-25 10:17:50', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(375, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Julho]', '2019-07-25 10:17:50', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(376, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Julho]', '2019-07-25 10:17:50', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(377, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-07-25 10:17:50', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(378, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Julho]', '2019-07-25 10:17:50', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(379, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Cotação SICES</b> e você já pode iniciar a tarefa <b>Negociação</b> </p>[LED nas Escolas - Julho]', '2019-07-25 10:18:50', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(380, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Cotação WEG</b> e você já pode iniciar a tarefa <b>Negociação</b> </p>[LED nas Escolas - Julho]', '2019-07-25 10:18:50', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(381, 6, '<p><b>Pedro</b> concluiu a tarefa  <b>Negociação</b> e você já pode iniciar a tarefa <b>Pagamento Inicial</b> </p>[LED nas Escolas - Julho]', '2019-07-25 10:18:56', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(382, 10, '<b>[Lembrete]</b> - Mandar WPP Jota', '2019-07-25 12:00:08', 'https://www.ownergy.com.br/zenit/', 'read'),
(383, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Cotação WEG</b> e você já pode iniciar a tarefa <b>Negociação</b> </p>[LED nas Escolas - Julho]', '2019-07-25 13:53:59', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(384, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Cotação SICES</b> e você já pode iniciar a tarefa <b>Negociação</b> </p>[LED nas Escolas - Julho]', '2019-07-25 13:54:00', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(385, 6, '<p><b>Pedro</b> concluiu a tarefa  <b>Negociação</b> e você já pode iniciar a tarefa <b>Pagamento Inicial</b> </p>[LED nas Escolas - Julho]', '2019-07-25 13:54:01', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(386, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Pagamento Inicial</b> e você já pode iniciar a tarefa <b>Entrega</b> </p>[LED nas Escolas - Julho]', '2019-07-25 13:54:02', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(387, 4, '<b>Lucas</b> moveu <b>Maria Aurea</b> para <b>Execução</b>', '2019-07-30 09:58:13', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(388, 6, '<b>Lucas</b> moveu <b>Maria Aurea</b> para <b>Execução</b>', '2019-07-30 09:58:13', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(389, 7, '<b>Lucas</b> moveu <b>Maria Aurea</b> para <b>Execução</b>', '2019-07-30 09:58:13', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(390, 8, '<b>Lucas</b> moveu <b>Maria Aurea</b> para <b>Execução</b>', '2019-07-30 09:58:13', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(391, 3, '<b>Lucas</b> moveu <b>Maria Aurea</b> para <b>Execução</b>', '2019-07-30 09:58:13', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(392, 5, '<b>Lucas</b> moveu <b>Maria Aurea</b> para <b>Execução</b>', '2019-07-30 09:58:13', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(393, 10, '<b>[Lembrete]</b> - Lembrar J da obra', '2019-08-02 11:00:04', 'https://www.ownergy.com.br/zenit/', 'new'),
(394, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Solicitação de Acesso</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-08-07 10:13:16', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(395, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Solicitação de Acesso</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-08-07 10:13:17', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(396, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Solicitação de Acesso</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-08-07 10:13:20', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(397, 0, '<p><b>Pedro</b> concluiu a tarefa  <b>Atualizar Lista de Material do Almoxarifado</b> e você já pode iniciar a tarefa <b>Definir Lista de Materiais para Cotação</b> </p>[LED nas Escolas - Julho]', '2019-08-07 10:13:47', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(398, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Definir Lista de Materiais para Cotação</b> e você já pode iniciar a tarefa <b>Cotar Loja Elétrica</b> </p>[LED nas Escolas - Julho]', '2019-08-07 10:13:50', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(399, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Definir Lista de Materiais para Cotação</b> e você já pode iniciar a tarefa <b>Cotação na MLM</b> </p>[LED nas Escolas - Julho]', '2019-08-07 10:13:50', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(400, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Definir Lista de Materiais para Cotação</b> e você já pode iniciar a tarefa <b>Cotação na Universo Elétrico</b> </p>[LED nas Escolas - Julho]', '2019-08-07 10:13:51', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(401, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Definir Lista de Materiais para Cotação</b> e você já pode iniciar a tarefa <b>Cotação na Othon de Carvalho</b> </p>[LED nas Escolas - Julho]', '2019-08-07 10:13:51', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(402, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Cotar Loja Elétrica</b> e você já pode iniciar a tarefa <b>Negociação (AL)</b> </p>[LED nas Escolas - Julho]', '2019-08-07 10:14:02', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(403, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Cotação na MLM</b> e você já pode iniciar a tarefa <b>Negociação (AL)</b> </p>[LED nas Escolas - Julho]', '2019-08-07 10:14:02', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(404, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Cotação na Othon de Carvalho</b> e você já pode iniciar a tarefa <b>Negociação (AL)</b> </p>[LED nas Escolas - Julho]', '2019-08-07 10:14:04', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(405, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Cotação na Universo Elétrico</b> e você já pode iniciar a tarefa <b>Negociação (AL)</b> </p>[LED nas Escolas - Julho]', '2019-08-07 10:14:04', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(406, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Negociação (AL)</b> e você já pode iniciar a tarefa <b>Emissão do Pedido</b> </p>[LED nas Escolas - Julho]', '2019-08-07 10:14:04', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(407, 0, '<p><b>Pedro</b> concluiu a tarefa  <b>Emissão do Pedido</b> e você já pode iniciar a tarefa <b>Coleta do Material</b> </p>[LED nas Escolas - Julho]', '2019-08-07 10:14:06', 'https://www.ownergy.com.br/zenit/projects/view/4', 'new'),
(408, 7, '<b>Thiago</b> moveu <b>Pousada Vidinha Bela</b> para <b>Elaboração de Propostas</b>', '2019-08-07 10:18:18', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(409, 8, '<b>Thiago</b> moveu <b>Pousada Vidinha Bela</b> para <b>Elaboração de Propostas</b>', '2019-08-07 10:18:18', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(410, 10, '<b>Thiago</b> moveu <b>EMC Empreendimentos</b> para <b>Coluna temporária para zerar status das propostas</b>', '2019-08-07 10:18:39', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(411, 10, '<b>Thiago</b> moveu <b>EMC Empreendimentos</b> para <b>Proposta Enviada</b>', '2019-08-07 10:18:48', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(412, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Solicitação de Acesso</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Julho]', '2019-08-07 10:19:25', 'https://www.ownergy.com.br/zenit/projects/view/4', 'read'),
(413, 4, '<b>Thiago</b> moveu <b>Robson Antonio </b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-08-07 10:20:07', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(414, 6, '<b>Thiago</b> moveu <b>Robson Antonio </b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-08-07 10:20:07', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(415, 3, '<b>Thiago</b> moveu <b>Robson Antonio </b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-08-07 10:20:07', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(416, 5, '<b>Thiago</b> moveu <b>Robson Antonio </b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-08-07 10:20:07', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(417, 4, '<b>Thiago</b> moveu <b>Luiz Roberto</b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-08-07 10:20:08', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(418, 6, '<b>Thiago</b> moveu <b>Luiz Roberto</b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-08-07 10:20:08', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(419, 3, '<b>Thiago</b> moveu <b>Luiz Roberto</b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-08-07 10:20:08', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(420, 5, '<b>Thiago</b> moveu <b>Luiz Roberto</b> para <b>Parecer de Acesso e pgto da 1a parcela</b>', '2019-08-07 10:20:08', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(421, 4, '<b>Thiago</b> moveu <b>Renato Sanches Rodrigues </b> para <b>Execução</b>', '2019-08-07 10:20:17', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(422, 6, '<b>Thiago</b> moveu <b>Renato Sanches Rodrigues </b> para <b>Execução</b>', '2019-08-07 10:20:17', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(423, 3, '<b>Thiago</b> moveu <b>Renato Sanches Rodrigues </b> para <b>Execução</b>', '2019-08-07 10:20:17', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(424, 5, '<b>Thiago</b> moveu <b>Renato Sanches Rodrigues </b> para <b>Execução</b>', '2019-08-07 10:20:17', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(425, 4, '<b>Thiago</b> moveu <b>Maria Aurea</b> para <b>Execução</b>', '2019-08-07 10:20:18', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(426, 6, '<b>Thiago</b> moveu <b>Maria Aurea</b> para <b>Execução</b>', '2019-08-07 10:20:18', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(427, 3, '<b>Thiago</b> moveu <b>Maria Aurea</b> para <b>Execução</b>', '2019-08-07 10:20:18', 'https://www.ownergy.com.br/zenit/leads/', 'read'),
(428, 5, '<b>Thiago</b> moveu <b>Maria Aurea</b> para <b>Execução</b>', '2019-08-07 10:20:18', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(429, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:13', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(430, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:13', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(431, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Solicitação de Acesso</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:14', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(432, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:16', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(433, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:16', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(434, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:16', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(435, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:19', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(436, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:19', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(437, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Solicitação de Acesso</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:19', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(438, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:21', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(439, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:21', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(440, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:21', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(441, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:24', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(442, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:24', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(443, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Solicitação de Acesso</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:24', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(444, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:27', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(445, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:27', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(446, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:27', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(447, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:31', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(448, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:31', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(449, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Solicitação de Acesso</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:32', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(450, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:33', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(451, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:33', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(452, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:33', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(453, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:37', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(454, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:37', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(455, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Solicitação de Acesso</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:38', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(456, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:38', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(457, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:38', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(458, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:38', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(459, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:41', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(460, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:41', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(461, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:43', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(462, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:43', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(463, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:43', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(464, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:45', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(465, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:45', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(466, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:45', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(467, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:45', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(468, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:46', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(469, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:47', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(470, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:47', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(471, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:48', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(472, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:48', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(473, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:48', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(474, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:51', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(475, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:51', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(476, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:51', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(477, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:51', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(478, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:51', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(479, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Solicitação de Acesso</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:53', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(480, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Mobilização</b> e você já pode iniciar a tarefa <b>Instalação</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:53', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(481, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Comissionamento</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:54', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(482, 9, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Pedido de Vistoria</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:54', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(483, 5, '<p><b>Pedro</b> concluiu a tarefa  <b>Instalação</b> e você já pode iniciar a tarefa <b>Relatório de Evidências</b> </p>[LED nas Escolas - Agosto]', '2019-08-08 11:37:54', 'https://www.ownergy.com.br/zenit/projects/view/5', 'new'),
(484, 10, '<b>José</b> moveu <b>EMC Empreendimentos</b> para <b>Follow up</b>', '2019-08-12 14:57:38', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(485, 10, '<b>José</b> moveu <b>EMC Empreendimentos</b> para <b>Follow up</b>', '2019-08-12 15:12:32', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(486, 4, '<b>José</b> moveu <b>Robson Antonio </b> para <b>Execução</b>', '2019-08-12 15:16:55', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(487, 6, '<b>José</b> moveu <b>Robson Antonio </b> para <b>Execução</b>', '2019-08-12 15:16:56', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(488, 3, '<b>José</b> moveu <b>Robson Antonio </b> para <b>Execução</b>', '2019-08-12 15:16:56', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(489, 5, '<b>José</b> moveu <b>Robson Antonio </b> para <b>Execução</b>', '2019-08-12 15:16:56', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(490, 4, '<b>José</b> moveu <b>Luiz Roberto</b> para <b>Execução</b>', '2019-08-12 15:17:42', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(491, 6, '<b>José</b> moveu <b>Luiz Roberto</b> para <b>Execução</b>', '2019-08-12 15:17:42', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(492, 3, '<b>José</b> moveu <b>Luiz Roberto</b> para <b>Execução</b>', '2019-08-12 15:17:42', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(493, 5, '<b>José</b> moveu <b>Luiz Roberto</b> para <b>Execução</b>', '2019-08-12 15:17:42', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(494, 4, '<b>José</b> moveu <b>Fernando Zanandrea</b> para <b>Negociação</b>', '2019-08-15 17:31:35', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(495, 4, '<b>[Lembrete]</b> - Ligar Rodrigo para saber do Sicredi', '2019-08-19 10:00:04', 'https://www.ownergy.com.br/zenit/', 'new'),
(496, 4, '<b>[Lembrete]</b> - Contatar Lessandro para fup', '2019-08-19 10:48:03', 'https://www.ownergy.com.br/zenit/', 'new'),
(497, 4, '<b>[Lembrete]</b> - Contato telefônico derradeiro com Rodrigo Stella', '2019-08-19 11:00:05', 'https://www.ownergy.com.br/zenit/', 'new'),
(498, 4, '<b>[Lembrete]</b> - Contato telefônico com Bruno para FUP', '2019-08-19 11:24:06', 'https://www.ownergy.com.br/zenit/', 'new'),
(499, 4, '<b>[Lembrete]</b> - Verificar com Coutinho se houve retorno do Ricardo', '2019-08-19 11:48:03', 'https://www.ownergy.com.br/zenit/', 'new'),
(500, 4, '<b>[Lembrete]</b> - Contatar Eduardo para saber se vamos seguir', '2019-08-27 10:00:05', 'https://www.ownergy.com.br/zenit/', 'new'),
(501, 7, '<b>Thiago</b> moveu <b>Gizela Abras</b> para <b>Elaboração de Propostas</b>', '2019-10-18 12:20:02', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(502, 8, '<b>Thiago</b> moveu <b>Gizela Abras</b> para <b>Elaboração de Propostas</b>', '2019-10-18 12:20:02', 'https://www.ownergy.com.br/zenit/leads/', 'new'),
(503, 4, '<b>José</b> moveu <b>EMC Empreendimentos</b> para <b>Negociação</b>', '2019-10-21 18:56:28', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(504, 10, '<b>José</b> moveu <b>EMC Empreendimentos</b> para <b>Negociação</b>', '2019-10-21 18:56:28', 'http://www.ownergy.com.br/zenit/leads/', 'new'),
(505, 4, '<b>José</b> moveu <b>Shopping Oi - Contagem</b> para <b>Negociação</b>', '2019-10-21 19:16:57', 'http://www.ownergy.com.br/zenit/leads/', 'new');

-- --------------------------------------------------------

--
-- Estrutura para tabela `private_message`
--

CREATE TABLE `private_message` (
  `id` int(11) UNSIGNED NOT NULL,
  `status` varchar(150) DEFAULT NULL,
  `sender` varchar(250) DEFAULT NULL,
  `recipient` varchar(250) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `time` varchar(100) DEFAULT NULL,
  `conversation` varchar(32) DEFAULT NULL,
  `deleted` int(11) DEFAULT 0,
  `attachment` varchar(255) DEFAULT NULL,
  `attachment_link` varchar(255) DEFAULT NULL,
  `receiver_delete` int(11) DEFAULT 0,
  `marked` int(1) DEFAULT 0,
  `read` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `private_message`
--

INSERT INTO `private_message` (`id`, `status`, `sender`, `recipient`, `subject`, `message`, `time`, `conversation`, `deleted`, `attachment`, `attachment_link`, `receiver_delete`, `marked`, `read`) VALUES
(1, 'Replied', 'u8', 'u7', 'Alo você', '<p>Teste</p>', '2019-02-12 00:36', '47407a683e0b51815f494524960b6b96', 0, NULL, NULL, 0, 0, 0),
(2, 'Read', 'u7', 'u8', 'Alo você', '<p>Teste1</p>', '2019-02-12 00:37', '47407a683e0b51815f494524960b6b96', 0, NULL, NULL, 0, 0, 0),
(3, 'Replied', 'u6', 'u1', 'Vc é top', 'Estou <font color=\"#ff0000\">adorando </font>o <b>Zenit</b>', '2019-02-12 00:44', '855bd851fb94a2c1bf54b4d1a0c56041', 0, NULL, NULL, 0, 0, 0),
(4, 'Replied', 'u1', 'u5', 'Almoço', '<p>Aqui vamos decidir o hoário de almoçar todos os dias</p>', '2019-02-12 01:06', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(5, 'Replied', 'u5', 'u1', 'Almoço', '<p>desnecessário...</p>', '2019-02-12 01:07', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(6, 'Replied', 'u1', 'u5', 'Almoço', '<p>Acho que não hein</p>', '2019-02-12 03:13', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(7, 'Replied', 'u1', 'u5', 'Almoço', '<p>Que horas vamos almoçar amanhã?</p>', '2019-02-12 03:21', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(8, 'Replied', 'u5', 'u1', 'Almoço', '<p>11 h</p>', '2019-02-12 03:22', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(9, 'Replied', 'u1', 'u6', 'Vc é top', '<p>Você que é top</p>', '2019-02-12 03:23', '855bd851fb94a2c1bf54b4d1a0c56041', 0, NULL, NULL, 0, 0, 0),
(10, 'Replied', 'u1', 'u6', 'Vc é top', '<p>Tá recebendo notificação dessa conversa?</p>', '2019-02-12 03:26', '855bd851fb94a2c1bf54b4d1a0c56041', 0, NULL, NULL, 0, 0, 0),
(11, 'Replied', 'u1', 'u6', 'Vc é top', '<p>E essa?</p>', '2019-02-12 03:31', '855bd851fb94a2c1bf54b4d1a0c56041', 0, NULL, NULL, 0, 0, 0),
(12, 'Replied', 'u6', 'u1', 'Vc é top', '<p>Agora sim</p>', '2019-02-12 03:32', '855bd851fb94a2c1bf54b4d1a0c56041', 0, NULL, NULL, 0, 0, 0),
(13, 'Replied', 'u1', 'u5', 'Almoço', '<p>muito cedo, tente novamente</p>', '2019-02-12 03:34', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(14, 'Replied', 'u1', 'u5', 'Almoço', '<p>hoje almoçamos sem combinado prévio</p>', '2019-02-13 03:55', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(15, 'Replied', 'u1', 'u5', 'Almoço', '<p>faltam 6 minutos, tá animado?</p>', '2019-02-14 00:44', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(16, 'Replied', 'u5', 'u1', 'Almoço', '<p>Você tá muito bonito hoje cara</p>', '2019-02-14 00:45', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(17, 'Replied', 'u1', 'u5', 'Almoço', '<p><span style=\"font-family: &quot;Open Sans&quot;; font-size: 15px; font-weight: 600;\">[$̲̅(̲̅ ͡° ͜ʖ ͡°̲̅)̲̅$̲̅]</span><br></p>', '2019-02-14 00:48', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(18, 'Replied', 'u5', 'u1', 'Almoço', '<p>¬¬</p>', '2019-02-14 00:49', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(19, 'Replied', 'u1', 'u5', 'Almoço', '<p>Tô mandando msg pelo cel</p>', '2019-02-14 06:10', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(20, 'Replied', 'u5', 'u1', 'Almoço', '<p>que bom</p><p><br></p>', '2019-02-14 22:23', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(21, 'Replied', 'u1', 'u5', 'Almoço', '<p>Testando horário de envio de msg</p>', '2019-02-14 22:39', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(22, 'Replied', 'u1', 'u5', 'Almoço', '<p>Esse é o melhor fuso que consegui nesse servidor</p>', '2019-02-14 10:05', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(23, 'Replied', 'u5', 'u1', 'Almoço', '<p>Bom que vai parecer que todo dia chego na hora.</p>', '2019-02-14 10:05', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(24, 'Replied', 'u1', 'u5', 'Almoço', '<p>pena que o zenit não aprendeu a registrar o ponto</p>', '2019-02-14 10:06', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(25, 'Replied', 'u1', 'u2', 'Papo cabeça', '<p>Coé Jorge, bora conversar uma conversa sadia pra eu testar o módulo de mensagens do Zenit</p>', '2019-02-14 10:07', 'e1d337228fa44356f5d324ee95356f44', 0, NULL, NULL, 0, 0, 0),
(26, 'Replied', 'u2', 'u1', 'Papo cabeça', '<p>Só sei que nada sei, e isso é algo fundamental&nbsp; que me coloca a frente de todos os demais.</p>', '2019-02-14 10:10', 'e1d337228fa44356f5d324ee95356f44', 0, NULL, NULL, 0, 0, 0),
(27, 'Replied', 'u1', 'u2', 'Papo cabeça', '<p>Concordo, mas tb sei que o modelo estrutural aqui preconizado oferece uma interessante oportunidade para verificação dos conhecimentos estratégicos para atingir a excelência.</p>', '2019-02-14 10:19', 'e1d337228fa44356f5d324ee95356f44', 0, NULL, NULL, 0, 0, 0),
(28, 'Read', 'u2', 'u1', 'Papo cabeça', '<p>Melhor depois do Pelé: Arthur Antunes Coimbra</p>', '2019-02-14 10:25', 'e1d337228fa44356f5d324ee95356f44', 0, NULL, NULL, 0, 0, 0),
(29, 'Read', 'u2', 'u5', 'Francisco Célio', '<p><span style=\"background-color: rgb(255, 255, 0);\">Ele é bonito? O nome dele é bonito, ele deve ser um cara bonito tb. A voz dele é bonita?</span></p>', '2019-02-14 10:26', '791cfad25cdedbb140045b5ddf65d20d', 0, NULL, NULL, 0, 0, 0),
(30, 'Replied', 'u5', 'u2', 'Francisco Célio', '<p>Acho q ele é bonito, a voz dele é empossada, nem ligo da ligação estar durando tanto</p>', '2019-02-14 11:25', '791cfad25cdedbb140045b5ddf65d20d', 0, NULL, NULL, 0, 0, 0),
(31, 'Replied', 'u5', 'u2', 'Francisco Célio', '<p>só recebi agora a msg</p>', '2019-02-14 11:25', '791cfad25cdedbb140045b5ddf65d20d', 0, NULL, NULL, 0, 0, 0),
(32, 'Read', 'u2', 'u5', 'Francisco Célio', '<p>Fala com ele q eu quero falar com ele no final da ligação!</p>', '2019-02-14 11:26', '791cfad25cdedbb140045b5ddf65d20d', 0, NULL, NULL, 0, 0, 0),
(33, 'Replied', 'u1', 'u5', 'Almoço', '<p>temos almoçado mtas vezes sem nenhum combinado pelo chat</p>', '2019-02-19 16:11', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(34, 'Replied', 'u5', 'u1', 'Almoço', '<p>Verdade.. pra me redimir pelo péssimo comportamento, amanhã eu pago seu almoço amigo</p>', '2019-02-19 16:13', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(35, 'Replied', 'u1', 'u5', 'Almoço', '<p>obrigado! &gt;.&lt;</p>', '2019-02-19 16:18', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(36, 'Replied', 'u1', 'u5', 'Almoço', '<p>oi amigo, os pushes do zenit ainda tão funcionando?</p><p><span style=\"color: rgb(51, 51, 50); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 22px;\">ಠ_ಠ</span><br></p>', '2019-02-27 16:53', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(37, 'Replied', 'u5', 'u1', 'Almoço', '<p>RAZOAVELMENTE</p><p><br></p>', '2019-02-27 16:54', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(38, 'Replied', 'u1', 'u5', 'Almoço', '<p><span style=\"color: rgb(51, 51, 50); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 22px;\">ಥ_ಥ&nbsp;</span></p><p>obg amigo, isso foi esclarecedor</p><p><br></p>', '2019-02-27 16:54', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(39, 'Read', 'u1', 'u6', 'Vc é top', '<p>Top top, ela é top.</p>', '2019-04-30 10:26', '855bd851fb94a2c1bf54b4d1a0c56041', 0, NULL, NULL, 0, 0, 0),
(40, 'Replied', 'u1', 'u5', 'Almoço', '<p>Declarou seu IR certinho?</p>', '2019-04-30 10:27', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(41, 'Read', 'u6', 'u1', ';)', '<p>Obrigada!</p>', '2019-04-30 10:29', '34cfedcf8f41d8b8c4aa4066c3445a9c', 0, NULL, NULL, 0, 0, 0),
(42, 'Read', 'u5', 'u1', 'Almoço', '<p>Foi lindo</p><p><br></p>', '2019-04-30 10:36', '77033b9a3d906ff15383040d2288b36e', 0, NULL, NULL, 0, 0, 0),
(43, 'Read', 'u1', 'u11', 'Permissões Zenit', '<p>Niza, atualiza a página e veja se apareceu o módulo de Funil de Vendas. Se não tiver aparecido, faça logout e login novamente.</p>', '2019-09-25 09:34', '257aca71930076ddb4e99b26bb247e81', 0, NULL, NULL, 0, 0, 0),
(44, 'Read', 'u11', 'u1', 'Permissões Zenit', '<p>Ok entendido rsrs</p>', '2019-09-25 09:39', 'da8f922d24c109a8fc53c91c85c32530', 0, NULL, NULL, 0, 0, 0),
(45, 'Read', 'u11', 'u1', 'Permissões Zenit', '<p>Deu certoooooooo</p><p>Obrigada</p>', '2019-09-25 09:40', 'b8aa2a034a807be5c31e63ba18cb47bd', 0, NULL, NULL, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `reference` int(11) DEFAULT 0,
  `name` varchar(65) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `start` varchar(20) DEFAULT NULL,
  `end` varchar(20) DEFAULT NULL,
  `progress` decimal(3,0) DEFAULT NULL,
  `phases` varchar(150) DEFAULT NULL,
  `tracking` int(11) DEFAULT 0,
  `time_spent` int(11) DEFAULT 0,
  `datetime` int(11) DEFAULT 0,
  `sticky` enum('1','0') DEFAULT '0',
  `color` varchar(100) DEFAULT '#5071ab',
  `company_id` int(11) DEFAULT 0,
  `note` longtext DEFAULT NULL,
  `progress_calc` tinyint(4) DEFAULT 0,
  `hide_tasks` int(1) DEFAULT 0,
  `enable_client_tasks` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `project`
--

INSERT INTO `project` (`id`, `reference`, `name`, `description`, `start`, `end`, `progress`, `phases`, `tracking`, `time_spent`, `datetime`, `sticky`, `color`, `company_id`, `note`, `progress_calc`, `hide_tasks`, `enable_client_tasks`) VALUES
(1, 0, 'Projeto base', 'Projeto para ser copiado. Base para todos os novos.', '2019-02-11 12:00', '2019-06-28 12:00', '0', NULL, 0, 0, 1549915844, '0', '#2657dd', 1, NULL, 1, 0, 0),
(2, 1, 'Base LED nas Escolas', '', '2019-07-01 12:00', '2019-12-31 12:00', '0', NULL, 0, 0, 1562090829, '0', '#5071ab', 1, NULL, 1, 0, 0),
(4, 2, 'LED nas Escolas - Julho', '', '2019-06-26 12:00', '2019-07-25 12:00', '68', NULL, 0, 0, 1562346004, '0', '#5071ab', 1, NULL, 1, 0, 0),
(5, 3, 'LED nas Escolas - Agosto', 'Instalação das escolas do mês de Agosto de 2019', '2019-07-25 12:00', '2019-08-25 12:00', '42', NULL, 0, 0, 1565274040, '0', '#5071ab', 1, NULL, 1, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `project_activity`
--

CREATE TABLE `project_activity` (
  `id` bigint(20) NOT NULL,
  `project_id` bigint(20) DEFAULT 0,
  `user_id` bigint(20) DEFAULT 0,
  `client_id` bigint(20) DEFAULT 0,
  `datetime` varchar(250) DEFAULT NULL,
  `subject` varchar(250) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `type` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `project_file`
--

CREATE TABLE `project_file` (
  `id` int(10) NOT NULL,
  `project_id` int(10) DEFAULT 0,
  `user_id` int(10) DEFAULT 0,
  `client_id` int(10) DEFAULT 0,
  `type` varchar(80) DEFAULT NULL,
  `name` varchar(120) DEFAULT NULL,
  `filename` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `savename` varchar(200) DEFAULT NULL,
  `phase` varchar(100) DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL,
  `download_counter` int(10) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `project_message`
--

CREATE TABLE `project_message` (
  `id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT 0,
  `media_id` int(11) DEFAULT 0,
  `from` varchar(120) DEFAULT NULL,
  `text` text DEFAULT NULL,
  `datetime` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `project_milestone`
--

CREATE TABLE `project_milestone` (
  `id` int(11) UNSIGNED NOT NULL,
  `project_id` int(11) DEFAULT 0,
  `name` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `due_date` varchar(255) DEFAULT NULL,
  `orderindex` int(11) DEFAULT 0,
  `start_date` varchar(255) DEFAULT NULL,
  `area_id` int(11) DEFAULT 0,
  `area_order` int(11) DEFAULT 0,
  `public` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `project_milestone`
--

INSERT INTO `project_milestone` (`id`, `project_id`, `name`, `description`, `due_date`, `orderindex`, `start_date`, `area_id`, `area_order`, `public`) VALUES
(1, 1, 'Aviso de 2º Pagamento', '<p><br></p>', '', 0, '', 1, 0, 0),
(2, 1, 'Cotações', '', '', 0, '', 1, 0, 0),
(3, 1, 'Negociações', '', '', 0, '', 1, 0, NULL),
(4, 1, 'Aprovação de Compra', '', '', 0, '', 1, 0, NULL),
(5, 1, 'Coleta do Material', '', '', 0, '', 1, 0, NULL),
(6, 1, 'Recebimento dos Materiais', '', '', 0, '', 1, 0, 0),
(7, 1, 'Troca de Materiais', '', NULL, 0, NULL, 1, 0, NULL),
(8, 1, 'Pré-Solicitação', '', NULL, 0, NULL, 2, 0, NULL),
(9, 1, 'Solicitação de Acesso', '', NULL, 0, NULL, 2, 0, NULL),
(10, 1, 'Vistoria', '', NULL, 0, NULL, 2, 0, NULL),
(11, 1, 'Entrega Databook', '', NULL, 0, NULL, 2, 0, NULL),
(12, 1, 'Cadastro Compensação', '', NULL, 0, NULL, 2, 0, NULL),
(13, 1, 'Entrada de Materiais', '', NULL, 0, NULL, 4, 0, NULL),
(14, 1, 'Saída de Materiais', '', NULL, 0, NULL, 4, 0, NULL),
(15, 1, 'Mobilização', '', NULL, 0, NULL, 3, 0, NULL),
(16, 1, 'Instalação', '', NULL, 0, NULL, 3, 0, NULL),
(17, 1, 'Desmobilização', '', NULL, 0, NULL, 3, 0, NULL),
(18, 2, 'Lote X - 15 kits', '<p>Kits de geração fotovoltaica para instalação nas escolas</p>', NULL, 0, NULL, 1, 0, 0),
(20, 2, 'Insumos - Gestão de Atividades', '<p>Atividades para serem realizadas no mês corrente para controle de insumos utilizados e de estoque.</p>', NULL, 0, NULL, 4, 0, 0),
(35, 2, 'XYA - E.E. XXXX YYYY', '', NULL, 3, NULL, 3, 0, 0),
(53, 2, 'XYB - E.E. XXXX YYYY', '', NULL, 1, NULL, 3, 0, 0),
(54, 2, 'XYC - E.E. XXXX YYYY', '', NULL, 1, NULL, 3, 0, 0),
(55, 2, 'XYD - E.E. XXXX YYYY', '', NULL, 1, NULL, 3, 0, 0),
(56, 2, 'XYE - E.E. XXXX YYYY', '', NULL, 1, NULL, 3, 0, 0),
(57, 2, 'XYF - E.E. XXXX YYYY', '', NULL, 1, NULL, 3, 0, 0),
(58, 2, 'XYG - E.E. XXXX YYYY', '', NULL, 1, NULL, 3, 0, 0),
(59, 2, 'XYH - E.E. XXXX YYYY', '', NULL, 1, NULL, 3, 0, 0),
(60, 2, 'XYI - E.E. XXXX YYYY', '', NULL, 1, NULL, 3, 0, 0),
(61, 2, 'XYJ - E.E. XXXX YYYY', '', NULL, 1, NULL, 3, 0, 0),
(62, 2, 'XYK - E.E. XXXX YYYY', '', NULL, 1, NULL, 3, 0, 0),
(63, 2, 'XYL - E.E. XXXX YYYY', '', NULL, 1, NULL, 3, 0, 0),
(64, 2, 'XYM - E.E. XXXX YYYY', '', NULL, 1, NULL, 3, 0, 0),
(65, 2, 'XYN - E.E. XXXX YYYY', '', NULL, 1, NULL, 3, 0, 0),
(66, 4, 'Lote 7 - 15 kits', '<p>Kits de geração fotovoltaica para instalação nas escolas</p>', NULL, 0, NULL, 1, 0, 0),
(67, 4, 'Insumos - Gestão de Atividades', '<p>Atividades para serem realizadas no mês corrente para controle de insumos utilizados e de estoque.</p>', NULL, 0, NULL, 4, 0, 0),
(68, 4, '081 - E.E. Professor João de Arruda Pinto', '', NULL, 1, NULL, 3, 0, 0),
(69, 4, '065 - E.E. Sagrada Família', '', NULL, 2, NULL, 3, 0, 0),
(70, 4, '095 - E.E. Celso Machado', '', NULL, 3, NULL, 3, 0, 0),
(71, 4, '093 - E.E. Nova Contagem', '', NULL, 4, NULL, 3, 0, 0),
(72, 4, '085 - E.E. Antônio Augusto Ribeiro', '', NULL, 5, NULL, 3, 0, 0),
(73, 4, '086 - E.E. Cecília Meireles', '', NULL, 6, NULL, 3, 0, 0),
(74, 4, '083 - E.E. DE MELO VIANA', '', NULL, 7, NULL, 3, 0, 0),
(75, 4, '088 - E.E. Dr Orestes Diniz', '', NULL, 8, NULL, 3, 0, 0),
(76, 4, '089 - E.E. João Guimarães Rosa', '', NULL, 10, NULL, 3, 0, 0),
(77, 4, '091 - E.E. Professora Lourdes Bernadete Silva', '', NULL, 11, NULL, 3, 0, 0),
(78, 4, '092 - E.E. Tito Lívio De Souza', '', NULL, 12, NULL, 3, 0, 0),
(79, 4, '084 - E.E. Santa Quitéria', '', NULL, 9, NULL, 3, 0, 0),
(80, 4, '096 - E.E. Pedro Evangelista Diniz', '', NULL, 13, NULL, 3, 0, 0),
(82, 2, 'lanterna dos afogados', '', NULL, 0, NULL, 2, 0, NULL),
(83, 5, 'Lote X - 15 kits', '<p>Kits de geração fotovoltaica para instalação nas escolas</p>', NULL, 0, NULL, 1, 0, 0),
(84, 5, 'Insumos - Gestão de Atividades', '<p>Atividades para serem realizadas no mês corrente para controle de insumos utilizados e de estoque.</p>', NULL, 0, NULL, 4, 0, 0),
(85, 5, 'lanterna dos afogados', '', NULL, 0, NULL, 2, 0, NULL),
(86, 5, '094 - E.E. Do Bairro São Caetano', '', NULL, 1, NULL, 3, 0, 0),
(87, 5, '097 - E.E. Professora Yolanda Martins', '', NULL, 1, NULL, 3, 0, 0),
(88, 5, '100 - E.E. Afonso Pena', '', NULL, 1, NULL, 3, 0, 0),
(89, 5, '099 - E.E. José Pereira dos Santos', '', NULL, 1, NULL, 3, 0, 0),
(90, 5, '078 - E.E. Estudante Lívia Mara de Castro', '', NULL, 1, NULL, 3, 0, 0),
(91, 5, '021 - E.E. João Paulo I', '', NULL, 1, NULL, 3, 0, 0),
(92, 5, '082 - E.E. Dr Renato Azeredo', '', NULL, 1, NULL, 3, 0, 0),
(93, 5, '087 - E.E. Professor Osvaldo Franco', '', NULL, 1, NULL, 3, 0, 0),
(94, 5, '090 - E.E. Professor Carlos Lúcio de Assis', '', NULL, 1, NULL, 3, 0, 0),
(95, 5, '098 - E.E. Gramont Alves Gontijo', '', NULL, 1, NULL, 3, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `project_task`
--

CREATE TABLE `project_task` (
  `id` int(10) NOT NULL,
  `project_id` int(10) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `public` int(10) DEFAULT NULL,
  `datetime` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `start_date` varchar(250) DEFAULT NULL,
  `due_date` varchar(250) DEFAULT NULL,
  `completion_date` varchar(250) DEFAULT NULL,
  `value` float DEFAULT 0,
  `priority` smallint(6) DEFAULT 0,
  `time` int(11) DEFAULT NULL,
  `client_id` int(30) DEFAULT 0,
  `created_by_client` int(30) DEFAULT 0,
  `tracking` int(11) DEFAULT 0,
  `time_spent` int(11) DEFAULT 0,
  `milestone_id` int(11) DEFAULT 0,
  `invoice_id` int(60) DEFAULT 0,
  `milestone_order` int(11) DEFAULT 0,
  `task_order` int(11) DEFAULT 0,
  `progress` int(11) DEFAULT 0,
  `created_at` varchar(50) DEFAULT NULL,
  `sucessors` varchar(10000) DEFAULT NULL COMMENT 'Array de IDs de tarefas sucessoras',
  `scheduled_time` int(11) NOT NULL DEFAULT 0,
  `reference` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `project_task`
--

INSERT INTO `project_task` (`id`, `project_id`, `name`, `user_id`, `status`, `public`, `datetime`, `description`, `start_date`, `due_date`, `completion_date`, `value`, `priority`, `time`, `client_id`, `created_by_client`, `tracking`, `time_spent`, `milestone_id`, `invoice_id`, `milestone_order`, `task_order`, `progress`, `created_at`, `sucessors`, `scheduled_time`, `reference`) VALUES
(2, 1, 'Fazer Cotação na SICES (1d)', 0, 'open', 0, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 2, 0, 1, 0, 0, '2019-02-12 06:58:26', NULL, 0, 'QJAGJWUFGJ'),
(3, 1, 'Fazer Cotação na WEG (2)', 0, 'open', 0, NULL, '', '2019-03-29 12:00', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 2, 0, 2, 0, 0, '2019-02-12 07:00:15', NULL, 2, 'DQU9KW37BD'),
(5, 1, 'Negociar Preço e Forma de Pagamento com WEG', 0, 'open', 0, NULL, '', '2019-03-12 12:00', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 3, 0, 0, 0, 0, '2019-02-12 07:03:55', '8', 3, 'JFPVKFOK1A'),
(6, 1, 'Autorizar Pagamento (1d)', 0, 'open', 0, NULL, '<p>Autorizar Pagamento Base</p>', '2019-02-11 12:00', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 4, 0, 0, 0, 0, '2019-02-12 07:06:09', NULL, 0, 'JPVGAUCNGL'),
(7, 1, 'Avisar Financeiro → FINANCEIRO', 0, 'open', 0, NULL, '<p>Nesse momento é preciso programar o pagamento do material.</p><p>Quando houver o departamento financeiro, precisaremos criar tarefa de pagamento.</p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 4, 0, 0, 0, 0, '2019-02-12 07:08:27', NULL, 0, 'IJ26JGVGFW'),
(8, 1, 'Confirmar Data da Coleta', 0, 'open', 0, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 5, 0, 1, 0, 0, '2019-02-12 07:11:41', NULL, 0, 'JO3YFH9UR0'),
(9, 1, 'Confirmar Previsão da Data de Entrega', 0, 'open', 0, NULL, '', '', '', '2019-03-27 17:25', 0, 2, NULL, 0, 0, 0, 0, 5, 0, 2, 0, 0, '2019-02-12 07:13:16', '11', 0, 'U2LKDLAGZG'),
(11, 1, 'Confirmar Qualidade e Quantidade', 0, 'open', 0, NULL, '<ol><li>Confirmar se Materiais estão em Perfeito estado.</li><li>Pedir Fotos para os clientes</li></ol><p>Obs: Criar formulário para cliente enviar as fotos dos materiais recebidos, quantidades e estado de conservação.</p>', '2019-03-27 17:25', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 6, 0, 0, 0, 0, '2019-02-12 07:18:23', NULL, 2, 'RCQNBZUWAZ'),
(12, 1, 'Se Materiais OK → FINANCEIRO', 0, 'open', 0, NULL, '<p>Em alguns casos o recebimento dos materiais poderá disparar um evento de pagamento. </p><p><br></p><p><b style=\"\"><font color=\"#ff0000\">Se materiais NOK, voltar para COLETA DO MATERIAL e refazer o ciclo. Marcar as atividades como não executadas.</font></b></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 6, 0, 0, 0, 0, '2019-02-12 07:20:03', NULL, 0, 'NKJKEOSEDF'),
(13, 1, 'Se Materiais Ok → EXECUÇÃO', 0, 'open', 0, NULL, '<p>Em alguns casos o recebimento dos materiais poderá disparar um evento de pagamento. </p><p><br></p><p><span style=\"font-weight: 700;\"><font color=\"#ff0000\">Se materiais NOK, voltar para COLETA DO MATERIAL e refazer o ciclo. Marcar as atividades como não executadas.</font></span></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 6, 0, 0, 0, 0, '2019-02-12 07:28:55', NULL, 0, '8YBKEEWFKQ'),
(14, 1, 'Aumento de Carga', 0, 'open', NULL, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 8, 0, 3, 0, 0, '2019-06-07 15:11:36', NULL, 0, '40QHXGXAVG'),
(15, 1, 'Troca de Titularidade', 0, 'open', 0, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 8, 0, 4, 0, 0, '2019-06-07 15:11:56', NULL, 0, 'FVWEUQOWIP'),
(16, 1, 'Conseguir Certificado de Conformidade', 0, 'open', 0, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 9, 0, 2, 0, 0, '2019-06-07 15:13:52', NULL, 0, 'MLSXQQRPYT'),
(17, 1, 'Conferir Cadastro Disjuntor na Cemig', 0, 'open', 0, NULL, '<p>Verificar se cadastro de disjuntor do padrão de entrada é compatível com o disjuntor instalado fisicamente. </p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 8, 0, 2, 0, 0, '2019-06-07 15:15:24', NULL, 0, 'MCROCPHIDK'),
(18, 1, 'Verificar Disjuntor do Padrão de Entrada', 0, 'open', 0, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 8, 0, 1, 0, 0, '2019-06-07 15:16:17', NULL, 0, 'EQXULCQL2P'),
(19, 1, 'Verificar Potência e Equip. da Usina em Contrato', 0, 'open', 0, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 8, 0, 0, 0, 0, '2019-06-07 15:19:29', NULL, 0, 'JR7SGRPSXS'),
(20, 1, 'Emitir ART', 0, 'open', NULL, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 9, 0, 1, 0, 0, '2019-06-07 15:21:29', NULL, 0, 'J3HY3MCJJD'),
(21, 1, 'Redigir Memorial Descritivo', 0, 'open', NULL, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 9, 0, 0, 0, 0, '2019-06-07 15:22:37', NULL, 0, 'HLBXIDKHFP'),
(22, 1, 'Elaborar DUB', 0, 'open', NULL, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 9, 0, 0, 0, 0, '2019-06-07 15:37:54', NULL, 0, 'RFUEHF6WET'),
(23, 1, 'Preencher Formulário GD', 0, 'open', 0, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 9, 0, 0, 0, 0, '2019-06-07 15:38:10', NULL, 0, 'BJGKT8RTUW'),
(24, 1, 'Anexar ID Cliente', 0, 'open', 0, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 9, 0, 0, 0, 0, '2019-06-07 15:39:29', NULL, 0, 'WJTP7BPCOI'),
(25, 1, 'Fazer Solicitação de Acesso Cemig Atende', 0, 'open', 0, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 9, 0, 0, 0, 0, '2019-06-07 15:40:04', NULL, 0, '6DYW2GBNWS'),
(26, 1, 'Registrar Entrada de Materiais', 0, 'open', 0, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 13, 0, 0, 0, 0, '2019-06-11 16:46:29', NULL, 0, '2D7G7IAONK'),
(27, 1, 'Registrar Saída de Materiais', 0, 'open', NULL, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 14, 0, 0, 0, 0, '2019-06-11 16:47:09', NULL, 0, '0GZOEAYJ3O'),
(28, 1, 'Consultar e Retirar Materiais do Almoxarifado', 0, 'open', NULL, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 15, 0, 2, 0, 0, '2019-06-11 16:53:31', NULL, 0, 'PXIM8JWH7T'),
(29, 1, 'Comprar Insumos para Instalação', 0, 'open', 0, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 15, 0, 3, 0, 0, '2019-06-11 16:53:48', NULL, 0, 'GDHLACMCGU'),
(30, 1, 'Direcionar Equipe para Instalação', 0, 'open', 0, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 15, 0, 1, 0, 0, '2019-06-11 16:54:33', NULL, 0, 'DNM9FK6M0D'),
(31, 1, 'Executar Instalação', 0, 'open', 0, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 16, 0, 1, 0, 0, '2019-06-11 16:55:08', NULL, 0, 'GHXYJL0WPD'),
(32, 1, 'Realizar Comissionamento', 0, 'open', 0, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 16, 0, 2, 0, 0, '2019-06-11 16:55:27', NULL, 0, 'GDBVKCWHWG'),
(33, 1, 'Devolver Materiais ao Almoxarifado', 0, 'open', 0, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 17, 0, 0, 0, 0, '2019-06-11 16:56:14', NULL, 0, '76IZ3OKTYY'),
(34, 2, 'Cotação WEG', 5, 'open', 0, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 18, 0, 0, 0, 0, '2019-07-02 15:13:43', '36', 2, 'GD9A94ROD5'),
(35, 2, 'Cotação SICES', 5, 'open', 0, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 18, 0, 0, 0, 0, '2019-07-02 15:16:43', '36', 1, 'WIY3HCOUXQ'),
(36, 2, 'Negociação', 5, 'open', 0, NULL, '<p>A negociação será feita com a cotação de melhor custo benefício entre WEG e SICES</p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 18, 0, 0, 0, 0, '2019-07-02 15:29:38', '37', 2, 'ZPWRSOHJSN'),
(37, 2, 'Pagamento Inicial', 6, 'open', 0, NULL, 'Pagamento pode ser feito em até 5 dias.', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 18, 0, 0, 0, 0, '2019-07-02 15:37:04', '38', 5, 'OSA1STUJVE'),
(38, 2, 'Entrega', 5, 'open', 0, NULL, 'Fazer o acompanhamento da entrega junto a fornecedora e a transportadoras. Tomar cuidado com local de entrega.', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 18, 0, 0, 0, 0, '2019-07-02 15:40:16', NULL, 20, 'F6Q9INVDTT'),
(45, 2, 'Atualizar Lista de Material do Almoxarifado', 0, 'open', 0, NULL, 'No dia 25 de cada mês, Vander deverá atualizar os materiais do almoxarifado para levantamento de qual insumo está faltando e deve ser reposto, assim como quanto foi gasto de cada material.', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 20, 0, 0, 0, 0, '2019-07-02 16:23:02', '46', 25, 'WHSHMNAWDW'),
(46, 2, 'Definir Lista de Materiais para Cotação', 0, 'open', 0, NULL, 'A partir do levantamento do estoque, Vander deverá fazer lista para cotação dos materiais necessários.', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 20, 0, 0, 0, 0, '2019-07-02 16:24:08', '47,48,49,50', 1, 'P9AOC5BQTI'),
(47, 2, 'Cotação na Loja Elétrica', 5, 'open', 0, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 20, 0, 0, 0, 0, '2019-07-02 16:24:30', '51', 2, 'C0SIYPNGBT'),
(48, 2, 'Cotação na MLM', 5, 'open', 0, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 20, 0, 0, 0, 0, '2019-07-02 16:24:50', '51', 0, 'JFQGIY4NBE'),
(49, 2, 'Cotação na Universo Elétrico', 5, 'open', 0, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 20, 0, 0, 0, 0, '2019-07-02 16:25:12', '51', 2, 'JCXLBBJ9DO'),
(50, 2, 'Cotação na Othon de Carvalho', 5, 'open', 0, NULL, '', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 20, 0, 0, 0, 0, '2019-07-02 16:29:38', '51', 2, 'CQ79MBOZYS'),
(51, 2, 'Negociação (AL)', 5, 'open', 0, NULL, 'Negociação com as fornecedoras para obter melhor preço.', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 20, 0, 0, 0, 0, '2019-07-02 16:30:18', '52', 2, 'OGQBNLATMJ'),
(52, 2, 'Emissão do Pedido', 5, 'open', 0, NULL, 'Fazer pedido junto a fornecedora com melhor preço.', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 20, 0, 0, 0, 0, '2019-07-02 16:31:06', '54', 1, 'QE2GL2ZMZM'),
(54, 2, 'Coleta do Material', 0, 'open', NULL, NULL, 'Após emissão do pedido, Vander deverá buscar os materiais comprados na fornecedora.', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 20, 0, 0, 0, 0, '2019-07-02 16:33:45', NULL, 1, 'SDD2MAOSFP'),
(144, 2, 'Mobilização', 5, 'open', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 35, 0, 0, 0, 0, '2019-07-04 14:18:37', '145,146', 1, 'YLQZYO6QPM'),
(145, 2, 'Solicitação de Acesso', 9, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 35, 0, 0, 0, 0, '2019-07-04 14:18:37', '148', 17, 'VLTQPXYA9Z'),
(146, 2, 'Instalação', 5, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 35, 0, 0, 0, 0, '2019-07-04 14:18:37', '147,148,149', 15, '8TBCDRZIKS'),
(147, 2, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 35, 0, 0, 0, 0, '2019-07-04 14:18:37', '150', 1, 'TDFYLSLFOJ'),
(148, 2, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 35, 0, 0, 0, 0, '2019-07-04 14:18:37', NULL, 2, 'FYKDH3ADWS'),
(149, 2, 'Relatório de Evidências', 5, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 35, 0, 0, 0, 0, '2019-07-04 14:18:37', NULL, 5, 'LKXMVLQ7PT'),
(150, 2, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 35, 0, 0, 0, 0, '2019-07-04 14:18:37', NULL, 0, 'L9DHZQ4OEG'),
(270, 2, 'Mobilização', 5, 'open', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 53, 0, 0, 0, 0, '2019-07-05 13:42:47', '271,272', 0, 'RYIEO2T20U'),
(271, 2, 'Solicitação de Acesso', 9, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 53, 0, 0, 0, 0, '2019-07-05 13:42:47', '274', 17, 'JRJS4K5LXK'),
(272, 2, 'Instalação', 5, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 53, 0, 0, 0, 0, '2019-07-05 13:42:47', '273,274,275', 15, 'QLRBK9R4EY'),
(273, 2, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 53, 0, 0, 0, 0, '2019-07-05 13:42:47', '276', 1, 'DRWV4HH9RH'),
(274, 2, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 53, 0, 0, 0, 0, '2019-07-05 13:42:47', NULL, 2, '77DJ1JGXOW'),
(275, 2, 'Relatório de Evidências', 5, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 53, 0, 0, 0, 0, '2019-07-05 13:42:47', NULL, 5, 'UCAULINCYS'),
(276, 2, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 53, 0, 0, 0, 0, '2019-07-05 13:42:47', NULL, 0, 'KNFXSGOA87'),
(277, 2, 'Mobilização', 5, 'open', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 54, 0, 0, 0, 0, '2019-07-05 13:44:39', '278,279', 1, 'LGAQR6ZDDW'),
(278, 2, 'Solicitação de Acesso', 9, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 54, 0, 0, 0, 0, '2019-07-05 13:44:39', '281', 17, 'IHHJTA36EA'),
(279, 2, 'Instalação', 5, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 54, 0, 0, 0, 0, '2019-07-05 13:44:39', '280,281,282', 15, 'B7P3FEYBVL'),
(280, 2, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 54, 0, 0, 0, 0, '2019-07-05 13:44:39', '283', 1, 'XKBHFKXOOL'),
(281, 2, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 54, 0, 0, 0, 0, '2019-07-05 13:44:39', NULL, 2, 'J2FFP5O3DB'),
(282, 2, 'Relatório de Evidências', 5, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 54, 0, 0, 0, 0, '2019-07-05 13:44:39', NULL, 5, 'EDRLVKP7SJ'),
(283, 2, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 54, 0, 0, 0, 0, '2019-07-05 13:44:39', NULL, 0, 'KKRCRNXAUW'),
(284, 2, 'Mobilização', 5, 'open', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 55, 0, 0, 0, 0, '2019-07-05 13:45:24', '285,286', 1, 'WCNBM0UYOU'),
(285, 2, 'Solicitação de Acesso', 9, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 55, 0, 0, 0, 0, '2019-07-05 13:45:24', '288', 17, 'N1LEKTTZRX'),
(286, 2, 'Instalação', 5, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 55, 0, 0, 0, 0, '2019-07-05 13:45:24', '287,288,289', 15, 'U7GGHUBQJF'),
(287, 2, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 55, 0, 0, 0, 0, '2019-07-05 13:45:24', '290', 1, 'F07PMO6HK8'),
(288, 2, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 55, 0, 0, 0, 0, '2019-07-05 13:45:24', NULL, 2, '7OV6GPSDIQ'),
(289, 2, 'Relatório de Evidências', 5, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 55, 0, 0, 0, 0, '2019-07-05 13:45:24', NULL, 5, 'ST5ERYWZEJ'),
(290, 2, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 55, 0, 0, 0, 0, '2019-07-05 13:45:24', NULL, 0, 'OD9RDPDH5I'),
(291, 2, 'Mobilização', 5, 'open', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 56, 0, 0, 0, 0, '2019-07-05 13:45:59', '292,293', 1, 'EYMRB7K9NP'),
(292, 2, 'Solicitação de Acesso', 9, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 56, 0, 0, 0, 0, '2019-07-05 13:45:59', '295', 17, 'ZFC1H3Q0XF'),
(293, 2, 'Instalação', 5, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 56, 0, 0, 0, 0, '2019-07-05 13:45:59', '294,295,296', 15, 'JEVPPURWRM'),
(294, 2, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 56, 0, 0, 0, 0, '2019-07-05 13:45:59', '297', 1, 'X3PHPMFOJK'),
(295, 2, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 56, 0, 0, 0, 0, '2019-07-05 13:45:59', NULL, 2, 'E8JGZIHATD'),
(296, 2, 'Relatório de Evidências', 5, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 56, 0, 0, 0, 0, '2019-07-05 13:45:59', NULL, 5, '2UZECOEADM'),
(297, 2, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 56, 0, 0, 0, 0, '2019-07-05 13:45:59', NULL, 0, 'VJP7NQVGW1'),
(298, 2, 'Mobilização', 5, 'open', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 57, 0, 0, 0, 0, '2019-07-05 13:46:33', '299,300', 1, 'HJAKEUVIWC'),
(299, 2, 'Solicitação de Acesso', 9, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 57, 0, 0, 0, 0, '2019-07-05 13:46:33', '302', 17, 'I6QR2O1XYU'),
(300, 2, 'Instalação', 5, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 57, 0, 0, 0, 0, '2019-07-05 13:46:33', '301,302,303', 15, '0WPPHBTLL3'),
(301, 2, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 57, 0, 0, 0, 0, '2019-07-05 13:46:33', '304', 1, 'A1OOUM20VC'),
(302, 2, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 57, 0, 0, 0, 0, '2019-07-05 13:46:33', NULL, 2, 'ES4YZAJEKA'),
(303, 2, 'Relatório de Evidências', 5, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 57, 0, 0, 0, 0, '2019-07-05 13:46:33', NULL, 5, 'ZTSJC06TWG'),
(304, 2, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 57, 0, 0, 0, 0, '2019-07-05 13:46:33', NULL, 0, 'TBLASK9H91'),
(305, 2, 'Mobilização', 5, 'open', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 58, 0, 0, 0, 0, '2019-07-05 13:47:04', '306,307', 1, 'T2HVW7C61H'),
(306, 2, 'Solicitação de Acesso', 9, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 58, 0, 0, 0, 0, '2019-07-05 13:47:04', '309', 17, 'XPNVVB4KFO'),
(307, 2, 'Instalação', 5, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 58, 0, 0, 0, 0, '2019-07-05 13:47:04', '308,309,310', 15, 'QIKMGV1MSI'),
(308, 2, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 58, 0, 0, 0, 0, '2019-07-05 13:47:04', '311', 1, 'I45ETMWV8V'),
(309, 2, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 58, 0, 0, 0, 0, '2019-07-05 13:47:04', NULL, 2, 'DYQIZ0LVKJ'),
(310, 2, 'Relatório de Evidências', 5, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 58, 0, 0, 0, 0, '2019-07-05 13:47:04', NULL, 5, 'WWYS28FSSR'),
(311, 2, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 58, 0, 0, 0, 0, '2019-07-05 13:47:04', NULL, 0, 'ZV4UOPG1IP'),
(312, 2, 'Mobilização', 5, 'open', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 59, 0, 0, 0, 0, '2019-07-05 13:47:51', '313,314', 1, 'KCIE5F3GBT'),
(313, 2, 'Solicitação de Acesso', 9, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 59, 0, 0, 0, 0, '2019-07-05 13:47:51', '316', 17, 'LISEEREFSL'),
(314, 2, 'Instalação', 5, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 59, 0, 0, 0, 0, '2019-07-05 13:47:51', '315,316,317', 15, 'AD3LTP1U1P'),
(315, 2, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 59, 0, 0, 0, 0, '2019-07-05 13:47:51', '318', 1, 'OOCNHYFW5M'),
(316, 2, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 59, 0, 0, 0, 0, '2019-07-05 13:47:51', NULL, 2, 'CLIWTT0YWP'),
(317, 2, 'Relatório de Evidências', 5, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 59, 0, 0, 0, 0, '2019-07-05 13:47:51', NULL, 5, 'VTHMBDE2AB'),
(318, 2, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 59, 0, 0, 0, 0, '2019-07-05 13:47:51', NULL, 0, 'DM0OVAXUOW'),
(319, 2, 'Mobilização', 5, 'open', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 60, 0, 0, 0, 0, '2019-07-05 13:48:30', '320,321', 1, '8WEGCQC4HI'),
(320, 2, 'Solicitação de Acesso', 9, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 60, 0, 0, 0, 0, '2019-07-05 13:48:30', '323', 17, '7TZRYQIO0G'),
(321, 2, 'Instalação', 5, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 60, 0, 0, 0, 0, '2019-07-05 13:48:30', '322,323,324', 15, '3S5Q9O1ABD'),
(322, 2, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 60, 0, 0, 0, 0, '2019-07-05 13:48:30', '325', 1, 'BFCYO9HDFP'),
(323, 2, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 60, 0, 0, 0, 0, '2019-07-05 13:48:30', NULL, 2, '5K0WBGJRPA'),
(324, 2, 'Relatório de Evidências', 5, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 60, 0, 0, 0, 0, '2019-07-05 13:48:30', NULL, 5, 'SOOACUTEGB'),
(325, 2, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 60, 0, 0, 0, 0, '2019-07-05 13:48:30', NULL, 0, '7A0SB4BB94'),
(326, 2, 'Mobilização', 5, 'open', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 61, 0, 0, 0, 0, '2019-07-05 13:49:13', '327,328', 1, 'WOXU0H1RPU'),
(327, 2, 'Solicitação de Acesso', 9, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 61, 0, 0, 0, 0, '2019-07-05 13:49:13', '274', 17, 'KUXOLS2TFV'),
(328, 2, 'Instalação', 5, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 61, 0, 0, 0, 0, '2019-07-05 13:49:13', '329,330,331', 15, 'B8L9UPN3Q9');
INSERT INTO `project_task` (`id`, `project_id`, `name`, `user_id`, `status`, `public`, `datetime`, `description`, `start_date`, `due_date`, `completion_date`, `value`, `priority`, `time`, `client_id`, `created_by_client`, `tracking`, `time_spent`, `milestone_id`, `invoice_id`, `milestone_order`, `task_order`, `progress`, `created_at`, `sucessors`, `scheduled_time`, `reference`) VALUES
(329, 2, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 61, 0, 0, 0, 0, '2019-07-05 13:49:13', '332', 1, 'SVCUQFTL3S'),
(330, 2, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 61, 0, 0, 0, 0, '2019-07-05 13:49:13', NULL, 2, 'TFJBOCA6FB'),
(331, 2, 'Relatório de Evidências', 5, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 61, 0, 0, 0, 0, '2019-07-05 13:49:13', NULL, 5, 'EVDAP2DWNY'),
(332, 2, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 61, 0, 0, 0, 0, '2019-07-05 13:49:13', NULL, 0, 'TWNVFO6LDW'),
(333, 2, 'Mobilização', 5, 'open', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 62, 0, 0, 0, 0, '2019-07-05 13:49:51', '334,335', 1, 'JADAXAWNH0'),
(334, 2, 'Solicitação de Acesso', 9, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 62, 0, 0, 0, 0, '2019-07-05 13:49:51', '337', 17, 'BY2CFURL0J'),
(335, 2, 'Instalação', 5, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 62, 0, 0, 0, 0, '2019-07-05 13:49:51', '336,337,338', 15, 'IN1VQFGAEQ'),
(336, 2, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 62, 0, 0, 0, 0, '2019-07-05 13:49:51', '339', 1, 'T2OOUEZRWN'),
(337, 2, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 62, 0, 0, 0, 0, '2019-07-05 13:49:51', NULL, 2, '4YQD6YPL94'),
(338, 2, 'Relatório de Evidências', 5, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 62, 0, 0, 0, 0, '2019-07-05 13:49:51', NULL, 5, 'BOYNRWDTCK'),
(339, 2, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 62, 0, 0, 0, 0, '2019-07-05 13:49:51', NULL, 0, 'SRMTBFBEDW'),
(340, 2, 'Mobilização', 5, 'open', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 63, 0, 0, 0, 0, '2019-07-05 13:51:47', '341,342', 1, 'EZFOV3CXLA'),
(341, 2, 'Solicitação de Acesso', 9, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 63, 0, 0, 0, 0, '2019-07-05 13:51:47', '344', 17, 'VWMJPMLAL5'),
(342, 2, 'Instalação', 5, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 63, 0, 0, 0, 0, '2019-07-05 13:51:47', '343,344,345', 15, 'NIQIZBHSN4'),
(343, 2, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 63, 0, 0, 0, 0, '2019-07-05 13:51:47', '346', 1, 'QZBWCUALYB'),
(344, 2, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 63, 0, 0, 0, 0, '2019-07-05 13:51:47', NULL, 2, 'PVQJHTAFYI'),
(345, 2, 'Relatório de Evidências', 5, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 63, 0, 0, 0, 0, '2019-07-05 13:51:47', NULL, 5, 'CL1XYANTST'),
(346, 2, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 63, 0, 0, 0, 0, '2019-07-05 13:51:47', NULL, 0, 'MRT0PKLBIL'),
(347, 2, 'Mobilização', 5, 'open', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 64, 0, 0, 0, 0, '2019-07-05 13:52:28', '348,349', 1, 'G519S1QAU2'),
(348, 2, 'Solicitação de Acesso', 9, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 64, 0, 0, 0, 0, '2019-07-05 13:52:28', '351', 17, 'ORAUZA2GZZ'),
(349, 2, 'Instalação', 5, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 64, 0, 0, 0, 0, '2019-07-05 13:52:28', '350,351,352', 15, 'LUNGRUXHSV'),
(350, 2, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 64, 0, 0, 0, 0, '2019-07-05 13:52:28', '353', 1, 'YV6FJCHNOF'),
(351, 2, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 64, 0, 0, 0, 0, '2019-07-05 13:52:28', NULL, 2, 'YGJB4FBVAE'),
(352, 2, 'Relatório de Evidências', 5, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 64, 0, 0, 0, 0, '2019-07-05 13:52:28', NULL, 5, 'TQW3SJ8OMG'),
(353, 2, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 64, 0, 0, 0, 0, '2019-07-05 13:52:28', NULL, 0, 'FP6PFGF4CK'),
(354, 2, 'Mobilização', 5, 'open', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 65, 0, 0, 0, 0, '2019-07-05 13:53:10', '355,356', 1, 'UVNHGVDW8P'),
(355, 2, 'Solicitação de Acesso', 9, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 65, 0, 0, 0, 0, '2019-07-05 13:53:10', NULL, 17, '9XKRSFQZSU'),
(356, 2, 'Instalação', 5, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 65, 0, 0, 0, 0, '2019-07-05 13:53:10', '357,358,359', 15, 'KJJNUGGIRE'),
(357, 2, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '', '', NULL, 0, 2, NULL, 0, 0, 0, 0, 65, 0, 0, 0, 0, '2019-07-05 13:53:10', '360', 1, 'ZAHJEXEO2B'),
(358, 2, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 65, 0, 0, 0, 0, '2019-07-05 13:53:10', NULL, 2, '2JVTONU4NL'),
(359, 2, 'Relatório de Evidências', 5, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 65, 0, 0, 0, 0, '2019-07-05 13:53:10', NULL, 5, 'LTTEFUL0E9'),
(360, 2, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 65, 0, 0, 0, 0, '2019-07-05 13:53:10', NULL, 0, 'Y3HGMJDRID'),
(361, 4, 'Cotação WEG', 5, 'done', 0, NULL, '', '2019-07-09 12:00', '2019-07-11 12:00', '2019-07-25 13:53', 0, 2, NULL, 0, 0, 0, 0, 66, 0, 0, 0, 0, '2019-07-05 14:00:04', '363', 3, 'GD9A94ROD5'),
(362, 4, 'Cotação SICES', 5, 'done', 0, NULL, '', '2019-07-10 12:00', '2019-07-15 12:00', '2019-07-25 13:54', 0, 2, NULL, 0, 0, 0, 0, 66, 0, 0, 0, 0, '2019-07-05 14:00:04', '363', 3, 'WIY3HCOUXQ'),
(363, 4, 'Negociação', 5, 'done', 0, NULL, '<p>A negociação será feita com a cotação de melhor custo benefício entre WEG e SICES</p>', '2019-07-25 13:54', '2019-07-29 13:54', '2019-07-25 13:54', 0, 2, NULL, 0, 0, 0, 0, 66, 0, 0, 0, 0, '2019-07-05 14:00:04', '364', 2, 'ZPWRSOHJSN'),
(364, 4, 'Pagamento Inicial', 6, 'done', 0, NULL, 'Pagamento pode ser feito em até 5 dias.', '2019-07-25 13:54', '2019-08-01 13:54', '2019-07-25 13:54', 0, 2, NULL, 0, 0, 0, 0, 66, 0, 0, 0, 0, '2019-07-05 14:00:04', '365', 5, 'OSA1STUJVE'),
(365, 4, 'Entrega', 5, 'done', 0, NULL, 'Fazer o acompanhamento da entrega junto a fornecedora e a transportadoras. Tomar cuidado com local de entrega.', '2019-07-25 13:54', '2019-08-22 13:54', '2019-07-25 13:54', 0, 2, NULL, 0, 0, 0, 0, 66, 0, 0, 0, 0, '2019-07-05 14:00:04', NULL, 20, 'F6Q9INVDTT'),
(366, 4, 'Atualizar Lista de Material do Almoxarifado', 0, 'done', 0, NULL, 'No dia 25 de cada mês, Vander deverá atualizar os materiais do almoxarifado para levantamento de qual insumo está faltando e deve ser reposto, assim como quanto foi gasto de cada material.', '2019-06-26 12:00', '2019-08-05 12:00', '2019-08-07 10:13', 0, 2, NULL, 0, 0, 0, 0, 67, 0, 0, 0, 0, '2019-07-05 14:00:04', '367', 28, 'WHSHMNAWDW'),
(367, 4, 'Definir Lista de Materiais para Cotação', 0, 'done', 0, NULL, 'A partir do levantamento do estoque, Vander deverá fazer lista para cotação dos materiais necessários.', '2019-08-07 10:13', '2019-08-08 10:13', '2019-08-07 10:13', 0, 2, NULL, 0, 0, 0, 0, 67, 0, 0, 0, 0, '2019-07-05 14:00:04', '368,369,370,371', 1, 'P9AOC5BQTI'),
(368, 4, 'Cotar Loja Elétrica', 5, 'done', 0, NULL, '', '2019-08-07 10:13', '2019-08-09 10:13', '2019-08-07 10:14', 0, 2, NULL, 0, 0, 0, 0, 67, 0, 0, 0, 0, '2019-07-05 14:00:04', '372', 2, 'C0SIYPNGBT'),
(369, 4, 'Cotação na MLM', 5, 'done', 0, NULL, '', '2019-08-07 10:13', '2019-08-07 10:13', '2019-08-07 10:14', 0, 2, NULL, 0, 0, 0, 0, 67, 0, 0, 0, 0, '2019-07-05 14:00:04', '372', 0, 'JFQGIY4NBE'),
(370, 4, 'Cotação na Universo Elétrico', 5, 'done', 0, NULL, '', '2019-08-07 10:13', '2019-08-09 10:13', '2019-08-07 10:14', 0, 2, NULL, 0, 0, 0, 0, 67, 0, 0, 0, 0, '2019-07-05 14:00:04', '372', 2, 'JCXLBBJ9DO'),
(371, 4, 'Cotação na Othon de Carvalho', 5, 'done', 0, NULL, '', '2019-08-07 10:13', '2019-08-09 10:13', '2019-08-07 10:14', 0, 2, NULL, 0, 0, 0, 0, 67, 0, 0, 0, 0, '2019-07-05 14:00:04', '372', 2, 'CQ79MBOZYS'),
(372, 4, 'Negociação (AL)', 5, 'done', 0, NULL, 'Negociação com as fornecedoras para obter melhor preço.', '2019-08-07 10:14', '2019-08-09 10:14', '2019-08-07 10:14', 0, 2, NULL, 0, 0, 0, 0, 67, 0, 0, 0, 0, '2019-07-05 14:00:04', '373', 2, 'OGQBNLATMJ'),
(373, 4, 'Emissão do Pedido', 5, 'done', 0, NULL, 'Fazer pedido junto a fornecedora com melhor preço.', '2019-08-07 10:14', '2019-08-08 10:14', '2019-08-07 10:14', 0, 2, NULL, 0, 0, 0, 0, 67, 0, 0, 0, 0, '2019-07-05 14:00:04', '374', 1, 'QE2GL2ZMZM'),
(374, 4, 'Coleta do Material', 0, 'done', NULL, NULL, 'Após emissão do pedido, Vander deverá buscar os materiais comprados na fornecedora.', '2019-08-07 10:14', '2019-08-08 10:14', '2019-08-07 10:14', 0, 2, NULL, 0, 0, 0, 0, 67, 0, 0, 0, 0, '2019-07-05 14:00:04', NULL, 1, 'SDD2MAOSFP'),
(375, 4, 'Mobilização', 5, 'done', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '2019-06-26 12:00', '2019-06-27 12:00', '2019-07-09 16:13', 0, 2, NULL, 0, 0, 0, 0, 68, 0, 0, 0, 0, '2019-07-05 14:00:05', '376,377', 1, 'RYIEO2T20U'),
(376, 4, 'Solicitação de Acesso', 9, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '2019-07-09 16:13', '2019-08-01 16:13', '2019-07-25 10:15', 0, 2, NULL, 0, 0, 0, 0, 68, 0, 0, 0, 0, '2019-07-05 14:00:05', '379', 17, 'JRJS4K5LXK'),
(377, 4, 'Instalação', 5, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '2019-07-09 16:13', '2019-07-30 16:13', '2019-07-10 11:22', 0, 2, NULL, 0, 0, 0, 0, 68, 0, 0, 0, 0, '2019-07-05 14:00:05', '378,379,380', 15, 'QLRBK9R4EY'),
(378, 4, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '2019-07-10 11:22', '2019-07-11 11:22', NULL, 0, 2, NULL, 0, 0, 0, 0, 68, 0, 0, 0, 0, '2019-07-05 14:00:05', '381', 1, 'DRWV4HH9RH'),
(379, 4, 'Pedido de Vistoria', 9, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', '2019-07-25 10:15', '2019-07-29 10:15', '2019-07-25 10:15', 0, 2, NULL, 0, 0, 0, 0, 68, 0, 0, 0, 0, '2019-07-05 14:00:05', NULL, 2, '77DJ1JGXOW'),
(380, 4, 'Relatório de Evidências', 5, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', '2019-07-10 11:22', '2019-07-17 11:22', '2019-07-25 13:54', 0, 2, NULL, 0, 0, 0, 0, 68, 0, 0, 0, 0, '2019-07-05 14:00:05', NULL, 5, 'UCAULINCYS'),
(381, 4, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 68, 0, 0, 0, 0, '2019-07-05 14:00:05', NULL, 0, 'KNFXSGOA87'),
(382, 4, 'Mobilização', 5, 'done', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '2019-06-26 12:00', '2019-06-27 12:00', '2019-07-09 16:26', 0, 2, NULL, 0, 0, 0, 0, 69, 0, 0, 0, 0, '2019-07-05 14:00:05', '383,384', 1, 'LGAQR6ZDDW'),
(383, 4, 'Solicitação de Acesso', 9, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '2019-07-09 16:26', '2019-08-01 16:26', '2019-07-25 10:15', 0, 2, NULL, 0, 0, 0, 0, 69, 0, 0, 0, 0, '2019-07-05 14:00:05', '386', 17, 'IHHJTA36EA'),
(384, 4, 'Instalação', 5, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '2019-07-09 16:26', '2019-07-30 16:26', '2019-07-10 11:22', 0, 2, NULL, 0, 0, 0, 0, 69, 0, 0, 0, 0, '2019-07-05 14:00:05', '385,386,387', 15, 'B7P3FEYBVL'),
(385, 4, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '2019-07-10 11:22', '2019-07-10 11:22', NULL, 0, 2, NULL, 0, 0, 0, 0, 69, 0, 0, 0, 0, '2019-07-05 14:00:05', '388', 0, 'XKBHFKXOOL'),
(386, 4, 'Pedido de Vistoria', 9, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', '2019-07-25 10:15', '2019-07-29 10:15', '2019-07-25 10:15', 0, 2, NULL, 0, 0, 0, 0, 69, 0, 0, 0, 0, '2019-07-05 14:00:05', NULL, 2, 'J2FFP5O3DB'),
(387, 4, 'Relatório de Evidências', 5, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', '2019-07-10 11:22', '2019-07-17 11:22', '2019-07-25 13:54', 0, 2, NULL, 0, 0, 0, 0, 69, 0, 0, 0, 0, '2019-07-05 14:00:05', NULL, 5, 'EDRLVKP7SJ'),
(388, 4, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 69, 0, 0, 0, 0, '2019-07-05 14:00:05', NULL, 0, 'KKRCRNXAUW'),
(389, 4, 'Mobilização', 5, 'done', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '2019-07-01 12:00', '2019-07-02 12:00', '2019-07-09 16:29', 0, 2, NULL, 0, 0, 0, 0, 70, 0, 0, 0, 0, '2019-07-05 14:00:05', '390,391', 1, 'WCNBM0UYOU'),
(390, 4, 'Solicitação de Acesso', 9, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '2019-07-09 16:29', '2019-08-01 16:29', '2019-07-25 10:16', 0, 2, NULL, 0, 0, 0, 0, 70, 0, 0, 0, 0, '2019-07-05 14:00:05', '393', 17, 'N1LEKTTZRX'),
(391, 4, 'Instalação', 5, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '2019-07-09 16:29', '2019-07-30 16:29', '2019-07-10 11:22', 0, 2, NULL, 0, 0, 0, 0, 70, 0, 0, 0, 0, '2019-07-05 14:00:05', '392,393,394', 15, 'U7GGHUBQJF'),
(392, 4, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '2019-07-10 11:22', '2019-07-11 11:22', NULL, 0, 2, NULL, 0, 0, 0, 0, 70, 0, 0, 0, 0, '2019-07-05 14:00:05', '395', 1, 'F07PMO6HK8'),
(393, 4, 'Pedido de Vistoria', 9, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', '2019-07-25 10:16', '2019-07-29 10:16', '2019-07-25 10:16', 0, 2, NULL, 0, 0, 0, 0, 70, 0, 0, 0, 0, '2019-07-05 14:00:05', NULL, 2, '7OV6GPSDIQ'),
(394, 4, 'Relatório de Evidências', 5, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', '2019-07-10 11:22', '2019-07-17 11:22', '2019-07-25 13:55', 0, 2, NULL, 0, 0, 0, 0, 70, 0, 0, 0, 0, '2019-07-05 14:00:05', NULL, 5, 'ST5ERYWZEJ'),
(395, 4, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 70, 0, 0, 0, 0, '2019-07-05 14:00:05', NULL, 0, 'OD9RDPDH5I'),
(396, 4, 'Mobilização', 5, 'done', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '2019-06-27 12:00', '2019-06-28 12:00', '2019-07-09 16:32', 0, 2, NULL, 0, 0, 0, 0, 71, 0, 0, 0, 0, '2019-07-05 14:00:05', '397,398', 1, 'EYMRB7K9NP'),
(397, 4, 'Solicitação de Acesso', 9, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '2019-07-09 16:32', '2019-08-01 16:32', '2019-07-17 12:23', 0, 2, NULL, 0, 0, 0, 0, 71, 0, 0, 0, 0, '2019-07-05 14:00:05', '400', 17, 'ZFC1H3Q0XF'),
(398, 4, 'Instalação', 5, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '2019-07-09 16:32', '2019-07-30 16:32', '2019-07-10 11:22', 0, 2, NULL, 0, 0, 0, 0, 71, 0, 0, 0, 0, '2019-07-05 14:00:05', '399,400,401', 15, 'JEVPPURWRM'),
(399, 4, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '2019-07-10 11:22', '2019-07-10 11:22', NULL, 0, 2, NULL, 0, 0, 0, 0, 71, 0, 0, 0, 0, '2019-07-05 14:00:06', '402', 0, 'X3PHPMFOJK'),
(400, 4, 'Pedido de Vistoria', 9, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', '2019-07-17 12:23', '2019-07-19 12:23', '2019-07-17 12:23', 0, 2, NULL, 0, 0, 0, 0, 71, 0, 0, 0, 0, '2019-07-05 14:00:06', NULL, 2, 'E8JGZIHATD'),
(401, 4, 'Relatório de Evidências', 5, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', '2019-07-10 11:22', '2019-07-17 11:22', '2019-07-25 13:55', 0, 2, NULL, 0, 0, 0, 0, 71, 0, 0, 0, 0, '2019-07-05 14:00:06', NULL, 5, '2UZECOEADM'),
(402, 4, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 71, 0, 0, 0, 0, '2019-07-05 14:00:06', NULL, 0, 'VJP7NQVGW1'),
(403, 4, 'Mobilização', 5, 'done', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '2019-07-01 12:00', '2019-07-01 12:00', '2019-07-09 16:42', 0, 2, NULL, 0, 0, 0, 0, 72, 0, 0, 0, 0, '2019-07-05 14:00:06', '404,405', 1, 'HJAKEUVIWC'),
(404, 4, 'Solicitação de Acesso', 9, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '2019-07-09 16:42', '2019-08-01 16:42', '2019-08-07 10:19', 0, 2, NULL, 0, 0, 0, 0, 72, 0, 0, 0, 0, '2019-07-05 14:00:06', '407', 17, 'I6QR2O1XYU'),
(405, 4, 'Instalação', 5, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '2019-07-09 16:42', '2019-07-30 16:42', '2019-07-10 11:23', 0, 2, NULL, 0, 0, 0, 0, 72, 0, 0, 0, 0, '2019-07-05 14:00:06', '406,407,408', 15, '0WPPHBTLL3'),
(406, 4, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '2019-07-10 11:23', '2019-07-10 11:23', NULL, 0, 2, NULL, 0, 0, 0, 0, 72, 0, 0, 0, 0, '2019-07-05 14:00:06', '409', 0, 'A1OOUM20VC'),
(407, 4, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', '2019-08-07 10:19', '2019-08-09 10:19', NULL, 0, 2, NULL, 0, 0, 0, 0, 72, 0, 0, 0, 0, '2019-07-05 14:00:06', NULL, 2, 'ES4YZAJEKA'),
(408, 4, 'Relatório de Evidências', 5, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', '2019-07-10 11:23', '2019-07-17 11:23', '2019-07-25 13:56', 0, 2, NULL, 0, 0, 0, 0, 72, 0, 0, 0, 0, '2019-07-05 14:00:06', NULL, 5, 'ZTSJC06TWG'),
(409, 4, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 72, 0, 0, 0, 0, '2019-07-05 14:00:06', NULL, 0, 'TBLASK9H91'),
(410, 4, 'Mobilização', 5, 'done', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '2019-07-03 12:00', '2019-07-04 12:00', '2019-07-09 16:50', 0, 2, NULL, 0, 0, 0, 0, 73, 0, 0, 0, 0, '2019-07-05 14:00:07', '411,412', 1, 'T2HVW7C61H'),
(411, 4, 'Solicitação de Acesso', 9, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '2019-07-09 16:50', '2019-08-01 16:50', '2019-07-17 12:23', 0, 2, NULL, 0, 0, 0, 0, 73, 0, 0, 0, 0, '2019-07-05 14:00:07', '414', 17, 'XPNVVB4KFO'),
(412, 4, 'Instalação', 5, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '2019-07-09 16:50', '2019-07-30 16:50', '2019-07-10 11:23', 0, 2, NULL, 0, 0, 0, 0, 73, 0, 0, 0, 0, '2019-07-05 14:00:07', '413,414,415', 15, 'QIKMGV1MSI'),
(413, 4, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '2019-07-10 11:23', '2019-07-10 11:23', NULL, 0, 2, NULL, 0, 0, 0, 0, 73, 0, 0, 0, 0, '2019-07-05 14:00:07', '416', 0, 'I45ETMWV8V'),
(414, 4, 'Pedido de Vistoria', 9, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', '2019-07-17 12:23', '2019-07-19 12:23', '2019-07-17 12:23', 0, 2, NULL, 0, 0, 0, 0, 73, 0, 0, 0, 0, '2019-07-05 14:00:07', NULL, 2, 'DYQIZ0LVKJ');
INSERT INTO `project_task` (`id`, `project_id`, `name`, `user_id`, `status`, `public`, `datetime`, `description`, `start_date`, `due_date`, `completion_date`, `value`, `priority`, `time`, `client_id`, `created_by_client`, `tracking`, `time_spent`, `milestone_id`, `invoice_id`, `milestone_order`, `task_order`, `progress`, `created_at`, `sucessors`, `scheduled_time`, `reference`) VALUES
(415, 4, 'Relatório de Evidências', 5, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', '2019-07-10 11:23', '2019-07-17 11:23', '2019-07-25 13:56', 0, 2, NULL, 0, 0, 0, 0, 73, 0, 0, 0, 0, '2019-07-05 14:00:07', NULL, 5, 'WWYS28FSSR'),
(416, 4, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 73, 0, 0, 0, 0, '2019-07-05 14:00:07', NULL, 0, 'ZV4UOPG1IP'),
(417, 4, 'Mobilização', 5, 'done', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '2019-07-03 12:00', '2019-07-04 12:00', '2019-07-09 16:54', 0, 2, NULL, 0, 0, 0, 0, 74, 0, 0, 0, 0, '2019-07-05 14:00:07', '418,419', 1, 'KCIE5F3GBT'),
(418, 4, 'Solicitação de Acesso', 9, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '2019-07-09 16:54', '2019-08-01 16:54', '2019-07-25 10:16', 0, 2, NULL, 0, 0, 0, 0, 74, 0, 0, 0, 0, '2019-07-05 14:00:07', '421', 17, 'LISEEREFSL'),
(419, 4, 'Instalação', 5, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '2019-07-09 16:54', '2019-07-30 16:54', '2019-07-10 11:23', 0, 2, NULL, 0, 0, 0, 0, 74, 0, 0, 0, 0, '2019-07-05 14:00:07', '420,421,422', 15, 'AD3LTP1U1P'),
(420, 4, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '2019-07-10 11:23', '2019-07-10 11:23', NULL, 0, 2, NULL, 0, 0, 0, 0, 74, 0, 0, 0, 0, '2019-07-05 14:00:08', '423', 0, 'OOCNHYFW5M'),
(421, 4, 'Pedido de Vistoria', 9, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', '2019-07-25 10:16', '2019-07-29 10:16', '2019-07-25 10:16', 0, 2, NULL, 0, 0, 0, 0, 74, 0, 0, 0, 0, '2019-07-05 14:00:08', NULL, 2, 'CLIWTT0YWP'),
(422, 4, 'Relatório de Evidências', 5, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', '2019-07-10 11:23', '2019-07-17 11:23', '2019-07-25 13:56', 0, 2, NULL, 0, 0, 0, 0, 74, 0, 0, 0, 0, '2019-07-05 14:00:08', NULL, 5, 'VTHMBDE2AB'),
(423, 4, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 74, 0, 0, 0, 0, '2019-07-05 14:00:08', NULL, 0, 'DM0OVAXUOW'),
(424, 4, 'Mobilização', 5, 'done', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '2019-07-04 12:00', '2019-07-05 12:00', '2019-07-09 17:08', 0, 2, NULL, 0, 0, 0, 0, 75, 0, 0, 0, 0, '2019-07-05 14:00:08', '425,426', 1, '8WEGCQC4HI'),
(425, 4, 'Solicitação de Acesso', 9, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '2019-07-09 17:08', '2019-08-01 17:08', '2019-07-25 10:16', 0, 2, NULL, 0, 0, 0, 0, 75, 0, 0, 0, 0, '2019-07-05 14:00:08', '428', 17, '7TZRYQIO0G'),
(426, 4, 'Instalação', 5, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '2019-07-09 17:08', '2019-07-30 17:08', '2019-07-10 11:23', 0, 2, NULL, 0, 0, 0, 0, 75, 0, 0, 0, 0, '2019-07-05 14:00:08', '427,428,429', 15, '3S5Q9O1ABD'),
(427, 4, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '2019-07-10 11:23', '2019-07-10 11:23', NULL, 0, 2, NULL, 0, 0, 0, 0, 75, 0, 0, 0, 0, '2019-07-05 14:00:08', '430', 0, 'BFCYO9HDFP'),
(428, 4, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', '2019-07-25 10:16', '2019-07-29 10:16', NULL, 0, 2, NULL, 0, 0, 0, 0, 75, 0, 0, 0, 0, '2019-07-05 14:00:08', NULL, 2, '5K0WBGJRPA'),
(429, 4, 'Relatório de Evidências', 5, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', '2019-07-10 11:23', '2019-07-17 11:23', '2019-07-25 13:56', 0, 2, NULL, 0, 0, 0, 0, 75, 0, 0, 0, 0, '2019-07-05 14:00:08', NULL, 5, 'SOOACUTEGB'),
(430, 4, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 75, 0, 0, 0, 0, '2019-07-05 14:00:08', NULL, 0, '7A0SB4BB94'),
(431, 4, 'Mobilização', 5, 'done', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '2019-07-09 12:00', '2019-07-09 12:00', '2019-07-09 17:14', 0, 2, NULL, 0, 0, 0, 0, 76, 0, 0, 0, 0, '2019-07-05 14:00:08', '432,433', 1, 'WOXU0H1RPU'),
(432, 4, 'Solicitação de Acesso', 9, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '2019-07-09 17:14', '2019-08-01 17:14', '2019-07-25 10:17', 0, 2, NULL, 0, 0, 0, 0, 76, 0, 0, 0, 0, '2019-07-05 14:00:08', '435', 17, 'KUXOLS2TFV'),
(433, 4, 'Instalação', 5, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '2019-07-09 17:14', '2019-07-30 17:14', '2019-07-10 11:23', 0, 2, NULL, 0, 0, 0, 0, 76, 0, 0, 0, 0, '2019-07-05 14:00:08', '434,435,436', 15, 'B8L9UPN3Q9'),
(434, 4, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '2019-07-10 11:23', '2019-07-10 11:23', NULL, 0, 2, NULL, 0, 0, 0, 0, 76, 0, 0, 0, 0, '2019-07-05 14:00:08', '437', 0, 'SVCUQFTL3S'),
(435, 4, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', '2019-07-25 10:17', '2019-07-29 10:17', NULL, 0, 2, NULL, 0, 0, 0, 0, 76, 0, 0, 0, 0, '2019-07-05 14:00:08', NULL, 2, 'TFJBOCA6FB'),
(436, 4, 'Relatório de Evidências', 5, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', '2019-07-10 11:23', '2019-07-17 11:23', '2019-07-25 13:56', 0, 2, NULL, 0, 0, 0, 0, 76, 0, 0, 0, 0, '2019-07-05 14:00:08', NULL, 5, 'EVDAP2DWNY'),
(437, 4, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 76, 0, 0, 0, 0, '2019-07-05 14:00:08', NULL, 0, 'TWNVFO6LDW'),
(438, 4, 'Mobilização', 5, 'done', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '2019-07-09 12:00', '2019-07-10 12:00', '2019-07-09 17:21', 0, 2, NULL, 0, 0, 0, 0, 77, 0, 0, 0, 0, '2019-07-05 14:00:09', '439,440', 1, 'JADAXAWNH0'),
(439, 4, 'Solicitação de Acesso', 9, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '2019-07-09 17:21', '2019-08-01 17:21', '2019-07-25 10:17', 0, 2, NULL, 0, 0, 0, 0, 77, 0, 0, 0, 0, '2019-07-05 14:00:09', '442', 17, 'BY2CFURL0J'),
(440, 4, 'Instalação', 5, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '2019-07-09 17:21', '2019-07-30 17:21', '2019-07-25 10:17', 0, 2, NULL, 0, 0, 0, 0, 77, 0, 0, 0, 0, '2019-07-05 14:00:09', '441,442,443', 15, 'IN1VQFGAEQ'),
(441, 4, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '2019-07-25 10:17', '2019-07-25 10:17', NULL, 0, 2, NULL, 0, 0, 0, 0, 77, 0, 0, 0, 0, '2019-07-05 14:00:09', '444', 0, 'T2OOUEZRWN'),
(442, 4, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', '2019-07-25 10:17', '2019-07-29 10:17', NULL, 0, 2, NULL, 0, 0, 0, 0, 77, 0, 0, 0, 0, '2019-07-05 14:00:09', NULL, 2, '4YQD6YPL94'),
(443, 4, 'Relatório de Evidências', 5, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', '2019-07-25 10:17', '2019-08-01 10:17', NULL, 0, 2, NULL, 0, 0, 0, 0, 77, 0, 0, 0, 0, '2019-07-05 14:00:09', NULL, 5, 'BOYNRWDTCK'),
(444, 4, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 77, 0, 0, 0, 0, '2019-07-05 14:00:09', NULL, 0, 'SRMTBFBEDW'),
(445, 4, 'Mobilização', 5, 'done', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '2019-07-12 12:00', '2019-07-15 12:00', '2019-07-09 17:27', 0, 2, NULL, 0, 0, 0, 0, 78, 0, 0, 0, 0, '2019-07-05 14:00:09', '446,447', 1, 'EZFOV3CXLA'),
(446, 4, 'Solicitação de Acesso', 9, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '2019-07-09 17:27', '2019-08-01 17:27', '2019-08-07 10:13', 0, 2, NULL, 0, 0, 0, 0, 78, 0, 0, 0, 0, '2019-07-05 14:00:09', '449', 17, 'VWMJPMLAL5'),
(447, 4, 'Instalação', 5, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '2019-07-09 17:27', '2019-07-30 17:27', '2019-07-25 10:17', 0, 2, NULL, 0, 0, 0, 0, 78, 0, 0, 0, 0, '2019-07-05 14:00:09', '448,449,450', 15, 'NIQIZBHSN4'),
(448, 4, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '2019-07-25 10:17', '2019-07-25 10:17', NULL, 0, 2, NULL, 0, 0, 0, 0, 78, 0, 0, 0, 0, '2019-07-05 14:00:09', '451', 0, 'QZBWCUALYB'),
(449, 4, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', '2019-08-07 10:13', '2019-08-09 10:13', NULL, 0, 2, NULL, 0, 0, 0, 0, 78, 0, 0, 0, 0, '2019-07-05 14:00:09', NULL, 2, 'PVQJHTAFYI'),
(450, 4, 'Relatório de Evidências', 5, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', '2019-07-25 10:17', '2019-08-01 10:17', '2019-07-25 13:57', 0, 2, NULL, 0, 0, 0, 0, 78, 0, 0, 0, 0, '2019-07-05 14:00:09', NULL, 5, 'CL1XYANTST'),
(451, 4, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 78, 0, 0, 0, 0, '2019-07-05 14:00:09', NULL, 0, 'MRT0PKLBIL'),
(452, 4, 'Mobilização', 5, 'done', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '2019-07-04 12:00', '2019-07-05 12:00', '2019-07-10 11:16', 0, 2, NULL, 0, 0, 0, 0, 79, 0, 0, 0, 0, '2019-07-05 14:00:09', '453,454', 1, 'G519S1QAU2'),
(453, 4, 'Solicitação de Acesso', 9, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '2019-07-10 11:16', '2019-08-02 11:16', '2019-08-07 10:13', 0, 2, NULL, 0, 0, 0, 0, 79, 0, 0, 0, 0, '2019-07-05 14:00:09', '456', 17, 'ORAUZA2GZZ'),
(454, 4, 'Instalação', 5, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '2019-07-10 11:16', '2019-07-31 11:16', '2019-07-10 11:23', 0, 2, NULL, 0, 0, 0, 0, 79, 0, 0, 0, 0, '2019-07-05 14:00:09', '455,456,457', 15, 'LUNGRUXHSV'),
(455, 4, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '2019-07-10 11:23', '2019-07-10 11:23', NULL, 0, 2, NULL, 0, 0, 0, 0, 79, 0, 0, 0, 0, '2019-07-05 14:00:09', '458', 0, 'YV6FJCHNOF'),
(456, 4, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', '2019-08-07 10:13', '2019-08-09 10:13', NULL, 0, 2, NULL, 0, 0, 0, 0, 79, 0, 0, 0, 0, '2019-07-05 14:00:09', NULL, 2, 'YGJB4FBVAE'),
(457, 4, 'Relatório de Evidências', 5, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', '2019-07-10 11:23', '2019-07-17 11:23', '2019-07-25 13:57', 0, 2, NULL, 0, 0, 0, 0, 79, 0, 0, 0, 0, '2019-07-05 14:00:09', NULL, 5, 'TQW3SJ8OMG'),
(458, 4, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 79, 0, 0, 0, 0, '2019-07-05 14:00:09', NULL, 0, 'FP6PFGF4CK'),
(459, 4, 'Mobilização', 5, 'done', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '2019-07-12 12:00', '2019-07-15 12:00', '2019-07-25 10:17', 0, 2, NULL, 0, 0, 0, 0, 80, 0, 0, 0, 0, '2019-07-05 14:00:09', '460,461', 1, 'UVNHGVDW8P'),
(460, 4, 'Solicitação de Acesso', 9, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '2019-07-25 10:17', '2019-08-19 10:17', '2019-08-07 10:13', 0, 2, NULL, 0, 0, 0, 0, 80, 0, 0, 0, 0, '2019-07-05 14:00:09', '463', 17, '9XKRSFQZSU'),
(461, 4, 'Instalação', 5, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '2019-07-25 10:17', '2019-08-15 10:17', '2019-07-25 10:17', 0, 2, NULL, 0, 0, 0, 0, 80, 0, 0, 0, 0, '2019-07-05 14:00:09', '462,463,464', 15, 'KJJNUGGIRE'),
(462, 4, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '2019-07-25 10:17', '2019-07-25 10:17', NULL, 0, 2, NULL, 0, 0, 0, 0, 80, 0, 0, 0, 0, '2019-07-05 14:00:09', '465', 0, 'ZAHJEXEO2B'),
(463, 4, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', '2019-08-07 10:13', '2019-08-09 10:13', NULL, 0, 2, NULL, 0, 0, 0, 0, 80, 0, 0, 0, 0, '2019-07-05 14:00:09', NULL, 2, '2JVTONU4NL'),
(464, 4, 'Relatório de Evidências', 5, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', '2019-07-25 10:17', '2019-08-01 10:17', '2019-07-25 13:57', 0, 2, NULL, 0, 0, 0, 0, 80, 0, 0, 0, 0, '2019-07-05 14:00:09', NULL, 5, 'LTTEFUL0E9'),
(465, 4, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 80, 0, 0, 0, 0, '2019-07-05 14:00:09', NULL, 0, 'Y3HGMJDRID'),
(473, 5, 'Cotação WEG', 5, 'open', 0, NULL, '', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 83, 0, 0, 0, 0, '2019-08-08 11:20:40', '475', 2, 'GD9A94ROD5'),
(474, 5, 'Cotação SICES', 5, 'open', 0, NULL, '', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 83, 0, 0, 0, 0, '2019-08-08 11:20:40', '475', 1, 'WIY3HCOUXQ'),
(475, 5, 'Negociação', 5, 'open', 0, NULL, '<p>A negociação será feita com a cotação de melhor custo benefício entre WEG e SICES</p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 83, 0, 0, 0, 0, '2019-08-08 11:20:40', '476', 2, 'ZPWRSOHJSN'),
(476, 5, 'Pagamento Inicial', 6, 'open', 0, NULL, 'Pagamento pode ser feito em até 5 dias.', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 83, 0, 0, 0, 0, '2019-08-08 11:20:40', '477', 5, 'OSA1STUJVE'),
(477, 5, 'Entrega', 5, 'open', 0, NULL, 'Fazer o acompanhamento da entrega junto a fornecedora e a transportadoras. Tomar cuidado com local de entrega.', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 83, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 20, 'F6Q9INVDTT'),
(478, 5, 'Atualizar Lista de Material do Almoxarifado', 0, 'open', 0, NULL, 'No dia 25 de cada mês, Vander deverá atualizar os materiais do almoxarifado para levantamento de qual insumo está faltando e deve ser reposto, assim como quanto foi gasto de cada material.', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 84, 0, 0, 0, 0, '2019-08-08 11:20:40', '479', 25, 'WHSHMNAWDW'),
(479, 5, 'Definir Lista de Materiais para Cotação', 0, 'open', 0, NULL, 'A partir do levantamento do estoque, Vander deverá fazer lista para cotação dos materiais necessários.', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 84, 0, 0, 0, 0, '2019-08-08 11:20:40', '480,481,482,483', 1, 'P9AOC5BQTI'),
(480, 5, 'Cotação na Loja Elétrica', 5, 'open', 0, NULL, '', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 84, 0, 0, 0, 0, '2019-08-08 11:20:40', '484', 2, 'C0SIYPNGBT'),
(481, 5, 'Cotação na MLM', 5, 'open', 0, NULL, '', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 84, 0, 0, 0, 0, '2019-08-08 11:20:40', '484', 0, 'JFQGIY4NBE'),
(482, 5, 'Cotação na Universo Elétrico', 5, 'open', 0, NULL, '', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 84, 0, 0, 0, 0, '2019-08-08 11:20:40', '484', 2, 'JCXLBBJ9DO'),
(483, 5, 'Cotação na Othon de Carvalho', 5, 'open', 0, NULL, '', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 84, 0, 0, 0, 0, '2019-08-08 11:20:40', '484', 2, 'CQ79MBOZYS'),
(484, 5, 'Negociação (AL)', 5, 'open', 0, NULL, 'Negociação com as fornecedoras para obter melhor preço.', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 84, 0, 0, 0, 0, '2019-08-08 11:20:40', '485', 2, 'OGQBNLATMJ'),
(485, 5, 'Emissão do Pedido', 5, 'open', 0, NULL, 'Fazer pedido junto a fornecedora com melhor preço.', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 84, 0, 0, 0, 0, '2019-08-08 11:20:40', '486', 1, 'QE2GL2ZMZM'),
(486, 5, 'Coleta do Material', 0, 'open', NULL, NULL, 'Após emissão do pedido, Vander deverá buscar os materiais comprados na fornecedora.', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 84, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 1, 'SDD2MAOSFP'),
(487, 5, 'Mobilização', 5, 'done', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '2019-07-25 12:00', '2019-07-25 12:00', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 86, 0, 0, 0, 0, '2019-08-08 11:20:40', '488,489', 0, 'RYIEO2T20U'),
(488, 5, 'Solicitação de Acesso', 9, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '2019-08-08 11:37', '2019-09-02 11:37', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 86, 0, 0, 0, 0, '2019-08-08 11:20:40', '491', 17, 'JRJS4K5LXK'),
(489, 5, 'Instalação', 5, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '2019-08-08 11:37', '2019-08-29 11:37', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 86, 0, 0, 0, 0, '2019-08-08 11:20:40', '490,491,492', 15, 'QLRBK9R4EY'),
(490, 5, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-09 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 86, 0, 0, 0, 0, '2019-08-08 11:20:40', '493', 1, 'DRWV4HH9RH'),
(491, 5, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-12 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 86, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 2, '77DJ1JGXOW'),
(492, 5, 'Relatório de Evidências', 5, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-15 11:37', '2019-08-08 11:40', 0, 2, NULL, 0, 0, 0, 0, 86, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 5, 'UCAULINCYS'),
(493, 5, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 86, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 0, 'KNFXSGOA87'),
(494, 5, 'Mobilização', 5, 'done', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '2019-07-25 12:00', '2019-07-26 12:00', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 87, 0, 0, 0, 0, '2019-08-08 11:20:40', '495,496', 1, 'LGAQR6ZDDW'),
(495, 5, 'Solicitação de Acesso', 9, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '2019-08-08 11:37', '2019-09-02 11:37', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 87, 0, 0, 0, 0, '2019-08-08 11:20:40', '498', 17, 'IHHJTA36EA'),
(496, 5, 'Instalação', 5, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '2019-08-08 11:37', '2019-08-29 11:37', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 87, 0, 0, 0, 0, '2019-08-08 11:20:40', '497,498,499', 15, 'B7P3FEYBVL'),
(497, 5, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-09 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 87, 0, 0, 0, 0, '2019-08-08 11:20:40', '500', 1, 'XKBHFKXOOL'),
(498, 5, 'Pedido de Vistoria', 9, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-12 11:37', '2019-08-08 11:40', 0, 2, NULL, 0, 0, 0, 0, 87, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 2, 'J2FFP5O3DB'),
(499, 5, 'Relatório de Evidências', 5, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-15 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 87, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 5, 'EDRLVKP7SJ'),
(500, 5, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 87, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 0, 'KKRCRNXAUW'),
(501, 5, 'Mobilização', 5, 'done', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '2019-07-31 12:00', '2019-08-01 12:00', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 88, 0, 0, 0, 0, '2019-08-08 11:20:40', '502,503', 1, 'WCNBM0UYOU'),
(502, 5, 'Solicitação de Acesso', 9, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '2019-08-08 11:37', '2019-09-02 11:37', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 88, 0, 0, 0, 0, '2019-08-08 11:20:40', '505', 17, 'N1LEKTTZRX'),
(503, 5, 'Instalação', 5, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '2019-08-08 11:37', '2019-08-29 11:37', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 88, 0, 0, 0, 0, '2019-08-08 11:20:40', '504,505,506', 15, 'U7GGHUBQJF'),
(504, 5, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-09 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 88, 0, 0, 0, 0, '2019-08-08 11:20:40', '507', 1, 'F07PMO6HK8'),
(505, 5, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-12 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 88, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 2, '7OV6GPSDIQ'),
(506, 5, 'Relatório de Evidências', 5, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-15 11:37', '2019-08-08 11:40', 0, 2, NULL, 0, 0, 0, 0, 88, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 5, 'ST5ERYWZEJ'),
(507, 5, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 88, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 0, 'OD9RDPDH5I');
INSERT INTO `project_task` (`id`, `project_id`, `name`, `user_id`, `status`, `public`, `datetime`, `description`, `start_date`, `due_date`, `completion_date`, `value`, `priority`, `time`, `client_id`, `created_by_client`, `tracking`, `time_spent`, `milestone_id`, `invoice_id`, `milestone_order`, `task_order`, `progress`, `created_at`, `sucessors`, `scheduled_time`, `reference`) VALUES
(508, 5, 'Mobilização', 5, 'done', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '2019-07-31 12:00', '2019-08-01 12:00', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 89, 0, 1, 0, 0, '2019-08-08 11:20:40', '509,510', 1, 'EYMRB7K9NP'),
(509, 5, 'Solicitação de Acesso', 9, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '2019-08-08 11:37', '2019-09-02 11:37', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 89, 0, 2, 0, 0, '2019-08-08 11:20:40', '512', 17, 'ZFC1H3Q0XF'),
(510, 5, 'Instalação', 5, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '2019-08-08 11:37', '2019-08-29 11:37', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 89, 0, 3, 0, 0, '2019-08-08 11:20:40', '511,512,513', 15, 'JEVPPURWRM'),
(511, 5, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-09 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 89, 0, 4, 0, 0, '2019-08-08 11:20:40', '514', 1, 'X3PHPMFOJK'),
(512, 5, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-12 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 89, 0, 5, 0, 0, '2019-08-08 11:20:40', NULL, 2, 'E8JGZIHATD'),
(513, 5, 'Relatório de Evidências', 5, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-15 11:37', '2019-08-08 11:40', 0, 2, NULL, 0, 0, 0, 0, 89, 0, 6, 0, 0, '2019-08-08 11:20:40', NULL, 5, '2UZECOEADM'),
(514, 5, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 89, 0, 7, 0, 0, '2019-08-08 11:20:40', NULL, 0, 'VJP7NQVGW1'),
(515, 5, 'Mobilização', 5, 'done', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '2019-08-05 12:00', '2019-08-06 12:00', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 90, 0, 0, 0, 0, '2019-08-08 11:20:40', '516,517', 1, 'HJAKEUVIWC'),
(516, 5, 'Solicitação de Acesso', 9, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '2019-08-08 11:37', '2019-09-02 11:37', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 90, 0, 0, 0, 0, '2019-08-08 11:20:40', '519', 17, 'I6QR2O1XYU'),
(517, 5, 'Instalação', 5, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '2019-08-08 11:37', '2019-08-29 11:37', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 90, 0, 0, 0, 0, '2019-08-08 11:20:40', '518,519,520', 15, '0WPPHBTLL3'),
(518, 5, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-09 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 90, 0, 0, 0, 0, '2019-08-08 11:20:40', '521', 1, 'A1OOUM20VC'),
(519, 5, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-12 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 90, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 2, 'ES4YZAJEKA'),
(520, 5, 'Relatório de Evidências', 5, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-15 11:37', '2019-08-08 11:40', 0, 2, NULL, 0, 0, 0, 0, 90, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 5, 'ZTSJC06TWG'),
(521, 5, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 90, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 0, 'TBLASK9H91'),
(522, 5, 'Mobilização', 5, 'done', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '2019-08-05 12:00', '2019-08-06 12:00', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 91, 0, 0, 0, 0, '2019-08-08 11:20:40', '523,524', 1, 'T2HVW7C61H'),
(523, 5, 'Solicitação de Acesso', 9, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '2019-08-08 11:37', '2019-09-02 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 91, 0, 0, 0, 0, '2019-08-08 11:20:40', '526', 17, 'XPNVVB4KFO'),
(524, 5, 'Instalação', 5, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '2019-08-08 11:37', '2019-08-29 11:37', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 91, 0, 0, 0, 0, '2019-08-08 11:20:40', '525,526,527', 15, 'QIKMGV1MSI'),
(525, 5, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-09 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 91, 0, 0, 0, 0, '2019-08-08 11:20:40', '528', 1, 'I45ETMWV8V'),
(526, 5, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-12 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 91, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 2, 'DYQIZ0LVKJ'),
(527, 5, 'Relatório de Evidências', 5, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-15 11:37', '2019-08-08 11:40', 0, 2, NULL, 0, 0, 0, 0, 91, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 5, 'WWYS28FSSR'),
(528, 5, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 91, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 0, 'ZV4UOPG1IP'),
(529, 5, 'Mobilização', 5, 'done', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '2019-08-08 12:00', '2019-08-09 12:00', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 92, 0, 0, 0, 0, '2019-08-08 11:20:40', '530,531', 1, 'KCIE5F3GBT'),
(530, 5, 'Solicitação de Acesso', 9, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '2019-08-08 11:37', '2019-09-02 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 92, 0, 0, 0, 0, '2019-08-08 11:20:40', '533', 17, 'LISEEREFSL'),
(531, 5, 'Instalação', 5, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '2019-08-08 11:37', '2019-08-29 11:37', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 92, 0, 0, 0, 0, '2019-08-08 11:20:40', '532,533,534', 15, 'AD3LTP1U1P'),
(532, 5, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-09 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 92, 0, 0, 0, 0, '2019-08-08 11:20:40', '535', 1, 'OOCNHYFW5M'),
(533, 5, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-12 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 92, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 2, 'CLIWTT0YWP'),
(534, 5, 'Relatório de Evidências', 5, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-15 11:37', '2019-08-08 11:40', 0, 2, NULL, 0, 0, 0, 0, 92, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 5, 'VTHMBDE2AB'),
(535, 5, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 92, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 0, 'DM0OVAXUOW'),
(536, 5, 'Mobilização', 5, 'done', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '2019-08-08 12:00', '2019-08-09 12:00', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 93, 0, 0, 0, 0, '2019-08-08 11:20:40', '537,538', 1, '8WEGCQC4HI'),
(537, 5, 'Solicitação de Acesso', 9, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '2019-08-08 11:37', '2019-09-02 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 93, 0, 0, 0, 0, '2019-08-08 11:20:40', '540', 17, '7TZRYQIO0G'),
(538, 5, 'Instalação', 5, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '2019-08-08 11:37', '2019-08-29 11:37', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 93, 0, 0, 0, 0, '2019-08-08 11:20:40', '539,540,541', 15, '3S5Q9O1ABD'),
(539, 5, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-09 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 93, 0, 0, 0, 0, '2019-08-08 11:20:40', '542', 1, 'BFCYO9HDFP'),
(540, 5, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-12 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 93, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 2, '5K0WBGJRPA'),
(541, 5, 'Relatório de Evidências', 5, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-15 11:37', '2019-08-08 11:40', 0, 2, NULL, 0, 0, 0, 0, 93, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 5, 'SOOACUTEGB'),
(542, 5, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 93, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 0, '7A0SB4BB94'),
(543, 5, 'Mobilização', 5, 'done', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '2019-08-12 12:00', '2019-08-13 12:00', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 94, 0, 0, 0, 0, '2019-08-08 11:20:40', '544,545', 1, 'WOXU0H1RPU'),
(544, 5, 'Solicitação de Acesso', 9, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '2019-08-08 11:37', '2019-09-02 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 94, 0, 0, 0, 0, '2019-08-08 11:20:40', '491', 17, 'KUXOLS2TFV'),
(545, 5, 'Instalação', 5, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '2019-08-08 11:37', '2019-08-29 11:37', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 94, 0, 0, 0, 0, '2019-08-08 11:20:40', '546,547,548', 15, 'B8L9UPN3Q9'),
(546, 5, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-09 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 94, 0, 0, 0, 0, '2019-08-08 11:20:40', '549', 1, 'SVCUQFTL3S'),
(547, 5, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-12 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 94, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 2, 'TFJBOCA6FB'),
(548, 5, 'Relatório de Evidências', 5, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-15 11:37', '2019-08-08 11:40', 0, 2, NULL, 0, 0, 0, 0, 94, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 5, 'EVDAP2DWNY'),
(549, 5, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 94, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 0, 'TWNVFO6LDW'),
(550, 5, 'Mobilização', 5, 'done', 0, NULL, '<p><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Entrar em contato com a escola enviando um\nmembro de uma das equipes. Objetivo é informar a direção da escola, assim como\nverificar condições de local para instalação e confirmar disjuntores de entrada\nda escola para confirmar informações da CEMIG.</span><br></p>', '2019-08-12 12:00', '2019-08-13 12:00', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 95, 0, 0, 0, 0, '2019-08-08 11:20:40', '551,552', 1, 'JADAXAWNH0'),
(551, 5, 'Solicitação de Acesso', 9, 'open', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Produção dos documentos necessários para\nsolicitar acesso na CEMIG, assim como a fazer o cadastro dos mesmos na\nplataforma APR da CEMIG.</span>', '2019-08-08 11:37', '2019-09-02 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 95, 0, 0, 0, 0, '2019-08-08 11:20:40', '554', 17, 'BY2CFURL0J'),
(552, 5, 'Instalação', 5, 'done', 0, NULL, '<span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Coordenar equipe de campo na instalação da UFV.</span>', '2019-08-08 11:37', '2019-08-29 11:37', '2019-08-08 11:37', 0, 2, NULL, 0, 0, 0, 0, 95, 0, 0, 0, 0, '2019-08-08 11:20:40', '553,554,555', 15, 'IN1VQFGAEQ'),
(553, 5, 'Comissionamento', 9, 'open', 0, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Verificar o funcionamento\ndo sistema e detecção de alguma anomalia.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-09 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 95, 0, 0, 0, 0, '2019-08-08 11:20:40', '556', 1, 'T2OOUEZRWN'),
(554, 5, 'Pedido de Vistoria', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Após receber parecer de\nacesso, entrar com pedido de vistoria. Caso a vistoria seja reprovada por\nquestões de infraestrutura da escola, comunicar a gerência do projeto junto a\nCEMIG e aguardar posicionamento deles.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-12 11:37', NULL, 0, 2, NULL, 0, 0, 0, 0, 95, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 2, '4YQD6YPL94'),
(555, 5, 'Relatório de Evidências', 5, 'done', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar a instalação com\nênfase no antes e depois, com fotos, período de instalação e se houve mudanças\nno escopo inicial e/ou pontos críticos observados.</span><o:p></o:p></p>', '2019-08-08 11:37', '2019-08-15 11:37', '2019-08-08 11:40', 0, 2, NULL, 0, 0, 0, 0, 95, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 5, 'BOYNRWDTCK'),
(556, 5, 'Relatório de Comissionamento', 9, 'open', NULL, NULL, '<p class=\"MsoNormal\"><span style=\"font-size: 10.5pt; line-height: 107%; font-family: Helvetica, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Relatar condições\nobservadas no comissionamento.</span><o:p></o:p></p>', NULL, NULL, NULL, 0, 2, NULL, 0, 0, 0, 0, 95, 0, 0, 0, 0, '2019-08-08 11:20:40', NULL, 0, 'SRMTBFBEDW');

-- --------------------------------------------------------

--
-- Estrutura para tabela `project_timesheet`
--

CREATE TABLE `project_timesheet` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` int(11) DEFAULT 0,
  `user_id` int(11) DEFAULT 0,
  `time` varchar(250) DEFAULT '0',
  `task_id` int(11) DEFAULT 0,
  `client_id` int(11) DEFAULT 0,
  `start` varchar(250) DEFAULT '0',
  `end` varchar(250) DEFAULT '0',
  `invoice_id` int(11) DEFAULT 0,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `project_worker`
--

CREATE TABLE `project_worker` (
  `id` int(10) NOT NULL,
  `project_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `project_worker`
--

INSERT INTO `project_worker` (`id`, `project_id`, `user_id`) VALUES
(1, 1, 3),
(2, 1, 1),
(3, 1, 2),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 2, 9),
(10, 2, 1),
(11, 2, 5),
(12, 2, 6),
(13, 2, 3),
(14, 3, 9),
(15, 4, 9),
(16, 4, 1),
(17, 4, 3),
(18, 4, 5),
(19, 4, 6),
(20, 5, 9);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pw_reset`
--

CREATE TABLE `pw_reset` (
  `id` int(10) NOT NULL,
  `email` varchar(250) DEFAULT NULL,
  `timestamp` varchar(250) DEFAULT NULL,
  `token` varchar(250) DEFAULT NULL,
  `user` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `pw_reset`
--

INSERT INTO `pw_reset` (`id`, `email`, `timestamp`, `token`, `user`) VALUES
(11, 'patrick@ownergy.com.br', '1556644527', '0c733b4bdd8634bf32e4b08cfc484dd6a68181c7a21cd2dcfdb6b6872e98bf2d', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `queue`
--

CREATE TABLE `queue` (
  `id` bigint(20) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `inactive` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `queue`
--

INSERT INTO `queue` (`id`, `name`, `description`, `inactive`) VALUES
(1, 'Administrativo', 'Tickets ligados à área administrativa', 0),
(2, 'Comercial', 'Tickets ligados à área comercial', 0),
(3, 'Engenharia', 'Tickets ligados à área de engenharia', 0),
(4, 'Tecnologia', 'Tickets ligados à área de tecnologia', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `reminder`
--

CREATE TABLE `reminder` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module` varchar(250) DEFAULT NULL,
  `source_id` bigint(20) DEFAULT 0,
  `title` varchar(250) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `email_notification` int(1) DEFAULT 0,
  `done` int(1) DEFAULT 0,
  `datetime` varchar(50) DEFAULT NULL,
  `sent_at` varchar(50) DEFAULT '0',
  `user_id` int(20) DEFAULT 0,
  `push_notification` tinyint(1) NOT NULL DEFAULT 0,
  `push_sent_at` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `reminder`
--

INSERT INTO `reminder` (`id`, `module`, `source_id`, `title`, `body`, `email_notification`, `done`, `datetime`, `sent_at`, `user_id`, `push_notification`, `push_sent_at`) VALUES
(20, 'lead', 2, 'Contatar Lessandro para fup', '', 1, 0, '2019-08-19 10:30:00 -03', '2019-08-19 10:48:02 GMT-0300', 4, 1, '2019-08-19 10:48:02 GMT-0300'),
(21, 'lead', 4, 'Contato telefônico derradeiro com Rodrigo Stella', '', 1, 0, '2019-08-19 11:00:00 -03', '2019-08-19 11:00:04 GMT-0300', 4, 1, '2019-08-19 11:00:04 GMT-0300'),
(22, 'lead', 6, 'Contato telefônico com Bruno para FUP', '', 1, 0, '2019-08-19 11:20:00 -03', '2019-08-19 11:24:05 GMT-0300', 4, 1, '2019-08-19 11:24:06 GMT-0300'),
(24, 'lead', 19, 'Contatar Eduardo para saber se vamos seguir', '', 1, 0, '2019-08-27 10:00:00 -03', '2019-08-27 10:00:03 GMT-0300', 4, 1, '2019-08-27 10:00:04 GMT-0300'),
(25, 'lead', 1, 'Verificar com Coutinho se houve retorno do Ricardo', '', 1, 0, '2019-08-19 11:30:00 -03', '2019-08-19 11:48:02 GMT-0300', 4, 1, '2019-08-19 11:48:02 GMT-0300');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tag`
--

CREATE TABLE `tag` (
  `id` bigint(20) NOT NULL,
  `name` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `tag`
--

INSERT INTO `tag` (`id`, `name`) VALUES
(1, 'Comércio'),
(2, 'Escola / Colégio'),
(3, 'Hotel'),
(4, 'Condomínio'),
(5, 'Indústria'),
(6, 'Clínica / Hospital'),
(7, 'Residência'),
(8, 'Transportadora'),
(9, 'Sirius'),
(10, 'Fazenda solar');

-- --------------------------------------------------------

--
-- Estrutura para tabela `task_comment`
--

CREATE TABLE `task_comment` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `datetime` varchar(20) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `task_id` bigint(20) DEFAULT NULL,
  `attachment_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `terrain`
--

CREATE TABLE `terrain` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status_id` bigint(20) DEFAULT 0,
  `source` varchar(250) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `position` varchar(250) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `city` varchar(250) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `country` varchar(250) DEFAULT NULL,
  `zipcode` varchar(250) DEFAULT NULL,
  `language` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `owner` varchar(500) DEFAULT NULL,
  `phone` varchar(250) DEFAULT NULL,
  `mobile` varchar(250) DEFAULT NULL,
  `company` varchar(250) DEFAULT NULL,
  `tags` varchar(10000) NOT NULL,
  `description` text DEFAULT NULL,
  `proposal_value` varchar(20) DEFAULT '0,00',
  `rated_power_mod` varchar(10) NOT NULL,
  `last_contact` varchar(250) DEFAULT NULL,
  `last_landing` varchar(250) DEFAULT NULL,
  `created` varchar(20) DEFAULT NULL,
  `modified` varchar(20) DEFAULT NULL,
  `private` tinyint(1) DEFAULT 1,
  `completed` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT 0,
  `icon` varchar(255) DEFAULT NULL,
  `order` float DEFAULT 0,
  `payment` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `terrain`
--

INSERT INTO `terrain` (`id`, `status_id`, `source`, `name`, `position`, `address`, `city`, `state`, `country`, `zipcode`, `language`, `email`, `owner`, `phone`, `mobile`, `company`, `tags`, `description`, `proposal_value`, `rated_power_mod`, `last_contact`, `last_landing`, `created`, `modified`, `private`, `completed`, `user_id`, `icon`, `order`, `payment`) VALUES
(1, 1, NULL, 'Terreno teste', '0', 'rua x', 'bh', 'mg', 'brasil', '1', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '0,00', '', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, 0, '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `terrain_comment`
--

CREATE TABLE `terrain_comment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `attachment` varchar(250) DEFAULT NULL,
  `attachment_link` varchar(250) DEFAULT NULL,
  `datetime` varchar(250) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `user_id` bigint(20) DEFAULT 0,
  `terrain_id` bigint(20) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `terrain_history`
--

CREATE TABLE `terrain_history` (
  `id` int(11) UNSIGNED NOT NULL,
  `terrain_id` int(10) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `terrain_status`
--

CREATE TABLE `terrain_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `order` float DEFAULT 0,
  `offset` bigint(200) DEFAULT 0,
  `limit` bigint(200) DEFAULT 50,
  `color` varchar(100) DEFAULT '#5071ab',
  `duration` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `terrain_status`
--

INSERT INTO `terrain_status` (`id`, `name`, `description`, `order`, `offset`, `limit`, `color`, `duration`) VALUES
(1, 'Status teste', 'Teste terrain', 1, 0, 50, '#5071ab', 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `terrain_status_receiver`
--

CREATE TABLE `terrain_status_receiver` (
  `id` int(10) NOT NULL,
  `terrain_status_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `terrain_warning_user`
--

CREATE TABLE `terrain_warning_user` (
  `id` int(10) NOT NULL,
  `terrain_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ticket`
--

CREATE TABLE `ticket` (
  `id` bigint(20) NOT NULL,
  `from` varchar(250) DEFAULT NULL,
  `reference` varchar(250) DEFAULT NULL,
  `type_id` smallint(6) DEFAULT 1,
  `lock` smallint(6) DEFAULT NULL,
  `subject` varchar(250) DEFAULT NULL,
  `text` text DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `client_id` int(11) DEFAULT 0,
  `company_id` int(11) DEFAULT 0,
  `user_id` int(11) DEFAULT 0,
  `escalation_time` int(11) DEFAULT 0,
  `priority` varchar(50) DEFAULT NULL,
  `created` int(11) DEFAULT 0,
  `queue_id` int(11) DEFAULT 0,
  `updated` tinyint(4) DEFAULT 0,
  `project_id` bigint(20) DEFAULT 0,
  `raw` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `ticket`
--

INSERT INTO `ticket` (`id`, `from`, `reference`, `type_id`, `lock`, `subject`, `text`, `status`, `client_id`, `company_id`, `user_id`, `escalation_time`, `priority`, `created`, `queue_id`, `updated`, `project_id`, `raw`) VALUES
(1, 'Pedro Santos - pedro.santos@ownergy.com.br', '1', 1, NULL, 'Troca de Titularidade e Envio dos Créditos Acumulados', '<p>Acompanhar pedido de troca de titularidade e envio dos créditos acumulados no escritório para&nbsp; o supermercado</p>', 'open', 0, 0, 9, 0, NULL, 1563548947, 3, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `ticket_article`
--

CREATE TABLE `ticket_article` (
  `id` bigint(20) NOT NULL,
  `ticket_id` int(11) DEFAULT 0,
  `from` varchar(250) NOT NULL,
  `reply_to` varchar(250) DEFAULT NULL,
  `to` varchar(250) DEFAULT NULL,
  `cc` varchar(250) DEFAULT NULL,
  `subject` varchar(250) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `datetime` varchar(250) DEFAULT NULL,
  `internal` int(10) DEFAULT 1,
  `user_id` bigint(20) DEFAULT 0,
  `note` int(1) DEFAULT 0,
  `raw` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ticket_attachment`
--

CREATE TABLE `ticket_attachment` (
  `id` bigint(20) NOT NULL,
  `ticket_id` bigint(20) DEFAULT NULL,
  `filename` varchar(250) DEFAULT NULL,
  `savename` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ticket_type`
--

CREATE TABLE `ticket_type` (
  `id` bigint(20) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `inactive` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `ticket_type`
--

INSERT INTO `ticket_type` (`id`, `name`, `description`, `inactive`) VALUES
(1, 'Prevenção', 'Tickets de prevenção', 0),
(2, 'Remediação', 'Tickets de remediação', 0),
(3, 'Solicitação', 'Tickets de solicitações', 0),
(4, 'Investigação', 'Tickets de investigação', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `firstname` varchar(120) DEFAULT NULL,
  `lastname` varchar(120) DEFAULT NULL,
  `hashed_password` varchar(128) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `status` enum('active','inactive','deleted') DEFAULT NULL,
  `admin` enum('0','1') DEFAULT '0',
  `created` timestamp NULL DEFAULT current_timestamp(),
  `userpic` varchar(250) DEFAULT 'no-pic.png',
  `title` varchar(150) DEFAULT NULL,
  `access` varchar(150) NOT NULL DEFAULT '1,2',
  `last_active` varchar(50) DEFAULT NULL,
  `last_login` varchar(50) DEFAULT NULL,
  `queue` bigint(20) DEFAULT 0,
  `token` varchar(255) DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `signature` text DEFAULT NULL,
  `push_active` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Permissão para receber pushes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `user`
--

INSERT INTO `user` (`id`, `username`, `firstname`, `lastname`, `hashed_password`, `email`, `status`, `admin`, `created`, `userpic`, `title`, `access`, `last_active`, `last_login`, `queue`, `token`, `language`, `signature`, `push_active`) VALUES
(1, 'thiago.pires', 'Thiago', 'Pires', '634755376f23444369675e2b715d402a312c6d6f52275a6f2c6d6f4650325946b828219e8f0e943b5a86b3a4246c583d046a882933f3d379b863f64e00330200', 'thiago.pires@ownergy.com.br', 'active', '1', '2018-11-26 11:41:06', 'a693b7120123dcd2cd72ee4d50663852.jpg', 'Analista de Inovação', '1,2,3,4,108,34,20,105,9,10,11', '1571857616', '1571857369', 1, '8dacf92301e47aa845f807057cd04abc', NULL, 'Thiago Pires', '1'),
(2, 'jorge.felipe', 'Jorge', 'Felipe', '6f7b2e504258623e764d4746342f5d694a4a5749582c7a2143475f2e456d2772b0cbc2187ea75008ca4bf0384cea63f6881a286ba40852f328231e454cd304e1', 'jorge.felipe@ownergy.com.br', 'inactive', '0', '2018-12-10 18:06:35', 'd3b0ce907e249e12b6abcb5dfa6be054.png', 'Coordenador de Projetos', '1,2,3,4,34,20,105,10,11', '1550154916', '1550154773', 3, NULL, NULL, 'Jorge Felipe B. Mota', '0'),
(3, 'patrick', 'Patrick', 'Lüdtke', '4345224124455b463c38643f265f7c5f3a2a3844285162515e4a474e7962514e68b750ef10292bea28c8f22c2d6ffa56ac279097e11f206819278e40e9fb7eed', 'patrick@ownergy.com.br', 'active', '1', '2018-12-11 17:48:23', '0063816beb99c00058e7bcefba1ac54d.png', 'Diretor de Operações', '1,2,3,4,108,34,20,105,10,11', '1565274643', '1565272972', 1, NULL, NULL, 'Patrick Lüdtke', '1'),
(4, 'jfdutra', 'José', 'Francisco', '6b6d6f5b482f4b452a634b506e386c732d597d3e62572d6d674c31655150652fdc141bf826a17fd707f022642b818b5772ffd80c5882d19222f6e0697fc8c079', 'jfdutra@ownergy.com.br', 'active', '1', '2018-12-11 17:49:41', 'bdf7fcd8988ed35766dd8ec01007f214.png', 'Diretor Financeiro', '1,2,3,4,108,34,20,105,10,11', '1571696585', '1571675144', 1, NULL, NULL, 'José Francisco Dutra', '1'),
(5, 'alan.barros', 'Alan', 'Barros ', '5970456c444b4b304d4f4e38403d7a2c3d6677776f7a406d48596d6b572a6445c1f3db95578db9b5396fdcc43cb16659bd893843541fa98ba19ca1adc16b5732', 'alan.barros@ownergy.com.br', 'active', '0', '2018-12-11 17:51:15', '716c4943f4888d29e9a23bd6feb98f72.png', 'Analista de Projetos', '1,2,3,4,108,34,20,105,10,11', '1561651438', '1561651405', 3, NULL, NULL, 'Alan Rodriguez Barros', '1'),
(6, 'marlem.batista', 'Marlem', 'Batista', '345e5a544f4d5b636d30485d554c5e54343b2e31444252797d642841767a343095b09186da93ca1bfb2c5a715b5e7566324bfd8af2c2975c438bd8f92c76f7d7', 'marlem.batista@ownergy.com.br', 'active', '0', '2018-12-11 17:52:36', '114ed6f77ddf7c0570a1f449a21d2272.png', 'Analista Administrativo', '1,2,3,4,108,20,105,10,11', '1569413112', '1569413105', 1, NULL, NULL, 'Marlem Batista', '1'),
(7, 'andreia.ribeiro', 'Andreia', 'Ribeiro', '4f3f5d283e694b61275c462f742a3c213171763a7b474d76672b3d4c2853423a5bba4f87e13cb978100bf022866aba94f3b2b4c312f1b0c9c83dcae31616c44c', 'andreia.ribeiro@ownergy.com.br', 'inactive', '0', '2018-12-11 17:54:11', 'db1ae56543fcd7208798459f347c4e88.png', 'Analista Comercial', '1,2,3,4,108,20,105,10,11', '1557172835', '1557172829', 2, NULL, NULL, 'Andreia Ribeiro', '1'),
(8, 'bernardo.guaracy', 'Bernardo', 'Guaracy', '69654b295e75556566295b794946454e4f37323c5855354b7a6f26532967354386db9f39cf90204137136a3e1bab4df4178343761a28a004a155b67f4ae5dbbc', 'bernardo.guaracy@ownergy.com.br', 'inactive', '0', '2019-02-11 14:02:13', '576dbc7d786fcf0227503a1c64394d86.jpeg', 'Gestor Comercial', '1,2,3,4,108,20,105,10,11', '0', '1559043899', 2, NULL, NULL, 'Bernardo Guaracy', '1'),
(9, 'pedro.santos', 'Pedro', 'Santos', '595d6b307c394e365a767a346844653d7d65532d373d4b373b512b3b21693a5a8f768837ecb276e6fa06e976b9038a62336398c826b790cf0f9c5d8bb5e331b1', 'pedro.santos@ownergy.com.br', 'active', '0', '2019-05-06 12:00:30', '1dae7ab79f3f8a046d38108b2777c786.png', 'Analista de Projetos', '1,2,3,4,108,20,105,10,11', '1565275401', '1565273335', 3, NULL, NULL, 'Pedro Santos', '1'),
(10, 'lucas.felipe', 'Lucas', 'Felipe', '28364e38614837254b7222656c3b5c635b782943323550437139527366727544bb52eed638487594d91da1ec2d92ab7dca7753a135c3042f65388b4f334e0434', 'lucas.felipe@ownergy.com.br', 'inactive', '0', '2019-05-09 12:44:12', '20021c9ffa5f4b14ab2b2c1d67820749.png', 'Assistente Administrativo', '1,2,3,4,108,20,105,10,11', '1564690583', '1564664476', 1, NULL, NULL, 'Lucas Felipe', '0'),
(11, 'arteniza.silva', 'Arteniza', 'Silva', '475a6e6d494c5c4e7b2f5534457d373e77492a7b32462d5e47286e324d406376ca784d88dbb502849c6e1f33be5d01efd74eb2111142a36937866f6c6e51c2c2', 'arteniza.silva@ownergy.com.br', 'active', '0', '2019-08-02 14:32:18', '4f957f2624cbae4d556e9ee90be709af.png', 'Administrativo', '1,2,3,4,108,20,105,10,11', '1571843261', '1571832262', 1, NULL, NULL, 'Arteniza Silva', '1'),
(12, 'vinicius.pedroni', 'Vinícius', 'Pedroni', '237222645d593f652e4c7429703c3d2b4c426f72443f27233b3b226b7b346a79888ce20f6c479e7709b1820a71daab0a2b6608c3044e5c61f223e9d77237432f', 'vinicius@siriusenergia.com.br', 'active', '0', '2019-10-02 15:58:23', 'c4e36f4f71702c8fea918399de4a184e.jpg', 'Engenheiro Eletricista', '1,2,3,4,108,20,105,9,10,11', '1571239039', '1571232753', 3, NULL, NULL, 'Vinícius Pedroni', '1'),
(13, 'gilson.queiroz', 'Gilson', 'Queiroz', '45772d445f7c646a3b73364a3722506f643f74466a435146617169455a78562b7651bdf09354c9182134de5d48ffd35e76104ab0346c78077f6006da92f3f26d', 'gilson.queiroz@ownergy.com.br', 'active', '0', '2019-10-14 11:51:48', 'e2f35c0dd5a2f90c7cecf0038ca472c6.png', 'Engenheiro Eletricista', '1,2,3,20,105,10,11', '0', '1571078616', 3, NULL, NULL, 'Gilson Queiroz', '1'),
(14, 'joao.reis', 'João Wilian ', 'dos Reis', '252e415f58287879294b7b6563783e6a2a742150592f523b5b646f2965663f795e587481dc23b4111c9f0d60b5ce948002bf02e0e6f126a675d81595c3cb0229', 'joao.reis@ownergy.com.br', 'active', '1', '2019-10-23 19:06:56', 'no-pic.png', 'Analista Desenvolvedor', '1,2,3,4,108,34,109,20,105,9,10,11', '1572445904', '1572432730', 4, NULL, NULL, 'João Wilian ', '1');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `article_attachment`
--
ALTER TABLE `article_attachment`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `company_admin`
--
ALTER TABLE `company_admin`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `core`
--
ALTER TABLE `core`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `department_area`
--
ALTER TABLE `department_area`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Índices de tabela `department_worker`
--
ALTER TABLE `department_worker`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `lead`
--
ALTER TABLE `lead`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `lead_comment`
--
ALTER TABLE `lead_comment`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `lead_history`
--
ALTER TABLE `lead_history`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `lead_status`
--
ALTER TABLE `lead_status`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `lead_status_receiver`
--
ALTER TABLE `lead_status_receiver`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`lead_status_id`);

--
-- Índices de tabela `lead_warning_user`
--
ALTER TABLE `lead_warning_user`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `private_message`
--
ALTER TABLE `private_message`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `project_activity`
--
ALTER TABLE `project_activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices de tabela `project_file`
--
ALTER TABLE `project_file`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `project_message`
--
ALTER TABLE `project_message`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `project_milestone`
--
ALTER TABLE `project_milestone`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `project_task`
--
ALTER TABLE `project_task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices de tabela `project_timesheet`
--
ALTER TABLE `project_timesheet`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `project_worker`
--
ALTER TABLE `project_worker`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Índices de tabela `pw_reset`
--
ALTER TABLE `pw_reset`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `reminder`
--
ALTER TABLE `reminder`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `task_comment`
--
ALTER TABLE `task_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices de tabela `terrain`
--
ALTER TABLE `terrain`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `terrain_comment`
--
ALTER TABLE `terrain_comment`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `terrain_history`
--
ALTER TABLE `terrain_history`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `terrain_status`
--
ALTER TABLE `terrain_status`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `terrain_status_receiver`
--
ALTER TABLE `terrain_status_receiver`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`terrain_status_id`);

--
-- Índices de tabela `terrain_warning_user`
--
ALTER TABLE `terrain_warning_user`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Índices de tabela `ticket_article`
--
ALTER TABLE `ticket_article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Índices de tabela `ticket_attachment`
--
ALTER TABLE `ticket_attachment`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `ticket_type`
--
ALTER TABLE `ticket_type`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `article_attachment`
--
ALTER TABLE `article_attachment`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `company_admin`
--
ALTER TABLE `company_admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `core`
--
ALTER TABLE `core`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `department_area`
--
ALTER TABLE `department_area`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `department_worker`
--
ALTER TABLE `department_worker`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `event`
--
ALTER TABLE `event`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `lead`
--
ALTER TABLE `lead`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de tabela `lead_comment`
--
ALTER TABLE `lead_comment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de tabela `lead_history`
--
ALTER TABLE `lead_history`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT de tabela `lead_status`
--
ALTER TABLE `lead_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `lead_status_receiver`
--
ALTER TABLE `lead_status_receiver`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `lead_warning_user`
--
ALTER TABLE `lead_warning_user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `module`
--
ALTER TABLE `module`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT de tabela `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=506;

--
-- AUTO_INCREMENT de tabela `private_message`
--
ALTER TABLE `private_message`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de tabela `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `project_activity`
--
ALTER TABLE `project_activity`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `project_file`
--
ALTER TABLE `project_file`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `project_message`
--
ALTER TABLE `project_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `project_milestone`
--
ALTER TABLE `project_milestone`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT de tabela `project_task`
--
ALTER TABLE `project_task`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=557;

--
-- AUTO_INCREMENT de tabela `project_timesheet`
--
ALTER TABLE `project_timesheet`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `project_worker`
--
ALTER TABLE `project_worker`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `pw_reset`
--
ALTER TABLE `pw_reset`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `queue`
--
ALTER TABLE `queue`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `reminder`
--
ALTER TABLE `reminder`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `tag`
--
ALTER TABLE `tag`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `task_comment`
--
ALTER TABLE `task_comment`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `terrain_status`
--
ALTER TABLE `terrain_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `ticket_article`
--
ALTER TABLE `ticket_article`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ticket_attachment`
--
ALTER TABLE `ticket_attachment`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ticket_type`
--
ALTER TABLE `ticket_type`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;
