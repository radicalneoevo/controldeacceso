using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using ControlDeIngresoCSharp.Excepciones;
using ControlDeIngresoCSharp.Logica;
using ControlDeIngresoCSharp.Base_de_datos;

namespace ControlDeIngresoCSharp.Interfaces
{
    public partial class EditarHorarios : Form
    {
        //variables
        private Principal padre;
        private string usuario;
        private List<HorarioHabitualDTO> turnos;

        public EditarHorarios(Principal p, string u)
        {
            InitializeComponent();
            padre = p;
            usuario = u;
        }

        /// <summary>
        /// Agrega una columna a la tabla en base al turno pasado como parámetro
        /// </summary>
        /// <param name="turno">Turno registrado</param>
        private void agregarColumna(HorarioHabitualDTO turno)
        {
            //Obtengo la data table
            DataTable dt = (DataTable)asignadoTable.DataSource;

            //Pongo autozise para las columnas
            asignadoTable.ColumnHeadersHeightSizeMode =
                System.Windows.Forms.
                    DataGridViewColumnHeadersHeightSizeMode.AutoSize;

            //Creo las columnas si no hay tabla
            if (dt == null)
            {
                asignadoTable.DataSource = null;
                dt = new DataTable();
                //Area
                dt.Columns.Add("Área", typeof(string));
                dt.Columns[0].ReadOnly = true;
                //Dia
                dt.Columns.Add("Día", typeof(string));
                dt.Columns[1].ReadOnly = true;
                //Ingreso
                dt.Columns.Add("Ingreso", typeof(string));
                dt.Columns[2].ReadOnly = true;
                //Egreso
                dt.Columns.Add("Egreso", typeof(string));
                dt.Columns[3].ReadOnly = true;
                //Duraciòn
                dt.Columns.Add("Duración", typeof(string));
                dt.Columns[4].ReadOnly = true;
                //Confirmado
                dt.Columns.Add("Confirmado", typeof(string));
                dt.Columns[5].ReadOnly = true;
            }

            //Creo la fila
            DataRow fila = dt.NewRow();

            //Cargo los datos
            fila[0] = turno.Area;
            fila[1] = turno.Dia;
            fila[2] = turno.Ingreso;
            fila[3] = turno.Egreso;
            fila[4] = turno.Duracion;
            fila[5] = turno.Confirmado;
            
            //Otra forma de cargarlos seria hacer lo siguiente:
            //dt.Rows.Add("Sistemas", "Martes", "12:30","15:30", "03:00" ,"SI");

            dt.Rows.Add(fila);

            asignadoTable.DataSource = dt;
        }

        /// <summary>
        /// Vuelve a la ventana anterior al cerrar
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void EditarHorarios_FormClosed(object sender, FormClosedEventArgs e)
        {
            padre.Show();
        }

        /// <summary>
        /// Valida el horario ingresado y lo guarda en la base de datos
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void guardarButton_Click(object sender, EventArgs e)
        {
            if(areaCombo.SelectedIndex == -1)
            {
                MessageBox.Show("No se seleccionó un área", "Error", MessageBoxButtons.OK , MessageBoxIcon.Error);
                return;
            }

            if (diaCombo.SelectedIndex == -1)
            {
                MessageBox.Show("No se seleccionó un día", "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return;
            }

            try
            {
                //este constructor verifica la integridad
                Horario ingreso = new Horario(ingresoText.Text);
                Horario egreso = new Horario(egresoText.Text);

                //el constructor verifica la integridad
                RangoHorario rango = new RangoHorario(ingreso, egreso);

                //el tamaño minimo es 59 minutos
                if (rango.rangoMenor(0, 59))
                    throw new RangoMinimoException();

                //armo la entidad turno DTO
                HorarioHabitualDTO turno = new HorarioHabitualDTO();
                turno.Area = areaCombo.Text;
                turno.Dia = diaCombo.Text;
                turno.Ingreso = ingreso;
                turno.Egreso = egreso;
                turno.Duracion = rango.getDuracion();
                turno.Confirmado = "NO";

                //hay que validar que no se superponga a otros horarios

                foreach (HorarioHabitualDTO t in turnos)
                {
                    if (Fecha.getNumeroDia(t.Dia) == Fecha.getNumeroDia(turno.Dia))
                    {
                        RangoHorario r1 = new RangoHorario(t.Ingreso, t.Egreso);

                        if (r1.rangoSuperpuesto(rango))
                            throw new TurnoSuperpuestoException();

                    }
                }

                //y finalmente guardo el horario
                GestorHorarios gestor = new GestorHorarios();
                gestor.crearHorarioHabitual(this.usuario, turno);

                // y si anda todo bien agrego la columna a la tabla
                this.agregarColumna(turno);
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
       }

        /// <summary>
        /// Carga los datos iniciales necesarios
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void loadform(object sender, EventArgs e)
        {
            GestorUsuarios usuarioDAO = new GestorUsuarios();
            GestorHorarios turnoDAO = new GestorHorarios();

            //Obtiene las areas a las que pertenece el usuario
            List<string> areas = usuarioDAO.getAreasFromUsuario(this.usuario);

            foreach (string area in areas)
            {
                areaCombo.Items.Add(area);   
            }

            //Obtiene los horarios ya asignados
            turnos = turnoDAO.horariosHabitualesRegistrados(this.usuario);

            foreach (HorarioHabitualDTO t in turnos)
            {
                this.agregarColumna(t);
            }

        }

        /// <summary>
        /// Hace que siempre esten seleccionadas las componentes al obtener el foco
        /// para el campo ingreso
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void focoIngreso(object sender, EventArgs e)
        {
            this.ingresoText.Select(0, ingresoText.Text.Length);
        }

        /// <summary>
        /// Hace que siempre esten seleccionada las componentes al obtener el foco
        /// para el campo egreso
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void egresoFoco(object sender, EventArgs e)
        {
            this.egresoText.Select(0, egresoText.Text.Length);
        }

        /// <summary>
        /// Actualiza las horas necesarias y las horas totales a medida que se elige
        /// un área
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void areaCombo_SelectedIndexChanged(object sender, EventArgs e)
        {
            try
            {
                //Si no hay nada seleccionado no hago nada
                if (areaCombo.SelectedIndex == -1)
                    throw new Exception();

                GestorUsuarios usuarioDAO = new GestorUsuarios();

                //Obtiene la cantidad de horas que necesita el usuario en el area seleccionada
                Horario horasNecesarias = usuarioDAO.getHorasNecesarias(this.usuario, this.areaCombo.Text);
                this.horasNecesariasTextBox.Text = horasNecesarias.ToString();

                //Obtiene las horas totales hasta el momento
                Horario horasTotales =usuarioDAO.getHorasAsignadasTotales(this.usuario, this.areaCombo.Text);
                this.totalAsignadoTextBox.Text = horasTotales.ToString();
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        /// <summary>
        /// Elimina el horario seleccionado solo si no esta confirmado
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void eliminarButton_Click(object sender, EventArgs e)
        {
            try
            {
                if (asignadoTable.SelectedRows.Count == 0)
                    throw new NoSeleccionoFilaException();

                //Obtengo las celdas de la fila seleccionada
                DataGridViewCellCollection celdas = asignadoTable.SelectedRows[0].Cells;

                //La quinta celda corresponde al valor de confirmacion
                if (celdas[5].Value.ToString().Equals("SI"))
                    throw new EliminacionInvalidaException();

                //Si esta NO confiramda procedo a armar el turnoDTO
                HorarioHabitualDTO turno = new HorarioHabitualDTO();
                turno.Area = celdas[0].Value.ToString();
                turno.Dia = celdas[1].Value.ToString();
                turno.Ingreso = new Horario(celdas[2].Value.ToString());
                turno.Egreso = new Horario(celdas[3].Value.ToString());
                turno.Duracion = new Horario(celdas[4].Value.ToString());
                turno.Confirmado = celdas[5].Value.ToString();

                //Elimino el horario de la BD
                GestorHorarios turnoDAO = new GestorHorarios();
                turnoDAO.eliminarHorariosHabitual(usuario, turno);

                //Carga los horarios restantes en la tabla
                turnos = turnoDAO.horariosHabitualesRegistrados(this.usuario);
                asignadoTable.DataSource = null;
                foreach (HorarioHabitualDTO t in turnos)
                {
                    this.agregarColumna(t);
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        /// <summary>
        /// Para cuando se hace click en cambiar horario 
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void cambiarHorarioButton_Click(object sender, EventArgs e)
        {
            try
            {
                if (asignadoTable.SelectedRows.Count == 0)
                    throw new NoSeleccionoFilaException();

                //Obtengo las celdas de la fila seleccionada
                DataGridViewCellCollection celdas = asignadoTable.SelectedRows[0].Cells;

                //La quinta celda corresponde al valor de confirmacion
                if (celdas[5].Value.ToString().Equals("NO"))
                    throw new CambioHorarioInvalidoException();

                //Procedo a armar el turnoDTO
                HorarioHabitualDTO turno = new HorarioHabitualDTO();
                turno.Area = celdas[0].Value.ToString();
                turno.Dia = celdas[1].Value.ToString();
                turno.Ingreso = new Horario(celdas[2].Value.ToString());
                turno.Egreso = new Horario(celdas[3].Value.ToString());
                turno.Duracion = new Horario(celdas[4].Value.ToString());
                turno.Confirmado = celdas[5].Value.ToString();

                //Registro la solicitud para el admin
                GestorHorarios horarioDAO = new GestorHorarios();
                horarioDAO.registrarSolicitudCambioHorario(this.usuario, turno);

                //Mensajito
                MessageBox.Show("Solicitud de cambio registrada con éxito.", "Éxito",
                    MessageBoxButtons.OK, MessageBoxIcon.Information);
            }
            catch (CambioHorarioInvalidoException ex)
            {
                MessageBox.Show(ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            catch (NoSeleccionoFilaException ex)
            {
                MessageBox.Show(ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

    }
}
