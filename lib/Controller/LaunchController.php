<?php

namespace OCA\Overleaf\Controller;

use OCA\Overleaf\AppInfo\Application;
use OCA\Overleaf\Service\AppService;
use OCA\Overleaf\Settings\AppSettings;

use OCP\AppFramework\{Controller, Http\ContentSecurityPolicy, Http\RedirectResponse, Http\TemplateResponse};
use OCP\IRequest;
use OCP\IURLGenerator;

class LaunchController extends Controller {
    private IURLGenerator $urlGenerator;

    private AppService $appService;

    private AppSettings $appSettings;

    public function __construct(
        IRequest      $request,
        IURLGenerator $urlGenerator,
        AppService    $appService,
        AppSettings   $appSettings) {
        parent::__construct(Application::APP_ID, $request);

        $this->urlGenerator = $urlGenerator;

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
        $appHost = $this->appService->getAppHost(true);

        $csp = new ContentSecurityPolicy();
        $csp->addAllowedConnectDomain($host);
        $csp->addAllowedConnectDomain($appHost);
        $csp->addAllowedConnectDomain("blob:");
        $csp->addAllowedFrameDomain($host);
        $csp->addAllowedFrameDomain($appHost);
        $csp->addAllowedFrameDomain("blob:");

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
        return new RedirectResponse($this->appService->settings()->getAppURL());
    }
}
