using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace ControlDeIngresoCSharp
{
    public class Fecha
    {
       
        private int dia;
        /// <summary>
        /// Dia de la fecha.
        /// </summary>
        public int Dia
        {
            get { return dia; }
            set { dia = value; }
        }


        private int mes;
        /// <summary>
        /// Mes de la fecha.
        /// </summary>
        public int Mes
        {
            get { return mes; }
            set { mes = value; }
        }


        private int año;
        /// <summary>
        /// Año de la fecha.
        /// </summary>
        public int Año
        {
            get { return año; }
            set { año = value; }
        }

        private string diaDeSemana;

        /// <summary>
        /// Constructor que utiliza párametros string.
        /// </summary>
        /// <param name="unDia">string que representa numericamente el día</param>
        /// <param name="unMes">>string que representa numericamente el mes</param>
        /// <param name="unAño">>string que representa numericamente el año</param>
        /// <param name="unDiaSemana">>string que representa el nombre del dia de la
        /// semana en ingles</param>
        public Fecha(string unDia, string unMes, string unAño, string unDiaSemana)
        {
            dia = int.Parse(unDia);
            mes = int.Parse(unMes);
            año = int.Parse(unAño);
            diaDeSemana = unDiaSemana;
        }

        /// <summary>
        /// Contructor que utiliza parametros int y string
        /// </summary>
        /// <param name="unDia">número de día</param>
        /// <param name="unMes">número de mes</param>
        /// <param name="unAño">número de año</param>
        /// <param name="unDiaSemana">string que representa el nombre del dia de la
        /// semana en ingles</param>
        public Fecha(int unDia, int unMes, int unAño, string unDiaSemana)
        {
            dia = unDia;
            mes = unMes;
            año = unAño;
            diaDeSemana = unDiaSemana;
        }

        /// <summary>
        /// Constructor que utiliza como parámetro un objeto DateTime
        /// </summary>
        /// <param name="fecha"></param>
        public Fecha(DateTime fecha)
        {
            dia = fecha.Day;
            mes = fecha.Month;
            año = fecha.Year;
            diaDeSemana = fecha.DayOfWeek.ToString();
        }

        /// <summary>
        /// El constructor vacio se inicializa con la fecha actual del sistema
        /// </summary>
        public Fecha()
        {
            dia = DateTime.Today.Day;
            mes = DateTime.Today.Month;
            año = DateTime.Today.Year;
            diaDeSemana = DateTime.Today.DayOfWeek.ToString();
        }

        /// <summary>
        /// Convierte la fecha a formato aaaa-mm-dd
        /// </summary>
        /// <returns></returns>
        public string getSQLFormat()
        {
            return "'" + año.ToString() + "-" + mes.ToString() + "-" + dia.ToString() + "'";
        }

        /// <summary>
        /// Muestra la fecha en formato dd/mm/aaaa
        /// </summary>
        /// <returns></returns>
        public override string ToString()
        {
            return dia.ToString() + "/" + mes.ToString() + "/" + año.ToString();
        }

        /// <summary>
        /// Obtiene el día de la semana de manera numérica. Comienza en domingo
        /// siguiendo la forma de mysql.
        /// </summary>
        /// <returns></returns>
        public int getDiaDeSemana()
        {
            string diaIngles = this.diaDeSemana;
            int dia = 0;

            if (diaIngles.Equals("Sunday"))
                dia = 1;

            else if (diaIngles.Equals("Monday"))
                dia = 2;

            else if (diaIngles.Equals("Tuesday"))
                dia = 3;

            else if (diaIngles.Equals("Wednesday"))
                dia = 4;

            else if (diaIngles.Equals("Thursday"))
                dia = 5;

            else if (diaIngles.Equals("Friday"))
                dia = 6;

            else if (diaIngles.Equals("Saturday"))
                dia = 7;

            return dia;
        }

        /// <summary>
        /// Clona el objeto. Retorna una nueva instancia.
        /// </summary>
        /// <returns></returns>
        public Fecha clone()
        {
            return new Fecha(dia, mes, año, diaDeSemana);
        }

        /// <summary>
        /// Transforma el paràmetro numerico que representa el día de la semana
        /// en un String que dice el nombre del día correspondiente
        /// </summary>
        /// <param name="numeroDia">numero entre 1 y 7</param>
        /// <returns>nombre del día</returns>
        public static string getDiaSemana(int numeroDia)
        {
            if (numeroDia == 1)
                return "Domingo";

            if (numeroDia == 2)
                return "Lunes";

            if (numeroDia == 3)
                return "Martes";

            if (numeroDia == 4)
                return "Miércoles";

            if (numeroDia == 5)
                return "Jueves";

            if (numeroDia == 6)
                return "Viernes";

            if (numeroDia == 7)
                return "Sábado";

            return "";
        }

        /// <summary>
        /// Tranforma el nombre del dìa en el número equivalente para el 
        /// sistema.
        /// </summary>
        /// <param name="nombre"></param>
        /// <returns></returns>
        public static int getNumeroDia(string nombre)
        {
            if (nombre.Equals("Domingo", StringComparison.CurrentCultureIgnoreCase))
                return 1;

            if (nombre.Equals("Lunes", StringComparison.CurrentCultureIgnoreCase))
                return 2;

            if (nombre.Equals("Martes", StringComparison.CurrentCultureIgnoreCase))
                return 3;

            if (nombre.Equals("Miércoles", StringComparison.CurrentCultureIgnoreCase))
                return 4;

            if (nombre.Equals("Jueves", StringComparison.CurrentCultureIgnoreCase))
                return 5;

            if (nombre.Equals("Viernes", StringComparison.CurrentCultureIgnoreCase))
                return 6;

            if (nombre.Equals("Sábado", StringComparison.CurrentCultureIgnoreCase))
                return 7;

            return -1;
        }

        }
}
