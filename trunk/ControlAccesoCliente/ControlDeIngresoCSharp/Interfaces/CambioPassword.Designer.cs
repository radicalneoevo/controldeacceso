namespace ControlDeIngresoCSharp.Interfaces
{
    partial class CambioPassword
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(CambioPassword));
            this.botonCancelar = new System.Windows.Forms.Button();
            this.botonAceptar = new System.Windows.Forms.Button();
            this.campoPass = new System.Windows.Forms.TextBox();
            this.Label1 = new System.Windows.Forms.Label();
            this.campoDni = new System.Windows.Forms.TextBox();
            this.labelUsuario = new System.Windows.Forms.Label();
            this.label2 = new System.Windows.Forms.Label();
            this.nuevoPass = new System.Windows.Forms.TextBox();
            this.label3 = new System.Windows.Forms.Label();
            this.confirmarNuevoPass = new System.Windows.Forms.TextBox();
            this.SuspendLayout();
            // 
            // botonCancelar
            // 
            this.botonCancelar.Location = new System.Drawing.Point(232, 210);
            this.botonCancelar.Name = "botonCancelar";
            this.botonCancelar.Size = new System.Drawing.Size(112, 24);
            this.botonCancelar.TabIndex = 16;
            this.botonCancelar.Text = "Cancelar";
            this.botonCancelar.UseVisualStyleBackColor = true;
            this.botonCancelar.Click += new System.EventHandler(this.botonCancelar_Click);
            // 
            // botonAceptar
            // 
            this.botonAceptar.Location = new System.Drawing.Point(12, 210);
            this.botonAceptar.Name = "botonAceptar";
            this.botonAceptar.Size = new System.Drawing.Size(113, 24);
            this.botonAceptar.TabIndex = 15;
            this.botonAceptar.Text = "Aceptar";
            this.botonAceptar.UseVisualStyleBackColor = true;
            this.botonAceptar.Click += new System.EventHandler(this.botonAceptar_Click);
            // 
            // campoPass
            // 
            this.campoPass.Location = new System.Drawing.Point(107, 53);
            this.campoPass.Name = "campoPass";
            this.campoPass.PasswordChar = '*';
            this.campoPass.ShortcutsEnabled = false;
            this.campoPass.Size = new System.Drawing.Size(237, 20);
            this.campoPass.TabIndex = 14;
            this.campoPass.KeyPress += new System.Windows.Forms.KeyPressEventHandler(this.campoPass_KeyPress);
            // 
            // Label1
            // 
            this.Label1.AutoSize = true;
            this.Label1.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.Label1.Location = new System.Drawing.Point(38, 56);
            this.Label1.Name = "Label1";
            this.Label1.Size = new System.Drawing.Size(65, 13);
            this.Label1.TabIndex = 13;
            this.Label1.Text = "Password:";
            // 
            // campoDni
            // 
            this.campoDni.Location = new System.Drawing.Point(107, 21);
            this.campoDni.Name = "campoDni";
            this.campoDni.ShortcutsEnabled = false;
            this.campoDni.Size = new System.Drawing.Size(237, 20);
            this.campoDni.TabIndex = 12;
            this.campoDni.KeyPress += new System.Windows.Forms.KeyPressEventHandler(this.campoDni_KeyPress);
            // 
            // labelUsuario
            // 
            this.labelUsuario.AutoSize = true;
            this.labelUsuario.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.labelUsuario.Location = new System.Drawing.Point(38, 24);
            this.labelUsuario.Name = "labelUsuario";
            this.labelUsuario.Size = new System.Drawing.Size(33, 13);
            this.labelUsuario.TabIndex = 11;
            this.labelUsuario.Text = "DNI:";
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label2.Location = new System.Drawing.Point(38, 115);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(106, 13);
            this.label2.TabIndex = 17;
            this.label2.Text = "Nuevo Password:";
            // 
            // nuevoPass
            // 
            this.nuevoPass.Location = new System.Drawing.Point(165, 112);
            this.nuevoPass.Name = "nuevoPass";
            this.nuevoPass.PasswordChar = '*';
            this.nuevoPass.ShortcutsEnabled = false;
            this.nuevoPass.Size = new System.Drawing.Size(179, 20);
            this.nuevoPass.TabIndex = 18;
            this.nuevoPass.KeyPress += new System.Windows.Forms.KeyPressEventHandler(this.nuevoPass_KeyPress);
            // 
            // label3
            // 
            this.label3.AutoSize = true;
            this.label3.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label3.Location = new System.Drawing.Point(38, 157);
            this.label3.Name = "label3";
            this.label3.Size = new System.Drawing.Size(122, 13);
            this.label3.TabIndex = 19;
            this.label3.Text = "Confirmar Password:";
            // 
            // confirmarNuevoPass
            // 
            this.confirmarNuevoPass.Location = new System.Drawing.Point(165, 150);
            this.confirmarNuevoPass.Name = "confirmarNuevoPass";
            this.confirmarNuevoPass.PasswordChar = '*';
            this.confirmarNuevoPass.ShortcutsEnabled = false;
            this.confirmarNuevoPass.Size = new System.Drawing.Size(179, 20);
            this.confirmarNuevoPass.TabIndex = 20;
            this.confirmarNuevoPass.KeyPress += new System.Windows.Forms.KeyPressEventHandler(this.confirmarNuevoPass_KeyPress);
            // 
            // CambioPassword
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(371, 266);
            this.Controls.Add(this.confirmarNuevoPass);
            this.Controls.Add(this.label3);
            this.Controls.Add(this.nuevoPass);
            this.Controls.Add(this.label2);
            this.Controls.Add(this.botonCancelar);
            this.Controls.Add(this.botonAceptar);
            this.Controls.Add(this.campoPass);
            this.Controls.Add(this.Label1);
            this.Controls.Add(this.campoDni);
            this.Controls.Add(this.labelUsuario);
            this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
            this.Name = "CambioPassword";
            this.Text = "CambioPassword";
            this.FormClosed += new System.Windows.Forms.FormClosedEventHandler(this.CambioPassword_FormClosed);
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        internal System.Windows.Forms.Button botonCancelar;
        internal System.Windows.Forms.Button botonAceptar;
        internal System.Windows.Forms.TextBox campoPass;
        internal System.Windows.Forms.Label Label1;
        internal System.Windows.Forms.TextBox campoDni;
        internal System.Windows.Forms.Label labelUsuario;
        internal System.Windows.Forms.Label label2;
        internal System.Windows.Forms.TextBox nuevoPass;
        internal System.Windows.Forms.Label label3;
        internal System.Windows.Forms.TextBox confirmarNuevoPass;

    }
}