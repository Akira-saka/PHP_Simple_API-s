<?php

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
    

    function execute()
    {
        try {
            $obj = $this->slack->getInfos();
            $slack_message = $this->slack->setMessages($obj);
            $this->slackNotice->execNotice($slack_message);
        } catch (Exception $e) {
            echo "Faiiled" . $e->getMessage();
            exit();
        }
        return true;
    }
}

$slack = new SlackExecute();
$result = $slack->execute();
echo $result === true ? "Slack Notice Complete!\n" : "Bad! Failed!\n";

?>