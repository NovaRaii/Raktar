<?php
class DB
{
    protected $mysqli;

    function __construct($host = 'localhost', $user = 'root', $password = null)
    {
        $this->mysqli = mysqli_connect($host, $user, $password);
        if (!$this->mysqli) {
            die("Connection failed: " . mysqli_connect_error());
        }
         
    }

    function __destruct()
    {
        $this->mysqli->close();
    }
}
?>