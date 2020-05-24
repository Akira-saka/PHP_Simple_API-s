<?php

require_once __DIR__ . "/../vendor/autoload.php";

ini_set('date.timezone', 'Asia/Tokyo');

const calendar_id = "xxxxx";

class Google
{

    protected $my_json_key;
    protected $service;
    protected $now_day;
    protected $schedules;

    function __construct()
    {
        $this->client = new Google_Client();
        $this->slackNotice = new SlackNotice();
    }

    function createService()
    {
        $my_json_key = "../xxxxx";
        $this->client->setApplicationName('カレンダー操作テスト イベントの取得');
        // 予定を取得する時は Google_Service_Calendar::CALENDAR_READONLY
        // 予定を追加する時は Google_Service_Calendar::CALENDAR_EVENTS
        $this->client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
        // ユーザーアカウントのjsonを指定
        $this->client->setAuthConfig($my_json_key);
        // サービスオブジェクトの用意
        $service = new Google_Service_Calendar($this->client);
        return $service;
    }

    function getSchedules()
    {
        $service = $this->createService();
        // 取得時の詳細設定
        $options = array(
            'maxResults' => 5,
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => date('c', strtotime(date("Y-m-d\TH:i"))),
        );
        $result = $service->events->listEvents(calendar_id, $options);
        $schedules = $result->getItems();
        return $schedules;
    }

}

?>