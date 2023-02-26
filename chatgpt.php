<?php

session_start();

$API_KEY = "your api key here"

// Get the user's message
$message = $_POST['text'];

// Set up the OpenAI API endpoint URL
$url = 'https://api.openai.com/v1/engines/text-davinci-003/completions';

// Set up the request headers, including the API key
$headers = array(
    'Content-Type: application/json',
    'Authorization: Bearer '.$API_KEY
);

// Get the conversation history
$history = isset($_SESSION['history']) ? $_SESSION['history'] : "";

$history .= $message."\n";


// Set up the request data as a JSON object
$data = array(
    'prompt' => $history,
    'temperature' => 0.8,
    'max_tokens' => 1200
);
$json_data = json_encode($data);

// Set up the cURL request
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Submit the cURL request and get the response
$response = curl_exec($ch);

// Close the cURL connection
curl_close($ch);

// Extract the chatbot response from the JSON response
$json_response = json_decode($response);
$chatbot_response = trim($json_response->choices[0]->text);

// Add the current message and response to the history
$history .= $chatbot_response."\n";
$_SESSION['history'] = $history;

// Return the chatbot response to the user
echo $chatbot_response;
