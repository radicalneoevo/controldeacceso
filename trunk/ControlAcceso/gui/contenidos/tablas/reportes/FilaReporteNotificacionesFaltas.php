<?php

include_once("gui/contenidos/tablas/reportes/FilaReporte.php");

/**
 * Descripcion de FilaReporteNotificacionFalta
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 02-12-2009
 */
class FilaReporteNotificacionesFaltas extends FilaReporte
{
    protected $fechaFalta;
    protected $horaFalta;
    protected $fechaRecupera;
    protected $horaRecupera;
    protected $fechaRegistro;

    function __construct()
    {

    }

    public function getFechaFalta()
    {
        return $this->fechaFalta->format('d-m-Y');
    }

    public function setFechaFaltaISO($fecha)
    {
        $fecha = trim($fecha);
        $fecha = substr($fecha, 0, 10);
        $fecha = DateTime::createFromFormat('!Y-m-d', $fecha);

        if(!empty($fecha))
            $this->fechaFalta = $fecha;
        else
            throw new Exception('Fecha incorrecta');
    }

    public function getHoraFalta()
    {
        return $this->horaFalta->format('H:i');
    }

    public function setHoraFalta($horaFalta)
    {
        $horaFalta = substr($horaFalta, 0, 5);
        $this->horaFalta = DateTime::createFromFormat('H:i', $horaFalta);
    }

    public function getFechaRecupera()
    {
        return $this->fechaRecupera->format('d-m-Y');
    }

    public function setFechaRecuperaISO($fecha)
    {
        $fecha = trim($fecha);
        $fecha = substr($fecha, 0, 10);
        $fecha = DateTime::createFromFormat('!Y-m-d', $fecha);

        if(!empty($fecha))
            $this->fechaRecupera = $fecha;
        else
            throw new Exception('Fecha incorrecta');
    }

    public function getHoraRecupera()
    {
        return $this->horaRecupera->format('H:i');
    }

    public function setHoraRecupera($horaRecupera)
    {
        $horaRecupera = substr($horaRecupera, 0, 5);
        $this->horaRecupera = DateTime::createFromFormat('H:i', $horaRecupera);
    }

    public function getFechaRegistro()
    {
        return $this->fechaRegistro->format('d-m-Y H:i:s');
    }

    public function setFechaRegistro($fechaRegistro)
    {
        // TODO agregar controles
        $this->fechaRegistro = DateTime::createFromFormat('Y-m-d H:i:s', $fechaRegistro);
    }

    public function imprimirCabecera()
    {
        imprimirTabulados(6);
        echo '<tr>';

        imprimirTabulados(7);
        echo '<th class="tablaReporte">Persona que falta</th>';
        imprimirTabulados(7);
        echo '<th class="tablaReporte">Area</th>';
        imprimirTabulados(7);
        echo '<th class="tablaReporte">Fecha falta</th>';
        imprimirTabulados(7);
        echo '<th class="tablaReporte">Hora falta</th>';
        imprimirTabulados(7);
        echo '<th class="tablaReporte">Fecha recupera</th>';
        imprimirTabulados(7);
        echo '<th class="tablaReporte">Hora recupera</th>';
        imprimirTabulados(7);
        echo '<th class="tablaReporte">Fecha registro</th>';

        imprimirTabulados(6);
        echo '</tr>';
    }

    public function imprimir()
    {
        imprimirTabulados(6);
        echo '<tr>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte"><a class="data" href="usuario.php?numeroDocumento='. $this->getNumeroDocumento() . '">' . $this->getApellido() . ' ' . $this->getNombre() . '</a></td>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte">' . $this->getArea()->getNombreArea() . '</td>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte">' . $this->getFechaFalta() . '</td>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte">' . $this->getHoraFalta() . '</td>';

        // Ya asigno un horario para recuperar
        if(!empty($this->fechaRecupera))
        {
            imprimirTabulados(7);
            echo '<td class="tablaReporte">' . $this->getFechaRecupera() . '</td>';

            imprimirTabulados(7);
            echo '<td class="tablaReporte">' . $this->getHoraRecupera() . '</td>';
        }
        else
        {
            imprimirTabulados(7);
            echo '<td class="tablaReporte"></td>';

            imprimirTabulados(7);
            echo '<td class="tablaReporte"></td>';
        }

        imprimirTabulados(7);
        echo '<td class="tablaReporte">' . $this->getFechaRegistro() . '</td>';

        imprimirTabulados(6);
        echo '</tr>';
    }
}
?>
