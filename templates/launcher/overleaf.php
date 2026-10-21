<?php

use OCP\Util;

use OCA\OverleafV6\AppInfo\Application;

Util::addScript(Application::APP_ID, Application::APP_ID . "-launcher_overleaf");
?>

<div id="overleaf-app" style="width: 100%;"></div>
