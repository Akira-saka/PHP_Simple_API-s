<?php

class SlackNotice 
{
    protected $slack_message;
    protected $obj;

    function setMessages($obj) {
        $slack_message = [
            "username" => "intermission-codingkey",
            "text" => $obj[0] . "\n" . $obj[1] . "\n" . $obj[6],
            "attachments" => [
                [
                    "color" => "good",
                    "fields" => [
                        [   
                            "title" => "My Googole Calender",
                            "value" => $obj[3],
                        ]
                    ]
                ], [
                    "color" => "warning",
                    "fields" => [
                        [   
                            "title" => "My Trello",
                            "value" => $obj[4],
                        ]
                    ]
                ], [
                    "color" => "danger",
                    "fields" => [
                        [   
                            "title" => "My manaba",
                            "value" => $obj[5],
                        ]
                    ]
                ]
            ],
            "icon_emoji" => ":ghost:",
        ];
        return $slack_message;
    }

    function execNotice($obj) {
        $slack_message = $this->setMessages($obj);
        $ch = curl_init();
        $options = [
            CURLOPT_URL => $obj[2],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'payload' => json_encode($slack_message)
            ])
        ];
        curl_setopt_array($ch, $options);
        curl_exec($ch);
        curl_close($ch);
        return true;
    }

}
?>
