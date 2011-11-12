using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace ControlDeIngresoCSharp.Logica
{
    class HorarioHabitualDTO
    {
        private String area;
        /// <summary>
        /// Area a la cual pertenece el turno
        /// </summary>
        public String Area
        {
            get { return area; }
            set { area = value; }
        }

        private String dia;
        /// <summary>
        /// Dia en el cual se cumple el turno
        /// </summary>
        public String Dia
        {
            get { return dia; }
            set { dia = value; }
        }

        private Horario ingreso;
        /// <summary>
        /// Hora de ingreso para el turno
        /// </summary>
        internal Horario Ingreso
        {
            get { return ingreso; }
            set { ingreso = value; }
        }

        private Horario egreso;
        /// <summary>
        /// Hora de egreso para el turno
        /// </summary>
        internal Horario Egreso
        {
            get { return egreso; }
            set { egreso = value; }
        }

        private string confirmado;
        /// <summary>
        /// toma el valor "SI" si el horario esta confirmado.. caso contrario toma "NO"
        /// </summary>
        public string Confirmado
        {
            get { return confirmado; }
            set { confirmado = value; }
        }

        private Horario duracion;
        /// <summary>
        /// Duraciòn en horas del turno... usado para visualizacion
        /// no es necesario guardarlo en la base de datos
        /// </summary>
        public Horario Duracion
        {
            get { return duracion; }
            set { duracion = value; }
        }

        /// <summary>
        /// Traduce el string confirmado a un int para poder guardarlo en la base de datos
        /// </summary>
        /// <returns></returns>
        public int confirmadoForSQL()
        {
            if (confirmado.Equals("SI"))
                return 1;
            else
                return 0;
        }
    }
}
