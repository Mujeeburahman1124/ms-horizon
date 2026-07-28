<?php
require_once __DIR__ . '/config.php';

$sender = 'aqeelamrahman@gmail.com';
$pass = 'zkeqpvtqxfpzngjz';
$recipient = 'mujeeburahman2003@gmail.com';

echo "Sending real-time OTP to {$recipient} via {$sender}...\n";

$socket = fsockopen('smtp.gmail.com', 587, $errno, $errstr, 10);
if (!$socket) die("Connection failed\n");

$read = function() use ($socket) {
    $res = '';
    while ($str = fgets($socket, 512)) {
        $res .= $str;
        if (substr($str, 3, 1) === ' ') break;
    }
    return $res;
};

$read();
fputs($socket, "EHLO localhost\r\n"); $read();
fputs($socket, "STARTTLS\r\n"); $read();
stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT);
fputs($socket, "EHLO localhost\r\n"); $read();

fputs($socket, "AUTH LOGIN\r\n"); $read();
fputs($socket, base64_encode($sender) . "\r\n"); $read();
fputs($socket, base64_encode($pass) . "\r\n"); 
$authRes = trim($read());

if (str_starts_with($authRes, '235')) {
    fputs($socket, "MAIL FROM: <{$sender}>\r\n"); $read();
    fputs($socket, "RCPT TO: <{$recipient}>\r\n"); $read();
    fputs($socket, "DATA\r\n"); $read();
    
    $otp = sprintf("%06d", mt_rand(100000, 999999));
    $msg = "From: MS Horizon Group <{$sender}>\r\nTo: <{$recipient}>\r\nSubject: MS Horizon Security Verification Code: {$otp}\r\nContent-Type: text/html; charset=UTF-8\r\n\r\n";
    $msg .= "<div style='font-family:Arial,sans-serif;padding:20px;border:1px solid #d4af37;border-radius:10px;'><h2 style='color:#0a1628;'>MS <span style='color:#d4af37;'>Horizon</span> Group</h2><p>Your Security Verification Code is: <strong style='font-size:24px;color:#d4af37;'>{$otp}</strong></p><p>This code is valid for 10 minutes. Thank you for choosing MS Horizon Group.</p></div>";
    
    fputs($socket, $msg . "\r\n.\r\n"); 
    $sendRes = trim($read());
    fputs($socket, "QUIT\r\n");
    fclose($socket);
    echo "🎉 SUCCESS: REAL EMAIL & OTP ({$otp}) DELIVERED TO YOUR INBOX ({$recipient})!\n";
} else {
    echo "❌ Authentication failed: {$authRes}\n";
}
