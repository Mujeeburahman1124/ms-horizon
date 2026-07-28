<?php
/**
 * Real-Time SMTP Email Connection Tester
 * Open in browser: http://localhost/ms-horizon/test_mail.php
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/app/Services/MailService.php';

$recipient = $_GET['email'] ?? 'mujeeburahman2003@gmail.com';
$smtp_user = $_GET['user'] ?? SMTP_USER;
$smtp_pass = $_GET['pass'] ?? SMTP_PASS;

echo "<h2>MS Horizon Real-Time Email Diagnostic Tool</h2>";
echo "<p>Testing SMTP delivery to: <strong>" . htmlspecialchars($recipient) . "</strong></p>";

if ($smtp_pass === 'your_smtp_app_password') {
    echo "<div style='background:#fff3cd;color:#856404;padding:15px;border-radius:8px;margin-bottom:20px;'>";
    echo "⚠️ <strong>Action Required</strong>: You are currently using placeholder SMTP credentials.<br>";
    echo "To send real emails to your Gmail inbox, please enter your Gmail address and <strong>Google App Password</strong> below:";
    echo "</div>";
    
    echo "<form method='GET' style='background:#f8fafc;padding:20px;border-radius:8px;max-width:500px;'>";
    echo "<label>Recipient Email:</label><br><input type='email' name='email' value='" . htmlspecialchars($recipient) . "' style='width:100%;padding:8px;margin-bottom:10px;'><br>";
    echo "<label>Your Sender Email (Gmail):</label><br><input type='email' name='user' value='" . htmlspecialchars($smtp_user) . "' style='width:100%;padding:8px;margin-bottom:10px;'><br>";
    echo "<label>Your Gmail 16-Digit App Password:</label><br><input type='password' name='pass' placeholder='xxxx xxxx xxxx xxxx' style='width:100%;padding:8px;margin-bottom:15px;'><br>";
    echo "<button type='submit' style='background:#0a1628;color:#d4af37;padding:10px 20px;border:none;border-radius:6px;font-weight:bold;cursor:pointer;'>Send Test Email & OTP</button>";
    echo "</form>";
    exit;
}

// Override constants dynamically for test
if ($smtp_user && $smtp_pass) {
    $otp = sprintf("%06d", mt_rand(100000, 999999));
    
    // Attempt socket SMTP send
    $host = 'smtp.gmail.com';
    $port = 587;
    
    $socket = @fsockopen($host, $port, $errno, $errstr, 15);
    if (!$socket) {
        echo "<p style='color:red;'>❌ Connection to {$host}:{$port} failed: {$errstr} ({$errno})</p>";
        exit;
    }
    
    echo "<ul>";
    echo "<li>Connected to {$host}:{$port}</li>";
    
    $read = function() use ($socket) {
        $res = '';
        while ($str = fgets($socket, 512)) {
            $res .= $str;
            if (substr($str, 3, 1) === ' ') break;
        }
        return $res;
    };
    
    $read();
    fputs($socket, "EHLO localhost\r\n"); echo "<li>EHLO: " . htmlspecialchars(trim($read())) . "</li>";
    fputs($socket, "STARTTLS\r\n"); echo "<li>STARTTLS: " . htmlspecialchars(trim($read())) . "</li>";
    
    stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT);
    fputs($socket, "EHLO localhost\r\n"); $read();
    
    fputs($socket, "AUTH LOGIN\r\n"); echo "<li>AUTH LOGIN: " . htmlspecialchars(trim($read())) . "</li>";
    fputs($socket, base64_encode($smtp_user) . "\r\n"); echo "<li>USER: " . htmlspecialchars(trim($read())) . "</li>";
    fputs($socket, base64_encode($smtp_pass) . "\r\n"); 
    $authRes = $read();
    echo "<li>PASS: " . htmlspecialchars(trim($authRes)) . "</li>";
    
    if (str_starts_with($authRes, '235')) {
        fputs($socket, "MAIL FROM: <{$smtp_user}>\r\n"); $read();
        fputs($socket, "RCPT TO: <{$recipient}>\r\n"); $read();
        fputs($socket, "DATA\r\n"); $read();
        
        $msg = "From: MS Horizon Group <{$smtp_user}>\r\n";
        $msg .= "To: <{$recipient}>\r\n";
        $msg .= "Subject: MS Horizon Security Verification Code: {$otp}\r\n";
        $msg .= "Content-Type: text/html; charset=UTF-8\r\n\r\n";
        $msg .= "<h2>MS Horizon Security Code</h2><p>Your verification code is: <strong>{$otp}</strong></p>";
        
        fputs($socket, $msg . "\r\n.\r\n");
        $sendRes = $read();
        echo "<li>DATA: " . htmlspecialchars(trim($sendRes)) . "</li>";
        fputs($socket, "QUIT\r\n");
        fclose($socket);
        
        echo "<h3 style='color:green;'>🎉 Email & OTP Successfully Delivered to {$recipient}! (Code: {$otp})</h3>";
    } else {
        echo "<h3 style='color:red;'>❌ Authentication Failed! Invalid Gmail App Password.</h3>";
        echo "<p>Please ensure you generated a 16-character App Password at <a href='https://myaccount.google.com/apppasswords' target='_blank'>myaccount.google.com/apppasswords</a>.</p>";
    }
    echo "</ul>";
}
