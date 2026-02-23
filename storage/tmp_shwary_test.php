<?php
$ch = curl_init('https://api.shwary.com/api/v1/merchants/payment/sandbox/DRC');
$logFile = __DIR__ . '/shwary_debug.txt';
$fp = fopen($logFile, 'a');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HEADER => true,
    CURLOPT_VERBOSE => true,
    CURLOPT_STDERR => $fp,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_SSL_VERIFYPEER => true,
    CURLOPT_SSL_VERIFYHOST => 2,
    CURLOPT_HTTPHEADER => ['Accept: application/json'],
]);
$resp = curl_exec($ch);
$err = curl_error($ch);
$info = curl_getinfo($ch);
$time = date('c');
fwrite($fp, "=== Request at $time ===\n");
fwrite($fp, print_r($info, true) . "\n");
fwrite($fp, "Error: $err\n");
fwrite($fp, "Response:\n" . $resp . "\n\n");
if (is_resource($fp)) fclose($fp);
if ($resp === false) {
    echo "CURL ERROR: $err\n";
} else {
    echo "CURL OK\n";
}
print_r($info);
echo "\nRESPONSE:\n";
echo $resp;
curl_close($ch);
