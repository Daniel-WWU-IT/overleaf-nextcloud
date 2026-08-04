<?php

use OCP\Util;

use OCA\Overleaf\AppInfo\Application;

Util::addScript(Application::APP_ID, "launcher/launcher");

Util::addStyle(Application::APP_ID, "main");
Util::addStyle(Application::APP_ID, "launcher/launcher");
?>

<div id="content" class="app-wrapper">
    <div id="app-loading" class="app-wrapper-loading" style="color: black;"><i>Loading application...</i></div>
    <iframe id="app-frame" class="app-frame" src="<?php p($_['app-source']); ?>" title="Overleaf" x-origin="<?php p($_['app-origin']); ?>"></iframe>

    <div id="overlay">
        <div class="popup">
            <h2>Important notice: Switch to Overleaf V6</h2>
            <p>
                <strong>This current version of Overleaf will be taken offline in the coming months and has been replaced by the new Overleaf V6 version.</strong>
            </p>
            <p>
                Please transfer your existing projects manually to Overleaf V6, as they will <em>not</em> be transferred automatically. To do so, download each project you want to keep as a Zip file using the corresponding action and upload them in Overleaf V6.
            </p>
            <p>
                The current version will remain available for a limited time to give you enough opportunity to migrate your projects. We recommend starting the migration process soon to ensure a smooth transition.
            </p>

            <div class="popup-footer">
                <button id="closePopup">Close</button>
            </div>
        </div>
    </div>
</div>
