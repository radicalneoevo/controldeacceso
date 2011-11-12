using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace ControlDeIngresoCSharp.Excepciones
{
    class RangoMinimoException : Exception
    {
        public override string Message
        {
            get
            {
                return "El horario especificado no cumple con el rángo mínimo.";
            }
        }
    }
}
