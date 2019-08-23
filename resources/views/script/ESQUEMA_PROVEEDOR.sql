
-- ----------------------------
-- TABLA PROVEEDOR
-- ----------------------------
    DROP SEQUENCE IF EXISTS acopio.prov_id_seq;
    CREATE SEQUENCE acopio.prov_id_seq INCREMENT 1 START 1;
    DROP TABLE IF EXISTS acopio.proveedor;
    CREATE TABLE acopio.proveedor (
        "prov_id" integer DEFAULT nextval('acopio.prov_id_seq'::regclass) NOT NULL,
        "prov_nombre" varchar(100) NOT NULL,
        "prov_ap" varchar(100) COLLATE "default" NULL,
        "prov_am" varchar(100) COLLATE "default" NULL,
        "prov_ci" integer NOT NULL,
        "prov_exp" integer NOT NULL,
        "prov_tel" integer NULL,
        "prov_foto" varchar(300) COLLATE "default" NULL,
        "prov_id_tipo" integer NOT NULL,
        "prov_id_convenio" varchar(10) NULL,
        "prov_departamento" integer NOT NULL,
        "prov_id_municipio" integer NOT NULL,
        "prov_id_comunidad" integer NOT NULL,
        "prov_id_asociacion" integer  NOT NULL,
        "prov_direccion" varchar(200) NULL,
        "prov_rau" integer NULL,
        "prov_nit" integer NULL,
        "prov_cuenta" integer NULL,
        "prov_lugar" integer NULL,
        "prov_id_linea" integer NOT NULL,
        "prov_estado" character (1) NOT NULL,
        "prov_fecha_reg" timestamp(6) NULL,
        "prov_id_recep" integer NULL,
        "prov_latitud" float  NULL,
        "prov longitud" float NULL
    );
        ALTER TABLE acopio.proveedor ADD CONSTRAINT proveedor_pkey PRIMARY KEY (prov_id);

        INSERT INTO acopio.proveedor VALUES ('1', 'MAGALI', 'AMAPO', 'YUBANERA', '10721382', '1', '0', 'xxxxxx', 1, 'SI', 1, 1, 1, 1, 'xxxxxxxx', 0, 0, 0, 1, 1, 'A', '2018-05-18 16:56:42', 1, NULL, NULL);

-- ----------------------------
-- TABLA TIPO PROVEEDOR
-- ----------------------------
    DROP SEQUENCE IF EXISTS acopio.tprov_id_seq;
    CREATE SEQUENCE acopio.tprov_id_seq INCREMENT 1 START 1;

    DROP TABLE IF EXISTS acopio.tipo_proveedor;
    CREATE TABLE acopio.tipo_proveedor (
        tprov_id integer DEFAULT nextval('acopio.tprov_id_seq'::regclass) NOT NULL,
        tprov_tipo varchar(50) NOT NULL,
        tprov_estado  character (1) NOT NULL,
        tprov_id_linea integer NOT NULL
    );

    ALTER TABLE acopio.tipo_proveedor ADD CONSTRAINT tipo_proveedor_pkey PRIMARY KEY (tprov_id);
    ALTER TABLE acopio.proveedor ADD CONSTRAINT proveedor_tipo_proveedor FOREIGN KEY (prov_id_tipo) REFERENCES acopio.tipo_proveedor (tprov_id) ON DELETE No Action ON UPDATE No Action;

    INSERT INTO acopio.tipo_proveedor VALUES (1, 'COMUNARIO', 'A', 1);
    INSERT INTO acopio.tipo_proveedor VALUES (2, 'RESCATISTA', 'A', 1);
    INSERT INTO acopio.tipo_proveedor VALUES (3, 'BARRAQUERO', 'A', 1);
    INSERT INTO acopio.tipo_proveedor VALUES (4, 'CAMPESINO', 'A', 1);
    INSERT INTO acopio.tipo_proveedor VALUES (5, 'INDIGENA', 'A', 1);
    INSERT INTO acopio.tipo_proveedor VALUES (6, 'PRIVADO', 'A', 1);
    INSERT INTO acopio.tipo_proveedor VALUES (7, 'PROVEEDOR', 'A', 2);
    INSERT INTO acopio.tipo_proveedor VALUES (8, 'SUB-PROVEEDOR', 'A', 2);
    INSERT INTO acopio.tipo_proveedor VALUES (9, 'PRODUCTOR APICOLA', 'A', 3);
    INSERT INTO acopio.tipo_proveedor VALUES (10, 'PROVEEDOR APICOLA', 'A', 3);
    INSERT INTO acopio.tipo_proveedor VALUES (11, 'PROVEEDOR APICOLA POR CONVENIO', 'A', 3);

-- ----------------------------
-- TABLA MUNICIPIO
-- ----------------------------
    DROP SEQUENCE IF EXISTS acopio.mun_id_seq;
    CREATE SEQUENCE acopio.mun_id_seq INCREMENT 1 START 1;

    DROP TABLE IF EXISTS acopio.municipio;
    CREATE TABLE acopio.municipio (
        mun_id integer DEFAULT nextval('acopio.mun_id_seq'::regclass) NOT NULL,
        mun_nombre varchar(50) NOT NULL,
        mun_id_dep integer NOT NULL
    );

    ALTER TABLE acopio.municipio ADD CONSTRAINT municipio_pkey PRIMARY KEY (mun_id);
    ALTER TABLE acopio.proveedor ADD CONSTRAINT proveedor_id_municipio FOREIGN KEY (prov_id_municipio) REFERENCES acopio.municipio (mun_id) ON DELETE No Action ON UPDATE No Action;

    INSERT INTO acopio.municipio VALUES (1, 'GONZALO MORENO', 8);
    INSERT INTO acopio.municipio VALUES (2, 'EL SENA', 8);
    INSERT INTO acopio.municipio VALUES (3, 'SAN LORENZO', 8);
    INSERT INTO acopio.municipio VALUES (4, 'PUERTO RICO', 8);
    INSERT INTO acopio.municipio VALUES (5, 'FILADELFIA', 8);
    INSERT INTO acopio.municipio VALUES (6, 'SAN PEDRO', 8);
    INSERT INTO acopio.municipio VALUES (7, 'SANTA ROSA DEL ABUNA', 8);
    INSERT INTO acopio.municipio VALUES (8, 'INGAVI', 8);
    INSERT INTO acopio.municipio VALUES (9, 'PORVENIR', 8);
    INSERT INTO acopio.municipio VALUES (10, 'COBIJA', 8);
    INSERT INTO acopio.municipio VALUES (11, 'BOLPEBRA', 8);
    INSERT INTO acopio.municipio VALUES (12, 'NUEVA ESPERANZA', 8);
    INSERT INTO acopio.municipio VALUES (13, 'VILLA NUEVA', 8);
    INSERT INTO acopio.municipio VALUES (14, 'SANTOS MERCADOS', 8);
    INSERT INTO acopio.municipio VALUES (15, 'RIBERALTA', 7);
    INSERT INTO acopio.municipio VALUES (16, 'GUAYARAMERIN', 7);
    INSERT INTO acopio.municipio VALUES (17, 'BAURES', 7);
    INSERT INTO acopio.municipio VALUES (18, 'MAGDALENA', 7);
    INSERT INTO acopio.municipio VALUES (19, 'IXIAMAS', 1);

-- ----------------------------
-- TABLA ASOCIACION
-- ----------------------------
    DROP SEQUENCE IF EXISTS acopio.aso_id_seq;
    CREATE SEQUENCE acopio.aso_id_seq INCREMENT 1 START 1;

    DROP TABLE IF EXISTS acopio.asociacion;
    CREATE TABLE acopio.asociacion
    (
        aso_id integer  DEFAULT NEXTVAL('acopio.aso_id_seq'::regclass) NOT NULL ,
        aso_nombre varchar(100) NOT NULL,
        aso_sigla varchar(20) NULL,
        aso_id_mun integer NULL,
        aso_estado character (1) NOT NULL,
        aso_fecha_reg timestamp(6) NOT NULL,
        aso_id_usr integer NOT NULL,
        aso_id_linea integer NOT NULL
    );

    ALTER TABLE acopio.asociacion ADD CONSTRAINT asociacion_pkey PRIMARY KEY (aso_id);
    ALTER TABLE acopio.proveedor ADD CONSTRAINT proveedor_id_asociacion FOREIGN KEY (prov_id_asociacion) REFERENCES acopio.asociacion (aso_id) ON DELETE No Action ON UPDATE No Action;
    ALTER TABLE acopio.asociacion ADD CONSTRAINT asociacion_id_municipio FOREIGN KEY (aso_id_mun) REFERENCES acopio.municipio (mun_id) ON DELETE No Action ON UPDATE No Action;

    INSERT INTO acopio.asociacion VALUES (1,'ASOCIACION - AIRCOA','AIRCOA',1,'A','2018-01-01 22:42:27',1,1);
    INSERT INTO acopio.asociacion VALUES (2,'ASOCIACION - APAE','APAE',1,'A','2018-01-01 22:42:27',1,1);
    INSERT INTO acopio.asociacion VALUES (3,'OECOM - LOMA ALTA','LOMA ALTA',14,'A','2018-01-01 22:42:27',1,1);
    INSERT INTO acopio.asociacion VALUES (4,'OECOM - CHACOBO-PACAHURA',' CHACOBO-PACAHURA',16,'A','2018-01-01 22:42:27',1,1);
    INSERT INTO acopio.asociacion VALUES (5,'OECOM - PALMA REAL','PALMA REAL',2,'A','2018-01-01 22:42:27',1,1);
    INSERT INTO acopio.asociacion VALUES (6,'OECOM - TCO-ARAONA','TCO-ARAONA',19,'A','2018-01-01 22:42:27',1,1);
    INSERT INTO acopio.asociacion VALUES (7,'PD ANMI ITENEZ','PD ANMI ITENEZ',19,'A','2018-01-01 22:42:27',1,1);
    INSERT INTO acopio.asociacion VALUES (8,'CENTRALOP','CNT',19,'A','2018-01-01 22:42:27',1,1);
    INSERT INTO acopio.asociacion VALUES (9,'CENTRALZZ','CNTZ',6,'A','2018-01-01 22:42:27',1,1);
    INSERT INTO acopio.asociacion VALUES (10,'MIEL','M',6,'A','2018-01-01 22:42:27',1,3);

-- ----------------------------
-- TABLA CONTRATOS
-- ----------------------------
    DROP SEQUENCE IF EXISTS acopio.contrato_id_seq;
    CREATE SEQUENCE acopio.contrato_id_seq INCREMENT 1 START 1;

    DROP TABLE IF EXISTS acopio.contrato;
    CREATE TABLE acopio.contrato
    (
        contrato_id integer DEFAULT NEXTVAL('acopio.contrato_id_seq'::regclass) NOT NULL,
        contrato_id_prov varchar(50) NOT NULL,
        contrato_nro text NOT NULL,
        contrato_precio decimal NOT NULL,
        contrato_deuda decimal NOT NULL,
        contrato_sindicato text NOT NULL,
        contrato_central text NOT NULL
    );
    ALTER TABLE acopio.contrato ADD CONSTRAINT contrato_pkey PRIMARY KEY (contrato_id);
    ALTER TABLE acopio.contrato ADD CONSTRAINT contrato_contrato_id FOREIGN KEY (contrato_id) REFERENCES acopio.proveedor (prov_id) ON DELETE No Action ON UPDATE No Action;

    INSERT INTO acopio.contrato VALUES (1,'xxxxx','DD2DD', 20.00, 20.00, 'VVV3VV', 'FFF8FFF');

-- ----------------------------
-- TABLA PAGOS
-- ----------------------------
    DROP SEQUENCE IF EXISTS acopio.pago_id_seq;
    CREATE SEQUENCE acopio.pago_id_seq INCREMENT 1 START 1;

    DROP TABLE IF EXISTS acopio.pagos;
    CREATE TABLE acopio.pagos
    (
        pago_id integer DEFAULT NEXTVAL('acopio.pago_id_seq'::regclass) NOT NULL,
        pago_amortizacion decimal NULL,
        pago_amortizacionBs decimal NULL,
        pago_t_men_amort decimal NULL,
        pago_rau_iue decimal NULL,
        pago_rau_it decimal NULL,
        pago_liquido_pag decimal NOT NULL,
        pago_saldo_deuda decimal NOT NULL,
        pago_id_contrato integer NOT null
    );
    ALTER TABLE acopio.pagos ADD CONSTRAINT pagos_pkey PRIMARY KEY (pago_id);
   -- ALTER TABLE acopio.pagos ADD CONSTRAINT pagos_pago_id FOREIGN KEY (pago_id) REFERENCES acopio.contrato (contrato_id) ON DELETE No Action ON UPDATE No Action;
    INSERT INTO acopio.pagos VALUES (1, NULL, NULL, NULL, NULL, NULL, 00.00, 00.00, 1);

    
	
	


