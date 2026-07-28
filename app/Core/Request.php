<?php
namespace App\Core;

/**
 * HTTP Request Handler
 */
class Request
{
    public static function getMethod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }

    public static function getUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';

        // Strip query string
        $position = strpos($uri, '?');
        if ($position !== false) {
            $uri = substr($uri, 0, $position);
        }

        // Handle subfolder deployment (e.g., /ms-horizon or /ms-horizon/public)
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
        $baseDir = preg_replace('#/public$#', '', $scriptDir);

        if (!empty($scriptDir) && $scriptDir !== '/' && str_starts_with($uri, $scriptDir)) {
            $uri = substr($uri, strlen($scriptDir));
        } elseif (!empty($baseDir) && $baseDir !== '/' && str_starts_with($uri, $baseDir)) {
            $uri = substr($uri, strlen($baseDir));
        }

        return '/' . trim($uri, '/');
    }

    public static function isPost(): bool
    {
        return self::getMethod() === 'POST';
    }

    public static function isGet(): bool
    {
        return self::getMethod() === 'GET';
    }

    public static function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    public static function getBody(): array
    {
        $data = [];

        if (self::isGet()) {
            foreach ($_GET as $key => $value) {
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if (self::isPost()) {
            foreach ($_POST as $key => $value) {
                if (is_array($value)) {
                    $data[$key] = array_map(fn($item) => is_string($item) ? htmlspecialchars(trim($item), ENT_QUOTES, 'UTF-8') : $item, $value);
                } else {
                    $data[$key] = htmlspecialchars(trim((string)$value), ENT_QUOTES, 'UTF-8');
                }
            }
        }

        return $data;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $body = self::getBody();
        return $body[$key] ?? $default;
    }

    public static function file(string $key): ?array
    {
        return $_FILES[$key] ?? null;
    }
}
