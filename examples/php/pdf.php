<?php
// Website to PDF API – PHP example (ext-curl)
// Usage: CAPTUREKIT_API_KEY=your-key php pdf.php

function call(string $method, string $url, ?string $body = null): string
{
    $ch = curl_init($url);
    $headers = ['x-api-key: ' . getenv('CAPTUREKIT_API_KEY')];
    if ($body !== null) {
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    }
    curl_setopt_array($ch, [
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 120,
        CURLOPT_HTTPHEADER => $headers,
    ]);
    $res = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($status >= 400) {
        fwrite(STDERR, "HTTP $status: $res\n");
        exit(1);
    }
    return $res;
}

$query = http_build_query([
    'url' => 'https://github.com/seaweedfs/seaweedfs',
    'format' => 'pdf'
]);
$response = call('GET', 'https://api.capturekit.dev/v1/capture' . ($query ? '?' . $query : ''));

file_put_contents('page.pdf', $response);
echo 'Saved page.pdf', PHP_EOL;
