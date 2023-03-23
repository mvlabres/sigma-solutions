use sigmascheduling;

create table systems(
	id int auto_increment primary key not null,
    name varchar(50) not null,
    description varchar(50) not null
)

create table userSystems(
	id int auto_increment primary key not null,
    userId int not null,
    systemsId int not null,
    CONSTRAINT FK_userId FOREIGN KEY (userId) REFERENCES usuario(id),
	CONSTRAINT FK_systemsId FOREIGN KEY (systemsId) REFERENCES systems(id)
)

insert into systems (name, description) values ('schedules', 'Agendamentos')