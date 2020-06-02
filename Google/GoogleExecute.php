<?php

declare(strict_types = 1);

require_once "Google.php";
require_once __DIR__ . "/../Slack/SlackNotice.php";
require_once __DIR__ . "/../Slack/Slack.php";
require_once __DIR__ . "/../QueryBuilder.php";
require_once __DIR__ . "/../LINE/Line.php";
require_once __DIR__ . "/../config/common.php";

ini_set('date.timezone', 'Asia/Tokyo');

class GoogleExecute
{

    protected $schedules;
    protected $slack_message;
    protected $pdo;

    function __construct()
    {
        $this->google = new Google();
        $this->slackNotice = new SlackNotice();
        $this->slack = new Slack();
        $this->pdo = new QueryBuilder();
        $this->line = new Line();
        $this->connect= $this->pdo->connectPdo();
    }

    function sendMessages(): bool
    {

        try {
            $schedules = $this->google->getSchedules();
            $msg_val = "";

            foreach ($schedules as $schedule) {
                $msg_val .= date("Y年m月d日 H時i分", strtotime($schedule->start->dateTime)) . "から" . date("Y年m月d日 H時i分", strtotime($schedule->end->dateTime)) . "まで\n" . $schedule->summary . "です。\n" . $schedule->htmlLink . "\n";
            }

	        $row = $this->pdo->select($this->connect);
	        if ($row) {
                $result = $this->pdo->update($this->connect, SLACK_ID, $schedules);
                $text_msg = UPDATE_MESSAGE;
            } else {
                $result = $this->pdo->insert($this->connect, SLACK_ID, $schedules);
                $text_msg = INSERT_MESSAGE;
            }

            if ($result == false) {
                return false;
            }

            $slack_message = [
                "username" => "google-intermission-codingkey",
                "text" => $text_msg . "\n<@" . SLACK_ID . ">\n",
                "attachments" => [
                    [
                        "color" => "good",
                        "fields" => [
                            [   
                                "title" => date("Y-m-d"),
                                "value" => $msg_val,
                            ]
                        ]
                    ]
                ],
                "icon_emoji" => ":sunglasses:",
            ];
            $this->slackNotice->execNotice($slack_message);
            $this->line->sendLine($msg_val);
        } catch (Exception | TypeError $e) {
            echo "Faiiled" . $e->getMessage() . "\n";
            exit();
        }
        return true;
    }

    function sendNotify(): bool
    {
        try {
            $row = $this->pdo->select($this->connect);
            if ($row) {
                //DBの直近のスケジュールの開始時間
                //次のスケジュールの時間　Y-m-d\TH:i Googleの時間format
                $next_start_time = $row["start_time_1"];
                $before_five_minutes = date("Y-m-d H:i:s", strtotime("-5minutes"));
            
                if ($next_start_time > $before_five_minutes  ) {
                    $send_msg = $row["schedule_1"] . "の開始５分前です\n" . "頑張りましょう！";
                    $this->line->sendLine($send_msg);
                    $message = $this->slack->beforeFiveMsg($send_msg);
                    $this->slackNotice->execNotice($message);
                    $this->pdo->buildBatch($this->connect, SLACK_ID);
                    return true;
                }
            }
            return false;
        } catch (Exception | TypeError $e) {
            echo "Faiiled" . $e->getMessage() . "\n";
            exit();
        }
        return true;
    }

}

$oGoogleExec = new GoogleExecute();
$slack_res = $oGoogleExec->sendMessages();
echo $slack_res === true ? "Slack Notice Complete!\n" : "Failed\n";
$line_res = $oGoogleExec->sendNotify();
echo $line_res === true ? "Line Notice Complete!\n" : "No Notify\n";
