<?php

namespace OCA\Overleaf\Util;

use OCA\Overleaf\Settings\AppSettings;

class Requests {
    const HEADER_APIKEY = "X-Overleaf-Apikey";
    const HEADER_PASSWORD = "X-Overleaf-Password";

    static public function getProtectedContents(string $url, AppSettings $settings, array $extraHeaders = null): false|string {
        $headers = [
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
