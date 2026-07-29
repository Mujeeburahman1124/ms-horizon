<?php
namespace App\Core;

/**
 * HTTP Response Helper with Fallback JavaScript Redirects
 */
class Response
{
    public static function setStatusCode(int $code): void
    {
        if (!headers_sent()) {
            http_response_code($code);
        }
    }

    public static function redirect(string $url): void
    {
        if (!str_starts_with($url, 'http')) {
            $url = APP_URL . '/' . ltrim($url, '/');
        }

        if (!headers_sent()) {
            header("Location: $url");
        }

        echo "<!DOCTYPE html><html><head><meta charset='UTF-8'>";
        echo "<meta http-equiv='refresh' content='0;url=" . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . "'>";
        echo "<script>window.location.href=" . json_encode($url) . ";</script>";
        echo "</head><body>";
        echo "<p>Redirecting to <a href='" . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . "</a>...</p>";
        echo "</body></html>";
        exit;
    }

    public static function json(array $data, int $statusCode = 200): void
    {
        self::setStatusCode($statusCode);
        if (!headers_sent()) {
            header('Content-Type: application/json; charset=utf-8');
        }
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
        if (!headers_sent()) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
        }
        readfile($filePath);
        exit;
    }
}
