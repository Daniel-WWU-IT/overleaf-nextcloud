<?php

namespace OCA\OverleafV6\Events;

use OCA\OverleafV6\AppInfo\Application;
use OCA\OverleafV6\Service\AppService;

use OCP\Collaboration\Resources\LoadAdditionalScriptsEvent;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;
use OCP\Util;

class LoadAdditionalScriptsListener implements IEventListener {
	private AppService $appService;

    public function __construct(AppService $appService) {
        $this->appService = $appService;
    }

	public function handle(Event $event): void {
		if ($event instanceof LoadAdditionalScriptsEvent) {
			$this->onLoadAdditionalScripts($event);
		}
	}

	private function onLoadAdditionalScripts(LoadAdditionalScriptsEvent $event): void {
		Util::addInitScript(Application::APP_ID, Application::APP_ID . "-files_integration");
	}
}
