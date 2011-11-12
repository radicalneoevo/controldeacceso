using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace ControlDeIngresoCSharp.Excepciones
{
    class CambioHorarioInvalidoException : Exception
    {
        public override string Message
        {
            get
            {
                return "El horario no se encuentra confirmado \n\rO ya se realizó una solicitud sobre el mismo";
            }
        }
    }
}
