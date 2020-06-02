<?php

declare(strict_types = 1);

require_once __DIR__ . "/../config/common.php";

class Slack 
{
    
    protected $slack_infos;
    protected $obj;

    function loadArrayInfos(): array
    {
        $custom_manaba_info = UNIVERSITY_NAME . "\n" . MANABA_URL;
        $array_infos = [
            "slack_id" => SLACK_ID,
            "google_calender" => GOOGLE_CALENDAR_URL,
            "trello" => TRELLO_URL,
            "manaba" => $custom_manaba_info,
        ];
        return $array_infos;
    }

    function setMessages(array $obj): array
    {
        $slack_message = [
            "username" => "slack-intermission-codingkey",
            "text" => "Slack通知：チェックURL:\n<@" . SLACK_ID . ">",
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

    function beforeFiveMsg(string $message): array
    {
        $slack_message = [
            "username" => "5minutes-intermission-codingkey",
            "text" => "<@" . SLACK_ID . ">",
            "attachments" => [
                [
                    "color" => "good",
                    "fields" => [
                        [   
                            "title" => "Note！Before 5 minutes Notify",
                            "value" => $message . "ファイト！\n",
                        ]
                    ]
                ], 
            ],
            "icon_emoji" => ":fire:",
        ];
        return $slack_message;
    } 
}
