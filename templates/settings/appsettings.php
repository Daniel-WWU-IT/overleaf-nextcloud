<?php

use OCP\Util;

use OCA\Overleaf\AppInfo\Application;

Util::addScript(Application::APP_ID, "settings/appsettings");

Util::addStyle(Application::APP_ID, "main");
Util::addStyle(Application::APP_ID, "settings/appsettings");

?>

<div id="settings" class="section">
    <h2>Overleaf Settings</h2>

    <form id="settings-form" style="padding-bottom: 1rem; width: 600px;">
        <div id="main-settings-section" style="padding-bottom: 1rem;">
            <div class="section-header">
                <h3>Main</h3>
            </div>
            <div style="padding-bottom: 1rem;">Configure the main Overleaf settings.</div>

            <div class="settings-table settings-table-main">
                <label for="app-url">Overleaf URL:</label>
                <input id="app-url" type="text" style="width: 400px;" placeholder="https://www.mydomain.com" value="<?php p($_['app_url']) ?>"/>
                <div class="settings-table-info"><em>The URL of your Overleaf instance.</em></div>

                <label for="api-key" style="grid-row: 2;">API Key:</label>
                <input id="api-key" type="text" style="width: 400px;" placeholder="secret-key-1234" style="grid-row: 2;" value="<?php p($_['api_key']) ?>"/>
                <div class="settings-table-info"><em>The key used to authenticate against the Overleaf API.</em></div>
            </div>
        </div>

        <div id="userid-settings-section">
            <div class="section-header">
                <h3>User IDs</h3>
            </div>
            <div style="padding-bottom: 1rem;">Configure how the user IDs for Overleaf are generated.</div>
            <div style="padding-bottom: 1rem;">
                <em>By default, a suffix (if specified) is only appended to a Nextcloud ID if it is not an email address. This behavior can be changed by enforcing the suffix.</em>
            </div>

            <div class="settings-table settings-table-userid">
                <label for="userid-suffix">Suffix:</label>
                <input id="userid-suffix" type="text" style="width: 400px;" placeholder="mydomain.com" value="<?php p($_['userid_suffix']) ?>"/>
                <div class="settings-table-info"><em>The user IDs will be generated in the form of <i>nextcloud-id@suffix</i>. It should thus be in the form of <i>host.tld</i>, like <i>mydomain.com</i>.</em></div>

                <div style="padding-top: 3.0rem;">&nbsp;</div>
                <div>
                    <input id="userid-suffix-enforce" type="checkbox" class="checkbox" <?php p($_['userid_suffix_enforce'] ? 'checked' : ''); ?>/>
                    <label for="userid-suffix-enforce">Enforce suffix</label>
                </div>
                <div class="settings-table-info"><em>If enabled, user IDs which already are an email address will nonetheless use the specified suffix.</em></div>
            </div>
        </div>
    </form>

    <div id="success-message" class="success-message" style="display: none;">Settings saved!</div>
</div>
