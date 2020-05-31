<?php

declare(strict_types = 1);

require_once "Slack.php";
require_once "SlackNotice.php";

class SlackExecute
{

    protected $obj;
    protected $slack_message;

    function __construct()
    {
        $this->slack = new Slack();
        $this->slackNotice = new SlackNotice();
    }
    

    function sendMsgToSlack(): bool
    {
        try {
            $obj = $this->slack->loadArrayInfos();
            $slack_message = $this->slack->setMessages($obj);
            $this->slackNotice->execNotice($slack_message);
        } catch (Exception | TypeError $e) {
            echo "Failed" . $e->getMessage() . "\n";
            exit();
        }
        return true;
    }
}

$oSlackExec = new SlackExecute();
$send_res = $oSlackExec->sendMsgToSlack();
echo $send_res === true ? "Slack Notice Complete!\n" : "Bad! Failed!\n";
