<?php

$header = [
    'alg' => 'HS256',
    'typ' => 'JWT'
];

$payload = [
    'first_name' => 'Ricardo',
    'last_name' => 'Gama',
    'email' => 'ricard.gama@gmail.com'
];

$header = json_encode($header);
$payload = json_encode($payload);

echo "Header: $header";
echo "\n";
echo "Payload: $payload";
echo "\n";

$header = base64_encode($header);
$payload = base64_encode($payload);

echo "Header - base64: $header";
echo "\n";
echo "Payload - base64: $payload";
echo "\n";

$key = 't3Dp799v9L0558xFMZTPOJNerEKI6zQd';

$signature = hash_hmac('sha256', "$header.$payload", $key, true);
echo "Signature: $signature";
echo "\n";
$signature = base64_encode($signature);
echo "Signature - base64: $signature";
echo "\n\n\n";

echo "$header.$payload.$signature";