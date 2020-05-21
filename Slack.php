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
        $this->slack_id = "<@U01260D3HMG>";
        $this->webhook_url = "https://hooks.slack.com/services/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";
        $this->google_calender = "https://calendar.google.com/calendar/r";
        $this->trello = "https://trello.com/b/x7E1lW49/%E8%87%AA%E5%88%86%E3%81%AE%E3%82%BF%E3%82%B9%E3%82%AF%E7%AE%A1%E7%90%86";
        $this->manaba_url = "https://mgu.manaba.jp/ct/home_course";
        $this->university_name = "明治学院";
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
