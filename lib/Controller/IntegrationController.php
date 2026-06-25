<?php

namespace OCA\OverleafV6\Controller;

use OCA\OverleafV6\AppInfo\Application;
use OCA\OverleafV6\Service\AppService;

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

    private AppService $appService;

    public function __construct(
        IRequest      $request,
        IURLGenerator $urlGenerator,
        AppService    $appService
    ) {
        parent::__construct(Application::APP_ID, $request);

        $this->urlGenerator = $urlGenerator;

        $this->appService = $appService;
    }

    /*** Integration endpoints ***/

    #[NoCSRFRequired]
    #[NoAdminRequired]
    #[FrontpageRoute(verb: "GET", url: "/integration/import-file/{fileId}")]
    public function launch($fileId): RedirectResponse {
        // TODO: Handle importing etc
        $url = $this->urlGenerator->linkToRoute(Application::APP_ID . ".launch.launch", ["fileId" => $fileId]);
        return new RedirectResponse($url);
    }
}

