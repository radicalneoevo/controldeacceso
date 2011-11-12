using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace ControlDeIngresoCSharp.Excepciones
{
    class HorarioFormatException : Exception
    {
        public override string Message
        {
            get
            {
                return "Formato de hora inválido";
            }
        }
    }
}
