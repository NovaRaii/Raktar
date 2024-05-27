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

    function createUsers($username, $email, $password, $privilege)
{

    $token = $this->getNewToken();
    $validUntil = $this->getValidUntil();
    $sql = "INSERT INTO " . self::DBTABLE . " (name, email, password, token, token_valid_until, privilege) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $this->mysqli->prepare($sql);
    $stmt->bind_param("ssssss", $username, $email, $password, $token, $validUntil, $privilege);
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

    function getcreatedDate(){
        $createdDate = new DateTime();
        $createdDate->add(new DateInterval('PT0H'));
        return $createdDate->format("Y-m-d H:i:s");
    }

    function getUserByEmail($email)
{
    $query = "SELECT token FROM " . self::DBTABLE . " WHERE email = ?";
    $stmt = $this->mysqli->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($token); 
    $stmt->fetch(); 
    $stmt->close();
    return $token; 
}

function getUserByToken($token){

    $datetime = new DateTime();
        $strDatetime = $datetime->format('Y-m-d H:i:s');
        $query = "SELECT * FROM users WHERE token = '$token' and token_valid_until > '$strDatetime';";
        $stmt = $this->mysqli->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
}

function updateUserByToken($token, $createdDate){

    $sql = "UPDATE " . self::DBTABLE . " SET created_at = ?, is_active = TRUE WHERE token = ?";
    $stmt = $this->mysqli->prepare($sql);
    $stmt->bind_param("ss", $token, $createdDate);
    $result = $stmt->execute();
    if (!$result) {
        echo "Error updating user: " . $this->mysqli->error;
        return false;
    }
    return true;
}

/*function updateToken($token){
    $query = "UPDATE " . self::DBTABLE . " SET token = NULL WHERE is_active = TRUE";
    $stmt = $this->mysqli->prepare($query);
    $stmt->bind_param("s", $token);
    $result = $stmt->execute();
    if (!$result) {
        echo "Error updating user: " . $this->mysqli->error;
        return false;
    }
    return true;
}*/

function getUser($loginEmail){
    $query = "SELECT users.password FROM users WHERE email = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("s", $loginEmail);
        $stmt->execute();
        $result = $stmt->get_result();
        $login = $result->fetch_assoc();
        $stmt->close();
        $password = '';
        if(!empty($login['password']))
        {
            $password = $login['password'];
        }
        return $password;
}

function getUserPrivilegeByEmail($email){
    $query = "SELECT privilege FROM " . self::DBTABLE . " WHERE email = ?";
    $stmt = $this->mysqli->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($privilege);
    $stmt->fetch();
    $stmt->close();
    return $privilege;
}
}


?>