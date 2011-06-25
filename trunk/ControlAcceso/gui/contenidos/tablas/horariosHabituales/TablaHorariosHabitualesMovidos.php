<?php
include_once("gui/contenidos/tablas/horariosHabituales/TablaHorariosHabituales.php");

/**
 * Representa una tabla con los horarios habituales movidos.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 20-12-2009
 * @version 0.5
 */
class TablaHorariosHabitualesMovidos extends TablaHorariosHabituales
{
    function __construct($horarios)
    {
        parent::__construct($horarios);
    }
}
?>
