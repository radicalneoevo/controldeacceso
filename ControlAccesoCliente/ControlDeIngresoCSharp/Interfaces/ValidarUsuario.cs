using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using MySql.Data.MySqlClient;
using ControlDeIngresoCSharp.Entidades;

namespace ControlDeIngresoCSharp.Interfaces
{
    public partial class ValidarUsuario : Form
    {
        private Principal padre;
        private string siguiente;

        public ValidarUsuario(Principal p, string s)
        {
            InitializeComponent();
            this.padre = p;
            this.siguiente = s;
        }

        /// <summary>
        /// Identifica si el usuario y la contraseña son vàlidos y abre
        /// la siguiente ventana.
        /// </summary>
        private void autenticarUsuario()
        {
            string dniUsuario = campoDni.Text.Trim();
            string password = campoPass.Text.Trim();
            GestorUsuarios gestor = new GestorUsuarios();

            try
            {
                //Valido usuario y password. Si no tiro excepción.
                bool ok = gestor.autenticar(dniUsuario, password);

                if (siguiente.Equals("datos personales"))
                {
                    Usuario usuario = gestor.getUsuario(dniUsuario);
                    DatosPersonales datosPers = new DatosPersonales(this.padre, usuario);

                    datosPers.Show();
                }

                if (siguiente.Equals("asignar horario"))
                {
                    EditarHorarios edit = new EditarHorarios(this.padre, dniUsuario);

                    edit.Show();
                }

                //CHAU
                this.Close();
                this.padre.Hide();

            }
            catch (MySqlException exError)
            {
                MessageBox.Show(exError.Message, "Error de DB", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return;
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message, "Inválido", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        /// <summary>
        /// Cuando se presiona el boton aceptar se genera este evento
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void botonAceptar_Click(object sender, EventArgs e)
        {
            this.autenticarUsuario();
        }

        /// <summary>
        /// Maneja la lógica de los eventos de tipeo del campo DNI
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void campoDni_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (e.KeyChar == Convert.ToChar(Keys.Enter))
                campoPass.Focus();

            // (c > 47 && c < 58) significa que el caracter sea numérico, lo otro que admita  
            // la tecla backspace (borrar)
            if (!(e.KeyChar > 47 && e.KeyChar < 58 || (e.KeyChar == Convert.ToChar(Keys.Back))))
                e.Handled = true;  

        }

        /// <summary>
        /// Maneja la lógica del boton cancelar
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void botonCancelar_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        /// <summary>
        /// Maneja la lógica del campo password
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void campoPass_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (e.KeyChar == Convert.ToChar(Keys.Enter))
                this.autenticarUsuario();   
        }

        
    }
}
