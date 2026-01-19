<?php

namespace OCA\Overleaf\Util;

use OCP\IConfig;

class URLUtils
{
    public static function buildURL(string $scheme, string $host, string|int|null $port, string $path = "", string $query = ""): string
    {
        $fullPort = "";
        if ($port != 0 && $port != "" && $port != null) {
            $fullPort = ":{$port}";
        }
        $path = ltrim($path, "/");
        if ($query != "") {
            $query = "?{$query}";
        }
        return "{$scheme}://{$host}{$fullPort}/{$path}{$query}";
    }

    public static function getHostURL(IConfig $config, string $endpoint = ""): string
    {
        $host = $_SERVER["HTTP_HOST"];
        $protocol = !empty($_SERVER["HTTPS"]) ? "https" : "http";

        $url = $config->getSystemValue("overwriteprotocol", $protocol) . "://" . $config->getSystemValue("overwritehost", $host);
        if ($endpoint != "") {
            if (!str_ends_with($url, "/") && !str_starts_with($endpoint, "/")) {
                $url .= "/";
            }
            $url .= $endpoint;
        }
        return $url;
    }
}
