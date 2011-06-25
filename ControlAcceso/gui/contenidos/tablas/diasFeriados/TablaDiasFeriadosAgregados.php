<?php
include_once("gui/contenidos/tablas/diasFeriados/TablaDiasFeriados.php");

/**
 * Representa una tabla con los días feriados agregados.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 20-12-2009
 * @version 0.5
 */
class TablaDiasFeriadosAgregados extends TablaDiasFeriados
{
    function __construct($diasFeriados)
    {
        parent::__construct($diasFeriados);
    }
}
?>
