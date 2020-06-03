<?php

declare(strict_types = 1);

require_once __DIR__ . "/../config/common.php";
require_once __DIR__ . "/../Google/GoogleExecute.php";

class Line
{
    function sendLine(string $send_msg): bool
    {
        $post_data['messages'][] = array(
            'type' => 'text',
            'text' => $send_msg
        );

        $ch = curl_init('https://api.line.me/v2/bot/message/broadcast');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charser=UTF-8',
            'Authorization: Bearer ' . LINE_ACCESS_TOKEN
        ));

        curl_exec($ch);
        curl_close($ch);

        return true;
      }
}
