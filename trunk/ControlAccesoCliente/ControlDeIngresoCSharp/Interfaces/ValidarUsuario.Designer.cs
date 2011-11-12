namespace ControlDeIngresoCSharp.Interfaces
{
    partial class ValidarUsuario
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(ValidarUsuario));
            this.campoPass = new System.Windows.Forms.TextBox();
            this.Label1 = new System.Windows.Forms.Label();
            this.campoDni = new System.Windows.Forms.TextBox();
            this.labelUsuario = new System.Windows.Forms.Label();
            this.botonCancelar = new System.Windows.Forms.Button();
            this.botonAceptar = new System.Windows.Forms.Button();
            this.SuspendLayout();
            // 
            // campoPass
            // 
            this.campoPass.Location = new System.Drawing.Point(140, 49);
            this.campoPass.Name = "campoPass";
            this.campoPass.PasswordChar = '*';
            this.campoPass.Size = new System.Drawing.Size(156, 20);
            this.campoPass.TabIndex = 8;
            this.campoPass.KeyPress += new System.Windows.Forms.KeyPressEventHandler(this.campoPass_KeyPress);
            // 
            // Label1
            // 
            this.Label1.AutoSize = true;
            this.Label1.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.Label1.Location = new System.Drawing.Point(71, 52);
            this.Label1.Name = "Label1";
            this.Label1.Size = new System.Drawing.Size(65, 13);
            this.Label1.TabIndex = 7;
            this.Label1.Text = "Password:";
            // 
            // campoDni
            // 
            this.campoDni.Location = new System.Drawing.Point(140, 17);
            this.campoDni.Name = "campoDni";
            this.campoDni.ShortcutsEnabled = false;
            this.campoDni.Size = new System.Drawing.Size(156, 20);
            this.campoDni.TabIndex = 6;
            this.campoDni.KeyPress += new System.Windows.Forms.KeyPressEventHandler(this.campoDni_KeyPress);
            // 
            // labelUsuario
            // 
            this.labelUsuario.AutoSize = true;
            this.labelUsuario.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.labelUsuario.Location = new System.Drawing.Point(71, 20);
            this.labelUsuario.Name = "labelUsuario";
            this.labelUsuario.Size = new System.Drawing.Size(33, 13);
            this.labelUsuario.TabIndex = 5;
            this.labelUsuario.Text = "DNI:";
            // 
            // botonCancelar
            // 
            this.botonCancelar.Location = new System.Drawing.Point(231, 92);
            this.botonCancelar.Name = "botonCancelar";
            this.botonCancelar.Size = new System.Drawing.Size(112, 24);
            this.botonCancelar.TabIndex = 10;
            this.botonCancelar.Text = "Cancelar";
            this.botonCancelar.UseVisualStyleBackColor = true;
            this.botonCancelar.Click += new System.EventHandler(this.botonCancelar_Click);
            // 
            // botonAceptar
            // 
            this.botonAceptar.Location = new System.Drawing.Point(23, 92);
            this.botonAceptar.Name = "botonAceptar";
            this.botonAceptar.Size = new System.Drawing.Size(113, 24);
            this.botonAceptar.TabIndex = 9;
            this.botonAceptar.Text = "Aceptar";
            this.botonAceptar.UseVisualStyleBackColor = true;
            this.botonAceptar.Click += new System.EventHandler(this.botonAceptar_Click);
            // 
            // ValidarUsuario
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(381, 128);
            this.Controls.Add(this.botonCancelar);
            this.Controls.Add(this.botonAceptar);
            this.Controls.Add(this.campoPass);
            this.Controls.Add(this.Label1);
            this.Controls.Add(this.campoDni);
            this.Controls.Add(this.labelUsuario);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedDialog;
            this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
            this.Name = "ValidarUsuario";
            this.ShowInTaskbar = false;
            this.Text = "Autenticación Usuario";
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        internal System.Windows.Forms.TextBox campoPass;
        internal System.Windows.Forms.Label Label1;
        internal System.Windows.Forms.TextBox campoDni;
        internal System.Windows.Forms.Label labelUsuario;
        internal System.Windows.Forms.Button botonCancelar;
        internal System.Windows.Forms.Button botonAceptar;
    }
}