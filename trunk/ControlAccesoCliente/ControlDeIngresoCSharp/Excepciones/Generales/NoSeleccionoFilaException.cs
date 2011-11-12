using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace ControlDeIngresoCSharp.Excepciones
{
    class NoSeleccionoFilaException : Exception
    {
        public override string Message
        {
            get
            {
                return "Debe seleccionar una fila para poder eliminar";
            }
        }
    }
}
