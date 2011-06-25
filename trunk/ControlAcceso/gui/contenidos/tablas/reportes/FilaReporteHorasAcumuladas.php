<?php

include_once("gui/contenidos/tablas/reportes/FilaReporte.php");

/**
 * Descripcion de filaReporteHorasAcumuladas
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 04-12-2009
 */
// TODO Buscar un mejor formato para guardar tiempo acumulado
class FilaReporteHorasAcumuladas extends FilaReporte
{
    private $horasHabitualesAsignadas;
    private $horasHabitualesCumplidas;
    private $horasCompensadasPorOtroUsuario;
    private $horasCompensadasPorUsuario;
    private $horasCompensadasAOtroUsuario;
    private $horasExtras;

    function __construct()
    {
        $this->horasHabitualesAsignadas = '00:00';
        $this->horasHabitualesCumplidas = '00:00';
        $this->horasCompensadasPorOtroUsuario = '00:00';
        $this->horasCompensadasPorUsuario = '00:00';
        $this->horasCompensadasAOtroUsuario = '00:00';
        $this->horasExtras = '00:00';
    }

    public function getHorasHabitualesAsignadas()
    {
        return $this->horasHabitualesAsignadas;
    }

    public function setHorasHabitualesAsignadas($horasHabitualesAsignadas)
    {
        $this->horasHabitualesAsignadas = $horasHabitualesAsignadas;
    }

    public function getHorasHabitualesCumplidas()
    {
        return $this->horasHabitualesCumplidas;
    }

    public function setHorasHabitualesCumplidas($horasHabitualesCumplidas)
    {
        $this->horasHabitualesCumplidas = $horasHabitualesCumplidas;
    }

    public function getHorasCompensadasPorOtroUsuario()
    {
        return $this->horasCompensadasPorOtroUsuario;
    }

    public function setHorasCompensadasPorOtroUsuario($horasCompensadasPorOtroUsuario)
    {
        $this->horasCompensadasPorOtroUsuario = $horasCompensadasPorOtroUsuario;
    }

    public function getHorasCompensadasPorUsuario()
    {
        return $this->horasCompensadasPorUsuario;
    }

    public function setHorasCompensadasPorUsuario($horasCompensadasPorUsuario)
    {
        $this->horasCompensadasPorUsuario = $horasCompensadasPorUsuario;
    }

    public function getHorasCompensadasAOtroUsuario()
    {
        return $this->horasCompensadasAOtroUsuario;
    }

    public function setHorasCompensadasAOtroUsuario($horasCompensadasAOtroUsuario)
    {
        $this->horasCompensadasAOtroUsuario = $horasCompensadasAOtroUsuario;
    }

    public function getHorasExtras()
    {
        return $this->horasExtras;
    }

    public function setHorasExtras($horasExtras)
    {
        $this->horasExtras = $horasExtras;
    }

    public function imprimirCabecera()
    {
        imprimirTabulados(6);
        echo '<tr>';

        imprimirTabulados(7);
        echo '<th class="tablaReporte">Nombre</th>';
        imprimirTabulados(7);
        echo '<th class="tablaReporte">Apellido</th>';
        imprimirTabulados(7);
        echo '<th class="tablaReporte">Area</th>';
        imprimirTabulados(7);
        echo '<th class="tablaReporte">Horas habituales asignadas</th>';
        imprimirTabulados(7);
        echo '<th class="tablaReporte">Horas habituales cumplidas</th>';
        imprimirTabulados(7);
        echo '<th class="tablaReporte">Horas compensadas por usuario</th>';
        imprimirTabulados(7);
        echo '<th class="tablaReporte">Horas compensadas por otro usuario</th>';
        imprimirTabulados(7);
        echo '<th class="tablaReporte">Horas compensadas a otro usuario</th>';
        imprimirTabulados(7);
        echo '<th class="tablaReporte">Horas extras</th>';

        imprimirTabulados(6);
        echo '</tr>';
    }

    public function imprimir()
    {
        imprimirTabulados(6);
        echo '<tr>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte">'. $this->getNombre() . '</td>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte"><a class="data" href="usuario.php?numeroDocumento='. $this->getNumeroDocumento() . '">' . $this->getApellido() . '</a></td>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte">' . $this->area->getNombreArea() . '</td>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte">' . $this->getHorasHabitualesAsignadas() . '</td>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte">' . $this->getHorasHabitualesCumplidas() . '</td>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte">' . $this->getHorasCompensadasPorUsuario() . '</td>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte">' . $this->getHorasCompensadasPorOtroUsuario() . '</td>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte">' . $this->getHorasCompensadasAOtroUsuario() . '</td>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte">' . $this->getHorasExtras() . '</td>';

        imprimirTabulados(6);
        echo '</tr>';
    }
}
?>
