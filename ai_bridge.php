<?php
function check_message_safety($text) {
    // The URL where your Python IDE is running the model
    $url = 'http://127.0.0.1:5001/check';
    
    // Prepare the text to be sent
    $data = json_encode(['comment' => $text]);

    // Setup the request (cURL)
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    
    // If Python service is off, assume it's safe to avoid crashing the site
    if ($response === false) { return 0; }

    $result = json_decode($response, true);
    curl_close($ch);

    // Returns 1 if Cyberbullying, 0 if Safe
    return $result['is_bully'];
}
?>