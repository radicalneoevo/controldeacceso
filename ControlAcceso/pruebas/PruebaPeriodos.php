<?php
include_once("entidad/Periodo.php");

$periodo = new Periodo();

echo 'is_null($periodo->getInicio()): ' . is_null($periodo->getInicio());
echo 'empty($periodo->getInicio()): ' . $periodo->getInicio();
?>
