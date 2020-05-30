<?php
declare(strict_types = 1);

require_once __DIR__ . "/../config/common.php";

class SlackNotice
{
    protected $slack_message;

    function execNotice(array $slack_message): bool
    {
        $ch = curl_init();
        $options = [
            CURLOPT_URL => WEBHOOK_URL,
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
