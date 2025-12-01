create table usuarios_db(
    id_usu int(3) PRIMARY KEY AUTO_INCREMENT,
    user varchar(8) NOT NULL UNIQUE,
    pass varchar(64) NOT NULL,
    nom varchar(20) NOT NULL,
    apat varchar(20) NOT NULL,
    amat varchar(20) default"-",
    email varchar(40)NOT NULL UNIQUE,
    status int(1) NOT NULL default 0
);