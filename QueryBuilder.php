<?php

declare(strict_types = 1);

require_once __DIR__ . "/config/common.php";

ini_set('date.timezone', 'Asia/Tokyo');

class QueryBuilder
{

    //connectPdoの返りを受け取り、他のSQLに渡す
    function connectPdo(): object
    {
        try {
            $pdo = new PDO(
                DSN,
                USER_NAME,
                PASS_WORD,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
            echo "Connect Success\n";
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

    function select(object $pdo)
    {
        $stmt = $pdo->prepare(
            "SELECT
                * 
            FROM
                schedules
            WHERE
                slack_id = :slack_id"
        );
        $stmt->bindValue(":slack_id", SLACK_ID);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result) {
            echo "Find Row\n";
            return $result;
	} else {
	    return false;
	}
    }

    function insert(object $pdo, array $obj): bool
    {
        echo "INSERT\n";
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO schedules (
                    slack_id,
                    schedule_1,
                    start_time_1,
                    schedule_2,
                    start_time_2,
                    schedule_3,
                    start_time_3,
                    schedule_4,
                    start_time_4,
                    schedule_5,
                    start_time_5
                )
                VALUES (
                    :slack_id,
                    :schedule_1,
                    :start_time_1,
                    :schedule_2,
                    :start_time_2,
                    :schedule_3,
                    :start_time_3,
                    :schedule_4,
                    :start_time_4,
                    :schedule_5,
                    :start_time_5
                )"
            );
            $stmt->bindValue(":slack_id", SLACK_ID);
            $stmt->bindValue(":schedule_1", $obj[0]->summary);
            $stmt->bindValue(":start_time_1", date("Y-m-d H:i:s", strtotime($obj[0]->start->dateTime)));
            $stmt->bindValue(":schedule_2", $obj[1]->summary);
            $stmt->bindValue(":start_time_2", date("Y-m-d H:i:s", strtotime($obj[1]->start->dateTime)));
            $stmt->bindValue(":schedule_3", $obj[2]->summary);
            $stmt->bindValue(":start_time_3", date("Y-m-d H:i:s", strtotime($obj[2]->start->dateTime)));
            $stmt->bindValue(":schedule_4", $obj[3]->summary);
            $stmt->bindValue(":start_time_4", date("Y-m-d H:i:s", strtotime($obj[3]->start->dateTime)));
            $stmt->bindValue(":schedule_5", $obj[4]->summary);
            $stmt->bindValue(":start_time_5", date("Y-m-d H:i:s", strtotime($obj[4]->start->dateTime)));
            $stmt->execute();
            return true;
        } catch (Exception | TypeError $e) {
            echo "Insert Failed" . $e->getMessage() . "\n";
        }
    }

    function update(object $pdo, array $obj): bool
    {
	$exist_check = $this->select($pdo);
        echo "UPDATE\n";
        $present_schedule = [
            $exist_check["schedule_1"],
            $exist_check["schedule_2"],
            $exist_check["schedule_3"],
            $exist_check["schedule_4"],
            $exist_check["schedule_5"],
        ];
        $future_schedule = [
            $obj[0]->summary,
            $obj[1]->summary,
            $obj[2]->summary,
            $obj[3]->summary,
            $obj[4]->summary,
        ];
        $diff_check = array_diff($present_schedule, $future_schedule);
        if (count($diff_check) != UPDATE_DIFF_CHECK) {
            try{
                $stmt = $pdo->prepare(
                    "UPDATE 
                        schedules
                    SET
                        schedule_1 = :schedule_1,
                        start_time_1 = :start_time_1,
                        schedule_2 = :schedule_2,
                        start_time_2 = :start_time_2,
                        schedule_3 = :schedule_3,
                        start_time_3 = :start_time_3,
                        schedule_4 = :schedule_4,
                        start_time_4 = :start_time_4,
                        schedule_5 = :schedule_5,
                        start_time_5 = :start_time_5,
                        batch_flag = :batch_flag,
                        updated_at = NOW()
                    WHERE
                        slack_id = :slack_id"
                );
                $stmt->bindValue(":schedule_1", $obj[0]->summary);
                $stmt->bindValue(":start_time_1", date("Y-m-d H:i:s", strtotime($obj[0]->start->dateTime)));
                $stmt->bindValue(":schedule_2", $obj[1]->summary);
                $stmt->bindValue(":start_time_2", date("Y-m-d H:i:s", strtotime($obj[1]->start->dateTime)));
                $stmt->bindValue(":schedule_3", $obj[2]->summary);
                $stmt->bindValue(":start_time_3", date("Y-m-d H:i:s", strtotime($obj[2]->start->dateTime)));
                $stmt->bindValue(":schedule_4", $obj[3]->summary);
                $stmt->bindValue(":start_time_4", date("Y-m-d H:i:s", strtotime($obj[3]->start->dateTime)));
                $stmt->bindValue(":schedule_5", $obj[4]->summary);
                $stmt->bindValue(":start_time_5", date("Y-m-d H:i:s", strtotime($obj[4]->start->dateTime)));
                $stmt->bindValue(":batch_flag", BATCH_FALSE);
                $stmt->bindValue(":slack_id", SLACK_ID);
                $stmt->execute();
                return true;
            } catch (Exception | TypeError $e) {
                echo "Update Failed" . $e->getMessage() . "\n";
            }
        } else {
            echo "NO UPDATE!\n";
            return false;
        }
    }

    function buildBatch(object $pdo): bool
    {
        try{
            $stmt = $pdo->prepare(
                "UPDATE 
                    schedules
                SET
                    batch_flag = :batch_flag,
                    updated_at = NOW()
                WHERE
                    slack_id = :slack_id"
            );
            $stmt->bindValue(":batch_flag", BATCH_TRUE);
            $stmt->bindValue(":slack_id", SLACK_ID);
            $stmt->execute();
            return true;
        } catch (Exception | TypeError $e) {
            echo "Update Failed" . $e->getMessage() . "\n";
        }
    }

    /*function delete($pdo, $id, $slack_id, $schedule_1, $schedule_2, $schedule_3, $schedule_4, $schedule_5)
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
            $stmt->bindValue(":id", (int)$id, PDO::PARAM_INT);
            $result = $stmt->execute();
        } else {
            return false;
        }
        return $result;
    }*/

}

?>