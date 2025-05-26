create table logError(
	id int primary key auto_increment not null,
    userId int,
    dateError datetime,
    description varchar(1000),
    CONSTRAINT FK_logUserId FOREIGN KEY (userId)
    REFERENCES usuario(id)
);


CREATE TABLE operation_source(
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  label varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  cliente varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO user_access set userType = 'adm', functionName = 'register_operation_source';

ALTER TABLE operation_type ADD COLUMN operation_source_id int,
ADD CONSTRAINT otfk FOREIGN KEY (operation_source_id) REFERENCES operation_source(id);



create table system_error_info(
	id int not null auto_increment primary key,
    user_id int not null,
    contact_email varchar(100) not null,
    created_date datetime not null,
    attachment_name varchar(100),
    description varchar(200) not null,
    CONSTRAINT uifk FOREIGN KEY (user_id) REFERENCES usuario(id)
);

alter table system_error_info add COLUMN status varchar(50);
alter table system_error_info add COLUMN resolution varchar(100);


ALTER TABLE janela ADD COLUMN operation_type_id int null ;

ALTER TABLE janela
ADD CONSTRAINT otifk FOREIGN KEY (operation_type_id) REFERENCES operation_type(id);


DELIMITER $$
CREATE TRIGGER `updateJanelaOperation` BEFORE INSERT ON `janela` FOR EACH ROW BEGIN
    DECLARE operation_name varchar(50);
    SET operation_name = (SELECT name FROM operation_type WHERE Id = NEW.operation_type_id LIMIT 1);
    
    SET NEW.operacao = operation_name;
END
$$
DELIMITER ;



DELIMITER $$
CREATE TRIGGER `updateJanelaOperationUp` BEFORE UPDATE ON `janela` FOR EACH ROW BEGIN
    DECLARE operation_name varchar(50);
    SET operation_name = (SELECT name FROM operation_type WHERE Id = NEW.operation_type_id LIMIT 1);
    
    SET NEW.operacao = operation_name;
END
$$
DELIMITER ;


CREATE TABLE employee(
  id int(11) primary key NOT NULL AUTO_INCREMENT,
  name varchar(50) NOT NULL,
  position varchar(20) NOT NULL,
  created_date datetime not null,
  created_by int(11) not null,
  last_modified_date datetime DEFAULT NULL,
  last_modified_by int(11) DEFAULT NULL,
  CONSTRAINT cbefk FOREIGN KEY (created_by) REFERENCES usuario(id),
  CONSTRAINT lmbefk FOREIGN KEY (last_modified_by) REFERENCES usuario(id)
);

INSERT INTO user_access set userType = 'adm', functionName = 'register_employee';

ALTER TABLE janela ADD COLUMN operator varchar(50) default null;
ALTER TABLE janela ADD COLUMN checker varchar(50) default null;

ALTER TABLE janela ADD COLUMN created_date datetime not null;
ALTER TABLE janela ADD COLUMN last_modified_date datetime default null;
ALTER TABLE janela ADD COLUMN last_modified_by varchar(100) default null;

drop table janela_log;

CREATE TABLE `janela_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT  PRIMARY KEY,
  `status` varchar(50) DEFAULT NULL,
  `tipoVeiculo` varchar(50) DEFAULT NULL,
  `placa_carreta` varchar(50) DEFAULT NULL,
  `operacao` varchar(50) DEFAULT NULL,
  `nf` varchar(50) DEFAULT NULL,
  `doca` varchar(50) DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `dataInclusao` date DEFAULT NULL,
  `inicio_operacao` datetime DEFAULT NULL,
  `horaChegada` datetime DEFAULT NULL,
  `fim_operacao` datetime DEFAULT NULL,
  `transportadora` varchar(100) DEFAULT NULL,
  `placa_cavalo` varchar(50) DEFAULT NULL,
  `peso` varchar(10) DEFAULT NULL,
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
  `operator` varchar(14) DEFAULT NULL,
  `checker` varchar(14) DEFAULT NULL,
  `action` varchar(20) NOT NULL,
  `user_action` varchar(100) NOT NULL,
  `date_time_action` datetime not null
);

DROP TRIGGER log_janela_update;
DROP TRIGGER log_janela_delete;

DELIMITER $$
CREATE TRIGGER `log_janela_update` AFTER UPDATE ON `janela` FOR EACH ROW BEGIN
    INSERT INTO janela_log (status,tipoVeiculo,placa_carreta,operacao,nf,doca,usuario,dataInclusao,inicio_operacao,horaChegada,fim_operacao,transportadora,placa_cavalo,peso,data_agendamento,saida,separacao,shipment_id,do_s,cidade,carga_qtde,observacao,dados_gerais,cliente,nome_motorista,placa_carreta2,documento_motorista,operator,checker,action,user_action,date_time_action) 
    VALUES(OLD.status,OLD.tipoVeiculo,OLD.placa_carreta,OLD.operacao,OLD.nf,OLD.doca,OLD.usuario,OLD.dataInclusao,OLD.inicio_operacao,OLD.horaChegada,OLD.fim_operacao,OLD.transportadora,OLD.placa_cavalo,OLD.peso,OLD.data_agendamento,OLD.saida,OLD.separacao,OLD.shipment_id,OLD.do_s,OLD.cidade,OLD.carga_qtde,OLD.observacao,OLD.dados_gerais,OLD.cliente,OLD.nome_motorista,OLD.placa_carreta2,OLD.documento_motorista,OLD.operator,OLD.checker,"update",NEW.last_modified_by,now()); 
END
$$
DELIMITER ;

ALTER TABLE `attachment` ADD COLUMN created_date DATETIME DEFAULT NULL;
ALTER TABLE `attachment` ADD COLUMN created_by VARCHAR(100) DEFAULT NULL;
ALTER TABLE `attachment` ADD COLUMN type VARCHAR(30) DEFAULT NULL;

CREATE TABLE `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `message` varchar(300) DEFAULT NULL,
  `duration` int DEFAULT NULL,
  `created_date` date DEFAULT NULL
);

CREATE TABLE attachment_log(
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `path` varchar(100) DEFAULT NULL,
  `shipmentId` VARCHAR(15) DEFAULT NULL,
  `created_date` DATETIME DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `action` varchar(20) NOT NULL,
  `user_action` varchar(100) NOT NULL,
  `date_time_action` datetime not null
);

DELIMITER $$
CREATE TRIGGER `log_attachment_delete` AFTER DELETE ON `attachment` FOR EACH ROW BEGIN
    INSERT INTO attachment_log (path,created_date,type,action,date_time_action) 
    VALUES(OLD.path,OLD.created_date,OLD.type,"delete",now()); 
END
$$
DELIMITER ;


ALTER TABLE janela ADD COLUMN attatchment_picking_status VARCHAR(20) DEFAULT NULL;
ALTER TABLE janela ADD COLUMN attatchment_certificate_status VARCHAR(20) DEFAULT NULL;
ALTER TABLE janela ADD COLUMN attatchment_invoice_status VARCHAR(20) DEFAULT NULL;
ALTER TABLE janela ADD COLUMN attatchment_boarding_status VARCHAR(20) DEFAULT NULL;


ALTER TABLE janela_log ADD COLUMN attatchment_picking_status VARCHAR(20) DEFAULT NULL;
ALTER TABLE janela_log ADD COLUMN attatchment_certificate_status VARCHAR(20) DEFAULT NULL;
ALTER TABLE janela_log ADD COLUMN attatchment_invoice_status VARCHAR(20) DEFAULT NULL;
ALTER TABLE janela_log ADD COLUMN attatchment_boarding_status VARCHAR(20) DEFAULT NULL;
ALTER TABLE janela_log ADD COLUMN schedule_id INT(11) DEFAULT NULL;

DROP TRIGGER log_janela_update;

DELIMITER $$
CREATE TRIGGER `log_janela_update` AFTER UPDATE ON `janela` FOR EACH ROW BEGIN
    INSERT INTO janela_log (schedule_id,status,tipoVeiculo,placa_carreta,operacao,nf,doca,usuario,dataInclusao,inicio_operacao,horaChegada,fim_operacao,transportadora,placa_cavalo,peso,data_agendamento,saida,separacao,shipment_id,do_s,cidade,carga_qtde,observacao,dados_gerais,cliente,nome_motorista,placa_carreta2,documento_motorista,operator,checker,attatchment_picking_status,attatchment_certificate_status,attatchment_invoice_status,attatchment_boarding_status,action,user_action,date_time_action) 
    VALUES(OLD.id,NEW.status,NEW.tipoVeiculo,NEW.placa_carreta,NEW.operacao,NEW.nf,NEW.doca,NEW.usuario,NEW.dataInclusao,NEW.inicio_operacao,NEW.horaChegada,NEW.fim_operacao,NEW.transportadora,NEW.placa_cavalo,NEW.peso,NEW.data_agendamento,NEW.saida,NEW.separacao,NEW.shipment_id,NEW.do_s,NEW.cidade,NEW.carga_qtde,NEW.observacao,NEW.dados_gerais,NEW.cliente,NEW.nome_motorista,NEW.placa_carreta2,NEW.documento_motorista,NEW.operator,NEW.checker,NEW.attatchment_picking_status,NEW.attatchment_certificate_status,NEW.attatchment_invoice_status,NEW.attatchment_boarding_status,"update",NEW.last_modified_by,now()); 
END
$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER `log_janela_insert` AFTER INSERT ON `janela` FOR EACH ROW BEGIN
    INSERT INTO janela_log (schedule_id,status,tipoVeiculo,placa_carreta,operacao,nf,doca,usuario,dataInclusao,inicio_operacao,horaChegada,fim_operacao,transportadora,placa_cavalo,peso,data_agendamento,saida,separacao,shipment_id,do_s,cidade,carga_qtde,observacao,dados_gerais,cliente,nome_motorista,placa_carreta2,documento_motorista,operator,checker,attatchment_picking_status,attatchment_certificate_status,attatchment_invoice_status,attatchment_boarding_status,action,user_action,date_time_action) 
    VALUES(NEW.id,NEW.status,NEW.tipoVeiculo,NEW.placa_carreta,NEW.operacao,NEW.nf,NEW.doca,NEW.usuario,NEW.dataInclusao,NEW.inicio_operacao,NEW.horaChegada,NEW.fim_operacao,NEW.transportadora,NEW.placa_cavalo,NEW.peso,NEW.data_agendamento,NEW.saida,NEW.separacao,NEW.shipment_id,NEW.do_s,NEW.cidade,NEW.carga_qtde,NEW.observacao,NEW.dados_gerais,NEW.cliente,NEW.nome_motorista,NEW.placa_carreta2,NEW.documento_motorista,NEW.operator,NEW.checker,NEW.attatchment_picking_status,NEW.attatchment_certificate_status,NEW.attatchment_invoice_status,NEW.attatchment_boarding_status,"save",NEW.usuario,now()); 
END
$$
DELIMITER ;


ALTER TABLE janela ADD COLUMN attatchment_other_status VARCHAR(20) DEFAULT NULL;
ALTER TABLE janela_log ADD COLUMN attatchment_other_status VARCHAR(20) DEFAULT NULL;

DROP TRIGGER log_janela_update;
DROP TRIGGER log_janela_insert;

DELIMITER $$
CREATE TRIGGER `log_janela_update` AFTER UPDATE ON `janela` FOR EACH ROW BEGIN
    INSERT INTO janela_log (schedule_id,status,tipoVeiculo,placa_carreta,operacao,nf,doca,usuario,dataInclusao,inicio_operacao,horaChegada,fim_operacao,transportadora,placa_cavalo,peso,data_agendamento,saida,separacao,shipment_id,do_s,cidade,carga_qtde,observacao,dados_gerais,cliente,nome_motorista,placa_carreta2,documento_motorista,operator,checker,attatchment_picking_status,attatchment_certificate_status,attatchment_invoice_status,attatchment_boarding_status,attatchment_other_status,action,user_action,date_time_action) 
    VALUES(OLD.id,NEW.status,NEW.tipoVeiculo,NEW.placa_carreta,NEW.operacao,NEW.nf,NEW.doca,NEW.usuario,NEW.dataInclusao,NEW.inicio_operacao,NEW.horaChegada,NEW.fim_operacao,NEW.transportadora,NEW.placa_cavalo,NEW.peso,NEW.data_agendamento,NEW.saida,NEW.separacao,NEW.shipment_id,NEW.do_s,NEW.cidade,NEW.carga_qtde,NEW.observacao,NEW.dados_gerais,NEW.cliente,NEW.nome_motorista,NEW.placa_carreta2,NEW.documento_motorista,NEW.operator,NEW.checker,NEW.attatchment_picking_status,NEW.attatchment_certificate_status,NEW.attatchment_invoice_status,NEW.attatchment_boarding_status,NEW.attatchment_other_status,"update",NEW.last_modified_by,now()); 
END
$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER `log_janela_insert` AFTER INSERT ON `janela` FOR EACH ROW BEGIN
    INSERT INTO janela_log (schedule_id,status,tipoVeiculo,placa_carreta,operacao,nf,doca,usuario,dataInclusao,inicio_operacao,horaChegada,fim_operacao,transportadora,placa_cavalo,peso,data_agendamento,saida,separacao,shipment_id,do_s,cidade,carga_qtde,observacao,dados_gerais,cliente,nome_motorista,placa_carreta2,documento_motorista,operator,checker,attatchment_picking_status,attatchment_certificate_status,attatchment_invoice_status,attatchment_boarding_status,attatchment_other_status,action,user_action,date_time_action) 
    VALUES(NEW.id,NEW.status,NEW.tipoVeiculo,NEW.placa_carreta,NEW.operacao,NEW.nf,NEW.doca,NEW.usuario,NEW.dataInclusao,NEW.inicio_operacao,NEW.horaChegada,NEW.fim_operacao,NEW.transportadora,NEW.placa_cavalo,NEW.peso,NEW.data_agendamento,NEW.saida,NEW.separacao,NEW.shipment_id,NEW.do_s,NEW.cidade,NEW.carga_qtde,NEW.observacao,NEW.dados_gerais,NEW.cliente,NEW.nome_motorista,NEW.placa_carreta2,NEW.documento_motorista,NEW.operator,NEW.checker,NEW.attatchment_picking_status,NEW.attatchment_certificate_status,NEW.attatchment_invoice_status,NEW.attatchment_boarding_status,NEW.attatchment_other_status,"save",NEW.usuario,now()); 
END
$$
DELIMITER ;

INSERT INTO `user_access` (`userType`, `functionName`) VALUES ('adm', 'tracking');

#################################################


DELIMITER $$
CREATE TRIGGER `log_attachment_insert` AFTER INSERT ON `attachment` FOR EACH ROW BEGIN
    SET @shipmentid = (SELECT shipment_id FROM janela WHERE Id = NEW.scheduleId LIMIT 1);

    INSERT INTO attachment_log (path,created_date,type,shipmentId,user_action,action,date_time_action) 
    VALUES(NEW.path,NEW.created_date,NEW.type,@shipmentid,NEW.created_by,"insert",created_date); 
END
$$
DELIMITER ;









