<?php

class ShelfDBTools {
    const DBTABLE = 'shelves';

    private $mysqli;

    function __construct($host = 'localhost', $user = 'root', $password = null, $db = 'electronics_db') {
        $this->mysqli = new mysqli($host, $user, $password, $db);
        if ($this->mysqli->connect_errno){
            throw new Exception($this->mysqli->connect_errno);  
        }
    }
    function __destruct()
    {
        $this->mysqli->close();
    }
    function createShelf($shelf)
    {
        $result = $this->mysqli->query("INSERT INTO " . self::DBTABLE . " (name) VALUES ('$shelf')");
        if (!$result) {
            echo "Hiba történt a $shelf beszúrása közben";

        }
        return $result;
    }
    function truncateShelf()
    {
        $result = $this->mysqli->query("TRUNCATE TABLE " . self::DBTABLE);
        return $result;
    }
}

?>