using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using MySql.Data.MySqlClient;
using ControlDeIngresoCSharp.Interfaces;

namespace ControlDeIngresoCSharp
{
    public partial class login_por_password : Form
    {
        //Variable
        private Principal padre;

        public login_por_password(Principal p)
        {
            InitializeComponent();
            comboArea.SelectedIndex = 0;
            padre = p;
        }

        private void botonCancelar_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void campoDni_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (e.KeyChar == Convert.ToChar(Keys.Enter))
                    campoPass.Focus();

            // (c > 47 && c < 58) significa que el caracter sea numérico, lo otro que admita  
            // la tecla backspace (borrar)
            if (!(e.KeyChar > 47 && e.KeyChar < 58 || (e.KeyChar == Convert.ToChar(Keys.Back))))
                e.Handled = true;
        }

        private void campoPass_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (e.KeyChar == Convert.ToChar(Keys.Enter))
                botonAceptar.Focus();
        }

        /// <summary>
        /// Efectua el registro si los datos son correctos
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void botonAceptar_Click(object sender, EventArgs e)
        {
            string usuario = campoDni.Text.Trim();
            string password = campoPass.Text.Trim();
            string observacion = campoObservaciones.Text.Trim();
            string area = comboArea.SelectedItem.ToString();
            GestorUsuarios gestor = new GestorUsuarios();
            GestorTurnos gestorAccion = new GestorTurnos();

            try
            {
                //Valido usuario y password. Si no tiro excepción.
                bool ok = gestor.autenticar(usuario, password);

                //Registro Accion de ingreso o egreso.
                int resultado = gestorAccion.registrarAccion(usuario, observacion, area);

                //Mesaje de fin
                if (resultado == 1)
                {
                    MessageBox.Show("Registro de INGRESO finalizado", "Éxito", MessageBoxButtons.OK, MessageBoxIcon.Asterisk);
                    PantallaBienvenida welcome = new PantallaBienvenida(padre, usuario);
                    padre.Hide();
                    welcome.Show();
                }
                else
                    MessageBox.Show("Registro de EGRESO finalizado", "Éxito", MessageBoxButtons.OK, MessageBoxIcon.Asterisk);

                //CHAU
                this.Close();
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


    }
}
