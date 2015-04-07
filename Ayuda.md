## Principales conceptos del sistema ##

---


### Períodos ###
Para la organización de los horarios de los laboratorios, el sistema se basa en Períodos. Un período es un intervalo de tiempo (en el orden de meses o semanas) asociado a un área en el que tiene validez un horario habitual asociado a un becario. Un período puede incluir semanas especiales o días feriados. Los períodos de un área son intervalos mutuamemte excluyentes, solo puede coincidir el último día de uno con el primer día del otro. Dado que muchos elementos conceptuales dependen del período, de momento solo puede editarse su descripción, no su inicio ni su fin. Para comenzar con la carga de horarios debe ingresarse un período para cada área. El período dentro del cual cae la fecha actual es el período actual.

### Días feriados ###
Representa un día no laboral sea éste un feriado, paro, día festivo, etc. Está asociado a un período, puede modificarse o eliminarse posteriormente si es necesario.

### Semanas especiales ###
Intervalos de fechas dentro de un período dentro de las cuales no se aplican los horarios habituales definidos para cada usuario, por ejemplo semanas de consulta, semanas de exámenes, semanas del receso, etc. Puede editarse o eliminarse.

### Horario habitual ###
Dia de la semana y hora que normalmente cumple un usuario. Está asociado a un período y área en particular.

### Horario ###
Representa un horario que debe cumplir un usuario en una fecha y horas específicas. Está asociado a un período y área en particular. Puede pertenecer a un horario habitual.

## Turno ##
Representa el horario que efectivamente cumplió un usuario, esta asociado generalmente a un horario (podrían ser horas extras hechas por el usuario).

