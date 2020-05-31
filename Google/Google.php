<?php

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../config/common.php";

ini_set('date.timezone', 'Asia/Tokyo');

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
        $my_json_key = GOOGLE_JSON_KEY;
        $this->client->setApplicationName('カレンダー操作テスト イベントの取得');
        // 予定を取得する時は Google_Service_Calendar::CALENDAR_READONLY
        // 予定を追加する時は Google_Service_Calendar::CALENDAR_EVENTS
        $this->client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
        // ユーザーアカウントのjsonを指定
        $this->client->setAuthConfig($my_json_key);
        // サービスオブジェクトの用意
        $oService = new Google_Service_Calendar($this->client);
        return $oService;
    }

    function getSchedules()
    {
        $oService = $this->createService();
        // 取得時の詳細設定
        $config_opt = array(
            'maxResults' => 5,
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => date('c', strtotime(date("Y-m-d\TH:i"))),
        );
        $can_listen_on_serve = $oService->events->listEvents(GOOGLE_CALENDAR_ID, $config_opt);
        $schedules = $can_listen_on_serve->getItems();
        return $schedules;
    }

}
