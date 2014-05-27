/*
Navicat MySQL Data Transfer

Source Server         : MYSQL_Localhost
Source Server Version : 50616
Source Host           : localhost:3306
Source Database       : sghh

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2014-05-27 16:32:57
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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of funcionario
-- ----------------------------
INSERT INTO `funcionario` VALUES ('1', 'Admin', '11111111111', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `funcionario` VALUES ('2', 'Sérgio Macedo', '22222222222', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `funcionario` VALUES ('3', 'Enrique Bonifácio', '33333333333', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `funcionario` VALUES ('4', 'Weslei Nunes', '44444444444', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `funcionario` VALUES ('5', 'Fábio Mello', '55555555555', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `funcionario` VALUES ('6', 'Juliana Vieira', '66666666666', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `funcionario` VALUES ('7', 'Jorge Pimenta', '77777777777', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `funcionario` VALUES ('8', 'Humberto Paulus', '88888888888', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `funcionario` VALUES ('10', 'Joana', '99999999999', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `funcionario` VALUES ('12', 'Maria', '00000000000', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `funcionario` VALUES ('15', 'Maria', '01365229638', 'd8c4dc8d9f564181068be4cf7aa97ba0');
INSERT INTO `funcionario` VALUES ('16', 'João', '01365229637', 'd8c4dc8d9f564181068be4cf7aa97ba0');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of leito
-- ----------------------------

-- ----------------------------
-- Table structure for mudanca
-- ----------------------------
DROP TABLE IF EXISTS `mudanca`;
CREATE TABLE `mudanca` (
  `MudancaId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(200) NOT NULL,
  `Descricao` text,
  `PrioridadeId` int(10) unsigned NOT NULL,
  `UsuarioId` int(10) unsigned NOT NULL,
  `DH_Solicitacao` datetime NOT NULL,
  `AutorizacaoDesenvolvimento` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0-Não autorizado 1-Autorizado',
  `StatusId` tinyint(10) unsigned NOT NULL DEFAULT '1',
  `Avaliacao` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0-Não aprovado 1-Aprovado',
  PRIMARY KEY (`MudancaId`),
  KEY `PrioridadeId` (`PrioridadeId`),
  KEY `0` (`UsuarioId`),
  KEY `StatusId` (`StatusId`),
  CONSTRAINT `0` FOREIGN KEY (`UsuarioId`) REFERENCES `funcionario` (`FuncionarioId`) ON UPDATE CASCADE,
  CONSTRAINT `mudanca_ibfk_1` FOREIGN KEY (`PrioridadeId`) REFERENCES `ticket_prioridade` (`PrioridadeId`) ON UPDATE CASCADE,
  CONSTRAINT `mudanca_ibfk_2` FOREIGN KEY (`StatusId`) REFERENCES `mudanca_status` (`StatusId`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mudanca
-- ----------------------------
INSERT INTO `mudanca` VALUES ('1', 'Nome da mudança', 'Descrição da mudança', '1', '1', '2014-05-22 22:13:21', '0', '1', '0');

-- ----------------------------
-- Table structure for mudanca_comite
-- ----------------------------
DROP TABLE IF EXISTS `mudanca_comite`;
CREATE TABLE `mudanca_comite` (
  `ComiteId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UsuarioId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ComiteId`),
  KEY `UsuarioId` (`UsuarioId`),
  CONSTRAINT `mudanca_comite_ibfk_1` FOREIGN KEY (`UsuarioId`) REFERENCES `funcionario` (`FuncionarioId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mudanca_comite
-- ----------------------------

-- ----------------------------
-- Table structure for mudanca_justificativa
-- ----------------------------
DROP TABLE IF EXISTS `mudanca_justificativa`;
CREATE TABLE `mudanca_justificativa` (
  `JustificativaId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `MudancaId` int(10) unsigned NOT NULL,
  `Justificativa` text NOT NULL,
  `UsuarioId` int(10) unsigned NOT NULL,
  `DH_Cadastro` datetime NOT NULL,
  PRIMARY KEY (`JustificativaId`),
  KEY `MudancaId` (`MudancaId`),
  KEY `UsuarioId` (`UsuarioId`),
  CONSTRAINT `mudanca_justificativa_ibfk_2` FOREIGN KEY (`UsuarioId`) REFERENCES `funcionario` (`FuncionarioId`) ON UPDATE CASCADE,
  CONSTRAINT `mudanca_justificativa_ibfk_1` FOREIGN KEY (`MudancaId`) REFERENCES `mudanca` (`MudancaId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mudanca_justificativa
-- ----------------------------

-- ----------------------------
-- Table structure for mudanca_status
-- ----------------------------
DROP TABLE IF EXISTS `mudanca_status`;
CREATE TABLE `mudanca_status` (
  `StatusId` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(40) NOT NULL,
  PRIMARY KEY (`StatusId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mudanca_status
-- ----------------------------
INSERT INTO `mudanca_status` VALUES ('1', 'Não avaliado');
INSERT INTO `mudanca_status` VALUES ('2', 'Aprovado');
INSERT INTO `mudanca_status` VALUES ('3', 'Reprovado');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of paciente
-- ----------------------------
INSERT INTO `paciente` VALUES ('1', 'Sérgio Macedo', '1', '01257303651', 'Rua I', '932', '', 'Eldorado', 'Contagem', 'MG', '1', '1', '2014-05-07 19:20:13');
INSERT INTO `paciente` VALUES ('2', 'Wesley Nunes de Assis', '1', '01266439625', 'Rua A', '2', '', 'Eldorado', 'Contagem', 'MG', '2', '1', '2014-05-07 18:38:44');
INSERT INTO `paciente` VALUES ('3', 'Juliana Vieira', '2', '06027264683', 'Rua B', '5', '', 'Centro', 'Belo Horizonte', 'MG', '1', '0', '2014-05-07 18:40:33');

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of quarto
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of setor
-- ----------------------------
INSERT INTO `setor` VALUES ('19', 'BI', '2');
INSERT INTO `setor` VALUES ('20', 'SO', '2');
INSERT INTO `setor` VALUES ('21', 'CORP', '2');
INSERT INTO `setor` VALUES ('22', 'BD', '2');
INSERT INTO `setor` VALUES ('23', 'Desenvolvimento I', '2');
INSERT INTO `setor` VALUES ('24', 'Desenvolvimento II', '2');
INSERT INTO `setor` VALUES ('25', 'Desenvolvimento III', '2');
INSERT INTO `setor` VALUES ('26', 'Banco de Dados I', '2');
INSERT INTO `setor` VALUES ('27', 'Banco de Dados II', '2');
INSERT INTO `setor` VALUES ('28', 'Recepção', '2');
INSERT INTO `setor` VALUES ('29', 'Camareira', '2');
INSERT INTO `setor` VALUES ('30', 'Analísta de Requisitos', '2');

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
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of setorfuncionario
-- ----------------------------
INSERT INTO `setorfuncionario` VALUES ('63', '26', '3');
INSERT INTO `setorfuncionario` VALUES ('64', '27', '4');
INSERT INTO `setorfuncionario` VALUES ('68', '23', '3');
INSERT INTO `setorfuncionario` VALUES ('69', '24', '7');
INSERT INTO `setorfuncionario` VALUES ('70', '25', '4');
INSERT INTO `setorfuncionario` VALUES ('71', '29', '12');
INSERT INTO `setorfuncionario` VALUES ('72', '28', '12');
INSERT INTO `setorfuncionario` VALUES ('73', '20', '10');
INSERT INTO `setorfuncionario` VALUES ('74', '21', '10');
INSERT INTO `setorfuncionario` VALUES ('75', '19', '10');
INSERT INTO `setorfuncionario` VALUES ('76', '22', '10');
INSERT INTO `setorfuncionario` VALUES ('77', '30', '6');
INSERT INTO `setorfuncionario` VALUES ('78', '19', '4');
INSERT INTO `setorfuncionario` VALUES ('79', '20', '15');
INSERT INTO `setorfuncionario` VALUES ('80', '20', '16');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of telefone
-- ----------------------------
INSERT INTO `telefone` VALUES ('3', '2', '(31)9227-9390');
INSERT INTO `telefone` VALUES ('4', '3', '(31)9999-9999');
INSERT INTO `telefone` VALUES ('5', '1', '(31)8811-8927');

-- ----------------------------
-- Table structure for ticket
-- ----------------------------
DROP TABLE IF EXISTS `ticket`;
CREATE TABLE `ticket` (
  `TicketId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TipoId` int(10) unsigned NOT NULL,
  `FuncionarioId` int(10) unsigned NOT NULL,
  `DH_Solicitacao` datetime NOT NULL,
  `DH_Aceite` date DEFAULT NULL,
  `DH_Previsao` datetime DEFAULT NULL,
  `DH_Baixa` datetime DEFAULT NULL,
  `PrioridadeId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`TicketId`),
  KEY `tipoid` (`TipoId`),
  KEY `funcionarioid` (`FuncionarioId`),
  KEY `PrioridadeId` (`PrioridadeId`),
  CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`TipoId`) REFERENCES `ticket_tipo` (`TipoId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`FuncionarioId`) REFERENCES `funcionario` (`FuncionarioId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ticket_ibfk_5` FOREIGN KEY (`PrioridadeId`) REFERENCES `ticket_prioridade` (`PrioridadeId`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ticket
-- ----------------------------
INSERT INTO `ticket` VALUES ('24', '19', '15', '2014-05-27 15:54:13', null, null, null, '3');
INSERT INTO `ticket` VALUES ('25', '19', '15', '2014-05-27 15:54:13', null, null, null, '3');
INSERT INTO `ticket` VALUES ('26', '19', '15', '2014-05-27 16:15:50', null, null, null, '3');
INSERT INTO `ticket` VALUES ('27', '19', '15', '2014-05-27 16:15:50', null, null, null, '3');
INSERT INTO `ticket` VALUES ('28', '35', '4', '2014-05-03 11:11:09', null, null, null, '3');

-- ----------------------------
-- Table structure for ticket_atendimento
-- ----------------------------
DROP TABLE IF EXISTS `ticket_atendimento`;
CREATE TABLE `ticket_atendimento` (
  `AtendimentoId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TicketId` int(10) unsigned NOT NULL,
  `Tipo_Nivel` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `StatusId` int(10) unsigned NOT NULL DEFAULT '1',
  `AtendenteId` int(10) unsigned DEFAULT NULL,
  `DH_Solicitacao` datetime NOT NULL,
  `Ativo` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`AtendimentoId`),
  KEY `TicketId` (`TicketId`),
  KEY `StatusId` (`StatusId`),
  KEY `AtendenteId` (`AtendenteId`),
  CONSTRAINT `ticket_atendimento_ibfk_1` FOREIGN KEY (`TicketId`) REFERENCES `ticket` (`TicketId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ticket_atendimento_ibfk_2` FOREIGN KEY (`StatusId`) REFERENCES `ticket_status` (`StatusId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `ticket_atendimento_ibfk_3` FOREIGN KEY (`AtendenteId`) REFERENCES `funcionario` (`FuncionarioId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ticket_atendimento
-- ----------------------------
INSERT INTO `ticket_atendimento` VALUES ('29', '24', '1', '1', '15', '2014-05-27 15:54:13', '1');
INSERT INTO `ticket_atendimento` VALUES ('30', '25', '1', '1', '15', '2014-05-27 15:54:13', '1');
INSERT INTO `ticket_atendimento` VALUES ('31', '26', '1', '1', '15', '2014-05-27 16:15:50', '1');
INSERT INTO `ticket_atendimento` VALUES ('32', '27', '1', '1', '15', '2014-05-27 16:15:50', '1');
INSERT INTO `ticket_atendimento` VALUES ('33', '28', '1', '1', '4', '2014-05-03 11:11:09', '1');

-- ----------------------------
-- Table structure for ticket_categoria
-- ----------------------------
DROP TABLE IF EXISTS `ticket_categoria`;
CREATE TABLE `ticket_categoria` (
  `CategoriaId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(50) NOT NULL,
  PRIMARY KEY (`CategoriaId`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ticket_categoria
-- ----------------------------
INSERT INTO `ticket_categoria` VALUES ('1', 'BI');
INSERT INTO `ticket_categoria` VALUES ('2', 'SO');
INSERT INTO `ticket_categoria` VALUES ('3', 'CORP');
INSERT INTO `ticket_categoria` VALUES ('4', 'BD');
INSERT INTO `ticket_categoria` VALUES ('12', 'Usuário');
INSERT INTO `ticket_categoria` VALUES ('13', 'Quarto');
INSERT INTO `ticket_categoria` VALUES ('14', 'Leito');
INSERT INTO `ticket_categoria` VALUES ('15', 'Paciente');
INSERT INTO `ticket_categoria` VALUES ('16', 'Setor');
INSERT INTO `ticket_categoria` VALUES ('17', 'Categoria');

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
  `TipoNivel` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `DH_Cadastro` datetime NOT NULL,
  PRIMARY KEY (`HistoricoId`),
  KEY `UsuarioId` (`UsuarioId`),
  KEY `HistoricoTipoId` (`HistoricoTipoId`),
  KEY `TicketId` (`TicketId`),
  CONSTRAINT `ticket_historico_ibfk_1` FOREIGN KEY (`UsuarioId`) REFERENCES `funcionario` (`FuncionarioId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ticket_historico_ibfk_2` FOREIGN KEY (`HistoricoTipoId`) REFERENCES `ticket_histoticotipo` (`HistoticoTipoId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ticket_historico_ibfk_3` FOREIGN KEY (`TicketId`) REFERENCES `ticket` (`TicketId`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ticket_historico
-- ----------------------------
INSERT INTO `ticket_historico` VALUES ('22', '28', 'Ticket importado via XML', '5', '2', '1', '2014-05-27 16:30:34');

-- ----------------------------
-- Table structure for ticket_histoticotipo
-- ----------------------------
DROP TABLE IF EXISTS `ticket_histoticotipo`;
CREATE TABLE `ticket_histoticotipo` (
  `HistoticoTipoId` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(50) NOT NULL,
  PRIMARY KEY (`HistoticoTipoId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ticket_histoticotipo
-- ----------------------------
INSERT INTO `ticket_histoticotipo` VALUES ('1', 'Mensagem do Solicitante');
INSERT INTO `ticket_histoticotipo` VALUES ('2', 'Mensagem do Atendente');
INSERT INTO `ticket_histoticotipo` VALUES ('3', 'Anexo do Solicitante');
INSERT INTO `ticket_histoticotipo` VALUES ('4', 'Anexo do Atendente');
INSERT INTO `ticket_histoticotipo` VALUES ('5', 'Mensagem entre Atendentes');
INSERT INTO `ticket_histoticotipo` VALUES ('6', 'Elevação de Nível do Suporte');

-- ----------------------------
-- Table structure for ticket_prioridade
-- ----------------------------
DROP TABLE IF EXISTS `ticket_prioridade`;
CREATE TABLE `ticket_prioridade` (
  `PrioridadeId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(20) NOT NULL,
  `Tempo` int(11) NOT NULL DEFAULT '24' COMMENT 'Tempo de Resposta da Prioridade',
  `TipoBotao` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`PrioridadeId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ticket_prioridade
-- ----------------------------
INSERT INTO `ticket_prioridade` VALUES ('1', 'Muito Alta', '1', 'btn-danger');
INSERT INTO `ticket_prioridade` VALUES ('2', 'Alta', '6', 'btn-warning');
INSERT INTO `ticket_prioridade` VALUES ('3', 'Normal', '12', 'btn-primary');
INSERT INTO `ticket_prioridade` VALUES ('4', 'Baixa', '24', 'btn-info');
INSERT INTO `ticket_prioridade` VALUES ('5', 'Muito Baixa', '48', 'btn-success');
INSERT INTO `ticket_prioridade` VALUES ('6', 'Planejada', '60', null);

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
  `PrioridadeId` int(10) unsigned NOT NULL,
  `SLA` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'Por convensão unidade de medida é HORA',
  `Ativo` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`TipoId`),
  KEY `categoriaid` (`CategoriaId`),
  KEY `PriodidadeId` (`PrioridadeId`),
  CONSTRAINT `ticket_tipo_ibfk_1` FOREIGN KEY (`CategoriaId`) REFERENCES `ticket_categoria` (`CategoriaId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ticket_tipo_ibfk_2` FOREIGN KEY (`PrioridadeId`) REFERENCES `ticket_prioridade` (`PrioridadeId`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ticket_tipo
-- ----------------------------
INSERT INTO `ticket_tipo` VALUES ('19', 'Outros SO', '2', '3', '12', '1');
INSERT INTO `ticket_tipo` VALUES ('20', 'Outros CORP', '3', '3', '12', '1');
INSERT INTO `ticket_tipo` VALUES ('21', 'Outros BD', '4', '3', '12', '1');
INSERT INTO `ticket_tipo` VALUES ('22', 'Cadastro de leito', '14', '4', '24', '1');
INSERT INTO `ticket_tipo` VALUES ('23', 'Edição do leito', '14', '4', '24', '1');
INSERT INTO `ticket_tipo` VALUES ('24', 'Alteração do status do leito', '14', '2', '3', '1');
INSERT INTO `ticket_tipo` VALUES ('25', 'Cadastro de quartob', '13', '4', '24', '1');
INSERT INTO `ticket_tipo` VALUES ('26', 'Edição do quarto', '13', '3', '12', '1');
INSERT INTO `ticket_tipo` VALUES ('27', 'Consulta de paciente', '15', '1', '2', '1');
INSERT INTO `ticket_tipo` VALUES ('28', 'Ocupação do paciente', '15', '1', '2', '1');
INSERT INTO `ticket_tipo` VALUES ('29', 'Cadastro de categoria', '17', '3', '12', '1');
INSERT INTO `ticket_tipo` VALUES ('30', 'Cadastro de setor', '16', '4', '24', '1');
INSERT INTO `ticket_tipo` VALUES ('31', 'Edição de setor', '16', '3', '12', '1');
INSERT INTO `ticket_tipo` VALUES ('32', 'Falha ao logar', '12', '2', '3', '1');
INSERT INTO `ticket_tipo` VALUES ('33', 'Cadastro de usuário', '12', '3', '12', '1');
INSERT INTO `ticket_tipo` VALUES ('34', 'Deslogar usuário', '12', '2', '3', '1');
INSERT INTO `ticket_tipo` VALUES ('35', 'Outros BI', '1', '3', '12', '1');

-- ----------------------------
-- Table structure for ticket_tiponivel
-- ----------------------------
DROP TABLE IF EXISTS `ticket_tiponivel`;
CREATE TABLE `ticket_tiponivel` (
  `TipoNivelId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TipoId` int(10) unsigned NOT NULL,
  `Nivel` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `SetorId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`TipoNivelId`),
  KEY `Tipoid` (`TipoId`),
  KEY `SetorId` (`SetorId`),
  CONSTRAINT `ticket_tiponivel_ibfk_1` FOREIGN KEY (`TipoId`) REFERENCES `ticket_tipo` (`TipoId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ticket_tiponivel_ibfk_2` FOREIGN KEY (`SetorId`) REFERENCES `setor` (`SetorId`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ticket_tiponivel
-- ----------------------------
INSERT INTO `ticket_tiponivel` VALUES ('31', '19', '1', '20');
INSERT INTO `ticket_tiponivel` VALUES ('32', '20', '1', '21');
INSERT INTO `ticket_tiponivel` VALUES ('33', '21', '1', '22');
INSERT INTO `ticket_tiponivel` VALUES ('34', '22', '1', '23');
INSERT INTO `ticket_tiponivel` VALUES ('35', '23', '1', '23');
INSERT INTO `ticket_tiponivel` VALUES ('36', '24', '1', '23');
INSERT INTO `ticket_tiponivel` VALUES ('37', '25', '1', '23');
INSERT INTO `ticket_tiponivel` VALUES ('38', '26', '1', '23');
INSERT INTO `ticket_tiponivel` VALUES ('39', '27', '1', '23');
INSERT INTO `ticket_tiponivel` VALUES ('40', '28', '1', '23');
INSERT INTO `ticket_tiponivel` VALUES ('41', '29', '1', '23');
INSERT INTO `ticket_tiponivel` VALUES ('42', '30', '1', '23');
INSERT INTO `ticket_tiponivel` VALUES ('43', '31', '1', '23');
INSERT INTO `ticket_tiponivel` VALUES ('44', '32', '1', '23');
INSERT INTO `ticket_tiponivel` VALUES ('45', '33', '1', '23');
INSERT INTO `ticket_tiponivel` VALUES ('46', '34', '1', '23');
INSERT INTO `ticket_tiponivel` VALUES ('47', '35', '1', '19');

-- ----------------------------
-- Table structure for vinculo_mudanca_ticket
-- ----------------------------
DROP TABLE IF EXISTS `vinculo_mudanca_ticket`;
CREATE TABLE `vinculo_mudanca_ticket` (
  `VinculoId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `MudancaId` int(10) unsigned NOT NULL,
  `TicketId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`VinculoId`),
  KEY `MudancaId` (`MudancaId`),
  KEY `TicketId` (`TicketId`),
  CONSTRAINT `vinculo_mudanca_ticket_ibfk_2` FOREIGN KEY (`TicketId`) REFERENCES `ticket` (`TicketId`) ON UPDATE CASCADE,
  CONSTRAINT `vinculo_mudanca_ticket_ibfk_1` FOREIGN KEY (`MudancaId`) REFERENCES `mudanca` (`MudancaId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of vinculo_mudanca_ticket
-- ----------------------------
