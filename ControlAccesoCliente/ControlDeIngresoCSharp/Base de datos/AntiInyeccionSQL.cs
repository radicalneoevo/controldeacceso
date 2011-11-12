using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using ControlDeIngresoCSharp.Excepciones.SQL;

namespace ControlDeIngresoCSharp.Base_de_datos
{
    class AntiInyeccionSQL
    {
        /// <summary>
        /// Valida que el string pasado por parámetro no contenga potenciales
        /// inyecciones SQL o caracteres indeseados
        /// </summary>
        /// <param name="campo"></param>
        /// <returns>true si no contiene elementos peligrosos</returns>
        public void validarString(string campo)
        {
            if (campo.Contains("="))
                throw new CaracterInvalidoException("=");

            if (campo.Contains("*"))
                throw new CaracterInvalidoException("*");
        }
    }
}
