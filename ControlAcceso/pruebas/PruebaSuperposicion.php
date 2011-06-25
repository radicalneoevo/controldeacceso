<?php

include_once("entidad/Horario.php");

$horario1 = new Horario();
$horario1->setIngreso('01:00');
$horario1->setEgreso('13:00');

$horario2 = new Horario();
$horario2->setIngreso('15:00');
$horario2->setEgreso('18:00');

echo 'Superposicion horario ? ' . $horario1->superponeCon($horario2);

?>
