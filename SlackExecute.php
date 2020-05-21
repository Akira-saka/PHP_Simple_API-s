<?php
require "Slack.php";
require "SlackNotice.php";

class SlackExecute {

    function __construct() {
        $this->slack = new Slack();
        $this->slackNotice = new SlackNotice();
    }

    function execute() {
        try {
            $slack_infos = $this->slack->slackInfos();
            $this->slackNotice->execNotice($slack_infos);
        } catch (Exception $e) {
            echo "Faiiled!" . $e->getMessage();
            exit();
        }
        return true;
    }
}

$slack = new SlackExecute();
$result = $slack->execute();
echo $result === true ? "Slack Notice Complete!\n" : "Bad! Failed!\n";
?>