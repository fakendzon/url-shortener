create table if not exists urls (
    id integer not null auto_increment,
    url varchar(255) UNIQUE not null,
    primary key (id)
    )
    ENGINE=InnoDB;

create table if not exists short_urls (
    id integer not null auto_increment,
    id_url integer not null,
    short_url varbinary(6) UNIQUE not null,
    primary key (id)
    )
    ENGINE=InnoDB;

