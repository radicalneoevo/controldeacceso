using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace ControlDeIngresoCSharp.Excepciones
{
    class CamposVaciosException : Exception
    {
        public override string Message
        {
            get
            {
                return "Complete los campos vacios";
            }
        }
    }
}
