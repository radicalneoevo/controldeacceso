<?php
include_once("gui/contenidos/tablas/TablaHorariosAsignados.php");

/**
 * Representa una tabla con los horarios asignados eliminados.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 20-12-2009
 * @version 0.5
 */
class TablaHorariosAsignadosEliminados extends TablaHorariosAsignados
{
    function __construct($horarios)
    {
        parent::__construct($horarios);
    }
}
?>
