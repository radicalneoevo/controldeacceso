using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace ControlDeIngresoCSharp.Excepciones
{
    class TurnoSuperpuestoException : Exception
    {
        public override string Message
        {
            get
            {
                return "El turno elegido se superpone a un turno ya registrado";
            }
        }
    }
}
