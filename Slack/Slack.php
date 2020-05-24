<?php

class Slack 
{
    protected $slack_id;
    protected $google_calender;
    protected $trello;
    protected $manabaa;
    protected $university_name;
    protected $slack_infos;
    protected $obj;

    function __construct()
    {
        $this->slack_id = "xxxxx";
        $this->google_calender = "xxxxx";
        $this->trello = "xxxxx";
        $this->manaba_url = "xxxxx";
        $this->university_name = "xxxxx";
    }

    function getInfos()
    {
        $slack_id = $this->slack_id;
        $google_calender = $this->google_calender;
        $trello = $this->trello;
        $manaba = $this->university_name . "\n" . $this->manaba_url;
        $slack_infos = [
            "slack_id" => $slack_id,
            "google_calender" => $google_calender,
            "trello" => $trello,
            "manaba" => $manaba,
        ];
        return $slack_infos;
    }

    function setMessages($obj)
    {
        $slack_message = [
            "username" => "slack-intermission-codingkey",
            "text" => "Slack通知：チェックURL:\n<@" . $this->slack_id . ">",
            "attachments" => [
                [
                    "color" => "good",
                    "fields" => [
                        [   
                            "title" => "My Googole Calender",
                            "value" => $obj["google_calender"],
                        ]
                    ]
                ], [
                    "color" => "warning",
                    "fields" => [
                        [   
                            "title" => "My Trello",
                            "value" => $obj["trello"],
                        ]
                    ]
                ], [
                    "color" => "danger",
                    "fields" => [
                        [   
                            "title" => "My manaba",
                            "value" => $obj["manaba"],
                        ]
                    ]
                ]
            ],
            "icon_emoji" => ":sun_with_face:",
        ];
        return $slack_message;
    }
}

?>
