<?php

namespace OCA\Overleaf\Service;

use OCA\Overleaf\Settings\AppSettings;

use OCP\IUserSession;

class AppService {
    private IUserSession $userSession;

    private AppSettings $settings;

    public function __construct(IUserSession $userSession, AppSettings $settings) {
        $this->userSession = $userSession;

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


    public function generateProjectsURL($userData, $origin): string {
        $url = $this->settings->getAppURL();
        if ($url == "") {
            return "";
        }

        // Build the URL and redirect to it
        $params = http_build_query([
            "origin" => $origin,
            "action" => "open-projects",
            "data" => $userData,
        ]);
        return rtrim($url, "/") . "/regsvc?{$params}";
    }

    public function generateCreateAndLoginURL(): string {
        $url = $this->settings->getAppURL();
        if ($url == "") {
            return "";
        }

        $user = $this->userSession->getUser();
        if ($user == null) {
            return "";
        }

        // Build the URL and redirect to it
        $params = http_build_query([
            "action" => "create-and-login",
            "email" => $this->normalizeUserID($user->getUID()),
        ]);
        return rtrim($url, "/") . "/regsvc?{$params}";
    }

    public function generateDeleteUserURL($user): string {
        $url = $this->settings->getAppURL();
        if ($url == "") {
            return "";
        }

        // Build the URL and redirect to it
        $params = http_build_query([
            "action" => "delete",
            "email" => $this->normalizeUserID($user->getUID()),
        ]);
        return rtrim($url, "/") . "/regsvc?{$params}";
    }

    public function generatePassword(int $length = 64) {
        $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-";
        $randomString = "";
        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
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
