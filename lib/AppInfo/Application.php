<?php

declare(strict_types=1);
// SPDX-FileCopyrightText: University of Muenster <info@uni-muenster.de>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\Overleaf\AppInfo;

use OCA\Overleaf\Events\UserDeletedListener;

use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\EventDispatcher\IEventDispatcher;
use OCP\User\Events\UserDeletedEvent;

class Application extends App implements IBootstrap {
    public const APP_ID = 'overleaf_nextcloud';

    public function __construct() {
        parent::__construct(self::APP_ID);

        $this->addEventListeners();
    }

    public function register(IRegistrationContext $context): void {
    }

    public function boot(IBootContext $context): void {
    }

    private function addEventListeners(): void {
        // User deleted
        $dispatcher = $this->getContainer()->get(IEventDispatcher::class);
        $dispatcher->addServiceListener(UserDeletedEvent::class, UserDeletedListener::class);
    }
}
