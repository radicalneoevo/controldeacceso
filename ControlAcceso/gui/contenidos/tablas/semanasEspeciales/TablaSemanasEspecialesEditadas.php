<?php
include_once("gui/contenidos/tablas/semanasEspeciales/TablaSemanasEspeciales.php");

/**
 * Representa una tabla con las semanas especiales editadas.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 20-12-2009
 * @version 0.5
 */
class TablaSemanasEspecialesEditadas extends TablaSemanasEspeciales
{
    function __construct($semanasEspeciales)
    {
        parent::__construct($semanasEspeciales);
    }
}
?>
