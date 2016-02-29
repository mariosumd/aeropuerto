drop table if exists usuarios cascade;

create table usuarios(
    id          bigserial    constraint pk_usuarios primary key,
    nombre      varchar(50)  not null,
    email       varchar(100) not null,
    password    char(60)     not null,
    dni         char(9)      not null constraint uq_dni_ususarios unique,
    constraint ck_dni_length check(char_length(DNI) = 9)
);

drop table if exists aeropuertos cascade;

create table aeropuertos(
    id      bigserial constraint pk_aeropuertos primary key,
    nombre  char(3) not null
);

drop table if exists companyias cascade;

create table companyias(
    id      bigserial constraint pk_companyias primary key,
    nombre  varchar(50) not null
);

drop table if exists vuelos cascade;

create table vuelos(
    id           bigserial constraint pk_vuelos primary key,
    nombre       char(6) not null,
    id_origen    bigint constraint fk_origen_aeropuertos  references aeropuertos(id) on delete cascade on update cascade,
    id_destino   bigint constraint fk_destino_aeropuertos references aeropuertos(id) on delete cascade on update cascade,
    id_companyia bigint constraint fk_vuelos_companyias   references companyias(id)  on delete cascade on update cascade,
    salida       timestamp not null default current_timestamp,
    plazas       numeric(3) not null
);

drop table if exists reservas cascade;

create table reservas(
    id          bigserial constraint pk_reservas primary key,
    id_vuelo    bigint    constraint fk_reservas_vuelos   references vuelos(id) on delete cascade on update cascade,
    id_usuario  bigint    constraint fk_reservas_usuarios references usuarios(id) on delete cascade on update cascade
);

drop table if exists ci_sessions cascade;

create table "ci_sessions" (
    "id" varchar(40) not null primary key,
    "ip_address" varchar(45) not null,
    "timestamp" bigint default 0 not null,
    "data" text default '' not null
);

create index "ci_sessions_timestamp" on "ci_sessions" ("timestamp");

drop view if exists v_vuelos;

create view v_vuelos as
    select v.id, v.nombre as vuelo, to_char(v.salida, 'DD/MM/YYY HH:MI') as salida,
            o.nombre as origen, d.nombre as destino, c.nombre as companyia
      from vuelos v join aeropuertos o on (id_origen    = o.id)
                    join aeropuertos d on (id_destino   = d.id)
                    join companyias  c on (id_companyia = c.id);

drop view if exists v_vuelos_disponibles;

create view v_vuelos_disponibles as
         select v.id, v.nombre as vuelo, to_char(v.salida, 'DD/MM/YYY HH:MI') as salida,
                 o.nombre as origen, d.nombre as destino, c.nombre as companyia,
                 (v.plazas - coalesce((select count(*) from reservas where id_vuelo = v.id group by id_vuelo), 0)) as plazas
           from vuelos v join aeropuertos o on (id_origen    = o.id)
                         join aeropuertos d on (id_destino   = d.id)
                         join companyias  c on (id_companyia = c.id)
          where v.plazas > coalesce((select count(*) from reservas where id_vuelo = v.id group by id_vuelo), 0);

insert into usuarios (nombre, email, password, dni)
    values ('Juan Pérez', 'juan@gmail.com', crypt('juan', gen_salt('bf')), '11111111A'),
           ('María Rodríguez', 'maria@gmail.com', crypt('maria',gen_salt('bf')), '22222222A');

insert into aeropuertos (nombre)
    values ('XER'),
           ('MAD'),
           ('BAR');

insert into companyias (nombre)
    values ('Ryanair'),
           ('Iberia'),
           ('AirBerlin');

insert into vuelos (nombre, id_origen, id_destino, id_companyia, plazas, salida)
    values ('VA0123', 1, 2, 1, 1, '2016-03-02 09:00'::timestamp),
           ('CZ7894', 1, 3, 2, 2, '2016-03-02 09:00'::timestamp),
           ('QW9631', 2, 3, 3, 1, '2016-03-02 09:00'::timestamp);

insert into reservas (id_vuelo, id_usuario)
    values (1, 1);
