using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using ControlDeIngresoCSharp.Entidades;
using ControlDeIngresoCSharp.Base_de_datos;
using System.Windows.Forms;
using System.Text.RegularExpressions;

namespace ControlDeIngresoCSharp.Interfaces
{
    public partial class DatosPersonales : Form
    {
        //Variables
        private Usuario usuario;
        private Principal padre;

        public DatosPersonales(Principal p, Usuario us)
        {
            InitializeComponent();
            this.usuario = us;
            this.padre = p;
            //Pongo para que el cursor aparezca en el campo EMAIL
            emailTextBox.Select();
        }

        /******************************************
         ********   EVENTOS DE LA VENTANA *********
         *****************************************/
        private void DatosPersonales_FormClosed(object sender, FormClosedEventArgs e)
        {
            padre.Show();
        }

        private void cancelarButton_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void emailTextBox_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (e.KeyChar == Convert.ToChar(Keys.Enter))
                this.direccionTextBox.Focus();
        }

        private void direccionTextBox_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (e.KeyChar == Convert.ToChar(Keys.Enter))
                this.telFijoTextBox.Focus();
        }

        private void telFijoTextBox_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (e.KeyChar == Convert.ToChar(Keys.Enter))
                this.telCelularTextBox.Focus();

            // (c > 47 && c < 58) significa que el caracter sea numérico, lo otro que admita  
            // la tecla backspace (borrar)
            // y el 45 la tecla -
            if (!(e.KeyChar > 47 && e.KeyChar < 58
                || (e.KeyChar == Convert.ToChar(Keys.Back))
                || (e.KeyChar == 45)
                ))
                e.Handled = true;
        }

        private void telCelularTextBox_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (e.KeyChar == Convert.ToChar(Keys.Enter))
                this.actualizarButton.Focus();

            // (c > 47 && c < 58) significa que el caracter sea numérico, lo otro que admita  
            // la tecla backspace (borrar)
            // y el 45 la tecla -
            if (!(e.KeyChar > 47 && e.KeyChar < 58 
                || (e.KeyChar == Convert.ToChar(Keys.Back))
                || (e.KeyChar == 45)
                ))
                e.Handled = true;
        }

        private void DatosPersonales_Load(object sender, EventArgs e)
        {
            //campos no editables
            this.nombreTextBox.Text = usuario.Nombre;
            this.segNombreTextBox.Text = usuario.SegundoNombre;
            this.apellidoTextBox.Text = usuario.Apellido;
            this.documentoTextBox.Text = usuario.TipoDni + " - " + usuario.NumeroDocumento;
            this.fechaNacTextBox.Text = usuario.FechaNacimiento.ToString();

            //campos editables =)
            this.emailTextBox.Text = usuario.Email;
            this.direccionTextBox.Text = usuario.Direccion;
            this.telFijoTextBox.Text = usuario.TelefonoFijo;
            this.telCelularTextBox.Text = usuario.TelefonoCelular;
        }

        private void actualizarButton_Click(object sender, EventArgs e)
        {
            this.actualizarDatos();
        }

        /******************************************
         ********  OTRAS FUNCIONES DE LA VENTANA **
         *****************************************/
        /// <summary>
        /// Valida la sitaxis de el email pasado como parámetro
        /// utilizando expresiones regulares
        /// </summary>
        /// <param name="email"></param>
        /// <returns>TRUE si es correcto</returns>
        public static bool validarEmail(string email)
        {
            string expresion = "\\w+([-+.']\\w+)*@\\w+([-.]\\w+)*\\.\\w+([-.]\\w+)*";

            if (Regex.IsMatch(email, expresion))
            {
                if (Regex.Replace(email, expresion, String.Empty).Length == 0)
                { return true; }
                else
                { return false; }
            }
            else
            { return false; }
        }

        /// <summary>
        /// Verifica los datos ingresados. Si son correctos los actualiza
        /// </summary>
        private void actualizarDatos()
        {
            //primero valido la sintaxis del email
            bool ok = validarEmail(this.emailTextBox.Text);
            if (!ok)
            {
                MessageBox.Show("Email incorrecto", "Campo Inválido", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return;
            }

            //Incluyo el carater de escape para poder introducir la ' en mysql
            string email = this.emailTextBox.Text.Replace("'", "\\'").Trim();
            string direccion = this.direccionTextBox.Text.Replace("'", "\\'").Trim();
            string telefonoFijo = this.telFijoTextBox.Text.Replace("'", "\\'").Trim();
            string telefonoCelular = this.telCelularTextBox.Text.Replace("'", "\\'").Trim();

            // Verifico la longitud maxima y minima de los campos
            if (email.Length > 40)
            {
                MessageBox.Show("Email inválido", "Campo Inválido", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return;
            }

            if (direccion.Length < 7 || direccion.Length > 50)
            {
                MessageBox.Show("Dirección inválida", "Campo Inválido", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return;
            }

            if ((telefonoFijo.Length > 0 && telefonoFijo.Length < 7) || telefonoFijo.Length > 20)
            {
                MessageBox.Show("Teléfono fijo inválido", "Campo Inválido", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return;
            }

            if (telefonoCelular.Length > 0 && telefonoCelular.Length < 10 || telefonoCelular.Length > 20)
            {
                MessageBox.Show("Teléfono celular inválido", "Campo Inválido", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return;
            }

            //Verificación contra inyecciones SQL
            AntiInyeccionSQL antiInyeccion = new AntiInyeccionSQL();
            antiInyeccion.validarString(email);
            antiInyeccion.validarString(direccion);
            antiInyeccion.validarString(telefonoFijo);
            antiInyeccion.validarString(telefonoCelular);

            //Si todo es válido guardo los datos
            usuario.Email = email;
            usuario.Direccion = direccion;
            usuario.TelefonoFijo = telefonoFijo;
            usuario.TelefonoCelular = telefonoCelular;

            GestorUsuarios gestor = new GestorUsuarios();
            gestor.actualizarDatos(usuario);

            MessageBox.Show("Datos actualizados con éxito", "Operación exitosa", MessageBoxButtons.OK, MessageBoxIcon.Information);
            this.Close();
        }

    }
}
