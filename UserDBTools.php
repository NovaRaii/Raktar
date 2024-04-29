<?php


class UserDBTools {
    const DBTABLE = 'Users';
    private $mysqli;

    function __construct($host = 'localhost', $user = 'root', $password = null, $db = 'electronics_db') {
        $this->mysqli = new mysqli($host, $user, $password, $db);
        if ($this->mysqli->connect_errno) {
            throw new Exception($this->mysqli->connect_errno);
        }
    }

    function __destruct() {
        $this->mysqli->close();
    }

    function createUsers($username,$email,$password)
    {
        $token = $this->getNewToken();
        $valid = $this->getValidUntil();
        $sql = "INSERT INTO " . self::DBTABLE . " (name,email,password, token, token_valid_until) VALUES (?, ?, ?, '$token', '$valid')";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $password);
        $result = $stmt->execute();
        if (!$result) {
            echo "Hiba történt.";
            return false;
        }
        return true;
    }

    function truncateUsers()
    {
        $result = $this->mysqli->query("TRUNCATE TABLE " . self::DBTABLE);
        return $result;
    }

    function deleteUsers()
    {
        $result = $this->mysqli->query("DROP TABLE " . self::DBTABLE);
        return $result;
    }

    private function getNewToken(){
        return str_replace(["-","+"], ["",""], base64_encode(random_bytes(160/8)));
    }
    function getValidUntil(){
        $validUntil = new DateTime();
        $validUntil->add(new DateInterval('PT1H'));
        return $validUntil->format("Y-m-d H:i:s");
    }
}


?>