<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require_once "LINEBotTiny.php";
require_once __DIR__ . "/../config/common.php";
require_once __DIR__ . "/../QueryBuilder.php";

class LineReply {

    function __construct()
    {
        $this->pdo = new QueryBuilder();
        $this->connect = $this->pdo->connectPdo();
        $this->client = new LINEBotTiny(LINE_ACCESS_TOKEN, LINE_ACCESS_SECRET);
    }

    function ReplyMsg() {
        foreach ($this->client->parseEvents() as $event) {
            switch ($event["type"]) {
                case "message":
                    $message = $event["message"];
                    switch ($message["type"]) {
                        case "text":
                            switch ($message["text"]) {
                                case "trello":
                                    $reply = TRELLO_URL;
                                    break;
                                case "manaba":
                                    $reply = MANABA_URL;
                                    break;
                                case "YouTube":
                                    $reply = YOUTUBE;
                                    break;
                                case "スケジュール":
                                    $row = $this->pdo->select($this->connect);
                                    $next_schedule = $row["schedule_2"];
                                    $next_start_time = date("n月j日 G時i", strtotime($row["start_time_2"]));
                                    $reply = "次のスケジュールは\n" . $next_start_time . "から\n" . $next_schedule . "です！";
                                    break;
                                default:
                                    $reply = "Fight!";
                                    break;
                            }
                            $this->client->replyMessage([
                                "replyToken" => $event["replyToken"],
                                "messages" => [
                                    [
                                        "type" => "text",
                                        "text" => $reply
                                    ]
                                ]
                            ]);
                            break;
                        default:
                            error_log("Unsupported message type: " . $message["type"]);
                            break;
                    }
                    break;
                default:
                    error_log("Unsupported event type: " . $event["type"]);
                    break;
            }
        }
    }
};
$oLineReply = new LineReply();
$oLineReply->ReplyMsg();