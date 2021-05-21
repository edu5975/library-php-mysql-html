create database biblioteca;

use biblioteca;

create table autor(id integer auto_increment primary key,
        nombre varchar(40),
        apellidos varchar(40));

create table categoria(id integer auto_increment primary key,
        nombre varchar(30));

create table editorial(id integer auto_increment primary key,
        nombre varchar(30));

create table usuario(id integer auto_increment primary key,
        usuario varchar(20),
        nombre varchar(40),
        apellido varchar(40),
        email varchar(50),
        nacimiento date,
        contrasena varchar(42),
        tipoUsuario smallint,
        foto varchar(100),
        vencimieto date);

create table libro(id integer auto_increment primary key,
        archivo varchar(100),
        imagen varchar(100),
        idioma varchar(20),
        titulo varchar(100),
        fechaPublicacion date,
        contenido text,
        idEditorial integer,
        constraint foreign key (id) references editorial(id));

create table autores(idLibro integer,
        idAutor integer,
        constraint foreign key (idLibro) references libro(id),
        constraint foreign key (idAutor) references autor(id),
        constraint primary key (idLibro,idAutor));

create table pertenece(idLibro integer,
        idCategoria integer,
        constraint foreign key (idLibro) references libro(id),
        constraint foreign key (idCategoria) references categoria(id),
        constraint primary key (idLibro,idCategoria));

create table prestamo(idLibro integer,
        idUsuario integer,
        fechaPrestamo date,
        fechaEntrega date,
        constraint foreign key (idLibro) references libro(id),
        constraint foreign key (idUsuario) references usuario(id),
        constraint primary key (idLibro,idUsuario,fechaPrestamo));

