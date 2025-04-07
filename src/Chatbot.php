<?php

namespace App;

class Chatbot
{
    private $apiKey;
    private $guideText;

    public function __construct(string $apiKey, string $guideText = '')
    {
        $this->apiKey = $apiKey;
        $this->guideText = $guideText;
    }

    public function getReply(string $message): string 
    {
        if (empty($message)) {
            return "Tidak ada respon.";
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $this->apiKey;
        
        $data = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [['text' => $message]]
                ]
            ]
        ];

        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'content' => json_encode($data)
            ]
        ];

        $context = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);
        
        if ($response === false) {
            return "Tidak ada respon.";
        }

        $result = json_decode($response, true);
        return $result['candidates'][0]['content']['parts'][0]['text'] ?? "Tidak ada respon.";
    }
}