<?php

require_once 'UserInterface.php';
require_once 'DB.php';


class DBUser extends DB implements UserInterface
{

    public function createTable(){
        $query = 'CREATE TABLE IF NOT EXISTS users (id int AUTO_INCREMENT PRIMARY KEY, name varchar(50) NOT NULL, email varchar(25) not null unique, password varchar(200) not null, token varchar(100), token_valid_until datetime, created_at datetime, is_active tinyint default false, privilege varchar(10))';
        return $this->mysqli->query($query);
    }

    public function create(array $data): ?int
    {
        $sql = 'INSERT INTO users (%s) VALUES (%s)';
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

