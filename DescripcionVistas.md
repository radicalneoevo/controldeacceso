## Descripción de las vistas ##

---



### horario\_asignado\_duracion ###
Tabla horario\_asignado más duración y semana sin horarios inactivos

### horario\_asignado\_habitual\_duracion ###
Tabla horario\_asignado\_habitual más duración y semana sin horarios inactivos

### horas\_compensadas\_a\_otro\_usuario ###
De la tabla turno\_usuario\_area, agrupa por usuario y area la cantidad de horas que le compenso el usuario a otro usuario

### horas\_compensadas\_por\_otro\_usuario ###
De la tabla turno\_usuario\_area, agrupa por usuario y area la cantidad de horas que le compenso otro usuario

### horas\_compensadas\_por\_usuario ###
De la tabla turno\_usuario\_area, agrupa por usuario y area la cantidad de horas que el mismo usuario recupero de alguna falta anterior

### horas\_extra ###
De la tabla turno\_usuario\_area, agrupa por usuario y area la cantidad de horas extras que hizo cada dia

### horas\_habituales\_asignadas ###
De la tabla horario\_asignado\_duracion, agrupa por usuario y area la cantidad de horas asignadas que tiene asignado por dia, se descartan las horarios que compensan faltas

### horas\_habituales\_cumplidas ###
De la tabla turno\_usuario\_area, agrupa por usuario y area la cantidad de horas que cumplio cada dia, se descartan las turnos que compensan faltas

### notificacion\_falta\_usuarios ###
Tabla notificacion\_falta con sus respectivos usuarios (el que falta y el que recupera)

### turno\_usuario\_area ###
Tabla turno con su respectivos usuario, área y duración. Unión de turnos normales y horas extras.

### cambio\_horario\_usuario ###
Tabla cambio\_horario\_habitual con el usuario al que corresponde

### nuevo\_horario\_usuario ###
Tabla nuevo\_horario\_habitual con el usuario al que corresponde

