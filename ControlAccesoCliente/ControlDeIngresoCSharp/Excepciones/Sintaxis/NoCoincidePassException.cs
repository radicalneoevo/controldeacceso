using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace ControlDeIngresoCSharp.Excepciones
{
    class NoCoincidePassException : Exception
    {
        public override string Message
        {
            get
            {
                return "El nuevo password y su verificación no coinciden";
            }
        }
    }
}
