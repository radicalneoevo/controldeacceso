using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;

namespace ControlDeIngresoCSharp
{
    public partial class VerPresentes : Form
    {
        public VerPresentes()
        {
            InitializeComponent();
        }

        private void VerPresentes_Load(object sender, EventArgs e)
        {
            GestorTurnos turnos = new GestorTurnos();
            List<string> presentes = turnos.personalPresente();
            StringBuilder sb = new StringBuilder();

            foreach (string s in presentes)
            {
                sb.AppendLine(s);
            }

            campoPresentes.Text = sb.ToString();
        }

        private void campoPresentes_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (e.KeyChar == Convert.ToChar(Keys.Escape))
                this.Close();
        }


    }
}
