
window.onload = function()
{
    // Reporte de horas acumuladas
    if(document.getElementById('campoFechaEspecificaHorasAcumuladas') != null)
    Calendar.setup
    ({
        // id del campo de texto
        inputField     :    "campoFechaEspecificaHorasAcumuladas",
        // formato de la fecha, cuando se escriba en el campo de texto
        ifFormat       :    "%d-%m-%Y",
        // el id del botón que lanzará el calendario
        button         :    "seleccionarFechaEspecificaHorasAcumuladas"     
    });

    if(document.getElementById('fechaInicioHorasAcumuladas') != null)
    Calendar.setup
    ({
        // id del campo de texto
        inputField     :    "fechaInicioHorasAcumuladas",
        // formato de la fecha, cuando se escriba en el campo de texto
        ifFormat       :    "%d-%m-%Y",
        // el id del botón que lanzará el calendario
        button         :    "seleccionarFechaInicioHorasAcumuladas"
    });

    if(document.getElementById('fechaFinHorasAcumuladas') != null)
    Calendar.setup
    ({
        // id del campo de texto
        inputField     :    "fechaFinHorasAcumuladas",
        // formato de la fecha, cuando se escriba en el campo de texto
        ifFormat       :    "%d-%m-%Y",
        // el id del botón que lanzará el calendario
        button         :    "seleccionarFechaFinHorasAcumuladas"
    });

    if(document.getElementById('campoFechaEspecificaNotificacionesFaltas') != null)
    // Reporte de notificaciones de faltas
    Calendar.setup
    ({
        // id del campo de texto
        inputField     :    "campoFechaEspecificaNotificacionesFaltas",
        // formato de la fecha, cuando se escriba en el campo de texto
        ifFormat       :    "%d-%m-%Y",
        // el id del botón que lanzará el calendario
        button         :    "seleccionarFechaEspecificaNotificacionesFaltas"
    });

    if(document.getElementById('fechaInicioNotificacionesFaltas') != null)
    Calendar.setup
    ({
        // id del campo de texto
        inputField     :    "fechaInicioNotificacionesFaltas",
        // formato de la fecha, cuando se escriba en el campo de texto
        ifFormat       :    "%d-%m-%Y",
        // el id del botón que lanzará el calendario
        button         :    "seleccionarFechaInicioNotificacionesFaltas"
    });

    if(document.getElementById('fechaFinNotificacionesFaltas') != null)
    Calendar.setup
    ({
        // id del campo de texto
        inputField     :    "fechaFinNotificacionesFaltas",
        // formato de la fecha, cuando se escriba en el campo de texto
        ifFormat       :    "%d-%m-%Y",
        // el id del botón que lanzará el calendario
        button         :    "seleccionarFechaFinNotificacionesFaltas"
    });

    if(document.getElementById('fechaInicioPeriodo') != null)
    Calendar.setup
    ({
        // id del campo de texto
        inputField     :    "fechaInicioPeriodo",
        // formato de la fecha, cuando se escriba en el campo de texto
        ifFormat       :    "%d-%m-%Y",
        // el id del botón que lanzará el calendario
        button         :    "seleccionarFechaInicioPeriodo"
    });

    if(document.getElementById('fechaFinPeriodo') != null)
    Calendar.setup
    ({
        // id del campo de texto
        inputField     :    "fechaFinPeriodo",
        // formato de la fecha, cuando se escriba en el campo de texto
        ifFormat       :    "%d-%m-%Y",
        // el id del botón que lanzará el calendario
        button         :    "seleccionarFechaFinPeriodo"
    });

    if(document.getElementById('fechaDiaFeriado') != null)
    Calendar.setup
    ({
        // id del campo de texto
        inputField     :    "fechaDiaFeriado",
        // formato de la fecha, cuando se escriba en el campo de texto
        ifFormat       :    "%d-%m-%Y",
        // el id del botón que lanzará el calendario
        button         :    "seleccionarFechaDiaFeriado"
    });

    if(document.getElementById('fechaInicioSemanaEspecial') != null)
    Calendar.setup
    ({
        // id del campo de texto
        inputField     :    "fechaInicioSemanaEspecial",
        // formato de la fecha, cuando se escriba en el campo de texto
        ifFormat       :    "%d-%m-%Y",
        // el id del botón que lanzará el calendario
        button         :    "seleccionarFechaInicioSemanaEspecial"
    });

   if(document.getElementById('fechaFinSemanaEspecial') != null)
    Calendar.setup
    ({
        // id del campo de texto
        inputField     :    "fechaFinSemanaEspecial",
        // formato de la fecha, cuando se escriba en el campo de texto
        ifFormat       :    "%d-%m-%Y",
        // el id del botón que lanzará el calendario
        button         :    "seleccionarFechaFinSemanaEspecial"
    });

   if(document.getElementById('fechaInicioHorarioAsignado') != null)
    Calendar.setup
    ({
        // id del campo de texto
        inputField     :    "fechaInicioHorarioAsignado",
        // formato de la fecha, cuando se escriba en el campo de texto
        ifFormat       :    "%d-%m-%Y",
        // el id del botón que lanzará el calendario
        button         :    "seleccionarFechaInicioHorarioAsignado"
    });

   if(document.getElementById('fechaFinHorarioAsignado') != null)
    Calendar.setup
    ({
        // id del campo de texto
        inputField     :    "fechaFinHorarioAsignado",
        // formato de la fecha, cuando se escriba en el campo de texto
        ifFormat       :    "%d-%m-%Y",
        // el id del botón que lanzará el calendario
        button         :    "seleccionarFechaFinHorarioAsignado"
    });
}