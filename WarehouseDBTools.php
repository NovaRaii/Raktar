<?php

class WarehouseDBTools {
    const DBTABLE = 'warehouses';

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
    function createWarehouse($warehouse)
    {
        $result = $this->mysqli->query("INSERT INTO " . self::DBTABLE . " (name) VALUES ('$warehouse')");
        if (!$result) {
            echo "Hiba történt a $warehouse beszúrása közben";

        }
        return $result;
    }
    function truncateWarehouse()
    {
        $result = $this->mysqli->query("TRUNCATE TABLE " . self::DBTABLE);
        return $result;
    }
}

?>