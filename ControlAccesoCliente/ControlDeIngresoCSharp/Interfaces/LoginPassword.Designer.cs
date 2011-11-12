namespace ControlDeIngresoCSharp
{
    partial class login_por_password
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

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(login_por_password));
            this.labelAdvertencia = new System.Windows.Forms.Label();
            this.labelUsuario = new System.Windows.Forms.Label();
            this.campoDni = new System.Windows.Forms.TextBox();
            this.Label1 = new System.Windows.Forms.Label();
            this.campoPass = new System.Windows.Forms.TextBox();
            this.botonAceptar = new System.Windows.Forms.Button();
            this.botonCancelar = new System.Windows.Forms.Button();
            this.campoObservaciones = new System.Windows.Forms.TextBox();
            this.label2 = new System.Windows.Forms.Label();
            this.label3 = new System.Windows.Forms.Label();
            this.comboArea = new System.Windows.Forms.ComboBox();
            this.SuspendLayout();
            // 
            // labelAdvertencia
            // 
            this.labelAdvertencia.AutoSize = true;
            this.labelAdvertencia.Font = new System.Drawing.Font("Microsoft Sans Serif", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.labelAdvertencia.Location = new System.Drawing.Point(12, 19);
            this.labelAdvertencia.Name = "labelAdvertencia";
            this.labelAdvertencia.Size = new System.Drawing.Size(445, 20);
            this.labelAdvertencia.TabIndex = 0;
            this.labelAdvertencia.Text = "Solo utilice el password si no funciona el dispositivo biometrico";
            // 
            // labelUsuario
            // 
            this.labelUsuario.AutoSize = true;
            this.labelUsuario.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.labelUsuario.Location = new System.Drawing.Point(110, 73);
            this.labelUsuario.Name = "labelUsuario";
            this.labelUsuario.Size = new System.Drawing.Size(33, 13);
            this.labelUsuario.TabIndex = 1;
            this.labelUsuario.Text = "DNI:";
            // 
            // campoDni
            // 
            this.campoDni.Location = new System.Drawing.Point(179, 70);
            this.campoDni.Name = "campoDni";
            this.campoDni.ShortcutsEnabled = false;
            this.campoDni.Size = new System.Drawing.Size(156, 20);
            this.campoDni.TabIndex = 2;
            this.campoDni.KeyPress += new System.Windows.Forms.KeyPressEventHandler(this.campoDni_KeyPress);
            // 
            // Label1
            // 
            this.Label1.AutoSize = true;
            this.Label1.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.Label1.Location = new System.Drawing.Point(110, 105);
            this.Label1.Name = "Label1";
            this.Label1.Size = new System.Drawing.Size(65, 13);
            this.Label1.TabIndex = 3;
            this.Label1.Text = "Password:";
            // 
            // campoPass
            // 
            this.campoPass.Location = new System.Drawing.Point(179, 102);
            this.campoPass.Name = "campoPass";
            this.campoPass.PasswordChar = '*';
            this.campoPass.ShortcutsEnabled = false;
            this.campoPass.Size = new System.Drawing.Size(156, 20);
            this.campoPass.TabIndex = 4;
            this.campoPass.KeyPress += new System.Windows.Forms.KeyPressEventHandler(this.campoPass_KeyPress);
            // 
            // botonAceptar
            // 
            this.botonAceptar.Location = new System.Drawing.Point(31, 339);
            this.botonAceptar.Name = "botonAceptar";
            this.botonAceptar.Size = new System.Drawing.Size(113, 24);
            this.botonAceptar.TabIndex = 5;
            this.botonAceptar.Text = "Aceptar";
            this.botonAceptar.UseVisualStyleBackColor = true;
            this.botonAceptar.Click += new System.EventHandler(this.botonAceptar_Click);
            // 
            // botonCancelar
            // 
            this.botonCancelar.Location = new System.Drawing.Point(324, 339);
            this.botonCancelar.Name = "botonCancelar";
            this.botonCancelar.Size = new System.Drawing.Size(112, 24);
            this.botonCancelar.TabIndex = 6;
            this.botonCancelar.Text = "Cancelar";
            this.botonCancelar.UseVisualStyleBackColor = true;
            this.botonCancelar.Click += new System.EventHandler(this.botonCancelar_Click);
            // 
            // campoObservaciones
            // 
            this.campoObservaciones.Location = new System.Drawing.Point(32, 150);
            this.campoObservaciones.Multiline = true;
            this.campoObservaciones.Name = "campoObservaciones";
            this.campoObservaciones.Size = new System.Drawing.Size(404, 113);
            this.campoObservaciones.TabIndex = 7;
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label2.Location = new System.Drawing.Point(29, 134);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(91, 13);
            this.label2.TabIndex = 8;
            this.label2.Text = "Observaciones";
            // 
            // label3
            // 
            this.label3.AutoSize = true;
            this.label3.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label3.Location = new System.Drawing.Point(29, 292);
            this.label3.Name = "label3";
            this.label3.Size = new System.Drawing.Size(116, 13);
            this.label3.TabIndex = 3;
            this.label3.Text = "Area de hora extra:";
            // 
            // comboArea
            // 
            this.comboArea.FormattingEnabled = true;
            this.comboArea.Items.AddRange(new object[] {
            "Sistemas",
            "Conectividad"});
            this.comboArea.Location = new System.Drawing.Point(151, 289);
            this.comboArea.Name = "comboArea";
            this.comboArea.Size = new System.Drawing.Size(166, 21);
            this.comboArea.TabIndex = 9;
            // 
            // login_por_password
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(479, 375);
            this.Controls.Add(this.comboArea);
            this.Controls.Add(this.label2);
            this.Controls.Add(this.campoObservaciones);
            this.Controls.Add(this.botonCancelar);
            this.Controls.Add(this.botonAceptar);
            this.Controls.Add(this.campoPass);
            this.Controls.Add(this.label3);
            this.Controls.Add(this.Label1);
            this.Controls.Add(this.campoDni);
            this.Controls.Add(this.labelUsuario);
            this.Controls.Add(this.labelAdvertencia);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedDialog;
            this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
            this.MaximizeBox = false;
            this.Name = "login_por_password";
            this.ShowInTaskbar = false;
            this.Text = "Login por password";
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        internal System.Windows.Forms.Label labelAdvertencia;
        internal System.Windows.Forms.Label labelUsuario;
        internal System.Windows.Forms.TextBox campoDni;
        internal System.Windows.Forms.Label Label1;
        internal System.Windows.Forms.TextBox campoPass;
        internal System.Windows.Forms.Button botonAceptar;
        internal System.Windows.Forms.Button botonCancelar;
        

        #endregion
        private System.Windows.Forms.TextBox campoObservaciones;
        internal System.Windows.Forms.Label label2;
        internal System.Windows.Forms.Label label3;
        private System.Windows.Forms.ComboBox comboArea;
    }
}