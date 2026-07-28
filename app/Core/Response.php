<?php
namespace App\Core;

/**
 * HTTP Response Helper
 */
class Response
{
    public static function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    public static function redirect(string $url): void
    {
        if (!str_starts_with($url, 'http')) {
            $url = APP_URL . '/' . ltrim($url, '/');
        }
        header("Location: $url");
        exit;
    }

    public static function json(array $data, int $statusCode = 200): void
    {
        self::setStatusCode($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    public static function download(string $filePath, ?string $filename = null): void
    {
        if (!file_exists($filePath)) {
            self::setStatusCode(404);
            die("File not found.");
        }

        $filename = $filename ?: basename($filePath);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }
}
