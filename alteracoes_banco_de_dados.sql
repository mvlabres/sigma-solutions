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


/*=====================================================*/


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

/*=====================================================*/