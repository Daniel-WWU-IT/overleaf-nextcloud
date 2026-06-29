<?php

namespace OCA\OverleafV6\Util;

class Session {
    private static function start(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set(string $key, mixed $value): void {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function get(string $key): mixed {
        self::start();
        return $_SESSION[$key] ?? null;
    }

    public static function unset(string $key): void {
        self::start();
        unset($_SESSION[$key]);
    }
}
