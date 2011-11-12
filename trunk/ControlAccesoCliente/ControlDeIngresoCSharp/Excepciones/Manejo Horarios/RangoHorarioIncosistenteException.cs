using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace ControlDeIngresoCSharp.Excepciones
{
    class RangoHorarioIncosistenteException : Exception
    {
        public override string Message
        {
            get
            {
                return "El horario de ingreso no puede ser" +
                " mayor que el horario de egreso";
            }
        }
    }
}
