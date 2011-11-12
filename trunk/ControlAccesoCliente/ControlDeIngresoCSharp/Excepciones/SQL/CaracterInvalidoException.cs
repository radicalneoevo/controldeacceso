using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace ControlDeIngresoCSharp.Excepciones.SQL
{
    class CaracterInvalidoException : Exception
    {
        private string caracter;

        public CaracterInvalidoException(string s)
        {
            caracter = s;
        }

        public override string Message
        {
            get
            {
                return "No se permite el caracter " + caracter;
            }
        }
    }
}
