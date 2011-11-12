using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Text.RegularExpressions;
using System.Windows.Forms;
using ControlDeIngresoCSharp.Excepciones.SQL;
using ControlDeIngresoCSharp.Excepciones;
using ControlDeIngresoCSharp.Base_de_datos;


namespace ControlDeIngresoCSharp.Interfaces
{
    public partial class CambioPassword : Form
    {
        //Variables
        private Principal padre;

        public CambioPassword(Principal p)
        {
            padre = p;
            InitializeComponent();
            padre.Hide();
        }

        /// <summary>
        /// Hace que se pueda navegar al siguiente campo presionando ENTER
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void campoDni_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (e.KeyChar == Convert.ToChar(Keys.Enter))
                this.campoPass.Focus();

            // (c > 47 && c < 58) significa que el caracter sea numérico, lo otro que admita  
            // la tecla backspace (borrar)
            if (!(e.KeyChar > 47 && e.KeyChar < 58 || (e.KeyChar == Convert.ToChar(Keys.Back))))
                e.Handled = true;  
        }

        /// <summary>
        /// Maneja la lógica del campo pass actual
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void campoPass_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (e.KeyChar == Convert.ToChar(Keys.Enter))
                this.nuevoPass.Focus();
        }

        /// <summary>
        /// Maneja la lógica del campo nuevo pass
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void nuevoPass_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (e.KeyChar == Convert.ToChar(Keys.Enter))
                this.confirmarNuevoPass.Focus();
        }

        /// <summary>
        /// Maneja la lógica del campo confirmar pass
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void confirmarNuevoPass_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (e.KeyChar == Convert.ToChar(Keys.Enter))
                this.cambiarPass();
        }

        /// <summary>
        /// Cambia el password de un usuario dado si los datos ingresados son correctos
        /// </summary>
        private void cambiarPass()
        {
            try
            {
                //Genero los strings con los datos ingresados
                string usuario = this.campoDni.Text.Trim();
                string campoPass = this.campoPass.Text.Trim();
                string nuevoPass = this.nuevoPass.Text.Trim();
                string confirmacionPass = this.confirmarNuevoPass.Text.Trim();

                //Primero verifico que los campos no sean vacios
                if (usuario.Equals(""))
                    throw new CamposVaciosException();

                if (campoPass.Equals(""))
                    throw new CamposVaciosException();

                if (nuevoPass.Equals(""))
                    throw new CamposVaciosException();

                if (confirmacionPass.Equals(""))
                    throw new CamposVaciosException();

                //Ahora tengo que validar que el usuario y password ingresados exista
                GestorUsuarios usuarioDAO = new GestorUsuarios();
                //El metodo autenticar ya tira la excepciòn si no tiene éxito
                usuarioDAO.autenticar(usuario, campoPass);
                    

                //Verifico que el nuevo password y la confimación sean iguales
                if (!nuevoPass.Equals(confirmacionPass))
                    throw new NoCoincidePassException();

                //Documento debe ser numérico
                int numeroDoc;

                if (int.TryParse(usuario, out numeroDoc))
                    numeroDoc = int.Parse(usuario);
                else
                    throw new Exception("El documento debe ser numerico");

                //Verifico la longitud mínima de la nueva contraseña
                if (nuevoPass.Length < 6)
                    throw new Exception("La longitud mínima es de 6 caracteres");

                //Verifico la longitud máxima de la nueva contraseña
                if (nuevoPass.Length > 40)
                    throw new Exception("La longitud máxima es de 40 caracteres");

                //La contraseña debe contener solo letras y números
                //Utilizo expresiones regulares para esta validación
                // (De paso aprendo algo nuevo ;D
                String Patron = "^[a-zA-Z0-9-]+$";
                Regex ExpresionRegular = new Regex(Patron);

                if (!ExpresionRegular.IsMatch(nuevoPass))
                    throw new SintaxisPasswordInvalida();

                //Verifico que no existan inyecciones SQL
                //No verifico el password porque va a estar encriptado así que no
                //importa lo que escriban, al final va a ser un monton de letras extrañas
                AntiInyeccionSQL antiInyeccion = new AntiInyeccionSQL();
                antiInyeccion.validarString(usuario);

                //Actualizo la base de datos
                usuarioDAO.cambiarPassword(usuario, nuevoPass);
                MessageBox.Show("Password modificado con éxito", "Password Cambiado", 
                    MessageBoxButtons.OK, MessageBoxIcon.Information);

                this.Close();
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message, "Inválido", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void CambioPassword_FormClosed(object sender, FormClosedEventArgs e)
        {
            padre.Show();
        }

        private void botonCancelar_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void botonAceptar_Click(object sender, EventArgs e)
        {
            this.cambiarPass();
        }

    }
}
