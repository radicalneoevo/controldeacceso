using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace ControlDeIngresoCSharp.Excepciones
{
    class EliminacionInvalidaException : Exception
    {
        public override string Message
        {
            get
            {
                return "Solo se pueden eliminar horarios NO confirmados";
            }
        }
    }
}
