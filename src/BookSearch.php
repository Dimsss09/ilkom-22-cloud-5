<?php

namespace App;

class BookSearch {
    private $apiKey;
    private $baseUrl = "https://www.googleapis.com/books/v1/volumes";
    
    public function __construct(string $apiKey = '') {
        $this->apiKey = $apiKey;
    }
    
    public function search(string $query, int $startIndex = 0, int $maxResults = 10): array {
        $url = $this->baseUrl . "?q=" . urlencode($query) . 
               "&startIndex=" . $startIndex . 
               "&maxResults=" . $maxResults;
               
        if (!empty($this->apiKey)) {
            $url .= "&key=" . $this->apiKey;
        }
        
        $response = @file_get_contents($url);
        if ($response === false) {
            return ['items' => [], 'totalItems' => 0];
        }
        
        return json_decode($response, true) ?? ['items' => [], 'totalItems' => 0];
    }
}