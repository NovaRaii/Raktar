<?php
require_once 'WarehouseInterface.php';
require_once 'DB.php';

class DBWarehouse    extends DB implements WarehouseInterface{
    public function createTable(){
        $query = 'USE electronics_db';
        $this->mysqli->query($query);
        $query = 'CREATE TABLE IF NOT EXISTS warehouses (id int AUTO_INCREMENT PRIMARY KEY, zip_code varchar(4), city varchar(50) NOT NULL, id_county int NOT NULL)';
        return $this->mysqli->query($query);
    }

    public function create(array $data): ?int
    {
        $sql = 'INSERT INTO warehouses (%s) VALUES (%s)';
        $fields = '';
        $values = '';
        foreach ($data as $field => $value) {
            if ($fields > '') {
                $fields .= ',' . $field;
            } else
                $fields .= $field;

            if ($values > '') {
                $values .= ',' . "'$value'";
            } else
                $values .= "'$value'";
        }
        $sql = sprintf($sql, $fields, $values);
        $this->mysqli->query($sql);

        $lastInserted = $this->mysqli->query("SELECT LAST_INSERT_ID() id;")->fetch_assoc();

        return $lastInserted['id'];
    }
}
?>