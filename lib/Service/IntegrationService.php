<?php

namespace OCA\OverleafV6\Service;

use DateTime;

use OCA\OverleafV6\Settings\AppSettings;

use OCP\Constants;
use OCP\IUserSession;
use OCP\IURLGenerator;
use OCP\Files\File;
use OCP\Files\IRootFolder;
use OCP\Share\IManager;
use OCP\Share\IShare;

class IntegrationService {
    private const KEY_IMPORT_FILE = "overleaf_import_file";

    private IUserSession $userSession;
    private IRootFolder $rootFolder;
    private IManager $shareManager;
    private IURLGenerator $urlGenerator;

    public function __construct(IUserSession $userSession, IRootFolder $rootFolder, IManager $shareManager, IURLGenerator $urlGenerator) {
        session_start();

        $this->userSession = $userSession;
        $this->rootFolder = $rootFolder;
        $this->shareManager = $shareManager;
        $this->urlGenerator = $urlGenerator;
    }

    public function generateImportFileURL($fileId): string {
        $user = $this->userSession->getUser();
        if ($user == null) {
            return "";
        }

		$userFolder = $this->rootFolder->getUserFolder($user->getUID());
		$nodes = $userFolder->getById($fileId);
		if (count($nodes) > 0 && ($nodes[0] instanceof File)) {
			$share = $this->shareManager->newShare();
			$share->setNode($nodes[0]);
			$share->setPermissions(Constants::PERMISSION_READ);
			$share->setShareType(IShare::TYPE_LINK);
			$share->setSharedBy($user->getUID());
			$share->setLabel("Overleaf V6");
			$share->setExpirationDate(new DateTime("now + 5 minutes"));
			$share = $this->shareManager->createShare($share);
			return $this->urlGenerator->getAbsoluteURL("/public.php/dav/files/" . $share->getToken());
        }
        
        return "";
    }

    public function storeImportFile($fileId): void {
        unset($_SESSION[self::KEY_IMPORT_FILE]);
        if ($fileId !== null) {
            $_SESSION[self::KEY_IMPORT_FILE] = $this->generateImportFileURL($fileId);
        }
    }

    public function retrieveImportFile(): ?string {
        $importFile = $_SESSION[self::KEY_IMPORT_FILE] ?? null;
        $this->storeImportFile(null);
        return $importFile;
    }
}
