/*
Navicat MySQL Data Transfer

Source Server         : MYSQL_Localhost
Source Server Version : 50616
Source Host           : localhost:3306
Source Database       : sghh

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2014-05-25 19:27:34
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

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
INSERT INTO `leito` VALUES ('1', '1', 'Leito 01', '1');
INSERT INTO `leito` VALUES ('2', '1', 'Leito 02', '2');
INSERT INTO `leito` VALUES ('3', '1', 'Leito 03', '1');
INSERT INTO `leito` VALUES ('4', '1', 'Leito 04', '1');
INSERT INTO `leito` VALUES ('5', '2', 'Leito 01', '1');
INSERT INTO `leito` VALUES ('6', '4', 'Leito 01', '1');

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
INSERT INTO `ocupacao` VALUES ('1', '1', '6', null, '1', '2014-05-07', '18:28:25', '1', '2014-05-07', '18:41:08');
INSERT INTO `ocupacao` VALUES ('2', '2', '1', null, '1', '2014-05-07', '18:39:04', null, null, null);
INSERT INTO `ocupacao` VALUES ('3', '3', '5', null, '1', '2014-05-07', '18:40:53', '1', '2014-05-07', '19:19:22');
INSERT INTO `ocupacao` VALUES ('4', '1', '6', null, '1', '2014-05-07', '19:20:59', null, null, null);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of quarto
-- ----------------------------
INSERT INTO `quarto` VALUES ('1', '1 andar', 'Quarto 01', '1');
INSERT INTO `quarto` VALUES ('2', '2 andar', 'Quarto Fem', '1');
INSERT INTO `quarto` VALUES ('3', '1 ANDAR', 'Quarto 02', '1');
INSERT INTO `quarto` VALUES ('4', '1 ANDAR', 'Quarto 03', '1');
INSERT INTO `quarto` VALUES ('5', 'Andar 10', 'undefined', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of setor
-- ----------------------------
INSERT INTO `setor` VALUES ('1', 'Recepção', '2');
INSERT INTO `setor` VALUES ('2', 'Camareira', '2');
INSERT INTO `setor` VALUES ('3', 'Desenvolvimento I', '2');
INSERT INTO `setor` VALUES ('4', 'Documentação', '2');
INSERT INTO `setor` VALUES ('5', 'Banco de dados', '2');
INSERT INTO `setor` VALUES ('13', 'Desenvolvimento II', '2');
INSERT INTO `setor` VALUES ('14', 'Desenvolvimento III', '2');

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
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of setorfuncionario
-- ----------------------------
INSERT INTO `setorfuncionario` VALUES ('3', '3', '3');
INSERT INTO `setorfuncionario` VALUES ('29', '3', '8');
INSERT INTO `setorfuncionario` VALUES ('32', '13', '4');
INSERT INTO `setorfuncionario` VALUES ('33', '14', '5');
INSERT INTO `setorfuncionario` VALUES ('58', '5', '4');
INSERT INTO `setorfuncionario` VALUES ('59', '4', '3');
INSERT INTO `setorfuncionario` VALUES ('60', '4', '6');

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ticket
-- ----------------------------
INSERT INTO `ticket` VALUES ('18', '1', '3', '2014-05-03 11:11:09', null, null, null, '1');
INSERT INTO `ticket` VALUES ('19', '3', '1', '2014-05-04 16:12:04', null, null, null, '3');
INSERT INTO `ticket` VALUES ('20', '5', '7', '2014-05-07 19:27:25', null, null, null, '3');

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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ticket_atendimento
-- ----------------------------
INSERT INTO `ticket_atendimento` VALUES ('16', '18', '1', '4', '4', '2014-05-03 11:11:09', '1');
INSERT INTO `ticket_atendimento` VALUES ('23', '18', '2', '1', null, '2014-05-03 16:00:36', '1');
INSERT INTO `ticket_atendimento` VALUES ('24', '19', '1', '1', null, '2014-05-04 16:12:04', '1');
INSERT INTO `ticket_atendimento` VALUES ('25', '20', '1', '4', '8', '2014-05-07 19:27:25', '1');

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
INSERT INTO `ticket_categoria` VALUES ('4', 'DB');
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ticket_historico
-- ----------------------------
INSERT INTO `ticket_historico` VALUES ('10', '18', 'Teste BI', '1', '3', '1', '2014-05-03 11:11:09');
INSERT INTO `ticket_historico` VALUES ('13', '18', 'teste', '2', '4', '1', '2014-05-03 15:49:04');
INSERT INTO `ticket_historico` VALUES ('17', '18', 'teste 5', '6', '4', '1', '2014-05-03 16:00:36');
INSERT INTO `ticket_historico` VALUES ('18', '18', 'teste de observação interna', '5', '4', '1', '2014-05-03 16:18:13');
INSERT INTO `ticket_historico` VALUES ('19', '19', 'TEWDADASDASD', '1', '1', '1', '2014-05-04 16:12:04');
INSERT INTO `ticket_historico` VALUES ('20', '20', 'Nao consegui efetuar o cadastro do leito', '1', '7', '1', '2014-05-07 19:27:25');

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ticket_tipo
-- ----------------------------
INSERT INTO `ticket_tipo` VALUES ('1', 'Outros BI', '1', '1', '12', '1');
INSERT INTO `ticket_tipo` VALUES ('2', 'Outros SO', '2', '3', '12', '1');
INSERT INTO `ticket_tipo` VALUES ('3', 'Outros CORP', '3', '3', '12', '1');
INSERT INTO `ticket_tipo` VALUES ('4', 'Outros DB', '4', '3', '12', '1');
INSERT INTO `ticket_tipo` VALUES ('5', 'Cadastro de leito', '14', '3', '12', '1');
INSERT INTO `ticket_tipo` VALUES ('6', 'Edição do leito', '14', '3', '6', '1');
INSERT INTO `ticket_tipo` VALUES ('7', 'Alteração do status do leito', '14', '1', '6', '1');
INSERT INTO `ticket_tipo` VALUES ('8', 'Cadastro de quarto', '13', '3', '12', '1');
INSERT INTO `ticket_tipo` VALUES ('9', 'Edição do quarto', '13', '1', '12', '1');
INSERT INTO `ticket_tipo` VALUES ('10', 'Consulta de paciente', '15', '1', '6', '1');
INSERT INTO `ticket_tipo` VALUES ('11', 'Ocupação do paciente', '15', '1', '6', '1');
INSERT INTO `ticket_tipo` VALUES ('12', 'Cadastro de categoria', '17', '3', '12', '1');
INSERT INTO `ticket_tipo` VALUES ('13', 'Cadastro de setor', '16', '3', '12', '1');
INSERT INTO `ticket_tipo` VALUES ('14', 'Edição de setor', '16', '1', '6', '1');
INSERT INTO `ticket_tipo` VALUES ('15', 'Falha ao logar', '12', '1', '6', '1');
INSERT INTO `ticket_tipo` VALUES ('16', 'Cadastro de usuário', '12', '3', '12', '1');
INSERT INTO `ticket_tipo` VALUES ('17', 'Deslogar usuário', '12', '3', '12', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ticket_tiponivel
-- ----------------------------
INSERT INTO `ticket_tiponivel` VALUES ('1', '1', '1', '5');
INSERT INTO `ticket_tiponivel` VALUES ('2', '2', '1', '3');
INSERT INTO `ticket_tiponivel` VALUES ('3', '3', '1', '3');
INSERT INTO `ticket_tiponivel` VALUES ('4', '4', '1', '3');
INSERT INTO `ticket_tiponivel` VALUES ('5', '1', '2', '4');
INSERT INTO `ticket_tiponivel` VALUES ('17', '5', '1', '3');
INSERT INTO `ticket_tiponivel` VALUES ('18', '6', '1', '3');
INSERT INTO `ticket_tiponivel` VALUES ('19', '7', '1', '3');
INSERT INTO `ticket_tiponivel` VALUES ('20', '8', '1', '3');
INSERT INTO `ticket_tiponivel` VALUES ('21', '9', '1', '3');
INSERT INTO `ticket_tiponivel` VALUES ('22', '10', '1', '3');
INSERT INTO `ticket_tiponivel` VALUES ('23', '11', '1', '3');
INSERT INTO `ticket_tiponivel` VALUES ('24', '12', '1', '3');
INSERT INTO `ticket_tiponivel` VALUES ('25', '13', '1', '3');
INSERT INTO `ticket_tiponivel` VALUES ('26', '14', '1', '3');
INSERT INTO `ticket_tiponivel` VALUES ('27', '15', '1', '3');
INSERT INTO `ticket_tiponivel` VALUES ('28', '16', '1', '3');
INSERT INTO `ticket_tiponivel` VALUES ('29', '17', '1', '3');

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
