<?php

class ShelvesDbTools {
    const DBTABLE = 'shelves';

    private $mysqli;

    function __construct($host = 'localhost', $user = 'root', $password = null, $db = 'electronics_db')
    {
        $this->mysqli = new mysqli($host, $user, $password, $db);
        if ($this->mysqli->connect_errno){
            throw new Exception($this->mysqli->connect_errno);
        }
    
    }

    function __destruct()
    {
        $this->mysqli->close();
    }

    function createShelves($shelves,$itemName)
    {
        $sql = "INSERT INTO " . self::DBTABLE . " (shelf_line,item_name) VALUES (?, ?)";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ss", $shelves, $itemName);
        $result = $stmt->execute();
        if (!$result) {
            echo "Hiba történt a leltár beszúrása közben";
            return false;
        }
        return true;
    }

    function truncateShelves()
    {
        $result = $this->mysqli->query("TRUNCATE TABLE " . self::DBTABLE);
        return $result;
    }

    function deleteShelves()
    {
        $result = $this->mysqli->query("DROP TABLE " . self::DBTABLE);
        return $result;
    }

    function updateShelves($warehouseIds, $shelves)
    {
        $sql = "UPDATE " . self::DBTABLE . " SET warehouse_id = ? WHERE shelf_line = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("is", $warehouseId, $shelfLine);

        foreach ($shelves as $shelf) {
            
            $warehouseId = $this->findWarehouseId($shelf, $warehouseIds);
            if ($warehouseId === false) {
                continue;
            }

            $shelfLine = $shelf[0];
            $stmt->execute();
        }

        return true;
    } 

    function deleteShelfById($shelfId)
    {
        $sql = "DELETE FROM " . self::DBTABLE . " WHERE id = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $shelfId);
        $result = $stmt->execute();
        if (!$result) {
            echo "Hiba történt a polc törlése közben";
            return false;
        }
        return true;
    }

    private function findWarehouseId($shelf, $warehouseIds)
    {
        $shelfPrefix = substr($shelf[0], 0, 1);

        $warehouseMapping = [
            'M' => 1,
            'E' => 2,
            'G' => 3,
            'T' => 4
        ];

        if (array_key_exists($shelfPrefix, $warehouseMapping)) {
            $warehouseId = $warehouseMapping[$shelfPrefix];
            if (in_array($warehouseId, $warehouseIds)) {
                return $warehouseId;
            }
        }

        return false;
    }

    public function searchShelves($needle){
        $sql = "SELECT * FROM  shelves WHERE name LIKE '%$needle%'";
        $stmt = $this->mysqli->prepare($sql);
        //$stmt->bind_param('s',$needle);
 
        $result = $this->mysqli->query($sql);
 
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $shelves[] = $row;
            }
        }
 
        return $shelves;
    }
 
    public function getShelvesByWarehouseId($warehouseId) {
        $query = "SELECT shelves.*, warehouses.name AS warehouse_name FROM shelves INNER JOIN warehouses ON shelves.warehouse_id = warehouses.id WHERE shelves.warehouse_id = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $warehouseId);
        $stmt->execute();
        $result = $stmt->get_result();
        $shelves = [];
        while ($row = $result->fetch_assoc()) {
            $shelves[] = $row;
        }
        $stmt->close();
        return $shelves;
    }

    public function addItem($shelfLine, $warehouseId, $itemName) {
        $sql = "INSERT INTO " . self::DBTABLE . " (shelf_line, warehouse_id, item_name) VALUES (?, ?, ?)";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ssi", $shelfLine, $warehouseId, $itemName);
        $result = $stmt->execute();
 
        if (!$result) {
            echo "Error adding city: " . $this->mysqli->error;
            return false;
        }
 
        return true;
    }

    public function getShelfById($shelfId) {
        $query = "SELECT * FROM " . self::DBTABLE . " WHERE id = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $shelfId);
        $stmt->execute();
        $result = $stmt->get_result();
        $shelves = $result->fetch_assoc();
        $stmt->close();
        return $shelves;
    }

}
