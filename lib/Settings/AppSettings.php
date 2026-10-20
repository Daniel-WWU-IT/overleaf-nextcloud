<?php

namespace OCA\OverleafV6\Settings;

use OCA\OverleafV6\AppInfo\Application;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Services\IInitialState;
use OCP\IAppConfig;
use OCP\Settings\ISettings;

class AppSettings implements ISettings {
    const SETTING_APP_URL = "app_url";

    const SETTING_API_KEY = "api_key";

    const SETTING_USERID_SUFFIX = "userid_suffix";
    const SETTING_USERID_SUFFIX_ENFORCE = "userid_suffix_enforce";

    private IAppConfig $config;
    private IInitialState $initialState;

    public function __construct(IAppConfig $config, IInitialState $initialState) {
        $this->config = $config;
        $this->initialState = $initialState;
    }

    public function getAppURL($internalCall = false): string {
        $internalURL = getenv("OVERLEAF_INTERNAL_URL");
        return $internalCall && $internalURL ? $internalURL : $this->config->getValueString(Application::APP_ID, AppSettings::SETTING_APP_URL, "", lazy: true);
    }

    public function setAppURL(string $url): void {
        $this->config->setValueString(Application::APP_ID, AppSettings::SETTING_APP_URL, $url, lazy: true);
    }

    public function getAPIKey(): string {
        return $this->config->getValueString(Application::APP_ID, AppSettings::SETTING_API_KEY, "", lazy: true);
    }

    public function setAPIKey(string $apiKey): void {
        $this->config->setValueString(Application::APP_ID, AppSettings::SETTING_API_KEY, $apiKey, lazy: true);
    }

    public function getUserIDSuffix(): string {
        return $this->config->getValueString(Application::APP_ID, AppSettings::SETTING_USERID_SUFFIX, "", lazy: true);
    }

    public function setUserIDSuffix(string $suffix): void {
        $this->config->setValueString(Application::APP_ID, AppSettings::SETTING_USERID_SUFFIX, $suffix, lazy: true);
    }

    public function getEnforceUserIDSuffix(): bool {
        return $this->config->getValueBool(Application::APP_ID, AppSettings::SETTING_USERID_SUFFIX_ENFORCE, false, lazy: true);
    }

    public function setEnforceUserIDSuffix(bool $enforceSuffix): void {
        $this->config->setValueBool(Application::APP_ID, AppSettings::SETTING_USERID_SUFFIX_ENFORCE, $enforceSuffix, lazy: true);
    }

    public function getForm(): TemplateResponse {
        $this->initialState->provideInitialState(AppSettings::SETTING_APP_URL, $this->getAppURL());
        $this->initialState->provideInitialState(AppSettings::SETTING_API_KEY, $this->getAPIKey());
        $this->initialState->provideInitialState(AppSettings::SETTING_USERID_SUFFIX, $this->getUserIDSuffix());
        $this->initialState->provideInitialState(AppSettings::SETTING_USERID_SUFFIX_ENFORCE, $this->getEnforceUserIDSuffix());
        return new TemplateResponse(Application::APP_ID, "settings/appSettings");
    }

    public function getSection(): string {
        return Application::APP_ID;
    }

    public function getPriority(): int {
        return 70;
    }
}
