 
-- ----------------------------
-- TABLA ACOPIO
-- ----------------------------
    DROP SEQUENCE IF EXISTS acopio.aco_id_seq;
    CREATE SEQUENCE acopio.aco_id_seq INCREMENT 1 START 1;
    DROP TABLE IF EXISTS acopio.acopio;
    CREATE TABLE acopio.acopio (
        "aco_id" integer DEFAULT nextval('acopio.aco_id_seq'::regclass) NOT NULL,
        "aco_id_prov" integer NULL,
        "aco_id_recep" integer NOT NULL,
        "aco_obs" varchar(200) COLLATE "default" NULL,
        "aco_id_tipo_cas" integer NOT NULL,
        "aco_cantidad" decimal NULL,
        "aco_centro" varchar(300) NULL,
        "aco_num_rec" text NULL,
        "aco_cos_un" decimal NULL,
        "aco_cos_total" decimal NULL,
        "aco_numaco" decimal NULL,
        "aco_unidad" integer NOT NULL,
        "aco_peso_neto" decimal NULL,
        "aco_fecha_acop" timestamp(6) NULL,
        "aco_id_proc" integer NOT NULL,
        "aco_id_comunidad" integer NULL,
        "aco_con_hig" integer NULL,
        "aco_tram" time NULL,
        "aco_pago" integer NULL,
        "aco_num_act" integer NULL,
        "aco_fecha_rec" timestamp(6) NULL,
        "aco_id_destino" integer NOT NULL,
        "aco_id_prom" integer NOT NULL,
        "aco_id_linea" integer NOT NULL,
        "aco_id_usr" integer NOT NULL,
        "aco_fecha_reg"  timestamp(6) NULL,
        "aco_estado"  character (1) NOT NULL,
        "aco_lac_tem" numeric(50,0) NULL,
        "aco_lac_aci" numeric(50,0) NULL,
        "aco_lac_ph" numeric(50,0) NULL,
        "aco_lac_sng" numeric(50,0) NULL,
        "aco_lac_den" numeric(50,0) NULL,
        "aco_lac_mgra" numeric(50,0) NULL,
        "aco_lac_palc" integer NULL,
        "aco_lac_pant" integer NULL,
        "aco_lac_asp" integer NULL,
        "aco_lac_col" integer NULL,
        "aco_lac_olo" integer NULL,
        "aco_lac_sab" integer NULL,
        "aco_id_comp" integer NULL,
        "aco_cert" integer NULL,
        "aco_tipo" integer NULL,
        "aco_mat_prim" integer NULL
    );
    ALTER TABLE acopio.acopio ADD CONSTRAINT acopio_pkey PRIMARY KEY (aco_id);
    ALTER TABLE acopio.acopio ADD CONSTRAINT acopio_id_proveedor FOREIGN KEY (aco_id_prov) REFERENCES acopio.proveedor (prov_id) ON DELETE No Action ON UPDATE No Action;
    
    INSERT INTO acopio.acopio VALUES (1,1,1,'xxxxx',1,00.00,'vvvvvv','123',00.00,00.00,00.00,1,00.00,'2018-05-18 16:56:42',1,1,1,'16:56:42',1,1,'2018-05-18 16:56:42',1,1,1,1,'2018-05-18 16:56:42','A',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL, NULL,NULL);
    
-- ----------------------------
-- TABLA COMUNIDAD
-- ----------------------------
    DROP SEQUENCE IF EXISTS acopio.com_id_seq;
    CREATE SEQUENCE acopio.com_id_seq INCREMENT 1 START 1;

    DROP TABLE IF EXISTS acopio.comunidad;
    CREATE TABLE acopio.comunidad (
        com_id integer DEFAULT nextval('acopio.com_id_seq'::regclass) NOT NULL,
        com_nombre varchar(50) NOT NULL,
        com_id_mun integer NOT NULL,
        com_estado character (1) NOT NULL
    );

    ALTER TABLE acopio.comunidad ADD CONSTRAINT comunidad_pkey PRIMARY KEY (com_id);
    ALTER TABLE acopio.proveedor ADD CONSTRAINT proveedor_prov_id_comunidad FOREIGN KEY (prov_id_comunidad) REFERENCES acopio.comunidad (com_id) ON DELETE No Action ON UPDATE No Action;
    ALTER TABLE acopio.acopio ADD CONSTRAINT acopio_aco_id_comunidad FOREIGN KEY (aco_id_comunidad) REFERENCES acopio.comunidad (com_id) ON DELETE No Action ON UPDATE No Action;
    ALTER TABLE acopio.comunidad ADD CONSTRAINT comunidad_com_id_mun FOREIGN KEY (com_id_mun) REFERENCES acopio.municipio (mun_id) ON DELETE No Action ON UPDATE No Action;

    INSERT INTO acopio.comunidad VALUES (1, 'CAMPESINA GONZALO MORENO', 1, 'A');
    INSERT INTO acopio.comunidad VALUES (2, 'CAMPESINA LAS PIEDRAS', 1, 'A');
    INSERT INTO acopio.comunidad VALUES (3, 'CAMPESINA LAGO VICTORIA', 1, 'A');
    INSERT INTO acopio.comunidad VALUES (4, 'CAMPESINA AGUA DULCE', 1, 'A');
    INSERT INTO acopio.comunidad VALUES (5, 'CAMPESINA LIBERTAD', 1, 'A');
    INSERT INTO acopio.comunidad VALUES (6, 'CAMPESINA FRONTERA', 1, 'A');
    INSERT INTO acopio.comunidad VALUES (7, 'CAMPESINA BUEN FUTURO', 1, 'A');
    INSERT INTO acopio.comunidad VALUES (8, 'INDIGENA PORTACHUELO ALTO', 1, 'A');
    INSERT INTO acopio.comunidad VALUES (9, 'INDIGENA PORTACHUELO MEDIO', 1, 'A');
    INSERT INTO acopio.comunidad VALUES (10, 'INDIGENA PORTACHUELO BAJO', 1, 'A');
    INSERT INTO acopio.comunidad VALUES (11, 'INDIGENA CONTRAVARICIA', 1, 'A');
    INSERT INTO acopio.comunidad VALUES (12, 'INDIGENA VILLA NUEVA', 1, 'A');
    INSERT INTO acopio.comunidad VALUES (13, 'INDIGENA AMERICA', 1, 'A');
    INSERT INTO acopio.comunidad VALUES (14, 'INDIGENA 6 DE AGOSTO', 1, 'A');
    INSERT INTO acopio.comunidad VALUES (15, 'INDIGENA SANTA ROSITA', 1, 'A');
    INSERT INTO acopio.comunidad VALUES (16, 'INDIGENA MIRAFLORES', 1, 'A');
    INSERT INTO acopio.comunidad VALUES (17, 'CAMPESINA CANDELARIA', 1, 'A');
    INSERT INTO acopio.comunidad VALUES (18, 'CAMPESINA SAN CARLOS', 1, 'A');
    INSERT INTO acopio.comunidad VALUES (19, 'CAMPESINA DOS PALMAS', 1, 'A');
    INSERT INTO acopio.comunidad VALUES (20, 'CAMPESINA SAN PABLO', 1, 'A');
    INSERT INTO acopio.comunidad VALUES (21, 'EL SENA', 2, 'A');
    INSERT INTO acopio.comunidad VALUES (22, 'SAN ANTONIO', 2, 'A');
    INSERT INTO acopio.comunidad VALUES (23, 'REMANSO', 2, 'A');
    INSERT INTO acopio.comunidad VALUES (24, 'LAS MERCEDES', 2, 'A');
    INSERT INTO acopio.comunidad VALUES (25, 'SANTA ROSA', 2, 'A');
    INSERT INTO acopio.comunidad VALUES (26, 'RANCHITO', 2, 'A');

-- ----------------------------
-- TABLA LINEA DE TRABAJO
-- ----------------------------
    DROP SEQUENCE IF EXISTS acopio.ltra_id_seq;
    CREATE SEQUENCE acopio.ltra_id_seq INCREMENT 1 START 1;

    DROP TABLE IF EXISTS acopio.linea_trab;
    CREATE TABLE acopio.linea_trab (
        ltra_id integer DEFAULT nextval('acopio.ltra_id_seq'::regclass) NOT NULL,
        ltra_nombre varchar(50) NOT NULL,
        ltra_estado character (1) NOT NULL,
        ltra_fecha_reg timestamp(6) NOT NULL
    );

    ALTER TABLE acopio.linea_trab ADD CONSTRAINT linea_trab_pkey PRIMARY KEY (ltra_id);
    ALTER TABLE acopio.proveedor ADD CONSTRAINT proveedor_prov_id_linea FOREIGN KEY (prov_id_linea) REFERENCES acopio.linea_trab (ltra_id) ON DELETE No Action ON UPDATE No Action;
    ALTER TABLE acopio.acopio ADD CONSTRAINT acopio_aco_id_linea FOREIGN KEY (aco_id_linea) REFERENCES acopio.linea_trab (ltra_id) ON DELETE No Action ON UPDATE No Action;
   
    INSERT INTO acopio.linea_trab VALUES (1, 'ALMENDRA', 'A', '2018-05-18 16:56:42');
    INSERT INTO acopio.linea_trab VALUES (2, 'LACTEOS', 'A', '2018-05-18 16:56:42');
    INSERT INTO acopio.linea_trab VALUES (3, 'MIEL', 'A', '2018-05-18 16:56:42');

-- ----------------------------
-- TABLA RESPONSABLE DE RECEPCION
-- ----------------------------
    DROP SEQUENCE IF EXISTS acopio.rec_id_seq;
    CREATE SEQUENCE acopio.rec_id_seq INCREMENT 1 START 1;

    DROP TABLE IF EXISTS acopio.resp_recep;
    CREATE TABLE acopio.resp_recep (
        rec_id integer DEFAULT nextval('acopio.rec_id_seq'::regclass) NOT NULL,
        rec_nombre varchar(50) NOT NULL,
        rec_ap varchar(50) NOT NULL,
        rec_am varchar(50) NOT NULL,
        rec_ci integer NOT NULL,
        rec_tipo integer NULL,
        rec_id_linea integer NOT NULL,
        rec_estado character (1) NOT NULL
    );

    ALTER TABLE acopio.resp_recep ADD CONSTRAINT resp_recep_pkey PRIMARY KEY (rec_id);
    ALTER TABLE acopio.proveedor ADD CONSTRAINT proveedor_prov_id_recep FOREIGN KEY (prov_id_recep) REFERENCES acopio.resp_recep (rec_id) ON DELETE No Action ON UPDATE No Action;
    ALTER TABLE acopio.acopio ADD CONSTRAINT acopio_aco_id_recep FOREIGN KEY (aco_id_recep) REFERENCES acopio.resp_recep (rec_id) ON DELETE No Action ON UPDATE No Action;
    ALTER TABLE acopio.resp_recep ADD CONSTRAINT resp_recep_rec_id_linea FOREIGN KEY (rec_id_linea) REFERENCES acopio.linea_trab (ltra_id) ON DELETE No Action ON UPDATE No Action;

    INSERT INTO acopio.resp_recep VALUES (1, 'xxxxxx', 'CCCCC', 'FFFFF',123456, 1, 3, 'A');

-- ----------------------------
-- TABLA UNIDAD
-- ----------------------------
    DROP SEQUENCE IF EXISTS acopio.uni_id_seq;
    CREATE SEQUENCE acopio.uni_id_seq INCREMENT 1 START 1;

    DROP TABLE IF EXISTS acopio.unidad;
    CREATE TABLE acopio.unidad
    (
        uni_id integer DEFAULT NEXTVAL('acopio.uni_id_seq'::regclass) NOT NULL,
        uni_nombre varchar(50) NOT NULL,
        uni_sigla varchar(10) NOT NULL,
        uni_estado character (1) NOT NULL
    );

    ALTER TABLE acopio.unidad ADD CONSTRAINT unidad_pkey PRIMARY KEY (uni_id);
    ALTER TABLE acopio.acopio ADD CONSTRAINT acopio_aco_unidad FOREIGN KEY (aco_unidad) REFERENCES acopio.unidad (uni_id) ON DELETE No Action ON UPDATE No Action;

    INSERT INTO acopio.unidad VALUES (1,'UNIDAD', 'Und', 'A');
    INSERT INTO acopio.unidad VALUES (2,'KILOGRAMO', 'Kg', 'A');
    INSERT INTO acopio.unidad VALUES (3,'CAJA', 'Cj', 'A');

-- ----------------------------
-- TABLA TIPO DE CASTAÑA
-- ----------------------------
    DROP SEQUENCE IF EXISTS acopio.tca_id_seq;
    CREATE SEQUENCE acopio.tca_id_seq INCREMENT 1 START 1;

    DROP TABLE IF EXISTS acopio.tipo_castania;
    CREATE TABLE acopio.tipo_castania
    (
        tca_id integer  DEFAULT NEXTVAL('acopio.tca_id_seq'::regclass) NOT NULL ,
        tca_nombre varchar(100) NOT NULL,
        tca_estado character (1) NOT NULL,
        tca_fecha_reg timestamp(6) NOT NULL
    );

    ALTER TABLE acopio.tipo_castania ADD CONSTRAINT tipo_castenia_pkey PRIMARY KEY (tca_id);
    ALTER TABLE acopio.acopio ADD CONSTRAINT acopio_aco_id_tipo_cas FOREIGN KEY (aco_id_tipo_cas) REFERENCES acopio.tipo_castania (tca_id) ON DELETE No Action ON UPDATE No Action;
   
    INSERT INTO acopio.tipo_castania VALUES (1,'Castaña Organica', 'A', '2018-05-18 16:56:42');
    INSERT INTO acopio.tipo_castania VALUES (2,'Castaña Convencional', 'A', '2018-05-18 16:56:42');
-- ----------------------------
-- TABLA LUGAR DE PROCEDENCIA
-- ----------------------------
    DROP SEQUENCE IF EXISTS acopio.proc_id_seq;
    CREATE SEQUENCE acopio.proc_id_seq INCREMENT 1 START 1;

    DROP TABLE IF EXISTS acopio.lugar_proc;
    CREATE TABLE acopio.lugar_proc
    (
        proc_id integer  DEFAULT NEXTVAL('acopio.proc_id_seq'::regclass) NOT NULL ,
        proc_nombre varchar(100) NOT NULL,
        proc_estado character (1) NOT NULL,
        proc_fecha_reg timestamp(6) NOT NULL,
        proc_id_linea integer NOT NULL
    );

    ALTER TABLE acopio.lugar_proc ADD CONSTRAINT lugar_proc_pkey PRIMARY KEY (proc_id);
    ALTER TABLE acopio.acopio ADD CONSTRAINT acopio_aco_id_proc FOREIGN KEY (aco_id_proc) REFERENCES acopio.lugar_proc (proc_id) ON DELETE No Action ON UPDATE No Action;
   
    INSERT INTO acopio.lugar_proc VALUES (1,'CENTRO DE ACOPIO', 'A', '2018-05-18 16:56:42',1);
    INSERT INTO acopio.lugar_proc VALUES (2,'PAYOL', 'A', '2018-05-18 16:56:42',1);
    INSERT INTO acopio.lugar_proc VALUES (3,'FABRICA', 'A', '2018-05-18 16:56:42',1);
    INSERT INTO acopio.lugar_proc VALUES (4,'MIEL', 'A', '2018-05-18 16:56:42',3);

-- ----------------------------
-- TABLA DESTINO
-- ----------------------------
    DROP SEQUENCE IF EXISTS acopio.des_id_seq;
    CREATE SEQUENCE acopio.des_id_seq INCREMENT 1 START 1;

    DROP TABLE IF EXISTS acopio.destino;
    CREATE TABLE acopio.destino
    (
        des_id integer DEFAULT NEXTVAL('acopio.des_id_seq'::regclass) NOT NULL,
        des_descripcion varchar(100) NOT NULL,
        des_estado character (1) NOT NULL,
        des_fecha_reg timestamp(6) NOT NULL
    );

    ALTER TABLE acopio.destino ADD CONSTRAINT destino_pkey PRIMARY KEY (des_id);
    ALTER TABLE acopio.acopio ADD CONSTRAINT acopio_aco_id_destino FOREIGN KEY (aco_id_destino) REFERENCES acopio.destino (des_id) ON DELETE No Action ON UPDATE No Action;
 
    INSERT INTO acopio.destino VALUES (1,'xxxxx', 'A', '2018-05-18 16:56:42');

-- ----------------------------
-- TABLA PROPIEDADES DE MIEL
-- ----------------------------
    DROP SEQUENCE IF EXISTS acopio.prom_id_seq;
    CREATE SEQUENCE acopio.prom_id_seq INCREMENT 1 START 1;

    DROP TABLE IF EXISTS acopio.propiedades_miel;
    CREATE TABLE acopio.propiedades_miel
    (
        prom_id integer DEFAULT NEXTVAL('acopio.prom_id_seq'::regclass) NOT NULL,
        prom_peso_bruto decimal NOT NULL,
        prom_peso_tara decimal NOT NULL,
        prom_peso_neto decimal NOT NULL,
        prom_cantidad_baldes integer NOT NULL,
        prom_total decimal NOT NULL,
        prom_cod_colmenas integer NULL,
        prom_centrifugado decimal NULL,
        prom_peso_bruto_centrif decimal NULL, 
        prom_peso_bruto_filt decimal NULL,
        prom_peso_bruto_imp decimal NULL,
        prom_humedad decimal NULL,
        prom_cos_un decimal null,
        prom_humedad decimal NULL,
        prom_cos_un decimal NULL
    );

    ALTER TABLE acopio.propiedades_miel ADD CONSTRAINT propiedades_miel_pkey PRIMARY KEY (prom_id);
    ALTER TABLE acopio.acopio ADD CONSTRAINT acopio_aco_id_prom FOREIGN KEY (aco_id_prom) REFERENCES acopio.propiedades_miel (prom_id) ON DELETE No Action ON UPDATE No Action;
 
    INSERT INTO acopio.propiedades_miel VALUES (1, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- TABLA SOLICITUDES
-- ----------------------------
    DROP SEQUENCE IF EXISTS acopio.sol_id_seq;
    CREATE SEQUENCE acopio.sol_id_seq INCREMENT 1 START 1;

    DROP TABLE IF EXISTS acopio.solicitud;
    CREATE TABLE acopio.solicitud
    (
        sol_id integer DEFAULT NEXTVAL('acopio.sol_id_seq'::regclass) NOT NULL,
        sol_id_usr integer NOT NULL,
        sol_detalle varchar(200) NOT NULL,
        sol_monto decimal NOT NULL,
        sol_estado character (1) NOT NULL,
        sol_observacion varchar(300) NULL,
        sol_id_mun integer NOT NULL,
        sol_centr_acopio varchar(200) NULL,
        sol_fecha_reg timestamp(6) NULL,
        sol_usr_modif integer NULL, 
        sol_fecha_modif timestamp(6) NULL
    );

    ALTER TABLE acopio.solicitud ADD CONSTRAINT solicitud_pkey PRIMARY KEY (sol_id);
    ALTER TABLE acopio.solicitud ADD CONSTRAINT solicitud_sol_id_mun FOREIGN KEY (sol_id_mun) REFERENCES acopio.municipio (mun_id) ON DELETE No Action ON UPDATE No Action;

-- ----------------------------
-- TABLA ASIGNACION DE PRESUPUESTO
-- ----------------------------
    DROP SEQUENCE IF EXISTS acopio.asig_id_seq;
    CREATE SEQUENCE acopio.asig_id_seq INCREMENT 1 START 1;

    DROP TABLE IF EXISTS acopio.asignacion_presupuesto;
    CREATE TABLE acopio.asignacion_presupuesto
    (
        asig_id integer DEFAULT NEXTVAL('acopio.asig_id_seq'::regclass) NOT NULL,
        asig_id_comp integer NOT NULL,
        asig_monto decimal NOT NULL,
        asig_fecha timestamp(6) NOT NULL,
        asig_obs varchar(200) NULL,
        asig_id_usr integer NOT NULL,
        asig_estado character (1) NOT NULL,
        asig_fecha_reg timestamp(6) NOT NULL,
        asig_id_sol integer NOT NULL
    );

    ALTER TABLE acopio.asignacion_presupuesto ADD CONSTRAINT asignacion_presupuesto_pkey PRIMARY KEY (asig_id);
    ALTER TABLE acopio.asignacion_presupuesto ADD CONSTRAINT acopiasig_ido_asig_id_sol FOREIGN KEY (asig_id_sol) REFERENCES acopio.solicitud (sol_id) ON DELETE No Action ON UPDATE No Action;
 
-- ----------------------------
-- TABLA DEPARTAMENTO
-- ----------------------------
    DROP SEQUENCE IF EXISTS acopio.dep_id_seq;
    CREATE SEQUENCE acopio.dep_id_seq INCREMENT 1 START 1;

    DROP TABLE IF EXISTS acopio.departamento;
    CREATE TABLE acopio.departamento
    (
        dep_id integer DEFAULT NEXTVAL('acopio.dep_id_seq'::regclass) NOT NULL,
        dep_nombre varchar(20) NOT NULL,
        dep_exp varchar(5) NOT NULL
    );

    ALTER TABLE acopio.departamento ADD CONSTRAINT departamento_pkey PRIMARY KEY (dep_id);
    ALTER TABLE acopio.proveedor ADD CONSTRAINT proveedor_prov_departamento FOREIGN KEY (prov_departamento) REFERENCES acopio.departamento (dep_id) ON DELETE No Action ON UPDATE No Action;
    ALTER TABLE acopio.municipio ADD CONSTRAINT municipio_mun_id_dep FOREIGN KEY (mun_id_dep) REFERENCES acopio.departamento (dep_id) ON DELETE No Action ON UPDATE No Action;
 
    INSERT INTO acopio.departamento VALUES (1, 'La Paz', 'LP');
    INSERT INTO acopio.departamento VALUES (2, 'Oruro', 'OR');
    INSERT INTO acopio.departamento VALUES (3, 'Potosi', 'PT');
    INSERT INTO acopio.departamento VALUES (4, 'Tarija', 'TJ');
    INSERT INTO acopio.departamento VALUES (5, 'Santa Cruz', 'SC');
    INSERT INTO acopio.departamento VALUES (6, 'Cochabamba', 'CB');
    INSERT INTO acopio.departamento VALUES (7, 'Beni', 'BN');
    INSERT INTO acopio.departamento VALUES (8, 'Pando', 'PA');
    INSERT INTO acopio.departamento VALUES (9, 'Chuquisaca', 'CH');

  -- ----------------------------
-- TABLA DETALLE DE ACOPIO CENTRO 
-- ----------------------------
    DROP SEQUENCE IF EXISTS acopio.det_acop_ca_dac_id_seq;
    CREATE SEQUENCE acopio.det_acop_ca_dac_id_seq INCREMENT 1 START 1;

    DROP TABLE IF EXISTS acopio.det_acop_ca;
    CREATE TABLE acopio.det_acop_ca
    (
        dac_id integer NOT NULL DEFAULT nextval('acopio.det_acop_ca_dac_id_seq'::regclass),
        dac_id_prov integer,
        dac_cert integer,
        dac_fecha_acop date,
        dac_hora character(6) COLLATE pg_catalog."default",
        dac_cant_uni numeric,
        dac_obs character(100) COLLATE pg_catalog."default",
        dac_cond integer,
        dac_tem numeric,
        dac_sng numeric,
        dac_palc integer,
        dac_aspecto integer,
        dac_color integer,
        dac_olor integer,
        dac_sabor integer,
        dac_tenv integer,
        dac_estado integer,
        dac_fecha_reg date,
        dac_id_rec integer
    );    
    ALTER TABLE acopio.det_acop_ca ADD CONSTRAINT det_acop_ca_pkey PRIMARY KEY (dac_id);

  -- ----------------------------
-- TABLA DETALLE DE ACOPIO ESLAC 
-- ----------------------------
    DROP SEQUENCE IF EXISTS acopio.det_acoreslac_id_seq;
    CREATE SEQUENCE acopio.det_acoreslac_id_seq INCREMENT 1 START 1;

    DROP TABLE IF EXISTS acopio.det_acoreslac;
    CREATE TABLE acopio.det_acoreslac
    (
        detlac_id integer DEFAULT nextval('acopio.det_acoreslac_id_seq'::regclass),
        detlac_id_rec integer,
        detlac_fecha date,
        detlac_cant numeric,
        detlac_obs character varying COLLATE pg_catalog."default",
        detlac_tem numeric,
        detlac_sng numeric,
        detlac_palc integer,
        detlac_aspecto integer,
        detlac_color integer,
        detlac_olor integer,
        detlac_sabor integer,
        detlac_estado character varying COLLATE pg_catalog."default",
        detlac_fecha_reg date,
        detlac_cant_prov integer,
        detlac_est_reg integer,
        detlac_nom_rec character varying(50) COLLATE pg_catalog."default",
        detlac_envio character varying(50)
    );
    ALTER TABLE acopio.det_acoreslac ADD CONSTRAINT det_acoreslac_pkey PRIMARY KEY (detlac_id);

--MODIFICACIONES ACOPIO LACTEOS
CREATE TABLE acopio.modulo(
    modulo_id serial primary key,
    modulo_nombre text NOT NULL,
    modulo_paterno text,
    modulo_materno text,
    modulo_ci text,
    modulo_dir text,
    modulo_tel text,    
    modulo_usr_id integer NOT NULL,
    modulo_registrado timestamp NOT NULL DEFAULT now(),
    modulo_modificado timestamp NOT NULL DEFAULT now(),
    modulo_estado char(1) NOT NULL DEFAULT 'A'
);
-- SOLCITUDES DE CAMBIOS Y/O MODIFICACIONES
--TABLA TIPO SOLICIUD CAMBIOS 
create table acopio.tipo_solicitud_cambio(
    tipsolcam_id serial,
    tipsolcam_nombre text,
    primary key (tipsolcam_id)
);
--TABLA SOLICITUD CAMBIOS
create table acopio.solicitud_cambio(
    solcam_id serial,
    solcam_aco_id integer,
    solcam_usr_id integer,
    solcam_cantidad decimal,
    solcam_costo_unitario decimal,
    solcam_costo_total decimal,
    solcam_peso_caja decimal,
    solcam_nro_recibo text,
    solcam_tipo_id integer,
    solcam_observacion text,
    solcam_estado character(1) default 'A',
    solcam_fecha_registro timestamp default now(),
    primary key (solcam_id)
);
alter table acopio.solicitud_cambio add constraint FK_solicitud_tipo_sol 
foreign key (solcam_tipo_id)
references acopio.tipo_solicitud_cambio(tipsolcam_id);

-- INSERT INTOS
INSERT INTO acopio.tipo_solicitud_cambio (tipsolcam_nombre) VALUES ('CANTIDAD');
INSERT INTO acopio.tipo_solicitud_cambio (tipsolcam_nombre) VALUES ('PESO');
INSERT INTO acopio.tipo_solicitud_cambio (tipsolcam_nombre) VALUES ('NUMERO RECIBO');
INSERT INTO acopio.tipo_solicitud_cambio (tipsolcam_nombre) VALUES ('ELIMINACION');
INSERT INTO acopio.tipo_solicitud_cambio (tipsolcam_nombre) VALUES ('PRECIO');

-- TABLA APROBACION SOLICITUDES JEFE ACOPIO
create table acopio.aprobacion_soljefe(
    apsoljefe_id serial,
    apsoljefe_aco_id integer,
    apsoljefe_usr_id integer,
    apsoljefe_solcam_id integer,
    apsoljefe_observacion text,
    apsoljefe_estado character(1) default 'A',
    apsoljefe_fecha_registro timestamp default now(),
    primary key (apsoljefe_id)
);

alter table acopio.aprobacion_soljefe add constraint FK_aprobacion_solcam_id
foreign key (apsoljefe_solcam_id)
references acopio.solicitud_cambio(solcam_id);

-- TABLA APROBACION SOLICITUDES GERENTE ALMENDRA
create table acopio.aprobacion_solgerente(
    apsolgerente_id serial,
    apsolgerente_aco_id integer,
    apsolgerente_usr_id integer,
    apsolgerente_apsoljefe_id integer,
    apsolgerente_estado character(1) default 'A',
    apsolgerente_fecha_registro timestamp default now(),
    primary key (apsolgerente_id)
);

alter table acopio.aprobacion_solgerente add constraint FK_aprobaciongerente_solcam_id
foreign key (apsolgerente_apsoljefe_id)
references acopio.aprobacion_soljefe(apsoljefe_id);