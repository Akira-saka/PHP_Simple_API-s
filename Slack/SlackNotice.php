<?php

require_once "Slack.php";

class SlackNotice extends Slack
{
    protected $slack_message;
    protected $webhook_url;

    function __construct()
    {
        parent::__construct();
        $this->webhook_url = "xxxxx";
    }

    function execNotice($slack_message)
    {
        $ch = curl_init();
        $options = [
            CURLOPT_URL => $this->webhook_url,
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
