<?php

namespace OCA\Overleaf\Controller;

use OCA\Overleaf\AppInfo\Application;
use OCA\Overleaf\Service\AppService;
use OCA\Overleaf\Settings\AppSettings;
use OCA\Overleaf\Util\Requests;
use OCA\Overleaf\Util\URLUtils;

use OCP\AppFramework\{Controller, Http\ContentSecurityPolicy, Http\RedirectResponse, Http\TemplateResponse, Http\DataResponse, Http};
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
    public function app(): TemplateResponse {
        // Create the user and forward the retrieved information to the actual app loader
        $createURL = $this->appService->generateCreateURL();
        $data = Requests::getProtectedContents($createURL, $this->appSettings);
        $userData = json_decode($data);

        $resp = new TemplateResponse(Application::APP_ID, "launcher/app", [
            "url" => $this->appSettings->getAppURL(),
            "email" => $userData->email,
            "password" => $userData->password,
        ]);
        $resp->setContentSecurityPolicy($this->createContentSecurityPolicy());
        return $resp;
    }

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
