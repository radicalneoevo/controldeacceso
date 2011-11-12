using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using ControlDeIngresoCSharp.Interfaces;

namespace ControlDeIngresoCSharp
{
    public partial class Principal : Form
    {
        //Variables
        private Fecha fecha;
        private Horario hora = new Horario();
        private login_por_huella huella;
        private login_por_password pass;
        private VerPresentes presentes;
        private ValidarUsuario validarUser;
        private AboutBox about;
        private CambioPassword cambiarPass;

        //Constructor
        public Principal()
        {
            InitializeComponent();
        }

        //Eventos
        private void Principal_Load(object sender, EventArgs e)
        {
            fecha = new Fecha(DateTime.Today.Day, DateTime.Today.Month, DateTime.Today.Year, DateTime.Today.DayOfWeek.ToString());
            labelFecha.Text = "(" + fecha.ToString() + ")";

            this.mensajes.Text = "Bienvenido";
        }

        private void BotonLoginHuella_Click(object sender, EventArgs e)
        {
            if (huella == null || huella.IsDisposed)
                huella = new login_por_huella();
            else
                huella.BringToFront();


            huella.Show();
        }

        private void LoginPorHuellaToolStripMenuItem_Click(object sender, EventArgs e)
        {
            if (huella == null || huella.IsDisposed)
                huella = new login_por_huella();
            else
                huella.BringToFront();


            huella.Show();
        }

        private void Timer1_Tick(object sender, EventArgs e)
        {
            hora.setTimeSpan(DateTime.Now.TimeOfDay);
            labelHora.Text = hora.ToString();
        }

        private void BotonLoginPassword_Click(object sender, EventArgs e)
        {
            if (pass == null || pass.IsDisposed)
                pass = new login_por_password(this);
            else
                pass.BringToFront();


            pass.Show();
        }

        private void LoginPorPasswordToolStripMenuItem_Click(object sender, EventArgs e)
        {
            if (pass == null || pass.IsDisposed)
                pass = new login_por_password(this);
            else
                pass.BringToFront();


            pass.Show();
        }

        private void verPresentesToolStripMenuItem_Click(object sender, EventArgs e)
        {
            if (presentes == null || presentes.IsDisposed)
                presentes = new VerPresentes();
            else
                presentes.BringToFront();


            presentes.Show();
        }

        private void DefinirHorariosToolStripMenuItem_Click(object sender, EventArgs e)
        {
            if (validarUser == null || validarUser.IsDisposed)
                validarUser = new ValidarUsuario(this, "asignar horario");
            else
                validarUser.BringToFront();


            validarUser.Show();
        }

        private void ModificarDatosPersonalesToolStripMenuItem_Click(object sender, EventArgs e)
        {
            if (validarUser == null || validarUser.IsDisposed)
                validarUser = new ValidarUsuario(this, "datos personales");
            else
                validarUser.BringToFront();


            validarUser.Show();
        }

        private void buttonAbout_Click(object sender, EventArgs e)
        {
            if (about == null || about.IsDisposed)
                about = new AboutBox();
            else
                about.BringToFront();

            about.Show();
        }

        private void cambiarPasswordToolStripMenuItem_Click(object sender, EventArgs e)
        {
            if (cambiarPass == null || cambiarPass.IsDisposed)
                cambiarPass = new CambioPassword(this);
            else
                cambiarPass.BringToFront();

            cambiarPass.Show();
        }
    }
}
