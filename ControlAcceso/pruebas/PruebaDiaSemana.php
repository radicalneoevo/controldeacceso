
<?php

include_once("entidad/DiaSemana.php");

$diaSemana = new DiaSemana(1);
echo '<p>DiaSemana(1): ' . $diaSemana->getNombre() . '--' . $diaSemana->getIdDiaSemana()  .'</p>';

$diaSemana = new DiaSemana(2);
echo '<p>DiaSemana(2): ' . $diaSemana->getNombre() . '--' . $diaSemana->getIdDiaSemana()  .'</p>';

$diaSemana = new DiaSemana(3);
echo '<p>DiaSemana(3): ' . $diaSemana->getNombre() . '--' . $diaSemana->getIdDiaSemana()  .'</p>';

$diaSemana = new DiaSemana(4);
echo '<p>DiaSemana(4): ' . $diaSemana->getNombre() . '--' . $diaSemana->getIdDiaSemana()  .'</p>';

$diaSemana = new DiaSemana(5);
echo '<p>DiaSemana(5): ' . $diaSemana->getNombre() . '--' . $diaSemana->getIdDiaSemana()  .'</p>';

$diaSemana = new DiaSemana(6);
echo '<p>DiaSemana(6): ' . $diaSemana->getNombre() . '--' . $diaSemana->getIdDiaSemana()  .'</p>';

$diaSemana = new DiaSemana(7);
echo '<p>DiaSemana(7): ' . $diaSemana->getNombre() . '--' . $diaSemana->getIdDiaSemana()  .'</p>';

$diaSemana->setNombre('Lunes');
echo '<p>$diaSemana->setNombre(\'Lunes\'): ' . $diaSemana->getNombre() . '--' . $diaSemana->getIdDiaSemana()  .'</p>';

$diaSemana->setNombre('Martes');
echo '<p>$diaSemana->setNombre(\'Martes\'): ' . $diaSemana->getNombre() . '--' . $diaSemana->getIdDiaSemana()  .'</p>';

$diaSemana->setNombre('Miercoles');
echo '<p>$diaSemana->setNombre(\'Miercoles\'): ' . $diaSemana->getNombre() . '--' . $diaSemana->getIdDiaSemana()  .'</p>';

$diaSemana->setNombre('Jueves');
echo '<p>$diaSemana->setNombre(\'Jueves\'): ' . $diaSemana->getNombre() . '--' . $diaSemana->getIdDiaSemana()  .'</p>';

$diaSemana->setNombre('Viernes');
echo '<p>$diaSemana->setNombre(\'Viernes\'): ' . $diaSemana->getNombre() . '--' . $diaSemana->getIdDiaSemana()  .'</p>';

$diaSemana->setNombre('Sabado');
echo '<p>$diaSemana->setNombre(\'Sabado\'): ' . $diaSemana->getNombre() . '--' . $diaSemana->getIdDiaSemana()  .'</p>';

$dia1 = new DiaSemana(1);
$dia2 = new DiaSemana(2);

echo '<p>$dia1->igual($dia2) ? ' . ($dia1->igual($dia2) ? 'Si' : 'No') . '</p>'

?>
