<?php

class Slack 
{
    protected $slack_id;
    protected $google_calendero;
    protected $trello;
    protected $manabaa;
    protected $university_name;
    protected $slack_infos;
    protected $obj;

    function __construct()
    {
        $this->slack_id = "<@U01260D3HMG>";
        $this->google_calender = "https://calendar.google.com/calendar/r";
        $this->trello = "https://trello.com/b/x7E1lW49/%E8%87%AA%E5%88%86%E3%81%AE%E3%82%BF%E3%82%B9%E3%82%AF%E7%AE%A1%E7%90%86";
        $this->manaba_url = "https://mgu.manaba.jp/ct/home_course";
        $this->university_name = "明治学院";
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
            "text" => "Slack通知：チェックURL:\n" . $this->slack_id,
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
