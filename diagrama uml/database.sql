

CREATE DATABASE IF NOT EXISTS  laravel_master;
USE laravel_master;

CREATE TABLE users(

    id                  int(255) auto_increment not null,
    role                varchar(20),
    name                varchar(100),
    surname             varchar(200),
    nick                varchar(100),
    email               varchar(255),
    password            varchar(255),
    image               varchar(255),
    created_at          datetime,
    updated_at          datetime,
    remember_token      varchar(255),

    CONSTRAINT pk_users PRIMARY KEY (id)

)ENGINE=InnoDb;

INSERT INTO users VALUES(null, 'user', 'luis', 'pormachi', 'luis22', 'luisangelpormachi@gmail.com', '123456', null, curtime(), curtime(), null);
INSERT INTO users VALUES(null, 'user', 'hernan', 'pormachi', 'hernan11', 'hernan@gmail.com', '123456', null, curtime(), curtime(), null);
INSERT INTO users VALUES(null, 'user', 'jimmy', 'pormachi', 'jimmyBen', 'jimmy@gmail.com', '123456', null, curtime(), curtime(), null);
INSERT INTO users VALUES(null, 'user', 'victor', 'robles', 'victorWeb', 'victorroblesweb@gmail.com', '123456', null, curtime(), curtime(), null);



CREATE TABLE IF NOT EXISTS images(

    id                  int(255) auto_increment not null,
    user_id             int(255),
    image_path          varchar(255),
    description         text,
    created_at          datetime,
    updated_at          datetime,

    CONSTRAINT pk_images PRIMARY KEY (id),
    CONSTRAINT fk_images_users FOREIGN KEY (user_id) REFERENCES users(id)

)ENGINE=InnoDb;

INSERT INTO images VALUES(null, 1, 'test.jpg', 'descripcion de prueba 1', curtime(), curtime());
INSERT INTO images VALUES(null, 1, 'playa.jpg', 'descripcion de prueba 2', curtime(), curtime());
INSERT INTO images VALUES(null, 1, 'arena.jpg', 'descripcion de prueba 3', curtime(), curtime());
INSERT INTO images VALUES(null, 3, 'familia.jpg', 'descripcion de prueba 4', curtime(), curtime());

CREATE TABLE IF NOT EXISTS comments(

    id                  int(255) auto_increment not null,
    user_id             int(255),
    image_id            int(255),
    content             text,
    created_at          datetime,
    updated_at          datetime,

    CONSTRAINT pk_comments PRIMARY KEY (id),
    CONSTRAINT fk_comments_users FOREIGN KEY (user_id) REFERENCES users(id),
    CONSTRAINT fk_comments_images FOREIGN KEY (image_id) REFERENCES images(id)

)ENGINE=InnoDb;


INSERT INTO comments VALUES(null, 1, 4, 'Buena foro de familia', curtime(), curtime());
INSERT INTO comments VALUES(null, 2, 2, 'Buena foro de Playa', curtime(), curtime());
INSERT INTO comments VALUES(null, 2, 1, 'Que bueno', curtime(), curtime());
INSERT INTO comments VALUES(null, 3, 3, 'Buena foro de familia', curtime(), curtime());

CREATE TABLE IF NOT EXISTS likes(

    id                  int(255) auto_increment not null,
    user_id             int(255),
    image_id            int(255),
    created_at          datetime,
    updated_at          datetime,

    CONSTRAINT pk_likes PRIMARY KEY (id),
    CONSTRAINT fk_likes_users FOREIGN KEY (user_id) REFERENCES users(id),
    CONSTRAINT fk_likes_images FOREIGN KEY (image_id) REFERENCES images(id)

)ENGINE=InnoDb;


INSERT INTO likes VALUES(null, 1, 4, curtime(), curtime());
INSERT INTO likes VALUES(null, 2, 4, curtime(), curtime());
INSERT INTO likes VALUES(null, 3, 1, curtime(), curtime());
INSERT INTO likes VALUES(null, 3, 2, curtime(), curtime());
INSERT INTO likes VALUES(null, 2, 1, curtime(), curtime());