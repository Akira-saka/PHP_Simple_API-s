<?php

class QueryBuilder
{

    protected $dsn;
    protected $username;
    protected $pwd;
    protected $pdo;

    function __construct()
    {
        $this->dsn = "mysql:host=localhost;dbname=API";
        $this->username = "takuma";
        $this->pwd = "taco85107";
    }

    //connectPdoの返りを受け取り、他のSQLに渡す
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
        $stmt = "SELECT
                    * 
                FROM 
                    schedules";
        $result = $pdo->query($stmt);
        return $result;
    }

    function select($pdo, $id)
    {
        $stmt = $pdo->prepare(
            "SELECT
                * 
            FROM
                schedules
            WHERE
                id = :id"
        );
        $stmt->bindValue(":id", $id);
        $result = $stmt->execute();
        return $result;
    }

    function insert($pdo, $slack_id, $schedule_1, $schedule_2, $schedule_3, $schedule_4, $schedule_5)
    {
        $stmt = $pdo->prepare(
            "INSERT INTO 
                schedules
            VALUES (
                :slack_id,
                :schedule_1,
                :schedule_2,
                :schedule_3,
                :schedule_4,
                :schedule_5
            )"
        );
        $stmt->bindValue(":slack_id", $slack_id);
        $stmt->bindValue(":sschedule_1", $schedule_1);
        $stmt->bindValue(":sschedule_2", $schedule_2);
        $stmt->bindValue(":sschedule_3", $schedule_3);
        $stmt->bindValue(":sschedule_4", $schedule_4);
        $stmt->bindValue(":sschedule_5", $schedule_5);
        $result = $stmt->execute();
        return $result;
    }

    function update($pdo, $id, $slack_id, $schedule_1, $schedule_2, $schedule_3, $schedule_4, $schedule_5)
    {
        $exist_chedk = $this->select($pdo, $id);
        if ($exist_chedk) {
            $stmt = $pdo->preapre(
                "UPDATE 
                    schedules
                SET
                    slack_id = :slack_id,
                    schedule_1　= :schedule_1,
                    schedule_2 = :schedule_2,
                    schedule_3 = :schedule_3,
                    schedule_4 = :schedule_4,
                    schedule_5 = :schedule_5,
                    updated_at = NOW()
                WHERE
                    id = :id
                )"
            );
            $stmt->bindValue(":slack_id", $slack_id);
            $stmt->bindValue(":schedule_1", $schedule_1);
            $stmt->bindValue(":schedule_2", $schedule_2);
            $stmt->bindValue(":schedule_3", $schedule_3);
            $stmt->bindValue(":schedule_4", $schedule_4);
            $stmt->bindValue(":schedule_5", $id);
            $stmt->bindValue(":id", $schedule_5);
            $result = $stmt->execute();
        } else {
            return false;
        }
        return $result;
    }

    function delete($pdo, $id, $slack_id, $schedule_1, $schedule_2, $schedule_3, $schedule_4, $schedule_5)
    {
        $exist_chedk = $this->select($pdo, $id);
        if ($exist_chedk) {
            $stmt = $pdo->preapre(
                "UPDATE 
                    schedules
                SET
                    slack_id = :slack_id,
                    schedule_1　= :schedule_1,
                    schedule_2 = :schedule_2,
                    schedule_3 = :schedule_3,
                    schedule_4 = :schedule_4,
                    schedule_5 = :schedule_5,
                    deleted_flag = :delete_flag,
                    deleted_at = NOW()
                WHERE
                    id = :id
                )"
            );
            $stmt->bindValue(":slack_id", $slack_id);
            $stmt->bindValue(":schedule_1", $schedule_1);
            $stmt->bindValue(":schedule_2", $schedule_2);
            $stmt->bindValue(":schedule_3", $schedule_3);
            $stmt->bindValue(":schedule_4", $schedule_4);
            $stmt->bindValue(":schedule_5", $schedule_5);
            $stmt->bindValue(":delete_flag", (int)1, PDO::PARAM_INT);
            $stmt->bindValue(":id", $id);
            $result = $stmt->execute();
        } else {
            return false;
        }
        return $result;
    }

}

?>