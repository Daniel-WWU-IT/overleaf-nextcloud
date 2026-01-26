<?php

namespace OCA\Overleaf\Util;

use OCA\Overleaf\Settings\AppSettings;

use OCP\IConfig;

class Requests {
    const HEADER_ORIGIN = "X-Overleaf-Origin";
    const HEADER_APIKEY = "X-Overleaf-Apikey";
    const HEADER_PASSWORD = "X-Overleaf-Password";

    static public function getProtectedContents(string $url, IConfig $config, AppSettings $settings, array $extraHeaders = null): false|string {
        $headers = [
            Requests::HEADER_ORIGIN => URLUtils::getHostURL($config),
            Requests::HEADER_APIKEY => $settings->getAPIKey(),
        ];
        if ($extraHeaders != null) {
            $headers = array_merge($headers, $extraHeaders);
        }

        $opts = [
            "http" => [
                "method" => "GET",
                "header" => Requests::formatHeaders($headers)
            ]
        ];
        $context = stream_context_create($opts);
        return file_get_contents($url, false, $context);
    }

    static private function formatHeaders(array $headers): string {
        $headerText = "";
        foreach ($headers as $key => $value) {
            $headerText .= $key . ": " . $value . "\r\n";
        }
        return $headerText;
    }
}
