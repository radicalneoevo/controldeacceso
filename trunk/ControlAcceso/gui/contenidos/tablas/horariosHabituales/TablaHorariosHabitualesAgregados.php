<?php
include_once("gui/contenidos/tablas/horariosHabituales/TablaHorariosHabituales.php");

/**
 * Representa una tabla con los horarios habituales agregados.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 20-12-2009
 * @version 0.5
 */
class TablaHorariosHabitualesAgregados extends TablaHorariosHabituales
{
    function __construct($horarios)
    {
        parent::__construct($horarios);
    }
}
?>
