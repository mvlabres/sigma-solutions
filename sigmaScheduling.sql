
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sigmaScheduling`
--
CREATE DATABASE IF NOT EXISTS `sigmaScheduling` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `sigmaScheduling`;

-- --------------------------------------------------------

--
-- Table structure for table `armazem`
--

CREATE TABLE IF NOT EXISTS `armazem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attachment`
--

CREATE TABLE IF NOT EXISTS `attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `scheduleId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_scheduleId` (`scheduleId`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `columns_preference`
--

CREATE TABLE IF NOT EXISTS `columns_preference` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `preference` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK2_userId` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `tel` varchar(14) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `horario`
--

CREATE TABLE IF NOT EXISTS `horario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) DEFAULT NULL,
  `posicao` varchar(10) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `armazem` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `janela`
--

CREATE TABLE IF NOT EXISTS `janela` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_horario` varchar(100) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `tipoVeiculo` varchar(50) DEFAULT NULL,
  `placa_carreta` varchar(50) DEFAULT NULL,
  `operacao` varchar(50) DEFAULT NULL,
  `nf` varchar(50) DEFAULT NULL,
  `doca` varchar(50) DEFAULT NULL,
  `peso_inicial` float DEFAULT NULL,
  `peso_final` float DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `dataInclusao` date DEFAULT NULL,
  `inicio_operacao` datetime DEFAULT NULL,
  `horaChegada` datetime DEFAULT NULL,
  `fim_operacao` datetime DEFAULT NULL,
  `transportadora` varchar(100) DEFAULT NULL,
  `posicao` varchar(50) DEFAULT NULL,
  `placa_cavalo` varchar(50) DEFAULT NULL,
  `armazem` varchar(5) DEFAULT NULL,
  `destino` varchar(100) DEFAULT NULL,
  `peso` varchar(10) DEFAULT NULL,
  `oferta` varchar(14) DEFAULT NULL,
  `data_agendamento` datetime DEFAULT NULL,
  `saida` datetime DEFAULT NULL,
  `separacao` varchar(20) DEFAULT NULL,
  `shipment_id` varchar(15) DEFAULT NULL,
  `do_s` varchar(50) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `carga_qtde` int(11) DEFAULT NULL,
  `observacao` varchar(150) DEFAULT NULL,
  `dados_gerais` varchar(500) DEFAULT NULL,
  `cliente` varchar(50) DEFAULT NULL,
  `nome_motorista` varchar(100) DEFAULT NULL,
  `placa_carreta2` varchar(12) DEFAULT NULL,
  `documento_motorista` varchar(14) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35779 DEFAULT CHARSET=latin1;

--
-- Triggers `janela`
--
DELIMITER $$
CREATE TRIGGER `log_janela_delete` AFTER DELETE ON `janela` FOR EACH ROW BEGIN
    INSERT INTO janela_log (id_horario,data,status,tipoVeiculo,placa_carreta,operacao, nf, doca, peso_inicial,peso_final,usuario,dataInclusao,inicio_operacao,horaChegada,fim_operacao,transportadora,posicao,placa_cavalo,armazem,operacao_tabela,data_operacao_tabela,usuario_operacao_tabela) 
    VALUES(OLD.id_horario,OLD.data,OLD.status,OLD.tipoVeiculo,OLD.placa_carreta,OLD.operacao,OLD.nf,OLD.doca,OLD.peso_inicial,OLD.peso_final,OLD.usuario,OLD.dataInclusao,OLD.inicio_operacao,OLD.horaChegada,OLD.fim_operacao,OLD.transportadora,OLD.posicao,OLD.placa_cavalo,OLD.armazem,"delete", now(), null); 
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `log_janela_update` AFTER UPDATE ON `janela` FOR EACH ROW BEGIN
    INSERT INTO janela_log (id_horario,data,status,tipoVeiculo,placa_carreta,operacao, nf, doca, peso_inicial,peso_final,usuario,dataInclusao,inicio_operacao,horaChegada,fim_operacao,transportadora,posicao,placa_cavalo,armazem,operacao_tabela,data_operacao_tabela,usuario_operacao_tabela) 
    VALUES(OLD.id_horario,OLD.data,OLD.status,OLD.tipoVeiculo,OLD.placa_carreta,OLD.operacao,OLD.nf,OLD.doca,OLD.peso_inicial,OLD.peso_final,OLD.usuario,OLD.dataInclusao,OLD.inicio_operacao,OLD.horaChegada,OLD.fim_operacao,OLD.transportadora,OLD.posicao,OLD.placa_cavalo,OLD.armazem,"update", now(), null); 
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `janela_log`
--

CREATE TABLE IF NOT EXISTS `janela_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_horario` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` date DEFAULT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipoVeiculo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `placa_carreta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `operacao` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nf` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `doca` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `peso_inicial` float DEFAULT NULL,
  `peso_final` float DEFAULT NULL,
  `usuario` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dataInclusao` date DEFAULT NULL,
  `inicio_operacao` datetime DEFAULT NULL,
  `horaChegada` datetime DEFAULT NULL,
  `fim_operacao` datetime DEFAULT NULL,
  `transportadora` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `posicao` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `placa_cavalo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `operacao_tabela` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data_operacao_tabela` date DEFAULT NULL,
  `usuario_operacao_tabela` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `armazem` int(11) DEFAULT NULL,
  `destino` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `peso` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16760 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `operacao`
--

CREATE TABLE IF NOT EXISTS `operacao` (
  `id` int(11) DEFAULT NULL AUTO_INCREMENT,
  `descricao` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `operation_type`
--

CREATE TABLE IF NOT EXISTS `operation_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cliente` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `systems`
--

CREATE TABLE IF NOT EXISTS `systems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `systemUrl` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iconPath` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `systems` (`id`, `name`, `description`, `systemUrl`, `iconPath`) VALUES
(1, 'klabinSchedules', 'Klabin Agendamentos', 'klabin-agendamentos/pages/', 'images/icone-agendamento.png'),
(2, 'tetrapakShedules', 'TetraPak Agendamentos', 'schedules/index.php?customer=tetrapak', 'images/icone-agendamento.png');

-- --------------------------------------------------------

--
-- Table structure for table `tipoVeiculo`
--

CREATE TABLE IF NOT EXISTS `tipoVeiculo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transportadora`
--

CREATE TABLE IF NOT EXISTS `transportadora` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `cnpj` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `cliente_origem` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;

--
-- Triggers `transportadora`
--
DELIMITER $$
CREATE TRIGGER `transp_user` AFTER INSERT ON `transportadora` FOR EACH ROW BEGIN
    INSERT INTO usuario (nome,username,password,tipo,dataInclusao,usuarioCriacao) VALUES(NEW.nome,NEW.username,NEW.password,'user',now(),NEW.usuario); 
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `transp_user_delete` AFTER DELETE ON `transportadora` FOR EACH ROW BEGIN
    DELETE FROM usuario WHERE nome = OLD.nome; 
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `transp_user_update` AFTER UPDATE ON `transportadora` FOR EACH ROW BEGIN
    UPDATE usuario SET nome=NEW.nome, username = NEW.username, password = NEW.password, dataInclusao = now(), usuarioCriacao = NEW.usuario WHERE nome = OLD.nome; 
END
$$
DELIMITER ;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  `dataInclusao` timestamp DEFAULT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tipo` varchar(20) DEFAULT NULL,
  `usuarioCriacao` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `username`, `password`, `dataInclusao`, `tipo`, `usuarioCriacao`) VALUES
(1, 'Marcos Vinicius Labres de Oliveira', 'marcos.labres ', 'getnis2017', '2023-05-06 09:00:00', 'adm', 'Marcos Vinicius Labres de Oliveira');

--
-- Table structure for table `userSystems`
--

CREATE TABLE IF NOT EXISTS `userSystems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `systemsId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_userId` (`userId`),
  KEY `FK_systemsId` (`systemsId`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `userSystems`
--

INSERT INTO `userSystems` (`id`, `userId`, `systemsId`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_access`
--

CREATE TABLE IF NOT EXISTS `user_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userType` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `functionName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_access`
--

INSERT INTO `user_access` (`id`, `userType`, `functionName`) VALUES
(1, 'adm', 'schedule'),
(2, 'adm', 'schedule_new'),
(3, 'adm', 'schedule_list'),
(4, 'adm', 'register'),
(5, 'adm', 'register_operation_type'),
(6, 'adm', 'register_truck_type'),
(7, 'adm', 'register_shipping_company'),
(8, 'adm', 'register_log'),
(9, 'adm', 'register_report'),
(10, 'porter', 'schedule'),
(11, 'porter', 'schedule_list'),
(12, 'client', 'schedule'),
(13, 'client', 'schedule_new'),
(14, 'client', 'schedule_list'),
(15, 'operator', 'schedule'),
(16, 'operator', 'schedule_list'),
(17, 'operator', 'register_report'),
(18, 'operator', 'schedule'),
(19, 'operator', 'schedule_list'),
(20, 'operator', 'register_report'),
(21, 'operator', 'schedule_new');



--
-- Constraints for dumped tables
--

--
-- Constraints for table `attachment`
--
ALTER TABLE `attachment`
  ADD CONSTRAINT `FK_scheduleId` FOREIGN KEY (`scheduleId`) REFERENCES `janela` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `columns_preference`
--
ALTER TABLE `columns_preference`
  ADD CONSTRAINT `FK2_userId` FOREIGN KEY (`userId`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`ownerId`) REFERENCES `usuario` (`id`);

--
-- Constraints for table `userSystems`
--
ALTER TABLE `userSystems`
  ADD CONSTRAINT `FK_systemsId` FOREIGN KEY (`systemsId`) REFERENCES `systems` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_userId` FOREIGN KEY (`userId`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
