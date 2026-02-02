<?php

use OCP\Util;

use OCA\Overleaf\AppInfo\Application;

Util::addScript(Application::APP_ID, "launcher/app");

Util::addStyle(Application::APP_ID, "main");
Util::addStyle(Application::APP_ID, "launcher/app");
?>

<div id="app-frame">
    <input type="hidden" id="overleaf-url" value="<?php p($_['url']); ?>" />
    <input type="hidden" id="user-email" value="<?php p($_['email']); ?>" />
    <input type="hidden" id="user-password" value="<?php p($_['password']); ?>" />
</div>
