<?php

use Illuminate\Database\Seeder;
use siga\Modelo\insumo\insumo_registros\Proveedor;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $proveedores = [
            ['prov_nom'=>'ACOPIO','prov_dir'=>'LUGAR EMPRESA EBA','prov_tel'=>'2486325','prov_nom_res'=>'EBA','prov_ap_res'=>'EBA','prov_am_res'=>'EBA','prov_tel_res'=>'1234567','prov_obs'=>'EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS','prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'AGUA PURA NUEVA ESPERANZA','prov_dir'=>'CALLE INNOMINADA S/N PT. VILLARROEL','prov_tel'=>'72828427','prov_nom_res'=>'VILMA','prov_ap_res'=>'LORENZO','prov_am_res'=>'FLORES','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'AIRTAC','prov_dir'=>'CALLE JOSE QUINTIN MENDOZA Nº 1455','prov_tel'=>'4414252','prov_nom_res'=>'SERGIO','prov_ap_res'=>'HINOJOSA','prov_am_res'=>'HINOJOSA','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'ALIMENTOS AGUAS CLARAS S.A.','prov_dir'=>'AV. 6TO ANILLO S/N MZNO. 50B, EDIFICIO LA SUPREMA, ZONA PARQUE INDUSTRIAL DE LA CIUDAD DE SANTA CRUZ','prov_tel'=>'61000659','prov_nom_res'=>'JUAN ENRIQUE','prov_ap_res'=>'TRIGO','prov_am_res'=>'VALDIVIA','prov_tel_res'=>'61000659','prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'ALMACEN "SANTA CRUZ"','prov_dir'=>'CALLE MAX PAREDES N° 589','prov_tel'=>'2453805','prov_nom_res'=>'ELISA','prov_ap_res'=>'APAZA','prov_am_res'=>'CHOQUE','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'AUDI COLOR S','prov_dir'=>'AV. JORGE CARRASCO N° 88 ZONA 12 DE OCTUBRE','prov_tel'=>'77271848','prov_nom_res'=>'ELIMIO','prov_ap_res'=>'UTURUNCO','prov_am_res'=>'YUJRA','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'AUTO PIEZAS MOBILITY','prov_dir'=>'AV. PANAMERICANA S/N','prov_tel'=>'4980177','prov_nom_res'=>'4980177','prov_ap_res'=>'NUÑEZ','prov_am_res'=>'MIRANDA','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'BETTY FOTOCOPIAS','prov_dir'=>'CALLE BOLIVAR Nº 700 BARRIO LA PAMPA','prov_tel'=>'66 53461','prov_nom_res'=>'MIRIO GONZALO','prov_ap_res'=>'FLORES','prov_am_res'=>'SUBIA','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'BOHIMAC','prov_dir'=>'CALLE TUMUSLA 489 ','prov_tel'=>'4585402','prov_nom_res'=>'VIRGINIA','prov_ap_res'=>'CABRERA','prov_am_res'=>'MAMANI','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'CARDEL','prov_dir'=>'CALLE LANZA 1190 ESQ. PUNATA ','prov_tel'=>'4222122','prov_nom_res'=>'Florencio','prov_ap_res'=>'Cardenas','prov_am_res'=>'Delgadillo','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'CARPINTERIA Y APICOLA G&M','prov_dir'=>'CALLE BOLIVAR N° 693','prov_tel'=>'6472192-76124045','prov_nom_res'=>'TIMOTEO','prov_ap_res'=>'GARCIA','prov_am_res'=>'BARRIENTOS','prov_tel_res'=>'6472192-76124045','prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'CASA ARMY','prov_dir'=>'AV. AROMA','prov_tel'=>'4660253','prov_nom_res'=>'ZULMA LIZBETH','prov_ap_res'=>'BALDERRAMA','prov_am_res'=>'NAVIA','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'CENTRO DE EST. E INVESTIGACIONES AMERICANO','prov_dir'=>'CALLE MURILLO N°1028 EDIF. CENTRO COMERICIAL PEATONAL','prov_tel'=>'2330482','prov_nom_res'=>'MARCELO','prov_ap_res'=>'TREVIÑO','prov_am_res'=>'TORRICO','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'CODENSA','prov_dir'=>'CALLE 16 DE JULIO N: 185','prov_tel'=>'2259772','prov_nom_res'=>'JUAN RAUL ','prov_ap_res'=>'MONTAN','prov_am_res'=>'MONTAN','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'COLUMBIA VET AGRO','prov_dir'=>'CAMPERO Nº 1039','prov_tel'=>'466-41501','prov_nom_res'=>'ROBERT W.','prov_ap_res'=>'ZURITA','prov_am_res'=>'FERNANDEZ','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'COMER S.R.L.','prov_dir'=>'AV. JUAN PABLO II  Nro 190','prov_tel'=>'75555476','prov_nom_res'=>'ROMER','prov_ap_res'=>'GIRONDA','prov_am_res'=>'PATSI','prov_tel_res'=>'60169419','prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'COMERCIAL "GIMPLAS"','prov_dir'=>'CALLE LEONARDO QUISPE Nª S/N','prov_tel'=>'4133746','prov_nom_res'=>'LEON','prov_ap_res'=>'RENGIFO','prov_am_res'=>'LEON','prov_tel_res'=>'','prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'COMERCIAL "LIMPITO"','prov_dir'=>'CALLE LADISLAO CABRERA N° 518','prov_tel'=>'5258978','prov_nom_res'=>'LOURDES','prov_ap_res'=>'GONSALES','prov_am_res'=>'GONSALES','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'COMERCIAL "SAROM"','prov_dir'=>'CALLE 25 DE MAYO N°608','prov_tel'=>'4501410','prov_nom_res'=>'CARMINIA DODAMIN','prov_ap_res'=>'VARGAS','prov_am_res'=>'ARNEZ','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'COMERCIAL AyL','prov_dir'=>'CALLE HONDURAS ESQ. REPUBLICA','prov_tel'=>'65411017','prov_nom_res'=>'LAURA','prov_ap_res'=>'GONZALES','prov_am_res'=>'HERRERA','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'','prov_dir'=>'','prov_tel'=>'','prov_nom_res'=>'','prov_ap_res'=>'','prov_am_res'=>'','prov_tel_res'=>'','prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'COMERCIAL BRIANITA','prov_dir'=>'AV. REPUBLICA Nº 679','prov_tel'=>'4550808','prov_nom_res'=>'JOS LUIS','prov_ap_res'=>'PACO','prov_am_res'=>'HUANCA','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'COMERCIAL CRISTIAN GABRIEL','prov_dir'=>'CALLE ANGOSTURA EDIF. CENTRO COMERCIAL','prov_tel'=>'70307377','prov_nom_res'=>'ANTONIO','prov_ap_res'=>'URQUIDI','prov_am_res'=>'URQUIDI','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'COMERCIAL E&M','prov_dir'=>'CALLE BALLIVIAN S/N','prov_tel'=>'66 45113','prov_nom_res'=>'EDUARDO','prov_ap_res'=>'MONTOYA','prov_am_res'=>'ROLDAN','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'COMERCIAL EL CONSTRUCTOR','prov_dir'=>'AV. LA PAZ Nº 578 BARRIO VIRGEN DE FATIMA','prov_tel'=>'72966091','prov_nom_res'=>'LUIS ADOLFO','prov_ap_res'=>'ORTIZ','prov_am_res'=>'HOYOS','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'COMERCIAL EL PROGRESO','prov_dir'=>'AV. MORTENSON ','prov_tel'=>'0','prov_nom_res'=>'EUSEBIO','prov_ap_res'=>'PASCUAL','prov_am_res'=>'ROMERO','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'COMERCIAL HIDROPLAST','prov_dir'=>'AV. RENE BARRIENTOS ORTUÑO Nº 1759','prov_tel'=>'4563392','prov_nom_res'=>'LUZ CONCEPCION','prov_ap_res'=>'ZAMBRANA','prov_am_res'=>'ANTEZANA','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'COMERCIAL J. ESTIVARIS','prov_dir'=>'CALLE TUMUSLA Y GRAL. ACHA ','prov_tel'=>'4583211','prov_nom_res'=>'JORGE','prov_ap_res'=>'ESTIVARIZ','prov_am_res'=>'ASCARRUNS','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'COMERCIAL NANDY','prov_dir'=>'IVIRGARZAMA','prov_tel'=>'44545643','prov_nom_res'=>'NAN','prov_ap_res'=>'CESPEDES','prov_am_res'=>'FLORES','prov_tel_res'=>'67342322','prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'COMERCIAL SAN JUAN','prov_dir'=>'CALLE COMERCIO N 62 - ZONA CENTRAL','prov_tel'=>'66-35229','prov_nom_res'=>'JUAN','prov_ap_res'=>'HUAQUIPA','prov_am_res'=>'MAMANI','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'COMERCIAL STIHL','prov_dir'=>'CALLE LA PAZ S/N AV. MORTENSON ','prov_tel'=>'70351449','prov_nom_res'=>'FERNANDO RODRIGO ','prov_ap_res'=>'SOLIZ','prov_am_res'=>'GUTIERREZ','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'COMERCIAL VEIZAGA','prov_dir'=>'CALLE COCAHBAMBA ','prov_tel'=>'76481830','prov_nom_res'=>'CARMINIA','prov_ap_res'=>'VEIZAGA','prov_am_res'=>'MACHADO','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'COMERCIO VICKER','prov_dir'=>'CALLE ARANDA BARRIO SARCOBAMBA','prov_tel'=>'4301865','prov_nom_res'=>'VICTOR HUGO ','prov_ap_res'=>'ANDIA','prov_am_res'=>'BUTRON','prov_tel_res'=>'','prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'CONOCO','prov_dir'=>'CALLE TUMUSLA Y GRAL. ACHA ','prov_tel'=>'4581701','prov_nom_res'=>'EDGAR','prov_ap_res'=>'PIEROLA','prov_am_res'=>'RIVERA','prov_tel_res'=>'','prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'CONTROL EXPERTO INGENIERIA INDUSTRIAL','prov_dir'=>'CALLE INNOMINADA  ZONA BRUNO TIQUIPAYA CBBA','prov_tel'=>'44315262','prov_nom_res'=>'WINSTON JAVIER','prov_ap_res'=>'AYAVIRI','prov_am_res'=>'SIVILA','prov_tel_res'=>'','prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'CONTROLTECH ','prov_dir'=>'AV. HEROINAS Nº 460','prov_tel'=>'4254754','prov_nom_res'=>'WILFREDO','prov_ap_res'=>'MEJIA','prov_am_res'=>'JORDAN','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'CORIMEX LTDA.','prov_dir'=>'C. ISMAEL CESPEDES Nº 1138','prov_tel'=>'4422201','prov_nom_res'=>'CORIMEX LTDA.','prov_ap_res'=>'LTDA.','prov_am_res'=>null,'prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'DISTRIBUIDORA SANFER','prov_dir'=>'AV. LA PAZ Nº 332','prov_tel'=>'66-35161','prov_nom_res'=>'LINO FERNANDO','prov_ap_res'=>'SANCHEZ','prov_am_res'=>'FERNANDEZ','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'DISTRIBUIDORA SUR TARIJA','prov_dir'=>'CALLE ABAROA Nº 1156 BARRIO VIRGEN DE FATIMA','prov_tel'=>'66 43816','prov_nom_res'=>'JULIO SEGUNDINO','prov_ap_res'=>'UGARTE','prov_am_res'=>'RUIZ','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'E.L.Y.','prov_dir'=>'AV. ANGEL BALDIVIEZO S/N BARRIO ARANJUEZ','prov_tel'=>'66-43969','prov_nom_res'=>'ELIANA PATRICIA','prov_ap_res'=>'REJAS','prov_am_res'=>'PEREZ','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'EBENEZER LTDA.','prov_dir'=>'AV. REPUBLICA S-0858 ENTRE 16 DE JULIO ','prov_tel'=>'4252312','prov_nom_res'=>'EBENEZER LTDA.','prov_ap_res'=>'EBENEZER LTDA.','prov_am_res'=>null,'prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'EL MUNDO DE LOS RETENES ','prov_dir'=>'CALLE TUMUSLA N: 322','prov_tel'=>'4584885','prov_nom_res'=>'NELSON DANIEL','prov_ap_res'=>'VARGAS','prov_am_res'=>'MENCHACA','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'EL QUIJOTE SIN MANCHA ','prov_dir'=>'EDIF. RENACER LOCAL 1 ZONA SOPOCACHI ','prov_tel'=>'2416924','prov_nom_res'=>'JORGE ANTONIO ','prov_ap_res'=>'BARRIOS','prov_am_res'=>'REQUENA','prov_tel_res'=>'77295678','prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'ELECTRICA MEN ','prov_dir'=>'CALLE: MURILLO Nº 1155 EDIF. ORURO II','prov_tel'=>'2900818 - 2000590','prov_nom_res'=>'FRANKLIN AMAUCIO','prov_ap_res'=>'MENDOZA','prov_am_res'=>'JALLAZA','prov_tel_res'=>'72558140','prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'ELECTROFRIO','prov_dir'=>'AV. JUANA AZURDUY Nª045','prov_tel'=>'4118438','prov_nom_res'=>'JUANA LUZMILA','prov_ap_res'=>'ANGULO','prov_am_res'=>'ACOSTA','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'ELECTRORED','prov_dir'=>'CALLE TUMUSLA Nº 36','prov_tel'=>'4583221','prov_nom_res'=>'ELECTRORED','prov_ap_res'=>'ELECTRORED BOLIVIA SRL','prov_am_res'=>'ELECTRORED BOLIVIA SRL','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'EQUIMPORT','prov_dir'=>'CALLE CALAMA Nº 340','prov_tel'=>'4250406','prov_nom_res'=>'PASCUAL','prov_ap_res'=>'QUINTEROS','prov_am_res'=>'VEGA','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'ETRAI','prov_dir'=>'AV. CAPITAN VICTOR USTARIS KM 10  S/N','prov_tel'=>'4354355 - 4354327','prov_nom_res'=>'NANCY ANTONIETA ','prov_ap_res'=>'ROJAS','prov_am_res'=>'ZAPATA DE CASTELLON','prov_tel_res'=>'','prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'FERRETERÍA COMERCIAL MERCED','prov_dir'=>'CALLE URUGUAY Nº 679','prov_tel'=>'4506595','prov_nom_res'=>'AMADEO','prov_ap_res'=>'BUSTOS','prov_am_res'=>'MUCHACA','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'FERRETERÍA EMANUEL ','prov_dir'=>'AV. BARRIENTOS ESQ. MAGDALENA','prov_tel'=>'4563437','prov_nom_res'=>'ANA','prov_ap_res'=>'USTARES','prov_am_res'=>'MAMANI','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'FERRETERIA PEREDO','prov_dir'=>'AV. MORTENSON N° S/N','prov_tel'=>'70381125','prov_nom_res'=>'JINGLER','prov_ap_res'=>'PEREDO','prov_am_res'=>'PASCUAL','prov_tel_res'=>'','prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'FERRETERIA Y VIDRIERIA "CHOQUE"','prov_dir'=>'CALLE PACAJES NRO 13 - ZONA MASAYA - ACHACACHI','prov_tel'=>'70503026','prov_nom_res'=>'DIONICIA','prov_ap_res'=>'HUARACHI','prov_am_res'=>'DE CHOQUE','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'FIERRERO','prov_dir'=>'AV. OQUENDO N°863','prov_tel'=>'4029845','prov_nom_res'=>'NESTOR JESUS','prov_ap_res'=>'VERGARA','prov_am_res'=>'COCA','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'FRENZENBOL SRL','prov_dir'=>'AV. DORBIGNI','prov_tel'=>'4430575','prov_nom_res'=>'SUMINISTROS INDUSTRIALES','prov_ap_res'=>'SUMINISTROS INDUSTRIALES','prov_am_res'=>'SUMINISTROS INDUSTRIALES','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'GONZALO VIDAURRE PANIAGUA','prov_dir'=>'AV. PANAMERICANA Nº 1240 BARRIO EL CARMEN','prov_tel'=>'66-76136','prov_nom_res'=>'GONZALO','prov_ap_res'=>'VIDAURRE','prov_am_res'=>'PANIAGUA','prov_tel_res'=>null,'prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
            ['prov_nom'=>'','prov_dir'=>'','prov_tel'=>'','prov_nom_res'=>'','prov_ap_res'=>'','prov_am_res'=>'','prov_tel_res'=>'','prov_obs'=>null,'prov_usr_id'=>1,'prov_id_planta'=>1],
        ];


        foreach($proveedores as $proveedor)
        {
            Proveedor::create($proveedor);
        }
    }
}
