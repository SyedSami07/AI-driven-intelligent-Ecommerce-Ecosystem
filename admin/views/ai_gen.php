<?php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $pdt_name = isset($_POST['pdt_name']) ? trim($_POST['pdt_name']) : '';
    $diet_type = isset($_POST['diet_type']) ? trim($_POST['diet_type']) : 'General';

    if (empty($pdt_name)) {
        echo json_encode(["success" => false, "error" => "Product name is required!"]);
        exit;
    }

    $apiKey = ""; 
    $url = "";

   
    $prompt = "Write a professional and engaging marketing description for the following product.
               Product Name: $pdt_name. 
               Context/Category: $diet_type. 

               Strict Instructions:
               1. START the description directly with enticing words.
               2. DO NOT include the category name, 'Category:', or any labels at the start.
               3. If it is a gadget, focus on performance; if food, focus on taste/health.
               4. Length: 60-80 words.
               5. DO NOT use bold text (**), markdown stars (*), or hashtags (#).
               6. Provide only the body text of the description.";

    $data = [
        "model" => "llama-3.1-8b-instant",
        "messages" => [
            [
                "role" => "system", 
                "content" => "You are a premium e-commerce copywriter. You provide only the final description text without any titles, categories, or introductory labels."
            ],
            [
                "role" => "user", 
                "content" => $prompt
            ]
        ],
        "temperature" => 0.7,
        "max_tokens" => 250
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $apiKey,
        "Content-Type: application/json"
    ]);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        $result = json_decode($response, true);
        if (isset($result['choices'][0]['message']['content'])) {
            $description = $result['choices'][0]['message']['content'];

            // --- আরও বেশি ক্লিনিং লজিক ---
            // ১. যদি প্রথম লাইনে Category বা Product Name থাকে সেটি রিমুভ করবে
            $clean_desc = preg_replace('/^(Category|Product|Name):.*$/mi', '', $description);
            
            // ২. ডাবল স্টার, হ্যাশ বা বোল্ড ফরম্যাট ক্লিন করবে
            $clean_desc = str_replace(['**', '*', '#'], '', $clean_desc);
            
            echo json_encode([
                "success" => true, 
                "description" => trim($clean_desc)
            ]);
        } else {
            echo json_encode(["success" => false, "error" => "AI failed to respond properly."]);
        }
    } else {
        $errorResponse = json_decode($response, true);
        echo json_encode(["success" => false, "error" => "API Error: " . ($errorResponse['error']['message'] ?? 'Unknown')]);
    }

} else {
    echo json_encode(["success" => false, "error" => "Invalid Method"]);
}
?>