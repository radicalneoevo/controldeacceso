using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using ControlDeIngresoCSharp.Base_de_datos;

namespace ControlDeIngresoCSharp.Interfaces
{
    public partial class PantallaBienvenida : Form
    {
        //Variables
        string usuario;
        private Principal padre;

        //Constructor
        public PantallaBienvenida(Principal padre, string usuario)
        {
            InitializeComponent();
            this.usuario = usuario;
            this.padre = padre;
        }

        /// <summary>
        /// Evento que maneja el click al boton salir
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void button1_Click(object sender, EventArgs e)
        {
            this.Close();
        }


        /// <summary>
        /// Evento que se ejectua al abrir la pantalla
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void PantallaBienvenida_Load(object sender, EventArgs e)
        {
            GestorNotificaciones mensajesManager = new GestorNotificaciones();
            List<string> mensajes = mensajesManager.getListaNotificaciones(usuario);
            StringBuilder sb = new StringBuilder();

            if (mensajes.Count == 0)
                this.Close();

            foreach (string s in mensajes)
            {
                sb.AppendLine(s);
            }

            notificacionesTextBox.Text = sb.ToString();
        }

        /// <summary>
        /// Evento ejecutado antes de cerrar
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void PantallaBienvenida_FormClosed(object sender, FormClosedEventArgs e)
        {
            //Vuelvo a la pantalla principal
            this.padre.Show();
        }
    }
}
