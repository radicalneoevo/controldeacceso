using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace ControlDeIngresoCSharp.Entidades
{
    public class Usuario
    {
        
        private string tipoDni;
        /// <summary>
        /// Tipo de documento del usuario
        /// </summary>
        public string TipoDni
        {
            get { return tipoDni; }
            set { tipoDni = value; }
        }

        
        private string numeroDocumento;
        /// <summary>
        /// Numero de documento
        /// </summary>
        public string NumeroDocumento
        {
            get { return numeroDocumento; }
            set { numeroDocumento = value; }
        }

        
        private string nombre;
        /// <summary>
        /// Nombre del usuario
        /// </summary>
        public string Nombre
        {
            get { return nombre; }
            set { nombre = value; }
        }

        private string segundoNombre;
        /// <summary>
        /// Segundo nombre del usuario
        /// </summary>
        public string SegundoNombre
        {
            get { return segundoNombre; }
            set { segundoNombre = value; }
        }

       
        private string apellido;
        /// <summary>
        /// Apellido del usuario
        /// </summary>
        public string Apellido
        {
            get { return apellido; }
            set { apellido = value; }
        }

        private Fecha fechaNacimiento;
        /// <summary>
        /// Fecha de nacimiento que admite multiples formatos
        /// </summary>
        public Fecha FechaNacimiento
        {
            get { return fechaNacimiento; }
            set { fechaNacimiento = value; }
        }

        private string direccion;
        /// <summary>
        /// Direccion con calle y número
        /// </summary>
        public string Direccion
        {
            get { return direccion; }
            set { direccion = value; }
        }

        private string telefonoFijo;
        /// <summary>
        /// Telefono fijo
        /// </summary>
        public string TelefonoFijo
        {
            get { return telefonoFijo; }
            set { telefonoFijo = value; }
        }

        
        private string telefonoCelular;
        /// <summary>
        /// Telefono Celular
        /// </summary>
        public string TelefonoCelular
        {
            get { return telefonoCelular; }
            set { telefonoCelular = value; }
        }

        private string email;
        /// <summary>
        /// Dirección de email
        /// </summary>
        public string Email
        {
            get { return email; }
            set { email = value; }
        }

        private string notas;
        /// <summary>
        /// Notas u observaciones adicionales
        /// </summary>
        public string Notas
        {
            get { return notas; }
            set { notas = value; }
        }

        public Usuario()
        {

        }
    }
}
