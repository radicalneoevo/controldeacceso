using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace ControlDeIngresoCSharp.Excepciones
{
    class SintaxisPasswordInvalida : Exception
    {
        public override string Message
        {
            get
            {
                return "El password solo puede contener letras y números";
            }
        }
    }
}
