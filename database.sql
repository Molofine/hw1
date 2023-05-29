CREATE DATABASE db;
USE db;

CREATE TABLE users (
    id integer primary key auto_increment,
    username varchar(20) not null unique,
    email varchar(255) not null unique,
    password varchar(255) not null,
    name varchar(255),
    surname varchar(255)
) Engine = InnoDB;

CREATE TABLE img (
    id integer primary key auto_increment,
    userid integer not null,
    imgid varchar(255) not null,
    info json,

    FOREIGN KEY (userid) REFERENCES users(id)
) Engine = InnoDB;

CREATE TABLE uploads (
    id integer primary key auto_increment,
    username varchar(20) not null,
    destination varchar(255) not null unique,
    descrip varchar(255) not null,
    alt_desc varchar(255),
    created varchar(255) not null
) Engine = InnoDB;
