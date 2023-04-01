use sigmascheduling;

create table systems(
	id int auto_increment primary key not null,
    name varchar(50) not null,
    description varchar(50) not null,
    systemUrl varchar(100) not null,
    iconPath varchar(50) not null
);

create table userSystems(
	id int auto_increment primary key not null,
    userId int not null,
    systemsId int not null,
    CONSTRAINT FK_userId FOREIGN KEY (userId) REFERENCES usuario(id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT FK_systemsId FOREIGN KEY (systemsId) REFERENCES systems(id) ON DELETE CASCADE ON UPDATE CASCADE
);

insert into systems (name, description, systemUrl, iconPath) values ('klabinSchedules', 'Klabin Agendamentos', 'klabin-agendamentos/pages/', 'images/icone-agendamento.png');

INSERT INTO `userSystems` (`userId`, `systemsID`) VALUES
(7, 1),
(35,1),
(38,1),
(40,1),
(41,1),
(42,1),
(46,1),
(49,1),
(50,1),
(52,1),
(53,1),
(54,1),
(58,1),
(63,1),
(64,1),
(65,1),
(68,1),
(69,1),
(70,1),
(71,1),
(72,1),
(73,1),
(74,1),
(76,1),
(77,1),
(78,1),
(79,1),
(81,1),
(82,1),
(84,1),
(86,1),
(89,1),
(90,1),
(91,1),
(92,1),
(93,1),
(94,1),
(96,1),
(97,1),
(98,1),
(99,1),
(100,1),
(101,1),
(102,1),
(103,1),
(104,1),
(105,1),
(106,1),
(107,1),
(108,1),
(109,1),
(110,1),
(111,1),
(112,1),
(113,1),
(114,1),
(116,1),
(117,1),
(118,1),
(119,1),
(120,1);

// até aqui já esta aplicado em produção

alter table customer add column description varchar(50);

insert into customer (name, description) values ('tetrapak', 'TetraPak');
insert into customer (name, description) values ('klabin', 'Klabin');

create table operation_type(
    id int primary key auto_increment not null,
    name varchar(50) not null,
    label varchar(50) not null
);

alter table transportadora add column cliente_origem varchar(50);

update transportadora set cliente_origem = 'klabin';


