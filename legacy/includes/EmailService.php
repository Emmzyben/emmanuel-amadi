<?php
/**
 * EmailService - Automated notifications using Connecta API
 */
class EmailService {
    public static function send($to, $subject, $message) {
        $url  = 'https://connecta.uk/send_email3.php';
        $data = json_encode([
            'email'   => $to,
            'subject' => $subject,
            'message' => $message
        ]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Required on local XAMPP
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);

        $response = curl_exec($ch);
        $err      = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($err) {
            error_log("🌐 Email cURL error: " . $err);
            return false;
        }

        $result = json_decode($response, true);
        if (isset($result['status']) && $result['status'] === 'success') {
            return true;
        }

        error_log("❌ Email send failed to $to: " . ($result['message'] ?? $response));
        return false;
    }
}
?>
