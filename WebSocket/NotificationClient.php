<?php
/**
 * Simple helper to push notifications to the running WebSocket server's HTTP /push endpoint.
 * Usage:
 *   \WebSocket\NotificationClient::push(['message' => 'Hello']);
 */
class NotificationClient
{
    /**
     * Push payload to the HTTP push endpoint.
     * Accepts array or string. Returns associative array with 'ok' boolean and 'http_code' or 'error'.
     */
    public static function push($payload)
    {
        $pushHost = defined('WS_PUSH_HOST') ? WS_PUSH_HOST : '127.0.0.1';
        $pushPort = defined('WS_PUSH_PORT') ? WS_PUSH_PORT : 8081;
        $url = "http://{$pushHost}:{$pushPort}/push";

        $body = is_string($payload) ? $payload : json_encode($payload);

        // Try cURL if available
        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            $resp = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $err = curl_error($ch);
            curl_close($ch);

            if ($resp === false) {
                return ['ok' => false, 'error' => $err];
            }

            return ['ok' => ($code >= 200 && $code < 300), 'http_code' => $code, 'body' => $resp];
        }

        // Fallback: file_get_contents with stream context
        $opts = [
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-Type: application/json\r\n",
                'content' => $body,
                'timeout' => 3
            ]
        ];
        $context  = stream_context_create($opts);
        $resp = @file_get_contents($url, false, $context);

        if ($resp === false) {
            return ['ok' => false, 'error' => 'file_get_contents failed'];
        }

        // Try to parse response
        $decoded = json_decode($resp, true);
        return ['ok' => isset($decoded['ok']) ? (bool)$decoded['ok'] : true, 'body' => $resp];
    }
}
