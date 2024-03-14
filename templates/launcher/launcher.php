<?php

use OCP\Util;

use OCA\Overleaf\AppInfo\Application;

Util::addScript(Application::APP_ID, "launcher/launcher");

Util::addStyle(Application::APP_ID, "main");
Util::addStyle(Application::APP_ID, "launcher/launcher");
?>

<div id="content" class="app-wrapper">
    <div id="app-loading" class="app-wrapper-loading"><i>Loading application...</i></div>
    <iframe id="app-frame" class="app-frame" src="<?php p($_['app-source']); ?>" title="Overleaf" x-origin="<?php p($_['app-origin']); ?>"></iframe>
</div>
