<?php


class Database  {
    private $mysqli;

    public function __construct()   {
        $config = include_once('config.php');

        $this->mysqli = new mysqli($config['db_host'], $config['db_user'], $config['db_password'],
            $config['db_name'], $config['db_port']);

        if ($this->mysqli->connect_errno) {
            printf("Не удалось подключиться: %s\n", $this->mysqli->connect_error);
            exit();
        }
    }

    public function __destruct()
    {
        $this->mysqli->close();
    }

    /**
     * @param $query
     * @return bool|mysqli_result
     */
    public function query($query) {
        return $this->mysqli->query($query);
    }

    public function getLastInsertId() {
        echo $this->mysqli->error;
        return $this->mysqli->insert_id;
    }

    /**
     * @param $string
     * @return string
     */
    public function getEscapedString($string) {
        return $this->mysqli->real_escape_string($string);
    }
}