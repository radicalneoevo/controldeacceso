using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace ControlDeIngresoCSharp.Excepciones
{
    class FormatoPassInvalidoException : Exception
    {
        public override string Message
        {
            get
            {
                return "Solo se permiten letras y números en el password";
            }
        }
    }
}
