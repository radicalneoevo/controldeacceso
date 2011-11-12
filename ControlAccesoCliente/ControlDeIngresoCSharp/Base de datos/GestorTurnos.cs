using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using MySql.Data.MySqlClient;
using ControlDeIngresoCSharp.Logica;
using ControlDeIngresoCSharp.Excepciones;
using System.Configuration;

namespace ControlDeIngresoCSharp
{
    class GestorTurnos
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
        /// Obtiene de la base de datos aquellas personas presentes a la hora
        /// de invocar el método
        /// </summary>
        /// <returns>Lista que contiene el nombre y apellido de los presentes</returns>
        public List<string> personalPresente()
        {
            //Abro conexión
            MySqlConnection conexionADO = new MySqlConnection();
            conexionADO.ConnectionString = conexionString;
            conexionADO.Open();

            //Creo lector =) y efectuo la consulta
            MySqlDataReader data;
            MySqlCommand lectura = new MySqlCommand("SELECT * FROM turno_usuario_area, usuario WHERE " +
                "turno_usuario_area.usuario = usuario.numeroDocumento AND " +
                "turno_usuario_area.egreso IS NULL", conexionADO);
            data = lectura.ExecuteReader();

            //armo la lista 
            List<string> presentes = new List<string>();
            while (data.Read())
            {
                presentes.Add(data.GetString("nombre") +" "+data.GetString("Apellido"));
            }
            data.Close();
            return presentes;
        }

        

        //************************************
        //***** Métodos de escritura *********
        //************************************
        /// <summary>
        /// Detecta si la accion a registrarse es un ingreso o egreso.
        /// </summary>
        /// <param name="usuario"></param>
        /// <param name="observacion"></param>
        /// <returns></returns>
        public int registrarAccion(string usuario, string observacion, string area)
        {
            //Abro conexión
            MySqlConnection conexionADO = new MySqlConnection();
            conexionADO.ConnectionString = conexionString;
            conexionADO.Open();
            Fecha fecha;
            Horario hora;
            //Conecto mediante NTP para obtener fecha/hora
            try
            {
                // Fuerzo a no utilizar el ntp porque anda mas o menos
                throw new Exception();
                //Servidor NTP externo
                SNTPClient ntp = new SNTPClient("ar.pool.ntp.org");
                
                //SNTPClient ntp = new SNTPClient("ntp.frsf.utn.edu.ar");
                ntp.Connect(false);
                fecha = new Fecha(ntp.ReceiveTimestamp.Day, ntp.ReceiveTimestamp.Month,
                    ntp.ReceiveTimestamp.Year, ntp.ReceiveTimestamp.DayOfWeek.ToString());
                hora = new Horario(ntp.ReceiveTimestamp.Hour, ntp.ReceiveTimestamp.Minute, ntp.ReceiveTimestamp.Second);
            }
            catch (Exception ex)
            {
                
                //Si no funciona el ntp obtengo la hora de la base de datos
                MySqlDataReader dataread;
                MySqlCommand lecturaF = new MySqlCommand("select NOW() as ahora;" , conexionADO);
                dataread = lecturaF.ExecuteReader();
                dataread.Read();

                fecha = new Fecha(dataread.GetDateTime("ahora").Date);
                hora = new Horario();
                hora.setTimeSpan(dataread.GetDateTime("ahora").TimeOfDay);

                dataread.Close();
            }

            //Veo si es un ingeso o egreso
            //Creo lector =) y efectuo la consulta
            MySqlDataReader data;
            MySqlCommand lectura = new MySqlCommand("SELECT * FROM turno_usuario_area t WHERE usuario=" + usuario + 
                " AND fecha = " + fecha.getSQLFormat() + " AND t.egreso IS NULL;", conexionADO);
            data = lectura.ExecuteReader();
            //tipo 0: egreso .. tipo 1: ingreso
            int tipoAccion = 1;
            int idTurno = 0;

            //si existe dato entonces es un egreso
            if (data.Read())
            {
                //registro el egreso
                idTurno = data.GetInt32("idTurno");
                tipoAccion = 0;
            }

            //Cierro el data reader (esa no la sabia) :o
            data.Close();

            //Creo consulta
            string myquerystring;

            //Cambio la consulta dependiendo si es ingreso o egreso
            if (tipoAccion == 1)
            {
                //Primero obtengo si hay algun horario asignado para este dia de esa persona
                int dia = fecha.getDiaDeSemana();
                MySqlDataReader data2;
                string consulta = "SELECT idHorario as id " +
                    "FROM `horario_asignado` as h " +
                    "WHERE " +
                    "h.`usuario` = '" + usuario + "' AND " +
                    "h.`fecha` = " + fecha.getSQLFormat() + " AND " +
                    "h.`activo` = 1 AND " +
                    "h.`confirmado` = 1 AND " +
                    "TIME_TO_SEC(" + hora.getSQLFormat() + ") >= (TIME_TO_SEC(h.`ingreso`) - 1800) AND " +
                    "TIME_TO_SEC(" + hora.getSQLFormat() + ") < TIME_TO_SEC(h.`egreso`);";

                MySqlCommand lectura2 = new MySqlCommand(consulta, conexionADO);
                data2 = lectura2.ExecuteReader();
                int id = 0;

                //Veo si hay horario asignado
                if (data2.Read())
                {
                    id = data2.GetInt32("id");
                    this.registroIngreso(usuario, id, fecha, hora, observacion);
                }
                else
                {
                    id = this.crearHorarioExtra(usuario, area);
                    this.registroIngresoHoraExtra(usuario, id, fecha, hora, observacion);
                }
                
                data2.Close();

            }
            else
            {
                //Para el egreso
                myquerystring = "UPDATE turno SET egreso = " + hora.getSQLFormat() + ", observacionSalida = '" + observacion + "' WHERE idTurno =" + idTurno + ";";
                //Asigno y ejecuto
                MySqlCommand cmd = new MySqlCommand();
                cmd.Connection = conexionADO;
                cmd.CommandText = myquerystring;
                cmd.ExecuteNonQuery();
            }
           
            conexionADO.Close();
            return tipoAccion;
        }

        /// <summary>
        /// Crea un horario extra en la DB
        /// </summary>
        /// <param name="usuario"></param>
        /// <param name="id"></param>
        /// <param name="fecha"></param>
        /// <param name="hora"></param>
        /// <param name="observacion"></param>
        private void registroIngresoHoraExtra(string usuario,int id,Fecha fecha,Horario hora,string observacion)
        {
            //Abro conexión
            MySqlConnection conexionADO2 = new MySqlConnection();
            conexionADO2.ConnectionString = conexionString;
            conexionADO2.Open();

            String myquerystring = "INSERT INTO turno(fecha,ingreso, extra, observacionEntrada) "
                + "VALUES ("
                + fecha.getSQLFormat() + ", "
                + hora.getSQLFormat() + ","
                + id.ToString() + ", '"
                + observacion + "');";

            //Asigno y ejecuto 3
            MySqlCommand cmd = new MySqlCommand();
            cmd.Connection = conexionADO2;
            cmd.CommandText = myquerystring;
            cmd.ExecuteNonQuery();
        }

        /// <summary>
        /// Registra acciones de ingreso para horarios.
        /// </summary>
        /// <param name="usuario"></param>
        /// <param name="fecha"></param>
        /// <param name="hora"></param>
        /// <param name="observacion"></param>
        public void registroIngreso(string usuario, int id , Fecha fecha, Horario hora, String observacion)
        {
            //Abro conexión
            MySqlConnection conexionADO2 = new MySqlConnection();
            conexionADO2.ConnectionString = conexionString;
            conexionADO2.Open();
            
            String myquerystring = "INSERT INTO turno(fecha,ingreso, horario, observacionEntrada) "
                + "VALUES ("
                + fecha.getSQLFormat() + ", "
                + hora.getSQLFormat() + "," 
                + id.ToString() + ", '"
                + observacion + "');";

            //Asigno y ejecuto 3
            MySqlCommand cmd = new MySqlCommand();
            cmd.Connection = conexionADO2;
            cmd.CommandText = myquerystring;
            cmd.ExecuteNonQuery();
        }

        /// <summary>
        /// Crea un horario extra para el area a la que pertenece el usuario.
        /// Si pertenece a mas de un area, se utiliza el parámetro nombreArea
        /// para conocer sobre que area se efectua el horario extra.
        /// </summary>
        /// <param name="usuario"></param>
        /// <returns></returns>
        public int crearHorarioExtra(string usuario, string nombreArea)
        {
            //Abro conexión
            MySqlConnection conexionADO2 = new MySqlConnection();
            conexionADO2.ConnectionString = conexionString;
            conexionADO2.Open();

            //Obtengo el nombre de las areas a las que pertenece
            GestorUsuarios usuarioDAO = new GestorUsuarios();
            List<String> areas = usuarioDAO.getAreasFromUsuario(usuario);
            int idArea = 0;

            //Si pertenece a una sola area, busco su ID
            if (areas.Count == 1)
            {
                //Creo lector =) y efectuo la consulta
                MySqlDataReader data;
                MySqlCommand consulta = new MySqlCommand("SELECT * FROM usuario_area WHERE usuario ='"
                              + usuario + "';", conexionADO2);
                data = consulta.ExecuteReader();
                data.Read();
                idArea = data.GetInt32("idArea");
                data.Close();
            }
            else
            {
                //Creo lector =) y efectuo la consulta
                MySqlDataReader data;
                MySqlCommand consulta = new MySqlCommand("SELECT * FROM area WHERE nombreArea ='"
                              + nombreArea + "';", conexionADO2);
                data = consulta.ExecuteReader();
                data.Read();
                idArea = data.GetInt32("idArea");
                data.Close();
            }

           

            String myquerystring = "INSERT INTO horario_extra(usuario, area) "
                + "VALUES ('"
                + usuario + "', '"
                + idArea + "');";

            //Asigno y ejecuto 3
            MySqlCommand cmd = new MySqlCommand();
            cmd.Connection = conexionADO2;
            cmd.CommandText = myquerystring;
            cmd.ExecuteNonQuery();

            MySqlDataReader data2;
            MySqlCommand consulta2= new MySqlCommand("SELECT MAX(idHorarioExtra) as id FROM horario_extra;"
                          , conexionADO2);
            data2 = consulta2.ExecuteReader();
            data2.Read();
            int id = data2.GetInt32("id");
            data2.Close();

            return id;
        }

    }

    
}
