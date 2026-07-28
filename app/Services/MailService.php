<?php
namespace App\Services;

use App\Core\Database;

/**
 * Enterprise Real-Time SMTP & HTML Email Dispatcher
 */
class MailService
{
    /**
     * Send real-time transactional email via SMTP / PHP mail
     */
    public static function sendNotification(string $toEmail, string $subject, string $templateName, array $data = []): bool
    {
        $body = self::renderTemplate($templateName, $data);
        $fromEmail = MAIL_FROM_ADDRESS;
        $fromName = MAIL_FROM_NAME;

        $sent = false;

        // Try SMTP transport if enabled
        if (defined('SMTP_ENABLED') && SMTP_ENABLED && !empty(SMTP_HOST) && SMTP_PASS !== 'your_smtp_app_password') {
            $sent = self::sendSmtp($toEmail, $subject, $body, $fromEmail, $fromName);
        }

        // Fallback to PHP native mail() if SMTP isn't configured with real password
        if (!$sent) {
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $headers .= "From: {$fromName} <{$fromEmail}>\r\n";
            $headers .= "Reply-To: {$fromEmail}\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();

            $sent = @mail($toEmail, $subject, $body, $headers);
        }

        // Log transaction into audit logs
        try {
            Database::insert('audit_logs', [
                'user_id' => null,
                'user_email' => $toEmail,
                'action' => 'REALTIME_EMAIL_DISPATCH',
                'details' => "Subject: {$subject} | Status: " . ($sent ? 'Delivered' : 'Queued/Logged'),
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'
            ]);
        } catch (\Throwable $e) {
            // Ignore DB audit error on email send
        }

        return $sent;
    }

    /**
     * Native Socket-based SMTP Dispatcher
     */
    private static function sendSmtp(string $to, string $subject, string $htmlContent, string $fromEmail, string $fromName): bool
    {
        try {
            $host = SMTP_HOST;
            $port = SMTP_PORT;
            $user = SMTP_USER;
            $pass = SMTP_PASS;
            $encryption = SMTP_ENCRYPTION;

            $prefix = ($encryption === 'ssl') ? 'ssl://' : '';
            $socket = @fsockopen($prefix . $host, $port, $errno, $errstr, 10);
            if (!$socket) return false;

            $getResponse = function() use ($socket) {
                $res = '';
                while ($str = fgets($socket, 512)) {
                    $res .= $str;
                    if (substr($str, 3, 1) === ' ') break;
                }
                return $res;
            };

            $getResponse();
            fputs($socket, "EHLO " . gethostname() . "\r\n");
            $getResponse();

            if ($encryption === 'tls') {
                fputs($socket, "STARTTLS\r\n");
                $getResponse();
                stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT);
                fputs($socket, "EHLO " . gethostname() . "\r\n");
                $getResponse();
            }

            fputs($socket, "AUTH LOGIN\r\n");
            $getResponse();
            fputs($socket, base64_encode($user) . "\r\n");
            $getResponse();
            fputs($socket, base64_encode($pass) . "\r\n");
            $getResponse();

            fputs($socket, "MAIL FROM: <{$fromEmail}>\r\n");
            $getResponse();
            fputs($socket, "RCPT TO: <{$to}>\r\n");
            $getResponse();

            fputs($socket, "DATA\r\n");
            $getResponse();

            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $headers .= "From: {$fromName} <{$fromEmail}>\r\n";
            $headers .= "To: {$to}\r\n";
            $headers .= "Subject: {$subject}\r\n\r\n";

            fputs($socket, $headers . $htmlContent . "\r\n.\r\n");
            $getResponse();

            fputs($socket, "QUIT\r\n");
            fclose($socket);

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    private static function renderTemplate(string $template, array $data): string
    {
        extract($data);
        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
          <style>
            body { font-family: 'Segoe UI', Arial, sans-serif; background: #f8fafc; color: #0f172a; margin:0; padding:20px; }
            .card { background:#ffffff; border-radius:16px; padding:30px; max-width:600px; margin:0 auto; border:1px solid #e2e8f0; box-shadow:0 10px 30px rgba(0,0,0,.05); }
            .header { border-bottom:2px solid #d4af37; padding-bottom:15px; margin-bottom:20px; text-align:center; }
            .brand { font-size:26px; font-weight:800; color:#0a1628; }
            .brand span { color:#d4af37; }
            .badge { background:#d4af37; color:#0a1628; font-weight:bold; padding:4px 12px; border-radius:99px; font-size:12px; }
            .footer { margin-top:30px; font-size:12px; color:#64748b; text-align:center; }
          </style>
        </head>
        <body>
          <div class="card">
            <div class="header">
              <div class="brand">MS <span>Horizon</span> Group</div>
              <div style="font-size:12px;color:#64748b;margin-top:4px;">Your Global Partner for Travel, Talent, Business & Technology</div>
            </div>
            <h2>Service Notification</h2>
            <p>Dear Valued Client,</p>
            <p><?= htmlspecialchars($message ?? 'Thank you for contacting MS Horizon Group. Your enquiry has been received by our division team.', ENT_QUOTES, 'UTF-8') ?></p>
            <?php if (!empty($reference)): ?>
              <div style="background:#0a1628;color:#ffffff;padding:15px;border-radius:8px;font-weight:bold;margin:15px 0;text-align:center;">
                Reference Code: <span style="color:#d4af37;"><?= htmlspecialchars($reference, ENT_QUOTES, 'UTF-8') ?></span>
              </div>
            <?php endif; ?>
            <p>You can track application updates anytime using your reference code or registered mobile number.</p>
            <div class="footer">
              © <?= date('Y') ?> MS Horizon Group LLC. Level 28, Horizon Tower, Business Bay, Dubai, UAE.<br>
              Phone: +971 4 123 4567 | WhatsApp: +971 50 123 4567
            </div>
          </div>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}
