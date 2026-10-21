<?php

use OCP\Util;

use OCA\OverleafV6\AppInfo\Application;

Util::addScript(Application::APP_ID, Application::APP_ID . "-launcher_launcher");
?>

<div id="overleaf-launcher" style="width: 100%;"></div>
