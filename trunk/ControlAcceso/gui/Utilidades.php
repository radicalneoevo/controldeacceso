<?php

    function imprimirTabulados($value)
    {
        $string = "\n";

        for($i = 1; $i <= $value; $i++)
            $string = $string . "\t";

        echo $string;
    }

    // Convierte fechas del formato AAAA-MM-DD a DD-MM-AAAA
    function fechaDMA($amd)
    {
        return substr($amd, 8, 2)."-".substr($amd, 5, 2)."-".substr($amd, 0, 4);
    }

    // Convierte fechas del formato DD-MM-AAAA a AAAA-MM-DD
    function fechaAMD($dma)
    {
        return substr($dma, 7, 4)."-".substr($dma, 4, 2)."-".substr($dma, 1, 2);
    }

    /**
     * Valida una fecha en formato DD-MM-AAAA. Lanza una excepción en caso de error.
     */
    function validarFecha($fecha)
    {
        $fecha = trim($fecha);
        $fecha = substr($fecha, 0, 10);
        $fecha = DateTime::createFromFormat('!d-m-Y', $fecha);

        // Error al parsear la fecha
        if(!empty($fecha))
            return;
        else
            throw new Exception('Fecha incorrecta');
    }

    /**
     * Valida un intervalo de fechas en formato DD-MM-AAAA. Lanza una excepción en caso de error.
     */
    function validarIntervaloFechas($fechaInicio, $fechaFin)
    {
        $fechaInicio = trim($fechaInicio);
        $fechaInicio = substr($fechaInicio, 0, 10);
        $fechaInicio = DateTime::createFromFormat('!d-m-Y', $fechaInicio);

        $fechaFin = trim($fechaFin);
        $fechaFin = substr($fechaFin, 0, 10);
        $fechaFin = DateTime::createFromFormat('!d-m-Y', $fechaFin);

        // Fechas bien formadas ?
        if(!empty($fechaInicio) && !empty($fechaFin))
            // La fecha de fin es mayor o igual a la de inicio ?
            if($fechaInicio->getTimeStamp() <= $fechaFin->getTimeStamp())
                return;
            else
                throw new Exception('La fecha de inicio es mayor a la de fin');
        else
            throw new Exception('Intervalo de fechas incorrecto');;
    }

    /**
     * Valida un intervalo de fechas en formato DD-MM-AAAA. Lanza una excepción en caso de error.
     */
    function validarIntervaloFechasFuturo($fechaInicio, $fechaFin)
    {
        // Fecha actual a las 00:00:00
        $fechaActual = new DateTime();
        $fechaActual->setTime(0, 0, 0);

        $fechaInicio = trim($fechaInicio);
        $fechaInicio = substr($fechaInicio, 0, 10);
        $fechaInicio = DateTime::createFromFormat('!d-m-Y', $fechaInicio);

        $fechaFin = trim($fechaFin);
        $fechaFin = substr($fechaFin, 0, 10);
        $fechaFin = DateTime::createFromFormat('!d-m-Y', $fechaFin);

        // Fechas bien formadas ?
        if(!empty($fechaInicio) && !empty($fechaFin))
            // La fecha de fin es mayor o igual a la de inicio ?
            if($fechaInicio->getTimeStamp() <= $fechaFin->getTimeStamp())
                // Fecha de inicio mayor o igual a la actual ?
                if($fechaInicio->getTimeStamp() >= $fechaActual->getTimeStamp())
                    return;
                else
                    throw new Exception('La fecha de inicio debe ser la actual o una futura');
            else
                throw new Exception('La fecha de inicio es mayor a la de fin');
        else
            throw new Exception('Intervalo de fechas incorrecto');
    }
?>
