<?php

namespace OCA\OverleafV6\Controller;

use OCA\OverleafV6\AppInfo\Application;
use OCA\OverleafV6\Service\IntegrationService;
use OCA\OverleafV6\Util\Requests;
use OCA\OverleafV6\Util\Session;

use OCP\AppFramework\{
    Controller,
    Http\Attribute\FrontpageRoute,
    Http\Attribute\NoAdminRequired,
    Http\Attribute\NoCSRFRequired,
    Http\RedirectResponse,
};
use OCP\IRequest;
use OCP\IURLGenerator;

class IntegrationController extends Controller {
    private IURLGenerator $urlGenerator;

    private IntegrationService $integrationService;

    public function __construct(
        IRequest           $request,
        IURLGenerator      $urlGenerator,
        IntegrationService $integrationService
    ) {
        parent::__construct(Application::APP_ID, $request);

        $this->urlGenerator = $urlGenerator;
        $this->integrationService = $integrationService;

        $this->appService = $appService;
    }

    /*** Integration endpoints ***/

    #[NoCSRFRequired]
    #[NoAdminRequired]
    #[FrontpageRoute(verb: "GET", url: "/integration/import-file/{fileId}")]
    public function importFile($fileId): RedirectResponse {
        $this->integrationService->storeImportFile($fileId);
        
        $url = $this->urlGenerator->linkToRoute(Application::APP_ID . ".launch.launch");        
        return new RedirectResponse($url);
    }
}

