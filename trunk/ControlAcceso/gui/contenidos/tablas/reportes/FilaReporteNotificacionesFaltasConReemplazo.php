<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

/**
 * 
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 07-05-2010
 * @version 0.5
 */
class FilaReporteNotificacionesFaltasConReemplazo extends FilaReporteNotificacionesFaltas
{
    private $nombreRecupera;
    private $apellidoRecupera;
    private $numeroDocumentoRecupera;

    function __construct()
    {

    }

    public function getNombreRecupera()
    {
        return $this->nombreRecupera;
    }

    public function setNombreRecupera($nombreRecupera)
    {
        $this->nombreRecupera = $nombreRecupera;
    }

    public function getApellidoRecupera()
    {
        return $this->apellidoRecupera;
    }

    public function setApellidoRecupera($apellidoRecupera)
    {
        $this->apellidoRecupera = $apellidoRecupera;
    }

    public function getNumeroDocumentoRecupera()
    {
        return $this->numeroDocumentoRecupera;
    }

    public function setNumeroDocumentoRecupera($numeroDocumentoRecupera)
    {
        $this->numeroDocumentoRecupera = $numeroDocumentoRecupera;
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
        echo '<th class="tablaReporte">Persona que recupera</th>';
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

        // Ya designo una persona que reemplaza
        if(!empty($this->numeroDocumentoRecupera))
        {
            imprimirTabulados(7);
            echo '<td class="tablaReporte"><a class="data" href="usuario.php?numeroDocumento='. $this->getNumeroDocumentoRecupera() . '">' . $this->getApellidoRecupera() . ' ' . $this->getNombreRecupera() . '</a></td>';

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
