using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using MySql.Data.MySqlClient;
using ControlDeIngresoCSharp.Logica;
using ControlDeIngresoCSharp.Excepciones;
using System.Configuration;

namespace ControlDeIngresoCSharp.Base_de_datos
{
    class GestorHorarios
    {
        //********Variables**********

        string conexionString = "Server=" + ConfigurationSettings.AppSettings["dbLocation"] + ";"
                + "Database=controlacceso;"
                + "Uid=" + ConfigurationSettings.AppSettings["dbUser"] + ";"
                + "Pwd=AccessControl20100215;";

        //**********************************
        //***** Métodos de lectura *********
        //**********************************
        /// <summary>
        /// Obtiene los turnos registrados para un usuario... tanto si estan confirmados como si no lo están
        /// </summary>
        /// <param name="usuario"></param>
        /// <returns></returns>
        public List<HorarioHabitualDTO> horariosHabitualesRegistrados(string usuario)
        {
            //Abro conexión
            MySqlConnection conexionADO = new MySqlConnection();
            conexionADO.ConnectionString = conexionString;
            conexionADO.Open();

            //Creo lector =) y efectuo la consulta
            MySqlDataReader data;
            MySqlCommand lectura = new MySqlCommand("SELECT * FROM horario_asignado_habitual_duracion as h, area as a WHERE " +
                "h.usuario = '" + usuario + "' AND " +
                "h.area = a.idArea;", conexionADO);
            data = lectura.ExecuteReader();

            //armo la lista 
            List<HorarioHabitualDTO> turnos = new List<HorarioHabitualDTO>();
            while (data.Read())
            {
                HorarioHabitualDTO t = new HorarioHabitualDTO();
                t.Area = data.GetString("nombreArea");
                t.Dia = Fecha.getDiaSemana(data.GetInt32("dia"));
                t.Ingreso = new Horario(data.GetString("ingreso"));
                t.Egreso = new Horario(data.GetString("egreso"));
                t.Duracion = new Horario(data.GetString("duracion"));

                int confirmacion = data.GetInt32("confirmado");
                if (confirmacion == 0)
                    t.Confirmado = "NO";
                else
                    t.Confirmado = "SI";

                turnos.Add(t);
            }

            data.Close();

            return turnos;
        }

        //************************************
        //***** Métodos de escritura *********
        //************************************

        /// <summary>
        /// Asigna el horario habitual pasado por paràmetro como no confirmado
        /// </summary>
        /// <param name="usuario">dni del usuario en formato string</param>
        /// <param name="turno">parametros del turno</param>
        public void crearHorarioHabitual(string usuario, HorarioHabitualDTO horarioHabitual)
        {
            //Abro conexión
            MySqlConnection conexionADO = new MySqlConnection();
            conexionADO.ConnectionString = conexionString;
            conexionADO.Open();

            //Necesito el ID de area para determinar el perìodo actual que le corresponde
            //Creo consulta
            MySqlDataReader data;
            MySqlCommand lectura = new MySqlCommand("SELECT idArea FROM area WHERE nombreArea = '" + horarioHabitual.Area + "';", conexionADO);
            data = lectura.ExecuteReader();
            int idArea = 0;

            if (data.Read())
                idArea = data.GetInt32("idArea");
            else
                throw new SQLErrorException("Área");

            data.Close();


            //Obtengo el perìodo actual
            MySqlDataReader data2;
            MySqlCommand lectura2 = new MySqlCommand("SELECT idPeriodo, nombre, area, inicio, fin, observaciones " +
            "FROM periodo " +
            "WHERE inicio < curdate() AND curdate() < fin AND area = " + idArea, conexionADO);
            data2 = lectura2.ExecuteReader();
            int idPeriodo = 0;

            if (data2.Read())
                idPeriodo = data2.GetInt32("idPeriodo");
            else
                throw new SQLErrorException("Periodo");

            data2.Close();

            // Ahora guardo el horario asignado habitual :D
            string myquerystring1 = "INSERT INTO horario_asignado_habitual (usuario, dia, ingreso, egreso, area, periodo, confirmado) " +
            "VALUES ('" + usuario + "'," + Fecha.getNumeroDia(horarioHabitual.Dia) + "," + horarioHabitual.Ingreso.getSQLFormat() + "," + horarioHabitual.Egreso.getSQLFormat() + "," + idArea +
                    "," + idPeriodo + "," + horarioHabitual.confirmadoForSQL() + ");";

            //Asigno y ejecuto
            MySqlCommand cmd = new MySqlCommand();
            cmd.Connection = conexionADO;
            cmd.CommandText = myquerystring1;
            cmd.ExecuteNonQuery();

            //Registro la solicitud
            this.registrarSolicitudNuevoHorario();
        }

        /// <summary>
        /// Registra en la tabla Nuevo_horario la solicitud al admin
        /// para aceptar o rechazar el horario propuesto
        /// </summary>
        /// <param name="usuario"></param>
        /// <param name="horarioHabitual"></param>
        private void registrarSolicitudNuevoHorario()
        {
            //Abro conexión
            MySqlConnection conexionADO = new MySqlConnection();
            conexionADO.ConnectionString = conexionString;
            conexionADO.Open();

            //Necesito el ID del horario registrado como foranea
            MySqlDataReader data;
            MySqlCommand lectura = new MySqlCommand("SELECT max(idHorarioHabitual) as id FROM horario_asignado_habitual;"
                                        , conexionADO);
            data = lectura.ExecuteReader();
            data.Read();
            int idHorario = data.GetInt32("id");

            data.Close();

            // Ahora guardo la solicitud
            string myquerystring1 = "INSERT INTO nuevo_horario_habitual (horarioHabitual) " +
            "VALUES (" + idHorario.ToString() + ");" ;

            //Asigno y ejecuto
            MySqlCommand cmd = new MySqlCommand();
            cmd.Connection = conexionADO;
            cmd.CommandText = myquerystring1;
            cmd.ExecuteNonQuery();
            
        }

        /// <summary>
        /// Establece como inactivo el turno pasado como parámetro.
        /// </summary>
        /// <param name="usuario"></param>
        /// <param name="turno"></param>
        public void eliminarHorariosHabitual(string usuario, HorarioHabitualDTO turno)
        {
            //Abro conexión
            MySqlConnection conexionADO = new MySqlConnection();
            conexionADO.ConnectionString = conexionString;
            conexionADO.Open();

            //Necesito el ID de area para poder eliminar
            MySqlDataReader data;
            MySqlCommand lectura = new MySqlCommand("SELECT idArea FROM area WHERE nombreArea = '" + turno.Area + "';", conexionADO);
            data = lectura.ExecuteReader();
            int idArea = 0;

            if (data.Read())
                idArea = data.GetInt32("idArea");
            else
                throw new SQLErrorException("Área");

            data.Close();

            //Obtengo el perìodo actual para eliminar el horario que
            //corresponde a este periodo
            MySqlDataReader data2;
            MySqlCommand lectura2 = new MySqlCommand("SELECT idPeriodo, nombre, area, inicio, fin, observaciones " +
            "FROM periodo " +
            "WHERE inicio < curdate() AND curdate() < fin AND area = " + idArea, conexionADO);
            data2 = lectura2.ExecuteReader();
            int idPeriodo = 0;

            if (data2.Read())
                idPeriodo = data2.GetInt32("idPeriodo");
            else
                throw new SQLErrorException("Periodo");

            data2.Close();


            // Ahora pongo como no activo el horario
            string myquerystring3 = "UPDATE horario_asignado_habitual " +
                "SET activo = 0 WHERE " +
                "area = " + idArea + " AND " +
                "usuario = '" + usuario + "' AND " +
                "dia = " + Fecha.getNumeroDia(turno.Dia) + " AND " +
                "periodo = " + idPeriodo + " AND " +
                "ingreso = " + turno.Ingreso.getSQLFormat() + " AND " +
                "egreso = " + turno.Egreso.getSQLFormat() + ";";


            //Asigno y ejecuto 3
            MySqlCommand cmd = new MySqlCommand();
            cmd.Connection = conexionADO;
            cmd.CommandText = myquerystring3;
            cmd.ExecuteNonQuery();

            //Obtengo el id del horario que di de baja.
            MySqlDataReader data4;
            MySqlCommand lectura4 = new MySqlCommand("SELECT * " +
            "FROM horario_asignado_habitual " +
            "WHERE " +
                "area = " + idArea + " AND " +
                "usuario = '" + usuario + "' AND " +
                "dia = " + Fecha.getNumeroDia(turno.Dia) + " AND " +
                "periodo = " + idPeriodo + " AND " +
                "ingreso = " + turno.Ingreso.getSQLFormat() + " AND " +
                "egreso = " + turno.Egreso.getSQLFormat() + ";"
            , conexionADO);
            data4 = lectura4.ExecuteReader();
            int idHorario = 0;

            if (data4.Read())
                idHorario = data4.GetInt32("idHorarioHabitual");
            else
                throw new SQLErrorException("ID");

            data4.Close();
            

            //Elimino la solicitud de asignaciòn para dicho horario.
            string myquerystring4 = "DELETE FROM nuevo_horario_habitual " +
                "WHERE " +
                "horarioHabitual = " + idHorario + ";";

            //Asigno y ejecuto 4
            MySqlCommand cmd1 = new MySqlCommand();
            cmd1.Connection = conexionADO;
            cmd1.CommandText = myquerystring4;
            cmd1.ExecuteNonQuery();
        }

        /// <summary>
        /// Crea una solicitud para los administradores para el cambio de horario
        /// </summary>
        /// <param name="usuario"></param>
        /// <param name="turno"></param>
        public void registrarSolicitudCambioHorario(string usuario, HorarioHabitualDTO turno)
        {
            /* Primero debo obtener el id del horario que se desea cambiar.
             *Para saber cual es el horario, ademas de el usuario y los datos 
             *contenidos en el DTO, debo obtener el IDarea y el periodo actual
             */

            //Abro conexión
            MySqlConnection conexionADO = new MySqlConnection();
            conexionADO.ConnectionString = conexionString;
            conexionADO.Open();

            //Necesito el ID de area
            MySqlDataReader data;
            MySqlCommand lectura = new MySqlCommand("SELECT idArea FROM area WHERE nombreArea = '" + turno.Area + "';", conexionADO);
            data = lectura.ExecuteReader();
            int idArea = 0;

            if (data.Read())
                idArea = data.GetInt32("idArea");
            else
                throw new SQLErrorException("Área");

            data.Close();

            //Obtengo el perìodo actual 
            MySqlDataReader data2;
            MySqlCommand lectura2 = new MySqlCommand("SELECT idPeriodo, nombre, area, inicio, fin, observaciones " +
            "FROM periodo " +
            "WHERE inicio < curdate() AND curdate() < fin AND area = " + idArea, conexionADO);
            data2 = lectura2.ExecuteReader();
            int idPeriodo = 0;

            if (data2.Read())
                idPeriodo = data2.GetInt32("idPeriodo");
            else
                throw new SQLErrorException("Periodo");

            data2.Close();

            //Ahora puedo obtener el id del horario con estos datos
            MySqlDataReader data3;
            string comando3 = "SELECT * " +
                "FROM horario_asignado_habitual WHERE " +
                "area = " + idArea + " AND " +
                "usuario = '" + usuario + "' AND " +
                "dia = " + Fecha.getNumeroDia(turno.Dia) + " AND " +
                "periodo = " + idPeriodo + " AND " +
                "ingreso = " + turno.Ingreso.getSQLFormat() + " AND " +
                "egreso = " + turno.Egreso.getSQLFormat() + ";";
            MySqlCommand lectura3 = new MySqlCommand(comando3, conexionADO);
            data3 = lectura3.ExecuteReader();
            int idHorario = 0;

            if (data3.Read())
                idHorario = data3.GetInt32("idHorarioHabitual");
            else
                throw new SQLErrorException("Horario Habitual");

            data3.Close();

            //Compruebo que no se haya solicitado con anterioridad dicho cambio
            //Obtengo el perìodo actual 
            MySqlDataReader data4;
            MySqlCommand lectura4 = new MySqlCommand("SELECT * " +
            "FROM cambio_horario_habitual " +
            "WHERE horarioHabitual = " + idHorario + " AND activo = 1;", conexionADO);
            data4 = lectura4.ExecuteReader();

            if (data4.Read())
                throw new CambioHorarioInvalidoException();
            data4.Close();

            // Ahora guardo la solicitud
            string myquerystring1 = "INSERT INTO cambio_horario_habitual (horarioHabitual) " +
            "VALUES (" + idHorario.ToString() + ");";

            //Asigno y ejecuto
            MySqlCommand cmd = new MySqlCommand();
            cmd.Connection = conexionADO;
            cmd.CommandText = myquerystring1;
            cmd.ExecuteNonQuery();
        }
    }
}
