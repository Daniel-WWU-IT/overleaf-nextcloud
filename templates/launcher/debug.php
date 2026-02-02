<?php

use OCP\Util;

use OCA\Overleaf\AppInfo\Application;

Util::addScript(Application::APP_ID, "launcher/launcher");

Util::addStyle(Application::APP_ID, "main");
Util::addStyle(Application::APP_ID, "launcher/launcher");
?>

<div id="content" class="app-wrapper">
    <div id="app-loading" class="app-wrapper-loading" style="color: black;">
        <i>Debugging application:</i><br>
        <?php p($_['message']) ?>
    </div>
</div>
