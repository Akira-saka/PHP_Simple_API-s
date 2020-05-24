<?php

require_once "Google.php";
require_once __DIR__ . "/../Slack/SlackNotice.php";

ini_set('date.timezone', 'Asia/Tokyo');

class GoogleExecute extends Slack
{

    protected $schedules;
    protected $slack_message;

    function __construct()
    {
        parent::__construct();
        $this->google = new Google();
        $this->slackNotice = new SlackNotice();
    }

    function sendMessages()
    {

        try {
            $schedules = $this->google->getSchedules();
            $value = "";

            foreach ($schedules as $schedule) {
                $value .= date("Y年m月d日 H時i分", strtotime($schedule->start->dateTime)) . "から" . date("Y年m月d日 H時i分", strtotime($schedule->end->dateTime)) . "まで\n" . $schedule->summary . "です。\n" . $schedule->htmlLink . "\n";
            }

            $slack_message = [
                "username" => "google-intermission-codingkey",
                "text" => "直近5つのスケジュールです\n" . $this->slack_id,
                "attachments" => [
                    [
                        "color" => "good",
                        "fields" => [
                            [   
                                "title" => date("Y-m-d"),
                                "value" => $value,
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

$google = new GoogleExecute();
$result = $google->sendMessages();
echo $result === true ? "Slack Notice Complete!\n" : "Bad! Failed!\n";

?>