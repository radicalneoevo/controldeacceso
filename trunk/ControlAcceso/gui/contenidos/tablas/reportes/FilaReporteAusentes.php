<?php

include_once("gui/contenidos/tablas/reportes/FilaReporte.php");

/**
 * Descripcion de filaReporteAusentes
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 02-12-2009
 */
class FilaReporteAusentes extends FilaReporte
{
    private $telefonoCelular;
    private $email;
    private $ingresoOficial;
    private $egresoOficial;
    private $notificoFalta;

    function __construct()
    {

    }

    public function getTelefonoCelular()
    {
        return $this->telefonoCelular;
    }

    public function setTelefonoCelular($telefonoCelular)
    {
        $this->telefonoCelular = $telefonoCelular;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getIngresoOficial()
    {
        return $this->ingresoOficial->format('H:i');
    }

    public function setIngresoOficial($ingresoOficial)
    {
        $ingresoOficial = substr($ingresoOficial, 0, 5);
        $this->ingresoOficial = DateTime::createFromFormat('H:i', $ingresoOficial);
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

    public function getNotificoFalta()
    {
        return $this->notificoFalta;
    }

    public function setNotificoFalta($notificoFalta)
    {
        $this->notificoFalta = $notificoFalta;
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
        echo '<th class="tablaReporte">Celular</th>';
        imprimirTabulados(6);
        echo '<th class="tablaReporte">Email</th>';
        imprimirTabulados(6);
        echo '<th class="tablaReporte">Hora de ingreso</th>';
        imprimirTabulados(6);
        echo '<th class="tablaReporte">Hora de egreso</th>';
        imprimirTabulados(6);
        echo '<th class="tablaReporte">Notificó falta</th>';

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
        echo '<td class="tablaReporte">' . $this->getNombre() . '</td>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte">' . $this->getTelefonoCelular() . '</td>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte"><a class="data" href="mailto:' . $this->getEmail() . '">' . $this->getEmail() . '</a></td>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte">' . $this->getIngresoOficial() . '</td>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte">' . $this->getEgresoOficial() . '</td>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte">' .
        ($this->getNotificoFalta() != 0 ?
        '<a class="data" href="notificacionfalta.php?notificacion=' .
        $this->getNotificoFalta() . '">Si' : 'No')  . '</td>';

        imprimirTabulados(6);
        echo '</tr>';
    }
}
?>
