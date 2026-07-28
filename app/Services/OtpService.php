<?php
namespace App\Services;

use App\Core\Database;
use App\Core\Session;

/**
 * Enterprise Real-Time Email OTP Authentication & Verification Engine
 */
class OtpService
{
    /**
     * Generate & Send Real-Time 6-Digit OTP via Email
     */
    public static function sendOtp(string $email, string $purpose = 'login'): array
    {
        $otp = sprintf("%06d", mt_rand(100000, 999999));
        $expiresAt = date('Y-m-d H:i:s', time() + 600); // 10 minutes validity

        // Save OTP to database
        try {
            Database::query(
                "INSERT INTO otp_verifications (email, otp_code, purpose, expires_at) VALUES (:email, :otp, :purpose, :expires)",
                [
                    'email' => $email,
                    'otp' => $otp,
                    'purpose' => $purpose,
                    'expires' => $expiresAt
                ]
            );
        } catch (\Throwable $e) {
            // Fallback to session storage if table is unavailable
            Session::set("otp_{$email}_{$purpose}", [
                'code' => $otp,
                'expires' => time() + 600
            ]);
        }

        // Send real-time OTP via MailService
        $sent = MailService::sendNotification(
            $email,
            "Your MS Horizon Security Verification Code: {$otp}",
            'otp_verification',
            [
                'message' => "Your security verification code for MS Horizon Group is: {$otp}. This code is valid for 10 minutes. Do not share this code with anyone.",
                'reference' => "OTP-{$otp}"
            ]
        );

        return [
            'status' => 'success',
            'message' => "A 6-digit OTP verification code has been sent to {$email}.",
            'otp_demo' => (APP_ENV === 'development') ? $otp : null
        ];
    }

    /**
     * Verify Submitted OTP Code (Timezone-Independent)
     */
    public static function verifyOtp(string $email, string $otp, string $purpose = 'login'): bool
    {
        // Database verification
        try {
            $record = Database::fetchOne(
                "SELECT * FROM otp_verifications WHERE email = :email AND purpose = :purpose AND is_used = 0 ORDER BY id DESC LIMIT 1",
                ['email' => $email, 'purpose' => $purpose]
            );

            if ($record && strtotime($record['expires_at']) >= (time() - 60) && hash_equals((string)$record['otp_code'], (string)$otp)) {
                Database::query("UPDATE otp_verifications SET is_used = 1 WHERE id = :id", ['id' => $record['id']]);
                return true;
            }
        } catch (\Throwable $e) {
            // Fallback session check
            $sessionData = Session::get("otp_{$email}_{$purpose}");
            if ($sessionData && time() <= $sessionData['expires'] && hash_equals((string)$sessionData['code'], (string)$otp)) {
                Session::remove("otp_{$email}_{$purpose}");
                return true;
            }
        }

        return false;
    }
}
