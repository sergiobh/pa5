/*
Navicat MySQL Data Transfer

Source Server         : MYSQL_Localhost
Source Server Version : 50616
Source Host           : localhost:3306
Source Database       : sghh

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2014-04-18 18:07:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for funcionario
-- ----------------------------
DROP TABLE IF EXISTS `funcionario`;
CREATE TABLE `funcionario` (
  `FuncionarioId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(40) NOT NULL,
  `Cpf` char(11) NOT NULL,
  `Senha` varchar(33) NOT NULL,
  PRIMARY KEY (`FuncionarioId`),
  UNIQUE KEY `Cpf` (`Cpf`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of funcionario
-- ----------------------------
INSERT INTO `funcionario` VALUES ('1', 'Admin', '00000000000', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `funcionario` VALUES ('2', 'Sérgio Macedo', '11111111111', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `funcionario` VALUES ('3', 'Enrique Bonifácio', '22222222222', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `funcionario` VALUES ('5', 'Fábio', '33333333333', 'e10adc3949ba59abbe56e057f20f883e');

-- ----------------------------
-- Table structure for leito
-- ----------------------------
DROP TABLE IF EXISTS `leito`;
CREATE TABLE `leito` (
  `LeitoId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `QuartoId` int(10) unsigned NOT NULL,
  `Identificacao` varchar(10) NOT NULL,
  `Status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`LeitoId`),
  KEY `QuartoId` (`QuartoId`),
  CONSTRAINT `leito_ibfk_1` FOREIGN KEY (`QuartoId`) REFERENCES `quarto` (`QuartoId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of leito
-- ----------------------------
INSERT INTO `leito` VALUES ('1', '1', 'Leito 01', '1');

-- ----------------------------
-- Table structure for ocupacao
-- ----------------------------
DROP TABLE IF EXISTS `ocupacao`;
CREATE TABLE `ocupacao` (
  `OcupacaoId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PacienteId` int(10) unsigned NOT NULL,
  `LeitoId` int(10) unsigned NOT NULL,
  `Laudo` text,
  `FuncCadastro` int(10) unsigned NOT NULL,
  `DataCad` date NOT NULL,
  `HoraCad` time NOT NULL,
  `FuncBaixa` int(10) unsigned DEFAULT NULL,
  `DataBaixa` date DEFAULT NULL,
  `HoraBaixa` time DEFAULT NULL,
  PRIMARY KEY (`OcupacaoId`),
  KEY `PacienteId` (`PacienteId`),
  KEY `LeitoId` (`LeitoId`),
  KEY `FuncCadastro` (`FuncCadastro`),
  KEY `FuncBaixa` (`FuncBaixa`),
  CONSTRAINT `ocupacao_ibfk_1` FOREIGN KEY (`PacienteId`) REFERENCES `paciente` (`PacienteId`),
  CONSTRAINT `ocupacao_ibfk_2` FOREIGN KEY (`LeitoId`) REFERENCES `leito` (`LeitoId`),
  CONSTRAINT `ocupacao_ibfk_3` FOREIGN KEY (`FuncCadastro`) REFERENCES `funcionario` (`FuncionarioId`),
  CONSTRAINT `ocupacao_ibfk_4` FOREIGN KEY (`FuncBaixa`) REFERENCES `funcionario` (`FuncionarioId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ocupacao
-- ----------------------------

-- ----------------------------
-- Table structure for paciente
-- ----------------------------
DROP TABLE IF EXISTS `paciente`;
CREATE TABLE `paciente` (
  `PacienteId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(100) NOT NULL,
  `Sexo` tinyint(3) unsigned NOT NULL,
  `Cpf` char(11) NOT NULL,
  `Logradouro` varchar(50) DEFAULT NULL,
  `Numero` varchar(10) DEFAULT NULL,
  `Complemento` varchar(10) DEFAULT NULL,
  `Bairro` varchar(40) DEFAULT NULL,
  `Cidade` varchar(40) DEFAULT NULL,
  `Estado` char(2) DEFAULT NULL,
  `Tipo` tinyint(3) unsigned NOT NULL COMMENT '1 - Apartamento, 2 - Enfermária',
  `Status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `DataHora` datetime NOT NULL,
  PRIMARY KEY (`PacienteId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of paciente
-- ----------------------------

-- ----------------------------
-- Table structure for quarto
-- ----------------------------
DROP TABLE IF EXISTS `quarto`;
CREATE TABLE `quarto` (
  `QuartoId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Andar` varchar(10) NOT NULL,
  `Identificacao` varchar(10) NOT NULL,
  `Status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`QuartoId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of quarto
-- ----------------------------
INSERT INTO `quarto` VALUES ('1', '1 andar', 'Quarto 01', '1');
INSERT INTO `quarto` VALUES ('2', '2 andar', 'undefined', '1');

-- ----------------------------
-- Table structure for setor
-- ----------------------------
DROP TABLE IF EXISTS `setor`;
CREATE TABLE `setor` (
  `SetorId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(40) NOT NULL,
  `FuncionarioId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`SetorId`),
  KEY `FuncionarioId` (`FuncionarioId`),
  CONSTRAINT `setor_ibfk_1` FOREIGN KEY (`FuncionarioId`) REFERENCES `funcionario` (`FuncionarioId`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of setor
-- ----------------------------
INSERT INTO `setor` VALUES ('1', 'Recepção', '1');
INSERT INTO `setor` VALUES ('2', 'Camareira', '1');
INSERT INTO `setor` VALUES ('7', 'Desenvolvimento', '2');
INSERT INTO `setor` VALUES ('8', 'BI', '2');
INSERT INTO `setor` VALUES ('9', 'SO', '2');
INSERT INTO `setor` VALUES ('10', 'CORP', '2');
INSERT INTO `setor` VALUES ('11', 'DB', '2');

-- ----------------------------
-- Table structure for setorfuncionario
-- ----------------------------
DROP TABLE IF EXISTS `setorfuncionario`;
CREATE TABLE `setorfuncionario` (
  `SetorFuncionarioId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SetorId` int(10) unsigned NOT NULL,
  `FuncionarioId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`SetorFuncionarioId`),
  KEY `SetorId` (`SetorId`),
  KEY `FuncionarioId` (`FuncionarioId`),
  CONSTRAINT `setorfuncionario_ibfk_1` FOREIGN KEY (`SetorId`) REFERENCES `setor` (`SetorId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `setorfuncionario_ibfk_2` FOREIGN KEY (`FuncionarioId`) REFERENCES `funcionario` (`FuncionarioId`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of setorfuncionario
-- ----------------------------
INSERT INTO `setorfuncionario` VALUES ('17', '10', '2');

-- ----------------------------
-- Table structure for telefone
-- ----------------------------
DROP TABLE IF EXISTS `telefone`;
CREATE TABLE `telefone` (
  `TelefoneId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PacienteId` int(10) unsigned NOT NULL,
  `Telefone` varchar(14) NOT NULL,
  PRIMARY KEY (`TelefoneId`),
  KEY `PacienteId` (`PacienteId`),
  CONSTRAINT `telefone_ibfk_1` FOREIGN KEY (`PacienteId`) REFERENCES `paciente` (`PacienteId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of telefone
-- ----------------------------

-- ----------------------------
-- Table structure for ticket
-- ----------------------------
DROP TABLE IF EXISTS `ticket`;
CREATE TABLE `ticket` (
  `TicketId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TipoId` int(10) unsigned NOT NULL,
  `FuncionarioId` int(10) unsigned NOT NULL,
  `StatusId` int(10) unsigned NOT NULL,
  `DH_Solicitacao` datetime NOT NULL,
  `DH_Aceite` date DEFAULT NULL,
  `DH_Previsao` datetime DEFAULT NULL,
  `DH_Baixa` datetime DEFAULT NULL,
  `SetorId` int(10) unsigned DEFAULT NULL,
  `AtendenteId` int(10) unsigned DEFAULT NULL,
  `PrioridadeId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`TicketId`),
  KEY `tipoid` (`TipoId`),
  KEY `funcionarioid` (`FuncionarioId`),
  KEY `statusid` (`StatusId`),
  KEY `SetorId` (`SetorId`),
  KEY `PrioridadeId` (`PrioridadeId`),
  KEY `AtendenteId` (`AtendenteId`),
  CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`TipoId`) REFERENCES `ticket_tipo` (`TipoId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`FuncionarioId`) REFERENCES `funcionario` (`FuncionarioId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ticket_ibfk_3` FOREIGN KEY (`StatusId`) REFERENCES `ticket_status` (`StatusId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ticket_ibfk_4` FOREIGN KEY (`SetorId`) REFERENCES `setor` (`SetorId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ticket_ibfk_5` FOREIGN KEY (`PrioridadeId`) REFERENCES `ticket_prioridade` (`PrioridadeId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ticket_ibfk_6` FOREIGN KEY (`AtendenteId`) REFERENCES `funcionario` (`FuncionarioId`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ticket
-- ----------------------------
INSERT INTO `ticket` VALUES ('1', '3', '3', '1', '2014-04-18 09:10:40', null, null, null, '10', null, '3');

-- ----------------------------
-- Table structure for ticket_categoria
-- ----------------------------
DROP TABLE IF EXISTS `ticket_categoria`;
CREATE TABLE `ticket_categoria` (
  `CategoriaId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(50) NOT NULL,
  PRIMARY KEY (`CategoriaId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ticket_categoria
-- ----------------------------
INSERT INTO `ticket_categoria` VALUES ('1', 'BI');
INSERT INTO `ticket_categoria` VALUES ('2', 'SO');
INSERT INTO `ticket_categoria` VALUES ('3', 'CORP');
INSERT INTO `ticket_categoria` VALUES ('4', 'DB');

-- ----------------------------
-- Table structure for ticket_historico
-- ----------------------------
DROP TABLE IF EXISTS `ticket_historico`;
CREATE TABLE `ticket_historico` (
  `HistoricoId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TicketId` int(10) unsigned NOT NULL,
  `Texto` longtext,
  `HistoricoTipoId` tinyint(4) unsigned NOT NULL,
  `UsuarioId` int(10) unsigned NOT NULL,
  `DH_Cadastro` datetime NOT NULL,
  PRIMARY KEY (`HistoricoId`),
  KEY `UsuarioId` (`UsuarioId`),
  KEY `HistoricoTipoId` (`HistoricoTipoId`),
  KEY `TicketId` (`TicketId`),
  CONSTRAINT `ticket_historico_ibfk_1` FOREIGN KEY (`UsuarioId`) REFERENCES `funcionario` (`FuncionarioId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ticket_historico_ibfk_2` FOREIGN KEY (`HistoricoTipoId`) REFERENCES `ticket_histoticotipo` (`HistoticoTipoId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ticket_historico_ibfk_3` FOREIGN KEY (`TicketId`) REFERENCES `ticket` (`TicketId`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ticket_historico
-- ----------------------------
INSERT INTO `ticket_historico` VALUES ('24', '1', 'teste corp', '1', '2', '2014-04-18 09:10:40');
INSERT INTO `ticket_historico` VALUES ('25', '1', 'Canal_do_TS.txt', '4', '2', '2014-04-18 10:13:36');
INSERT INTO `ticket_historico` VALUES ('26', '1', 'Canal_do_TS1.txt', '4', '2', '2014-04-18 10:14:28');
INSERT INTO `ticket_historico` VALUES ('27', '1', 'oculos.jpg', '4', '3', '2014-04-18 10:16:53');
INSERT INTO `ticket_historico` VALUES ('28', '1', 'oculos1.jpg', '4', '3', '2014-04-18 10:19:48');
INSERT INTO `ticket_historico` VALUES ('29', '1', 'oculos3.jpg', '3', '3', '2014-04-18 10:23:59');
INSERT INTO `ticket_historico` VALUES ('30', '1', 'teste1 abcdefg', '1', '3', '2014-04-18 10:57:08');
INSERT INTO `ticket_historico` VALUES ('31', '1', 'teste2 atendente Sérgio', '2', '2', '2014-04-18 10:59:20');
INSERT INTO `ticket_historico` VALUES ('32', '1', 'mensagem 2 - Sérgio atendente', '2', '2', '2014-04-18 11:00:00');
INSERT INTO `ticket_historico` VALUES ('33', '1', 'teste 4 de reload', '2', '2', '2014-04-18 11:10:57');
INSERT INTO `ticket_historico` VALUES ('34', '1', 'teste5 reload', '2', '2', '2014-04-18 11:11:54');
INSERT INTO `ticket_historico` VALUES ('35', '1', 'teste6 reload', '2', '2', '2014-04-18 11:12:58');
INSERT INTO `ticket_historico` VALUES ('36', '1', 'teste7 reload', '2', '2', '2014-04-18 11:13:09');
INSERT INTO `ticket_historico` VALUES ('37', '1', 'oculos4.jpg', '4', '2', '2014-04-18 11:13:46');
INSERT INTO `ticket_historico` VALUES ('38', '1', 'oculos5.jpg', '3', '3', '2014-04-18 11:14:24');

-- ----------------------------
-- Table structure for ticket_histoticotipo
-- ----------------------------
DROP TABLE IF EXISTS `ticket_histoticotipo`;
CREATE TABLE `ticket_histoticotipo` (
  `HistoticoTipoId` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(50) NOT NULL,
  PRIMARY KEY (`HistoticoTipoId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ticket_histoticotipo
-- ----------------------------
INSERT INTO `ticket_histoticotipo` VALUES ('1', 'Mensagem do Solicitante');
INSERT INTO `ticket_histoticotipo` VALUES ('2', 'Mensagem do Atendente');
INSERT INTO `ticket_histoticotipo` VALUES ('3', 'Anexo do Solicitante');
INSERT INTO `ticket_histoticotipo` VALUES ('4', 'Anexo do Atendente');

-- ----------------------------
-- Table structure for ticket_prioridade
-- ----------------------------
DROP TABLE IF EXISTS `ticket_prioridade`;
CREATE TABLE `ticket_prioridade` (
  `PrioridadeId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(20) NOT NULL,
  `Tempo` int(11) NOT NULL DEFAULT '24' COMMENT 'Tempo de Resposta da Prioridade',
  PRIMARY KEY (`PrioridadeId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ticket_prioridade
-- ----------------------------
INSERT INTO `ticket_prioridade` VALUES ('1', 'Multo Alta', '1');
INSERT INTO `ticket_prioridade` VALUES ('2', 'Alta', '6');
INSERT INTO `ticket_prioridade` VALUES ('3', 'Normal', '12');
INSERT INTO `ticket_prioridade` VALUES ('4', 'Baixa', '24');
INSERT INTO `ticket_prioridade` VALUES ('5', 'Muito Baixa', '48');
INSERT INTO `ticket_prioridade` VALUES ('6', 'Planejada', '60');

-- ----------------------------
-- Table structure for ticket_status
-- ----------------------------
DROP TABLE IF EXISTS `ticket_status`;
CREATE TABLE `ticket_status` (
  `StatusId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(50) NOT NULL,
  `TipoBotao` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`StatusId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ticket_status
-- ----------------------------
INSERT INTO `ticket_status` VALUES ('1', 'Aberto', 'btn-success');
INSERT INTO `ticket_status` VALUES ('2', 'Aguardando Resposta', 'btn-warning');
INSERT INTO `ticket_status` VALUES ('3', 'Respondido', 'btn-warning');
INSERT INTO `ticket_status` VALUES ('4', 'Em manutenção', 'btn-info');
INSERT INTO `ticket_status` VALUES ('5', 'Fechado', 'btn-danger');
INSERT INTO `ticket_status` VALUES ('6', 'Cancelado', 'btn-primary');
INSERT INTO `ticket_status` VALUES ('7', 'Indeferido', 'btn-danger');

-- ----------------------------
-- Table structure for ticket_tipo
-- ----------------------------
DROP TABLE IF EXISTS `ticket_tipo`;
CREATE TABLE `ticket_tipo` (
  `TipoId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(100) NOT NULL,
  `CategoriaId` int(10) unsigned NOT NULL,
  `SetorId` int(10) unsigned NOT NULL,
  `PriodidadeId` int(10) unsigned NOT NULL,
  `SLA` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'Por convensão unidade de medida é HORA',
  PRIMARY KEY (`TipoId`),
  KEY `categoriaid` (`CategoriaId`),
  KEY `PriodidadeId` (`PriodidadeId`),
  KEY `SetorId` (`SetorId`),
  CONSTRAINT `ticket_tipo_ibfk_1` FOREIGN KEY (`CategoriaId`) REFERENCES `ticket_categoria` (`CategoriaId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ticket_tipo_ibfk_2` FOREIGN KEY (`PriodidadeId`) REFERENCES `ticket_prioridade` (`PrioridadeId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ticket_tipo_ibfk_3` FOREIGN KEY (`SetorId`) REFERENCES `setor` (`SetorId`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ticket_tipo
-- ----------------------------
INSERT INTO `ticket_tipo` VALUES ('1', 'Outros BI', '1', '8', '3', '12');
INSERT INTO `ticket_tipo` VALUES ('2', 'Outros SO', '2', '9', '3', '12');
INSERT INTO `ticket_tipo` VALUES ('3', 'Outros CORP', '3', '10', '3', '12');
INSERT INTO `ticket_tipo` VALUES ('4', 'Outros DB', '4', '11', '3', '12');
