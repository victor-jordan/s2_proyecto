<?php
/**
 * Clase para conexion a base de datos
 */
class ctrlBaseDatos
{
    private $_connection;
    private $_host;
    private $_username;
    private $_password;
    private $_database;

    function __construct()
    {
        $this->_host = "127.0.0.1";
        $this->_username = "userdb";
        $this->_password = "123456";
        $this->_database = "video_club";
        try{
            // creamos la conexión, pasando una cadena indicando del driver
            $this->_connection = new PDO("mysql:host=" . $this->_host . ";" . "dbname=" . $this->_database, $this->_username, $this->_password);
            // indicamos a PDO que deberá capturar la excepción si ocurre
            $this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            // Si algo falla mostramos el error
            echo "Falla:" . $e->getMessage();
        }
    }

    public function getConexion() {
        return $this->_connection;
    }

    public function __destruct() {
        if ($this->_connection) {
            $this->_connection = null;
        }
    }
}

?>