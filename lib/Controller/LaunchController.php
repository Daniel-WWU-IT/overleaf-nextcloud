<?php

namespace OCA\Overleaf\Controller;

use OCA\Overleaf\AppInfo\Application;
use OCA\Overleaf\Service\AppService;
use OCA\Overleaf\Settings\AppSettings;
use OCA\Overleaf\Util\Requests;
use OCA\Overleaf\Util\URLUtils;

use OCP\AppFramework\{Controller, Http\ContentSecurityPolicy, Http\RedirectResponse, Http\TemplateResponse};
use OCP\IRequest;
use OCP\IConfig;
use OCP\IURLGenerator;

class LaunchController extends Controller {
    private IURLGenerator $urlGenerator;
    private IConfig $config;

    private AppService $appService;

    private AppSettings $appSettings;

    public function __construct(
        IRequest      $request,
        IURLGenerator $urlGenerator,
        IConfig       $config,
        AppService    $appService,
        AppSettings   $appSettings) {
        parent::__construct(Application::APP_ID, $request);

        $this->urlGenerator = $urlGenerator;
        $this->config = $config;

        $this->appService = $appService;

        $this->appSettings = $appSettings;
    }

    /*** Page endpoints ***/

    /**
     * @NoCSRFRequired
     * @NoAdminRequired
     */
    public function launch(): TemplateResponse {
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

        $resp = new TemplateResponse(Application::APP_ID, "launcher/launcher", [
            "app-source" => $this->urlGenerator->linkToRoute(Application::APP_ID . ".launch.app"),
            "app-origin" => $appHost,
        ]);
        $resp->setContentSecurityPolicy($csp);
        return $resp;
    }

    /**
     * @NoCSRFRequired
     * @NoAdminRequired
     */
    public function app(): RedirectResponse {
        // Create and login the user, and use the provided data to redirect to the projects page
        $overleafURL = $this->appService->generateCreateAndLoginURL();
        $password = $this->appService->generatePassword();
        $data = Requests::getProtectedContents($overleafURL, $this->config, $this->appSettings, [Requests::HEADER_PASSWORD => $password]);

        $resp = new RedirectResponse($this->appService->generateProjectsURL($data, $this->appSettings->getAppURL()));
        return $resp;
    }
}
