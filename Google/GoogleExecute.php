<?php

require_once "Google.php";
require_once __DIR__ . "/../Slack/SlackNotice.php";

ini_set('date.timezone', 'Asia/Tokyo');

class GoogleExecute
{

    protected $schedules;
    protected $slack_message;

    function __construct()
    {
        $this->google = new Google();
        $this->slackNotice = new SlackNotice();
    }

    function sendMessages()
    {

        try {
            $schedules = $this->google->getSchedules();
            $msg_val = "";

            foreach ($schedules as $schedule) {
                $msg_val .= date("Y年m月d日 H時i分", strtotime($schedule->start->dateTime)) . "から" . date("Y年m月d日 H時i分", strtotime($schedule->end->dateTime)) . "まで\n" . $schedule->summary . "です。\n" . $schedule->htmlLink . "\n";
            }

            $slack_message = [
                "username" => "google-intermission-codingkey",
                "text" => "直近5つのスケジュールです\n" . SLACK_ID,
                "attachments" => [
                    [
                        "color" => "good",
                        "fields" => [
                            [   
                                "title" => date("Y-m-d"),
                                "msg_val" => $msg_val,
                            ]
                        ]
                    ]
                ],
                "icon_emoji" => ":sunglasses:",
            ];
            $this->slackNotice->execNotice($slack_message);
        } catch (Exception $e) {
            echo "Faiiled" . $e->getMessage();
            exit();
        }
        return true;
    }

}

$oGoogleExec = new GoogleExecute();
$send_res = $oGoogleExec->sendMessages();
echo $send_res === true ? "Slack Notice Complete!\n" : "Bad! Failed!\n";
