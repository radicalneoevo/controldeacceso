namespace ControlDeIngresoCSharp
{
    partial class Principal
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code
        /// private System.ComponentModel.IContainer components;
        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            this.components = new System.ComponentModel.Container();
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(Principal));
            this.labelHora = new System.Windows.Forms.Label();
            this.labelFecha = new System.Windows.Forms.Label();
            this.BotonLoginHuella = new System.Windows.Forms.Button();
            this.BotonLoginPassword = new System.Windows.Forms.Button();
            this.Timer1 = new System.Windows.Forms.Timer(this.components);
            this.panelMensajes = new System.Windows.Forms.Panel();
            this.botonEnviar = new System.Windows.Forms.Button();
            this.TextBox1 = new System.Windows.Forms.TextBox();
            this.mensajes = new System.Windows.Forms.TextBox();
            this.ToolStrip1 = new System.Windows.Forms.ToolStrip();
            this.ToolStripDropDownButton1 = new System.Windows.Forms.ToolStripDropDownButton();
            this.LoginPorHuellaToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.LoginPorPasswordToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.EnrolamientoToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.verPresentesToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.ToolStripDropDownButton2 = new System.Windows.Forms.ToolStripDropDownButton();
            this.ModificarDatosPersonalesToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.DefinirHorariosToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.cambiarPasswordToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.notificarFaltaToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.ReportesToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripSeparator1 = new System.Windows.Forms.ToolStripSeparator();
            this.buttonAbout = new System.Windows.Forms.ToolStripButton();
            this.panelMensajes.SuspendLayout();
            this.ToolStrip1.SuspendLayout();
            this.SuspendLayout();
            // 
            // labelHora
            // 
            this.labelHora.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left)
                        | System.Windows.Forms.AnchorStyles.Right)));
            this.labelHora.BackColor = System.Drawing.SystemColors.ControlText;
            this.labelHora.Font = new System.Drawing.Font("Microsoft Sans Serif", 48F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.labelHora.ForeColor = System.Drawing.Color.Lime;
            this.labelHora.Location = new System.Drawing.Point(135, 59);
            this.labelHora.Name = "labelHora";
            this.labelHora.Size = new System.Drawing.Size(284, 73);
            this.labelHora.TabIndex = 0;
            this.labelHora.Text = "00:00:00";
            this.labelHora.TextAlign = System.Drawing.ContentAlignment.MiddleCenter;
            // 
            // labelFecha
            // 
            this.labelFecha.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left)
                        | System.Windows.Forms.AnchorStyles.Right)));
            this.labelFecha.Font = new System.Drawing.Font("Microsoft Sans Serif", 18F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.labelFecha.Location = new System.Drawing.Point(199, 151);
            this.labelFecha.Name = "labelFecha";
            this.labelFecha.Size = new System.Drawing.Size(147, 29);
            this.labelFecha.TabIndex = 1;
            this.labelFecha.Text = "dd/mm/aaaa";
            this.labelFecha.TextAlign = System.Drawing.ContentAlignment.MiddleCenter;
            // 
            // BotonLoginHuella
            // 
            this.BotonLoginHuella.Location = new System.Drawing.Point(12, 200);
            this.BotonLoginHuella.Name = "BotonLoginHuella";
            this.BotonLoginHuella.Size = new System.Drawing.Size(120, 22);
            this.BotonLoginHuella.TabIndex = 2;
            this.BotonLoginHuella.Text = "Login por huella";
            this.BotonLoginHuella.UseVisualStyleBackColor = true;
            this.BotonLoginHuella.Click += new System.EventHandler(this.BotonLoginHuella_Click);
            // 
            // BotonLoginPassword
            // 
            this.BotonLoginPassword.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.BotonLoginPassword.Location = new System.Drawing.Point(402, 200);
            this.BotonLoginPassword.Name = "BotonLoginPassword";
            this.BotonLoginPassword.Size = new System.Drawing.Size(119, 22);
            this.BotonLoginPassword.TabIndex = 3;
            this.BotonLoginPassword.Text = "Login por password";
            this.BotonLoginPassword.UseVisualStyleBackColor = true;
            this.BotonLoginPassword.Click += new System.EventHandler(this.BotonLoginPassword_Click);
            // 
            // Timer1
            // 
            this.Timer1.Enabled = true;
            this.Timer1.Interval = 1000;
            this.Timer1.Tick += new System.EventHandler(this.Timer1_Tick);
            // 
            // panelMensajes
            // 
            this.panelMensajes.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom)
                        | System.Windows.Forms.AnchorStyles.Left)
                        | System.Windows.Forms.AnchorStyles.Right)));
            this.panelMensajes.Controls.Add(this.botonEnviar);
            this.panelMensajes.Controls.Add(this.TextBox1);
            this.panelMensajes.Controls.Add(this.mensajes);
            this.panelMensajes.Location = new System.Drawing.Point(19, 250);
            this.panelMensajes.Name = "panelMensajes";
            this.panelMensajes.Size = new System.Drawing.Size(502, 291);
            this.panelMensajes.TabIndex = 9;
            // 
            // botonEnviar
            // 
            this.botonEnviar.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Right)));
            this.botonEnviar.Enabled = false;
            this.botonEnviar.Location = new System.Drawing.Point(406, 267);
            this.botonEnviar.Name = "botonEnviar";
            this.botonEnviar.Size = new System.Drawing.Size(84, 20);
            this.botonEnviar.TabIndex = 2;
            this.botonEnviar.Text = "Enviar";
            this.botonEnviar.UseVisualStyleBackColor = true;
            this.botonEnviar.Visible = false;
            // 
            // TextBox1
            // 
            this.TextBox1.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)
                        | System.Windows.Forms.AnchorStyles.Right)));
            this.TextBox1.Enabled = false;
            this.TextBox1.Location = new System.Drawing.Point(3, 268);
            this.TextBox1.Name = "TextBox1";
            this.TextBox1.Size = new System.Drawing.Size(397, 20);
            this.TextBox1.TabIndex = 1;
            this.TextBox1.Visible = false;
            // 
            // mensajes
            // 
            this.mensajes.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom)
                        | System.Windows.Forms.AnchorStyles.Left)
                        | System.Windows.Forms.AnchorStyles.Right)));
            this.mensajes.Location = new System.Drawing.Point(3, 4);
            this.mensajes.Multiline = true;
            this.mensajes.Name = "mensajes";
            this.mensajes.ReadOnly = true;
            this.mensajes.Size = new System.Drawing.Size(496, 259);
            this.mensajes.TabIndex = 0;
            // 
            // ToolStrip1
            // 
            this.ToolStrip1.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.ToolStripDropDownButton1,
            this.ToolStripDropDownButton2,
            this.toolStripSeparator1,
            this.buttonAbout});
            this.ToolStrip1.Location = new System.Drawing.Point(0, 0);
            this.ToolStrip1.Name = "ToolStrip1";
            this.ToolStrip1.Size = new System.Drawing.Size(542, 25);
            this.ToolStrip1.TabIndex = 10;
            this.ToolStrip1.Text = "ToolStrip1";
            // 
            // ToolStripDropDownButton1
            // 
            this.ToolStripDropDownButton1.AutoToolTip = false;
            this.ToolStripDropDownButton1.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Text;
            this.ToolStripDropDownButton1.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.LoginPorHuellaToolStripMenuItem,
            this.LoginPorPasswordToolStripMenuItem,
            this.EnrolamientoToolStripMenuItem,
            this.verPresentesToolStripMenuItem});
            this.ToolStripDropDownButton1.ImageTransparentColor = System.Drawing.Color.Magenta;
            this.ToolStripDropDownButton1.Name = "ToolStripDropDownButton1";
            this.ToolStripDropDownButton1.Size = new System.Drawing.Size(45, 22);
            this.ToolStripDropDownButton1.Text = "Login";
            // 
            // LoginPorHuellaToolStripMenuItem
            // 
            this.LoginPorHuellaToolStripMenuItem.AutoToolTip = true;
            this.LoginPorHuellaToolStripMenuItem.Enabled = false;
            this.LoginPorHuellaToolStripMenuItem.Name = "LoginPorHuellaToolStripMenuItem";
            this.LoginPorHuellaToolStripMenuItem.Size = new System.Drawing.Size(178, 22);
            this.LoginPorHuellaToolStripMenuItem.Text = "Login por huella";
            this.LoginPorHuellaToolStripMenuItem.ToolTipText = "Login utilizando un dispositivo biométrico";
            this.LoginPorHuellaToolStripMenuItem.Click += new System.EventHandler(this.LoginPorHuellaToolStripMenuItem_Click);
            // 
            // LoginPorPasswordToolStripMenuItem
            // 
            this.LoginPorPasswordToolStripMenuItem.AutoToolTip = true;
            this.LoginPorPasswordToolStripMenuItem.Name = "LoginPorPasswordToolStripMenuItem";
            this.LoginPorPasswordToolStripMenuItem.Size = new System.Drawing.Size(178, 22);
            this.LoginPorPasswordToolStripMenuItem.Text = "Login por password";
            this.LoginPorPasswordToolStripMenuItem.ToolTipText = "Login por password solo si lo permiten los administradores";
            this.LoginPorPasswordToolStripMenuItem.Click += new System.EventHandler(this.LoginPorPasswordToolStripMenuItem_Click);
            // 
            // EnrolamientoToolStripMenuItem
            // 
            this.EnrolamientoToolStripMenuItem.AutoToolTip = true;
            this.EnrolamientoToolStripMenuItem.Enabled = false;
            this.EnrolamientoToolStripMenuItem.Name = "EnrolamientoToolStripMenuItem";
            this.EnrolamientoToolStripMenuItem.Size = new System.Drawing.Size(178, 22);
            this.EnrolamientoToolStripMenuItem.Text = "Enrolamiento";
            this.EnrolamientoToolStripMenuItem.ToolTipText = "Registrar huella de usuario para el dispositivo biometrico";
            // 
            // verPresentesToolStripMenuItem
            // 
            this.verPresentesToolStripMenuItem.Name = "verPresentesToolStripMenuItem";
            this.verPresentesToolStripMenuItem.Size = new System.Drawing.Size(178, 22);
            this.verPresentesToolStripMenuItem.Text = "Ver Presentes";
            this.verPresentesToolStripMenuItem.Click += new System.EventHandler(this.verPresentesToolStripMenuItem_Click);
            // 
            // ToolStripDropDownButton2
            // 
            this.ToolStripDropDownButton2.AutoToolTip = false;
            this.ToolStripDropDownButton2.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Text;
            this.ToolStripDropDownButton2.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.ModificarDatosPersonalesToolStripMenuItem,
            this.DefinirHorariosToolStripMenuItem,
            this.cambiarPasswordToolStripMenuItem,
            this.notificarFaltaToolStripMenuItem,
            this.ReportesToolStripMenuItem});
            this.ToolStripDropDownButton2.ImageTransparentColor = System.Drawing.Color.Magenta;
            this.ToolStripDropDownButton2.Name = "ToolStripDropDownButton2";
            this.ToolStripDropDownButton2.Size = new System.Drawing.Size(61, 22);
            this.ToolStripDropDownButton2.Text = "Personal";
            // 
            // ModificarDatosPersonalesToolStripMenuItem
            // 
            this.ModificarDatosPersonalesToolStripMenuItem.AutoToolTip = true;
            this.ModificarDatosPersonalesToolStripMenuItem.Name = "ModificarDatosPersonalesToolStripMenuItem";
            this.ModificarDatosPersonalesToolStripMenuItem.Size = new System.Drawing.Size(213, 22);
            this.ModificarDatosPersonalesToolStripMenuItem.Text = "Modificar datos personales";
            this.ModificarDatosPersonalesToolStripMenuItem.ToolTipText = "Modificar datos simples";
            this.ModificarDatosPersonalesToolStripMenuItem.Click += new System.EventHandler(this.ModificarDatosPersonalesToolStripMenuItem_Click);
            // 
            // DefinirHorariosToolStripMenuItem
            // 
            this.DefinirHorariosToolStripMenuItem.Name = "DefinirHorariosToolStripMenuItem";
            this.DefinirHorariosToolStripMenuItem.Size = new System.Drawing.Size(213, 22);
            this.DefinirHorariosToolStripMenuItem.Text = "Definir horarios";
            this.DefinirHorariosToolStripMenuItem.Click += new System.EventHandler(this.DefinirHorariosToolStripMenuItem_Click);
            // 
            // cambiarPasswordToolStripMenuItem
            // 
            this.cambiarPasswordToolStripMenuItem.Name = "cambiarPasswordToolStripMenuItem";
            this.cambiarPasswordToolStripMenuItem.Size = new System.Drawing.Size(213, 22);
            this.cambiarPasswordToolStripMenuItem.Text = "Cambiar Password";
            this.cambiarPasswordToolStripMenuItem.Click += new System.EventHandler(this.cambiarPasswordToolStripMenuItem_Click);
            // 
            // notificarFaltaToolStripMenuItem
            // 
            this.notificarFaltaToolStripMenuItem.Enabled = false;
            this.notificarFaltaToolStripMenuItem.Name = "notificarFaltaToolStripMenuItem";
            this.notificarFaltaToolStripMenuItem.Size = new System.Drawing.Size(213, 22);
            this.notificarFaltaToolStripMenuItem.Text = "Notificar falta";
            // 
            // ReportesToolStripMenuItem
            // 
            this.ReportesToolStripMenuItem.Enabled = false;
            this.ReportesToolStripMenuItem.Name = "ReportesToolStripMenuItem";
            this.ReportesToolStripMenuItem.Size = new System.Drawing.Size(213, 22);
            this.ReportesToolStripMenuItem.Text = "Informes y reportes";
            this.ReportesToolStripMenuItem.ToolTipText = "Reporte sumarizado por persona";
            // 
            // toolStripSeparator1
            // 
            this.toolStripSeparator1.Name = "toolStripSeparator1";
            this.toolStripSeparator1.Size = new System.Drawing.Size(6, 25);
            // 
            // buttonAbout
            // 
            this.buttonAbout.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Text;
            this.buttonAbout.Image = ((System.Drawing.Image)(resources.GetObject("buttonAbout.Image")));
            this.buttonAbout.ImageTransparentColor = System.Drawing.Color.Magenta;
            this.buttonAbout.Name = "buttonAbout";
            this.buttonAbout.Size = new System.Drawing.Size(60, 22);
            this.buttonAbout.Text = "Acerca De";
            this.buttonAbout.ToolTipText = "Acerca De";
            this.buttonAbout.Click += new System.EventHandler(this.buttonAbout_Click);
            // 
            // Principal
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.BackgroundImageLayout = System.Windows.Forms.ImageLayout.Stretch;
            this.ClientSize = new System.Drawing.Size(542, 553);
            this.Controls.Add(this.ToolStrip1);
            this.Controls.Add(this.panelMensajes);
            this.Controls.Add(this.BotonLoginPassword);
            this.Controls.Add(this.BotonLoginHuella);
            this.Controls.Add(this.labelFecha);
            this.Controls.Add(this.labelHora);
            this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
            this.Name = "Principal";
            this.Text = "Control de Ingreso/Egreso";
            this.Load += new System.EventHandler(this.Principal_Load);
            this.panelMensajes.ResumeLayout(false);
            this.panelMensajes.PerformLayout();
            this.ToolStrip1.ResumeLayout(false);
            this.ToolStrip1.PerformLayout();
            this.ResumeLayout(false);
            this.PerformLayout();

	    }
	    internal System.Windows.Forms.Label labelHora;
	    internal System.Windows.Forms.Label labelFecha;
	    internal System.Windows.Forms.Button BotonLoginHuella;
	    internal System.Windows.Forms.Button BotonLoginPassword;
	    internal System.Windows.Forms.Timer Timer1;
	    internal System.Windows.Forms.Panel panelMensajes;
	    internal System.Windows.Forms.TextBox mensajes;
	    internal System.Windows.Forms.Button botonEnviar;
	    internal System.Windows.Forms.TextBox TextBox1;
	    internal System.Windows.Forms.ToolStrip ToolStrip1;
	    internal System.Windows.Forms.ToolStripDropDownButton ToolStripDropDownButton1;
	    internal System.Windows.Forms.ToolStripMenuItem LoginPorHuellaToolStripMenuItem;
	    internal System.Windows.Forms.ToolStripMenuItem LoginPorPasswordToolStripMenuItem;
	    internal System.Windows.Forms.ToolStripMenuItem EnrolamientoToolStripMenuItem;
	    internal System.Windows.Forms.ToolStripDropDownButton ToolStripDropDownButton2;
	    internal System.Windows.Forms.ToolStripMenuItem ModificarDatosPersonalesToolStripMenuItem;
	    internal System.Windows.Forms.ToolStripMenuItem DefinirHorariosToolStripMenuItem;
	    internal System.Windows.Forms.ToolStripMenuItem ReportesToolStripMenuItem;


        

        #endregion
        private System.Windows.Forms.ToolStripMenuItem verPresentesToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem notificarFaltaToolStripMenuItem;
        private System.Windows.Forms.ToolStripButton buttonAbout;
        private System.Windows.Forms.ToolStripSeparator toolStripSeparator1;
        private System.Windows.Forms.ToolStripMenuItem cambiarPasswordToolStripMenuItem;
    }
}

