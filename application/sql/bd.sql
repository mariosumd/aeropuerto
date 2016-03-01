drop table if exists usuarios cascade;

create table usuarios (
  id_usuario bigserial   constraint pk_usuarios primary key,
  nombre     varchar(20) not null constraint uq_usuario_unico unique,
  password   char(32)    not null
);

drop table if exists aeropuertos cascade;

create table aeropuertos (
  id_aero  char(3)     constraint pk_aeropuertos primary key,
  den_aero varchar(40) not null
);

drop table if exists companias cascade;

create table companias (
  id_comp  bigserial   constraint pk_companias primary key,
  den_comp varchar(30) not null
);

drop table if exists vuelos cascade;

create table vuelos (
  id_vuelo char(6)      constraint pk_vuelos primary key,
  id_orig  char(3)      not null constraint fk_vuelos_aeropuerto_origen
                        references aeropuertos (id_aero)
                        on delete no action on update cascade,
  id_dest  char(3)      not null constraint fk_vuelos_aeropuerto_destino
                        references aeropuertos (id_aero)
                        on delete no action on update cascade,
  id_comp  bigint       not null constraint fk_vuelos_companias
                        references companias (id_comp)
                        on delete no action on update cascade,
  salida   timestamp    not null,
  llegada  timestamp    not null,
  plazas   numeric(3)   not null,
  precio   numeric(6,2) not null
);

drop table if exists reservas cascade;

create table reservas (
  id_reserva bigserial  constraint pk_reservas primary key,
  id_usuario bigint     not null constraint fk_reservas_usuarios
                        references usuarios (id_usuario)
                        on delete no action on update cascade,
  id_vuelo   char(6)    not null constraint fk_reservas_vuelos
                        references vuelos (id_vuelo)
                        on delete no action on update cascade,
  asiento    numeric(3) not null,
  fecha_hora timestamp  not null,
  constraint uq_asiento_unico unique (id_vuelo, asiento)
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
    select v.id_vuelo as vuelo, to_char(v.salida, 'DD/MM/YYY HH:MI') as salida,
            to_char(v.llegada, 'DD/MM/YYY HH:MI') as llegada,
            o.den_aero as origen, d.den_aero as destino, c.den_comp as compania
      from vuelos v join aeropuertos o on (id_orig = o.id_aero)
                    join aeropuertos d on (id_dest = d.id_aero)
                    join companias   c on (v.id_comp = c.id_comp);

drop view if exists v_vuelos_disponibles;

create view v_vuelos_disponibles as
    select v.id_vuelo as vuelo, to_char(v.salida, 'DD/MM/YYY HH:MI') as salida,
            to_char(v.llegada, 'DD/MM/YYY HH:MI') as llegada,
            o.den_aero as origen, d.den_aero as destino, c.den_comp as compania,
            (v.plazas - coalesce((select count(*) from reservas where id_vuelo = v.id_vuelo group by id_vuelo), 0)) as plazas
      from vuelos v join aeropuertos o on (id_orig = o.id_aero)
                    join aeropuertos d on (id_dest = d.id_aero)
                    join companias   c on (v.id_comp = c.id_comp)
     where v.plazas > coalesce((select count(*) from reservas where id_vuelo = v.id_vuelo group by id_vuelo), 0);

insert into usuarios (nombre, password)
    values ('juan', md5('juan')),
           ('maria', md5('maria'));

insert into aeropuertos (id_aero, den_aero)
    values ('XER', 'Jerez'),
           ('MAD', 'Madrid'),
           ('BAR', 'Barcelona');

insert into companias (den_comp)
    values ('Ryanair'),
           ('Iberia'),
           ('AirBerlin');

insert into vuelos (id_vuelo, id_orig, id_dest, id_comp, plazas, salida, llegada, precio)
    values ('VA0123', 'XER', 'MAD', 1, 1, '2016-03-05 09:30'::timestamp, '2016-03-05 10:00'::timestamp, 50.00),
           ('CZ7894', 'XER', 'BAR', 2, 2, '2016-03-05 09:00'::timestamp, '2016-03-05 10:30'::timestamp, 55.00),
           ('QW9631', 'MAD', 'BAR', 3, 1, '2016-03-05 10:00'::timestamp, '2016-03-05 11:00'::timestamp, 60.00);

insert into reservas (id_vuelo, id_usuario, asiento, fecha_hora)
    values ('VA0123', 1, 1, current_timestamp);
