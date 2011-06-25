<?php
include_once("gui/contenidos/tablas/diasFeriados/TablaDiasFeriados.php");

/**
 * Representa una tabla con los dias feriados eliminados.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 20-12-2009
 * @version 0.5
 */
class TablaDiasFeriadosEliminados extends TablaDiasFeriados
{
    function __construct($diasFeriados)
    {
        parent::__construct($diasFeriados);
    }
}
?>
