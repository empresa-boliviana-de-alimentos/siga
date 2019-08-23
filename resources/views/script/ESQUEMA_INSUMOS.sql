

CREATE TABLE insumo.ufv(
    ufv_id serial primary key,
    ufv_cant decimal NOT NULL,
    ufv_usr_id integer NOT NULL,
    ufv_registrado timestamp NOT NULL DEFAULT now(),
    ufv_modificado timestamp NOT NULL DEFAULT now(),
    ufv_estado char(1) NOT NULL DEFAULT 'A'
);

INSERT INTO insumo.ufv (ufv_cant, ufv_usr_id) VALUES 
(102.000, 1),
(100.236, 1),
(256.999, 1);

CREATE TABLE insumo.servicio(
    serv_id serial primary key,
    serv_nom text NOT NULL,
    serv_emp text,
    serv_nit integer,
    serv_nfact integer,
    serv_costo decimal NOT NULL,
    serv_id_mes integer NOT NULL,
    serv_usr_id integer NOT NULL,
    serv_registrado timestamp NOT NULL DEFAULT now(),
    serv_modificado timestamp NOT NULL DEFAULT now(),
    serv_estado char(1) NOT NULL DEFAULT 'A'  
);

INSERT INTO insumo.servicio(serv_nom, serv_emp, serv_nit, serv_nfact, serv_costo, serv_id_mes, serv_usr_id) VALUES 
('AGUA','EMAPA', 1245639, 895623, 23.56, 1, 1),
('LUZ','ELOCTROPAZ', 12496532, 562437, 150.33, 1, 1);

CREATE TABLE insumo.proveedor(
    prov_id serial primary key,
    prov_nom text NOT NULL,
    prov_dir text,
    prov_tel integer,
    prov_nom_res text,
    prov_ap_res text,
    prov_am_res text,
    prov_tel_res integer,
    prov_obs text,
    prov_usr_id integer NOT NULL,
    prov_registrado timestamp NOT NULL DEFAULT now(),
    prov_modificado timestamp NOT NULL DEFAULT now(),
    prov_estado char(1) NOT NULL DEFAULT 'A'
);
INSERT INTO insumo.proveedor(prov_nom, prov_dir, prov_tel, prov_nom_res, prov_ap_res, prov_am_res, prov_tel_res, prov_obs, prov_usr_id) VALUES
('MAPRIAL', 'nataniel aguirre', 28393, 'juancito', 'perez', 'perez', 727228, '', 1);

CREATE TABLE insumo.partida(
    part_id serial primary key,
    part_cod text,
    part_nom text,
    part_usr_id integer NOT NULL,
    part_registrado timestamp NOT NULL DEFAULT now(),
    part_modificado timestamp NOT NULL DEFAULT now(),
    part_estado char(1) NOT NULL DEFAULT 'A'  
);

INSERT INTO insumo.partida(part_cod, part_nom, part_usr_id) VALUES 
('1235', 'DDDDDD', 1);

CREATE TABLE insumo.dato(
    dat_id serial primary key,
    dat_id_clas integer NOT NULL,
    dat_nom text,
    dat_sigla text,
    dat_id_partida integer,
    dat_usr_id integer NOT NULL,
    dat_registrado timestamp NOT NULL DEFAULT now(),
    dat_modificado timestamp NOT NULL DEFAULT now(),
    dat_estado char(1) NOT NULL DEFAULT 'A',
    FOREIGN KEY(dat_id_partida) REFERENCES insumo.partida(part_id)
);
INSERT INTO insumo.dato (dat_id_clas, dat_nom, dat_sigla, dat_id_partida, dat_usr_id) VALUES
(1, 'xxxx', 'HP5623', 1, 1);

CREATE TABLE insumo.articulo(
    art_id serial primary key,
    art_cod text,
    art_nom text,
    art_id_unidad integer,
    art_id_part integer,
    art_id_cat integer,
    --art_id_tipo_art integer,
    art_usr_id integer NOT NULL,
    art_registrado timestamp NOT NULL DEFAULT now(),
    art_modificado timestamp NOT NULL DEFAULT now(),
    art_estado char(1) NOT NULL DEFAULT 'A'  
);

INSERT INTO insumo.articulo(art_cod, art_nom, art_usr_id) VALUES 
('8956GH', 'ARINA', 1);

CREATE TABLE insumo.insumo(
    ins_id serial primary key,
    ins_codigo text NOT NULL,
    ins_id_tip_art integer,
    ins_id_tip_ins integer,
    ins_id_part integer NOT NULL,
    ins_id_cat integer NOT NULL,
    ins_id_uni integer NOT NULL,
    ins_desc text,
    ins_usr_id integer NOT NULL,
    ins_registrado timestamp NOT NULL DEFAULT now(),
    ins_modificado timestamp NOT NULL DEFAULT now(),
    ins_estado char(1) NOT NULL DEFAULT 'A',
    FOREIGN KEY(ins_id_tip_art) REFERENCES insumo.articulo(art_id),
    FOREIGN KEY(ins_id_part) REFERENCES insumo.partida(part_id),
    FOREIGN KEY(ins_id_tip_ins) REFERENCES insumo.partida(part_id),
    FOREIGN KEY(ins_id_cat) REFERENCES insumo.dato(dat_id),
    FOREIGN KEY(ins_id_uni) REFERENCES insumo.dato(dat_id)
);
INSERT INTO insumo.insumo (ins_codigo, ins_id_tip_art, ins_id_part, ins_id_cat, ins_id_uni, ins_usr_id) VALUES
('8956DD', 1, 1, 1, 1, 1);

-- CREATE TABLE insumo.almacen(
--     alm_id serial primary key,
--     alm_id_prov integer,
--     alm_nota_rem text,
--     alm_id_tipo_ing integer,
--     alm_fecha timestamp,
--     alm_factura integer,
--     alm_usr_id integer NOT NULL,
--     alm_registrado timestamp NOT NULL DEFAULT now(),
--     alm_modificado timestamp NOT NULL DEFAULT now(),
--     alm_estado char(1) NOT NULL DEFAULT 'A',
--     FOREIGN KEY(alm_id_prov) REFERENCES insumo.proveedor(prov_id),
--     FOREIGN KEY(alm_id_tipo_ing) REFERENCES insumo.dato(dat_id)
-- );
-- INSERT INTO insumo.almacen (alm_id_prov, alm_nota_rem, alm_id_tipo_ing, alm_fecha, alm_factura, alm_usr_id) VALUES
-- (1, 'dsfdfdsfs', 1, '2018-12-04', 784595, 1);

CREATE TABLE insumo.carro_solicitud (
    carr_sol_id serial primary key NOT NULL,
    carr_cantidad integer,
    carr_costo float,
    carr_usr_id integer,
    carr_estado char(1) NOT NULL DEFAULT 'A'
    );

CREATE TABLE insumo.carro_ingreso (
    carr_ing_id serial primary key NOT NULL,
    carr_ing_prov integer,
    carr_ing_rem text,
    carr_ing_tiping integer,
    carr_ing_fech timestamp,
    carr_ing_fact text,
    carr_ing_usr_id integer,
    carr_ing_data jsonb,
    carr_ing_registrado timestamp NOT NULL DEFAULT now(),
    carr_ing_estado char(1) NOT NULL DEFAULT 'A'
    );

CREATE TABLE insumo.mercado (
    merc_id serial primary key NOT NULL,
    merc_nombre text,
    merc_usr_id integer,
    merc_registrado timestamp NOT NULL DEFAULT now(),   
    merc_modificado timestamp NOT NULL DEFAULT now(),
    merc_estado char(1) NOT NULL DEFAULT 'A'
    );
INSERT INTO insumo.mercado (merc_nombre, merc_usr_id) VALUES
('PRODUCCION', 1);

--EJECUTAR
CREATE TABLE insumo.receta (
    rec_id serial primary key NOT NULL,
    rec_nombre text,
    rec_cant_min float,
    rec_uni_base text,
    rec_id_planta integer,
    rec_id_lineatrab integer,
    rec_id_mercado integer,
    rec_data jsonb,
    rec_usr_id integer NOT NULL,
    rec_registrado timestamp NOT NULL DEFAULT now(),
    rec_modificado timestamp NOT NULL DEFAULT now(),
    rec_estado char(1) NOT NULL DEFAULT 'A',
    FOREIGN KEY(rec_id_planta) REFERENCES public._bp_planta(id_planta),
    FOREIGN KEY(rec_id_lineatrab) REFERENCES acopio.linea_trab(ltra_id),
    FOREIGN KEY(rec_id_mercado) REFERENCES insumo.mercado(merc_id)
    );

/*CREATE TABLE insumo.tmp_preliminar (
    tmpp_id serial primary key NOT NULL,
    tmpp_id_prov integer,
    tmpp_rem text,
    tmpp_tiping integer,
    tmpp_fech timestamp,
    tmpp_usr_id integer,
    tmpp_registrado timestamp NOT NULL DEFAULT now(),
    tmpp_estado char(1) NOT NULL DEFAULT 'A',
    FOREIGN KEY(tmpp_id_prov) REFERENCES insumo.proveedor(prov_id),
    FOREIGN KEY(tmpp_tiping) REFERENCES insumo.dato(dat_id)
    );*/

CREATE TABLE insumo.solcitud_receta (
    solrec_id serial primary key NOT NULL,
    solrec_id_rec integer,
    solrec_cantidad float,
    solrec_id_merc integer,
    solrec_data jsonb,
    solrec_usr_id integer,
    solrec_tipo integer,
    solrec_registrado timestamp NOT NULL DEFAULT now(),
    solrec_modificado timestamp NOT NULL DEFAULT now(),
    solrec_estado char(1) NOT NULL DEFAULT 'A',
    FOREIGN KEY(solrec_id_rec) REFERENCES insumo.receta(rec_id),
    FOREIGN KEY(solrec_id_merc) REFERENCES insumo.mercado(merc_id)
    );
--INSERT INTO insumo.solcitud_receta (solrec_id_rec, solrec_cantidad, solrec_id_merc, solrec_usr_id, solrec_tipo) VALUES
--(1, 1000, 1, 1, 1);

CREATE TABLE insumo.solcitud_adicional (
    soladi_id serial primary key NOT NULL,
    soladi_num_lote integer,
    soladi_num_salida integer,
    soladi_id_rec integer,
    soladi_cantidad float,
    soladi_id_merc integer,
    soladi_data jsonb,
    soladi_obs text,
    soladi_tipo integer,
    soladi_usr_id integer,
    soladi_registrado timestamp NOT NULL DEFAULT now(),
    soladi_modificado timestamp NOT NULL DEFAULT now(),
    soladi_estado char(1) NOT NULL DEFAULT 'A',
    FOREIGN KEY(soladi_id_rec) REFERENCES insumo.receta(rec_id),
    FOREIGN KEY(soladi_id_merc) REFERENCES insumo.mercado(merc_id)
    );
--INSERT INTO insumo.solcitud_adicional (soladi_num_lote, soladi_num_salida, soladi_id_rec, soladi_cantidad, soladi_id_merc, soladi_obs, soladi_tipo, soladi_usr_id) VALUES
--(123, 120, 1, 1000, 1, 'SIN OBSERVACION', 2, 1);

CREATE TABLE insumo.solcitud_maquila (
    solmaq_id serial primary key NOT NULL,
    solmaq_id_ins integer,
    solmaq_cantidad float,
    solmaq_vm text,
    solmaq_origen integer,
    solmaq_destino integer,
    solmaq_obs text,
    solmaq_usr_id integer,
    solmaq_tipo integer,
    solmaq_registrado timestamp NOT NULL DEFAULT now(),
    solmaq_modificado timestamp NOT NULL DEFAULT now(),
    solmaq_estado char(1) NOT NULL DEFAULT 'A',
    FOREIGN KEY(solmaq_id_ins) REFERENCES insumo.insumo(ins_id),
    FOREIGN KEY(solmaq_origen) REFERENCES public._bp_planta(id_planta),
    FOREIGN KEY(solmaq_destino) REFERENCES public._bp_planta(id_planta)
    );
--INSERT INTO insumo.solcitud_maquila (solmaq_id_ins, solmaq_cantidad, solmaq_vm, solmaq_origen, solmaq_destino, solmaq_obs, solmaq_usr_id, solmaq_tipo) VALUES
--(1, 1000, '222', 1, 1, 'SIN OBSERVACION', 1, 3);

CREATE TABLE insumo.tipo_solicitud (
    tipsol_id serial primary key NOT NULL,
    tipsol_nombre text,
    tipsol_usr_id integer
    );
INSERT INTO insumo.tipo_solicitud (tipsol_nombre, tipsol_usr_id) VALUES
('RECETAS', 1),
('INSUMO ADICIONAL', 1),
('TRASPASO/MAQUILA', 1);

CREATE TABLE insumo.solicitud (
    sol_id serial primary key NOT NULL,
    sol_id_rec integer,
    sol_id_merc integer,
    sol_data jsonb,
    sol_usr_id integer,
    sol_id_tipo integer,
    sol_id_planta integer,
    sol_gestion integer,
    sol_codnum integer,
    sol_obs text,
    sol_um text,
    sol_id_origen integer,
    sol_id_destino integer,
    sol_registrado date NOT NULL DEFAULT now(),
    sol_modificado date NOT NULL DEFAULT now(),
    sol_estado char(1) NOT NULL DEFAULT 'A',
    FOREIGN KEY(sol_id_rec) REFERENCES insumo.receta(rec_id),
    FOREIGN KEY(sol_id_merc) REFERENCES insumo.mercado(merc_id),
    FOREIGN KEY(sol_id_tipo) REFERENCES insumo.tipo_solicitud(tipsol_id),
    FOREIGN KEY(sol_id_planta) REFERENCES public._bp_planta(id_planta)
    );

CREATE TABLE insumo.aprobacion_solicitud (
    aprsol_id serial primary key NOT NULL,
    aprsol_insumo integer,
    aprsol_solicitud integer,
    aprsol_data jsonb,
    aprsol_usr_id integer,
    aprsol_registrado timestamp NOT NULL DEFAULT now(),
    aprsol_modificado timestamp NOT NULL DEFAULT now(),
    aprsol_estado char(1) NOT NULL DEFAULT 'A',
    FOREIGN KEY(aprsol_insumo) REFERENCES insumo.insumo(ins_id),
    FOREIGN KEY(aprsol_solicitud) REFERENCES insumo.solicitud(sol_id)
    );
--INSERT INTO insumo.aprobacion_solicitud (aprsol_insumo, aprsol_solicitud, aprsol_usr_id) VALUES
--(1, 1, 1);

CREATE TABLE insumo.devolucion (
    dev_id serial primary key NOT NULL,
    dev_id_aprsol integer,
    dev_num_sal integer,
    dev_data jsonb,
    dev_obs text,
    dev_id_planta integer,
    dev_gestion integer,
    dev_codnum integer,
    dev_usr_id integer,
    dev_registrado date NOT NULL DEFAULT now(),
    dev_modificado date NOT NULL DEFAULT now(),
    dev_estado char(1) NOT NULL DEFAULT 'A',
    FOREIGN KEY(dev_id_aprsol) REFERENCES insumo.aprobacion_solicitud(aprsol_id),
    FOREIGN KEY(dev_id_planta) REFERENCES public._bp_planta(id_planta)
    );

CREATE TABLE insumo.devolucion_recibidas(
    devrec_id serial primary key NOT NULL,
    devrec_id_dev integer,
    devrec_num_salida text,
    devrec_nom_receta text,
    devrec_tipo_sol integer,
    devrec_data jsonb,
    devrec_cod_num integer,
    devrec_gestion integer,
    devrec_id_planta integer,
    devrec_usr_id integer,
    devrec_registrado date NOT NULL DEFAULT now(),
    devrec_estado char(1) NOT NULL DEFAULT 'A',
    FOREIGN KEY(devrec_id_dev) REFERENCES insumo.devolucion(dev_id),
    FOREIGN KEY(devrec_id_planta) REFERENCES public._bp_planta(id_planta)
    );

/*CREATE TABLE acopio.envio_almacen(
   enval_id serial primary key,
   enval_cant_total decimal NOT NULL,
   enval_cost_total decimal NOT NULL,
   enval_usr_id int2 NOT NULL,
   enval_registrado timestamp NOT NULL DEFAULT now(),
   enval_estado char(1) NOT NULL DEFAULT 'A',
   enval_id_planta int2 NOT NULL,
   enval_nro_env int4 NOT NULL
);*/

CREATE TABLE insumo.matprima_aprobado(
   prim_id serial primary key,
   prim_id_enval integer,
   prim_cant_enval decimal,
   prim_unidad integer,
   prim_tipo_ins integer,
   prim_cant decimal,
   prim_costo decimal,
   prim_codnum integer,
   prim_gestion integer,
   prim_id_planta integer NOT NULL,
   prim_estado char(1) NOT NULL DEFAULT 'A',
   prim_usr_id integer,
   prim_registrado date NOT NULL DEFAULT now(),
   prim_obs text
);

CREATE TABLE insumo.detalle_data_carringreso(
   detcar_id serial primary key,
   detcar_id_carr integer,
   detcar_id_ins integer,
   detcar_id_prov integer,
   detcar_id_planta integer,
   detcar_cantidad decimal,
   detcar_costo_uni decimal,
   detcar_costo_tot decimal,
   detcar_usr_id integer,
   detcar_registrado date NOT NULL DEFAULT now(),
   FOREIGN KEY(detcar_id_carr) REFERENCES insumo.carro_ingreso(carr_ing_id),
   FOREIGN KEY(detcar_id_ins) REFERENCES insumo.insumo(ins_id),
   FOREIGN KEY(detcar_id_prov) REFERENCES insumo.proveedor(prov_id),
   FOREIGN KEY(detcar_id_planta) REFERENCES public._bp_planta(id_planta)
);

CREATE TABLE insumo.detalle_data_aprobsol(
   detaprob_id serial primary key,
   detaprob_id_aprobsol integer,
   detaprob_id_ins integer,
   detcar_id_planta integer,
   detaprob_cantidad decimal,
   detaprob_costo decimal,
   detaprob_usr_id integer,
   detaprob_registrado date NOT NULL DEFAULT now(),
   FOREIGN KEY(detaprob_id_aprobsol) REFERENCES insumo.aprobacion_solicitud(aprsol_id),
   FOREIGN KEY(detaprob_id_ins) REFERENCES insumo.insumo(ins_id),
   FOREIGN KEY(detcar_id_planta) REFERENCES public._bp_planta(id_planta)
);

CREATE TABLE insumo.stock_historial(
   hist_id serial primary key,
   hist_id_stock integer,
   hist_id_ins integer,
   hist_id_carring integer,
   hist_id_aprobsol integer,
   hist_id_planta integer,
   hist_fecha integer,
   hist_detale text,
   hist_cant_ent decimal,
   hist_cost_ent decimal,
   hist_tot_ent decimal,
   hist_cant_sal decimal,
   hist_cost_sal decimal,
   hist_tot_sal decimal,
   hist_cant_saldo decimal,
   hist_cost_saldo decimal,
   hist_tot_saldo decimal,
   hist_usr_id integer,
   hist_registrado date NOT NULL DEFAULT now()
);

CREATE TABLE insumo.evaluacion_proveedor(
  eval_id serial primary key,
  eval_prov_id integer,
  eval_evaluacion integer,
  enval_registrado date NOT NULL DEFAULT now()
);

