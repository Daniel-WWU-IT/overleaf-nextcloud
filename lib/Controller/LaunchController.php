<?php

namespace OCA\OverleafV6\Controller;

use OCA\OverleafV6\AppInfo\Application;
use OCA\OverleafV6\Service\AppService;
use OCA\OverleafV6\Service\IntegrationService;
use OCA\OverleafV6\Settings\AppSettings;
use OCA\OverleafV6\Util\Requests;
use OCA\OverleafV6\Util\URLUtils;
use OCA\OverleafV6\Util\Session;

use OCP\AppFramework\{
    Controller,
    Http\Attribute\FrontpageRoute,
    Http\Attribute\NoAdminRequired,
    Http\Attribute\NoCSRFRequired,
    Http\ContentSecurityPolicy, 
    Http\RedirectResponse,
    Http\TemplateResponse,
    Http\DataResponse, 
    Http
};
use OCP\IRequest;
use OCP\IConfig;
use OCP\IURLGenerator;

class LaunchController extends Controller {
    private IURLGenerator $urlGenerator;
    private IConfig $config;

    private AppService $appService;
    private IntegrationService $integrationService;

    private AppSettings $appSettings;

    public function __construct(
        IRequest           $request,
        IURLGenerator      $urlGenerator,
        IConfig            $config,
        AppService         $appService,
        IntegrationService $integrationService,
        AppSettings        $appSettings
    ) {            
        parent::__construct(Application::APP_ID, $request);

        $this->urlGenerator = $urlGenerator;
        $this->config = $config;
        
        $this->appService = $appService;
        $this->integrationService = $integrationService;

        $this->appSettings = $appSettings;
    }

    /*** Page endpoints ***/

    #[NoCSRFRequired]
    #[NoAdminRequired]
    #[FrontpageRoute(verb: "GET", url: "/launcher/launch")]
    public function launch(): TemplateResponse {
        $params = [];
        if (($importFile = $this->integrationService->retrieveImportFile()) !== null) {
            $params["importFile"] = $importFile;
        }
        $resp = new TemplateResponse(Application::APP_ID, "launcher/launcher", [
            "app-source" => $this->urlGenerator->linkToRoute(Application::APP_ID . ".launch.app", $params),
            "app-origin" => $this->appService->getAppHost(true),
        ]);
        $resp->setContentSecurityPolicy($this->createContentSecurityPolicy());
        return $resp;
    }

    #[NoCSRFRequired]
    #[NoAdminRequired]
    #[FrontpageRoute(verb: "GET", url: "/launcher/app")]
    public function app($importFile = null): TemplateResponse {
        // Create the user and forward the retrieved information to the actual app loader
        $createURL = $this->appService->generateCreateURL();
        $data = Requests::getProtectedContents($createURL, $this->appSettings);
        $userData = json_decode($data);

        $resp = new TemplateResponse(Application::APP_ID, "launcher/app", [
            "url" => $this->appSettings->getAppURL(),
            "email" => $userData->email,
            "password" => $userData->password,
            "importFile" => $importFile ?? "",
        ], TemplateResponse::RENDER_AS_BASE);
        $resp->setContentSecurityPolicy($this->createContentSecurityPolicy());
        return $resp;
    }

    /*** Helper functions ***/

    private function createContentSecurityPolicy(): ContentSecurityPolicy {
        $host = $_SERVER["HTTP_HOST"];
        $overwriteHost = URLUtils::getHostURL($this->config);
        $appHost = $this->appService->getAppHost(true);

        $csp = new ContentSecurityPolicy();
        $csp->addAllowedConnectDomain($host);
        $csp->addAllowedConnectDomain($appHost);
        $csp->addAllowedConnectDomain("blob:");
        $csp->addAllowedFrameDomain($host);
        $csp->addAllowedFrameDomain($appHost);
        $csp->addAllowedFrameDomain("blob:");
        $csp->addAllowedFrameAncestorDomain($host);
        $csp->addAllowedFrameAncestorDomain($appHost);
        $csp->addAllowedFrameAncestorDomain("blob:");

        if ($host != $overwriteHost) {
            $csp->addAllowedConnectDomain($overwriteHost);
            $csp->addAllowedFrameDomain($overwriteHost);
            $csp->addAllowedFrameAncestorDomain($overwriteHost);
        }

        return $csp;
    }
}
