<?php
include_once("gui/contenidos/tablas/TablaHorariosHabituales.php");

/**
 * Representa una tabla con los horarios habituales eliminados.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 20-12-2009
 * @version 0.5
 */
class TablaHorariosHabitualesEliminados extends TablaHorariosHabituales
{
    function __construct($horarios)
    {
        parent::__construct($horarios);
    }
}
?>
