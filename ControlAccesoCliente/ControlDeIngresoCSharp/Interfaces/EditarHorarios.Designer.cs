namespace ControlDeIngresoCSharp.Interfaces
{
    partial class EditarHorarios
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(EditarHorarios));
            this.label1 = new System.Windows.Forms.Label();
            this.asignadoTable = new System.Windows.Forms.DataGridView();
            this.guardarButton = new System.Windows.Forms.Button();
            this.cambiarHorarioButton = new System.Windows.Forms.Button();
            this.eliminarButton = new System.Windows.Forms.Button();
            this.label2 = new System.Windows.Forms.Label();
            this.areaCombo = new System.Windows.Forms.ComboBox();
            this.label3 = new System.Windows.Forms.Label();
            this.diaCombo = new System.Windows.Forms.ComboBox();
            this.label4 = new System.Windows.Forms.Label();
            this.label5 = new System.Windows.Forms.Label();
            this.ingresoText = new System.Windows.Forms.TextBox();
            this.egresoText = new System.Windows.Forms.TextBox();
            this.label6 = new System.Windows.Forms.Label();
            this.horasNecesariasTextBox = new System.Windows.Forms.TextBox();
            this.label7 = new System.Windows.Forms.Label();
            this.totalAsignadoTextBox = new System.Windows.Forms.TextBox();
            ((System.ComponentModel.ISupportInitialize)(this.asignadoTable)).BeginInit();
            this.SuspendLayout();
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Font = new System.Drawing.Font("Microsoft Sans Serif", 11.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label1.Location = new System.Drawing.Point(12, 21);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(157, 18);
            this.label1.TabIndex = 0;
            this.label1.Text = "Horarios Asignados";
            // 
            // asignadoTable
            // 
            this.asignadoTable.AllowUserToAddRows = false;
            this.asignadoTable.AllowUserToDeleteRows = false;
            this.asignadoTable.AllowUserToResizeRows = false;
            this.asignadoTable.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom)
                        | System.Windows.Forms.AnchorStyles.Left)
                        | System.Windows.Forms.AnchorStyles.Right)));
            this.asignadoTable.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.asignadoTable.Location = new System.Drawing.Point(15, 55);
            this.asignadoTable.MultiSelect = false;
            this.asignadoTable.Name = "asignadoTable";
            this.asignadoTable.ReadOnly = true;
            this.asignadoTable.SelectionMode = System.Windows.Forms.DataGridViewSelectionMode.FullRowSelect;
            this.asignadoTable.Size = new System.Drawing.Size(595, 253);
            this.asignadoTable.TabIndex = 1;
            // 
            // guardarButton
            // 
            this.guardarButton.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Right)));
            this.guardarButton.Location = new System.Drawing.Point(557, 361);
            this.guardarButton.Name = "guardarButton";
            this.guardarButton.Size = new System.Drawing.Size(75, 23);
            this.guardarButton.TabIndex = 2;
            this.guardarButton.Text = "Guardar";
            this.guardarButton.UseVisualStyleBackColor = true;
            this.guardarButton.Click += new System.EventHandler(this.guardarButton_Click);
            // 
            // cambiarHorarioButton
            // 
            this.cambiarHorarioButton.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)));
            this.cambiarHorarioButton.Location = new System.Drawing.Point(15, 314);
            this.cambiarHorarioButton.Name = "cambiarHorarioButton";
            this.cambiarHorarioButton.Size = new System.Drawing.Size(113, 23);
            this.cambiarHorarioButton.TabIndex = 3;
            this.cambiarHorarioButton.Text = "Cambiar horario";
            this.cambiarHorarioButton.UseVisualStyleBackColor = true;
            this.cambiarHorarioButton.Click += new System.EventHandler(this.cambiarHorarioButton_Click);
            // 
            // eliminarButton
            // 
            this.eliminarButton.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Right)));
            this.eliminarButton.Location = new System.Drawing.Point(535, 314);
            this.eliminarButton.Name = "eliminarButton";
            this.eliminarButton.Size = new System.Drawing.Size(75, 23);
            this.eliminarButton.TabIndex = 4;
            this.eliminarButton.Text = "Eliminar";
            this.eliminarButton.UseVisualStyleBackColor = true;
            this.eliminarButton.Click += new System.EventHandler(this.eliminarButton_Click);
            // 
            // label2
            // 
            this.label2.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)
                        | System.Windows.Forms.AnchorStyles.Right)));
            this.label2.AutoSize = true;
            this.label2.Font = new System.Drawing.Font("Microsoft Sans Serif", 9F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label2.Location = new System.Drawing.Point(12, 346);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(36, 15);
            this.label2.TabIndex = 5;
            this.label2.Text = "Área";
            // 
            // areaCombo
            // 
            this.areaCombo.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)));
            this.areaCombo.FormattingEnabled = true;
            this.areaCombo.Location = new System.Drawing.Point(15, 364);
            this.areaCombo.Name = "areaCombo";
            this.areaCombo.Size = new System.Drawing.Size(154, 21);
            this.areaCombo.TabIndex = 6;
            this.areaCombo.SelectedIndexChanged += new System.EventHandler(this.areaCombo_SelectedIndexChanged);
            // 
            // label3
            // 
            this.label3.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)
                        | System.Windows.Forms.AnchorStyles.Right)));
            this.label3.AutoSize = true;
            this.label3.Font = new System.Drawing.Font("Microsoft Sans Serif", 9F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label3.Location = new System.Drawing.Point(183, 346);
            this.label3.Name = "label3";
            this.label3.Size = new System.Drawing.Size(29, 15);
            this.label3.TabIndex = 5;
            this.label3.Text = "Día";
            // 
            // diaCombo
            // 
            this.diaCombo.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)));
            this.diaCombo.FormattingEnabled = true;
            this.diaCombo.Items.AddRange(new object[] {
            "Lunes",
            "Martes",
            "Miércoles",
            "Jueves",
            "Viernes",
            "Sábado"});
            this.diaCombo.Location = new System.Drawing.Point(186, 364);
            this.diaCombo.Name = "diaCombo";
            this.diaCombo.Size = new System.Drawing.Size(120, 21);
            this.diaCombo.TabIndex = 7;
            // 
            // label4
            // 
            this.label4.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Right)));
            this.label4.AutoSize = true;
            this.label4.Font = new System.Drawing.Font("Microsoft Sans Serif", 9F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label4.Location = new System.Drawing.Point(321, 346);
            this.label4.Name = "label4";
            this.label4.Size = new System.Drawing.Size(55, 15);
            this.label4.TabIndex = 5;
            this.label4.Text = "Ingreso";
            // 
            // label5
            // 
            this.label5.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Right)));
            this.label5.AutoSize = true;
            this.label5.Font = new System.Drawing.Font("Microsoft Sans Serif", 9F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label5.Location = new System.Drawing.Point(441, 346);
            this.label5.Name = "label5";
            this.label5.Size = new System.Drawing.Size(52, 15);
            this.label5.TabIndex = 5;
            this.label5.Text = "Egreso";
            // 
            // ingresoText
            // 
            this.ingresoText.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Right)));
            this.ingresoText.Location = new System.Drawing.Point(324, 365);
            this.ingresoText.Name = "ingresoText";
            this.ingresoText.Size = new System.Drawing.Size(100, 20);
            this.ingresoText.TabIndex = 8;
            this.ingresoText.Text = "HH:MM";
            this.ingresoText.Enter += new System.EventHandler(this.focoIngreso);
            // 
            // egresoText
            // 
            this.egresoText.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Right)));
            this.egresoText.Location = new System.Drawing.Point(444, 364);
            this.egresoText.Name = "egresoText";
            this.egresoText.Size = new System.Drawing.Size(100, 20);
            this.egresoText.TabIndex = 9;
            this.egresoText.Text = "HH:MM";
            this.egresoText.Enter += new System.EventHandler(this.egresoFoco);
            // 
            // label6
            // 
            this.label6.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)));
            this.label6.AutoSize = true;
            this.label6.Font = new System.Drawing.Font("Microsoft Sans Serif", 9F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label6.Location = new System.Drawing.Point(52, 428);
            this.label6.Name = "label6";
            this.label6.Size = new System.Drawing.Size(182, 15);
            this.label6.TabIndex = 5;
            this.label6.Text = "Horas mínimas necesarias:";
            // 
            // horasNecesariasTextBox
            // 
            this.horasNecesariasTextBox.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)));
            this.horasNecesariasTextBox.Location = new System.Drawing.Point(240, 428);
            this.horasNecesariasTextBox.Name = "horasNecesariasTextBox";
            this.horasNecesariasTextBox.ReadOnly = true;
            this.horasNecesariasTextBox.Size = new System.Drawing.Size(100, 20);
            this.horasNecesariasTextBox.TabIndex = 10;
            // 
            // label7
            // 
            this.label7.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Right)));
            this.label7.AutoSize = true;
            this.label7.Font = new System.Drawing.Font("Microsoft Sans Serif", 9F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label7.Location = new System.Drawing.Point(346, 429);
            this.label7.Name = "label7";
            this.label7.Size = new System.Drawing.Size(106, 15);
            this.label7.TabIndex = 5;
            this.label7.Text = "Total asignado:";
            // 
            // totalAsignadoTextBox
            // 
            this.totalAsignadoTextBox.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Right)));
            this.totalAsignadoTextBox.Location = new System.Drawing.Point(456, 427);
            this.totalAsignadoTextBox.Name = "totalAsignadoTextBox";
            this.totalAsignadoTextBox.ReadOnly = true;
            this.totalAsignadoTextBox.Size = new System.Drawing.Size(78, 20);
            this.totalAsignadoTextBox.TabIndex = 11;
            // 
            // EditarHorarios
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(644, 472);
            this.Controls.Add(this.totalAsignadoTextBox);
            this.Controls.Add(this.horasNecesariasTextBox);
            this.Controls.Add(this.egresoText);
            this.Controls.Add(this.ingresoText);
            this.Controls.Add(this.diaCombo);
            this.Controls.Add(this.areaCombo);
            this.Controls.Add(this.label5);
            this.Controls.Add(this.label4);
            this.Controls.Add(this.label3);
            this.Controls.Add(this.label7);
            this.Controls.Add(this.label6);
            this.Controls.Add(this.label2);
            this.Controls.Add(this.eliminarButton);
            this.Controls.Add(this.cambiarHorarioButton);
            this.Controls.Add(this.guardarButton);
            this.Controls.Add(this.asignadoTable);
            this.Controls.Add(this.label1);
            this.ForeColor = System.Drawing.SystemColors.ControlText;
            this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
            this.Name = "EditarHorarios";
            this.Text = "AsignarHorarios";
            this.Load += new System.EventHandler(this.loadform);
            this.FormClosed += new System.Windows.Forms.FormClosedEventHandler(this.EditarHorarios_FormClosed);
            ((System.ComponentModel.ISupportInitialize)(this.asignadoTable)).EndInit();
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.DataGridView asignadoTable;
        private System.Windows.Forms.Button guardarButton;
        private System.Windows.Forms.Button cambiarHorarioButton;
        private System.Windows.Forms.Button eliminarButton;
        private System.Windows.Forms.Label label2;
        private System.Windows.Forms.ComboBox areaCombo;
        private System.Windows.Forms.Label label3;
        private System.Windows.Forms.ComboBox diaCombo;
        private System.Windows.Forms.Label label4;
        private System.Windows.Forms.Label label5;
        private System.Windows.Forms.TextBox ingresoText;
        private System.Windows.Forms.TextBox egresoText;
        private System.Windows.Forms.Label label6;
        private System.Windows.Forms.TextBox horasNecesariasTextBox;
        private System.Windows.Forms.Label label7;
        private System.Windows.Forms.TextBox totalAsignadoTextBox;
    }
}