<?php

use OCP\Util;

use OCA\OverleafV6\AppInfo\Application;

Util::addScript(Application::APP_ID, Application::APP_ID . "-launcher_launcher");

Util::addStyle(Application::APP_ID, "main");
?>

<div id="overleaf-launcher"></div>
