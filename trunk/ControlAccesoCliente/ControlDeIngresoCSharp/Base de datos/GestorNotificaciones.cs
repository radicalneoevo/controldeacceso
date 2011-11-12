using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using MySql.Data.MySqlClient;
using System.Configuration;

namespace ControlDeIngresoCSharp.Base_de_datos
{
    class GestorNotificaciones
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
        /// Retorna una lista de string con las notificaciones para el usuario
        /// que se pasa como parámetro
        /// </summary>
        /// <param name="usuario">DNI del usuario</param>
        /// <returns>Lista de notificaciones a mostrar</returns>
        public List<string> getListaNotificaciones(string usuario)
        {
            List<string> resultado = new List<string>();
            List<int> idsNuevos = new List<int>();
            List<int> idsCambios = new List<int>();

            //Abro conexión
            MySqlConnection conexionADO = new MySqlConnection();
            conexionADO.ConnectionString = conexionString;
            conexionADO.Open();

            //Consulto para obtener si hay notificaciones de nuevos horarios
            //habituales no leidos.
            MySqlDataReader nuevosHorariosReader;
            MySqlCommand nuevosHorariosConsulta = new MySqlCommand(
                "SELECT * " +
                "FROM nuevo_horario_habitual n, horario_asignado_habitual h " + 
                "WHERE h.usuario = '" + usuario + "' AND " +
                "h.idHorarioHabitual = n.horarioHabitual AND " +
                "n.aceptado IS NOT NULL AND " +
                "n.activo = 1;"
                , conexionADO);
            nuevosHorariosReader = nuevosHorariosConsulta.ExecuteReader();

            //Incluyo los resultados en el vector.
            while(nuevosHorariosReader.Read())
            {
                int aceptado = nuevosHorariosReader.GetInt32("aceptado");
                string observacionAdmin = nuevosHorariosReader.GetString("observacionesAdministrador");
                int id = nuevosHorariosReader.GetInt32("idNuevoHorario");

                StringBuilder mensaje = new StringBuilder();
                mensaje.Append("Su solicitud de nuevo horario fue ");

                if (aceptado == 1)
                    mensaje.AppendLine("aceptada. ");
                else
                    mensaje.AppendLine("rechazada. ");

                if (observacionAdmin.Length > 1)
                    mensaje.AppendLine("Se incluyò el siguiente mensaje: " + observacionAdmin);

                resultado.Add(mensaje.ToString());
                idsNuevos.Add(id);
            }

            //Lo que SIEMPRE me olvido... cerrar de data reader
            nuevosHorariosReader.Close();

            //Consulto si hay notificaciones de cambios de horario.
            MySqlDataReader cambioHorarioReader;
            MySqlCommand cambioHorarioConsulta = new MySqlCommand(
                "SELECT * " +
                "FROM cambio_horario_habitual n, horario_asignado_habitual h " +
                "WHERE h.usuario = '" + usuario + "' AND " +
                "h.idHorarioHabitual = n.horarioHabitual AND " +
                "n.aceptado IS NOT NULL AND " +
                "n.activo = 1;"
                , conexionADO);
            cambioHorarioReader = cambioHorarioConsulta.ExecuteReader();

            //Incluyo los resultados en el vector.
            while (cambioHorarioReader.Read())
            {
                int aceptado = cambioHorarioReader.GetInt32("aceptado");
                string observacionAdmin = cambioHorarioReader.GetString("observacionesAdministrador");
                int id = cambioHorarioReader.GetInt32("idCambioHorario");

                StringBuilder mensaje = new StringBuilder();
                mensaje.Append("Su solicitud de cambio horario fue ");

                if (aceptado == 1)
                    mensaje.AppendLine("aceptada. ");
                else
                    mensaje.AppendLine("rechazada. ");

                if (observacionAdmin.Length > 1)
                    mensaje.AppendLine("Se incluyò el siguiente mensaje: " + observacionAdmin);

                resultado.Add(mensaje.ToString());
                idsCambios.Add(id);
            }

            //Cierro el reader
            cambioHorarioReader.Close();

            //Borro los mensajes leidos
            this.marcarComoLeidos(idsNuevos, idsCambios);

            return resultado;
        }

        //**********************************
        //***** Métodos de escritura *********
        //**********************************
        /// <summary>
        /// Marca las notificaciones como NO activas de modo que no se puedan leer
        /// más.
        /// </summary>
        /// <param name="nuevos">ids de mensajes en tabla nuevos horarios</param>
        /// <param name="cambios">ids de mensajes en tabla cambios horarios</param>
        public void marcarComoLeidos(List<int> nuevos, List<int> cambios)
        {
            //Abro conexión
            MySqlConnection conexionADO = new MySqlConnection();
            conexionADO.ConnectionString = conexionString;
            conexionADO.Open();

            //Marco como no activo a los mensajes de nuevos horarios
            foreach (int id in nuevos)
            {
                //Marco como no activo a los mensajes leidos
                string myquerystring = "UPDATE nuevo_horario_habitual SET activo = 0 WHERE idNuevoHorario = " + id + ";";
                //Asigno y ejecuto
                MySqlCommand cmd = new MySqlCommand();
                cmd.Connection = conexionADO;
                cmd.CommandText = myquerystring;
                cmd.ExecuteNonQuery();
                
            }
            
            //Marco como no activo a los mesajes de cambio de horario
            foreach (int id in cambios)
            {
                //Marco como no activo a los mensajes leidos
                string myquerystring = "UPDATE cambio_horario_habitual SET activo = 0 WHERE idCambioHorario = " + id + ";";
                //Asigno y ejecuto
                MySqlCommand cmd = new MySqlCommand();
                cmd.Connection = conexionADO;
                cmd.CommandText = myquerystring;
                cmd.ExecuteNonQuery();
            }
        }
    }
}
