<?php

namespace OCA\OverleafV6\Controller;

use OCA\OverleafV6\AppInfo\Application;
use OCA\OverleafV6\Settings\AppSettings;

use OCP\AppFramework\{
    Controller,
    Http\Attribute\FrontpageRoute,
    Http\Attribute\NoAdminRequired,
    Http\Attribute\NoCSRFRequired,
    Http\DataResponse,
    Http
};
use OCP\IRequest;

class AppSettingsController extends Controller {
    private IConfig $config;

    private AppSettings $appSettings;

    public function __construct(
        IRequest    $request,
        AppSettings $appSettings
    ) {
        parent::__construct(Application::APP_ID, $request);

        $this->appSettings = $appSettings;
    }

    /*** Page endpoints ***/

    #[NoAdminRequired]
    #[FrontpageRoute(verb: "PUT", url: "/settings")]
    public function overleafAppSettings(string $url, string $apiKey, string $suffix, bool $enforceSuffix): DataResponse {
        $this->appSettings->setAppURL($url);
        $this->appSettings->setAPIKey($apiKey);
        $this->appSettings->setUserIDSuffix($suffix);
        $this->appSettings->setEnforceUserIDSuffix($enforceSuffix);

        return new DataResponse("", Http::STATUS_OK);
    }
}
