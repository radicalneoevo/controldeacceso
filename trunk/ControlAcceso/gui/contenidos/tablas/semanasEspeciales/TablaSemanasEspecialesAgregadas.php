<?php
include_once("gui/contenidos/tablas/semanasEspeciales/TablaSemanasEspeciales.php");

/**
 * Representa una tabla con las semanas especiales agregadas.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 20-12-2009
 * @version 0.5
 */
class TablaSemanasEspecialesAgregadas extends TablaSemanasEspeciales
{
    function __construct($semanasEspeciales)
    {
        parent::__construct($semanasEspeciales);
    }
}
?>
