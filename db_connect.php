<?php
class DB_CONNECT
{
    function __construct()
    {
        $this->connect();
    }

    //  destructor
    function __destruct()
    {
        $this->close();
    }
    /**
     * function to connect width db 
     */
    function connect()
    {
        require_once 'db_config.php';

        $con = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die(mysql_error());
        $db = mysql_select_db(DB_DATABASE) or die(mysql_error());
        mysql_query("SET NAMES utf8");
        // return connection cursor
        return $con;
    }

    function close()
    {
        mysql_close();
    }
}

?>