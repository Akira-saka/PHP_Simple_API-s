<?php

declare(strict_types = 1);

require_once "Google.php";
require_once __DIR__ . "/../Slack/SlackNotice.php";
require_once __DIR__ . "/../QueryBuilder.php";

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
        $this->pdo = new QueryBuilder();
    }

    function sendMessages(): bool
    {

        try {
            $schedules = $this->google->getSchedules();
            $msg_val = "";

            foreach ($schedules as $schedule) {
                $msg_val .= date("Y年m月d日 H時i分", strtotime($schedule->start->dateTime)) . "から" . date("Y年m月d日 H時i分", strtotime($schedule->end->dateTime)) . "まで\n" . $schedule->summary . "です。\n" . $schedule->htmlLink . "\n";
            }

            $pdo = $this->pdo->connectPdo();
            $row = $this->pdo->select($pdo, DB_ID);

            if ($row) {
                $result = $this->pdo->update($pdo, DB_ID, SLACK_ID, $schedules);
                $text_msg = UPDATE_MESSAGE;
            } else {
                $result = $this->pdo->insert($pdo, SLACK_ID, $schedules);
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
        } catch (Exception | TypeError $e) {
            echo "Faiiled" . $e->getMessage() . "\n";
            exit();
        }
        return true;
    }

}

$oGoogleExec = new GoogleExecute();
$send_res = $oGoogleExec->sendMessages();
echo $send_res === true ? "Slack Notice Complete!\n" : "Failed\n";