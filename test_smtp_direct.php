<?php
$pass = 'zkeqpvtqxfpzngjz';
$emails = ['mujeeburahman2003@gmail.com', 'aqeelamrahman@gmail.com'];

foreach ($emails as $user) {
    echo "----------------------------------------\n";
    echo "Testing User: {$user}\n";
    $socket = @fsockopen('smtp.gmail.com', 587, $errno, $errstr, 10);
    if (!$socket) {
        echo "Connection failed\n";
        continue;
    }
    
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
    fputs($socket, base64_encode($user) . "\r\n"); $read();
    fputs($socket, base64_encode($pass) . "\r\n"); 
    $authRes = trim($read());
    echo "AUTH RESULT for {$user}: {$authRes}\n";
    
    if (str_starts_with($authRes, '235')) {
        fputs($socket, "MAIL FROM: <{$user}>\r\n"); $read();
        fputs($socket, "RCPT TO: <{$user}>\r\n"); $read();
        fputs($socket, "DATA\r\n"); $read();
        
        $otp = sprintf("%06d", mt_rand(100000, 999999));
        $msg = "From: MS Horizon Group <{$user}>\r\nTo: <{$user}>\r\nSubject: MS Horizon Test Security OTP: {$otp}\r\nContent-Type: text/html; charset=UTF-8\r\n\r\n";
        $msg .= "<h2>MS Horizon Test Email</h2><p>Your OTP Code is: <strong>{$otp}</strong></p>";
        
        fputs($socket, $msg . "\r\n.\r\n"); 
        $sendRes = trim($read());
        echo "SEND RESULT: {$sendRes}\n";
        fputs($socket, "QUIT\r\n");
        fclose($socket);
        echo "🎉 SUCCESS: EMAIL DELIVERED TO {$user}! (OTP: {$otp})\n";
    }
}
