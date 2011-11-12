using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using ControlDeIngresoCSharp.Entidades;
using MySql.Data.MySqlClient;
using ControlDeIngresoCSharp.Excepciones;
using System.Configuration;


namespace ControlDeIngresoCSharp
{
    class GestorUsuarios
    {
        //********Variables**********

        string conexionString = "Server=" + ConfigurationSettings.AppSettings["dbLocation"] + ";" 
                + "Database=controlacceso;" 
                + "Port=3306;" 
                + "Uid=" + ConfigurationSettings.AppSettings["dbUser"] + ";"
                + "Pwd=AccessControl20100215;"
                + "Connect Timeout= 300;";

        
        //**********************************
        //***** Métodos de lectura *********
        //**********************************

        /// <summary>
        /// Dado un usuario y un password retorna si el mismo es válido. Caso contrario lanza
        /// una excepción.
        /// </summary>
        /// <param name="usuario"></param>
        /// <param name="password"></param>
        /// <returns></returns>
        public Boolean autenticar(string usuario, string password)
        {
            //Vacio no es válido
            if (usuario == "")
				throw new Exception("Complete los campos vacios");

            //Documento debe ser numérico
            int numeroDoc;

            if (int.TryParse(usuario, out numeroDoc))
                numeroDoc = int.Parse(usuario);
            else
                throw new Exception("El documento debe ser numerico");

            //Abro conexión
            MySqlConnection conexionADO = new MySqlConnection();
			conexionADO.ConnectionString = conexionString;
			conexionADO.Open();

            //Creo lector =) y efectuo la consulta
			MySqlDataReader data;
			MySqlCommand consulta = new MySqlCommand("SELECT * FROM usuario WHERE numeroDocumento=" + usuario + 
                                " AND password = sha1('" + password +"') AND activo = 1;", conexionADO);
			data = consulta.ExecuteReader();

            //Leo el dato si existe encontre el usuario
            if (data.Read())
            {
                return true;
            }
            else
                throw new Exception("Password y/o Usuario erroneo");
        }

        /// <summary>
        /// Retorna una entidad usuario de la base de datos que contenga el nro de documento dado
        /// </summary>
        /// <param name="dni">Numero de doc del usuario buscado</param>
        /// <returns>Entidad usuario con los datos completos</returns>
        public Usuario getUsuario(string dni)
        {
            //Entidad vacia para el retorno 
            Usuario usuario = new Usuario();

            //Vacio no es válido
            if (dni == "")
                throw new Exception("Complete los campos vacios");

            //Documento debe ser numérico
            int numeroDoc;

            if (int.TryParse(dni, out numeroDoc))
                numeroDoc = int.Parse(dni);
            else
                throw new Exception("El documento debe ser numerico");

            //Abro conexión
            MySqlConnection conexionADO = new MySqlConnection();
            conexionADO.ConnectionString = conexionString;
            conexionADO.Open();

            //Creo lector =) y efectuo la consulta
            MySqlDataReader data;
            MySqlCommand consulta = new MySqlCommand("SELECT * FROM usuario WHERE numeroDocumento=" + dni +";", conexionADO);
            data = consulta.ExecuteReader();

            //Completo la entidad usuario
            if(data.Read())
            {
                usuario.Apellido = data.GetString("apellido");
                usuario.Direccion = data.GetString("direccion");
                usuario.Email = data.GetString("email");
                usuario.FechaNacimiento = new Fecha(data.GetDateTime("fechaNacimiento"));
                usuario.Nombre = data.GetString("nombre");
                usuario.Notas = data.GetString("notas");
                usuario.NumeroDocumento = data.GetString("numeroDocumento");
                usuario.SegundoNombre = data.GetString("segundoNombre");
                usuario.TelefonoCelular = data.GetString("telefonoCelular");
                usuario.TelefonoFijo = data.GetString("telefonoFijo");
                usuario.TipoDni = data.GetString("tipoDocumento");
            }
            else
                throw new Exception("Usuario inexistente");
           
            return usuario;
        }

        /// <summary>
        /// Método utilizado para obtener una lista de las áreas a la que
        /// pertenece el usuario
        /// </summary>
        /// <param name="dniUsuario">nro de dni del usuario</param>
        /// <returns></returns>
        public List<string> getAreasFromUsuario(string dni)
        {
            List<string> resultado = new List<string>();

            //Abro conexión
            MySqlConnection conexionADO = new MySqlConnection();
            conexionADO.ConnectionString = conexionString;
            conexionADO.Open();

            //Creo lector =) y efectuo la consulta
            MySqlDataReader data;
            MySqlCommand consulta = new MySqlCommand("SELECT a.nombreArea FROM usuario_area u , area a" +
            " WHERE a.idArea = u.idArea AND u.usuario=" + dni + ";", conexionADO);
            data = consulta.ExecuteReader();

            while (data.Read())
            {
                resultado.Add(data.GetString("nombreArea"));
            }

            return resultado;
        }

        /// <summary>
        /// Retorna la cantidad de horas totales que necesita cumplir un usuario
        /// en un área determinada.
        /// </summary>
        /// <param name="dni">string con el dni del usuario</param>
        /// <param name="area">nombre del area a la que pertenece el usuario</param>
        /// <returns></returns>
        public Horario getHorasNecesarias(string dni, string area)
        {
            //Abro conexión
            MySqlConnection conexionADO = new MySqlConnection();
            conexionADO.ConnectionString = conexionString;
            conexionADO.Open();

            //Obtengo el id del area
            MySqlDataReader data;
            MySqlCommand lectura = new MySqlCommand("SELECT idArea FROM area WHERE nombreArea = '" + area + "';", conexionADO);
            data = lectura.ExecuteReader();
            int idArea = 0;

            if (data.Read())
                idArea = data.GetInt32("idArea");
            else
                throw new SQLErrorException("Área");

            data.Close();

            //Ahora busco la cantidad total
            MySqlDataReader data2;

            MySqlCommand lectura2 = new MySqlCommand("SELECT * FROM usuario_area " +
                                    "WHERE usuario = '" + dni + "' AND idArea = " + idArea + ";", conexionADO);
            data2 = lectura2.ExecuteReader();
            string hora;

            if (data2.Read())
                hora = data2.GetString("horasAsignadas");
            else
                throw new SQLErrorException("Total asignado");

            Horario resultado = new Horario(hora);

            return resultado;
        }

        /// <summary>
        /// Retorna la cantidad de horas que se asignó un usuario
        /// en un àrea determinada
        /// </summary>
        /// <param name="dni"></param>
        /// <returns></returns>
        public Horario getHorasAsignadasTotales(string dni, string area)
        {
            //Abro conexión
            MySqlConnection conexionADO = new MySqlConnection();
            conexionADO.ConnectionString = conexionString;
            conexionADO.Open();

            //Obtengo el id del area
            MySqlDataReader data;
            MySqlCommand lectura = new MySqlCommand("SELECT idArea FROM area WHERE nombreArea = '" + area + "';", conexionADO);
            data = lectura.ExecuteReader();
            int idArea = 0;

            if (data.Read())
                idArea = data.GetInt32("idArea");
            else
                throw new SQLErrorException("Área");

            data.Close();

            //Creo lector =) y efectuo la consulta
            MySqlDataReader data2;

            MySqlCommand lectura2 = new MySqlCommand("SELECT sec_to_time(sum(time_to_sec(duracion))) AS suma FROM horario_asignado_habitual_duracion as h " +
                                    "WHERE usuario = '" + dni +"' AND area = " + idArea + ";", conexionADO);
            data2 = lectura2.ExecuteReader();
            string hora;

            if (data2.Read())
                hora = data2.GetString("suma");
            else
                throw new SQLErrorException("Suma");

            Horario resultado = new Horario(hora);

            return resultado;
        }


        //************************************
        //***** Métodos de escritura *********
        //************************************
        /// <summary>
        /// Actualiza el email, direccion, telefono fijo y telefono celular 
        /// de el usuario pasado como parámetro
        /// </summary>
        /// <param name="u">usuario con los datos actualizados</param>
        public void actualizarDatos(Usuario u)
        {
            //Abro conexion
            MySqlConnection conexionADO = new MySqlConnection();
            conexionADO.ConnectionString = conexionString;
            conexionADO.Open();

            //Creo consulta 
            String myquerystring = "UPDATE usuario SET email = '" + u.Email + "', direccion = '" + u.Direccion +
                "', telefonoFijo = '"+ u.TelefonoFijo +"', telefonoCelular = '"+ u.TelefonoCelular +
                "' WHERE numeroDocumento = " + u.NumeroDocumento  + ";";
            //Asigno y ejecuto
            MySqlCommand cmd = new MySqlCommand();
            cmd.Connection = conexionADO;
            cmd.CommandText = myquerystring;
            cmd.ExecuteNonQuery();
            //Cierro
            conexionADO.Close();
        }

        /// <summary>
        /// Cambia el password de un usuario determinado
        /// </summary>
        /// <param name="usuario">dni del usuario al que se le quiere modificar el pass</param>
        /// <param name="nuevoPass">nuevo password</param>
        public void cambiarPassword(string usuario, string nuevoPass)
        {
            //Abro conexion
            MySqlConnection conexionADO = new MySqlConnection();
            conexionADO.ConnectionString = conexionString;
            conexionADO.Open();

            // Creo consulta de update
            string cambiaPasswordQuery = "UPDATE usuario SET password = sha1('" + nuevoPass 
                + "') WHERE numeroDocumento = '" + usuario +"';";

            //Asigno y ejecuto
            MySqlCommand cmd = new MySqlCommand();
            cmd.Connection = conexionADO;
            cmd.CommandText = cambiaPasswordQuery;
            cmd.ExecuteNonQuery();
            //Cierro
            conexionADO.Close();
        }
    }
}
