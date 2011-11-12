using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using ControlDeIngresoCSharp.Excepciones;

namespace ControlDeIngresoCSharp
{
    /// <summary>
    /// Representa una hora en formato HH:MM:SS de 24 hs.
    /// </summary>
    class Horario
    {
        private int hora;
        /// <summary>
        /// La parte de hora del horario.
        /// </summary>
        public int Hora
        {
            get { return hora; }
            set { hora = value; }
        }

        private int minuto;
        /// <summary>
        /// La parte de minuto del horario.
        /// </summary>
        public int Minuto
        {
            get { return minuto; }
            set { minuto = value; }
        }


        private int segundo;
        /// <summary>
        /// La parte de segundo del horario
        /// </summary>
        public int Segundo
        {
            get { return segundo; }
            set { segundo = value; }
        }

        /// <summary>
        /// Crea un horario a partir de 3 strings
        /// </summary>
        /// <param name="unHora"></param>
        /// <param name="unMinuto"></param>
        /// <param name="unSegundo"></param>
        public Horario(string unHora, string unMinuto, string unSegundo)
        {
            if (int.TryParse(unHora, out hora) == false)
                throw new HorarioFormatException();

            if (int.TryParse(unMinuto, out minuto) == false)
                throw new HorarioFormatException();

            if (int.TryParse(unSegundo, out hora) == false)
                throw new HorarioFormatException();


            this.validar();
        }

        /// <summary>
        /// Crea el horario a partir de tres enteros
        /// </summary>
        /// <param name="unHora"></param>
        /// <param name="unMinuto"></param>
        /// <param name="unSegundo"></param>
        public Horario(int unHora, int unMinuto, int unSegundo)
        {
            hora = unHora;
            minuto = unMinuto;
            segundo = unSegundo;

            this.validar();
        }

        /// <summary>
        /// Crea una entidad Horario
        /// </summary>
        /// <param name="hora">Hora en formato HH:MM</param>
        public Horario(string horario)
        {
            string[] aux = horario.Split(':');

            if (int.TryParse(aux[0], out hora) == false)
                throw new HorarioFormatException();

            if (int.TryParse(aux[1], out minuto) == false)
                throw new HorarioFormatException();

            segundo = 0;

            this.validar();
        }
        
        /// <summary>
        /// Crea un horario con los campos en cero
        /// </summary>
        public Horario()
        {
            hora = 0;
            minuto = 0;
            segundo = 0;
        }

        public void setTimeSpan(TimeSpan time)
        {
            hora = time.Hours;
            minuto = time.Minutes;
            segundo = time.Seconds;
        }

        /// <summary>
        /// Hora en formato 'hh:mm:ss' para mysql
        /// </summary>
        /// <returns></returns>
        public string getSQLFormat()
        {
            string a;
            string b;
            string c;

            if (hora.ToString().Length == 1)
                a = "0";
            else
                a = "";
            if (minuto.ToString().Length == 1)
                b = "0";
            else
                b = "";
            if (segundo.ToString().Length == 1)
                c = "0";
            else
                c = "";
            return "'" + a + hora + ":" + b + minuto + ":" + c + segundo + "'";
        }

        /// <summary>
        /// Muestra la hora en formato hh:mm:ss
        /// </summary>
        /// <returns></returns>
        public override string ToString()
        {
            string a;
            string b;
            string c;
            if (hora.ToString().Length == 1)
                a = "0";
            else
                a = "";
            if (minuto.ToString().Length == 1)
                b = "0";
            else
                b = "";
            if (segundo.ToString().Length == 1)
                c = "0";
            else
                c = "";
            return a + hora + ":" + b + minuto + ":" + c + segundo;
        }

        /// <summary>
        /// Clona la entidad.
        /// </summary>
        /// <returns></returns>
        public Horario clone()
        {
            return new Horario(hora, minuto, segundo);
        }

        /// <summary>
        /// Verifica que la hora esté en el rango correcto.
        /// En caso contrario lanza una excepción.
        /// </summary>
        private void validar()
        {
            if (hora < 0 || hora > 24)
                throw new HorarioFormatException();

            if (minuto < 0 || minuto > 60)
                throw new HorarioFormatException();

            if (segundo < 0 || segundo > 60)
                throw new HorarioFormatException();
        }

        /// <summary>
        /// Compara la entidad actual con otra pasada por parámetro
        /// para ver cual es mayor
        /// </summary>
        /// <param name="unHorario"></param>
        /// <returns>true si el horario pasado por parámetro es mayor, sino false</returns>
        public bool mayorQue(Horario unHorario)
        {
            if (this.hora > unHorario.Hora)
                return true;
            else if (this.hora == unHorario.Hora)
            {
                if (this.minuto > unHorario.Minuto)
                    return true;
                else if (this.minuto == unHorario.Minuto)
                {
                    if (this.segundo > unHorario.Segundo)
                        return true;
                }
            }

            return false;
        }

        /// <summary>
        /// Convierte el horario a segundos
        /// </summary>
        /// <returns></returns>
        public long toSegundos()
        {
            long resultado = this.hora * 60 * 60;
            resultado = resultado + this.minuto * 60;
            resultado = resultado + this.segundo;

            return resultado;
        }
    }
}
