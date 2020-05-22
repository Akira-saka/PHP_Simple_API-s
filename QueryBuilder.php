<?php

class QueryBuilder
{

    protected $dsn;
    protected $username;
    protected $pwd;
    protected $pdo;

    function __construct()
    {
        $this->dsn = "xxxxx";
        $this->username = "xxxxx";
        $this->pwd = "xxxxx";
    }

    function connectPdo()
    {
        try {
            $pdo = new PDO(
                $this->dsn,
                $this->username,
                $this->pwd,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
            echo "ok!";
        } catch(Exception $e) {
            echo "Failed" . $e->getMessage();
            exit();
        }
        return $pdo;
    }

    function selectAll($pdo)
    {
        $sql = "SELECT * FROM schedules";
        $result = $pdo->query($sql);
        return $result;
    }

    function select($pdo, $id)
    {
        $sql = "SELECT * FROM schedules WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $data = array(
            ":id" => $id
        );
        $stmt->execute($data);
        $result = $stmt->fetch();
        return $result;
    }

    function insert()
    {
        //$sql = "INSERT XXX "
    }

    function update()
    {
        //
    }

    function delete()
    {
        //
    }

}

?>