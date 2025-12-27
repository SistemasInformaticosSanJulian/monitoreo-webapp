CREATE TABLE oficina
(
    id          integer primary key autoincrement,
    nombre      varchar(50)  not null,
    direccion varchar(255) not null,
    celular varchar(15) not null,
    soft_delete boolean      not null default 0,
    unique (nombre)
);

CREATE TABLE operador
(
    id          integer primary key autoincrement,
    nombre      varchar(50)  not null,
    contrasenia varchar(255) not null,
    rol        varchar(20)  not null default 'operador',
    oficina_id int not null,
    soft_delete boolean      not null default 0,
    created_at  timestamp             default CURRENT_TIMESTAMP,
    updated_at  timestamp,
    unique (nombre),
    foreign key (oficina_id) references oficina (id)
);

CREATE TABLE usuario
(
    id          integer primary key autoincrement,
    nombre      varchar(50)  not null,
    contrasenia varchar(255) not null,
    soft_delete boolean      not null default 0,
    created_at  timestamp             default CURRENT_TIMESTAMP,
    updated_at  timestamp,
    unique (nombre)
);

create table cliente
(
    id                 integer primary key autoincrement,
    nombres            varchar(50) not null,
    apellidos          varchar(50) not null,
    direccion          varchar(50),
    correo_electronico varchar(70) not null,
    celular            varchar(15) not null,
    usuario_id         int         not null,
    foreign key (usuario_id) references usuario (id)
);

create table conductor
(
    id               integer primary key autoincrement,
    nombres          varchar(35) not null,
    apellidos          varchar(35) not null,
    carnet           varchar(20) not null,
    fecha_nacimiento date        not null,
    celular          varchar(15) not null,
    correo           varchar(40),
    direccion        varchar(75),
    unique (carnet)
);

create table movil
(
    id                integer primary key autoincrement,
    interno           varchar(3)  not null,
    placa             varchar(10) not null,
    cantidad_asientos int         not null,
    conductor_id      integer     not null,
    unique (interno),
    foreign key (conductor_id) references conductor (id)
);

create table viaje
(
    id                integer primary key autoincrement,
    codigo            varchar(25) not null,
    origen            varchar(50) not null,
    destino           varchar(50) not null,
    fechahora_salida  datetime    not null,
    fechahora_llegada datetime,
    encomienda        varchar(35) not null,
    direccion_entrega  varchar(50) not null,
    emisor            varchar(50) not null,
    receptor          varchar(50) not null,
    estado            varchar(15) not null,
    movil_id          integer     not null,
    soft_delete       boolean     not null default 0,
    foreign key (movil_id) references movil (id)
);

create table monitoreo
(
    id         integer primary key autoincrement,
    latitud    real        not null,
    longitud   real        not null,
    codigo     varchar(25) not null,
    viaje_id   int         not null,
    updated_at timestamp default CURRENT_TIMESTAMP,
    unique (viaje_id)
);
