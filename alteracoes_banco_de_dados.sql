create table logError(
	id int primary key auto_increment not null,
    userId int,
    dateError datetime,
    description varchar(1000),
    CONSTRAINT FK_logUserId FOREIGN KEY (userId)
    REFERENCES usuario(id)
);


/*=====================================================*/

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