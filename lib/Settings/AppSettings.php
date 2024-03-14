<?php

namespace OCA\Overleaf\Settings;

use OCA\Overleaf\AppInfo\Application;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\IConfig;
use OCP\Settings\ISettings;

class AppSettings implements ISettings {
    const SETTING_APP_URL = "app_url";

    const SETTING_USERID_SUFFIX = "userid_suffix";
    const SETTING_USERID_SUFFIX_ENFORCE = "userid_suffix_enforce";

    private IConfig $config;

    public function __construct(IConfig $config) {
        $this->config = $config;
    }

    public function getSettings(): array {
        return [
            AppSettings::SETTING_APP_URL =>
                $this->config->getAppValue(Application::APP_ID, AppSettings::SETTING_APP_URL, ""),
            AppSettings::SETTING_USERID_SUFFIX =>
                $this->config->getAppValue(Application::APP_ID, AppSettings::SETTING_USERID_SUFFIX, ""),
            AppSettings::SETTING_USERID_SUFFIX_ENFORCE =>
                $this->config->getAppValue(Application::APP_ID, AppSettings::SETTING_USERID_SUFFIX_ENFORCE, false) == "true",
        ];
    }

    public function getAppURL(): string {
        return $this->getSettings()[self::SETTING_APP_URL];
    }

    public function getUserIDSuffix(): string {
        return $this->getSettings()[self::SETTING_USERID_SUFFIX];
    }

    public function getEnforceUserIDSuffix(): bool {
        return $this->getSettings()[self::SETTING_USERID_SUFFIX_ENFORCE];
    }

    public function getForm(): TemplateResponse {
        return new TemplateResponse(Application::APP_ID, "settings/appsettings", $this->getSettings());
    }

    public function getSection(): string {
        return Application::APP_ID;
    }

    public function getPriority(): int {
        return 70;
    }
}
