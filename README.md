# Fechas
PHP: Class para el tratamiento de Fechas. 
<h1>PHP: Class para el tratamiento de fechas en php </h1>

<b>Requerimientos</b>
PHP 5.0 o superior

Ejemplo de uso 

<?php

require_once 'Fechas.php';

// Asignamos el valor de la Fecha a la variable $fecha

$fecha = date( 'd-m-Y');



echo 'Fecha de hoy: ' . Fechas::getHoy('ES')

echo 'Dia' . Fechas::setDia( $fecha ) ;

echo 'Mes' . Fechas::setMes( $fecha );

echo 'Año ' . Fechas::setAnio( $fecha ) ;

echo 'Meses ' . Fechas::setMeses( $fecha )

echo Fechas::setFecha_db($fecha, 'ES');

 echo Fechas::setFecha_db($fecha, 'US');





?>

