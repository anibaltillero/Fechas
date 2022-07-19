<?php

/** ----------------------------------------------------------------------------
 *  Ayudantes para Fechas      
 * 
 *     Descripcion  : Convertir la fecha formato espa�ol a formato Base de datos
 *       @author   : Anibal G. Tillero O.
 *  Date created    : 19/07/2022            Date updated: 19/07/2022
 *       Docs By    : Anibal G. Tillero O.
 *     @copyright  : (c) 2022 by Ing Anibal Tillero.
 * -----------------------------------------------------------------------------
 */
class Fechas {

    // -------------------------------------------------------------------------
    // Declaracion de las Propiedades
    // -------------------------------------------------------------------------
    // Cantidades de Segundos incremental
    const YEAR = 31556926;
    const MONTH = 2629744;
    const WEEK = 604800;
    const DAY = 86400;
    const HOUR = 3600;
    const MINUTE = 60;

    /**
     *   Formatos disponibles para Fecha::meses()
     *  @var  string
     */
    const MONTHS_LONG = '%B';
    const MONTHS_SHORT = '%b';

    /**
     *  Formatos para la representacion numerica del dia de la semana.
     *  0 (para domingo hasta 6 (para sabado). 
     * 
     *  @var  string
     */
    const FORMATO_DIA_SEMANA = 'w';

  /**
     *  Formato para la Representación numérica ( 1 al 12 ) de los meses del año, 
     *  sin ceros iniciales.
     *  
     *  @var  string
     */
    const FOMATO_DIA_MES = 'n';

  /**
     *   Separado de fechas en PostgreSQL
     *  @var  string
     */
    const SEPARADOR = '-';

  /**
     * Arreglo con los Dias de la semana en Español
     * @var Array
     */
    public static $arrSemanas = array('Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado');

  /**
     * Arreglo con los Nombre de los meses del año en Español
     * @var Array
     */
    public static $arrMeses = array('Elige..', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

  /**
     *  Utitilizada por el metodo FechaDB para convertir la fecha en formato ES o US 
     * @var Array
     */
    private static $fecha_es_ins;
    private static $anio_ins;
    private static $mes_ins;
    private static $dia_ins;
    private static $timestamp_ins;
    private static $meses_letras_ins;
    private static $semanas_letras_ins;

  /**
     *  Utitilizada por el metodo FechaDB para convertir la fecha en formato ES o US 
     * @var Array
     */
    private static $fechaHOY;
    private static $fechaDB;
    private static $anio;
    private static $mes;
    private static $dia;
    private static $timestamp;
    private static $meses_letras;
    private static $semanas_letras;

  /**
     *  Descripcion: Permite instanciar la Clase Fecha, retonar por separado lo siguinetes datos:
     *                          Dia, mes, año, Fecha en formato dd-mm-yyyy, timestamp, semana en letras
     *                        meses en letras
     * 
     *  @example:   Fecha::setIns(  '31-12-2015');              
     *  @example:   Fecha::setIns(  '2015-12-31');  
     */
      public static function setIns($date = '') {
  

        if ($date) {
            $obj = new DateTime($date);

            Fechas::$anio_ins= (int) $obj->format('Y');
            Fechas::$mes_ins = (int) $obj->format('m');
            Fechas::$dia_ins = (int) $obj->format('d');

            Fechas::$fecha_es_ins = Fechas::$dia_ins . Fechas::SEPARADOR . Fechas::$mes_ins . Fechas::SEPARADOR . Fechas::$anio_ins;

            Fechas::$timestamp_ins = mktime(0, 0, 0, Fechas::$mes_ins, Fechas::$dia_ins, Fechas::$anio_ins);

            Fechas::$semanas_letras_ins = Fechas::$arrSemanas[date(Fechas::FORMATO_DIA_SEMANA, Fechas::$timestamp_ins)];
            Fechas::$meses_letras_ins = Fechas::$arrMeses[date("n", Fechas::$timestamp_ins)];
        } else {
            Fechas::$anio_ins = date("Y");
            Fechas::$mes_ins = date('m');
            Fechas::$dia_ins = date('d');
            Fechas::$fecha_es_ins = Fechas::$dia_ins . Fechas::SEPARADOR . Fechas::$mes_ins . Fechas::SEPARADOR . Fechas::$anio_ins;

            Fechas::$timestamp_ins = time();

            Fechas::$semanas_letras_ins = Fechas::$arrSemanas[date(Fechas::FORMATO_DIA_SEMANA, Fechas::$timestamp_ins)];
            Fechas::$meses_letras_ins = Fechas::$arrMeses[date(fechas::FOMATO_DIA_MES, Fechas::$timestamp_ins)];
        }
    }

  /**
     *  Descripcion: Permite mostar la fecha pasada al metodo instanciar
     * 
     *  @see Instanciar
     * 
     *  @example Fecha::setIns('31-12-2015');              
     *  @example Fecha::getInsFecha() ;      Resultado:  31-12-2015
     *  
     *  @return date Fecha en formato dd-mm-yyyy.
     */
    public static function getInsFecha() {
        return Fechas::$fecha_es_ins;
    }

    public static function getInsTimestamp() {
        return self::$timestamp_ins;
    }
    
  /**
     *  Descripcion: Retorna el dia 
     * 
     *   @example Fecha::setIns('31-12-2015');              
     *   @example Fecha::getInsDia( );               //  31  
     * 
     * @return  string  Retorna el dia_ins   
     */
    public static function getInsDia() {
        return sprintf("%02s", Fechas::$dia_ins);
    }

  /**
     *  Descripcion: Permite mostar el Mes al metodo instanciar
     * 
     *  @example Fecha::setIns('31-12-2015');              
     *  @example Fecha::getInsMes();  Resultado: 12             
     *  
     */
    public static function getInsMes() {
        return sprintf("%02s", Fechas::$mes_ins);
    }

 /**
     *  Descripcion: Permite mostar el Año al metodo instanciar
     * 
     *  @example Fecha::setIns('31-12-2015');              
     *  @example Fecha::getInsAnio();  Resultado: 2015             
     *  
     *  @return string Cadena del anio
     */
    public static function getInsAnio() {
        return Fechas::$anio_ins;
    }
    
    

    /**
     *  Descripcion: Permite mostar la Semana en Letras 
     * 
     *  @see Instanciar
     * 
     *  @example Fecha::setIns('31-12-2015');              
     *  @example Fecha::setInsSemanas();  //Resultado: Jueves
     *       *  @return string Cadena de nombre de la semana
     */
    public static function getInsSemanas() {
        return Fechas::$semanas_letras_ins;
    }

    public static function getInsMeses() {
        return Fechas::$meses_letras_ins;
    }

  /**
     *  Descripcion: Retorna la fecha de Hoy en formato dd-mm-yyyy 
     * 
     *  @example:   Fecha::Hoy()          
     *
     *  @return date Retorna la fecha de hoy
     */
    public static function getHoy($idioma = 'ES') {

        Fechas::$anio = date("Y");
        Fechas::$mes = date('m');
        Fechas::$dia = date('d');
        if (strtoupper($idioma) == 'ES') {

            Fechas::$fechaHOY = Fechas::$dia . Fechas::SEPARADOR . Fechas::$mes . Fechas::SEPARADOR . Fechas::$anio;
        } elseif (strtoupper($idioma) == 'US') {
            Fechas::$fechaHOY = Fechas::$anio . Fechas::SEPARADOR . Fechas::$mes . Fechas::SEPARADOR . Fechas::$dia;
        }

        return Fechas::$fechaHOY;
    }

  /**
     *  Descripcion: Retorna el dia en letras de la semana.
     * 
     *     Fecha::setSemana( '31-12-2015'); //  Jueves
     *     Fecha::setSemana( '2015-12-31'); //  Jueves
     *
     * @param   cadena  $month  number of month
     * @return  string  Retorna el año   
     */
    public static function setSemanas($fecha) {

        $obj = new DateTime($fecha);
        Fechas::$anio = (int) $obj->format('Y');
        Fechas::$mes = (int) $obj->format('m');
        Fechas::$dia = (int) $obj->format('d');
        Fechas::$timestamp = mktime(0, 0, 0, Fechas::$mes, Fechas::$dia, Fechas::$anio);

        return Fechas::$arrSemanas[date(Fechas::FORMATO_DIA_SEMANA, Fechas::$timestamp)];
    }

  /**
     *  Descripcion: Retorna el dia en letras de la semana.
     * 
     *     Fecha::Semana( '31-12-2015'); //  Jueves
     *     Fecha::Semana( '2015-12-31'); //  Jueves
     *
     * @param   cadena  $month  number of month
     * @param   cadena  $year   number of year to check month, defaults to the current year
     * @return  string  Retorna el año   
     */
    public static function setMeses($fecha) {


        if (isset($fecha)) {
            $obj = new DateTime($fecha);
            Fechas::$anio = (int) $obj->format('Y');
            Fechas::$mes = (int) $obj->format('m');
            Fechas::$dia = (int) $obj->format('d');
            Fechas::$timestamp = mktime(0, 0, 0, Fechas::$mes, Fechas::$dia, Fechas::$anio);
        } else {
            Fechas::$timestamp = time();
        }
        return Fechas::$arrMeses[date("n", Fechas::$timestamp)];
    }

  /**
     *  Descripcion: Retorna el año de una fecha 
     * 
     *     Fecha::Anio( 31-12-2015); //  2015
     *     Fecha::Anio( 2015-12-31); //  2015
     *
     * @param   cadena  $month  number of month
     * @param   cadena  $year   number of year to check month, defaults to the current year
     * @return  string  Retorna el año   
     */
    public static function setAnio($fecha) {

        $obj = new DateTime($fecha);
        Fechas::$anio = $obj->format('Y');

        return Fechas::$anio;
    }

  /**
     *  Descripcion: Retorna el año de una fecha 
     * 
     *     Fecha::Anio( 31-12-2015); //  2015   Formato: dd-mm-yyyy
     *     Fecha::Anio( 2015-12-31); //  2015   Formato: yyyy-mm-dd
     *
     * @param   date  Fecha del sistema en cualquiera de los formatos anteriores.
     * @return  string  Retorna el dia   
     */
    public static function setDia($fecha) {

        $obj = new DateTime($fecha);
        Fechas::$dia = $obj->format('d');

        return Fechas::$dia;
    }

  /**
     *  Descripcion: Retorna el año de una fecha 
     * 
     *     Fecha::Anio( 31-12-2015); //  2015
     *     Fecha::Anio( 2015-12-31); //  2015
     *
     * @param   cadena  $month  number of month
     * @param   cadena  $year   number of year to check month, defaults to the current year
     * @return  string  Retorna el año   
     */
    public static function setMes($fecha) {

        $obj = new DateTime($fecha);
        $mes = $obj->format('m');

        return $mes;
    }

  /**
     * Descripcion: Se debe colocar en el body  de los programa para deplegar 
     *              los calendarios de fecha.
     * 
     * @example Fechas::setiFrameCalendario();   
     *  
     */
    public static function setiFrameCalendario() {
        ?>
        <iframe width=180 height=189 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../clases/js/calendarios/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
        </iframe>

        <?php

    }

  /**
     *  Descripcion: Utilizada para convertir la fecha de la base de datos en:
     *               (1) Formato [ES] español para mostrarla en los browser. 
     *               (2) Formato [US] para ser guardada en la base de datos.
     *  
     *  @example    Fechas::setFecha($fecha,'ES'); 
     *  @resultado   Resultado: dd-mm-yyyy.  
     *   
     *  @example Fechas::setFecha($fecha);       Resultado: yyyy-mm-dd.  (POR DEFECTO)
     *  @resultado   Resultado: dd-mm-yyyy.     
     * 
     * @param   date     $fecha  fecha en cualquier formato valido. 
     * @return  date     Retorna una fecha 
     *  
     */
    public static function setFecha_db($fecha, $idioma = 'US') {

        try {
            $obj = new DateTime($fecha);

            Fechas::$anio = (int) $obj->format('Y');
            Fechas::$mes = (int) $obj->format('m');
            Fechas::$dia = (int) $obj->format('d');

            if (strtoupper($idioma) == 'US') {
                Fechas::$fechaDB = Fechas::$anio . Fechas::SEPARADOR . sprintf("%02s", Fechas::$mes) . Fechas::SEPARADOR . sprintf("%02s", Fechas::$dia);
            } elseif (strtoupper($idioma) == 'ES') {
                Fechas::$fechaDB = sprintf("%02s", Fechas::$dia) . Fechas::SEPARADOR . sprintf("%02s", Fechas::$mes) . Fechas::SEPARADOR . Fechas::$anio;
            }

            return Fechas::$fechaDB;
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

  /**
     *  Descripcion: Número de días en un mes de un año determinado. 
     *               Normalmente se utiliza como un acceso directo para 
     *               generar una lista que se puede utilizar en un formulario 
     * 
     *     Fecha::dias(4, 2010); // 1, 2, 3, ..., 28, 29, 30
     *
     * @param   integer $month  number of month
     * @param   integer $year   number of year to check month, defaults to the current year
     * @return  array   A mirrored (foo => foo) array of the days.
     */
    public static function lista_dias($month, $year = FALSE) {
        static $months;

        if ($year === FALSE) {
            // Use the current year by default
            $year = date('Y');
        }

        // Always integers
        $month = (int) $month;
        $year = (int) $year;

        // We use caching for months, because time functions are used
        if (empty($months[$year][$month])) {
            $months[$year][$month] = array();

            // Use date to find the number of days in the given month
            $total = date('t', mktime(1, 0, 0, $month, 1, $year)) + 1;

            for ($i = 1; $i < $total; $i++) {
                $months[$year][$month][$i] = (string) $i;
            }
        }

        return $months[$year][$month];
    }

  /**
     * Returns an array of years between a starting and ending year. By default,
     * the the current year - 5 and current year + 5 will be used. Typically used
     * as a shortcut for generating a list that can be used in a form.
     *
     *     $years = Date::years(2000, 2010); // 2000, 2001, ..., 2009, 2010
     *
     * @param   integer $start  starting year (default is current year - 5)
     * @param   integer $end    ending year (default is current year + 5)
     * @return  array
     */
    public static function lista_anios($start = FALSE, $end = FALSE) {
        // Default values
        
        $start = ($start === FALSE) ? (date('Y') - 5) : (int) $start;
        $end = ($end === FALSE) ? (date('Y') + 5) : (int) $end;

        $years = array();

        for ($i = $start; $i <= $end; $i++) {
            $years[$i] = (string) $i;
        }

        return $years;
    }

    
    
        /**
     *  Descripcion: Utilizada para convertir la fecha de la base de datos en:
     *               (1) Formato [ES] español para mostrarla en los browser. 
     *               (2) Formato [US] para ser guardada en la base de datos.
     *  
     *  @example    Fechas::setFecha($fecha,'ES'); 
     *  @resultado   Resultado: dd-mm-yyyy.  
     *   
     *  @example Fechas::setFecha($fecha);       Resultado: yyyy-mm-dd.  (POR DEFECTO)
     *  @resultado   Resultado: dd-mm-yyyy.     
     * 
     * @param   date     $fecha  fecha en cualquier formato valido. 
     * @return  date     Retorna una fecha 
     *  
     */
    public static function setTimeZone_db($fecha) {

        try {
            $obj = new DateTime($fecha);

            Fechas::$anio = (int) $obj->format('Y');
            Fechas::$mes = (int) $obj->format('m');
            Fechas::$dia = (int) $obj->format('d');

            
         Fechas::$timestamp = Fechas::$anio . Fechas::SEPARADOR . sprintf("%02s", Fechas::$mes) . Fechas::SEPARADOR . sprintf("%02s", Fechas::$dia) .' '.  date("H:i:s.000") ;
       

            return Fechas::$timestamp;
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

    

}
