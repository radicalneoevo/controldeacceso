using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace ControlDeIngresoCSharp.Excepciones
{
    class SQLErrorException : Exception
    {
        private string campo;

        public SQLErrorException(string campo)
        {
            this.campo = campo;
        }

        public override string Message
        {
            get
            {
                return "Error de consulta sobre el campo " + campo; ;
            }
        }
    }
}
