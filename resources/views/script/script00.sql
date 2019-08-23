CREATE TABLE _bp_estados_civiles (
	estcivil_id serial PRIMARY KEY,
	estcivil text not null,
	estcivil_registrado timestamp NOT NULL DEFAULT now(),
	estcivil_modificado timestamp NOT NULL DEFAULT now(),
	estcivil_usr_id integer NOT NULL,
	estcivil_estado char(1) NOT NULL DEFAULT 'A'
);
INSERT INTO _bp_estados_civiles (estcivil, estcivil_usr_id, estcivil_estado) VALUES 
                                ('Soltero/a', 1, 'A'),
								('Casado/a', 1, 'A'),
								('Divorciado/a', 1, 'A'),
								('Viudo/a', 1, 'A'),
								('Prs. Jurídica', 1, 'A');
CREATE TABLE _bp_personas (
	prs_id serial PRIMARY KEY,
	prs_id_estado_civil integer NOT NULL,
	prs_id_archivo_cv integer,
	prs_ci text NOT NULL,
	prs_nombres text NOT NULL,
	prs_paterno text NOT NULL,
	prs_materno text NOT NULL,
	prs_direccion text NOT NULL,
	prs_direccion2 text DEFAULT '',
	prs_telefono text DEFAULT '',
	prs_telefono2 text DEFAULT '',
	prs_celular text DEFAULT '',
	prs_empresa_telefonica text DEFAULT '',
	prs_correo text DEFAULT '',
	prs_sexo char(1) DEFAULT 'F',
	prs_fec_nacimiento date NOT NULL,
	prs_registrado timestamp NOT NULL DEFAULT now(),
	prs_modificado timestamp NOT NULL DEFAULT now(),
	prs_usr_id integer NOT NULL,
	prs_estado char(1) NOT NULL DEFAULT 'A',
    prs_linea_trabajo integer NULL,
	FOREIGN KEY(prs_id_estado_civil) REFERENCES _bp_estados_civiles(estcivil_id)
);

INSERT INTO _bp_personas (prs_id_estado_civil, prs_id_archivo_cv, prs_ci, prs_nombres, prs_paterno, prs_materno, prs_direccion, prs_direccion2, prs_telefono, prs_telefono2, prs_celular,prs_empresa_telefonica, prs_correo, prs_sexo, prs_fec_nacimiento, prs_usr_id, prs_estado, prs_linea_trabajo) 
VALUES (1, 0, 1, 'Roxana', 'Ortiz', 'Calani', '', '', '', '', '', '', '', 'F', '2015-01-01', 1, 'A',1);
INSERT INTO _bp_personas (prs_id_estado_civil, prs_id_archivo_cv, prs_ci, prs_nombres, prs_paterno, prs_materno, prs_direccion, prs_direccion2, prs_telefono, prs_telefono2, prs_celular,prs_empresa_telefonica, prs_correo, prs_sexo, prs_fec_nacimiento, prs_usr_id, prs_estado, prs_linea_trabajo) 
VALUES (1, 0, 1, 'Sandra', 'Macuchapi', 'Huanca', '', '', '', '', '', '', '', 'F', '2015-01-01', 1, 'A',2);
INSERT INTO _bp_personas (prs_id_estado_civil, prs_id_archivo_cv, prs_ci, prs_nombres, prs_paterno, prs_materno, prs_direccion, prs_direccion2, prs_telefono, prs_telefono2, prs_celular,prs_empresa_telefonica, prs_correo, prs_sexo, prs_fec_nacimiento, prs_usr_id, prs_estado, prs_linea_trabajo) 
VALUES (1, 0, 1, 'Roddwy', 'Miel', 'Miel', '', '', '', '', '', '', '', 'M', '2015-01-01', 1, 'A',3);




CREATE TABLE _bp_usuarios (
	usr_id serial PRIMARY KEY,
	usr_prs_id integer NOT NULL DEFAULT '1',
	usr_usuario text NOT NULL,
	usr_clave text NOT NULL,
	usr_controlar_ip char(1) NOT NULL DEFAULT 'S',
	usr_registrado timestamp NOT NULL DEFAULT now(),
	usr_modificado timestamp NOT NULL DEFAULT now(),
	usr_usr_id integer NOT NULL,
	usr_estado char(1) NOT NULL DEFAULT 'A',
	remember_token text,
    usr_linea_trabajo integer NULL,
    usr_planta_id integer NULL,
    --ZONA
    usr_zona_id integer NULL,
	FOREIGN KEY(usr_prs_id) REFERENCES _bp_personas(prs_id),
	--ZONA
	FOREIGN KEY(usr_zona_id) REFERENCES _bp_zonaS(zona_id)
);

INSERT INTO _bp_usuarios (usr_prs_id, usr_usuario, usr_clave, usr_controlar_ip, usr_usr_id, usr_estado, usr_linea_trabajo) 
VALUES ( 1, 'rortiz', '$2y$10$fhqENLSXN5TLXW4wHx3sy.Lw4Ns331BElTk2zJUGw21d0mmaIQJGG', 'N', 1, 'A', 1);
INSERT INTO _bp_usuarios (usr_prs_id, usr_usuario, usr_clave, usr_controlar_ip, usr_usr_id, usr_estado, usr_linea_trabajo)
VALUES ( 1, 'sandra', '$2y$10$fhqENLSXN5TLXW4wHx3sy.Lw4Ns331BElTk2zJUGw21d0mmaIQJGG', 'N', 1, 'A', 2);
INSERT INTO _bp_usuarios (usr_prs_id, usr_usuario, usr_clave, usr_controlar_ip, usr_usr_id, usr_estado, usr_linea_trabajo)
VALUES ( 1, 'roddwy', '$2y$10$fhqENLSXN5TLXW4wHx3sy.Lw4Ns331BElTk2zJUGw21d0mmaIQJGG', 'N', 1, 'A', 3);



CREATE TABLE _bp_roles(
	rls_id serial PRIMARY KEY,
	rls_rol text NOT NULL,
	rls_registrado timestamp NOT NULL DEFAULT now(),
	rls_modificado timestamp NOT NULL DEFAULT now(),
	rls_usr_id integer NOT NULL,
	rls_estado char(1) NOT NULL DEFAULT 'A',
    rls_linea_trabajo integer NULL
);

INSERT INTO _bp_roles (rls_rol, rls_usr_id, rls_estado, rls_linea_trabajo) 
VALUES ('Administrador', 1, 'A',NULL);
INSERT INTO _bp_roles (rls_rol, rls_usr_id, rls_estado, rls_linea_trabajo) 
VALUES ('Comprador', 1, 'A', 1);
INSERT INTO _bp_roles (rls_rol, rls_usr_id, rls_estado, rls_linea_trabajo) 
VALUES ('Tesorero', 1, 'A', 1);
INSERT INTO _bp_roles (rls_rol, rls_usr_id, rls_estado, rls_linea_trabajo) 
VALUES ('Recepcionista', 1, 'A', 2);
INSERT INTO _bp_roles (rls_rol, rls_usr_id, rls_estado, rls_linea_trabajo) 
VALUES ('Laboratorio', 1, 'A', 2);
INSERT INTO _bp_roles (rls_rol, rls_usr_id, rls_estado, rls_linea_trabajo) 
VALUES ('Acopiador', 1, 'A', 3);




CREATE TABLE _bp_grupos(
	grp_id serial PRIMARY KEY,
	grp_grupo text NOT NULL,
	grp_imagen text DEFAULT '',
	grp_registrado timestamp NOT NULL DEFAULT now(),
	grp_modificado timestamp NOT NULL DEFAULT now(),
	grp_usr_id integer NOT NULL,
	grp_estado char(1) NOT NULL DEFAULT 'A'

);


INSERT INTO _bp_grupos (grp_grupo, grp_imagen, grp_usr_id, grp_estado) VALUES ('ADMINISTRADOR', 'fa fa-cogs', 1, 'A');
INSERT INTO _bp_grupos (grp_grupo, grp_imagen, grp_usr_id, grp_estado) VALUES ('ACOPIO', 'fa fa-files-o', 1, 'A');
INSERT INTO _bp_grupos (grp_grupo, grp_imagen, grp_usr_id, grp_estado) VALUES ('ALMACEN', 'fa fa-edit', 1, 'A');
INSERT INTO _bp_grupos (grp_grupo, grp_imagen, grp_usr_id, grp_estado) VALUES ('PRODUCCION', 'fa fa-user-circle-o ', 1, 'A');

CREATE TABLE _bp_opciones(
	opc_id serial PRIMARY KEY,
	opc_grp_id integer NOT NULL,
	opc_opcion text NOT NULL,
	opc_contenido text DEFAULT '',
	opc_adicional text DEFAULT '',
	opc_orden integer,
	opc_imagen text DEFAULT '',
	opc_registrado timestamp NOT NULL DEFAULT now(),
	opc_modificado timestamp NOT NULL DEFAULT now(),
	opc_usr_id integer NOT NULL,
	opc_estado char(1) NOT NULL DEFAULT 'A',
	FOREIGN KEY(opc_grp_id) REFERENCES _bp_grupos(grp_id)
);

INSERT INTO _bp_opciones (opc_grp_id, opc_opcion, opc_contenido, opc_adicional, opc_orden, opc_imagen, opc_usr_id, opc_estado) VALUES (1, 'Personas', 'Persona', '', 20, '', 1, 'A');
INSERT INTO _bp_opciones (opc_grp_id, opc_opcion, opc_contenido, opc_adicional, opc_orden, opc_imagen, opc_usr_id, opc_estado) VALUES (1, 'Usuarios', 'Usuario', '', 30, '', 1, 'A');
INSERT INTO _bp_opciones (opc_grp_id, opc_opcion, opc_contenido, opc_adicional, opc_orden, opc_imagen, opc_usr_id, opc_estado) VALUES (1, 'Roles', 'Rol', '', 30, '', 1, 'A');
INSERT INTO _bp_opciones (opc_grp_id, opc_opcion, opc_contenido, opc_adicional, opc_orden, opc_imagen, opc_usr_id, opc_estado) VALUES (1, 'UsuariosRoles', 'RolUsuario', '', 30, '', 1, 'A');
INSERT INTO _bp_opciones (opc_grp_id, opc_opcion, opc_contenido, opc_adicional, opc_orden, opc_imagen, opc_usr_id, opc_estado) VALUES (1, 'Grupos', 'Grupo', '', 30, '', 1, 'A');
INSERT INTO _bp_opciones (opc_grp_id, opc_opcion, opc_contenido, opc_adicional, opc_orden, opc_imagen, opc_usr_id, opc_estado) VALUES (1, 'Opciones', 'Opcion', '', 30, '', 1, 'A');
INSERT INTO _bp_opciones (opc_grp_id, opc_opcion, opc_contenido, opc_adicional, opc_orden, opc_imagen, opc_usr_id, opc_estado) VALUES (1, 'Accesos', 'Asignacion', '', 30, '', 1, 'A');                    
INSERT INTO _bp_opciones (opc_grp_id, opc_opcion, opc_contenido, opc_adicional, opc_orden, opc_imagen, opc_usr_id, opc_estado) VALUES (2, 'ALMENDRA', 'AcopioAlmendraMenu', '', 10, '', 1, 'A');
INSERT INTO _bp_opciones (opc_grp_id, opc_opcion, opc_contenido, opc_adicional, opc_orden, opc_imagen, opc_usr_id, opc_estado) VALUES (2, 'LACTEOS', 'acopio_lacteos', '', 10, '', 1, 'A');
INSERT INTO _bp_opciones (opc_grp_id, opc_opcion, opc_contenido, opc_adicional, opc_orden, opc_imagen, opc_usr_id, opc_estado) VALUES (2, 'MIEL', 'AcopioMielMenu', '', 10, '', 1, 'A');
INSERT INTO _bp_opciones (opc_grp_id, opc_opcion, opc_contenido, opc_adicional, opc_orden, opc_imagen, opc_usr_id, opc_estado) VALUES (3, 'Registro Medico', 'Usuario', '', 10, '', 1, 'A');
INSERT INTO _bp_opciones (opc_grp_id, opc_opcion, opc_contenido, opc_adicional, opc_orden, opc_imagen, opc_usr_id, opc_estado) VALUES (4, 'Log Seguimiento', 'Seguimiento', '', 10, '', 1, 'A');

CREATE TABLE _bp_accesos(
	acc_id serial PRIMARY KEY,
	acc_opc_id integer NOT NULL,
	acc_rls_id integer NOT NULL,
	acc_registrado timestamp NOT NULL DEFAULT now(),
	acc_modificado timestamp NOT NULL DEFAULT now(),
	acc_usr_id integer NOT NULL,
	acc_estado char(1) NOT NULL DEFAULT 'A',
	FOREIGN KEY(acc_opc_id) REFERENCES _bp_opciones(opc_id),
	FOREIGN KEY(acc_rls_id) REFERENCES _bp_roles(rls_id)
);

INSERT INTO _bp_accesos (acc_opc_id, acc_rls_id, acc_usr_id, acc_estado) VALUES (1, 1, 1, 'A');
INSERT INTO _bp_accesos (acc_opc_id, acc_rls_id, acc_usr_id, acc_estado) VALUES (2, 1, 1, 'A');
INSERT INTO _bp_accesos (acc_opc_id, acc_rls_id, acc_usr_id, acc_estado) VALUES (3, 1, 1, 'A');
INSERT INTO _bp_accesos (acc_opc_id, acc_rls_id, acc_usr_id, acc_estado) VALUES (4, 1, 1, 'A');
INSERT INTO _bp_accesos (acc_opc_id, acc_rls_id, acc_usr_id, acc_estado) VALUES (5, 1, 1, 'A');
INSERT INTO _bp_accesos (acc_opc_id, acc_rls_id, acc_usr_id, acc_estado) VALUES (6, 1, 1, 'A');
INSERT INTO _bp_accesos (acc_opc_id, acc_rls_id, acc_usr_id, acc_estado) VALUES (8, 1, 1, 'A');
INSERT INTO _bp_accesos (acc_opc_id, acc_rls_id, acc_usr_id, acc_estado) VALUES (9, 1, 1, 'A');
INSERT INTO _bp_accesos (acc_opc_id, acc_rls_id, acc_usr_id, acc_estado) VALUES (10, 1, 1, 'A');




CREATE TABLE _bp_usuarios_roles (
	usrls_id serial PRIMARY KEY,
	usrls_usr_id integer NOT NULL,
	usrls_rls_id integer NOT NULL,
	usrls_registrado timestamp NOT NULL DEFAULT now(),
	usrls_modificado timestamp NOT NULL DEFAULT now(),
	usrls_usuarios_usr_id integer NOT NULL,
	usrls_estado char(1) NOT NULL DEFAULT 'A',
	FOREIGN KEY(usrls_usr_id) REFERENCES _bp_usuarios(usr_id),
	FOREIGN KEY(usrls_rls_id) REFERENCES _bp_roles(rls_id)
);


INSERT INTO _bp_usuarios_roles (usrls_usr_id, usrls_rls_id, usrls_usuarios_usr_id, usrls_estado) VALUES (1, 1, 1, 'A');
INSERT INTO _bp_usuarios_roles (usrls_usr_id, usrls_rls_id, usrls_usuarios_usr_id, usrls_estado) VALUES (2, 1, 1, 'A');
INSERT INTO _bp_usuarios_roles (usrls_usr_id, usrls_rls_id, usrls_usuarios_usr_id, usrls_estado) VALUES (3, 1, 1, 'A');


CREATE TABLE _bp_log_seguimiento(
	log_id serial PRIMARY KEY,
	log_usr_id integer NOT NULL,
	log_metodo text,
	log_accion text NOT NULL,
	log_detalle text,
	log_modulo text NOT NULL,
	log_consulta text NOT NULL,
	log_registrado timestamp NOT NULL DEFAULT now(),
	log_modificado timestamp NOT NULL DEFAULT now(),
	FOREIGN KEY (log_usr_id) REFERENCES _bp_usuarios (usr_id)
);

CREATE TABLE _bp_planta(
    id_planta serial PRIMARY KEY,
    nombre_planta text NULL,
    id_linea_trabajo integer null
);
	

CREATE OR REPLACE FUNCTION "public"."sp_lst_catalogo"()
  RETURNS TABLE("id_ctp" int4, "descripcion" varchar) AS $BODY$
  BEGIN
    RETURN QUERY 
      select ctp_id, ctp_descripcion
      from s_catalogo
      where ctp_estado = 'A' order by ctp_id asc;
      
  END;
  $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;

CREATE OR REPLACE FUNCTION "public"."autenticacion"("usrid" text, "usuario" text)
  RETURNS TABLE("idusr" int4, "usr" text, "nombre" text, "paterno" text, "materno" text, "idrl" int4, "rol" text, "vci" text, "vprs_id" int4) AS $BODY$
BEGIN
    RETURN QUERY SELECT usr_id,usr_usuario,prs_nombres,prs_paterno,prs_materno,rls_id,rls_rol,prs_ci,prs_id
     FROM _bp_usuarios
     INNER JOIN _bp_personas ON  prs_id=usr_prs_id  and prs_estado='A'
     INNER JOIN _bp_usuarios_roles ON usrls_usr_id=usr_id  and usrls_estado='A'
     INNER  JOIN _bp_roles ON usrls_rls_id=rls_id and rls_estado='A'
     where usr_usuario=usrId  AND usr_clave=usuario AND usr_estado='A' ORDER BY usrls_registrado DESC ;

END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;



CREATE OR REPLACE FUNCTION "public"."sp_obtiene_usuario"("usrid" int4)
  RETURNS TABLE("vrls_id" int4, "vrls_rol" text, "vusr_usuario" text, "vprs_nombres" text, "vprs_paterno" text, "vprs_materno" text, "vprs_id" int4) AS $BODY$
BEGIN
  RETURN QUERY select rls_id,rls_rol,usr_usuario,prs_nombres ,prs_paterno ,prs_materno ,prs_id
  from _bp_usuarios_roles
  inner join _bp_roles as r on r.rls_id= usrls_rls_id and usrls_estado='A' AND r.rls_estado='A'
  inner join _bp_usuarios as u on u.usr_id=usrls_usr_id AND usr_estado<> 'B'
  inner join _bp_personas as p on p.prs_id=u.usr_prs_id AND prs_estado='A'
  where usrls_usr_id=usrid;

END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;




CREATE TABLE _bp_departamento
(
  dpto_id serial PRIMARY KEY,
  dpto_pais_id integer NOT NULL,
  dpto_departamento text NOT NULL,
  dpto_codigo text NOT NULL,
  dpto_registrado timestamp without time zone NOT NULL DEFAULT now(),
  dpto_modificado timestamp without time zone NOT NULL DEFAULT now(),
  dpto_usr_id integer NOT NULL,
  dpto_estado character(1) NOT NULL DEFAULT 'A'::bpchar)
WITH (
  OIDS=FALSE
);

INSERT INTO _bp_departamento (dpto_pais_id, dpto_departamento, dpto_codigo,dpto_registrado,dpto_modificado,dpto_usr_id,dpto_estado) VALUES 
(1,'La Paz','LPZ','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Chuquisaca','CHQ','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Cochabamba     ','CBB','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Oruro          ','ORU','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Potosí         ','PTS','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Tarija         ','TJA','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Santa Cruz     ','SCZ','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Beni           ','BNI','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Pando          ','PND','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Exterior','10','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'B');

CREATE TABLE _bp_provincias
(
  prv_id serial PRIMARY KEY,
  prv_dpto_id integer NOT NULL,
  prv_provincia text NOT NULL,
  prv_codigo text NOT NULL,
  prv_dpto_codigo text NOT NULL,
  prv_codigo_compuesto text NOT NULL,
  prv_registrado timestamp without time zone NOT NULL DEFAULT now(),
  prv_modificado timestamp without time zone NOT NULL DEFAULT now(),
  prv_usr_id integer NOT NULL,
  prv_estado character(1) NOT NULL DEFAULT 'A'::bpchar)
WITH (
  OIDS=FALSE
);

INSERT INTO _bp_provincias (prv_dpto_id, prv_provincia,prv_codigo, prv_dpto_codigo,prv_codigo_compuesto,prv_registrado,prv_modificado,prv_usr_id,prv_estado) VALUES 
(1,'Murillo','1','LPZ','201','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Abel Iturralde','15','LPZ','215','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Aroma','13','LPZ','213','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Bautista Saavedra','16','LPZ','216','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Camacho','4','LPZ','204','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Caranavi','20','LPZ','220','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Franz Tamayo','7','LPZ','207','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Gral. Jose Manuel Pando','19','LPZ','219','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Gualberto Villarroel','18','LPZ','218','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Ingavi','8','LPZ','208','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Inquisivi','10','LPZ','210','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Larecaja','6','LPZ','206','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Loayza','9','LPZ','209','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Los Andes','12','LPZ','212','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Manco Kapac','17','LPZ','217','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Muñecas','5','LPZ','205','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Nor Yungas','14','LPZ','214','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Omasuyos','2','LPZ','202','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Pacajes','3','LPZ','203','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(1,'Sud Yungas','11','LPZ','211','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(2,'Azurduy','2','CHQ','102','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(2,'B. Boeto','8','CHQ','108','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(2,'Hernando Siles','5','CHQ','105','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(2,'Luis Calvo','10','CHQ','110','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(2,'Nor Cinti','7','CHQ','107','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(2,'Oropeza','1','CHQ','101','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(2,'Sud Cinti','9','CHQ','109','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(2,'Tomina','4','CHQ','104','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(2,'Yamparaez','6','CHQ','106','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(2,'Zudañez','3','CHQ','103','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(3,'Arani','5','CBB','305','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(3,'Arque','6','CBB','306','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(3,'Ayopaya','3','CBB','303','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(3,'Bolivar','15','CBB','315','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(3,'Campero','2','CBB','302','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(3,'Capinota','7','CBB','307','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(3,'Carrasco','12','CBB','312','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(3,'Cercado','1','CBB','301','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(3,'Chapare','10','CBB','310','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(3,'Esteban Arze','4','CBB','304','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(3,'German Jordan','8','CBB','308','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(3,'Mizque','13','CBB','313','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(3,'Punata','14','CBB','314','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(3,'Quillacollo','9','CBB','309','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(3,'Tapacari','11','CBB','311','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(3,'Tiraque','16','CBB','316','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(4,'Avaroa','2','ORU','402','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(4,'Carangas','3','ORU','403','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(4,'Cercado','1','ORU','401','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(4,'Ladislao Cabrera','8','ORU','408','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(4,'Litoral','5','ORU','405','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(4,'Mejillones','15','ORU','415','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(4,'Nor Carangas','16','ORU','416','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(4,'Pantaleon Dalence','7','ORU','407','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(4,'Poopó','6','ORU','406','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(4,'Sabaya','9','ORU','409','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(4,'Sajama','4','ORU','404','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(4,'San Pedro de Totora','13','ORU','413','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(4,'Saucari','10','ORU','410','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(4,'Sebastian Pagador','14','ORU','414','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(4,'Sud Carangas','12','ORU','412','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(4,'Tomas Barron','11','ORU','411','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(5,'Alonzo de Ibañez','7','PTS','507','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(5,'Antonio Quijarro','12','PTS','512','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(5,'Charcas','5','PTS','505','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(5,'Chayanta','4','PTS','504','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(5,'Cornelio Saavedra','3','PTS','503','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(5,'Daniel Campos','14','PTS','514','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(5,'Enrique Baldivieso','16','PTS','516','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(5,'Gral.B.Bilbao','13','PTS','513','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(5,'Jose Maria Linares','11','PTS','511','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(5,'Modesto Omiste','15','PTS','515','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(5,'Nor Chichas','6','PTS','506','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(5,'Nor Lipez','9','PTS','509','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(5,'Rafael Bustillo','2','PTS','502','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(5,'Sud Chichas','8','PTS','508','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(5,'Sud Lipez','10','PTS','510','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(5,'Tomas Frias','1','PTS','501','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(6,'Arce','2','TJA','602','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(6,'Aviles','4','TJA','604','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(6,'Cercado','1','TJA','601','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(6,'Gran Chaco','3','TJA','603','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(6,'Mendez','5','TJA','605','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(6,'O Connor','6','TJA','606','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(7,'Andres Ibañez','1','SCZ','701','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(7,'Angel Sandoval','12','SCZ','712','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(7,'Chiquitos','5','SCZ','705','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(7,'Cordillera','7','SCZ','707','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(7,'Florida','9','SCZ','709','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(7,'German Busch','14','SCZ','714','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(7,'Guarayos','15','SCZ','715','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(7,'Ichilo','4','SCZ','704','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(7,'Manuel Maria Caballero','13','SCZ','713','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(7,'Ñuflo de Chavez','11','SCZ','711','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(7,'Obispo Santistevan','10','SCZ','710','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(7,'Sara','6','SCZ','706','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(7,'Vallegrande','8','SCZ','708','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(7,'Velasco','3','SCZ','703','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(7,'Warnes','2','SCZ','702','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(8,'Cercado','1','BNI','801','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(8,'Gral. J. Ballivian','3','BNI','803','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(8,'Iténez','8','BNI','808','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(8,'Mamore','7','BNI','807','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(8,'Marban','6','BNI','806','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(8,'Moxos','5','BNI','805','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(8,'Vaca Diez','2','BNI','802','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(8,'Yacuma','4','BNI','804','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(9,'Abuna','4','PND','904','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(9,'Gral. Federico Roman','5','PND','905','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(9,'Madre de Dios','3','PND','903','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(9,'Manuripi','2','PND','902','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A'),
(9,'Nicolas Suarez','1','PND','901','2016-05-30 00:00:00','2016-05-30 00:00:00',1,'A');



CREATE TABLE _bp_municipios
(
  mnc_id serial PRIMARY KEY,
  mnc_prv_id integer NOT NULL,
  mnc_municipio text NOT NULL,
  mnc_codigo text NOT NULL,
  mnc_codigo_compuesto text NOT NULL,
  mnc_codigo_compuesto_prov text NOT NULL,
  mnc_registrado timestamp without time zone NOT NULL DEFAULT now(),
  mnc_modificado timestamp without time zone NOT NULL DEFAULT now(),
  mnc_usr_id integer NOT NULL,
  mnc_estado character(1) NOT NULL DEFAULT 'A'::bpchar)
WITH (
  OIDS=FALSE
);

INSERT INTO _bp_municipios (mnc_id, mnc_prv_id, mnc_municipio,mnc_codigo,mnc_codigo_compuesto,mnc_codigo_compuesto_prov,mnc_usr_id) VALUES 
(1,1,'LA PAZ',1,20101,201,1),
(2,1,'PALCA',2,20102,201,1),
(3,1,'MECAPACA',3,20103,201,1),
(4,1,'ACHOCALLA',4,20104,201,1),
(5,1,'EL ALTO',5,20105,201,1),
(6,18,'ACHACACHI',1,20201,202,1),
(7,18,'ANCORAIMES',2,20202,202,1),
(8,18,'CHUA COCANI',3,20203,202,1),
(9,18,',HUARINA',4,20204,202,1),
(10,18,'SANTIAGO DE HUATA',5,20205,202,1),
(11,18,'HUATAJATA',6,20206,202,1),
(12,19,'CORO CORO',1,20301,203,1),
(13,19,'CAQUIAVIRI',2,20302,203,1),
(14,19,'CALACOTO',3,20303,203,1),
(15,19,'COMANCHE',4,20304,203,1),
(16,19,'CHARAÑA',5,20305,203,1),
(17,19,'WALDO BALLIVIAN',6,20306,203,1),
(18,19,'NAZACARA DE PACAJES',7,20307,203,1),
(19,19,'SANTIAGO DE CALLAPA',8,20308,203,1),
(20,5,'PUERTO ACOSTA',1,20401,204,1),
(21,5,'MOCOMOCO',2,20402,204,1),
(22,5,'PUERTO CARABUCO',3,20403,204,1),
(23,5,'HUMANATA',4,20404,204,1),
(24,5,'ESCOMA',5,20405,204,1),
(25,16,'CHUMA',1,20501,205,1),
(26,16,'AYATA',2,20502,205,1),
(27,16,'AUCAPATA',3,20503,205,1),
(28,12,'SORATA',1,20601,206,1),
(29,12,'GUANAY',2,20602,206,1),
(30,12,'TACACOMA',3,20603,206,1),
(31,12,'QUIABAYA',4,20604,206,1),
(32,12,'COMBAYA',5,20605,206,1),
(33,12,'TIPUANI',6,20606,206,1),
(34,12,'MAPIRI',7,20607,206,1),
(35,12,'TEOPONTE',8,20608,206,1),
(36,7,'APOLO',1,20701,207,1),
(37,7,'PELECHUCO',2,20702,207,1),
(38,10,'VIACHA',1,20801,208,1),
(39,10,'GUAQUI',2,20802,208,1),
(40,10,'TIAHUANACU',3,20803,208,1),
(41,10,'DESAGUADERO',4,20804,208,1),
(42,10,'SAN ANDRES DE MACHACA',5,20805,208,1),
(43,10,'JESÚS DE MACHAKA',6,20806,208,1),
(44,10,'TARACO',7,20807,208,1),
(45,13,'LURIBAY',1,20901,209,1),
(46,13,'SAPAHAQUI',2,20902,209,1),
(47,13,'YACO',3,20903,209,1),
(48,13,'MALLA',4,20904,209,1),
(49,13,'CAIROMA',5,20905,209,1),
(50,11,'INQUISIVI',1,21001,210,1),
(51,11,'QUIME',2,21002,210,1),
(52,11,'CAJUATA',3,21003,210,1),
(53,11,'COLQUIRI',4,21004,210,1),
(54,11,'ICHOCA',5,21005,210,1),
(55,11,'LICOMA PAMPA',6,21006,210,1),
(56,20,'CHULUMANI',1,21101,211,1),
(57,20,'IRUPANA',2,21102,211,1),
(58,20,'YANACACHI',3,21103,211,1),
(59,20,'PALOS BLANCOS',4,21104,211,1),
(60,20,'LA ASUNTA',5,21105,211,1),
(61,14,'PUCARANI',1,21201,212,1),
(62,14,'LAJA',2,21202,212,1),
(63,14,'BATALLAS',3,21203,212,1),
(64,14,'PUERTO PEREZ',4,21204,212,1),
(65,3,'SICA SICA',1,21301,213,1),
(66,3,'UMALA',2,21302,213,1),
(67,3,'AYO AYO',3,21303,213,1),
(68,3,'CALAMARCA',4,21304,213,1),
(69,3,'PATACAMAYA',5,21305,213,1),
(70,3,'COLQUENCHA',6,21306,213,1),
(71,3,'COLLANA',7,21307,213,1),
(72,17,'COROICO',1,21401,214,1),
(73,17,'CORIPATA',2,21402,214,1),
(74,2,'IXIAMAS',1,21501,215,1),
(75,2,'SAN BUENAVENTURA',2,21502,215,1),
(76,4,'CHARAZANI',1,21601,216,1),
(77,4,'CURVA',2,21602,216,1),
(78,15,'COPACABANA',1,21701,217,1),
(79,15,'SAN PEDRO DE TIQUINA',2,21702,217,1),
(80,15,'TITO YUPANQUI',3,21703,217,1),
(81,9,'SAN PEDRO DE CURAHUARA',1,21801,218,1),
(82,9,'PAPEL PAMPA',2,21802,218,1),
(83,9,'CHACARILLA',3,21803,218,1),
(84,8,'SANTIAGO DE MACHACA',1,21901,219,1),
(85,8,'CATACORA',2,21902,219,1),
(86,6,'CARANAVI',1,22001,220,1),
(87,6,'ALTO BENI',2,22002,220,1),
(88,26,'SUCRE',1,10101,101,1),
(89,26,'YOTALA',2,10102,101,1),
(90,26,'POROMA',3,10103,101,1),
(91,21,'VILLA AZURDUY',1,10201,102,1),
(92,21,'TARVITA',2,10202,102,1),
(93,30,'VILLA ZUDAÑEZ',1,10301,103,1),
(94,30,'PRESTO',2,10302,103,1),
(95,30,'VILLA MOJOCOYA',3,10303,103,1),
(96,30,'ICLA',4,10304,103,1),
(97,28,'PADILLA',1,10401,104,1),
(98,28,'TOMINA',2,10402,104,1),
(99,28,'SOPACHUY',3,10403,104,1),
(100,28,'VILLA ALCALA',4,10404,104,1),
(101,28,'EL VILLAR',5,10405,104,1),
(102,23,'MONTEAGUDO',1,10501,105,1),
(103,23,'HUACARETA',2,10502,105,1),
(104,29,'TARABUCO',1,10601,106,1),
(105,29,'YAMPARAEZ',2,10602,106,1),
(106,25,'CAMARGO',1,10701,107,1),
(107,25,'SAN LUCAS',2,10702,107,1),
(108,25,'INCAHUASI',3,10703,107,1),
(109,25,'VILLA CHARCAS',4,10704,107,1),
(110,22,'VILLA SERRANO',1,10801,108,1),
(111,27,'CAMATAQUI (VILLA ABEC)',1,10901,109,1),
(112,27,'CULPINA',2,10902,109,1),
(113,27,'LAS CARRERAS',3,10903,109,1),
(114,24,'VILLA VACA GUZMAN (MUYUPAM)',1,11001,110,1),
(115,24,'HUACAYA',2,11002,110,1),
(116,24,'MACHARETI',3,11003,110,1),
(117,38,'COCHABAMBA',1,30101,301,1),
(118,35,'AIQUILE',1,30201,302,1),
(119,35,'PASORAPA',2,30202,302,1),
(120,35,'OMEREQUE',3,30203,302,1),
(121,33,'INDEPENDENCIA',1,30301,303,1),
(122,33,'MOROCHATA',2,30302,303,1),
(123,33,'COCAPATA',3,30303,303,1),
(124,40,'TARATA',1,30401,304,1),
(125,40,'ANZALDO',2,30402,304,1),
(126,40,'ARBIETO',3,30403,304,1),
(127,40,'SACABAMBA',4,30404,304,1),
(128,31,'ARANI',1,30501,305,1),
(129,31,'VACAS',2,30502,305,1),
(130,32,'ARQUE',1,30601,306,1),
(131,32,'TACOPAYA',2,30602,306,1),
(132,36,'CAPINOTA',1,30701,307,1),
(133,36,'SANTIVAÑEZ',2,30702,307,1),
(134,36,'SICAYA',3,30703,307,1),
(135,41,'CLIZA',1,30801,308,1),
(136,41,'TOCO',2,30802,308,1),
(137,41,'TOLATA',3,30803,308,1),
(138,44,'QUILLACOLLO',1,30901,309,1),
(139,44,'SIPE SIPE',2,30902,309,1),
(140,44,'TIQUIPAYA',3,30903,309,1),
(141,44,'VINTO',4,30904,309,1),
(142,44,'COLCAPIRHUA',5,30905,309,1),
(143,39,'SACABA',1,31001,310,1),
(144,39,'COLOMI',2,31002,310,1),
(145,39,'VILLA TUNARI',3,31003,310,1),
(146,45,'TAPACARI',1,31101,311,1),
(147,37,'TOTORA',1,31201,312,1),
(148,37,'POJO',2,31202,312,1),
(149,37,'POCONA',3,31203,312,1),
(150,37,'CHIMORE',4,31204,312,1),
(151,37,'PUERTO VILLARROEL',5,31205,312,1),
(152,37,'ENTRE RIOS',6,31206,312,1),
(153,42,'MIZQUE',1,31301,313,1),
(154,42,'VILA VILA',2,31302,313,1),
(155,42,'ALALAY',3,31303,313,1),
(156,43,'PUNATA',1,31401,314,1),
(157,43,'VILLA RIVERO',2,31402,314,1),
(158,43,'VILLA QUINTIN MENDOZA (SAN BENITO)',3,31403,314,1),
(159,43,'TACACHI',4,31404,314,1),
(160,43,'VILLA GUALBERTO VILLARROEL (CUCHUMUE)',5,31405,314,1),
(161,34,'BOLIVAR',1,31501,315,1),
(162,46,'TIRAQUE',1,31601,316,1),
(163,46,'SHINAHOTA',2,31602,316,1),
(164,49,'ORURO',1,40101,401,1),
(165,49,'CARACOLLO',2,40102,401,1),
(166,49,'EL CHORO',3,40103,401,1),
(167,49,'SORACACHI',4,40104,401,1),
(168,47,'CHALLAPATA',1,40201,402,1),
(169,47,'SANTUARIO DE QUILLACAS',2,40202,402,1),
(170,48,'CORQUE',1,40301,403,1),
(171,48,'CHOQUECOTA',2,40302,403,1),
(172,57,'CURAHUARA DE CARANGAS',1,40401,404,1),
(173,57,'TURCO',2,40402,404,1),
(174,51,'HUACHACALLA',1,40501,405,1),
(175,51,'ESCARA',2,40502,405,1),
(176,51,'CRUZ DE MACHACAMARCA',3,40503,405,1),
(177,51,'YUNGUYO DEL LITORAL',4,40504,405,1),
(178,51,'ESMERALDA',5,40505,405,1),
(179,55,'VILLA POOPO',1,40601,406,1),
(180,55,'PAZÑA',2,40602,406,1),
(181,55,'ANTEQUERA',3,40603,406,1),
(182,54,'HUANUNI',1,40701,407,1),
(183,54,'MACHACAMARCA',2,40702,407,1),
(184,50,'SALINAS DE GARCI MENDOZA',1,40801,408,1),
(185,50,'PAMPA AULLAGAS',2,40802,408,1),
(186,56,'SABAYA',1,40901,409,1),
(187,56,'COIPASA',2,40902,409,1),
(188,56,'CHIPAYA',3,40903,409,1),
(189,59,'TOLEDO',1,41001,410,1),
(190,62,'EUCALIPTUS',1,41101,411,1),
(191,61,'ANDAMARCA',1,41201,412,1),
(192,61,'BELÉN DE ANDAMARCA',2,41202,412,1),
(193,58,'TOTORA',1,41301,413,1),
(194,60,'SANTIAGO DE HUARI',1,41401,414,1),
(195,52,'LA RIVERA',1,41501,415,1),
(196,52,'TODOS SANTOS',2,41502,415,1),
(197,52,'CARANGAS',3,41503,415,1),
(198,53,'SANTIAGO DE HUAYLLAMARCA',1,41601,416,1),
(199,78,'POTOSÍ',1,50101,501,1),
(200,78,'TINGUIPAYA',2,50102,501,1),
(201,78,'YOCALLA',3,50103,501,1),
(202,78,'URMIRI',4,50104,501,1),
(203,75,'UNCIA',1,50201,502,1),
(204,75,'CHAYANTA',2,50202,502,1),
(205,75,'LLALLAGUA',3,50203,502,1),
(206,75,'CHUQUIHUTA AYLLU JUCUMANI',4,50204,502,1),
(207,67,'BETANZOS',1,50301,503,1),
(208,67,'CHAQUI',2,50302,503,1),
(209,67,'TACOBAMBA',3,50303,503,1),
(210,66,'COLQUECHACA',1,50401,504,1),
(211,66,'RAVELO',2,50402,504,1),
(212,66,'POCOATA',3,50403,504,1),
(213,66,'OCURI',4,50404,504,1),
(214,65,'SAN PEDRO DE BUENA VISTA',1,50501,505,1),
(215,65,'TORO TORO',2,50502,505,1),
(216,73,'COTAGAITA',1,50601,506,1),
(217,73,'VITICHI',2,50602,506,1),
(218,63,'SACACA',1,50701,507,1),
(219,63,'CARIPUYO',2,50702,507,1),
(220,76,'TUPIZA',1,50801,508,1),
(221,76,'ATOCHA',2,50802,508,1),
(222,74,'COLCHA K',1,50901,509,1),
(223,74,'SAN PEDRO DE QUEMES',2,50902,509,1),
(224,77,'SAN PABLO DE LIPEZ',1,51001,510,1),
(225,77,'MOJINETE',2,51002,510,1),
(226,77,'SAN ANTONIO DE ESMORUCO',3,51003,510,1),
(227,71,'PUNA(C.VILLA TALAVE)',1,51101,511,1),
(228,71,'CAIZA D',2,51102,511,1),
(229,71,'CKOCHAS',3,51103,511,1),
(230,64,'UYUNI',1,51201,512,1),
(231,64,'TOMAVE',2,51202,512,1),
(232,64,'PORCO',3,51203,512,1),
(233,70,'ARAMPAMPA',1,51301,513,1),
(234,70,'ACASIO',2,51302,513,1),
(235,68,'LLICA',1,51401,514,1),
(236,68,'TAHUA',2,51402,514,1),
(237,72,'VILLAZÓN',1,51501,515,1),
(238,69,'SAN AGUSTIN',1,51601,516,1),
(239,81,'TARIJA',1,60101,601,1),
(240,79,'PADCAYA',1,60201,602,1),
(241,79,'BERMEJO',2,60202,602,1),
(242,82,'YACUIBA',1,60301,603,1),
(243,82,'CARAPARI',2,60302,603,1),
(244,82,'VILLA MONTES',3,60303,603,1),
(245,80,'CONCEPCIÓN (URIONDO)',1,60401,604,1),
(246,80,'YUNCHARA',2,60402,604,1),
(247,83,'SAN LORENZO',1,60501,605,1),
(248,83,'EL PUENTE',2,60502,605,1),
(249,84,'ENTRE RIOS',1,60601,606,1),
(250,85,'SANTA CRUZ DE LA SIERRA',1,70101,701,1),
(251,85,'COTOCA',2,70102,701,1),
(252,85,'PORONGO',3,70103,701,1),
(253,85,'LA GUARDIA',4,70104,701,1),
(254,85,'EL TORNO',5,70105,701,1),
(255,99,'WARNES',1,70201,702,1),
(256,99,'OKINAWA' ,1,70202,702,1),
(257,98,'SAN IGNACIO',1,70301,703,1),
(258,98,'SAN MIGUEL',2,70302,703,1),
(259,98,'SAN RAFAEL',3,70303,703,1),
(260,92,'BUENA VISTA',1,70401,704,1),
(261,92,'SAN CARLOS',2,70402,704,1),
(262,92,'YAPACANÍ',3,70403,704,1),
(263,92,'SAN JUAN DE YAPACANÍ',4,70404,704,1),
(264,87,'SAN JOSÉ',1,70501,705,1),
(265,87,'PAILÓN',2,70502,705,1),
(266,87,'ROBORÉ',3,70503,705,1),
(267,96,'PORTACHUELO',1,70601,706,1),
(268,96,'SANTA ROSA',2,70602,706,1),
(269,96,'LA BÉLGICA',3,70603,706,1),
(270,88,'LAGUNILLAS',1,70701,707,1),
(271,88,'CHARAGUA',2,70702,707,1),
(272,88,'CABEZAS',3,70703,707,1),
(273,88,'CUEVO',4,70704,707,1),
(274,88,'GUTIÉRREZ',5,70705,707,1),
(275,88,'CAMIRI',6,70706,707,1),
(276,88,'BOYUIBE',7,70707,707,1),
(277,97,'VALLEGRANDE',1,70801,708,1),
(278,97,'TRIGAL',2,70802,708,1),
(279,97,'MOROMORO',3,70803,708,1),
(280,97,'POSTRERVALLE',4,70804,708,1),
(281,97,'PUCARÁ',5,70805,708,1),
(282,89,'SAMAIPATA',1,70901,709,1),
(283,89,'PAMPAGRANDE',2,70902,709,1),
(284,89,'MAIRANA',3,70903,709,1),
(285,89,'QUIRUSILLAS',4,70904,709,1),
(286,95,'MONTERO',1,71001,710,1),
(287,95,'GENERAL SAAVEDRA',2,71002,710,1),
(288,95,'MINEROS',3,71003,710,1),
(289,95,'FERNÁNDEZ ALONZO',4,71004,710,1),
(290,95,'SAN PEDRO',5,71005,710,1),
(291,94,'CONCEPCIÓN',1,71101,711,1),
(292,94,'SAN JAVIER',2,71102,711,1),
(293,94,'SAN RAMÓN',3,71103,711,1),
(294,94,'SAN JULIAN',4,71104,711,1),
(295,94,'SAN ANTONIO DE LOMERIO',5,71105,711,1),
(296,94,'CUATRO CAÑADAS',6,71106,711,1),
(297,86,'SAN MATÍAS',1,71201,712,1),
(298,93,'COMARAPA',1,71301,713,1),
(299,93,'SAIPINA',2,71302,713,1),
(300,90,'PUERTO SUAREZ',1,71401,714,1),
(301,90,'QUIJARRO',2,71402,714,1),
(302,90,'EL CARMEN RIVERO TORREZ',3,71403,714,1),
(303,91,'ASCENCIÓN (GUARAYOS)',1,71501,715,1),
(304,91,'URUBICHÁ',2,71502,715,1),
(305,91,'EL PUENTE',3,71503,715,1),
(306,100,'TRINIDAD',1,80101,801,1),
(307,100,'SAN JAVIER',2,80102,801,1),
(308,106,'RIBERALTA',1,80201,802,1),
(309,106,'GUAYARAMERÍN',2,80202,802,1),
(310,101,'REYES',1,80301,803,1),
(311,101,'SAN BORJA',2,80302,803,1),
(312,101,'SANTA ROSA',3,80303,803,1),
(313,101,'RURRENABAQUE',4,80304,803,1),
(314,107,'SANTA ANA',1,80401,804,1),
(315,107,'EXALTACIÓN',2,80402,804,1),
(316,105,'SAN IGNACIO',1,80501,805,1),
(317,104,'LORETO',1,80601,806,1),
(318,104,'SAN ANDRÉS',2,80602,806,1),
(319,103,'SAN JOAQUÍN',1,80701,807,1),
(320,103,'SAN RAMÓN',2,80702,807,1),
(321,103,'PUERTO SILES',3,80703,807,1),
(322,102,'MAGDALENA',1,80801,808,1),
(323,102,'BAURES',2,80802,808,1),
(324,102,'HUACARAJE',3,80803,808,1),
(325,112,'COBIJA',1,90101,901,1),
(326,112,'PORVENIR',2,90102,901,1),
(327,112,'BOLPEBRA',3,90103,901,1),
(328,112,'BELLA FLOR',4,90104,901,1),
(329,111,'PUERTO RICO',1,90201,902,1),
(330,111,'SAN PEDRO',2,90202,902,1),
(331,111,'FILADELFIA',3,90203,902,1),
(332,110,'GONZALO MORENO',1,90301,903,1),
(333,110,'SAN LORENZO',2,90302,903,1),
(334,110,'EL SENA',3,90303,903,1),
(335,108,'SANTA ROSA DEL ABUNA',1,90401,904,1),
(336,108,'INGAVI',2,90402,904,1),
(337,109,'NUEVA ESPERANZA',1,90501,905,1),
(338,109,'VILLA NUEVA',2,90502,905,1),
(339,109,'SANTOS MERCADO',3,90503,905,1);
	
--TABLE ZONAS
CREATE TABLE _bp_zonas (
	zona_id serial PRIMARY KEY,
	zona_nombre text NOT NULL,
	zona_serie text NOT NULL,
	zona_estado char(1) NOT NULL DEFAULT 'A'
);
-- TABLA EVALUACIO SISTEMA
create table public.evaluacion_sistema(
    evalsis_id serial,
    evalsis_res_uno character(250),
    evalsis_res_dos character(250),
    evalsis_res_tres character(250),
    evalsis_puntuacion integer,
    evalsis_id_usuario integer,
    evalsis_id_sistema integer,
    evalsis_estado character(1) default 'B',
    evalsis_fecha_registro timestamp default now(),
    primary key (evalsis_id)
);							   