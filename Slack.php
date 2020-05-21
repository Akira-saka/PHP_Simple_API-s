<?php

class Slack 
{
    protected $start_message;
    protected $slack_id;
    protected $webhook_url;
    protected $google_calendero;
    protected $trello;
    protected $manabaa;
    protected $university_name;
    protected $end_message;

    function __construct() {
        $this->start_message = "Message for Me!";
        $this->slack_id = "xxxxxx";
        $this->webhook_url = "xxxxxx";
        $this->google_calender = "xxxxxx";
        $this->trello = "xxxxxx";
        $this->manaba_url = "xxxxxx";
        $this->university_name = "xxxxxx";
        $this->end_message = "Fighet!";
    }

    function slackInfos() {
        $start_message = $this->start_message;
        $slack_id = $this->slack_id;
        $webhook_url = $this->webhook_url;
        $google_calender = $this->google_calender;
        $trello = $this->trello;
        $manaba = $this->university_name . "\n" . $this->manaba_url;
        $end_message = $this->end_message;
        $slack_infos = [
            0 => $start_message,
            1 => $slack_id,
            2 => $webhook_url,
            3 => $google_calender,
            4 => $trello,
            5 => $manaba,
            6 => $end_message,
        ];
        return $slack_infos;
    } 
}

?>
