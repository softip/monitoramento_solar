-- --------------------------------------------------------
-- Servidor:                     192.168.1.111
-- Versão do servidor:           10.0.38-MariaDB-0ubuntu0.16.04.1 - Ubuntu 16.04
-- OS do Servidor:               debian-linux-gnueabihf
-- HeidiSQL Versão:              9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para solarmon
CREATE DATABASE IF NOT EXISTS `solarmon` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `solarmon`;

-- Copiando estrutura para tabela solarmon.cliente
CREATE TABLE IF NOT EXISTS `cliente` (
  `idcliente` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `fone` varchar(45) DEFAULT NULL,
  `cpf` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `senha` varchar(45) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idcliente`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela solarmon.cliente: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` (`idcliente`, `nome`, `fone`, `cpf`, `email`, `senha`, `foto`) VALUES
	(21, 'Ivan Paulino Pereira', '(35) 9911-9090', '07298764624', 'ivan.pereira@ifsuldeminas.edu.br', '123', '2a001-unnamed.jpg'),
	(22, 'Universidade Estadual de Campinas', '(19) 3521-7000', '12344', 'unicamp', '123', '2666a-unicamp.png');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;

-- Copiando estrutura para tabela solarmon.energia_gerada
CREATE TABLE IF NOT EXISTS `energia_gerada` (
  `idenergia_gerada` int(11) NOT NULL AUTO_INCREMENT,
  `energia` varchar(45) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `valor_atual` float DEFAULT NULL,
  `planta_idplanta` int(11) NOT NULL,
  PRIMARY KEY (`idenergia_gerada`),
  KEY `fk_energia_gerada_planta1_idx` (`planta_idplanta`),
  CONSTRAINT `fk_energia_gerada_planta1` FOREIGN KEY (`planta_idplanta`) REFERENCES `planta` (`idplanta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela solarmon.energia_gerada: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `energia_gerada` DISABLE KEYS */;
/*!40000 ALTER TABLE `energia_gerada` ENABLE KEYS */;

-- Copiando estrutura para tabela solarmon.medicao
CREATE TABLE IF NOT EXISTS `medicao` (
  `idmedicao` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NULL DEFAULT NULL,
  `potencia` float DEFAULT NULL,
  `temperatura` float DEFAULT NULL,
  `luminosidade` float DEFAULT NULL,
  `previsao_tempo` varchar(45) DEFAULT NULL,
  `planta_idplanta` int(11) NOT NULL,
  PRIMARY KEY (`idmedicao`),
  KEY `fk_medicao_planta1_idx` (`planta_idplanta`),
  CONSTRAINT `fk_medicao_planta1` FOREIGN KEY (`planta_idplanta`) REFERENCES `planta` (`idplanta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela solarmon.medicao: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `medicao` DISABLE KEYS */;
/*!40000 ALTER TABLE `medicao` ENABLE KEYS */;

-- Copiando estrutura para tabela solarmon.placas
CREATE TABLE IF NOT EXISTS `placas` (
  `idplacas` int(11) NOT NULL AUTO_INCREMENT,
  `planta_idplanta` int(11) NOT NULL,
  `fabricante` varchar(45) DEFAULT NULL,
  `potencia_maxima` float DEFAULT NULL,
  `potencia_minima` float DEFAULT NULL,
  `corrente_maxima` float DEFAULT NULL,
  `tensao_maxima` float DEFAULT NULL,
  `corrente_curto_circuito` float DEFAULT NULL,
  `tensao_circuito_aberto` float DEFAULT NULL,
  `tensao_max_admissivel` float DEFAULT NULL,
  `eficiencia` float DEFAULT NULL,
  `coeficiente_termico_tensao` float DEFAULT NULL,
  `coeficiente_termico_corrente` float DEFAULT NULL,
  PRIMARY KEY (`idplacas`,`planta_idplanta`),
  KEY `fk_placas_planta1_idx` (`planta_idplanta`),
  CONSTRAINT `fk_placas_planta1` FOREIGN KEY (`planta_idplanta`) REFERENCES `planta` (`idplanta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela solarmon.placas: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `placas` DISABLE KEYS */;
INSERT INTO `placas` (`idplacas`, `planta_idplanta`, `fabricante`, `potencia_maxima`, `potencia_minima`, `corrente_maxima`, `tensao_maxima`, `corrente_curto_circuito`, `tensao_circuito_aberto`, `tensao_max_admissivel`, `eficiencia`, `coeficiente_termico_tensao`, `coeficiente_termico_corrente`) VALUES
	(1, 1, 'KRIPT', 300, 32.97, 9.1, 39.97, 9.48, 39.97, NULL, 18.4, NULL, NULL);
/*!40000 ALTER TABLE `placas` ENABLE KEYS */;

-- Copiando estrutura para tabela solarmon.planta
CREATE TABLE IF NOT EXISTS `planta` (
  `idplanta` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_idcliente` int(11) NOT NULL,
  `sistema` enum('On Grid','Off Grid') DEFAULT NULL,
  `local` varchar(45) DEFAULT NULL,
  `endereco` varchar(150) DEFAULT NULL,
  `foto` varchar(200) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idplanta`),
  KEY `fk_planta_cliente_idx` (`cliente_idcliente`),
  CONSTRAINT `fk_planta_cliente` FOREIGN KEY (`cliente_idcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela solarmon.planta: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `planta` DISABLE KEYS */;
INSERT INTO `planta` (`idplanta`, `cliente_idcliente`, `sistema`, `local`, `endereco`, `foto`, `latitude`, `longitude`) VALUES
	(1, 21, 'On Grid', 'Casa', 'Av Arlindo Bonamichi, 474 - Santa Isabel - Inconfidentes - MG', '52ae2-sistema-fotovoltaico-artigos-cursos-cpt.jpg', '-22.309982', '-46.321486'),
	(2, 21, 'On Grid', 'teste', 'teste', '1ed6a-sistema-fotovoltaico-artigos-cursos-cpt.jpg', '-22.309982', '-46.321486'),
	(3, 22, 'Off Grid', 'Cidade Universitária Zeferino Vaz', 'Av. Barão Geraldo, Campinas - SP, CEP 13083-970', 'c3c21-untitled-1.jpg', '-22.8184', '-47.0647');
/*!40000 ALTER TABLE `planta` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
