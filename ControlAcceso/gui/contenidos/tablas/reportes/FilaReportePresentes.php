<?php

include_once("gui/contenidos/tablas/reportes/FilaReporte.php");

/**
 * Description of filaReporte
 *
 * @author Ramiro
 */
// TODO Buscar un mejor formato para guardar tiempo acumulado
class FilaReportePresentes extends FilaReporte
{
    private $ingreso;
    private $egresoOficial;
    private $tiempoAcumulado;

    function __construct()
    {
        $this->tiempoAcumulado = '00:00';
        $this->egresoOficial = DateTime::createFromFormat("H:i", '00:00');
    }

    public function getIngreso()
    {
        return $this->ingreso->format('H:i');
    }

    /**
     *
     * @param string $ingreso
     */
    public function setIngreso($ingreso)
    {
        $ingreso = substr($ingreso, 0, 5);
        $this->ingreso = DateTime::createFromFormat('H:i', $ingreso);
    }

    public function getEgresoOficial()
    {
        return $this->egresoOficial->format('H:i');
    }

    public function setEgresoOficial($egresoOficial)
    {
        $egresoOficial = substr($egresoOficial, 0, 5);
        $this->egresoOficial = DateTime::createFromFormat('H:i', $egresoOficial);
    }

    public function getTiempoAcumulado()
    {
        return $this->tiempoAcumulado;
    }

    /**
     *
     * @param string $tiempoAcumulado
     */
    public function setTiempoAcumulado($tiempoAcumulado)
    {
        $this->tiempoAcumulado = $tiempoAcumulado;
    }

    public function imprimirCabecera()
    {
        imprimirTabulados(6);
        echo '<tr>';

        imprimirTabulados(7);
        echo '<th class="tablaReporte">Apellido</th>';
        imprimirTabulados(7);
        echo '<th class="tablaReporte">Nombre</th>';
        imprimirTabulados(7);
        echo '<th class="tablaReporte">Area</th>';
        imprimirTabulados(6);
        echo '<th class="tablaReporte">Hora de ingreso</th>';
        imprimirTabulados(6);
        echo '<th class="tablaReporte">Hora de egreso</th>';
        imprimirTabulados(6);
        echo '<th class="tablaReporte">Tiempo acumulado</th>';

        imprimirTabulados(6);
        echo '</tr>';
    }

    public function imprimir()
    {
        imprimirTabulados(6);
        echo '<tr>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte"><a class="data" href="usuario.php?numeroDocumento='. $this->getNumeroDocumento() . '">' . $this->getApellido() . '</a></td>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte">'. $this->getNombre() . '</td>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte">' . $this->area->getNombreArea() . '</td>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte">' . $this->getIngreso() . '</td>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte">' . $this->getEgresoOficial() . '</td>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte">' . $this->getTiempoAcumulado() . '</td>';

        imprimirTabulados(6);
        echo '</tr>';
    }
}
?>
