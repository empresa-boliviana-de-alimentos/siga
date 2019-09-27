CREATE TABLE producto_terminado.vehiculos
	(	veh_id serial PRIMARY KEY,
		veh_placa text  NOT NULL,
		veh_marca text,
		veh_modelo text,
		veh_tipo text NOT NULL,
		veh_chasis text NOT NULL,
		veh_roseta_soat text NOT NULL,
		veh_roseta_inspeccion text NOT NULL,
		veh_restriccion_transito text NOT NULL,
		veh_restriccion_municipio text NOT NULL,
		veh_usr_id integer NOT NULL,
		veh_registrado timestamp DEFAULT now(),
		veh_modificado timestamp DEFAULT now(),
		veh_estado text DEFAULT 'A'
	);

INSERT INTO producto_terminado.vehiculos(veh_placa,veh_marca,veh_modelo,veh_tipo,veh_chasis,veh_roseta_soat,veh_roseta_inspeccion,veh_restriccion_transito,veh_restriccion_municipio,veh_usr_id)
	 VALUES
	('AJG11','NIZAN','2013','vagoneta','EF9 - 1988-91 Civic Hatchback SiR','2017','si','viernes','',1),
	('B32S1','TOYOTA','2011','vagoneta','EF8 - 1988-91 Honda CR-X SiR','2017','si','lunes','',1),
	('RD567','TOYOTA','2014','camioneta','EG6- 1992-95 Civic Hatchback SiR','2017','si','miercoles','',1),
	('BLG12','KING LONG','2016','camnioneta','EK4 - 1996-00 Civic SiR Hatchback','2017','si','jueves','',1),
	('FGT67','KING LONG','2016','camnioneta','EK9 - 1996-00 Civic Type-R Hatchback','2017','si','martes','',1);	


CREATE TABLE producto_terminado.conductor (
	pcd_id serial PRIMARY KEY,
	pcd_id_estado_civil integer NOT NULL,
	pcd_ci text NOT NULL,
	pcd_nro_licencia text NOT NULL,
	pcd_categoria text NOT NULL,
	pcd_nombres text NOT NULL,
	pcd_paterno text NOT NULL,
	pcd_materno text NOT NULL,
	pcd_direccion text NOT NULL,
	pcd_telefono text DEFAULT '',
	pcd_celular text DEFAULT '',
	pcd_correo text DEFAULT '',
	pcd_sexo char(1) DEFAULT 'F',
	pcd_veh_id integer NOT NULL,
	pcd_fec_nacimiento date NOT NULL,
	pcd_registrado timestamp NOT NULL DEFAULT now(),
	pcd_modificado timestamp NOT NULL DEFAULT now(),
	pcd_usr_id integer NOT NULL,
	pcd_estado char(1) NOT NULL DEFAULT 'A',
	FOREIGN KEY(pcd_id_estado_civil) REFERENCES _bp_estados_civiles(estcivil_id),
	FOREIGN KEY(pcd_veh_id) REFERENCES producto_terminado.vehiculos(veh_id)
);

CREATE TABLE producto_terminado.destino (
	de_id serial PRIMARY KEY,
	de_nombre text NOT NULL,
	de_codigo text,
	de_mercado text NOT NULL,
	de_linea_trabajo integer,
    de_planta_id integer,
	de_departamento integer NOT NULL,
	de_registrado timestamp NOT NULL DEFAULT now(),
	de_modificado timestamp NOT NULL DEFAULT now(),
	de_usr_id integer NOT NULL,
	de_estado char(1) NOT NULL DEFAULT 'A',
	FOREIGN KEY(de_linea_trabajo) REFERENCES acopio.linea_trab(ltra_id),
	FOREIGN KEY(de_planta_id) REFERENCES public._bp_planta(id_planta)
);

CREATE TABLE producto_terminado.canastillos (
	ctl_id serial PRIMARY KEY,
	ctl_descripcion text NOT NULL,
	ctl_codigo text NOT NULL,
	ctl_rece_id integer NOT NULL,
	ctl_altura double precision,
	ctl_ancho double precision,
	ctl_largo double precision,
	ctl_peso double precision,
	ctl_material text,
	ctl_observacion text,
	ctl_logo text,
	ctl_almacenamiento text,
	ctl_transporte text,
	ctl_aplicacion text,
	ctl_foto_canastillo text,
	ctl_registrado timestamp NOT NULL DEFAULT now(),
	ctl_modificado timestamp NOT NULL DEFAULT now(),
	ctl_usr_id integer NOT NULL,
	ctl_estado char(1) NOT NULL DEFAULT 'A',
	FOREIGN KEY(ctl_rece_id) REFERENCES insumo.receta(rece_id)
);



CREATE TABLE producto_terminado.control_vehiculos
(
  ctrv_id serial NOT NULL,
  ctrv_id_vehiculo integer,
  ctrv_check_equipos jsonb DEFAULT '{"gata_est": "0", "llanta_est": "0", "llaves_est": "0", "botiquin_est": "0", "extintor_est": "0", "promedio_est1": "0", "atomizador_est": "0", "montacarga_est": "0", "termometro_est": "0", "herramientas_est": "0", "observaciones_est1": "0"}'::jsonb,
  ctrv_check_limpieza jsonb DEFAULT '{"furgon_est": "0", "pintado_est": "0", "promedio_est2": "0", "implemento_est": "0", "limpieza_ext_est": "0", "limpieza_int_est": "0", "observaciones_est2": "0"}'::jsonb,
  ctrv_check_mecanicas jsonb DEFAULT '{}'::jsonb,
  ctrv_registrado timestamp without time zone NOT NULL DEFAULT now(),
  ctrv_modificado timestamp without time zone NOT NULL DEFAULT now(),
  ctrv_usr_id integer NOT NULL,
  ctrv_estado character(1) NOT NULL DEFAULT 'A'::bpchar,
  CONSTRAINT control_vehiculos_pkey PRIMARY KEY (ctrv_id),
  CONSTRAINT control_vehiculos_ctrv_id_vehiculo_fkey FOREIGN KEY (ctrv_id_vehiculo)
      REFERENCES producto_terminado.vehiculos (veh_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE producto_terminado.ingreso_almacen_canastillo
(
  	iac_id serial PRIMARY KEY,
	iac_ctl_id integer NOT NULL,
	iac_nro_ingreso text,
	iac_fecha_ingreso date NOT NULL,
	iac_cantidad integer NOT NULL,	
	iac_origen integer NOT NULL,	
	iac_observacion text,	
	iac_chofer integer NOT NULL,	
	iac_de_id integer,
	iac_fecha_salida timestamp,
	iac_codigo_salida text,
	iac_estado char(1) NOT NULL DEFAULT 'A',
	iac_registrado timestamp NOT NULL DEFAULT now(),
	iac_modificado timestamp NOT NULL DEFAULT now(),
	iac_usr_id integer NOT NULL,
	iac_estado_baja char(1) NOT NULL DEFAULT 'A',
);

CREATE TABLE producto_terminado.ingreso_almacen_orp
(
  	ipt_id serial PRIMARY KEY,
	ipt_orprod_id integer NOT NULL,
	ipt_cantidad numeric(10,2) NOT NULL,
	ipt_lote text NOT NULL,
	ipt_hora_falta text NOT NULL,
	ipt_fecha_vencimiento date NOT NULL,
	ipt_costo_unitario numeric(10,2) NOT NULL,	
	ipt_observacion text,
	ipt_sobrante integer,	
	ipt_registrado timestamp NOT NULL DEFAULT now(),
	ipt_modificado timestamp NOT NULL DEFAULT now(),
	ipt_usr_id integer NOT NULL,
	ipt_estado char(1) NOT NULL DEFAULT 'A',
	ipt_estado_baja char(1) NOT NULL DEFAULT 'A',
	FOREIGN KEY(ipt_orprod_id) REFERENCES insumo.orden_produccion(orprod_id)
);

CREATE TABLE producto_terminado.despacho_almacen_orp
(
  	dao_id serial PRIMARY KEY,
	dao_ipt_id integer NOT NULL,
	dao_codigo integer,
	dao_de_id integer NOT NULL,
	dao_cantidad numeric(10,2) NOT NULL,
	dao_tipo_orp integer NOT NULL,
	dao_fecha_despacho text NOT NULL,
	dao_codigo_salida text,
	dao_registrado timestamp NOT NULL DEFAULT now(),
	dao_modificado timestamp NOT NULL DEFAULT now(),
	dao_usr_id integer NOT NULL,
	dao_estado char(1) NOT NULL DEFAULT 'A',
	FOREIGN KEY(dao_ipt_id) REFERENCES producto_terminado.ingreso_almacen_orp(ipt_id),
	FOREIGN KEY(dao_de_id) REFERENCES producto_terminado.destino(de_id)
);

CREATE TABLE producto_terminado.despacho_almacen_producto_terminado
(
  	dapt_id serial PRIMARY KEY,
	dapt_ipt_id integer NOT NULL,
	dapt_de_id integer NOT NULL,
	dapt_cantidad text NOT NULL,
	dapt_fecha_despacho text NOT NULL,
	dapt_registrado timestamp NOT NULL DEFAULT now(),
	dapt_modificado timestamp NOT NULL DEFAULT now(),
	dapt_usr_id integer NOT NULL,
	dapt_estado char(1) NOT NULL DEFAULT 'A',
	FOREIGN KEY(dapt_ipt_id) REFERENCES producto_terminado.ingreso_almacen_orp(ipt_id)
	FOREIGN KEY(dapt_de_id) REFERENCES producto_terminado.destino(de_id)
);

CREATE TABLE producto_terminado.despacho_almacen_canastillo
(
  	iac_id serial PRIMARY KEY,
	iac_ctl_id integer NOT NULL,
	iac_nro_ingreso text,
	iac_fecha_ingreso date NOT NULL,
	iac_cantidad integer NOT NULL,	
	iac_origen integer NOT NULL,	
	iac_observacion text,	
	iac_chofer integer NOT NULL,	
	iac_registrado timestamp NOT NULL DEFAULT now(),
	iac_modificado timestamp NOT NULL DEFAULT now(),
	iac_usr_id integer NOT NULL,
	iac_estado char(1) NOT NULL DEFAULT 'A',
	FOREIGN KEY(iac_ctl_id) REFERENCES producto_terminado.canastillos(ctl_id)
);

CREATE TABLE producto_terminado.correlativo(
    corr_id serial primary key,
    corr_codigo text NOT NULL,
    corr_correlativo integer DEFAULT 0,
    corr_gestion integer NOT NULL,
    corr_usr_id integer NOT NULL,
    corr_tpd_id integer NOT NULL,
    corr_registrado timestamp NOT NULL DEFAULT now(),
    corr_modificado timestamp NOT NULL DEFAULT now(),
    corr_estado char(1) NOT NULL DEFAULT 'A'
);


INSERT INTO producto_terminado.correlativo(corr_codigo,corr_gestion,corr_usr_id,corr_tpd_id)
	VALUES
('ENTRADA',2019,1,1),
('ENTRADA',2019,1,2),
('ENTRADA',2019,1,3),
('ENTRADA',2019,1,4),
('ENTRADA',2019,1,5),
('ENTRADA',2019,1,6),
('ENTRADA',2019,1,7),
('ENTRADA',2019,1,8),
('ENTRADA',2019,1,9),
('ENTRADA',2019,1,10),
('ENTRADA',2019,1,11),
('ENTRADA',2019,1,12),
('ENTRADA',2019,1,13),
('ENTRADA',2019,1,14),
('ENTRADA',2019,1,15),
('ENTRADA',2019,1,16),
('ENTRADA',2019,1,17),
('ENTRADA',2019,1,18),
('ENTRADA',2019,1,19),
('ENTRADA',2019,1,20),
('ENTRADA',2019,1,21),
('ENTRADA',2019,1,22),
('ENTRADA',2019,1,23),
('ENTRADA',2019,1,24),
('ENTRADA',2019,1,25),
('ENTRADA',2019,1,26),

('SALIDA',2019,1,1),
('SALIDA',2019,1,2),
('SALIDA',2019,1,3),
('SALIDA',2019,1,4),
('SALIDA',2019,1,5),
('SALIDA',2019,1,6),
('SALIDA',2019,1,7),
('SALIDA',2019,1,8),
('SALIDA',2019,1,9),
('SALIDA',2019,1,10),
('SALIDA',2019,1,11),
('SALIDA',2019,1,12),
('SALIDA',2019,1,13),
('SALIDA',2019,1,14),
('SALIDA',2019,1,15),
('SALIDA',2019,1,16),
('SALIDA',2019,1,17),
('SALIDA',2019,1,18),
('SALIDA',2019,1,19),
('SALIDA',2019,1,20),
('SALIDA',2019,1,21),
('SALIDA',2019,1,22),
('SALIDA',2019,1,23),
('SALIDA',2019,1,24),
('SALIDA',2019,1,25),
('SALIDA',2019,1,26),

('ENTRADA_CANASTILLA',2019,1,1),
('ENTRADA_CANASTILLA',2019,1,2),
('ENTRADA_CANASTILLA',2019,1,3),
('ENTRADA_CANASTILLA',2019,1,4),
('ENTRADA_CANASTILLA',2019,1,5),
('ENTRADA_CANASTILLA',2019,1,6),
('ENTRADA_CANASTILLA',2019,1,7),
('ENTRADA_CANASTILLA',2019,1,8),
('ENTRADA_CANASTILLA',2019,1,9),
('ENTRADA_CANASTILLA',2019,1,10),
('ENTRADA_CANASTILLA',2019,1,11),
('ENTRADA_CANASTILLA',2019,1,12),
('ENTRADA_CANASTILLA',2019,1,13),
('ENTRADA_CANASTILLA',2019,1,14),
('ENTRADA_CANASTILLA',2019,1,15),
('ENTRADA_CANASTILLA',2019,1,16),
('ENTRADA_CANASTILLA',2019,1,17),
('ENTRADA_CANASTILLA',2019,1,18),
('ENTRADA_CANASTILLA',2019,1,19),
('ENTRADA_CANASTILLA',2019,1,20),
('ENTRADA_CANASTILLA',2019,1,21),
('ENTRADA_CANASTILLA',2019,1,22),
('ENTRADA_CANASTILLA',2019,1,23),
('ENTRADA_CANASTILLA',2019,1,24),
('ENTRADA_CANASTILLA',2019,1,25),
('ENTRADA_CANASTILLA',2019,1,26),

('SALIDA_CANASTILLA',2019,1,1),
('SALIDA_CANASTILLA',2019,1,2),
('SALIDA_CANASTILLA',2019,1,3),
('SALIDA_CANASTILLA',2019,1,4),
('SALIDA_CANASTILLA',2019,1,5),
('SALIDA_CANASTILLA',2019,1,6),
('SALIDA_CANASTILLA',2019,1,7),
('SALIDA_CANASTILLA',2019,1,8),
('SALIDA_CANASTILLA',2019,1,9),
('SALIDA_CANASTILLA',2019,1,10),
('SALIDA_CANASTILLA',2019,1,11),
('SALIDA_CANASTILLA',2019,1,12),
('SALIDA_CANASTILLA',2019,1,13),
('SALIDA_CANASTILLA',2019,1,14),
('SALIDA_CANASTILLA',2019,1,15),
('SALIDA_CANASTILLA',2019,1,16),
('SALIDA_CANASTILLA',2019,1,17),
('SALIDA_CANASTILLA',2019,1,18),
('SALIDA_CANASTILLA',2019,1,19),
('SALIDA_CANASTILLA',2019,1,20),
('SALIDA_CANASTILLA',2019,1,21),
('SALIDA_CANASTILLA',2019,1,22),
('SALIDA_CANASTILLA',2019,1,23),
('SALIDA_CANASTILLA',2019,1,24),
('SALIDA_CANASTILLA',2019,1,25),
('SALIDA_CANASTILLA',2019,1,26);



CREATE TABLE producto_terminado.correlativo(
    corr_id serial primary key,
    corr_codigo text NOT NULL,
    corr_correlativo integer DEFAULT 0,
    corr_gestion integer NOT NULL,
    corr_usr_id integer NOT NULL,
    corr_tpd_id integer NOT NULL,
    corr_registrado timestamp NOT NULL DEFAULT now(),
    corr_modificado timestamp NOT NULL DEFAULT now(),
    corr_estado char(1) NOT NULL DEFAULT 'A'
);


CREATE TABLE public._bp_planta(
    id_planta serial PRIMARY KEY,
    nombre_planta text NULL,
    codigo_planta text NULL,
    id_linea_trabajo integer null
);

INSERT INTO public._bp_planta(id_planta,nombre_planta,codigo_planta,id_linea_trabajo)
	VALUES

(1,'GONZALO MORENO','GM',1),
(2,'SAN LORENZO','SL',2),
(3,'VILLA NUEVA','VN',1),
(4,'SANTOS MERCADO','SM',1),
(5,'BOLPEBRA','BOL',1),
(6,'MAGDALENA','MAG',1),
(7,'BAURES','BAU',1),
(8,'IXIAMAS','IXI',1),
(9,'RIBERALTA','RIB',1),
(10,'EL SENA','ES',1),
(11,'ACHACACHI','ACHA',2),
(12,'IVIRGAZAMA','IVIZ',2),
(13,'CHALLAPATA','CHAL',2),
(14,'PLANTA DEV','PD',1),
(15,'SAN ANDRES','SA',2),
(16,'SAMUZABETY','SAB',3),
(17,'SHINAHOTA','SNT',3),
(18,'MONTEAGUDO','MON',3),
(19,'CAMARGO','CMR',3),
(20,'EL VILLAR','EVR',3),
(21,'IRUPANA','IRU',3),
(22,'VALLE SACTA','VS',4),
(23,'VALLA 14 SEPTIEMBRE','VSE',4),
(24,'CARANAVI','CARN',4),
(25,'COBIJA','COB',1),
(26,'PLANTA  DEV LACTEOS','PDL',2);

CREATE TABLE producto_terminado.stock_producto_terminado(
    spt_id serial primary key,
    spt_orprod_id integer NOT NULL,
    spt_planta_id integer NOT NULL,
  	spt_fecha timestamp without time zone NOT NULL,
    spt_cantidad numeric(10,2) NOT NULL,
	spt_costo numeric(10,2) NOT NULL,
	spt_costo_unitario numeric(10,2) NOT NULL,
    spt_usr_id integer NOT NULL,
    spt_estado char(1) NOT NULL DEFAULT 'A',
    spt_registrado timestamp NOT NULL DEFAULT now(),
    spt_modificado timestamp NOT NULL DEFAULT now(),
    spt_estado_baja char(1) NOT NULL DEFAULT 'A',
	FOREIGN KEY(spt_orprod_id) REFERENCES insumo.orden_produccion(orprod_id),
	FOREIGN KEY(spt_planta_id) REFERENCES public._bp_planta(id_planta)
);

CREATE TABLE producto_terminado.stock_producto_terminado_historial(
    spth_id serial primary key,
    spth_orprod_id integer NOT NULL,
    spth_planta_id integer NOT NULL,
  	spth_fecha timestamp without time zone NOT NULL,
    spth_cantidad numeric(10,2) NOT NULL,
	spth_costo numeric(10,2) NOT NULL,
	spth_costo_unitario numeric(10,2) NOT NULL,
    spth_usr_id integer NOT NULL,
    spth_estado char(1) NOT NULL DEFAULT 'A',
    spth_registrado timestamp NOT NULL DEFAULT now(),
    spth_modificado timestamp NOT NULL DEFAULT now(),
    spth_estado_baja char(1) NOT NULL DEFAULT 'A',
    spth_rece_id integer NOT NULL,
    spth_fecha_vencimiento timestamp NOT NULL,
	FOREIGN KEY(spth_orprod_id) REFERENCES insumo.orden_produccion(orprod_id),
	FOREIGN KEY(spth_planta_id) REFERENCES public._bp_planta(id_planta)
);
--KARDEX PRODUCTO HISTORIAL
CREATE TABLE producto_terminado.producto_terminado_historial(
    pth_id serial primary key,
    pth_rece_id integer NOT NULL,
    pth_planta_id integer NOT NULL,
  	pth_ipt_id integer,
  	pth_dao_id integer,
    pth_cantidad numeric(10,2) NOT NULL,
    pth_fecha_vencimiento timestamp NOT NULL,
    pth_lote text NOT NULL,    
    pth_registrado timestamp NOT NULL DEFAULT now(),
    pth_modificado timestamp NOT NULL DEFAULT now(),
    pth_estado char(1) NOT NULL DEFAULT 'A',
	FOREIGN KEY(pth_ipt_id) REFERENCES producto_terminado.ingreso_almacen_orp(ipt_id),
	FOREIGN KEY(pth_dao_id) REFERENCES producto_terminado.despacho_almacen_orp(dao_id),
	FOREIGN KEY(pth_planta_id) REFERENCES public._bp_planta(id_planta) 
);
--END KARDEX PRODUCTO HISTORIAL
CREATE OR REPLACE FUNCTION sp_lst_ctrlvehiculo_eq(
    IN id_vehiculo integer)
	  RETURNS TABLE(xctrv_id integer, xctrv_registrado date, xgata text, xllanta text, xllaves text, xbotiquin text, xextintor text, xatomizador text, xmontacarga text, xtermometro text, xherramientas text, xobservaciones text, xpromedio text) AS
	$BODY$
	  BEGIN
	  RETURN QUERY select ctrv_id,ctrv_registrado::date,ctrv_check_equipos::json->>'gata_est' as gata,ctrv_check_equipos::json->>'llanta_est' as llanta,ctrv_check_equipos::json->>'llaves_est' as llaves,ctrv_check_equipos::json->>'botiquin_est' as botiquin,ctrv_check_equipos::json->>'extintor_est' as extintor,ctrv_check_equipos::json->>'atomizador_est' as atomizador,ctrv_check_equipos::json->>'montacarga_est' as montacarga,ctrv_check_equipos::json->>'termometro_est' as termometro,ctrv_check_equipos::json->>'herramientas_est' as herramientas,ctrv_check_equipos::json->>'observaciones_est1' as observaciones,ctrv_check_equipos::json->>'promedio_est1' as promedio
	  from ace_control_vehiculos
	  where ctrv_id_vehiculo=id_vehiculo; 
	  END;
	  $BODY$
	  LANGUAGE plpgsql VOLATILE
	  COST 100
	  ROWS 1000;
	ALTER FUNCTION sp_lst_ctrlvehiculo_eq(integer)
	  OWNER TO postgres;

----------------
-- Function: sp_lst_ctrlvehiculo_lim(integer, integer, integer)

-- DROP FUNCTION sp_lst_ctrlvehiculo_lim(integer, integer, integer);

CREATE OR REPLACE FUNCTION sp_lst_ctrlvehiculo_lim(
    IN id_vehiculo integer)
	  RETURNS TABLE(xctrv_id integer, xctrv_registrado date, xfurgon text, xpintado text, ximplemento text, xlimpieza_int text, limpieza_ext text, xobservaciones text, xpromedio text) AS
	$BODY$
	  BEGIN
	  RETURN QUERY select ctrv_id,ctrv_registrado::date,ctrv_check_limpieza::json->>'furgon_est' as furgon,ctrv_check_limpieza::json->>'pintado_est' as pintado,ctrv_check_limpieza::json->>'implemento_est' as implemento,ctrv_check_limpieza::json->>'limpieza_int_est' as limpieza_int,ctrv_check_limpieza::json->>'limpieza_ext_est' as limpieza_ext,ctrv_check_limpieza::json->>'observaciones_est2' as observaciones,ctrv_check_limpieza::json->>'promedio_est2' as promedio
	  from ace_control_vehiculos
	  where ctrv_id_vehiculo=id_vehiculo ; 
	  END;
	  $BODY$
	  LANGUAGE plpgsql VOLATILE
	  COST 100
	  ROWS 1000;
	ALTER FUNCTION sp_lst_ctrlvehiculo_lim(integer)
  OWNER TO postgres;

-- Function: sp_update_ctrv_eq(integer, jsonb)

-- DROP FUNCTION sp_update_ctrv_eq(integer, jsonb);

CREATE OR REPLACE FUNCTION sp_update_ctrv_eq(
    xctrv_id integer,
    xctrv_check_equipos jsonb)
  RETURNS SETOF integer AS
$BODY$
  BEGIN
  UPDATE ace_control_vehiculos
  SET ctrv_check_equipos=xctrv_check_equipos,ctrv_modificado=now()
  WHERE ctrv_id=xctrv_id;
  RETURN QUERY select xctrv_id;
  END;
  $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION sp_update_ctrv_eq(integer, jsonb)
  OWNER TO postgres;
---
-- Function: sp_update_ctrv_lim(integer, jsonb)

-- DROP FUNCTION sp_update_ctrv_lim(integer, jsonb);

CREATE OR REPLACE FUNCTION sp_update_ctrv_lim(
    xctrv_id integer,
    xctrv_check_limpieza jsonb)
  RETURNS SETOF integer AS
$BODY$
  BEGIN
  UPDATE ace_control_vehiculos
  SET ctrv_check_limpieza=xctrv_check_limpieza,ctrv_modificado=now()
  WHERE ctrv_id=xctrv_id;
  RETURN QUERY select xctrv_id;
  END;
  $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION sp_update_ctrv_lim(integer, jsonb)
  OWNER TO postgres;


  --------------------------------

-- Function: sp_lst_ctrl_vehiculos(integer, integer, integer)

-- DROP FUNCTION sp_lst_ctrl_vehiculos(integer, integer, integer);

CREATE OR REPLACE FUNCTION sp_lst_ctrl_vehiculos(
    IN id_carpeta integer,
    IN id_empresa integer,
    IN id_vehiculo integer)
  RETURNS TABLE(xidctrv integer, xctrv_check_equipos jsonb, xctrv_check_limpieza jsonb) AS
$BODY$
  BEGIN
  RETURN QUERY select ctrv_id,ctrv_check_equipos,ctrv_check_limpieza
  from ace_control_vehiculos
  where ctrv_id_carpeta=id_carpeta and ctrv_id_empresa=id_empresa and ctrv_id_vehiculo=id_vehiculo and ctrv_registrado::date=now()::date;
  END;
  $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION sp_lst_ctrl_vehiculos(integer, integer, integer)
  OWNER TO postgres;


CREATE OR REPLACE FUNCTION producto_terminado.sp_listado_sobrantes()
  RETURNS TABLE(xorprod_rece_id bigint, xtotal bigint, xrece_nombre text, xrece_lineaprod_id integer, xrece_presentacion character varying, xumed_nombre character varying, xsab_nombre character varying, xipt_id integer, xipt_orprod_id integer, xipt_fecha_vencimiento date, xipt_usr_id integer, xorprod_planta_id integer, xipt_lote text, ipt_costo_unitario numeric, xorprod_codigo character varying, xorprod_nro_orden bigint) AS
$BODY$
 BEGIN
 RETURN QUERY
	select DISTINCT ON (e.orprod_rece_id) e.orprod_rece_id,e.total,rece.rece_nombre,rece.rece_lineaprod_id,rece.rece_presentacion,umed.umed_nombre,sab.sab_nombre,ing1.ipt_id,ing1.ipt_orprod_id,ing1.ipt_fecha_vencimiento,ing1.ipt_usr_id,orp2.orprod_planta_id,ing1.ipt_lote,ing1.ipt_costo_unitario,orp2.orprod_codigo,orp2.orprod_nro_orden
	from 
	(select orp1.orprod_rece_id,sum(ipt_sobrante) as total
		from producto_terminado.ingreso_almacen_orp 
		inner join insumo.orden_produccion as orp1 on orp1.orprod_id=ipt_orprod_id
		where ipt_estado='D' and ipt_sobrante>0 group by orp1.orprod_rece_id) e
	inner join insumo.orden_produccion as orp2 on orp2.orprod_rece_id=e.orprod_rece_id
	inner join insumo.receta as rece on e.orprod_rece_id=rece.rece_id
	inner join producto_terminado.ingreso_almacen_orp  as ing1 on ing1.ipt_orprod_id= orp2.orprod_id
	inner join insumo.sabor as sab on rece.rece_sabor_id=sab.sab_id
	inner join insumo.unidad_medida as umed on rece.rece_uni_id=umed.umed_id
	where orp2.orprod_estado_orp='D';
 END;
 $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION producto_terminado.sp_listado_sobrantes()
  OWNER TO postgres;


CREATE OR REPLACE FUNCTION producto_terminado.sp_listado_stock()
  RETURNS TABLE(xspt_rece_id integer, xspt_planta_id integer, xtotal numeric, xrece_codigo character varying, xrece_nombre text, xrece_presentacion character varying, xrece_lineaprod_id integer) AS
$BODY$
 BEGIN
 RETURN QUERY
	select spt_rece_id,spt_planta_id, total,rece_codigo,rece_nombre,rece_presentacion,rece_lineaprod_id from
	(select spt_rece_id, sum(spt_cantidad) as total,spt_planta_id from producto_terminado.stock_producto_terminado where spt_estado='A' group By spt_rece_id,spt_planta_id) as st ,
	insumo.receta as rece
	where rece.rece_id=st.spt_rece_id 
	and rece.rece_estado='A';
 END;
 $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION producto_terminado.sp_listado_stock()
  OWNER TO postgres;
