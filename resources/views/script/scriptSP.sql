CREATE OR REPLACE FUNCTION "acopio"."sp_sum_asignado"()
  RETURNS TABLE("asig_id_comp1" int4, "asig_monto1" numeric) AS $BODY$
BEGIN
RETURN query
SELECT asig_id_comp, sum(asig_monto) FROM acopio.asignacion_presupuesto where asig_id_comp=1 GROUP BY (asig_id_comp);     
 END;
 $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000


CREATE OR REPLACE FUNCTION "acopio"."sp_sum_asignado"("id" int4)
  RETURNS TABLE("asig_id_comp1" int4, "asig_monto1" numeric) AS $BODY$
BEGIN
RETURN query
SELECT asig_id_comp, sum(asig_monto) FROM acopio.asignacion_presupuesto where asig_id_comp=id GROUP BY (asig_id_comp);     
 END;
 $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000


CREATE OR REPLACE FUNCTION "acopio"."sp_sum_group"()
  RETURNS TABLE("aco_id_prov1" int4, "prov_nombre1" varchar, "prov_ap1" varchar, "prov_am1" varchar, "prov_ci1" int4, "aco_cos_total3" numeric, "aco_cos_total2" numeric, "aco_num_rec1" text, "aco_peso_neto2" numeric, "aco_numaco1" numeric, "aco_cantidad1" numeric, "aco_peso_neto1" numeric, "aco_cos_total1" numeric) AS $BODY$
BEGIN
RETURN query
SELECT aco_id_prov, prov_nombre, prov_ap, prov_am, prov_ci, min(aco_cos_total), max(aco_cos_total), max(aco_num_rec), max(aco_peso_neto),sum(aco_numaco), sum(aco_cantidad), sum(aco_peso_neto), sum(aco_cos_total) FROM acopio.acopio INNER JOIN acopio.proveedor ON acopio.aco_id_prov = proveedor.prov_id GROUP BY (aco_id_prov, prov_nombre, prov_ap, prov_am, prov_ci);     
 END;
 $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000


CREATE OR REPLACE FUNCTION "acopio"."sp_sum_group1"()
  RETURNS TABLE("aco_id_prov1" int4, "prov_nombre1" varchar, "prov_ap1" varchar, "prov_am1" varchar, "prov_ci1" int4, "aco_numaco1" numeric, "aco_cantidad1" numeric, "aco_peso_neto1" numeric, "aco_cos_total1" numeric) AS $BODY$
BEGIN
RETURN query
SELECT aco_id_prov, prov_nombre, prov_ap, prov_am, prov_ci, sum(aco_numaco), sum(aco_cantidad), sum(aco_peso_neto), sum(aco_cos_total) FROM acopio.acopio INNER JOIN acopio.proveedor ON acopio.aco_id_prov = proveedor.prov_id GROUP BY (aco_id_prov, prov_nombre, prov_ap, prov_am, prov_ci);     
 END;
 $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000


CREATE OR REPLACE FUNCTION "acopio"."sp_sum_utilizado"()
  RETURNS TABLE("aco_id_usr1" int4, "aco_cos_total1" numeric) AS $BODY$
BEGIN
RETURN query
SELECT aco_id_usr, sum(aco_cos_total) FROM acopio.acopio GROUP BY (aco_id_usr);     
 END;
 $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000


CREATE OR REPLACE FUNCTION acopio.sp_sum_lact2(
	ids integer,
	fecha date)
    RETURNS TABLE(xtotalprov bigint, xtotal numeric) 
    LANGUAGE 'plpgsql'

    COST 100
    VOLATILE 
    ROWS 1000
AS $BODY$

  BEGIN
  RETURN QUERY 
  select count(dac_id_prov) as totalprov,sum(dac_cant_uni) as total from acopio.det_acop_ca
   where dac_id_rec=ids and dac_fecha_acop=fecha::date;

   END;
  

$BODY$;

ALTER FUNCTION acopio.sp_sum_lact2(integer, date)
    OWNER TO postgres;