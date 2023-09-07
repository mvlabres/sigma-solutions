create table logError(
	id int primary key auto_increment not null,
    userId int,
    dateError datetime,
    description varchar(1000),
    CONSTRAINT FK_logUserId FOREIGN KEY (userId)
    REFERENCES usuario(id)
);