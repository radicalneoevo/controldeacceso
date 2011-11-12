using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using ControlDeIngresoCSharp.Excepciones;

namespace ControlDeIngresoCSharp.Logica
{
    class RangoHorario
    {
        private Horario inicio;
        /// <summary>
        /// Horario de inicio del rango.
        /// </summary>
        internal Horario Inicio
        {
            get { return inicio; }
        }

        private Horario fin;
        /// <summary>
        /// Horario que marca el fin del rango.
        /// </summary>
        internal Horario Fin
        {
            get { return fin; }
        }

        /// <summary>
        /// Crea una entidad RangoHorario verificando la consistencia.
        /// </summary>
        /// <param name="inicio"></param>
        /// <param name="fin"></param>
        public RangoHorario(Horario inicio, Horario fin)
        {
            if (inicio.mayorQue(fin))
                throw new RangoHorarioIncosistenteException();

            this.inicio = inicio;
            this.fin = fin;
        }

        /// <summary>
        /// Verifica que el rango horario sea menor que
        /// la cantidad de horas y minutos pasados como parámetro.
        /// </summary>
        /// <param name="hora"></param>
        /// <param name="minuto"></param>
        /// <returns></returns>
        public bool rangoMenor(int hora, int minuto)
        {
            long rango = hora * 3600 + minuto * 60; //rango en segundos

            long rangoReal = fin.toSegundos() - inicio.toSegundos(); //rango real en segundos

            if (rangoReal < rango)
                return true;

            return false;
        }

        /// <summary>
        /// Comprueba que el rango actual no se superponga con el rángo pasado
        /// como parámetro. No tiene en cuenta los segundos.
        /// </summary>
        /// <param name="otroRango">rango a comparar con el actual</param>
        /// <returns>true si el rango se superpone, caso contrario false</returns>
        public bool rangoSuperpuesto(RangoHorario otroRango)
        {
            if (this.fin.Hora < otroRango.inicio.Hora)
                return false;
            else if (this.fin.Hora == otroRango.inicio.Hora)
                if (this.fin.Minuto < otroRango.inicio.Minuto)
                    return false;


            if (this.inicio.Hora < otroRango.inicio.Hora)
                return true;
            else if (this.inicio.Hora == otroRango.inicio.Hora)
                if (this.inicio.Minuto < otroRango.inicio.Minuto)
                    return true;


            if (otroRango.fin.Hora < this.inicio.Hora)
                return false;
            else if (otroRango.fin.Hora == this.inicio.Hora)
                if (otroRango.fin.Minuto < this.inicio.Minuto)
                    return false;


            return true;
        }

        /// <summary>
        /// Obtiene la duracion del rango
        /// </summary>
        /// <returns>duracion en formato HH:MM:SS</returns>
        public Horario getDuracion()
        {
            TimeSpan timeI = new TimeSpan(inicio.Hora, inicio.Minuto, inicio.Segundo);
            TimeSpan timeF = new TimeSpan(fin.Hora, fin.Minuto, fin.Segundo);

            TimeSpan s = timeF - timeI;

            Horario resultado = new Horario();
            resultado.setTimeSpan(s);
            return resultado;
        }
    }
}
