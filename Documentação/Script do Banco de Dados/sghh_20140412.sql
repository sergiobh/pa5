/*
Navicat MySQL Data Transfer

Source Server         : MYSQL_Localhost
Source Server Version : 50616
Source Host           : localhost:3306
Source Database       : sghh

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2014-04-12 15:40:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for funcionario
-- ----------------------------
DROP TABLE IF EXISTS `funcionario`;
CREATE TABLE `funcionario` (
  `FuncionarioId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(40) NOT NULL,
  `SetorId` int(10) unsigned NOT NULL,
  `Cpf` char(11) NOT NULL,
  `Senha` varchar(33) NOT NULL,
  PRIMARY KEY (`FuncionarioId`),
  KEY `SetorId` (`SetorId`),
  CONSTRAINT `funcionario_ibfk_1` FOREIGN KEY (`SetorId`) REFERENCES `setor` (`SetorId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of funcionario
-- ----------------------------
INSERT INTO `funcionario` VALUES ('1', 'Sérgio Macedo', '0', '11111111111', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `funcionario` VALUES ('3', 'Geral', '0', '00000000000', '11111111');
INSERT INTO `funcionario` VALUES ('9', 'fabio', '8', '04307234669', 'sem acesso');
INSERT INTO `funcionario` VALUES ('10', 'enrique', '12', '04564567899', 'sem acesso');
INSERT INTO `funcionario` VALUES ('11', 'Maria', '9', '01365229638', 'sem acesso');
INSERT INTO `funcionario` VALUES ('12', 'João', '12', '01365229637', 'sem acesso');

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of setor
-- ----------------------------
INSERT INTO `setor` VALUES ('1', 'Recepção', '1');
INSERT INTO `setor` VALUES ('2', 'Camareira', '1');
INSERT INTO `setor` VALUES ('6', 'Geral', '0');
INSERT INTO `setor` VALUES ('7', 'Desenvolvimento', '1');
INSERT INTO `setor` VALUES ('8', 'BI', '3');
INSERT INTO `setor` VALUES ('9', 'SO', '1');
INSERT INTO `setor` VALUES ('10', 'CORP', '1');
INSERT INTO `setor` VALUES ('11', 'DB', '1');
INSERT INTO `setor` VALUES ('12', 'Importado via Xml', '1');

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
  CONSTRAINT `setorfuncionario_ibfk_2` FOREIGN KEY (`FuncionarioId`) REFERENCES `funcionario` (`FuncionarioId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `setorfuncionario_ibfk_1` FOREIGN KEY (`SetorId`) REFERENCES `setor` (`SetorId`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of setorfuncionario
-- ----------------------------
INSERT INTO `setorfuncionario` VALUES ('14', '8', '9');
INSERT INTO `setorfuncionario` VALUES ('15', '8', '3');
INSERT INTO `setorfuncionario` VALUES ('16', '8', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ticket
-- ----------------------------
INSERT INTO `ticket` VALUES ('56', '3', '1', '4', '2014-04-12 11:56:27', null, null, null, '10', null, '3');
INSERT INTO `ticket` VALUES ('57', '1', '1', '1', '2014-04-12 12:18:01', null, null, null, '8', null, '3');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ticket_historico
-- ----------------------------
INSERT INTO `ticket_historico` VALUES ('1', '56', 'Descrição do incidente do CORP', '1', '1', '2014-04-12 11:56:27');
INSERT INTO `ticket_historico` VALUES ('2', '56', 'abc.txt', '3', '1', '2014-04-12 12:11:20');
INSERT INTO `ticket_historico` VALUES ('3', '56', 'def', '1', '1', '2014-04-12 12:11:28');
INSERT INTO `ticket_historico` VALUES ('4', '57', 'Erro do Relatório de BI', '1', '1', '2014-04-12 12:18:01');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

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
  CONSTRAINT `ticket_tipo_ibfk_3` FOREIGN KEY (`SetorId`) REFERENCES `setor` (`SetorId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ticket_tipo_ibfk_1` FOREIGN KEY (`CategoriaId`) REFERENCES `ticket_categoria` (`CategoriaId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ticket_tipo_ibfk_2` FOREIGN KEY (`PriodidadeId`) REFERENCES `ticket_prioridade` (`PrioridadeId`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ticket_tipo
-- ----------------------------
INSERT INTO `ticket_tipo` VALUES ('1', 'Outros BI', '1', '8', '3', '12');
INSERT INTO `ticket_tipo` VALUES ('2', 'Outros SO', '2', '9', '3', '12');
INSERT INTO `ticket_tipo` VALUES ('3', 'Outros CORP', '3', '10', '3', '12');
INSERT INTO `ticket_tipo` VALUES ('4', 'Outros DB', '4', '11', '3', '12');
