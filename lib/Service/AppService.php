<?php

namespace OCA\Overleaf\Service;

use OCA\Overleaf\Settings\AppSettings;

class AppService {
    private AppSettings $settings;

    public function __construct(AppSettings $settings) {
        $this->settings = $settings;
    }

    public function getAppHost(bool $includePort = false): string {
        $url = $this->settings->getAppURL();
        if ($url == "") {
            return "";
        }

        $port = parse_url($url, PHP_URL_PORT);
        $host = parse_url($url, PHP_URL_HOST);

        if ($includePort && $port != null) {
            return "$host:$port";
        }
        return $host;
    }

    public function normalizeUserID(string $uid): string {
        if (filter_var($uid, FILTER_VALIDATE_EMAIL)) {
            if ($this->settings->getEnforceUserIDSuffix()) {
                $uid = str_replace(['@', '.'], '-', $uid);
            } else {
                return $uid;
            }
        }
        $uid = str_replace('@', '-', $uid);
        $host = $this->settings->getUserIDSuffix();
        if ($host == "") {
            $host = $this->getAppHost();
        }
        return $uid . '@' . $host;
    }

    public function settings(): AppSettings {
        return $this->settings;
    }
}
