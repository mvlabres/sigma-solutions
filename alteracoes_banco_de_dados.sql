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


#################################################

ALTER TABLE janela ADD COLUMN operator varchar(50) default null;
ALTER TABLE janela ADD COLUMN checker varchar(50) default null;
