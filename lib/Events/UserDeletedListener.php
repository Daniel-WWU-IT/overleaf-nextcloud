<?php

namespace OCA\Overleaf\Events;

use OCA\Overleaf\Service\AppService;
use OCA\Overleaf\Util\Requests;

use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;
use OCP\IUser;
use OCP\User\Events\UserDeletedEvent;

class UserDeletedListener implements IEventListener {
    private AppService $appService;

    public function __construct(AppService $appService) {
        $this->appService = $appService;
    }


    public function handle(Event $event): void {
        if ($event instanceof UserDeletedEvent) {
            $this->onUserDeleted($event->getUser());
        }
    }

    private function onUserDeleted(IUser $user): void {
        $url = $this->appService->generateDeleteUserURL($user);
        Requests::getProtectedContents($url, $this->appService->settings());
    }
}
