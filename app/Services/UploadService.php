<?php
namespace App\Services;

/**
 * Secure File Upload Service
 * Enforces extension whitelist, size limits, and hashed filenames.
 */
class UploadService
{
    private string $uploadDir;
    private array $allowedMimes = [
        'application/pdf',
        'image/jpeg',
        'image/png',
        'image/webp',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];
    private array $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'webp', 'doc', 'docx'];
    private int $maxSizeBytes = 10485760; // 10MB

    public function __construct(string $subDirectory = 'docs')
    {
        $this->uploadDir = rtrim(UPLOAD_DIR, '/') . '/' . $subDirectory . '/';

        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0750, true);
        }
    }

    /**
     * Upload a file from $_FILES array
     * @param array $file - $_FILES['fieldname']
     * @return array ['success' => bool, 'path' => string, 'original' => string, 'error' => string]
     */
    public function upload(array $file): array
    {
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return ['success' => false, 'error' => 'No file was uploaded.'];
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => 'Upload error code: ' . $file['error']];
        }

        if ($file['size'] > $this->maxSizeBytes) {
            return ['success' => false, 'error' => 'File exceeds maximum size of 10MB.'];
        }

        // Validate MIME type using finfo
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        if (!in_array($mimeType, $this->allowedMimes)) {
            return ['success' => false, 'error' => 'File type not permitted. Allowed: PDF, JPG, PNG, WEBP, DOC, DOCX'];
        }

        // Validate extension
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $this->allowedExtensions)) {
            return ['success' => false, 'error' => 'File extension not allowed.'];
        }

        // Generate a secure hashed filename
        $filename = bin2hex(random_bytes(16)) . '_' . time() . '.' . $ext;
        $destination = $this->uploadDir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return ['success' => false, 'error' => 'Failed to save uploaded file.'];
        }

        // Write .htaccess to block direct PHP execution in uploads
        $htaccessPath = $this->uploadDir . '.htaccess';
        if (!file_exists($htaccessPath)) {
            file_put_contents($htaccessPath, "Options -ExecCGI\nAddHandler cgi-script .php .php3 .php4 .phtml .pl .py .rb\n<Files *.php>\ndeny from all\n</Files>");
        }

        return [
            'success' => true,
            'path' => $filename,
            'full_path' => $destination,
            'original' => htmlspecialchars($file['name'], ENT_QUOTES, 'UTF-8'),
            'size' => $file['size'],
            'mime' => $mimeType
        ];
    }

    /**
     * Delete an uploaded file safely
     */
    public function delete(string $filename): bool
    {
        $path = $this->uploadDir . basename($filename);
        if (file_exists($path)) {
            return unlink($path);
        }
        return false;
    }
}
