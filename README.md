php notice for univ_student

実装予定
```
trello、zoom API使用可能性あり
twitter 指定ワード　slack通知、ニュースURLにする可能性あり
line message apiによりgoogle calender通知
```

icon
https://www.webfx.com/tools/emoji-cheat-sheet/

# PHP_Simple_API's

PHP_Simple_API's is a tutorial of PHP.

# Description

API、cronで欲しい情報を全て連携させる

スケジュール、タスク管理をどのサービスから行っても共有できるため、1つのスケジュールを変更すれば良い。

#Requirement

* PHP 7.3.14
* mysql  Ver 15.1 Distrib 10.3.17-MariaDB, for Linux (x86_64) using readline 5.1
* slack webhook API
* Google Calender API

etc...

# OS

CentOS Linux 8.0.1905 

# Usage


bash
```
git clone https://github.com/siv8510/PHP_Simple_API-s.git
cd slackbot
```

DB
```
mysql -u hoge -p
enter your pwd
CREATE DATABASE API;
USE API;
source ./create_schedules_table.sql;
quit;
```
crontab
```
*/5 * * * * php path/slackbot/Google/GoogleExecute.php
0 8-20/6 * * * php path/slackbot/Slack/SlackExecute.php
```

# Note

完全個人用のため、必要に応じて、ファイル内の大幅な書き換えの可能性あり。

# Author

* sivchari
* university student 🇫🇷
* https://twitter.com/sivchari


enjoy making your schedule!

I'm glad this system makes you smile :)
 
Thank you!
